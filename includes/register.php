<?php
session_start();
include 'connect.php';

// Function to sanitize input
function sanitizeInput($data) {
    if ($data === null) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password
function isPasswordStrong($password) {
    // At least 6 characters, 1 uppercase, 1 lowercase, 1 number
    return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\W]{6,}$/", $password);
}

// Ensure connection is established
if (!isset($conn) || $conn->connect_error) {
    $_SESSION['error'] = "Database connection failed.";
    header("Location: ../signup.php?form=signup");
    exit();
}

// ----------------------------------------------------------------------------
// SIGNUP LOGIC
// ----------------------------------------------------------------------------
if (isset($_POST['signup'])) {
    
    // 1. Sanitize & Retrieve Inputs
    $username = sanitizeInput($_POST['username'] ?? '');
    $email    = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; 
    $location = sanitizeInput($_POST['location'] ?? '');
    $about    = sanitizeInput($_POST['about'] ?? '');
    $bio      = sanitizeInput($_POST['bio'] ?? '');
    $grade    = ''; 

    // Store inputs in session for form persistence
    $_SESSION['signup_data'] = [
        'username' => $username,
        'email' => $email,
        'location' => $location,
        'about' => $about,
        'bio' => $bio
    ];

    // 2. Validate Inputs
    $errors = [];
    
    if (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = "Username must be between 3 and 50 characters.";
    }
    
    if (!isValidEmail($email)) {
        $errors[] = "Invalid email format.";
    }
    
    if (!empty($password) && !isPasswordStrong($password)) {
        $errors[] = "Password must be at least 6 characters long and contain an uppercase letter, a lowercase letter, and a number.";
    }
    
    if (strlen($location) > 100) {
        $errors[] = "Location must be less than 100 characters.";
    }
    if (strlen($about) > 500) {
        $errors[] = "About section must be less than 500 characters.";
    }
    if (strlen($bio) > 500) {
        $errors[] = "Bio section must be less than 500 characters.";
    }

    // 3. Process Signup or Return Errors
    if (!empty($errors)) {
        $_SESSION['signup_error'] = implode("<br>", $errors);
        header("Location: ../signup.php?form=signup");
        exit();
    }

    // 4. Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($checkEmail) {
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['signup_error'] = "This Email Address is already registered!";
            $checkEmail->close();
            header("Location: ../signup.php?form=signup");
            exit();
        }
        $checkEmail->close();
    } else {
        $_SESSION['signup_error'] = "Database prepare error checking email: " . $conn->error;
        header("Location: ../signup.php?form=signup");
        exit();
    }

    // 5. Hash Password & Insert User
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    $insertQuery = $conn->prepare("INSERT INTO users (username, email, password, location, about, bio, grade) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($insertQuery) {
        $insertQuery->bind_param("sssssss", $username, $email, $hashedPassword, $location, $about, $bio, $grade);
        
        if ($insertQuery->execute()) {
            $_SESSION['success'] = "Account created successfully! Please log in.";
            unset($_SESSION['signup_data']); // Clear form data on success
            $insertQuery->close();
            header("Location: ../signup.php?form=login");
            exit();
        } else {
            $_SESSION['signup_error'] = "Error creating account: " . $conn->error;
            $insertQuery->close();
            header("Location: ../signup.php?form=signup");
            exit();
        }
    } else {
        $_SESSION['signup_error'] = "Database prepare error on insert: " . $conn->error;
        header("Location: ../signup.php?form=signup");
        exit();
    }
}

// ----------------------------------------------------------------------------
// LOGIN LOGIC
// ----------------------------------------------------------------------------
if (isset($_POST['login'])) {
    
    // 1. Sanitize & Retrieve Inputs
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; 

    $_SESSION['login_data'] = [
        'email' => $email
    ];

    // 2. Validate format
    if (!isValidEmail($email)) {
        $_SESSION['login_error'] = "Invalid email format.";
        header("Location: ../signup.php?form=login");
        exit();
    }

    // 3. Authenticate User
    $sql = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    if ($sql) {
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                unset($_SESSION['login_data']); // Clear on success
                unset($_SESSION['login_error']);
                
                // Set persistent cookie
                setcookie("email", $user['email'], [
                    'expires' => time() + 36000,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);

                $sql->close();
                header("Location: ../home.php");
                exit();
                
            } else {
                $_SESSION['login_error'] = "Incorrect password.";
                $sql->close();
                header("Location: ../signup.php?form=login");
                exit();
            }
        } else {
            $_SESSION['login_error'] = "No account found with that email address.";
            $sql->close();
            header("Location: ../signup.php?form=login");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Database prepare error on login lookup: " . $conn->error;
        header("Location: ../signup.php?form=login");
        exit();
    }
}
?>

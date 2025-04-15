<?php 

include 'connect.php';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO users(username, email, password)
                        VALUES ('$username', '$email', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: signup.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['id']; 
        setcookie("email", $row['email'], time() + 36000, "/");

        header("Location: home.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}

?>

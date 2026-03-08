<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    // Determine the base path based on current directory
    $script_path = $_SERVER['SCRIPT_NAME'];
    $is_in_pages = strpos($script_path, '/pages/') !== false;
    $redirect_url = $is_in_pages ? '../signup.php' : 'signup.php';
    
    // Optional: Store the intended destination to redirect back after login
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    
    header("Location: " . $redirect_url);
    exit();
}
?>

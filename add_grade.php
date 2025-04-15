<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

if (isset($_POST['agree']) && isset($_POST['grade'])) {
    $user_id = $_SESSION['user_id'];
    $grade = $_POST['grade'];

    $sql = "UPDATE users SET grade = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $grade, $user_id);

    if ($stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating grade: " . $conn->error;
    }
} else {
    echo "Please select the checkbox.";
}
?>

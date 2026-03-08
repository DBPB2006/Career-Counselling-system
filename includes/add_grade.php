<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../signup.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grade']) && isset($_POST['agree'])) {
        $user_id = $_SESSION['user_id'];
        $grade = $_POST['grade'];

        // Validate grade value
        $valid_grades = ['High School', 'Pre-university', 'UG', 'PG'];
        if (!in_array($grade, $valid_grades)) {
            $_SESSION['error'] = "Invalid grade selection.";
            header("Location: ../pages/grade.php");
            exit();
        }

        $sql = "UPDATE users SET grade = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $grade, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Grade updated successfully!";
            header("Location: ../pages/profile.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating grade: " . $conn->error;
            header("Location: ../pages/grade.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Please select the checkbox to confirm your grade.";
        header("Location: grade.php");
        exit();
    }
} else {
    header("Location: grade.php");
    exit();
}
?>

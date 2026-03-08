<?php

$host="localhost";
$user="root";
$pass="";
$db="login";

// Create connection without specifying the database
$conn = new mysqli($host, $user, $pass);
if($conn->connect_error){
    error_log("Failed to connect DB: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql_db = "CREATE DATABASE IF NOT EXISTS `$db`";
if ($conn->query($sql_db) !== TRUE) {
    error_log("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($db);

// Create users table if it doesn't exist
$table_users = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `about` text DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT 'Not set',
  `bio` text DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($table_users);

// Create user_results table if it doesn't exist
$table_results = "CREATE TABLE IF NOT EXISTS `user_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `result_text` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($table_results);

?>

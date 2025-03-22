<?php

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "user_portal";


$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_details = "CREATE TABLE IF NOT EXISTS user_details (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    full_name VARCHAR(100),
    age INT(3),
    gender VARCHAR(20),
    email VARCHAR(100),
    phone VARCHAR(20),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

$conn->query($sql_users);
$conn->query($sql_details);
?>
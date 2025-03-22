<?php
session_start();
require_once "database.php";

$registration_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $conn->real_escape_string($_POST["reg_username"]);
    $password = $_POST["reg_password"];
    $confirm_password = $_POST["confirm_password"];
    
    
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $registration_message = "Username already taken";
    } else if ($password != $confirm_password) {
        $registration_message = "Passwords do not match";
    } else {
        
        
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            $registration_message = "Registration successful! You can now login.";
            $_SESSION["registration_success"] = true;
        } else {
            $registration_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    
    $_SESSION["registration_message"] = $registration_message;
    header("location: loginpage.html");
    exit;
}
else {
    
    header("location: loginpage.html");
    exit;
}
?>
<?php
session_start();
require_once "data_functions.php";

$registration_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["reg_username"];
    $password = $_POST["reg_password"];
    $confirm_password = $_POST["confirm_password"];
    
    
    $existing_user = get_user_by_username($username);
    
    if ($existing_user) {
        $registration_message = "Username already taken";
    } else if ($password != $confirm_password) {
        $registration_message = "Passwords do not match";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        
        $user_id = add_user($username, $hashed_password);
        
        if ($user_id) {
            $registration_message = "Registration successful! You can now login.";
            $_SESSION["registration_success"] = true;
        } else {
            $registration_message = "Error: Could not create user account";
        }
    }
    
    
    $_SESSION["registration_message"] = $registration_message;
    header("location: index.php");
    exit;
} else {
    
    header("location: index.php");
    exit;
}
?>
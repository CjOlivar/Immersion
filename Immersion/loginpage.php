<?php
session_start();
require_once "data_functions.php";

$login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    
    $user = get_user_by_username($username);
    
    if ($user) {
        
        if (password_verify($password, $user["password"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("location: homepage.php");
            exit;
        } else {
            $login_error = "Invalid password";
        }
    } else {
        $login_error = "Username not found";
    }
    
    if (!empty($login_error)) {
        $_SESSION["login_error"] = $login_error;
        header("location: index.php");
        exit;
    }
} else {
    header("location: index.php");
    exit;
}
?>
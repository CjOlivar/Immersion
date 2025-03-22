<?php
session_start();
require_once "database.php";

$login_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $_POST["password"];
    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

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
        header("location: index.html");
        exit;
    }
}
else {
    header("location: index.html");
    exit;
}
?>
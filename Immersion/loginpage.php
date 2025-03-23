<?php
session_start();
$valid_username = "user";
$valid_password = "password123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
       
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;    
        echo json_encode(['success' => true]);
    } else {        
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password. Please try again.'
        ]);
    }
} else {  
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>

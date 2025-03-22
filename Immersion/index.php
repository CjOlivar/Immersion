<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: homepage.php");
    exit;
}
$login_error = isset($_SESSION["login_error"]) ? $_SESSION["login_error"] : "";
unset($_SESSION["login_error"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <div class="container" id="auth-container">
        <!-- Login Form -->
        <div id="login" class="auth-tab">
            <h1>User Login</h1>
            <form method="post" action="loginpage.php">
                <?php if (!empty($login_error)): ?>
                    <div class="error-message"><?php echo $login_error; ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
            <div class="login-info" style="margin-top: 20px; padding: 10px; background-color: #f1f1f1; border-radius: 4px; text-align: center;">
                <p>Default login credentials:</p>
                <p><strong>Username:</strong> user</p>
                <p><strong>Password:</strong> 123456</p>
            </div>
        </div>
    </div>
</body>
</html>
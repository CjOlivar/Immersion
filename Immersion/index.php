<?php
session_start();


if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: homepage.php");
    exit;
}


$login_error = isset($_SESSION["login_error"]) ? $_SESSION["login_error"] : "";
$registration_message = isset($_SESSION["registration_message"]) ? $_SESSION["registration_message"] : "";


unset($_SESSION["login_error"]);
unset($_SESSION["registration_message"]);
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
        <div class="tab-container">
            <button class="tab-button active" onclick="showTab('login')">Login</button>
            <button class="tab-button" onclick="showTab('register')">Register</button>
        </div>
        
        <!-- Login Form -->
        <div id="login" class="auth-tab">
            <h1>Login</h1>
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
        </div>
        
        <!-- Registration Form -->
        <div id="register" class="auth-tab" style="display: none;">
            <h1>Register</h1>
            <form method="post" action="register.php">
                <?php if (!empty($registration_message)): ?>
                    <div class="<?php echo strpos($registration_message, "successful") !== false ? "success-message" : "error-message"; ?>">
                        <?php echo $registration_message; ?>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="reg_username">Username</label>
                    <input type="text" id="reg_username" name="reg_username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <input type="password" id="reg_password" name="reg_password" placeholder="Choose a password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
<?php
session_start();
require_once "database.php";


if (!isset($_SESSION["loggedin"])) {
    header("location: index.html");
    exit;
}


$details_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_details"])) {
    $user_id = $_SESSION["id"];
    $full_name = $conn->real_escape_string($_POST["name"]);
    $age = $conn->real_escape_string($_POST["age"]);
    $gender = $conn->real_escape_string($_POST["gender"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $phone = $conn->real_escape_string($_POST["phone"]);
    
    
    $sql = "SELECT id FROM user_details WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        
        $sql = "UPDATE user_details SET 
                full_name = '$full_name', 
                age = '$age', 
                gender = '$gender', 
                email = '$email', 
                phone = '$phone' 
                WHERE user_id = '$user_id'";
    } else {
        
        $sql = "INSERT INTO user_details (user_id, full_name, age, gender, email, phone) 
                VALUES ('$user_id', '$full_name', '$age', '$gender', '$email', '$phone')";
    }
    
    if ($conn->query($sql) === TRUE) {
        $details_message = "Details saved successfully!";
    } else {
        $details_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}


$user_details = null;
$user_id = $_SESSION["id"];
$sql = "SELECT * FROM user_details WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user_details = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal - Homepage</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <div class="container homepage" id="homepage">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        
        <!-- Details Form -->
        <div class="details-section">
            <h2>Enter Your Details</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php if (!empty($details_message)): ?>
                    <div class="success-message"><?php echo $details_message; ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" 
                        value="<?php echo isset($user_details['full_name']) ? htmlspecialchars($user_details['full_name']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="120"
                        value="<?php echo isset($user_details['age']) ? htmlspecialchars($user_details['age']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select gender</option>
                        <option value="male" <?php echo (isset($user_details['gender']) && $user_details['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo (isset($user_details['gender']) && $user_details['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo (isset($user_details['gender']) && $user_details['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                        <option value="prefer-not-to-say" <?php echo (isset($user_details['gender']) && $user_details['gender'] == 'prefer-not-to-say') ? 'selected' : ''; ?>>Prefer not to say</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        value="<?php echo isset($user_details['email']) ? htmlspecialchars($user_details['email']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
                        value="<?php echo isset($user_details['phone']) ? htmlspecialchars($user_details['phone']) : ''; ?>">
                </div>
                <button type="submit" name="save_details">Save Details</button>
            </form>
        </div>
        
        <!-- Saved Details -->
        <div class="saved-details">
            <h2>Your Saved Details</h2>
            <?php if ($user_details): ?>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['full_name'] ?: 'Not provided'); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user_details['age'] ?: 'Not provided'); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_details['gender'] ?: 'Not provided'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email'] ?: 'Not provided'); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['phone'] ?: 'Not provided'); ?></p>
            <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($user_details['updated_at']); ?></p>
            <?php else: ?>
            <p>No details saved yet. Please fill in your information above.</p>
            <?php endif; ?>
        </div>
        
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit;
}
function getSavedData() {
    $username = $_SESSION['username'];
    $dataFile = "data/{$username}_profile.json";   
    if (file_exists($dataFile)) {
        $jsonData = file_get_contents($dataFile);
        return json_decode($jsonData, true);
    }
    return [
        'name' => '',
        'age' => '',
        'gender' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'occupation' => '',
        'bio' => ''
    ];
}
$userData = getSavedData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Personal Information System</title>
    <link rel="stylesheet" href="./css files/styleshome.css">
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">Personal Information System</div>
            <div class="user-info">
                <span class="username">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <form action="logout.php" method="post">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Personal Information</h2>
            </div>
            <div class="card-body">
                <form id="profileForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" min="1" max="120" value="<?php echo htmlspecialchars($userData['age']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="" disabled <?php echo empty($userData['gender']) ? 'selected' : ''; ?>>Select gender</option>
                                <option value="male" <?php echo $userData['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo $userData['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                                <option value="other" <?php echo $userData['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                                <option value="prefer-not-to-say" <?php echo $userData['gender'] === 'prefer-not-to-say' ? 'selected' : ''; ?>>Prefer not to say</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userData['phone']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($userData['occupation']); ?>">
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userData['address']); ?>">
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="bio">Bio/About Me</label>
                            <textarea id="bio" name="bio"><?php echo htmlspecialchars($userData['bio']); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="buttons">
                        <button type="submit" class="save-btn">Save Information</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card details-section">
            <div class="card-header">
                <h2 class="card-title">Saved Details</h2>
            </div>
            <div class="details-content">
                <div id="saved-details">
                    <?php if (empty($userData['name'])): ?>
                        <p>No saved information yet. Fill out the form above to save your details.</p>
                    <?php else: ?>
                        <div class="detail-item">
                            <div class="detail-label">Name:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['name']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Age:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['age']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Gender:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['gender']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['email']); ?></div>
                        </div>
                        <?php if (!empty($userData['phone'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Phone:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['phone']); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($userData['address'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Address:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['address']); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($userData['occupation'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Occupation:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($userData['occupation']); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($userData['bio'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Bio:</div>
                            <div class="detail-value"><?php echo nl2br(htmlspecialchars($userData['bio'])); ?></div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>  
    <div id="notification" class="notification">Information saved successfully!</div>   
    <script>
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            const formData = new FormData(this);
            const formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            fetch('save_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formObject)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {              
                    const notification = document.getElementById('notification');
                    notification.classList.add('show');
                    updateSavedDetails(formObject);
                    setTimeout(() => {
                        notification.classList.remove('show');
                    }, 3000);
                } else {
                    alert('Error saving data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving your data. Please try again.');
            });
        });
        function updateSavedDetails(data) {
            const detailsContainer = document.getElementById('saved-details'); 
            let html = '';
            html += createDetailItem('Name', data.name);
            html += createDetailItem('Age', data.age);
            html += createDetailItem('Gender', data.gender);
            html += createDetailItem('Email', data.email);
            if (data.phone) {
                html += createDetailItem('Phone', data.phone);
            }
            if (data.address) {
                html += createDetailItem('Address', data.address);
            }
            if (data.occupation) {
                html += createDetailItem('Occupation', data.occupation);
            }
            if (data.bio) {
                html += createDetailItem('Bio', data.bio.replace(/\n/g, '<br>'));
            }
            detailsContainer.innerHTML = html;
        }
        function createDetailItem(label, value) {
            return `
                <div class="detail-item">
                    <div class="detail-label">${label}:</div>
                    <div class="detail-value">${value}</div>
                </div>
            `;
        }
    </script>
</body>
</html>
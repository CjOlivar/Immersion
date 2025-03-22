// Function to show the selected tab
function showTab(tabName) {
    // Hide all tabs
    document.getElementById('login').style.display = 'none';
    document.getElementById('register').style.display = 'none';
    
    // Show the selected tab
    document.getElementById(tabName).style.display = 'block';
    
    // Update active tab button
    const tabButtons = document.getElementsByClassName('tab-button');
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove('active');
    }
    
    // Find and activate the clicked button
    const buttons = document.getElementsByClassName('tab-button');
    for (let i = 0; i < buttons.length; i++) {
        if (buttons[i].textContent.toLowerCase() === tabName) {
            buttons[i].classList.add('active');
        }
    }
}

// Check for login errors or registration messages in URL parameters
document.addEventListener('DOMContentLoaded', function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    
    // Handle login errors
    if (urlParams.has('login_error')) {
        const errorMsg = urlParams.get('login_error');
        document.getElementById('loginError').textContent = decodeURIComponent(errorMsg);
        showTab('login');
    }
    
    // Handle registration messages
    if (urlParams.has('reg_message')) {
        const regMsg = urlParams.get('reg_message');
        const messageElement = document.getElementById('registerMessage');
        messageElement.textContent = decodeURIComponent(regMsg);
        
        // Add success class if it's a success message
        if (regMsg.includes('successful')) {
            messageElement.className = 'success-message';
        } else {
            messageElement.className = 'error-message';
        }
        
        showTab('register');
    }
});
<?php
// Require login for this page
require_once 'includes/auth.php';
require_login();

// Get user information
$user = get_logged_in_user();

$pageTitle = "Crynance - My Profile";
include 'includes/header.php';
?>

<main class="dashboard-page">
    <section class="dashboard-header">
        <div class="container">
            <h1>My Profile</h1>
            <p>View and update your personal information</p>
        </div>
    </section>
    
    <section class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                <!-- Sidebar -->
                <div class="dashboard-sidebar">
                    <div class="user-info">
                        <div class="user-avatar">
                            <i data-feather="user"></i>
                        </div>
                        <div class="user-details">
                            <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                            <p><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                    
                    <ul class="dashboard-menu">
                        <li>
                            <a href="dashboard.php">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="wallets.php">
                                <i data-feather="credit-card"></i>
                                <span>My Wallets</span>
                            </a>
                        </li>
                        <li>
                            <a href="transactions.php">
                                <i data-feather="list"></i>
                                <span>Transaction History</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="profile.php">
                                <i data-feather="user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="settings.php">
                                <i data-feather="settings"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Main Content -->
                <div class="dashboard-main">
                    <!-- Personal Information -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Personal Information</h2>
                            <button class="btn btn-sm btn-outline-primary" id="edit-profile-btn">Edit Profile</button>
                        </div>
                        
                        <div id="profile-info">
                            <div class="profile-grid">
                                <div class="profile-item">
                                    <div class="profile-label">Full Name</div>
                                    <div class="profile-value"><?php echo htmlspecialchars($user['name']); ?></div>
                                </div>
                                
                                <div class="profile-item">
                                    <div class="profile-label">Email Address</div>
                                    <div class="profile-value"><?php echo htmlspecialchars($user['email']); ?></div>
                                </div>
                                
                                <div class="profile-item">
                                    <div class="profile-label">Member Since</div>
                                    <div class="profile-value">May 2023</div>
                                </div>
                                
                                <div class="profile-item">
                                    <div class="profile-label">Account Status</div>
                                    <div class="profile-value"><span class="badge badge-success">Active</span></div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="profile-form" style="display: none;">
                            <form action="includes/profile_handler.php" method="post" id="update-profile-form">
                                <input type="hidden" name="action" value="update_profile">
                                
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                
                                <div class="form-buttons">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <button type="button" class="btn btn-outline-secondary" id="cancel-edit-btn">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Security -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Security</h2>
                            <button class="btn btn-sm btn-outline-primary" id="change-password-btn">Change Password</button>
                        </div>
                        
                        <div id="security-info">
                            <div class="profile-grid">
                                <div class="profile-item">
                                    <div class="profile-label">Password</div>
                                    <div class="profile-value">••••••••</div>
                                </div>
                                
                                <div class="profile-item">
                                    <div class="profile-label">Two-Factor Authentication</div>
                                    <div class="profile-value"><span class="badge badge-warning">Disabled</span></div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="password-form" style="display: none;">
                            <form action="includes/profile_handler.php" method="post" id="change-password-form">
                                <input type="hidden" name="action" value="change_password">
                                
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                                    <small class="form-text text-muted">Password must be at least 8 characters and include a number and a special character</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                </div>
                                
                                <div class="form-buttons">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                    <button type="button" class="btn btn-outline-secondary" id="cancel-password-btn">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Preferences -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Preferences</h2>
                        </div>
                        
                        <div class="preference-list">
                            <div class="preference-item">
                                <div class="preference-info">
                                    <h3>Email Notifications</h3>
                                    <p>Receive email notifications about account activity and trading updates</p>
                                </div>
                                <div class="preference-control">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="preference-item">
                                <div class="preference-info">
                                    <h3>SMS Notifications</h3>
                                    <p>Receive SMS alerts for important account activities</p>
                                </div>
                                <div class="preference-control">
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="preference-item">
                                <div class="preference-info">
                                    <h3>Newsletter</h3>
                                    <p>Receive our weekly newsletter with market insights and tips</p>
                                </div>
                                <div class="preference-control">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit profile functionality
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const cancelEditBtn = document.getElementById('cancel-edit-btn');
    const profileInfo = document.getElementById('profile-info');
    const profileForm = document.getElementById('profile-form');
    
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function() {
            profileInfo.style.display = 'none';
            profileForm.style.display = 'block';
        });
    }
    
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            profileForm.style.display = 'none';
            profileInfo.style.display = 'block';
        });
    }
    
    // Change password functionality
    const changePasswordBtn = document.getElementById('change-password-btn');
    const cancelPasswordBtn = document.getElementById('cancel-password-btn');
    const securityInfo = document.getElementById('security-info');
    const passwordForm = document.getElementById('password-form');
    
    if (changePasswordBtn) {
        changePasswordBtn.addEventListener('click', function() {
            securityInfo.style.display = 'none';
            passwordForm.style.display = 'block';
        });
    }
    
    if (cancelPasswordBtn) {
        cancelPasswordBtn.addEventListener('click', function() {
            passwordForm.style.display = 'none';
            securityInfo.style.display = 'block';
        });
    }
    
    // Form validation for password change
    const passwordForm = document.getElementById('change-password-form');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(event) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Validate password strength
            if (newPassword.length < 8 || !/[0-9]/.test(newPassword) || !/[^A-Za-z0-9]/.test(newPassword)) {
                event.preventDefault();
                alert('Password must be at least 8 characters and include a number and a special character');
                return;
            }
            
            // Validate password match
            if (newPassword !== confirmPassword) {
                event.preventDefault();
                alert('New password and confirmation do not match');
                return;
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>

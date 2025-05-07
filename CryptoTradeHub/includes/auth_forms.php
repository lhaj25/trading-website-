<?php
/**
 * Authentication Forms
 * This file contains the HTML for the login and signup popup forms
 */
?>

<!-- Login Form Modal -->
<div id="login-modal" class="auth-modal">
    <div class="auth-modal-content">
        <span class="close-modal">&times;</span>
        
        <div class="auth-header">
            <h2>Log In</h2>
            <p>Welcome back! Log in to access your account.</p>
        </div>
        
        <div class="auth-message" id="login-message"></div>
        
        <form id="login-form" class="auth-form" method="post" action="includes/auth_handler.php">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label for="login-email">Email Address</label>
                <input type="email" id="login-email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" required>
                <div class="password-toggle">
                    <i data-feather="eye"></i>
                </div>
            </div>
            
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember-me" name="remember">
                    <label for="remember-me">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
        </form>
        
        <div class="auth-footer">
            <p>Don't have an account? <a href="#" id="show-signup">Sign Up</a></p>
        </div>
    </div>
</div>

<!-- Signup Form Modal -->
<div id="signup-modal" class="auth-modal">
    <div class="auth-modal-content">
        <span class="close-modal">&times;</span>
        
        <div class="auth-header">
            <h2>Sign Up</h2>
            <p>Create an account to start trading crypto</p>
        </div>
        
        <div class="auth-message" id="signup-message"></div>
        
        <form id="signup-form" class="auth-form" method="post" action="includes/auth_handler.php">
            <input type="hidden" name="action" value="signup">
            
            <div class="form-group">
                <label for="signup-name">Full Name</label>
                <input type="text" id="signup-name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="signup-email">Email Address</label>
                <input type="email" id="signup-email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" required>
                <div class="password-toggle">
                    <i data-feather="eye"></i>
                </div>
                <span class="password-hint">Password must be at least 8 characters and include a number and a special character</span>
            </div>
            
            <div class="form-group">
                <label for="signup-confirm">Confirm Password</label>
                <input type="password" id="signup-confirm" name="confirm_password" required>
            </div>
            
            <div class="form-terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>
        
        <div class="auth-footer">
            <p>Already have an account? <a href="#" id="show-login">Log In</a></p>
        </div>
    </div>
</div>
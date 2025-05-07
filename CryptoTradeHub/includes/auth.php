<?php
/**
 * Authentication Utilities
 * This file contains functions for checking user authentication status and permissions
 */

// Include required files
require_once 'user_model.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool True if user is logged in, false otherwise
 */
function is_logged_in() {
    // Check if user ID is set in session
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    
    // Check if auth token is set in cookies
    if (isset($_COOKIE['auth_token'])) {
        $user = validateSession($_COOKIE['auth_token']);
        
        if ($user) {
            // Update session with user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            return true;
        } else {
            // Invalid token, clear cookie
            setcookie('auth_token', '', time() - 3600, '/', '', false, true);
        }
    }
    
    return false;
}

/**
 * Get current logged in user data
 * @return array|null User data or null if not logged in
 */
function get_logged_in_user() {
    if (is_logged_in()) {
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? '',
            'email' => $_SESSION['user_email'] ?? ''
        ];
    }
    
    return null;
}

/**
 * Require user to be logged in to access the page
 * @param string $redirect_url URL to redirect to if not logged in
 * @return void
 */
function require_login($redirect_url = 'index.php') {
    if (!is_logged_in()) {
        // Redirect to specified page
        header('Location: ' . $redirect_url);
        exit;
    }
}

/**
 * Get user wallet balances
 * @return array Array of wallet balances
 */
function get_user_wallets() {
    if (is_logged_in()) {
        return getUserWallets($_SESSION['user_id']);
    }
    
    return [];
}

/**
 * Update user wallet balance
 * @param string $currency Currency code
 * @param float $amount Amount to add (positive) or subtract (negative)
 * @return bool Success status
 */
function update_user_wallet($currency, $amount) {
    if (is_logged_in()) {
        return updateWalletBalance($_SESSION['user_id'], $currency, $amount);
    }
    
    return false;
}
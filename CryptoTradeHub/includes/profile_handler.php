<?php
/**
 * Profile Handler
 * This file processes profile update and password change requests
 */

// Include required files
require_once 'form_handler.php';
require_once 'user_model.php';
require_once 'auth.php';
require_once 'db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set header to return JSON response
header('Content-Type: application/json');

// Check if user is logged in
if (!is_logged_in()) {
    $response = [
        'success' => false,
        'message' => 'You must be logged in to perform this action'
    ];
    
    echo json_encode($response);
    exit;
}

// Get user information
$user = get_logged_in_user();

/**
 * Update user profile
 * @param array $post_data POST data
 * @return array Response
 */
function update_profile($post_data) {
    global $user, $pdo;
    
    // Required fields
    $required_fields = ['name', 'email'];
    
    // Initialize variables
    $form_data = [];
    $errors = [];
    
    // Sanitize inputs
    foreach ($post_data as $key => $value) {
        $form_data[$key] = sanitize_input($value);
    }
    
    // Check required fields
    $errors = validate_required_fields($required_fields, $form_data);
    
    // Validate email format
    if (!empty($form_data['email']) && !is_valid_email($form_data['email'])) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // If validation fails, return errors
    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors,
            'message' => 'Please correct the errors below'
        ];
    }
    
    // Check if email is already in use by another user
    if ($form_data['email'] !== $user['email']) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$form_data['email'], $user['id']]);
        
        if ($stmt->fetchColumn()) {
            return [
                'success' => false,
                'message' => 'This email address is already registered. Please use a different email.'
            ];
        }
    }
    
    try {
        // Update user profile
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, updated_at = NOW() WHERE id = ?");
        $success = $stmt->execute([$form_data['name'], $form_data['email'], $user['id']]);
        
        if ($success) {
            // Update session data
            $_SESSION['user_name'] = $form_data['name'];
            $_SESSION['user_email'] = $form_data['email'];
            
            return [
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => [
                    'id' => $user['id'],
                    'name' => $form_data['name'],
                    'email' => $form_data['email']
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update profile. Please try again later.'
            ];
        }
    } catch (PDOException $e) {
        error_log("Error updating profile: " . $e->getMessage());
        
        return [
            'success' => false,
            'message' => 'An error occurred while updating your profile. Please try again later.'
        ];
    }
}

/**
 * Change user password
 * @param array $post_data POST data
 * @return array Response
 */
function change_password($post_data) {
    global $user, $pdo;
    
    // Required fields
    $required_fields = ['current_password', 'new_password', 'confirm_password'];
    
    // Initialize variables
    $form_data = [];
    $errors = [];
    
    // Sanitize inputs
    foreach ($post_data as $key => $value) {
        $form_data[$key] = sanitize_input($value);
    }
    
    // Check required fields
    $errors = validate_required_fields($required_fields, $form_data);
    
    // If validation fails, return errors
    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors,
            'message' => 'Please correct the errors below'
        ];
    }
    
    // Verify current password
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user['id']]);
    $current_hash = $stmt->fetchColumn();
    
    if (!password_verify($form_data['current_password'], $current_hash)) {
        return [
            'success' => false,
            'message' => 'Current password is incorrect'
        ];
    }
    
    // Validate password strength
    if (strlen($form_data['new_password']) < 8 || !preg_match('/[0-9]/', $form_data['new_password']) || !preg_match('/[^A-Za-z0-9]/', $form_data['new_password'])) {
        return [
            'success' => false,
            'message' => 'Password must be at least 8 characters and include a number and a special character'
        ];
    }
    
    // Check if passwords match
    if ($form_data['new_password'] !== $form_data['confirm_password']) {
        return [
            'success' => false,
            'message' => 'New password and confirmation do not match'
        ];
    }
    
    try {
        // Hash the new password
        $hash = password_hash($form_data['new_password'], PASSWORD_DEFAULT);
        
        // Update password
        $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        $success = $stmt->execute([$hash, $user['id']]);
        
        if ($success) {
            return [
                'success' => true,
                'message' => 'Password changed successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to change password. Please try again later.'
            ];
        }
    } catch (PDOException $e) {
        error_log("Error changing password: " . $e->getMessage());
        
        return [
            'success' => false,
            'message' => 'An error occurred while changing your password. Please try again later.'
        ];
    }
}

// Process the request based on the action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'update_profile':
            $response = update_profile($_POST);
            break;
            
        case 'change_password':
            $response = change_password($_POST);
            break;
            
        default:
            $response = [
                'success' => false,
                'message' => 'Invalid action'
            ];
    }
    
    // Return JSON response
    echo json_encode($response);
} else {
    // If not a POST request, return error
    $response = [
        'success' => false,
        'message' => 'Invalid request method'
    ];
    
    echo json_encode($response);
}
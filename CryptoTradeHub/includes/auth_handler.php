<?php
/**
 * Authentication Handler
 * This file processes login and signup requests
 */

// Include required files
require_once 'form_handler.php';
require_once 'user_model.php';
require_once 'db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set header to return JSON response
header('Content-Type: application/json');

// Function to handle user login
function handle_login($post_data) {
    // Required fields
    $required_fields = ['email', 'password'];
    
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
    
    // Verify user credentials
    $user = verifyUser($form_data['email'], $form_data['password']);
    
    if ($user) {
        // Get user's IP and user agent
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        // Create a session token
        $token = createSession($user['id'], $ip_address, $user_agent);
        
        if ($token) {
            // Store session token in cookie (30 days expiration)
            $remember = isset($form_data['remember']) && $form_data['remember'] === 'on';
            $expiry = $remember ? time() + (86400 * 30) : 0; // 30 days or session cookie
            
            setcookie('auth_token', $token, $expiry, '/', '', false, true);
            
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            // Success! User authenticated
            return [
                'success' => true,
                'message' => 'Login successful! Redirecting...',
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ]
            ];
        } else {
            // Failed to create session
            return [
                'success' => false,
                'message' => 'Authentication error. Please try again.'
            ];
        }
    } else {
        // Authentication failed
        return [
            'success' => false,
            'message' => 'Invalid email or password. Please try again.'
        ];
    }
}

// Function to handle user signup
function handle_signup($post_data) {
    // Required fields
    $required_fields = ['name', 'email', 'password', 'confirm_password', 'terms'];
    
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
    
    // Validate password strength
    if (!empty($form_data['password']) && (strlen($form_data['password']) < 8 || !preg_match('/[0-9]/', $form_data['password']) || !preg_match('/[^A-Za-z0-9]/', $form_data['password']))) {
        $errors['password'] = 'Password must be at least 8 characters and include a number and a special character';
    }
    
    // Check if passwords match
    if (!empty($form_data['password']) && !empty($form_data['confirm_password']) && $form_data['password'] !== $form_data['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    // If validation fails, return errors
    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors,
            'message' => 'Please correct the errors below'
        ];
    }
    
    // Check if email already exists
    $existingUser = getUserByEmail($form_data['email']);
    
    if ($existingUser) {
        return [
            'success' => false,
            'message' => 'This email address is already registered. Please log in or use a different email.'
        ];
    }
    
    // Create the new user
    $user = createUser($form_data['name'], $form_data['email'], $form_data['password']);
    
    if ($user) {
        // Registration successful
        return [
            'success' => true,
            'message' => 'Account created successfully! You can now log in.',
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ]
        ];
    } else {
        // Registration failed
        return [
            'success' => false,
            'message' => 'An error occurred during registration. Please try again later.'
        ];
    }
}

// Function to handle user logout
function handle_logout() {
    // Check if user has a valid session token
    $token = $_COOKIE['auth_token'] ?? null;
    
    if ($token) {
        // End the session in the database
        endSession($token);
    }
    
    // Clear session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    // Clear the auth token cookie
    setcookie('auth_token', '', time() - 3600, '/', '', false, true);
    
    return [
        'success' => true,
        'message' => 'You have been logged out successfully.'
    ];
}

// Process the request based on the action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'login':
            $response = handle_login($_POST);
            break;
            
        case 'signup':
            $response = handle_signup($_POST);
            break;
            
        case 'logout':
            $response = handle_logout();
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
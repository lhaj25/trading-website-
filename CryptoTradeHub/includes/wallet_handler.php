<?php
/**
 * Wallet Handler
 * This file processes deposit and withdrawal requests
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
 * Handle deposit request
 * @param array $post_data POST data
 * @return array Response
 */
function handle_deposit($post_data) {
    global $user;
    
    // Required fields
    $required_fields = ['currency', 'amount'];
    
    // Initialize variables
    $form_data = [];
    $errors = [];
    
    // Sanitize inputs
    foreach ($post_data as $key => $value) {
        $form_data[$key] = sanitize_input($value);
    }
    
    // Check required fields
    $errors = validate_required_fields($required_fields, $form_data);
    
    // Validate amount
    if (!empty($form_data['amount']) && (!is_numeric($form_data['amount']) || $form_data['amount'] <= 0)) {
        $errors['amount'] = 'Please enter a valid amount';
    }
    
    // Validate currency
    $allowed_currencies = ['USD', 'BTC', 'ETH'];
    if (!empty($form_data['currency']) && !in_array($form_data['currency'], $allowed_currencies)) {
        $errors['currency'] = 'Invalid currency';
    }
    
    // If validation fails, return errors
    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors,
            'message' => 'Please correct the errors below'
        ];
    }
    
    // Check if USD deposit includes payment method
    if ($form_data['currency'] === 'USD' && empty($form_data['payment_method'])) {
        return [
            'success' => false,
            'message' => 'Please select a payment method'
        ];
    }
    
    // In a real application, you would:
    // 1. Process the payment via a payment processor
    // 2. Update the user's wallet balance once the payment is confirmed
    // 3. Create a transaction record
    
    // For this demo, we'll simulate a successful deposit
    $amount = floatval($form_data['amount']);
    $currency = $form_data['currency'];
    
    // Update wallet balance
    $success = update_user_wallet($currency, $amount);
    
    if ($success) {
        return [
            'success' => true,
            'message' => "Deposit of {$amount} {$currency} processed successfully",
            'amount' => $amount,
            'currency' => $currency
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to process deposit. Please try again later.'
        ];
    }
}

/**
 * Handle withdrawal request
 * @param array $post_data POST data
 * @return array Response
 */
function handle_withdrawal($post_data) {
    global $user;
    
    // Required fields
    $required_fields = ['currency', 'amount'];
    
    // Initialize variables
    $form_data = [];
    $errors = [];
    
    // Sanitize inputs
    foreach ($post_data as $key => $value) {
        $form_data[$key] = sanitize_input($value);
    }
    
    // Check required fields
    $errors = validate_required_fields($required_fields, $form_data);
    
    // Validate amount
    if (!empty($form_data['amount']) && (!is_numeric($form_data['amount']) || $form_data['amount'] <= 0)) {
        $errors['amount'] = 'Please enter a valid amount';
    }
    
    // Validate currency
    $allowed_currencies = ['USD', 'BTC', 'ETH'];
    if (!empty($form_data['currency']) && !in_array($form_data['currency'], $allowed_currencies)) {
        $errors['currency'] = 'Invalid currency';
    }
    
    // If validation fails, return errors
    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors,
            'message' => 'Please correct the errors below'
        ];
    }
    
    // Get user's wallets
    $wallets = get_user_wallets();
    $has_sufficient_funds = false;
    
    foreach ($wallets as $wallet) {
        if ($wallet['currency'] === $form_data['currency'] && $wallet['balance'] >= floatval($form_data['amount'])) {
            $has_sufficient_funds = true;
            break;
        }
    }
    
    if (!$has_sufficient_funds) {
        return [
            'success' => false,
            'message' => 'Insufficient funds for withdrawal'
        ];
    }
    
    // Check additional required fields based on currency
    if ($form_data['currency'] === 'USD') {
        if (empty($form_data['withdraw_method'])) {
            return [
                'success' => false,
                'message' => 'Please select a withdrawal method'
            ];
        }
        
        if ($form_data['withdraw_method'] === 'bank_transfer' && empty($form_data['bank_account'])) {
            return [
                'success' => false,
                'message' => 'Please enter your bank account information'
            ];
        }
        
        if ($form_data['withdraw_method'] === 'paypal' && empty($form_data['paypal_email'])) {
            return [
                'success' => false,
                'message' => 'Please enter your PayPal email address'
            ];
        }
    } else {
        // Crypto withdrawal
        if (empty($form_data['wallet_address'])) {
            return [
                'success' => false,
                'message' => 'Please enter a valid wallet address'
            ];
        }
        
        if (empty($form_data['network'])) {
            return [
                'success' => false,
                'message' => 'Please select a network'
            ];
        }
    }
    
    // In a real application, you would:
    // 1. Process the withdrawal via appropriate channels
    // 2. Update the user's wallet balance once the withdrawal is confirmed
    // 3. Create a transaction record
    
    // For this demo, we'll simulate a successful withdrawal
    $amount = floatval($form_data['amount']);
    $currency = $form_data['currency'];
    
    // Update wallet balance (negative amount for withdrawal)
    $success = update_user_wallet($currency, -$amount);
    
    if ($success) {
        return [
            'success' => true,
            'message' => "Withdrawal of {$amount} {$currency} processed successfully",
            'amount' => $amount,
            'currency' => $currency
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to process withdrawal. Please try again later.'
        ];
    }
}

// Process the request based on the action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    switch ($action) {
        case 'deposit':
            $response = handle_deposit($_POST);
            break;
            
        case 'withdraw':
            $response = handle_withdrawal($_POST);
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
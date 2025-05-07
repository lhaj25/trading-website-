<?php
/**
 * Form Handler
 * This file contains functions for handling form submissions and validation.
 */

// Function to sanitize form inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email format
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate required fields
function validate_required_fields($required_fields, $form_data) {
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (empty($form_data[$field])) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
        }
    }
    
    return $errors;
}

// Function to handle contact form submission
function handle_contact_form($post_data) {
    // Define required fields
    $required_fields = ['name', 'email', 'subject', 'message'];
    
    // Initialize variables
    $form_data = [];
    $errors = [];
    
    // Sanitize and validate form data
    foreach ($post_data as $key => $value) {
        $form_data[$key] = sanitize_input($value);
    }
    
    // Check required fields
    $errors = validate_required_fields($required_fields, $form_data);
    
    // Validate email format
    if (!empty($form_data['email']) && !is_valid_email($form_data['email'])) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // Validate name format (letters and spaces only)
    if (!empty($form_data['name']) && !preg_match("/^[a-zA-Z ]*$/", $form_data['name'])) {
        $errors['name'] = 'Name should contain only letters and spaces';
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Store the message in a database
        // 2. Send an email notification
        // 3. Set up an auto-responder
        
        // For this demo, we'll just return success
        return [
            'success' => true,
            'message' => 'Thank you for your message. We will get back to you soon.',
            'data' => $form_data
        ];
    } else {
        return [
            'success' => false,
            'errors' => $errors,
            'data' => $form_data
        ];
    }
}

// Function to handle newsletter subscription
function handle_newsletter_subscription($email) {
    // Sanitize email
    $email = sanitize_input($email);
    
    // Validate email
    if (empty($email)) {
        return [
            'success' => false,
            'error' => 'Email address is required'
        ];
    }
    
    if (!is_valid_email($email)) {
        return [
            'success' => false,
            'error' => 'Please enter a valid email address'
        ];
    }
    
    // In a real application, you would:
    // 1. Check if the email already exists in your database
    // 2. Add the email to your newsletter database or send to a marketing service like Mailchimp
    // 3. Send a confirmation email
    
    // For this demo, we'll just return success
    return [
        'success' => true,
        'message' => 'Thank you for subscribing to our newsletter!'
    ];
}

// Function to process a cryptocurrency order (buy/sell)
function process_crypto_order($order_data) {
    // In a real application, this would connect to a trading engine
    // For this demo, we'll just validate the inputs and return a mock response
    
    // Required fields
    $required_fields = ['type', 'symbol', 'amount', 'price'];
    $errors = validate_required_fields($required_fields, $order_data);
    
    // Validate amount and price
    if (!empty($order_data['amount']) && (!is_numeric($order_data['amount']) || $order_data['amount'] <= 0)) {
        $errors['amount'] = 'Please enter a valid amount';
    }
    
    if (!empty($order_data['price']) && (!is_numeric($order_data['price']) || $order_data['price'] <= 0)) {
        $errors['price'] = 'Please enter a valid price';
    }
    
    // If validation fails, return errors
    if (!empty($errors)) {
        return [
            'success' => false,
            'errors' => $errors,
            'data' => $order_data
        ];
    }
    
    // Calculate total
    $total = $order_data['amount'] * $order_data['price'];
    
    // Generate a unique order ID
    $order_id = uniqid('ORD');
    
    // Return successful response with order details
    return [
        'success' => true,
        'message' => 'Order placed successfully',
        'order' => [
            'id' => $order_id,
            'type' => $order_data['type'],
            'symbol' => $order_data['symbol'],
            'amount' => $order_data['amount'],
            'price' => $order_data['price'],
            'total' => $total,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
}

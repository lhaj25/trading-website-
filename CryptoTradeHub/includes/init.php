<?php
/**
 * Initialization File
 * This file is included at the beginning of every page to initialize the application
 */

// Include database configuration and models
require_once 'db.php';
require_once 'user_model.php';
require_once 'auth.php';

// Run database setup on first load or when DEBUG=true
// This ensures tables are created if they don't exist
$debug_mode = getenv('DEBUG') === 'true' || !file_exists(__DIR__ . '/../.db_initialized');

if ($debug_mode) {
    // Include and run database setup
    require_once 'db.php';
    
    // Create a file to indicate that the database has been initialized
    file_put_contents(__DIR__ . '/../.db_initialized', date('Y-m-d H:i:s'));
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Function to display error messages
 * @param string $message Error message
 * @param string $type Type of error (danger, warning, success, info)
 * @return string HTML for the error message
 */
function display_error($message, $type = 'danger') {
    return '<div class="alert alert-' . $type . '">' . $message . '</div>';
}

/**
 * Function to log application errors
 * @param string $message Error message
 * @param string $level Error level
 * @return void
 */
function app_log($message, $level = 'ERROR') {
    $log_file = __DIR__ . '/../logs/app.log';
    
    // Create logs directory if it doesn't exist
    if (!file_exists(__DIR__ . '/../logs')) {
        mkdir(__DIR__ . '/../logs', 0755, true);
    }
    
    // Format log message
    $log_message = date('Y-m-d H:i:s') . ' [' . $level . '] ' . $message . PHP_EOL;
    
    // Append to log file
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

/**
 * Function to format price with proper decimal places
 * @param float $price Price to format
 * @param int $decimals Number of decimal places
 * @return string Formatted price
 */
function format_price($price, $decimals = 2) {
    return number_format($price, $decimals);
}

/**
 * Function to format cryptocurrency price with proper decimal places
 * @param float $price Price to format
 * @param string $symbol Cryptocurrency symbol
 * @return string Formatted price
 */
function format_crypto_price($price, $symbol = 'BTC') {
    // Default to 2 decimal places
    $decimals = 2;
    
    // Adjust decimal places based on cryptocurrency
    switch (strtoupper($symbol)) {
        case 'BTC':
            $decimals = $price < 0.1 ? 8 : 6;
            break;
            
        case 'ETH':
        case 'BCH':
        case 'LTC':
            $decimals = 5;
            break;
            
        case 'XRP':
        case 'XLM':
        case 'ADA':
        case 'DOT':
            $decimals = 4;
            break;
            
        case 'DOGE':
        case 'SHIB':
            $decimals = 8;
            break;
    }
    
    return number_format($price, $decimals);
}
<?php
/**
 * User Model
 * This file contains functions for managing user data in the database
 */

// Include database configuration
require_once 'db.php';

/**
 * Get user by ID
 * @param int $id User ID
 * @return array|null User data or null if not found
 */
function getUserById($id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Get user by email
 * @param string $email User email
 * @return array|null User data or null if not found
 */
function getUserByEmail($email) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

/**
 * Create a new user
 * @param string $name User's name
 * @param string $email User's email
 * @param string $password Password (will be hashed)
 * @return array|bool New user data or false on failure
 */
function createUser($name, $email, $password) {
    global $pdo;
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        // Start transaction
        $pdo->beginTransaction();
        
        // Insert user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?) RETURNING id");
        $stmt->execute([$name, $email, $hashedPassword]);
        $userId = $stmt->fetchColumn();
        
        // Initialize user wallets with default balances
        $walletStmt = $pdo->prepare("INSERT INTO user_wallets (user_id, currency, balance) VALUES (?, ?, ?)");
        $walletStmt->execute([$userId, 'USD', 1000.00]); // Default $1000 USD
        $walletStmt->execute([$userId, 'BTC', 0.0]); // Empty BTC wallet
        $walletStmt->execute([$userId, 'ETH', 0.0]); // Empty ETH wallet
        
        // Commit transaction
        $pdo->commit();
        
        // Return the new user
        return getUserById($userId);
    } catch (PDOException $e) {
        // Rollback on error
        $pdo->rollBack();
        error_log("Error creating user: " . $e->getMessage());
        return false;
    }
}

/**
 * Verify user password
 * @param string $email User email
 * @param string $password Password to verify
 * @return array|bool User data if verification successful, false otherwise
 */
function verifyUser($email, $password) {
    $user = getUserByEmail($email);
    
    if (!$user) {
        return false;
    }
    
    if (password_verify($password, $user['password'])) {
        return $user;
    }
    
    return false;
}

/**
 * Create a new session for a user
 * @param int $userId User ID
 * @param string $ipAddress IP address
 * @param string $userAgent User agent string
 * @return string|bool Session token or false on failure
 */
function createSession($userId, $ipAddress = null, $userAgent = null) {
    global $pdo;
    
    // Generate a random token
    $token = bin2hex(random_bytes(32));
    
    // Set expiration time (24 hours from now)
    $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    try {
        $stmt = $pdo->prepare("INSERT INTO sessions (user_id, token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $token, $ipAddress, $userAgent, $expiresAt]);
        
        return $token;
    } catch (PDOException $e) {
        error_log("Error creating session: " . $e->getMessage());
        return false;
    }
}

/**
 * Validate session token
 * @param string $token Session token
 * @return array|bool User data if session is valid, false otherwise
 */
function validateSession($token) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT u.* FROM users u
            JOIN sessions s ON u.id = s.user_id
            WHERE s.token = ? AND s.expires_at > NOW()
        ");
        $stmt->execute([$token]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error validating session: " . $e->getMessage());
        return false;
    }
}

/**
 * End a user session
 * @param string $token Session token
 * @return bool Success status
 */
function endSession($token) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE token = ?");
        $stmt->execute([$token]);
        return true;
    } catch (PDOException $e) {
        error_log("Error ending session: " . $e->getMessage());
        return false;
    }
}

/**
 * Get user wallet balances
 * @param int $userId User ID
 * @return array Array of wallet balances
 */
function getUserWallets($userId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT currency, balance FROM user_wallets WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error getting user wallets: " . $e->getMessage());
        return [];
    }
}

/**
 * Update user wallet balance
 * @param int $userId User ID
 * @param string $currency Currency code
 * @param float $amount Amount to add (positive) or subtract (negative)
 * @return bool Success status
 */
function updateWalletBalance($userId, $currency, $amount) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Check if wallet exists
        $stmt = $pdo->prepare("SELECT balance FROM user_wallets WHERE user_id = ? AND currency = ?");
        $stmt->execute([$userId, $currency]);
        $wallet = $stmt->fetch();
        
        if ($wallet) {
            // Update existing wallet
            $newBalance = $wallet['balance'] + $amount;
            
            // Prevent negative balances
            if ($newBalance < 0) {
                $pdo->rollBack();
                return false;
            }
            
            $stmt = $pdo->prepare("UPDATE user_wallets SET balance = ?, updated_at = NOW() WHERE user_id = ? AND currency = ?");
            $stmt->execute([$newBalance, $userId, $currency]);
        } else {
            // Create new wallet if amount is positive
            if ($amount <= 0) {
                $pdo->rollBack();
                return false;
            }
            
            $stmt = $pdo->prepare("INSERT INTO user_wallets (user_id, currency, balance) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $currency, $amount]);
        }
        
        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Error updating wallet balance: " . $e->getMessage());
        return false;
    }
}

/**
 * Create password reset token
 * @param int $userId User ID
 * @return string|bool Token or false on failure
 */
function createPasswordResetToken($userId) {
    global $pdo;
    
    // Generate a random token
    $token = bin2hex(random_bytes(32));
    
    // Set expiration time (1 hour from now)
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    try {
        // Remove any existing tokens for this user
        $stmt = $pdo->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // Create new token
        $stmt = $pdo->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $token, $expiresAt]);
        
        return $token;
    } catch (PDOException $e) {
        error_log("Error creating password reset token: " . $e->getMessage());
        return false;
    }
}

/**
 * Validate password reset token
 * @param string $token Reset token
 * @return int|bool User ID if token is valid, false otherwise
 */
function validatePasswordResetToken($token) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT user_id FROM password_reset_tokens WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Error validating password reset token: " . $e->getMessage());
        return false;
    }
}

/**
 * Update user password
 * @param int $userId User ID
 * @param string $password New password
 * @return bool Success status
 */
function updatePassword($userId, $password) {
    global $pdo;
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $pdo->beginTransaction();
        
        // Update password
        $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
        
        // Delete any password reset tokens
        $stmt = $pdo->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Error updating password: " . $e->getMessage());
        return false;
    }
}
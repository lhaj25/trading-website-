<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crypto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = <<<SQL
-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create User Profiles Table
CREATE TABLE IF NOT EXISTS user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    profile_picture VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    country VARCHAR(100),
    postal_code VARCHAR(20),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Create User Wallets Table
CREATE TABLE IF NOT EXISTS user_wallets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    currency VARCHAR(10) NOT NULL,
    balance DECIMAL(20, 8) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    UNIQUE (user_id, currency)
);

-- Create Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    order_type VARCHAR(10) NOT NULL, -- 'market', 'limit'
    side VARCHAR(10) NOT NULL, -- 'buy', 'sell'
    symbol VARCHAR(10) NOT NULL,
    price DECIMAL(20, 8) NOT NULL,
    amount DECIMAL(20, 8) NOT NULL,
    filled DECIMAL(20, 8) DEFAULT 0,
    status VARCHAR(20) NOT NULL, -- 'open', 'filled', 'canceled'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Create Transactions Table
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    order_id INTEGER,
    transaction_type VARCHAR(20) NOT NULL, -- 'deposit', 'withdrawal', 'trade'
    currency VARCHAR(10) NOT NULL,
    amount DECIMAL(20, 8) NOT NULL,
    fee DECIMAL(20, 8) DEFAULT 0,
    status VARCHAR(20) NOT NULL, -- 'completed', 'pending', 'failed'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE 

-- Create Password Re

-- Create Sessions Table
CREATE TABLE IF NOT EXISTS sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    token VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Create API Keys Table for users who want to use the API
CREATE TABLE IF NOT EXISTS api_keys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER NOT NULL,
    api_key VARCHAR(100) NOT NULL,
    api_secret VARCHAR(255) NOT NULL,
    permissions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Insert default demo user (for testing purposes)
INSERT INTO users (name, email, password) 
VALUES ('Demo User', 'demo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON CONFLICT (email) DO NOTHING;

-- Give the demo user some wallet balances
INSERT INTO user_wallets (user_id, currency, balance)
VALUES 
    ((SELECT id FROM users WHERE email = 'demo@example.com'), 'USD', 10000.00),
    ((SELECT id FROM users WHERE email = 'demo@example.com'), 'BTC', 0.5),
    ((SELECT id FROM users WHERE email = 'demo@example.com'), 'ETH', 5.0)
ON CONFLICT (user_id, currency) DO NOTHING;
SQL;

if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>

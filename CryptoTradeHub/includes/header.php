<?php
// Include initialization file
require_once 'db.php';
require_once 'user_model.php';
require_once 'auth.php';
//require_once 'includes/init.php';

// Get current page for navigation highlighting
$currentPage = basename($_SERVER['PHP_SELF']);

// Get current user (if logged in)
$currentUser = get_logged_in_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'CryptoTrade'; ?></title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&family=IBM+Plex+Mono&display=swap" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Chart.js for trading charts -->
    <?php if ($currentPage == 'trading.php'): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php">
                        <img src="assets/logo.svg" alt="CryptoTrade Logo">
                        <h1>CryptoTrade</h1>
                    </a>
                </div>
                
                <button class="nav-toggle" aria-label="Toggle Navigation">
                    <i data-feather="menu"></i>
                </button>
                
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="trading.php" class="nav-link <?php echo ($currentPage == 'trading.php') ? 'active' : ''; ?>">Trading</a>
                    </li>
                    <li class="nav-item">
                        <a href="education.php" class="nav-link <?php echo ($currentPage == 'education.php') ? 'active' : ''; ?>">Education</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.php" class="nav-link <?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="faq.php" class="nav-link <?php echo ($currentPage == 'faq.php') ? 'active' : ''; ?>">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contact</a>
                    </li>
                </ul>
                
                <div class="user-actions">
                    <?php if ($currentUser): ?>
                        <div class="user-dropdown">
                            <button class="user-dropdown-toggle">
                                <i data-feather="user"></i>
                                <span><?php echo htmlspecialchars($currentUser['name']); ?></span>
                                <i data-feather="chevron-down"></i>
                            </button>
                            <div class="user-dropdown-menu">
                                <a href="dashboard.php" class="dropdown-item">
                                    <i data-feather="home"></i> Dashboard
                                </a>
                                <a href="profile.php" class="dropdown-item">
                                    <i data-feather="user"></i> My Profile
                                </a>
                                <a href="wallets.php" class="dropdown-item">
                                    <i data-feather="credit-card"></i> My Wallets
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" id="logout-btn" class="dropdown-item">
                                    <i data-feather="log-out"></i> Log Out
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="#" class="btn btn-outline-primary" id="login-btn">Log In</a>
                        <a href="#" class="btn btn-primary" id="signup-btn">Sign Up</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        
        <!-- Cryptocurrency Price Ticker -->
        <div class="header-ticker"></div>
    </header>

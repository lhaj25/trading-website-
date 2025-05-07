<?php
// Require login for this page
require_once 'includes/auth.php';
require_login();

// Get user information
$user = get_logged_in_user();
$wallets = get_user_wallets();

$pageTitle = "Crynance - Dashboard";
include 'includes/header.php';
?>

<main class="dashboard-page">
    <section class="dashboard-header">
        <div class="container">
            <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p>Manage your accounts, view your trading history, and track your portfolio performance.</p>
        </div>
    </section>
    
    <section class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                <!-- Sidebar -->
                <div class="dashboard-sidebar">
                    <div class="user-info">
                        <div class="user-avatar">
                            <i data-feather="user"></i>
                        </div>
                        <div class="user-details">
                            <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                            <p><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                    
                    <ul class="dashboard-menu">
                        <li class="active">
                            <a href="dashboard.php">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="wallets.php">
                                <i data-feather="credit-card"></i>
                                <span>My Wallets</span>
                            </a>
                        </li>
                        <li>
                            <a href="transactions.php">
                                <i data-feather="list"></i>
                                <span>Transaction History</span>
                            </a>
                        </li>
                        <li>
                            <a href="profile.php">
                                <i data-feather="user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="settings.php">
                                <i data-feather="settings"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Main Content -->
                <div class="dashboard-main">
                    <!-- Wallet Overview -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Your Wallets</h2>
                            <a href="wallets.php" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        
                        <div class="wallet-cards">
                            <?php if (empty($wallets)): ?>
                                <div class="empty-state">
                                    <i data-feather="credit-card"></i>
                                    <p>You don't have any wallets yet.</p>
                                    <a href="wallets.php" class="btn btn-primary">Add Wallet</a>
                                </div>
                            <?php else: ?>
                                <?php foreach ($wallets as $wallet): ?>
                                    <div class="wallet-card">
                                        <div class="wallet-icon">
                                            <?php if ($wallet['currency'] === 'USD'): ?>
                                                <i data-feather="dollar-sign"></i>
                                            <?php elseif ($wallet['currency'] === 'BTC'): ?>
                                                <i data-feather="bitcoin"></i>
                                            <?php elseif ($wallet['currency'] === 'ETH'): ?>
                                                <i data-feather="hash"></i>
                                            <?php else: ?>
                                                <i data-feather="credit-card"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="wallet-details">
                                            <h3><?php echo htmlspecialchars($wallet['currency']); ?> Wallet</h3>
                                            <p class="wallet-balance">
                                                <?php if ($wallet['currency'] === 'USD'): ?>
                                                    $<?php echo number_format($wallet['balance'], 2); ?>
                                                <?php else: ?>
                                                    <?php echo format_crypto_price($wallet['balance'], $wallet['currency']); ?> <?php echo htmlspecialchars($wallet['currency']); ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="wallet-actions">
                                            <a href="wallets.php?action=deposit&currency=<?php echo urlencode($wallet['currency']); ?>" class="btn btn-sm btn-outline-primary">Deposit</a>
                                            <a href="wallets.php?action=withdraw&currency=<?php echo urlencode($wallet['currency']); ?>" class="btn btn-sm btn-outline-secondary">Withdraw</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Recent Transactions -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Recent Transactions</h2>
                            <a href="transactions.php" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        
                        <div class="transaction-list">
                            <!-- For now, show a message that we'll implement this later -->
                            <div class="empty-state">
                                <i data-feather="list"></i>
                                <p>No recent transactions found.</p>
                                <a href="trading.php" class="btn btn-primary">Start Trading</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Market Overview -->
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Market Overview</h2>
                            <a href="trading.php" class="btn btn-sm btn-outline-primary">Go to Trading</a>
                        </div>
                        
                        <div class="market-summary">
                            <div class="market-card">
                                <div class="market-header">
                                    <div class="market-icon">
                                        <i data-feather="bitcoin"></i>
                                    </div>
                                    <div class="market-info">
                                        <h3>Bitcoin</h3>
                                        <p>BTC / USD</p>
                                    </div>
                                </div>
                                <div class="market-price">
                                    <span class="price">$43,250.78</span>
                                    <span class="change up">+2.4%</span>
                                </div>
                                <div class="market-chart">
                                    <!-- Small chart will go here -->
                                    <div class="mini-chart" id="btc-mini-chart"></div>
                                </div>
                            </div>
                            
                            <div class="market-card">
                                <div class="market-header">
                                    <div class="market-icon">
                                        <i data-feather="hash"></i>
                                    </div>
                                    <div class="market-info">
                                        <h3>Ethereum</h3>
                                        <p>ETH / USD</p>
                                    </div>
                                </div>
                                <div class="market-price">
                                    <span class="price">$3,185.42</span>
                                    <span class="change down">-1.2%</span>
                                </div>
                                <div class="market-chart">
                                    <!-- Small chart will go here -->
                                    <div class="mini-chart" id="eth-mini-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

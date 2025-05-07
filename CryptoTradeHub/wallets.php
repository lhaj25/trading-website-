<?php
// Require login for this page
require_once 'includes/auth.php';
require_login();

// Get user information
$user = get_logged_in_user();
$wallets = get_user_wallets();

// Process any action parameters
$action = isset($_GET['action']) ? $_GET['action'] : '';
$currency = isset($_GET['currency']) ? $_GET['currency'] : '';

$pageTitle = "crynance - My Wallets";
include 'includes/header.php';
?>

<main class="dashboard-page">
    <section class="dashboard-header">
        <div class="container">
            <h1>My Wallets</h1>
            <p>Manage your cryptocurrency and fiat wallets, make deposits and withdrawals</p>
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
                        <li>
                            <a href="dashboard.php">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="active">
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
                    <!-- Modal Forms (shown conditionally) -->
                    <?php if ($action === 'deposit' && $currency): ?>
                        <!-- Deposit Modal -->
                        <div class="dashboard-section">
                            <div class="section-header">
                                <h2>Deposit <?php echo htmlspecialchars($currency); ?></h2>
                                <a href="wallets.php" class="btn btn-sm btn-outline-secondary">Cancel</a>
                            </div>
                            
                            <div class="modal-form">
                                <?php if ($currency === 'USD'): ?>
                                    <!-- USD Deposit Form -->
                                    <form action="includes/wallet_handler.php" method="post" id="usd-deposit-form">
                                        <input type="hidden" name="action" value="deposit">
                                        <input type="hidden" name="currency" value="USD">
                                        
                                        <div class="form-group">
                                            <label for="amount">Amount (USD)</label>
                                            <div class="input-group">
                                                <div class="input-prefix">$</div>
                                                <input type="number" id="amount" name="amount" class="form-control" min="10" step="0.01" required>
                                            </div>
                                            <small class="form-text text-muted">Minimum deposit: $10.00</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method</label>
                                            <select id="payment_method" name="payment_method" class="form-control" required>
                                                <option value="">Select payment method</option>
                                                <option value="credit_card">Credit/Debit Card</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="paypal">PayPal</option>
                                            </select>
                                        </div>
                                        
                                        <div id="payment-details" class="form-group" style="display: none;">
                                            <!-- Payment details will be shown based on selected method -->
                                        </div>
                                        
                                        <div class="form-buttons">
                                            <button type="submit" class="btn btn-primary">Deposit Funds</button>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <!-- Crypto Deposit -->
                                    <div class="crypto-deposit">
                                        <div class="deposit-info">
                                            <p>To deposit <?php echo htmlspecialchars($currency); ?>, send your funds to the following address:</p>
                                            
                                            <div class="wallet-address-container">
                                                <div class="wallet-address">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</div>
                                                <button class="btn btn-sm btn-outline-primary copy-address-btn" data-clipboard-text="bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh">
                                                    <i data-feather="copy"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="qr-code">
                                                <!-- QR code placeholder - in a real app, this would be generated dynamically -->
                                                <div class="qr-placeholder">
                                                    <i data-feather="square"></i>
                                                    <span>QR Code</span>
                                                </div>
                                            </div>
                                            
                                            <div class="deposit-notice">
                                                <h4>Important Notice:</h4>
                                                <ul>
                                                    <li>Only send <?php echo htmlspecialchars($currency); ?> to this address</li>
                                                    <li>Sending any other cryptocurrency may result in permanent loss</li>
                                                    <li>Minimum deposit: 0.001 <?php echo htmlspecialchars($currency); ?></li>
                                                    <li>Your deposit will be credited after 3 network confirmations</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php elseif ($action === 'withdraw' && $currency): ?>
                        <!-- Withdraw Modal -->
                        <div class="dashboard-section">
                            <div class="section-header">
                                <h2>Withdraw <?php echo htmlspecialchars($currency); ?></h2>
                                <a href="wallets.php" class="btn btn-sm btn-outline-secondary">Cancel</a>
                            </div>
                            
                            <div class="modal-form">
                                <form action="includes/wallet_handler.php" method="post" id="withdraw-form">
                                    <input type="hidden" name="action" value="withdraw">
                                    <input type="hidden" name="currency" value="<?php echo htmlspecialchars($currency); ?>">
                                    
                                    <div class="form-group">
                                        <label for="withdraw_amount">Amount (<?php echo htmlspecialchars($currency); ?>)</label>
                                        <div class="input-group">
                                            <?php if ($currency === 'USD'): ?>
                                                <div class="input-prefix">$</div>
                                            <?php endif; ?>
                                            <input type="number" id="withdraw_amount" name="amount" class="form-control" min="0.01" step="0.01" required>
                                        </div>
                                        
                                        <?php foreach ($wallets as $wallet): ?>
                                            <?php if ($wallet['currency'] === $currency): ?>
                                                <small class="form-text text-muted">
                                                    Available balance: 
                                                    <?php if ($currency === 'USD'): ?>
                                                        $<?php echo number_format($wallet['balance'], 2); ?>
                                                    <?php else: ?>
                                                        <?php echo format_crypto_price($wallet['balance'], $currency); ?> <?php echo htmlspecialchars($currency); ?>
                                                    <?php endif; ?>
                                                </small>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <?php if ($currency === 'USD'): ?>
                                        <!-- USD Withdrawal Fields -->
                                        <div class="form-group">
                                            <label for="withdraw_method">Withdrawal Method</label>
                                            <select id="withdraw_method" name="withdraw_method" class="form-control" required>
                                                <option value="">Select withdrawal method</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="paypal">PayPal</option>
                                            </select>
                                        </div>
                                        
                                        <div id="bank-details" class="form-group" style="display: none;">
                                            <label for="bank_account">Bank Account</label>
                                            <input type="text" id="bank_account" name="bank_account" class="form-control" placeholder="Bank Account Number">
                                        </div>
                                        
                                        <div id="paypal-details" class="form-group" style="display: none;">
                                            <label for="paypal_email">PayPal Email</label>
                                            <input type="email" id="paypal_email" name="paypal_email" class="form-control" placeholder="your-email@example.com">
                                        </div>
                                    <?php else: ?>
                                        <!-- Crypto Withdrawal Fields -->
                                        <div class="form-group">
                                            <label for="wallet_address"><?php echo htmlspecialchars($currency); ?> Wallet Address</label>
                                            <input type="text" id="wallet_address" name="wallet_address" class="form-control" placeholder="Enter your wallet address" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="network">Network</label>
                                            <select id="network" name="network" class="form-control" required>
                                                <?php if ($currency === 'BTC'): ?>
                                                    <option value="bitcoin">Bitcoin</option>
                                                    <option value="lightning">Lightning Network</option>
                                                <?php elseif ($currency === 'ETH'): ?>
                                                    <option value="ethereum">Ethereum (ERC-20)</option>
                                                    <option value="polygon">Polygon</option>
                                                <?php else: ?>
                                                    <option value="main">Main Network</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="form-group">
                                        <label for="withdraw_description">Description (Optional)</label>
                                        <input type="text" id="withdraw_description" name="description" class="form-control" placeholder="Add a note to this withdrawal">
                                    </div>
                                    
                                    <div class="form-buttons">
                                        <button type="submit" class="btn btn-primary">Withdraw Funds</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Wallet Overview -->
                        <div class="dashboard-section">
                            <div class="section-header">
                                <h2>Your Wallets</h2>
                                <button class="btn btn-sm btn-primary" id="add-wallet-btn">Add New Wallet</button>
                            </div>
                            
                            <div class="wallets-container">
                                <?php if (empty($wallets)): ?>
                                    <div class="empty-state">
                                        <i data-feather="credit-card"></i>
                                        <p>You don't have any wallets yet.</p>
                                        <button class="btn btn-primary" id="create-wallet-btn">Create Your First Wallet</button>
                                    </div>
                                <?php else: ?>
                                    <div class="wallet-list">
                                        <?php foreach ($wallets as $wallet): ?>
                                            <div class="wallet-item">
                                                <div class="wallet-header">
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
                                                    <div class="wallet-info">
                                                        <h3><?php echo htmlspecialchars($wallet['currency']); ?> Wallet</h3>
                                                        <?php if ($wallet['currency'] === 'USD'): ?>
                                                            <p class="wallet-name">US Dollar</p>
                                                        <?php elseif ($wallet['currency'] === 'BTC'): ?>
                                                            <p class="wallet-name">Bitcoin</p>
                                                        <?php elseif ($wallet['currency'] === 'ETH'): ?>
                                                            <p class="wallet-name">Ethereum</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="wallet-body">
                                                    <div class="wallet-balance">
                                                        <h4>Balance</h4>
                                                        <?php if ($wallet['currency'] === 'USD'): ?>
                                                            <div class="balance-amount">$<?php echo number_format($wallet['balance'], 2); ?></div>
                                                        <?php else: ?>
                                                            <div class="balance-amount"><?php echo format_crypto_price($wallet['balance'], $wallet['currency']); ?> <?php echo htmlspecialchars($wallet['currency']); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <div class="wallet-actions">
                                                        <a href="wallets.php?action=deposit&currency=<?php echo urlencode($wallet['currency']); ?>" class="btn btn-primary btn-block">Deposit</a>
                                                        <a href="wallets.php?action=withdraw&currency=<?php echo urlencode($wallet['currency']); ?>" class="btn btn-secondary btn-block">Withdraw</a>
                                                        <a href="trading.php" class="btn btn-outline-primary btn-block">Trade</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
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
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy wallet address to clipboard
    const copyButtons = document.querySelectorAll('.copy-address-btn');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const text = this.getAttribute('data-clipboard-text');
            navigator.clipboard.writeText(text).then(() => {
                // Change button text temporarily
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i data-feather="check"></i>';
                feather.replace();
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    feather.replace();
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        });
    });
    
    // Payment method toggle for USD deposit
    const paymentMethodSelect = document.getElementById('payment_method');
    const paymentDetailsDiv = document.getElementById('payment-details');
    
    if (paymentMethodSelect && paymentDetailsDiv) {
        paymentMethodSelect.addEventListener('change', function() {
            const method = this.value;
            
            if (method) {
                paymentDetailsDiv.style.display = 'block';
                
                // Show different form fields based on selected payment method
                let detailsHTML = '';
                
                if (method === 'credit_card') {
                    detailsHTML = `
                        <h4>Credit/Debit Card Details</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card_number">Card Number</label>
                                <input type="text" id="card_number" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" class="form-control" placeholder="MM/YY" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="card_name">Name on Card</label>
                            <input type="text" id="card_name" name="card_name" class="form-control" required>
                        </div>
                    `;
                } else if (method === 'bank_transfer') {
                    detailsHTML = `
                        <h4>Bank Transfer Details</h4>
                        <p>Please use the following details to make your bank transfer:</p>
                        <div class="bank-details">
                            <div class="detail-row">
                                <div class="detail-label">Account Name:</div>
                                <div class="detail-value">crynance Inc.</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Account Number:</div>
                                <div class="detail-value">1234567890</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Routing Number:</div>
                                <div class="detail-value">087654321</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Bank Name:</div>
                                <div class="detail-value">Example Bank</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Reference:</div>
                                <div class="detail-value">Your crynance ID</div>
                            </div>
                        </div>
                        <p class="mt-3">Your account will be credited once we receive your payment. This usually takes 1-3 business days.</p>
                    `;
                } else if (method === 'paypal') {
                    detailsHTML = `
                        <h4>PayPal</h4>
                        <p>You will be redirected to PayPal to complete your deposit after submitting this form.</p>
                        <div class="form-group">
                            <label for="paypal_email">PayPal Email (Optional)</label>
                            <input type="email" id="paypal_email" name="paypal_email" class="form-control" placeholder="your-email@example.com">
                        </div>
                    `;
                }
                
                paymentDetailsDiv.innerHTML = detailsHTML;
            } else {
                paymentDetailsDiv.style.display = 'none';
            }
        });
    }
    
    // Withdrawal method toggle
    const withdrawMethodSelect = document.getElementById('withdraw_method');
    const bankDetails = document.getElementById('bank-details');
    const paypalDetails = document.getElementById('paypal-details');
    
    if (withdrawMethodSelect && bankDetails && paypalDetails) {
        withdrawMethodSelect.addEventListener('change', function() {
            const method = this.value;
            
            if (method === 'bank_transfer') {
                bankDetails.style.display = 'block';
                paypalDetails.style.display = 'none';
            } else if (method === 'paypal') {
                bankDetails.style.display = 'none';
                paypalDetails.style.display = 'block';
            } else {
                bankDetails.style.display = 'none';
                paypalDetails.style.display = 'none';
            }
        });
    }
    
    // Add new wallet functionality
    const addWalletBtn = document.getElementById('add-wallet-btn');
    const createWalletBtn = document.getElementById('create-wallet-btn');
    
    const createWalletModal = function() {
        alert('This feature will be implemented soon!');
    };
    
    if (addWalletBtn) {
        addWalletBtn.addEventListener('click', createWalletModal);
    }
    
    if (createWalletBtn) {
        createWalletBtn.addEventListener('click', createWalletModal);
    }
});
</script>

<?php include 'includes/footer.php'; ?>

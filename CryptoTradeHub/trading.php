<?php
include 'includes/crypto_data.php';
$pageTitle = "Crynance - Trading Platform";

// Get the selected cryptocurrency from URL parameter
$selectedSymbol = isset($_GET['symbol']) ? $_GET['symbol'] : 'BTC';

// Find the selected cryptocurrency data
$selectedCrypto = null;
foreach ($cryptoData as $crypto) {
    if ($crypto['symbol'] === $selectedSymbol) {
        $selectedCrypto = $crypto;
        break;
    }
}

// If not found, default to first one
if (!$selectedCrypto) {
    $selectedCrypto = $cryptoData[0];
    $selectedSymbol = $selectedCrypto['symbol'];
}

include 'includes/header.php';
?>

<main class="trading-page">
    <div class="container">
        <div class="trading-layout">
            <aside class="market-sidebar">
                <div class="sidebar-header">
                    <h3>Markets</h3>
                    <div class="search-box">
                        <input type="text" id="market-search" placeholder="Search...">
                        <i data-feather="search"></i>
                    </div>
                </div>
                <div class="market-list">
                    <?php foreach ($cryptoData as $crypto): ?>
                    <a href="trading.php?symbol=<?php echo $crypto['symbol']; ?>" class="market-item <?php echo ($crypto['symbol'] === $selectedSymbol) ? 'active' : ''; ?>">
                        <div class="market-name">
                            <span class="symbol"><?php echo $crypto['symbol']; ?></span>
                            <span class="name"><?php echo $crypto['name']; ?></span>
                        </div>
                        <div class="market-price">
                            <span class="price">$<?php echo number_format($crypto['price'], 2); ?></span>
                            <span class="change <?php echo $crypto['change_24h'] >= 0 ? 'up' : 'down'; ?>">
                                <?php echo $crypto['change_24h'] >= 0 ? '+' : ''; ?><?php echo $crypto['change_24h']; ?>%
                            </span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </aside>

            <div class="trading-main">
                <div class="trading-header">
                    <div class="selected-market">
                        <h2><?php echo $selectedCrypto['name']; ?> (<?php echo $selectedCrypto['symbol']; ?>)</h2>
                        <div class="market-details">
                            <span class="current-price">$<?php echo number_format($selectedCrypto['price'], 2); ?></span>
                            <span class="price-change <?php echo $selectedCrypto['change_24h'] >= 0 ? 'up' : 'down'; ?>">
                                <?php echo $selectedCrypto['change_24h'] >= 0 ? '+' : ''; ?><?php echo $selectedCrypto['change_24h']; ?>%
                            </span>
                        </div>
                    </div>
                    <div class="chart-controls">
                        <div class="timeframe-selector">
                            <button class="timeframe-btn active" data-timeframe="1h">1H</button>
                            <button class="timeframe-btn" data-timeframe="1d">1D</button>
                            <button class="timeframe-btn" data-timeframe="1w">1W</button>
                            <button class="timeframe-btn" data-timeframe="1m">1M</button>
                            <button class="timeframe-btn" data-timeframe="1y">1Y</button>
                        </div>
                        <div class="chart-type-selector">
                            <button class="chart-type-btn active" data-type="candle">
                                <i data-feather="bar-chart-2"></i>
                            </button>
                            <button class="chart-type-btn" data-type="line">
                                <i data-feather="trending-up"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="priceChart"></canvas>
                </div>

                <div class="market-stats-grid">
                    <div class="stat-box">
                        <span class="stat-label">24h High</span>
                        <span class="stat-value">$<?php echo number_format($selectedCrypto['price'] * (1 + rand(2, 5) / 100), 2); ?></span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-label">24h Low</span>
                        <span class="stat-value">$<?php echo number_format($selectedCrypto['price'] * (1 - rand(2, 5) / 100), 2); ?></span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-label">24h Volume</span>
                        <span class="stat-value">$<?php echo number_format($selectedCrypto['volume_24h'] / 1000000000, 2); ?>B</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-label">Market Cap</span>
                        <span class="stat-value">$<?php echo number_format($selectedCrypto['market_cap'] / 1000000000, 2); ?>B</span>
                    </div>
                </div>
            </div>

            <div class="trading-panel">
                <div class="panel-tabs">
                    <button class="tab-btn active" data-tab="buy">Buy</button>
                    <button class="tab-btn" data-tab="sell">Sell</button>
                </div>

                <div class="tab-content active" id="buy-tab">
                    <form class="trading-form" id="buy-form">
                        <div class="form-group">
                            <label for="buy-price">Price (USD)</label>
                            <input type="number" id="buy-price" value="<?php echo $selectedCrypto['price']; ?>" step="0.01" readonly>
                        </div>
                        <div class="form-group">
                            <label for="buy-amount">Amount (<?php echo $selectedCrypto['symbol']; ?>)</label>
                            <input type="number" id="buy-amount" step="0.0001" min="0.0001" required>
                        </div>
                        <div class="form-group">
                            <label for="buy-total">Total (USD)</label>
                            <input type="number" id="buy-total" step="0.01" readonly>
                        </div>
                        <div class="amount-shortcuts">
                            <button type="button" class="shortcut-btn" data-percent="25">25%</button>
                            <button type="button" class="shortcut-btn" data-percent="50">50%</button>
                            <button type="button" class="shortcut-btn" data-percent="75">75%</button>
                            <button type="button" class="shortcut-btn" data-percent="100">100%</button>
                        </div>
                        <button type="submit" class="btn btn-success btn-buy">Buy <?php echo $selectedCrypto['symbol']; ?></button>
                    </form>
                </div>

                <div class="tab-content" id="sell-tab">
                    <form class="trading-form" id="sell-form">
                        <div class="form-group">
                            <label for="sell-price">Price (USD)</label>
                            <input type="number" id="sell-price" value="<?php echo $selectedCrypto['price']; ?>" step="0.01" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sell-amount">Amount (<?php echo $selectedCrypto['symbol']; ?>)</label>
                            <input type="number" id="sell-amount" step="0.0001" min="0.0001" required>
                        </div>
                        <div class="form-group">
                            <label for="sell-total">Total (USD)</label>
                            <input type="number" id="sell-total" step="0.01" readonly>
                        </div>
                        <div class="amount-shortcuts">
                            <button type="button" class="shortcut-btn" data-percent="25">25%</button>
                            <button type="button" class="shortcut-btn" data-percent="50">50%</button>
                            <button type="button" class="shortcut-btn" data-percent="75">75%</button>
                            <button type="button" class="shortcut-btn" data-percent="100">100%</button>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sell">Sell <?php echo $selectedCrypto['symbol']; ?></button>
                    </form>
                </div>

                <div class="account-summary">
                    <h3>Account Balance</h3>
                    <div class="balance-item">
                        <span class="balance-label">USD</span>
                        <span class="balance-value">$10,000.00</span>
                    </div>
                    <div class="balance-item">
                        <span class="balance-label"><?php echo $selectedCrypto['symbol']; ?></span>
                        <span class="balance-value">0.0000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-history">
            <h3>Order History</h3>
            <div class="order-tabs">
                <button class="order-tab active" data-tab="open-orders">Open Orders</button>
                <button class="order-tab" data-tab="order-history">Order History</button>
            </div>
            <div class="order-table-container active" id="open-orders-tab">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Pair</th>
                            <th>Type</th>
                            <th>Side</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Filled</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="empty-state">
                            <td colspan="9">No open orders</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="order-table-container" id="order-history-tab">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Pair</th>
                            <th>Type</th>
                            <th>Side</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="empty-state">
                            <td colspan="8">No order history</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="js/charts.js"></script>
<script src="js/trading.js"></script>

<?php include 'includes/footer.php'; ?>

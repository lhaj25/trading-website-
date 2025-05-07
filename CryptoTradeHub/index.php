<?php
include 'includes/crypto_data.php';
$pageTitle = "CryptoTrade - Home";
include 'includes/header.php';
?>

<main>
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Trade Cryptocurrency with Confidence</h1>
                <p>Access real-time market data and trade popular cryptocurrencies with our secure and intuitive platform.</p>
                <a href="trading.php" class="btn btn-primary">Start Trading</a>
                <a href="education.php" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <section class="market-overview">
        <div class="container">
            <h2>Market Overview</h2>
            <div class="market-stats">
                <div class="stat-card">
                    <h3>Market Cap</h3>
                    <p>$1.84T</p>
                    <span class="change up">+2.3%</span>
                </div>
                <div class="stat-card">
                    <h3>24h Volume</h3>
                    <p>$78.5B</p>
                    <span class="change up">+5.1%</span>
                </div>
                <div class="stat-card">
                    <h3>BTC Dominance</h3>
                    <p>42.3%</p>
                    <span class="change down">-0.8%</span>
                </div>
            </div>

            <div class="crypto-table-container">
                <h3>Top Cryptocurrencies</h3>
                <table class="crypto-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>24h %</th>
                            <th>Market Cap</th>
                            <th>Volume (24h)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="crypto-table-body">
                        <?php foreach ($cryptoData as $index => $crypto): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <div class="crypto-name">
                                    <span class="crypto-symbol"><?php echo $crypto['symbol']; ?></span>
                                    <span><?php echo $crypto['name']; ?></span>
                                </div>
                            </td>
                            <td>$<?php echo number_format($crypto['price'], 2); ?></td>
                            <td class="<?php echo $crypto['change_24h'] >= 0 ? 'up' : 'down'; ?>">
                                <?php echo $crypto['change_24h'] >= 0 ? '+' : ''; ?><?php echo $crypto['change_24h']; ?>%
                            </td>
                            <td>$<?php echo number_format($crypto['market_cap'] / 1000000000, 2); ?>B</td>
                            <td>$<?php echo number_format($crypto['volume_24h'] / 1000000000, 2); ?>B</td>
                            <td><a href="trading.php?symbol=<?php echo $crypto['symbol']; ?>" class="btn btn-small">Trade</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Why Choose CryptoTrade</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-feather="shield"></i>
                    </div>
                    <h3>Secure Trading</h3>
                    <p>Advanced security protocols to protect your assets and personal information.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-feather="trending-up"></i>
                    </div>
                    <h3>Real-Time Data</h3>
                    <p>Access up-to-the-minute market data to make informed trading decisions.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-feather="dollar-sign"></i>
                    </div>
                    <h3>Low Fees</h3>
                    <p>Competitive trading fees to maximize your investment potential.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-feather="book-open"></i>
                    </div>
                    <h3>Educational Resources</h3>
                    <p>Comprehensive guides and tutorials for traders of all experience levels.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Start Trading?</h2>
                <p>Join thousands of traders on our platform and start your cryptocurrency journey today.</p>
                <a href="trading.php" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

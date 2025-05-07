<?php
$pageTitle = "CryptoTrade - FAQ";
include 'includes/header.php';
?>

<main class="faq-page">
    <section class="faq-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about cryptocurrency trading and our platform.</p>
            </div>
        </div>
    </section>

    <section class="faq-search">
        <div class="container">
            <div class="search-container">
                <input type="text" id="faq-search-input" placeholder="Search FAQs...">
                <button class="search-btn">
                    <i data-feather="search"></i>
                </button>
            </div>
        </div>
    </section>

    <section class="faq-categories">
        <div class="container">
            <div class="category-tabs">
                <button class="category-tab active" data-category="all">All</button>
                <button class="category-tab" data-category="account">Account</button>
                <button class="category-tab" data-category="trading">Trading</button>
                <button class="category-tab" data-category="security">Security</button>
                <button class="category-tab" data-category="payments">Payments</button>
                <button class="category-tab" data-category="crypto">Cryptocurrency</button>
            </div>

            <div class="faq-list">
                <!-- Account Section -->
                <div class="faq-section" id="account">
                    <h2>Account Questions</h2>
                    
                    <div class="faq-item" data-category="account">
                        <div class="faq-question">
                            <h3>How do I create an account?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Creating an account is simple:</p>
                            <ol>
                                <li>Click on the "Sign Up" button in the top right corner of our website</li>
                                <li>Enter your email address and create a strong password</li>
                                <li>Verify your email address by clicking on the link we send you</li>
                                <li>Complete your profile by providing the required information</li>
                                <li>Set up two-factor authentication for additional security</li>
                            </ol>
                            <p>Once these steps are completed, you can start trading on our platform.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="account">
                        <div class="faq-question">
                            <h3>How can I verify my account?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>To verify your account:</p>
                            <ol>
                                <li>Log in to your account and go to the "Verification" section</li>
                                <li>Select the verification level you wish to complete</li>
                                <li>Follow the instructions to upload the required documents (usually a government-issued ID and proof of address)</li>
                                <li>Wait for our team to review your documents (typically within 24-48 hours)</li>
                            </ol>
                            <p>Different verification levels provide different trading limits and features. Higher verification levels require more documentation but offer increased functionality.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="account">
                        <div class="faq-question">
                            <h3>How do I reset my password?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>If you've forgotten your password:</p>
                            <ol>
                                <li>Click on "Login" at the top of the page</li>
                                <li>Select "Forgot Password"</li>
                                <li>Enter the email address associated with your account</li>
                                <li>Check your email for a password reset link</li>
                                <li>Click the link and follow the instructions to create a new password</li>
                            </ol>
                            <p>For security reasons, password reset links expire after 30 minutes. If your link has expired, you'll need to request a new one.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Trading Section -->
                <div class="faq-section" id="trading">
                    <h2>Trading Questions</h2>
                    
                    <div class="faq-item" data-category="trading">
                        <div class="faq-question">
                            <h3>What are the trading fees?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Our fee structure is designed to be transparent and competitive:</p>
                            <ul>
                                <li><strong>Standard Trading Fee:</strong> 0.25% per trade</li>
                                <li><strong>High-Volume Discount:</strong> Fees decrease based on your 30-day trading volume, down to 0.10% for our most active traders</li>
                                <li><strong>Maker-Taker Model:</strong> "Makers" who add liquidity to the market receive lower fees than "takers" who remove liquidity</li>
                            </ul>
                            <p>Additional fees may apply for certain payment methods or withdrawals. For a complete breakdown of all fees, please visit our <a href="#">Fee Schedule</a> page.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="trading">
                        <div class="faq-question">
                            <h3>What cryptocurrencies can I trade on your platform?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>We currently support over 100 cryptocurrencies for trading, including:</p>
                            <ul>
                                <li>Bitcoin (BTC)</li>
                                <li>Ethereum (ETH)</li>
                                <li>Binance Coin (BNB)</li>
                                <li>Cardano (ADA)</li>
                                <li>Solana (SOL)</li>
                                <li>And many more</li>
                            </ul>
                            <p>We regularly add new cryptocurrencies based on market demand and after thorough security and compliance reviews. You can view the complete list of supported cryptocurrencies in the "Markets" section of our platform.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="trading">
                        <div class="faq-question">
                            <h3>How do I place a trade?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>To place a trade on our platform:</p>
                            <ol>
                                <li>Navigate to the "Trading" section of the platform</li>
                                <li>Select the cryptocurrency pair you wish to trade (e.g., BTC/USD)</li>
                                <li>Choose the order type (Market, Limit, Stop-Limit)</li>
                                <li>Enter the amount you wish to buy or sell</li>
                                <li>Review the details of your trade, including any fees</li>
                                <li>Click "Buy" or "Sell" to execute your trade</li>
                            </ol>
                            <p>For market orders, your trade will be executed immediately at the best available price. For limit or stop-limit orders, your trade will be executed when the market reaches your specified price.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Security Section -->
                <div class="faq-section" id="security">
                    <h2>Security Questions</h2>
                    
                    <div class="faq-item" data-category="security">
                        <div class="faq-question">
                            <h3>How do I enable two-factor authentication (2FA)?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>To enable two-factor authentication:</p>
                            <ol>
                                <li>Log in to your account and go to the "Security" section</li>
                                <li>Select "Two-Factor Authentication"</li>
                                <li>Choose your preferred 2FA method (Google Authenticator, Authy, or SMS)</li>
                                <li>Follow the on-screen instructions to set up your chosen method</li>
                                <li>Store your backup codes in a safe place (these allow you to regain access if you lose your 2FA device)</li>
                            </ol>
                            <p>We strongly recommend enabling 2FA for all accounts as it significantly enhances your account security.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="security">
                        <div class="faq-question">
                            <h3>Is my cryptocurrency safe on your platform?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>We take multiple measures to ensure the safety of your assets:</p>
                            <ul>
                                <li><strong>Cold Storage:</strong> 95% of all user funds are stored in offline cold wallets, inaccessible to hackers</li>
                                <li><strong>Regular Audits:</strong> Our security systems undergo regular third-party audits</li>
                                <li><strong>Insurance:</strong> We maintain insurance to cover potential losses from security breaches</li>
                                <li><strong>Advanced Encryption:</strong> All data is encrypted using bank-level encryption standards</li>
                                <li><strong>24/7 Monitoring:</strong> Our security team monitors our systems around the clock</li>
                            </ul>
                            <p>While we take every precaution to protect your assets, we also encourage users to implement all available security features, including strong passwords and two-factor authentication.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Payments Section -->
                <div class="faq-section" id="payments">
                    <h2>Payment Questions</h2>
                    
                    <div class="faq-item" data-category="payments">
                        <div class="faq-question">
                            <h3>What payment methods do you accept?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>We accept a variety of payment methods, including:</p>
                            <ul>
                                <li>Credit and debit cards (Visa, Mastercard)</li>
                                <li>Bank transfers</li>
                                <li>PayPal</li>
                                <li>Cryptocurrencies</li>
                                <li>Various local payment methods depending on your region</li>
                            </ul>
                            <p>The available payment methods may vary depending on your location and verification level. You can view all available options in the "Deposit" section of your account.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="payments">
                        <div class="faq-question">
                            <h3>How long do deposits and withdrawals take?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Processing times vary by method:</p>
                            <ul>
                                <li><strong>Credit/Debit Cards:</strong> Deposits are typically instant; withdrawals take 1-3 business days</li>
                                <li><strong>Bank Transfers:</strong> Deposits take 1-3 business days; withdrawals take 1-5 business days</li>
                                <li><strong>Cryptocurrency:</strong> Deposits require blockchain confirmations (varies by cryptocurrency); withdrawals are processed within 24 hours</li>
                            </ul>
                            <p>Please note that all withdrawals undergo security verification, which may sometimes cause additional delays, especially for large amounts or unusual activity patterns.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Cryptocurrency Section -->
                <div class="faq-section" id="crypto">
                    <h2>Cryptocurrency Questions</h2>
                    
                    <div class="faq-item" data-category="crypto">
                        <div class="faq-question">
                            <h3>What is cryptocurrency mining?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Cryptocurrency mining is the process by which new coins are created and transactions are verified and added to the blockchain. Key aspects of mining include:</p>
                            <ul>
                                <li><strong>Process:</strong> Miners use powerful computers to solve complex mathematical problems, which validates transactions and secures the network</li>
                                <li><strong>Proof of Work:</strong> Many cryptocurrencies, including Bitcoin, use a consensus mechanism called Proof of Work, which requires computational power to validate transactions</li>
                                <li><strong>Rewards:</strong> Miners are rewarded with newly created coins and transaction fees for their contribution to maintaining the network</li>
                                <li><strong>Equipment:</strong> Mining requires specialized hardware (ASICs or GPUs), substantial electrical power, and cooling systems</li>
                            </ul>
                            <p>Not all cryptocurrencies use mining. Some use alternative consensus mechanisms like Proof of Stake, which validates transactions based on the number of coins held rather than computational power.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="crypto">
                        <div class="faq-question">
                            <h3>What is a cryptocurrency wallet?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>A cryptocurrency wallet is a digital tool that allows you to store, send, and receive cryptocurrencies. Key points about wallets:</p>
                            <ul>
                                <li><strong>Private Keys:</strong> Wallets store your private keys, which prove ownership of your digital assets and allow you to access and manage them</li>
                                <li><strong>Types of Wallets:</strong>
                                    <ul>
                                        <li><em>Hardware Wallets:</em> Physical devices that store your private keys offline (most secure)</li>
                                        <li><em>Software Wallets:</em> Applications you install on your computer or smartphone</li>
                                        <li><em>Web Wallets:</em> Online services accessible through a browser</li>
                                        <li><em>Paper Wallets:</em> Physical documents containing your keys and QR codes</li>
                                    </ul>
                                </li>
                                <li><strong>Security:</strong> Different wallet types offer different levels of security and convenience; hardware wallets are generally considered the most secure for long-term storage</li>
                            </ul>
                            <p>It's important to note that our platform provides a custodial wallet service, which means we manage the private keys on your behalf. For maximum security, many users transfer larger holdings to their personal hardware wallets.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="crypto">
                        <div class="faq-question">
                            <h3>What is the difference between a coin and a token?</h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Although sometimes used interchangeably, coins and tokens have distinct characteristics:</p>
                            
                            <h4>Cryptocurrency Coins:</h4>
                            <ul>
                                <li>Operate on their own blockchain (e.g., Bitcoin, Ethereum, Litecoin)</li>
                                <li>Primarily designed to function as digital money</li>
                                <li>Can be mined (in Proof of Work systems) or earned through staking (in Proof of Stake systems)</li>
                                <li>Examples: BTC, ETH, ADA, SOL</li>
                            </ul>
                            
                            <h4>Cryptocurrency Tokens:</h4>
                            <ul>
                                <li>Built on existing blockchains (e.g., many tokens run on Ethereum, Binance Smart Chain, or Solana)</li>
                                <li>Often serve specific functions within applications or ecosystems</li>
                                <li>Cannot be mined directly; they're created through smart contracts</li>
                                <li>Examples: USDT (Tether), LINK (Chainlink), UNI (Uniswap), AAVE</li>
                            </ul>
                            
                            <p>Tokens can represent various things, including assets, utility within a specific ecosystem, or even digital collectibles (NFTs). Their value and function are determined by their intended use case and the project behind them.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-contact">
        <div class="container">
            <div class="contact-box">
                <h2>Didn't Find Your Answer?</h2>
                <p>Our support team is available 24/7 to assist you with any questions or concerns.</p>
                <div class="contact-buttons">
                    <a href="contact.php" class="btn btn-primary">Contact Support</a>
                    <a href="#" class="btn btn-secondary">Live Chat</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category tab switching
    const categoryTabs = document.querySelectorAll('.category-tab');
    const faqItems = document.querySelectorAll('.faq-item');
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            categoryTabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            tab.classList.add('active');
            
            const category = tab.getAttribute('data-category');
            
            // Show/hide FAQ items based on category
            faqItems.forEach(item => {
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // FAQ accordion functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        const answer = question.nextElementSibling;
        const icon = question.querySelector('i');
        
        // Initially hide all answers
        answer.style.display = 'none';
        
        question.addEventListener('click', () => {
            const isOpen = answer.style.display === 'block';
            
            // Toggle current FAQ
            answer.style.display = isOpen ? 'none' : 'block';
            icon.setAttribute('data-feather', isOpen ? 'chevron-down' : 'chevron-up');
            
            // Re-initialize Feather icons
            feather.replace();
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('faq-search-input');
    
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>

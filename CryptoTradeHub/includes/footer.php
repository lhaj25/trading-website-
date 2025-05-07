    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column footer-about">
                    <h3>CryptoTrade</h3>
                    <p>Your trusted partner in cryptocurrency trading. We provide a secure and user-friendly platform for buying, selling, and learning about cryptocurrencies.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon" aria-label="Twitter">
                            <i data-feather="twitter"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Facebook">
                            <i data-feather="facebook"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Instagram">
                            <i data-feather="instagram"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="LinkedIn">
                            <i data-feather="linkedin"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="YouTube">
                            <i data-feather="youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="trading.php">Trading Platform</a></li>
                        <li><a href="education.php">Education</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Legal</h3>
                    <ul class="footer-links">
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Trading Rules</a></li>
                        <li><a href="#">KYC/AML Policy</a></li>
                        <li><a href="#">Risk Disclosure</a></li>
                    </ul>
                </div>
                
                <div class="footer-column footer-newsletter">
                    <h3>Stay Updated</h3>
                    <p>Subscribe to our newsletter for the latest updates, market insights, and educational content.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> CryptoTrade. All rights reserved.
                </div>
                
                <div class="footer-nav">
                    <a href="#">Sitemap</a>
                    <a href="#">Accessibility</a>
                    <a href="#">Disclaimer</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- "Back to Top" Button -->
    <button id="scroll-top-btn" aria-label="Scroll to Top" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 99; border: none; outline: none; background-color: var(--primary-color); color: white; cursor: pointer; padding: 15px; border-radius: 50%; width: 50px; height: 50px;">
        <i data-feather="arrow-up"></i>
    </button>

    <!-- JavaScript Files -->
    <script src="js/main.js"></script>
    
    <!-- Initialize Feather Icons -->
    <!-- Include Authentication Forms -->
    <?php include 'includes/auth_forms.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
    
    <!-- Authentication Modals JavaScript -->
    <script src="js/auth.js"></script>
</body>
</html>

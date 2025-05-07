<?php
$pageTitle = "Crynance - Contact Us";

// Initialize variables
$name = $email = $subject = $message = "";
$nameErr = $emailErr = $subjectErr = $messageErr = "";
$formSubmitted = false;
$formSuccess = false;

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formSubmitted = true;
    
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }
    
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    // Validate subject
    if (empty($_POST["subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $subject = test_input($_POST["subject"]);
    }
    
    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }
    
    // If no errors, process the form
    if (empty($nameErr) && empty($emailErr) && empty($subjectErr) && empty($messageErr)) {
        // In a real application, you would send an email or save to database here
        // For this demo, we'll just set success flag
        $formSuccess = true;
        
        // Reset form fields
        $name = $email = $subject = $message = "";
    }
}

// Helper function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

include 'includes/header.php';
?>

<main class="contact-page">
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Contact Us</h1>
                <p>Have questions or need support? Our team is here to help you.</p>
            </div>
        </div>
    </section>

    <section class="contact-content">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2>Get in Touch</h2>
                    <p>We're here to answer your questions and provide assistance with our cryptocurrency trading platform.</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">
                                <i data-feather="mail"></i>
                            </div>
                            <div class="method-details">
                                <h3>Email Us</h3>
                                <p>support@crynance.com</p>
                                <p>For general inquiries: info@crynance.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i data-feather="phone"></i>
                            </div>
                            <div class="method-details">
                                <h3>Call Us</h3>
                                <p>+1 (555) 123-4567</p>
                                <p>Monday to Friday, 9am - 5pm EST</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i data-feather="message-circle"></i>
                            </div>
                            <div class="method-details">
                                <h3>Live Chat</h3>
                                <p>Available 24/7 through our platform</p>
                                <button class="btn btn-secondary">Start Chat</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-media">
                        <h3>Follow Us</h3>
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
                </div>
                
                <div class="contact-form-container">
                    <h2>Send Us a Message</h2>
                    
                    <?php if ($formSubmitted && $formSuccess): ?>
                    <div class="form-success">
                        <div class="success-icon">
                            <i data-feather="check-circle"></i>
                        </div>
                        <h3>Thank You!</h3>
                        <p>Your message has been sent successfully. We'll get back to you as soon as possible.</p>
                    </div>
                    <?php else: ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="contact-form">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="<?php echo ($nameErr) ? 'error' : ''; ?>">
                            <?php if ($nameErr): ?>
                            <span class="error-message"><?php echo $nameErr; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="<?php echo ($emailErr) ? 'error' : ''; ?>">
                            <?php if ($emailErr): ?>
                            <span class="error-message"><?php echo $emailErr; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" value="<?php echo $subject; ?>" class="<?php echo ($subjectErr) ? 'error' : ''; ?>">
                            <?php if ($subjectErr): ?>
                            <span class="error-message"><?php echo $subjectErr; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="6" class="<?php echo ($messageErr) ? 'error' : ''; ?>"><?php echo $message; ?></textarea>
                            <?php if ($messageErr): ?>
                            <span class="error-message"><?php echo $messageErr; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <section class="faq-preview">
        <div class="container">
            <h2>Frequently Asked Questions</h2>
            <p>Find quick answers to common questions about our platform and cryptocurrency trading.</p>
            
            <div class="faq-preview-list">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do I create an account?</h3>
                        <i data-feather="chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Creating an account is simple. Click on the "Sign Up" button in the top right corner of our website, fill in the required information, verify your email address, and you're ready to start trading.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What payment methods do you accept?</h3>
                        <i data-feather="chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>We accept various payment methods including credit/debit cards, bank transfers, and other cryptocurrencies. The available options may vary depending on your location.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How secure is your platform?</h3>
                        <i data-feather="chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Security is our top priority. We employ industry-standard security measures including two-factor authentication, cold storage for the majority of assets, regular security audits, and encryption for all sensitive data.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-link">
                <a href="faq.php" class="btn btn-secondary">View All FAQs</a>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ accordion functionality
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = question.querySelector('i');
        
        // Initially hide all answers
        answer.style.display = 'none';
        
        question.addEventListener('click', () => {
            const isOpen = answer.style.display === 'block';
            
            // Close all other FAQs
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.faq-answer').style.display = 'none';
                    otherItem.querySelector('.faq-question i').setAttribute('data-feather', 'chevron-down');
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current FAQ
            answer.style.display = isOpen ? 'none' : 'block';
            icon.setAttribute('data-feather', isOpen ? 'chevron-down' : 'chevron-up');
            item.classList.toggle('active');
            
            // Re-initialize Feather icons
            feather.replace();
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>

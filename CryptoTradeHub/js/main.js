/**
 * CryptoTrade - Main JavaScript File
 * Contains general website functionality, UI interactions, and initializations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Mobile navigation toggle
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const userActions = document.querySelector('.user-actions');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            if (userActions) {
                userActions.classList.toggle('active');
            }
            
            // Change icon based on menu state
            const icon = navToggle.querySelector('i');
            if (icon) {
                if (navMenu.classList.contains('active')) {
                    icon.setAttribute('data-feather', 'x');
                } else {
                    icon.setAttribute('data-feather', 'menu');
                }
                feather.replace();
            }
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href').substring(1);
            if (!targetId) return; // Skip if href is just "#"
            
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                e.preventDefault();
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Adjust for header height
                    behavior: 'smooth'
                });
                
                // Update URL without page reload
                history.pushState(null, null, `#${targetId}`);
            }
        });
    });

    // Activate navigation item based on scroll position
    function setActiveNavItem() {
        const scrollPosition = window.scrollY;
        
        // Get all sections with IDs
        const sections = document.querySelectorAll('section[id]');
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                // Remove active class from all nav items
                document.querySelectorAll('.nav-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Add active class to current nav item
                const activeNavItem = document.querySelector(`.nav-item[href="#${sectionId}"]`);
                if (activeNavItem) {
                    activeNavItem.classList.add('active');
                }
            }
        });
    }

    // Initialize active nav item on page load
    setActiveNavItem();
    
    // Update active nav item on scroll
    window.addEventListener('scroll', setActiveNavItem);

    // FAQ accordions (if present on the page)
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        if (!question) return;
        
        question.addEventListener('click', () => {
            const answer = item.querySelector('.faq-answer');
            const icon = question.querySelector('i');
            
            // Check if this FAQ is already open
            const isOpen = answer.style.display === 'block';
            
            // Close all FAQs
            faqItems.forEach(otherItem => {
                const otherAnswer = otherItem.querySelector('.faq-answer');
                const otherIcon = otherItem.querySelector('.faq-question i');
                
                if (otherAnswer) {
                    otherAnswer.style.display = 'none';
                }
                
                if (otherIcon) {
                    otherIcon.setAttribute('data-feather', 'chevron-down');
                }
            });
            
            // Open/close the clicked FAQ
            if (answer) {
                answer.style.display = isOpen ? 'none' : 'block';
            }
            
            if (icon) {
                icon.setAttribute('data-feather', isOpen ? 'chevron-down' : 'chevron-up');
            }
            
            // Reinitialize Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    });

    // Show/hide "Back to Top" button based on scroll position
    const scrollTopBtn = document.getElementById('scroll-top-btn');
    
    if (scrollTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.style.display = 'block';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        });
        
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Newsletter form validation
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();
            
            if (!email || !isValidEmail(email)) {
                // Show error
                emailInput.classList.add('error');
                
                // Create error message if it doesn't exist
                let errorMsg = this.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('span');
                    errorMsg.className = 'error-message';
                    emailInput.parentNode.appendChild(errorMsg);
                }
                errorMsg.textContent = 'Please enter a valid email address';
            } else {
                // Clear error state
                emailInput.classList.remove('error');
                const errorMsg = this.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
                
                // Show success message
                emailInput.value = '';
                
                const successMsg = document.createElement('div');
                successMsg.className = 'newsletter-success';
                successMsg.textContent = 'Thank you for subscribing!';
                
                // Replace form with success message
                this.style.display = 'none';
                this.parentNode.appendChild(successMsg);
                
                // In a real application, you would submit the form data via AJAX here
            }
        });
    }

    // Helper function to validate email format
    function isValidEmail(email) {
        const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return regex.test(email);
    }

    // Add animation to stats counters when they come into view
    const statValues = document.querySelectorAll('.stat-value');
    
    if (statValues.length > 0) {
        const options = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const valueText = target.textContent;
                    
                    // Extract the number and suffix
                    const match = valueText.match(/^(\$?)(\d+(?:\.\d+)?)([a-zA-Z+%]*)$/);
                    
                    if (match) {
                        const prefix = match[1] || '';
                        const finalValue = parseFloat(match[2]);
                        const suffix = match[3] || '';
                        
                        // Start from zero and animate to the final value
                        let startValue = 0;
                        const duration = 2000; // 2 seconds
                        const increment = finalValue / (duration / 16); // 60fps
                        
                        function updateCounter() {
                            startValue += increment;
                            
                            if (startValue < finalValue) {
                                target.textContent = prefix + Math.round(startValue).toLocaleString() + suffix;
                                requestAnimationFrame(updateCounter);
                            } else {
                                target.textContent = prefix + finalValue.toLocaleString() + suffix;
                            }
                        }
                        
                        updateCounter();
                        
                        // Unobserve after animation starts
                        observer.unobserve(target);
                    }
                }
            });
        }, options);
        
        statValues.forEach(value => {
            observer.observe(value);
        });
    }
});

// Create a cryptocurrency ticker for the header
class CryptoTicker {
    constructor(selector) {
        this.container = document.querySelector(selector);
        this.tickerData = [];
        this.animationFrame = null;
        this.scrollPosition = 0;
        this.scrollSpeed = 0.5;
        
        if (this.container) {
            this.init();
        }
    }
    
    async init() {
        // In a real application, you would fetch real-time data from an API
        // For this demo, we'll use mock data
        this.tickerData = [
            { symbol: 'BTC', price: 37582.21, change: 2.4 },
            { symbol: 'ETH', price: 2023.65, change: 1.2 },
            { symbol: 'BNB', price: 301.45, change: -0.8 },
            { symbol: 'SOL', price: 58.32, change: 5.6 },
            { symbol: 'ADA', price: 0.39, change: 0.3 },
            { symbol: 'XRP', price: 0.62, change: -1.2 },
            { symbol: 'DOGE', price: 0.075, change: 2.1 },
            { symbol: 'DOT', price: 5.82, change: -0.5 }
        ];
        
        this.render();
        this.startScrolling();
    }
    
    render() {
        // Create ticker element
        this.container.innerHTML = '';
        this.container.classList.add('crypto-ticker');
        
        const tickerTrack = document.createElement('div');
        tickerTrack.className = 'ticker-track';
        
        // Create ticker items
        this.tickerData.forEach(coin => {
            const tickerItem = document.createElement('div');
            tickerItem.className = 'ticker-item';
            
            const symbol = document.createElement('span');
            symbol.className = 'ticker-symbol';
            symbol.textContent = coin.symbol;
            
            const price = document.createElement('span');
            price.className = 'ticker-price';
            price.textContent = `$${coin.price.toFixed(2)}`;
            
            const change = document.createElement('span');
            change.className = `ticker-change ${coin.change >= 0 ? 'up' : 'down'}`;
            change.textContent = `${coin.change >= 0 ? '+' : ''}${coin.change}%`;
            
            tickerItem.appendChild(symbol);
            tickerItem.appendChild(price);
            tickerItem.appendChild(change);
            
            tickerTrack.appendChild(tickerItem);
        });
        
        // Duplicate items for seamless scrolling
        const tickerItemsClone = tickerTrack.innerHTML;
        tickerTrack.innerHTML += tickerItemsClone;
        
        this.container.appendChild(tickerTrack);
        this.trackElement = tickerTrack;
    }
    
    startScrolling() {
        const scroll = () => {
            this.scrollPosition += this.scrollSpeed;
            
            // Reset position when first set of items is scrolled out
            if (this.scrollPosition > this.trackElement.offsetWidth / 2) {
                this.scrollPosition = 0;
            }
            
            this.trackElement.style.transform = `translateX(-${this.scrollPosition}px)`;
            this.animationFrame = requestAnimationFrame(scroll);
        };
        
        scroll();
        
        // Pause on hover
        this.container.addEventListener('mouseenter', () => {
            cancelAnimationFrame(this.animationFrame);
        });
        
        this.container.addEventListener('mouseleave', () => {
            this.animationFrame = requestAnimationFrame(scroll);
        });
    }
}

// Initialize ticker if element exists
document.addEventListener('DOMContentLoaded', function() {
    const ticker = new CryptoTicker('.header-ticker');
});

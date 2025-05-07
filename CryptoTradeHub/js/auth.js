/**
 * CryptoTrade - Authentication JavaScript File
 * Contains all functionality for login and signup modals
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const loginModal = document.getElementById('login-modal');
    const signupModal = document.getElementById('signup-modal');
    
    // Get buttons that open modals
    const loginBtn = document.getElementById('login-btn');
    const signupBtn = document.getElementById('signup-btn');
    const logoutBtn = document.getElementById('logout-btn');
    
    // Get elements that close modals
    const closeButtons = document.querySelectorAll('.close-modal');
    
    // Get link elements that switch between modals
    const showLoginLink = document.getElementById('show-login');
    const showSignupLink = document.getElementById('show-signup');
    
    // Get form elements
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    
    // Get message containers
    const loginMessage = document.getElementById('login-message');
    const signupMessage = document.getElementById('signup-message');
    
    // Get password toggle elements
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    // Get user dropdown elements
    const userDropdownToggle = document.querySelector('.user-dropdown-toggle');
    const userDropdownMenu = document.querySelector('.user-dropdown-menu');
    
    // Open login modal when login button is clicked
    if (loginBtn) {
        loginBtn.addEventListener('click', function(event) {
            event.preventDefault();
            loginModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling while modal is open
            
            // Initialize Feather icons in the modal
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    }
    
    // Open signup modal when signup button is clicked
    if (signupBtn) {
        signupBtn.addEventListener('click', function(event) {
            event.preventDefault();
            signupModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling while modal is open
            
            // Initialize Feather icons in the modal
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    }
    
    // Close modals when close button is clicked
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            loginModal.style.display = 'none';
            signupModal.style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
            
            // Reset forms
            if (loginForm) loginForm.reset();
            if (signupForm) signupForm.reset();
            
            // Clear error messages
            if (loginMessage) loginMessage.innerHTML = '';
            if (signupMessage) signupMessage.innerHTML = '';
        });
    });
    
    // Close modals when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === loginModal) {
            loginModal.style.display = 'none';
            document.body.style.overflow = '';
            if (loginForm) loginForm.reset();
            if (loginMessage) loginMessage.innerHTML = '';
        }
        
        if (event.target === signupModal) {
            signupModal.style.display = 'none';
            document.body.style.overflow = '';
            if (signupForm) signupForm.reset();
            if (signupMessage) signupMessage.innerHTML = '';
        }
    });
    
    // Switch from login to signup
    if (showSignupLink) {
        showSignupLink.addEventListener('click', function(event) {
            event.preventDefault();
            loginModal.style.display = 'none';
            signupModal.style.display = 'flex';
            
            // Reset forms
            if (loginForm) loginForm.reset();
            if (loginMessage) loginMessage.innerHTML = '';
            
            // Initialize Feather icons in the modal
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    }
    
    // Switch from signup to login
    if (showLoginLink) {
        showLoginLink.addEventListener('click', function(event) {
            event.preventDefault();
            signupModal.style.display = 'none';
            loginModal.style.display = 'flex';
            
            // Reset forms
            if (signupForm) signupForm.reset();
            if (signupMessage) signupMessage.innerHTML = '';
            
            // Initialize Feather icons in the modal
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    }
    
    // Toggle password visibility
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.setAttribute('data-feather', 'eye-off');
            } else {
                passwordField.type = 'password';
                icon.setAttribute('data-feather', 'eye');
            }
            
            // Update Feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    });
    
    // Handle login form submission
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Clear previous message
            loginMessage.innerHTML = '';
            loginMessage.className = 'auth-message';
            
            // Disable submit button to prevent multiple submissions
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Logging in...';
            
            // Get form data
            const formData = new FormData(this);
            
            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    loginMessage.className = 'auth-message success';
                    loginMessage.textContent = data.message;
                    
                    // In a real application, you would:
                    // 1. Store the user data or token in localStorage/sessionStorage
                    // 2. Update the UI to show the logged-in user
                    // 3. Redirect to a dashboard or reload the page
                    
                    // For demo purposes, we'll just reload the page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    loginMessage.className = 'auth-message error';
                    
                    if (data.errors) {
                        // Display specific field errors
                        const errorList = document.createElement('ul');
                        Object.entries(data.errors).forEach(([field, message]) => {
                            const errorItem = document.createElement('li');
                            errorItem.textContent = message;
                            errorList.appendChild(errorItem);
                            
                            // Add error class to the field
                            const inputField = document.getElementById(`login-${field}`);
                            if (inputField) {
                                inputField.classList.add('error');
                            }
                        });
                        loginMessage.appendChild(errorList);
                    } else {
                        // Display general error message
                        loginMessage.textContent = data.message;
                    }
                    
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Log In';
                }
            })
            .catch(error => {
                // Handle network or server errors
                loginMessage.className = 'auth-message error';
                loginMessage.textContent = 'An error occurred. Please try again later.';
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.innerHTML = 'Log In';
                
                console.error('Error:', error);
            });
        });
    }
    
    // Handle signup form submission
    if (signupForm) {
        signupForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Clear previous message
            signupMessage.innerHTML = '';
            signupMessage.className = 'auth-message';
            
            // Disable submit button to prevent multiple submissions
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Creating account...';
            
            // Get form data
            const formData = new FormData(this);
            
            // Perform client-side validation
            let isValid = true;
            
            // Reset previous error states
            this.querySelectorAll('input').forEach(input => {
                input.classList.remove('error');
            });
            
            // Validate password strength
            const password = formData.get('password');
            if (password.length < 8 || !/[0-9]/.test(password) || !/[^A-Za-z0-9]/.test(password)) {
                isValid = false;
                signupMessage.className = 'auth-message error';
                signupMessage.textContent = 'Password must be at least 8 characters and include a number and a special character';
                document.getElementById('signup-password').classList.add('error');
            }
            
            // Validate password match
            const confirmPassword = formData.get('confirm_password');
            if (password !== confirmPassword) {
                isValid = false;
                signupMessage.className = 'auth-message error';
                signupMessage.textContent = 'Passwords do not match';
                document.getElementById('signup-confirm').classList.add('error');
            }
            
            // Validate terms checkbox
            if (!formData.get('terms')) {
                isValid = false;
                signupMessage.className = 'auth-message error';
                signupMessage.textContent = 'You must agree to the Terms of Service and Privacy Policy';
            }
            
            // If client-side validation fails, stop submission
            if (!isValid) {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Create Account';
                return;
            }
            
            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    signupMessage.className = 'auth-message success';
                    signupMessage.textContent = data.message;
                    
                    // In a real application, you would:
                    // 1. Redirect to a verification page or login page
                    // 2. Show a more detailed success message
                    
                    // For demo purposes, we'll switch to the login modal after a short delay
                    setTimeout(() => {
                        signupModal.style.display = 'none';
                        loginModal.style.display = 'flex';
                        signupForm.reset();
                        
                        // Show a message in the login form
                        loginMessage.className = 'auth-message success';
                        loginMessage.textContent = 'Account created successfully! You can now log in.';
                        
                        // Re-enable submit button
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Create Account';
                    }, 2000);
                } else {
                    // Show error message
                    signupMessage.className = 'auth-message error';
                    
                    if (data.errors) {
                        // Display specific field errors
                        const errorList = document.createElement('ul');
                        Object.entries(data.errors).forEach(([field, message]) => {
                            const errorItem = document.createElement('li');
                            errorItem.textContent = message;
                            errorList.appendChild(errorItem);
                            
                            // Add error class to the field
                            const inputField = document.getElementById(`signup-${field}`);
                            if (inputField) {
                                inputField.classList.add('error');
                            }
                        });
                        signupMessage.appendChild(errorList);
                    } else {
                        // Display general error message
                        signupMessage.textContent = data.message;
                    }
                    
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Create Account';
                }
            })
            .catch(error => {
                // Handle network or server errors
                signupMessage.className = 'auth-message error';
                signupMessage.textContent = 'An error occurred. Please try again later.';
                
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.innerHTML = 'Create Account';
                
                console.error('Error:', error);
            });
        });
    }
    
    // Handle logout functionality
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Create form data with logout action
            const formData = new FormData();
            formData.append('action', 'logout');
            
            // Send logout request
            fetch('includes/auth_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to reflect logged out state
                    window.location.reload();
                } else {
                    console.error('Logout failed:', data.message);
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
        });
    }
    
    // Toggle user dropdown menu
    if (userDropdownToggle) {
        userDropdownToggle.addEventListener('click', function(event) {
            event.preventDefault();
            
            if (userDropdownMenu) {
                // Toggle display
                userDropdownMenu.classList.toggle('active');
                
                // Handle click outside to close menu
                const closeMenuOnClickOutside = function(e) {
                    if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                        userDropdownMenu.classList.remove('active');
                        document.removeEventListener('click', closeMenuOnClickOutside);
                    }
                };
                
                // Add event listener for next click
                setTimeout(() => {
                    document.addEventListener('click', closeMenuOnClickOutside);
                }, 0);
            }
        });
    }
});
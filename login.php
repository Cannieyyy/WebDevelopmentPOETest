<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="auth-page">
    <nav class="navbar auth-navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span class="logo-icon">◆</span>
                <span class="logo-text">PasTimes</span>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="browse.php" class="nav-link">Browse</a></li>
                <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <li><a href="login.php" class="nav-link active">Sign In</a></li>
            </ul>
            <div class="nav-actions">
                <a href="register.php" class="btn btn-outline">Create Account</a>
            </div>
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div class="auth-container">
        <div class="auth-visual">
            <div class="slideshow-container auth-slideshow-height">
                <div class="slideshow-slide active">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200" alt="Sustainable fashion">
                    <div class="slide-caption">
                        <span>Welcome Back</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200" alt="Vintage finds">
                    <div class="slide-caption">
                        <span>Discover Unique Pieces</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1200" alt="Sell your clothes">
                    <div class="slide-caption">
                        <span>Turn Closet into Cash</span>
                    </div>
                </div>
                
                <div class="slideshow-dots">
                    <button class="dot active" aria-label="Slide 1"></button>
                    <button class="dot" aria-label="Slide 2"></button>
                    <button class="dot" aria-label="Slide 3"></button>
                </div>
            </div>
            <div class="auth-overlay"></div>
        </div>

        <div class="auth-form-section">
            <div class="auth-form-container">
                <a href="index.php" class="back-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to home
                </a>

                <h1>Sign In</h1>
                <p class="auth-subtitle">Enter your credentials to access your account</p>
                
                <div id="errorMessage" class="error-message" style="display: none;"></div>
                
                <form class="auth-form" id="loginForm">
                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="username" name="username" class="form-input" required placeholder="username or you@example.com">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
                            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" class="custom-checkbox" id="rememberMe">
                            <span class="checkmark">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                            Remember me
                        </label>
                        <a href="#" class="link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-large btn-primary auth-submit" id="submitBtn">
                        Sign In
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>

                    <div class="auth-divider">
                        <span>or continue with</span>
                    </div>

                    <div class="social-auth">
                        <button type="button" class="btn btn-social">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Google
                        </button>
                        <button type="button" class="btn btn-social">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                    </div>
                </form>

                <p class="auth-footer">
                    Don't have an account? 
                    <a href="register.php" class="link-bold">Create one</a>
                </p>
            </div>
        </div>
    </div>

    <style>
        .error-message {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid var(--accent-danger);
            color: var(--accent-danger);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-lg);
            font-size: 0.875rem;
        }
        
        .success-message {
            background: rgba(6, 255, 165, 0.1);
            border: 1px solid var(--accent-success);
            color: var(--accent-success);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-lg);
            font-size: 0.875rem;
        }
        
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const errorDiv = document.getElementById('errorMessage');
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear previous messages
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';
            
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                showError('Please enter username/email and password');
                return;
            }
            
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing In...';
            
            const formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);
            
            try {
                const response = await fetch('login_handler.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess(data.message);
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    showError(data.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Sign In <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
                }
            } catch (error) {
                showError('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Sign In <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
            }
        });
        
        function showError(message) {
            errorDiv.innerHTML = message;
            errorDiv.className = 'error-message';
            errorDiv.style.display = 'block';
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        function showSuccess(message) {
            errorDiv.innerHTML = message;
            errorDiv.className = 'success-message';
            errorDiv.style.display = 'block';
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
            });
        });
        
        // Enter key submission
        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                form.dispatchEvent(new Event('submit'));
            }
        });
    });
    </script>
</body>
</html>
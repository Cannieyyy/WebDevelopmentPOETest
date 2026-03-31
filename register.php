
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="auth-page">


    <!-- Navigation -->
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
                <li><a href="register.php" class="nav-link active">Sign Up</a></li>
            </ul>
            <div class="nav-actions">
                <a href="login.php" class="btn btn-outline">Sign In</a>
            </div>
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div class="auth-container">
        <!-- Left Side: Uses EXISTING slideshow classes from index -->
        <div class="auth-visual">
            <div class="slideshow-container auth-slideshow-height">
                <div class="slideshow-slide active">
                    <img src="https://images.unsplash.com/photo-1467043237213-65f2da53396f?w=1200" alt="Wardrobe">
                    <div class="slide-caption">
                        <span>Join 50,000+ Members</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200" alt="Fashion collection">
                    <div class="slide-caption">
                        <span>Save Up to 70%</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?w=1200" alt="Sneakers">
                    <div class="slide-caption">
                        <span>Sell in Minutes</span>
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

        <!-- Right Side: Registration Form -->
        <div class="auth-form-section">
            <div class="auth-form-container">
                <a href="index.php" class="back-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to home
                </a>

                <h1>Create Account</h1>
                <p class="auth-subtitle">Join our community in seconds</p>
                
            <!--post method to allow php to validate-->
                <form class="auth-form" id="registerForm" method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <input type="text" id="firstName" class="form-input" required placeholder="Jane">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <div class="input-wrapper">
                                <input type="text" id="lastName" class="form-input" required placeholder="Doe">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input type="email" id="email" class="form-input" required placeholder="jane@example.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regUsername">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            <input type="text" id="regUsername" name="username" class="form-input" required placeholder="fashionista_2024">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>I want to:</label>
                        <div class="role-selector">
                            <label class="role-option">
                                <input type="radio" name="role" value="buyer" checked>
                                <span class="role-card">
                                    <svg class="role-icon-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                        <line x1="3" y1="6" x2="21" y2="6"/>
                                        <path d="M16 10a4 4 0 0 1-8 0"/>
                                    </svg>
                                    <span class="role-title">Buy</span>
                                    <span class="role-desc">Shop unique items</span>
                                </span>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="seller">
                                <span class="role-card">
                                    <svg class="role-icon-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                                    </svg>
                                    <span class="role-title">Sell</span>
                                    <span class="role-desc">List my items</span>
                                </span>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="both">
                                <span class="role-card">
                                    <svg class="role-icon-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M17 1l4 4-4 4"/>
                                        <path d="M3 11V9a4 4 0 0 1 4-4h14"/>
                                        <path d="M7 23l-4-4 4-4"/>
                                        <path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                                    </svg>
                                    <span class="role-title">Both</span>
                                    <span class="role-desc">Buy and sell</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regPassword">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="regPassword" name="password" class="form-input" required placeholder="Min 8 characters">
                            <button type="button" class="toggle-password">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <ul class="password-requirements" id="passwordReqs">
                            <li class="req-item" data-req="length">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                At least 8 characters
                            </li>
                            <li class="req-item" data-req="number">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                Contains a number
                            </li>
                            <li class="req-item" data-req="special">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                Contains a special character
                            </li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="confirmPassword" class="form-input" required placeholder="Confirm your password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label terms-label">
                            <input type="checkbox" required class="custom-checkbox">
                            <span class="checkmark">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                            <span class="terms-text">I agree to the <a href="#" class="link">Terms of Service</a> and <a href="#" class="link">Privacy Policy</a></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-large btn-primary auth-submit">
                        Create Account
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                </form>

                <p class="auth-footer">
                    Already have an account? 
                    <a href="login.php" class="link-bold">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
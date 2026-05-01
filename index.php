<?php
session_start();
require_once 'DBConn.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['userID']) && isset($_SESSION['logged_in']);
$userRole = $_SESSION['role'] ?? '';
$userName = $_SESSION['firstName'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasTimes - Secondhand Fashion</title>
    <!-- Link to external stylesheet - keeping all styles in one file for reusability -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- Google Fonts for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navigation - consistent across all pages -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <span class="logo-icon">◆</span>
                <span class="logo-text">PasTimes</span>
            </a>

            <!-- Mobile menu toggle button -->
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Navigation links -->
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link active">Home</a></li>
                <li><a href="browse.php" class="nav-link">Browse</a></li>
                <?php if ($isLoggedIn && ($userRole == 'seller' || $userRole == 'both')): ?>
                    <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <?php else: ?>
                    <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <?php endif; ?>
                <li><a href="messages.php" class="nav-link">Messages</a></li>
            </ul>

            <!-- User actions section with Logout button -->
            <div class="nav-actions">
                <a href="cart.php" class="icon-btn cart-btn" aria-label="Shopping cart">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 2L6 7H3L5.5 20H18.5L21 7H18L15 2H9Z" />
                        <path d="M9 11V17M15 11V17" />
                    </svg>
                    <span class="cart-count" id="cartCount">0</span>
                </a>

                <?php if ($isLoggedIn): ?>
                    <!-- User info and logout button when logged in -->
                    <div class="user-info">
                        <span class="user-greeting"> <?php echo htmlspecialchars($userName); ?></span>
                        <a href="logout.php" class="btn btn-outline logout-btn">
                            Logout
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Login button when not logged in -->
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="register.php" class="btn btn-primary">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Personalized Welcome Message -->
    <header class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <?php if ($isLoggedIn && ($userRole == 'buyer' || $userRole == 'both')): ?>
                    <h1 class="hero-title">
                        Welcome back, <?php echo htmlspecialchars($userName); ?>! <span class="gradient-text"></span>
                    </h1>
                    <p class="hero-subtitle">
                        Discover amazing pre-loved fashion just for you.
                    </p>
                <?php elseif ($isLoggedIn && $userRole == 'seller'): ?>
                    <h1 class="hero-title">
                        Welcome back, <span class="gradient-text">Seller!</span>
                    </h1>
                    <p class="hero-subtitle">
                        Ready to list new items? Your customers are waiting!
                    </p>
                <?php else: ?>
                    <h1 class="hero-title">
                        Fashion that<br>
                        <span class="gradient-text">doesn't cost</span><br>
                        the Earth
                    </h1>
                    <p class="hero-subtitle">
                        Buy and sell pre-loved fashion. Join the sustainable revolution
                        where style meets consciousness.
                    </p>
                <?php endif; ?>

                <div class="hero-cta">
                    <?php if ($isLoggedIn && ($userRole == 'seller' || $userRole == 'both')): ?>
                        <a href="seller-dashboard.php" class="btn btn-large btn-primary">
                            Go to Dashboard
                            <span class="btn-arrow">→</span>
                        </a>
                        <a href="upload.php" class="btn btn-large btn-glass">
                            List New Item
                        </a>
                    <?php else: ?>
                        <a href="browse.php" class="btn btn-large btn-primary">
                            Start Exploring
                            <span class="btn-arrow">→</span>
                        </a>
                        <a href="seller-dashboard.php" class="btn btn-large btn-glass">
                            Start Selling
                        </a>
                    <?php endif; ?>
                </div>

                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Items Sold</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">12K+</span>
                        <span class="stat-label">Active Sellers</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">4.9</span>
                        <span class="stat-label">User Rating</span>
                    </div>
                </div>
            </div>

            <!-- Slideshow (keep as is) -->
            <div class="hero-visual">
                <div class="gradient-orb"></div>
                <div class="slideshow-container">
                    <div class="slideshow-slide active">
                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800" alt="Woman shopping sustainable fashion">
                        <div class="slide-caption">
                            <span>Shop Sustainable</span>
                        </div>
                    </div>
                    <div class="slideshow-slide">
                        <img src="https://images.unsplash.com/photo-1634133118553-1e6e18299886?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Vintage clothing collection">
                        <div class="slide-caption">
                            <span>Unique Vintage Finds</span>
                        </div>
                    </div>
                    <div class="slideshow-slide">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=800" alt="Sell your clothes">
                        <div class="slide-caption">
                            <span>Sell Your Style</span>
                        </div>
                    </div>
                    <div class="slideshow-dots">
                        <button class="dot active" aria-label="Slide 1"></button>
                        <button class="dot" aria-label="Slide 2"></button>
                        <button class="dot" aria-label="Slide 3"></button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Browse by Category</h2>
            <div class="category-grid">
                <!-- Category cards with hover effects -->
                <a href="browse.php?category=women" class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600" alt="Women's Fashion">
                    </div>
                    <div class="category-overlay">
                        <h3>Women</h3>
                        <span class="category-count">2,400+ items</span>
                    </div>
                </a>
                <a href="browse.php?category=men" class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?w=600" alt="Men's Fashion">
                    </div>
                    <div class="category-overlay">
                        <h3>Men</h3>
                        <span class="category-count">1,800+ items</span>
                    </div>
                </a>
                <a href="browse.php?category=vintage" class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1634133118553-1e6e18299886?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Vintage">
                    </div>
                    <div class="category-overlay">
                        <h3>Vintage</h3>
                        <span class="category-count">900+ items</span>
                    </div>
                </a>
                <a href="browse.php?category=accessories" class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=600" alt="Accessories">
                    </div>
                    <div class="category-overlay">
                        <h3>Accessories</h3>
                        <span class="category-count">3,200+ items</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- How it works section -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How PasTimes Works</h2>
            <div class="steps-grid">
                <!-- Step 1: Snap & List -->
                <div class="step-card">
                    <div class="step-number">01</div>
                    <!-- Custom SVG icon: Camera/Shutter symbol for photography -->
                    <div class="step-icon">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <!-- Camera body -->
                            <rect x="4" y="12" width="40" height="28" rx="4" stroke="currentColor" stroke-width="2.5" fill="none" />
                            <!-- Lens outer ring -->
                            <circle cx="24" cy="26" r="10" stroke="currentColor" stroke-width="2.5" fill="none" />
                            <!-- Lens inner ring -->
                            <circle cx="24" cy="26" r="6" stroke="currentColor" stroke-width="2" fill="none" />
                            <!-- Lens aperture -->
                            <circle cx="24" cy="26" r="2.5" fill="currentColor" />
                            <!-- Flash/viewfinder bump -->
                            <path d="M16 12V8C16 6.89543 16.8954 6 18 6H30C31.1046 6 32 6.89543 32 8V12" stroke="currentColor" stroke-width="2.5" fill="none" />
                            <!-- Shutter button -->
                            <circle cx="40" cy="18" r="2" fill="currentColor" />
                        </svg>
                    </div>
                    <h3>Snap & List</h3>
                    <p>Take photos of your items, add details, and list in under 2 minutes</p>
                </div>

                <!-- Step 2: Get Verified -->
                <div class="step-card">
                    <div class="step-number">02</div>
                    <!-- Custom SVG icon: Shield with checkmark for verification/security -->
                    <div class="step-icon">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <!-- Shield outline -->
                            <path d="M24 4L6 12V22C6 33.05 13.9 42.22 24 44C34.1 42.22 42 33.05 42 22V12L24 4Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" fill="none" />
                            <!-- Checkmark inside shield -->
                            <path d="M16 24L22 30L32 18" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                        </svg>
                    </div>
                    <h3>Get Verified</h3>
                    <p>Our team reviews listings to ensure quality and authenticity</p>
                </div>

                <!-- Step 3: Connect -->
                <div class="step-card">
                    <div class="step-number">03</div>
                    <!-- Custom SVG icon: Chat bubbles for messaging/connection -->
                    <div class="step-icon">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <!-- Main chat bubble -->
                            <path d="M40 20C40 28.8366 32.8366 36 24 36C21.4227 36 19.0063 35.4229 16.8856 34.3996L8 38L10.5 29.5C8.88163 26.7742 8 23.4927 8 20C8 11.1634 15.1634 4 24 4C32.8366 4 40 11.1634 40 20Z" stroke="currentColor" stroke-width="2.5" fill="none" />
                            <!-- Secondary chat bubble overlapping -->
                            <path d="M44 32C44 38.6274 38.6274 44 32 44C30.1774 44 28.4607 43.5778 26.9366 42.8326L20 46L22.125 39.25C20.883 37.1814 20 34.6861 20 32C20 25.3726 25.3726 20 32 20C38.6274 20 44 25.3726 44 32Z" stroke="currentColor" stroke-width="2.5" fill="rgba(0,245,212,0.1)" />
                            <!-- Dots in secondary bubble -->
                            <circle cx="29" cy="32" r="1.5" fill="currentColor" />
                            <circle cx="32" cy="32" r="1.5" fill="currentColor" />
                            <circle cx="35" cy="32" r="1.5" fill="currentColor" />
                        </svg>
                    </div>
                    <h3>Connect</h3>
                    <p>Chat with buyers, negotiate prices, and build your community</p>
                </div>

                <!-- Step 4: Ship & Earn -->
                <div class="step-card">
                    <div class="step-number">04</div>
                    <!-- Custom SVG icon: Package box with dollar sign for shipping/earning -->
                    <div class="step-icon">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <!-- Package box -->
                            <rect x="4" y="12" width="40" height="32" rx="3" stroke="currentColor" stroke-width="2.5" fill="none" />
                            <!-- Top flaps -->
                            <path d="M4 20H44" stroke="currentColor" stroke-width="2" />
                            <path d="M24 12V20" stroke="currentColor" stroke-width="2" />
                            <!-- Tape/seal -->
                            <path d="M18 12L24 20L30 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <!-- Dollar sign on box -->
                            <text x="24" y="38" text-anchor="middle" fill="currentColor" font-size="16" font-family="Space Grotesk" font-weight="700">$</text>
                            <!-- Arrows indicating shipping/return -->
                            <path d="M8 8L4 12L8 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M40 8L44 12L40 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Ship & Earn</h3>
                    <p>Ship items with our prepaid labels and get paid instantly</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Items Preview -->
    <section class="featured">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Fresh Drops</h2>
                <a href="browse.php" class="link-arrow">View all →</a>
            </div>
            <div class="product-grid" id="featuredGrid">
                <!-- Products populated by js -->
            </div>
        </div>
    </section>

    <!-- Footer - Consistent across all pages -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">
                        <span class="logo-icon">◆</span>
                        <span class="logo-text">PasTimes</span>
                    </a>
                    <p>Building a sustainable future, one outfit at a time.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="Twitter">TW</a>
                        <a href="#" aria-label="Pinterest">PI</a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="browse.php">All Items</a></li>
                        <li><a href="browse.php?category=women">Women</a></li>
                        <li><a href="browse.php?category=men">Men</a></li>
                        <li><a href="browse.php?category=vintage">Vintage</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Sell</h4>
                    <ul>
                        <li><a href="seller-dashboard.php">Start Selling</a></li>
                        <li><a href="#">Seller Guide</a></li>
                        <li><a href="#">Success Stories</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="admin-dashboard.php">Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 PasTimes. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript file - all functionality separated from HTML -->
    <script src="js/main.js"></script>
</body>

</html>
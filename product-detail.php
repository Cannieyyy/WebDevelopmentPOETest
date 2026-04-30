<?php
require_once 'includes/auth.php';
$currentUser = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vintage Denim Jacket - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span class="logo-icon">◆</span>
                <span class="logo-text">PasTimes</span>
            </a>
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="browse.php" class="nav-link active">Browse</a></li>
                <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <li><a href="messages.php" class="nav-link">Messages</a></li>
            </ul>
            <div class="nav-actions">
                <a href="cart.php" class="icon-btn cart-btn" aria-label="Shopping cart">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 2L6 7H3L5.5 20H18.5L21 7H18L15 2H9Z"/>
                        <path d="M9 11V17M15 11V17"/>
                    </svg>
                    <span class="cart-count" id="cartCount">0</span>
                </a>
                <a href="login.php" class="btn btn-outline">Login</a>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <div class="container">
            <ol class="breadcrumb-list">
                <li><a href="index.php">Home</a></li>
                <li><a href="browse.php">Women</a></li>
                <li><a href="browse.php">Jackets</a></li>
                <li aria-current="page">Vintage Denim Jacket</li>
            </ol>
        </div>
    </nav>

    <!-- Product Detail Section -->
    <main class="product-detail">
        <div class="container">
            <div class="product-layout">
                <!-- Image Gallery -->
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=800" alt="Vintage Denim Jacket" id="mainImage">
                        <button class="image-nav prev" aria-label="Previous image">←</button>
                        <button class="image-nav next" aria-label="Next image">→</button>
                        <span class="image-badge">Verified</span>
                    </div>
                    <div class="thumbnail-grid">
                        <button class="thumbnail active">
                            <img src="https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=200" alt="View 1">
                        </button>
                        <button class="thumbnail">
                            <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=200" alt="View 2">
                        </button>
                        <button class="thumbnail">
                            <img src="https://images.unsplash.com/photo-1544923246-77307dd628b9?w=200" alt="View 3">
                        </button>
                        <button class="thumbnail">
                            <img src="https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=200" alt="View 4">
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-header">
                        <div class="product-meta">
                            <span class="product-condition">Excellent Condition</span>
                            <span class="product-posted">Posted 2 hours ago</span>
                        </div>
                        <h1 class="product-title">Vintage Denim Jacket</h1>
                        <div class="product-price-section">
                            <span class="current-price">$68</span>
                            <span class="original-price">$120</span>
                            <span class="discount-badge">43% off</span>
                        </div>
                    </div>

                    <div class="seller-card">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Seller" class="seller-avatar">
                        <div class="seller-info">
                            <h4>Sarah's Closet</h4>
                            <div class="seller-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-count">(128 reviews)</span>
                            </div>
                            <span class="verified-seller">✓ Verified Seller</span>
                        </div>
                        <a href="messages.php?seller=sarah" class="btn btn-outline btn-small">Message</a>
                    </div>

                    <div class="product-details">
                        <h3>Description</h3>
                        <p>Authentic vintage denim jacket from the 90s. Perfect condition with natural fading. Size M but fits oversized. Measurements: Chest 42", Length 26".</p>
                        
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Size</span>
                                <span class="detail-value">M (US)</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Color</span>
                                <span class="detail-value">Vintage Blue</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Brand</span>
                                <span class="detail-value">Levi's</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Material</span>
                                <span class="detail-value">100% Cotton</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-actions">
                        <div class="quantity-selector">
                            <button class="qty-btn" aria-label="Decrease quantity">−</button>
                            <input type="number" value="1" min="1" max="5" class="qty-input">
                            <button class="qty-btn" aria-label="Increase quantity">+</button>
                        </div>
                        <button class="btn btn-large btn-primary add-to-cart" id="addToCart">
                            Add to Cart - $68
                        </button>
                        <button class="btn btn-large btn-outline wishlist-btn" aria-label="Add to wishlist">
                            ♡
                        </button>
                    </div>

                    <div class="trust-badges">
                        <div class="badge">
                            <span class="badge-icon">🛡️</span>
                            <span>Buyer Protection</span>
                        </div>
                        <div class="badge">
                            <span class="badge-icon">🚚</span>
                            <span>Free Shipping</span>
                        </div>
                        <div class="badge">
                            <span class="badge-icon">↩️</span>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Items -->
            <section class="similar-items">
                <h2 class="section-title">You May Also Like</h2>
                <div class="product-grid" id="similarGrid">
                    <!-- Loaded via JS -->
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">
                        <span class="logo-icon">◆</span>
                        <span class="logo-text">PasTimes</span>
                    </a>
                    <p>Building a sustainable future, one outfit at a time.</p>
                </div>
                <div class="footer-links">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="browse.php">All Items</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
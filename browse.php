<?php
session_start();
require_once 'DBConn.php';

$isLoggedIn = isset($_SESSION['userID']) && isset($_SESSION['logged_in']);
$userRole = $_SESSION['role'] ?? '';
$userName = $_SESSION['firstName'] ?? '';

if ($userRole != 'buyer' && $userRole != 'both') {
    $_SESSION['error'] = 'Access denied. Only buyers can access the dashboard.';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse - PasTimes</title>
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
                <?php if ($isLoggedIn && ($userRole == 'seller' || $userRole == 'both')): ?>
                    <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <?php else: ?>
                    <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <?php endif; ?>
                <li><a href="messages.php" class="nav-link">Messages</a></li>
            </ul>
            <div class="nav-actions">
                <a href="cart.php" class="icon-btn cart-btn" aria-label="Shopping cart">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 2L6 7H3L5.5 20H18.5L21 7H18L15 2H9Z" />
                        <path d="M9 11V17M15 11V17" />
                    </svg>
                    <span class="cart-count" id="cartCount">0</span>
                </a>

                <?php if ($isLoggedIn): ?>
                    <div class="user-info">
                        <span class="user-greeting"><?php echo htmlspecialchars($userName); ?></span>
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
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="register.php" class="btn btn-primary">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Browse Header with Search -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-title">Discover Pre-Loved Fashion</h1>
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search for items, brands, or styles..." id="searchInput">
                <button class="search-btn" aria-label="Search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21L16.65 16.65" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Browse Layout -->
    <main class="browse-layout">
        <!-- Sidebar Filters - Collapsible on mobile -->
        <aside class="filters-sidebar" id="filtersSidebar">
            <div class="filters-header">
                <h3>Filters</h3>
                <button class="btn btn-text" id="clearFilters">Clear all</button>
            </div>

            <!-- Filter Groups -->
            <div class="filter-group">
                <h4 class="filter-title">Category</h4>
                <div class="filter-options">
                    <label class="checkbox-label">
                        <input type="checkbox" value="women" class="filter-checkbox">
                        <span class="checkmark"></span>
                        Women
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="men" class="filter-checkbox">
                        <span class="checkmark"></span>
                        Men
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="vintage" class="filter-checkbox">
                        <span class="checkmark"></span>
                        Vintage
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="accessories" class="filter-checkbox">
                        <span class="checkmark"></span>
                        Accessories
                    </label>
                </div>
            </div>

            <div class="filter-group">
                <h4 class="filter-title">Price Range</h4>
                <div class="price-range">
                    <input type="range" min="0" max="500" value="500" class="price-slider" id="priceSlider">
                    <div class="price-inputs">
                        <input type="number" placeholder="Min" class="price-input">
                        <span>to</span>
                        <input type="number" placeholder="Max" class="price-input" value="500">
                    </div>
                </div>
            </div>

            <div class="filter-group">
                <h4 class="filter-title">Size</h4>
                <div class="size-grid">
                    <button class="size-btn">XS</button>
                    <button class="size-btn">S</button>
                    <button class="size-btn active">M</button>
                    <button class="size-btn">L</button>
                    <button class="size-btn">XL</button>
                    <button class="size-btn">XXL</button>
                </div>
            </div>

            <div class="filter-group">
                <h4 class="filter-title">Condition</h4>
                <div class="filter-options">
                    <label class="checkbox-label">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="checkmark"></span>
                        Like New
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" class="filter-checkbox" checked>
                        <span class="checkmark"></span>
                        Excellent
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" class="filter-checkbox">
                        <span class="checkmark"></span>
                        Good
                    </label>
                </div>
            </div>
        </aside>

        <!-- Mobile Filter Toggle -->
        <button class="mobile-filter-toggle" id="mobileFilterToggle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="4" y1="6" x2="20" y2="6" />
                <line x1="4" y1="12" x2="20" y2="12" />
                <line x1="4" y1="18" x2="20" y2="18" />
            </svg>
            Filters
        </button>

        <!-- Product Grid Area -->
        <section class="products-section">
            <div class="products-header">
                <span class="results-count">Showing 24 of 1,240 items</span>
                <div class="sort-dropdown">
                    <select class="sort-select" id="sortSelect">
                        <option value="newest">Newest First</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Product Grid -->
            <div class="product-grid" id="productGrid">
                <!-- Products loaded via JavaScript -->
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn" disabled>← Previous</button>
                <div class="page-numbers">
                    <button class="page-number active">1</button>
                    <button class="page-number">2</button>
                    <button class="page-number">3</button>
                    <span class="page-ellipsis">...</span>
                    <button class="page-number">52</button>
                </div>
                <button class="page-btn">Next →</button>
            </div>
        </section>
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
                        <li><a href="browse.php?category=women">Women</a></li>
                        <li><a href="browse.php?category=men">Men</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Sell</h4>
                    <ul>
                        <li><a href="seller-dashboard.php">Start Selling</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="admin-dashboard.php">Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 PasTimes. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>

</html>
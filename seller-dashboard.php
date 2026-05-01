<?php
session_start();
require_once 'DBConn.php';

// Check if user is logged in
if (!isset($_SESSION['userID']) || !isset($_SESSION['logged_in'])) {
    $_SESSION['error'] = 'Please login to access the seller dashboard.';
    header('Location: login.php');
    exit();
}

// Check if user has seller role
$isLoggedIn = isset($_SESSION['userID']) && isset($_SESSION['logged_in']);
$userRole = $_SESSION['role'] ?? '';
$userName = $_SESSION['firstName'] ?? '';

if ($userRole != 'seller' && $userRole != 'both') {
    $_SESSION['error'] = 'Access denied. Only sellers can access the dashboard.';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
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
                <li><a href="browse.php" class="nav-link">Browse</a></li>
                <li><a href="seller-dashboard.php" class="nav-link active">Sell</a></li>
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

    <main class="dashboard">
        <div class="container">
            <div class="dashboard-header">
                <div class="seller-info">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200" alt="Store" class="store-avatar">
                    <div class="seller-details">
                        <h1>Welcome back <?php echo htmlspecialchars($userName); ?></h1>
                        <span class="seller-status verified">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Verified Seller
                        </span>
                        <div class="seller-stats">
                            <span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                                4.9 Rating
                            </span>
                            <span>•</span>
                            <span>128 Sales</span>
                            <span>•</span>
                            <span>Member since 2023</span>
                        </div>
                    </div>
                </div>
                <a href="upload.php" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    List New Item
                </a>
            </div>

            <div class="dashboard-grid">
                <!-- Sidebar Navigation -->
                <aside class="dashboard-sidebar">
                    <nav class="dashboard-nav">
                        <a href="#" class="dash-nav-item active">
                            <svg class="dash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                            </svg>
                            Overview
                        </a>
                        <a href="#" class="dash-nav-item">
                            <svg class="dash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            </svg>
                            My Items
                            <span class="dash-badge">12</span>
                        </a>
                        <a href="#" class="dash-nav-item">
                            <svg class="dash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            </svg>
                            Orders
                            <span class="dash-badge new">3</span>
                        </a>
                        <a href="messages.php" class="dash-nav-item">
                            <svg class="dash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                            Messages
                            <span class="dash-badge">5</span>
                        </a>
                        <a href="#" class="dash-nav-item">
                            <svg class="dash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                            Earnings
                        </a>
                        <a href="#" class="dash-nav-item">
                            <svg class="dash-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3" />
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                            </svg>
                            Settings
                        </a>
                    </nav>
                </aside>

                <!-- Main Dashboard Content -->
                <section class="dashboard-content">
                    <!-- Stats Cards -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23" />
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Total Earnings</span>
                                <span class="stat-value">R 4,280</span>
                                <span class="stat-change positive">+12% this month</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Item Views</span>
                                <span class="stat-value">2,845</span>
                                <span class="stat-change positive">+28% this week</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                    <polyline points="17 6 23 6 23 12" />
                                </svg>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Conversion Rate</span>
                                <span class="stat-value">4.5%</span>
                                <span class="stat-change negative">-0.2% this week</span>
                            </div>
                        </div>
                    </div>

                    <!-- Items Status -->
                    <div class="dashboard-section">
                        <h2>Your Items</h2>
                        <div class="items-tabs">
                            <button class="tab-btn active" data-tab="active">Active (8)</button>
                            <button class="tab-btn" data-tab="pending">Pending Approval (2)</button>
                            <button class="tab-btn" data-tab="sold">Sold (12)</button>
                        </div>

                        <div class="items-list" id="itemsList">
                            <div class="item-row">
                                <img src="https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=200" alt="Item">
                                <div class="item-info">
                                    <h4>Vintage Denim Jacket</h4>
                                    <span class="item-price">R 450</span>
                                    <span class="item-status active">Active</span>
                                </div>
                                <div class="item-stats">
                                    <span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        234 views
                                    </span>
                                    <span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                        </svg>
                                        12 likes
                                    </span>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-small btn-outline">Edit</button>
                                    <button class="btn btn-small btn-text">Delete</button>
                                </div>
                            </div>

                            <div class="item-row pending">
                                <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=200" alt="Item">
                                <div class="item-info">
                                    <h4>Silk Blouse</h4>
                                    <span class="item-price">R 320</span>
                                    <span class="item-status pending">Pending Review</span>
                                </div>
                                <div class="item-stats">
                                    <span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        Submitted 2h ago
                                    </span>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-small btn-text">Withdraw</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="dashboard-section">
                        <h2>Recent Activity</h2>
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="activity-icon sale">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="1" x2="12" y2="23" />
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <p><strong>Vintage Denim Jacket</strong> was purchased</p>
                                    <span class="activity-time">2 hours ago</span>
                                </div>
                                <span class="activity-amount">+R 450</span>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon message">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <p>New message from <strong>Jane Doe</strong></p>
                                    <span class="activity-time">5 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script src="js/main.js"></script>
</body>

</html>
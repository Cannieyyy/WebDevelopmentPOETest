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
$userRole = $_SESSION['role'] ?? '';
$userName = $_SESSION['firstName'] ?? '';
$userID = $_SESSION['userID'];
$isLoggedIn = isset($_SESSION['userID']) && isset($_SESSION['logged_in']);

if ($userRole != 'seller' && $userRole != 'both') {
    $_SESSION['error'] = 'Access denied. Only sellers can access the dashboard.';
    header('Location: index.php');
    exit();
}

// Fetch seller's items from tblClothes
try {
    $stmt = $pdo->prepare("
        SELECT itemID, title, category, size, brand, condition_status, price, 
               description, images, status, views, createdAt 
        FROM tblClothes 
        WHERE sellerID = ? 
        ORDER BY createdAt DESC
    ");
    $stmt->execute([$userID]);
    $sellerItems = $stmt->fetchAll();

    // Count by status
    $activeItems = 0;
    $pendingItems = 0;
    $soldItems = 0;

    foreach ($sellerItems as $item) {
        switch ($item['status']) {
            case 'active':
                $activeItems++;
                break;
            case 'pending':
                $pendingItems++;
                break;
            case 'sold':
                $soldItems++;
                break;
        }
    }

    // Calculate total earnings (from sold items)
    $stmt = $pdo->prepare("
        SELECT SUM(oi.priceAtTime * oi.quantity) as totalEarnings
        FROM tblOrderItems oi
        JOIN tblClothes c ON oi.itemID = c.itemID
        WHERE c.sellerID = ? AND c.status = 'sold'
    ");
    $stmt->execute([$userID]);
    $earnings = $stmt->fetch();
    $totalEarnings = $earnings['totalEarnings'] ?? 0;
} catch (PDOException $e) {
    error_log("Error fetching seller items: " . $e->getMessage());
    $sellerItems = [];
    $activeItems = 0;
    $pendingItems = 0;
    $soldItems = 0;
    $totalEarnings = 0;
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
                            <div class="stat-icon">💰</div>
                            <div class="stat-info">
                                <span class="stat-label">Total Earnings</span>
                                <span class="stat-value">R <?php echo number_format($totalEarnings, 2); ?></span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">👁️</div>
                            <div class="stat-info">
                                <span class="stat-label">Total Views</span>
                                <span class="stat-value"><?php echo array_sum(array_column($sellerItems, 'views')); ?></span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">📦</div>
                            <div class="stat-info">
                                <span class="stat-label">Items Listed</span>
                                <span class="stat-value"><?php echo count($sellerItems); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Items Status -->
                    <div class="dashboard-section">
                        <h2>Your Items</h2>
                        <div class="items-tabs">
                            <button class="tab-btn active" data-tab="active">Active (<?php echo $activeItems; ?>)</button>
                            <button class="tab-btn" data-tab="pending">Pending Approval (<?php echo $pendingItems; ?>)</button>
                            <button class="tab-btn" data-tab="sold">Sold (<?php echo $soldItems; ?>)</button>
                        </div>

                        <div class="items-list" id="itemsList">
                            <?php if (empty($sellerItems)): ?>
                                <div class="empty-state" style="text-align: center; padding: 60px;">
                                    <p>You haven't listed any items yet.</p>
                                    <a href="upload.php" class="btn btn-primary">List Your First Item</a>
                                </div>
                            <?php else: ?>
                                <?php foreach ($sellerItems as $item):
                                    $statusClass = '';
                                    $statusText = '';
                                    switch ($item['status']) {
                                        case 'active':
                                            $statusClass = 'active';
                                            $statusText = 'Active';
                                            break;
                                        case 'pending':
                                            $statusClass = 'pending';
                                            $statusText = 'Pending Review';
                                            break;
                                        case 'sold':
                                            $statusClass = 'sold';
                                            $statusText = 'Sold';
                                            break;
                                        default:
                                            $statusClass = 'pending';
                                            $statusText = ucfirst($item['status']);
                                    }

                                    // Parse images JSON or get first image
                                    $images = json_decode($item['images'], true);
                                    $firstImage = !empty($images) ? $images[0] : 'https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=200';
                                ?>
                                    <div class="item-row" data-item-id="<?php echo $item['itemID']; ?>">
                                        <img src="<?php echo htmlspecialchars($firstImage); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                        <div class="item-info">
                                            <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                                            <span class="item-price">R <?php echo number_format($item['price'], 2); ?></span>
                                            <span class="item-status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                        </div>
                                        <div class="item-stats">
                                            <span>👁️ <?php echo number_format($item['views'] ?? 0); ?> views</span>
                                            <span>📅 <?php echo date('M d, Y', strtotime($item['createdAt'])); ?></span>
                                        </div>
                                        <div class="item-actions">
                                            <?php if ($item['status'] == 'active'): ?>
                                                <button class="btn btn-small btn-primary add-to-cart-btn"
                                                    onclick="showPricePopup(<?php echo $item['itemID']; ?>, <?php echo $item['price']; ?>, '<?php echo addslashes($item['title']); ?>')">
                                                    🛒 Add to Cart
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn btn-small btn-outline">Edit</button>
                                            <button class="btn btn-small btn-text delete-item" data-id="<?php echo $item['itemID']; ?>">Delete</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
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

    <script>
        // Popup modal for showing price
        function showPricePopup(itemId, price, title) {
            // Create modal overlay
            const modal = document.createElement('div');
            modal.className = 'price-modal';
            modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        backdrop-filter: blur(5px);
    `;

            // Create modal content
            modal.innerHTML = `
        <div style="
            background: var(--bg-card);
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            border: 1px solid rgba(0,245,212,0.3);
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        ">
            <h2 style="color: var(--accent-primary); margin-bottom: 15px;">Item Price</h2>
            <p style="font-size: 18px; margin-bottom: 10px;">${escapeHtml(title)}</p>
            <p style="font-size: 48px; font-weight: 700; color: var(--accent-primary); margin: 20px 0;">
                R ${price.toFixed(2)}
            </p>
            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
                <button class="btn btn-primary" onclick="this.closest('.price-modal').remove(); addToCartFromModal(${itemId}, ${price}, '${escapeHtml(title)}')">
                    Add to Cart
                </button>
                <button class="btn btn-outline" onclick="this.closest('.price-modal').remove()">
                    Close
                </button>
            </div>
        </div>
    `;

            document.body.appendChild(modal);

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && document.querySelector('.price-modal')) {
                    document.querySelector('.price-modal').remove();
                }
            });
        }

        function addToCartFromModal(itemId, price, title) {
            // Get existing cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');

            // Check if item already in cart
            const existingItem = cart.find(item => item.id === itemId);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: itemId,
                    title: title,
                    price: price,
                    quantity: 1,
                    image: document.querySelector(`.item-row[data-item-id="${itemId}"] img`)?.src || ''
                });
            }

            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Show success message
            showToast('✓ Item added to cart!', 'success');

            // Update cart count if function exists
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.cssText = `
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: ${type === 'success' ? '#06ffa5' : '#00f5d4'};
        color: #0a0a0f;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        z-index: 10001;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Tab switching functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tab = this.dataset.tab;
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Filter items
                document.querySelectorAll('.item-row').forEach(row => {
                    const statusSpan = row.querySelector('.item-status');
                    if (statusSpan) {
                        const statusText = statusSpan.textContent.toLowerCase();
                        if (tab === 'active' && (statusText === 'active' || statusText === 'active')) {
                            row.style.display = 'grid';
                        } else if (tab === 'pending' && statusText.includes('pending')) {
                            row.style.display = 'grid';
                        } else if (tab === 'sold' && statusText === 'sold') {
                            row.style.display = 'grid';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        });

        // Delete item functionality
        document.querySelectorAll('.delete-item').forEach(btn => {
            btn.addEventListener('click', async function() {
                const itemId = this.dataset.id;
                if (confirm('Are you sure you want to delete this item?')) {
                    // AJAX call to delete item
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('itemID', itemId);

                    try {
                        const response = await fetch('delete-item.php', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.closest('.item-row').remove();
                            showToast('Item deleted successfully');
                        } else {
                            showToast('Failed to delete item', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Error deleting item', 'error');
                    }
                }
            });
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
        document.head.appendChild(style);
    </script>
</body>

</html>
<?php
require_once 'includes/auth.php';
$currentUser = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <span class="logo-icon">◆</span>
                <span>Admin Panel</span>
            </div>
            <nav class="admin-nav">
                <a href="#" class="admin-nav-item active" data-section="overview">
                    <span>📊</span> Overview
                </a>
                <a href="#" class="admin-nav-item" data-section="users">
                    <span>👥</span> Users
                    <span class="admin-badge">3</span>
                </a>
                <a href="#" class="admin-nav-item" data-section="items">
                    <span>📦</span> Items
                    <span class="admin-badge alert">5</span>
                </a>
                <a href="#" class="admin-nav-item" data-section="orders">
                    <span>🛒</span> Orders
                </a>
                <a href="#" class="admin-nav-item" data-section="messages">
                    <span>💬</span> Messages
                </a>
                <a href="#" class="admin-nav-item" data-section="settings">
                    <span>⚙️</span> Settings
                </a>
            </nav>
            <div class="admin-user">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Admin">
                <div>
                    <strong>Admin User</strong>
                    <span>Super Admin</span>
                </div>
            </div>
        </aside>

        <!-- Admin Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1>Dashboard Overview</h1>
                <div class="admin-actions">
                    <button class="btn btn-outline">Export Data</button>
                    <button class="btn btn-primary">System Health: Good</button>
                </div>
            </header>

            <!-- Admin Stats -->
            <div class="admin-stats-grid">
                <div class="admin-stat-card">
                    <div class="stat-header">
                        <h3>Total Users</h3>
                        <span class="stat-trend up">↑ 12%</span>
                    </div>
                    <div class="stat-value">12,458</div>
                    <div class="stat-breakdown">
                        <span>Buyers: 8,234</span>
                        <span>Sellers: 4,224</span>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="stat-header">
                        <h3>Pending Verifications</h3>
                        <span class="stat-trend alert">!</span>
                    </div>
                    <div class="stat-value">23</div>
                    <div class="stat-breakdown">
                        <span>Sellers: 12</span>
                        <span>Items: 11</span>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="stat-header">
                        <h3>Today's Revenue</h3>
                        <span class="stat-trend up">↑ 8%</span>
                    </div>
                    <div class="stat-value">$4,280</div>
                    <div class="stat-breakdown">
                        <span>Orders: 45</span>
                        <span>Avg: $95</span>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="stat-header">
                        <h3>Active Listings</h3>
                        <span class="stat-trend down">↓ 2%</span>
                    </div>
                    <div class="stat-value">8,492</div>
                    <div class="stat-breakdown">
                        <span>New today: 124</span>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications Section -->
            <section class="admin-section">
                <div class="section-header">
                    <h2>Pending Verifications</h2>
                    <div class="section-tabs">
                        <button class="tab-btn active" data-tab="sellers">Sellers (12)</button>
                        <button class="tab-btn" data-tab="items">Items (11)</button>
                    </div>
                </div>

                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User/Item</th>
                                <th>Type</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="table-user">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="">
                                        <div>
                                            <strong>Sarah Johnson</strong>
                                            <span>sarah@email.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Seller Verification</td>
                                <td>2 hours ago</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <button class="btn btn-small btn-success">Approve</button>
                                    <button class="btn btn-small btn-danger">Reject</button>
                                    <button class="btn btn-small btn-outline">Review</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="table-item">
                                        <img src="https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=100" alt="">
                                        <div>
                                            <strong>Vintage Denim Jacket</strong>
                                            <span>By: Sarah's Closet</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Item Listing</td>
                                <td>3 hours ago</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <button class="btn btn-small btn-success">Approve</button>
                                    <button class="btn btn-small btn-danger">Reject</button>
                                    <button class="btn btn-small btn-outline">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- User Management Section -->
            <section class="admin-section">
                <div class="section-header">
                    <h2>User Management</h2>
                    <div class="table-actions">
                        <input type="search" placeholder="Search users..." class="form-input">
                        <button class="btn btn-primary">+ Add User</button>
                    </div>
                </div>
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="table-user">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="">
                                        <div>
                                            <strong>Jane Cooper</strong>
                                            <span>jane@example.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Seller</td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>Jan 15, 2024</td>
                                <td>
                                    <button class="btn btn-small btn-outline">Edit</button>
                                    <button class="btn btn-small btn-danger">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
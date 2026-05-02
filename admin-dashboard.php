<?php
session_start();
require_once 'DBConn.php';

// only admin allowed
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    header('Location: login.php');
    exit();
}

// Fetch pending users
$stmt = $pdo->prepare("SELECT * FROM tblUser WHERE userStatus = 'inactive' ORDER BY userID DESC");
$stmt->execute();
$pendingUsers = $stmt->fetchAll();

// Handle approve/reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && isset($_POST['userID'])) {

        $userID = intval($_POST['userID']);
        $action = $_POST['action'];
        switch ($action) {

            case 'approve':
                $stmt = $pdo->prepare("UPDATE tblUser SET userStatus = 'active' WHERE userID = ?");
                $stmt->execute([$userID]);
                break;

            case 'reject':
                $stmt = $pdo->prepare("UPDATE tblUser SET userStatus = 'banned' WHERE userID = ?");
                $stmt->execute([$userID]);
                break;

            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM tblUser WHERE userID = ?");
                $stmt->execute([$userID]);
                break;

            case 'update':
                $status = $_POST['status'];
                $role = $_POST['role'];

                $stmt = $pdo->prepare("
                    UPDATE tblUser 
                    SET userStatus = ?, role = ?
                    WHERE userID = ?
                ");
                $stmt->execute([$status, $role, $userID]);
                break;
        }

        // refresh page so changes show immediately
        header("Location: admin-dashboard.php");
        exit();
    }
}
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
                        <?php if (count($pendingUsers) > 0): ?>
                            <?php foreach ($pendingUsers as $user): ?>
                                <tr>
                                    <td>
                                        <div class="table-user">
                                            <img src="https://via.placeholder.com/40" alt="">
                                            <div>
                                                <strong><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></strong>
                                                <span><?php echo htmlspecialchars($user['email']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Account</td>
                                    <td>Recently</td>
                                    <td>
                                        <span class="status-badge pending">Pending</span>
                                    </td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn btn-small btn-success">Approve</button>
                                        </form>

                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn btn-small btn-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No pending users</td>
                            </tr>
                        <?php endif; ?>
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
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM tblUser ORDER BY userID DESC");
                            $stmt->execute();
                            $allUsers = $stmt->fetchAll();
                            ?>

                            <?php foreach ($allUsers as $user): ?>
                            <tr>
                                <td>
                                    <div class="table-user">
                                        <img src="https://via.placeholder.com/40" alt="">
                                        <div>
                                            <strong><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></strong>
                                            <span><?php echo htmlspecialchars($user['email']); ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td><?php echo htmlspecialchars($user['role']); ?></td>

                                <td>
                                    <?php
                                    $status = $user['userStatus'];

                                    if ($status === 'active') {
                                        echo '<span class="status-badge active">Active</span>';
                                    } elseif ($status === 'inactive') {
                                        echo '<span class="status-badge pending">Pending</span>';
                                    } elseif ($status === 'banned') {
                                        echo '<span class="status-badge banned">Banned</span>';
                                    } else {
                                        echo '<span class="status-badge">Unknown</span>';
                                    }
                                    ?>
                                </td>

                                <td><?php echo $user['createdAt']; ?></td>

                                <td>
                                    <button
                                        class="btn btn-small btn-outline"
                                        onclick="openEditModal(
                                            <?= $user['userID'] ?>,
                                            '<?= $user['userStatus'] ?>',
                                            '<?= $user['role'] ?>'
                                        )"
                                        >
                                        Edit
                                    </button>

                                    <!-- DELETE -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn btn-small btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
   <div id="editModal" class="modal">
    <div class="modal-content">

        <h2 style="margin: 0;">Edit User</h2>

        <form method="POST" class="modal-form">
            <input type="hidden" name="userID" id="editUserID">
            <input type="hidden" name="action" value="update">

            <label>Status</label>
            <select name="status" id="editStatus">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="banned">Banned</option>
            </select>

            <label>Role</label>
            <select name="role" id="editRole">
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
                <option value="both">Both</option>
            </select>

            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">Cancel</button>
            </div>

        </form>

    </div>
</div>
    <script src="js/main.js"></script>
</body>

</html>
<?php
/**
 * loadClothingStore.php
 * Creates ALL tables for ClothingStore database
 * Drops all tables before creating (no foreign key issues)
 */

// Include database connection
require_once 'DBConn.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load ClothingStore Database</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0a0f;
            color: #fff;
            padding: 40px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #151520;
            border-radius: 16px;
            padding: 30px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        h1, h2 { color: #00f5d4; }
        h3 { color: #ffb703; margin-top: 20px; }
        .success { color: #06ffa5; background: rgba(6,255,165,0.1); padding: 10px; border-radius: 8px; margin: 10px 0; }
        .error { color: #ff4757; background: rgba(255,71,87,0.1); padding: 10px; border-radius: 8px; margin: 10px 0; }
        .info { color: #ffb703; background: rgba(255,183,3,0.1); padding: 10px; border-radius: 8px; margin: 10px 0; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background: #1a1a25;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #00f5d4;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { color: #00f5d4; }
        .button {
            display: inline-block;
            background: #00f5d4;
            color: #0a0a0f;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            margin-right: 10px;
        }
        .button-secondary {
            background: #1a1a25;
            color: #00f5d4;
            border: 1px solid #00f5d4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏗️ ClothingStore Database Setup</h1>
        <p>Creating all tables and loading sample data</p>
        
        <?php
        try {
            // ============================================
            // DROP ALL TABLES IN CORRECT ORDER
            // ============================================
            echo "<h2>📋 Step 1: Dropping existing tables</h2>";
            
            $tablesToDrop = ['tblOrderItems', 'tblWishlist', 'tblMessages', 'tblAorder', 'tblClothes', 'tblAdmin', 'tblUser'];
            foreach ($tablesToDrop as $table) {
                try {
                    $pdo->exec("DROP TABLE IF EXISTS `$table`");
                    echo "<p class='info'>✓ Dropped $table (if existed)</p>";
                } catch (PDOException $e) {
                    // Ignore errors - table might not exist
                }
            }
            
            // ============================================
            // CREATE ALL TABLES
            // ============================================
            echo "<h2>📋 Step 2: Creating tables</h2>";
            
            // 1. tblUser
            $sql = "CREATE TABLE IF NOT EXISTS `tblUser` (
                `userID` INT AUTO_INCREMENT PRIMARY KEY,
                `firstName` VARCHAR(50) NOT NULL,
                `lastName` VARCHAR(50) NOT NULL,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `email` VARCHAR(100) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `role` ENUM('buyer', 'seller', 'both') DEFAULT 'buyer',
                `userStatus` ENUM('active', 'inactive', 'banned') DEFAULT 'active',
                `remember_token` VARCHAR(255) NULL,
                `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_email` (`email`),
                INDEX `idx_username` (`username`),
                INDEX `idx_status` (`userStatus`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblUser</p>";
            
            // 2. tblAdmin
            $sql = "CREATE TABLE IF NOT EXISTS `tblAdmin` (
                `adminID` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `email` VARCHAR(100) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `fullName` VARCHAR(100) NOT NULL,
                `role` ENUM('super', 'moderator', 'support') DEFAULT 'moderator',
                `lastLogin` TIMESTAMP NULL,
                `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX `idx_username` (`username`),
                INDEX `idx_email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblAdmin</p>";
            
            // 3. tblClothes
            $sql = "CREATE TABLE IF NOT EXISTS `tblClothes` (
                `itemID` INT AUTO_INCREMENT PRIMARY KEY,
                `sellerID` INT NOT NULL,
                `title` VARCHAR(200) NOT NULL,
                `category` VARCHAR(50) NOT NULL,
                `subcategory` VARCHAR(50),
                `size` VARCHAR(10),
                `brand` VARCHAR(100),
                `condition_status` ENUM('new', 'excellent', 'good', 'fair') DEFAULT 'good',
                `price` DECIMAL(10,2) NOT NULL,
                `description` TEXT,
                `images` TEXT,
                `shipping` VARCHAR(20) DEFAULT 'buyer',
                `status` ENUM('pending', 'active', 'sold', 'inactive') DEFAULT 'pending',
                `views` INT DEFAULT 0,
                `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`sellerID`) REFERENCES `tblUser`(`userID`) ON DELETE CASCADE,
                INDEX `idx_seller` (`sellerID`),
                INDEX `idx_category` (`category`),
                INDEX `idx_status` (`status`),
                INDEX `idx_price` (`price`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblClothes</p>";
            
            // 4. tblAorder
            $sql = "CREATE TABLE IF NOT EXISTS `tblAorder` (
                `orderID` INT AUTO_INCREMENT PRIMARY KEY,
                `buyerID` INT NOT NULL,
                `orderNumber` VARCHAR(50) NOT NULL UNIQUE,
                `totalAmount` DECIMAL(10,2) NOT NULL,
                `shippingAddress` TEXT NOT NULL,
                `shippingCity` VARCHAR(100),
                `shippingPostal` VARCHAR(20),
                `paymentMethod` VARCHAR(50) NOT NULL,
                `paymentStatus` ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
                `orderStatus` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
                `trackingNumber` VARCHAR(100),
                `notes` TEXT,
                `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (`buyerID`) REFERENCES `tblUser`(`userID`) ON DELETE CASCADE,
                INDEX `idx_buyer` (`buyerID`),
                INDEX `idx_order_number` (`orderNumber`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblAorder</p>";
            
            // 5. tblOrderItems
            $sql = "CREATE TABLE IF NOT EXISTS `tblOrderItems` (
                `orderItemID` INT AUTO_INCREMENT PRIMARY KEY,
                `orderID` INT NOT NULL,
                `itemID` INT NOT NULL,
                `quantity` INT DEFAULT 1,
                `priceAtTime` DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (`orderID`) REFERENCES `tblAorder`(`orderID`) ON DELETE CASCADE,
                FOREIGN KEY (`itemID`) REFERENCES `tblClothes`(`itemID`) ON DELETE CASCADE,
                INDEX `idx_order` (`orderID`),
                INDEX `idx_item` (`itemID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblOrderItems</p>";
            
            // 6. tblMessages
            $sql = "CREATE TABLE IF NOT EXISTS `tblMessages` (
                `messageID` INT AUTO_INCREMENT PRIMARY KEY,
                `senderID` INT NOT NULL,
                `receiverID` INT NOT NULL,
                `itemID` INT NULL,
                `message` TEXT NOT NULL,
                `isRead` BOOLEAN DEFAULT FALSE,
                `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`senderID`) REFERENCES `tblUser`(`userID`) ON DELETE CASCADE,
                FOREIGN KEY (`receiverID`) REFERENCES `tblUser`(`userID`) ON DELETE CASCADE,
                FOREIGN KEY (`itemID`) REFERENCES `tblClothes`(`itemID`) ON DELETE SET NULL,
                INDEX `idx_conversation` (`senderID`, `receiverID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblMessages</p>";
            
            // 7. tblWishlist
            $sql = "CREATE TABLE IF NOT EXISTS `tblWishlist` (
                `wishlistID` INT AUTO_INCREMENT PRIMARY KEY,
                `userID` INT NOT NULL,
                `itemID` INT NOT NULL,
                `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`userID`) REFERENCES `tblUser`(`userID`) ON DELETE CASCADE,
                FOREIGN KEY (`itemID`) REFERENCES `tblClothes`(`itemID`) ON DELETE CASCADE,
                UNIQUE KEY `unique_wishlist` (`userID`, `itemID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
            echo "<p class='success'>✓ Created tblWishlist</p>";
            
            // ============================================
            // LOAD SAMPLE DATA
            // ============================================
            echo "<h2>📋 Step 3: Loading sample data</h2>";
            
            // Insert Users (10 users)
            $users = [
                ['John', 'Doe', 'john.doe', 'john.doe@example.com', password_hash('password123', PASSWORD_DEFAULT), 'buyer', 'active'],
                ['Jane', 'Smith', 'jane.smith', 'jane.smith@example.com', password_hash('password123', PASSWORD_DEFAULT), 'seller', 'active'],
                ['Sarah', 'Johnson', 'sarah.johnson', 'sarah.johnson@example.com', password_hash('password123', PASSWORD_DEFAULT), 'both', 'active'],
                ['Michael', 'Chen', 'michael.chen', 'michael.chen@example.com', password_hash('password123', PASSWORD_DEFAULT), 'buyer', 'active'],
                ['Emily', 'Wilson', 'emily.wilson', 'emily.wilson@example.com', password_hash('password123', PASSWORD_DEFAULT), 'seller', 'active'],
                ['David', 'Brown', 'david.brown', 'david.brown@example.com', password_hash('password123', PASSWORD_DEFAULT), 'buyer', 'active'],
                ['Lisa', 'Garcia', 'lisa.garcia', 'lisa.garcia@example.com', password_hash('password123', PASSWORD_DEFAULT), 'both', 'active'],
                ['James', 'Martinez', 'james.martinez', 'james.martinez@example.com', password_hash('password123', PASSWORD_DEFAULT), 'seller', 'active'],
                ['Maria', 'Rodriguez', 'maria.rodriguez', 'maria.rodriguez@example.com', password_hash('password123', PASSWORD_DEFAULT), 'buyer', 'active'],
                ['Robert', 'Lee', 'robert.lee', 'robert.lee@example.com', password_hash('password123', PASSWORD_DEFAULT), 'seller', 'active'],
            ];
            
            $stmt = $pdo->prepare("INSERT INTO tblUser (firstName, lastName, username, email, password, role, userStatus) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($users as $user) {
                $stmt->execute($user);
            }
            echo "<p class='success'>✓ Inserted " . count($users) . " users</p>";
            
            // Insert Admin
            $stmt = $pdo->prepare("INSERT INTO tblAdmin (username, email, password, fullName, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@pastes.com', password_hash('admin123', PASSWORD_DEFAULT), 'System Administrator', 'super']);
            echo "<p class='success'>✓ Inserted admin account (admin/admin123)</p>";
            
            // Insert Products
            $sellerIDs = $pdo->query("SELECT userID FROM tblUser WHERE role IN ('seller', 'both') LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
            
            $products = [
                ['Vintage Denim Jacket', 'women', 'jackets', 'M', "Levi's", 'excellent', 68.00, 'Beautiful vintage denim jacket from the 90s.', 'active', 234],
                ['Silk Blouse', 'women', 'tops', 'S', 'Zara', 'excellent', 45.00, 'Elegant silk blouse in cream color.', 'active', 189],
                ['Leather Ankle Boots', 'women', 'shoes', '38', 'Dr. Martens', 'good', 89.00, 'Genuine leather ankle boots.', 'active', 312],
                ['Wool Coat', 'women', 'outerwear', 'L', 'Mango', 'excellent', 120.00, 'Beautiful wool coat in camel color.', 'active', 156],
                ['Designer Handbag', 'accessories', 'bags', 'One Size', 'Coach', 'excellent', 199.00, 'Genuine leather handbag.', 'active', 278],
            ];
            
            $productStmt = $pdo->prepare("INSERT INTO tblClothes (sellerID, title, category, subcategory, size, brand, condition_status, price, description, status, views) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($products as $index => $product) {
                $sellerID = $sellerIDs[$index % count($sellerIDs)];
                $productStmt->execute(array_merge([$sellerID], $product));
            }
            echo "<p class='success'>✓ Inserted " . count($products) . " products</p>";
            
            // Insert Orders
            $buyerIDs = $pdo->query("SELECT userID FROM tblUser WHERE role IN ('buyer', 'both') LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
            
            $orders = [
                ['ORD-2024-0001', 68.00, '123 Main St', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered'],
                ['ORD-2024-0002', 45.00, '456 Oak Ave', 'Johannesburg', '2001', 'paypal', 'paid', 'shipped'],
                ['ORD-2024-0003', 89.00, '789 Pine Rd', 'Durban', '4001', 'credit_card', 'paid', 'delivered'],
                ['ORD-2024-0004', 120.00, '321 Elm St', 'Pretoria', '0001', 'paypal', 'paid', 'processing'],
                ['ORD-2024-0005', 199.00, '654 Maple Dr', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered'],
            ];
            
            $orderStmt = $pdo->prepare("INSERT INTO tblAorder (buyerID, orderNumber, totalAmount, shippingAddress, shippingCity, shippingPostal, paymentMethod, paymentStatus, orderStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($orders as $index => $order) {
                $buyerID = $buyerIDs[$index % count($buyerIDs)];
                $orderStmt->execute(array_merge([$buyerID], $order));
            }
            echo "<p class='success'>✓ Inserted " . count($orders) . " orders</p>";
            
            // ============================================
            // DISPLAY STATISTICS
            // ============================================
            echo "<h2>📊 Database Statistics</h2>";
            
            $tables = ['tblUser', 'tblAdmin', 'tblClothes', 'tblAorder', 'tblOrderItems', 'tblMessages', 'tblWishlist'];
            
            echo "<div class='stats-grid'>";
            foreach ($tables as $table) {
                $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
                echo "<div class='stat-card'>";
                echo "<div class='stat-number'>$count</div>";
                echo "<div>" . str_replace('tbl', '', $table) . "</div>";
                echo "</div>";
            }
            echo "</div>";
            
            echo "<p class='success'>✅ Database setup complete! All tables created and populated.</p>";
            
        } catch (PDOException $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        ?>
        
        <div style="margin-top: 30px;">
            <a href="index.php" class="button">🏠 Homepage</a>
            <a href="login.php" class="button button-secondary">🔐 Login</a>
            <a href="admin-dashboard.php" class="button button-secondary">👑 Admin Panel</a>
        </div>
        
        <div class="info" style="margin-top: 20px;">
            <strong>📝 Login Credentials:</strong><br>
            • Admin: username <code>admin</code> / password <code>admin123</code><br>
            • Test User: username <code>john.doe</code> / password <code>password123</code>
        </div>
    </div>
</body>
</html>
<?php
include 'DBConn.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Setup - PasTimes</title>
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; 
            background: #0a0a0f; 
            color: #fff; 
            padding: 40px; 
            margin: 0; 
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: #151520; 
            border-radius: 16px; 
            padding: 30px; 
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        h1 { 
            color: #00f5d4; 
            margin-bottom: 10px;
            font-size: 28px;
        }
        h2 {
            color: #fff;
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        h3 {
            color: #a0a0b0;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .success { 
            color: #06ffa5; 
            background: rgba(6,255,165,0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 3px solid #06ffa5;
        }
        .error { 
            color: #ff4757; 
            background: rgba(255,71,87,0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 3px solid #ff4757;
        }
        .info { 
            color: #ffb703; 
            background: rgba(255,183,3,0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 3px solid #ffb703;
        }
        pre { 
            background: #0a0a0f; 
            padding: 15px; 
            border-radius: 8px; 
            overflow-x: auto; 
            font-size: 12px;
            font-family: 'Courier New', monospace;
        }
        hr { 
            border-color: rgba(255,255,255,0.1); 
            margin: 20px 0; 
        }
        .table-list {
            background: #0a0a0f;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .table-list ul {
            margin: 10px 0 0 20px;
            color: #a0a0b0;
        }
        .table-list li {
            margin: 5px 0;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
        }
        .badge-success { background: #06ffa5; color: #0a0a0f; }
        .badge-info { background: #00f5d4; color: #0a0a0f; }
        .button {
            display: inline-block;
            background: #00f5d4;
            color: #0a0a0f;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,245,212,0.3);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            color: #6b6b7b;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔧 PasTimes Database Setup</h1>
    <p>Setting up your ClothingStore database...</p>
    <hr>";

try {
    // First, select the database
    $pdo->exec("USE clothing_stores");
    echo "<p class='info'>📁 Using database: ClothingStore</p>";

    // ============================================
    // 1. CREATE tblUser TABLE
    // ============================================
    echo "<h2>📋 Creating Tables</h2>";

    // Drop existing tables in correct order (foreign key constraints)
    $tablesToDrop = ['tblOrderItems', 'tblWishlist', 'tblMessages', 'tblAorder', 'tblClothes', 'tblAdmin', 'tblUser'];
    foreach ($tablesToDrop as $table) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            echo "<p class='info'>✓ Dropped existing $table table (if existed)</p>";
        } catch (PDOException $e) {
            // Ignore errors when dropping
        }
    }

    // Create tblUser
    $sql = "CREATE TABLE tblUser (
        userID INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(50) NOT NULL,
        lastName VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('buyer', 'seller', 'both') DEFAULT 'buyer',
        userStatus ENUM('active', 'inactive', 'banned') DEFAULT 'active',
        remember_token VARCHAR(255) NULL,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_username (username),
        INDEX idx_status (userStatus)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblUser table</p>";

    // ============================================
    // 2. CREATE tblAdmin TABLE
    // ============================================
    $sql = "CREATE TABLE tblAdmin (
        adminID INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        fullName VARCHAR(100) NOT NULL,
        role ENUM('super', 'moderator', 'support') DEFAULT 'moderator',
        lastLogin TIMESTAMP NULL,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_username (username),
        INDEX idx_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblAdmin table</p>";

    // Insert default admin
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO tblAdmin (username, email, password, fullName, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['admin', 'admin@pastes.com', $adminPassword, 'System Administrator', 'super']);
    echo "<p class='info'>👑 Added default admin account (username: admin, password: admin123)</p>";

    // ============================================
    // 3. CREATE tblClothes TABLE
    // ============================================
    $sql = "CREATE TABLE tblClothes (
        itemID INT AUTO_INCREMENT PRIMARY KEY,
        sellerID INT NOT NULL,
        title VARCHAR(200) NOT NULL,
        category VARCHAR(50) NOT NULL,
        subcategory VARCHAR(50),
        size VARCHAR(10),
        brand VARCHAR(100),
        condition_status ENUM('new', 'excellent', 'good', 'fair') DEFAULT 'good',
        price DECIMAL(10,2) NOT NULL,
        description TEXT,
        images TEXT,
        shipping VARCHAR(20) DEFAULT 'buyer',
        status ENUM('pending', 'active', 'sold', 'inactive') DEFAULT 'pending',
        views INT DEFAULT 0,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (sellerID) REFERENCES tblUser(userID) ON DELETE CASCADE,
        INDEX idx_seller (sellerID),
        INDEX idx_category (category),
        INDEX idx_status (status),
        INDEX idx_price (price),
        INDEX idx_created (createdAt)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblClothes table</p>";

    // ============================================
    // 4. CREATE tblAorder TABLE
    // ============================================
    $sql = "CREATE TABLE tblAorder (
        orderID INT AUTO_INCREMENT PRIMARY KEY,
        buyerID INT NOT NULL,
        orderNumber VARCHAR(50) NOT NULL UNIQUE,
        totalAmount DECIMAL(10,2) NOT NULL,
        shippingAddress TEXT NOT NULL,
        shippingCity VARCHAR(100),
        shippingPostal VARCHAR(20),
        paymentMethod VARCHAR(50) NOT NULL,
        paymentStatus ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
        orderStatus ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        trackingNumber VARCHAR(100),
        notes TEXT,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (buyerID) REFERENCES tblUser(userID) ON DELETE CASCADE,
        INDEX idx_buyer (buyerID),
        INDEX idx_order_status (orderStatus),
        INDEX idx_payment_status (paymentStatus),
        INDEX idx_order_number (orderNumber)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblAorder table</p>";

    // ============================================
    // 5. CREATE tblOrderItems TABLE
    // ============================================
    $sql = "CREATE TABLE tblOrderItems (
        orderItemID INT AUTO_INCREMENT PRIMARY KEY,
        orderID INT NOT NULL,
        itemID INT NOT NULL,
        quantity INT DEFAULT 1,
        priceAtTime DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (orderID) REFERENCES tblAorder(orderID) ON DELETE CASCADE,
        FOREIGN KEY (itemID) REFERENCES tblClothes(itemID) ON DELETE CASCADE,
        INDEX idx_order (orderID),
        INDEX idx_item (itemID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblOrderItems table</p>";

    // ============================================
    // 6. CREATE tblMessages TABLE
    // ============================================
    $sql = "CREATE TABLE tblMessages (
        messageID INT AUTO_INCREMENT PRIMARY KEY,
        senderID INT NOT NULL,
        receiverID INT NOT NULL,
        itemID INT NULL,
        message TEXT NOT NULL,
        isRead BOOLEAN DEFAULT FALSE,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (senderID) REFERENCES tblUser(userID) ON DELETE CASCADE,
        FOREIGN KEY (receiverID) REFERENCES tblUser(userID) ON DELETE CASCADE,
        FOREIGN KEY (itemID) REFERENCES tblClothes(itemID) ON DELETE SET NULL,
        INDEX idx_conversation (senderID, receiverID),
        INDEX idx_read_status (isRead),
        INDEX idx_created (createdAt)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblMessages table</p>";

    // ============================================
    // 7. CREATE tblWishlist TABLE
    // ============================================
    $sql = "CREATE TABLE tblWishlist (
        wishlistID INT AUTO_INCREMENT PRIMARY KEY,
        userID INT NOT NULL,
        itemID INT NOT NULL,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (userID) REFERENCES tblUser(userID) ON DELETE CASCADE,
        FOREIGN KEY (itemID) REFERENCES tblClothes(itemID) ON DELETE CASCADE,
        UNIQUE KEY unique_wishlist (userID, itemID),
        INDEX idx_user (userID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($sql);
    echo "<p class='success'>✅ Created tblWishlist table</p>";

    // ============================================
    // LOAD DATA FROM userData.txt
    // ============================================
    echo "<hr>";
    echo "<h2>📝 Loading User Data</h2>";

    $dataFile = 'userData.txt';

    if (file_exists($dataFile)) {
        // Read the file line by line
        $lines = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($lines as $line) {
            // Parse line: firstName lastName email password role
            $parts = preg_split('/\s+/', $line);
            if (count($parts) >= 5) {
                $firstName = $parts[0];
                $lastName = $parts[1];
                $email = $parts[2];
                $password = $parts[3]; // Already hashed
                $role = $parts[4];

                // Generate username from firstname.lastname
                $username = strtolower($firstName . '.' . $lastName);

                // Check if user already exists
                $checkStmt = $pdo->prepare("SELECT userID FROM tblUser WHERE email = ? OR username = ?");
                $checkStmt->execute([$email, $username]);

                if ($checkStmt->rowCount() == 0) {
                    $stmt = $pdo->prepare("INSERT INTO tblUser (firstName, lastName, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$firstName, $lastName, $username, $email, $password, $role]);
                    $insertedCount++;
                } else {
                    $skippedCount++;
                }
            } elseif (count($parts) >= 4) {
                // Fallback: firstName lastName email password (default role buyer)
                $firstName = $parts[0];
                $lastName = $parts[1];
                $email = $parts[2];
                $password = $parts[3];
                $username = strtolower($firstName . '.' . $lastName);
                $role = 'buyer';

                $checkStmt = $pdo->prepare("SELECT userID FROM tblUser WHERE email = ? OR username = ?");
                $checkStmt->execute([$email, $username]);

                if ($checkStmt->rowCount() == 0) {
                    $stmt = $pdo->prepare("INSERT INTO tblUser (firstName, lastName, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$firstName, $lastName, $username, $email, $password, $role]);
                    $insertedCount++;
                } else {
                    $skippedCount++;
                }
            }
        }

        if ($insertedCount > 0) {
            echo "<p class='success'>✅ Loaded $insertedCount new users from userData.txt</p>";
        }
        if ($skippedCount > 0) {
            echo "<p class='info'>⚠️ Skipped $skippedCount duplicate users (already exist)</p>";
        }
        if ($insertedCount == 0 && $skippedCount == 0) {
            echo "<p class='info'>📄 userData.txt exists but no valid user entries found</p>";
        }
    } else {
        echo "<p class='error'>❌ userData.txt not found! Creating sample file...</p>";

        // Create sample userData.txt file
        $sampleData = [
            "John Doe j.doe@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi buyer",
            "Jane Smith j.smith@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi seller",
            "Sarah Johnson s.johnson@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi both",
            "Michael Chen m.chen@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi buyer",
            "Emily Wilson e.wilson@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi seller"
        ];

        file_put_contents($dataFile, implode("\n", $sampleData));
        echo "<p class='success'>✅ Created sample userData.txt with 5 test users</p>";

        // Now load them
        $stmt = $pdo->prepare("INSERT INTO tblUser (firstName, lastName, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($sampleData as $line) {
            $parts = explode(' ', $line);
            if (count($parts) >= 5) {
                $firstName = $parts[0];
                $lastName = $parts[1];
                $email = $parts[2];
                $password = $parts[3];
                $role = $parts[4];
                $username = strtolower($firstName . '.' . $lastName);

                $stmt->execute([$firstName, $lastName, $username, $email, $password, $role]);
            }
        }
        echo "<p class='success'>✅ Loaded " . count($sampleData) . " users into database</p>";
    }

    // ============================================
    // ADD SAMPLE PRODUCT DATA
    // ============================================
    echo "<hr>";
    echo "<h2>🛍️ Adding Sample Products</h2>";

    // Get first seller ID
    $sellerStmt = $pdo->query("SELECT userID FROM tblUser WHERE role IN ('seller', 'both') LIMIT 1");
    $seller = $sellerStmt->fetch();
    $sellerID = $seller ? $seller['userID'] : 1;

    $sampleProducts = [
        [
            'title' => 'Vintage Denim Jacket',
            'category' => 'women',
            'subcategory' => 'jackets',
            'size' => 'M',
            'brand' => "Levi's",
            'condition' => 'excellent',
            'price' => 68.00,
            'description' => 'Beautiful vintage denim jacket from the 90s. Excellent condition with natural fading. Perfect for any casual outfit.',
            'status' => 'active'
        ],
        [
            'title' => 'Silk Blouse',
            'category' => 'women',
            'subcategory' => 'tops',
            'size' => 'S',
            'brand' => 'Zara',
            'condition' => 'excellent',
            'price' => 45.00,
            'description' => 'Elegant silk blouse in cream color. Worn only twice. Perfect for office or special occasions.',
            'status' => 'active'
        ],
        [
            'title' => 'Leather Ankle Boots',
            'category' => 'women',
            'subcategory' => 'shoes',
            'size' => '38',
            'brand' => 'Dr. Martens',
            'condition' => 'good',
            'price' => 89.00,
            'description' => 'Genuine leather ankle boots. Some signs of wear but plenty of life left. Very comfortable!',
            'status' => 'active'
        ],
        [
            'title' => 'Wool Coat',
            'category' => 'women',
            'subcategory' => 'outerwear',
            'size' => 'L',
            'brand' => 'Mango',
            'condition' => 'excellent',
            'price' => 120.00,
            'description' => 'Beautiful wool coat in camel color. Perfect for winter. Like new condition.',
            'status' => 'active'
        ]
    ];

    $insertedProducts = 0;
    foreach ($sampleProducts as $product) {
        $stmt = $pdo->prepare("INSERT INTO tblClothes (sellerID, title, category, subcategory, size, brand, condition_status, price, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $sellerID,
            $product['title'],
            $product['category'],
            $product['subcategory'],
            $product['size'],
            $product['brand'],
            $product['condition'],
            $product['price'],
            $product['description'],
            $product['status']
        ]);
        $insertedProducts++;
    }

    echo "<p class='success'>✅ Added $insertedProducts sample products to tblClothes</p>";

    // ============================================
    // SUMMARY
    // ============================================
    echo "<hr>";
    echo "<h2>✅ Database Setup Complete!</h2>";

    // Get table counts
    $tables = ['tblUser', 'tblAdmin', 'tblClothes', 'tblAorder', 'tblOrderItems', 'tblMessages', 'tblWishlist'];
    echo "<div class='table-list'>";
    echo "<h3>📊 Table Statistics:</h3>";
    echo "<ul>";
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "<li><strong>$table</strong>: $count records</li>";
    }
    echo "</ul>";
    echo "</div>";

    // Get user count by role
    $roleStats = $pdo->query("SELECT role, COUNT(*) as count FROM tblUser GROUP BY role")->fetchAll();
    if ($roleStats) {
        echo "<div class='table-list'>";
        echo "<h3>👥 User Statistics:</h3>";
        echo "<ul>";
        foreach ($roleStats as $stat) {
            echo "<li><strong>" . ucfirst($stat['role']) . "</strong>: " . $stat['count'] . " users</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "<p class='error'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='info'>💡 Troubleshooting tips:</p>";
    echo "<ul style='color: #a0a0b0; margin-left: 20px;'>";
    echo "<li>Make sure MySQL is running (XAMPP/WAMP/MAMP)</li>";
    echo "<li>Check database credentials in DBConn.php</li>";
    echo "<li>Verify the database 'ClothingStore' exists in phpMyAdmin</li>";
    echo "<li>Make sure you have proper MySQL privileges</li>";
    echo "</ul>";
}
?>

<hr>

<div style="background: #0a0a0f; padding: 20px; border-radius: 12px; margin: 20px 0;">
    <h3>🔑 Login Credentials</h3>
    <p><strong>Admin Access:</strong></p>
    <ul style="color: #a0a0b0; margin-bottom: 15px;">
        <li>Username: <code style="background: #1a1a25; padding: 2px 6px; border-radius: 4px;">admin</code></li>
        <li>Password: <code style="background: #1a1a25; padding: 2px 6px; border-radius: 4px;">admin123</code></li>
    </ul>
    <p><strong>Test User Accounts (from userData.txt):</strong></p>
    <ul style="color: #a0a0b0;">
        <li>Username: <code>john.doe</code> / Password: <code>password123</code> (Buyer)</li>
        <li>Username: <code>jane.smith</code> / Password: <code>password123</code> (Seller)</li>
        <li>Username: <code>sarah.johnson</code> / Password: <code>password123</code> (Both)</li>
    </ul>
</div>

<div style="text-align: center;">
    <a href="index.php" class="button">🏠 Go to Homepage</a>
    <a href="login.php" class="button" style="background: #1a1a25; color: #00f5d4; margin-left: 10px;">🔐 Go to Login</a>
    <a href="register.php" class="button" style="background: #1a1a25; color: #00f5d4; margin-left: 10px;">📝 Create Account</a>
</div>

<div class="footer">
    <p>PasTimes - Secondhand Fashion Marketplace</p>
    <p>Database: ClothingStore | Tables: 7 | Status: Active</p>
</div>
</div>
</body>

</html>
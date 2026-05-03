<?php
/**
 * createTable.php
 * Creates tblUser table only, loads data from userData.txt
 * Each execution drops and recreates the table
 */

// Include database connection
require_once 'DBConn.php';

// Function to load users from text file
function loadUsersFromFile($filename) {
    $users = [];
    if (!file_exists($filename)) {
        return $users;
    }
    
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Parse line: firstName lastName email password role
        $parts = preg_split('/\s+/', $line);
        if (count($parts) >= 5) {
            $users[] = [
                'firstName' => $parts[0],
                'lastName' => $parts[1],
                'email' => $parts[2],
                'password' => $parts[3],
                'role' => $parts[4]
            ];
        }
    }
    return $users;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User Table - PasTimes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0a0f;
            color: #fff;
            padding: 40px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #151520;
            border-radius: 16px;
            padding: 30px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        h1 { color: #00f5d4; margin-bottom: 20px; }
        .success { color: #06ffa5; background: rgba(6,255,165,0.1); padding: 10px; border-radius: 8px; margin: 10px 0; }
        .error { color: #ff4757; background: rgba(255,71,87,0.1); padding: 10px; border-radius: 8px; margin: 10px 0; }
        .info { color: #ffb703; background: rgba(255,183,3,0.1); padding: 10px; border-radius: 8px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { color: #00f5d4; }
        .button { display: inline-block; background: #00f5d4; color: #0a0a0f; padding: 10px 20px; border-radius: 8px; text-decoration: none; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 tblUser Table Setup</h1>
        
        <?php
        try {
            // Step 1: Drop table if exists
            $pdo->exec("DROP TABLE IF EXISTS `tblUser`");
            echo "<p class='success'>✓ Dropped existing tblUser table</p>";
            
            // Step 2: Create tblUser table
            $sql = "CREATE TABLE `tblUser` (
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
            echo "<p class='success'>✓ Created tblUser table</p>";
            
            // Step 3: Load data from userData.txt
            $userDataFile = 'userData.txt';
            $users = loadUsersFromFile($userDataFile);
            
            if (empty($users)) {
                // Create sample userData.txt if it doesn't exist
                $sampleData = [
                    "John Doe john.doe@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi buyer",
                    "Jane Smith jane.smith@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi seller",
                    "Sarah Johnson sarah.johnson@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi both",
                    "Michael Chen michael.chen@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi buyer",
                    "Emily Wilson emily.wilson@example.com \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi seller"
                ];
                file_put_contents($userDataFile, implode("\n", $sampleData));
                $users = loadUsersFromFile($userDataFile);
                echo "<p class='info'>✓ Created sample userData.txt with 5 entries</p>";
            }
            
            // Insert users
            $stmt = $pdo->prepare("INSERT INTO tblUser (firstName, lastName, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $inserted = 0;
            
            foreach ($users as $user) {
                $username = strtolower($user['firstName'] . '.' . $user['lastName']);
                $stmt->execute([
                    $user['firstName'],
                    $user['lastName'],
                    $username,
                    $user['email'],
                    $user['password'],
                    $user['role']
                ]);
                $inserted++;
            }
            
            echo "<p class='success'>✓ Loaded $inserted users from userData.txt</p>";
            
            // Step 4: Display users
            $allUsers = $pdo->query("SELECT userID, firstName, lastName, username, email, role, userStatus, createdAt FROM tblUser ORDER BY userID")->fetchAll();
            
            echo "<h2>📊 Current Users in tblUser (" . count($allUsers) . " records)</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th></tr>";
            foreach ($allUsers as $user) {
                echo "<tr>";
                echo "<td>{$user['userID']}</td>";
                echo "<td>{$user['firstName']}</td>";
                echo "<td>{$user['lastName']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "<td>{$user['userStatus']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } catch (PDOException $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        ?>
        
        <a href="index.php" class="button">🏠 Go to Homepage</a>
        <a href="login.php" class="button" style="background: #1a1a25; color: #00f5d4; margin-left: 10px;">🔐 Login</a>
    </div>
</body>
</html>
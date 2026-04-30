<?php
// createTable.php - Creates tblUser table and loads data from userData.txt
// This works alongside your existing Users table without affecting it

require_once 'DBConn.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Create Table - tblUser</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #0a0a0f;
            color: #ffffff;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #12121a;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        h1, h2 {
            color: #00f5d4;
        }
        .success {
            color: #06ffa5;
            background: rgba(6,255,165,0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .error {
            color: #ff4757;
            background: rgba(255,71,87,0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .info {
            color: #00bbf9;
            background: rgba(0,187,249,0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px;
            text-align: left;
        }
        th {
            background: #1a1a25;
            color: #00f5d4;
        }
        hr {
            border-color: rgba(255,255,255,0.1);
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: #00f5d4;
            color: #0a0a0f;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class='container'>";

echo "<h1>🔧 PasTimes - Database Setup Script</h1>";
echo "<hr>";

// Create database connection
$database = new DBConn();
$conn = $database->getConnection();

// Function to check if table exists
function tableExists($conn, $tableName) {
    try {
        $stmt = $conn->prepare("SHOW TABLES LIKE :table");
        $stmt->bindParam(':table', $tableName);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch(PDOException $e) {
        return false;
    }
}

// Function to drop table if exists
function dropTable($conn, $tableName) {
    try {
        $conn->exec("DROP TABLE IF EXISTS `$tableName`");
        echo "<div class='success'>🗑️ Table '$tableName' dropped successfully</div>";
        return true;
    } catch(PDOException $e) {
        echo "<div class='error'>❌ Error dropping table: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Function to create tblUser table
function createTable($conn) {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS tblUser (
            UserID INT PRIMARY KEY AUTO_INCREMENT,
            FullName VARCHAR(100) NOT NULL,
            Email VARCHAR(100) UNIQUE NOT NULL,
            Password VARCHAR(255) NOT NULL,
            CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_email (Email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        $conn->exec($sql);
        echo "<div class='success'>✅ Table 'tblUser' created successfully</div>";
        return true;
        
    } catch(PDOException $e) {
        echo "<div class='error'>❌ Error creating table: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Function to load data from text file
function loadDataFromFile($conn, $filename) {
    try {
        // Check if file exists
        if (!file_exists($filename)) {
            echo "<div class='error'>❌ File '$filename' not found in current directory!</div>";
            echo "<div class='info'>📁 Current directory: " . __DIR__ . "</div>";
            return false;
        }
        
        // Read the file
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        if (empty($lines)) {
            echo "<div class='error'>❌ No data found in file!</div>";
            return false;
        }
        
        echo "<div class='info'>📄 Found " . count($lines) . " lines in userData.txt</div>";
        
        // Prepare SQL statement for insertion
        $sql = "INSERT INTO tblUser (FullName, Email, Password) VALUES (:fullname, :email, :password)";
        $stmt = $conn->prepare($sql);
        
        $insertedCount = 0;
        $errorCount = 0;
        $errors = [];
        
        // Process each line
        foreach ($lines as $lineNum => $line) {
            // Split by pipe delimiter
            $data = explode('|', $line);
            
            if (count($data) == 3) {
                $fullname = trim($data[0]);
                $email = trim($data[1]);
                $password = trim($data[2]);
                
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Line " . ($lineNum + 1) . ": Invalid email format - $email";
                    $errorCount++;
                    continue;
                }
                
                // Insert into database
                $stmt->bindParam(':fullname', $fullname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                
                if ($stmt->execute()) {
                    $insertedCount++;
                    echo "<div class='success'>✅ Inserted: $fullname ($email)</div>";
                } else {
                    $errors[] = "Line " . ($lineNum + 1) . ": Failed to insert $fullname";
                    $errorCount++;
                }
            } else {
                $errors[] = "Line " . ($lineNum + 1) . ": Invalid format - $line";
                $errorCount++;
            }
        }
        
        echo "<hr>";
        echo "<h2>📊 Data Loading Summary</h2>";
        echo "<div class='success'>✅ Successfully inserted: $insertedCount records</div>";
        
        if ($errorCount > 0) {
            echo "<div class='error'>⚠️ Failed/Skipped: $errorCount records</div>";
            if (!empty($errors)) {
                echo "<div class='info'>📝 Error details:<br>";
                foreach ($errors as $error) {
                    echo "&nbsp;&nbsp;• " . htmlspecialchars($error) . "<br>";
                }
                echo "</div>";
            }
        }
        
        return $insertedCount > 0;
        
    } catch(PDOException $e) {
        echo "<div class='error'>❌ Error loading data: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Function to verify and display table data
function verifyTableData($conn) {
    try {
        $sql = "SELECT COUNT(*) as total FROM tblUser";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<hr>";
        echo "<h2>📋 Table Verification</h2>";
        echo "<div class='success'>📊 Table 'tblUser' contains " . $result['total'] . " records</div>";
        
        // Display all data
        if ($result['total'] > 0) {
            echo "<h3>📋 All Records in tblUser:</h3>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>UserID</th>";
            echo "<th>Full Name</th>";
            echo "<th>Email</th>";
            echo "<th>Password (MD5)</th>";
            echo "<th>Created At</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            $sql = "SELECT UserID, FullName, Email, Password, CreatedAt FROM tblUser ORDER BY UserID";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . htmlspecialchars($row['FullName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                echo "<td><code>" . $row['Password'] . "</code></td>";
                echo "<td>" . $row['CreatedAt'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        
    } catch(PDOException $e) {
        echo "<div class='error'>❌ Error verifying data: " . $e->getMessage() . "</div>";
    }
}

// Check existing tables
echo "<h2>📊 Existing Tables in Database</h2>";
$stmt = $conn->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo "<div class='info'>";
foreach ($tables as $table) {
    if ($table == 'tblUser') {
        echo "🟢 Table: <strong>$table</strong> (will be recreated)<br>";
    } elseif ($table == 'Users') {
        echo "🔵 Table: <strong>$table</strong> (your existing Users table - will NOT be affected)<br>";
    } else {
        echo "⚪ Table: $table<br>";
    }
}
echo "</div>";
echo "<hr>";

// Check if tblUser exists
if (tableExists($conn, 'tblUser')) {
    echo "<div class='info'>⚠️ Table 'tblUser' exists. Dropping and recreating...<br>";
    dropTable($conn, 'tblUser');
} else {
    echo "<div class='info'>ℹ️ Table 'tblUser' does not exist. Creating new table...<br>";
}

// Create the table
if (createTable($conn)) {
    // Load data from text file
    echo "<hr>";
    echo "<h2>📂 Loading Data from userData.txt</h2>";
    
    if (loadDataFromFile($conn, 'userData.txt')) {
        // Verify the data
        verifyTableData($conn);
        
        echo "<hr>";
        echo "<div class='success'>✅ <strong>SUCCESS!</strong> Table 'tblUser' has been created and populated with data!</div>";
        echo "<div class='info'>💡 Note: Your existing 'Users' table was NOT affected. It still contains your registration data.</div>";
    } else {
        echo "<hr>";
        echo "<div class='error'>⚠️ Table created but data loading failed. Please check userData.txt file.</div>";
    }
} else {
    echo "<div class='error'>❌ Failed to create table. Please check your database connection.</div>";
}

// Display comparison between tables
echo "<hr>";
echo "<h2>📊 Database Status</h2>";

// Check Users table
$stmt = $conn->query("SELECT COUNT(*) as count FROM Users");
$usersCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Check tblUser table
$stmt = $conn->query("SELECT COUNT(*) as count FROM tblUser");
$tblUserCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

echo "<table>";
echo "<tr><th>Table Name</th><th>Record Count</th><th>Purpose</th></tr>";
echo "<tr>";
echo "<td><strong>Users</strong></td>";
echo "<td>$usersCount records</td>";
echo "<td>Your main application table (registration, login) - NOT affected</td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>tblUser</strong></td>";
echo "<td>$tblUserCount records</td>";
echo "<td>Assignment requirement table - Created by this script</td>";
echo "</tr>";
echo "</table>";

echo "<hr>";
echo "<div class='info'>";
echo "<h3>📝 How to use this script:</h3>";
echo "<ul>";
echo "<li>Run this script anytime to reset the tblUser table</li>";
echo "<li>Edit <strong>userData.txt</strong> to modify the user data</li>";
echo "<li>Each line format: <code>FullName|Email|PasswordHash</code></li>";
echo "<li>Your existing <strong>Users</strong> table and application data remains intact</li>";
echo "<li>To verify: Check phpMyAdmin - both 'Users' and 'tblUser' tables exist separately</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<a href='index.php' class='button'>← Back to Homepage</a>";
echo "&nbsp;&nbsp;&nbsp;";
echo "<a href='test_tblUser.php' class='button'>🔍 Test tblUser Table</a>";

echo "</div></body></html>";
?>
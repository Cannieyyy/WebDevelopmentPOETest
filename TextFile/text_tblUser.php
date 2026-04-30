<?php
// test_tblUser.php - Test script to verify tblUser table
require_once 'DBConn.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Test tblUser Table</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #0a0a0f;
            color: #ffffff;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #12121a;
            padding: 30px;
            border-radius: 12px;
        }
        .success { color: #06ffa5; }
        .error { color: #ff4757; }
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
        th { background: #1a1a25; color: #00f5d4; }
    </style>
</head>
<body>
<div class='container'>";

$database = new DBConn();
$conn = $database->getConnection();

echo "<h1>🔍 Testing tblUser Table</h1>";
echo "<hr>";

try {
    // Check if table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'tblUser'");
    if ($stmt->rowCount() == 0) {
        echo "<div class='error'>❌ Table 'tblUser' does not exist. Run createTable.php first.</div>";
    } else {
        echo "<div class='success'>✅ Table 'tblUser' exists.</div>";
        
        // Get total count
        $stmt = $conn->query("SELECT COUNT(*) as total FROM tblUser");
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<div class='success'>📊 Total records: " . $total['total'] . "</div>";
        
        // Display all users
        $stmt = $conn->query("SELECT * FROM tblUser ORDER BY UserID");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            echo "<h2>📋 All Users in tblUser:</h2>";
            echo "<table>";
            echo "<tr><th>UserID</th><th>Full Name</th><th>Email</th><th>Password (MD5)</th><th>Created At</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['UserID']}</td>";
                echo "<td>" . htmlspecialchars($user['FullName']) . "</td>";
                echo "<td>" . htmlspecialchars($user['Email']) . "</td>";
                echo "<td><code>{$user['Password']}</code></td>";
                echo "<td>{$user['CreatedAt']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
} catch(PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<a href='createTable.php' style='color: #00f5d4;'>← Back to createTable.php</a>";

echo "</div></body></html>";
?>
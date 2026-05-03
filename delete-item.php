<?php
session_start();
require_once 'DBConn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userID']) || !isset($_SESSION['logged_in'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $itemID = intval($_POST['itemID']);
    $userID = $_SESSION['userID'];
    
    try {
        // Verify item belongs to this seller
        $stmt = $pdo->prepare("SELECT sellerID FROM tblClothes WHERE itemID = ?");
        $stmt->execute([$itemID]);
        $item = $stmt->fetch();
        
        if (!$item || $item['sellerID'] != $userID) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit();
        }
        
        // Delete the item
        $stmt = $pdo->prepare("DELETE FROM tblClothes WHERE itemID = ?");
        $stmt->execute([$itemID]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
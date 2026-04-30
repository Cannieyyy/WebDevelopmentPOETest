<?php
// login_handler.php
require_once 'includes/User.php';
require_once 'includes/auth.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $response['message'] = 'Please enter username/email and password';
    echo json_encode($response);
    exit;
}

$user = new User();

if ($user->login($username, $password)) {
    $response['success'] = true;
    $response['message'] = 'Login successful! Redirecting...';
    
    // Redirect based on role
    if (isAdmin()) {
        $response['redirect'] = 'admin-dashboard.php';
    } elseif (isSeller()) {
        $response['redirect'] = 'seller-dashboard.php';
    } else {
        $response['redirect'] = 'browse.php';  // Buyers go to browse page
    }
} else {
    $response['message'] = 'Invalid username/email or password';
}

echo json_encode($response);
?>
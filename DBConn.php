<?php
// Database configuration
$host = 'localhost';
$dbname = 'clothing_stores';
$username = 'root';
$password = '';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Session helper functions
function isLoggedIn()
{
    return isset($_SESSION['userID']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function isAdmin()
{
    return isLoggedIn() && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true;
}

function isSeller()
{
    return isLoggedIn() && (isset($_SESSION['role']) && ($_SESSION['role'] === 'seller' || $_SESSION['role'] === 'both'));
}

function getCurrentUser()
{
    if (!isLoggedIn()) return null;
    return [
        'userID' => $_SESSION['userID'],
        'username' => $_SESSION['username'],
        'firstName' => $_SESSION['firstName'],
        'lastName' => $_SESSION['lastName'],
        'email' => $_SESSION['email'],
        'role' => $_SESSION['role']
    ];
}

function logout()
{
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }
    session_destroy();
}

function requireLogin()
{
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit();
    }
}

function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.php');
        exit();
    }
}

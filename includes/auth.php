<?php
// includes/auth.php - Authentication and authorization helpers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user has specific role
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

// Check if user is buyer
function isBuyer() {
    return hasRole('buyer');
}

// Check if user is seller
function isSeller() {
    return hasRole('seller');
}

// Check if user is admin
function isAdmin() {
    return hasRole('admin');
}

// Require login - redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
}

// Require specific role - redirect if not authorized
function requireRole($role) {
    requireLogin();
    if (!hasRole($role) && !isAdmin()) {
        header("Location: index.php?error=unauthorized");
        exit();
    }
}

// Get user's landing page based on role
function getUserLandingPage() {
    if (!isLoggedIn()) {
        return 'login.php';
    }
    
    switch ($_SESSION['role']) {
        case 'admin':
            return 'admin-dashboard.php';
        case 'seller':
            return 'seller-dashboard.php';
        case 'buyer':
        default:
            return 'browse.php';  // Buyers go to browse page
    }
}

// Get current user info
function getCurrentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'email' => $_SESSION['email'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'firstname' => $_SESSION['firstname'] ?? null,
        'lastname' => $_SESSION['lastname'] ?? null,
        'storename' => $_SESSION['storename'] ?? null,
        'is_verified' => $_SESSION['is_verified'] ?? false
    ];
}

// Logout function
function logout() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    session_destroy();
}
?>
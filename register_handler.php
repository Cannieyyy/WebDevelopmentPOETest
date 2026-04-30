<?php
// register_handler.php
require_once 'includes/User.php';
require_once 'includes/auth.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Validate required fields
$required_fields = ['firstName', 'lastName', 'email', 'regUsername', 'regPassword', 'confirmPassword', 'role'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $response['message'] = "Missing required field: $field";
        echo json_encode($response);
        exit;
    }
}

// Get form data
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$email = trim($_POST['email']);
$username = trim($_POST['regUsername']);
$password = $_POST['regPassword'];
$confirmPassword = $_POST['confirmPassword'];
$role = $_POST['role'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Invalid email format';
    echo json_encode($response);
    exit;
}

// Validate password length
if (strlen($password) < 8) {
    $response['message'] = 'Password must be at least 8 characters long';
    echo json_encode($response);
    exit;
}

// Validate password match
if ($password !== $confirmPassword) {
    $response['message'] = 'Passwords do not match';
    echo json_encode($response);
    exit;
}

// Validate password strength
if (!preg_match('/\d/', $password)) {
    $response['message'] = 'Password must contain at least one number';
    echo json_encode($response);
    exit;
}

if (!preg_match('/[!@#$%^&*]/', $password)) {
    $response['message'] = 'Password must contain at least one special character (!@#$%^&*)';
    echo json_encode($response);
    exit;
}

// Validate role
if (!in_array($role, ['buyer', 'seller', 'both'])) {
    $response['message'] = 'Invalid role selected';
    echo json_encode($response);
    exit;
}

// Convert 'both' to appropriate role
$finalRole = $role;
if ($role === 'both') {
    $finalRole = 'seller'; // Let them be seller since they want both
}

// Create User object
$user = new User();

// Check if username exists
if ($user->usernameExists($username)) {
    $response['message'] = 'Username already taken';
    echo json_encode($response);
    exit;
}

// Check if email exists
if ($user->emailExists($email)) {
    $response['message'] = 'Email already registered';
    echo json_encode($response);
    exit;
}

// Prepare user data
$user->Username = $username;
$user->Email = $email;
$user->Password = $password;
$user->FirstName = $firstName;
$user->LastName = $lastName;
$user->Role = $finalRole;
$user->StoreName = ($finalRole === 'seller') ? $username . "'s Store" : null;

// Attempt registration
if ($user->register()) {
    // Auto-login after registration
    if ($user->login($username, $password)) {
        $response['success'] = true;
        $response['message'] = 'Registration successful! Redirecting...';
        
        // Redirect based on role
        if (isAdmin()) {
            $response['redirect'] = 'admin-dashboard.php';
        } elseif (isSeller()) {
            $response['redirect'] = 'seller-dashboard.php';
        } else {
            $response['redirect'] = 'browse.php';  // Buyers go to browse page
        }
    } else {
        $response['success'] = true;
        $response['message'] = 'Registration successful! Please login.';
        $response['redirect'] = 'login.php';
    }
} else {
    $response['message'] = 'Registration failed. Please try again.';
}

echo json_encode($response);
?>
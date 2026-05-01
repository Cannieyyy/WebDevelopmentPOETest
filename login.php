<?php
session_start();
require_once 'DBConn.php';

$error = '';
$success = '';

// If user is already logged in, redirect to homepage
if (isset($_SESSION['userID'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']) ? true : false;

    // Validation
    if (empty($username)) {
        $error = 'Please enter your username or email address.';
    } elseif (empty($password)) {
        $error = 'Please enter your password.';
    } else {
        try {
            // Check if login is with username or email
            $stmt = $pdo->prepare("SELECT * FROM tblUser WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Check if user is active
                    if ($user['userStatus'] !== 'active') {
                        $error = 'Your account is ' . $user['userStatus'] . '. Please contact support.';
                    } else {
                        // Store user info in session
                        $_SESSION['userID'] = $user['userID'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['firstName'] = $user['firstName'];
                        $_SESSION['lastName'] = $user['lastName'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['role'] = $user['role']; // This is important for role checking
                        $_SESSION['logged_in'] = true;

                        // Check if admin
                        $adminStmt = $pdo->prepare("SELECT * FROM tblAdmin WHERE username = ? OR email = ?");
                        $adminStmt->execute([$user['username'], $user['email']]);
                        if ($adminStmt->fetch()) {
                            $_SESSION['isAdmin'] = true;
                        }

                        // Redirect based on role (optional)
                        if ($user['role'] == 'seller' || $user['role'] == 'both') {
                            header('Location: seller-dashboard.php');
                        } else {
                            header('Location: index.php');
                        }
                        exit();
                    }
                } else {
                    $error = 'Invalid password. Please try again.';
                }
            } else {
                $error = 'No account found with that username or email address.';
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $error = 'Login failed. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .error-message {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.3);
            color: #ff4757;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .input-wrapper .form-input {
            padding-left: 48px;
            padding-right: 48px;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: var(--accent-primary);
        }

        .custom-checkbox {
            display: none;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .checkmark {
            width: 20px;
            height: 20px;
            border: 2px solid var(--bg-tertiary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            background: var(--bg-tertiary);
        }

        .custom-checkbox:checked+.checkmark {
            background: var(--accent-primary);
            border-color: var(--accent-primary);
        }

        .custom-checkbox:checked+.checkmark svg {
            opacity: 1;
        }

        .checkmark svg {
            opacity: 0;
            width: 12px;
            height: 12px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .link {
            color: var(--accent-primary);
            text-decoration: none;
            font-size: 14px;
        }

        .link:hover {
            text-decoration: underline;
        }

        .link-bold {
            color: var(--accent-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .link-bold:hover {
            text-decoration: underline;
        }

        .auth-submit {
            width: 100%;
            margin-top: 20px;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auth-divider span {
            margin: 0 16px;
        }

        .social-auth {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .btn-social {
            background: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            padding: 12px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-social:hover {
            background: var(--bg-hover);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 32px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--accent-primary);
        }
    </style>
</head>

<body class="auth-page">

    <nav class="navbar auth-navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span class="logo-icon">◆</span>
                <span class="logo-text">PasTimes</span>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="browse.php" class="nav-link">Browse</a></li>
                <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <li><a href="login.php" class="nav-link active">Sign In</a></li>
            </ul>
            <div class="nav-actions">
                <a href="register.php" class="btn btn-outline">Create Account</a>
            </div>
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div class="auth-container">
        <div class="auth-visual">
            <div class="slideshow-container auth-slideshow-height">
                <div class="slideshow-slide active">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200" alt="Sustainable fashion">
                    <div class="slide-caption">
                        <span>Welcome Back</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200" alt="Vintage finds">
                    <div class="slide-caption">
                        <span>Discover Unique Pieces</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1200" alt="Sell your clothes">
                    <div class="slide-caption">
                        <span>Turn Closet into Cash</span>
                    </div>
                </div>
                <div class="slideshow-dots">
                    <button class="dot active" aria-label="Slide 1"></button>
                    <button class="dot" aria-label="Slide 2"></button>
                    <button class="dot" aria-label="Slide 3"></button>
                </div>
            </div>
            <div class="auth-overlay"></div>
        </div>

        <div class="auth-form-section">
            <div class="auth-form-container">
                <a href="index.php" class="back-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to home
                </a>

                <h1>Welcome Back</h1>
                <p class="auth-subtitle">Sign in to continue shopping</p>

                <?php if ($error): ?>
                    <div class="error-message">
                        <strong>⚠️</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form class="auth-form" id="loginForm" method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <input type="text" id="username" name="username" class="form-input" required placeholder="username or email@example.com" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
                            <button type="button" class="toggle-password" data-target="password" aria-label="Toggle password visibility">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" class="custom-checkbox" id="rememberCheckbox">
                            <span class="checkmark">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            Remember me
                        </label>
                        <a href="forgot-password.php" class="link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-large btn-primary auth-submit" id="loginBtn">
                        Sign In
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 8px;">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>

                    <div class="auth-divider">
                        <span>or continue with</span>
                    </div>

                    <div class="social-auth">
                        <button type="button" class="btn-social" onclick="alert('Google login coming soon!')">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            Google
                        </button>
                        <button type="button" class="btn-social" onclick="alert('Facebook login coming soon!')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            Facebook
                        </button>
                    </div>
                </form>

                <p class="auth-footer">
                    Don't have an account?
                    <a href="register.php" class="link-bold">Create one</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                if (input) {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                }
            });
        });

        // Mobile navigation toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                const spans = this.querySelectorAll('span');
                if (navMenu.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
                } else {
                    spans[0].style.transform = '';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = '';
                }
            });
        }
    </script>
</body>

</html>
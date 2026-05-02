<?php
session_start();
require_once 'DBConn.php';

$error = '';
$success = '';

// Function to save user to text file
function saveUserToTextFile($firstName, $lastName, $email, $password, $role)
{
    $filename = 'userData.txt';

    // Format: firstName lastName email hashedPassword role
    $userLine = $firstName . ' ' . $lastName . ' ' . $email . ' ' . $password . ' ' . $role . "\n";

    // Check if file exists, create if not
    if (!file_exists($filename)) {
        file_put_contents($filename, '');
    }

    // Append the new user to the file
    if (file_put_contents($filename, $userLine, FILE_APPEND | LOCK_EX)) {
        return true;
    }
    return false;
}

// Function to check if email already exists in text file
function emailExistsInTextFile($email)
{
    $filename = 'userData.txt';
    if (!file_exists($filename)) {
        return false;
    }

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode(' ', $line);
        if (count($parts) >= 3 && $parts[2] === $email) {
            return true;
        }
    }
    return false;
}

// Function to check if username exists (extracted from email for text file)
function usernameExistsInTextFile($firstName, $lastName)
{
    $filename = 'userData.txt';
    if (!file_exists($filename)) {
        return false;
    }

    $username = strtolower($firstName . '.' . $lastName);
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode(' ', $line);
        if (count($parts) >= 2) {
            $existingUsername = strtolower($parts[0] . '.' . $parts[1]);
            if ($existingUsername === $username) {
                return true;
            }
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $role = $_POST['role'] ?? 'buyer';

    // Validation
    $errors = [];

    if (empty($firstName)) {
        $errors[] = 'First name is required';
    }
    if (empty($lastName)) {
        $errors[] = 'Last name is required';
    }
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }

    if (empty($errors)) {
        try {
            $dbSuccess = false;
            $textFileSuccess = false;
            $existingInDb = false;
            $existingInText = false;

            // Check if email already exists in database
            $stmt = $pdo->prepare("SELECT userID FROM tblUser WHERE email = ? OR username = ?");
            $stmt->execute([$email, $username]);

            if ($stmt->rowCount() > 0) {
                $existingInDb = true;
                $error = 'Email or username already exists in database.';
            }

            // Check if email already exists in text file
            if (emailExistsInTextFile($email)) {
                $existingInText = true;
                $error = 'Email already exists in userData.txt.';
            }

            // Check if username would conflict in text file
            if (usernameExistsInTextFile($firstName, $lastName)) {
                $existingInText = true;
                $error = 'A user with this name already exists in userData.txt.';
            }

            if (!$existingInDb && !$existingInText) {
                // Hash password for database
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO tblUser (firstName, lastName, username, email, password, role, userStatus) VALUES (?, ?, ?, ?, ?, ?, 'inactive')");
                $dbSuccess = $stmt->execute([$firstName, $lastName, $username, $email, $hashedPassword, $role]);

                if ($dbSuccess) {
                    // Also save to text file with the hashed password
                    $textFileSuccess = saveUserToTextFile($firstName, $lastName, $email, $hashedPassword, $role);

                    if ($textFileSuccess) {
                         $success = 'Account created successfully! Please wait for admin approval before logging in.';

                        // Redirect to login page
                        header("refresh:2;url=login.php");
                        exit();
                        
                    } else {
                        $error = 'Account created in database but failed to save to text file.';
                    }
                } else {
                    $error = 'Registration failed. Please try again.';
                }
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $error = 'Registration failed: ' . $e->getMessage();
        }
    } else {
        $error = implode('<br>', $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - PasTimes</title>
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

        .success-message {
            background: rgba(6, 255, 165, 0.1);
            border: 1px solid rgba(6, 255, 165, 0.3);
            color: #06ffa5;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            background: var(--bg-tertiary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: var(--font-body);
            resize: vertical;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--accent-primary);
        }

        .char-count {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
            display: block;
        }

        .strength-bar {
            height: 3px;
            background: var(--bg-tertiary);
            border-radius: 3px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .strength-bar.weak {
            background: #ff4757;
            width: 33%;
        }

        .strength-bar.medium {
            background: #ffb703;
            width: 66%;
        }

        .strength-bar.strong {
            background: #06ffa5;
            width: 100%;
        }

        .req-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .req-item.valid {
            color: #06ffa5;
        }

        .req-item svg {
            width: 14px;
            height: 14px;
        }

        .password-requirements {
            list-style: none;
            margin-top: 8px;
        }

        .info-note {
            background: rgba(0, 245, 212, 0.1);
            border: 1px solid rgba(0, 245, 212, 0.3);
            color: #00f5d4;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            margin-top: 16px;
            text-align: center;
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
                <li><a href="register.php" class="nav-link active">Sign Up</a></li>
            </ul>
            <div class="nav-actions">
                <a href="login.php" class="btn btn-outline">Sign In</a>
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
                    <img src="https://images.unsplash.com/photo-1467043237213-65f2da53396f?w=1200" alt="Wardrobe">
                    <div class="slide-caption">
                        <span>Join 50,000+ Members</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200" alt="Fashion collection">
                    <div class="slide-caption">
                        <span>Save Up to 70%</span>
                    </div>
                </div>
                <div class="slideshow-slide">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?w=1200" alt="Sneakers">
                    <div class="slide-caption">
                        <span>Sell in Minutes</span>
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

                <h1>Create Account</h1>
                <p class="auth-subtitle">Join our community in seconds</p>

                <?php if ($error): ?>
                    <div class="error-message">⚠️ <?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">✓ <?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form class="auth-form" id="registerForm" method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <input type="text" id="firstName" name="firstName" class="form-input" required placeholder="Jane" value="<?php echo htmlspecialchars($_POST['firstName'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <div class="input-wrapper">
                                <input type="text" id="lastName" name="lastName" class="form-input" required placeholder="Doe" value="<?php echo htmlspecialchars($_POST['lastName'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <input type="email" id="email" name="email" class="form-input" required placeholder="jane@example.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regUsername">Username *</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            <input type="text" id="regUsername" name="username" class="form-input" required placeholder="fashionista_2024" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>I want to: *</label>
                        <div class="role-selector">
                            <label class="role-option">
                                <input type="radio" name="role" value="buyer" <?php echo (!isset($_POST['role']) || $_POST['role'] === 'buyer') ? 'checked' : ''; ?>>
                                <span class="role-card">
                                    <svg class="role-icon-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                        <line x1="3" y1="6" x2="21" y2="6" />
                                        <path d="M16 10a4 4 0 0 1-8 0" />
                                    </svg>
                                    <span class="role-title">Buy</span>
                                    <span class="role-desc">Shop unique items</span>
                                </span>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="seller" <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'checked' : ''; ?>>
                                <span class="role-card">
                                    <svg class="role-icon-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                        <line x1="12" y1="22.08" x2="12" y2="12" />
                                    </svg>
                                    <span class="role-title">Sell</span>
                                    <span class="role-desc">List my items</span>
                                </span>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="both" <?php echo (isset($_POST['role']) && $_POST['role'] === 'both') ? 'checked' : ''; ?>>
                                <span class="role-card">
                                    <svg class="role-icon-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M17 1l4 4-4 4" />
                                        <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                                        <path d="M7 23l-4-4 4-4" />
                                        <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                                    </svg>
                                    <span class="role-title">Both</span>
                                    <span class="role-desc">Buy and sell</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="regPassword">Password *</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" id="regPassword" name="password" class="form-input" required placeholder="Min 8 characters">
                            <button type="button" class="toggle-password" data-target="regPassword">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <div class="strength-bar" id="strengthBar"></div>
                        <ul class="password-requirements" id="passwordReqs">
                            <li class="req-item" data-req="length">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                At least 8 characters
                            </li>
                            <li class="req-item" data-req="number">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                Contains a number
                            </li>
                            <li class="req-item" data-req="special">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                Contains a special character
                            </li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password *</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" required placeholder="Confirm your password">
                            <button type="button" class="toggle-password" data-target="confirmPassword">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label terms-label">
                            <input type="checkbox" required class="custom-checkbox" id="termsCheckbox">
                            <span class="checkmark">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <span class="terms-text">I agree to the <a href="#" class="link">Terms of Service</a> and <a href="#" class="link">Privacy Policy</a> *</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-large btn-primary auth-submit" id="submitBtn">
                        Create Account
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>
                </form>

                <div class="info-note">
                    📝 Your information will be saved to both the database and userData.txt file
                </div>

                <p class="auth-footer">
                    Already have an account?
                    <a href="login.php" class="link-bold">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Password strength checker
        const passwordInput = document.getElementById('regPassword');
        const strengthBar = document.getElementById('strengthBar');
        const reqItems = document.querySelectorAll('.req-item');

        function checkPasswordStrength(password) {
            let strength = 0;

            // Check requirements
            const hasLength = password.length >= 8;
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            // Update requirement indicators
            reqItems.forEach(item => {
                const req = item.dataset.req;
                if (req === 'length' && hasLength) {
                    item.classList.add('valid');
                    strength++;
                } else if (req === 'number' && hasNumber) {
                    item.classList.add('valid');
                    strength++;
                } else if (req === 'special' && hasSpecial) {
                    item.classList.add('valid');
                    strength++;
                } else if (!item.classList.contains('valid')) {
                    item.classList.remove('valid');
                }
            });

            // Update strength bar
            if (strength === 0) {
                strengthBar.className = 'strength-bar';
            } else if (strength === 1) {
                strengthBar.className = 'strength-bar weak';
            } else if (strength === 2) {
                strengthBar.className = 'strength-bar medium';
            } else if (strength === 3) {
                strengthBar.className = 'strength-bar strong';
            }
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });
        }

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

        // Form validation before submit
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                const password = document.getElementById('regPassword').value;
                const confirm = document.getElementById('confirmPassword').value;
                const terms = document.getElementById('termsCheckbox');

                if (password !== confirm) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }

                if (password.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long!');
                    return false;
                }

                if (!terms.checked) {
                    e.preventDefault();
                    alert('Please agree to the Terms of Service and Privacy Policy');
                    return false;
                }

                return true;
            });
        }

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
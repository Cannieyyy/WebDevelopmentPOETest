<?php
require_once 'includes/auth.php';
$currentUser = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="checkout-page">
    <!-- Simplified header for checkout flow -->
    <header class="checkout-header">
        <div class="container">
            <a href="index.php" class="logo">
                <span class="logo-icon">◆</span>
                <span class="logo-text">PasTimes</span>
            </a>
            <div class="checkout-steps">
                <div class="step active">
                    <span class="step-number">1</span>
                    <span class="step-label">Shipping</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <span class="step-number">2</span>
                    <span class="step-label">Payment</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <span class="step-number">3</span>
                    <span class="step-label">Confirm</span>
                </div>
            </div>
            <div class="secure-badge">
                <span>🔒 Secure</span>
            </div>
        </div>
    </header>

    <main class="checkout-main">
        <div class="container">
            <div class="checkout-layout">
                <!-- Checkout Form -->
                <section class="checkout-form-section">
                    <form class="checkout-form" id="checkoutForm">
                        <!-- Shipping Address -->
                        <div class="form-section">
                            <h2>Shipping Address</h2>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" required class="form-input">
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" required class="form-input">
                                </div>
                                <div class="form-group full-width">
                                    <label for="address">Street Address</label>
                                    <input type="text" id="address" required class="form-input" placeholder="123 Main Street">
                                </div>
                                <div class="form-group">
                                    <label for="apartment">Apt/Suite (Optional)</label>
                                    <input type="text" id="apartment" class="form-input" placeholder="Apt 4B">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" required class="form-input">
                                </div>
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select id="state" required class="form-select">
                                        <option value="">Select State</option>
                                        <option value="CA">California</option>
                                        <option value="NY">New York</option>
                                        <option value="TX">Texas</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="zip">ZIP Code</label>
                                    <input type="text" id="zip" required class="form-input" pattern="[0-9]{5}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" required class="form-input" placeholder="(555) 123-4567">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="form-section">
                            <h2>Payment Method</h2>
                            <div class="payment-methods">
                                <label class="payment-option active">
                                    <input type="radio" name="payment" value="card" checked>
                                    <span class="payment-radio"></span>
                                    <span class="payment-label">Credit Card</span>
                                    <span class="payment-icons">💳</span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment" value="paypal">
                                    <span class="payment-radio"></span>
                                    <span class="payment-label">PayPal</span>
                                    <span class="payment-icons">P</span>
                                </label>
                            </div>

                            <div class="card-form" id="cardForm">
                                <div class="form-group full-width">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="text" id="cardNumber" class="form-input" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="expiry">Expiry Date</label>
                                        <input type="text" id="expiry" class="form-input" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" class="form-input" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="cart.php" class="btn btn-text">← Return to Cart</a>
                            <button type="submit" class="btn btn-large btn-primary">
                                Complete Order - R177.11
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Order Summary Sidebar -->
                <aside class="checkout-summary">
                    <div class="summary-card">
                        <h3>Order Summary</h3>
                        <div class="mini-cart" id="miniCart">
                            <div class="mini-item">
                                <img src="https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=100" alt="">
                                <div class="mini-item-info">
                                    <span class="mini-name">Vintage Denim Jacket</span>
                                    <span class="mini-price">R68.00</span>
                                </div>
                            </div>
                            <div class="mini-item">
                                <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=100" alt="">
                                <div class="mini-item-info">
                                    <span class="mini-name">Silk Blouse × 2</span>
                                    <span class="mini-price">R90.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>R158.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>R5.99</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax</span>
                            <span>R13.12</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-amount">R177.11</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <script src="js/main.js"></script>
</body>
</html>
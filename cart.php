<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - PasTimes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <span class="logo-icon">◆</span>
                <span class="logo-text">PasTimes</span>
            </a>
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="browse.php" class="nav-link">Browse</a></li>
                <li><a href="seller-dashboard.php" class="nav-link">Sell</a></li>
                <li><a href="messages.php" class="nav-link">Messages</a></li>
            </ul>
            <div class="nav-actions">
                <a href="cart.php" class="icon-btn cart-btn active" aria-label="Shopping cart">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 2L6 7H3L5.5 20H18.5L21 7H18L15 2H9Z" />
                        <path d="M9 11V17M15 11V17" />
                    </svg>
                    <span class="cart-count" id="cartCount">3</span>
                </a>
                <a href="login.php" class="btn btn-outline">Login</a>
            </div>
        </div>
    </nav>

    <main class="cart-page">
        <div class="container">
            <h1 class="page-title">Shopping Cart</h1>

            <!-- Centered wrapper added around cart-layout -->
            <div class="cart-wrapper">
                <div class="cart-layout">
                    <!-- Cart Items -->
                    <section class="cart-items" id="cartItems">
                        <div class="cart-item">
                            <img src="https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=200" alt="Product" class="item-image">
                            <div class="item-details">
                                <h3 class="item-name">Vintage Denim Jacket</h3>
                                <p class="item-seller">From: Sarah's Closet</p>
                                <p class="item-variant">Size: M • Color: Blue</p>
                                <div class="item-actions">
                                    <div class="quantity-selector small">
                                        <button class="qty-btn">−</button>
                                        <input type="number" value="1" class="qty-input">
                                        <button class="qty-btn">+</button>
                                    </div>
                                    <button class="btn-text remove-btn">Remove</button>
                                    <button class="btn-text save-btn">Save for later</button>
                                </div>
                            </div>
                            <div class="item-price">
                                <span class="price">R68.00</span>
                                <span class="shipping">+ R5.99 shipping</span>
                            </div>
                        </div>

                        <div class="cart-item">
                            <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=200" alt="Product" class="item-image">
                            <div class="item-details">
                                <h3 class="item-name">Silk Blouse</h3>
                                <p class="item-seller">From: Vintage Finds</p>
                                <p class="item-variant">Size: S • Color: Cream</p>
                                <div class="item-actions">
                                    <div class="quantity-selector small">
                                        <button class="qty-btn">−</button>
                                        <input type="number" value="2" class="qty-input">
                                        <button class="qty-btn">+</button>
                                    </div>
                                    <button class="btn-text remove-btn">Remove</button>
                                    <button class="btn-text save-btn">Save for later</button>
                                </div>
                            </div>
                            <div class="item-price">
                                <span class="price">R45.00</span>
                                <span class="original-price">R90.00</span>
                                <span class="shipping">Free shipping</span>
                            </div>
                        </div>
                    </section>

                    <!-- Order Summary -->
                    <aside class="cart-summary">
                        <div class="summary-card">
                            <h2>Order Summary</h2>
                            <div class="summary-row">
                                <span>Subtotal (3 items)</span>
                                <span id="subtotal">R158.00</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span id="shipping">R5.99</span>
                            </div>
                            <div class="summary-row">
                                <span>Tax</span>
                                <span id="tax">R13.12</span>
                            </div>
                            <div class="summary-row discount" id="discountRow" style="display: none;">
                                <span>Discount</span>
                                <span id="discount">R0.00</span>
                            </div>
                            <div class="promo-code">
                                <input type="text" placeholder="Enter promo code" class="promo-input" id="promoInput">
                                <button class="btn btn-outline btn-small" id="applyPromo">Apply</button>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span id="total">R177.11</span>
                            </div>
                            <a href="checkout.php" class="btn btn-large btn-primary checkout-btn">
                                Proceed to Checkout
                            </a>
                            <div class="payment-icons">
                                <span>🔒 Secure Checkout</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <!-- Empty State (hidden by default, shown via JS when cart is empty) -->
            <div class="empty-cart" id="emptyCart" style="display: none;">
                <div class="empty-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added anything yet.</p>
                <a href="browse.php" class="btn btn-primary">Start Shopping</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">
                        <span class="logo-icon">◆</span>
                        <span class="logo-text">PasTimes</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>

</html>
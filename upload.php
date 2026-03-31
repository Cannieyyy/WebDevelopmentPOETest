<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Item - PasTimes</title>
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
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="browse.php" class="nav-link">Browse</a></li>
                <li><a href="seller-dashboard.php" class="nav-link active">Sell</a></li>
            </ul>
            <div class="nav-actions">
                <a href="cart.php" class="icon-btn cart-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 2L6 7H3L5.5 20H18.5L21 7H18L15 2H9Z"/>
                    </svg>
                    <span class="cart-count" id="cartCount">0</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="upload-page">
        <div class="container">
            <div class="upload-header">
                <h1>List Your Item</h1>
                <p>Upload your pre-loved fashion in minutes</p>
            </div>

            <form class="upload-form" id="uploadForm">
                <div class="upload-layout">
                    <!-- Left Column: Images -->
                    <section class="upload-section">
                        <h2>Photos</h2>
                        <p class="section-hint">Add up to 8 photos. First photo will be the cover.</p>
                        
                        <div class="image-upload-grid" id="imageGrid">
                            <div class="upload-zone" id="uploadZone">
                                <input type="file" id="fileInput" multiple accept="image/*" hidden>
                                <div class="upload-prompt">
                                    <span class="upload-icon">📸</span>
                                    <span class="upload-text">Click or drag photos here</span>
                                    <span class="upload-hint">Supports JPG, PNG up to 10MB</span>
                                </div>
                            </div>
                            <!-- Preview images will appear here -->
                        </div>

                        <div class="photo-tips">
                            <h4>📷 Photo Tips:</h4>
                            <ul>
                                <li>Use natural lighting</li>
                                <li>Show any flaws honestly</li>
                                <li>Include brand tags</li>
                                <li>Model the item if possible</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Right Column: Details -->
                    <section class="upload-section">
                        <h2>Item Details</h2>
                        
                        <div class="form-group">
                            <label for="itemTitle">Title *</label>
                            <input type="text" id="itemTitle" class="form-input" required placeholder="e.g., Vintage Levi's Denim Jacket">
                            <span class="char-count"><span id="titleCount">0</span>/80</span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="itemCategory">Category *</label>
                                <select id="itemCategory" class="form-select" required>
                                    <option value="">Select category</option>
                                    <option value="women">Women</option>
                                    <option value="men">Men</option>
                                    <option value="vintage">Vintage</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="itemSubcategory">Subcategory</label>
                                <select id="itemSubcategory" class="form-select">
                                    <option value="">Select subcategory</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="itemSize">Size *</label>
                                <select id="itemSize" class="form-select" required>
                                    <option value="">Select size</option>
                                    <option value="xs">XS</option>
                                    <option value="s">S</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                    <option value="xl">XL</option>
                                    <option value="xxl">XXL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="itemBrand">Brand</label>
                                <input type="text" id="itemBrand" class="form-input" placeholder="e.g., Levi's">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="itemCondition">Condition *</label>
                            <div class="condition-selector">
                                <label class="condition-option">
                                    <input type="radio" name="condition" value="new" required>
                                    <span class="condition-card">
                                        <strong>New with tags</strong>
                                        <span>Never worn, original tags attached</span>
                                    </span>
                                </label>
                                <label class="condition-option">
                                    <input type="radio" name="condition" value="excellent">
                                    <span class="condition-card">
                                        <strong>Excellent</strong>
                                        <span>Worn once or twice, like new</span>
                                    </span>
                                </label>
                                <label class="condition-option">
                                    <input type="radio" name="condition" value="good">
                                    <span class="condition-card">
                                        <strong>Good</strong>
                                        <span>Gently used, minor signs of wear</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="itemPrice">Price *</label>
                            <div class="price-input-group">
                                <span class="currency">$</span>
                                <input type="number" id="itemPrice" class="form-input" required min="1" step="0.01" placeholder="0.00">
                            </div>
                            <div class="price-suggestion" id="priceSuggestion"></div>
                        </div>

                        <div class="form-group">
                            <label for="itemDescription">Description *</label>
                            <textarea id="itemDescription" class="form-textarea" rows="5" required placeholder="Describe your item, mention any flaws, fit, fabric, etc."></textarea>
                            <span class="char-count"><span id="descCount">0</span>/1000</span>
                        </div>

                        <div class="form-group">
                            <label>Shipping</label>
                            <div class="shipping-options">
                                <label class="shipping-option">
                                    <input type="radio" name="shipping" value="buyer" checked>
                                    <span>Buyer pays shipping</span>
                                </label>
                                <label class="shipping-option">
                                    <input type="radio" name="shipping" value="seller">
                                    <span>I pay shipping (+$5.99)</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-outline">Save as Draft</button>
                            <button type="submit" class="btn btn-primary">Submit for Review</button>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </main>

    <script src="js/main.js"></script>
</body>
</html>
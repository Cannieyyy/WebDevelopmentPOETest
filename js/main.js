/**
 * PasTimes - Secondhand Fashion Marketplace
 * Main JavaScript File
 * Handles all interactive functionality across the site
 */

// ==========================================
// ADMIN EDIT MODAL
// ==========================================

function openEditModal(userID, status, role) {
    document.getElementById('editModal').style.display = 'flex';

    document.getElementById('editUserID').value = userID;
    document.getElementById('editStatus').value = status;
    document.getElementById('editRole').value = role;
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// close when clicking outside modal
window.onclick = function (event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

// ==========================================
// STATE MANAGEMENT
// ==========================================
const Store = {
    cart: JSON.parse(localStorage.getItem('cart')) || [],
    user: JSON.parse(localStorage.getItem('user')) || null,
    currentPage: window.location.pathname,
    
    // Save cart to localStorage
    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
        this.updateCartCount();
    },
    
    // Update cart count in navbar
    updateCartCount() {
        const countElements = document.querySelectorAll('#cartCount');
        const count = this.cart.reduce((sum, item) => sum + item.quantity, 0);
        countElements.forEach(el => {
            el.textContent = count;
            el.style.display = count > 0 ? 'flex' : 'none';
        });
    },
    
    // Add item to cart
    addToCart(product) {
        const existing = this.cart.find(item => item.id === product.id);
        if (existing) {
            existing.quantity += product.quantity || 1;
        } else {
            this.cart.push({ ...product, quantity: product.quantity || 1 });
        }
        this.saveCart();
        this.showNotification('Added to cart!', 'success');
    },
    
    // Remove from cart
    removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.renderCart();
    },
    
    // Show notification toast
    showNotification(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: ${type === 'success' ? 'var(--accent-success)' : 'var(--accent-primary)'};
            color: var(--bg-primary);
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 600;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
};

// ==========================================
// HERO SLIDESHOW
// ==========================================
function initSlideshow() {
    const slides = document.querySelectorAll('.slideshow-slide');
    const dots = document.querySelectorAll('.slideshow-dots .dot');
    
    if (slides.length === 0) return;
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    function showSlide(index) {
        // Remove active class from all
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Add active to current
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    // Auto-advance every 5 seconds
    let slideInterval = setInterval(nextSlide, 5000);
    
    // Dot click handlers
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            clearInterval(slideInterval);
            currentSlide = index;
            showSlide(currentSlide);
            slideInterval = setInterval(nextSlide, 5000);
        });
    });
}

// Call in your DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    initSlideshow();
    // ... rest of your init calls
});

// ==========================================
// MOBILE NAVIGATION
// ==========================================
function initMobileNav() {
    const toggle = document.getElementById('mobileToggle');
    const menu = document.getElementById('navMenu');
    
    if (!toggle || !menu) return;
    
    toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
        toggle.classList.toggle('active');
        
        // Animate hamburger to X
        const spans = toggle.querySelectorAll('span');
        if (menu.classList.contains('active')) {
            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
        } else {
            spans[0].style.transform = '';
            spans[1].style.opacity = '1';
            spans[2].style.transform = '';
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('active');
            toggle.classList.remove('active');
            spans.forEach(span => span.style.transform = '');
            spans[1].style.opacity = '1';
        }
    });
}

// ==========================================
// PRODUCT DATA & RENDERING
// ==========================================
const products = [
    {
        id: 1,
        title: "Vintage Denim Jacket",
        seller: "Sarah's Closet",
        price: 68,
        originalPrice: 120,
        image: "https://images.unsplash.com/photo-1543076447-215ad9ba6923?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8ZGVuaW0lMjBqYWNrZXR8ZW58MHx8MHx8fDA%3D",
        rating: 4.9,
        reviews: 12,
        badge: "Best Seller"
    },
    {
        id: 2,
        title: "Silk Blouse",
        seller: "Vintage Finds",
        price: 45,
        originalPrice: 90,
        image: "https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400",
        rating: 4.7,
        reviews: 8
    },
    {
        id: 3,
        title: "Leather Ankle Boots",
        seller: "Urban Style",
        price: 89,
        originalPrice: 160,
        image: "https://images.unsplash.com/photo-1764590544650-ca51cd3eb207?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8YW5rbGUlMjBib290c3xlbnwwfHwwfHx8MA%3D%3D",
        rating: 4.8,
        reviews: 24,
        badge: "New"
    },
    {
        id: 4,
        title: "Wool Coat",
        seller: "Classic Wear",
        price: 120,
        originalPrice: 250,
        image: "https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400",
        rating: 4.9,
        reviews: 15
    },
    {
        id: 5,
        title: "Vintage Denim Jacket",
        seller: "Sarah's Closet",
        price: 265,
        originalPrice: 120,
        image: "https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?w=400",
        rating: 4.9,
        reviews: 12,
        badge: "Best Seller"
    },
    {
        id: 6,
        title: "Silk Blouse",
        seller: "Vintage Finds",
        price: 45,
        originalPrice: 90,
        image: "https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400",
        rating: 4.7,
        reviews: 8
    },
    {
        id: 7,
        title: "Leather Ankle Boots",
        seller: "Urban Style",
        price: 89,
        originalPrice: 160,
        image: "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=400",
        rating: 4.8,
        reviews: 24,
        badge: "New"
    },
    {
        id: 8,
        title: "Wool Coat",
        seller: "Classic Wear",
        price: 120,
        originalPrice: 250,
        image: "https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400",
        rating: 4.9,
        reviews: 15
    }

];

function createProductCard(product) {
    const discount = Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100);
    
    return `
        <article class="product-card" data-id="${product.id}">
            <div class="product-image">
                <img src="${product.image}" alt="${product.title}" loading="lazy">
                ${product.badge ? `<span class="product-badge">${product.badge}</span>` : ''}
                <button class="product-wishlist" aria-label="Add to wishlist">♡</button>
            </div>
            <div class="product-info">
                <h3 class="product-title">${product.title}</h3>
                <div class="product-meta">
                    <span class="product-seller">${product.seller}</span>
                    <span class="product-rating">★ ${product.rating}</span>
                </div>
                <div class="product-footer">
                    <div>
                        <span class="product-price">R ${product.price}</span>
                        ${product.originalPrice ? `<span class="product-original">R ${product.originalPrice}</span>` : ''}
                    </div>
                    <button class="add-cart-btn" onclick="Store.addToCart({id: ${product.id}, title: '${product.title}', price: ${product.price}, image: '${product.image}'})" aria-label="Add to cart">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 2L6 7H3L5.5 20H18.5L21 7H18L15 2H9Z"/>
                            <path d="M9 11V17M15 11V17"/>
                        </svg>
                    </button>
                </div>
            </div>
        </article>
    `;
}

function renderProducts(containerId, productList = products) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    container.innerHTML = productList.map(createProductCard).join('');
}

// ==========================================
// CART FUNCTIONALITY
// ==========================================
function renderCart() {
    const container = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');
    if (!container) return;
    
    if (Store.cart.length === 0) {
        container.style.display = 'none';
        if (emptyCart) emptyCart.style.display = 'block';
        return;
    }
    
    container.style.display = 'flex';
    if (emptyCart) emptyCart.style.display = 'none';
    
    container.innerHTML = Store.cart.map(item => `
        <div class="cart-item" data-id="${item.id}">
            <img src="${item.image}" alt="${item.title}" class="item-image">
            <div class="item-details">
                <h3 class="item-name">${item.title}</h3>
                <p class="item-seller">From: ${item.seller || 'Unknown'}</p>
                <p class="item-variant">Size: M • Color: Default</p>
                <div class="item-actions">
                    <div class="quantity-selector small">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                        <input type="number" value="${item.quantity}" class="qty-input" readonly>
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                    <button class="btn-text remove-btn" onclick="Store.removeFromCart(${item.id})">Remove</button>
                    <button class="btn-text save-btn">Save for later</button>
                </div>
            </div>
            <div class="item-price">
                <span class="price">$${(item.price * item.quantity).toFixed(2)}</span>
                <span class="shipping">+ R199.99 shipping</span>
            </div>
        </div>
    `).join('');
    
    updateCartTotals();
}

function updateQuantity(productId, change) {
    const item = Store.cart.find(i => i.id === productId);
    if (!item) return;
    
    item.quantity += change;
    if (item.quantity <= 0) {
        Store.removeFromCart(productId);
    } else {
        Store.saveCart();
        renderCart();
    }
}

function updateCartTotals() {
    const subtotal = Store.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = Store.cart.length > 0 ? 5.99 : 0;
    const tax = subtotal * 0.08;
    const total = subtotal + shipping + tax;
    
    const subtotalEl = document.getElementById('subtotal');
    const shippingEl = document.getElementById('shipping');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total');
    
    if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    if (shippingEl) shippingEl.textContent = `$${shipping.toFixed(2)}`;
    if (taxEl) taxEl.textContent = `$${tax.toFixed(2)}`;
    if (totalEl) totalEl.textContent = `$${total.toFixed(2)}`;
}

// ==========================================
// FILTER FUNCTIONALITY
// ==========================================
function initFilters() {
    const filterToggle = document.getElementById('mobileFilterToggle');
    const sidebar = document.getElementById('filtersSidebar');
    
    if (filterToggle && sidebar) {
        filterToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
        
        // Close when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024 && 
                !sidebar.contains(e.target) && 
                !filterToggle.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        });
    }
    
    // Size buttons
    const sizeBtns = document.querySelectorAll('.size-btn');
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            sizeBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
    
    // Checkboxes
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    checkboxes.forEach(box => {
        box.addEventListener('change', () => {
            // In a real app, this would filter the products
            console.log('Filter changed:', box.value, box.checked);
        });
    });
}

// ==========================================
// UPLOAD FUNCTIONALITY
// ==========================================
function initUpload() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const imageGrid = document.getElementById('imageGrid');
    
    if (!uploadZone || !fileInput) return;
    
    // Click to upload
    uploadZone.addEventListener('click', () => fileInput.click());
    
    // Drag and drop
    uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.style.borderColor = 'var(--accent-primary)';
        uploadZone.style.background = 'rgba(0,245,212,0.05)';
    });
    
    uploadZone.addEventListener('dragleave', () => {
        uploadZone.style.borderColor = '';
        uploadZone.style.background = '';
    });
    
    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.style.borderColor = '';
        uploadZone.style.background = '';
        handleFiles(e.dataTransfer.files);
    });
    
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });
    
    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'thumbnail';
                    div.innerHTML = `<img src="${e.target.result}" alt="Upload">`;
                    imageGrid.insertBefore(div, uploadZone);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Character counters
    const titleInput = document.getElementById('itemTitle');
    const descInput = document.getElementById('itemDescription');
    
    if (titleInput) {
        titleInput.addEventListener('input', () => {
            const count = titleInput.value.length;
            document.getElementById('titleCount').textContent = count;
        });
    }
    
    if (descInput) {
        descInput.addEventListener('input', () => {
            const count = descInput.value.length;
            document.getElementById('descCount').textContent = count;
        });
    }
}

// ==========================================
// MESSAGING FUNCTIONALITY
// ==========================================
function initMessaging() {
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const chatMessages = document.getElementById('chatMessages');
    
    if (!messageInput || !sendBtn) return;
    
    function sendMessage() {
        const text = messageInput.value.trim();
        if (!text) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message sent';
        messageDiv.innerHTML = `
            <div class="message-content">
                <p>${escapeHtml(text)}</p>
                <span class="message-time">Just now</span>
            </div>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        messageInput.value = '';
        
        // Simulate reply
        setTimeout(() => {
            const replyDiv = document.createElement('div');
            replyDiv.className = 'message received';
            replyDiv.innerHTML = `
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User" class="message-avatar">
                <div class="message-content">
                    <p>Thanks for your message! I'll get back to you shortly.</p>
                    <span class="message-time">Just now</span>
                </div>
            `;
            chatMessages.appendChild(replyDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 2000);
    }
    
    sendBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==========================================
// FORM VALIDATION
// ==========================================
function initForms() {
    // Login form
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Simulate login
            Store.user = { username, role: 'buyer' };
            localStorage.setItem('user', JSON.stringify(Store.user));
            Store.showNotification('Welcome back!', 'success');
            setTimeout(() => window.location.href = 'index.php', 1000);
        });
    }
    
    // Register form
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        const password = document.getElementById('regPassword');
        const reqs = document.querySelectorAll('.req-item');
        
        if (password) {
            password.addEventListener('input', () => {
                const val = password.value;
                
                // Check requirements
                const hasLength = val.length >= 8;
                const hasNumber = /\d/.test(val);
                const hasSpecial = /[!@#$%^&*]/.test(val);
                
                reqs[0].classList.toggle('valid', hasLength);
                reqs[1].classList.toggle('valid', hasNumber);
                reqs[2].classList.toggle('valid', hasSpecial);
            });
        }
        
        
    }
    
    // Checkout form
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', (e) => {
            e.preventDefault();
            Store.showNotification('Order placed successfully!', 'success');
            Store.cart = [];
            Store.saveCart();
            setTimeout(() => window.location.href = 'index.php', 2000);
        });
    }
    
    // Upload form
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            Store.showNotification('Item submitted for review!', 'success');
        });
    }
}

// ==========================================
// UTILITY FUNCTIONS
// ==========================================
function initScrollEffects() {
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 10, 15, 0.95)';
                navbar.style.boxShadow = '0 4px 30px rgba(0,0,0,0.3)';
            } else {
                navbar.style.background = 'rgba(10, 10, 15, 0.8)';
                navbar.style.boxShadow = 'none';
            }
        });
    }
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.product-card, .step-card, .stat-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// ==========================================
// INITIALIZATION
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    // Initialize all components
    initMobileNav();
    initFilters();
    initUpload();
    initMessaging();
    initForms();
    initScrollEffects();
    
    // Update cart count on page load
    Store.updateCartCount();
    
    // Render products on appropriate pages
    renderProducts('featuredGrid');
    renderProducts('productGrid');
    renderProducts('similarGrid');
    
    // Render cart if on cart page
    renderCart();
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    console.log('🛍️ PasTimes initialized successfully!');
});
<?php
require_once 'includes/auth.php';
$currentUser = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - PasTimes</title>
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
                <li><a href="messages.php" class="nav-link active">Messages</a></li>
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

    <main class="messages-page">
        <div class="container">
            <div class="messages-layout">
                <!-- Conversations List -->
                <aside class="conversations-sidebar">
                    <div class="conversations-header">
                        <h2>Messages</h2>
                        <div class="search-box">
                            <input type="search" placeholder="Search conversations..." class="form-input">
                        </div>
                    </div>
                    <div class="conversations-list" id="conversationsList">
                        <div class="conversation-item active unread">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User" class="conversation-avatar">
                            <div class="conversation-preview">
                                <div class="conversation-top">
                                    <h4>Sarah's Closet</h4>
                                    <span class="conversation-time">2m</span>
                                </div>
                                <p>Is the denim jacket still available?</p>
                                <span class="unread-badge">2</span>
                            </div>
                        </div>
                        <div class="conversation-item">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="User" class="conversation-avatar">
                            <div class="conversation-preview">
                                <div class="conversation-top">
                                    <h4>Mike's Vintage</h4>
                                    <span class="conversation-time">2h</span>
                                </div>
                                <p>Thanks for your purchase!</p>
                            </div>
                        </div>
                        <div class="conversation-item">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100" alt="User" class="conversation-avatar">
                            <div class="conversation-preview">
                                <div class="conversation-top">
                                    <h4>Emma's Boutique</h4>
                                    <span class="conversation-time">1d</span>
                                </div>
                                <p>Would you take $40 for the blouse?</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Chat Area -->
                <section class="chat-area">
                    <div class="chat-header">
                        <div class="chat-user">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User">
                            <div>
                                <h3>Sarah's Closet</h3>
                                <span class="user-status online">Online</span>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <button class="btn btn-small btn-outline">View Item</button>
                            <button class="btn btn-small btn-text">Report</button>
                        </div>
                    </div>

                    <div class="chat-messages" id="chatMessages">
                        <div class="message-date">Today</div>
                        
                        <div class="message received">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User" class="message-avatar">
                            <div class="message-content">
                                <p>Hi! I'm interested in the vintage denim jacket you posted. Is it still available?</p>
                                <span class="message-time">2:30 PM</span>
                            </div>
                        </div>

                        <div class="message sent">
                            <div class="message-content">
                                <p>Yes, it's still available! It's in excellent condition, only worn twice.</p>
                                <span class="message-time">2:32 PM</span>
                            </div>
                        </div>

                        <div class="message received">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User" class="message-avatar">
                            <div class="message-content">
                                <p>Great! Would you be willing to negotiate on the price? I can do $55.</p>
                                <span class="message-time">2:35 PM</span>
                            </div>
                        </div>

                        <div class="message sent">
                            <div class="message-content">
                                <p>I can do $60, it's already a great deal at $68! 😊</p>
                                <span class="message-time">2:36 PM</span>
                            </div>
                        </div>

                        <div class="message received">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="User" class="message-avatar">
                            <div class="message-content">
                                <p>Deal! I'll add it to my cart now.</p>
                                <span class="message-time">2:38 PM</span>
                            </div>
                        </div>
                    </div>

                    <div class="chat-input-area">
                        <div class="chat-input-wrapper">
                            <button class="attach-btn" aria-label="Attach file">📎</button>
                            <input type="text" class="chat-input" placeholder="Type a message..." id="messageInput">
                            <button class="emoji-btn" aria-label="Add emoji">😊</button>
                            <button class="send-btn" id="sendBtn" aria-label="Send message">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script src="js/main.js"></script>
</body>
</html>
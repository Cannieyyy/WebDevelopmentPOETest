# PasTimes — Secondhand Fashion Marketplace

PasTimes is a full-stack PHP and MySQL-based web application that allows users to buy, sell, and manage secondhand fashion items. The platform includes role-based access (buyers, sellers, admins), user verification, and a complete admin dashboard for system management.

## Features

### User System
- User registration and login
- Role-based accounts:
  - Buyer
  - Seller
  - Both (buyer + seller)
- Session-based authentication
- Secure password hashing (`password_hash`, `password_verify`)

### Marketplace Features
- Browse available fashion items
- Category filtering (Men, Women, Vintage, Accessories)
- Product search functionality
- Item listing system for sellers
- Messaging system (basic implementation)

### Seller Features
- Upload and list items for sale
- Manage seller dashboard
- Track listed items
- Receive buyer interactions

### Admin Panel
- Full admin dashboard
- User management system:
  - Approve accounts
  - Reject / ban users
  - Edit user roles (buyer, seller, both)
  - Delete users
- Pending verification system
- Live database-driven statistics:
  - Total users
  - Buyers / sellers breakdown
  - Active / inactive / banned users
- Role-based admin access (super, moderator, support)

### Admin Analytics
- Real-time stats using SQL `COUNT()` aggregation
- Pending verification tracking
- User role distribution overview

## Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP (Core PHP, no framework)
- **Database:** MySQL
- **Authentication:** PHP Sessions
- **Security:** Password hashing + prepared statements (PDO)
- **CI/CD :** GitHub Actions (basic workflow setup)

## 📁 Project Structure

/css
/js
/assets
/WebFiles

## Database Overview

Main tables:

### `tblUser`
- userID
- firstName
- lastName
- email
- username
- password
- role (buyer, seller, both)
- userStatus (active, inactive, banned)
- createdAt

### `tblAdmin`
- adminID
- username
- email
- password
- fullName
- role (super, moderator, support)
- lastLogin
- createdAt

## Authentication Flow

1. User logs in via login page
2. Credentials verified using `password_verify`
3. Session variables stored:
   - `userID`
   - `username`
   - `role`
   - `logged_in`
   - `isAdmin` (for admin users)
4. Role-based redirects:
   - Admin → admin dashboard
   - Seller → seller dashboard
   - Buyer → homepage / browse

## Admin Functionality

Admins can:

- View all users
- Approve or reject registrations
- Ban or activate users
- Modify roles dynamically
- Delete user accounts
- Monitor system statistics in real time

---

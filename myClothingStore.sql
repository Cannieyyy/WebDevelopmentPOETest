-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 03, 2026 at 08:24 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothingstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
CREATE TABLE IF NOT EXISTS `tbladmin` (
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super','moderator','support') COLLATE utf8mb4_unicode_ci DEFAULT 'moderator',
  `lastLogin` timestamp NULL DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`adminID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`adminID`, `username`, `email`, `password`, `fullName`, `role`, `lastLogin`, `createdAt`) VALUES
(1, 'admin', 'admin@pastes.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'super', NULL, '2026-05-03 20:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblaorder`
--

DROP TABLE IF EXISTS `tblaorder`;
CREATE TABLE IF NOT EXISTS `tblaorder` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `buyerID` int(11) NOT NULL,
  `orderNumber` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `shippingAddress` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shippingCity` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shippingPostal` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentMethod` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentStatus` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `orderStatus` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `trackingNumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`orderID`),
  UNIQUE KEY `orderNumber` (`orderNumber`),
  KEY `idx_buyer` (`buyerID`),
  KEY `idx_order_status` (`orderStatus`),
  KEY `idx_payment_status` (`paymentStatus`),
  KEY `idx_order_number` (`orderNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblaorder`
--

INSERT INTO `tblaorder` (`orderID`, `buyerID`, `orderNumber`, `totalAmount`, `shippingAddress`, `shippingCity`, `shippingPostal`, `paymentMethod`, `paymentStatus`, `orderStatus`, `trackingNumber`, `notes`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'ORD-2024-0001', '68.00', '123 Main St', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(2, 4, 'ORD-2024-0002', '45.00', '456 Oak Ave', 'Johannesburg', '2001', 'paypal', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(3, 6, 'ORD-2024-0003', '89.00', '789 Pine Rd', 'Durban', '4001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(4, 7, 'ORD-2024-0004', '120.00', '321 Elm St', 'Pretoria', '0001', 'paypal', 'paid', 'processing', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(5, 8, 'ORD-2024-0005', '199.00', '654 Maple Dr', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(6, 9, 'ORD-2024-0006', '85.00', '987 Cedar Ln', 'Johannesburg', '2001', 'paypal', 'pending', 'pending', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(7, 10, 'ORD-2024-0007', '75.00', '147 Birch Ct', 'Durban', '4001', 'credit_card', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(8, 11, 'ORD-2024-0008', '250.00', '258 Spruce Way', 'Pretoria', '0001', 'paypal', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(9, 12, 'ORD-2024-0009', '35.00', '369 Willow Ave', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(10, 13, 'ORD-2024-0010', '120.00', '741 Ash St', 'Johannesburg', '2001', 'paypal', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(11, 14, 'ORD-2024-0011', '95.00', '852 Poplar Dr', 'Durban', '4001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(12, 15, 'ORD-2024-0012', '45.00', '963 Beech Rd', 'Pretoria', '0001', 'paypal', 'pending', 'pending', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(13, 16, 'ORD-2024-0013', '180.00', '159 Hickory Ct', 'Cape Town', '8001', 'credit_card', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(14, 17, 'ORD-2024-0014', '350.00', '753 Walnut Ln', 'Johannesburg', '2001', 'paypal', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(15, 18, 'ORD-2024-0015', '250.00', '951 Chestnut St', 'Durban', '4001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(16, 19, 'ORD-2024-0016', '110.00', '357 Magnolia Ave', 'Pretoria', '0001', 'paypal', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(17, 20, 'ORD-2024-0017', '55.00', '468 Dogwood Dr', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(18, 21, 'ORD-2024-0018', '65.00', '579 Sycamore Rd', 'Johannesburg', '2001', 'paypal', 'pending', 'pending', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(19, 22, 'ORD-2024-0019', '85.00', '681 Juniper Ct', 'Durban', '4001', 'credit_card', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(20, 23, 'ORD-2024-0020', '60.00', '792 Aspen Ln', 'Pretoria', '0001', 'paypal', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(21, 24, 'ORD-2024-0021', '120.00', '904 Beechwood Ave', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(22, 25, 'ORD-2024-0022', '300.00', '126 Redwood Dr', 'Johannesburg', '2001', 'paypal', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(23, 26, 'ORD-2024-0023', '175.00', '238 Pinecrest Rd', 'Durban', '4001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(24, 27, 'ORD-2024-0024', '50.00', '347 Oakwood Ct', 'Pretoria', '0001', 'paypal', 'pending', 'pending', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(25, 28, 'ORD-2024-0025', '70.00', '456 Elmwood Ln', 'Cape Town', '8001', 'credit_card', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(26, 29, 'ORD-2024-0026', '45.00', '567 Maplewood Ave', 'Johannesburg', '2001', 'paypal', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(27, 30, 'ORD-2024-0027', '35.00', '678 Cedarwood Dr', 'Durban', '4001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(28, 1, 'ORD-2024-0028', '150.00', '789 Birchwood Rd', 'Pretoria', '0001', 'paypal', 'paid', 'shipped', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(29, 4, 'ORD-2024-0029', '200.00', '891 Ashwood Ct', 'Cape Town', '8001', 'credit_card', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(30, 6, 'ORD-2024-0030', '250.00', '912 Poplarwood Ln', 'Johannesburg', '2001', 'paypal', 'paid', 'delivered', NULL, NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblclothes`
--

DROP TABLE IF EXISTS `tblclothes`;
CREATE TABLE IF NOT EXISTS `tblclothes` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `sellerID` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_status` enum('new','excellent','good','fair') COLLATE utf8mb4_unicode_ci DEFAULT 'good',
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'buyer',
  `status` enum('pending','active','sold','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `views` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`itemID`),
  KEY `idx_seller` (`sellerID`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`),
  KEY `idx_price` (`price`),
  KEY `idx_created` (`createdAt`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblclothes`
--

INSERT INTO `tblclothes` (`itemID`, `sellerID`, `title`, `category`, `subcategory`, `size`, `brand`, `condition_status`, `price`, `description`, `images`, `shipping`, `status`, `views`, `createdAt`, `updatedAt`) VALUES
(1, 2, 'Vintage Denim Jacket', 'women', 'jackets', 'M', 'Levi\'s', 'excellent', '68.00', 'Beautiful vintage denim jacket from the 90s. Excellent condition.', NULL, 'buyer', 'active', 234, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(2, 3, 'Silk Blouse', 'women', 'tops', 'S', 'Zara', 'excellent', '45.00', 'Elegant silk blouse in cream color. Worn only twice.', NULL, 'buyer', 'active', 189, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(3, 5, 'Leather Ankle Boots', 'women', 'shoes', '38', 'Dr. Martens', 'good', '89.00', 'Genuine leather ankle boots. Very comfortable!', NULL, 'buyer', 'active', 312, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(4, 2, 'Wool Coat', 'women', 'outerwear', 'L', 'Mango', 'excellent', '120.00', 'Beautiful wool coat in camel color. Perfect for winter.', NULL, 'buyer', 'active', 156, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(5, 3, 'Designer Handbag', 'accessories', 'bags', 'One Size', 'Coach', 'excellent', '199.00', 'Genuine leather handbag. Like new condition.', NULL, 'buyer', 'active', 278, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(6, 5, 'Cashmere Sweater', 'women', 'sweaters', 'M', 'J.Crew', 'new', '85.00', 'Soft cashmere sweater, never worn with tags.', NULL, 'buyer', 'active', 98, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(7, 2, 'Running Shoes', 'men', 'shoes', '42', 'Nike', 'good', '75.00', 'Used for 3 months, still great condition.', NULL, 'buyer', 'active', 145, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(8, 3, 'Leather Jacket', 'men', 'jackets', 'L', 'Schott', 'excellent', '250.00', 'Classic leather jacket. Worn only a few times.', NULL, 'buyer', 'active', 367, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(9, 5, 'Summer Dress', 'women', 'dresses', 'S', 'H&M', 'good', '35.00', 'Floral summer dress. Perfect for vacation.', NULL, 'buyer', 'active', 89, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(10, 2, 'Wool Scarf', 'accessories', 'scarves', 'One Size', 'Burberry', 'excellent', '120.00', 'Authentic Burberry scarf. Like new.', NULL, 'buyer', 'active', 203, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(11, 3, 'Sunglasses', 'accessories', 'eyewear', 'One Size', 'Ray-Ban', 'excellent', '95.00', 'Classic Ray-Ban Wayfarer sunglasses.', NULL, 'buyer', 'active', 167, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(12, 5, 'Jeans', 'men', 'pants', '32x32', 'Levi\'s', 'good', '45.00', '501 original fit. Gently used.', NULL, 'buyer', 'active', 112, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(13, 2, 'Leather Belt', 'accessories', 'belts', 'M', 'Gucci', 'excellent', '180.00', 'Designer belt. Minor signs of wear.', NULL, 'buyer', 'active', 234, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(14, 3, 'Evening Gown', 'women', 'dresses', '6', 'Vera Wang', 'excellent', '350.00', 'Stunning evening gown. Worn once.', NULL, 'buyer', 'active', 78, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(15, 5, 'Sports Watch', 'accessories', 'watches', 'One Size', 'Apple', 'good', '250.00', 'Apple Watch Series 7. Works perfectly.', NULL, 'buyer', 'active', 456, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(16, 2, 'Winter Boots', 'women', 'shoes', '7', 'UGG', 'excellent', '110.00', 'Warm winter boots. Like new condition.', NULL, 'buyer', 'active', 134, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(17, 3, 'Tennis Skirt', 'women', 'skirts', 'S', 'Lululemon', 'new', '55.00', 'Brand new with tags.', NULL, 'buyer', 'active', 67, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(18, 5, 'Dress Shirt', 'men', 'shirts', '15.5', 'Hugo Boss', 'excellent', '65.00', 'Professional dress shirt. Dry cleaned.', NULL, 'buyer', 'active', 89, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(19, 2, 'Crossbody Bag', 'accessories', 'bags', 'One Size', 'Michael Kors', 'good', '85.00', 'Gently used. Some wear on corners.', NULL, 'buyer', 'active', 198, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(20, 3, 'Yoga Pants', 'women', 'activewear', 'M', 'Lululemon', 'excellent', '60.00', 'Like new condition.', NULL, 'buyer', 'active', 123, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(21, 5, 'Hoodie', 'men', 'outerwear', 'XL', 'Supreme', 'good', '120.00', 'Streetwear hoodie. Minor fading.', NULL, 'buyer', 'active', 345, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(22, 2, 'Necklace', 'accessories', 'jewelry', 'One Size', 'Tiffany', 'excellent', '300.00', 'Silver necklace. Beautiful condition.', NULL, 'buyer', 'active', 267, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(23, 3, 'Blazer', 'men', 'jackets', '40R', 'Armani', 'excellent', '175.00', 'Designer blazer. Worn twice.', NULL, 'buyer', 'active', 156, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(24, 5, 'Sneakers', 'men', 'shoes', '9', 'Adidas', 'good', '50.00', 'Yeezy style. Slight wear on soles.', NULL, 'buyer', 'active', 423, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(25, 2, 'Cardigan', 'women', 'sweaters', 'M', 'Ralph Lauren', 'excellent', '70.00', 'Classic cable knit cardigan.', NULL, 'buyer', 'active', 98, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(26, 3, 'Backpack', 'accessories', 'bags', 'One Size', 'North Face', 'good', '45.00', 'Great for school or hiking.', NULL, 'buyer', 'active', 156, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(27, 5, 'Swimsuit', 'women', 'swimwear', 'M', 'Speedo', 'new', '35.00', 'Never worn. Still has tags.', NULL, 'buyer', 'active', 67, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(28, 2, 'Tie', 'accessories', 'ties', 'One Size', 'Hermes', 'excellent', '150.00', 'Luxury silk tie.', NULL, 'buyer', 'active', 89, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(29, 3, 'Ski Jacket', 'men', 'outerwear', 'L', 'North Face', 'excellent', '200.00', 'Waterproof ski jacket. Used once.', NULL, 'buyer', 'active', 134, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(30, 5, 'Wallet', 'accessories', 'wallets', 'One Size', 'Louis Vuitton', 'good', '250.00', 'Designer wallet. Authentic.', NULL, 'buyer', 'active', 345, '2026-05-03 20:23:53', '2026-05-03 20:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessages`
--

DROP TABLE IF EXISTS `tblmessages`;
CREATE TABLE IF NOT EXISTS `tblmessages` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `itemID` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isRead` tinyint(1) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`messageID`),
  KEY `receiverID` (`receiverID`),
  KEY `itemID` (`itemID`),
  KEY `idx_conversation` (`senderID`,`receiverID`),
  KEY `idx_read_status` (`isRead`),
  KEY `idx_created` (`createdAt`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblmessages`
--

INSERT INTO `tblmessages` (`messageID`, `senderID`, `receiverID`, `itemID`, `message`, `isRead`, `createdAt`) VALUES
(1, 1, 2, 1, 'Is the denim jacket still available?', 1, '2026-05-03 20:23:53'),
(2, 2, 1, 1, 'Yes, it is! Would you like to purchase?', 1, '2026-05-03 20:23:53'),
(3, 3, 5, 3, 'What size are the boots?', 1, '2026-05-03 20:23:53'),
(4, 5, 3, 3, 'Size 38, fits true to size', 0, '2026-05-03 20:23:53'),
(5, 4, 2, 2, 'Can you do $40 for the blouse?', 1, '2026-05-03 20:23:53'),
(6, 2, 4, 2, 'I can do $42, final offer', 0, '2026-05-03 20:23:53'),
(7, 6, 3, 4, 'Is the coat still available?', 1, '2026-05-03 20:23:53'),
(8, 3, 6, 4, 'Yes, still available', 0, '2026-05-03 20:23:53'),
(9, 7, 5, 5, 'Is the handbag authentic?', 1, '2026-05-03 20:23:53'),
(10, 5, 7, 5, 'Yes, 100% authentic with box', 0, '2026-05-03 20:23:53'),
(11, 8, 2, 6, 'What material is the sweater?', 0, '2026-05-03 20:23:53'),
(12, 2, 8, 6, '100% cashmere', 0, '2026-05-03 20:23:53'),
(13, 9, 3, 7, 'Are these original Nike?', 1, '2026-05-03 20:23:53'),
(14, 3, 9, 7, 'Yes, authentic', 0, '2026-05-03 20:23:53'),
(15, 10, 5, 8, 'Can you ship internationally?', 0, '2026-05-03 20:23:53'),
(16, 5, 10, 8, 'Sorry, local shipping only', 0, '2026-05-03 20:23:53'),
(17, 11, 2, 9, 'What size is the dress?', 1, '2026-05-03 20:23:53'),
(18, 2, 11, 9, 'Size Small', 0, '2026-05-03 20:23:53'),
(19, 12, 3, 10, 'Is the scarf authentic Burberry?', 0, '2026-05-03 20:23:53'),
(20, 3, 12, 10, 'Yes, comes with dust bag', 0, '2026-05-03 20:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblorderitems`
--

DROP TABLE IF EXISTS `tblorderitems`;
CREATE TABLE IF NOT EXISTS `tblorderitems` (
  `orderItemID` int(11) NOT NULL AUTO_INCREMENT,
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `priceAtTime` decimal(10,2) NOT NULL,
  PRIMARY KEY (`orderItemID`),
  KEY `idx_order` (`orderID`),
  KEY `idx_item` (`itemID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblorderitems`
--

INSERT INTO `tblorderitems` (`orderItemID`, `orderID`, `itemID`, `quantity`, `priceAtTime`) VALUES
(1, 1, 1, 1, '68.00'),
(2, 2, 2, 1, '45.00'),
(3, 3, 3, 1, '89.00'),
(4, 4, 4, 1, '120.00'),
(5, 5, 5, 1, '199.00'),
(6, 6, 6, 1, '85.00'),
(7, 7, 7, 1, '75.00'),
(8, 8, 8, 1, '250.00'),
(9, 9, 9, 1, '35.00'),
(10, 10, 10, 1, '120.00'),
(11, 11, 11, 1, '95.00'),
(12, 12, 12, 1, '45.00'),
(13, 13, 13, 1, '180.00'),
(14, 14, 14, 1, '350.00'),
(15, 15, 15, 1, '250.00'),
(16, 16, 16, 1, '110.00'),
(17, 17, 17, 1, '55.00'),
(18, 18, 18, 1, '65.00'),
(19, 19, 19, 1, '85.00'),
(20, 20, 20, 1, '60.00'),
(21, 21, 21, 1, '120.00'),
(22, 22, 22, 1, '300.00'),
(23, 23, 23, 1, '175.00'),
(24, 24, 24, 1, '50.00'),
(25, 25, 25, 1, '70.00'),
(26, 26, 26, 1, '45.00'),
(27, 27, 27, 1, '35.00'),
(28, 28, 1, 2, '68.00'),
(29, 29, 3, 1, '89.00'),
(30, 30, 5, 1, '199.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
CREATE TABLE IF NOT EXISTS `tbluser` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('buyer','seller','both') COLLATE utf8mb4_unicode_ci DEFAULT 'buyer',
  `userStatus` enum('active','inactive','banned') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_status` (`userStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`userID`, `firstName`, `lastName`, `username`, `email`, `password`, `role`, `userStatus`, `remember_token`, `createdAt`, `updatedAt`) VALUES
(1, 'John', 'Doe', 'john.doe', 'john.doe@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(2, 'Jane', 'Smith', 'jane.smith', 'jane.smith@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(3, 'Sarah', 'Johnson', 'sarah.johnson', 'sarah.johnson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(4, 'Michael', 'Chen', 'michael.chen', 'michael.chen@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(5, 'Emily', 'Wilson', 'emily.wilson', 'emily.wilson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(6, 'David', 'Brown', 'david.brown', 'david.brown@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(7, 'Lisa', 'Garcia', 'lisa.garcia', 'lisa.garcia@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(8, 'James', 'Martinez', 'james.martinez', 'james.martinez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(9, 'Maria', 'Rodriguez', 'maria.rodriguez', 'maria.rodriguez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(10, 'Robert', 'Lee', 'robert.lee', 'robert.lee@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(11, 'Jennifer', 'Walker', 'jennifer.walker', 'jennifer.walker@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(12, 'William', 'Hall', 'william.hall', 'william.hall@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(13, 'Patricia', 'Young', 'patricia.young', 'patricia.young@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(14, 'Charles', 'King', 'charles.king', 'charles.king@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(15, 'Linda', 'Wright', 'linda.wright', 'linda.wright@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(16, 'Thomas', 'Lopez', 'thomas.lopez', 'thomas.lopez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(17, 'Barbara', 'Hill', 'barbara.hill', 'barbara.hill@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(18, 'Christopher', 'Scott', 'christopher.scott', 'christopher.scott@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(19, 'Jessica', 'Green', 'jessica.green', 'jessica.green@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(20, 'Daniel', 'Adams', 'daniel.adams', 'daniel.adams@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(21, 'Karen', 'Baker', 'karen.baker', 'karen.baker@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(22, 'Paul', 'Gonzalez', 'paul.gonzalez', 'paul.gonzalez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(23, 'Nancy', 'Nelson', 'nancy.nelson', 'nancy.nelson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(24, 'Mark', 'Carter', 'mark.carter', 'mark.carter@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(25, 'Sandra', 'Mitchell', 'sandra.mitchell', 'sandra.mitchell@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(26, 'George', 'Perez', 'george.perez', 'george.perez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(27, 'Betty', 'Roberts', 'betty.roberts', 'betty.roberts@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'both', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(28, 'Edward', 'Turner', 'edward.turner', 'edward.turner@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(29, 'Helen', 'Phillips', 'helen.phillips', 'helen.phillips@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'buyer', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53'),
(30, 'Kevin', 'Campbell', 'kevin.campbell', 'kevin.campbell@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', 'active', NULL, '2026-05-03 20:23:53', '2026-05-03 20:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblwishlist`
--

DROP TABLE IF EXISTS `tblwishlist`;
CREATE TABLE IF NOT EXISTS `tblwishlist` (
  `wishlistID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`wishlistID`),
  UNIQUE KEY `unique_wishlist` (`userID`,`itemID`),
  KEY `itemID` (`itemID`),
  KEY `idx_user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblwishlist`
--

INSERT INTO `tblwishlist` (`wishlistID`, `userID`, `itemID`, `createdAt`) VALUES
(1, 1, 2, '2026-05-03 20:23:53'),
(2, 1, 5, '2026-05-03 20:23:53'),
(3, 4, 1, '2026-05-03 20:23:53'),
(4, 4, 8, '2026-05-03 20:23:53'),
(5, 6, 3, '2026-05-03 20:23:53'),
(6, 6, 7, '2026-05-03 20:23:53'),
(7, 7, 4, '2026-05-03 20:23:53'),
(8, 7, 6, '2026-05-03 20:23:53'),
(9, 8, 2, '2026-05-03 20:23:53'),
(10, 8, 9, '2026-05-03 20:23:53'),
(11, 9, 1, '2026-05-03 20:23:53'),
(12, 9, 10, '2026-05-03 20:23:53'),
(13, 10, 5, '2026-05-03 20:23:53'),
(14, 10, 8, '2026-05-03 20:23:53'),
(15, 11, 3, '2026-05-03 20:23:53'),
(16, 11, 6, '2026-05-03 20:23:53'),
(17, 12, 4, '2026-05-03 20:23:53'),
(18, 12, 7, '2026-05-03 20:23:53'),
(19, 13, 2, '2026-05-03 20:23:53'),
(20, 13, 9, '2026-05-03 20:23:53'),
(21, 14, 1, '2026-05-03 20:23:53'),
(22, 14, 10, '2026-05-03 20:23:53'),
(23, 15, 5, '2026-05-03 20:23:53'),
(24, 15, 8, '2026-05-03 20:23:53'),
(25, 16, 3, '2026-05-03 20:23:53'),
(26, 16, 6, '2026-05-03 20:23:53'),
(27, 17, 4, '2026-05-03 20:23:53'),
(28, 17, 7, '2026-05-03 20:23:53'),
(29, 18, 2, '2026-05-03 20:23:53'),
(30, 18, 9, '2026-05-03 20:23:53'),
(31, 19, 1, '2026-05-03 20:23:53'),
(32, 19, 10, '2026-05-03 20:23:53'),
(33, 20, 5, '2026-05-03 20:23:53'),
(34, 20, 8, '2026-05-03 20:23:53'),
(35, 21, 3, '2026-05-03 20:23:53'),
(36, 21, 6, '2026-05-03 20:23:53'),
(37, 22, 4, '2026-05-03 20:23:53'),
(38, 22, 7, '2026-05-03 20:23:53'),
(39, 23, 2, '2026-05-03 20:23:53'),
(40, 23, 9, '2026-05-03 20:23:53'),
(41, 24, 1, '2026-05-03 20:23:53'),
(42, 24, 10, '2026-05-03 20:23:53'),
(43, 25, 5, '2026-05-03 20:23:53'),
(44, 25, 8, '2026-05-03 20:23:53'),
(45, 26, 3, '2026-05-03 20:23:53'),
(46, 26, 6, '2026-05-03 20:23:53'),
(47, 27, 4, '2026-05-03 20:23:53'),
(48, 27, 7, '2026-05-03 20:23:53'),
(49, 28, 2, '2026-05-03 20:23:53'),
(50, 28, 9, '2026-05-03 20:23:53'),
(51, 29, 1, '2026-05-03 20:23:53'),
(52, 29, 10, '2026-05-03 20:23:53'),
(53, 30, 5, '2026-05-03 20:23:53'),
(54, 30, 8, '2026-05-03 20:23:53');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblaorder`
--
ALTER TABLE `tblaorder`
  ADD CONSTRAINT `tblaorder_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `tblclothes`
--
ALTER TABLE `tblclothes`
  ADD CONSTRAINT `tblclothes_ibfk_1` FOREIGN KEY (`sellerID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `tblmessages`
--
ALTER TABLE `tblmessages`
  ADD CONSTRAINT `tblmessages_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblmessages_ibfk_2` FOREIGN KEY (`receiverID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblmessages_ibfk_3` FOREIGN KEY (`itemID`) REFERENCES `tblclothes` (`itemID`) ON DELETE SET NULL;

--
-- Constraints for table `tblorderitems`
--
ALTER TABLE `tblorderitems`
  ADD CONSTRAINT `tblorderitems_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `tblaorder` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblorderitems_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `tblclothes` (`itemID`) ON DELETE CASCADE;

--
-- Constraints for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  ADD CONSTRAINT `tblwishlist_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `tbluser` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblwishlist_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `tblclothes` (`itemID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

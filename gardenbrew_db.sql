-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 06:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gardenbrew_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(100) NOT NULL,
  `admin_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod_size` varchar(50) NOT NULL,
  `prod_total` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_qty` int(11) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `status` enum('pending','approved','ongoing','completed','canceled') NOT NULL DEFAULT 'pending',
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `date_approved` datetime DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `payment_mode`, `status`, `order_date`, `date_approved`, `canceled_at`, `date_completed`) VALUES
(19, 4, 'gcash', 'canceled', '2024-05-26 09:56:06', NULL, '2024-05-26 10:09:49', NULL),
(20, 4, 'cod', 'completed', '2024-05-26 09:56:37', NULL, NULL, NULL),
(21, 4, 'cod', 'completed', '2024-05-26 10:09:45', '2024-05-26 12:03:50', NULL, '2024-05-26 12:07:46'),
(22, 4, 'gcash', 'completed', '2024-05-26 10:15:13', '0000-00-00 00:00:00', NULL, '2024-05-26 12:07:45'),
(23, 4, 'cod', 'completed', '2024-05-26 10:43:11', NULL, NULL, '2024-05-26 12:07:44'),
(24, 4, 'cod', 'completed', '2024-05-26 11:04:22', NULL, NULL, '2024-05-26 12:06:57'),
(25, 4, 'cod', 'completed', '2024-05-26 12:05:37', '2024-05-26 12:07:38', NULL, '2024-05-26 12:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod_size` varchar(100) NOT NULL,
  `prod_qty` int(11) NOT NULL,
  `prod_total` int(11) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_id`, `prod_id`, `prod_name`, `prod_price`, `prod_size`, `prod_qty`, `prod_total`, `prod_img`, `user_id`) VALUES
(8, 5, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(9, 5, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(10, 5, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(11, 5, 4, 'Strawberry', 39, '16oz', 1, 39, 'strawberry.png', 4),
(12, 5, 5, 'Wintermelon', 39, '16oz', 1, 39, 'wintermelon.png', 4),
(13, 6, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(14, 6, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(15, 7, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(16, 7, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(17, 8, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(18, 8, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(19, 9, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(20, 10, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(21, 11, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(22, 12, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(23, 13, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(24, 13, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(25, 13, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(26, 13, 4, 'Strawberry', 39, '16oz', 1, 39, 'strawberry.png', 4),
(27, 13, 5, 'Wintermelon', 39, '16oz', 1, 39, 'wintermelon.png', 4),
(28, 14, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(29, 14, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(30, 14, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 4),
(31, 14, 4, 'Strawberry', 39, '16oz', 1, 39, 'strawberry.png', 4),
(32, 14, 5, 'Wintermelon', 39, '16oz', 1, 39, 'wintermelon.png', 4),
(33, 15, 15, 'Caffe Latte', 39, '8oz', 4, 156, 'caffe_latte.png', 5),
(34, 16, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 14),
(35, 17, 3, 'Matcha', 39, '16oz', 2, 78, 'matcha.png', 4),
(36, 18, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(37, 19, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(38, 19, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(39, 19, 5, 'Wintermelon', 39, '16oz', 1, 39, 'wintermelon.png', 4),
(40, 19, 4, 'Strawberry', 39, '16oz', 1, 39, 'strawberry.png', 4),
(41, 20, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(42, 21, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 4),
(43, 21, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(44, 22, 2, 'Dark Chocolate', 39, '16oz', 6, 234, 'dark_choco.png', 4),
(45, 23, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(46, 24, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4),
(47, 25, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(90) NOT NULL,
  `prod_price` int(11) NOT NULL DEFAULT 0,
  `prod_img` varchar(500) NOT NULL,
  `prod_size` varchar(50) NOT NULL,
  `is_available` int(11) DEFAULT 1,
  `category` enum('Classic','Special','Premium','Hot','Fries','Pizza') NOT NULL,
  `prod_desc` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_name`, `prod_price`, `prod_img`, `prod_size`, `is_available`, `category`, `prod_desc`, `created_at`, `updated_at`) VALUES
(1, 'Cookies and Cream', 0, 'cookies_and_cream.png', '16', 1, 'Classic', 'A delightful mix of creamy milk tea and sweet chocolate cookie crumbs', '2024-05-23 15:08:44', '2024-05-25 13:08:57'),
(2, 'Dark Chocolate', 0, 'dark_choco.png', '16', 1, 'Classic', 'A rich blend of smooth milk tea and decadent dark chocolate for a deeply satisfying treat', '2024-05-23 15:09:28', '2024-05-25 13:09:57'),
(3, 'Matcha', 0, 'matcha.png', '16', 1, 'Classic', 'A refreshing blend of creamy milk tea and earthy matcha green tea for a smooth, invigorating flavor', '2024-05-23 15:10:13', '2024-05-25 13:09:03'),
(4, 'Strawberry', 0, 'strawberry.png', '16', 1, 'Classic', 'A delightful blend of creamy milk tea and sweet, juicy strawberries', '2024-05-23 15:11:01', '2024-05-25 13:09:05'),
(5, 'Wintermelon', 0, 'wintermelon.png', '16', 1, 'Classic', 'A sweet and refreshing blend of creamy milk tea and the unique flavor of wintermelon', '2024-05-23 19:54:57', '2024-05-25 13:09:07'),
(6, 'Strawberrry Cream', 0, 'strawberrry_cream.png', '16', 1, 'Special', 'A luscious blend of creamy milk tea and sweet, fresh strawberries', '2024-05-25 13:56:19', '2024-05-25 13:58:05'),
(7, 'Milky Mango', 0, 'milky_mango.png', '16', 1, 'Special', 'A tropical blend of creamy milk tea and sweet, ripe mangoes', '2024-05-25 13:56:19', '2024-05-25 13:58:23'),
(8, 'Choco Strawberry', 0, 'choco_strawberry.png', '16', 1, 'Special', 'A delicious blend of creamy milk tea, rich chocolate, and sweet strawberries', '2024-05-25 13:57:34', '2024-05-25 13:58:38'),
(9, 'Choco Matcha', 0, 'choco_matcha.png', '16', 1, 'Special', 'A unique blend of creamy milk tea, rich chocolate, and earthy matcha', '2024-05-25 13:57:34', '2024-05-25 13:59:14'),
(10, 'Double Cookies & Cream', 0, 'double_cookies_cream.png', '22', 1, 'Premium', 'An extra indulgent blend of creamy milk tea with double the sweet chocolate cookie goodness', '2024-05-25 14:36:58', '2024-05-25 15:22:05'),
(11, 'Premium Dark Chocolate', 0, 'premium_dark_chocolate.png', '22', 1, 'Premium', 'A luxurious blend of creamy milk tea and rich, premium dark chocolate', '2024-05-25 14:36:58', '2024-05-25 15:22:45'),
(12, 'Premium Taro', 0, 'premium_taro.png', '22', 1, 'Premium', 'A smooth blend of creamy milk tea and the rich, nutty flavor of premium taro', '2024-05-25 14:36:58', '2024-05-25 15:23:20'),
(13, 'Premium Wintermelon', 0, 'premium_wintermelon.png', '22', 1, 'Premium', 'A refined blend of creamy milk tea and the sweet, refreshing flavor of premium wintermelon', '2024-05-25 14:36:58', '2024-05-25 15:23:41'),
(14, 'Espresso Latte', 0, 'espresso_latte.png', '8', 1, 'Hot', 'A bold blend of creamy milk tea and robust espresso for a perfect pick-me-up', '2024-05-25 15:41:10', '2024-05-25 16:57:02'),
(15, 'Caffe Latte', 0, 'caffe_latte.png', '8', 1, 'Hot', 'A smooth blend of creamy milk tea and rich, aromatic coffee', '2024-05-25 15:44:04', '2024-05-25 16:57:32'),
(16, 'Cappuccino', 0, 'cappuccino.png', '8', 1, 'Hot', 'A perfect blend of creamy milk tea and bold, frothy cappuccino', '2024-05-25 15:44:04', '2024-05-25 16:57:49'),
(17, 'Caramel Macchiato', 0, 'caramel_macchiato.png', '8', 1, 'Hot', 'Caramel Macchiato', '2024-05-25 15:44:04', '2024-05-25 16:57:57'),
(18, 'Caffe Mocha', 0, 'caffe_mocha.png', '8', 1, 'Hot', 'Caffe Mocha', '2024-05-25 15:44:04', '2024-05-25 16:58:08'),
(19, 'Cheese', 0, 'cheese.png', 'Single', 1, 'Fries', 'Crispy golden fries topped with a generous layer of creamy, melted cheese', '2024-05-25 18:37:26', '2024-05-25 19:13:43'),
(20, 'BBQ', 0, 'bbq.png', 'Single', 1, 'Fries', 'Crispy golden fries seasoned with bold and tangy BBQ flavor', '2024-05-25 18:38:33', '2024-05-25 19:13:47'),
(21, 'Sour Cream', 0, 'sour_cream.png', 'Single', 1, 'Fries', 'Crispy golden fries coated with a tangy and savory sour cream seasoning', '2024-05-25 18:38:33', '2024-05-25 19:13:52'),
(22, 'Cheesy Overload', 0, 'cheesy__overload.png', 'Solo', 1, 'Pizza', NULL, '2024-05-25 19:09:58', '2024-05-25 19:14:06'),
(23, 'Ham & Cheese', 0, 'ham_cheese.png', 'Solo', 1, 'Pizza', NULL, '2024-05-25 19:09:58', '2024-05-25 19:14:10'),
(24, 'Bacon Ham and Cheese', 0, 'bacon_ham_cheese.png', 'Solo', 1, 'Pizza', NULL, '2024-05-25 19:09:58', '2024-05-25 19:14:14'),
(25, 'Pepperoni', 0, 'pepperoni.png', 'Solo', 1, 'Pizza', NULL, '2024-05-25 19:09:58', '2024-05-25 19:14:17'),
(26, 'Four Seasons', 0, 'four_seasons.png', 'Solo', 1, 'Pizza', NULL, '2024-05-25 19:09:58', '2024-05-25 19:14:21'),
(27, 'Pork Salami', 0, 'pork_salami.png', 'Solo', 1, 'Pizza', NULL, '2024-05-25 19:09:58', '2024-05-25 19:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `address` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `username`, `email`, `password`, `phone_number`, `address`, `created_at`, `updated_at`) VALUES
(4, 'Ericson', 'Palisoc', 'cullen', '', '$2y$10$q54pcWOu43pbmOUjcBG7OuE.eYrgyKqfCG2jfUh8L3Hw4aSEUniAO', '0915803565', 'Urbiztondo', '2024-05-24 01:57:11', '2024-05-24 07:42:43'),
(5, 'Leon', 'Balverde', 'poks', '', '$2y$10$hO23dDrUmqx2cOp5VRFhFelfFus4C50Gs5UW.FZUFNi.QBE6dJPm6', '091580353563', 'Luna', '2024-05-24 06:17:34', '2024-05-24 06:17:34'),
(6, 'asdf', 'sasdf', 'asdfadfad', '', '$2y$10$QHl0crCxAFJXD2OYSeP8SOmGtwj0wDD8uxg4Lj4OBZpazM3BxfInq', '123123123', 'asdfadfadf', '2024-05-24 07:22:29', '2024-05-24 07:22:29'),
(10, 'Kristine', 'Pacania', 'kristine', '', '$2y$10$p7goU2y5C9eBT7FbcTOlw.cBf/dJ9eBl5IIPboMam/4TftUQWAXIm', '1234123414', 'SCCP', '2024-05-24 07:27:59', '2024-05-24 07:27:59'),
(14, 'qwe', 'qwe', 'qwe', '', '$2y$10$Gv6RbgeveTZo2D9qQDlNyO.26q42JucR92KPFNNwd6HJ1yG.kGgT.', '123123', 'qweqwe', '2024-05-26 01:32:09', '2024-05-26 01:32:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_items_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

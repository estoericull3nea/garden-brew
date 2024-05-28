-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 11:57 PM
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
  `status` enum('pending','approved','ongoing','delivered','canceled','denied') NOT NULL DEFAULT 'pending',
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `date_approved` datetime DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `date_delivered` datetime DEFAULT NULL,
  `date_ongoing_started` datetime DEFAULT NULL,
  `date_denied` datetime DEFAULT NULL,
  `why_denied` varchar(200) DEFAULT NULL,
  `user_feedback` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `payment_mode`, `status`, `order_date`, `date_approved`, `canceled_at`, `date_delivered`, `date_ongoing_started`, `date_denied`, `why_denied`, `user_feedback`) VALUES
(48, 24, 'cod', 'delivered', '2024-05-27 21:12:45', '2024-05-27 21:13:35', NULL, '2024-05-27 21:13:36', '2024-05-27 21:13:36', NULL, NULL, 'hello'),
(49, 24, 'cod', 'delivered', '2024-05-27 21:31:34', '2024-05-27 21:32:09', NULL, '2024-05-27 21:32:18', '2024-05-27 21:32:18', NULL, NULL, 'good'),
(56, 24, 'cod', 'denied', '2024-05-27 22:27:21', NULL, NULL, NULL, NULL, '2024-05-27 22:45:52', 'spamming', NULL),
(57, 24, 'cod', 'delivered', '2024-05-27 23:37:46', '2024-05-27 23:37:53', NULL, '2024-05-27 23:37:55', '2024-05-27 23:37:55', NULL, NULL, 'this is my feedback for you'),
(58, 24, 'cod', 'delivered', '2024-05-27 23:57:40', '2024-05-27 23:57:50', NULL, '2024-05-27 23:58:22', '2024-05-27 23:58:14', NULL, NULL, NULL),
(59, 24, 'cod', 'delivered', '2024-05-27 23:59:18', '2024-05-27 23:59:51', NULL, '2024-05-28 06:28:15', '2024-05-27 23:59:52', NULL, NULL, NULL),
(60, 24, 'cod', 'canceled', '2024-05-28 06:16:39', NULL, '2024-05-28 06:16:50', NULL, NULL, NULL, NULL, NULL),
(61, 24, 'cod', 'canceled', '2024-05-28 06:20:23', NULL, '2024-05-28 06:22:54', NULL, NULL, NULL, NULL, NULL),
(62, 24, 'cod', 'delivered', '2024-05-28 06:24:40', '2024-05-28 06:25:43', NULL, '2024-05-28 06:26:05', '2024-05-28 06:26:00', NULL, NULL, NULL),
(63, 24, 'cod', 'pending', '2024-05-28 06:28:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 26, 'cod', 'pending', '2024-05-29 05:40:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(105, 48, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 24),
(106, 48, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 24),
(107, 48, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 24),
(108, 48, 4, 'Strawberry', 39, '16oz', 1, 39, 'strawberry.png', 24),
(109, 48, 5, 'Wintermelon', 39, '16oz', 1, 39, 'wintermelon.png', 24),
(110, 49, 14, 'Espresso Latte', 39, '8oz', 1, 39, 'espresso_latte.png', 24),
(111, 49, 15, 'Caffe Latte', 39, '8oz', 1, 39, 'caffe_latte.png', 24),
(112, 49, 16, 'Cappuccino', 39, '8oz', 1, 39, 'cappuccino.png', 24),
(113, 49, 17, 'Caramel Macchiato', 39, '8oz', 5, 195, 'caramel_macchiato.png', 24),
(114, 49, 18, 'Caffe Mocha', 39, '8oz', 1, 39, 'caffe_mocha.png', 24),
(115, 50, 6, 'Strawberrry Cream', 69, '22oz', 2, 138, 'strawberrry_cream.png', 24),
(116, 51, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 24),
(117, 52, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 24),
(118, 53, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 24),
(119, 54, 1, 'Cookies and Cream', 39, '16oz', 1, 39, 'cookies_and_cream.png', 24),
(120, 55, 4, 'Strawberry', 39, '16oz', 1, 39, 'strawberry.png', 24),
(121, 56, 10, 'Double Cookies & Cream', 49, '22oz', 1, 49, 'double_cookies_cream.png', 24),
(122, 56, 11, 'Premium Dark Chocolate', 49, '22oz', 1, 49, 'premium_dark_chocolate.png', 24),
(123, 57, 109, 'qwe qwe', 49, '22oz', 1, 49, 'gb_latest.drawio.png', 24),
(124, 58, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 24),
(125, 59, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 24),
(126, 60, 3, 'Matcha', 39, '16oz', 1, 39, 'matcha.png', 24),
(127, 61, 2, 'Dark Chocolate', 39, '16oz', 2, 78, 'dark_choco.png', 24),
(128, 62, 2, 'Dark Chocolate', 39, '16oz', 1, 39, 'dark_choco.png', 24),
(129, 63, 1, 'Cookies and Cream', 39, '16oz', 4, 156, 'cookies_and_cream.png', 24),
(130, 64, 109, 'qwe qwe', 49, '22oz', 1, 49, 'gb_latest.drawio.png', 26),
(131, 64, 109, 'qwe qwe', 39, '16oz', 1, 39, 'gb_latest.drawio.png', 26);

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
(17, 'Caramel Macchiato', 0, 'caramel_macchiato.png', '8', 1, 'Hot', 'espresso-based drink with vanilla syrup, steamed milk, and caramel sauce drizzled on top', '2024-05-25 15:44:04', '2024-05-26 23:50:14'),
(18, 'Caffe Mocha', 0, 'caffe_mocha.png', '8', 1, 'Hot', 'espresso-based drink with steamed milk, chocolate syrup, and often topped with whipped cream', '2024-05-25 15:44:04', '2024-05-26 23:50:34'),
(19, 'Cheese', 0, 'cheese.png', 'Single', 1, 'Fries', 'Crispy golden fries topped with a generous layer of creamy, melted cheese', '2024-05-25 18:37:26', '2024-05-25 19:13:43'),
(20, 'BBQ', 0, 'bbq.png', 'Single', 1, 'Fries', 'Crispy golden fries seasoned with bold and tangy BBQ flavor', '2024-05-25 18:38:33', '2024-05-25 19:13:47'),
(21, 'Sour Cream', 0, 'sour_cream.png', 'Single', 1, 'Fries', 'Crispy golden fries coated with a tangy and savory sour cream seasoning', '2024-05-25 18:38:33', '2024-05-25 19:13:52'),
(22, 'Cheesy Overload', 0, 'cheesy__overload.png', 'Solo', 1, 'Pizza', 'Cheesy Overload pizza: a rich, gooey blend of cheeses on a classic crust, perfect for cheese lovers', '2024-05-25 19:09:58', '2024-05-26 23:39:40'),
(23, 'Ham & Cheese', 0, 'ham_cheese.png', 'Solo', 1, 'Pizza', 'Ham & Cheese pizza: savory ham and melted cheese on a classic crust, a perfect pairing', '2024-05-25 19:09:58', '2024-05-26 23:40:11'),
(24, 'Bacon Ham and Cheese', 0, 'bacon_ham_cheese.png', 'Solo', 1, 'Pizza', 'Bacon Ham and Cheese pizza: crispy bacon, savory ham, and melted cheese on a classic crust', '2024-05-25 19:09:58', '2024-05-26 23:40:35'),
(25, 'Pepperoni', 0, 'pepperoni.png', 'Solo', 1, 'Pizza', 'Pepperoni pizza: classic crust topped with spicy pepperoni and melted cheese', '2024-05-25 19:09:58', '2024-05-26 23:41:03'),
(26, 'Four Seasons', 0, 'four_seasons.png', 'Solo', 1, 'Pizza', 'Four Seasons pizza: a classic crust divided into sections with diverse toppings representing the four seasons', '2024-05-25 19:09:58', '2024-05-26 23:41:26'),
(27, 'Pork Salami', 0, 'pork_salami.png', 'Solo', 1, 'Pizza', 'Pork Salami pizza: savory pork salami and melted cheese on a classic crust', '2024-05-25 19:09:58', '2024-05-26 23:41:42'),
(113, 'qwe', 39, 'gb_latest.drawio.png', '39', 1, 'Hot', 'sdafsdf', '2024-05-29 05:56:27', '2024-05-29 05:56:27');

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
(24, 'Kristine', 'Pacania', 'kristine', '', '$2y$10$iS1rUvryvNPk8qg7yaesdeahgBaie8FkhVMePtP9Ih5VR.dktdp/O', '09158033561', 'Doyong, SCCP', '2024-05-27 21:12:31', '2024-05-27 21:12:31'),
(25, 'Arabella', 'Cancino', 'arabella', '', '$2y$10$bA3jCpqW4.vCEA3Tnc6ZOO2SJC0GQXcslrx.CrGS1XhEveP3nrCJ6', '53495024234', 'Matagdem, SCCP', '2024-05-28 00:05:07', '2024-05-28 00:05:07'),
(26, 'Ericson', 'Palisoc', 'cullen', '', '$2y$10$r0EWStXF3Sp8Whs4/33.hePsC58xxwpN/65FMURze2lmLUmB87ZpS', '84758239408', 'Urbiztondo', '2024-05-28 00:05:48', '2024-05-28 00:05:48');

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

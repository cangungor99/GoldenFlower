-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2024 at 04:11 AM
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
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(15, 44, 6, 2),
(16, 44, 7, 1),
(26, 87, 46, 4),
(27, NULL, 50, NULL),
(28, NULL, 50, NULL),
(29, NULL, 50, NULL),
(30, NULL, 50, NULL),
(31, NULL, 50, NULL),
(32, NULL, 50, NULL),
(33, NULL, 50, NULL),
(34, NULL, 50, NULL),
(35, NULL, 50, NULL),
(36, NULL, 50, NULL),
(37, NULL, 50, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `ptype` enum('Meal','Drink','Dessert') NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `content`, `price`, `ptype`, `image_path`) VALUES
(49, 'Golden Burger', 'Its our chefs special', 220.00, 'Meal', 'uploads/burger.jpeg'),
(50, 'Pide', 'Turkish Pide', 230.00, 'Meal', 'uploads/pide.jpeg'),
(51, 'Frozen', 'Strawberry milkshake ', 120.00, 'Drink', 'uploads/watermelon.jpeg'),
(52, 'Turkish Cigarrette Börek', 'Turkish Börek', 80.00, 'Meal', 'uploads/sigaraboregi.jpeg'),
(53, 'Beer', 'Cold beer', 65.00, 'Drink', 'uploads/indir.jpeg'),
(54, 'Roasted Beef', 'Roasted Beef', 280.00, 'Meal', 'uploads/beef.jpeg'),
(55, 'Alcohol Coctail ', 'it contains %38 alcohol', 90.00, 'Drink', 'uploads/indir (1).jpeg'),
(56, 'Pasta', 'Pasta with sauce', 145.00, 'Meal', 'uploads/makarna.jpeg'),
(57, 'Dry Aged Beef', '48 hour dry aged', 380.00, 'Meal', 'uploads/roasted beef.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_mail` varchar(250) NOT NULL,
  `user_password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `user_name`, `user_mail`, `user_password`) VALUES
(88, 'test', 'testyeni@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

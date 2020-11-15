-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2020 at 08:19 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `orderId` int(11) DEFAULT 0,
  `createdDatetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartId`, `clientId`, `productId`, `quantity`, `price`, `status`, `orderId`, `createdDatetime`) VALUES
(1, 1, 3, 1, '1000.00', 1, 1, '2020-11-15 07:01:30'),
(2, 1, 8, 1, '500.00', 1, 1, '2020-11-15 07:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `clientName` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `createddatetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `clientName`, `email`, `mobile`, `status`, `createddatetime`) VALUES
(1, 'Test UserA1', 'user1@gmail.com', '7896541230', 1, '2020-11-11 12:49:54'),
(2, 'Test User2', 'user2@gmail.com', '7896541231', 1, '2020-11-11 12:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `cartId` int(11) DEFAULT NULL,
  `orderPrice` decimal(10,2) NOT NULL,
  `currentCurrencyId` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `deliveryFee` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `pincode` int(11) NOT NULL,
  `orderStatus` int(11) NOT NULL,
  `createdDateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `clientId`, `cartId`, `orderPrice`, `currentCurrencyId`, `tax`, `discount`, `deliveryFee`, `totalPrice`, `address`, `city`, `state`, `country`, `mobile`, `pincode`, `orderStatus`, `createdDateTime`) VALUES
(1, 1, NULL, '21.43', 2, NULL, NULL, '0.71', '22.14', 'Madhurawada', 'Vizag', 'Andhra Pradesh', 'India', '08121712027', 530048, 1, '2020-11-15 07:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `prodStatus` int(11) NOT NULL,
  `createdDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productName`, `price`, `prodStatus`, `createdDateTime`) VALUES
(1, 'Chicken Pizza', '250.00', 1, '2020-11-11 12:55:57'),
(2, 'Pizza Mushroom', '500.00', 1, '2020-11-11 12:55:57'),
(3, 'Pizza Margherita', '1000.00', 1, '2020-11-11 12:55:57'),
(4, 'Pizza Pepperoni', '800.00', 0, '2020-11-11 12:55:57'),
(5, 'Pizza Capricciosa', '450.00', 1, '2020-11-11 12:55:57'),
(6, 'Pizza Marinara', '500.00', 1, '2020-11-11 15:30:01'),
(7, 'Pizza Hawaiin', '500.00', 1, '2020-11-11 15:30:01'),
(8, 'Pizza Mexican', '500.00', 1, '2020-11-11 15:30:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

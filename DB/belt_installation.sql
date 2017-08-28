-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2017 at 10:54 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belt_installation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `name` char(70) NOT NULL,
  `email` char(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=Inactive, 1=Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `remember_token`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'sagarr@webplanex.com', '$2y$10$oxeb0qL3KuCiZqo/y9sslOG7b.jZKOyoUR4QafJ1i7Q.ZbtfXE8Iu', 'UlYXxKn20vm3nN9YIB2sMQ4umkbgRmFOfxf4xbIfY8EFioRsdnpFj25wt5EU', '1', '0000-00-00 00:00:00', '2017-03-21 12:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0-Inactive, 1-Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(3, 'Honda', '1', '2017-03-21 05:21:57', '2017-03-21 05:57:35'),
(4, 'LEXUS', '1', '2017-04-04 08:10:36', '2017-04-04 08:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0-Inactive, 1-Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `brand_id`, `model_name`, `active`, `created_at`, `updated_at`) VALUES
(3, 3, 'CIVIC', '1', '2017-03-21 07:43:04', '2017-03-21 07:10:00'),
(4, 3, 'ACCORD', '1', '2017-03-21 07:43:04', '2017-03-21 07:10:00'),
(5, 4, 'GS 460', '1', '2017-04-04 08:22:36', '2017-04-04 08:22:36'),
(6, 4, 'GS 470', '1', '2017-04-04 08:30:36', '2017-04-04 08:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `model_details`
--

CREATE TABLE `model_details` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `from_year` varchar(20) NOT NULL,
  `to_year` varchar(20) NOT NULL,
  `clyinders` varchar(100) NOT NULL,
  `liters` float NOT NULL,
  `main_belt` varchar(100) NOT NULL,
  `power_steering_belt` varchar(100) NOT NULL,
  `alternator_belt` varchar(100) NOT NULL,
  `air_con_belt` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0-Inactive, 1-Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_details`
--

INSERT INTO `model_details` (`id`, `model_id`, `from_year`, `to_year`, `clyinders`, `liters`, `main_belt`, `power_steering_belt`, `alternator_belt`, `air_con_belt`, `image`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, '1993', '2000', '4', 1.5, 'V6', 'Av2106', '652-659', '54sa45', '1490091387.jpg', '0', '2017-03-21 10:27:16', '2017-03-21 10:20:07'),
(4, 3, '2011', '2015', '456', 2.03, 'asd', 'asd', 'asd', 'asd', '1490159050.jpg', '1', '2017-03-22 05:10:04', '2017-03-22 05:04:45'),
(5, 3, '2009', '2009', '45', 45, 'fgh', 'fgh', 'fh', '', '1490163185.jpg', '1', '2017-03-22 06:05:13', '2017-03-22 06:13:06'),
(6, 5, '2010', '2017', '4', 3, '7PK 1755', '', '', '', '1491295117.jpg', '1', '2017-04-04 08:37:38', '2017-04-04 08:38:38'),
(7, 6, '2000', '2011', '4', 1.5, '7PK 1835', '4PK 0895', '', '', '1491295158.jpg', '1', '2017-04-04 08:17:39', '2017-04-04 08:39:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_details`
--
ALTER TABLE `model_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `model_details`
--
ALTER TABLE `model_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

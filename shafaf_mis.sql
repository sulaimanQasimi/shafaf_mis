-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2026 at 04:20 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6
DROP DATABASE IF EXISTS `shafaf_mis`;
CREATE DATABASE `shafaf_mis`;
USE `shafaf_mis`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shafaf_mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `base` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `base`) VALUES
(1, 'دالر', 1),
(2, 'افغانی', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `address` text COLLATE utf8mb4_persian_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_cate_id` int(50) NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL,
  `amount` float NOT NULL,
  `rate` float NOT NULL,
  `currenycy_id` int(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `to_ex_cat` (`ex_cate_id`),
  KEY `to_currency_id_1` (`currenycy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_categories`
--

CREATE TABLE `expenses_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_major`
--

CREATE TABLE `purchase_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(50) DEFAULT NULL,
  `reciept` float NOT NULL,
  `currency_id` int(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `to_supplier_id_1` (`supplier_id`),
  KEY `to_currency_id_2` (`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_minor`
--

CREATE TABLE `purchase_minor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_major_id` int(50) NOT NULL,
  `item_id_stock_major` int(50) NOT NULL,
  `amount` float NOT NULL,
  `purchase_price` float NOT NULL,
  `extra_expense` int(11) NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reciepts`
--

CREATE TABLE `reciepts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `amount` float NOT NULL,
  `currency_id` int(150) NOT NULL,
  `rate` float NOT NULL,
  `purchase_id` int(150) DEFAULT NULL,
  `sale_id` int(150) DEFAULT NULL,
  `date` date NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_major`
--

CREATE TABLE `sale_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(50) NOT NULL,
  `reciept` float NOT NULL,
  `currency_id` int(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_minor`
--

CREATE TABLE `sale_minor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` float NOT NULL,
  `sale_rate` float NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL,
  `purchase_minor_id` int(100) NOT NULL,
  `sale_major_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `address` text COLLATE utf8mb4_persian_ci NOT NULL,
  `image` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_major`
--

CREATE TABLE `stock_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(50) NOT NULL,
  `amount` float NOT NULL,
  `unit_id` int(50) NOT NULL,
  `minor_unit_id` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_minor`
--

CREATE TABLE `stock_minor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `address` text CHARACTER SET utf8mb4 NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_major`
--

CREATE TABLE `unit_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_minor`
--

CREATE TABLE `unit_minor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_major_id` int(50) NOT NULL,
  `unit_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `pack_quantity` float NOT NULL,
  `major_factor` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(50) NOT NULL,
  `user_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `authority` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `employee_id`, `user_name`, `password`, `authority`) VALUES
(2, 2, 'admin', 'YWRtaW4=', 'SuperAdmin'),
(3, 1, 'mohammad', 'bW9oYW1tYWQ=', 'SuperAdmin');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `company_address` text COLLATE utf8mb4_persian_ci NOT NULL,
  `company_phone` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `company_logo` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_list_of_sales`
-- (See below for the actual view)
--
CREATE TABLE `view_list_of_sales` (
`item_name` varchar(150)
,`purchase_date` date
,`unit_name` varchar(150)
,`purchase_price_t` double
,`id` int(11)
,`sale_major_id` int(50)
,`amount` float
,`details` text
,`sale_rate` float
);

-- --------------------------------------------------------

--
-- Structure for view `view_list_of_sales`
--
DROP TABLE IF EXISTS `view_list_of_sales`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_list_of_sales`  AS  select (select (select `stock_minor`.`item_name` from `stock_minor` where (`stock_minor`.`id` = `stock_major`.`item_id`)) from `stock_major` where (`stock_major`.`id` = `purchase_minor`.`item_id_stock_major`)) AS `item_name`,(select `purchase_major`.`date` from `purchase_major` where (`purchase_major`.`id` = `purchase_minor`.`purchase_major_id`)) AS `purchase_date`,(select `unit_minor`.`unit_name` from `unit_minor` where (`unit_minor`.`id` = (select `stock_major`.`minor_unit_id` from `stock_major` where (`stock_major`.`id` = `purchase_minor`.`item_id_stock_major`)))) AS `unit_name`,(`purchase_minor`.`purchase_price` + `purchase_minor`.`extra_expense`) AS `purchase_price_t`,`sale_minor`.`id` AS `id`,`sale_minor`.`sale_major_id` AS `sale_major_id`,`sale_minor`.`amount` AS `amount`,`sale_minor`.`details` AS `details`,`sale_minor`.`sale_rate` AS `sale_rate` from (`sale_minor` left join `purchase_minor` on((`sale_minor`.`purchase_minor_id` = `purchase_minor`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for dumped tables
-- (Primary keys and indexes already defined in CREATE TABLE statements)
--

--
-- Indexes for table `company_settings`
-- (Primary key already defined in CREATE TABLE)
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

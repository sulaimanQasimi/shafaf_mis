-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2022 at 12:02 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `base` int(10) NOT NULL
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
  `id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `address` text COLLATE utf8mb4_persian_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `ex_cate_id` int(50) NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL,
  `amount` float NOT NULL,
  `rate` float NOT NULL,
  `currenycy_id` int(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_categories`
--

CREATE TABLE `expenses_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `purchased_from_suppliers_list`
-- (See below for the actual view)
--
CREATE TABLE `purchased_from_suppliers_list` (
`id` int(11)
,`full_name` varchar(150)
,`phone_number` varchar(20)
,`address` text
,`date` date
,`total_purchase_price` double
,`total_reciept` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `purchased_invoices`
-- (See below for the actual view)
--
CREATE TABLE `purchased_invoices` (
`bill_number` int(11)
,`supplier_name` varchar(150)
,`currency_name` varchar(150)
,`purchase_date` date
,`total_reciept` float
,`total_purchased_price` double
,`total_extra_price` double
,`total_reciepts_price` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `purchased_items_list`
-- (See below for the actual view)
--
CREATE TABLE `purchased_items_list` (
`purchase_major_id` int(11)
,`purchase_minor_id` int(11)
,`minor_unit_name` varchar(150)
,`item_name` varchar(150)
,`amount` float
,`purchase_price` float
,`extra_expense` int(11)
,`details` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `purchased_items_list_by_unit_and_item_group`
-- (See below for the actual view)
--
CREATE TABLE `purchased_items_list_by_unit_and_item_group` (
);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_major`
--

CREATE TABLE `purchase_major` (
  `id` int(11) NOT NULL,
  `supplier_id` int(50) DEFAULT NULL,
  `reciept` float NOT NULL,
  `currency_id` int(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_minor`
--

CREATE TABLE `purchase_minor` (
  `id` int(11) NOT NULL,
  `purchase_major_id` int(50) NOT NULL,
  `item_id_stock_major` int(50) NOT NULL,
  `amount` float NOT NULL,
  `purchase_price` float NOT NULL,
  `extra_expense` int(11) NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reciepts`
--

CREATE TABLE `reciepts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `amount` float NOT NULL,
  `currency_id` int(150) NOT NULL,
  `rate` float NOT NULL,
  `purchase_id` int(150) DEFAULT NULL,
  `sale_id` int(150) DEFAULT NULL,
  `date` date NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `sales_to_customers_list`
-- (See below for the actual view)
--
CREATE TABLE `sales_to_customers_list` (
`id` int(11)
,`full_name` varchar(150)
,`phone_number` varchar(20)
,`address` text
,`date` date
,`total_sale_price` double
);

-- --------------------------------------------------------

--
-- Table structure for table `sale_major`
--

CREATE TABLE `sale_major` (
  `id` int(11) NOT NULL,
  `customer_id` int(50) NOT NULL,
  `reciept` float NOT NULL,
  `currency_id` int(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_minor`
--

CREATE TABLE `sale_minor` (
  `id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `sale_rate` float NOT NULL,
  `details` text COLLATE utf8mb4_persian_ci NOT NULL,
  `purchase_minor_id` int(100) NOT NULL,
  `sale_major_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `sold_invoices`
-- (See below for the actual view)
--
CREATE TABLE `sold_invoices` (
`bill_number` int(11)
,`customer_name` varchar(150)
,`currency_name` varchar(150)
,`sale_date` date
,`total_reciept` float
,`total_sold_price` double
,`total_reciepts_price` double
);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `address` text COLLATE utf8mb4_persian_ci NOT NULL,
  `image` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_major`
--

CREATE TABLE `stock_major` (
  `id` int(11) NOT NULL,
  `item_id` int(50) NOT NULL,
  `amount` float NOT NULL,
  `unit_id` int(50) NOT NULL,
  `minor_unit_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_minor`
--

CREATE TABLE `stock_minor` (
  `id` int(11) NOT NULL,
  `item_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `address` text COLLATE utf8mb4_persian_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_major`
--

CREATE TABLE `unit_major` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_minor`
--

CREATE TABLE `unit_minor` (
  `id` int(11) NOT NULL,
  `unit_major_id` int(50) NOT NULL,
  `unit_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `pack_quantity` float NOT NULL,
  `major_factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `employee_id` int(50) NOT NULL,
  `user_name` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL,
  `authority` varchar(150) COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `employee_id`, `user_name`, `password`, `authority`) VALUES
(2, 2, 'admin', 'YWRtaW4=', 'SuperAdmin'),
(3, 1, 'mohammad', 'bW9oYW1tYWQ=', 'SuperAdmin');

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
-- Structure for view `purchased_from_suppliers_list`
--
DROP TABLE IF EXISTS `purchased_from_suppliers_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `purchased_from_suppliers_list`  AS SELECT `suppliers`.`id` AS `id`, `suppliers`.`full_name` AS `full_name`, `suppliers`.`phone_number` AS `phone_number`, `suppliers`.`address` AS `address`, `suppliers`.`date` AS `date`, sum(`purchase_minor`.`purchase_price` * `purchase_minor`.`amount`) AS `total_purchase_price`, (select sum(`purchase_major`.`reciept`) from `purchase_major` where `purchase_major`.`supplier_id` = `suppliers`.`id`) AS `total_reciept` FROM ((`suppliers` left join `purchase_major` on(`suppliers`.`id` = `purchase_major`.`supplier_id`)) left join `purchase_minor` on(`purchase_minor`.`purchase_major_id` = `purchase_major`.`id`)) GROUP BY `suppliers`.`id``id`  ;

-- --------------------------------------------------------

--
-- Structure for view `purchased_invoices`
--
DROP TABLE IF EXISTS `purchased_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `purchased_invoices`  AS SELECT `purchase_major`.`id` AS `bill_number`, `suppliers`.`full_name` AS `supplier_name`, `currencies`.`name` AS `currency_name`, `purchase_major`.`date` AS `purchase_date`, `purchase_major`.`reciept` AS `total_reciept`, (select sum(`purchase_minor`.`purchase_price` * `purchase_minor`.`amount`) from `purchase_minor` where `purchase_minor`.`purchase_major_id` = `purchase_major`.`id`) AS `total_purchased_price`, (select sum(`purchase_minor`.`extra_expense` * `purchase_minor`.`amount`) from `purchase_minor` where `purchase_minor`.`purchase_major_id` = `purchase_major`.`id`) AS `total_extra_price`, (select sum(`reciepts`.`amount` / `reciepts`.`rate`) from `reciepts` where `reciepts`.`purchase_id` = `purchase_major`.`id`) AS `total_reciepts_price` FROM ((`purchase_major` left join `currencies` on(`currencies`.`id` = `purchase_major`.`currency_id`)) left join `suppliers` on(`suppliers`.`id` = `purchase_major`.`supplier_id`)) ORDER BY `purchase_major`.`id` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `purchased_items_list`
--
DROP TABLE IF EXISTS `purchased_items_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `purchased_items_list`  AS SELECT `purchase_major`.`id` AS `purchase_major_id`, `purchase_minor`.`id` AS `purchase_minor_id`, (select `unit_minor`.`unit_name` from `unit_minor` where `unit_minor`.`id` = `purchase_minor`.`item_id_stock_major`) AS `minor_unit_name`, (select `stock_minor`.`item_name` from `stock_minor` where `stock_minor`.`id` = (select `stock_major`.`item_id` from `stock_major` where `stock_major`.`id` = `purchase_minor`.`item_id_stock_major`)) AS `item_name`, `purchase_minor`.`amount` AS `amount`, `purchase_minor`.`purchase_price` AS `purchase_price`, `purchase_minor`.`extra_expense` AS `extra_expense`, `purchase_minor`.`details` AS `details` FROM (`purchase_minor` left join `purchase_major` on(`purchase_minor`.`purchase_major_id` = `purchase_major`.`id`)) WHERE `purchase_minor`.`purchase_major_id` = `purchase_major`.`id``id`  ;

-- --------------------------------------------------------

--
-- Structure for view `purchased_items_list_by_unit_and_item_group`
--
DROP TABLE IF EXISTS `purchased_items_list_by_unit_and_item_group`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `purchased_items_list_by_unit_and_item_group`  AS SELECT `purchase_minor`.`item_id_stock_major` AS `item_id_stock_major`, `purchase_minor`.`minor_unit_id` AS `minor_unit_id`, (select `stock_minor`.`item_name` from `stock_minor` where `stock_minor`.`id` = `purchase_minor`.`item_id_stock_major`) AS `item_name`, (select sum(`sale_minor`.`amount`) from `sale_minor` where `purchase_minor`.`id` = `sale_minor`.`purchase_minor_id`) AS `total_sold_quantity`, (select `unit_minor`.`unit_name` from `unit_minor` where `unit_minor`.`id` = `purchase_minor`.`minor_unit_id`) AS `unit_name`, (select `unit_major`.`unit_name` from `unit_major` where `unit_major`.`id` = (select `unit_minor`.`unit_major_id` from `unit_minor` where `unit_minor`.`id` = `purchase_minor`.`minor_unit_id`)) AS `major_unit`, sum(`purchase_minor`.`amount`) AS `total_amount` FROM `purchase_minor` GROUP BY `purchase_minor`.`minor_unit_id`, `purchase_minor`.`item_id_stock_major``item_id_stock_major`  ;

-- --------------------------------------------------------

--
-- Structure for view `sales_to_customers_list`
--
DROP TABLE IF EXISTS `sales_to_customers_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sales_to_customers_list`  AS SELECT `customers`.`id` AS `id`, `customers`.`full_name` AS `full_name`, `customers`.`phone_number` AS `phone_number`, `customers`.`address` AS `address`, `customers`.`date` AS `date`, sum(`sale_minor`.`sale_rate` * `sale_minor`.`amount`) AS `total_sale_price` FROM ((`customers` left join `sale_major` on(`customers`.`id` = `sale_major`.`customer_id`)) left join `sale_minor` on(`sale_minor`.`sale_major_id` = `sale_major`.`id`)) GROUP BY `customers`.`id``id`  ;

-- --------------------------------------------------------

--
-- Structure for view `sold_invoices`
--
DROP TABLE IF EXISTS `sold_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sold_invoices`  AS SELECT `sale_major`.`id` AS `bill_number`, `customers`.`full_name` AS `customer_name`, `currencies`.`name` AS `currency_name`, `sale_major`.`date` AS `sale_date`, `sale_major`.`reciept` AS `total_reciept`, (select sum(`sale_minor`.`sale_rate` * `sale_minor`.`amount`) from `sale_minor` where `sale_minor`.`sale_major_id` = `sale_major`.`id`) AS `total_sold_price`, (select sum(`reciepts`.`amount` / `reciepts`.`rate`) from `reciepts` where `reciepts`.`sale_id` = `sale_major`.`id`) AS `total_reciepts_price` FROM ((`sale_major` left join `currencies` on(`currencies`.`id` = `sale_major`.`currency_id`)) left join `customers` on(`customers`.`id` = `sale_major`.`customer_id`)) ORDER BY `sale_major`.`id` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `view_list_of_sales`
--
DROP TABLE IF EXISTS `view_list_of_sales`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_list_of_sales`  AS SELECT (select (select `stock_minor`.`item_name` from `stock_minor` where `stock_minor`.`id` = `stock_major`.`item_id`) from `stock_major` where `stock_major`.`id` = `purchase_minor`.`item_id_stock_major`) AS `item_name`, (select `purchase_major`.`date` from `purchase_major` where `purchase_major`.`id` = `purchase_minor`.`purchase_major_id`) AS `purchase_date`, (select `unit_minor`.`unit_name` from `unit_minor` where `unit_minor`.`id` = (select `stock_major`.`minor_unit_id` from `stock_major` where `stock_major`.`id` = `purchase_minor`.`item_id_stock_major`)) AS `unit_name`, `purchase_minor`.`purchase_price`+ `purchase_minor`.`extra_expense` AS `purchase_price_t`, `sale_minor`.`id` AS `id`, `sale_minor`.`sale_major_id` AS `sale_major_id`, `sale_minor`.`amount` AS `amount`, `sale_minor`.`details` AS `details`, `sale_minor`.`sale_rate` AS `sale_rate` FROM (`sale_minor` left join `purchase_minor` on(`sale_minor`.`purchase_minor_id` = `purchase_minor`.`id`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_ex_cat` (`ex_cate_id`),
  ADD KEY `to_currency_id_1` (`currenycy_id`);

--
-- Indexes for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_major`
--
ALTER TABLE `purchase_major`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_supplier_id_1` (`supplier_id`),
  ADD KEY `to_currency_id_2` (`currency_id`);

--
-- Indexes for table `purchase_minor`
--
ALTER TABLE `purchase_minor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_purchase_major` (`purchase_major_id`),
  ADD KEY `to_stock_major_id` (`item_id_stock_major`);

--
-- Indexes for table `reciepts`
--
ALTER TABLE `reciepts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_currency_3` (`currency_id`),
  ADD KEY `ro_purchase_major` (`purchase_id`),
  ADD KEY `to_sale_major` (`sale_id`);

--
-- Indexes for table `sale_major`
--
ALTER TABLE `sale_major`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_currency_4` (`currency_id`),
  ADD KEY `to_customer_id` (`customer_id`);

--
-- Indexes for table `sale_minor`
--
ALTER TABLE `sale_minor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_sale_major_2` (`sale_major_id`),
  ADD KEY `to_purchase_minor_2` (`purchase_minor_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_major`
--
ALTER TABLE `stock_major`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_stock_minor_id` (`item_id`),
  ADD KEY `to_major_unit` (`unit_id`),
  ADD KEY `to_unit_minor` (`minor_unit_id`);

--
-- Indexes for table `stock_minor`
--
ALTER TABLE `stock_minor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_major`
--
ALTER TABLE `unit_major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_minor`
--
ALTER TABLE `unit_minor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_unit_major_x` (`unit_major_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_categories`
--
ALTER TABLE `expenses_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_major`
--
ALTER TABLE `purchase_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_minor`
--
ALTER TABLE `purchase_minor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reciepts`
--
ALTER TABLE `reciepts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_major`
--
ALTER TABLE `sale_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_minor`
--
ALTER TABLE `sale_minor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_major`
--
ALTER TABLE `stock_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_minor`
--
ALTER TABLE `stock_minor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_major`
--
ALTER TABLE `unit_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_minor`
--
ALTER TABLE `unit_minor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `to_currency_id_1` FOREIGN KEY (`currenycy_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_ex_cat` FOREIGN KEY (`ex_cate_id`) REFERENCES `expenses_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_major`
--
ALTER TABLE `purchase_major`
  ADD CONSTRAINT `to_currency_id_2` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_supplier_id_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_minor`
--
ALTER TABLE `purchase_minor`
  ADD CONSTRAINT `to_purchase_major` FOREIGN KEY (`purchase_major_id`) REFERENCES `purchase_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_stock_major_id` FOREIGN KEY (`item_id_stock_major`) REFERENCES `stock_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reciepts`
--
ALTER TABLE `reciepts`
  ADD CONSTRAINT `ro_purchase_major` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_currency_3` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_sale_major` FOREIGN KEY (`sale_id`) REFERENCES `sale_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_major`
--
ALTER TABLE `sale_major`
  ADD CONSTRAINT `to_currency_4` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_minor`
--
ALTER TABLE `sale_minor`
  ADD CONSTRAINT `to_purchase_minor_2` FOREIGN KEY (`purchase_minor_id`) REFERENCES `purchase_minor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_sale_major_2` FOREIGN KEY (`sale_major_id`) REFERENCES `sale_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_major`
--
ALTER TABLE `stock_major`
  ADD CONSTRAINT `to_major_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_stock_minor_id` FOREIGN KEY (`item_id`) REFERENCES `stock_minor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `to_unit_minor` FOREIGN KEY (`minor_unit_id`) REFERENCES `unit_minor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `unit_minor`
--
ALTER TABLE `unit_minor`
  ADD CONSTRAINT `to_unit_major_x` FOREIGN KEY (`unit_major_id`) REFERENCES `unit_major` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

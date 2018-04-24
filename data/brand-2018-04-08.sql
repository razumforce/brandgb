-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 09, 2018 at 02:56 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brand`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `item_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) UNSIGNED NOT NULL,
  `shipping_id` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `is_in_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`item_id`, `color_id`, `size_id`, `quantity`, `shipping_id`, `user_id`, `is_in_order`) VALUES
(3, 1, 2, 1, 1, 21, 15),
(4, 1, 5, 1, 1, 21, 19),
(4, 1, 5, 1, 1, 21, 23),
(4, 1, 5, 1, 1, 22, 20),
(5, 2, 4, 1, 1, 21, 18),
(5, 2, 4, 1, 1, 22, 22),
(6, 3, 1, 1, 1, 1, 17),
(6, 3, 1, 1, 1, 21, 13),
(6, 3, 1, 1, 1, 21, 14),
(6, 3, 1, 1, 1, 21, 15),
(6, 3, 1, 1, 1, 21, 18),
(6, 3, 1, 1, 1, 22, 21),
(6, 3, 2, 3, 1, 23, 16),
(7, 1, 1, 1, 1, 21, 12),
(8, 1, 2, 4, 1, 21, 12);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `name`) VALUES
(1, 'MEN COLLECTION'),
(2, 'WOMEN COLLECTION'),
(3, 'KIDS COLLECTION'),
(4, 'ACCESSORIES');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id_color` int(11) NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id_color`, `name`, `code`) VALUES
(1, 'Red', '#f16d7f'),
(2, 'Black', '#000000'),
(3, 'Blue', '#000088');

-- --------------------------------------------------------

--
-- Table structure for table `designers`
--

CREATE TABLE `designers` (
  `id_designer` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `designers`
--

INSERT INTO `designers` (`id_designer`, `name`) VALUES
(1, 'BINBURHAN'),
(2, 'DESIGNTOP'),
(3, 'CREATOR'),
(4, 'DOLCE'),
(5, 'VERSACE');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(4) NOT NULL DEFAULT '0',
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(2048) NOT NULL,
  `short_description` text NOT NULL,
  `material_id` int(11) NOT NULL,
  `designer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id_item`, `name`, `price`, `category_id`, `status`, `date`, `views`, `rating`, `description`, `short_description`, `material_id`, `designer_id`) VALUES
(1, 'MANGO PEOPLE T-SHIRT', '52.00', 1, 1, '2018-03-06 20:20:05', 0, 7, 'xxxxxx', 'xxxx', 1, 1),
(2, 'MANGO  T-SHIRT', '62.00', 1, 1, '2018-03-06 20:28:36', 0, 0, 'sdgfssgrhsrth', 'fdgdff', 1, 1),
(3, 'XXX T-SHIRT', '110.11', 1, 2, '2018-03-06 20:29:25', 0, 0, 'dfgrsteghsbfb', 'fdgfdg', 2, 2),
(4, 'MANGO  T-SHIRT', '63.00', 1, 1, '2018-03-08 04:43:14', 0, 0, 'dsfaeerhbgfnth', 'sdfa', 1, 3),
(5, 'BLAZE LEGGINGS', '35.00', 2, 2, '2018-03-08 04:45:51', 0, 0, 'sdafsgfger', 'sdfdsf', 3, 4),
(6, 'ALEXA SWEATER', '45.00', 2, 1, '2018-03-08 04:45:51', 0, 2, 'agghterhqer', 'sdf', 1, 5),
(7, 'AGNES TOP', '22.22', 2, 1, '2018-03-08 04:45:51', 0, 0, 'dsagfdgfdg', 'sddssd', 1, 2),
(8, 'SYLVA SWEATER', '300.00', 2, 2, '2018-03-08 04:45:51', 0, 3, 'sdagfdg', 'sddds', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `items_colors`
--

CREATE TABLE `items_colors` (
  `item_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items_colors`
--

INSERT INTO `items_colors` (`item_id`, `color_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(7, 1),
(8, 1),
(1, 2),
(2, 2),
(3, 2),
(5, 2),
(7, 2),
(2, 3),
(6, 3),
(7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `items_sizes`
--

CREATE TABLE `items_sizes` (
  `item_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items_sizes`
--

INSERT INTO `items_sizes` (`item_id`, `size_id`) VALUES
(1, 1),
(6, 1),
(7, 1),
(1, 2),
(2, 2),
(3, 2),
(6, 2),
(8, 2),
(1, 3),
(2, 3),
(3, 3),
(6, 3),
(1, 4),
(3, 4),
(5, 4),
(1, 5),
(4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id_material` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id_material`, `name`) VALUES
(1, 'SILK'),
(2, 'COTTON'),
(3, 'WOOL');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int(11) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `date`, `quantity`, `amount`, `user_id`, `status_id`) VALUES
(12, '2018-03-15 10:15:13', 5, 1222, 21, 0),
(13, '2018-03-15 11:00:12', 1, 45, 21, 100),
(14, '2018-03-15 11:10:49', 1, 45, 21, 100),
(15, '2018-04-08 11:58:10', 2, 155, 21, 100),
(16, '2018-04-08 12:00:22', 3, 135, 23, 100),
(17, '2018-04-08 18:07:40', 1, 45, 1, 100),
(18, '2018-04-08 20:16:39', 2, 80, 21, 100),
(19, '2018-04-08 20:17:02', 1, 63, 21, 100),
(20, '2018-04-08 20:23:53', 1, 63, 22, 100),
(21, '2018-04-08 20:27:05', 1, 45, 22, 0),
(22, '2018-04-08 20:27:30', 1, 35, 22, 100),
(23, '2018-04-08 20:28:07', 1, 63, 21, 100);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id_status` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id_status`, `name`) VALUES
(0, 'created'),
(1, 'in process'),
(100, 'deleted');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id_photo` int(11) NOT NULL,
  `url` text NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id_photo`, `url`, `item_id`, `type`) VALUES
(1, '/img/featured1.png', 1, 0),
(2, '/img/featured2.png', 2, 0),
(3, '/img/featured3.png', 3, 0),
(4, '/img/featured4.png', 4, 0),
(5, '/img/featured5.png', 5, 0),
(6, '/img/featured6.png', 6, 0),
(7, '/img/featured7.png', 7, 0),
(8, '/img/featured8.png', 8, 0),
(9, '/img/single/product-big-photo.png', 1, 2),
(10, '/img/single/product-big-photo.png', 1, 1),
(11, '/img/single/product-big-photo.png', 2, 1),
(12, '/img/single/product-big-photo.png', 2, 2),
(13, '/img/single/product-big-photo.png', 2, 1),
(14, '/img/single/product-big-photo.png', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id_shipping` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id_shipping`, `name`) VALUES
(1, 'FREE');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id_size` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id_size`, `name`) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `comment` text,
  `status_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `login`, `password`, `comment`, `status_id`) VALUES
(1, 'test@test.test', 'test', '$2y$10$cRyauLZ2uXYj4wuUwGeXgOItp2eZibL3DsKf4OOyNWWo.LZ9Rc/yC', NULL, 9),
(21, 'aaa@aaa.ru', 'user25', '$2y$10$lm0pULMUxaEEmwe6QYwuc.AGUWHAiMLPFnL2WmZymewAR88QQFvJ2', '', 0),
(22, '777@aaa.ry', 'user777', '$2y$10$P7nBHsS8ijdIqP7.Cz/JLOD2N/SLhJsxtavNg2FRfX8bEOYEH8DGi', '', 0),
(23, 'test128@mail.ccc', 'test128', '$2y$10$QRbTA7BaDL16q0UaMCC86uU1/ChBaZKKPO4ygYU9EDGgCGiKCcZZC', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_auth`
--

CREATE TABLE `users_auth` (
  `id_user_session` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash_cookie` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_auth`
--

INSERT INTO `users_auth` (`id_user_session`, `user_id`, `hash_cookie`, `date`, `comment`) VALUES
(51, 1, 'f95e6b8cc5a2073869509e1bb10d1b62637df84cc666a322668f4fb5496d08fc', '2018-03-13', '1520930554.4948377493552824'),
(125, 21, '68c0ce51c35835f1146e3a3fce3f81396d71b415feb6df0beb64c8c117e573cb', '2018-03-14', '1521060290.7536885206748044'),
(138, 21, '9391f55cb452e2a8058806ef661dde128909bbd32214de5f792a036063f15b04', '2018-03-15', '1521100638.1151186265890356'),
(163, 21, '560dc52118b15d9d4c0037c7de2bea0c107ef93cdf2d25ac3a505ab647c1bd06', '2018-04-08', '1523183904.74139100892417685277111'),
(179, 1, '4cd526603f85779d87591d731e2cfd7237ab8659fa2d9c158fc5815a55c39119', '2018-04-08', '1523208506.1547728956328100547567');

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE `user_status` (
  `id_status` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`id_status`, `name`) VALUES
(0, 'user'),
(9, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`item_id`,`color_id`,`size_id`,`user_id`,`shipping_id`,`is_in_order`) USING BTREE,
  ADD KEY `is_in_order` (`is_in_order`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `shipping_id` (`shipping_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`);

--
-- Indexes for table `designers`
--
ALTER TABLE `designers`
  ADD PRIMARY KEY (`id_designer`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `designer_id` (`designer_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `items_colors`
--
ALTER TABLE `items_colors`
  ADD PRIMARY KEY (`item_id`,`color_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indexes for table `items_sizes`
--
ALTER TABLE `items_sizes`
  ADD PRIMARY KEY (`item_id`,`size_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id_material`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `fk_item_idx` (`item_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id_shipping`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id_size`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `index_login` (`login`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `users_auth`
--
ALTER TABLE `users_auth`
  ADD PRIMARY KEY (`id_user_session`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designers`
--
ALTER TABLE `designers`
  MODIFY `id_designer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id_shipping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id_size` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_auth`
--
ALTER TABLE `users_auth`
  MODIFY `id_user_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `basket_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id_color`),
  ADD CONSTRAINT `basket_ibfk_4` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id_size`),
  ADD CONSTRAINT `basket_ibfk_5` FOREIGN KEY (`shipping_id`) REFERENCES `shipping` (`id_shipping`),
  ADD CONSTRAINT `basket_ibfk_6` FOREIGN KEY (`item_id`) REFERENCES `items` (`id_item`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id_category`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`id_designer`),
  ADD CONSTRAINT `items_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id_material`);

--
-- Constraints for table `items_colors`
--
ALTER TABLE `items_colors`
  ADD CONSTRAINT `items_colors_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id_color`),
  ADD CONSTRAINT `items_colors_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id_item`);

--
-- Constraints for table `items_sizes`
--
ALTER TABLE `items_sizes`
  ADD CONSTRAINT `items_sizes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id_item`),
  ADD CONSTRAINT `items_sizes_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id_size`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`id_status`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `user_status` (`id_status`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

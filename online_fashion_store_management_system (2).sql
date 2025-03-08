-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 11:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_fashion_store_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_emails`
--

CREATE TABLE `newsletter_emails` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter_emails`
--

INSERT INTO `newsletter_emails` (`id`, `email`) VALUES
(1, 'ndayisabagloire96@gmail.com'),
(2, 'chizaanicet@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_amount` float NOT NULL,
  `status` varchar(10) NOT NULL,
  `delivered` varchar(20) DEFAULT 'Not Delivered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `delivered`) VALUES
(18, 2, '2024-09-15 20:40:24', 9000, 'completed', 'Delivered'),
(19, 2, '2024-09-13 23:56:48', 3500, 'pending', 'Not Delivered'),
(20, 2, '2025-03-08 12:45:59', 2000, 'pending', 'Not Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `size` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `total_price`, `size`) VALUES
(19, 18, 7, 6, 6000, 'S'),
(20, 18, 8, 5, 3000, 'S, M'),
(21, 19, 4, 5, 3500, 'M, L'),
(22, 20, 7, 2, 2000, 'S, M');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_user`
--

CREATE TABLE `order_item_user` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `size` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item_user`
--

INSERT INTO `order_item_user` (`order_item_id`, `order_id`, `product_id`, `quantity`, `total_price`, `size`) VALUES
(19, 18, 7, 6, 6000, 'S'),
(20, 18, 8, 5, 3000, 'S, M'),
(21, 19, 4, 5, 3500, 'M, L'),
(22, 20, 7, 2, 2000, 'S, M');

-- --------------------------------------------------------

--
-- Table structure for table `order_user`
--

CREATE TABLE `order_user` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_amount` float NOT NULL,
  `status` varchar(10) NOT NULL,
  `delivered` varchar(20) DEFAULT 'Not Delivered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_user`
--

INSERT INTO `order_user` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `delivered`) VALUES
(18, 2, '2024-09-15 20:40:24', 9000, 'completed', 'Delivered'),
(19, 2, '2024-09-05 23:56:48', 3500, 'pending', 'Not Delivered'),
(20, 2, '2025-03-08 12:45:59', 2000, 'pending', 'Not Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `payment_date`, `payment_method`, `status`, `amount`) VALUES
(11, 18, '2024-09-13 23:18:34', 'Flutterwave', 'completed', 9000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(10) NOT NULL,
  `size` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `product_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `size`, `stock`, `price`, `description`, `product_image`) VALUES
(4, 'Shirt-men', 'Men', 'M, L, XL', 23, 700, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis repellat veniam explicabo voluptatem, recusandae necessitatibus aspernatur illum delectus officia accusantium dicta? Corrupti ducimus eos neque!', 'prod-5.jpg'),
(7, 'pant', 'Men', 'S, M, L, XL', 8, 1000, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis repellat veniam explicabo voluptatem, recusandae necessitatibus aspernatur illum delectus officia accusantium dicta? Corrupti ducimus eos neque!', 'prod-1.jpg'),
(8, 'T-shirt', 'Wemen', 'S,M,L,XL', 13, 600, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis repellat veniam explicabo voluptatem, recusandae necessitatibus aspernatur illum delectus officia accusantium dicta? Corrupti ducimus eos neque!', 'prod-8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `testimony` text NOT NULL,
  `profile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `names`, `job_title`, `testimony`, `profile`) VALUES
(2, 'Joseph CHIZA', 'Manager/KLAB', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.', 'pic-4.jpg'),
(3, 'BUHENDWA Gabriel', 'Entrepreneur', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Non aliquam veniam temporibus saepe eius tenetur.', 'pic-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `address` text NOT NULL,
  `profile` text NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `reset_token_hash` varchar(64) NOT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `phone_number`, `address`, `profile`, `password`, `role`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(2, 'BARAKA', 'Chiza', 'chizaanicet@gmail.com', '+25079146075', 'Kigali', 'pic-4.jpg', '$2y$10$FbXcvefA658XtWVYZjbGH.nd6TeLs3uUheriEYscu4H76WNQgS4.G', 'admin', 'd18e247c265fe93fd0391784529fe0a1b02ce889ac7ed04d052763755a5147bb', '2024-09-10 16:03:12'),
(4, 'Gabriel', 'Bunga', 'josephanicet00@gmail.com', '+24397085907', 'Kigali', 'pic-4.jpg', '$2y$10$WAJgg6rGCenunMQX84C0CePzxKPulb9zF6Qu3.1XS1gDMr3TuRpGe', NULL, '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `newsletter_emails`
--
ALTER TABLE `newsletter_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_order_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_item` (`product_id`),
  ADD KEY `fk_order_item` (`order_id`);

--
-- Indexes for table `order_item_user`
--
ALTER TABLE `order_item_user`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_item_user` (`product_id`),
  ADD KEY `fk_order_item_user` (`order_id`);

--
-- Indexes for table `order_user`
--
ALTER TABLE `order_user`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_order_user_id` (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `newsletter_emails`
--
ALTER TABLE `newsletter_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_item_user`
--
ALTER TABLE `order_item_user`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_user`
--
ALTER TABLE `order_user`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_item` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `order_item_user`
--
ALTER TABLE `order_item_user`
  ADD CONSTRAINT `fk_item_user` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_item_user` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_user_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_item_user_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `order_user`
--
ALTER TABLE `order_user`
  ADD CONSTRAINT `fk_order_id_user` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `order_user_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

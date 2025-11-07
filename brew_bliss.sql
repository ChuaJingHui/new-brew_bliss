-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2025 at 12:00 PM
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
-- Database: `brew_bliss`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `review_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`review_id`, `name`, `comment`, `time`) VALUES
(1, 'Alice', 'Love the mocha! Perfect balance of chocolate and coffee.', '2025-10-25 06:28:20'),
(2, 'Bob', 'The latte is smooth and creamy, my daily go-to.', '2025-10-25 06:28:20'),
(3, 'Charlie', 'Friendly staff and cozy atmosphere.', '2025-10-25 06:28:20'),
(4, 'Eazin', 'Tried their homemade muffins with a cappuccino. Everything tastes so fresh and real!', '2025-10-25 06:28:20'),
(5, 'JJ', 'Great！', '2025-10-25 06:33:24'),
(6, 'Jacky', 'The matcha is amazing!', '2025-11-06 15:54:27'),
(7, 'Jin', 'Berry cheesecake is wonderful and so creamy. I love it!', '2025-11-06 16:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 'Chocolate Cupcake', 6.00, 1),
(2, 1, 'Brownie', 6.50, 1),
(3, 2, 'Chocolate Cupcake', 6.00, 1),
(4, 2, 'Brownie', 6.50, 1),
(5, 2, 'Honey Lemon (Ice)', 5.00, 1),
(6, 3, 'Matcha (Hot)', 9.00, 1),
(7, 4, 'Caramel Milkshake (Ice)', 8.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchasehistory`
--

CREATE TABLE `purchasehistory` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` int(13) NOT NULL,
  `address` varchar(255) NOT NULL,
  `card_number` int(20) NOT NULL,
  `expiry_month` int(2) NOT NULL,
  `expiry_year` int(4) NOT NULL,
  `cvv` int(3) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `purchase_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchasehistory`
--

INSERT INTO `purchasehistory` (`id`, `username`, `phone`, `address`, `card_number`, `expiry_month`, `expiry_year`, `cvv`, `remark`, `purchase_time`) VALUES
(1, 'yes', 124756679, 'Jalan Damai 25', 1234567890, 12, 2026, 321, NULL, '2025-10-25 07:08:44'),
(2, 'yes', 124756679, '1, Jalan Damai 1, 14000 BM', 1234567890, 12, 2026, 674, 'more ice for honey lemon', '2025-11-06 09:59:49'),
(3, 'yeji', 2147483647, '1, Jalan Aman 1, Taman Aman, 14000 BM', 2147483647, 12, 2026, 436, NULL, '2025-11-06 15:48:53'),
(4, 'John', 2147483647, '31, Jalan Aman 4, Taman Aman, 14000 BM', 1975656283, 7, 2028, 692, '', '2025-11-06 16:13:13'),
(5, 'Lim  Wendy', 2147483647, '5, Jalan Alma 4, Taman Alma, 14000 BM', 2147483647, 7, 2027, 9876, '', '2025-11-07 10:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'JJ', 'jj@gmail.com', '$2y$10$O.LnKpqcjq9cHlWtJrJ8CeO0j/HSEgccTMgLDqo2tMShsC3mkrUkq', '2025-10-25 03:28:07'),
(2, 'admin0618', 'admin0618@gmail.com', '$2y$10$RMpbFYsGkyy90NRG86u/L.26qi7lrJ7zlJr/nA/3.ktoWzGPkzycq', '2025-10-25 07:09:21'),
(3, 'yes', 'yes@gmail.com', '$2y$10$VIldhPbOme3exeEDbbqHo.sa/27NgD8eZzCZ9XoSen/UXbDqaR/IK', '2025-11-06 15:52:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `purchasehistory`
--
ALTER TABLE `purchasehistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchasehistory`
--
ALTER TABLE `purchasehistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`id`) REFERENCES `purchasehistory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

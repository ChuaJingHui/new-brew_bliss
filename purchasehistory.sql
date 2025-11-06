-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2025 at 05:14 PM
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
(4, 'John', 2147483647, '31, Jalan Aman 4, Taman Aman, 14000 BM', 1975656283, 7, 2028, 692, '', '2025-11-06 16:13:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchasehistory`
--
ALTER TABLE `purchasehistory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchasehistory`
--
ALTER TABLE `purchasehistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

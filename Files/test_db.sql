-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 03:39 PM
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
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(15) DEFAULT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `part_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_phone`, `employee_id`, `part_name`, `quantity`, `price`, `paid_amount`, `due_amount`, `timestamp`, `total_price`) VALUES
(73, 'Zunayed', '09876543210', '#2024000', 'file', 3, 70.00, 150.00, 120.00, '2024-06-05 17:55:33', 210),
(74, 'Zunayed', '09876543210', '#2024000', 'pen', 10, 6.00, 150.00, 120.00, '2024-06-05 17:55:33', 60),
(75, 'Riaz', '01912345678', '#2024000', 'Notebook', 3, 115.00, 100.00, 245.00, '2024-06-05 21:17:57', 345),
(76, 'Ferdus', '01934514851', '#2024000', 'Gel pen', 2, 40.00, 100.00, 52.00, '2024-06-05 21:20:58', 80),
(77, 'Ferdus', '01934514851', '#2024000', 'Pencil', 6, 12.00, 100.00, 52.00, '2024-06-05 21:20:58', 72),
(78, 'Khan', '01981273645', '#2024000', 'Coffee', 2, 650.00, 1375.00, 0.00, '2024-06-06 08:40:14', 1300),
(79, 'Khan', '01981273645', '#2024000', 'Sugar', 1, 75.00, 1375.00, 0.00, '2024-06-06 08:40:14', 75),
(99, 'Riaz', '019878678', '2024000', 'Ball', 5, 30.00, 130.00, 20.00, '2024-06-06 13:22:13', 150);

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` varchar(50) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`timestamp`, `employee_id`, `employee_name`, `total_price`) VALUES
('2024-06-06 13:22:13', '2024000', 'Ferdus Rhaman Khan', 150);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `name`, `number`, `email`, `address`, `reset_token`, `token_expiry`) VALUES
(2024000, 'ferdus', 'd93591bdf7860e1e4ee2fca799911215', 'Ferdus Rhaman Khan', '01934514851', 'feriqra007@gmail.com', 'Uttara,Dhaka-1230', '58f4203f5e8012b33ee3d800a2ed6a4e96a34c300c24c0cddf39d45aa5481d3d', '2024-06-03 18:40:18'),
(2024001, 'riaz', '81dc9bdb52d04dc20036dbd8313ed055', 'Riaz Hosen', '01987654321', 'riaz420@gmail.com', 'Jamalpur, Bangladesh', NULL, NULL),
(2024002, 'zunayed', '4e642e966fe95bca094b7d2d6f0556b7', 'Zunayed', '01912345678', 'zunayed@gmail.com', 'ECB, Dhaka, Bangladesh', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2024003;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

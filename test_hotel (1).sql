-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 02:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `sl_no` varchar(20) DEFAULT NULL,
  `status` enum('checked_in','checked_out') NOT NULL DEFAULT 'checked_in',
  `checkin_date` datetime DEFAULT NULL,
  `checkout_date` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `aadhar_no` varchar(100) DEFAULT NULL,
  `other` varchar(100) DEFAULT NULL,
  `documents` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `room_number`, `sl_no`, `status`, `checkin_date`, `checkout_date`, `name`, `mail`, `mobile`, `aadhar_no`, `other`, `documents`, `created_at`, `updated_at`) VALUES
(1, '101', 'SL001', 'checked_in', '2022-01-01 10:00:00', NULL, 'John Doe', 'john@example.com', '1234567890', '123456789012', 'Passport', 'document1.jpg', '2025-02-17 16:14:02', '2025-02-17 16:14:02'),
(2, '102', 'SL002', 'checked_out', '2022-01-05 12:00:00', NULL, 'Jane Doe', 'jane@example.com', '0987654321', '987654321098', 'Drivers License', 'document2.pdf', '2025-02-17 16:14:02', '2025-02-17 16:14:02'),
(3, '103', 'SL003', 'checked_in', '2022-01-10 14:00:00', '2022-01-15 12:00:00', 'Richard Roe', 'richard@example.com', '5551234567', '5551234567012', 'State ID', 'document3.png', '2025-02-17 16:14:02', '2025-02-17 16:14:02'),
(4, '104', 'SL004', 'checked_in', '2022-01-12 16:00:00', NULL, 'Bob Smith', 'bob@example.com', '5559012345', '5559012345012', 'Passport', 'document4.doc', '2025-02-17 16:14:02', '2025-02-17 16:14:02'),
(5, '107', 'SL005', 'checked_in', '2022-01-18 18:00:00', '2022-01-20 10:00:00', 'Alice Johnson', 'alice@example.com', '5551112222', '5551112222012', 'Drivers License', 'document5.txt', '2025-02-17 16:14:02', '2025-02-17 16:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(10) NOT NULL,
  `key` varchar(20) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(10) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `room_number` varchar(10) DEFAULT NULL,
  `floor` int(2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `category`, `room_number`, `floor`, `price`, `description`, `created_at`) VALUES
(1, 'non_ac', '104', 2, 100.00, 'null', '2025-02-15 14:19:47'),
(2, 'ac', '103', 2, 111.00, 'null', '2025-02-15 14:19:47'),
(3, 'ac', '102', 2, 500.00, '4444', '2025-02-15 14:19:47'),
(4, 'ac', '101', 2, 1000.00, '1411', '2025-02-15 14:19:47'),
(5, 'ac', '105', 2, 500.00, 'sdgdsfgdsf', '2025-02-15 14:27:55'),
(6, 'Select Category', '106', 2, 501.00, '3213131', '2025-02-15 14:30:08'),
(15, 'non_ac', '107', 1, 200.00, 'ss', '2025-02-17 17:47:28'),
(16, 'ac', '201', 1, 323.00, '33', '2025-02-17 17:47:41'),
(17, 'ac', '202', 1, 222.00, '2', '2025-02-17 17:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT '''STAF''',
  `data` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `data`, `created_at`) VALUES
(1, 'taksh', 'Taksh@123', 'ADMIN', '{\"rooms_create\": 1,\"rooms_edit\": 1,\"rooms_delete\": 1,\"bookings\": 1,\"booking_payments\": 1,\"dashboard_1\": 1,\"dashboard_2\": 1,\"dashboard_3\": 1,\"history_booking\": 1,\"history_payment\": 1}', '2025-02-12 13:44:54'),
(2, 'takshstaff', 'Taksh@123', 'STAFF', '{\"rooms_create\": 1,\"rooms_edit\": 1,\"rooms_delete\": 1,\"bookings\": 1,\"booking_payments\": 1,\"dashboard_1\": 1,\"dashboard_2\": 1,\"dashboard_3\": 1,\"history_booking\": 1,\"history_payment\": 1}', '2025-02-14 14:49:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_number` (`room_number`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_number`) REFERENCES `rooms` (`room_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 08:53 AM
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
-- Database: `automryl_cafeteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `admin_user` varchar(100) DEFAULT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `admin_user`, `action_type`, `target_type`, `target_id`, `message`, `ip_address`, `created_at`) VALUES
(1, 'SuperAdmin', 'UPDATE', 'employee', NULL, 'Updated employee Simran Kaur (Food: One Time → Two Times)', NULL, '2026-06-25 10:50:08'),
(2, 'SuperAdmin', 'UPDATE', 'employee', NULL, 'Updated employee Rohan Mehta (Food: One Time → Two Times)', NULL, '2026-06-25 10:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `company_master`
--

CREATE TABLE `company_master` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_by` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_master`
--

INSERT INTO `company_master` (`id`, `company_name`, `status`, `created_by`, `created_at`) VALUES
(1, 'Unity Enterprises', 1, 1, '2026-05-14 15:30:56'),
(2, 'SS Dev Systems', 1, 1, '2026-05-14 15:31:08'),
(3, 'NextGen Software Ltd', 1, 1, '2026-05-14 15:31:15'),
(4, 'SS Solutions Pvt Ltd', 1, 1, '2026-05-14 15:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `department_master`
--

CREATE TABLE `department_master` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_master`
--

INSERT INTO `department_master` (`id`, `department_name`, `status`, `created_by`, `created_at`) VALUES
(1, 'Digital Marketing', 1, 1, '2026-05-14 15:31:41'),
(2, 'Operations', 1, 1, '2026-05-14 15:31:54'),
(3, 'Social Media', 1, 3, '2026-06-24 11:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(20) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `emp_status` tinyint(4) DEFAULT 1,
  `two_times_food_allowed` tinyint(1) DEFAULT 1,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `emp_id`, `emp_name`, `department_id`, `emp_status`, `two_times_food_allowed`, `company_id`, `created_by`, `created_at`) VALUES
(2, '0004', 'Simran Kaur', 1, 1, 2, 1, 1, '2026-05-14 15:41:14'),
(3, '0020', 'Deepak Chauhan', 1, 1, 1, 1, 1, '2026-05-14 15:41:42'),
(4, '0019', 'Ritika Malhotra', 1, 1, 1, 1, 1, '2026-05-14 15:42:18'),
(5, '0018', 'Nitin Agarwal', 1, 1, 1, 1, 1, '2026-05-14 15:42:36'),
(6, '0017', 'Kavita Shah', 1, 1, 1, 1, 1, '2026-05-14 15:43:16'),
(7, '0016', 'Sanjay Kumar', 1, 1, 1, 1, 1, '2026-05-14 15:43:44'),
(8, '0015', 'Meera Kapoor', 1, 1, 1, 1, 1, '2026-05-14 15:44:05'),
(9, '0005', 'Akash Tupe', 1, 1, 1, 1, 1, '2026-05-14 15:44:40'),
(10, '0014', 'Vikas Yadav', 1, 1, 1, 1, 1, '2026-05-14 15:44:58'),
(11, '0013', 'Anjali Desai', 1, 1, 1, 1, 1, '2026-05-14 15:45:16'),
(12, '0012', 'Amit Joshi', 1, 1, 1, 1, 1, '2026-05-14 15:45:35'),
(13, '0011', 'Pooja Nair', 1, 1, 1, 1, 1, '2026-05-14 15:45:53'),
(14, '0010', 'Rahul Gupta', 1, 1, 1, 1, 1, '2026-05-14 15:46:24'),
(15, '0009', 'Sneha Iyer', 1, 1, 1, 1, 1, '2026-05-14 15:46:49'),
(16, '0008', 'Karan Patel', 1, 1, 1, 1, 1, '2026-05-14 15:47:32'),
(17, '0007', 'Priya Singh', 1, 1, 2, 1, 1, '2026-05-14 15:48:39'),
(18, '0006', 'Rohan Mehta', 1, 1, 1, 1, 7, '2026-05-15 06:24:40'),
(20, '0001', 'Aarav Sharma', 1, 1, 1, 1, 3, '2026-06-24 10:14:27'),
(21, '0002', 'Neha Verma', 1, 1, 1, 1, 3, '2026-06-24 10:21:24'),
(22, '0003', 'Rohan Mehta', 1, 1, 2, 1, 3, '2026-06-24 10:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `employee_request`
--

CREATE TABLE `employee_request` (
  `id` int(11) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `emp_id` varchar(50) DEFAULT NULL,
  `vnd_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `flag` varchar(200) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_entry`
--

CREATE TABLE `food_entry` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(20) DEFAULT NULL,
  `meal_time` enum('Lunch','Dinner') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `food_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_entry`
--

INSERT INTO `food_entry` (`id`, `emp_id`, `meal_time`, `created_by`, `created_at`, `food_type`) VALUES
(1, '0002', 'Lunch', 5, '2026-06-25 05:25:40', 2),
(2, '0004', 'Lunch', 6, '2026-06-25 05:26:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_type_master`
--

CREATE TABLE `food_type_master` (
  `id` int(11) NOT NULL,
  `food_type_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_type_master`
--

INSERT INTO `food_type_master` (`id`, `food_type_name`, `status`, `created_by`, `created_at`) VALUES
(1, 'Meal', 1, 1, '2026-05-14 15:32:08'),
(2, 'Pizza', 1, 1, '2026-05-14 15:32:19'),
(3, 'Nutritional Meal', 1, 1, '2026-05-14 15:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` tinyint(2) DEFAULT NULL COMMENT '1=Admin, 2=Vendor, 3=SuperAdmin',
  `email_id` varchar(100) DEFAULT NULL,
  `food_type_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `name`, `username`, `password`, `role`, `email_id`, `food_type_id`, `status`, `created_by`, `created_at`) VALUES
(1, 'DailyMeal Services', 'dailymeal', '123456', 2, 'ocoxup@fexpost.com', 1, 1, 1, '2026-05-14 15:40:13'),
(2, 'kat', 'kat', '123456', 1, 'kat.dev@gmail.com', NULL, 1, NULL, '2026-05-14 15:51:12'),
(3, 'SuperAdmin', 'shaikh', '123456', 3, 'superadmin@gmail.com', NULL, 1, NULL, '2026-05-14 15:54:04'),
(4, 'Sana Shaikh', 'sana', '123456', 1, 'ounaqu@fexpost.com', NULL, 1, NULL, '2026-05-14 16:51:24'),
(5, 'PizzaHub Vendor', 'pizzahub', '123456', 2, 'wykvofu@fexpost.com', 2, 1, 2, '2026-05-14 16:56:20'),
(6, 'FreshBite Catering', 'freshbite', '123456', 2, 'putkow@fexpost.com', 1, 1, 4, '2026-05-14 17:01:02'),
(7, 'admin', 'admin', '123456', 1, 'admin@ondirect.in', NULL, 2, NULL, '2026-05-14 17:27:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_master`
--
ALTER TABLE `company_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_master`
--
ALTER TABLE `department_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `employee_request`
--
ALTER TABLE `employee_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_entry`
--
ALTER TABLE `food_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `fk_food_type` (`food_type`);

--
-- Indexes for table `food_type_master`
--
ALTER TABLE `food_type_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD KEY `food_type_id` (`food_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_master`
--
ALTER TABLE `company_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department_master`
--
ALTER TABLE `department_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `employee_request`
--
ALTER TABLE `employee_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_entry`
--
ALTER TABLE `food_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `food_type_master`
--
ALTER TABLE `food_type_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_master` (`id`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`id`),
  ADD CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`);

--
-- Constraints for table `food_entry`
--
ALTER TABLE `food_entry`
  ADD CONSTRAINT `fk_food_type` FOREIGN KEY (`food_type`) REFERENCES `food_type_master` (`id`),
  ADD CONSTRAINT `food_entry_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`),
  ADD CONSTRAINT `food_entry_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user_master` (`id`);

--
-- Constraints for table `user_master`
--
ALTER TABLE `user_master`
  ADD CONSTRAINT `user_master_ibfk_1` FOREIGN KEY (`food_type_id`) REFERENCES `food_type_master` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

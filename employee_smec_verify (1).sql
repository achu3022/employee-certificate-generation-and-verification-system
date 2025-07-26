-- phpMyAdmin SQL Dump
-- version 5.2.2deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 26, 2025 at 11:34 AM
-- Server version: 8.4.5-0ubuntu0.2
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_smec_verify`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'SMEC_Admin_2025!', '$2y$10$OLUMCmkE7gOYmqatYjJH6.oWJxdhDMflNER0S8n0VfH8jwBxP9/y2', '2025-07-19 06:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int UNSIGNED NOT NULL,
  `employee_id` int UNSIGNED NOT NULL,
  `doc_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `uploaded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `employee_id`, `doc_type`, `file_name`, `original_name`, `uploaded_at`) VALUES
(36, 1, 'offer_letter', 'Offer_Letter_Abhijith_20250722061821.pdf', 'Offer_Letter.pdf', '2025-07-22 06:18:21'),
(37, 1, 'experience_certificate', 'Experience_Certificate_Abhijith_20250722061823.jpg', 'Experience_Certificate_Abhijith_20250722061823.jpg', '2025-07-22 06:18:23'),
(38, 6, 'experience_certificate', 'Experience_Certificate_Anto xavier_20250723051128.jpg', 'Experience_Certificate_Anto xavier_20250723051128.jpg', '2025-07-23 05:11:28'),
(40, 5, 'experience_certificate', 'Experience_Certificate_test05_20250723060537.jpg', 'Experience_Certificate_test05_20250723060537.jpg', '2025-07-23 06:05:37'),
(44, 4, 'experience_certificate', 'Experience_Certificate_test04_20250723064750.jpg', 'Experience_Certificate_test04_20250723064750.jpg', '2025-07-23 06:47:51'),
(47, 4, 'offer_letter', 'Offer_Letter_test04_20250723065014.pdf', 'Offer_Letter.pdf', '2025-07-23 06:50:14'),
(48, 6, 'offer_letter', 'Offer_Letter_Anto xavier_20250723093100.pdf', 'Offer_Letter.pdf', '2025-07-23 09:31:00'),
(49, 5, 'offer_letter', 'Offer_Letter_test05_20250723093216.pdf', 'Offer_Letter.pdf', '2025-07-23 09:32:16'),
(50, 7, 'offer_letter', 'Offer_Letter_buttonchck_20250726044015.pdf', 'Offer_Letter.pdf', '2025-07-26 04:40:15'),
(51, 7, 'experience_certificate', 'Experience_Certificate_buttonchck_20250726044019.jpg', 'Experience_Certificate_buttonchck_20250726044019.jpg', '2025-07-26 04:40:20'),
(52, 7, 'other_certificate', 'other_688488038624e.jpg', 'Zamorin_of_Calicut.jpg', '2025-07-26 07:47:15'),
(53, 6, 'other_certificate', 'other_68848814bc497.jpeg', 'images (1).jpeg', '2025-07-26 07:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int UNSIGNED NOT NULL,
  `employee_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `designation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `dob` date NOT NULL,
  `approved` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `name`, `designation`, `department`, `contact`, `location`, `status`, `start_date`, `end_date`, `dob`, `approved`) VALUES
(1, 'sa42192', 'Abhijith', 'Wordpress', 'Media & IT', '9526403035', 'Kochiyy', 'active', '2023-02-13', '2025-02-11', '1992-05-27', 1),
(2, 'test01', 'test01', 'test01', 'test01', 'test01', 'test01', 'active', '2025-07-02', '0000-00-00', '2025-07-01', 0),
(3, 'test02', 'test02', 'test02', 'test02', 'test02', 'test02', 'active', '2025-07-03', '0000-00-00', '2025-07-03', 1),
(4, 'test04', 'test04', 'test04', 'test04', 'test04', 'test04', 'active', '2025-07-09', '2025-07-09', '2025-07-09', 1),
(5, 'test05', 'test05', 'test05', 'test05', 'test05', 'test05', 'active', '2025-07-01', '2025-07-20', '2025-01-01', 0),
(6, 'SA42191', 'Anto xavier', 'Videographer', 'Media', '1234567890', 'Kochi', 'active', '2024-02-13', NULL, '1997-06-23', 1),
(7, 'sa42222', 'buttonchck', 'buttonchck', 'buttonchck', 'buttonchck', 'buttonchck', 'active', '2025-07-01', '2025-07-10', '2025-07-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_letter_details`
--

CREATE TABLE `offer_letter_details` (
  `id` int UNSIGNED NOT NULL,
  `employee_id` int UNSIGNED NOT NULL,
  `joining_date` date NOT NULL,
  `salary` varchar(100) NOT NULL,
  `reporting_manager` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offer_letter_details`
--

INSERT INTO `offer_letter_details` (`id`, `employee_id`, `joining_date`, `salary`, `reporting_manager`, `created_at`) VALUES
(1, 6, '2025-07-01', '123456', 'Shiyas A (Mob: 9656227714)', '2025-07-23 09:31:00'),
(2, 5, '2025-07-04', '123456', 'Shiyas A (Mob: 9656227714)', '2025-07-23 09:32:16'),
(3, 7, '0000-00-00', '145200', 'Shiyas A (Mob: 9656227714)', '2025-07-26 04:40:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_letter_details`
--
ALTER TABLE `offer_letter_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_letter_details`
--
ALTER TABLE `offer_letter_details`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

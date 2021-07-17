-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2020 at 11:42 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockdemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LCD', 8, 0, '2019-12-02 08:10:34', '2019-12-02 08:10:34'),
(2, 'KEYBOARD', 8, 0, '2019-12-02 08:10:48', '2019-12-02 08:11:01'),
(3, 'STORAGE DEVICES', 8, 0, '2019-12-11 18:23:43', '2019-12-11 18:23:43'),
(4, 'CASING AND APPEARANCE', 8, 0, '2019-12-11 18:25:07', '2019-12-11 18:25:07'),
(5, 'SOCKET I/O PORTS ETC', 8, 0, '2019-12-11 18:26:19', '2019-12-11 18:26:19'),
(6, 'OTHER PROBLEMS', 8, 0, '2019-12-13 10:12:47', '2019-12-13 10:12:47'),
(7, 'DISPLAY', 10, -1, '2020-01-04 13:35:46', '2020-01-04 13:37:04'),
(8, 'PURCHASE', 10, 0, '2020-02-11 10:31:10', '2020-02-11 10:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `catremarks`
--

CREATE TABLE `catremarks` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catremarks`
--

INSERT INTO `catremarks` (`id`, `name`, `company_id`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SDSFADFS', 8, 1, 0, '2019-12-02 09:24:15', '2019-12-02 09:33:10'),
(5, 'SFSF', 8, 2, 0, '2019-12-02 09:33:15', '2019-12-02 09:33:33'),
(6, 'SFDGF', 8, 1, 0, '2019-12-02 10:03:45', '2019-12-02 10:03:45'),
(7, 'KEY MISSING / CAPS ETC..', 8, 2, 0, '2019-12-11 18:15:11', '2019-12-11 18:21:38'),
(8, 'LINES', 8, 1, 0, '2019-12-11 18:15:37', '2019-12-11 18:15:37'),
(9, 'BROCKEN', 8, 1, 0, '2019-12-11 18:20:01', '2019-12-11 18:20:01'),
(10, 'FLICKERING IN LCD DISPLAY', 8, 1, 0, '2019-12-11 18:21:08', '2019-12-11 18:21:08'),
(11, 'DEFECTIVE KEYBOARD-KEYS NOT WORKING AT ALL', 8, 2, 0, '2019-12-11 18:22:55', '2019-12-11 18:22:55'),
(12, 'HARD DRIVE NOISY / DEFECTIVE', 8, 3, 0, '2019-12-11 18:27:48', '2019-12-11 18:27:48'),
(13, 'NOT BOOTING TO OS / ERROR WHILE BOOTING', 8, 3, 0, '2019-12-11 18:28:47', '2019-12-11 18:28:47'),
(14, 'OPTICAL DRIVE NOT WORKING', 8, 3, 0, '2019-12-11 18:29:20', '2019-12-11 18:29:20'),
(15, 'BROKEN CASING', 8, 4, 0, '2019-12-11 18:30:04', '2019-12-11 18:30:04'),
(16, 'DEFECTIVE / LOOS HINGES', 8, 4, 0, '2019-12-11 18:30:25', '2019-12-11 18:30:25'),
(17, 'DAMAGED / LOOS POWER SOCKET', 8, 5, 0, '2019-12-11 18:31:10', '2019-12-11 18:31:10'),
(18, 'USB PORT DAMAGED', 8, 5, 0, '2019-12-11 18:31:42', '2019-12-11 18:31:42'),
(19, 'NO POWERING ON', 8, 6, 0, '2019-12-13 10:14:11', '2019-12-13 10:14:11'),
(20, 'SWITH OFF AFTER SOME TIMES', 8, 6, 0, '2019-12-13 10:14:40', '2019-12-13 10:14:40'),
(21, 'POWER ON NO DISPLAY', 8, 6, 0, '2019-12-13 10:15:13', '2019-12-13 10:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `closings`
--

CREATE TABLE `closings` (
  `id` int(10) UNSIGNED NOT NULL,
  `opening_balance` json DEFAULT NULL,
  `total_opening` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `collection` json DEFAULT NULL,
  `total_collection` json DEFAULT NULL,
  `expense` json DEFAULT NULL,
  `total_expense` json DEFAULT NULL,
  `closing_balance` json DEFAULT NULL,
  `closing_time` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `closings`
--

INSERT INTO `closings` (`id`, `opening_balance`, `total_opening`, `date`, `collection`, `total_collection`, `expense`, `total_expense`, `closing_balance`, `closing_time`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '[{\"type\": \"CASH\", \"amount\": \"5000\"}, {\"type\": \"BANK\", \"amount\": \"5000\"}]', 10000, '2020-07-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-02 07:21:58', '2020-07-02 07:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'JOB ADVISOR', 0, '2019-11-25 07:01:22', '2019-11-25 07:01:22'),
(2, 'TECHNICIAN', 0, '2019-11-25 07:01:22', '2019-11-25 07:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `employee_type` int(11) NOT NULL COMMENT '1- job advisor, 2- technician',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `company_id`, `name`, `employee_type`, `status`, `created_at`, `updated_at`) VALUES
(6, 8, 'SHARAFALI', 1, -1, '2019-11-18 18:03:28', '2019-12-11 17:47:22'),
(7, 8, 'FASAL', 1, -1, '2019-11-18 18:07:18', '2019-12-11 17:47:18'),
(8, 8, 'SHIJU', 1, -1, '2019-11-18 18:07:40', '2019-12-11 17:47:15'),
(9, 8, 'ANWAR', 1, -1, '2019-11-18 18:07:52', '2019-12-11 17:47:11'),
(10, 8, 'MUSTHAFA', 1, -1, '2019-11-18 18:08:08', '2019-12-11 17:46:59'),
(11, 8, 'JASIL', 1, -1, '2019-11-18 18:08:21', '2019-12-11 17:46:55'),
(12, 8, 'IQBAL', 1, -1, '2019-11-18 18:08:37', '2019-12-11 17:47:05'),
(13, 8, 'RAJU', 2, -1, '2019-11-18 18:08:50', '2019-12-11 17:47:32'),
(14, 8, 'MOIN', 2, -1, '2019-11-18 18:09:02', '2019-12-11 17:47:29'),
(15, 8, 'SUBAHN', 2, -1, '2019-11-18 18:09:14', '2019-12-11 17:47:36'),
(16, 8, 'FURKAN', 2, -1, '2019-11-18 18:09:27', '2019-12-11 17:44:49'),
(17, 8, 'SHOAIB', 2, -1, '2019-11-18 18:09:53', '2019-12-11 17:47:26'),
(18, 8, 'WAJID', 2, -1, '2019-11-18 18:10:03', '2019-12-11 17:47:40'),
(19, 8, 'JUNAID', 1, -1, '2019-11-18 18:10:27', '2019-12-11 17:47:43'),
(20, 8, 'SALE', 5, -1, '2019-11-26 10:21:45', '2019-11-26 10:26:50'),
(21, 8, 'COUNTER SALE', 2, -1, '2019-11-26 10:26:45', '2019-12-11 17:44:45'),
(22, 11, 'SHIJU', 1, -1, '2019-11-26 10:43:52', '2019-12-13 16:05:09'),
(23, 11, 'FASAL', 1, -1, '2019-11-26 10:44:04', '2019-12-13 16:05:39'),
(24, 11, 'SHARAFU', 1, -1, '2019-11-26 10:44:18', '2019-12-13 16:05:21'),
(25, 11, 'MUSTHAFA', 1, -1, '2019-11-26 10:44:29', '2019-12-13 16:05:13'),
(26, 11, 'ANWAR', 1, -1, '2019-11-26 10:44:41', '2019-12-13 16:05:17'),
(27, 11, 'JASIL', 1, -1, '2019-11-26 10:44:50', '2019-12-13 16:05:42'),
(28, 11, 'SHOHAIB', 2, -1, '2019-11-26 10:45:09', '2019-12-13 16:05:36'),
(29, 11, 'SUBAHAN', 2, -1, '2019-11-26 10:45:21', '2019-12-13 16:05:25'),
(30, 11, 'RAJU', 2, -1, '2019-11-26 10:45:30', '2019-12-13 16:05:32'),
(31, 11, 'FURKHAN', 2, -1, '2019-11-26 10:45:49', '2019-12-13 16:05:29'),
(32, 11, 'ISTIYAK', 2, -1, '2019-11-26 10:46:01', '2019-12-13 16:05:45'),
(33, 11, 'NAZRUL', 2, -1, '2019-11-26 10:46:18', '2019-12-13 16:05:49'),
(34, 10, 'SHIGIL', 1, 0, '2019-12-11 15:58:29', '2019-12-11 15:58:29'),
(35, 10, 'ASHIDA', 1, 0, '2019-12-11 15:58:50', '2019-12-11 15:58:50'),
(36, 10, 'ALFAS', 1, -1, '2019-12-11 15:59:05', '2019-12-11 16:04:27'),
(37, 10, 'SREERAG', 1, -1, '2019-12-11 15:59:24', '2019-12-11 16:04:31'),
(38, 10, 'ALFAS', 2, 0, '2019-12-11 16:04:40', '2019-12-11 16:04:40'),
(39, 10, 'SREERAG-T', 2, 0, '2019-12-11 16:04:57', '2019-12-11 16:04:57'),
(40, 8, 'AMEER', 1, 0, '2019-12-11 17:48:16', '2019-12-11 17:48:16'),
(41, 8, 'JUNAID', 2, 0, '2019-12-11 17:48:50', '2019-12-11 17:48:50'),
(42, 8, 'ARJUN', 2, 0, '2019-12-11 17:49:11', '2019-12-11 17:49:11'),
(43, 8, 'ARSHAD', 2, 0, '2019-12-11 17:49:23', '2019-12-11 17:49:23'),
(44, 8, 'AMEER C', 2, 0, '2019-12-12 10:38:02', '2019-12-12 10:38:02'),
(45, 11, 'VISHNU', 2, 0, '2019-12-13 16:06:03', '2019-12-13 16:06:03'),
(46, 11, 'ATHUL', 1, 0, '2019-12-13 16:06:13', '2019-12-13 16:06:13'),
(47, 11, 'HAFIS', 1, -1, '2019-12-13 16:06:24', '2020-02-26 17:06:29'),
(48, 11, 'SAHIL', 1, -1, '2019-12-13 16:06:34', '2020-02-26 17:06:35'),
(49, 11, 'RAHEES', 1, 0, '2020-01-04 13:17:14', '2020-01-04 13:17:14'),
(50, 11, 'AMEER', 1, 0, '2020-02-26 17:07:00', '2020-02-26 17:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `expensecategories`
--

CREATE TABLE `expensecategories` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expensecategories`
--

INSERT INTO `expensecategories` (`id`, `company_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'SALARY', -1, '2019-11-09 05:32:44', '2019-11-18 14:29:28'),
(2, 1, 'SALARY', 0, '2019-11-09 18:05:21', '2019-11-09 18:05:21'),
(3, 6, 'SALARY ADV.', 0, '2019-11-11 17:44:43', '2019-11-18 17:55:53'),
(4, 6, 'STAR MC CHEMICAL', 0, '2019-11-11 17:45:02', '2019-11-11 17:47:06'),
(5, 6, 'INTERNET', 0, '2019-11-11 17:45:22', '2019-11-11 17:45:22'),
(6, 6, 'TEMP WAGE EXP', 0, '2019-11-11 17:46:06', '2019-11-11 17:46:06'),
(7, 6, 'STAFF FOOD EXP', 0, '2019-11-11 17:46:20', '2019-11-11 17:46:20'),
(8, 6, 'LUVLY SOLUTIONS (I) PVT LTD', 0, '2019-11-11 17:47:33', '2019-11-11 17:47:33'),
(9, 6, 'SHOP RENT', 0, '2019-11-11 17:48:05', '2019-11-11 17:48:05'),
(10, 6, 'ELECTRICITY BILL', 0, '2019-11-11 17:48:17', '2019-11-11 17:48:17'),
(11, 6, 'OTHER EXP', 0, '2019-11-11 17:49:23', '2019-11-11 17:49:23'),
(12, 5, 'SALARY', 0, '2019-11-11 20:27:26', '2019-11-11 20:27:26'),
(13, 5, 'RENT', 0, '2019-11-11 20:27:35', '2019-11-11 20:27:35'),
(14, 5, 'ELECTRICITY', 0, '2019-11-11 20:27:48', '2019-11-11 20:27:48'),
(15, 7, 'SALARY', 0, '2019-11-14 11:50:28', '2019-11-14 11:50:28'),
(16, 4, 'ELECTRICITY', 0, '2019-11-18 09:25:37', '2019-11-18 09:25:49'),
(17, 4, 'SANOOP SALARY', 0, '2019-11-18 14:27:11', '2019-11-18 14:27:11'),
(18, 4, 'RAKESH SALARY', 0, '2019-11-18 14:27:37', '2019-11-18 14:27:37'),
(19, 4, 'SHANKER SALARY', 0, '2019-11-18 14:27:53', '2019-11-18 14:27:53'),
(20, 4, 'PERLANK SALARY', 0, '2019-11-18 14:28:07', '2019-11-18 14:28:07'),
(21, 4, 'KAMAL SALARY', 0, '2019-11-18 14:28:18', '2019-11-18 14:28:18'),
(22, 4, 'SANJU SALARY', 0, '2019-11-18 14:28:28', '2019-11-18 14:28:51'),
(23, 4, 'AMEER SALARY', 0, '2019-11-18 14:29:03', '2019-11-18 14:29:03'),
(24, 4, 'THANVEER SALARY', 0, '2019-11-18 14:29:17', '2019-11-18 14:29:17'),
(25, 4, 'PURCHASE LUVLY SOLUTIONS PVT LTD', 0, '2019-11-18 14:33:19', '2019-11-18 14:34:20'),
(26, 4, 'PURCHASE GANGOTRI AGENCIES', 0, '2019-11-18 14:36:35', '2019-11-18 14:36:35'),
(27, 4, 'PURCHASE WESTEND ENTERPRISES', 0, '2019-11-18 14:37:38', '2019-11-18 14:37:38'),
(28, 4, 'PURCHASE THEM AGENCIES', 0, '2019-11-18 14:38:17', '2019-11-18 14:38:17'),
(29, 4, 'PURCHASE JONSE', 0, '2019-11-18 14:39:18', '2019-11-18 14:39:18'),
(30, 4, 'FOOD', 0, '2019-11-18 14:39:32', '2019-11-18 14:39:32'),
(31, 4, 'PETROL', 0, '2019-11-18 14:39:50', '2019-11-18 14:39:50'),
(32, 4, 'OTHER', 0, '2019-11-18 14:40:03', '2019-11-18 14:40:03'),
(33, 4, 'NUMBER PLATE', 0, '2019-11-18 14:40:57', '2019-11-18 14:40:57'),
(34, 9, 'SALARY', 0, '2019-11-18 17:42:14', '2019-11-18 17:42:14'),
(35, 9, 'ELECTRICITY', 0, '2019-11-18 17:42:23', '2019-11-18 17:42:23'),
(36, 9, 'RENT', 0, '2019-11-18 17:42:34', '2019-11-18 17:42:34'),
(37, 6, 'DRINKING WATER', 0, '2019-11-18 17:53:06', '2019-11-18 17:53:06'),
(38, 4, 'STAFF EXPENCE', 0, '2019-11-19 14:43:11', '2019-11-19 14:43:11'),
(39, 8, 'ABC', -1, '2019-11-22 22:28:44', '2020-01-17 18:48:45'),
(40, 8, 'SALARY', 0, '2019-12-07 05:42:11', '2019-12-07 05:42:11'),
(41, 10, 'WATER', 0, '2020-01-09 10:21:59', '2020-01-09 10:21:59'),
(42, 8, 'STATINORY', 0, '2020-01-09 19:49:07', '2020-01-09 19:49:07'),
(43, 10, 'SHOP MAINTANANCE', -1, '2020-01-10 15:23:19', '2020-07-01 11:38:53'),
(44, 10, 'NEO POUCH', -1, '2020-01-13 19:12:13', '2020-07-01 11:38:49'),
(45, 10, 'ACCESSORIES', 0, '2020-01-13 19:13:08', '2020-01-13 19:13:08'),
(46, 10, 'SALERY ADVANCE', -1, '2020-01-13 19:15:34', '2020-07-01 11:38:44'),
(47, 10, 'CLEANING', 0, '2020-01-13 19:15:52', '2020-01-13 19:15:52'),
(48, 11, 'PETROL', 0, '2020-01-14 19:32:06', '2020-01-14 19:32:06'),
(49, 8, 'SERVICE TOOLS', 0, '2020-01-14 19:44:08', '2020-01-14 19:44:08'),
(50, 11, 'SALARY ADVANCE', 0, '2020-01-15 13:29:44', '2020-01-15 13:29:44'),
(51, 11, 'STATIONERY', 0, '2020-01-15 13:30:23', '2020-01-15 13:30:23'),
(52, 11, 'OFFICE EXPENSES', 0, '2020-01-15 13:30:50', '2020-01-15 13:30:50'),
(53, 11, 'SERVICE TOOL PURCHASE', 0, '2020-01-15 13:31:23', '2020-01-15 13:31:23'),
(54, 8, 'PURCHASE', 0, '2020-01-17 18:48:37', '2020-01-17 18:48:37'),
(55, 11, 'PAYMENT CREDIT', 0, '2020-01-17 19:31:54', '2020-01-17 19:31:54'),
(56, 10, 'USED PHONE PURCHERS', -1, '2020-01-17 20:24:24', '2020-07-01 11:38:39'),
(57, 10, 'SIGNET SALIH', 0, '2020-01-18 17:23:21', '2020-01-18 17:23:21'),
(58, 11, 'I-FIX', 0, '2020-01-21 13:59:19', '2020-01-21 13:59:19'),
(59, 11, 'NEO POUCHES', 0, '2020-01-21 13:59:32', '2020-01-21 13:59:32'),
(60, 11, 'SKY PHONE', 0, '2020-01-21 13:59:49', '2020-01-21 13:59:49'),
(61, 11, 'NEO BATTERY', 0, '2020-01-21 14:00:06', '2020-01-21 14:00:06'),
(62, 11, 'PAYMENT', 0, '2020-01-21 16:30:30', '2020-01-21 16:30:30'),
(63, 10, 'EXPENSE', -1, '2020-01-21 16:54:28', '2020-07-01 11:38:36'),
(64, 11, 'AKSHAY OG', 0, '2020-01-21 16:59:47', '2020-01-21 16:59:47'),
(65, 11, 'WATER', 0, '2020-01-22 10:29:19', '2020-01-22 10:29:19'),
(66, 10, 'DONATION', -1, '2020-01-23 16:31:49', '2020-07-01 11:38:32'),
(67, 11, 'RE FUND JOB', 0, '2020-01-24 19:21:40', '2020-01-24 19:21:40'),
(68, 10, 'VODAFONE BILL', -1, '2020-01-27 17:30:19', '2020-07-01 11:38:28'),
(69, 11, 'PURCHASE', 0, '2020-01-28 14:21:18', '2020-01-28 14:21:18'),
(70, 10, 'SERVICE EQUIPMENTS', -1, '2020-01-29 20:00:21', '2020-07-01 11:38:23'),
(71, 10, 'CASH REFUND', 0, '2020-01-31 16:43:54', '2020-01-31 16:43:54'),
(72, 8, 'REFUND', 0, '2020-02-04 18:43:00', '2020-02-04 18:43:00'),
(73, 11, 'MOBILE BILL', 0, '2020-02-05 16:50:44', '2020-02-05 16:50:44'),
(74, 10, 'PURCHASE', 0, '2020-02-11 10:32:44', '2020-02-11 10:32:44'),
(75, 11, 'COURIER', 0, '2020-02-19 19:49:52', '2020-02-19 19:49:52'),
(76, 8, 'PETROL', 0, '2020-02-29 19:26:12', '2020-02-29 19:26:12'),
(77, 11, 'SHOP MAINTAINS', 0, '2020-03-03 11:51:55', '2020-03-03 11:51:55'),
(78, 8, 'PAYMENT', 0, '2020-03-19 19:20:26', '2020-03-19 19:20:26'),
(79, 8, 'SHOPE EXPENCE', 0, '2020-03-21 19:24:20', '2020-03-21 19:24:20'),
(80, 10, 'ASD', -1, '2020-07-01 12:11:45', '2020-07-01 12:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expensecategory` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `expensecategory`, `amount`, `payment_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DFSD', 'AMEER SALARY', '1500.00', 1, 0, '2020-07-02 07:06:35', '2020-07-02 07:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `incomecategories`
--

CREATE TABLE `incomecategories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `incomecategories`
--

INSERT INTO `incomecategories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'OIL LOOSE', 0, '2019-11-22 23:02:12', '2019-11-22 23:02:12'),
(2, 'PAYMENT CREDIT', -1, '2020-01-17 19:31:07', '2020-01-17 19:31:42'),
(3, 'PURCHERS RETUN', 0, '2020-05-13 16:53:14', '2020-05-13 16:53:14'),
(4, 'PUCHERS CASH RETUN', 0, '2020-05-20 17:09:44', '2020-05-20 17:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incomecategory` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_03_15_061151_create_upload_logs_table', 1),
(2, '2019_03_15_061215_create_campaigns_table', 1),
(3, '2019_03_15_065948_create_services_table', 1),
(4, '2019_03_15_120634_create_users_table', 1),
(5, '2019_03_15_122046_create_roles_table', 1),
(6, '2019_10_01_155504_create_companies_table', 1),
(7, '2019_10_09_164653_create_sms_settings_table', 1),
(8, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(9, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(11, '2016_06_01_000004_create_oauth_clients_table', 2),
(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(13, '2020_07_01_223941_create_sales_table', 3),
(14, '2020_07_01_225147_create_sale_details_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0ae70fcfce3275cdfaca07fc38fa126b74da23115067f75dec1a38335230cb358291ee1cb304e988', 7, 1, 'Service Premium', '[]', 0, '2019-11-19 08:21:13', '2019-11-19 08:21:13', '2020-11-19 08:21:13'),
('0c144e02a396ca9cc91753fce069a67a8b4173daab51802502df7d0f511e2ab38db11e82d8d8f1b3', 4, 1, 'Service Premium', '[]', 1, '2019-11-11 16:26:47', '2019-11-11 16:26:47', '2020-11-11 16:26:47'),
('0f4a56c81185d7d07b9a45d14a4ed2ef2b33c3ed764e838eb078ba7d466beedcd2f763dcd40d4a0a', 5, 1, 'Service Premium', '[]', 0, '2019-11-11 12:44:57', '2019-11-11 12:44:57', '2020-11-11 12:44:57'),
('1006b3db7b1d62f2ba9b4df180c03f0e146a4f03f4c75624283a5997bae437b9598541b38592df17', 7, 1, 'Service Premium', '[]', 0, '2019-11-16 08:14:08', '2019-11-16 08:14:08', '2020-11-16 08:14:08'),
('151cb664b2100ad71e843b0b21d91b17f3d0aa9c321e5f26022d54b8f0690c34cd8865322d55c427', 2, 1, 'Service Premium', '[]', 1, '2019-11-16 17:47:47', '2019-11-16 17:47:47', '2020-11-16 17:47:47'),
('15906e38f99caba3b45038650db3d15932ba17b698d19f062d78429c5834c0a60f9ac9e147bb31ac', 7, 1, 'Service Premium', '[]', 0, '2019-11-14 07:52:33', '2019-11-14 07:52:33', '2020-11-14 07:52:33'),
('15c681c49dfb871d744db45a69e291fc79391df0092fac4b1a11918aaabbb9471f7f76408c8d4a96', 2, 1, 'Service Premium', '[]', 1, '2019-11-15 18:08:20', '2019-11-15 18:08:20', '2020-11-15 18:08:20'),
('1f26edab0d040bca27f86083a5b0ff0aca9a3ecbd90e657811ddc6640a400b891c2ccaf807e490a4', 7, 1, 'Service Premium', '[]', 1, '2019-11-18 08:35:56', '2019-11-18 08:35:56', '2020-11-18 08:35:56'),
('216a6f76f360797beb56681c8aed4da20fa7c66e2e45e03a9a52e2fa95351c22bdbf27da7afee247', 2, 1, 'Service Premium', '[]', 0, '2019-11-17 12:32:19', '2019-11-17 12:32:19', '2020-11-17 12:32:19'),
('2198c9b6c93071a9ad64473a192e7ac95470e6050e9ac6bd8988d00fd5add2a0b51621b1a5a8cd9c', 5, 1, 'Service Premium', '[]', 1, '2019-11-19 10:39:11', '2019-11-19 10:39:11', '2020-11-19 10:39:11'),
('2b734843765137e91405c7e174e0a5d944ad238e5ad46e7d74564b08db0248cbbfc870ea7dcb6b4e', 4, 1, 'Service Premium', '[]', 0, '2019-11-15 12:15:14', '2019-11-15 12:15:14', '2020-11-15 12:15:14'),
('2c1ef5c6252aa33aaea9b769947925d42d58d860f36d3f60bdd23ffca803db536bc4645ab6240fbf', 4, 1, 'Service Premium', '[]', 1, '2019-11-15 12:09:59', '2019-11-15 12:09:59', '2020-11-15 12:09:59'),
('2d41e6ab494d5b410f6e3af7f87827cf6dc7ce8a5abbbb9784b5eaecc35666d6b69314cd21f2d67c', 7, 1, 'Service Premium', '[]', 0, '2019-11-13 08:13:58', '2019-11-13 08:13:58', '2020-11-13 08:13:58'),
('310257f67b3dc889ed0a775de059fcb8c151528c32c7d7271a4a3f7f10b7290786c70dac675b4872', 4, 1, 'Service Premium', '[]', 1, '2019-11-12 15:03:21', '2019-11-12 15:03:21', '2020-11-12 15:03:21'),
('350439b630d01ae967a061c06f8a2a8a3b61a8dfa54dc4cd0cdc6ab005bc562da0e3cbf9f2ed8083', 8, 1, 'Service Premium', '[]', 1, '2019-11-14 11:30:12', '2019-11-14 11:30:12', '2020-11-14 11:30:12'),
('390d79b161c6dfb362008c822a28031fe9e1f67751b079a4679611f189eede4c49b92d1fc006c573', 5, 1, 'Service Premium', '[]', 0, '2019-11-19 10:49:01', '2019-11-19 10:49:01', '2020-11-19 10:49:01'),
('3fbb2ab7a0c5059b1705f33c74f61093cb0017b4666c0703a51326048af8c10309623c2e8ba2599f', 2, 1, 'Service Premium', '[]', 1, '2019-11-14 12:04:34', '2019-11-14 12:04:34', '2020-11-14 12:04:34'),
('410653c0628211469abe60f08dbb29eb3d233f0552a68fe6341cc55807cbb54dc53466b1d7ff5c10', 4, 1, 'Service Premium', '[]', 1, '2019-11-15 12:06:48', '2019-11-15 12:06:48', '2020-11-15 12:06:48'),
('4763a9e0e8a9e8a94e70169f681e7847848a5136557863e4953651cd3cc5ee0a5b51915ec5b2bf62', 5, 1, 'Service Premium', '[]', 1, '2019-11-16 17:47:18', '2019-11-16 17:47:18', '2020-11-16 17:47:18'),
('4a0993202edbe1f10efa4a8be26774f47562f597920cfbdb54e652fd639c4fdc0e2cf6c42fe36f4b', 7, 1, 'Service Premium', '[]', 0, '2019-11-15 08:22:18', '2019-11-15 08:22:18', '2020-11-15 08:22:18'),
('4dc2ec755e8740207dbc9613c4361fd185ba463c808c5d44c4c47c8ce962d303cb7ae5d9ab32adc7', 5, 1, 'Service Premium', '[]', 0, '2019-11-18 09:24:22', '2019-11-18 09:24:22', '2020-11-18 09:24:22'),
('57030295fa58203fdfeab6a20c75b65487a0f364578dd64314b6ddfa51c80ff9ed84612cab9a4d83', 5, 1, 'Service Premium', '[]', 1, '2019-11-13 20:26:25', '2019-11-13 20:26:25', '2020-11-13 20:26:25'),
('613795c29ec677e0d7fa1dd8b834e224e8e7a0f8123805bad2839cc41a97cbae1cb8f3da74a40a2d', 8, 1, 'Service Premium', '[]', 1, '2019-11-14 10:47:26', '2019-11-14 10:47:26', '2020-11-14 10:47:26'),
('6332d35f7b49747d50ab8d7853670c49b377bd9006501deb7bd34735a2688a3a7d60650e5117e8c1', 2, 1, 'Service Premium', '[]', 1, '2019-11-14 22:26:33', '2019-11-14 22:26:33', '2020-11-14 22:26:33'),
('638ca189efb65f385106c24e88ffad38080a7a1ed797888d956d7fe5542de0cbdefaa5dc820ad9b1', 2, 1, 'Service Premium', '[]', 1, '2019-11-12 17:07:17', '2019-11-12 17:07:17', '2020-11-12 17:07:17'),
('6a08ddc77682953512733c389bccb16351210a5d33816dcbbc563b7b1fadeb88b0e8c940ae6471d2', 5, 1, 'Service Premium', '[]', 1, '2019-11-11 12:46:02', '2019-11-11 12:46:02', '2020-11-11 12:46:02'),
('6c3dafc5ee104e5644a57e8199e5ac3f78bd83f4dee5f79abbb3430b30f6185719c664e590644d98', 5, 1, 'Service Premium', '[]', 1, '2019-11-13 20:02:36', '2019-11-13 20:02:36', '2020-11-13 20:02:36'),
('70f8e695b631acdae42621ac4c5a2345889f97b6a5c37e4fc217d6734fc849ba0709f705cd8b3334', 2, 1, 'Service Premium', '[]', 0, '2019-11-12 16:16:05', '2019-11-12 16:16:05', '2020-11-12 16:16:05'),
('779778591f414b136a2acc4600a19ba54a57a79ec7b60bdfe3e7135908724b9a977ecd15df24eebd', 4, 1, 'Service Premium', '[]', 1, '2019-11-16 17:46:51', '2019-11-16 17:46:51', '2020-11-16 17:46:51'),
('77dd6346ef3599703332c1ad6129eae2da70d84c78064c97ed0fd309bb1e3ecf68439d84bd3614ef', 10, 1, 'Service Premium', '[]', 0, '2019-11-18 17:29:12', '2019-11-18 17:29:12', '2020-11-18 17:29:12'),
('921aebb9a91ddf6be1137b22ec6b8f772de1946a814466b12b9498a8e42a16c489a2104d3bc9e3c3', 4, 1, 'Service Premium', '[]', 0, '2019-11-15 12:22:44', '2019-11-15 12:22:44', '2020-11-15 12:22:44'),
('93e6d66beebc96990eaaa74fe4c6f82537b92126a40f3609f523d66949e790ce14ddd367d16fb88e', 2, 1, 'Service Premium', '[]', 1, '2019-11-15 14:53:31', '2019-11-15 14:53:31', '2020-11-15 14:53:31'),
('99348deb8321586775e525e537187dddaa1ec29506c143f205c216e950d14806ca3c788ed69c29be', 5, 1, 'Service Premium', '[]', 1, '2019-11-14 11:23:13', '2019-11-14 11:23:13', '2020-11-14 11:23:13'),
('a813d5342e39982f70ae16102f03fb44b08c7fcaa96f8c8840e8972c245e1875546dac8809aaa300', 2, 1, 'Service Premium', '[]', 0, '2019-11-15 11:55:14', '2019-11-15 11:55:14', '2020-11-15 11:55:14'),
('b2675473e5c45d5e577471dd5372b8375e2bb1854a9421ad9c2666fe415e1242ddd9a54b3d3d9fef', 10, 1, 'Service Premium', '[]', 1, '2019-11-18 17:26:07', '2019-11-18 17:26:07', '2020-11-18 17:26:07'),
('b8d624864ca2185999bd65d4c4f64c1e011cb4ebd278429990d95f8332eff0e214e5725ce4b7f824', 5, 1, 'Service Premium', '[]', 1, '2019-11-12 11:21:26', '2019-11-12 11:21:26', '2020-11-12 11:21:26'),
('bd3bdd4133e12934de0059f73035f38c838c593eac3adf4aa0359ca24ce14f98c96eb9864922286a', 7, 1, 'Service Premium', '[]', 1, '2019-11-15 19:28:47', '2019-11-15 19:28:47', '2020-11-15 19:28:47'),
('c421b1f161cc9f5bdafef9514d0061912742669be0c94ab10c363808e5aac2577109fa336cb9c0d7', 5, 1, 'Service Premium', '[]', 1, '2019-11-19 10:50:23', '2019-11-19 10:50:23', '2020-11-19 10:50:23'),
('ca62c10df92143326776886cbe5c1deba22410ee3ddde15b0a0125204cf6382e0e44a776353b4309', 10, 1, 'Service Premium', '[]', 0, '2019-11-19 11:19:01', '2019-11-19 11:19:01', '2020-11-19 11:19:01'),
('d2259d7498a221d48f0830a00ad059d1b35c430029a2316d023c53cf9bb2ef870bb7728c5cccac24', 7, 1, 'Service Premium', '[]', 1, '2019-11-13 20:03:06', '2019-11-13 20:03:06', '2020-11-13 20:03:06'),
('d4625fa7f924629ba930d10c75271fbdc71ba1df8525d7dbbea142f35b61edf7426cea4505d8fbf2', 7, 1, 'Service Premium', '[]', 1, '2019-11-11 18:40:10', '2019-11-11 18:40:10', '2020-11-11 18:40:10'),
('ddfbbf43260f730751ba2b18e67bb99098fc10d6a18899c5d1dc3e4677a8610e68d275f1784707bf', 7, 1, 'Service Premium', '[]', 1, '2019-11-12 16:58:00', '2019-11-12 16:58:00', '2020-11-12 16:58:00'),
('de6d6c11382bee953e99003049daa8d8db85fd91956df34f08c973de309c81dbbd94e2660b3b737e', 4, 1, 'Service Premium', '[]', 0, '2019-11-15 18:05:45', '2019-11-15 18:05:45', '2020-11-15 18:05:45'),
('e1b375a3454de43cdf86d69cc0a15ed900489907c9afaefd670244b28b3d58a51abba86b64f28d83', 5, 1, 'Service Premium', '[]', 1, '2019-11-16 17:39:17', '2019-11-16 17:39:17', '2020-11-16 17:39:17'),
('e205d00e14568df42b1213840a1320fa82b4525290dffcf426f42c318c8b21de1ce3f760f4403b91', 6, 1, 'Service Premium', '[]', 0, '2019-11-11 20:26:05', '2019-11-11 20:26:05', '2020-11-11 20:26:05'),
('e36d35387d65c78541548e48abdc0160459eabfc71ed30a65aa9edfe9d95ce36b057af224b064fd4', 7, 1, 'Service Premium', '[]', 1, '2019-11-14 11:22:26', '2019-11-14 11:22:26', '2020-11-14 11:22:26'),
('e6951dd23fab6b5d19c68c71e160beac5584d2799230d8a8cd322ca3aee6cadaa7cd153f9bfac49f', 7, 1, 'Service Premium', '[]', 1, '2019-11-12 09:10:45', '2019-11-12 09:10:45', '2020-11-12 09:10:45'),
('fbf985599f30841c099aa073155718459081b635bf7ad1f30d868e8ac5f9d918516c62b792e706d5', 7, 1, 'Service Premium', '[]', 0, '2019-11-15 18:33:37', '2019-11-15 18:33:37', '2020-11-15 18:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'fkL6Iq7kAaDwHYNr9qGzjMSCN3d4s6XnoNqhmNiA', 'http://localhost', 1, 0, 0, '2019-11-11 12:44:50', '2019-11-11 12:44:50'),
(2, NULL, 'Laravel Password Grant Client', 'd0sfgbHrDNDT96bszf96kZmXv07hXYKPXJqHcQDQ', 'http://localhost', 0, 1, 0, '2019-11-11 12:44:50', '2019-11-11 12:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-11-11 12:44:50', '2019-11-11 12:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `receipt_no` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `receipt_no`, `payment_type`, `amount`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '11000.00', 'aaaa', 0, '2020-07-02 08:04:38', '2020-07-02 08:04:38'),
(2, 2, 2, '350.00', 'dfgfxd', 0, '2020-07-02 08:06:38', '2020-07-02 08:06:38'),
(3, 3, 2, '150.00', 'xcvxzc', 0, '2020-07-02 08:11:32', '2020-07-02 08:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'CASH', 0, NULL, '2020-03-06 08:55:16', NULL),
(2, 'BANK', 0, NULL, '2020-03-06 08:55:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `item_type` smallint(6) NOT NULL DEFAULT '1' COMMENT '1- piece, 2-kg',
  `ndp` decimal(10,2) DEFAULT NULL,
  `mrp` decimal(10,2) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `item_type`, `ndp`, `mrp`, `status`, `created_at`, `updated_at`) VALUES
(1, 'iphone', 1, '5500.00', '5500.00', 0, '2020-06-23 02:48:28', '2020-07-02 05:53:09'),
(2, 'Mike 5s', 1, '38.00', '290.00', 0, '2020-06-26 08:43:31', '2020-07-02 06:32:31'),
(3, 'Flash s5', 1, '30.00', NULL, 0, '2020-06-27 09:41:35', '2020-07-02 08:19:36'),
(4, 'Slider M12', 1, NULL, NULL, 0, '2020-06-27 10:09:47', '2020-06-27 10:09:47'),
(5, 'Charge Port M12', 1, '200.00', NULL, 0, '2020-06-27 10:11:30', '2020-07-01 11:13:19'),
(6, 'iphone 11 pouch', 1, '35.00', NULL, 0, '2020-06-29 07:59:46', '2020-07-02 08:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `purchasecredits`
--

CREATE TABLE `purchasecredits` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment` int(11) NOT NULL DEFAULT '0',
  `payment_type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchasecredits`
--

INSERT INTO `purchasecredits` (`id`, `vendor_id`, `amount`, `remarks`, `payment`, `payment_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '500.00', 'XCVX', 0, NULL, 0, '2020-07-02 08:19:37', '2020-07-02 08:19:37'),
(2, 1, '200.00', 'cbc', 1, 2, 0, '2020-07-02 08:20:45', '2020-07-02 08:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL COMMENT '1- paid, 2 - not paid',
  `company_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchasevendors`
--

CREATE TABLE `purchasevendors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opening_credit` double(8,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchasevendors`
--

INSERT INTO `purchasevendors` (`id`, `name`, `address`, `mobile_no`, `opening_credit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ABCD', 'adasdas', '528545455', 123000.00, 0, '2020-07-01 10:45:14', '2020-07-01 10:45:14'),
(2, 'PARI', 'adasdas', '7858966585', 21000.00, 0, '2020-07-01 10:48:41', '2020-07-01 10:48:41'),
(3, 'sdgsdg', 'sdgsdg', '423522535', 23000.00, -1, '2020-07-01 10:49:37', '2020-07-01 10:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_log_details`
--

CREATE TABLE `purchase_log_details` (
  `id` int(11) NOT NULL,
  `product` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `remarks` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_log_details`
--

INSERT INTO `purchase_log_details` (`id`, `product`, `qty`, `rate`, `purchase_date`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Charge Port M12', 2, '500.00', '2020-06-28', 'SDFG', 0, '2020-06-28 12:40:16', '2020-06-28 12:40:16'),
(2, 'Flash s5', 4, '2500.00', '2020-06-28', 'SDFG', 0, '2020-06-28 12:40:16', '2020-06-28 12:40:16'),
(3, 'iphone 11 pouch', 25, '90.00', '2020-06-29', 'ADAD', 0, '2020-06-29 07:59:47', '2020-06-29 07:59:47'),
(4, 'iphone', 2, '200.00', '2020-07-01', 'SSDSAD', 0, '2020-07-01 10:53:55', '2020-07-01 10:53:55'),
(5, 'Flash s5', 2, '100.00', '2020-07-01', 'XCVXZV', 0, '2020-07-01 11:07:12', '2020-07-01 11:07:12'),
(6, 'Charge Port M12', 21, '30.00', '2020-07-01', 'ASDAS', 0, '2020-07-01 11:08:04', '2020-07-01 11:08:04'),
(7, 'Charge Port M12', 2, '200.00', '2020-07-01', 'SFS', 0, '2020-07-01 11:13:19', '2020-07-01 11:13:19'),
(8, 'iphone', 50, '5500.00', '2020-07-02', 'GVSX', 0, '2020-07-01 18:38:13', '2020-07-01 18:38:13'),
(9, 'iphone', 5, '5500.00', '2020-07-02', 'XVXX', 0, '2020-07-02 05:53:09', '2020-07-02 05:53:09'),
(10, 'Flash s5', 10, '55.00', '2020-07-02', 'XVXX', 0, '2020-07-02 05:53:09', '2020-07-02 05:53:09'),
(11, 'Flash s5', 5, '55.00', '2020-07-02', 'ASDAS', 0, '2020-07-02 06:32:31', '2020-07-02 06:32:31'),
(12, 'Mike 5s', 3, '38.00', '2020-07-02', 'ASDAS', 0, '2020-07-02 06:32:31', '2020-07-02 06:32:31'),
(13, 'Flash s5', 5, '30.00', '2020-07-02', 'XCVX', 0, '2020-07-02 08:12:28', '2020-07-02 08:12:28'),
(14, 'Flash s5', 5, '30.00', '2020-07-02', 'XCVX', 0, '2020-07-02 08:12:43', '2020-07-02 08:12:43'),
(15, 'Flash s5', 5, '30.00', '2020-07-02', 'XCVX', 0, '2020-07-02 08:17:51', '2020-07-02 08:17:51'),
(16, 'Flash s5', 5, '30.00', '2020-07-02', 'XCVX', 0, '2020-07-02 08:19:14', '2020-07-02 08:19:14'),
(17, 'Flash s5', 5, '30.00', '2020-07-02', 'XCVX', 0, '2020-07-02 08:19:36', '2020-07-02 08:19:36'),
(18, 'iphone 11 pouch', 10, '35.00', '2020-07-02', 'XCVX', 0, '2020-07-02 08:19:37', '2020-07-02 08:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(0, 'SUPERADMIN', NULL, NULL),
(1, 'ADMIN', NULL, NULL),
(2, 'SERVICE', NULL, NULL),
(3, 'SHOPADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receipt_no` int(11) NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_date` date NOT NULL,
  `total_items` int(11) NOT NULL,
  `total_gross_amount` decimal(10,2) NOT NULL,
  `total_discount_amount` decimal(10,2) DEFAULT NULL,
  `total_net_amount` decimal(10,2) NOT NULL,
  `received_amount` decimal(10,2) NOT NULL,
  `credit` int(11) NOT NULL DEFAULT '0',
  `payment_type` int(11) DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT '0',
  `remarks` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `receipt_no`, `customer_name`, `mobile`, `sale_date`, `total_items`, `total_gross_amount`, `total_discount_amount`, `total_net_amount`, `received_amount`, `credit`, `payment_type`, `payment_status`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'LALU', '4565656563', '2020-07-02', 2, '11055.00', '55.00', '11000.00', '11000.00', 0, NULL, 0, 'aaaa', 0, '2020-07-02 08:04:38', '2020-07-02 08:04:38'),
(2, 2, 'MANU', '4565857485', '2020-07-02', 3, '355.00', '5.00', '350.00', '350.00', 0, NULL, 0, 'dfgfxd', 0, '2020-07-02 08:06:39', '2020-07-02 08:06:39'),
(3, 3, 'BALU', '1478965842', '2020-07-02', 2, '5600.00', '0.00', '5600.00', '150.00', 1, NULL, 0, 'xgvsd', 0, '2020-07-02 08:10:03', '2020-07-02 08:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receipt_no` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `service_string` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `remarks` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `receipt_no`, `product_id`, `service_string`, `rate`, `qty`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Flash s5', '55.00', 1, 'aaaa', 0, '2020-07-02 08:04:38', '2020-07-02 08:04:38'),
(2, 1, 1, 'iphone', '5500.00', 2, 'aaaa', 0, '2020-07-02 08:04:38', '2020-07-02 08:04:38'),
(3, 2, 5, 'Charge Port M12', '80.00', 3, 'dfgfxd', 0, '2020-07-02 08:06:38', '2020-07-02 08:06:38'),
(4, 2, 3, 'Flash s5', '55.00', 1, 'dfgfxd', 0, '2020-07-02 08:06:38', '2020-07-02 08:06:38'),
(5, 2, 4, 'Slider M12', '60.00', 1, 'dfgfxd', 0, '2020-07-02 08:06:38', '2020-07-02 08:06:38'),
(6, 3, 1, 'iphone', '5500.00', 1, 'xgvsd', 0, '2020-07-02 08:10:03', '2020-07-02 08:10:03'),
(7, 3, 6, 'iphone 11 pouch', '100.00', 1, 'xgvsd', 0, '2020-07-02 08:10:03', '2020-07-02 08:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
(31, 'GENERAL CHECKUP', 8, 0, '2019-11-18 15:20:45', '2019-11-18 23:17:11'),
(36, 'OIL CHANGE', 8, 0, '2019-11-18 17:43:46', '2019-11-18 17:43:46'),
(37, 'CHAIN SPOKET CHANGE', 8, 0, '2019-11-18 17:44:23', '2019-11-18 17:44:23'),
(38, 'THROTTLE CABLE CHANGE', 8, 0, '2019-11-18 17:45:00', '2019-11-18 17:45:00'),
(39, 'CLUTCH CABLE CHANGE', 8, 0, '2019-11-18 17:45:16', '2019-11-18 17:45:16'),
(40, 'HEAD LIGHT BULB CHANGE', 8, 0, '2019-11-18 17:45:45', '2019-11-18 17:45:45'),
(41, 'INDICATOR BULB CHANGE', 8, 0, '2019-11-18 17:46:05', '2019-11-18 17:46:05'),
(42, 'SPEEDOMETER CABLE CHANGE', 8, 0, '2019-11-18 17:52:10', '2019-11-18 17:52:10'),
(43, 'REAR BRAKE PADS CHANGE', 8, 0, '2019-11-18 23:10:20', '2019-11-18 23:10:20'),
(44, 'REAR MUDGUARD CHANGE', 8, 0, '2019-11-18 23:10:36', '2019-11-18 23:10:36'),
(45, 'REAR BRAKE SERVICE', 8, 0, '2019-11-18 23:11:00', '2019-11-18 23:11:00'),
(46, 'CHAIN SERVICE', 8, 0, '2019-11-18 23:12:01', '2019-11-18 23:12:01'),
(47, 'CHAIN LUBRICANTS AND CLEANING', 8, 0, '2019-11-18 23:12:33', '2019-11-18 23:12:33'),
(48, 'CHAIN LUB AND CLEAN WITH CHAIN SERVICE', 8, 0, '2019-11-18 23:15:00', '2019-11-18 23:15:00'),
(49, 'REAR CARRIER FITTING', 8, 0, '2019-11-18 23:15:19', '2019-11-18 23:15:19'),
(50, 'REAR SEAT RING FIXING', 8, 0, '2019-11-18 23:15:46', '2019-11-18 23:15:46'),
(51, 'SEAT COVER FITTING', 8, 0, '2019-11-18 23:16:04', '2019-11-18 23:16:04'),
(52, 'CRASH GURD FITTING', 8, 0, '2019-11-18 23:16:26', '2019-11-18 23:16:26'),
(53, 'SWINGARM BUSH CHANGE', 8, 0, '2019-11-18 23:17:51', '2019-11-18 23:17:51'),
(54, 'KICKER SPRING CHANGE', 8, 0, '2019-11-18 23:18:23', '2019-11-18 23:18:42'),
(55, 'FRONT BRAKE PADS CHANGE', 8, 0, '2019-11-18 23:19:18', '2019-11-18 23:19:18'),
(56, 'FRONT BRAKE SERVICE', 8, 0, '2019-11-18 23:19:33', '2019-11-18 23:19:33'),
(57, 'FRONT MUDGUARD CHANGE', 8, 0, '2019-11-18 23:19:55', '2019-11-18 23:19:55'),
(58, 'FRONT FORK TUBE SERVICE', 8, 0, '2019-11-18 23:20:35', '2019-11-18 23:20:35'),
(59, 'FRONT FORK TUBE CHANGE', 8, 0, '2019-11-18 23:20:58', '2019-11-18 23:20:58'),
(60, 'TESTOM CHANGE', 8, 0, '2019-11-18 23:21:29', '2019-11-18 23:21:29'),
(61, 'BOLL RICER CHANGE', 8, 0, '2019-11-18 23:22:12', '2019-11-18 23:22:12'),
(62, 'FRONT BRAKE CABLE CHANGE', 8, 0, '2019-11-18 23:22:57', '2019-11-18 23:22:57'),
(63, 'AIR FILTER CHANGE', 8, 0, '2019-11-18 23:23:18', '2019-11-18 23:23:18'),
(64, 'OIL CHANGE OLD MODEL BULLET', 8, 0, '2019-11-18 23:24:44', '2019-11-18 23:24:44'),
(65, 'CLUTCH SERVICE', 8, 0, '2019-11-18 23:25:06', '2019-11-18 23:25:06'),
(66, 'CARBURATOR CLEANING', 8, 0, '2019-11-18 23:25:29', '2019-11-18 23:25:29'),
(67, 'CARBURATOR SERVICE', 8, 0, '2019-11-18 23:25:48', '2019-11-18 23:25:48'),
(68, 'CARBURATOR CHANGE', 8, 0, '2019-11-18 23:26:02', '2019-11-18 23:26:02'),
(69, 'PETROL TANK COVER FIXING', 8, 0, '2019-11-18 23:26:33', '2019-11-18 23:26:33'),
(70, 'PETROL TANK CLEANING', 8, 0, '2019-11-18 23:27:01', '2019-11-18 23:27:01'),
(71, 'PETROL TANK CHANGE', 8, 0, '2019-11-18 23:27:24', '2019-11-18 23:27:24'),
(72, 'PETROL TANK SERVICE', 8, 0, '2019-11-18 23:28:33', '2019-11-18 23:28:33'),
(73, 'PETROL TANK STICKER WORK', 8, 0, '2019-11-18 23:29:07', '2019-11-18 23:29:07'),
(74, 'BATTERY SERVICE', 8, 0, '2019-11-18 23:29:26', '2019-11-18 23:29:26'),
(75, 'BATTERY CHARGING', 8, 0, '2019-11-18 23:29:39', '2019-11-18 23:29:39'),
(76, 'BATTERY REPLACEMENT', 8, 0, '2019-11-18 23:29:51', '2019-11-18 23:29:51'),
(77, 'TYRE CHANGE FRONT WHEEL', 8, 0, '2019-11-18 23:31:48', '2019-11-18 23:32:13'),
(78, 'TYRE CHANGE REAR WHEEL', 8, 0, '2019-11-18 23:32:28', '2019-11-18 23:32:28'),
(79, 'RH SWITCH CHANGE', 8, 0, '2019-11-18 23:33:13', '2019-11-18 23:33:13'),
(80, 'LH SWITCH CHANGE', 8, 0, '2019-11-18 23:33:27', '2019-11-18 23:33:27'),
(81, 'THROTTLE GRIP CHANGE', 8, 0, '2019-11-18 23:34:02', '2019-11-18 23:34:02'),
(82, 'LH GRIP CHANGE', 8, 0, '2019-11-18 23:34:18', '2019-11-18 23:34:18'),
(83, 'MIRROR FITTING', 8, 0, '2019-11-18 23:34:30', '2019-11-18 23:34:30'),
(84, 'SPEEDOMETER CHANGE', 8, 0, '2019-11-18 23:34:47', '2019-11-18 23:34:47'),
(85, 'SPEEDOMETER SERVICE', 8, 0, '2019-11-18 23:35:03', '2019-11-18 23:35:03'),
(86, 'SPEEDOMETER PINION CHANGE', 8, 0, '2019-11-18 23:35:39', '2019-11-18 23:35:39'),
(87, 'ONE WAY CLUTCH SERVICE', 8, 0, '2019-11-18 23:36:25', '2019-11-18 23:36:25'),
(88, 'ONE WAY CLUTCH CHANGE', 8, 0, '2019-11-18 23:36:47', '2019-11-18 23:36:47'),
(89, 'REAR BRAKE LIGHT SERVICE', 8, 0, '2019-11-18 23:37:32', '2019-11-18 23:37:32'),
(90, 'REAR BRAKE LIGHT CHANGE', 8, 0, '2019-11-18 23:37:48', '2019-11-18 23:37:48'),
(91, 'FUSE CHANGE', 8, 0, '2019-11-18 23:38:58', '2019-11-18 23:38:58'),
(92, 'HORN SERVICE', 8, 0, '2019-11-18 23:39:24', '2019-11-18 23:39:24'),
(93, 'HORN FIXING', 8, 0, '2019-11-18 23:39:46', '2019-11-18 23:39:46'),
(94, 'WIRING SET SERVICE', 8, 0, '2019-11-18 23:40:32', '2019-11-18 23:40:32'),
(95, 'WIRING KIT CHANGE', 8, 0, '2019-11-18 23:40:54', '2019-11-18 23:40:54'),
(96, 'INDICATOR BUSSAR FIXING', 8, 0, '2019-11-18 23:41:33', '2019-11-18 23:41:33'),
(97, 'FOR INDICATOR SERVICE', 8, 0, '2019-11-18 23:42:02', '2019-11-18 23:42:02'),
(98, 'KICKER SHAFT CHANGE', 8, 0, '2019-11-18 23:42:39', '2019-11-18 23:42:39'),
(99, 'BATTERY CARRIER FITTING', 8, 0, '2019-11-18 23:44:02', '2019-11-18 23:44:02'),
(100, 'BATTERY COVER LOCK CHARGE', 8, 0, '2019-11-18 23:44:25', '2019-11-18 23:44:25'),
(101, 'BATTERY COVER CHARGING', 8, 0, '2019-11-18 23:44:44', '2019-11-18 23:44:44'),
(102, 'TCI SERVICE', 8, 0, '2019-11-18 23:45:16', '2019-11-18 23:45:16'),
(103, 'TCI CHANGE', 8, 0, '2019-11-18 23:45:29', '2019-11-18 23:45:29'),
(104, 'CDI SERVICE', 8, 0, '2019-11-18 23:45:47', '2019-11-18 23:45:47'),
(105, 'CDI CHANGE', 8, 0, '2019-11-18 23:46:02', '2019-11-18 23:46:02'),
(106, 'PETROL T SERVICE', 8, 0, '2019-11-18 23:46:27', '2019-11-18 23:46:27'),
(107, 'PETROL T CHANGE', 8, 0, '2019-11-18 23:46:49', '2019-11-18 23:46:49'),
(108, 'NORMAL WASH', 8, 0, '2019-11-18 23:47:22', '2019-11-18 23:47:22'),
(109, 'DIESEL WASH', 8, 0, '2019-11-18 23:47:32', '2019-11-18 23:47:32'),
(110, 'SILENCER FIXING', 8, 0, '2019-11-18 23:48:02', '2019-11-18 23:48:02'),
(111, 'SILENCER SERVICE', 8, 0, '2019-11-18 23:48:20', '2019-11-18 23:48:20'),
(112, 'FRONT NUMBER PLATE SERVICE', 8, 0, '2019-11-18 23:49:18', '2019-11-18 23:49:18'),
(113, 'FRONT NUMBER PLATE CHANGE', 8, 0, '2019-11-18 23:49:48', '2019-11-18 23:49:48'),
(114, 'REAR NUMBER PLATE SERVICE', 8, 0, '2019-11-18 23:50:16', '2019-11-18 23:50:16'),
(115, 'REAR NUMBER PLATE CHANGE', 8, 0, '2019-11-18 23:50:35', '2019-11-18 23:50:35'),
(116, 'COMPLETE ENGINE BUFFING', 8, 0, '2019-11-18 23:51:07', '2019-11-18 23:51:35'),
(117, 'COMPLETE ENGINE POWDER COATING AND ENGINE PAINT', 8, 0, '2019-11-18 23:52:27', '2019-11-18 23:52:53'),
(118, 'COMPLETE POWDER COATING WITH ENGINE +BOTH WHEELS AND SILENCER WITH SILENCER BEND', 8, 0, '2019-11-18 23:53:52', '2019-11-18 23:55:11'),
(119, 'PETROL TANK PAINTING', 8, 0, '2019-11-18 23:56:39', '2019-11-18 23:56:39'),
(120, 'FRONT MUDGUARD PAINTING', 8, 0, '2019-11-18 23:57:00', '2019-11-18 23:57:00'),
(121, 'REAR MUDGUARD PAINTING', 8, 0, '2019-11-18 23:57:17', '2019-11-18 23:57:17'),
(122, 'SIDE BOX PAINTING LH', 8, 0, '2019-11-18 23:57:35', '2019-11-18 23:57:51'),
(123, 'SIDE BOX PAINTING RH', 8, 0, '2019-11-18 23:58:08', '2019-11-18 23:58:08'),
(124, 'HANDLE BAR CHARGE', 8, 0, '2019-11-18 23:58:36', '2019-11-18 23:58:36'),
(125, 'HANDLE BAR LIGHT FITTING', 8, 0, '2019-11-18 23:59:07', '2019-11-18 23:59:07'),
(126, 'AMPIAR MEETAR SERVICE', 8, 0, '2019-11-18 23:59:55', '2019-11-18 23:59:55'),
(127, 'AMPIAR MEETAR CHANGE', 8, 0, '2019-11-19 00:00:19', '2019-11-19 00:00:19'),
(128, 'TIMING CHAIN SERVICE', 8, 0, '2019-11-19 00:00:50', '2019-11-19 00:00:50'),
(129, 'TIMING CHAIN CHANGE', 8, 0, '2019-11-19 00:01:26', '2019-11-19 00:01:26'),
(130, 'POWER FLUG CHANGE', 8, 0, '2019-11-19 00:01:51', '2019-11-19 00:01:51'),
(131, 'HEAD SERVICE', 8, 0, '2019-11-19 00:02:13', '2019-11-19 00:02:13'),
(132, 'CYLINDER SERVICE', 8, 0, '2019-11-19 00:02:35', '2019-11-19 00:02:35'),
(133, 'OLD MODEL CLUTCH PLATE CHANGE', 8, 0, '2019-11-19 00:03:06', '2019-11-19 00:03:06'),
(134, 'COMPLETE ENGINE WORK', 8, 0, '2019-11-19 00:03:59', '2019-11-19 00:03:59'),
(135, 'COMPLETE PAINTING AND POWDER COATING WORK', 8, 0, '2019-11-19 00:05:06', '2019-11-19 00:05:06'),
(136, 'CRASH GURD ROAP FIXING', 8, 0, '2019-11-19 00:05:43', '2019-11-19 00:05:43'),
(137, 'ALLOYE WHEEL FITTING', 8, 0, '2019-11-19 00:06:46', '2019-11-19 00:06:46'),
(138, 'COMPLETE GRILLE FITTING', 8, 0, '2019-11-19 00:07:14', '2019-11-19 00:07:14'),
(139, 'FRONT FOOTREST CHANGE', 8, 0, '2019-11-19 00:08:04', '2019-11-19 00:08:04'),
(140, 'FRONT FOOTREST SERVICE', 8, 0, '2019-11-19 00:08:32', '2019-11-19 00:08:32'),
(141, 'REAR FOOTREST CHANGE', 8, 0, '2019-11-19 00:08:50', '2019-11-19 00:08:50'),
(142, 'REAR FOOTREST SERVICE', 8, 0, '2019-11-19 00:09:11', '2019-11-19 00:09:11'),
(143, 'SAREEGURD FIXING', 8, 0, '2019-11-19 00:09:49', '2019-11-19 00:09:49'),
(144, 'GENERAL CHECKUP', 10, 0, NULL, NULL),
(145, 'OIL CHANGE', 10, 0, NULL, NULL),
(146, 'CHAIN SPOKET CHANGE', 10, 0, NULL, NULL),
(147, 'THROTTLE CABLE CHANGE', 10, 0, NULL, NULL),
(148, 'CLUTCH CABLE CHANGE', 10, 0, NULL, NULL),
(149, 'HEAD LIGHT BULB CHANGE', 10, 0, NULL, NULL),
(150, 'INDICATOR BULB CHANGE', 10, 0, NULL, NULL),
(151, 'SPEEDOMETER CABLE CHANGE', 10, 0, NULL, NULL),
(152, 'REAR BRAKE PADS CHANGE', 10, 0, NULL, NULL),
(153, 'REAR MUDGUARD CHANGE', 10, 0, NULL, NULL),
(154, 'REAR BRAKE SERVICE', 10, 0, NULL, NULL),
(155, 'CHAIN SERVICE', 10, 0, NULL, NULL),
(156, 'CHAIN LUBRICANTS AND CLEANING', 10, 0, NULL, NULL),
(157, 'CHAIN LUB AND CLEAN WITH CHAIN SERVICE', 10, 0, NULL, NULL),
(158, 'REAR CARRIER FITTING', 10, 0, NULL, NULL),
(159, 'REAR SEAT RING FIXING', 10, 0, NULL, NULL),
(160, 'SEAT COVER FITTING', 10, 0, NULL, NULL),
(161, 'CRASH GURD FITTING', 10, 0, NULL, NULL),
(162, 'SWINGARM BUSH CHANGE', 10, 0, NULL, NULL),
(163, 'KICKER SPRING CHANGE', 10, 0, NULL, NULL),
(164, 'FRONT BRAKE PADS CHANGE', 10, 0, NULL, NULL),
(165, 'FRONT BRAKE SERVICE', 10, 0, NULL, NULL),
(166, 'FRONT MUDGUARD CHANGE', 10, 0, NULL, NULL),
(167, 'FRONT FORK TUBE SERVICE', 10, 0, NULL, NULL),
(168, 'FRONT FORK TUBE CHANGE', 10, 0, NULL, NULL),
(169, 'TESTOM CHANGE', 10, 0, NULL, NULL),
(170, 'BOLL RICER CHANGE', 10, 0, NULL, NULL),
(171, 'FRONT BRAKE CABLE CHANGE', 10, 0, NULL, NULL),
(172, 'AIR FILTER CHANGE', 10, 0, NULL, NULL),
(173, 'OIL CHANGE OLD MODEL BULLET', 10, 0, NULL, NULL),
(174, 'CLUTCH SERVICE', 10, 0, NULL, NULL),
(175, 'CARBURATOR CLEANING', 10, 0, NULL, NULL),
(176, 'CARBURATOR SERVICE', 10, 0, NULL, NULL),
(177, 'CARBURATOR CHANGE', 10, 0, NULL, NULL),
(178, 'PETROL TANK COVER FIXING', 10, 0, NULL, NULL),
(179, 'PETROL TANK CLEANING', 10, 0, NULL, NULL),
(180, 'PETROL TANK CHANGE', 10, 0, NULL, NULL),
(181, 'PETROL TANK SERVICE', 10, 0, NULL, NULL),
(182, 'PETROL TANK STICKER WORK', 10, 0, NULL, NULL),
(183, 'BATTERY SERVICE', 10, 0, NULL, NULL),
(184, 'BATTERY CHARGING', 10, 0, NULL, NULL),
(185, 'BATTERY REPLACEMENT', 10, 0, NULL, NULL),
(186, 'TYRE CHANGE FRONT WHEEL', 10, 0, NULL, NULL),
(187, 'TYRE CHANGE REAR WHEEL', 10, 0, NULL, NULL),
(188, 'RH SWITCH CHANGE', 10, 0, NULL, NULL),
(189, 'LH SWITCH CHANGE', 10, 0, NULL, NULL),
(190, 'THROTTLE GRIP CHANGE', 10, 0, NULL, NULL),
(191, 'LH GRIP CHANGE', 10, 0, NULL, NULL),
(192, 'MIRROR FITTING', 10, 0, NULL, NULL),
(193, 'SPEEDOMETER CHANGE', 10, 0, NULL, NULL),
(194, 'SPEEDOMETER SERVICE', 10, 0, NULL, NULL),
(195, 'SPEEDOMETER PINION CHANGE', 10, 0, NULL, NULL),
(196, 'ONE WAY CLUTCH SERVICE', 10, 0, NULL, NULL),
(197, 'ONE WAY CLUTCH CHANGE', 10, 0, NULL, NULL),
(198, 'REAR BRAKE LIGHT SERVICE', 10, 0, NULL, NULL),
(199, 'REAR BRAKE LIGHT CHANGE', 10, 0, NULL, NULL),
(200, 'FUSE CHANGE', 10, 0, NULL, NULL),
(201, 'HORN SERVICE', 10, 0, NULL, NULL),
(202, 'HORN FIXING', 10, 0, NULL, NULL),
(203, 'WIRING SET SERVICE', 10, 0, NULL, NULL),
(204, 'WIRING KIT CHANGE', 10, 0, NULL, NULL),
(205, 'INDICATOR BUSSAR FIXING', 10, 0, NULL, NULL),
(206, 'FOR INDICATOR SERVICE', 10, 0, NULL, NULL),
(207, 'KICKER SHAFT CHANGE', 10, 0, NULL, NULL),
(208, 'BATTERY CARRIER FITTING', 10, 0, NULL, NULL),
(209, 'BATTERY COVER LOCK CHARGE', 10, 0, NULL, NULL),
(210, 'BATTERY COVER CHARGING', 10, 0, NULL, NULL),
(211, 'TCI SERVICE', 10, 0, NULL, NULL),
(212, 'TCI CHANGE', 10, 0, NULL, NULL),
(213, 'CDI SERVICE', 10, 0, NULL, NULL),
(214, 'CDI CHANGE', 10, 0, NULL, NULL),
(215, 'PETROL T SERVICE', 10, 0, NULL, NULL),
(216, 'PETROL T CHANGE', 10, 0, NULL, NULL),
(217, 'NORMAL WASH', 10, 0, NULL, NULL),
(218, 'DIESEL WASH', 10, 0, NULL, NULL),
(219, 'SILENCER FIXING', 10, 0, NULL, NULL),
(220, 'SILENCER SERVICE', 10, 0, NULL, NULL),
(221, 'FRONT NUMBER PLATE SERVICE', 10, 0, NULL, NULL),
(222, 'FRONT NUMBER PLATE CHANGE', 10, 0, NULL, NULL),
(223, 'REAR NUMBER PLATE SERVICE', 10, 0, NULL, NULL),
(224, 'REAR NUMBER PLATE CHANGE', 10, 0, NULL, NULL),
(225, 'COMPLETE ENGINE BUFFING', 10, 0, NULL, NULL),
(226, 'COMPLETE ENGINE POWDER COATING AND ENGINE PAINT', 10, 0, NULL, NULL),
(227, 'COMPLETE POWDER COATING WITH ENGINE +BOTH WHEELS AND SILENCER WITH SILENCER BEND', 10, 0, NULL, NULL),
(228, 'PETROL TANK PAINTING', 10, 0, NULL, NULL),
(229, 'FRONT MUDGUARD PAINTING', 10, 0, NULL, NULL),
(230, 'REAR MUDGUARD PAINTING', 10, 0, NULL, NULL),
(231, 'SIDE BOX PAINTING LH', 10, 0, NULL, NULL),
(232, 'SIDE BOX PAINTING RH', 10, 0, NULL, NULL),
(233, 'HANDLE BAR CHARGE', 10, 0, NULL, NULL),
(234, 'HANDLE BAR LIGHT FITTING', 10, 0, NULL, NULL),
(235, 'AMPIAR MEETAR SERVICE', 10, 0, NULL, NULL),
(236, 'AMPIAR MEETAR CHANGE', 10, 0, NULL, NULL),
(237, 'TIMING CHAIN SERVICE', 10, 0, NULL, NULL),
(238, 'TIMING CHAIN CHANGE', 10, 0, NULL, NULL),
(239, 'POWER FLUG CHANGE', 10, 0, NULL, NULL),
(240, 'HEAD SERVICE', 10, 0, NULL, NULL),
(241, 'CYLINDER SERVICE', 10, 0, NULL, NULL),
(242, 'OLD MODEL CLUTCH PLATE CHANGE', 10, 0, NULL, NULL),
(243, 'COMPLETE ENGINE WORK', 10, 0, NULL, NULL),
(244, 'COMPLETE PAINTING AND POWDER COATING WORK', 10, 0, NULL, NULL),
(245, 'CRASH GURD ROAP FIXING', 10, 0, NULL, NULL),
(246, 'ALLOYE WHEEL FITTING', 10, 0, NULL, NULL),
(247, 'COMPLETE GRILLE FITTING', 10, 0, NULL, NULL),
(248, 'FRONT FOOTREST CHANGE', 10, 0, NULL, NULL),
(249, 'FRONT FOOTREST SERVICE', 10, 0, NULL, NULL),
(250, 'REAR FOOTREST CHANGE', 10, 0, NULL, NULL),
(251, 'REAR FOOTREST SERVICE', 10, 0, NULL, NULL),
(252, 'SAREEGURD FIXING', 10, 0, NULL, NULL),
(253, 'OIL CHANGE', 11, -1, '2019-11-25 17:14:50', '2019-11-25 19:46:39'),
(254, 'REGULATORS CHANGE', 8, 0, '2019-11-25 17:42:58', '2019-11-25 17:42:58'),
(255, 'BRAKE LINER CHANGE', 11, -1, '2019-11-25 19:31:27', '2019-11-25 19:34:40'),
(256, 'CARBURETOR CLEANING', 11, -1, '2019-11-25 19:31:57', '2019-11-25 19:46:44'),
(257, 'TANK CLEANING', 11, -1, '2019-11-25 19:32:08', '2019-11-25 19:46:48'),
(258, 'CHAIN ADJUSTMENT', 11, -1, '2019-11-25 19:32:30', '2019-11-25 19:46:52'),
(259, 'BRAKE ADJUSTMENT FRON & BACK', 11, -1, '2019-11-25 19:32:46', '2019-11-25 19:46:56'),
(260, 'CHAIN LUB', 11, -1, '2019-11-25 19:33:11', '2019-11-25 19:43:25'),
(261, 'CHAIN LUB & CLEANING', 11, -1, '2019-11-25 19:34:04', '2019-11-25 19:46:59'),
(262, 'BRAKE PAD CHANGE FRONT', 11, -1, '2019-11-25 19:34:23', '2019-11-25 19:47:05'),
(263, 'BRAKE PAD CHANGE BACK', 11, -1, '2019-11-25 19:35:57', '2019-11-25 19:47:09'),
(264, 'WATER SERVICE', 11, -1, '2019-11-25 19:36:31', '2019-11-25 19:47:14'),
(265, 'BETERY CHARGING', 11, -1, '2019-11-25 19:42:33', '2019-11-25 19:47:24'),
(266, 'MILAGE TUNE', 11, -1, '2019-11-25 19:45:04', '2019-11-25 19:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `qty`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 69, '250.00', 0, '2020-06-26 17:10:28', '2020-07-02 08:10:03'),
(2, 2, 26, '85.00', 0, '2020-06-26 17:10:28', '2020-07-02 06:32:31'),
(3, 3, 39, '350.00', 0, '2020-06-27 09:41:35', '2020-07-02 08:19:36'),
(4, 4, 23, '185.00', 0, '2020-06-27 10:09:47', '2020-07-02 08:06:38'),
(5, 5, 48, '250.00', 0, '2020-06-27 10:11:30', '2020-07-02 08:06:38'),
(6, 3, 5, '30.00', 0, '2020-07-02 08:17:51', '2020-07-02 08:17:51'),
(7, 3, 5, '30.00', 0, '2020-07-02 08:19:14', '2020-07-02 08:19:14'),
(8, 6, 10, '35.00', 0, '2020-07-02 08:19:37', '2020-07-02 08:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `company_id`, `name`, `email`, `mobile`, `username`, `password`, `remember_token`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'SUPER ADMIN', 'superadmin@test.com', NULL, 'superadmin', '$2y$10$mz/z6E5gP2CvA09nDa5Fn./9LEmqMlYWbDpiXJc0b864mG6ArrDmC', NULL, 0, NULL, NULL, NULL),
(9, 1, 8, 'Sizcom Laptop Experts', NULL, '9656000075', 'laptop', '$2y$10$p7igiLWa0eLo9TtAI1hkHeck0X6AWHMgDqpLEiuPFTy46Jwn51Qn2', NULL, 0, NULL, '2019-11-18 14:14:06', '2019-12-07 04:09:33'),
(11, 1, 10, 'Sizcom Apple Experts', NULL, NULL, 'apple', '$2y$10$GX87TzbQuX2KjtjMUchdleAHxagRY4Mp1dNc.ydpVm./sr094sOkG', NULL, 0, NULL, '2019-11-23 13:21:21', '2019-12-11 13:38:11'),
(12, 1, 11, 'Sizcom Mobile Experts', NULL, NULL, 'mobile', '$2y$10$O0RHWFZRqKTou.LMBMgOLO4B4anvD2U1CSoMoxUQGmu9q/GJM8LDu', NULL, 0, NULL, '2019-11-23 13:23:42', '2019-12-11 13:37:43'),
(13, 3, 11, 'Junaid', NULL, '9656000075', 'junaid', '$2y$10$bLkldgvnKxWynpwVEh2CCuwT/JwonyQ.eLd8WMZZ4hxHA4xONdWsi', NULL, 0, NULL, '2019-11-18 14:14:06', '2019-11-23 13:22:12'),
(14, 1, 10, 'stock admin', NULL, NULL, 'stock admin', '$2y$10$6te8gIrlf6W.NpTUzKyoX.4O8SYoUuYU8pzSRG107n8H7VRAm0lZy', NULL, 0, NULL, '2020-07-01 10:17:17', '2020-07-01 10:17:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catremarks`
--
ALTER TABLE `catremarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closings`
--
ALTER TABLE `closings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expensecategories`
--
ALTER TABLE `expensecategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomecategories`
--
ALTER TABLE `incomecategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchasecredits`
--
ALTER TABLE `purchasecredits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchasevendors`
--
ALTER TABLE `purchasevendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_log_details`
--
ALTER TABLE `purchase_log_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `catremarks`
--
ALTER TABLE `catremarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `closings`
--
ALTER TABLE `closings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `expensecategories`
--
ALTER TABLE `expensecategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `incomecategories`
--
ALTER TABLE `incomecategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchasecredits`
--
ALTER TABLE `purchasecredits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchasevendors`
--
ALTER TABLE `purchasevendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_log_details`
--
ALTER TABLE `purchase_log_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

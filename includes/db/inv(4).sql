-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2025 at 04:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, 12, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-02-27 14:03:47'),
(2, 12, 'login', 'User logged in successfully', '::1', '2025-02-27 14:05:11'),
(3, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:09:07'),
(4, 12, 'login', 'User logged in successfully', '192.168.0.191', '2025-02-27 14:10:57'),
(5, 12, 'session_check', 'User session verified', '192.168.0.191', '2025-02-27 14:10:57'),
(6, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:33'),
(7, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:35'),
(8, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:43'),
(9, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:46'),
(10, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:49'),
(11, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:53'),
(12, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:11:55'),
(13, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:14:14'),
(14, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:15:23'),
(15, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:18:24'),
(16, 12, 'login', 'User logged in successfully', '192.168.0.191', '2025-02-27 14:18:51'),
(17, 12, 'session_check', 'User session verified', '192.168.0.191', '2025-02-27 14:18:51'),
(18, 12, 'session_check', 'User session verified', '192.168.0.191', '2025-02-27 14:18:53'),
(19, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:22:00'),
(20, 12, 'session_check', 'User session verified', '::1', '2025-02-27 14:27:23'),
(21, 12, 'login', 'User logged in successfully', '192.168.0.191', '2025-02-27 14:28:10'),
(22, 12, 'session_check', 'User session verified', '192.168.0.191', '2025-02-27 14:28:11'),
(23, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:16:39'),
(24, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:17:40'),
(25, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:17:44'),
(26, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:19:04'),
(27, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:20:12'),
(28, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:26:11'),
(29, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:27:08'),
(30, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:36:54'),
(31, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:44:41'),
(32, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:45:07'),
(33, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:48:23'),
(34, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:49:09'),
(35, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:49:13'),
(36, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:55:56'),
(37, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:56:20'),
(38, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:56:20'),
(39, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:56:56'),
(40, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:56:57'),
(41, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:57:02'),
(42, 12, 'session_check', 'User session verified', '::1', '2025-02-27 15:57:06'),
(43, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:17:16'),
(44, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:25:03'),
(45, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:26:51'),
(46, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:26:51'),
(47, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:27:01'),
(48, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:32:30'),
(49, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:32:41'),
(50, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:33:05'),
(51, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:33:05'),
(52, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:36:14'),
(53, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:36:14'),
(54, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:38:08'),
(55, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:38:17'),
(56, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:38:17'),
(57, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:38:48'),
(58, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:38:48'),
(59, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:38:53'),
(60, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:39:14'),
(61, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:44:38'),
(62, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:44:46'),
(63, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:44:57'),
(64, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:48:19'),
(65, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:48:24'),
(66, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:49:54'),
(67, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:50:11'),
(68, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:50:11'),
(69, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:50:25'),
(70, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:50:53'),
(71, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:55:44'),
(72, 12, 'session_check', 'User session verified', '::1', '2025-02-27 19:56:00'),
(73, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:07:16'),
(74, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:07:42'),
(75, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:08:19'),
(76, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:08:26'),
(77, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:08:50'),
(78, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:08:54'),
(79, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:09:01'),
(80, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:10:45'),
(81, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:11:35'),
(82, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:11:38'),
(83, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:14:33'),
(84, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:15:12'),
(85, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:15:14'),
(86, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:15:16'),
(87, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:18:56'),
(88, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:18:59'),
(89, 12, 'logout', 'User logged out', '::1', '2025-02-27 20:24:00'),
(90, NULL, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-02-27 20:24:21'),
(91, NULL, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-02-27 20:24:28'),
(92, 12, 'login', 'User logged in successfully', '::1', '2025-02-27 20:24:43'),
(93, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:25:13'),
(94, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:29:34'),
(95, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:29:40'),
(96, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:30:12'),
(97, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:30:29'),
(98, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:30:34'),
(99, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:30:53'),
(100, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:30:54'),
(101, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:30:59'),
(102, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:31:05'),
(103, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:31:06'),
(104, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:31:45'),
(105, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:31:46'),
(106, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:36:52'),
(107, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:38:40'),
(108, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:39:28'),
(109, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:40:52'),
(110, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:45:06'),
(111, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:45:20'),
(112, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:45:20'),
(113, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:45:51'),
(114, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:45:52'),
(115, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:46:09'),
(116, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:46:09'),
(117, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:46:25'),
(118, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:46:38'),
(119, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:46:41'),
(120, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:46:45'),
(121, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:47:31'),
(122, 12, 'logout', 'User logged out', '::1', '2025-02-27 20:47:36'),
(123, 12, 'login', 'User logged in successfully', '::1', '2025-02-27 20:47:39'),
(124, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:47:39'),
(125, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:47:53'),
(126, 12, 'logout', 'User logged out', '::1', '2025-02-27 20:47:55'),
(127, NULL, 'login_failed', 'Failed login attempt for username: Jarferh', '::1', '2025-02-27 20:48:04'),
(128, NULL, 'login_failed', 'Failed login attempt for username: Jarferh', '::1', '2025-02-27 20:48:35'),
(129, 12, 'login', 'User logged in successfully', '::1', '2025-02-27 20:49:01'),
(130, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:49:01'),
(131, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:49:42'),
(132, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:49:44'),
(133, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:50:00'),
(134, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:51:47'),
(135, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:51:48'),
(136, 12, 'logout', 'User logged out', '::1', '2025-02-27 20:52:06'),
(137, 13, 'login', 'User logged in successfully', '::1', '2025-02-27 20:52:25'),
(138, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:52:25'),
(139, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:52:41'),
(140, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:52:42'),
(141, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:52:55'),
(142, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:52:58'),
(143, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:53:05'),
(144, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:53:20'),
(145, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:54:38'),
(146, 13, 'session_check', 'User session verified', '::1', '2025-02-27 20:56:36'),
(147, 13, 'logout', 'User logged out', '::1', '2025-02-27 20:56:41'),
(148, 14, 'login', 'User logged in successfully', '::1', '2025-02-27 20:57:16'),
(149, 14, 'session_check', 'User session verified', '::1', '2025-02-27 20:57:17'),
(150, 14, 'session_check', 'User session verified', '::1', '2025-02-27 20:57:35'),
(151, 14, 'session_check', 'User session verified', '::1', '2025-02-27 20:57:38'),
(152, 14, 'session_check', 'User session verified', '::1', '2025-02-27 20:58:10'),
(153, 14, 'logout', 'User logged out', '::1', '2025-02-27 20:59:08'),
(154, 12, 'login', 'User logged in successfully', '::1', '2025-02-27 20:59:15'),
(155, 12, 'session_check', 'User session verified', '::1', '2025-02-27 20:59:15'),
(156, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:00:13'),
(157, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:03:33'),
(158, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:03:52'),
(159, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:03:52'),
(160, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:04:09'),
(161, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:04:10'),
(162, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:04:11'),
(163, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:04:12'),
(164, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:05:09'),
(165, 12, 'session_check', 'User session verified', '::1', '2025-02-27 21:05:11'),
(166, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:10:12'),
(167, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:10:40'),
(168, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:11:29'),
(169, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:11:32'),
(170, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:13:44'),
(171, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:14:45'),
(172, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:14:45'),
(173, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:14:57'),
(174, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:15:56'),
(175, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:16:01'),
(176, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:16:08'),
(177, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:16:17'),
(178, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:31:50'),
(179, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:31:53'),
(180, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:32:07'),
(181, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:32:48'),
(182, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:32:48'),
(183, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:33:01'),
(184, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:33:02'),
(185, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:33:03'),
(186, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:33:58'),
(187, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:33:59'),
(188, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:34:00'),
(189, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:35:12'),
(190, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:35:29'),
(191, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:35:34'),
(192, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:42:44'),
(193, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:42:46'),
(194, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:42:48'),
(195, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:43:08'),
(196, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:44:25'),
(197, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:44:34'),
(198, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:49:33'),
(199, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:49:35'),
(200, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:49:40'),
(201, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:50:10'),
(202, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:50:11'),
(203, 12, 'session_check', 'User session verified', '::1', '2025-02-28 14:50:12'),
(204, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:01:02'),
(205, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:01:03'),
(206, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:01:30'),
(207, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:01:55'),
(208, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:01:56'),
(209, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:01:57'),
(210, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:02:34'),
(211, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:02:34'),
(212, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:02:35'),
(213, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:02:48'),
(214, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:02:48'),
(215, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:02:49'),
(216, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:03:04'),
(217, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:03:04'),
(218, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:03:05'),
(219, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:03:08'),
(220, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:03:08'),
(221, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:08:34'),
(222, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:08:36'),
(223, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:08:43'),
(224, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:08:44'),
(225, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:08:46'),
(226, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:12:18'),
(227, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:12:19'),
(228, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:12:27'),
(229, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:12:57'),
(230, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:08'),
(231, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:14'),
(232, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:29'),
(233, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:34'),
(234, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:36'),
(235, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:37'),
(236, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:13:42'),
(237, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:14:00'),
(238, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:14:09'),
(239, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:14:17'),
(240, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:14:51'),
(241, 12, 'session_check', 'User session verified', '::1', '2025-02-28 15:15:16'),
(242, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:03'),
(243, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:16'),
(244, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:21'),
(245, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:21'),
(246, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:23'),
(247, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:26'),
(248, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:27'),
(249, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:44:30'),
(250, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:45:01'),
(251, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:45:09'),
(252, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:45:09'),
(253, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:45:15'),
(254, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:45:15'),
(255, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:54:40'),
(256, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:54:59'),
(257, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:54:59'),
(258, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:55:08'),
(259, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:55:11'),
(260, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:33'),
(261, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:39'),
(262, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:40'),
(263, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:40'),
(264, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:45'),
(265, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:46'),
(266, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:46'),
(267, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:59'),
(268, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:59'),
(269, 12, 'session_check', 'User session verified', '::1', '2025-02-28 16:57:59'),
(270, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:01:52'),
(271, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:06:37'),
(272, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:06:51'),
(273, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:06:51'),
(274, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:06:56'),
(275, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:07'),
(276, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:23'),
(277, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:35'),
(278, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:35'),
(279, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:35'),
(280, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:46'),
(281, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:47'),
(282, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:07:53'),
(283, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:08:09'),
(284, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:08:10'),
(285, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:09:24'),
(286, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:09:24'),
(287, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:09:24'),
(288, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:09:34'),
(289, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:10:36'),
(290, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:10:40'),
(291, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:10:47'),
(292, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:11:20'),
(293, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:11:21'),
(294, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:11:42'),
(295, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:12:01'),
(296, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:12:20'),
(297, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:12:48'),
(298, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:12:50'),
(299, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:12:50'),
(300, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:13:08'),
(301, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:13:14'),
(302, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:13:28'),
(303, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:13:29'),
(304, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:13:56'),
(305, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:13:59'),
(306, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:14:00'),
(307, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:14:20'),
(308, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:17:33'),
(309, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:17:41'),
(310, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:17:44'),
(311, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:17:44'),
(312, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:18:50'),
(313, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:18:50'),
(314, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:18:51'),
(315, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:19:04'),
(316, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:25'),
(317, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:34'),
(318, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:37'),
(319, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:44'),
(320, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:45'),
(321, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:46'),
(322, 12, 'session_check', 'User session verified', '::1', '2025-02-28 17:20:54'),
(323, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:27:08'),
(324, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:27:30'),
(325, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:27:45'),
(326, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:27:46'),
(327, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:28:07'),
(328, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:28:08'),
(329, 12, 'session_check', 'User session verified', '::1', '2025-03-01 21:31:01'),
(330, 12, 'session_check', 'User session verified', '::1', '2025-03-02 09:58:12'),
(331, 12, 'session_check', 'User session verified', '::1', '2025-03-02 09:58:14'),
(332, 12, 'session_check', 'User session verified', '::1', '2025-03-02 10:07:58'),
(333, 12, 'session_check', 'User session verified', '::1', '2025-03-02 10:08:05'),
(334, 12, 'session_check', 'User session verified', '::1', '2025-03-02 10:08:07'),
(335, 12, 'session_check', 'User session verified', '::1', '2025-03-02 10:08:09'),
(336, 12, 'session_check', 'User session verified', '::1', '2025-03-02 10:25:05'),
(337, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:11:27'),
(338, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:11:52'),
(339, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:11:55'),
(340, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:12:41'),
(341, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:12:42'),
(342, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:12:55'),
(343, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:12:57'),
(344, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:13:04'),
(345, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:13:04'),
(346, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:15:39'),
(347, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:15:40'),
(348, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:15:52'),
(349, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:22:09'),
(350, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:22:34'),
(351, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:22:36'),
(352, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:22:42'),
(353, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:32:19'),
(354, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:32:20'),
(355, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:32:23'),
(356, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:32:54'),
(357, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:36:01'),
(358, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:36:02'),
(359, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:36:04'),
(360, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:03'),
(361, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:10'),
(362, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:13'),
(363, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:14'),
(364, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:28'),
(365, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:29'),
(366, 12, 'session_check', 'User session verified', '::1', '2025-03-05 11:39:29'),
(367, 12, 'session_check', 'User session verified', '::1', '2025-03-05 12:38:39'),
(368, 12, 'session_check', 'User session verified', '::1', '2025-03-05 12:46:10'),
(369, 12, 'session_check', 'User session verified', '::1', '2025-03-05 12:46:11'),
(370, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:07'),
(371, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:21'),
(372, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:25'),
(373, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:28'),
(374, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:29'),
(375, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:45'),
(376, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:46'),
(377, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:48'),
(378, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:43:51'),
(379, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:44:00'),
(380, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:44:05'),
(381, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:45:24'),
(382, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:47:35'),
(383, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:48:00'),
(384, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:48:00'),
(385, 12, 'logout', 'User logged out', '::1', '2025-03-06 09:48:10'),
(386, 14, 'login', 'User logged in successfully', '::1', '2025-03-06 09:58:12'),
(387, 14, 'session_check', 'User session verified', '::1', '2025-03-06 09:58:12'),
(388, 14, 'session_check', 'User session verified', '::1', '2025-03-06 09:58:34'),
(389, 14, 'session_check', 'User session verified', '::1', '2025-03-06 09:58:35'),
(390, 14, 'logout', 'User logged out', '::1', '2025-03-06 09:58:36'),
(391, 12, 'login', 'User logged in successfully', '::1', '2025-03-06 09:58:43'),
(392, 12, 'session_check', 'User session verified', '::1', '2025-03-06 09:58:45'),
(393, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:14:04'),
(394, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:40:37'),
(395, 12, 'logout', 'User logged out', '::1', '2025-03-06 10:41:10'),
(396, 12, 'login', 'User logged in successfully', '192.168.0.191', '2025-03-06 10:42:39'),
(397, 12, 'session_check', 'User session verified', '192.168.0.191', '2025-03-06 10:42:39'),
(398, 12, 'login', 'User logged in successfully', '::1', '2025-03-06 10:43:03'),
(399, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:43:03'),
(400, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:43:15'),
(401, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:43:50'),
(402, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:43:50'),
(403, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:00'),
(404, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:00'),
(405, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:04'),
(406, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:06'),
(407, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:07'),
(408, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:45'),
(409, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:45'),
(410, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:46'),
(411, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:45:50'),
(412, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:46:17'),
(413, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:58:36'),
(414, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:58:59'),
(415, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:59:04'),
(416, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:59:11'),
(417, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:59:12'),
(418, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:59:17'),
(419, 12, 'session_check', 'User session verified', '::1', '2025-03-06 10:59:21'),
(420, 12, 'login', 'User logged in successfully', '192.168.0.127', '2025-03-06 11:20:54'),
(421, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:20:54'),
(422, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:21:13'),
(423, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:21:17'),
(424, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:21:18'),
(425, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:21:44'),
(426, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:21:56'),
(427, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:00'),
(428, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:01'),
(429, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:20'),
(430, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:20'),
(431, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:47'),
(432, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:50'),
(433, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:22:51'),
(434, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:23:02'),
(435, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:23:06'),
(436, 12, 'session_check', 'User session verified', '192.168.0.127', '2025-03-06 11:23:20'),
(437, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:25:38'),
(438, 12, 'logout', 'User logged out', '::1', '2025-03-06 11:27:11'),
(439, 12, 'login', 'User logged in successfully', '::1', '2025-03-06 11:27:31'),
(440, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:27:33'),
(441, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:27:43'),
(442, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:27:45'),
(443, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:28:06'),
(444, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:28:07'),
(445, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:28:25'),
(446, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:28:27'),
(447, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:29:29'),
(448, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:29:32'),
(449, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:29:37'),
(450, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:29:47'),
(451, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:30:27'),
(452, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:30:32'),
(453, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:30:37'),
(454, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:30:44'),
(455, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:31:06'),
(456, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:31:12'),
(457, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:31:17'),
(458, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:31:40'),
(459, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:31:57'),
(460, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:32:10'),
(461, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:32:20'),
(462, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:32:37'),
(463, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:33:07'),
(464, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:33:08'),
(465, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:33:57'),
(466, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:34:00'),
(467, 12, 'logout', 'User logged out', '::1', '2025-03-06 11:34:42'),
(468, 12, 'login', 'User logged in successfully', '::1', '2025-03-06 11:34:59'),
(469, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:35:00'),
(470, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:35:16'),
(471, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:37:00'),
(472, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:37:07'),
(473, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:37:10'),
(474, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:37:27'),
(475, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:37:31'),
(476, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:37:34'),
(477, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:38:53'),
(478, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:38:54'),
(479, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:38:57'),
(480, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:40:09'),
(481, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:40:29'),
(482, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:40:30'),
(483, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:40:34'),
(484, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:40:45'),
(485, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:41:09'),
(486, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:41:28'),
(487, 12, 'session_check', 'User session verified', '::1', '2025-03-06 11:41:34'),
(488, 12, 'session_check', 'User session verified', '::1', '2025-03-08 18:57:18'),
(489, 12, 'session_check', 'User session verified', '::1', '2025-03-08 18:57:53'),
(490, 12, 'login', 'User logged in successfully', '::1', '2025-03-08 19:07:53'),
(491, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:07:53'),
(492, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:08:08'),
(493, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:08:09'),
(494, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:08:19'),
(495, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:08:26'),
(496, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:09:13'),
(497, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:12:20'),
(498, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:12:36'),
(499, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:13:49'),
(500, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:14:25'),
(501, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:15:11'),
(502, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:23:19'),
(503, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:25:13'),
(504, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:30:56'),
(505, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:31:52'),
(506, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:31:52'),
(507, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:32:40'),
(508, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:32:40'),
(509, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:32:40'),
(510, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:36:34'),
(511, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:37:10'),
(512, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:37:10'),
(513, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:38:13'),
(514, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:38:13'),
(515, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:42:40'),
(516, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:43:28'),
(517, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:43:28'),
(518, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:43:30'),
(519, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:43:34'),
(520, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:46:38'),
(521, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:46:59'),
(522, 12, 'session_check', 'User session verified', '::1', '2025-03-08 19:46:59'),
(523, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:37:20'),
(524, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:38:13'),
(525, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:38:25'),
(526, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:38:28'),
(527, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:38:34'),
(528, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:38:51'),
(529, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:45:17'),
(530, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:48:26'),
(531, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:48:44'),
(532, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:48:44'),
(533, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:48:44'),
(534, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:49:40'),
(535, 12, 'session_check', 'User session verified', '::1', '2025-03-10 12:50:51'),
(536, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:03:19'),
(537, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:03:54'),
(538, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:05:38'),
(539, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:08:44'),
(540, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:08:46'),
(541, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:09:13'),
(542, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:09:34'),
(543, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:10:08'),
(544, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:10:08'),
(545, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:10:08'),
(546, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:13:54'),
(547, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:14:05'),
(548, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:14:09'),
(549, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:14:48'),
(550, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:14:50'),
(551, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:15:28'),
(552, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:15:32'),
(553, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:15:33'),
(554, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:15:38'),
(555, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:16:02'),
(556, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:16:21'),
(557, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:16:22'),
(558, 12, 'logout', 'User logged out', '::1', '2025-03-10 13:16:31'),
(559, 17, 'login', 'User logged in successfully', '::1', '2025-03-10 13:16:57'),
(560, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:16:57'),
(561, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:12'),
(562, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:13'),
(563, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:15'),
(564, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:18'),
(565, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:19'),
(566, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:47'),
(567, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:47'),
(568, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:17:48'),
(569, 17, 'logout', 'User logged out', '::1', '2025-03-10 13:18:01'),
(570, 12, 'login', 'User logged in successfully', '::1', '2025-03-10 13:18:04'),
(571, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:18:04'),
(572, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:18:36'),
(573, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:18:43'),
(574, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:38:27'),
(575, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:56:20'),
(576, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:57:17'),
(577, 12, 'logout', 'User logged out', '::1', '2025-03-10 13:57:20'),
(578, 17, 'login', 'User logged in successfully', '::1', '2025-03-10 13:57:31'),
(579, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:57:31'),
(580, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:58:45'),
(581, 17, 'session_check', 'User session verified', '::1', '2025-03-10 13:58:45'),
(582, 17, 'logout', 'User logged out', '::1', '2025-03-10 13:58:49'),
(583, 12, 'login', 'User logged in successfully', '::1', '2025-03-10 13:58:52'),
(584, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:58:52'),
(585, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:59:11'),
(586, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:59:15'),
(587, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:59:38'),
(588, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:29:19'),
(589, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:30:49'),
(590, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:31:06'),
(591, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:31:07'),
(592, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:31:16'),
(593, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:31:35'),
(594, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:32:54'),
(595, 12, 'session_check', 'User session verified', '::1', '2025-03-10 14:32:55'),
(596, 12, 'logout', 'User logged out', '::1', '2025-03-10 14:33:02'),
(597, NULL, 'login_failed', 'Failed login attempt for username: cashier1', '::1', '2025-03-10 14:33:12'),
(598, 17, 'login', 'User logged in successfully', '::1', '2025-03-10 14:33:24'),
(599, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:33:24'),
(600, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:34:09'),
(601, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:34:10'),
(602, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:34:30'),
(603, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:38:09'),
(604, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:38:11'),
(605, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:40:42'),
(606, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:40:42'),
(607, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:40:44'),
(608, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:40:47'),
(609, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:42:55'),
(610, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:46:30'),
(611, 17, 'session_check', 'User session verified', '::1', '2025-03-10 14:51:26'),
(612, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:06:37'),
(613, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:11'),
(614, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:15'),
(615, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:19');
INSERT INTO `activity_log` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(616, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:20'),
(617, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:29'),
(618, 17, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:29'),
(619, 17, 'logout', 'User logged out', '::1', '2025-03-10 15:10:38'),
(620, 12, 'login', 'User logged in successfully', '::1', '2025-03-10 15:10:42'),
(621, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:42'),
(622, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:49'),
(623, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:10:56'),
(624, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:11:03'),
(625, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:11:04'),
(626, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:11:34'),
(627, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:11:43'),
(628, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:11:51'),
(629, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:12:35'),
(630, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:12:35'),
(631, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:12:37'),
(632, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:12:47'),
(633, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:13:58'),
(634, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:13:58'),
(635, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:13:59'),
(636, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:14:02'),
(637, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:15:53'),
(638, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:16:16'),
(639, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:16:16'),
(640, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:16:17'),
(641, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:16:37'),
(642, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:38:56'),
(643, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:42:45'),
(644, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:43:08'),
(645, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:44:03'),
(646, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:44:36'),
(647, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:45:51'),
(648, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:47:04'),
(649, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:50:22'),
(650, 12, 'session_check', 'User session verified', '::1', '2025-03-10 15:59:18'),
(651, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:00:21'),
(652, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:00:44'),
(653, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:04:12'),
(654, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:05:23'),
(655, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:06:14'),
(656, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:06:27'),
(657, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:10:17'),
(658, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:11:44'),
(659, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:12:32'),
(660, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:12:54'),
(661, 12, 'session_check', 'User session verified', '::1', '2025-03-10 16:17:30'),
(662, 12, 'session_check', 'User session verified', '::1', '2025-03-12 10:58:26'),
(663, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:01:08'),
(664, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:01:12'),
(665, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:08:43'),
(666, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:08:43'),
(667, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:11'),
(668, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:11'),
(669, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:12'),
(670, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:37'),
(671, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:37'),
(672, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:37'),
(673, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:41'),
(674, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:09:41'),
(675, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:31'),
(676, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:31'),
(677, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:43'),
(678, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:43'),
(679, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:43'),
(680, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:50'),
(681, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:14:50'),
(682, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:01'),
(683, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:02'),
(684, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:20'),
(685, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:20'),
(686, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:21'),
(687, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:26'),
(688, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:20:27'),
(689, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:27:02'),
(690, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:27:03'),
(691, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:27:07'),
(692, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:27:21'),
(693, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:27:21'),
(694, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:27:22'),
(695, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:51:20'),
(696, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:53:22'),
(697, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:54:12'),
(698, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:55:59'),
(699, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:56:00'),
(700, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:56:03'),
(701, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:56:24'),
(702, 12, 'add_payment', 'Payment of ₦1,000.00 added to sale #18. New total paid: ₦2,000.00. Status: paid', '::1', '2025-03-12 11:28:47'),
(703, 12, 'session_check', 'User session verified', '::1', '2025-03-12 12:56:30'),
(704, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:02:21'),
(705, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:02:22'),
(706, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:28'),
(707, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:28'),
(708, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:29'),
(709, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:33'),
(710, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:42'),
(711, 17, 'add_payment', 'Payment of ₦20,000.00 added to sale #19. New total paid: ₦20,000.00. Status: partial', '::1', '2025-03-12 11:56:49'),
(712, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:49'),
(713, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:57'),
(714, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:03:58'),
(715, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:04:01'),
(716, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:04:12'),
(717, 17, 'add_payment', 'Payment of ₦10,000.00 added to sale #19. New total paid: ₦30,000.00. Status: paid', '::1', '2025-03-12 11:56:49'),
(718, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:04:25'),
(719, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:04:31'),
(720, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:04:32'),
(721, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:06:37'),
(722, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:06:37'),
(723, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:06:38'),
(724, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:06:46'),
(725, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:06:53'),
(726, 17, 'add_payment', 'Payment of ₦10,000.00 added to sale #20. New total paid: ₦20,000.00. Status: paid', '::1', '2025-03-12 11:56:49'),
(727, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:07:13'),
(728, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:07:20'),
(729, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:07:21'),
(730, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:12:42'),
(731, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:12:43'),
(732, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:05'),
(733, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:05'),
(734, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:06'),
(735, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:09'),
(736, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:15'),
(737, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:19'),
(738, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:13:20'),
(739, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:15:37'),
(740, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:15:52'),
(741, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:03'),
(742, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:06'),
(743, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:07'),
(744, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:09'),
(745, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:12'),
(746, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:13'),
(747, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:16:16'),
(748, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:19:59'),
(749, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:21:21'),
(750, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:22:04'),
(751, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:23:01'),
(752, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:24:09'),
(753, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:25:33'),
(754, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:27:00'),
(755, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:27:04'),
(756, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:27:05'),
(757, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:28:04'),
(758, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:28:05'),
(759, 12, 'logout', 'User logged out', '::1', '2025-03-12 13:28:17'),
(760, NULL, 'login_failed', 'Failed login attempt for username: cashier1', '::1', '2025-03-12 13:28:24'),
(761, NULL, 'login_failed', 'Failed login attempt for username: Jarferh', '::1', '2025-03-12 13:28:38'),
(762, NULL, 'login_failed', 'Failed login attempt for username: jarferh', '::1', '2025-03-12 13:28:53'),
(763, NULL, 'login_failed', 'Failed login attempt for username: jarferh', '::1', '2025-03-12 13:29:03'),
(764, 17, 'login', 'User logged in successfully', '::1', '2025-03-12 13:29:14'),
(765, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:29:14'),
(766, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:30:05'),
(767, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:30:08'),
(768, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:30:12'),
(769, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:30:20'),
(770, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:30:20'),
(771, 17, 'logout', 'User logged out', '::1', '2025-03-12 13:30:25'),
(772, 12, 'login', 'User logged in successfully', '::1', '2025-03-12 13:30:34'),
(773, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:30:34'),
(774, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:36:15'),
(775, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:36:18'),
(776, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:37:20'),
(777, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:41:20'),
(778, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:41:23'),
(779, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:41:25'),
(780, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:41:58'),
(781, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:42:22'),
(782, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:43:05'),
(783, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:43:43'),
(784, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:51:36'),
(785, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:51:42'),
(786, 12, 'logout', 'User logged out', '::1', '2025-03-12 13:51:45'),
(787, 17, 'login', 'User logged in successfully', '::1', '2025-03-12 13:51:54'),
(788, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:51:54'),
(789, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:52:31'),
(790, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:52:31'),
(791, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:52:32'),
(792, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:52:34'),
(793, 17, 'session_check', 'User session verified', '::1', '2025-03-12 13:52:35'),
(794, 17, 'logout', 'User logged out', '::1', '2025-03-12 13:52:37'),
(795, 12, 'login', 'User logged in successfully', '::1', '2025-03-12 13:52:42'),
(796, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:52:42'),
(797, 12, 'session_check', 'User session verified', '::1', '2025-03-12 13:53:36'),
(798, 12, 'session_check', 'User session verified', '::1', '2025-03-12 14:19:52'),
(799, 12, 'session_check', 'User session verified', '::1', '2025-03-12 14:25:37'),
(800, 12, 'session_check', 'User session verified', '::1', '2025-03-12 14:25:40'),
(801, 12, 'session_check', 'User session verified', '::1', '2025-03-12 14:26:23'),
(802, 12, 'session_check', 'User session verified', '::1', '2025-03-12 14:27:08'),
(803, 12, 'session_check', 'User session verified', '::1', '2025-03-12 14:27:14'),
(804, 12, 'session_check', 'User session verified', '::1', '2025-03-12 16:57:32'),
(805, 12, 'session_check', 'User session verified', '::1', '2025-03-12 16:57:49'),
(806, 12, 'session_check', 'User session verified', '::1', '2025-03-12 16:57:52'),
(807, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:03:35'),
(808, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:14'),
(809, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:19'),
(810, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:22'),
(811, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:22'),
(812, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:23'),
(813, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:25'),
(814, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:21:30'),
(815, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:22:26'),
(816, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:24:52'),
(817, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:25:02'),
(818, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:25:03'),
(819, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:25:12'),
(820, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:25:30'),
(821, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:25:32'),
(822, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:26:01'),
(823, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:26:02'),
(824, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:26:05'),
(825, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:26:08'),
(826, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:27:41'),
(827, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:29:11'),
(828, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:30:43'),
(829, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:30:47'),
(830, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:30:53'),
(831, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:35:36'),
(832, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:38:57'),
(833, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:40:45'),
(834, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:40:52'),
(835, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:40:53'),
(836, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:41:33'),
(837, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:41:34'),
(838, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:41:53'),
(839, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:41:54'),
(840, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:41:58'),
(841, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:42:16'),
(842, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:49:21'),
(843, 12, 'session_check', 'User session verified', '::1', '2025-03-12 23:51:15'),
(844, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:22:59'),
(845, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:33:39'),
(846, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:36:44'),
(847, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:37:53'),
(848, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:41:04'),
(849, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:42:08'),
(850, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:42:43'),
(851, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:43:33'),
(852, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:43:52'),
(853, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:47:14'),
(854, 12, 'login', 'User logged in successfully', '192.168.255.101', '2025-03-13 10:58:16'),
(855, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 10:58:16'),
(856, 12, 'session_check', 'User session verified', '::1', '2025-03-13 10:59:58'),
(857, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:00:04'),
(858, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:00:12'),
(859, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:00:39'),
(860, 12, 'login', 'User logged in successfully', '192.168.255.101', '2025-03-13 11:01:47'),
(861, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:01:47'),
(862, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:02:24'),
(863, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:02:30'),
(864, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:02:30'),
(865, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:04:25'),
(866, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:04:25'),
(867, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:04:30'),
(868, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:04:34'),
(869, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:18:46'),
(870, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:20:31'),
(871, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:23:14'),
(872, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:23:51'),
(873, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:24:22'),
(874, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:24:49'),
(875, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:27:44'),
(876, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:28:55'),
(877, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:29:15'),
(878, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:30:00'),
(879, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:30:03'),
(880, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:30:52'),
(881, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:31:54'),
(882, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:32:14'),
(883, 12, 'login', 'User logged in successfully', '192.168.255.101', '2025-03-13 11:32:51'),
(884, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:32:51'),
(885, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:32:59'),
(886, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:33:07'),
(887, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:34:16'),
(888, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:35:28'),
(889, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:39:24'),
(890, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:42:30'),
(891, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:42:54'),
(892, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:54:19'),
(893, 12, 'logout', 'User logged out', '::1', '2025-03-13 11:54:23'),
(894, 12, 'login', 'User logged in successfully', '::1', '2025-03-13 11:54:55'),
(895, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:54:55'),
(896, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:55:04'),
(897, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:55:06'),
(898, 12, 'logout', 'User logged out', '192.168.255.101', '2025-03-13 11:55:08'),
(899, 12, 'login', 'User logged in successfully', '192.168.255.101', '2025-03-13 11:55:17'),
(900, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:55:17'),
(901, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:55:38'),
(902, 12, 'login', 'User logged in successfully', '192.168.255.101', '2025-03-13 11:56:18'),
(903, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:56:18'),
(904, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:57:56'),
(905, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:57:57'),
(906, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 11:58:33'),
(907, 12, 'session_check', 'User session verified', '::1', '2025-03-13 11:59:11'),
(908, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:00:37'),
(909, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:00:48'),
(910, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:00:51'),
(911, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:01:41'),
(912, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:02:17'),
(913, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:03:47'),
(914, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:04:08'),
(915, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:04:20'),
(916, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:04:26'),
(917, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:05:51'),
(918, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:06:18'),
(919, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:07:20'),
(920, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:07:39'),
(921, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:07:52'),
(922, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:08:13'),
(923, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:08:22'),
(924, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:08:30'),
(925, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:08:37'),
(926, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:09:50'),
(927, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:10:35'),
(928, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:10:49'),
(929, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:11:13'),
(930, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:12:11'),
(931, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:12:21'),
(932, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:12:32'),
(933, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:13:39'),
(934, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:13:51'),
(935, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:14:54'),
(936, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:16'),
(937, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:25'),
(938, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:28'),
(939, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:29'),
(940, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:35'),
(941, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:15:47'),
(942, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:47'),
(943, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:15:51'),
(944, 12, 'session_check', 'User session verified', '192.168.255.101', '2025-03-13 12:15:53'),
(946, 12, 'login', 'User logged in successfully', '::1', '2025-03-13 12:23:03'),
(947, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:23:03'),
(948, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:39:13'),
(949, 12, 'session_check', 'User session verified', '::1', '2025-03-13 12:39:15'),
(950, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:26:32'),
(951, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:26:34'),
(952, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:28:38'),
(953, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:29:38'),
(954, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:29:55'),
(955, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:38:43'),
(956, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:38:49'),
(957, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:38:50'),
(958, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:39:28'),
(959, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:39:28'),
(960, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:39:29'),
(961, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:45:22'),
(962, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:45:23'),
(963, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:45:25'),
(964, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:45:26'),
(965, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:45:30'),
(966, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:51:51'),
(967, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:54:00'),
(968, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:54:58'),
(969, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:54:59'),
(970, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:55:28'),
(971, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:55:28'),
(972, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:55:29'),
(973, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:56:12'),
(974, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:58:30'),
(975, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:58:30'),
(976, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:58:31'),
(977, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:59:04'),
(978, 12, 'session_check', 'User session verified', '::1', '2025-03-13 14:59:22'),
(979, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:00:01'),
(980, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:00:08'),
(981, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:00:13'),
(982, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:00:13'),
(983, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:00:15'),
(984, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:00:19'),
(985, 12, 'logout', 'User logged out', '::1', '2025-03-13 15:00:50'),
(986, 17, 'login', 'User logged in successfully', '::1', '2025-03-13 15:01:05'),
(987, 17, 'session_check', 'User session verified', '::1', '2025-03-13 15:01:05'),
(988, 17, 'session_check', 'User session verified', '::1', '2025-03-13 15:01:24'),
(989, 17, 'session_check', 'User session verified', '::1', '2025-03-13 15:01:28'),
(990, 17, 'session_check', 'User session verified', '::1', '2025-03-13 15:02:02'),
(991, 17, 'session_check', 'User session verified', '::1', '2025-03-13 15:02:03'),
(992, 17, 'logout', 'User logged out', '::1', '2025-03-13 15:02:09'),
(993, 13, 'login', 'User logged in successfully', '::1', '2025-03-13 15:02:26'),
(994, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:02:26'),
(995, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:02:48'),
(996, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:02:51'),
(997, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:04'),
(998, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:07'),
(999, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:19'),
(1000, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:20'),
(1001, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:37'),
(1002, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:37'),
(1003, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:38'),
(1004, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:42'),
(1005, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:56'),
(1006, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:58'),
(1007, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:03:59'),
(1008, 13, 'logout', 'User logged out', '::1', '2025-03-13 15:04:44'),
(1009, 13, 'login', 'User logged in successfully', '::1', '2025-03-13 15:04:50'),
(1010, 13, 'session_check', 'User session verified', '::1', '2025-03-13 15:04:50'),
(1011, 13, 'logout', 'User logged out', '::1', '2025-03-13 15:05:13'),
(1012, 12, 'login', 'User logged in successfully', '::1', '2025-03-13 15:05:23'),
(1013, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:05:23'),
(1014, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:05:32'),
(1015, 12, 'logout', 'User logged out', '::1', '2025-03-13 15:06:54'),
(1016, NULL, 'login_failed', 'Failed login attempt for username: cashier1', '::1', '2025-03-13 15:07:09'),
(1017, NULL, 'login_failed', 'Failed login attempt for username: cashier1', '::1', '2025-03-13 15:07:10'),
(1018, 12, 'login', 'User logged in successfully', '::1', '2025-03-13 15:07:20'),
(1019, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:07:20'),
(1020, 12, 'logout', 'User logged out', '::1', '2025-03-13 15:07:34'),
(1021, NULL, 'login_failed', 'Failed login attempt for username: cashier1', '::1', '2025-03-13 15:07:46'),
(1022, NULL, 'login_failed', 'Failed login attempt for username: cashier1', '::1', '2025-03-13 15:07:46'),
(1023, 12, 'login', 'User logged in successfully', '::1', '2025-03-13 15:36:33'),
(1024, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:33'),
(1025, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:38'),
(1026, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:46'),
(1027, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:50'),
(1028, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:55'),
(1029, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:57'),
(1030, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:36:58'),
(1031, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:37:33'),
(1032, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:37:53'),
(1033, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:37:56'),
(1034, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:39:06'),
(1035, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:39:10'),
(1036, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:43:49'),
(1037, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:43:50'),
(1038, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:44:00'),
(1039, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:47:42'),
(1040, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:47:43'),
(1041, 12, 'session_check', 'User session verified', '::1', '2025-03-13 15:49:44'),
(1042, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-16 15:39:54'),
(1043, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-16 15:39:54'),
(1044, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-16 15:40:22'),
(1045, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-16 15:40:22'),
(1046, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-16 15:40:36'),
(1047, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-16 15:40:36'),
(1048, 12, 'login', 'User logged in successfully', '::1', '2025-04-16 15:40:48'),
(1049, 12, 'session_check', 'User session verified', '::1', '2025-04-16 15:40:48'),
(1050, NULL, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-04-23 17:08:25'),
(1051, NULL, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-04-23 17:08:26'),
(1052, NULL, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-04-23 17:08:31'),
(1053, NULL, 'login_failed', 'Failed login attempt for username: admin', '::1', '2025-04-23 17:08:31'),
(1054, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-23 17:08:39'),
(1055, NULL, 'login_failed', 'Failed login attempt for username: admin1', '::1', '2025-04-23 17:08:39'),
(1056, 12, 'login', 'User logged in successfully', '::1', '2025-04-23 17:08:53'),
(1057, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:08:53'),
(1058, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:04'),
(1059, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:04'),
(1060, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:21'),
(1061, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:21'),
(1062, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:36'),
(1063, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:37'),
(1064, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:39'),
(1065, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:44'),
(1066, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:09:49'),
(1067, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:10:56'),
(1068, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:10:56'),
(1069, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:11:08'),
(1070, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:11:08'),
(1071, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:11:09'),
(1072, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:11:13'),
(1073, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:11:18'),
(1074, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:11:44'),
(1075, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:12:45'),
(1076, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:12:45'),
(1077, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:12:48'),
(1078, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:13:30'),
(1079, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:13:30'),
(1080, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:13:34'),
(1081, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:13:53'),
(1082, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:14:47'),
(1083, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:16:07'),
(1084, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:16:08'),
(1085, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:16:10'),
(1086, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:16:18'),
(1087, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:16:33'),
(1088, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:07'),
(1089, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:07'),
(1090, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:13'),
(1091, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:13'),
(1092, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:13'),
(1093, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:14'),
(1094, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:14'),
(1095, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:24'),
(1096, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:17:26'),
(1097, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:18:59'),
(1098, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:19:00'),
(1099, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:19:06'),
(1100, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:19:06'),
(1101, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:19:09'),
(1102, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:09'),
(1103, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:10'),
(1104, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:12'),
(1105, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:13'),
(1106, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:16'),
(1107, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:20'),
(1108, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:22'),
(1109, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:22'),
(1110, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:31'),
(1111, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:35'),
(1112, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:36'),
(1113, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:38'),
(1114, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:39'),
(1115, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:20:39'),
(1116, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:27'),
(1117, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:28'),
(1118, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:32'),
(1119, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:40'),
(1120, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:45'),
(1121, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:55'),
(1122, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:21:59'),
(1123, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:02'),
(1124, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:03'),
(1125, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:05'),
(1126, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:05'),
(1127, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:05'),
(1128, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:06'),
(1129, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:06'),
(1130, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:23'),
(1131, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:24'),
(1132, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:22:24'),
(1133, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:36:01'),
(1134, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:36:02'),
(1135, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:36:09'),
(1136, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:37:15'),
(1137, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:39:28'),
(1138, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:39:30'),
(1139, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:39:49'),
(1140, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:43:33'),
(1141, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:43:35'),
(1142, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:43:44'),
(1143, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:47:35'),
(1144, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:47:36'),
(1145, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:47:38'),
(1146, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:48:39'),
(1147, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:48:40'),
(1148, 12, 'session_check', 'User session verified', '::1', '2025-04-23 17:50:31'),
(1149, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:24:40'),
(1150, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:24:46'),
(1151, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:24:48'),
(1152, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:31:22'),
(1153, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:31:35'),
(1154, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:40:30'),
(1155, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:40:39'),
(1156, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:40:55'),
(1157, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:40:56'),
(1158, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:41:18'),
(1159, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:42:49'),
(1160, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:49:46'),
(1161, 12, 'session_check', 'User session verified', '::1', '2025-04-23 22:49:48'),
(1162, 12, 'session_check', 'User session verified', '::1', '2025-04-24 09:32:50'),
(1163, 12, 'session_check', 'User session verified', '::1', '2025-04-24 09:32:52'),
(1164, 12, 'session_check', 'User session verified', '::1', '2025-04-24 09:32:54'),
(1165, 12, 'session_check', 'User session verified', '::1', '2025-04-24 13:43:46'),
(1167, 12, 'login', 'User logged in successfully', '::1', '2025-04-26 13:46:37'),
(1168, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:46:37'),
(1169, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:47:02'),
(1170, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:47:02'),
(1171, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:47:15'),
(1172, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:47:44'),
(1173, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:47:44'),
(1174, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:48:13'),
(1175, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:48:30'),
(1176, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:48:33'),
(1177, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:50:23'),
(1178, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:51:13'),
(1179, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:51:29'),
(1180, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:52:28'),
(1181, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:52:40'),
(1182, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:52:47'),
(1183, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:54:19'),
(1184, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:54:29'),
(1185, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:54:45'),
(1186, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:54:45'),
(1187, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:55:42'),
(1188, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:56:05'),
(1189, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:56:09'),
(1190, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:56:58'),
(1191, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:57:26'),
(1192, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:57:30'),
(1193, 12, 'session_check', 'User session verified', '::1', '2025-04-26 13:59:29'),
(1194, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:10:29'),
(1195, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:10:29'),
(1196, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:11:04'),
(1197, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:11:04'),
(1198, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:11:47'),
(1199, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:11:48'),
(1201, NULL, 'login_failed', 'Failed login attempt for username: Adebayo', '::1', '2025-04-26 14:53:37'),
(1202, NULL, 'login_failed', 'Failed login attempt for username: Adebayo', '::1', '2025-04-26 14:53:37'),
(1203, 12, 'login', 'User logged in successfully', '::1', '2025-04-26 14:53:43'),
(1204, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:53:43'),
(1205, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:53:48'),
(1206, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:58:29'),
(1207, 12, 'session_check', 'User session verified', '::1', '2025-04-26 14:58:30'),
(1208, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:43:34'),
(1209, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:45:32'),
(1210, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:45:33'),
(1211, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:45:36'),
(1212, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:45:55'),
(1213, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:46:02'),
(1214, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:46:04'),
(1215, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:46:15'),
(1216, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:46:21'),
(1217, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:46:24'),
(1218, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:46:26'),
(1219, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:57:55');
INSERT INTO `activity_log` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1220, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:58:04'),
(1221, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:58:04'),
(1222, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:58:07'),
(1223, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:58:07'),
(1224, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:58:19'),
(1225, 12, 'session_check', 'User session verified', '::1', '2025-04-26 15:58:21'),
(1226, 12, 'session_check', 'User session verified', '::1', '2025-04-26 16:18:30'),
(1227, 12, 'session_check', 'User session verified', '::1', '2025-04-26 16:18:31'),
(1229, 12, 'login', 'User logged in successfully', '::1', '2025-04-27 11:41:36'),
(1230, 12, 'session_check', 'User session verified', '::1', '2025-04-27 11:41:36'),
(1231, 12, 'login', 'User logged in successfully', '192.168.55.135', '2025-04-27 11:48:23'),
(1232, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:23'),
(1233, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:36'),
(1234, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:36'),
(1235, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:45'),
(1236, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:49'),
(1237, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:53'),
(1238, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:58'),
(1239, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:48:58'),
(1240, 12, 'session_check', 'User session verified', '192.168.55.135', '2025-04-27 11:49:01'),
(1241, 12, 'session_check', 'User session verified', '::1', '2025-04-27 11:54:30'),
(1242, 12, 'session_check', 'User session verified', '::1', '2025-04-27 11:54:31'),
(1243, 12, 'session_check', 'User session verified', '::1', '2025-04-27 13:25:09'),
(1244, 12, 'session_check', 'User session verified', '::1', '2025-04-27 13:25:11'),
(1245, 12, 'session_check', 'User session verified', '::1', '2025-04-27 13:55:23'),
(1246, 12, 'session_check', 'User session verified', '::1', '2025-04-27 13:57:53'),
(1247, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:06:13'),
(1248, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:06:53'),
(1249, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:09:35'),
(1250, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:10:34'),
(1251, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:11:10'),
(1252, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:12:59'),
(1253, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:14:12'),
(1254, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:17:07'),
(1255, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:25:58'),
(1256, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:29:22'),
(1257, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:30:47'),
(1258, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:30:47'),
(1259, 12, 'session_check', 'User session verified', '::1', '2025-04-27 14:31:21'),
(1260, 12, 'session_check', 'User session verified', '::1', '2025-04-27 15:46:51'),
(1261, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:20:11'),
(1262, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:20:21'),
(1263, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:20:22'),
(1264, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:20:26'),
(1265, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:21:44'),
(1266, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:23:39'),
(1267, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:24:23'),
(1268, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:24:36'),
(1269, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:24:36'),
(1270, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:24:44'),
(1271, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:24:46'),
(1272, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:28:23'),
(1273, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:28:27'),
(1274, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:28:36'),
(1275, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:28:36'),
(1276, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:28:43'),
(1277, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:28:53'),
(1278, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:29:05'),
(1279, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:29:05'),
(1280, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:29:10'),
(1281, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:31:07'),
(1282, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:31:22'),
(1283, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:31:22'),
(1284, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:32:50'),
(1285, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:32:59'),
(1286, 12, 'session_check', 'User session verified', '::1', '2025-04-28 14:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Fruits', 'Fruits', NULL, '2025-02-27 15:48:14', NULL, '2025-02-27 15:48:14'),
(2, 'clothes', 'new', 12, '2025-02-27 19:38:17', NULL, '2025-02-27 19:38:17'),
(3, 'Electronics', 'new', 12, '2025-02-28 17:08:09', NULL, '2025-02-28 17:08:09'),
(4, 'Feeds', '', 12, '2025-03-06 10:43:50', NULL, '2025-03-06 10:43:50'),
(5, 'food', '', 12, '2025-03-08 19:31:52', NULL, '2025-03-08 19:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','transfer') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `sale_id`, `amount`, `payment_method`, `notes`, `created_by`, `created_at`) VALUES
(1, 18, 1000.00, 'cash', '', 12, '2025-03-12 11:28:47'),
(2, 19, 20000.00, 'cash', '', 17, '2025-03-12 11:56:49'),
(3, 19, 10000.00, 'cash', '', 17, '2025-03-12 11:56:49'),
(4, 20, 10000.00, 'cash', '', 17, '2025-03-12 11:56:49'),
(5, 21, 500.00, 'cash', '', 17, '2025-03-12 12:08:12'),
(6, 26, 200.00, 'cash', '', 17, '2025-03-12 12:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `unit_type` varchar(20) NOT NULL,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `min_stock_level` decimal(10,2) DEFAULT 0.00,
  `buying_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `description`, `unit_type`, `quantity`, `min_stock_level`, `buying_price`, `selling_price`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, '001', 'Mango', 'new', 'piece', 2003.00, 0.00, 200.00, 400.00, 'active', 12, '2025-02-27 19:38:48', 12, '2025-04-28 14:29:05'),
(2, 2, '002', 'T shirt', 'fresh and new', 'piece', 153.00, 0.00, 1000.00, 1500.00, 'active', 12, '2025-02-28 14:14:45', NULL, '2025-03-12 13:03:28'),
(3, 3, '003', 'Laptop', 'Dell Inspiron 15 500', 'piece', 2492.00, 1.00, 100000.00, 150000.00, 'active', 12, '2025-02-28 17:09:24', NULL, '2025-04-28 14:29:05'),
(4, 4, '0987654', 'Vistory FEED', '', 'kg', 11038.00, 1000.00, 90.00, 120.00, 'active', 12, '2025-03-06 10:45:00', NULL, '2025-03-10 15:12:35'),
(5, 1, '3138', 'Mango', '', 'box', 1.69, 0.05, 0.24, 0.57, 'active', 12, '2025-03-06 11:37:01', NULL, '2025-03-06 11:37:01'),
(7, 5, 'PRD2025030001', 'developer', '', 'kg', 4997.00, 9.00, 1000.00, 1500.00, 'active', 12, '2025-03-08 19:38:13', NULL, '2025-04-28 14:29:05'),
(8, 3, 'PRD000001', 'Phone', '', 'piece', 7994.00, 10.00, 500.00, 2000.00, 'active', 12, '2025-03-10 13:10:08', NULL, '2025-03-13 15:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `last_password_change` timestamp NOT NULL DEFAULT current_timestamp(),
  `theme_preference` varchar(20) DEFAULT 'light',
  `language_preference` varchar(10) DEFAULT 'en',
  `notification_preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`notification_preferences`)),
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `avatar`, `phone`, `address`, `bio`, `date_of_birth`, `gender`, `position`, `department`, `last_password_change`, `theme_preference`, `language_preference`, `notification_preferences`, `social_links`, `created_at`, `updated_at`) VALUES
(1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-12 13:37:20', 'light', 'en', NULL, NULL, '2025-03-12 13:37:20', '2025-03-12 13:37:20'),
(7, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-12 13:52:32', 'light', 'en', NULL, NULL, '2025-03-12 13:52:32', '2025-03-12 13:52:32'),
(14, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-13 15:02:48', 'light', 'en', NULL, NULL, '2025-03-13 15:02:48', '2025-03-13 15:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', '[\"view_dashboard\",\"admin_access\", \"manage_users\", \"manage_roles\", \"manage_products\", \"manage_sales\", \"view_reports\",\"manage_settings\",\"profile\",\"proforma_invoice\"]', '2025-02-26 19:51:42', '2025-03-13 11:27:11'),
(2, 'manager', '[\"view_dashboard\",\"manage_products\",\"manage_sales\",\"view_reports\",\"profile\",\"proforma_invoice\"]', '2025-02-26 19:51:42', '2025-03-13 11:27:11'),
(3, 'cashier', '[\"view_dashboard\",\"manage_sales\",\"view_products\",\"profile\",\"proforma_invoice\"]', '2025-02-26 19:51:42', '2025-03-13 11:27:11'),
(14, 'user', '[\"manage_products\", \"manage_sales\", \"view_reports\",\"profile\",\"proforma_invoice\"]', '2025-02-27 20:29:29', '2025-03-13 11:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('pending','partial','paid') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cash','card','transfer') DEFAULT 'cash',
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_number`, `customer_id`, `total_amount`, `amount_paid`, `payment_status`, `payment_method`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'INV-202502-0001', NULL, 300.00, 300.00, 'paid', 'cash', 'good', 12, '2025-02-27 19:50:11', '2025-02-27 19:50:11'),
(2, 'INV-202502-0002', NULL, 1200.00, 0.00, 'paid', 'cash', '', 12, '2025-02-28 14:33:02', '2025-02-28 14:33:02'),
(3, 'INV-202502-0003', NULL, 30000.00, 0.00, 'paid', 'cash', '', 12, '2025-02-28 14:33:58', '2025-02-28 14:33:58'),
(4, 'INV-202502-0004', NULL, 3900.00, 0.00, 'paid', 'cash', '', 12, '2025-02-28 14:50:10', '2025-02-28 14:50:10'),
(5, 'INV-202502-0005', NULL, 3900.00, 3900.00, 'paid', 'cash', 'all', 12, '2025-02-28 15:01:56', '2025-02-28 15:01:56'),
(6, 'INV-202502-0006', NULL, 6000.00, 0.00, 'pending', 'cash', '', 12, '2025-02-28 15:02:34', '2025-02-28 15:02:34'),
(7, 'INV-202502-0007', NULL, 150000.00, 149999.39, 'partial', 'cash', '', 12, '2025-02-28 17:18:50', '2025-02-28 17:18:50'),
(8, 'INV-202503-0001', NULL, 150000.00, 150000.00, 'paid', 'cash', '', 12, '2025-03-05 11:39:28', '2025-03-05 11:39:28'),
(9, 'INV-202503-0002', NULL, 750000.00, 750000.00, 'paid', 'cash', '', 12, '2025-03-06 09:43:45', '2025-03-06 09:43:45'),
(10, 'INV-202503-0003', NULL, 2160.00, 2160.00, 'paid', 'cash', '', 12, '2025-03-06 10:45:45', '2025-03-06 10:45:45'),
(11, 'INV-202503-0004', NULL, 3360.00, 3360.00, 'paid', 'transfer', '', 12, '2025-03-06 11:29:30', '2025-03-06 11:29:30'),
(12, 'INV-202503-0005', NULL, 2220.00, 2220.00, 'paid', 'cash', '', 12, '2025-03-06 11:30:48', '2025-03-06 11:30:48'),
(13, 'INV-202503-0006', NULL, 2220.00, 2220.00, 'paid', 'cash', '', 12, '2025-03-06 11:31:08', '2025-03-06 11:31:08'),
(14, 'INV-202503-0007', NULL, 2880.00, 1.25, 'partial', 'card', '', 12, '2025-03-06 11:38:54', '2025-03-06 11:38:54'),
(15, 'INV-202503-0008', NULL, 4000.00, 4000.00, 'paid', 'transfer', '', 17, '2025-03-10 13:17:47', '2025-03-10 13:17:47'),
(16, 'INV-202503-0009', NULL, 400.00, 400.00, 'paid', 'cash', '', 17, '2025-03-10 14:40:42', '2025-03-10 14:40:42'),
(17, 'INV-202503-0010', NULL, 3620.00, 3000.00, 'partial', 'cash', '', 12, '2025-03-10 15:12:35', '2025-03-10 15:12:35'),
(18, 'INV-202503-0011', NULL, 2000.00, 2000.00, 'paid', 'cash', '', 12, '2025-03-12 12:09:11', '2025-03-12 11:28:47'),
(19, 'INV-202503-0012', NULL, 30000.00, 30000.00, 'paid', 'cash', '', 12, '2025-03-12 13:03:28', '2025-03-12 11:56:49'),
(20, 'INV-202503-0013', NULL, 20000.00, 20000.00, 'paid', 'cash', '', 12, '2025-03-12 13:06:37', '2025-03-12 11:56:49'),
(21, 'INV-202503-0014', NULL, 1500.00, 1500.00, 'paid', 'cash', '', 12, '2025-03-12 13:13:05', '2025-03-12 12:08:12'),
(22, 'INV-202503-0015', NULL, 1500.00, 1500.00, 'paid', 'cash', '', 12, '2025-03-13 14:39:28', '2025-03-13 14:39:28'),
(23, 'INV-202503-0016', NULL, 150000.00, 150000.00, 'paid', 'cash', '', 12, '2025-03-13 14:55:28', '2025-03-13 14:55:28'),
(24, 'INV-202503-0017', NULL, 2000.00, 2000.00, 'paid', 'cash', '', 12, '2025-03-13 14:58:30', '2025-03-13 14:58:30'),
(25, 'INV-202503-0018', NULL, 6400.00, 6400.00, 'paid', 'cash', '', 12, '2025-03-13 15:00:13', '2025-03-13 15:00:13'),
(26, 'INV-202503-0019', NULL, 400.00, 400.00, 'paid', 'cash', '', 13, '2025-03-13 15:03:37', '2025-03-12 12:08:12'),
(27, 'INV-202504-0001', NULL, 1500.00, 1500.00, 'paid', 'cash', '', 12, '2025-04-23 17:11:08', '2025-04-23 17:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `selling_price`, `created_at`) VALUES
(1, 1, 1, 1.00, 300.00, '2025-02-27 19:50:11'),
(2, 2, 1, 4.00, 300.00, '2025-02-28 14:33:02'),
(3, 3, 2, 20.00, 1500.00, '2025-02-28 14:33:58'),
(4, 4, 1, 3.00, 300.00, '2025-02-28 14:50:10'),
(5, 4, 2, 2.00, 1500.00, '2025-02-28 14:50:10'),
(6, 5, 1, 3.00, 300.00, '2025-02-28 15:01:56'),
(7, 5, 2, 2.00, 1500.00, '2025-02-28 15:01:56'),
(8, 6, 1, 20.00, 300.00, '2025-02-28 15:02:34'),
(9, 7, 3, 1.00, 150000.00, '2025-02-28 17:18:50'),
(10, 8, 3, 1.00, 150000.00, '2025-03-05 11:39:28'),
(11, 9, 3, 5.00, 150000.00, '2025-03-06 09:43:45'),
(12, 10, 4, 18.00, 120.00, '2025-03-06 10:45:45'),
(13, 11, 4, 28.00, 120.00, '2025-03-06 11:29:31'),
(14, 12, 1, 1.00, 300.00, '2025-03-06 11:30:48'),
(15, 12, 2, 1.00, 1500.00, '2025-03-06 11:30:55'),
(16, 12, 4, 1.00, 120.00, '2025-03-06 11:31:03'),
(17, 12, 1, 1.00, 300.00, '2025-03-06 11:31:03'),
(18, 13, 1, 1.00, 300.00, '2025-03-06 11:31:10'),
(19, 13, 2, 1.00, 1500.00, '2025-03-06 11:31:10'),
(20, 13, 4, 1.00, 120.00, '2025-03-06 11:31:10'),
(21, 13, 1, 1.00, 300.00, '2025-03-06 11:31:10'),
(22, 14, 4, 24.00, 120.00, '2025-03-06 11:38:54'),
(23, 15, 8, 2.00, 2000.00, '2025-03-10 13:17:47'),
(24, 16, 1, 1.00, 400.00, '2025-03-10 14:40:42'),
(25, 17, 4, 1.00, 120.00, '2025-03-10 15:12:35'),
(26, 17, 2, 1.00, 1500.00, '2025-03-10 15:12:35'),
(27, 17, 8, 1.00, 2000.00, '2025-03-10 15:12:35'),
(28, 18, 8, 1.00, 2000.00, '2025-03-12 12:09:11'),
(29, 19, 2, 20.00, 1500.00, '2025-03-12 13:03:28'),
(30, 20, 1, 50.00, 400.00, '2025-03-12 13:06:37'),
(31, 21, 7, 1.00, 1500.00, '2025-03-12 13:13:05'),
(32, 22, 7, 1.00, 1500.00, '2025-03-13 14:39:28'),
(33, 23, 3, 1.00, 150000.00, '2025-03-13 14:55:28'),
(34, 24, 8, 1.00, 2000.00, '2025-03-13 14:58:30'),
(35, 25, 8, 1.00, 2000.00, '2025-03-13 15:00:13'),
(36, 25, 1, 10.00, 400.00, '2025-03-13 15:00:13'),
(37, 25, 1, 1.00, 400.00, '2025-03-13 15:00:13'),
(38, 26, 1, 1.00, 400.00, '2025-03-13 15:03:37'),
(39, 27, 7, 1.00, 1500.00, '2025-04-23 17:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`, `is_active`, `created_at`, `updated_at`, `updated_by`) VALUES
('company_address', 'Your Company Address', 1, '2025-02-27 21:03:28', '2025-02-27 21:03:28', NULL),
('company_name', 'Your Company Name', 1, '2025-02-27 21:03:28', '2025-02-27 21:03:28', NULL),
('contact_email', 'contact@example.com', 1, '2025-02-27 21:03:28', '2025-02-27 21:03:28', NULL),
('contact_phone', '+234 000 000 0000', 1, '2025-02-27 21:03:28', '2025-02-27 21:03:28', NULL),
('currency_symbol', '₦', 1, '2025-02-27 21:03:28', '2025-02-27 21:03:28', NULL),
('low_stock_threshold', '10', 1, '2025-02-27 21:03:28', '2025-02-27 21:03:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `previous_quantity` decimal(10,2) NOT NULL,
  `new_quantity` decimal(10,2) NOT NULL,
  `change_quantity` decimal(10,2) NOT NULL,
  `change_type` enum('bulk_update','sale','return','adjustment') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_history`
--

INSERT INTO `stock_history` (`id`, `product_id`, `previous_quantity`, `new_quantity`, `change_quantity`, `change_type`, `notes`, `created_by`, `created_at`) VALUES
(1, 7, 997.00, 2997.00, 2000.00, 'bulk_update', '', 12, '2025-04-28 14:28:36'),
(2, 7, 2997.00, 4997.00, 2000.00, 'bulk_update', '', 12, '2025-04-28 14:29:05'),
(3, 3, 492.00, 2492.00, 2000.00, 'bulk_update', '', 12, '2025-04-28 14:29:05'),
(4, 1, 3.00, 2003.00, 2000.00, 'bulk_update', '', 12, '2025-04-28 14:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','manager','cashier','accountant') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `status`, `created_at`, `updated_at`, `role_id`, `last_login`, `created_by`) VALUES
(12, 'admin', '$2y$10$QLUcSQCtBK6jy6k6AasyXuk.ZOe9/3pygKNy16mk7awgJYypZmikO', 'System Administrator', 'admin@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:36', '2025-04-27 11:48:23', 1, '2025-04-27 11:48:23', NULL),
(13, 'manager', '$2y$10$AdWuYlgyhmJ8wpEqs.ko2uuS1T1bPgdvAqewjAwi0.yPUgXVjjzUG', 'Store Manager', 'manager@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:37', '2025-03-13 15:04:50', 2, '2025-03-13 15:04:50', NULL),
(14, 'cashier1', '$2y$10$Q2RzE2.FSQdaZGotgG19leqxh8LEiT1DnMC1x68lp0LuANt8AxWGu', 'First Cashier', 'cashier1@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:37', '2025-03-06 09:48:00', 3, NULL, NULL),
(15, 'cashier2', '$2y$10$crKf88jjULqoUhQm5b2GguNSPA/0FEGCLfCfSLRDVyx8XMmMaXkUe', 'Second Cashier', 'cashier2@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:37', '2025-02-27 20:45:20', 3, NULL, NULL),
(17, 'Jarferh', '$2y$10$8AQ7DM8r.X0D1pJuJP4gWefNl6u4kDmT.JwwSNqXr/dCKhY5wWxtO', 'Jaafar Muhammad', 'jarferhharoun1@gmail.com', 'admin', 'active', '2025-02-27 20:45:51', '2025-03-13 15:01:05', 3, '2025-03-13 15:01:05', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_created_by_fk` (`created_by`),
  ADD KEY `categories_updated_by_fk` (`updated_by`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `products_created_by_fk` (`created_by`),
  ADD KEY `products_updated_by_fk` (`updated_by`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `created_by` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1287;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_customer_id_fk` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_items_sale_id_fk` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD CONSTRAINT `stock_history_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_history_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

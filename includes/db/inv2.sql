-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2025 at 02:19 PM
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
(573, 12, 'session_check', 'User session verified', '::1', '2025-03-10 13:18:43');

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
(1, 1, '001', 'Mango', 'new', 'piece', 66.00, 0.00, 200.00, 400.00, 'active', 12, '2025-02-27 19:38:48', 12, '2025-03-10 12:48:44'),
(2, 2, '002', 'T shirt', 'fresh and new', 'piece', 174.00, 0.00, 1000.00, 1500.00, 'active', 12, '2025-02-28 14:14:45', NULL, '2025-03-06 11:31:10'),
(3, 3, '003', 'Laptop', 'Dell Inspiron 15 500', 'piece', 493.00, 1.00, 100000.00, 150000.00, 'active', 12, '2025-02-28 17:09:24', NULL, '2025-03-06 09:43:45'),
(4, 4, '0987654', 'Vistory FEED', '', 'kg', 11039.00, 1000.00, 90.00, 120.00, 'active', 12, '2025-03-06 10:45:00', NULL, '2025-03-06 11:38:54'),
(5, 1, '3138', 'Mango', '', 'box', 1.69, 0.05, 0.24, 0.57, 'active', 12, '2025-03-06 11:37:01', NULL, '2025-03-06 11:37:01'),
(7, 5, 'PRD2025030001', 'developer', '', 'kg', 1000.00, 9.00, 1000.00, 1500.00, 'active', 12, '2025-03-08 19:38:13', NULL, '2025-03-08 19:38:13'),
(8, 3, 'PRD000001', 'Phone', '', 'piece', 7998.00, 10.00, 500.00, 2000.00, 'active', 12, '2025-03-10 13:10:08', NULL, '2025-03-10 13:17:47');

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
(1, 'admin', '[\"view_dashboard\",\"admin_access\", \"manage_users\", \"manage_roles\", \"manage_products\", \"manage_sales\", \"view_reports\",\"manage_settings\"]', '2025-02-26 19:51:42', '2025-02-27 21:05:05'),
(2, 'manager', '[\"view_dashboard\",\"manage_products\",\"manage_sales\",\"view_reports\"]', '2025-02-26 19:51:42', '2025-02-27 13:58:02'),
(3, 'cashier', '[\"view_dashboard\",\"manage_sales\",\"view_products\"]', '2025-02-26 19:51:42', '2025-02-27 13:58:03'),
(14, 'user', '[\"manage_products\", \"manage_sales\", \"view_reports\"]', '2025-02-27 20:29:29', '2025-02-27 20:29:29');

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
(15, 'INV-202503-0008', NULL, 4000.00, 4000.00, 'paid', 'transfer', '', 17, '2025-03-10 13:17:47', '2025-03-10 13:17:47');

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
(23, 15, 8, 2.00, 2000.00, '2025-03-10 13:17:47');

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
(12, 'admin', '$2y$10$QLUcSQCtBK6jy6k6AasyXuk.ZOe9/3pygKNy16mk7awgJYypZmikO', 'System Administrator', 'admin@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:36', '2025-02-27 14:04:36', 1, NULL, NULL),
(13, 'manager', '$2y$10$AdWuYlgyhmJ8wpEqs.ko2uuS1T1bPgdvAqewjAwi0.yPUgXVjjzUG', 'Store Manager', 'manager@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:37', '2025-02-27 20:51:48', 2, NULL, NULL),
(14, 'cashier1', '$2y$10$Q2RzE2.FSQdaZGotgG19leqxh8LEiT1DnMC1x68lp0LuANt8AxWGu', 'First Cashier', 'cashier1@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:37', '2025-03-06 09:48:00', 3, NULL, NULL),
(15, 'cashier2', '$2y$10$crKf88jjULqoUhQm5b2GguNSPA/0FEGCLfCfSLRDVyx8XMmMaXkUe', 'Second Cashier', 'cashier2@samahagrovet.com', 'admin', 'active', '2025-02-27 14:04:37', '2025-02-27 20:45:20', 3, NULL, NULL),
(17, 'Jarferh', '$2y$10$8AQ7DM8r.X0D1pJuJP4gWefNl6u4kDmT.JwwSNqXr/dCKhY5wWxtO', 'Jaafar Muhammad', 'jarferhharoun1@gmail.com', 'admin', 'active', '2025-02-27 20:45:51', '2025-03-10 13:16:22', 3, NULL, 12);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=574;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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

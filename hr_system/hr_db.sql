-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Mar 2026 pada 17.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr_db`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertDataRajin` ()   BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < 30 DO
        -- Mengisi 30 hari ke belakang dengan status 'present' (tepat waktu)
        INSERT INTO attendances (employee_id, date, check_in, status) 
        VALUES (12, DATE_SUB(CURDATE(), INTERVAL i DAY), '07:30:00', 'present');
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('present','absent','late','leave') DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `date`, `check_in`, `check_out`, `status`, `notes`) VALUES
(1, 47, '2026-03-24', '07:15:00', NULL, 'present', NULL),
(2, 47, '2026-03-23', '07:15:00', NULL, 'present', NULL),
(3, 47, '2026-03-22', '07:15:00', NULL, 'present', NULL),
(4, 47, '2026-03-21', '07:15:00', NULL, 'present', NULL),
(5, 47, '2026-03-20', '07:15:00', NULL, 'present', NULL),
(6, 47, '2026-03-19', '07:15:00', NULL, 'present', NULL),
(7, 47, '2026-03-18', '07:15:00', NULL, 'present', NULL),
(8, 47, '2026-03-17', '07:15:00', NULL, 'present', NULL),
(9, 47, '2026-03-16', '07:15:00', NULL, 'present', NULL),
(10, 47, '2026-03-15', '07:15:00', NULL, 'present', NULL),
(11, 47, '2026-03-14', '07:15:00', NULL, 'present', NULL),
(12, 47, '2026-03-13', '07:15:00', NULL, 'present', NULL),
(13, 47, '2026-03-12', '07:15:00', NULL, 'present', NULL),
(14, 47, '2026-03-11', '07:15:00', NULL, 'present', NULL),
(15, 47, '2026-03-10', '07:15:00', NULL, 'present', NULL),
(16, 47, '2026-03-09', '07:15:00', NULL, 'present', NULL),
(17, 47, '2026-03-08', '07:15:00', NULL, 'present', NULL),
(18, 47, '2026-03-07', '07:15:00', NULL, 'present', NULL),
(19, 47, '2026-03-06', '07:15:00', NULL, 'present', NULL),
(20, 47, '2026-03-05', '07:15:00', NULL, 'present', NULL),
(21, 47, '2026-03-04', '07:15:00', NULL, 'present', NULL),
(22, 47, '2026-03-03', '07:15:00', NULL, 'present', NULL),
(23, 47, '2026-03-02', '07:15:00', NULL, 'present', NULL),
(24, 47, '2026-03-01', '07:15:00', NULL, 'present', NULL),
(25, 47, '2026-02-28', '07:15:00', NULL, 'present', NULL),
(26, 47, '2026-02-27', '07:15:00', NULL, 'present', NULL),
(27, 47, '2026-02-26', '07:15:00', NULL, 'present', NULL),
(28, 47, '2026-02-25', '07:15:00', NULL, 'present', NULL),
(29, 47, '2026-02-24', '07:15:00', NULL, 'present', NULL),
(30, 47, '2026-02-23', '07:15:00', NULL, 'present', NULL),
(32, 48, '2026-03-24', NULL, NULL, 'absent', NULL),
(33, 48, '2026-03-23', NULL, NULL, 'absent', NULL),
(34, 48, '2026-03-22', NULL, NULL, 'absent', NULL),
(35, 48, '2026-03-21', NULL, NULL, 'absent', NULL),
(36, 48, '2026-03-20', NULL, NULL, 'absent', NULL),
(37, 48, '2026-03-19', NULL, NULL, 'absent', NULL),
(38, 48, '2026-03-18', NULL, NULL, 'absent', NULL),
(39, 48, '2026-03-17', NULL, NULL, 'absent', NULL),
(40, 48, '2026-03-16', '08:45:00', NULL, 'late', NULL),
(41, 48, '2026-03-15', '08:45:00', NULL, 'late', NULL),
(42, 48, '2026-03-14', '08:45:00', NULL, 'late', NULL),
(43, 48, '2026-03-13', '08:45:00', NULL, 'late', NULL),
(44, 48, '2026-03-12', '08:45:00', NULL, 'late', NULL),
(45, 48, '2026-03-11', '08:45:00', NULL, 'late', NULL),
(46, 48, '2026-03-10', '08:45:00', NULL, 'late', NULL),
(47, 48, '2026-03-09', '08:45:00', NULL, 'late', NULL),
(48, 48, '2026-03-08', '08:45:00', NULL, 'late', NULL),
(49, 48, '2026-03-07', '08:45:00', NULL, 'late', NULL),
(50, 48, '2026-03-06', '08:45:00', NULL, 'late', NULL),
(51, 48, '2026-03-05', '08:45:00', NULL, 'late', NULL),
(52, 48, '2026-03-04', '07:30:00', NULL, 'present', NULL),
(53, 48, '2026-03-03', '07:30:00', NULL, 'present', NULL),
(54, 48, '2026-03-02', '07:30:00', NULL, 'present', NULL),
(55, 48, '2026-03-01', '07:30:00', NULL, 'present', NULL),
(56, 48, '2026-02-28', '07:30:00', NULL, 'present', NULL),
(57, 48, '2026-02-27', '07:30:00', NULL, 'present', NULL),
(58, 48, '2026-02-26', '07:30:00', NULL, 'present', NULL),
(59, 48, '2026-02-25', '07:30:00', NULL, 'present', NULL),
(60, 48, '2026-02-24', '07:30:00', NULL, 'present', NULL),
(61, 48, '2026-02-23', '07:30:00', NULL, 'present', NULL),
(63, 42, '2026-03-24', '08:15:00', NULL, 'late', NULL),
(64, 42, '2026-03-23', '08:15:00', NULL, 'late', NULL),
(65, 42, '2026-03-22', '08:15:00', NULL, 'late', NULL),
(66, 42, '2026-03-21', '08:15:00', NULL, 'late', NULL),
(67, 42, '2026-03-20', '08:15:00', NULL, 'late', NULL),
(68, 42, '2026-03-19', '07:45:00', NULL, 'present', NULL),
(69, 42, '2026-03-18', '07:45:00', NULL, 'present', NULL),
(70, 42, '2026-03-17', '07:45:00', NULL, 'present', NULL),
(71, 42, '2026-03-16', '07:45:00', NULL, 'present', NULL),
(72, 42, '2026-03-15', '07:45:00', NULL, 'present', NULL),
(73, 42, '2026-03-14', '07:45:00', NULL, 'present', NULL),
(74, 42, '2026-03-13', '07:45:00', NULL, 'present', NULL),
(75, 42, '2026-03-12', '07:45:00', NULL, 'present', NULL),
(76, 42, '2026-03-11', '07:45:00', NULL, 'present', NULL),
(77, 42, '2026-03-10', '07:45:00', NULL, 'present', NULL),
(78, 42, '2026-03-09', '07:45:00', NULL, 'present', NULL),
(79, 42, '2026-03-08', '07:45:00', NULL, 'present', NULL),
(80, 42, '2026-03-07', '07:45:00', NULL, 'present', NULL),
(81, 42, '2026-03-06', '07:45:00', NULL, 'present', NULL),
(82, 42, '2026-03-05', '07:45:00', NULL, 'present', NULL),
(83, 42, '2026-03-04', '07:45:00', NULL, 'present', NULL),
(84, 42, '2026-03-03', '07:45:00', NULL, 'present', NULL),
(85, 42, '2026-03-02', '07:45:00', NULL, 'present', NULL),
(86, 42, '2026-03-01', '07:45:00', NULL, 'present', NULL),
(87, 42, '2026-02-28', '07:45:00', NULL, 'present', NULL),
(88, 42, '2026-02-27', '07:45:00', NULL, 'present', NULL),
(89, 42, '2026-02-26', '07:45:00', NULL, 'present', NULL),
(90, 42, '2026-02-25', '07:45:00', NULL, 'present', NULL),
(91, 42, '2026-02-24', '07:45:00', NULL, 'present', NULL),
(92, 42, '2026-02-23', '07:45:00', NULL, 'present', NULL),
(94, 43, '2026-03-24', '08:20:00', NULL, 'present', NULL),
(95, 44, '2026-03-24', '08:20:00', NULL, 'present', NULL),
(96, 45, '2026-03-24', '08:20:00', NULL, 'present', NULL),
(97, 46, '2026-03-24', '07:40:00', NULL, 'present', NULL),
(98, 43, '2026-03-23', '07:40:00', NULL, 'present', NULL),
(99, 44, '2026-03-23', '08:20:00', NULL, 'late', NULL),
(100, 45, '2026-03-23', '07:40:00', NULL, 'present', NULL),
(101, 46, '2026-03-23', '07:40:00', NULL, 'late', NULL),
(102, 43, '2026-03-22', '07:40:00', NULL, 'late', NULL),
(103, 44, '2026-03-22', '07:40:00', NULL, 'late', NULL),
(104, 45, '2026-03-22', '08:20:00', NULL, 'present', NULL),
(105, 46, '2026-03-22', '07:40:00', NULL, 'present', NULL),
(106, 43, '2026-03-21', '07:40:00', NULL, 'present', NULL),
(107, 44, '2026-03-21', '07:40:00', NULL, 'present', NULL),
(108, 45, '2026-03-21', '08:20:00', NULL, 'late', NULL),
(109, 46, '2026-03-21', '07:40:00', NULL, 'late', NULL),
(110, 43, '2026-03-20', '07:40:00', NULL, 'present', NULL),
(111, 44, '2026-03-20', '07:40:00', NULL, 'present', NULL),
(112, 45, '2026-03-20', '08:20:00', NULL, 'present', NULL),
(113, 46, '2026-03-20', '07:40:00', NULL, 'late', NULL),
(114, 43, '2026-03-19', '08:20:00', NULL, 'present', NULL),
(115, 44, '2026-03-19', '07:40:00', NULL, 'late', NULL),
(116, 45, '2026-03-19', '08:20:00', NULL, 'present', NULL),
(117, 46, '2026-03-19', '07:40:00', NULL, 'present', NULL),
(118, 43, '2026-03-18', '07:40:00', NULL, 'present', NULL),
(119, 44, '2026-03-18', '08:20:00', NULL, 'present', NULL),
(120, 45, '2026-03-18', '07:40:00', NULL, 'present', NULL),
(121, 46, '2026-03-18', '07:40:00', NULL, 'present', NULL),
(122, 43, '2026-03-17', '07:40:00', NULL, 'late', NULL),
(123, 44, '2026-03-17', '08:20:00', NULL, 'present', NULL),
(124, 45, '2026-03-17', '07:40:00', NULL, 'late', NULL),
(125, 46, '2026-03-17', '07:40:00', NULL, 'present', NULL),
(126, 43, '2026-03-16', '08:20:00', NULL, 'present', NULL),
(127, 44, '2026-03-16', '07:40:00', NULL, 'present', NULL),
(128, 45, '2026-03-16', '07:40:00', NULL, 'present', NULL),
(129, 46, '2026-03-16', '07:40:00', NULL, 'present', NULL),
(130, 43, '2026-03-15', '07:40:00', NULL, 'present', NULL),
(131, 44, '2026-03-15', '07:40:00', NULL, 'present', NULL),
(132, 45, '2026-03-15', '08:20:00', NULL, 'present', NULL),
(133, 46, '2026-03-15', '08:20:00', NULL, 'present', NULL),
(134, 43, '2026-03-14', '08:20:00', NULL, 'present', NULL),
(135, 44, '2026-03-14', '07:40:00', NULL, 'present', NULL),
(136, 45, '2026-03-14', '07:40:00', NULL, 'present', NULL),
(137, 46, '2026-03-14', '08:20:00', NULL, 'late', NULL),
(138, 43, '2026-03-13', '07:40:00', NULL, 'present', NULL),
(139, 44, '2026-03-13', '07:40:00', NULL, 'present', NULL),
(140, 45, '2026-03-13', '08:20:00', NULL, 'late', NULL),
(141, 46, '2026-03-13', '07:40:00', NULL, 'present', NULL),
(142, 43, '2026-03-12', '07:40:00', NULL, 'present', NULL),
(143, 44, '2026-03-12', '07:40:00', NULL, 'late', NULL),
(144, 45, '2026-03-12', '07:40:00', NULL, 'present', NULL),
(145, 46, '2026-03-12', '07:40:00', NULL, 'present', NULL),
(146, 43, '2026-03-11', '07:40:00', NULL, 'late', NULL),
(147, 44, '2026-03-11', '07:40:00', NULL, 'present', NULL),
(148, 45, '2026-03-11', '07:40:00', NULL, 'late', NULL),
(149, 46, '2026-03-11', '08:20:00', NULL, 'late', NULL),
(150, 43, '2026-03-10', '08:20:00', NULL, 'late', NULL),
(151, 44, '2026-03-10', '07:40:00', NULL, 'present', NULL),
(152, 45, '2026-03-10', '07:40:00', NULL, 'present', NULL),
(153, 46, '2026-03-10', '08:20:00', NULL, 'present', NULL),
(154, 43, '2026-03-09', '08:20:00', NULL, 'late', NULL),
(155, 44, '2026-03-09', '07:40:00', NULL, 'late', NULL),
(156, 45, '2026-03-09', '08:20:00', NULL, 'present', NULL),
(157, 46, '2026-03-09', '08:20:00', NULL, 'late', NULL),
(158, 43, '2026-03-08', '07:40:00', NULL, 'present', NULL),
(159, 44, '2026-03-08', '08:20:00', NULL, 'present', NULL),
(160, 45, '2026-03-08', '08:20:00', NULL, 'late', NULL),
(161, 46, '2026-03-08', '07:40:00', NULL, 'present', NULL),
(162, 43, '2026-03-07', '07:40:00', NULL, 'late', NULL),
(163, 44, '2026-03-07', '07:40:00', NULL, 'present', NULL),
(164, 45, '2026-03-07', '07:40:00', NULL, 'present', NULL),
(165, 46, '2026-03-07', '07:40:00', NULL, 'present', NULL),
(166, 43, '2026-03-06', '07:40:00', NULL, 'present', NULL),
(167, 44, '2026-03-06', '08:20:00', NULL, 'present', NULL),
(168, 45, '2026-03-06', '08:20:00', NULL, 'present', NULL),
(169, 46, '2026-03-06', '08:20:00', NULL, 'present', NULL),
(170, 43, '2026-03-05', '07:40:00', NULL, 'present', NULL),
(171, 44, '2026-03-05', '08:20:00', NULL, 'present', NULL),
(172, 45, '2026-03-05', '08:20:00', NULL, 'present', NULL),
(173, 46, '2026-03-05', '07:40:00', NULL, 'present', NULL),
(174, 43, '2026-03-04', '07:40:00', NULL, 'late', NULL),
(175, 44, '2026-03-04', '07:40:00', NULL, 'present', NULL),
(176, 45, '2026-03-04', '07:40:00', NULL, 'present', NULL),
(177, 46, '2026-03-04', '08:20:00', NULL, 'present', NULL),
(178, 43, '2026-03-03', '07:40:00', NULL, 'present', NULL),
(179, 44, '2026-03-03', '07:40:00', NULL, 'present', NULL),
(180, 45, '2026-03-03', '07:40:00', NULL, 'late', NULL),
(181, 46, '2026-03-03', '07:40:00', NULL, 'late', NULL),
(182, 43, '2026-03-02', '07:40:00', NULL, 'present', NULL),
(183, 44, '2026-03-02', '08:20:00', NULL, 'present', NULL),
(184, 45, '2026-03-02', '07:40:00', NULL, 'present', NULL),
(185, 46, '2026-03-02', '07:40:00', NULL, 'late', NULL),
(186, 43, '2026-03-01', '07:40:00', NULL, 'late', NULL),
(187, 44, '2026-03-01', '07:40:00', NULL, 'present', NULL),
(188, 45, '2026-03-01', '08:20:00', NULL, 'late', NULL),
(189, 46, '2026-03-01', '07:40:00', NULL, 'present', NULL),
(190, 43, '2026-02-28', '08:20:00', NULL, 'late', NULL),
(191, 44, '2026-02-28', '07:40:00', NULL, 'present', NULL),
(192, 45, '2026-02-28', '07:40:00', NULL, 'late', NULL),
(193, 46, '2026-02-28', '07:40:00', NULL, 'present', NULL),
(194, 43, '2026-02-27', '07:40:00', NULL, 'late', NULL),
(195, 44, '2026-02-27', '07:40:00', NULL, 'present', NULL),
(196, 45, '2026-02-27', '08:20:00', NULL, 'present', NULL),
(197, 46, '2026-02-27', '08:20:00', NULL, 'present', NULL),
(198, 43, '2026-02-26', '07:40:00', NULL, 'late', NULL),
(199, 44, '2026-02-26', '07:40:00', NULL, 'present', NULL),
(200, 45, '2026-02-26', '07:40:00', NULL, 'present', NULL),
(201, 46, '2026-02-26', '07:40:00', NULL, 'late', NULL),
(202, 43, '2026-02-25', '07:40:00', NULL, 'present', NULL),
(203, 44, '2026-02-25', '07:40:00', NULL, 'present', NULL),
(204, 45, '2026-02-25', '07:40:00', NULL, 'present', NULL),
(205, 46, '2026-02-25', '07:40:00', NULL, 'late', NULL),
(206, 43, '2026-02-24', '08:20:00', NULL, 'late', NULL),
(207, 44, '2026-02-24', '07:40:00', NULL, 'present', NULL),
(208, 45, '2026-02-24', '08:20:00', NULL, 'present', NULL),
(209, 46, '2026-02-24', '07:40:00', NULL, 'late', NULL),
(210, 43, '2026-02-23', '08:20:00', NULL, 'present', NULL),
(211, 44, '2026-02-23', '07:40:00', NULL, 'late', NULL),
(212, 45, '2026-02-23', '07:40:00', NULL, 'present', NULL),
(213, 46, '2026-02-23', '08:20:00', NULL, 'present', NULL),
(221, 49, '2026-03-24', NULL, NULL, 'absent', NULL),
(222, 50, '2026-03-24', NULL, NULL, 'absent', NULL),
(223, 49, '2026-03-23', '07:50:00', NULL, 'present', NULL),
(224, 50, '2026-03-23', '07:50:00', NULL, 'present', NULL),
(225, 49, '2026-03-22', '07:50:00', NULL, 'present', NULL),
(226, 50, '2026-03-22', '07:50:00', NULL, 'present', NULL),
(227, 49, '2026-03-21', '07:50:00', NULL, 'present', NULL),
(228, 50, '2026-03-21', '07:50:00', NULL, 'present', NULL),
(229, 49, '2026-03-20', '07:50:00', NULL, 'present', NULL),
(230, 50, '2026-03-20', '07:50:00', NULL, 'present', NULL),
(231, 49, '2026-03-19', '07:50:00', NULL, 'present', NULL),
(232, 50, '2026-03-19', '07:50:00', NULL, 'present', NULL),
(233, 49, '2026-03-18', NULL, NULL, 'absent', NULL),
(234, 50, '2026-03-18', NULL, NULL, 'absent', NULL),
(235, 49, '2026-03-17', '07:50:00', NULL, 'present', NULL),
(236, 50, '2026-03-17', '07:50:00', NULL, 'present', NULL),
(237, 49, '2026-03-16', '07:50:00', NULL, 'present', NULL),
(238, 50, '2026-03-16', '07:50:00', NULL, 'present', NULL),
(239, 49, '2026-03-15', '07:50:00', NULL, 'present', NULL),
(240, 50, '2026-03-15', '07:50:00', NULL, 'present', NULL),
(241, 49, '2026-03-14', '07:50:00', NULL, 'present', NULL),
(242, 50, '2026-03-14', '07:50:00', NULL, 'present', NULL),
(243, 49, '2026-03-13', '07:50:00', NULL, 'present', NULL),
(244, 50, '2026-03-13', '07:50:00', NULL, 'present', NULL),
(245, 49, '2026-03-12', NULL, NULL, 'absent', NULL),
(246, 50, '2026-03-12', NULL, NULL, 'absent', NULL),
(247, 49, '2026-03-11', '07:50:00', NULL, 'present', NULL),
(248, 50, '2026-03-11', '07:50:00', NULL, 'present', NULL),
(249, 49, '2026-03-10', '07:50:00', NULL, 'present', NULL),
(250, 50, '2026-03-10', '07:50:00', NULL, 'present', NULL),
(251, 49, '2026-03-09', '07:50:00', NULL, 'present', NULL),
(252, 50, '2026-03-09', '07:50:00', NULL, 'present', NULL),
(253, 49, '2026-03-08', '07:50:00', NULL, 'present', NULL),
(254, 50, '2026-03-08', '07:50:00', NULL, 'present', NULL),
(255, 49, '2026-03-07', '07:50:00', NULL, 'present', NULL),
(256, 50, '2026-03-07', '07:50:00', NULL, 'present', NULL),
(257, 49, '2026-03-06', NULL, NULL, 'absent', NULL),
(258, 50, '2026-03-06', NULL, NULL, 'absent', NULL),
(259, 49, '2026-03-05', '07:50:00', NULL, 'present', NULL),
(260, 50, '2026-03-05', '07:50:00', NULL, 'present', NULL),
(261, 49, '2026-03-04', '07:50:00', NULL, 'present', NULL),
(262, 50, '2026-03-04', '07:50:00', NULL, 'present', NULL),
(263, 49, '2026-03-03', '07:50:00', NULL, 'present', NULL),
(264, 50, '2026-03-03', '07:50:00', NULL, 'present', NULL),
(265, 49, '2026-03-02', '07:50:00', NULL, 'present', NULL),
(266, 50, '2026-03-02', '07:50:00', NULL, 'present', NULL),
(267, 49, '2026-03-01', '07:50:00', NULL, 'present', NULL),
(268, 50, '2026-03-01', '07:50:00', NULL, 'present', NULL),
(269, 49, '2026-02-28', NULL, NULL, 'absent', NULL),
(270, 50, '2026-02-28', NULL, NULL, 'absent', NULL),
(271, 49, '2026-02-27', '07:50:00', NULL, 'present', NULL),
(272, 50, '2026-02-27', '07:50:00', NULL, 'present', NULL),
(273, 49, '2026-02-26', '07:50:00', NULL, 'present', NULL),
(274, 50, '2026-02-26', '07:50:00', NULL, 'present', NULL),
(275, 49, '2026-02-25', '07:50:00', NULL, 'present', NULL),
(276, 50, '2026-02-25', '07:50:00', NULL, 'present', NULL),
(277, 49, '2026-02-24', '07:50:00', NULL, 'present', NULL),
(278, 50, '2026-02-24', '07:50:00', NULL, 'present', NULL),
(279, 49, '2026-02-23', '07:50:00', NULL, 'present', NULL),
(280, 50, '2026-02-23', '07:50:00', NULL, 'present', NULL),
(300, 58, '2026-03-24', '07:45:00', NULL, 'present', NULL),
(301, 58, '2026-03-23', '07:45:00', NULL, 'present', NULL),
(302, 58, '2026-03-22', '07:45:00', NULL, 'present', NULL),
(303, 58, '2026-03-21', '07:45:00', NULL, 'present', NULL),
(304, 58, '2026-03-20', '07:45:00', NULL, 'present', NULL),
(305, 58, '2026-03-19', '07:45:00', NULL, 'present', NULL),
(306, 58, '2026-03-18', '07:45:00', NULL, 'present', NULL),
(307, 58, '2026-03-17', '07:45:00', NULL, 'present', NULL),
(308, 58, '2026-03-16', '07:45:00', NULL, 'present', NULL),
(309, 58, '2026-03-15', '07:45:00', NULL, 'present', NULL),
(315, 59, '2026-03-24', NULL, NULL, 'absent', NULL),
(316, 59, '2026-03-23', '07:15:00', NULL, 'present', NULL),
(317, 59, '2026-03-22', '08:45:00', NULL, 'late', NULL),
(318, 59, '2026-03-21', NULL, NULL, 'absent', NULL),
(319, 59, '2026-03-20', '08:45:00', NULL, 'late', NULL),
(320, 59, '2026-03-19', '07:15:00', NULL, 'present', NULL),
(321, 59, '2026-03-18', NULL, NULL, 'absent', NULL),
(322, 59, '2026-03-17', '07:15:00', NULL, 'present', NULL),
(323, 59, '2026-03-16', '08:45:00', NULL, 'late', NULL),
(324, 59, '2026-03-15', NULL, NULL, 'absent', NULL),
(325, 59, '2026-03-14', '08:45:00', NULL, 'late', NULL),
(326, 59, '2026-03-13', '07:15:00', NULL, 'present', NULL),
(327, 59, '2026-03-12', NULL, NULL, 'absent', NULL),
(328, 59, '2026-03-11', '07:15:00', NULL, 'present', NULL),
(329, 59, '2026-03-10', '08:45:00', NULL, 'late', NULL),
(330, 59, '2026-03-09', NULL, NULL, 'absent', NULL),
(331, 59, '2026-03-08', '08:45:00', NULL, 'late', NULL),
(332, 59, '2026-03-07', '07:15:00', NULL, 'present', NULL),
(333, 59, '2026-03-06', NULL, NULL, 'absent', NULL),
(334, 59, '2026-03-05', '07:15:00', NULL, 'present', NULL),
(335, 59, '2026-03-04', '08:45:00', NULL, 'late', NULL),
(336, 59, '2026-03-03', NULL, NULL, 'absent', NULL),
(337, 59, '2026-03-02', '08:45:00', NULL, 'late', NULL),
(338, 59, '2026-03-01', '07:15:00', NULL, 'present', NULL),
(339, 59, '2026-02-28', NULL, NULL, 'absent', NULL),
(340, 59, '2026-02-27', '07:15:00', NULL, 'present', NULL),
(341, 59, '2026-02-26', '08:45:00', NULL, 'late', NULL),
(342, 59, '2026-02-25', NULL, NULL, 'absent', NULL),
(343, 59, '2026-02-24', '08:45:00', NULL, 'late', NULL),
(344, 59, '2026-02-23', '07:15:00', NULL, 'present', NULL),
(346, 57, '2026-03-24', '07:45:00', NULL, 'present', NULL),
(347, 57, '2026-03-23', '07:45:00', NULL, 'present', NULL),
(348, 57, '2026-03-22', '07:45:00', NULL, 'present', NULL),
(349, 57, '2026-03-21', '07:45:00', NULL, 'present', NULL),
(350, 57, '2026-03-20', '07:45:00', NULL, 'present', NULL),
(351, 57, '2026-03-19', '07:45:00', NULL, 'present', NULL),
(352, 57, '2026-03-18', '07:45:00', NULL, 'present', NULL),
(353, 57, '2026-03-17', '07:45:00', NULL, 'present', NULL),
(354, 57, '2026-03-16', '07:45:00', NULL, 'present', NULL),
(355, 57, '2026-03-15', '07:45:00', NULL, 'present', NULL),
(361, 40, '2026-03-24', '22:56:39', NULL, 'absent', NULL),
(364, 47, '2026-03-24', '07:30:00', NULL, '', NULL),
(365, 48, '2026-03-24', '08:45:00', NULL, '', NULL),
(366, 57, '2026-03-24', '07:15:00', NULL, '', NULL),
(367, 47, '2026-03-24', '07:30:00', NULL, '', NULL),
(368, 48, '2026-03-24', '08:45:00', NULL, '', NULL),
(369, 57, '2026-03-24', '07:15:00', NULL, '', NULL),
(370, 47, '2026-03-24', '07:30:00', NULL, '', NULL),
(371, 48, '2026-03-24', '08:45:00', NULL, '', NULL),
(372, 57, '2026-03-24', '07:15:00', NULL, '', NULL),
(373, 47, '2026-03-24', '07:30:00', NULL, '', NULL),
(374, 48, '2026-03-24', '08:45:00', NULL, '', NULL),
(375, 57, '2026-03-24', '07:15:00', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `employee_code` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `resign_date` date DEFAULT NULL,
  `base_salary` decimal(10,2) DEFAULT NULL,
  `status` enum('active','resign') DEFAULT 'active',
  `resign_status` enum('active','pending','resign') DEFAULT 'active',
  `resign_requested_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `employee_code`, `name`, `department_id`, `position`, `hire_date`, `resign_date`, `base_salary`, `status`, `resign_status`, `resign_requested_at`) VALUES
(40, 47, '002A', 'satr', NULL, 'Admin', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(41, 48, '002C', 'z', NULL, 'Hr', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(42, 49, '0049C', 'hr_satu', NULL, 'HR Staff', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(43, 50, '0050C', 'hr_dua', NULL, 'HR Staff', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(44, 51, '0051C', 'hr_tiga', NULL, 'HR Staff', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(45, 52, '0052C', 'hr_empat', NULL, 'HR Staff', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(46, 53, '0053C', 'hr_lima', NULL, 'HR Staff', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(47, 54, '0054B', 'staff_jono', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(48, 55, '0055B', 'staff_siti', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(49, 56, '0056B', 'staff_andi', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(50, 57, '0057B', 'staff_budi', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(57, 59, '0059B', 'staff_raffi', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(58, 60, '0060B', 'staff_mira', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL),
(59, 61, '0061B', 'staff_duwi', NULL, 'Staff Employee', NULL, NULL, 5000000.00, 'active', 'active', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','hr','employee') DEFAULT 'employee',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(47, 'satr', '$2y$10$jPJxLDLyL8aVZHPP5puNYuqKOwLswijRWFsymORPAFI0J3klN4bI2', 's@gmail.com', 'admin', '2026-03-24 15:12:27'),
(49, 'hr_satu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hr1@mail.com', 'hr', '2026-03-24 15:42:15'),
(50, 'hr_dua', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hr2@mail.com', 'hr', '2026-03-24 15:42:15'),
(51, 'hr_tiga', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hr3@mail.com', 'hr', '2026-03-24 15:42:15'),
(52, 'hr_empat', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hr4@mail.com', 'hr', '2026-03-24 15:42:15'),
(53, 'hr_lima', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hr5@mail.com', 'hr', '2026-03-24 15:42:15'),
(54, 'staff_jono', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jono@mail.com', 'employee', '2026-03-24 15:42:15'),
(55, 'staff_siti', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siti@mail.com', 'employee', '2026-03-24 15:42:15'),
(56, 'staff_andi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'andi@mail.com', 'employee', '2026-03-24 15:42:15'),
(57, 'staff_budi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'budi@mail.com', 'employee', '2026-03-24 15:42:15'),
(61, 'staff_duwi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'duwi@mail.com', 'employee', '2026-03-24 15:51:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attendance_employee` (`employee_id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `fk_attendance_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

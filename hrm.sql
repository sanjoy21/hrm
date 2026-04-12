-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 06:17 AM
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
-- Database: `hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_letters`
--

CREATE TABLE `appointment_letters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `letter` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_letters`
--

INSERT INTO `appointment_letters` (`id`, `name`, `date`, `letter`, `created_at`, `updated_at`) VALUES
(16, 'Sanjoy Dey', '2025-10-26', '<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\"><b style=\"mso-bidi-font-weight:normal\"><span style=\"mso-bidi-font-size:10.0pt;\r\nline-height:115%;font-family:\" arial\",sans-serif\"=\"\">RKSBD/HR/20250301-03<span style=\"mso-spacerun:yes\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span></span></b>Date: 26/10/2025</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">&nbsp;</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">&nbsp;</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">Sanjoy Dey<span style=\"mso-spacerun:yes\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">Address: Uttar Paik Para, Paler Bari</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">Tongibari, Munshiganj-1502</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">Mobile: 01XXXXXXXXX</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">E-mail: example@gmail.com</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">&nbsp;</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">&nbsp;</p>\r\n\r\n<p class=\"MsoNormal\" align=\"center\" style=\"text-align:center\"><b style=\"mso-bidi-font-weight:\r\nnormal\"><span style=\"font-size:12.0pt;line-height:115%\">SUBJECT: <u>Appointment\r\nLetter</u></span></b></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align:justify;text-justify:inter-ideograph\">With\r\nreference to your bio-data submitted to us and the subsequent interview held\r\nfor Contractual Employment as an <b>Programmer&nbsp;</b>in <b style=\"mso-bidi-font-weight:normal\">RK Software (Bangladesh)\r\nLimited</b>, we are pleased to offer you <b style=\"mso-bidi-font-weight:normal\">Contractual\r\nEmployment from <span style=\"background:yellow;mso-highlight:yellow\">1<sup>st</sup>\r\n<span style=\"mso-spacerun:yes\">&nbsp;</span>March 2025</span> </b>on the following\r\nterms &amp; conditions.</p>\r\n\r\n<ol style=\"margin-top:0in\" start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">Your\r\n     station of duty will be as decided by the Company. </li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">Your\r\n     remuneration is fixed at 25,000 BDT (Twenty-Five Thousand Taka) per Month.</li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">You\r\n     must not engage yourself in any work or carryout any other assignment for\r\n     which you have no permission of the management of the company. </li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">You\r\n     must not disclose any secret information or any matter prejudicial to the\r\n     interest of the Company.</li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">You\r\n     are to abide by all rules and regulations of the Company, prevailing &amp;\r\n     subsequently coming in force from time to time &amp; the service contract\r\n     signed.</li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">You\r\n     will not leave the company before you have completed <b style=\"mso-bidi-font-weight:\r\n     normal\">02 (Two) Years of service</b> calculated from the date of your\r\n     joining or a period as may be agreed by you and the company. In breach of\r\n     this provision you shall have to pay compensation to the company.</li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\">You\r\n     will be on <b style=\"mso-bidi-font-weight:normal\">probation</b> for a\r\n     period of <b style=\"mso-bidi-font-weight:normal\">6 (Six) months</b>, and\r\n     on successful completion of your probation, your services will be\r\n     confirmed for <b style=\"mso-bidi-font-weight:normal\">Permanent Employment.</b></li><li class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-bottom:6.0pt;  page-break-before: always; text-align:\r\n     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1\"><p class=\"MsoListParagraph\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo1\"><b>&nbsp; &nbsp; &nbsp; &nbsp; Festival Bonus:</b></p>\r\n\r\n<ol style=\"margin-top:0in\" start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">Employees\r\n      who have completed six months of service will be eligible for a festival\r\n      bonus.</li><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">For\r\n      Muslim employees, there will be two Eid bonuses annually, each amounting\r\n      to half of the employee’s monthly salary.</li><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">Employees\r\n      belonging to other religious groups will receive a 100% yearly bonus\r\n      during Durga Puja, equivalent to one full month’s salary.</li></ol></li><li class=\"MsoNormal\" style=\"mso-list:l0 level1 lfo1;\"><b>Late Attendance and Salary Deduction:</b></li><ol style=\"margin-top:0in\" start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">The\r\n      company maintains a strict punctuality policy. If an employee is late for\r\n      work three times in a given month, one day\'s salary will be deducted from\r\n      the total salary for that month.</li></ol><li class=\"MsoNormal\" style=\"mso-list:l0 level1 lfo1\"><b>Financial and Legal\r\n     Responsibility:</b></li><ol style=\"margin-top:0in\" start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">RK\r\n      Software (Bangladesh) Limited works with Bangladesh government\r\n      organizations. If any employee is implicated in financial misconduct or\r\n      any criminal activity, the company will not take any liability or\r\n      responsibility for such actions.</li><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">The\r\n      company will fully cooperate with government authorities in investigating\r\n      and resolving any such crimes.</li><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">In\r\n      case of such incidents, the company reserves the right to terminate the\r\n      employee\'s contract immediately without prior notice.</li></ol><li class=\"MsoNormal\" style=\"mso-list:l0 level1 lfo1\"><b>Resignation Notice:</b></li><ol style=\"margin-top:0in\" start=\"1\" type=\"1\"><li class=\"MsoNormal\" style=\"mso-list:l0 level2 lfo1;tab-stops:list 1.0in\">If\r\n      you wish to resign from your position, you must provide the company with\r\n      a written notice at least two months in advance. Failure to comply with\r\n      this notice period may result in financial penalties or other actions as\r\n      per company policy.</li></ol></ol>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;\r\nmargin-left:0in;text-align:justify;text-justify:inter-ideograph\"><br>\r\nIf the above terms &amp; conditions are acceptable, you are advised to report\r\nfor duty to the Administration Department immediately. </p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"mso-no-proof:yes\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">Goutam Saha</p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">Chairman</p><p class=\"MsoNormal\" style=\"margin-bottom:0in;margin-bottom:.0001pt\">RK Software (Bangladesh) Ltd</p><br>', '2025-10-26 10:16:51', '2025-10-26 10:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `office` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `check_in` varchar(255) DEFAULT NULL,
  `check_in_lat` varchar(255) DEFAULT NULL,
  `check_in_long` varchar(255) DEFAULT NULL,
  `check_in_address` varchar(255) DEFAULT NULL,
  `check_out` varchar(255) DEFAULT NULL,
  `check_out_lat` varchar(255) DEFAULT NULL,
  `check_out_long` varchar(255) DEFAULT NULL,
  `check_out_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `office`, `date`, `check_in`, `check_in_lat`, `check_in_long`, `check_in_address`, `check_out`, `check_out_lat`, `check_out_long`, `check_out_address`, `created_at`, `updated_at`) VALUES
(14, 4, 1, '2025-10-06', '03:10:12 PM', '23.762006', '90.4025144', NULL, '03:10:17 PM', '23.762006', '90.4025144', NULL, '2025-10-07 09:10:12', '2025-10-07 09:10:17'),
(17, 4, 1, '2025-10-05', '09:10:12 AM', '23.762006', '90.4025144', NULL, '03:10:17 PM', '23.762006', '90.4025144', NULL, '2025-10-07 09:10:12', '2025-10-07 09:10:17'),
(25, 4, 1, '2025-10-07', '09:15:54 AM', '23.762006', '90.4025144', NULL, '04:16:40 PM', '23.762006', '90.4025144', NULL, '2025-10-07 10:15:54', '2025-10-07 10:16:40'),
(26, 4, 1, '2025-10-08', '09:09:30 AM', '23.762006', '90.4025144', NULL, NULL, NULL, NULL, NULL, '2025-10-08 05:09:30', '2025-10-08 05:09:30'),
(27, 7, 1, '2025-10-08', '08:36:28 AM', '23.7739274', '90.4031033', NULL, NULL, NULL, NULL, NULL, '2025-10-08 05:36:28', '2025-10-08 05:36:28'),
(28, 4, 1, '2025-10-20', '10:32:08 AM', '23.7746524', '90.4013364', NULL, NULL, NULL, NULL, NULL, '2025-10-20 04:32:08', '2025-10-20 04:32:08'),
(29, 4, 1, '2025-10-27', '09:10:28 AM', '23.7769195', '90.3872052', NULL, '04:33:07 PM', '23.7769195', '90.3872052', NULL, '2025-10-27 09:48:28', '2025-10-27 10:33:07'),
(30, 7, 1, '2025-10-27', '04:33:40 PM', '23.7769195', '90.3872052', NULL, NULL, NULL, NULL, NULL, '2025-10-27 10:33:40', '2025-10-27 10:33:40'),
(31, 4, 1, '2025-10-28', '03:12:47 PM', '23.7769195', '90.3872052', NULL, '03:14:45 PM', '23.7769195', '90.3872052', NULL, '2025-10-28 09:12:47', '2025-10-28 09:14:45'),
(33, 1, 1, '2025-10-29', '11:10:18 AM', '23.7769195', '90.3872052', NULL, '03:09:55 PM', '23.7769035', '90.3842619', NULL, '2025-10-29 05:10:18', '2025-10-29 09:09:55'),
(34, 9, 1, '2025-10-29', '08:15:39 AM', '23.7769195', '90.3872052', NULL, NULL, NULL, NULL, NULL, '2025-10-29 05:15:39', '2025-10-29 05:15:39'),
(35, 4, 1, '2025-10-29', '09:16:31 AM', '23.7769195', '90.3872052', NULL, NULL, NULL, NULL, NULL, '2025-10-29 05:16:31', '2025-10-29 05:16:31'),
(36, 8, 1, '2025-10-29', '12:07:44 PM', '23.7769035', '90.3842619', NULL, NULL, NULL, NULL, NULL, '2025-10-29 06:07:44', '2025-10-29 06:07:44'),
(37, 10, 1, '2025-10-29', '12:11:46 PM', '23.7769035', '90.3842619', NULL, NULL, NULL, NULL, NULL, '2025-10-29 06:11:46', '2025-10-29 06:11:46'),
(38, 1, 1, '2025-10-30', '09:20:58 AM', '23.7761801', '90.3854393', NULL, '05:00:42 PM', '23.7761801', '90.3854393', NULL, '2025-10-30 04:34:32', '2025-10-30 11:00:42'),
(39, 4, 1, '2025-10-30', '09:18:41 AM', '23.7841964', '90.3929295', NULL, '04:39:57 PM', '23.7761801', '90.3854393', NULL, '2025-10-30 04:38:41', '2025-10-30 10:39:57'),
(40, 7, 1, '2025-10-30', '11:06:23 AM', '23.7761801', '90.3454393', NULL, NULL, NULL, NULL, NULL, '2025-10-30 05:06:23', '2025-10-30 05:06:23'),
(42, 4, 1, '2025-12-30', '01:05:34 PM', '23.8192938', '90.4025143', NULL, NULL, NULL, NULL, NULL, '2025-12-30 08:15:34', '2025-12-30 08:15:34'),
(43, 4, 1, '2026-01-08', '12:46:11 PM', '23.7977506', '90.4037143', NULL, NULL, NULL, NULL, NULL, '2026-01-08 06:46:11', '2026-01-08 06:46:11'),
(44, 7, 1, '2026-01-08', '12:46:32 PM', '23.7977506', '90.4125143', NULL, NULL, NULL, NULL, NULL, '2026-01-08 06:46:32', '2026-01-08 06:46:32'),
(45, 12, 2, '2026-01-08', '08:46:54 AM', '23.8677506', '90.4025143', NULL, NULL, NULL, NULL, NULL, '2026-01-08 06:46:54', '2026-01-08 06:46:54'),
(46, 13, 2, '2026-01-08', '12:47:20 PM', '23.7977506', '90.4225143', NULL, NULL, NULL, NULL, NULL, '2026-01-08 06:47:20', '2026-01-08 06:47:20'),
(47, 1, 1, '2026-01-08', '12:53:15 PM', '23.7477506', '90.4025143', NULL, NULL, NULL, NULL, NULL, '2026-01-08 06:53:15', '2026-01-08 06:53:15'),
(56, 14, 3, '2026-01-18', '02:01:20 PM', '22.393542', '91.823427', NULL, NULL, NULL, NULL, NULL, '2026-01-18 08:01:20', '2026-01-18 08:01:20'),
(57, 12, 2, '2026-01-18', '02:08:16 PM', '23.7624678', '90.4033365', NULL, NULL, NULL, NULL, NULL, '2026-01-18 08:08:16', '2026-01-18 08:08:16'),
(58, 13, 2, '2026-01-18', '02:09:14 PM', '23.7724678', '90.4113365', NULL, NULL, NULL, NULL, NULL, '2026-01-18 08:09:14', '2026-01-18 08:09:14'),
(60, 1, 1, '2026-01-18', '05:51:19 PM', '23.7724678', '90.4013365', NULL, '05:56:01 PM', '23.7724678', '90.4013365', NULL, '2026-01-18 11:51:19', '2026-01-18 11:56:01'),
(63, 9, 1, '2026-01-18', '06:02:10 PM', '23.7724678', '90.4013365', NULL, NULL, NULL, NULL, NULL, '2026-01-18 12:02:10', '2026-01-18 12:02:10'),
(69, 4, 1, '2026-01-20', '02:53:56 PM', '23.7837', '90.3928', NULL, NULL, NULL, NULL, NULL, '2026-01-20 08:53:56', '2026-01-20 08:53:56'),
(70, 7, 1, '2026-01-20', '02:54:21 PM', '23.7837', '90.3828', NULL, NULL, NULL, NULL, NULL, '2026-01-20 08:54:21', '2026-01-20 08:54:21'),
(71, 12, 2, '2026-01-20', '02:54:43 PM', '23.7937', '90.3928', NULL, NULL, NULL, NULL, NULL, '2026-01-20 08:54:43', '2026-01-20 08:54:43'),
(72, 13, 2, '2026-01-20', '02:55:01 PM', '23.78340', '90.3930', NULL, NULL, NULL, NULL, NULL, '2026-01-20 08:55:01', '2026-01-20 08:55:01'),
(73, 4, 1, '2026-01-22', '10:02:35 AM', '23.7746956', '90.3842619', NULL, NULL, NULL, NULL, NULL, '2026-01-22 04:02:35', '2026-01-22 04:02:35'),
(74, 12, 2, '2026-01-22', '01:50:45 PM', '23.7946494', '90.4125143', NULL, NULL, NULL, NULL, NULL, '2026-01-22 07:50:45', '2026-01-22 07:50:45'),
(75, 13, 2, '2026-01-22', '01:51:06 PM', '23.7746494', '90.4035143', NULL, NULL, NULL, NULL, NULL, '2026-01-22 07:51:06', '2026-01-22 07:51:06'),
(76, 15, 2, '2026-01-22', '01:51:31 PM', '23.7756494', '90.4025143', NULL, NULL, NULL, NULL, NULL, '2026-01-22 07:51:31', '2026-01-22 07:51:31'),
(78, 4, 1, '2026-01-25', '08:52:20 AM', '23.8103357', '90.4154727', NULL, NULL, NULL, NULL, NULL, '2026-01-25 07:52:20', '2026-01-25 07:52:20'),
(80, 12, 2, '2026-01-26', '11:02:40 AM', '23.810356', '90.407815', NULL, NULL, NULL, NULL, NULL, '2026-01-26 05:02:40', '2026-01-26 05:02:40'),
(81, 4, 1, '2026-01-26', '09:04:34 AM', '23.790356', '90.397815', NULL, NULL, NULL, NULL, NULL, '2026-01-26 05:04:34', '2026-01-26 05:04:34'),
(82, 9, 1, '2026-01-26', '11:28:04 AM', '23.810356', '90.407815', NULL, '12:06:03 PM', '23.8073813', '90.407815', NULL, '2026-01-26 05:28:04', '2026-01-26 06:06:03'),
(83, 4, 1, '2026-02-05', '12:50:31 PM', '23.7769427', '90.3872052', NULL, NULL, NULL, NULL, NULL, '2026-02-05 06:50:31', '2026-02-05 06:50:31'),
(84, 7, 1, '2026-02-05', '12:51:49 PM', '22.333720', '91.829987', NULL, NULL, NULL, NULL, NULL, '2026-02-05 06:51:49', '2026-02-05 06:51:49'),
(85, 1, 1, '2026-02-16', '04:59:33 PM', '23.7746956', '90.3842619', NULL, '04:59:49 PM', '23.7746956', '90.3842619', NULL, '2026-02-16 10:59:33', '2026-02-16 10:59:49'),
(88, 9, 1, '2026-02-17', '10:46:02 AM', '23.7768836', '90.4013365', NULL, '10:46:38 AM', '23.7768836', '90.4013365', NULL, '2026-02-18 04:46:02', '2026-02-18 04:46:38'),
(89, 12, 2, '2026-02-22', '01:35:14 PM', '23.773184', '90.3872512', NULL, NULL, NULL, NULL, NULL, '2026-02-22 07:35:14', '2026-02-22 07:35:14'),
(95, 4, 1, '2026-03-03', '02:27:24 PM', '23.7895724', '90.3925039', NULL, NULL, NULL, NULL, NULL, '2026-03-03 08:27:25', '2026-03-03 08:27:25'),
(114, 1, 1, '2026-03-05', '11:45:38 AM', '23.7842136', '90.392908', 'House#286, Road#Road No 19/C, Kafrul, Dhaka', '11:51:46 AM', '40.7568384', '-73.924608', 'House#35-11, Road#35th Avenue, Queens', '2026-03-05 05:45:40', '2026-03-05 05:51:46'),
(116, 12, 2, '2026-03-05', '02:13:50 PM', '40.7568384', '-73.924608', 'House#35-11, Road#35th Avenue, Queens', '02:14:34 PM', '23.7842118', '90.3928969', 'House#286, Road#Road No 19/C, Kafrul, Dhaka', '2026-03-05 08:13:50', '2026-03-05 08:14:34'),
(117, 13, 2, '2026-03-05', '02:15:09 PM', '40.7568384', '-73.924608', 'House#35-11, Road#35th Avenue, Queens', '02:15:23 PM', '23.7842247', '90.3928997', 'House#287, Road#Road No 19, Kafrul, Dhaka', '2026-03-05 08:15:09', '2026-03-05 08:15:23'),
(133, 4, 1, '2026-04-01', '01:06:59 PM', '23.7769224', '90.3860279', 'Q9GP+QC Dhaka, Bangladesh', '01:07:20 PM', '23.7764608', '90.390528', 'Kafrul, Dhaka', '2026-04-01 07:07:00', '2026-04-01 07:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('hrm-cache-address_23.7746494_90.4025143', 's:5:\"Dhaka\";', 1775200484),
('hrm-cache-address_23.7753931_90.4025143', 's:32:\"QCG2+4VW, Dhaka 1212, Bangladesh\";', 1775290795),
('hrm-cache-address_23.7764608_90.390528', 's:13:\"Kafrul, Dhaka\";', 1777619239),
('hrm-cache-address_23.7769224_90.3860279', 's:25:\"Q9GP+QC Dhaka, Bangladesh\";', 1777619220),
('hrm-cache-address_23.7806365_90.4064505', 'N;', 1775197587),
('hrm-cache-address_23.7841839_90.3928951', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1777618486),
('hrm-cache-address_23.7841915_90.392877', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1775281843),
('hrm-cache-address_23.7841985_90.3928686', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1775802039),
('hrm-cache-address_23.784205_90.3929095', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1775280454),
('hrm-cache-address_23.7842077_90.3928854', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1775800464),
('hrm-cache-address_23.7842118_90.3928969', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1775290472),
('hrm-cache-address_23.7842136_90.392908', 's:43:\"House#286, Road#Road No 19/C, Kafrul, Dhaka\";', 1775281539),
('hrm-cache-address_23.7842247_90.3928997', 's:41:\"House#287, Road#Road No 19, Kafrul, Dhaka\";', 1775290522),
('hrm-cache-address_23.7895724_90.3925039', 'N;', 1775118445),
('hrm-cache-address_23.791017_90.4001587', 'N;', 1775196572),
('hrm-cache-address_40.7568384_-73.924608', 's:37:\"House#35-11, Road#35th Avenue, Queens\";', 1775201017),
('hrm-cache-address_40.7601152_-73.9180544', 's:41:\"House#31-52, Road#Steinway Street, Queens\";', 1777614788);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-09-11 04:05:35', '2025-09-17 00:49:23'),
(2, 'Management', '2025-09-11 04:07:24', '2025-09-11 04:07:24'),
(3, 'Accounts', '2025-09-11 04:07:43', '2025-09-11 04:07:43'),
(4, 'Software', '2025-09-11 04:08:06', '2025-09-11 04:08:06'),
(5, 'IT (Hardware+Network)', '2025-09-11 04:08:16', '2025-09-14 02:23:40'),
(7, 'Printing', '2025-09-14 02:22:11', '2025-09-14 02:23:08'),
(9, 'Delivery', '2025-09-15 03:35:32', '2025-09-15 03:35:32'),
(10, 'DNCC Zone', '2026-01-08 05:46:06', '2026-01-08 05:46:06'),
(11, 'CCC Sector', '2026-01-18 05:17:09', '2026-01-18 05:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hourly_work_updates`
--

CREATE TABLE `hourly_work_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `t9_10` text DEFAULT NULL,
  `t10_11` text DEFAULT NULL,
  `t11_12` text DEFAULT NULL,
  `t12_1` text DEFAULT NULL,
  `t1_2` text DEFAULT NULL,
  `t2_3` text DEFAULT NULL,
  `t3_4` text DEFAULT NULL,
  `t4_5` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hourly_work_updates`
--

INSERT INTO `hourly_work_updates` (`id`, `employee_id`, `date`, `t9_10`, `t10_11`, `t11_12`, `t12_1`, `t1_2`, `t2_3`, `t3_4`, `t4_5`, `created_at`, `updated_at`) VALUES
(1, 4, '2025-10-20', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Breakfast Break</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Finding Last Date of Filling Attendee Data on Database (Sanjay Sir\'s Project)</p>', '2025-10-21 09:51:59', '2025-10-21 10:16:27'),
(2, 4, '2025-10-21', '<p>1. Download Image from Server</p><p>2. Delete Image from Server</p><p>3. Optimize RK Courier Server</p><p>4. Breakfast Break</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-21 10:23:14', '2025-10-21 10:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type` bigint(20) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `total_day` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `application` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `leave_type`, `from_date`, `to_date`, `total_day`, `status`, `approved_by`, `application`, `comment`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2025-09-22', '2025-09-22', '1', 'Rejected', 1, '<p>21st September, 2025</p><p>The Chairman<br>RK Software BD Ltd.<br>New&nbsp; DOHS, Mohakhali, Dhaka.<br>Subject: Application for leave in advance.</p><p><br></p>', NULL, '2025-09-21 02:52:27', '2025-09-24 01:10:40'),
(2, 4, 1, '2024-09-22', '2024-09-22', '1', 'Approved', 1, '<p>21st September, 2025</p><p>The Chairman<br>RK Software BD Ltd.<br>New&nbsp; DOHS, Mohakhali, Dhaka.<br>Subject: Application for leave in advance.</p><p><br></p>', NULL, '2025-09-21 04:50:17', '2025-09-21 04:50:17'),
(3, 4, 5, '2025-09-29', '2025-09-30', '2', 'Rejected', 1, '<p>21st September, 2025</p><p>The Chairman<br>RK Software BD Ltd.<br>New&nbsp; DOHS, Mohakhali, Dhaka.<br>Subject: Application for leave in advance.</p><p><br></p>', NULL, '2025-09-21 02:56:47', '2026-01-07 06:50:27'),
(4, 4, 5, '2025-09-29', '2025-09-30', '2', 'Approved', 1, '<p>21st September, 2025</p><p>The Chairman<br>RK Software BD Ltd.<br>New&nbsp; DOHS, Mohakhali, Dhaka.<br>Subject: Application for leave in advance.</p><p>Sir,<br>I beg most respectfully to state that, I am Sanjoy Dey an employee of your organization. I need leave from 29-09-2025 to 30-09-2025 due to Durga Puja.</p><p>I, therefore, pray and hope that you will grant my leave in advance and oblige thereby.</p><p>I remain<br>Sir,<br>Your most obedient employee</p><p>Sanjoy Dey<br>Mobile: 01675845344</p><p><br></p>', NULL, '2025-09-21 04:36:55', '2026-01-07 04:38:36'),
(7, 12, 1, '2026-02-23', '2026-02-24', '2', 'Approved', 1, '<p>21st September, 2025<br>\r\nThe Chairman<br>\r\nRK Software BD Ltd.<br>\r\nNew&nbsp; DOHS, Mohakhali, Dhaka.<br>\r\nSubject: Application for leave in advance.<br><br>\r\nSir,<br>\r\n\r\n<br>\r\nI beg most respectfully to state that, I am Sanjoy Dey an employee of your organization. I need leave from 27-01-2026 to 29-01-2026.<br><br>\r\nI, therefore, pray and hope that you will grant my leave in advance and oblige thereby.<br><br>\r\nI remain<br>\r\nSir,<br>\r\nYour most obedient employee<br><br>Zone1<br>\r\nMobile: 01675845344</p>', NULL, '2026-01-26 03:25:38', '2026-01-26 03:25:56'),
(9, 9, 1, '2026-02-18', '2026-02-19', '2', 'Approved', 1, 'Application', NULL, '2026-02-18 03:44:24', '2026-02-18 03:44:45'),
(11, 4, 1, '2026-03-04', '2026-03-04', '1', 'Rejected', 1, '<p>25th February, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am [NAME HERE], an employee of your company, RK Software (Bangladesh) Limited. My designation is [DESIGNATION HERE]. I have an occasion in my house on 26/02/2026. That\'s why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>[NAME HERE]<br>[DESIGNATION HERE]</p><br>', 'Application format is not correct.', '2026-02-25 05:13:53', '2026-03-30 05:52:19'),
(20, 4, 2, '2026-04-01', '2026-04-01', '0', 'Approved', 1, '<p>1st April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Sanjoy Dey, an employee of your company, RK Software (Bangladesh) Limited. My designation is Project Manager. I have an occasion in my house on 26/02/2026. That\'s why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Sanjoy Dey<br>Project Manager<br>Mobile: 01675845344</p><br>', NULL, '2026-04-01 06:50:56', '2026-04-01 06:52:06'),
(21, 1, 2, '2026-04-01', '2026-04-01', '0', 'Approved', 1, '<p>1st April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Bivas Mondol, an employee of your company, RK Software (Bangladesh) Limited. My designation is HR & Admin. I have an occasion in my house on 26/02/2026. That\'s why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Bivas Mondol<br>HR & Admin<br>Mobile: 01915945110</p><br>', NULL, '2026-04-01 07:47:29', '2026-04-01 07:47:54'),
(22, 9, 1, '2026-04-01', '2026-04-01', '0', 'Approved', 1, '<p>1st April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Syed Mohammad Sohel Parveg Miah, an employee of your company, RK Software (Bangladesh) Limited. My designation is General Manager. I have an occasion in my house on 26/02/2026. That\'s why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Syed Mohammad Sohel Parveg Miah<br>General Manager<br>Mobile: 01700000014</p><br>', NULL, '2026-04-01 08:39:52', '2026-04-01 08:40:20'),
(23, 1, 1, '2026-04-01', '2026-04-01', '0', 'Approved', 1, 'Application submited earlier. Manually approved by admin.', 'Leave approved for 1 hour', '2026-04-01 10:43:05', '2026-04-01 10:43:05'),
(26, 4, 2, '2026-04-06', '2026-04-06', '0', 'Applied', NULL, '<p>6th April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Sanjoy Dey, an employee of your company, RK Software (Bangladesh) Limited. My designation is Project Manager. I have an occasion in my house on 26/02/2026. That\'s why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Sanjoy Dey<br>Project Manager<br>Mobile: 01675845344</p><br>', NULL, '2026-04-06 07:12:35', '2026-04-06 08:03:20'),
(27, 4, 3, '2026-04-06', '2026-04-06', '1', 'Approved', 1, '<p>6th April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Sanjoy Dey, an employee of your company, RK Software (Bangladesh) Limited. My designation is Project Manager. I have an occasion in my house on 26/02/2026. That\'s why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Sanjoy Dey<br>Project Manager<br>Mobile: 01675845344</p><br>', NULL, '2026-04-06 08:21:15', '2026-04-06 08:21:31'),
(28, 4, 6, '2026-04-07', '2026-04-07', '0', 'Approved', 1, '<p>7th April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: </p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Sanjoy Dey, an employee of your company, RK Software (Bangladesh) Limited. My designation is Project Manager.</p><p>I, therefore, pray and hope that you will consider my case and oblige thereby.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Sanjoy Dey<br>Project Manager<br>Mobile: 01675845344</p><br>', NULL, '2026-04-07 05:11:13', '2026-04-07 05:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `leave_attachments`
--

CREATE TABLE `leave_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_attachments`
--

INSERT INTO `leave_attachments` (`id`, `leave_id`, `file_name`, `file_path`, `file_type`, `file_size`, `created_at`, `updated_at`) VALUES
(4, 26, 'strandberg-j-artisan-7-07.jpg', 'leave_attachments/26/1775459555_69d35ce3d0c2e_strandberg-j-artisan-7-07.jpg', 'image/jpeg', 439093, '2026-04-06 07:12:35', '2026-04-06 07:12:35');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `leave_name`, `created_at`, `updated_at`) VALUES
(1, 'Casual Leave', '2025-09-11 04:48:19', '2025-09-17 00:49:39'),
(2, 'Sick Leave', '2025-09-11 04:48:45', '2025-09-14 02:07:21'),
(3, 'Earned Leave', '2025-09-11 04:49:05', '2025-09-11 04:49:05'),
(5, 'Special Leave', '2025-09-14 00:53:51', '2025-09-14 00:53:51'),
(6, 'General Application', '2026-04-07 05:08:49', '2026-04-07 05:08:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_11_084426_create_departments_table', 2),
(5, '2025_09_11_084606_create_leave_types_table', 2),
(7, '2025_09_16_045312_create_notices_table', 4),
(16, '2025_09_21_062530_create_leaves_table', 7),
(17, '2025_09_18_040936_create_projects_table', 8),
(19, '2025_10_06_091413_create_attendances_table', 9),
(20, '2025_09_17_040517_create_warnings_table', 10),
(22, '2025_10_08_132629_create_promotions_table', 11),
(23, '2025_10_08_162455_create_salaries_table', 12),
(24, '2025_10_14_123618_create_monthly_salary_sheets_table', 13),
(25, '2025_10_20_163540_create_hourly_work_updates_table', 14),
(26, '2025_10_22_122239_create_noc_types_table', 15),
(31, '2025_10_22_163013_create_nocs_table', 16),
(32, '2025_10_23_150732_create_appointment_letters_table', 17),
(33, '2025_10_29_124329_create_resigns_table', 18),
(34, '2026_01_18_095918_create_offices_table', 19),
(36, '2026_02_22_111312_create_notice_user_table', 20),
(37, '2026_03_29_102221_create_noc_applications_table', 21),
(38, '2026_03_31_113105_create_project_comments_table', 22),
(39, '2026_04_06_122103_create_leave_attachments_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_salary_sheets`
--

CREATE TABLE `monthly_salary_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `bonus` varchar(255) DEFAULT NULL,
  `performance_bonus` varchar(255) DEFAULT NULL,
  `other_add` varchar(255) DEFAULT NULL,
  `advance` varchar(255) DEFAULT NULL,
  `ait` varchar(255) DEFAULT NULL,
  `revenue_stamp` varchar(255) DEFAULT NULL,
  `late_attendance` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `total_paid` varchar(255) NOT NULL,
  `date_of_payment` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthly_salary_sheets`
--

INSERT INTO `monthly_salary_sheets` (`id`, `employee_id`, `month`, `year`, `salary`, `bonus`, `performance_bonus`, `other_add`, `advance`, `ait`, `revenue_stamp`, `late_attendance`, `other`, `total_paid`, `date_of_payment`, `created_at`, `updated_at`) VALUES
(1, 4, 'September', '2024', '25000', '0', '0', '0', '0', '0', '10', '0', '0', '24990', '2025-10-01', '2025-10-14 09:30:08', '2025-10-14 09:30:08'),
(2, 7, 'September', '2025', '15000', '0', '0', '0', '0', '0', '10', '0', '0', '14990', '2025-10-01', '2025-10-14 09:31:24', '2025-10-14 09:31:24'),
(3, 4, 'October', '2025', '25000', '0', '0', '0', '0', '0', '10', '0', '0', '24990', '2025-10-06', '2025-10-20 04:37:54', '2025-10-20 04:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `nocs`
--

CREATE TABLE `nocs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `noc_type` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `salutation` varchar(255) NOT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nocs`
--

INSERT INTO `nocs` (`id`, `employee_id`, `noc_type`, `date`, `from_date`, `to_date`, `salutation`, `passport`, `country`, `reason`, `created_at`, `updated_at`) VALUES
(8, 4, 4, '2026-04-02', NULL, NULL, 'He', 'A123456', 'India', 'medical purpose', '2026-04-02 04:10:21', '2026-04-02 04:10:21'),
(9, 4, 2, '2026-04-02', '2026-04-09', '2026-04-16', 'He', 'A123456', 'India', 'travel purpose', '2026-04-02 04:23:23', '2026-04-02 04:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `noc_applications`
--

CREATE TABLE `noc_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `application` text DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `noc_applications`
--

INSERT INTO `noc_applications` (`id`, `employee_id`, `application`, `status`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 4, '<p>29th March, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for No Objection Certificate (NOC).</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Sanjoy Dey, an employee of your company, RK Software (Bangladesh) Limited. My designation is Project Manager. I want to apply for a passport. That\'s why I need a No Objection Certificate.</p><p>I, therefore, pray and hope that you will consider my case and provide me a No Objection Certificate.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Sanjoy Dey<br>Project Manager</p><br>', 'Approved', 1, '2026-03-29 04:59:57', '2026-03-29 06:10:19'),
(2, 7, '<p>29th March, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for No Objection Certificate (NOC).</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Polash Mondol, an employee of your company, RK Software (Bangladesh) Limited. My designation is Deliveryman. I want to apply for a passport. That\'s why I need a No Objection Certificate.</p><p>I, therefore, pray and hope that you will consider my case and provide me a No Objection Certificate.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Polash Mondol<br>Deliveryman</p><br>', 'Rejected', 1, '2026-03-29 05:50:58', '2026-03-29 05:59:49'),
(5, 1, '<p>1st April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for No Objection Certificate (NOC).</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Bivas Mondol, an employee of your company, RK Software (Bangladesh) Limited. My designation is HR & Admin. I want to apply for a passport. That\'s why I need a No Objection Certificate.</p><p>I, therefore, pray and hope that you will consider my case and provide me a No Objection Certificate.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Bivas Mondol<br>HR & Admin<br>Mobile: 01915945110</p><br>', 'Approved', 1, '2026-04-01 04:57:09', '2026-04-01 05:09:21'),
(6, 9, '<p>1st April, 2026</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for No Objection Certificate (NOC).</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am Syed Mohammad Sohel Parveg Miah, an employee of your company, RK Software (Bangladesh) Limited. My designation is General Manager. I want to apply for a passport. That\'s why I need a No Objection Certificate.</p><p>I, therefore, pray and hope that you will consider my case and provide me a No Objection Certificate.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>Syed Mohammad Sohel Parveg Miah<br>General Manager<br>Mobile: 01700000014</p><br>', 'Approved', 1, '2026-04-01 09:47:00', '2026-04-01 09:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `noc_types`
--

CREATE TABLE `noc_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `noc_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `noc_types`
--

INSERT INTO `noc_types` (`id`, `noc_name`, `created_at`, `updated_at`) VALUES
(2, 'Travel', '2025-10-22 07:28:21', '2025-10-22 09:53:10'),
(3, 'Passport', '2025-10-23 05:37:22', '2025-10-23 05:37:22'),
(4, 'Visa', '2025-10-23 05:37:34', '2025-10-23 05:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `expire_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `message`, `date`, `expire_date`, `created_at`, `updated_at`) VALUES
(6, '7202 Trade Licence Delivered!', '<p>Hello All, Greetings.</p><p>This is to notify that we are running our Trade Licence Delivery Software without any bug.<br>We have already delivered <b><font color=\"#6ba54a\">7159</font></b> trade licences through our software.</p><p>Regards,</p><p><b>Bivas Mondol</b><br>HR and Admin</p>', '2025-09-10', '0000-00-00', '2025-09-16 02:51:21', '2025-09-16 22:13:47'),
(7, 'General Holiday', '<p>Dear All,<br>Our office will remain close on 26th October for general purpose.</p>', '2026-02-22', '2026-02-23', '2025-10-23 07:59:36', '2025-10-23 07:59:36'),
(8, 'Holiday', 'Test', '2026-02-22', '2026-02-22', '2026-01-07 03:43:16', '2026-01-07 03:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `notice_user`
--

CREATE TABLE `notice_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notice_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notice_user`
--

INSERT INTO `notice_user` (`id`, `notice_id`, `user_id`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 8, 7, '2026-02-22 05:49:42', '2026-02-22 05:49:42', '2026-02-22 05:49:42'),
(2, 8, 1, '2026-02-22 06:04:26', '2026-02-22 06:04:26', '2026-02-22 06:04:26'),
(3, 8, 9, '2026-02-22 06:13:03', '2026-02-22 06:13:03', '2026-02-22 06:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'HQ', '2026-01-18 04:50:03', '2026-01-18 04:50:03'),
(2, 'DNCC', '2026-01-18 05:10:36', '2026-01-18 05:10:36'),
(3, 'CCC', '2026-01-18 05:10:46', '2026-01-18 05:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_details` text NOT NULL,
  `employee` bigint(20) UNSIGNED NOT NULL,
  `employer` bigint(20) UNSIGNED NOT NULL,
  `assign_date` date NOT NULL,
  `deadline` date NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `progress` varchar(255) DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_details`, `employee`, `employer`, `assign_date`, `deadline`, `status`, `progress`, `submission_date`, `created_at`, `updated_at`) VALUES
(9, 'Reconcilation', '<p>Reconcilation Software</p>', 8, 9, '2026-01-20', '2026-01-30', 'Assigned', '0', NULL, '2026-01-20 10:05:32', '2026-01-20 10:05:32'),
(12, 'Project Name', '<p>sfgdfhdf bhfthb</p>', 4, 1, '2026-03-31', '2026-03-31', 'Assigned', '0', NULL, '2026-03-31 06:34:04', '2026-03-31 08:10:34');

-- --------------------------------------------------------

--
-- Table structure for table `project_comments`
--

CREATE TABLE `project_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_type` varchar(255) NOT NULL,
  `department` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) NOT NULL,
  `total_salary` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `employee_id`, `promotion_type`, `department`, `designation`, `total_salary`, `date`, `comment`, `created_at`, `updated_at`) VALUES
(8, 4, 'Promotion', 4, 'Sr. Programmer', '26000', '2025-12-22', 'Excellent Performance', '2025-10-20 09:11:52', '2025-10-20 09:11:52'),
(9, 7, 'Promotion', 9, 'Sr. Deliveryman', '16000', '2025-10-20', 'Excellent Performance.', '2025-10-20 09:12:24', '2025-10-20 09:12:24'),
(11, 7, 'Demotion', 9, 'Deliveryman', '15000', '2025-10-20', NULL, '2025-10-20 09:42:06', '2025-10-20 09:42:06'),
(12, 4, 'Promotion', 4, 'Project Manager', '27000', '2026-01-11', 'Brilliant Performance', '2025-10-20 09:42:51', '2025-10-20 09:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `resigns`
--

CREATE TABLE `resigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `basic` varchar(255) DEFAULT NULL,
  `house_rent` varchar(255) DEFAULT NULL,
  `convenience` varchar(255) DEFAULT NULL,
  `medical` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `employee_id`, `basic`, `house_rent`, `convenience`, `medical`, `total`, `created_at`, `updated_at`) VALUES
(4, 4, '14063', '7032', '2500', '1405', '25000', '2026-01-27 04:37:04', '2026-01-27 04:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('xlBv8XoU7BWC67GflKEcMQFvRdtWU2dlFpgRLpo7', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWMzbzlIMkFQcERxNmxRazRHM3JPWGNPWkoxd1VZYXpaUTR4aHk2QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS9wcm9qZWN0LzEyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775546665);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `role` enum('admin','army','management','employee') NOT NULL DEFAULT 'employee',
  `status` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `resigning_date` date DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `emergency_person` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `department` bigint(20) UNSIGNED DEFAULT NULL,
  `office` bigint(20) UNSIGNED DEFAULT NULL,
  `educational_qualification` text DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `joined_as` varchar(255) DEFAULT NULL,
  `starting_salary` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `dob`, `blood_group`, `gender`, `mobile`, `nid`, `role`, `status`, `address`, `image`, `joining_date`, `resigning_date`, `emergency_contact`, `emergency_person`, `relation`, `department`, `office`, `educational_qualification`, `experience`, `designation`, `joined_as`, `starting_salary`, `account_no`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bivas Mondol', 'admin@gmail.com', '$2y$12$GHKuuWu.dDA.cR/UrJIXU.6RVuCOEPWr1/gnDAONNIs9lMKgnRcny', '1960-11-07', 'A-', 'male', '01915945110', '1234567890', 'admin', 'active', 'H#286, R#19/C, New DOHS, Mohakhali, Dhaka', 'profiles/6Aq3xl7o7b3MRbRQMN8xSG5gvRWmL3NAeXEJi4LO.jpg', NULL, NULL, '01915945112', 'Mrs Mondol', 'Wife', 1, 1, NULL, NULL, 'HR & Admin', 'HR & Admin', '50000', '12345678907', NULL, NULL, '2025-09-10 02:32:40', '2026-03-08 08:49:05'),
(4, 'Sanjoy Dey', 'sanjoydey.cse@gmail.com', '$2y$12$hWWfwX3t.1Vxjz6YlyDku.L/LZcFNRoAzEJbhjY/Cns0Z9TttCibi', '1993-11-10', 'B+', 'male', '01675845344', '0987654321', 'employee', 'active', NULL, 'profiles/sgVCIqwoHlkiu08uWlMMcFvd8y4DHE5drAuSZtN5.jpg', '2025-03-02', NULL, '01843282462', 'Kona Ghosh', 'Wife', 4, 1, NULL, NULL, 'Project Manager', 'Programmer', '25000', '7022-0311068243', NULL, NULL, '2025-09-14 03:47:30', '2026-03-02 07:01:14'),
(7, 'Polash Mondol', 'polash@gmail.com', '$2y$12$i8TYZuehFbjKtufRdbYum.BgukKm3AgLnNyX44ljE/wrjoAoDuY4K', '1999-09-17', NULL, 'male', '01900000001', '0000000001', 'employee', 'active', NULL, NULL, '2025-06-01', NULL, '01800000001', 'Jhuma Moldol', 'Mother', 9, 1, NULL, NULL, 'Deliveryman', 'Deliveryman', '15000', NULL, NULL, NULL, '2025-09-16 23:56:13', '2025-10-20 09:42:05'),
(8, 'Mahmuda Mim', 'mahmuda@gmail.com', '$2y$12$iclgosyVo4eA8OKwIfzxNOlkveSrC4tOyKnqIm9X7Nm150c6rBzs2', '1998-10-13', NULL, 'female', '01912334488', '5522336699', 'employee', 'active', NULL, NULL, '2025-03-02', NULL, '01800000002', 'Jahanara Akter', 'Mother', 4, 1, NULL, NULL, 'Jr. Programmer', 'Jr. Programmer', '20000', NULL, NULL, NULL, '2025-10-13 05:56:19', '2025-10-13 05:56:19'),
(9, 'Syed Mohammad Sohel Parveg Miah', 'sohel@gmail.com', '$2y$12$YMvpxwcOX8SX62YUFsh3muDD95qI5f7BLHv55CUXamSmcXu8vCkPu', '2025-10-07', 'A+', 'male', '01700000014', '1300000013', 'management', 'active', 'Kanchpur, Narayanganj', NULL, '2014-10-30', NULL, '01800000015', 'Mrs Parvez', 'Wife', 2, 1, NULL, NULL, 'General Manager', 'General Manager', '120000', NULL, NULL, NULL, '2025-10-28 08:27:52', '2026-02-18 07:34:22'),
(10, 'Anup Das Ripon', 'ripon@gmail.com', '$2y$12$YMvpxwcOX8SX62YUFsh3muDD95qI5f7BLHv55CUXamSmcXu8vCkPu', '2025-03-07', NULL, 'male', '0170000004', '0000000014', 'admin', 'active', NULL, NULL, '2014-10-30', NULL, '01800000014', 'Mrs Ripon', 'Wife', 3, 1, NULL, NULL, 'Head of Admin and Finance', 'Head of Admin and Finance', '100000', NULL, NULL, NULL, '2025-10-28 08:27:52', '2025-10-28 08:27:52'),
(11, 'Bangladesh Army', 'bdarmy@gmail.com', '$2y$12$GHKuuWu.dDA.cR/UrJIXU.6RVuCOEPWr1/gnDAONNIs9lMKgnRcny', '1971-03-26', NULL, 'male', '1234567890', '26031971', 'army', 'active', NULL, 'profiles/RmP2sVBoL8Tf588GsJUCazecTWTvA1t8UaGtcGor.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 06:08:02'),
(12, 'Zone-1', 'zone1@gmail.com', '$2y$12$2ueQeDuXCgqSGmPn2hPJt.izRbYFYqK5wr5tUZp3Z/an2YflDJSmK', '2026-10-08', NULL, 'male', '11111111111', '11111111111', 'employee', 'active', NULL, NULL, '2026-01-08', NULL, '12121212121', 'Zone-1 Contact', 'Relation', 10, 2, NULL, NULL, 'Zone Supervisor', 'Zone Supervisor', '20000', NULL, NULL, NULL, '2026-01-08 05:47:34', '2026-01-08 05:47:34'),
(13, 'Zone-2', 'zone2@gmail.com', '$2y$12$DMAVJOX49EfEkE.YARqGJem.cHGXCS/MmCDmhsHa9PqIrgtrkiefC', '2026-05-10', NULL, 'female', '22222222222', '22222222222', 'employee', 'active', NULL, NULL, '2026-01-08', NULL, '12121212121', 'Zone-2 Contact', 'Relation', 10, 2, NULL, NULL, 'Zone Supervisor', 'Zone Supervisor', '20000', NULL, NULL, NULL, '2026-01-08 05:48:39', '2026-01-08 05:48:39'),
(14, 'Md. Habibur Rahman', 'habibursahad@gmail.com', '$2y$12$nl1.t6789ck.ZDXi.2Di9ejrvURLhMSstBH1oTlSTHvgXd4EQgYxe', '2000-02-02', NULL, 'male', '01823198563', '7364691845', 'employee', 'active', NULL, NULL, '2021-01-05', NULL, '01718090936', 'Md Al Amin', 'Father', 11, 3, NULL, NULL, 'Data Entry Operator', 'Data Entry Operator', '15000', NULL, NULL, NULL, '2026-01-18 05:19:26', '2026-01-18 05:19:26'),
(15, 'Zone-3', 'zone3@gmail.com', '$2y$12$ODE0eHFDgS6.54KQEpTw3.qV2sEaYATvl169oljMQl22mRV3Zd2ZK', '2026-01-21', NULL, 'male', '11111111115', '0000000016', 'employee', 'active', NULL, NULL, '2026-01-22', NULL, '12121212125', 'Zone-3 Contact', 'Own', 10, 2, NULL, NULL, 'Zone Supervisor', 'Zone Supervisor', '10000', NULL, NULL, NULL, '2026-01-22 06:43:56', '2026-01-22 06:43:56'),
(16, 'Zone-4', 'zone4@gmail.com', '$2y$12$TzdoAfhfQtFo5Mx5JOdG/ervdkMa6O4fkndsV6Wh5sJOI6cnU.Hrm', '2026-01-20', NULL, 'female', '01010123654', '1213354542', 'employee', 'active', NULL, NULL, '2026-01-22', NULL, '12121212165', 'Zone-4 Contact', 'Own', 10, 2, NULL, NULL, 'Zone Supervisor', 'Zone Supervisor', '10000', NULL, NULL, NULL, '2026-01-22 06:45:35', '2026-01-22 06:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `warnings`
--

CREATE TABLE `warnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `to_employee` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `mark_as_read` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warnings`
--

INSERT INTO `warnings` (`id`, `title`, `message`, `to_employee`, `date`, `mark_as_read`, `created_at`, `updated_at`) VALUES
(1, 'Leave Without Information', '<p>Hello Sanjoy, good morning.</p>', 4, '2025-10-08', '1', '2025-10-08 05:53:34', '2026-01-25 06:02:23'),
(2, 'Leave Without Information', '<p>Hello Polash, good morning.</p>', 7, '2025-10-08', '0', '2025-10-08 06:08:13', '2025-10-08 06:08:13'),
(3, 'fdhfh', '<p>fggjghkghdhd</p>', 4, '2026-01-25', '1', '2026-01-25 05:38:14', '2026-02-18 03:43:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_letters`
--
ALTER TABLE `appointment_letters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`employee_id`),
  ADD KEY `attendances_office` (`office`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hourly_work_updates`
--
ALTER TABLE `hourly_work_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hourly_work_updates_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_employee_id_foreign` (`employee_id`),
  ADD KEY `leaves_leave_type_foreign` (`leave_type`),
  ADD KEY `leaves_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `leave_attachments`
--
ALTER TABLE `leave_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_attachments_leave_id_foreign` (`leave_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_salary_sheets`
--
ALTER TABLE `monthly_salary_sheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monthly_salary_sheets_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `nocs`
--
ALTER TABLE `nocs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nocs_employee_id_foreign` (`employee_id`),
  ADD KEY `nocs_noc_type_foreign` (`noc_type`);

--
-- Indexes for table `noc_applications`
--
ALTER TABLE `noc_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `noc_applications_employee_id_foreign` (`employee_id`),
  ADD KEY `noc_applications_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `noc_types`
--
ALTER TABLE `noc_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_user`
--
ALTER TABLE `notice_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notice_user_notice_id_foreign` (`notice_id`),
  ADD KEY `notice_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_employee_foreign` (`employee`),
  ADD KEY `projects_employer_foreign` (`employer`);

--
-- Indexes for table `project_comments`
--
ALTER TABLE `project_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_comments_user_id_foreign` (`user_id`),
  ADD KEY `project_comments_project_id_created_at_index` (`project_id`,`created_at`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_employee_id_foreign` (`employee_id`),
  ADD KEY `promotions_department_foreign` (`department`);

--
-- Indexes for table `resigns`
--
ALTER TABLE `resigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resigns_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_nid_unique` (`nid`),
  ADD KEY `users_department_foreign` (`department`),
  ADD KEY `users_office_foreign` (`office`);

--
-- Indexes for table `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warnings_to_employee_foreign` (`to_employee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_letters`
--
ALTER TABLE `appointment_letters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hourly_work_updates`
--
ALTER TABLE `hourly_work_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `leave_attachments`
--
ALTER TABLE `leave_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `monthly_salary_sheets`
--
ALTER TABLE `monthly_salary_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nocs`
--
ALTER TABLE `nocs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `noc_applications`
--
ALTER TABLE `noc_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `noc_types`
--
ALTER TABLE `noc_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notice_user`
--
ALTER TABLE `notice_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `project_comments`
--
ALTER TABLE `project_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `resigns`
--
ALTER TABLE `resigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `warnings`
--
ALTER TABLE `warnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_office` FOREIGN KEY (`office`) REFERENCES `offices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hourly_work_updates`
--
ALTER TABLE `hourly_work_updates`
  ADD CONSTRAINT `hourly_work_updates_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_leave_type_foreign` FOREIGN KEY (`leave_type`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_attachments`
--
ALTER TABLE `leave_attachments`
  ADD CONSTRAINT `leave_attachments_leave_id_foreign` FOREIGN KEY (`leave_id`) REFERENCES `leaves` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `monthly_salary_sheets`
--
ALTER TABLE `monthly_salary_sheets`
  ADD CONSTRAINT `monthly_salary_sheets_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nocs`
--
ALTER TABLE `nocs`
  ADD CONSTRAINT `nocs_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nocs_noc_type_foreign` FOREIGN KEY (`noc_type`) REFERENCES `noc_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `noc_applications`
--
ALTER TABLE `noc_applications`
  ADD CONSTRAINT `noc_applications_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `noc_applications_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notice_user`
--
ALTER TABLE `notice_user`
  ADD CONSTRAINT `notice_user_notice_id_foreign` FOREIGN KEY (`notice_id`) REFERENCES `notices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notice_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_employee_foreign` FOREIGN KEY (`employee`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_employer_foreign` FOREIGN KEY (`employer`) REFERENCES `users` (`id`);

--
-- Constraints for table `project_comments`
--
ALTER TABLE `project_comments`
  ADD CONSTRAINT `project_comments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_department_foreign` FOREIGN KEY (`department`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resigns`
--
ALTER TABLE `resigns`
  ADD CONSTRAINT `resigns_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_foreign` FOREIGN KEY (`department`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_office_foreign` FOREIGN KEY (`office`) REFERENCES `offices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warnings`
--
ALTER TABLE `warnings`
  ADD CONSTRAINT `warnings_to_employee_foreign` FOREIGN KEY (`to_employee`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2026 at 05:41 AM
-- Server version: 11.7.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(1, 1, 'superadmin', '2026-08-21 12:02:12');

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'adminsuper@gmail.com', '$2y$12$fyszsnMUnMnoRSaVupfkd.9chCYa8XXOPxlqn/OEEg9lzQpKBnmm.', NULL, NULL, 0, '2026-09-23 09:42:10', '2026-08-21 11:59:25', '2026-09-23 09:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', NULL, '2026-08-21 09:47:22', 0),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'superadmin@gmail.com', NULL, '2026-08-21 12:03:29', 0),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-08-21 12:04:50', 1),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-08-21 17:42:21', 1),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-08-22 10:02:58', 1),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-08-26 11:43:22', 1),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-08-26 11:45:44', 1),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-08 11:04:02', 1),
(9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-08 11:10:59', 1),
(10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-08 11:18:45', 1),
(11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-08 19:43:55', 1),
(12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-08 20:18:35', 1),
(13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-09 09:53:08', 1),
(14, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-09 10:25:19', 1),
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-10 14:09:01', 1),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-10 14:12:42', 1),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-14 13:53:47', 1),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-15 18:32:46', 1),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-17 10:50:04', 1),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-17 14:32:23', 1),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 06:57:57', 1),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 07:12:44', 1),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 07:13:38', 1),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 07:15:47', 1),
(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 08:51:24', 1),
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 10:52:40', 1),
(27, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 11:26:31', 1),
(28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 11:36:46', 1),
(29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-18 11:50:42', 1),
(30, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-20 05:48:21', 1),
(31, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-21 09:22:53', 1),
(32, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-21 14:28:24', 1),
(33, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-22 09:38:25', 1),
(34, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-09-23 09:42:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factories`
--

CREATE TABLE `factories` (
  `id` int(9) NOT NULL,
  `name` varchar(31) NOT NULL,
  `uid` varchar(31) NOT NULL,
  `class` varchar(63) NOT NULL,
  `icon` varchar(31) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `logo` varchar(225) DEFAULT NULL,
  `school_name` varchar(225) DEFAULT 'SMK 1 Indonesia',
  `school_year` varchar(225) DEFAULT '2024/2025',
  `jam_masuk_limit` time DEFAULT '07:00:00',
  `jam_pulang_standard` time DEFAULT '14:00:00',
  `hari_kerja` varchar(30) DEFAULT '1,2,3,4,5',
  `copyright` varchar(225) DEFAULT '© 2025 All rights reserved.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `logo`, `school_name`, `school_year`, `jam_masuk_limit`, `jam_pulang_standard`, `hari_kerja`, `copyright`) VALUES
(1, NULL, 'SMK 1 Indonesia', '2024/2025', '07:00:00', '14:00:00', '1,2,3,4,5', '© 2025 All rights reserved.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(3043, '2023-08-18-000001', 'App\\Database\\Migrations\\CreateJurusanTable', 'default', 'App', 1787280711, 1),
(3044, '2023-08-18-000002', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1787280711, 1),
(3045, '2023-08-18-000003', 'App\\Database\\Migrations\\CreateDB', 'default', 'App', 1787280711, 1),
(3046, '2023-08-18-000004', 'App\\Database\\Migrations\\AddSuperadmin', 'default', 'App', 1787280711, 1),
(3047, '2024-07-24-083011', 'App\\Database\\Migrations\\GeneralSettings', 'default', 'App', 1787280711, 1),
(3048, '2025-12-23-000001', 'App\\Database\\Migrations\\AddRfidToSiswaGuru', 'default', 'App', 1787281210, 2),
(3049, '2025-12-23-000002', 'App\\Database\\Migrations\\AddWaliKelasToKelas', 'default', 'App', 1787284560, 3),
(3050, '2025-12-24-000001', 'App\\Database\\Migrations\\MigrateIsSuperadminToGroups', 'default', 'App', 1787284560, 3),
(3051, '2026-03-07-000001', 'App\\Database\\Migrations\\CreatePerizinanTable', 'default', 'App', 1787284560, 3),
(3052, '2026-03-07-000002', 'App\\Database\\Migrations\\AddLateSystemFields', 'default', 'App', 1787284560, 3),
(3053, '2026-03-07-000003', 'App\\Database\\Migrations\\CreateHariLiburTable', 'default', 'App', 1787284560, 3),
(3054, '2026-03-07-000004', 'App\\Database\\Migrations\\AddJamPulangStandard', 'default', 'App', 1787284560, 3),
(3055, '2026-03-07-000005', 'App\\Database\\Migrations\\AddGuruToPerizinan', 'default', 'App', 1787284560, 3),
(3056, '2026-03-07-000006', 'App\\Database\\Migrations\\CreateAuditLogsTable', 'default', 'App', 1787284560, 3),
(3057, '2026-06-17-000001', 'App\\Database\\Migrations\\AddWorkingDays', 'default', 'App', 1787284560, 3);

-- --------------------------------------------------------

--
-- Table structure for table `personel`
--

CREATE TABLE `personel` (
  `id` int(11) UNSIGNED NOT NULL,
  `nrp_nip` varchar(30) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `pangkat` varchar(50) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `satker` varchar(100) DEFAULT 'Bid TIK',
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `qr_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personel`
--

INSERT INTO `personel` (`id`, `nrp_nip`, `nama`, `pangkat`, `jabatan`, `satker`, `jenis_kelamin`, `qr_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1234567', 'Nayza Salma', 'KOMBES POL', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_1234567.png', '2026-09-10 18:18:42', '2026-09-22 11:05:09', NULL),
(3, '098', 'Nayza Salma', 'KOMPOL', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_098.png', '2026-09-10 18:34:00', '2026-09-22 11:05:09', NULL),
(4, '888', 'Nayza Salma', 'BRIPKA', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_888.png', '2026-09-10 18:38:09', '2026-09-17 11:31:00', '2026-09-17 11:31:00'),
(5, '111', 'awell', 'AKBP', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_111.png', NULL, NULL, NULL),
(7, '222', 'halo', 'KOMBES POL', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_222.png', '2026-09-10 20:26:18', '2026-09-22 11:05:09', NULL),
(8, '33', 'halo', 'KOMBES POL', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_33.png', '2026-09-10 20:31:13', '2026-09-10 20:31:19', '2026-09-10 20:31:19'),
(9, '555', 'caca', 'KOMBES POL', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_555.png', '2026-09-10 21:09:49', '2026-09-10 21:09:55', '2026-09-10 21:09:55'),
(10, '000', 'halo', 'AKBP', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_000.png', '2026-09-14 13:54:34', '2026-09-22 11:05:09', NULL),
(11, '999', 'nelsya', 'KOMPOL', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_999.png', '2026-09-17 11:04:37', '2026-09-22 11:05:09', NULL),
(12, '6666', 'Zahfarina', 'AKBP', NULL, 'Uryanduknis', 'L', 'uploads/qr_personel/qr_6666.png', '2026-09-18 07:17:44', '2026-09-22 11:05:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) UNSIGNED NOT NULL,
  `personel_id` int(11) UNSIGNED DEFAULT NULL,
  `waktu_masuk` datetime DEFAULT NULL,
  `waktu_pulang` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT 'HADIR',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `point_apel` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `personel_id`, `waktu_masuk`, `waktu_pulang`, `status`, `created_at`, `updated_at`, `point_apel`) VALUES
(19, 1, '2026-09-17 13:31:43', NULL, 'Hadir', '2026-09-17 13:31:43', '2026-09-17 13:31:43', '0'),
(21, 3, '2026-09-17 13:33:00', NULL, 'Izin', '2026-09-17 13:33:00', '2026-09-17 13:33:00', '0'),
(22, 5, '2026-09-17 13:33:00', NULL, 'Sakit', '2026-09-17 13:33:00', '2026-09-17 13:33:00', '0'),
(25, 5, '2026-09-18 11:27:40', NULL, 'CUTI', '2026-09-18 09:47:34', '2026-09-18 11:27:40', 'penting'),
(27, 10, '2026-09-18 11:27:40', NULL, 'HADIR', '2026-09-18 09:47:34', '2026-09-18 11:27:40', 'penting'),
(28, 11, '2026-09-18 11:27:40', NULL, 'HADIR', '2026-09-18 09:47:34', '2026-09-18 11:27:40', 'penting'),
(29, 12, '2026-09-18 11:27:40', NULL, 'DINAS', '2026-09-18 09:47:34', '2026-09-18 11:27:40', 'penting'),
(30, 3, '2026-09-18 11:27:40', NULL, 'DINAS', '2026-09-18 10:55:46', '2026-09-18 11:27:40', 'penting'),
(31, 1, '2026-09-18 11:27:40', NULL, 'HADIR', '2026-09-18 11:27:40', '2026-09-18 11:27:40', 'penting'),
(32, 7, '2026-09-18 11:27:40', NULL, 'HADIR', '2026-09-18 11:27:40', '2026-09-18 11:27:40', 'penting'),
(33, 1, '2026-09-21 09:32:03', NULL, 'HADIR', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(34, 3, '2026-09-21 09:32:03', NULL, 'DINAS', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(35, 5, '2026-09-21 09:32:03', NULL, 'LEPAS DINAS', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(36, 7, '2026-09-21 09:32:03', NULL, 'CUTI', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(37, 10, '2026-09-21 09:32:03', NULL, 'SAKIT', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(38, 11, '2026-09-21 09:32:03', NULL, 'HADIR', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(39, 12, '2026-09-21 09:32:03', NULL, 'HADIR', '2026-09-21 09:32:03', '2026-09-21 09:32:03', 'POENTINGG'),
(40, 1, '2026-09-22 11:31:38', NULL, 'Hadir', '2026-09-22 11:31:38', '2026-09-22 11:31:38', NULL),
(41, 1, '2026-09-23 09:55:08', NULL, 'Hadir', '2026-09-23 09:55:08', '2026-09-23 09:55:08', NULL),
(42, 5, '2026-09-23 10:29:20', '2026-09-23 10:36:30', 'Hadir', '2026-09-23 10:29:20', '2026-09-23 10:36:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_audit_logs`
--

CREATE TABLE `tb_audit_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `tabel` varchar(100) NOT NULL,
  `id_record` int(11) DEFAULT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `nuptk` varchar(24) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `unique_code` varchar(64) NOT NULL,
  `rfid_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_hari_libur`
--

CREATE TABLE `tb_hari_libur` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id` int(11) UNSIGNED NOT NULL,
  `jurusan` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'OTKP', NULL, NULL, NULL),
(3, 'BDP', NULL, NULL, NULL),
(4, 'AKL', NULL, NULL, NULL),
(5, 'RPL', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kehadiran`
--

CREATE TABLE `tb_kehadiran` (
  `id_kehadiran` int(11) NOT NULL,
  `kehadiran` enum('Hadir','Sakit','Izin','Tanpa keterangan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_kehadiran`
--

INSERT INTO `tb_kehadiran` (`id_kehadiran`, `kehadiran`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin'),
(4, 'Tanpa keterangan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `id_jurusan` int(11) UNSIGNED NOT NULL,
  `index_kelas` varchar(5) NOT NULL,
  `id_wali_kelas` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `tingkat`, `id_jurusan`, `index_kelas`, `id_wali_kelas`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'X', 2, 'A', NULL, NULL, NULL, NULL),
(3, 'X', 3, 'A', NULL, NULL, NULL, NULL),
(4, 'X', 4, 'A', NULL, NULL, NULL, NULL),
(5, 'X', 5, 'A', NULL, NULL, NULL, NULL),
(6, 'XI', 2, 'A', NULL, NULL, NULL, NULL),
(7, 'XI', 3, 'A', NULL, NULL, NULL, NULL),
(8, 'XI', 4, 'A', NULL, NULL, NULL, NULL),
(9, 'XI', 5, 'A', NULL, NULL, NULL, NULL),
(10, 'XII', 2, 'A', NULL, NULL, NULL, NULL),
(11, 'XII', 3, 'A', NULL, NULL, NULL, NULL),
(12, 'XII', 4, 'A', NULL, NULL, NULL, NULL),
(13, 'XII', 5, 'A', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_perizinan`
--

CREATE TABLE `tb_perizinan` (
  `id_perizinan` int(11) UNSIGNED NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tipe_izin` enum('Sakit','Izin') NOT NULL DEFAULT 'Sakit',
  `alasan` text DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `id_petugas` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi_guru`
--

CREATE TABLE `tb_presensi_guru` (
  `id_presensi` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi_siswa`
--

CREATE TABLE `tb_presensi_siswa` (
  `id_presensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `menit_keterlambatan` int(11) DEFAULT 0,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_presensi_siswa`
--

INSERT INTO `tb_presensi_siswa` (`id_presensi`, `id_siswa`, `id_kelas`, `tanggal`, `jam_masuk`, `jam_keluar`, `id_kehadiran`, `menit_keterlambatan`, `keterangan`) VALUES
(6, 3, 5, '2026-08-21', '14:11:49', '14:12:02', 1, 431, ''),
(7, 4, 5, '2026-08-21', '17:44:56', '17:45:04', 1, 644, ''),
(8, 4, 5, '2026-09-08', '11:24:04', NULL, 1, 264, 'Terlambat 264 menit');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(16) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `poin_pelanggaran` int(11) DEFAULT 0,
  `unique_code` varchar(64) NOT NULL,
  `rfid_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nis`, `nama_siswa`, `id_kelas`, `jenis_kelamin`, `no_hp`, `poin_pelanggaran`, `unique_code`, `rfid_code`) VALUES
(3, '123456', 'M.Setyo', 5, 'Perempuan', '08570628', 431, '6a87f72c622de5-62117207-78596912', '12345678'),
(4, '110906', 'Putri alifia Rahma', 5, 'Perempuan', '08571228', 908, '6a882bd2c748c2-60990970-74104811', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_guru`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'superadmin', NULL, NULL, 0, '2026-09-23 10:36:30', '2026-08-21 11:59:25', '2026-08-21 11:59:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `factories`
--
ALTER TABLE `factories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `uid` (`uid`),
  ADD KEY `deleted_at_id` (`deleted_at`,`id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nrp_nip` (`nrp_nip`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_audit_logs`
--
ALTER TABLE `tb_audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `unique_code` (`unique_code`),
  ADD KEY `idx_tb_guru_rfid_code` (`rfid_code`);

--
-- Indexes for table `tb_hari_libur`
--
ALTER TABLE `tb_hari_libur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indexes for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jurusan` (`jurusan`);

--
-- Indexes for table `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `tb_kelas_id_jurusan_foreign` (`id_jurusan`),
  ADD KEY `fk_tb_kelas_id_wali_kelas` (`id_wali_kelas`);

--
-- Indexes for table `tb_perizinan`
--
ALTER TABLE `tb_perizinan`
  ADD PRIMARY KEY (`id_perizinan`),
  ADD KEY `tb_perizinan_id_siswa_foreign` (`id_siswa`);

--
-- Indexes for table `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_kehadiran` (`id_kehadiran`);

--
-- Indexes for table `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_kehadiran` (`id_kehadiran`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `unique_code` (`unique_code`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `idx_tb_siswa_rfid_code` (`rfid_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_id_guru` (`id_guru`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `factories`
--
ALTER TABLE `factories`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3058;

--
-- AUTO_INCREMENT for table `personel`
--
ALTER TABLE `personel`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_audit_logs`
--
ALTER TABLE `tb_audit_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_hari_libur`
--
ALTER TABLE `tb_hari_libur`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_perizinan`
--
ALTER TABLE `tb_perizinan`
  MODIFY `id_perizinan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `fk_tb_kelas_id_wali_kelas` FOREIGN KEY (`id_wali_kelas`) REFERENCES `tb_guru` (`id_guru`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tb_kelas_id_jurusan_foreign` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tb_perizinan`
--
ALTER TABLE `tb_perizinan`
  ADD CONSTRAINT `tb_perizinan_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  ADD CONSTRAINT `tb_presensi_guru_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `tb_presensi_guru_id_kehadiran_foreign` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`) ON DELETE CASCADE;

--
-- Constraints for table `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  ADD CONSTRAINT `tb_presensi_siswa_id_kehadiran_foreign` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_presensi_siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `tb_presensi_siswa_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_id_guru` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

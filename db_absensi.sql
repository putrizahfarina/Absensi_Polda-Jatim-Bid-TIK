-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2026 at 06:05 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'adminsuper@gmail.com', '$2y$12$fyszsnMUnMnoRSaVupfkd.9chCYa8XXOPxlqn/OEEg9lzQpKBnmm.', NULL, NULL, 0, '2026-11-11 09:55:04', '2026-08-21 11:59:25', '2026-11-11 09:55:04');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-05 15:59:57', 1),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-05 18:52:12', 1),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-12 13:54:34', 1),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-13 12:18:57', 1),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-20 10:08:54', 1),
(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-20 10:13:09', 1),
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-23 13:40:51', 1),
(27, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-23 18:10:49', 1),
(28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-23 18:55:01', 1),
(29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-23 20:54:58', 1),
(30, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-24 07:26:26', 1),
(31, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-24 21:57:03', 1),
(32, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-26 10:13:29', 1),
(33, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-27 10:15:33', 1),
(34, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-27 10:15:44', 1),
(35, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-29 21:23:48', 1),
(36, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-31 19:21:12', 1),
(37, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.144.0 Chrome/150.0.7871.250 Electron/43.8.3 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-31 19:22:45', 1),
(38, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', NULL, '2026-10-31 19:23:36', 0),
(39, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-31 19:23:51', 1),
(40, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-10-31 19:45:38', 1),
(41, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-02 09:53:48', 1),
(42, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', NULL, '2026-11-04 10:03:32', 0),
(43, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', NULL, '2026-11-04 10:04:15', 0),
(44, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-04 10:05:31', 1),
(45, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-04 10:51:16', 1),
(46, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-04 11:39:10', 1),
(47, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-09 11:00:31', 1),
(48, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-09 11:09:58', 1),
(49, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-09 15:18:19', 1),
(50, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-10 10:16:47', 1),
(51, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'email_password', 'adminsuper@gmail.com', 1, '2026-11-11 09:55:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deskripsi_kegiatan`
--

CREATE TABLE `deskripsi_kegiatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `deskripsi_kegiatan`
--

INSERT INTO `deskripsi_kegiatan` (`id`, `tanggal`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, '2026-10-23', 'APEL PAGI \n1. TIDAK BOLEH IZIN \n2. HARUS HADIR TEPAT WAKTU \n3. KOMANDAN BERTANGGUNG JAWAB UNTUK ANGGOTANYA', '2026-10-23 22:29:41', '2026-10-23 22:40:35'),
(2, '2026-10-24', 'Apel Pagi', '2026-10-24 00:05:18', '2026-10-24 13:40:54'),
(3, '2026-10-27', 'apel pagi hari ini yang sangat mendung tidak mendukung', '2026-10-27 10:21:12', '2026-10-27 10:39:02'),
(4, '2026-11-04', '', '2026-11-04 10:54:44', '2026-11-04 12:39:46'),
(5, '2026-11-10', 'Hari ini upacara peringatan hari pahlawan', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(6, '2026-11-11', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(3057, '2026-06-17-000001', 'App\\Database\\Migrations\\AddWorkingDays', 'default', 'App', 1787284560, 3),
(3058, '2026-10-23-134444', 'App\\Database\\Migrations\\CreateDeskripsiKegiatan', 'default', 'App', 1792763185, 4);

-- --------------------------------------------------------

--
-- Table structure for table `personel`
--

CREATE TABLE `personel` (
  `id` int(11) UNSIGNED NOT NULL,
  `nrp_nip` varchar(30) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `pangkat` varchar(50) DEFAULT NULL,
  `subbid` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `ur` varchar(100) DEFAULT 'Bid TIK',
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `qr_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personel`
--

INSERT INTO `personel` (`id`, `nrp_nip`, `nama`, `pangkat`, `subbid`, `jabatan`, `ur`, `jenis_kelamin`, `qr_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(97, '69080576', 'Dra. YULIA AGUSTIN SELFA TRIANA, M.M.', 'KOMBES POL', 'KABID TIK', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_69080576.png', '2026-11-09 15:51:17', '2026-11-09 16:43:47', NULL),
(98, '71010446', 'ANDJAR SETIJANINGRUM, S.E.', 'AKBP', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_71010446.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(99, '70030469', 'Rr. ELIYA AYUNINGTYAS, S.H., M.M.', 'AKBP', 'SUBBAGRENMIN', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_70030469.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(100, '76060829', 'ZAINUDDIN WIRYO SUSENO, A.Md.', 'KOMPOL', 'SUBBIDTEKKOM', NULL, 'URHARKAN', 'L', 'uploads/qr_personel/qr_76060829.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(101, '68110302', 'ABDUL ROKIB, S.H., M.H', 'KOMPOL', 'SUBBIDTEKINFO', NULL, 'URPULLAHTA', 'L', 'uploads/qr_personel/qr_68110302.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(102, '86021583', 'ARIE TAUFAN BUDIMAN, S.I.K., M.I.K.', 'KOMPOL', 'SUBBIDTEKINFO', NULL, 'URINTI', 'L', 'uploads/qr_personel/qr_86021583.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(103, '71080169', 'MIFTAKHUL ARIF', 'IPTU', 'SUBBIDTEKKOM', NULL, 'URJARKOM', 'L', 'uploads/qr_personel/qr_71080169.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(104, '01081480', 'MARIA ALIN AGUSTIN PUSPASARI, S.Tr.K., M.H.', 'IPDA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_01081480.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(105, '84090733', 'SIMON LESTARI, S.H.', 'IPDA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_84090733.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(106, '78060331', 'EDY KURNIAWAN', 'IPDA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_78060331.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(107, '69060394', 'WAKIT', 'AIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_69060394.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(108, '76030217', 'SISWANDI', 'AIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_76030217.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(109, '79120452', 'ADE LISTIAWAN, S.H.', 'AIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_79120452.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(110, '80070566', 'ARIN WIDI KARTIKA', 'AIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_80070566.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(111, '80090933', 'NUR KHOLIS YASLI, A.Md.', 'AIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_80090933.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(112, '73030432', 'DANIEL RUMPOKO HADI', 'AIPDA', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_73030432.png', '2026-11-09 15:51:17', '2026-11-09 15:51:17', NULL),
(113, '83071126', 'SULTON ARIF', 'AIPDA', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_83071126.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(114, '86040548', 'ARISMA ROSDIANA', 'AIPDA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_86040548.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(115, '88080508', 'AGUSTIN NILA SARI, S.H.', 'BRIPKA', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_88080508.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(116, '91060103', 'FARIZAL LUTFI, S.H.', 'BRIPKA', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_91060103.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(117, '95041138', 'EDY SANTOSO, S.Kom', 'BRIGADIR', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_95041138.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(118, '96031034', 'EKKY DIMAS WAHYU PERDANA', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_96031034.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(119, '96080946', 'FAJAR WIRAWAN, S.Kom., M.M.', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_96080946.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(120, '99050111', 'YUDHA SANDHYANTORO, S.Kom.', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_99050111.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(121, '99050157', 'AHMAD HILMY BAIHAQY', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_99050157.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(122, '99040072', 'SITI HAJAR KHASIDIYAH', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_99040072.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(123, '98080618', 'DICKY AGUSTIAWAN, S.H.', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_98080618.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(124, '98100494', 'MUHAMMAD FAISAL RISDIANTO, S.H.', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_98100494.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(125, '99090436', 'SURYA AFANDI', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_99090436.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(126, '00050043', 'ADITYA DHARMAWAN, S.H.', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_00050043.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(127, '99020339', 'JOGI SUMARA HABEAHAN', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_99020339.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(128, '95011199', 'NURDIANA DWI SAFITRI, A.Md.', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_95011199.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(129, '00050817', 'MUHAMMAD RIVAL ARINALDY', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00050817.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(130, '00120645', 'FITRA DEA ANDI PRATAMA', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_00120645.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(131, '00110627', 'FADILATIL SALSA TRI RAMADAN', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00110627.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(132, '01110107', 'AKBAR FAJAR FAKTUROHMAN', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01110107.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(133, '01050466', 'MOCH RIZQI', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_01050466.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(134, '01080424', 'FERY SETYAWAN', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01080424.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(135, '00100434', 'INDRA ADITYA PAMUNGKAS', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00100434.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(136, '01030563', 'FANI AL BASRI', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_01030563.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(137, '01090164', 'MOCH. IFAN RIZKI PRATAMA', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01090164.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(138, '02020236', 'BAGAS DILY FIRMANSYAH', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_02020236.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(139, '01080450', 'DAFA ABIYYU SANTOSO', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01080450.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(140, '00010697', 'MUHAMMAD RAFLI HAIKAL AKBAR', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00010697.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(141, '01090335', 'KHOLID WALID', 'BRIPTU', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_01090335.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(142, '00090616', 'IQBAL KURNIAWAN SYAH PUTRA', 'BRIPTU', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00090616.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(143, '01040499', 'MUCHAMMAD NI\'AM BADRUZZAMAN', 'BRIPTU', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01040499.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(144, '03020299', 'RENDYKA BIMA BESTRADA', 'BRIPDA /', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_03020299.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(145, '03010134', 'VERO ANDREE ATMOKO', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_03010134.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(146, '02110477', 'SUGIARTO', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_02110477.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(147, '01010807', 'ODHI WIDYA PRATAMA', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01010807.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(148, '03060124', 'AMRI KEVIN SATRIA ANDHIKA', 'BRIPDA /', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_03060124.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(149, '03060255', 'MUHAMMAD FAJAR AFRIZAL', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_03060255.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(150, '00120929', 'MUHAMMAD ARIF PRATAMA', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00120929.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(151, '00110872', 'RIZQI ALWAN', 'BRIPDA /', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00110872.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(152, '02040409', 'DWI ARIYANTO', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_02040409.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(153, '00080919', 'VIKRY PRASETYO ADI', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_00080919.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(154, '01080635', 'AGUNG PRIAMBODO', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01080635.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(155, '02060574', 'ACHMAD ROFIQ HAMDANI', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_02060574.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(156, '03010377', 'VICKA NURULLAH EKA WICAKSONO', 'BRIPDA /', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_03010377.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(157, '02061054', 'LINTANG DWI SENTIKA', 'BRIPDA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_02061054.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(158, '01111415', 'NUR DWIKI SAPUTRA', 'BRIPDA', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_01111415.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(159, '05070102', 'MOCHAMMAD VERO SATRIA SUHANDA', 'BRIPDA', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_05070102.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(160, '02101945', 'ERICK RAMADHANI', 'BRIPDA', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_02101945.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(161, '03031706', 'ACHMAD GABRIEL VAVIAN NUGRAHA', 'BRIPDA', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_03031706.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(162, '04051089', 'ADIT MAYNDRA SAPUTRA', 'BRIPDA', 'SUBBIDTEKINFO', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_04051089.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(163, '197810072002122006', 'ERIK PUSPITA SARI, S.Kom, S.Psi.,M.H.', 'PEMBINA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_197810072002122006.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(164, '198704272009121001', 'RAHADITYA BIMANTORO, S.E M.Sc.', 'PEMBINA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_198704272009121001.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(165, '198104012009121001', 'ARIES FERDHITA HARIAWAN, S. Kom.', 'PEMBINA', 'SUBBIDTEKINFO', NULL, 'URYANDUKNIS', 'L', 'uploads/qr_personel/qr_198104012009121001.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(166, '197603182002121005', 'EDI SAPTANA, S.T.', 'PENATA TK. I', 'SUBBIDTEKKOM', NULL, 'URHARKAN', 'L', 'uploads/qr_personel/qr_197603182002121005.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(167, '198311132009121001', 'ARYANTO ARIBOWO, S.T, M.MT.', 'PENATA TK. I', 'SUBBIDTEKKOM', NULL, 'URYANKOM', 'L', 'uploads/qr_personel/qr_198311132009121001.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(168, '196908041999032001', 'ASRI WAHYUNI, S.Pd.', 'PENATA', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_196908041999032001.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(169, '198010242009102001', 'SULISTIANI,S.Sos', 'PENDA', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_198010242009102001.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(170, '196909092007012000.00', 'MUDRIKAH', 'PENGATUR TK. I', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_196909092007012000.00.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(171, '198307092014121004', 'RYO DEWANTORO, S.T.', 'PENGATUR', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_198307092014121004.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(172, '198209042025211010', 'CHOIRUL ANWAR', 'PPPK', 'SUBBAGRENMIN', NULL, 'URREN', 'L', 'uploads/qr_personel/qr_198209042025211010.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL),
(173, '197609112025211006', 'EDIE SUYITNO', 'PPPK', 'SUBBIDTEKKOM', NULL, 'URMINTU', 'L', 'uploads/qr_personel/qr_197609112025211006.png', '2026-11-09 15:51:18', '2026-11-09 15:51:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) UNSIGNED NOT NULL,
  `personel_id` int(11) UNSIGNED DEFAULT NULL,
  `waktu_masuk` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `personel_id`, `waktu_masuk`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(19, 1, '2026-09-17 13:31:43', 'Hadir', NULL, '2026-09-17 13:31:43', '2026-09-17 13:31:43'),
(21, 3, '2026-09-17 13:33:00', 'Izin', NULL, '2026-09-17 13:33:00', '2026-09-17 13:33:00'),
(22, 5, '2026-09-17 13:33:00', 'Sakit', NULL, '2026-09-17 13:33:00', '2026-09-17 13:33:00'),
(445, 1, '2026-10-12 21:02:42', 'Hadir', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(446, 3, '2026-10-12 21:02:42', 'Hadir', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(447, 5, '2026-10-12 21:02:42', 'Dinas Luar', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(448, 7, '2026-10-12 21:02:42', 'Sakit', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(449, 10, '2026-10-12 21:02:42', 'Hadir', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(450, 11, '2026-10-12 21:02:42', 'Hadir', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(451, 13, '2026-10-12 21:02:42', 'Hadir', '', '2026-10-12 21:02:42', '2026-10-12 21:02:42'),
(819, 1, '2026-10-13 17:04:41', 'Hadir', '', '2026-10-13 17:04:41', '2026-10-13 17:04:41'),
(820, 3, '2026-10-13 17:04:41', 'Hadir', '', '2026-10-13 17:04:41', '2026-10-13 17:04:41'),
(821, 5, '2026-10-13 17:04:41', 'Hadir', '', '2026-10-13 17:04:41', '2026-10-13 17:04:41'),
(822, 11, '2026-10-13 17:04:41', 'Hadir', '', '2026-10-13 17:04:41', '2026-10-13 17:04:41'),
(823, 12, '2026-10-13 17:04:41', 'Hadir', '', '2026-10-13 17:04:41', '2026-10-13 17:04:41'),
(824, 13, '2026-10-13 17:04:41', 'Hadir', '', '2026-10-13 17:04:41', '2026-10-13 17:04:41'),
(885, 1, '2026-10-20 13:15:34', 'Dinas Luar', 'dinas papua', '2026-10-20 13:15:34', '2026-10-20 13:15:34'),
(886, 3, '2026-10-20 13:15:34', 'Lepas Dinas', '', '2026-10-20 13:15:34', '2026-10-20 13:15:34'),
(887, 5, '2026-10-20 13:15:34', 'Hadir', '', '2026-10-20 13:15:34', '2026-10-20 13:15:34'),
(888, 11, '2026-10-20 13:15:34', 'Hadir', '', '2026-10-20 13:15:34', '2026-10-20 13:15:34'),
(889, 12, '2026-10-20 13:15:34', 'Hadir', '', '2026-10-20 13:15:34', '2026-10-20 13:15:34'),
(890, 13, '2026-10-20 13:15:34', 'Hadir', '', '2026-10-20 13:15:34', '2026-10-20 13:15:34'),
(921, 1, '2026-10-23 22:40:35', 'Hadir', '', '2026-10-23 22:40:35', '2026-10-23 22:40:35'),
(922, 3, '2026-10-23 22:40:35', 'Dinas Luar', 'dinas ke malang', '2026-10-23 22:40:35', '2026-10-23 22:40:35'),
(923, 5, '2026-10-23 22:40:35', 'Sakit', 'rawat inap demam 3 hari', '2026-10-23 22:40:35', '2026-10-23 22:40:35'),
(924, 11, '2026-10-23 22:40:35', 'Hadir', '', '2026-10-23 22:40:35', '2026-10-23 22:40:35'),
(925, 12, '2026-10-23 22:40:35', 'Hadir', '', '2026-10-23 22:40:35', '2026-10-23 22:40:35'),
(926, 13, '2026-10-23 22:40:35', 'Hadir', '', '2026-10-23 22:40:35', '2026-10-23 22:40:35'),
(940, 1, '2026-10-24 13:40:54', 'Hadir', '', '2026-10-24 13:40:54', '2026-10-24 13:40:54'),
(941, 5, '2026-10-24 13:40:54', 'Hadir', '', '2026-10-24 13:40:54', '2026-10-24 13:40:54'),
(942, 11, '2026-10-24 13:40:54', 'Lepas Dinas', 'lepas dinas 1 minggu', '2026-10-24 13:40:54', '2026-10-24 13:40:54'),
(943, 12, '2026-10-24 13:40:54', 'Cuti', 'cuti 2 hari', '2026-10-24 13:40:54', '2026-10-24 13:40:54'),
(944, 15, '2026-10-24 13:40:54', 'Hadir', '', '2026-10-24 13:40:54', '2026-10-24 13:40:54'),
(945, 16, '2026-10-24 13:40:54', 'Hadir', '', '2026-10-24 13:40:54', '2026-10-24 13:40:54'),
(946, 1, '2026-10-26 11:30:00', 'Hadir', NULL, '2026-10-26 11:30:00', '2026-10-26 11:30:00'),
(961, 1, '2026-10-27 10:39:02', 'Hadir', '', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(962, 5, '2026-10-27 10:39:02', 'Hadir', '', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(963, 11, '2026-10-27 10:39:02', 'Hadir', '', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(964, 12, '2026-10-27 10:39:02', 'Hadir', '', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(965, 15, '2026-10-27 10:39:02', 'Dinas Luar', 'dinas malang', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(966, 16, '2026-10-27 10:39:02', 'Sakit', 'demam', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(967, 17, '2026-10-27 10:39:02', 'Hadir', '', '2026-10-27 10:39:02', '2026-10-27 10:39:02'),
(973, 17, '2026-11-04 12:39:46', 'Sakit', 'di rumah sakit', '2026-11-04 12:39:46', '2026-11-04 12:39:46'),
(974, 22, '2026-11-04 12:39:46', 'Sakit', 'sakit', '2026-11-04 12:39:46', '2026-11-04 12:39:46'),
(975, 23, '2026-11-04 12:39:46', 'Hadir', '', '2026-11-04 12:39:46', '2026-11-04 12:39:46'),
(976, 97, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(977, 98, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(978, 99, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(979, 100, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(980, 101, '2026-11-10 10:19:35', 'Sakit', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(981, 102, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(982, 103, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(983, 104, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(984, 105, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(985, 106, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(986, 107, '2026-11-10 10:19:35', 'Dinas Luar', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(987, 108, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(988, 109, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(989, 110, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(990, 111, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(991, 112, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(992, 113, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(993, 114, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(994, 115, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(995, 116, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(996, 117, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(997, 118, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(998, 119, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(999, 120, '2026-11-10 10:19:35', 'Sakit', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1000, 121, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1001, 122, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1002, 123, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1003, 124, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1004, 125, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1005, 126, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1006, 127, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1007, 128, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1008, 129, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1009, 130, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1010, 131, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1011, 132, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1012, 133, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1013, 134, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1014, 135, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1015, 136, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1016, 137, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1017, 138, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1018, 139, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1019, 140, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1020, 141, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1021, 142, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1022, 143, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1023, 144, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1024, 145, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1025, 146, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1026, 147, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1027, 148, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1028, 149, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1029, 150, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1030, 151, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1031, 152, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1032, 153, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1033, 154, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1034, 155, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1035, 156, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1036, 157, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1037, 158, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1038, 159, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1039, 160, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1040, 161, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1041, 162, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1042, 163, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1043, 164, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1044, 165, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1045, 166, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1046, 167, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1047, 168, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1048, 169, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1049, 170, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1050, 171, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1051, 172, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1052, 173, '2026-11-10 10:19:35', 'Hadir', '', '2026-11-10 10:19:35', '2026-11-10 10:19:35'),
(1053, 97, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1054, 98, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1055, 99, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1056, 100, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1057, 101, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1058, 102, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1059, 103, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1060, 104, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1061, 105, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1062, 106, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1063, 107, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1064, 108, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1065, 109, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1066, 110, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1067, 111, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1068, 112, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1069, 113, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1070, 114, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1071, 115, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1072, 116, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1073, 117, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1074, 118, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1075, 119, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1076, 120, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1077, 121, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1078, 122, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1079, 123, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1080, 124, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1081, 125, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1082, 126, '2026-11-11 11:44:16', 'Dinas Luar', 'dinas ke lampung', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1083, 127, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1084, 128, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1085, 129, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1086, 130, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1087, 131, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1088, 132, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1089, 133, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1090, 134, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1091, 135, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1092, 136, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1093, 137, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1094, 138, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1095, 139, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1096, 140, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1097, 141, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1098, 142, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1099, 143, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1100, 144, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1101, 145, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1102, 146, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1103, 147, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1104, 148, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1105, 149, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1106, 150, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1107, 151, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1108, 152, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1109, 153, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1110, 154, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1111, 155, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1112, 156, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1113, 157, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1114, 158, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1115, 159, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1116, 160, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1117, 161, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1118, 162, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1119, 163, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1120, 164, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1121, 165, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1122, 166, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1123, 167, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1124, 168, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1125, 169, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1126, 170, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1127, 171, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1128, 172, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16'),
(1129, 173, '2026-11-11 11:44:16', 'Hadir', '', '2026-11-11 11:44:16', '2026-11-11 11:44:16');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_guru`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'superadmin', NULL, NULL, 0, '2026-11-11 11:51:53', '2026-08-21 11:59:25', '2026-08-21 11:59:25', NULL);

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
-- Indexes for table `deskripsi_kegiatan`
--
ALTER TABLE `deskripsi_kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
-- AUTO_INCREMENT for table `deskripsi_kegiatan`
--
ALTER TABLE `deskripsi_kegiatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3059;

--
-- AUTO_INCREMENT for table `personel`
--
ALTER TABLE `personel`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1130;

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

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 07:16 AM
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
-- Database: `tekom2bweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `venue` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `available_tickets` int(11) NOT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled') NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `image`, `event_date`, `venue`, `city`, `type`, `price`, `capacity`, `available_tickets`, `status`, `created_at`, `updated_at`) VALUES
(7, 'MEET WITH ROSSI', 'motor', 'images/1748404900_2022pajero.jpg', '2025-05-31 11:01:00', 'Hotel Pangeran', 'Padang', 'Workshop', 30000.00, 3, 3, 'upcoming', '2025-05-27 21:01:40', '2025-05-27 21:01:40'),
(8, 'Web Enginner', 'Biar kamu paham apa itu php', 'images/1748405904_3459e489d71096deec39dca7cbb9e23e2c5f0144690823707217478783.jpg', '2025-05-31 11:17:00', 'PKM PNP', 'Padang', 'Seminar', 10000.00, 100, 100, 'upcoming', '2025-05-27 21:18:24', '2025-05-27 21:18:24'),
(9, 'SUKSES SEBELUM 30 TAHUN', 'Bismillah', 'images/1748405953_6a398e2bffd61024b7fa8c6eaf6a4e62.png', '2025-05-31 11:18:00', 'PKM PNP', 'Padang', 'Seminar', 100000.00, 100, 100, 'upcoming', '2025-05-27 21:19:13', '2025-05-27 21:19:13');

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2024_03_19_create_events_table', 1),
(5, '2024_03_19_create_tickets_table', 1),
(6, '2024_03_20_create_rfid_cards_table', 1),
(7, '2024_06_09_000000_create_ticket_orders_table', 1),
(8, '2025_05_15_211935_create_sessions_table', 1),
(9, '2025_05_15_212358_add_role_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rfid_cards`
--

CREATE TABLE `rfid_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('26MA1RvyzFz2qC13WZN2CcnvGmW5K0RuMfcIbA3Z', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEc5Z0RadVl1UzZaUDdwVGVoUVZiTGw5SUtnRFNEZTJINFJoVml1YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749007997),
('eWiJXpQSCNJB8y7oIml6kyn5Ge5tVh4OInlTea6P', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHk2VWZCR3NWTWpaQmdoazdzbFMyMUZiYWdtVWI1Y01zQXdZUjdNSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749008468),
('Nk3TrleJVdzauV4YR77JbBs4n2iWRweWG0eBCj50', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2dlVk1IVFlzS015d3hMWFk5cXNQcUdNOXFlVjBaUU94RjREdmZ1dCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90aWNrZXRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1749013946),
('nkr4240OPsTwiVAvmSBldXzxz2SIVbhP5oLI7HSN', NULL, '127.0.0.1', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHdkUjJJZnM3OU45SksxcDM5UHZlYlRQc1FzeHZKV1piUWpzQzdsUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2V2ZW50cyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZXZlbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749007996),
('nlycl3hX8q82eSVAH3TW5p1xoUedHWnBTziJUtH5', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkJ1ZHNqWHVZQWo5WHZub043SHBjM0lsRllLNGFKMFllbEdQc0tIMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749007995),
('wTZ6vc6IezqFms08bTB1HoymEDmy0uBhRqJXlbyn', NULL, '127.0.0.1', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSUN4YkRVTTRKbUhZN2dHUm5FNVVPT2h5YWRoSW1EeFVZTjNaT1R5ViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2V2ZW50cyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZXZlbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749008466);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_code` varchar(255) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `buyer_email` varchar(255) NOT NULL,
  `buyer_phone` varchar(255) NOT NULL,
  `identity_type` varchar(255) NOT NULL,
  `identity_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','used','expired','cancelled') NOT NULL DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_orders`
--

CREATE TABLE `ticket_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `identity_type` varchar(255) NOT NULL,
  `identity_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_orders`
--

INSERT INTO `ticket_orders` (`id`, `event_id`, `name`, `identity_type`, `identity_number`, `address`, `province`, `city`, `email`, `whatsapp`, `sender_name`, `proof`, `status`, `created_at`, `updated_at`, `qrcode`) VALUES
(16, 7, 'jjk', 'SIM', '0u0u8', 'JAKART', 'DKI Jakarta', 'Jakarta', 'mrfajarauto@gmail.com', '4657679', 'kki', 'proofs/orYsFdYPlhldb6t5RO4w7zJlqWs8sI0LMM7nqzIp.jpg', 'confirmed', '2025-05-27 21:23:33', '2025-05-27 21:23:54', NULL),
(17, 8, 'baru gh', 'Kartu Pelajar', '34567890', 'JAKART', 'Sulawesi Selatan', 'Makassar', 'dimasgagah@gmail.com', '65988', 'bl2', 'proofs/cOTOE5g0OLNwkdJZPPg5rGFjXBSxDP4cQ4jdd8ft.jpg', 'confirmed', '2025-06-01 08:54:13', '2025-06-01 08:54:38', NULL),
(18, 9, 'dina', 'KTP', '34567890', 'JAKART', 'Sulawesi Selatan', 'Makassar', 'dimasgagah@gmail.com', '65988', 'fajar', 'proofs/THpMwlojzl0ft8vTp8ZxYXVBaP73TByiGZW9GMMb.jpg', 'confirmed', '2025-06-01 09:57:18', '2025-06-01 10:11:33', NULL),
(19, 7, 'dina', 'SIM', '34567890', 'JAKARTA', 'Sulawesi Selatan', 'Makassar', 'dimasgagah@gmail.com', '65988', 'bl2', 'bukti-transfer/1748797685_2022pajero.jpg', 'confirmed', '2025-06-01 10:08:05', '2025-06-01 10:11:29', NULL),
(20, 7, 'muhammad fajar', 'KTM', '34567890', 'JAKARTA', 'Sulawesi Selatan', 'Makassar', 'mrfajarauto@gmail.com', '65988', 'rian', 'bukti-transfer/1748797774_Screenshot 2025-06-02 000842.png', 'confirmed', '2025-06-01 10:09:34', '2025-06-01 10:09:55', NULL),
(21, 7, 'muhammad fajar', 'KTP', '34567890', 'JAKARTA', 'Sulawesi Selatan', 'Makassar', 'mrfajarauto@gmail.com', '65988', 'rian', 'bukti-transfer/1748797860_Screenshot 2025-04-25 143432.png', 'confirmed', '2025-06-01 10:11:00', '2025-06-01 10:11:26', NULL),
(22, 9, 'tes baru', 'KTP', '142618261096709164091606019', 'JAKART', 'DKI Jakarta', 'Jakarta', 'mrfajarauto@gmail.com', '08618761864981', 'baru', 'bukti-transfer/1748842221_Screenshot 2025-04-22 201028.png', 'confirmed', '2025-06-01 22:30:21', '2025-06-01 22:30:33', NULL),
(23, 9, 'bimby', 'KTP', '017418017', 'JAKART', 'Sulawesi Selatan', 'Makassar', 'dimasgagah@gmail.com', '7107010270', 'bimby', 'bukti-transfer/1748882531_coldplay.jpeg', 'confirmed', '2025-06-02 09:42:11', '2025-06-02 09:42:30', NULL),
(24, 8, 'tes baru', 'KTP', '142618261096709164091606019', 'JAKART', 'DKI Jakarta', 'Jakarta', 'mrfajarauto@gmail.com', '08618761864981', 'fajar', 'bukti-transfer/1748882707_alam.jpg', 'confirmed', '2025-06-02 09:45:07', '2025-06-02 09:45:20', NULL),
(25, 7, 'tes baru', 'SIM', '142618261096709164091606019', 'ojqe', 'DKI Jakarta', 'Jakarta', 'mrfajarauto@gmail.com', '08618761864981', 'bl2', 'bukti-transfer/1748882859_alam.jpg', 'confirmed', '2025-06-02 09:47:39', '2025-06-02 09:47:48', 'TKT-683dd5abb566b'),
(26, 8, 'bang padil', 'KTP', '142618261096709164091606019', 'JAKART', 'DKI Jakarta', 'Jakarta', 'mrfajarauto@gmail.com', '08618761864981', 'bl2', 'bukti-transfer/1748883503_bukit.jpg', 'confirmed', '2025-06-02 09:58:23', '2025-06-02 10:39:57', 'TKT-683dd82f58706'),
(27, 8, 'bimby baru', 'KTP', '142618261096709164091606019', 'JAKART', 'Jawa Tengah', 'Jakarta', 'mrfajarauto@gmail.com', '08618761864981', 'bimby', 'bukti-transfer/1748885310_alam.jpg', 'confirmed', '2025-06-02 10:28:30', '2025-06-02 10:28:49', 'TKT-683ddf3ec3053'),
(28, 9, 'baru', 'KTP', '142618261096709164091606019', 'JAKART', 'DKI Jakarta', 'Balikpapan', 'mrfajarauto@gmail.com', '08618761864981', 'baru', 'bukti-transfer/1749008033_bukit.jpg', 'confirmed', '2025-06-03 20:33:53', '2025-06-03 20:34:12', 'TKT-683fbea1539a3'),
(29, 9, 'baru', 'KTP', '142618261096709164091606019', 'JAKART', 'DKI Jakarta', 'Balikpapan', 'mrfajarauto@gmail.com', '08618761864981', 'bl2', 'bukti-transfer/1749012665_alam.jpg', 'confirmed', '2025-06-03 21:51:05', '2025-06-03 22:12:25', 'TKT-683fd0b96a80f');

-- --------------------------------------------------------

--
-- Stand-in structure for view `transaksievent`
-- (See below for the actual view)
--
CREATE TABLE `transaksievent` (
`name` varchar(255)
,`identity_number` varchar(255)
,`qrcode` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `identity_type` varchar(255) DEFAULT NULL,
  `identity_file` varchar(255) DEFAULT NULL,
  `rfid` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `identity_type`, `identity_file`, `rfid`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hafiz', 'admin@gmail.com', NULL, '$2y$12$TT5Re/.T6rcboCQVs0uaV.O.SP61ddu.AwYaLpZaBhj.kBwbEDb.y', 'admin', NULL, NULL, NULL, NULL, '2025-05-21 21:33:51', '2025-05-21 21:33:51'),
(2, 'bagas', 'superadmin@gmail.com', NULL, '$2y$12$yFdLbGrm7dkcEOJsRe9U8.M5T785KzP7CdqzS8yY7fEFEnwTgo322', 'superadmin', NULL, NULL, NULL, NULL, '2025-05-21 21:33:51', '2025-05-21 21:33:51'),
(3, 'dimas hg', 'dimasgagah@gmail.com', NULL, '$2y$12$xPQe17Pu5IQwbrvdbLXLR.xGFalQXXJjwbXSrjPnwyt0X0PWloypG', 'admin', 'KTP', 'identity_files/1pZN8YtnGmehAkZ7z3Wr9VUjddpqL1TNdB61wVMv.jpg', '2345678989', NULL, '2025-05-22 11:16:08', '2025-05-23 06:52:29');

-- --------------------------------------------------------

--
-- Structure for view `transaksievent`
--
DROP TABLE IF EXISTS `transaksievent`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksievent`  AS SELECT `ticket_orders`.`name` AS `name`, `ticket_orders`.`identity_number` AS `identity_number`, `ticket_orders`.`qrcode` AS `qrcode` FROM `ticket_orders` WHERE `ticket_orders`.`status` = 'confirmed' ;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfid_cards`
--
ALTER TABLE `rfid_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rfid_cards_card_number_unique` (`card_number`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_code_unique` (`ticket_code`),
  ADD KEY `tickets_event_id_foreign` (`event_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_orders`
--
ALTER TABLE `ticket_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qrcode` (`qrcode`),
  ADD KEY `ticket_orders_event_id_foreign` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rfid_cards`
--
ALTER TABLE `rfid_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_orders`
--
ALTER TABLE `ticket_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_orders`
--
ALTER TABLE `ticket_orders`
  ADD CONSTRAINT `ticket_orders_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

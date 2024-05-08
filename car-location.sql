-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 08 مايو 2024 الساعة 12:08
-- إصدار الخادم: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car-location`
--

-- --------------------------------------------------------

--
-- بنية الجدول `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `energie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque_id` bigint(20) UNSIGNED NOT NULL,
  `motor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilaya` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_per_day` decimal(8,2) NOT NULL,
  `pictures` json DEFAULT NULL,
  `confirmation_status` enum('pending','cancelled','confirmed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `car_availability` enum('disponible','indisponible') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `marques`
--

CREATE TABLE `marques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `marques`
--

INSERT INTO `marques` (`id`, `name`, `logo`, `created_at`, `updated_at`) VALUES
(4, 'KIA', 'marque_logos/1714994485_كيفاه يخرجلك فايسبوك الاشهار.png', '2024-05-06 09:29:10', '2024-05-06 10:21:25');

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2),
(6, '2019_08_19_000000_create_failed_jobs_table', 2),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(8, '2024_04_28_113946_create_marques_table', 3),
(9, '2024_05_05_101148_add_car_availability_to_cars_table', 4);

-- --------------------------------------------------------

--
-- بنية الجدول `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'authToken', '82a1c29cbc5cdb799b729bbc9dc0a425ef472ea54e0a732c481791c430603e7a', '[\"*\"]', NULL, '2024-04-28 15:44:54', '2024-04-28 15:44:54'),
(2, 'App\\Models\\User', 1, 'authToken', '73b42ea69c73bc60b24319b6091fbbc96673e77c6aafe615f686e3778f74093c', '[\"*\"]', NULL, '2024-04-28 15:45:00', '2024-04-28 15:45:00'),
(3, 'App\\Models\\User', 11, 'authToken', '77f30baf3b376fdca9511d8163d8e13e9436acdf1205bb317aea4034544d448d', '[\"*\"]', NULL, '2024-04-28 15:50:58', '2024-04-28 15:50:58'),
(4, 'App\\Models\\User', 1, 'authToken', 'c94c7bc8e496ad35e996423cfb6ea6c3e81c205f9cb8374808ecd2f47b8d15dc', '[\"*\"]', NULL, '2024-04-28 16:04:06', '2024-04-28 16:04:06'),
(5, 'App\\Models\\User', 1, 'authToken', '5327755311768ff6e946cb9c323fd218beb10a78ca04f1f3f4520b4730867068', '[\"*\"]', NULL, '2024-04-29 10:38:18', '2024-04-29 10:38:18'),
(6, 'App\\Models\\User', 5, 'authToken', 'b07bdb8f81bd6a2f17d860bf59230cfb038f6619001b1156545b33c2d64ae719', '[\"*\"]', NULL, '2024-04-29 10:39:11', '2024-04-29 10:39:11'),
(7, 'App\\Models\\User', 1, 'authToken', '680310a05f1c022863aaf77eae49c8c8b381f19aaecb8a3fffc76baa3ee089ce', '[\"*\"]', NULL, '2024-04-29 10:49:09', '2024-04-29 10:49:09'),
(8, 'App\\Models\\User', 14, 'authToken', '094af4d0e21fa0966a85e0a361ae9a1fc26592f292e47b9033cf31318c3a66cd', '[\"*\"]', NULL, '2024-05-08 09:13:09', '2024-05-08 09:13:09'),
(9, 'App\\Models\\User', 14, 'authToken', '734b5fc265d238233fb0dfc901aee42990ba35b921ee6ae7158ace2f68128af9', '[\"*\"]', NULL, '2024-05-08 09:14:37', '2024-05-08 09:14:37'),
(10, 'App\\Models\\User', 14, 'authToken', '0bd51288466b9bddb2cd534be5a79c2fb4c6068345290df3dc85c2e09682a006', '[\"*\"]', NULL, '2024-05-08 10:09:26', '2024-05-08 10:09:26');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bailleur',
  `phone` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_type`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'ADMIN KIM', 'ADMIN@KIM.com', 'admin', 656569260, NULL, '$2y$10$M2VzxDTfB0kvBgMrgXRZ4.61JFrs4iGEMn6UtV19QmIF6R8aTVtCS', NULL, '2024-05-05 12:44:29', '2024-05-05 12:44:29'),
(13, 'hakim', 'hakim@gmail.com', 'bailleur', 645781239, NULL, '$2y$10$ZRMvIWELWHxQED.MJJyCAeGoSpiPQ39xoPz483bwm0cbHjss2cxWi', NULL, '2024-05-08 08:45:24', '2024-05-08 08:45:24'),
(14, 'Hakim', 'halouat.hakim@gmail.com', 'bailleur', 676538606, NULL, '$2y$10$JOJrrnX89lm13Eo6Ksb/5Of9rJVCoi9RI5PgZTA3MFYIJDE/42/Ku', NULL, '2024-05-08 08:50:48', '2024-05-08 08:50:48'),
(15, 'Hakim', 'savd.saf@gmail.com', 'bailleur', 315181, NULL, '$2y$10$XOxxmMXw6teryXeGViMVyejaT7kGN8oTrxCQOn/eXZHcIm/PE1BQ6', NULL, '2024-05-08 08:52:39', '2024-05-08 08:52:39'),
(18, 'zakaria', 'null', 'bailleur', 656569261, NULL, '$2y$10$VrVjOrFe8REaRHQvWjgtE.oOB1Zq2ciCMQILkcHnIJOM3N0GuB/oS', NULL, '2024-05-08 09:00:21', '2024-05-08 09:00:21'),
(21, 'Hakim', NULL, 'bailleur', 216518541, NULL, '$2y$10$0xZHaQFyU6p0YvErBjf8sOoUE2aWqSknTj/I6d5qdexyEBdFOZ4em', NULL, '2024-05-08 09:02:20', '2024-05-08 09:02:20'),
(22, 'Hakim', NULL, 'bailleur', 3215, NULL, '$2y$10$VNSvoY31R0o/gHJIVkLIqOI02Bz4S4qFI5SVI6TWS6FuyaxafBb5e', NULL, '2024-05-08 09:03:41', '2024-05-08 09:03:41'),
(23, 'Hakim', NULL, 'bailleur', 321541, NULL, '$2y$10$C2rndRyOteEjdGg1zNiRz.IB11QS4f.rO1pDMpH46nuKRKICxiqCi', NULL, '2024-05-08 09:44:13', '2024-05-08 09:44:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cars_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marques`
--
ALTER TABLE `marques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

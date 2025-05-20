-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 16, 2024 at 01:35 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_project_pendataan_penduduk`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluargas`
--

CREATE TABLE `keluargas` (
  `id` bigint NOT NULL,
  `no_kk` bigint DEFAULT NULL,
  `kk_nik` bigint DEFAULT NULL,
  `kk_nama` longtext,
  `alamat` longtext,
  `rt` longtext,
  `rw` longtext,
  `kode_pos` longtext,
  `status` tinyint DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluargas`
--

INSERT INTO `keluargas` (`id`, `no_kk`, `kk_nik`, `kk_nama`, `alamat`, `rt`, `rw`, `kode_pos`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 123412341234, 123412341234, 'Budi Budiman', 'Perumahan Gotham Blok C3-21', '01', '01', '12345', 1, 3, '2024-12-14 09:07:22', '2024-12-14 23:28:44'),
(2, 132413241324, 132413241324, 'Yanto Hariyanto', 'Perumahan Central D1-23', '01', '01', '54321', 1, 2, '2024-12-14 11:18:42', '2024-12-14 23:29:49'),
(4, 111222333444, 111222333444, 'Bambang Pamungkas', 'Los Angeles', '01', '02', '13245', 1, 2, '2024-12-15 23:46:50', '2024-12-15 23:46:50'),
(5, 142314231423, 142314231423, 'Kustadi Steady', 'Pakis', '01', '01', '56789', 1, 2, '2024-12-15 23:48:26', '2024-12-15 23:48:26'),
(6, 102938475647, 102938475647, 'Leonardo DiCaprio', 'Singosari', '01', '01', '82931', 1, 2, '2024-12-16 09:12:52', '2024-12-16 09:12:52'),
(7, 102938475647, 102938475647, 'Leonardo Davinci', 'Plaosan', '01', '01', '77261', 1, 2, '2024-12-16 09:13:17', '2024-12-16 09:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `penduduks`
--

CREATE TABLE `penduduks` (
  `id` bigint NOT NULL,
  `kels_id` bigint DEFAULT NULL,
  `nik` bigint DEFAULT NULL,
  `nama` longtext,
  `tmp_lahir` longtext,
  `tgl_lahir` datetime(3) DEFAULT NULL,
  `kelamin` tinyint DEFAULT NULL,
  `stat_kawin` tinyint DEFAULT NULL,
  `hub_kel` tinyint DEFAULT NULL,
  `warga_neg` tinyint DEFAULT NULL,
  `agama` tinyint DEFAULT NULL,
  `pendidikan` tinyint DEFAULT NULL,
  `pekerjaan` tinyint DEFAULT NULL,
  `ayah` longtext,
  `ibu` longtext,
  `kepala_kel` longtext,
  `no_hp` longtext,
  `domisili` tinyint DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penduduks`
--

INSERT INTO `penduduks` (`id`, `kels_id`, `nik`, `nama`, `tmp_lahir`, `tgl_lahir`, `kelamin`, `stat_kawin`, `hub_kel`, `warga_neg`, `agama`, `pendidikan`, `pekerjaan`, `ayah`, `ibu`, `kepala_kel`, `no_hp`, `domisili`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 123412341234, 'Budi Budiman', 'Malang', '1980-12-01 19:16:01.000', 1, 2, 1, 1, 1, 8, 5, 'Ahmnad', 'Siti', 'Budi Budiman', '081234567890', 1, 1, 2, '2024-12-16 12:24:57', '2024-12-16 12:24:57'),
(2, 1, 123412341234, 'Markonah', 'Malang', '1982-12-01 19:16:01.000', 2, 2, 3, 1, 1, 8, 5, 'Bambang', 'Tukiyem', 'Budi Budiman', '080987654321', 1, 1, 3, '2024-12-16 12:24:57', '2024-12-16 12:24:57'),
(4, 2, 132413241324, 'Yanto Hariyanto', 'Magetan', '2000-01-01 07:00:00.000', 1, 2, 1, 1, 1, 8, 5, 'Sutarman', 'Rohmah', 'Yanto Hariyanto', '081029384756', 1, 1, 2, '2024-12-16 12:59:12', '2024-12-16 13:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` longtext,
  `email` varchar(191) NOT NULL,
  `password` longtext NOT NULL,
  `level` longtext,
  `profile_picture` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `level`, `profile_picture`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin@gmail.com', '$2a$10$TUdwSkl/m6jFawnlMY9prex501v6TuPGfKb4zC5H4S1KTOsk1Xstq', 'admin', '', '2024-12-09 11:56:55', '2024-12-10 04:04:25'),
(3, 'user test', 'test@user.com', '$2a$10$96h4m7KQMNcpSTwodPInDeczVk8i31VEJ4n5BcGvU9KWczAMp46bi', 'user', 'public/uploads/profile_pictures/avatar.png', '2024-12-10 03:35:02', '2024-12-14 09:02:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluargas`
--
ALTER TABLE `keluargas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keluargas_user` (`user_id`);

--
-- Indexes for table `penduduks`
--
ALTER TABLE `penduduks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_penduduks_user` (`user_id`),
  ADD KEY `fk_penduduks_keluarga` (`kels_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uni_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluargas`
--
ALTER TABLE `keluargas`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penduduks`
--
ALTER TABLE `penduduks`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keluargas`
--
ALTER TABLE `keluargas`
  ADD CONSTRAINT `fk_keluargas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `penduduks`
--
ALTER TABLE `penduduks`
  ADD CONSTRAINT `fk_penduduks_keluarga` FOREIGN KEY (`kels_id`) REFERENCES `keluargas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penduduks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2026 at 03:40 AM
-- Server version: 10.4.34-MariaDB
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ict`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku_tamu`
--

CREATE TABLE `buku_tamu` (
  `no` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `nrp` varchar(255) DEFAULT NULL,
  `instansi` varchar(255) DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `inspeksi_monitor`
--

CREATE TABLE `inspeksi_monitor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_aset` varchar(255) DEFAULT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal_inspeksi` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tampilan_layer` varchar(255) DEFAULT NULL,
  `kabel_power` varchar(255) DEFAULT NULL,
  `bracket_dudukan` varchar(255) DEFAULT NULL,
  `kebersihan` varchar(255) DEFAULT NULL,
  `stop_kontak` varchar(255) DEFAULT NULL,
  `tindakan_tampilan_layer` text DEFAULT NULL,
  `tindakan_kabel_power` text DEFAULT NULL,
  `tindakan_bracket_dudukan` text DEFAULT NULL,
  `tindakan_kebersihan` text DEFAULT NULL,
  `tindakan_stop_kontak` text DEFAULT NULL,
  `inspektor` varchar(255) DEFAULT NULL,
  `jabatan_inspektor` varchar(255) DEFAULT NULL,
  `diketahui_oleh` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspeksi_proyektors`
--

CREATE TABLE `inspeksi_proyektors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_aset` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `tanggal_inspeksi` date DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `kondisi_casing` varchar(255) DEFAULT NULL,
  `tindakan_kondisi_casing` text DEFAULT NULL,
  `kebersihan` varchar(255) DEFAULT NULL,
  `tindakan_kebersihan` text DEFAULT NULL,
  `kabel_adaptor` varchar(255) DEFAULT NULL,
  `tindakan_kabel_adaptor` text DEFAULT NULL,
  `lensa_proyektor` varchar(255) DEFAULT NULL,
  `tindakan_lensa_proyektor` text DEFAULT NULL,
  `indikator_lampu` varchar(255) DEFAULT NULL,
  `tindakan_indikator_lampu` text DEFAULT NULL,
  `fokus_zoom` varchar(255) DEFAULT NULL,
  `tindakan_fokus_zoom` text DEFAULT NULL,
  `kecerahan_kontras` varchar(255) DEFAULT NULL,
  `tindakan_kecerahan_kontras` text DEFAULT NULL,
  `koneksi_input_hdmi` varchar(255) DEFAULT NULL,
  `koneksi_input_vga` varchar(255) DEFAULT NULL,
  `koneksi_input_usb` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `inspektor` varchar(255) DEFAULT NULL,
  `jabatan_inspektor` varchar(255) DEFAULT NULL,
  `diketahui_oleh` varchar(255) DEFAULT 'Group Leader ICT',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspeksi_stavolts`
--

CREATE TABLE `inspeksi_stavolts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_aset` varchar(255) DEFAULT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal_inspeksi` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `casing` varchar(255) DEFAULT NULL,
  `tindakan_casing` text DEFAULT NULL,
  `kebersihan` varchar(255) DEFAULT NULL,
  `tindakan_kebersihan` text DEFAULT NULL,
  `kabel_adaptor` varchar(255) DEFAULT NULL,
  `tindakan_kabel_adaptor` text DEFAULT NULL,
  `tombol_switch` varchar(255) DEFAULT NULL,
  `tindakan_tombol_switch` text DEFAULT NULL,
  `indikator_voltase` varchar(255) DEFAULT NULL,
  `tindakan_indikator_voltase` text DEFAULT NULL,
  `respon_perubahan_beban` varchar(255) DEFAULT NULL,
  `tindakan_respon_perubahan_beban` text DEFAULT NULL,
  `inspektor` varchar(255) DEFAULT NULL,
  `jabatan_inspektor` varchar(255) DEFAULT NULL,
  `diketahui_oleh` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspeksi_ups`
--

CREATE TABLE `inspeksi_ups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_aset` varchar(255) DEFAULT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sn` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal_inspeksi` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `casing` varchar(255) DEFAULT NULL,
  `tindakan_casing` text DEFAULT NULL,
  `kebersihan` varchar(255) DEFAULT NULL,
  `tindakan_kebersihan` text DEFAULT NULL,
  `kabel_adaptor` varchar(255) DEFAULT NULL,
  `tindakan_kabel_adaptor` text DEFAULT NULL,
  `tombol_switch` varchar(255) DEFAULT NULL,
  `tindakan_tombol_switch` text DEFAULT NULL,
  `indikator_status` varchar(255) DEFAULT NULL,
  `tindakan_indikator_status` text DEFAULT NULL,
  `fungsi_alarm` varchar(255) DEFAULT NULL,
  `tindakan_fungsi_alarm` text DEFAULT NULL,
  `respon_kehilangan_daya` varchar(255) DEFAULT NULL,
  `tindakan_respon_kehilangan_daya` text DEFAULT NULL,
  `fuse` varchar(255) DEFAULT NULL,
  `tindakan_fuse` text DEFAULT NULL,
  `inspektor` varchar(255) DEFAULT NULL,
  `diketahui_oleh` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nrp` varchar(255) NOT NULL,
  `nama_perangkat` varchar(255) NOT NULL,
  `no_asset` varchar(255) DEFAULT NULL,
  `status_peminjaman` enum('Belum Dikembalikan','Dikembalikan') NOT NULL DEFAULT 'Belum Dikembalikan',
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `nama`, `nrp`, `nama_perangkat`, `no_asset`, `status_peminjaman`, `tanggal_peminjaman`, `tanggal_pengembalian`, `created_at`, `updated_at`) VALUES
(1, 'Brieyan', 'GL-0001', 'Mouse', '01', 'Belum Dikembalikan', '2026-07-17', NULL, '2026-07-15 03:18:29', '2026-07-15 03:18:29');

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
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nrp` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(5, '2025_11_29_081612_user', 1);

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
-- Table structure for table `registrasis`
--

CREATE TABLE `registrasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `perusahaan` varchar(255) NOT NULL,
  `nomor_lambung` varchar(255) NOT NULL,
  `jenis_kendaraan` varchar(255) NOT NULL,
  `nomor_polisi` varchar(255) DEFAULT NULL,
  `id_ptt` varchar(255) NOT NULL,
  `merek_radio` varchar(255) NOT NULL,
  `jenis_radio` varchar(200) DEFAULT NULL,
  `serial_number` varchar(255) NOT NULL,
  `tanggal_permintaan` date NOT NULL DEFAULT curdate(),
  `channels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`channels`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `range_power` varchar(255) DEFAULT NULL,
  `range_frekuensi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrasis`
--

INSERT INTO `registrasis` (`id`, `perusahaan`, `nomor_lambung`, `jenis_kendaraan`, `nomor_polisi`, `id_ptt`, `merek_radio`, `jenis_radio`, `serial_number`, `tanggal_permintaan`, `channels`, `created_at`, `updated_at`, `range_power`, `range_frekuensi`) VALUES
(1, 'PPA', '01', 'truck', 'DA 1234 XCF', '0001', 'motorola', 'Mobile', '1234', '2026-07-14', '[\"PPA SECURITY\"]', '2026-07-14 06:52:20', '2026-07-14 06:52:20', '45 W', '[\"146 - 174\"]');

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_radios`
--

CREATE TABLE `registrasi_radios` (
  `id` int(11) NOT NULL,
  `range_power` varchar(255) DEFAULT NULL,
  `range_frekuensi` varchar(255) DEFAULT NULL,
  `jenis_radio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
('WtHFkFylcBYu7YCdd7AlzRXa895LPOv80rplZw0f', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYWRQOWxJdHBveE01aWZzd2huSERMbGo4MlhnWXRBQjBqT3ppSnRMQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9pbnNwZWtzaXVwcyI7czo1OiJyb3V0ZSI7czoxNzoiaW5zcGVrc2l1cHMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1784086572);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `role` enum('ict','user') NOT NULL DEFAULT 'user',
  `nrp` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `email_verified_at` varchar(200) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `role`, `nrp`, `password`, `email`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ict', 'ict', NULL, '$2y$12$vbFlnYdhoNFOhnr1YAgckOohgnswzkz/YxTQuPlcZX0uTOmMeY3cm', 'drussel@example.net', '2026-07-14 14:35:46', 'jAmbUKJrF6AZFFFROMYbWDskCGBMEwwi34ijsmKOVYML3aR1wsBmAWKr9th2', '2026-07-14 06:35:47', '2026-07-14 06:35:47'),
(2, 'admin', 'ict', 'ADM-0001', '$2y$12$8dP8Bw6/pOetyxdA/82fWOrcJvnj33J3vxVWkXGthuqEiJBxg8rk6', NULL, NULL, NULL, '2026-07-15 02:46:03', '2026-07-15 02:46:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku_tamu`
--
ALTER TABLE `buku_tamu`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inspeksi_monitor`
--
ALTER TABLE `inspeksi_monitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspeksi_proyektors`
--
ALTER TABLE `inspeksi_proyektors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspeksi_stavolts`
--
ALTER TABLE `inspeksi_stavolts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspeksi_ups`
--
ALTER TABLE `inspeksi_ups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_nrp_unique` (`nrp`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `registrasis`
--
ALTER TABLE `registrasis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrasis_id_ptt_unique` (`id_ptt`);

--
-- Indexes for table `registrasi_radios`
--
ALTER TABLE `registrasi_radios`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku_tamu`
--
ALTER TABLE `buku_tamu`
  MODIFY `no` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspeksi_monitor`
--
ALTER TABLE `inspeksi_monitor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspeksi_proyektors`
--
ALTER TABLE `inspeksi_proyektors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspeksi_stavolts`
--
ALTER TABLE `inspeksi_stavolts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspeksi_ups`
--
ALTER TABLE `inspeksi_ups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registrasis`
--
ALTER TABLE `registrasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registrasi_radios`
--
ALTER TABLE `registrasi_radios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

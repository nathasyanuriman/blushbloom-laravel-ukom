-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Nov 2026 pada 05.06
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
-- Database: `blush_bloom`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('Menunggu','Dikonfirmasi','Selesai','Dibatalkan') NOT NULL DEFAULT 'Menunggu',
  `payment_status` enum('Belum Dibayar','Dibayar') NOT NULL DEFAULT 'Belum Dibayar',
  `total_price` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `service_id`, `event_date`, `event_time`, `event_location`, `event_type`, `notes`, `status`, `payment_status`, `total_price`, `created_at`, `updated_at`) VALUES
(2, 7, 4, '2026-10-25', '16:20:00', 'jl melati', 'Pesta', 'keren tapi elegan ya', 'Selesai', 'Dibayar', 450000, '2026-10-23 09:44:00', '2026-10-23 09:49:03'),
(4, 7, 5, '2026-10-29', '06:00:00', 'JL.Bintara raya 8', 'Lainnya', 'Gusti', 'Selesai', 'Dibayar', 300000, '2026-10-26 03:22:17', '2026-10-30 12:02:42'),
(8, 8, 6, '2026-10-31', '14:04:00', 'jl kayuringin', 'Lamaran', NULL, 'Selesai', 'Dibayar', 900000, '2026-10-30 12:05:23', '2026-11-05 12:33:37'),
(11, 8, 5, '2026-11-05', '20:28:00', 'jl.kemangi', 'Lainnya', 'yang bagus ya ka', 'Menunggu', 'Belum Dibayar', 300000, '2026-11-05 12:29:03', '2026-11-05 12:29:03'),
(12, 9, 3, '2026-11-10', '09:00:00', 'bukit pelangi', 'Prewedding', 'temanya pink', 'Dikonfirmasi', 'Belum Dibayar', 750000, '2026-11-05 12:32:22', '2026-11-05 12:33:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_01_01_000001_create_services_table', 1),
(3, '2026_01_01_000002_create_bookings_table', 1),
(4, '2026_11_08_203540_add_image_to_services_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `image`, `price`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Makeup Wisuda', 'Riasan fresh dan tahan lama untuk momen kelulusan.', 'services/fkpCVnioTCqb0XxPftHk7MIjrKneMBzjXgIWkznP.jpg', 350000, 1, '2026-10-23 08:49:40', '2026-11-08 15:02:12'),
(3, 'Makeup Prewedding', 'Look fotogenik untuk sesi foto prewedding dan momen spesial.', 'services/kQgfatC1vD89QNeSWywJvdE4sw6OEGRUka8SEjwu.jpg', 750000, 1, '2026-10-23 08:49:40', '2026-11-08 15:02:54'),
(4, 'Makeup Party', 'Riasan glam untuk pesta, ulang tahun, dan acara malam.', 'services/etR1hTs5fhua058mIrtIz8H6YR8EcZJkMAENsVNz.jpg', 450000, 1, '2026-10-23 08:49:40', '2026-11-08 15:03:09'),
(5, 'Makeup Natural', 'Tampilan ringan dan natural untuk acara santai.', 'services/poJzJCPojdKMOa3AXXEZ1iBlovnfQxxeMYyuJNyZ.jpg', 300000, 1, '2026-10-23 08:49:40', '2026-11-08 15:03:24'),
(6, 'Makeup Lamaran', 'Riasan manis dan elegan untuk acara lamaran.', 'services/IKdyTtEBjR63W1iucGbpcNyJLgl88xOdT7KugXC3.jpg', 900000, 1, '2026-10-23 08:49:40', '2026-11-08 15:03:38'),
(12, 'Makeup Pengantin', 'Tampilan flawless untuk hari akad dan resepsi, tahan seharian', 'services/Iu1w3J2yVsXkVMA6Bd0v6L15pjw7bEo4zQJWoZJr.jpg', 1500000, 1, '2026-11-05 11:51:28', '2026-11-08 15:02:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'Admin', 'admin@gmail.com', '0895325967112', '$2y$12$LQZY3vYg4GCqfBTD1o8nKuRw/RH09/01C6MxhDtGjDo3z5IHwJyH6', 'admin', NULL, '2026-10-23 09:40:34', '2026-10-23 09:40:34'),
(7, 'Nathasya', 'Nathasya@gmail.com', '08818280643', '$2y$12$xqSF1HwO8obA7G.8emORw.x/PosHVTPgMADX5GEaoG4pSCcUz/sSO', 'customer', NULL, '2026-10-23 09:40:35', '2026-10-23 09:40:35'),
(8, 'Vita', 'Novita@gmail.com', '08963527845', '$2y$12$WBGZckCFud5Kr7lT/9GMN.t5XAm6RQMV2DDK.mxnPEbo1s9xuL5Yi', 'customer', NULL, '2026-10-30 12:04:12', '2026-10-30 12:04:12'),
(9, 'zia', 'ziaaja@gmail.com', '087483274832', '$2y$12$hfjAat/3JupI8GEUGCZ9l.S1Db7vGdcjW4sF2BnxtpMvS.FkjrmeK', 'customer', NULL, '2026-11-05 12:30:41', '2026-11-05 12:30:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

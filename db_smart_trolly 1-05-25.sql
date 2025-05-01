-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Bulan Mei 2025 pada 12.57
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
-- Database: `db_smart_trolly`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `stock` int(11) NOT NULL,
  `rfid_code` varchar(255) NOT NULL,
  `rack_code` varchar(255) NOT NULL,
  `position_detail` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `stock`, `rfid_code`, `rack_code`, `position_detail`, `description`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Alexander the Great book\'s', 200000, 0, '549AF603', 'R-01', 'rak kedua', 'A catalog of books about Alexander the Great typically includes biographies, historical analyses, and explorations of the cultural impact of his life and conquests. These books delve into his military strategies, leadership, and the legacy he left behind, examining both his successes and failures. They also often explore the evolution of Alexander\'s image in literature, art, and popular culture.', '1745918317_df1b3b29a75f22081655.jpg', '2025-04-29 09:10:30', '2025-05-01 10:04:51'),
(7, 'landscape poster', 400000, 5, '1826182', 'R-02', 'rak pertama', '', '1745919164_a1a35702b4b3009f1255.png', '2025-04-29 09:32:44', '2025-05-01 08:33:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_rfids`
--

CREATE TABLE `item_rfids` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `rfid_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `item_rfids`
--

INSERT INTO `item_rfids` (`id`, `item_id`, `rfid_code`, `created_at`) VALUES
(1, 7, '549AF603', '2025-05-01 10:11:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `status` enum('pending','validated','cancelled') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, 600000, 'validated', '2025-04-29 12:42:39', '2025-04-29 11:20:42'),
(6, 1, 600000, 'cancelled', '2025-04-29 12:56:25', '2025-04-29 11:24:02'),
(7, 1, 800000, 'validated', '2025-05-01 07:55:15', '2025-04-29 11:57:02'),
(8, 1, 400000, 'pending', '2025-04-29 05:56:41', '2025-04-29 12:56:41'),
(9, 1, 200000, 'validated', '2025-05-01 06:57:54', '2025-05-01 06:56:45'),
(10, 2, 200000, 'pending', '2025-04-30 23:58:31', '2025-05-01 06:58:31'),
(11, 2, 400000, 'pending', '2025-05-01 01:33:38', '2025-05-01 08:33:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_items`
--

CREATE TABLE `payment_items` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payment_items`
--

INSERT INTO `payment_items` (`id`, `payment_id`, `item_id`, `quantity`, `price_at_purchase`) VALUES
(6, 5, 2, 1, 200000),
(7, 5, 7, 1, 400000),
(8, 6, 2, 1, 200000),
(9, 6, 7, 1, 400000),
(10, 7, 7, 1, 400000),
(11, 7, 2, 2, 200000),
(12, 8, 7, 1, 400000),
(13, 9, 2, 1, 200000),
(14, 10, 2, 1, 200000),
(15, 11, 7, 1, 400000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trolley_items`
--

CREATE TABLE `trolley_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trolley_items`
--

INSERT INTO `trolley_items` (`id`, `user_id`, `item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(30, 2, 7, 1, '2025-05-01 03:50:07', '2025-05-01 03:50:07'),
(31, 2, 7, 1, '2025-05-01 03:56:00', '2025-05-01 03:56:00'),
(32, 2, 7, 1, '2025-05-01 03:56:14', '2025-05-01 03:56:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('trolley','staff') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'STAFF1', '$2y$10$2icqh0qXL64ZFIz8qRILke/yXVsKQn9G8FcGGjbU58FvJbAdbTEce', 'staff', '2025-04-28 19:42:10', '2025-04-29 02:43:15'),
(2, 'TROLLEY', '$2y$10$UOofhtZC6Ah4xyYXT/cFmu16nNUYq/ZeCkWsn1hrIf2H8wt4/CxDO', 'trolley', '2025-04-29 08:05:27', '2025-04-29 08:05:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `item_rfids`
--
ALTER TABLE `item_rfids`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `payment_items`
--
ALTER TABLE `payment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indeks untuk tabel `trolley_items`
--
ALTER TABLE `trolley_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `item_rfids`
--
ALTER TABLE `item_rfids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `payment_items`
--
ALTER TABLE `payment_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `trolley_items`
--
ALTER TABLE `trolley_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

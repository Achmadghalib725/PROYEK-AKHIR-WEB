-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 02 Jun 2025 pada 04.24
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `penulis` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_terbit` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `status` enum('tersedia','dipinjam') COLLATE utf8mb4_general_ci DEFAULT 'tersedia',
  `dipinjam_oleh` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `tahun_terbit`, `id_kategori`, `status`, `dipinjam_oleh`) VALUES
(1, 'Statistika Terapan', 'Tanti Wulandari', 1996, 2, 'tersedia', NULL),
(2, 'Kimia Terapan', 'Indah Kartika', 2015, 2, 'tersedia', NULL),
(3, 'Pengantar Linguistik', 'Marzuki', 2002, 3, 'tersedia', NULL),
(4, 'Sosiologi Pendidikan', 'Andi Nurhayati', 1986, 3, 'tersedia', NULL),
(5, 'Filsafat Ilmu', 'Samsul Hadi', 2012, 2, 'tersedia', NULL),
(6, 'Jejak Langkah', 'Pramoedya Ananta Toer', 2017, 1, 'tersedia', NULL),
(7, 'Antropologi Budaya', 'Nurul Hidayah', 1982, 4, 'tersedia', NULL),
(8, 'Sosiologi Pendidikan', 'Andi Nurhayati', 1981, 3, 'tersedia', NULL),
(9, 'Laut Bercerita', 'Leila S. Chudori', 2020, 1, 'tersedia', NULL),
(10, 'Matematika Dasar', 'Yulianto', 1996, 3, 'tersedia', NULL),
(11, 'Antropologi Budaya', 'Nurul Hidayah', 2014, 4, 'tersedia', NULL),
(12, 'Matematika Dasar', 'Yulianto', 1993, 3, 'tersedia', NULL),
(13, 'Matematika Dasar', 'Yulianto', 2010, 3, 'tersedia', NULL),
(14, 'Biologi Dasar', 'Retno Wahyuni', 2004, 2, 'tersedia', NULL),
(15, 'Laskar Pelangi', 'Andrea Hirata', 1983, 1, 'tersedia', NULL),
(16, 'Teknologi Informasi', 'Bambang Haryanto', 1981, 2, 'tersedia', NULL),
(17, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 2019, 1, 'tersedia', NULL),
(18, 'Sosiologi Pendidikan', 'Andi Nurhayati', 2006, 3, 'tersedia', NULL),
(19, 'Laskar Pelangi', 'Andrea Hirata', 2007, 1, 'tersedia', NULL),
(20, 'Filsafat Ilmu', 'Samsul Hadi', 2005, 2, 'tersedia', NULL),
(21, 'Biologi Dasar', 'Retno Wahyuni', 1983, 2, 'tersedia', NULL),
(22, 'Statistika Terapan', 'Tanti Wulandari', 2005, 2, 'tersedia', NULL),
(23, 'Pengantar Linguistik', 'Marzuki', 1981, 3, 'tersedia', NULL),
(24, 'Biologi Dasar', 'Retno Wahyuni', 2006, 2, 'tersedia', NULL),
(25, 'Antropologi Budaya', 'Nurul Hidayah', 2023, 4, 'tersedia', NULL),
(26, 'Biologi Dasar', 'Retno Wahyuni', 2006, 2, 'tersedia', NULL),
(27, 'Jejak Langkah', 'Pramoedya Ananta Toer', 2003, 1, 'tersedia', NULL),
(28, 'Kimia Terapan', 'Indah Kartika', 1990, 2, 'tersedia', NULL),
(29, 'Teknologi Informasi', 'Bambang Haryanto', 2003, 2, 'tersedia', NULL),
(30, 'Biologi Dasar', 'Retno Wahyuni', 2010, 2, 'tersedia', NULL),
(31, 'Teknologi Informasi', 'Bambang Haryanto', 2005, 2, 'tersedia', NULL),
(32, 'Biologi Dasar', 'Retno Wahyuni', 2011, 2, 'tersedia', NULL),
(33, 'Sosiologi Pendidikan', 'Andi Nurhayati', 2023, 3, 'tersedia', NULL),
(34, 'Biologi Dasar', 'Retno Wahyuni', 1996, 2, 'tersedia', NULL),
(35, 'Kimia Terapan', 'Indah Kartika', 2016, 2, 'tersedia', NULL),
(36, 'Filsafat Ilmu', 'Samsul Hadi', 2020, 2, 'tersedia', NULL),
(37, 'Matematika Dasar', 'Yulianto', 1986, 3, 'tersedia', NULL),
(38, 'Jejak Langkah', 'Pramoedya Ananta Toer', 2017, 1, 'tersedia', NULL),
(39, 'Cantik Itu Luka', 'Eka Kurniawan', 1997, 1, 'tersedia', NULL),
(40, 'Statistika Terapan', 'Tanti Wulandari', 1985, 2, 'tersedia', NULL),
(41, 'Ilmu Pengetahuan Alam untuk SMP', 'Sri Handayani', 2004, 3, 'tersedia', NULL),
(42, 'Biologi Dasar', 'Retno Wahyuni', 2010, 2, 'tersedia', NULL),
(43, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1989, 1, 'tersedia', NULL),
(44, 'Laskar Pelangi', 'Andrea Hirata', 2001, 1, 'tersedia', NULL),
(45, 'Pengantar Ekonomi', 'Sugiyanto', 2008, 3, 'tersedia', NULL),
(46, 'Ilmu Pengetahuan Alam untuk SMP', 'Sri Handayani', 1980, 3, 'tersedia', NULL),
(47, 'Matematika Dasar', 'Yulianto', 2016, 3, 'tersedia', NULL),
(48, 'Biologi Dasar', 'Retno Wahyuni', 2014, 2, 'tersedia', NULL),
(49, 'Fisika untuk SMA', 'Darmawan', 2019, 2, 'tersedia', NULL),
(50, 'Sejarah Pergerakan Nasional', 'R. Sunaryadi', 1995, 4, 'tersedia', NULL),
(51, 'Laskar Pelangi', 'Andrea Hirata', 2008, 1, 'tersedia', NULL),
(52, 'Laut Bercerita', 'Leila S. Chudori', 1996, 1, 'tersedia', NULL),
(53, 'Antropologi Budaya', 'Nurul Hidayah', 1994, 4, 'tersedia', NULL),
(54, 'Pengantar Linguistik', 'Marzuki', 2018, 3, 'tersedia', NULL),
(55, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 2019, 1, 'tersedia', NULL),
(56, 'Matematika Dasar', 'Yulianto', 2020, 3, 'tersedia', NULL),
(57, 'Ilmu Pengetahuan Alam untuk SMP', 'Sri Handayani', 1993, 3, 'tersedia', NULL),
(58, 'Statistika Terapan', 'Tanti Wulandari', 2015, 2, 'tersedia', NULL),
(59, 'Sejarah Pergerakan Nasional', 'R. Sunaryadi', 2002, 4, 'tersedia', NULL),
(60, 'Biologi Dasar', 'Retno Wahyuni', 1983, 2, 'tersedia', NULL),
(61, 'Sejarah Indonesia', 'A. Kunto Wibisono', 1983, 4, 'tersedia', NULL),
(62, 'Sejarah Indonesia', 'A. Kunto Wibisono', 2021, 4, 'tersedia', NULL),
(63, 'Sejarah Indonesia', 'A. Kunto Wibisono', 2003, 4, 'tersedia', NULL),
(64, 'Laut Bercerita', 'Leila S. Chudori', 1990, 1, 'tersedia', NULL),
(65, 'Sosiologi Pendidikan', 'Andi Nurhayati', 2023, 3, 'tersedia', NULL),
(66, 'Antropologi Budaya', 'Nurul Hidayah', 1986, 4, 'tersedia', NULL),
(67, 'Teknologi Informasi', 'Bambang Haryanto', 2019, 2, 'tersedia', NULL),
(68, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1990, 1, 'tersedia', NULL),
(69, 'Cantik Itu Luka', 'Eka Kurniawan', 2014, 1, 'tersedia', NULL),
(70, 'Sejarah Pergerakan Nasional', 'R. Sunaryadi', 2015, 4, 'tersedia', NULL),
(71, 'Antropologi Budaya', 'Nurul Hidayah', 2015, 4, 'tersedia', NULL),
(72, 'Sosiologi Pendidikan', 'Andi Nurhayati', 2002, 3, 'tersedia', NULL),
(73, 'Ilmu Pengetahuan Alam untuk SMP', 'Sri Handayani', 1981, 3, 'tersedia', NULL),
(74, 'Pengantar Ekonomi', 'Sugiyanto', 2020, 3, 'tersedia', NULL),
(75, 'Laut Bercerita', 'Leila S. Chudori', 1996, 1, 'tersedia', NULL),
(76, 'Sejarah Pergerakan Nasional', 'R. Sunaryadi', 1980, 4, 'tersedia', NULL),
(77, 'Laut Bercerita', 'Leila S. Chudori', 2004, 1, 'tersedia', NULL),
(78, 'Jejak Langkah', 'Pramoedya Ananta Toer', 1986, 1, 'tersedia', NULL),
(79, 'Antropologi Budaya', 'Nurul Hidayah', 1989, 4, 'tersedia', NULL),
(80, 'Fisika untuk SMA', 'Darmawan', 1995, 2, 'tersedia', NULL),
(81, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1981, 1, 'tersedia', NULL),
(82, 'Bumi Manusia', 'Pramoedya Ananta Toer', 1988, 1, 'tersedia', NULL),
(83, 'Biologi Dasar', 'Retno Wahyuni', 1994, 2, 'tersedia', NULL),
(84, 'Pengantar Ekonomi', 'Sugiyanto', 2020, 3, 'tersedia', NULL),
(85, 'Laskar Pelangi', 'Andrea Hirata', 2002, 1, 'tersedia', NULL),
(86, 'Filsafat Ilmu', 'Samsul Hadi', 1989, 2, 'tersedia', NULL),
(87, 'Biologi Dasar', 'Retno Wahyuni', 1998, 2, 'tersedia', NULL),
(88, 'Antropologi Budaya', 'Nurul Hidayah', 1999, 4, 'tersedia', NULL),
(89, 'Laut Bercerita', 'Leila S. Chudori', 2022, 1, 'tersedia', NULL),
(90, 'Fisika untuk SMA', 'Darmawan', 2021, 2, 'tersedia', NULL),
(91, 'Sejarah Indonesia', 'A. Kunto Wibisono', 1995, 4, 'tersedia', NULL),
(92, 'Kimia Terapan', 'Indah Kartika', 1985, 2, 'tersedia', NULL),
(93, 'Pengantar Ekonomi', 'Sugiyanto', 1994, 3, 'tersedia', NULL),
(94, 'Bumi Manusia', 'Pramoedya Ananta Toer', 1989, 1, 'tersedia', NULL),
(95, 'Ronggeng Dukuh Paruk', 'Ahmad Tohari', 2014, 1, 'tersedia', NULL),
(96, 'Bumi Manusia', 'Pramoedya Ananta Toer', 2004, 1, 'tersedia', NULL),
(97, 'Antropologi Budaya', 'Nurul Hidayah', 1998, 4, 'tersedia', NULL),
(98, 'Jejak Langkah', 'Pramoedya Ananta Toer', 2002, 1, 'tersedia', NULL),
(99, 'Teknologi Informasi', 'Bambang Haryanto', 1981, 2, 'tersedia', NULL),
(100, 'Teknologi Informasi', 'Bambang Haryanto', 1995, 2, 'tersedia', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'fiksi\r\n'),
(2, 'ilmiah\r\n'),
(3, 'pendidikan '),
(4, 'sejarah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `nama_lengkap`, `keterangan`, `foto`) VALUES
(3, 'ghalib', '$2y$10$lZh3awGn4nmn6qPvUfKBL.Tv1fETHafrca1YQFROyH/0trMeD4Qnq', 'user', 'eeeeee', 'eak', '683c7f074289b.jpeg'),
(5, 'gadmin', '$2y$10$.lv5xOP4fV2/lbyQC7uRk.XqlYOiGSXU6Z.jki5kbqU7UGmvd2gja', 'admin', 'gadmin', NULL, NULL),
(7, 'abyan', '$2y$10$gJ39ap8WH4rsgcCpFK2Ke.2d13J5APF2qqP6ZXQ6OK7C0NzJQ7yiK', 'user', 'abyan', 'ngantuk bgt', '683d1dfd9e497.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

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
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

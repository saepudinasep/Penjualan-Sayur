-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Okt 2023 pada 12.48
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpenjualan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_cart`
--

CREATE TABLE `tb_cart` (
  `cart_id` int(11) NOT NULL,
  `toko_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `jenis` enum('buy','nBuy') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_cart`
--

INSERT INTO `tb_cart` (`cart_id`, `toko_id`, `pelanggan_id`, `produk_id`, `qty`, `jenis`) VALUES
(9, 1, NULL, 3, 3, 'buy'),
(11, 1, NULL, 12, 1, 'buy'),
(12, 1, NULL, 17, 2, 'buy'),
(15, 1, NULL, 18, 1, 'buy'),
(16, 1, NULL, 14, 1, 'buy'),
(17, 1, NULL, 19, 1, 'buy'),
(18, NULL, 1, 5, 1, 'buy'),
(19, NULL, 1, 6, 1, 'buy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_cartitems`
--

CREATE TABLE `tb_cartitems` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detailtransaksi`
--

CREATE TABLE `tb_detailtransaksi` (
  `detail_id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah_beli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_detailtransaksi`
--

INSERT INTO `tb_detailtransaksi` (`detail_id`, `transaksi_id`, `produk_id`, `jumlah_beli`) VALUES
(6, 3, 1, 2),
(7, 3, 3, 3),
(50, 24, 3, 3),
(51, 24, 6, 1),
(52, 24, 17, 2),
(53, 25, 18, 1),
(54, 30, 14, 1),
(55, 31, 19, 1),
(56, 32, 3, 1),
(57, 33, 6, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pasar`
--

CREATE TABLE `tb_pasar` (
  `pasar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pasar` varchar(100) NOT NULL,
  `lokasi_pasar` varchar(200) NOT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pasar`
--

INSERT INTO `tb_pasar` (`pasar_id`, `user_id`, `nama_pasar`, `lokasi_pasar`, `photo`) VALUES
(1, 2, 'Pasar Jagasatru', 'Kota Cirebon', NULL),
(2, 6, 'Pasar X', 'Lokasi Pasar X', NULL),
(4, 10, 'Pasar Pabuaran', '', NULL),
(5, 12, 'Pasar Ciledug', '', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `pelanggan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat_pelanggan` varchar(200) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`pelanggan_id`, `user_id`, `nama_pelanggan`, `alamat_pelanggan`, `photo`) VALUES
(1, 3, 'Asep Saepudin', 'Desa Ciuyah', ''),
(2, 7, 'Pelanggan Z', 'Alamat Pelanggan Z', ''),
(3, 8, 'Pelanggan W', 'Alamat Pelanggan W', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk`
--

CREATE TABLE `tb_produk` (
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi_produk` text DEFAULT NULL,
  `harga_beli` varchar(50) NOT NULL,
  `harga_jual` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `penjual_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_produk`
--

INSERT INTO `tb_produk` (`produk_id`, `nama_produk`, `deskripsi_produk`, `harga_beli`, `harga_jual`, `stok`, `penjual_id`) VALUES
(1, 'Produk 1', 'Deskripsi Produk 1', '100000', '120000', 50, 1),
(2, 'Produk 2', 'Deskripsi Produk 2', '75000', '90000', 30, 1),
(3, 'Produk 5', 'Deskripsi Produk 5', '50000', '60000', 35, 2),
(4, 'Produk 4', 'Deskripsi Produk 4', '120000', '144000', 40, 2),
(5, 'Produk 5', 'Deskripsi Produk 5', '80000', '96000', 24, 3),
(6, 'Produk 6', 'Deskripsi Produk 6', '60000', '72000', 34, 3),
(7, 'Nama Produk 10', 'Deskripsi Produk 10', '70000', '84000', 5, 1),
(10, 'Produk 3', 'Deskripsi Produk 3', '25000', '30000', 20, 2),
(12, 'Produk 6', 'Deskripsi Produk', '30000', '36000', 5, 2),
(13, 'Nama Produk 11', 'Deskripsi Produk 11', '10000', '12000', 10, 2),
(14, 'Produk 13', 'Deskripsi Produk 5', '25000', '30000', 9, 2),
(15, 'Sayur Kol', 'Sayur Kol murah-murah', '10000', '12000', 20, 10),
(16, 'Produk 6', 'Deskripsi Produk 6', '23000', '27600', 25, 6),
(17, 'Produk 7', 'Deskripsi Produk 7', '10000', '12000', 20, 6),
(18, 'Buncis', '1 bungkus = 1kg Buncis', '25000', '30000', 5, 12),
(19, 'Wortel', '1 bungkus wortel = 1kg berat', '20000', '24000', 4, 12),
(57, 'Sayur Bayam', 'Deskripsi Sayur Bayam', '36000', '43200', 1, 4),
(58, 'Produk 7', NULL, '12000', '14400', 2, 4),
(59, 'Produk 5', NULL, '60000', '72000', 3, 4),
(62, 'Buncis', 'Buncis ini diambil dari petani asli', '30000', '36000', 1, 4),
(63, 'Produk 13', NULL, '30000', '36000', 1, 4),
(64, 'Wortel', NULL, '24000', '28800', 1, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_toko`
--

CREATE TABLE `tb_toko` (
  `toko_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `alamat_toko` varchar(200) DEFAULT NULL,
  `kontak_toko` varchar(50) DEFAULT NULL,
  `photo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_toko`
--

INSERT INTO `tb_toko` (`toko_id`, `user_id`, `nama_toko`, `alamat_toko`, `kontak_toko`, `photo`) VALUES
(1, 4, 'Toko A', 'Jalan Toko A No. 123', '081234567890', NULL),
(2, 5, 'Toko B', 'Jalan Toko B No. 456', '087654321098', NULL),
(3, 11, 'toko7', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `toko_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_harga` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`transaksi_id`, `toko_id`, `pelanggan_id`, `tanggal_transaksi`, `total_harga`) VALUES
(3, NULL, 2, '2023-07-27 17:00:00', 'Rp 200.000'),
(4, NULL, 3, '2023-07-28 17:00:00', 'Rp 140.000'),
(24, 1, NULL, '2023-08-04 11:49:12', '240000'),
(25, 1, NULL, '2023-08-04 12:04:36', '30000'),
(26, 1, NULL, '2023-08-04 13:05:54', '60000'),
(27, 1, NULL, '2023-08-04 13:06:47', '60000'),
(28, 1, NULL, '2023-08-04 13:08:52', '60000'),
(29, 1, NULL, '2023-08-04 13:11:18', '30000'),
(30, 1, NULL, '2023-08-04 13:11:52', '30000'),
(31, 1, NULL, '2023-08-04 13:13:46', '24000'),
(32, NULL, 1, '2023-08-04 13:45:56', '96000'),
(33, NULL, 1, '2023-08-04 13:49:01', '72000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('Toko','Pasar','Pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `username`, `password`, `user_type`) VALUES
(1, 'toko', 'toko', 'Toko'),
(2, 'pasar', 'pasar', 'Pasar'),
(3, 'pelanggan', 'pelanggan', 'Pelanggan'),
(4, 'toko1', 'password_toko1', 'Toko'),
(5, 'toko2', 'password_toko2', 'Toko'),
(6, 'pasar1', 'password_pasar1', 'Pasar'),
(7, 'pelanggan1', 'password_pelanggan1', 'Pelanggan'),
(8, 'pelanggan2', 'password_pelanggan2', 'Pelanggan'),
(10, 'pasar7', 'pasar7', 'Pasar'),
(11, 'toko7', 'toko7', 'Toko'),
(12, 'pasar2', 'pasar2', 'Pasar');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `toko_id` (`toko_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `tb_cartitems`
--
ALTER TABLE `tb_cartitems`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `tb_detailtransaksi`
--
ALTER TABLE `tb_detailtransaksi`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `tb_pasar`
--
ALTER TABLE `tb_pasar`
  ADD PRIMARY KEY (`pasar_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`pelanggan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`produk_id`),
  ADD KEY `penjual_id` (`penjual_id`);

--
-- Indeks untuk tabel `tb_toko`
--
ALTER TABLE `tb_toko`
  ADD PRIMARY KEY (`toko_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `toko_id` (`toko_id`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_cartitems`
--
ALTER TABLE `tb_cartitems`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detailtransaksi`
--
ALTER TABLE `tb_detailtransaksi`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `tb_pasar`
--
ALTER TABLE `tb_pasar`
  MODIFY `pasar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `tb_toko`
--
ALTER TABLE `tb_toko`
  MODIFY `toko_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD CONSTRAINT `tb_cart_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `tb_pelanggan` (`pelanggan_id`),
  ADD CONSTRAINT `tb_cart_ibfk_2` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`toko_id`),
  ADD CONSTRAINT `tb_cart_ibfk_3` FOREIGN KEY (`produk_id`) REFERENCES `tb_produk` (`produk_id`);

--
-- Ketidakleluasaan untuk tabel `tb_cartitems`
--
ALTER TABLE `tb_cartitems`
  ADD CONSTRAINT `tb_cartitems_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `tb_cart` (`cart_id`),
  ADD CONSTRAINT `tb_cartitems_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `tb_produk` (`produk_id`);

--
-- Ketidakleluasaan untuk tabel `tb_detailtransaksi`
--
ALTER TABLE `tb_detailtransaksi`
  ADD CONSTRAINT `tb_detailtransaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `tb_transaksi` (`transaksi_id`),
  ADD CONSTRAINT `tb_detailtransaksi_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `tb_produk` (`produk_id`);

--
-- Ketidakleluasaan untuk tabel `tb_pasar`
--
ALTER TABLE `tb_pasar`
  ADD CONSTRAINT `tb_pasar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD CONSTRAINT `tb_pelanggan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD CONSTRAINT `tb_produk_ibfk_1` FOREIGN KEY (`penjual_id`) REFERENCES `tb_users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `tb_toko`
--
ALTER TABLE `tb_toko`
  ADD CONSTRAINT `tb_toko_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `tb_pelanggan` (`pelanggan_id`),
  ADD CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`toko_id`) REFERENCES `tb_toko` (`toko_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2025 at 07:29 AM
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
-- Database: `skafarm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `kode_barang` int NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` int NOT NULL,
  `harga_total` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `kode_barang`, `qty`, `harga_satuan`, `harga_total`) VALUES
(14, 24, 38, 1, 10000, 10000),
(15, 25, 38, 1, 10000, 10000),
(16, 26, 37, 1, 50000, 50000),
(17, 27, 38, 1, 10000, 10000),
(18, 28, 36, 1, 25000, 25000),
(19, 29, 35, 1, 12000, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_barang` int NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga` bigint NOT NULL,
  `img` text NOT NULL,
  `stok` int NOT NULL,
  `kode_gudang` int NOT NULL,
  `kategori_id` int NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`kode_barang`, `nama_barang`, `satuan`, `harga`, `img`, `stok`, `kode_gudang`, `kategori_id`, `deskripsi`) VALUES
(9, 'Jeruk', 'kg', 20000, 'prd_68dbfe6711720.jpg', 4, 5, 12, 'Jeruk Yang Sangat Enak'),
(10, 'Bayam', 'gram', 20000, 'prd_68dbfebd50e61.jpg', 33, 6, 11, 'Bayam Segarr Menyehatkan'),
(11, 'Jamu', 'liter', 20000, 'prd_68dbff0d01510.jpg', 22, 7, 13, 'Jamu Segar'),
(12, 'Benih Bunga Matahari', 'pcs', 1000000, 'prd_68dbff6e5f499.jpg', 44, 6, 16, 'Benih Bunga'),
(13, 'Pupuk ', 'kg', 20000, 'prd_68dbffb211cde.jpg', 66, 6, 17, 'Pupuk Besar'),
(34, 'Tomat', 'kg', 15000, 'prd_68dc00c526192.png', 50, 5, 11, 'Tomat segar langsung dari kebun hidroponik'),
(35, 'Semangka', 'kg', 12000, 'prd_68dc00ddf2fe7.jpg', 40, 6, 12, 'Semangka manis dan berair'),
(36, 'Kunyit', 'kg', 25000, 'prd_68dc0105b890d.jpg', 60, 7, 13, 'Kunyit segar untuk herbal dan bumbu'),
(37, 'Cangkul', 'pcs', 50000, 'prd_68dc011e9ffcc.jpg', 25, 8, 19, 'Alat pertanian untuk menggemburkan tanah'),
(38, 'Keripik Bayam', 'pcs', 10000, 'prd_68dc01455429f.jpeg', 100, 9, 21, 'Camilan sehat berbahan bayam segar');

-- --------------------------------------------------------

--
-- Table structure for table `master_blog`
--

CREATE TABLE `master_blog` (
  `id_blog` int NOT NULL,
  `kode_user` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `artikel` text NOT NULL,
  `img` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_blog`
--

INSERT INTO `master_blog` (`id_blog`, `kode_user`, `judul`, `artikel`, `img`, `created_at`) VALUES
(2, 15, 'Tips Menanam Tomat Hidroponik', 'Tomat hidroponik dapat tumbuh lebih cepat dan sehat jika diberi nutrisi AB mix yang seimbang serta pencahayaan cukup. Artikel ini membahas langkah demi langkah perawatan tomat hidroponik di rumah.', 'prd_68dc028165334.jpg', '2025-09-01'),
(3, 15, 'Manfaat Pupuk Organik untuk Tanaman', 'Pupuk organik membantu memperbaiki struktur tanah dan menjaga kelembaban. Selain itu, penggunaannya lebih ramah lingkungan dibanding pupuk kimia.', 'prd_68dc0331b1ee9.jpeg', '2025-09-05'),
(4, 15, 'Rahasia Bayam Segar dan Hijau', 'Bayam yang segar biasanya ditanam di tanah gembur dengan irigasi cukup. Petani juga bisa memanfaatkan pupuk cair alami dari sisa sayuran.', 'prd_68dc031a90828.jpg', '2025-09-10'),
(5, 15, 'Pentingnya Sensor IoT di Smart Farm', 'Sensor IoT dapat membantu petani memantau suhu, kelembaban, dan nutrisi tanaman secara real-time. Hal ini mendukung efisiensi dan produktivitas pertanian modern.', 'prd_68dc02a3a6cc0.jpg', '2025-09-15'),
(6, 15, 'Olahan Sehat dari Hasil Panen', 'Hasil panen seperti singkong, bayam, dan pisang bisa diolah menjadi camilan sehat seperti keripik dan smoothie. Ini membuka peluang usaha bagi petani muda.', 'prd_68dc02ed1f3e7.jpg', '2025-09-20'),
(7, 15, 'Masa Depan Pertanian Berkelanjutan', 'Pertanian berkelanjutan menekankan keseimbangan antara produksi pangan dan kelestarian alam. Teknologi modern, pupuk organik, dan energi terbarukan adalah kunci utama.', 'prd_68dc03bc2925f.jpg', '2025-09-25');

-- --------------------------------------------------------

--
-- Table structure for table `master_cart`
--

CREATE TABLE `master_cart` (
  `id_cart` int NOT NULL,
  `kode_user` int NOT NULL,
  `kode_barang` int NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` int NOT NULL,
  `subtotal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_cart`
--

INSERT INTO `master_cart` (`id_cart`, `kode_user`, `kode_barang`, `qty`, `harga_satuan`, `subtotal`) VALUES
(6, 15, 10, 1, 20000, 20000),
(7, 15, 36, 1, 25000, 25000),
(8, 15, 34, 1, 15000, 15000),
(9, 15, 38, 1, 10000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `master_gudang`
--

CREATE TABLE `master_gudang` (
  `kode_gudang` int NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `golongan` varchar(255) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_gudang`
--

INSERT INTO `master_gudang` (`kode_gudang`, `nama_gudang`, `golongan`, `keterangan`) VALUES
(5, 'Gudang A', 'Sayur', 'Menyimpan berbagai sayuran segar seperti bayam, sawi, kangkung, dan selada'),
(6, 'Gudang B', 'Buah', 'Tempat penyimpanan buah segar hasil panen seperti semangka, melon, dan pepaya'),
(7, 'Gudang C', 'Pupuk', 'Berisi pupuk organik dan kimia untuk mendukung pertumbuhan tanaman'),
(8, 'Gudang D', 'Alat', 'Menyimpan alat pertanian seperti cangkul, sprayer, selang, dan sensor IoT'),
(9, 'Gudang E', 'Lainnya', 'Gudang serbaguna untuk menyimpan kebutuhan tambahan Smart Farm');

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE `master_kategori` (
  `kode_kategori` int NOT NULL,
  `img` text NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kode_kategori`, `img`, `nama_kategori`) VALUES
(11, 'kat_68dbfa4eb0e6b.png', 'Sayur'),
(12, 'kat_68dbfa6af32d0.png', 'Buah'),
(13, 'kat_68dbfb61d823a.png', 'Herbal'),
(14, 'kat_68dbfb688567a.png', 'Padi'),
(15, 'kat_68dbfbe33e0af.png', 'Palawija'),
(16, 'kat_68dbfb7a6d103.png', 'Benih'),
(17, 'kat_68dbfb8245dd7.png', 'Pupuk'),
(18, 'kat_68dbfb89c9dd5.png', 'Obat'),
(19, 'kat_68dbfb9222dc2.png', 'Alat'),
(20, 'kat_68dbfb9ae8f9e.png', 'Panen'),
(21, 'kat_68dbfba2c1d9d.png', 'Olahan');

-- --------------------------------------------------------

--
-- Table structure for table `master_transaksi`
--

CREATE TABLE `master_transaksi` (
  `id_transaksi` int NOT NULL,
  `kode_transaksi` varchar(500) NOT NULL,
  `kode_user` int NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_harga` int NOT NULL,
  `status` enum('pending','selesai') NOT NULL DEFAULT 'pending',
  `metode_pembayaran` enum('tunai','ovo','gopay','qris') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_transaksi`
--

INSERT INTO `master_transaksi` (`id_transaksi`, `kode_transaksi`, `kode_user`, `tanggal_transaksi`, `total_harga`, `status`, `metode_pembayaran`, `alamat`) VALUES
(24, 'TRX1759249392', 15, '2025-09-30', 10000, 'pending', 'qris', 'Krian'),
(25, 'TRX1759249405', 15, '2025-09-30', 10000, 'pending', 'gopay', 'Surabaya'),
(26, 'TRX1761031187', 16, '2025-10-21', 50000, 'pending', 'tunai', 'Kcak'),
(27, 'TRX1761031318', 16, '2025-10-21', 10000, 'pending', 'tunai', 'd'),
(28, 'TRX1761031402', 15, '2025-10-21', 25000, 'pending', 'tunai', 'ds'),
(29, 'TRX1761031603', 15, '2025-10-21', 12000, 'pending', 'tunai', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `kode_user` int NOT NULL,
  `role` enum('admin','pengunjung') NOT NULL DEFAULT 'pengunjung',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`kode_user`, `role`, `username`, `email`, `password`) VALUES
(14, 'admin', 'admin', 'admin@gmail.com', '$2y$10$V0ETFxhhYJC38mjbmtrXqOWks9PENxcuTqkW0qtpmeLuTVW4LSsge'),
(15, 'pengunjung', 'user', 'user@gmail.com', '$2y$10$kpqmv5uQCm5GIyBl.vDJs.ZqqTuqgLZs58WqBwGUKlIEsOETfnPlG'),
(16, 'pengunjung', 'arek', 'arek@gmail.com', '$2y$10$I9YGZ67WleJgZrdrU0G2NuSCgPIn4KY4FBGU9XqXBd631bjITs.ta');

-- --------------------------------------------------------

--
-- Table structure for table `products_ratings`
--

CREATE TABLE `products_ratings` (
  `id_rating` int NOT NULL,
  `user_id` int NOT NULL,
  `kode_barang` int NOT NULL,
  `kode_transaksi` varchar(500) NOT NULL,
  `rating` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products_ratings`
--

INSERT INTO `products_ratings` (`id_rating`, `user_id`, `kode_barang`, `kode_transaksi`, `rating`, `comment`, `created_at`) VALUES
(3, 15, 38, 'TRX1759249392', 4, 'Poke ', '2025-10-21 00:00:00'),
(4, 15, 36, 'TRX1761031402', 4, 'Kocak a', '2025-10-21 00:00:00'),
(5, 16, 37, 'TRX1761031187', 4, 'Poke ', '2025-10-21 00:00:00'),
(6, 16, 38, 'TRX1761031318', 2, 'Mantap', '2025-10-21 00:00:00'),
(8, 15, 35, 'TRX1761031603', 4, 'Poke a\r\n', '2025-10-21 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `transaksi_detail` (`id_transaksi`),
  ADD KEY `detail_barang` (`kode_barang`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `barang_gudang` (`kode_gudang`),
  ADD KEY `kategori_barang` (`kategori_id`);

--
-- Indexes for table `master_blog`
--
ALTER TABLE `master_blog`
  ADD PRIMARY KEY (`id_blog`),
  ADD KEY `user_blog` (`kode_user`);

--
-- Indexes for table `master_cart`
--
ALTER TABLE `master_cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `user_cart` (`kode_user`),
  ADD KEY `cart_barang` (`kode_barang`);

--
-- Indexes for table `master_gudang`
--
ALTER TABLE `master_gudang`
  ADD PRIMARY KEY (`kode_gudang`);

--
-- Indexes for table `master_kategori`
--
ALTER TABLE `master_kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `user_transaksi` (`kode_user`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`kode_user`);

--
-- Indexes for table `products_ratings`
--
ALTER TABLE `products_ratings`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `user_rating` (`user_id`),
  ADD KEY `product_rating` (`kode_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `master_barang`
--
ALTER TABLE `master_barang`
  MODIFY `kode_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `master_blog`
--
ALTER TABLE `master_blog`
  MODIFY `id_blog` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `master_cart`
--
ALTER TABLE `master_cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_gudang`
--
ALTER TABLE `master_gudang`
  MODIFY `kode_gudang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_kategori`
--
ALTER TABLE `master_kategori`
  MODIFY `kode_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `kode_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products_ratings`
--
ALTER TABLE `products_ratings`
  MODIFY `id_rating` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_barang` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail` FOREIGN KEY (`id_transaksi`) REFERENCES `master_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD CONSTRAINT `barang_gudang` FOREIGN KEY (`kode_gudang`) REFERENCES `master_gudang` (`kode_gudang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kategori_barang` FOREIGN KEY (`kategori_id`) REFERENCES `master_kategori` (`kode_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_blog`
--
ALTER TABLE `master_blog`
  ADD CONSTRAINT `user_blog` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_cart`
--
ALTER TABLE `master_cart`
  ADD CONSTRAINT `cart_barang` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_cart` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD CONSTRAINT `user_transaksi` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_ratings`
--
ALTER TABLE `products_ratings`
  ADD CONSTRAINT `product_rating` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_rating` FOREIGN KEY (`user_id`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

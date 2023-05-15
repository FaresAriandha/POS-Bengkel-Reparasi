-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2023 at 07:33 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uts_ci4`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int(11) NOT NULL,
  `kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id`, `kategori`) VALUES
(1, 'Ban'),
(2, 'Oli');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `id` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `foto_barang` varchar(255) NOT NULL,
  `jenis_barang` int(11) DEFAULT NULL,
  `kuantitas` int(5) NOT NULL,
  `harga_per_satuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`id`, `nama_barang`, `foto_barang`, `jenis_barang`, `kuantitas`, `harga_per_satuan`) VALUES
(3, 'FDR Ring 14, 2023', 'FDR Ring 14, 2023_1684060456.jpg', 1, 30, 220000),
(4, 'Castrol Matic', 'Castrol Matic_1684060560.jpg', 2, 100, 100000),
(5, 'Yamalube XP 50', 'Yamalube XP 50_1684072614.jpg', 2, 10, 40000),
(6, 'Yamalube Gold Motor Oil', 'Yamalube Gold Motor Oil_1684073549.jpg', 2, 20, 50000),
(7, 'Federal Ring 14', 'Federal Ring 14_1684073879.jpg', 1, 10, 250000),
(8, 'FDR Ring 16, 2023', 'FDR Ring 16, 2023_1684073957.jpg', 1, 10, 300000);

-- --------------------------------------------------------

--
-- Table structure for table `master_karyawan`
--

CREATE TABLE `master_karyawan` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `foto_karyawan` varchar(255) NOT NULL,
  `no_tlp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `id_akun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_karyawan`
--

INSERT INTO `master_karyawan` (`id`, `nama_karyawan`, `jenis_kelamin`, `foto_karyawan`, `no_tlp`, `alamat`, `id_akun`) VALUES
(3, 'Ucup Surucup', 'Laki-laki', 'Ucup Surucup_1684128704.jpg', '087837483', 'Jl. Lorem Ipsum Dolor Amet', 9);

-- --------------------------------------------------------

--
-- Table structure for table `master_pengguna`
--

CREATE TABLE `master_pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL DEFAULT 'kasir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_pengguna`
--

INSERT INTO `master_pengguna` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin123', 'admin@gmail.com', '$2y$10$vxzPsqoV75Qo0sMtJCNDAuU6t/4jBUegxvgMRpyyz2wfQ.Temka9W', 'admin'),
(2, 'ad12', 'asas', '1sasas', 'kasir'),
(9, 'EMP1684128704', 'ucup123456@gmail.com', '$2y$10$I2sPnfFd9QlZ19m1fKKg5eFJkhdu6n01NSUeopcaA6gPUJYvx1vhO', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_barang_jenis` (`jenis_barang`);

--
-- Indexes for table `master_karyawan`
--
ALTER TABLE `master_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_karyawan_akun` (`id_akun`);

--
-- Indexes for table `master_pengguna`
--
ALTER TABLE `master_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_barang`
--
ALTER TABLE `master_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_karyawan`
--
ALTER TABLE `master_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_pengguna`
--
ALTER TABLE `master_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD CONSTRAINT `fk_barang_jenis` FOREIGN KEY (`jenis_barang`) REFERENCES `jenis_barang` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `master_karyawan`
--
ALTER TABLE `master_karyawan`
  ADD CONSTRAINT `fk_karyawan_akun` FOREIGN KEY (`id_akun`) REFERENCES `master_pengguna` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

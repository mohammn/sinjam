-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2022 at 05:46 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sinjam`
--

-- --------------------------------------------------------

--
-- Table structure for table `cicilan`
--

CREATE TABLE `cicilan` (
  `id` int(11) NOT NULL,
  `idPinjaman` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `petugas` varchar(32) NOT NULL,
  `sisa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cicilan`
--

INSERT INTO `cicilan` (`id`, `idPinjaman`, `nominal`, `tanggal`, `petugas`, `sisa`) VALUES
(0, 3, 5000, '2022-02-05 23:31:18', '1', 200000),
(0, 2, 2000, '2022-02-05 23:33:15', '1', 98000),
(0, 3, 22000, '2022-02-05 23:54:08', '1', 178000),
(0, 3, 179000, '2022-02-05 23:55:26', '1', 21000),
(0, 3, 200000, '2022-02-06 00:04:01', '1', 0),
(0, 3, 200000, '2022-02-06 00:07:39', '1', 0),
(0, 2, 50000, '2022-02-06 00:08:35', '1', 50000),
(0, 2, 60000, '2022-02-06 00:09:42', '1', -10000),
(0, 3, 20000, '2022-02-06 23:26:55', 'moham', 180000),
(0, 3, 190000, '2022-02-06 23:27:15', 'moham', -10000),
(0, 4, 10000, '2022-02-08 23:09:42', 'moham', 90000);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `nik` varchar(16) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `telp` varchar(14) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `foto` varchar(20) DEFAULT 'default.jpg',
  `saldo` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`nik`, `nama`, `telp`, `alamat`, `foto`, `saldo`, `status`, `tanggal`) VALUES
('02020', 'tes lagi', '092930129123', 'Desa Milyader', '02020.jpg', 10000, 1, '2022-02-02 23:20:34'),
('3522020202020202', 'Moham', '083479502893', 'Desa Suka Maju Mundur', '3522020202020202.jpg', 41000, 1, '2022-02-01 23:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `keterangan` varchar(32) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `petugas` varchar(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `cicilan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `nik`, `keterangan`, `nominal`, `tanggal`, `petugas`, `status`, `cicilan`) VALUES
(1, '02020', 'tes pinjam', 100000, '2022-02-04 16:41:47', '1', 0, 0),
(2, '02020', 'tes pinjam lagi', 100000, '2022-02-04 16:41:47', '1', 1, 110000),
(3, '3522020202020202', 'tes hemm', 200000, '0000-00-00 00:00:00', '1', 1, 210000),
(4, '3522020202020202', 'buat beli bensin', 100000, '0000-00-00 00:00:00', 'moham', 0, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(64) NOT NULL,
  `petugas` varchar(32) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `nik`, `nominal`, `tanggal`, `keterangan`, `petugas`, `saldo`) VALUES
(1, '02020', 12000, '2022-02-03 23:41:34', 'Nabung', '1', 12000),
(2, '3522020202020202', 10000, '2022-02-04 22:25:32', 'nabung awal', '1', 0),
(3, '3522020202020202', 11000, '2022-02-04 22:30:02', 'nabung tes', '1', 0),
(4, '3522020202020202', 20000, '2022-02-04 22:31:18', 'hehe', '1', 51000),
(5, '3522020202020202', -10000, '2022-02-04 22:31:42', 'buat beli pentoll', '1', 41000),
(6, '02020', 10000, '2022-02-06 23:12:33', 'menabung', 'moham', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `rule` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `password`, `rule`) VALUES
(1, 'moham', '$2y$10$c9uLmJ5y/hCdrAr/.5nRru3MN5vTrzrk.fn5sZwV0VGag/DjJfVIO', 1),
(2, 'reni', '$2y$10$AU73h9zwZ7Hilg9d5r1mjuQSbQZhJkGfgApmUjFVBdb2lvCGx53yy', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2022 at 03:58 AM
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
(0, 3, 190000, '2022-02-06 23:27:15', 'moham', -10000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

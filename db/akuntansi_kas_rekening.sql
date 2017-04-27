-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2017 at 04:40 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_kas_rekening`
--

CREATE TABLE IF NOT EXISTS `akuntansi_kas_rekening` (
  `id` int(11) NOT NULL,
  `kode_rekening` varchar(20) NOT NULL,
  `uraian` varchar(255) NOT NULL,
  `kode_unit` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_kas_rekening`
--

INSERT INTO `akuntansi_kas_rekening` (`id`, `kode_rekening`, `uraian`, `kode_unit`) VALUES
(1, '111101', 'Kas Bank Mandiri Operasional BLU No Rek. 1360020080005', 'all'),
(2, '111102', 'Kas Bank Mandiri Operasional BLU BPP FH No Rek. 1360020080013', '11'),
(3, '111103', 'Kas Bank Mandiri Operasional BLU BPP FE No Rek. 1360020080021', '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_kas_rekening`
--
ALTER TABLE `akuntansi_kas_rekening`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_kas_rekening`
--
ALTER TABLE `akuntansi_kas_rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

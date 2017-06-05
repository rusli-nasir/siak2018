-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2017 at 01:06 AM
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
-- Table structure for table `akuntansi_saldo`
--

CREATE TABLE IF NOT EXISTS `akuntansi_saldo` (
  `id` int(11) NOT NULL,
  `akun` varchar(50) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `saldo_awal` bigint(20) NOT NULL,
  `saldo_sekarang` bigint(20) NOT NULL,
  `saldo_kredit_awal` bigint(20) NOT NULL,
  `saldo_kredit_sekarang` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_saldo`
--

INSERT INTO `akuntansi_saldo` (`id`, `akun`, `tahun`, `saldo_awal`, `saldo_sekarang`, `saldo_kredit_awal`, `saldo_kredit_sekarang`) VALUES
(2, '111101', '2017', 123, 0, 0, 0),
(3, '111109', '2016', 4500000, 4203000, 0, 0),
(4, '311101', '2017', 500000000, 500000000, 0, 0),
(6, '212204', '2017', 5673002, 5673000, 0, 0),
(7, '321301', '2017', 7562000, 7562000, 0, 0),
(8, '111101', '2016', 5022, 5021, 21, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_saldo`
--
ALTER TABLE `akuntansi_saldo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_saldo`
--
ALTER TABLE `akuntansi_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

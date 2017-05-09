-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2017 at 05:19 AM
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
  `saldo_sekarang` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_saldo`
--

INSERT INTO `akuntansi_saldo` (`id`, `akun`, `tahun`, `saldo_awal`, `saldo_sekarang`) VALUES
(2, '111101', '2017', 123, 0),
(3, '111109', '2016', 4500000, 4203000),
(4, '311101', '2017', 500000000, 500000000),
(6, '212204', '2017', 5673002, 5673000),
(7, '321301', '2017', 7562000, 7562000);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

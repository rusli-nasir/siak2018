-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2017 at 03:49 AM
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
-- Table structure for table `akuntansi_user`
--

CREATE TABLE IF NOT EXISTS `akuntansi_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level` int(1) NOT NULL,
  `kode_unit` varchar(10) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_user`
--

INSERT INTO `akuntansi_user` (`id`, `username`, `password`, `level`, `kode_unit`, `aktif`) VALUES
(1, 'operator', 'fe96dd39756ac41b74283a9292652d366d73931f', 1, '', 1),
(2, 'verifikator', '89419c696ec663c93d47106d1d77841dd23be4d5', 2, '', 1),
(3, 'posting', '77f0dc34eb53c77ac74f359def94bcab7138398a', 3, '', 1),
(4, '11', '17ba0791499db908433b80f37c5fbc89b870084b', 1, '11', 1),
(5, '12', '7b52009b64fd0a2a49e6d8a939753077792b0554', 1, '12', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_user`
--
ALTER TABLE `akuntansi_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_user`
--
ALTER TABLE `akuntansi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

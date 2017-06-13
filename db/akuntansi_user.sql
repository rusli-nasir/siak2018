-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2017 at 05:40 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

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

CREATE TABLE `akuntansi_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level` int(1) NOT NULL,
  `kode_unit` varchar(10) NOT NULL,
  `kode_user` varchar(50) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_user`
--

INSERT INTO `akuntansi_user` (`id`, `username`, `password`, `level`, `kode_unit`, `kode_user`, `aktif`) VALUES
(1, 'operator', 'fe96dd39756ac41b74283a9292652d366d73931f', 1, '', '', 1),
(2, 'verifikator11', '299a07b3520b2b641eaa4707c6c32b9dd6c14b98', 2, '11', 'FHU-01', 1),
(3, 'universitas', '223be9d546a4de0ec20c80f3935d82a0171f793f', 3, '', '', 1),
(4, '11', '17ba0791499db908433b80f37c5fbc89b870084b', 1, '11', 'FHU-02', 1),
(5, '12', '7b52009b64fd0a2a49e6d8a939753077792b0554', 1, '12', '', 1),
(6, 'verifikator12', '81d8ded81fd42420751bdcde96fe2fed172db66a', 2, '12', 'X3', 1),
(7, 'verifikator', '89419c696ec663c93d47106d1d77841dd23be4d5', 2, '', 'X1', 1),
(8, '16', '1574bddb75c78a6fd2251d61e2993b5146201319', 1, '16', '', 1),
(9, '42', '92cfceb39d57d914ed8b14d0e37643de0797ae56', 1, '42', '', 1),
(10, '13', 'bd307a3ec329e10a2cff8fb87480823da114f8f4', 1, '13', '', 1),
(11, '14', 'fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 1, '14', '', 1),
(12, '15', 'f1abd670358e036c31296e66b3b66c382ac00812', 1, '15', '', 1),
(13, 'verifikator13', '3a9e7469da0fe93cc17b98f2bac174c6566b78a4', 2, '13', 'X4', 1),
(14, 'verifikator14', '930d6a1270ac2483bd27f52344f3fe67a3959826', 2, '14', 'X5', 1),
(15, 'verifikator15', 'f7d456e464128a32e76f175a561b617f29acfae2', 2, '15', 'X6', 1),
(16, 'verifikator16', 'e7b035e597f171a4e9ea2f5fbb81ca72b03cdd18', 2, '16', 'X7', 1),
(17, 'fhu03', '42a95376f36763fde7490e6d8535033fc3f36fae', 1, '11', 'FHU-03', 1),
(18, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 9, '', '', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

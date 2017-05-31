-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2017 at 05:56 AM
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
-- Table structure for table `akuntansi_pajak`
--

CREATE TABLE `akuntansi_pajak` (
  `id_akun_pajak` int(11) NOT NULL,
  `kode_akun` varchar(255) NOT NULL,
  `nama_akun` varchar(255) NOT NULL,
  `jenis_pajak` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pajak`
--

INSERT INTO `akuntansi_pajak` (`id_akun_pajak`, `kode_akun`, `nama_akun`, `jenis_pajak`) VALUES
(1, '411121', 'Pendapatan PPh Pasal 21', 'PPh_Ps_21'),
(2, '411122', 'Pendapatan PPh Pasal 22', 'PPh_Ps_22'),
(3, '411124', 'Pendapatan PPh Pasal 23', 'PPh_Ps_23'),
(4, '411127', 'Pendapatan PPh Pasal 26', 'PPh_Ps_26'),
(5, '411128', 'Pendapatan PPh Final', 'PPh_final'),
(6, '411211', 'Pendapatan PPN Dalam Negeri', 'PPN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_pajak`
--
ALTER TABLE `akuntansi_pajak`
  ADD PRIMARY KEY (`id_akun_pajak`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_pajak`
--
ALTER TABLE `akuntansi_pajak`
  MODIFY `id_akun_pajak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

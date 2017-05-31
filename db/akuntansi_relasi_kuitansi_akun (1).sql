-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2017 at 05:57 AM
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
-- Table structure for table `akuntansi_relasi_kuitansi_akun`
--

CREATE TABLE `akuntansi_relasi_kuitansi_akun` (
  `id_relasi_kuitansi_akun` int(11) NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `id_kuitansi_jadi` int(11) NOT NULL,
  `tipe` varchar(40) NOT NULL,
  `akun` varchar(40) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `jenis` varchar(40) NOT NULL,
  `persen_pajak` float DEFAULT NULL,
  `jenis_pajak` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_relasi_kuitansi_akun`
--
ALTER TABLE `akuntansi_relasi_kuitansi_akun`
  ADD PRIMARY KEY (`id_relasi_kuitansi_akun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_relasi_kuitansi_akun`
--
ALTER TABLE `akuntansi_relasi_kuitansi_akun`
  MODIFY `id_relasi_kuitansi_akun` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

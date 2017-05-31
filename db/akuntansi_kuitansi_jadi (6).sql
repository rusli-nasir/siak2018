-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2017 at 05:58 AM
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
-- Table structure for table `akuntansi_kuitansi_jadi`
--

CREATE TABLE `akuntansi_kuitansi_jadi` (
  `id_kuitansi_jadi` int(11) NOT NULL,
  `id_kuitansi` int(11) DEFAULT NULL,
  `no_bukti` varchar(50) NOT NULL,
  `no_spm` varchar(150) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `tanggal_bukti` date DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `kode_kegiatan` varchar(100) DEFAULT NULL,
  `unit_kerja` int(11) NOT NULL,
  `uraian` text NOT NULL,
  `jenis_pembatasan_dana` varchar(100) NOT NULL,
  `akun_debet` varchar(10) NOT NULL,
  `akun_debet_akrual` varchar(10) NOT NULL,
  `jumlah_debet` bigint(20) NOT NULL,
  `akun_kredit` varchar(10) NOT NULL,
  `akun_kredit_akrual` varchar(10) NOT NULL,
  `jumlah_kredit` bigint(20) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `flag` int(2) NOT NULL,
  `kode_user` varchar(255) NOT NULL,
  `tanggal_jurnal` datetime NOT NULL,
  `tanggal_verifikasi` datetime NOT NULL,
  `tanggal_posting` datetime NOT NULL,
  `status` enum('proses','terima','revisi','posted','direvisi') NOT NULL,
  `has_pajak` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_kuitansi_jadi`
--
ALTER TABLE `akuntansi_kuitansi_jadi`
  ADD PRIMARY KEY (`id_kuitansi_jadi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_kuitansi_jadi`
--
ALTER TABLE `akuntansi_kuitansi_jadi`
  MODIFY `id_kuitansi_jadi` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2017 at 05:49 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_kuitansi_jadi`
--

CREATE TABLE IF NOT EXISTS `akuntansi_kuitansi_jadi` (
  `id_kuitansi_jadi` int(11) NOT NULL AUTO_INCREMENT,
  `id_kuitansi` int(11) NOT NULL,
  `no_bukti` varchar(50) NOT NULL,
  `no_spm` varchar(150) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `kode_kegiatan` varchar(100) NOT NULL,
  `unit_kerja` int(11) NOT NULL,
  `uraian` text NOT NULL,
  `jenis_pembatasan_dana` varchar(100) NOT NULL,
  `akun_debet` varchar(10) NOT NULL,
  `akun_debet_akrual` varchar(10) NOT NULL,
  `jumlah_debet` bigint(20) NOT NULL,
  `akun_kredit` varchar(10) NOT NULL,
  `akun_kredit_akrual` varchar(10) NOT NULL,
  `jumlah_kredit` bigint(20) NOT NULL,
  `flag` int(2) NOT NULL,
  `status` enum('proses','terima','revisi','posted','direvisi') NOT NULL,
  PRIMARY KEY (`id_kuitansi_jadi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

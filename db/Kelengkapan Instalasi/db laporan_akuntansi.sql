-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 05, 2017 at 11:52 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laporan_akuntansi`
--

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_kuitansi_jadi`
--

CREATE TABLE IF NOT EXISTS `akuntansi_kuitansi_jadi` (
  `id_kuitansi_jadi` int(11) NOT NULL AUTO_INCREMENT,
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
  `id_pajak` int(11) DEFAULT '0',
  PRIMARY KEY (`id_kuitansi_jadi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5367 ;

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_relasi_kuitansi_akun`
--

CREATE TABLE IF NOT EXISTS `akuntansi_relasi_kuitansi_akun` (
  `id_relasi_kuitansi_akun` int(11) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(20) NOT NULL,
  `id_kuitansi_jadi` int(11) NOT NULL,
  `tipe` varchar(40) NOT NULL,
  `akun` varchar(40) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `jenis` varchar(40) NOT NULL,
  `persen_pajak` float DEFAULT NULL,
  `jenis_pajak` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_relasi_kuitansi_akun`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1589 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

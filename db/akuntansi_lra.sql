-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2017 at 10:16 PM
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
-- Table structure for table `akuntansi_lra_1`
--

CREATE TABLE IF NOT EXISTS `akuntansi_lra_1` (
  `id_akuntansi_lra_1` int(11) NOT NULL AUTO_INCREMENT,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_akuntansi_lra_1`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `akuntansi_lra_1`
--

INSERT INTO `akuntansi_lra_1` (`id_akuntansi_lra_1`, `akun_1`, `nama`) VALUES
(1, '4', 'PENDAPATAN');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_lra_2`
--

CREATE TABLE IF NOT EXISTS `akuntansi_lra_2` (
  `id_akuntansi_lra_2` int(11) NOT NULL AUTO_INCREMENT,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_akuntansi_lra_2`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `akuntansi_lra_2`
--

INSERT INTO `akuntansi_lra_2` (`id_akuntansi_lra_2`, `akun_1`, `akun_2`, `nama`) VALUES
(1, '4', '41', 'PENDAPATAN APBN'),
(2, '4', '42', 'PENDAPATAN SELAIN APBN');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_lra_3`
--

CREATE TABLE IF NOT EXISTS `akuntansi_lra_3` (
  `id_akuntansi_lra_3` int(11) NOT NULL AUTO_INCREMENT,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_akuntansi_lra_3`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `akuntansi_lra_3`
--

INSERT INTO `akuntansi_lra_3` (`id_akuntansi_lra_3`, `akun_1`, `akun_2`, `akun_3`, `nama`) VALUES
(1, '4', '41', '411', 'PENDAPATAN PENDANAAN BELANJA PEGAWAI'),
(2, '4', '41', '412', 'PENDAPATAN BANTUAN PENDANAAN PERGURUAN TINGGI NEGERI BADAN HUKUM (BP PTNBH)'),
(3, '4', '41', '413', 'PENDAPATAN APBN LAINNYA'),
(4, '4', '42', '421', 'PENDAPATAN LAYANAN PENDIDIKAN '),
(5, '4', '42', '422', 'PENDAPATAN DARI MASYARAKAT '),
(6, '4', '42', '423', 'PENDAPATAN USAHA PTN BH'),
(7, '4', '42', '424', 'PENDAPATAN KERJASAMA'),
(8, '4', '42', '425', 'PENDAPATAN PENGELOLAAN DANA ABADI'),
(9, '4', '42', '426', 'PENDAPATAN PENGELOLAAN KEKAYAAN PTNBH'),
(10, '4', '42', '427', 'PENDAPATAN BANTUAN DARI PEMERINTAH DAERAH'),
(11, '4', '42', '428', 'PENDAPATAN  JASA PERBANKAN DAN INVESTASI'),
(12, '4', '42', '429', 'PENDAPATAN LAINNYA');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_lra_4`
--

CREATE TABLE IF NOT EXISTS `akuntansi_lra_4` (
  `id_akuntansi_lra_4` int(11) NOT NULL AUTO_INCREMENT,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_akuntansi_lra_4`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `akuntansi_lra_4`
--

INSERT INTO `akuntansi_lra_4` (`id_akuntansi_lra_4`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `nama`) VALUES
(1, '4', '41', '411', '4111', 'Pendapatan Pendanaan Gaji PNS'),
(2, '4', '41', '411', '4112', 'Pendapatan Pendanaan Tunjangan PNS'),
(3, '4', '41', '411', '4113', 'Pendapatan Pendanaan Tunjangan Lain PNS'),
(4, '4', '41', '412', '4121', 'Pendapatan Bantuan Pendanaan Perguruan Tinggi Negeri Badan Hukum (BP PTNBH)'),
(5, '4', '41', '413', '4131', 'Pendapatan APBN Lainnya'),
(6, '4', '42', '421', '4211', 'PENDAPATAN LAYANAN PENDIDIKAN UTAMA'),
(7, '4', '42', '421', '4212', 'PENDAPATAN LAYANAN PENDUKUNG PENDIDIKAN '),
(8, '4', '42', '422', '4221', 'PENDAPATAN DARI MASYARAKAT'),
(9, '4', '42', '423', '4231', 'PENDAPATAN USAHA PTN BH'),
(10, '4', '42', '424', '4241', 'PENDAPATAN KERJASAMA TRI DHARMA'),
(11, '4', '42', '424', '4242', 'PENDAPATAN KERJASAMA PENDUKUNG TRI DHARMA'),
(12, '4', '42', '425', '4251', 'PENDAPATAN PENGELOLAAN DANA ABADI'),
(13, '4', '42', '426', '4261', 'PENDAPATAN PENGELOLAAN KEKAYAAN PTNBH'),
(14, '4', '42', '427', '4271', 'PENDAPATAN BANTUAN DARI PEMERINTAH DAERAH'),
(15, '4', '42', '428', '4281', 'PENDAPATAN JASA PERBANKAN'),
(16, '4', '42', '428', '4282', 'PENDAPATAN INVESTASI'),
(17, '4', '42', '429', '4291', 'PENDAPATAN LAINNYA');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_lra_6`
--

CREATE TABLE IF NOT EXISTS `akuntansi_lra_6` (
  `id_akuntansi_lra_6` int(11) NOT NULL AUTO_INCREMENT,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id_akuntansi_lra_6`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `akuntansi_lra_6`
--

INSERT INTO `akuntansi_lra_6` (`id_akuntansi_lra_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`) VALUES
(1, '4', '41', '411', '4111', '411101', 'Pendapatan Pendanaan Gaji Pokok PNS'),
(2, '4', '41', '411', '4111', '411102', 'Pendapatan Pendanaan Pembulatan Gaji PNS'),
(3, '4', '41', '411', '4112', '411201', 'Pendapatan Pendanaan Tunjangan Suami/Istri PNS'),
(4, '4', '41', '411', '4112', '411202', 'Pendapatan Pendanaan Tunjangan Anak PNS'),
(5, '4', '41', '411', '4112', '411203', 'Pendapatan Pendanaan Tunjangan Struktural PNS'),
(6, '4', '41', '411', '4112', '411204', 'Pendapatan Pendanaan Tunjangan Fungsional PNS'),
(7, '4', '41', '411', '4112', '411205', 'Pendapatan Pendanaan Tunjangan PPh PNS'),
(8, '4', '41', '411', '4112', '411206', 'Pendapatan Pendanaan Tunjangan Beras PNS'),
(9, '4', '41', '411', '4112', '411207', 'Pendapatan Pendanaan Tunjangan Kemahalan PNS'),
(10, '4', '41', '411', '4112', '411208', 'Pendapatan Pendanaan Tunjangan Lauk pauk PNS'),
(11, '4', '41', '411', '4112', '411209', 'Pendapatan Pendanaan Uang Makan PNS'),
(12, '4', '41', '411', '4113', '411301', 'Pendapatan Pendanaan Tunjangan Umum PNS'),
(13, '4', '41', '411', '4113', '411302', 'Pendapatan Pendanaan Tunjangan Profesi Dosen'),
(14, '4', '41', '411', '4113', '411303', 'Pendapatan Pendanaan Tunjangan Kehormatan Profesor'),
(15, '4', '41', '412', '4121', '412101', 'Pendapatan Bantuan Pendanaan Perguruan Tinggi Negeri Badan Hukum (BP PTNBH)'),
(16, '4', '41', '413', '4131', '413101', 'Pendapatan APBN Lainnya'),
(17, '4', '42', '421', '4211', '421101', 'Uang Kuliah Tunggal (UKT)'),
(18, '4', '42', '421', '4211', '421102', 'Bidik Misi'),
(19, '4', '42', '421', '4211', '421103', 'Sumbangan Pendidikan'),
(20, '4', '42', '421', '4211', '421104', 'Pendapatan Layanan Pendidikan Utama - Non UKT'),
(21, '4', '42', '421', '4211', '421105', 'Pendapatan Penyelenggara Penerimaan Mahasiswa Baru (PMB)'),
(22, '4', '42', '421', '4211', '421106', 'Pendapatan Pengenaan Denda Buku'),
(23, '4', '42', '421', '4211', '421107', 'Pendapatan KKN/KKL'),
(24, '4', '42', '421', '4211', '421108', 'Pendapatan Jasa Legalisir'),
(25, '4', '42', '421', '4211', '421109', 'Pendapatan Penyelenggaraan Wisuda'),
(26, '4', '42', '421', '4211', '421110', 'Pendapatan Penggantian KTM'),
(27, '4', '42', '421', '4212', '421201', 'Pendapatan Pendukung Pendidikan'),
(28, '4', '42', '422', '4221', '422101', 'Pendapatan Hibah'),
(29, '4', '42', '422', '4221', '422102', 'Pendapatan Wakaf'),
(30, '4', '42', '422', '4221', '422103', 'Pendapatan Zakat'),
(31, '4', '42', '422', '4221', '422104', 'Pendapatan Persembahan Kasih'),
(32, '4', '42', '422', '4221', '422105', 'Pendapatan Kolekte'),
(33, '4', '42', '422', '4221', '422106', 'Pendapatan Punia'),
(34, '4', '42', '422', '4221', '422107', 'Pendapatan Sumbangan Individu dan/atau Perusahaan'),
(35, '4', '42', '422', '4221', '422108', 'Pendapatan Dana Abadi Pendidikan Tinggi'),
(36, '4', '42', '422', '4221', '422109', 'Bentuk Lain sesuai dengan Ketentuan Perundang-Undangan'),
(37, '4', '42', '423', '4231', '423101', 'Pendapatan Rumah Sakit'),
(38, '4', '42', '423', '4231', '423102', 'Pendapatan Rumah Susun Mahasiswa'),
(39, '4', '42', '423', '4231', '423103', 'Pendapatan SPBU'),
(40, '4', '42', '423', '4231', '423104', 'Pendapatan Radio'),
(41, '4', '42', '423', '4231', '423105', 'Pendapatan Percetakan'),
(42, '4', '42', '423', '4231', '423106', 'Pendapatan Penginapan/Guest House'),
(43, '4', '42', '423', '4231', '423107', 'Pendapatan Gedung Parkir Bersama'),
(44, '4', '42', '423', '4231', '423108', 'Pendapatan Deviden Badan Usaha Milik Undip '),
(45, '4', '42', '423', '4231', '423109', 'Pendapatan Usaha Pertanian/Peternakan/Perikanan'),
(46, '4', '42', '423', '4231', '423110', 'Pendapatan Pelatihan Mandiri'),
(47, '4', '42', '423', '4231', '423111', 'Pendapatan Jasa Konsultasi dan Advokasi Mandiri'),
(48, '4', '42', '423', '4231', '423112', 'Pendapatan Jasa Uji Sertifikasi/Kompetensi Mandiri'),
(49, '4', '42', '423', '4231', '423113', 'Pendapatan Undip Career Center'),
(50, '4', '42', '423', '4231', '423114', 'Pendapatan Poliklinik'),
(51, '4', '42', '424', '4241', '424101', 'Pendapatan Kerjasama Pendidikan'),
(52, '4', '42', '424', '4241', '424102', 'Pendapatan Kerjasama Penelitian'),
(53, '4', '42', '424', '4241', '424103', 'Pendapatan Kerjasama Pengabdian Kepada Masyarakat'),
(54, '4', '42', '424', '4242', '424201', 'PENDAPATAN KERJASAMA JASA KONSULTASI DAN ADVOKASI'),
(55, '4', '42', '424', '4242', '424202', 'PENDAPATAN KERJASAMA JASA UJI SERTIFIKASI/KOMPETENSI'),
(56, '4', '42', '424', '4242', '424203', 'PENDAPATAN KERJASAMA PELATIHAN'),
(57, '4', '42', '425', '4251', '425101', 'Pendapatan Penyertaan Dalam Bentuk Saham'),
(58, '4', '42', '425', '4251', '425102', 'Pendapatan Penyertaan Dalam Bentuk Sukuk'),
(59, '4', '42', '425', '4251', '425103', 'Pendapatan Penyertaan Dalam Bentuk Deposito'),
(60, '4', '42', '426', '4261', '426101', 'Pendapatan Sewa Lahan'),
(61, '4', '42', '426', '4261', '426102', 'Pendapatan Sewa Gedung Bangunan'),
(62, '4', '42', '426', '4261', '426103', 'Pendapatan Sewa Peralatan dan Mesin'),
(63, '4', '42', '426', '4261', '426104', 'Pendapatan Sewa Laboratorium'),
(64, '4', '42', '427', '4271', '427101', 'Pendapatan Bantuan dari Pemerintah Daerah'),
(65, '4', '42', '428', '4281', '428101', 'Pendapatan Bunga'),
(66, '4', '42', '428', '4282', '428201', 'Pendapatan Investasi Saham/Reksadana/Obligasi'),
(67, '4', '42', '429', '4291', '429101', 'Pendapatan dari Pengembalian Kelebihan Pembayaran Tahun Lalu'),
(68, '4', '42', '429', '4291', '429102', 'Pendapatan Belum Teridentifikasi');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2017 at 05:42 AM
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
-- Table structure for table `akuntansi_aset_1`
--

CREATE TABLE `akuntansi_aset_1` (
  `id_akuntansi_aset_1` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_1`
--

INSERT INTO `akuntansi_aset_1` (`id_akuntansi_aset_1`, `akun_1`, `nama`) VALUES
(1, '1', 'ASET');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_2`
--

CREATE TABLE `akuntansi_aset_2` (
  `id_akuntansi_aset_2` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_2`
--

INSERT INTO `akuntansi_aset_2` (`id_akuntansi_aset_2`, `akun_1`, `akun_2`, `nama`) VALUES
(1, '1', '11', 'ASET LANCAR'),
(2, '1', '12', 'ASET TIDAK LANCAR');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_3`
--

CREATE TABLE `akuntansi_aset_3` (
  `id_akuntansi_aset_3` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_3`
--

INSERT INTO `akuntansi_aset_3` (`id_akuntansi_aset_3`, `akun_1`, `akun_2`, `akun_3`, `nama`) VALUES
(1, '1', '11', '111', 'KAS DAN SETARA KAS'),
(2, '1', '11', '112', 'INVESTASI JANGKA PENDEK'),
(3, '1', '11', '113', 'PIUTANG'),
(4, '1', '11', '114', 'PERSEDIAAN'),
(5, '1', '11', '115', 'BEBAN DIBAYAR DIMUKA'),
(6, '1', '12', '121', 'INVESTASI JANGKA PANJANG'),
(7, '1', '12', '122', 'ASET TETAP'),
(8, '1', '12', '123', 'ASET LAINNYA'),
(9, '1', '12', '129', 'AKUMULASI DEPRESIASI/AMORTISASI');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_4`
--

CREATE TABLE `akuntansi_aset_4` (
  `id_akuntansi_aset_4` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_4`
--

INSERT INTO `akuntansi_aset_4` (`id_akuntansi_aset_4`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `nama`) VALUES
(1, '1', '11', '111', '1111', 'Kas Bank Mandiri '),
(2, '1', '11', '111', '1112', 'Kas Bank BNI '),
(3, '1', '11', '111', '1113', 'Kas Bank BTN'),
(4, '1', '11', '111', '1114', 'Kas Bank BCA '),
(5, '1', '11', '111', '1115', 'Kas Bank BRI '),
(6, '1', '11', '111', '1116', 'Kas Bank BPD'),
(7, '1', '11', '112', '1121', 'Investasi Jangka Pendek Pada Deposito'),
(8, '1', '11', '112', '1122', ' Investasi Jangka Pendek Pada Reksadana'),
(9, '1', '11', '112', '1123', 'Investasi Jangka Pendek Pada Saham Perusahaan'),
(10, '1', '11', '113', '1131', 'Piutang Layanan'),
(11, '1', '11', '113', '1132', 'Piutang Usaha Lainnya'),
(12, '1', '11', '113', '1133', 'Penyisihan Piutang Tak Tertagih'),
(13, '1', '11', '114', '1141', 'Persediaan Barang Habis Konsumsi'),
(14, '1', '11', '114', '1142', ' Bahan Habis Pakai Kesehatan (Rumah Sakit)'),
(15, '1', '11', '114', '1143', ' Obat-Obatan Rumah Sakit'),
(16, '1', '11', '114', '1144', ' Bahan Percobaan Laboratorium'),
(17, '1', '11', '114', '1145', ' Persediaan SPBU'),
(18, '1', '11', '114', '1146', ' Persediaan Cetak (UPT Undip Press)'),
(19, '1', '11', '115', '1151', 'Sewa Dibayar Dimuka'),
(20, '1', '12', '121', '1211', 'Investasi Jangka Panjang Pada Deposito'),
(21, '1', '12', '121', '1212', 'Investasi Jangka Panjang Pada Reksadana'),
(22, '1', '12', '121', '1213', 'Investasi Jangka Panjang Pada Saham Perusahaan'),
(23, '1', '12', '122', '1221', 'Tanah '),
(24, '1', '12', '122', '1222', 'Gedung dan Bangunan'),
(25, '1', '12', '122', '1223', 'Peralatan dan Mesin'),
(26, '1', '12', '122', '1224', 'Jalan, Irigasi dan Jaringan'),
(27, '1', '12', '122', '1225', 'Aset Tetap Lainnya'),
(28, '1', '12', '122', '1226', 'Konstruksi Dalam Pengerjaan'),
(29, '1', '12', '123', '1231', 'Aset Tak Berwujud'),
(30, '1', '12', '124', '1291', 'Akumulasi Penyusutan Aset Tetap'),
(31, '1', '12', '124', '1292', 'Akumulasi Amortisasi Aset Tak Berwujud');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_6`
--

CREATE TABLE `akuntansi_aset_6` (
  `id_akuntansi_aset_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_unit` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_6`
--

INSERT INTO `akuntansi_aset_6` (`id_akuntansi_aset_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`, `kode_unit`) VALUES
(1, '1', '11', '111', '1111', '111101', 'Kas Bank Mandiri Operasional BLU No Rek. 1360020080005', 'all'),
(2, '1', '11', '111', '1111', '111102', 'Kas Bank Mandiri Operasional BLU BPP FH No Rek. 1360020080013', '11'),
(3, '1', '11', '111', '1111', '111103', 'Kas Bank Mandiri Operasional BLU BPP FE No Rek. 1360020080021', '12'),
(4, '1', '11', '111', '1111', '111104', 'Kas Bank Mandiri Operasional BLU BPP FT No Rek. 1360020080039', '13'),
(5, '1', '11', '111', '1111', '111105', 'Kas Bank Mandiri Operasional BLU BPP FK No Rek. 1360020080047', '14'),
(6, '1', '11', '111', '1111', '111106', 'Kas Bank Mandiri Operasional BLU BPP FP No Rek. 1360020080054', '15'),
(7, '1', '11', '111', '1111', '111107', 'Kas Bank Mandiri Operasional BLU BPP FIB No Rek. 1360020080062', '16'),
(8, '1', '11', '111', '1111', '111108', 'Kas Bank Mandiri Operasional BLU BPP FISIP No Rek. 1360020080070', '17'),
(9, '1', '11', '111', '1111', '111109', 'Kas Bank Mandiri Operasional BLU BPP FMIPA No Rek. 1360020080088', '18'),
(10, '1', '11', '111', '1111', '111110', 'Kas Bank Mandiri Operasional BLU BPP FKM No Rek. 1360020080096', '19'),
(11, '1', '11', '111', '1111', '111111', 'Kas Bank Mandiri Operasional BLU BPP FPIK No Rek. 1360020080104', '20'),
(12, '1', '11', '111', '1111', '111112', 'Kas Bank Mandiri Operasional BLU BPP FPSI No Rek. 1360020080112', '21'),
(13, '1', '11', '111', '1111', '111113', 'Kas Bank Mandiri Operasional BLU BPP LPPM No Rek. 1360007101626', '71'),
(14, '1', '11', '111', '1111', '111114', 'Kas Bank Mandiri Operasional BLU BPP LP2MP No Rek. 1360007117549', '72'),
(15, '1', '11', '111', '1111', '111115', 'Kas Bank Mandiri Operasional BLU BPP KP I No Rek. 1360020080146', ''),
(16, '1', '11', '111', '1111', '111116', 'Kas Bank Mandiri Operasional BLU BPP RSND No Rek. 1360014046251', '51'),
(17, '1', '11', '111', '1111', '111117', 'Kas Bank Mandiri BPn 026 UNDIP No Rek. 1360005599045', ''),
(18, '1', '11', '111', '1111', '111118', 'Kas Bank Mandiri Dana Kelolaan Penelitian dan Pengabdian No Rek. 1360006977653', ''),
(19, '1', '11', '111', '1111', '111119', 'Kas Bank Mandiri Operasional BLU Uji Kompetensi No Rek. 1360090044444', ''),
(20, '1', '11', '111', '1111', '111120', 'Kas Bank Mandiri Operasional BLU Pendaftaran Ujian Kompetensi No Rek. 1360014923632', ''),
(21, '1', '11', '111', '1111', '111121', 'Kas Bank Mandiri Operasional BLU Unicef No Rek. 1360015415000', ''),
(22, '1', '11', '111', '1111', '111122', 'Kas Bank Mandiri Universitas Diponegoro - PENERIMAAN 1360020170301', ''),
(23, '1', '11', '111', '1111', '111123', 'Kas Bank Mandiri Operasional BIDANG I - 1360020170012', ''),
(24, '1', '11', '111', '1111', '111124', 'Kas Bank Mandiri Operasional BIDANG II - 1360020170129', ''),
(25, '1', '11', '111', '1111', '111125', 'Kas Bank Mandiri Operasional BIDANG III - 1360020170038', ''),
(26, '1', '11', '111', '1111', '111126', 'Kas Bank Mandiri Operasional BIDANG IV - 1360020170046', ''),
(27, '1', '11', '111', '1111', '111127', 'Kas Bank Mandiri Operasional SPI - 1360020170053', ''),
(28, '1', '11', '111', '1111', '111128', 'Kas Bank Mandiri Operasional MWA - 1360020170061', ''),
(29, '1', '11', '111', '1111', '111129', 'Kas Bank Mandiri Operasional BPPTNBH - 1360020170095', ''),
(30, '1', '11', '111', '1111', '111130', 'Kas Bank Mandiri Operasional BP SATUAN USAHA - 1360020170202', ''),
(31, '1', '11', '111', '1111', '111131', 'Kas Bank Mandiri Operasional BP KERJASAMA - 1360020170103', ''),
(32, '1', '11', '111', '1111', '111132', 'Kas Bank Mandiri Operasional FH - 1360020170285', ''),
(33, '1', '11', '111', '1111', '111133', 'Kas Bank Mandiri Operasional FEB - 1360020170137', ''),
(34, '1', '11', '111', '1111', '111134', 'Kas Bank Mandiri Operasional FT - 1360020170145', ''),
(35, '1', '11', '111', '1111', '111135', 'Kas Bank Mandiri Operasional FK - 1360020170269', ''),
(36, '1', '11', '111', '1111', '111136', 'Kas Bank Mandiri Operasional FPP - 1360020170152', ''),
(37, '1', '11', '111', '1111', '111137', 'Kas Bank Mandiri Operasional FIB - 1360020170160', ''),
(38, '1', '11', '111', '1111', '111138', 'Kas Bank Mandiri Operasional FISIP - 1360020170178', ''),
(39, '1', '11', '111', '1111', '111139', 'Kas Bank Mandiri Operasional FSM - 1360020170186', ''),
(40, '1', '11', '111', '1111', '111140', 'Kas Bank Mandiri Operasional FKM - 1360020170194', ''),
(41, '1', '11', '111', '1111', '111141', 'Kas Bank Mandiri Operasional FPIK - 1360020170210', ''),
(42, '1', '11', '111', '1111', '111142', 'Kas Bank Mandiri Operasional FPSI - 1360020170228', ''),
(43, '1', '11', '111', '1111', '111143', 'Kas Bank Mandiri Operasional LPPM - 1360020170236', ''),
(44, '1', '11', '111', '1111', '111144', 'Kas Bank Mandiri Operasional LP2MP - 1360020170244', ''),
(45, '1', '11', '111', '1111', '111145', 'Kas Bank Mandiri Operasional PASCASARJANA - 1360020170251', ''),
(46, '1', '11', '111', '1111', '111146', 'Kas Bank Mandiri Operasional VOKASI - 1360020170087', ''),
(47, '1', '11', '111', '1111', '111147', 'Kas Bank Mandiri Operasional RSND - 1360020170293', ''),
(48, '1', '11', '111', '1111', '111148', 'Kas Bank Mandiri Operasional - 1360020170319', ''),
(49, '1', '11', '111', '1112', '111201', 'Kas Bank BNI BPg 026 UNDIP Rek. 0040131479', ''),
(50, '1', '11', '111', '1112', '111202', 'Kas Bank BNI Operasional BLU BPP Pascasarjana No Rek. 8012345671', ''),
(51, '1', '11', '111', '1112', '111203', 'Kas Bank BNI BPn 026 Undip No Rek. 0033664282', ''),
(52, '1', '11', '111', '1112', '111204', 'Kas Bank BNI Dana Kelolaan BLU Pascasarjana No Rek. 8012345682', ''),
(53, '1', '11', '111', '1112', '111205', 'Kas Bank BNI Dana Kelolaan BLU No Rek. 00113147606', ''),
(54, '1', '11', '111', '1112', '111206', 'Kas Bank BNI Dana Kelolaan BP-SPBU No Rek. 0196949645', ''),
(55, '1', '11', '111', '1112', '111207', 'Kas Bank BNI Dana Kelolaan Kerjasama BPOM No Rek. 0259467775', ''),
(56, '1', '11', '111', '1112', '111208', 'Kas Bank BNI Universitas Diponegoro - PENERIMAAN - 7101011123', ''),
(57, '1', '11', '111', '1113', '111301', 'Kas Bank BTN BPn 026 UNDIP No Rek. 0001301300004763', ''),
(58, '1', '11', '111', '1113', '111302', 'Kas Bank BTN Operasional RSND No Rek. 0000017501300000323', ''),
(59, '1', '11', '111', '1113', '111303', 'Kas Bank BTN Universitas Diponegoro - PENERIMAAN - 00013-01-30-000948-8', ''),
(60, '1', '11', '111', '1114', '111401', 'Kas Bank BCA Dana Kelolaan Kegiatan BLU No Rek. 0095310040', ''),
(61, '1', '11', '111', '1115', '111501', 'Kas Bank BRI BPn 026 UNDIP No Rek. 0000032501000988301', ''),
(62, '1', '11', '111', '1115', '111502', 'Kas Bank BRI Dana Kelolaan Beasiswa BUMN 00000083-01-001143-30-8', ''),
(63, '1', '11', '111', '1115', '111503', 'Kas Bank BRI Universitas Diponegoro - PENERIMAAN - 00000325.01.0020.193.02', ''),
(64, '1', '11', '111', '1116', '111601', 'Kas Bank BPD Dana Kelolaan Kerjasama/Beasiswa 1034-01694-8', ''),
(65, '1', '11', '112', '1121', '112101', 'Investasi Jangka Pendek Pada Deposito BNI', ''),
(66, '1', '11', '112', '1121', '112102', 'Investasi Jangka Pendek Pada Deposito BTN', ''),
(67, '1', '11', '112', '1121', '112103', 'Investasi Jangka Pendek Pada Deposito Mandiri', ''),
(68, '1', '11', '112', '1121', '112104', 'Investasi Jangka Pendek Pada Deposito BRI', ''),
(69, '1', '11', '112', '1121', '112105', 'Investasi Jangka Pendek Pada Deposito BCA', ''),
(70, '1', '11', '112', '1121', '112106', 'Investasi Jangka Pendek Pada Deposito BPD', ''),
(71, '1', '11', '112', '1122', '112201', ' Investasi Investasi Jangka Pendek Pada Reksadana ', ''),
(72, '1', '11', '112', '1123', '112301', 'Investasi Jangka Pendek Pada Saham Perusahaan ', ''),
(73, '1', '11', '113', '1131', '113101', 'Piutang Jasa Layanan Utama', ''),
(74, '1', '11', '113', '1131', '113102', 'Piutang Jasa Layanan Pendukung Pendidikan', ''),
(75, '1', '11', '113', '1132', '113201', 'Piutang Dari Masyarakat', ''),
(76, '1', '11', '113', '1132', '113202', 'Piutang Usaha PTNBH', ''),
(77, '1', '11', '113', '1132', '113203', 'Piutang Kerjasama Akademik', ''),
(78, '1', '11', '113', '1132', '113204', 'Piutang Pengelolaan Dana Abadi', ''),
(79, '1', '11', '113', '1132', '113205', 'Piutang Pengelolaan Kekayaan PTNBH', ''),
(80, '1', '11', '113', '1132', '113206', 'Piutang Bantuan dari Pemerintah Daerah', ''),
(81, '1', '11', '113', '1132', '113207', 'Piutang Lainnya', ''),
(82, '1', '11', '113', '1133', '113301', 'Penyisihan Piutang Tak Tertagih-Piutang Layanan', ''),
(83, '1', '11', '113', '1133', '113302', 'Penyisihan Piutang Tak Tertagih-Piutang Usaha Lainnya', ''),
(84, '1', '11', '114', '1141', '114101', 'Persediaan Barang Konsumsi', ''),
(85, '1', '11', '114', '1141', '114103', 'Bahan untuk Pemeliharaan', ''),
(86, '1', '11', '114', '1141', '114104', 'Suku Cadang', ''),
(87, '1', '11', '114', '1141', '114105', 'Hewan dan Tanaman untuk dijual atau diserahkan kepada Masyarakat', ''),
(88, '1', '11', '114', '1141', '114106', 'Barang Lainnya Untuk dijual atau diserahkan kepada Masyarakat', ''),
(89, '1', '11', '114', '1141', '114107', 'Bahan Baku', ''),
(90, '1', '11', '114', '1141', '114108', 'Persediaan untuk tujuan strategis/berjaga - jaga', ''),
(91, '1', '11', '114', '1141', '114109', 'Persediaan Operasi Pendidikan Lainnya', ''),
(92, '1', '11', '114', '1141', '114110', 'Materai dan Perangko', ''),
(93, '1', '11', '114', '1142', '114201', ' Bahan Habis Pakai Kesehatan (Rumah Sakit)', ''),
(94, '1', '11', '114', '1143', '114301', ' Obat-Obatan Rumah Sakit', ''),
(95, '1', '11', '114', '1144', '121401', ' Bahan Percobaan Laboratorium', ''),
(96, '1', '11', '114', '1145', '114501', ' Persediaan SPBU', ''),
(97, '1', '11', '114', '1146', '114601', ' Persediaan Cetak (UPT Undip Press)', ''),
(98, '1', '11', '115', '1151', '115101', 'Sewa Tanah Dibayar Dimuka', ''),
(99, '1', '11', '115', '1151', '115102', 'Sewa Gedung Dibayar Dimuka', ''),
(100, '1', '12', '121', '1211', '121101', 'Investasi Jangka Pendek Pada Deposito Mandiri', ''),
(101, '1', '12', '121', '1211', '121102', 'Investasi Jangka Pendek Pada Deposito BNI', ''),
(102, '1', '12', '121', '1211', '121103', 'Investasi Jangka Pendek Pada Deposito BTN', ''),
(103, '1', '12', '121', '1211', '121104', 'Investasi Jangka Pendek Pada Deposito BRI', ''),
(104, '1', '12', '121', '1211', '121105', 'Investasi Jangka Pendek Pada Deposito BCA', ''),
(105, '1', '12', '121', '1211', '121106', 'Investasi Jangka Pendek Pada Deposito BPD', ''),
(106, '1', '12', '121', '1212', '121201', 'Investasi Jangka Panjang Pada Reksadana', ''),
(107, '1', '12', '121', '1213', '121301', 'Investasi Jangka Panjang Pada Saham Perusahaan', ''),
(108, '1', '12', '122', '1221', '122101', 'Tanah Persial', ''),
(109, '1', '12', '122', '1221', '122102', 'Tanah Non Persil', ''),
(110, '1', '12', '122', '1221', '122103', 'Lapangan', ''),
(111, '1', '12', '122', '1222', '122201', 'Gedung  dan Bangunan Tempat Kerja', ''),
(112, '1', '12', '122', '1222', '122202', 'Gedung dan Bangunan Tempat Tinggal', ''),
(113, '1', '12', '122', '1222', '122203', 'Gedung dan Bangunan Monumen/Tugu', ''),
(114, '1', '12', '122', '1222', '122204', 'Bangunan Menara', ''),
(115, '1', '12', '122', '1223', '122301', 'Alat Besar', ''),
(116, '1', '12', '122', '1223', '122302', 'Alat Angkutan', ''),
(117, '1', '12', '122', '1223', '122303', 'Alat Bengkel dan Alat Ukur', ''),
(118, '1', '12', '122', '1223', '122304', 'Alat Pertanian', ''),
(119, '1', '12', '122', '1223', '122305', 'Alat Kantor dan Rumah Tangga', ''),
(120, '1', '12', '122', '1223', '122306', 'Alat Studio, Komunikasi Dan Pemancar', ''),
(121, '1', '12', '122', '1223', '122307', 'Alat Kedokteran', ''),
(122, '1', '12', '122', '1223', '122308', 'Alat Laboratorium', ''),
(123, '1', '12', '122', '1223', '122309', 'Alat Persenjataan', ''),
(124, '1', '12', '122', '1223', '122310', 'Alat Eksplorasi dan Produksi', ''),
(125, '1', '12', '122', '1223', '122311', 'Alat Keselamatan Kerja', ''),
(126, '1', '12', '122', '1223', '122312', 'Alat Kerja Penerbangan', ''),
(127, '1', '12', '122', '1223', '122313', 'Alat Peraga, Rambu-Rambu dan Alat Olah Raga', ''),
(128, '1', '12', '122', '1224', '122401', 'Jalan', ''),
(129, '1', '12', '122', '1224', '122402', 'Irigasi ', ''),
(130, '1', '12', '122', '1224', '122403', 'Jaringan', ''),
(131, '1', '12', '122', '1225', '122501', 'Aset Perpustakaan', ''),
(132, '1', '12', '122', '1225', '122502', 'Aset Bercorak Kesenian/Kebudayaan/Olahraga', ''),
(133, '1', '12', '122', '1225', '122503', 'Hewan dan Tanaman', ''),
(134, '1', '12', '122', '1225', '122504', 'Barang Koleksi Non Budaya', ''),
(135, '1', '12', '122', '1226', '122601', 'Konstruksi Dalam Pengerjaan', ''),
(136, '1', '12', '123', '1231', '123101', 'Software', ''),
(137, '1', '12', '123', '1231', '123102', 'Paten', ''),
(138, '1', '12', '123', '1231', '123103', 'Trandemark', ''),
(139, '1', '12', '123', '1231', '123104', 'HAKI', ''),
(140, '1', '12', '123', '1231', '123105', 'Goodwill', ''),
(141, '1', '12', '129', '1291', '129101', 'Akumulasi Penyusutan Gedung dan Bangunan', ''),
(142, '1', '12', '129', '1291', '129102', 'Akumulasi Penyusutan Peralatan dan Mesin', ''),
(143, '1', '12', '129', '1291', '129103', 'Akumulasi Penyusutan Jalan, Irigasi dan Jaringan', ''),
(144, '1', '12', '129', '1292', '129201', 'Akumulasi Amortisasi Aset Tak Berwujud', ''),
(145, '1', '12', '129', '1291', '129104', 'Akumulasi Penyusutan Irigasi', ''),
(146, '1', '12', '129', '1291', '129105', 'Akumulasi Penyusutasn Jaringan', ''),
(147, '1', '12', '129', '1291', '129106', 'Akumulasi Penyusutan aset Tetap Lainnya', ''),
(148, '1', '12', '129', '1292', '129202', 'Akumulasi Penyusutan Aset Lain-lain', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_aset_1`
--
ALTER TABLE `akuntansi_aset_1`
  ADD PRIMARY KEY (`id_akuntansi_aset_1`);

--
-- Indexes for table `akuntansi_aset_2`
--
ALTER TABLE `akuntansi_aset_2`
  ADD PRIMARY KEY (`id_akuntansi_aset_2`);

--
-- Indexes for table `akuntansi_aset_3`
--
ALTER TABLE `akuntansi_aset_3`
  ADD PRIMARY KEY (`id_akuntansi_aset_3`);

--
-- Indexes for table `akuntansi_aset_4`
--
ALTER TABLE `akuntansi_aset_4`
  ADD PRIMARY KEY (`id_akuntansi_aset_4`);

--
-- Indexes for table `akuntansi_aset_6`
--
ALTER TABLE `akuntansi_aset_6`
  ADD PRIMARY KEY (`id_akuntansi_aset_6`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_aset_1`
--
ALTER TABLE `akuntansi_aset_1`
  MODIFY `id_akuntansi_aset_1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_aset_2`
--
ALTER TABLE `akuntansi_aset_2`
  MODIFY `id_akuntansi_aset_2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akuntansi_aset_3`
--
ALTER TABLE `akuntansi_aset_3`
  MODIFY `id_akuntansi_aset_3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `akuntansi_aset_4`
--
ALTER TABLE `akuntansi_aset_4`
  MODIFY `id_akuntansi_aset_4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `akuntansi_aset_6`
--
ALTER TABLE `akuntansi_aset_6`
  MODIFY `id_akuntansi_aset_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

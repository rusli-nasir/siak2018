-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2017 at 11:02 PM
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
(9, '1', '12', '124', 'AKUMULASI DEPRESIASI/AMORTISASI');

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
(30, '1', '12', '124', '1241', 'Akumulasi Penyusutan Aset Tetap'),
(31, '1', '12', '124', '1242', 'Akumulasi Amortisasi Aset Tak Berwujud');

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
(141, '1', '12', '124', '1241', '124101', 'Akumulasi Penyusutan Gedung dan Bangunan', ''),
(142, '1', '12', '124', '1241', '124102', 'Akumulasi Penyusutan Peralatan dan Mesin', ''),
(143, '1', '12', '124', '1241', '124103', 'Akumulasi Penyusutan Jalan, Irigasi dan Jaringan', ''),
(144, '1', '12', '124', '1242', '124201', 'Akumulasi Amortisasi Aset Tak Berwujud', '');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_bersih_1`
--

CREATE TABLE `akuntansi_aset_bersih_1` (
  `id_akuntansi_aset_bersih_1` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_bersih_1`
--

INSERT INTO `akuntansi_aset_bersih_1` (`id_akuntansi_aset_bersih_1`, `akun_1`, `nama`) VALUES
(1, '3', 'Aktiva BERSIH');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_bersih_2`
--

CREATE TABLE `akuntansi_aset_bersih_2` (
  `id_akuntansi_aset_bersih_2` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_bersih_2`
--

INSERT INTO `akuntansi_aset_bersih_2` (`id_akuntansi_aset_bersih_2`, `akun_1`, `akun_2`, `nama`) VALUES
(1, '3', '31', 'Aktiva Bersih Tidak Terikat'),
(2, '3', '32', 'Aktiva Bersih Terikat');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_bersih_3`
--

CREATE TABLE `akuntansi_aset_bersih_3` (
  `id_akuntansi_aset_bersih_3` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_bersih_3`
--

INSERT INTO `akuntansi_aset_bersih_3` (`id_akuntansi_aset_bersih_3`, `akun_1`, `akun_2`, `akun_3`, `nama`) VALUES
(1, '3', '31', '311', 'Aktiva Bersih Tidak Terikat'),
(2, '3', '32', '321', 'Aktiva Bersih Terikat Temporer'),
(3, '3', '32', '322', 'Aktiva Bersih Terikat Permanen');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_bersih_4`
--

CREATE TABLE `akuntansi_aset_bersih_4` (
  `id_akuntansi_aset_bersih_4` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_bersih_4`
--

INSERT INTO `akuntansi_aset_bersih_4` (`id_akuntansi_aset_bersih_4`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `nama`) VALUES
(1, '3', '31', '311', '3111', 'Aktiva Bersih Tidak Terikat Kekayaan Awal PTN BH'),
(2, '3', '31', '311', '3112', 'Kenaikan (Penurunan) Aktiva Bersih Tidak Terikat Tahun Lalu'),
(3, '3', '31', '311', '3113', 'Kenaikan (Penurunan) Aktiva Bersih Tidak Terikat Tahun Ini'),
(4, '3', '32', '321', '3211', 'Aktiva Bersih Terikat Temporer Kekayaan Awal PTN BH'),
(5, '3', '32', '321', '3212', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Temporer Tahun Lalu'),
(6, '3', '32', '321', '3213', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Temporer Tahun Ini'),
(7, '3', '32', '322', '3221', 'Aktiva Bersih Terikat Permanen Kekayaan Awal PTN BH'),
(8, '3', '32', '322', '3222', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Permanen Tahun Lalu'),
(9, '3', '32', '322', '3223', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Permanen Tahun Ini');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_aset_bersih_6`
--

CREATE TABLE `akuntansi_aset_bersih_6` (
  `id_akuntansi_aset_bersih_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_bersih_6`
--

INSERT INTO `akuntansi_aset_bersih_6` (`id_akuntansi_aset_bersih_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`) VALUES
(1, '3', '31', '311', '3111', '311101', 'Aktiva Bersih Tidak Terikat Kekayaan Awal PTN BH'),
(2, '3', '31', '311', '3111', '311102', 'Koreksi Aktiva Bersih Tidak Terikat Kekayaan Awal PTN BH'),
(3, '3', '31', '311', '3112', '311201', 'Kenaikan (Penurunan) Aktiva Bersih Tidak Terikat Tahun Lalu'),
(4, '3', '31', '311', '3112', '311202', 'Koreksi Kenaikan (Penurunan) Aktiva Bersih Tidak Terikat Tahun Lalu'),
(5, '3', '31', '311', '3113', '311301', 'Kenaikan (Penurunan) Aktiva Bersih Tidak Terikat Tahun Ini'),
(6, '3', '31', '311', '3113', '311302', 'Koreksi Kenaikan (Penurunan) Aktiva Bersih Tidak Terikat Tahun Ini'),
(7, '3', '32', '321', '3211', '321101', 'Aktiva Bersih Terikat Temporer Kekayaan Awal PTN BH'),
(8, '3', '32', '321', '3211', '321102', 'Koreksi Aktiva Bersih Terikat Temporer Kekayaan Awal PTN BH'),
(9, '3', '32', '321', '3212', '321201', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Temporer Tahun Lalu'),
(10, '3', '32', '321', '3212', '321202', 'Koreksi Kenaikan (Penurunan) Aktiva Bersih Terikat Temporer Tahun Lalu'),
(11, '3', '32', '321', '3213', '321301', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Temporer Tahun Ini'),
(12, '3', '32', '321', '3213', '321302', 'Koreksi Kenaikan (Penurunan) Aktiva Bersih Terikat Temporer Tahun Ini'),
(13, '3', '32', '322', '3221', '322101', 'Aktiva Bersih Terikat Permanen Kekayaan Awal PTN BH'),
(14, '3', '32', '322', '3221', '322102', 'Koreksi Aktiva Bersih Terikat Permanen Kekayaan Awal PTN BH'),
(15, '3', '32', '322', '3222', '322201', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Permanen Tahun Lalu'),
(16, '3', '32', '322', '3222', '322202', 'Koreksi Kenaikan (Penurunan) Aktiva Bersih Terikat Permanen Tahun Lalu'),
(17, '3', '32', '322', '3223', '322301', 'Kenaikan (Penurunan) Aktiva Bersih Terikat Permanen Tahun Ini'),
(18, '3', '32', '322', '3223', '322302', 'Koreksi Kenaikan (Penurunan) Aktiva Bersih Terikat Permanen Tahun Ini');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_hutang_1`
--

CREATE TABLE `akuntansi_hutang_1` (
  `id_akuntansi_hutang_1` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_hutang_1`
--

INSERT INTO `akuntansi_hutang_1` (`id_akuntansi_hutang_1`, `akun_1`, `nama`) VALUES
(1, '2', 'HUTANG');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_hutang_2`
--

CREATE TABLE `akuntansi_hutang_2` (
  `id_akuntansi_hutang_2` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_hutang_2`
--

INSERT INTO `akuntansi_hutang_2` (`id_akuntansi_hutang_2`, `akun_1`, `akun_2`, `nama`) VALUES
(1, '2', '21', 'HUTANG JANGKA PENDEK'),
(2, '2', '22', 'HUTANG JANGKA PANJANG');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_hutang_3`
--

CREATE TABLE `akuntansi_hutang_3` (
  `id_akuntansi_hutang_3` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_hutang_3`
--

INSERT INTO `akuntansi_hutang_3` (`id_akuntansi_hutang_3`, `akun_1`, `akun_2`, `akun_3`, `nama`) VALUES
(1, '2', '21', '211', 'Hutang Pegawai'),
(2, '2', '21', '212', 'Hutang Insentif'),
(3, '2', '21', '213', 'Hutang Honorarium'),
(4, '2', '21', '214', 'Hutang Tambahan Kesejahteraan'),
(5, '2', '21', '215', 'Hutang Honorarium/Tunjangan Lain Terkait Pengembangan SDM '),
(6, '2', '21', '216', 'Hutang Pajak'),
(7, '2', '21', '217', 'Hutang Pihak Ketiga'),
(8, '2', '21', '218', 'Pendapatan Diterima Dimuka'),
(9, '2', '21', '219', 'Bagian Hutang Jangka Panjang yang Jatuh Tempo pada Tahun Berjalan'),
(10, '2', '22', '221', 'Hutang Hipotik'),
(11, '2', '22', '222', 'Hutang Obligasi');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_hutang_4`
--

CREATE TABLE `akuntansi_hutang_4` (
  `id_akuntansi_hutang_4` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_hutang_4`
--

INSERT INTO `akuntansi_hutang_4` (`id_akuntansi_hutang_4`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `nama`) VALUES
(1, '2', '21', '211', '2111', 'Hutang Gaji PNS'),
(2, '2', '21', '211', '2112', 'Hutang Tunjangan PNS'),
(3, '2', '21', '211', '2113', 'Hutang Gaji Non PNS'),
(4, '2', '21', '211', '2114', 'Hutang Tunjangan Non PNS'),
(5, '2', '21', '211', '2115', 'Hutang Tunjangan Lainnya PNS'),
(6, '2', '21', '212', '2121', 'Hutang Insentif PNS'),
(7, '2', '21', '212', '2122', 'Hutang Insentif Non PNS'),
(8, '2', '21', '212', '2123', 'Hutang Insentif Lainnya'),
(9, '2', '21', '213', '2131', 'Hutang Honorarium'),
(10, '2', '21', '214', '2141', 'Hutang Tambahan Kesejahteraan'),
(11, '2', '21', '215', '2151', 'Hutang Honorarium/Tunjangan Lain Terkait Pengembangan SDM '),
(12, '2', '21', '216', '2161', 'Hutang Pajak Penghasilan'),
(13, '2', '21', '217', '2171', 'Hutang Pengadaan Barang  '),
(14, '2', '21', '217', '2172', 'Hutang Jasa'),
(15, '2', '21', '217', '2173', 'Hutang Pemeliharaan'),
(16, '2', '21', '217', '2174', 'Hutang Perjalanan Dinas'),
(17, '2', '21', '217', '2175', 'Hutang Pengadaan Aset'),
(18, '2', '21', '218', '2181', 'Pendapatan Diterima Dimuka Selain APBN'),
(19, '2', '21', '219', '2191', 'Bagian Hutang Jangka Panjang yang Jatuh Tempo pada Tahun Berjalan'),
(20, '2', '22', '221', '2211', 'Hutang Hipotik'),
(21, '2', '22', '222', '2221', 'Hutang Obligasi Terjamin'),
(22, '2', '22', '222', '2222', 'Hutang Obligasi Tidak terjamin');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_hutang_6`
--

CREATE TABLE `akuntansi_hutang_6` (
  `id_akuntansi_hutang_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_hutang_6`
--

INSERT INTO `akuntansi_hutang_6` (`id_akuntansi_hutang_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`) VALUES
(1, '2', '21', '211', '2111', '211101', 'Hutang Gaji Pokok PNS'),
(2, '2', '21', '211', '2111', '211102', 'Hutang Pembulatan Gaji PNS'),
(3, '2', '21', '211', '2112', '211201', 'Hutang Tunjangan Suami/Istri PNS'),
(4, '2', '21', '211', '2112', '211202', 'Hutang Tunjangan Anak PNS'),
(5, '2', '21', '211', '2112', '211203', 'Hutang Tunjangan Struktural PNS'),
(6, '2', '21', '211', '2112', '211204', 'Hutang Tunjangan Fungsional PNS'),
(7, '2', '21', '211', '2112', '211205', 'Hutang Tunjangan PPh PNS'),
(8, '2', '21', '211', '2112', '211206', 'Hutang Tunjangan Beras PNS'),
(9, '2', '21', '211', '2112', '211207', 'Hutang Tunjangan Kemahalan PNS'),
(10, '2', '21', '211', '2112', '211208', 'Hutang Tunjangan Lauk pauk PNS'),
(11, '2', '21', '211', '2112', '211209', 'Hutang Uang Makan PNS'),
(12, '2', '21', '211', '2113', '211301', 'Hutang Gaji Pokok Non PNS'),
(13, '2', '21', '211', '2113', '211302', 'Hutang Pembulatan Gaji Non PNS'),
(14, '2', '21', '211', '2114', '211401', 'Hutang Tunjangan Suami/Istri Non PNS'),
(15, '2', '21', '211', '2114', '211402', 'Hutang Tunjangan Anak Non PNS'),
(16, '2', '21', '211', '2114', '211403', 'Hutang Tunjangan Struktural Non PNS'),
(17, '2', '21', '211', '2114', '211404', 'Hutang Tunjangan Fungsional Non PNS'),
(18, '2', '21', '211', '2114', '211405', 'Hutang Tunjangan PPh Non PNS'),
(19, '2', '21', '211', '2114', '211406', 'Hutang Tunjangan Beras Non PNS'),
(20, '2', '21', '211', '2114', '211407', 'Hutang Tunjangan Kemahalan Non PNS'),
(21, '2', '21', '211', '2114', '211408', 'Hutang Tunjangan Lauk pauk Non PNS'),
(22, '2', '21', '211', '2114', '211409', 'Hutang Uang Makan Non PNS'),
(23, '2', '21', '211', '2115', '211501', 'Hutang Tunjangan Umum PNS'),
(24, '2', '21', '211', '2115', '211502', 'Hutang Tunjangan Profesi Dosen'),
(25, '2', '21', '211', '2115', '211503', 'Hutang Tunjangan Kehormatan Profesor'),
(26, '2', '21', '212', '2121', '212101', 'Hutang Insentif Perbaikan Penghasilan (IPP) PNS'),
(27, '2', '21', '212', '2121', '212102', 'Hutang Insentif Kinerja Wajib (IKW) PNS'),
(28, '2', '21', '212', '2121', '212103', 'Hutang Insentif Kelebihan Kinerja (IKK) PNS '),
(29, '2', '21', '212', '2121', '212104', 'Hutang Insentif Tugas Tambahan PNS'),
(30, '2', '21', '212', '2121', '212105', 'Hutang Insentif Tugas Tambahan Senat/MWA'),
(31, '2', '21', '212', '2122', '212201', 'Hutang Insentif Perbaikan Penghasilan (IPP) Non PNS'),
(32, '2', '21', '212', '2122', '212202', 'Hutang Insentif Kinerja Wajib (IKW) Non PNS'),
(33, '2', '21', '212', '2122', '212203', 'Hutang Insentif Kelebihan Kinerja (IKK) Non PNS'),
(34, '2', '21', '212', '2122', '212204', 'Hutang Insentif Tugas Tambahan Non PNS'),
(35, '2', '21', '212', '2123', '212301', 'Hutang Insentif Pengelola Keuangan, Barang, Akuntansi dan IT'),
(36, '2', '21', '213', '2131', '213101', 'Hutang Honorarium Manajemen Pengelolaan PT'),
(37, '2', '21', '213', '2131', '213102', 'Hutang Honorarium RSND'),
(38, '2', '21', '213', '2131', '213103', 'Hutang Honorarium Dosen dan Tenaga Tidak Tetap dari Luar Undip'),
(39, '2', '21', '214', '2141', '214101', 'Hutang Belanja Jaminan Sosial  Dosen dan Tendik'),
(40, '2', '21', '215', '2151', '215101', 'Hutang Beasiswa Dosen dan Tendik'),
(41, '2', '21', '215', '2151', '215102', 'Hutang Honorarium/Tunjangan Peningkatan Mutu Ketrampilan, Keahlian dan Penghargaan Prestasi '),
(42, '2', '21', '216', '2161', '216101', 'Hutang PPh Pasal 21'),
(43, '2', '21', '216', '2161', '216102', 'Hutang PPh Pasal 22'),
(44, '2', '21', '216', '2161', '216103', 'Hutang PPh Pasal 23'),
(45, '2', '21', '216', '2161', '216104', 'Hutang PPh Final'),
(46, '2', '21', '216', '2161', '216105', 'Hutang PPN Dalam Negeri'),
(47, '2', '21', '216', '2161', '216106', 'Hutang PPNBM Dalam Negeri'),
(48, '2', '21', '216', '2161', '216107', 'Hutang PPh Badan'),
(49, '2', '21', '217', '2171', '217101', 'Hutang Pengadaan Barang Persediaan'),
(50, '2', '21', '217', '2171', '217102', 'Hutang Pengadaan Barang Pakai Habis'),
(51, '2', '21', '217', '2172', '217201', 'Hutang Jasa Fasilitas Pendukung Pendidikan '),
(52, '2', '21', '217', '2172', '217202', 'Hutang Jasa Rutin Perkantoran Langganan Telpon'),
(53, '2', '21', '217', '2172', '217203', 'Hutang Jasa Rutin Perkantoran Langganan Listrik'),
(54, '2', '21', '217', '2172', '217204', 'Hutang Jasa Rutin Perkantoran Langganan Air'),
(55, '2', '21', '217', '2172', '217205', 'Hutang Jasa Asuransi'),
(56, '2', '21', '217', '2172', '217206', 'Hutang Jasa Outsourcing'),
(57, '2', '21', '217', '2172', '217207', 'Hutang Jasa Sewa'),
(58, '2', '21', '217', '2172', '217208', 'Hutang Jasa Konsultan dan Profesi'),
(59, '2', '21', '217', '2172', '217209', 'Hutang Jasa Lainnya'),
(60, '2', '21', '217', '2173', '217301', 'Hutang Pemeliharaan Gedung dan Bangunan'),
(61, '2', '21', '217', '2173', '217302', 'Hutang Pemeliharaan Peralatan dan Mesin'),
(62, '2', '21', '217', '2173', '217303', 'Hutang Pemeliharaan Jalan, Irigasi dan Jaringan'),
(63, '2', '21', '217', '2174', '217401', 'Hutang Perjalanan Dinas Dalam Negeri'),
(64, '2', '21', '217', '2174', '217402', 'Hutang Perjalanan Dinas Luar Negeri'),
(65, '2', '21', '217', '2175', '217501', 'Belanja Modal Tanah '),
(66, '2', '21', '217', '2175', '217502', 'Belanja Modal Gedung dan Bangunan'),
(67, '2', '21', '217', '2175', '217503', 'Belanja Modal Peralatan dan Mesin'),
(68, '2', '21', '217', '2175', '217504', 'Belanja Modal Jalan, Irigasi dan Jaringan'),
(69, '2', '21', '217', '2175', '217505', 'Belanja Modal Aset Lainnya'),
(70, '2', '21', '218', '2181', '218101', 'Pendapatan Diterima Dimuka Layanan Pendidikan Utama'),
(71, '2', '21', '218', '2181', '218102', 'Pendapatan Diterima Dimuka Layanan Pendukung Pendidikan '),
(72, '2', '21', '218', '2181', '218103', 'Pendapatan Diterima Dimuka Dari Masyarakat'),
(73, '2', '21', '218', '2181', '218104', 'Pendapatan Diterima Dimuka dari Kerjasama'),
(74, '2', '21', '218', '2181', '218105', 'Pendapatan Diterima Dimuka Usaha PTNBH'),
(75, '2', '21', '218', '2181', '218106', 'Pendapatan Diterima Dimuka Pengelolaan Dana Abadi'),
(76, '2', '21', '218', '2181', '218107', 'Pendapatan DiterimaDimuka Pengelolaan Kekayaan PTNBH'),
(77, '2', '21', '218', '2181', '218108', 'Pendapatan Diterima Dimuka Lainnya'),
(78, '2', '21', '219', '2191', '219101', 'Bagian Hutang Jangka Panjang yang Jatuh Tempo pada Tahun Berjalan'),
(79, '2', '22', '221', '2211', '221101', 'Hutang Bank '),
(80, '2', '22', '222', '2221', '222101', 'Hutang Obligasi Terjamin'),
(81, '2', '22', '222', '2222', '222201', 'Hutang Obligasi Tidak terjamin');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_lra_1`
--

CREATE TABLE `akuntansi_lra_1` (
  `id_akuntansi_lra_1` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_lra_1`
--

INSERT INTO `akuntansi_lra_1` (`id_akuntansi_lra_1`, `akun_1`, `nama`) VALUES
(1, '4', 'PENDAPATAN');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_lra_2`
--

CREATE TABLE `akuntansi_lra_2` (
  `id_akuntansi_lra_2` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `akuntansi_lra_3` (
  `id_akuntansi_lra_3` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `akuntansi_lra_4` (
  `id_akuntansi_lra_4` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `akuntansi_lra_6` (
  `id_akuntansi_lra_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_pembiayaan_1`
--

CREATE TABLE `akuntansi_pembiayaan_1` (
  `id_akuntansi_pembiayaan_1` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pembiayaan_1`
--

INSERT INTO `akuntansi_pembiayaan_1` (`id_akuntansi_pembiayaan_1`, `akun_1`, `nama`) VALUES
(2, '8', 'AKTIVITAS PENDANAAN DAN PEMBIAYAAN');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_pembiayaan_2`
--

CREATE TABLE `akuntansi_pembiayaan_2` (
  `id_akuntansi_pembiayaan_2` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pembiayaan_2`
--

INSERT INTO `akuntansi_pembiayaan_2` (`id_akuntansi_pembiayaan_2`, `akun_1`, `akun_2`, `nama`) VALUES
(3, '8', '81', 'AKTIVITAS PENDANAAN'),
(4, '8', '82', 'AKTIVITAS PEMBIAYAAN');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_pembiayaan_3`
--

CREATE TABLE `akuntansi_pembiayaan_3` (
  `id_akuntansi_pembiayaan_3` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pembiayaan_3`
--

INSERT INTO `akuntansi_pembiayaan_3` (`id_akuntansi_pembiayaan_3`, `akun_1`, `akun_2`, `akun_3`, `nama`) VALUES
(13, '8', '81', '811', 'Penggunaan SiLPA Periode-periode Sebelumnya');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_pembiayaan_4`
--

CREATE TABLE `akuntansi_pembiayaan_4` (
  `id_akuntansi_pembiayaan_4` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pembiayaan_4`
--

INSERT INTO `akuntansi_pembiayaan_4` (`id_akuntansi_pembiayaan_4`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `nama`) VALUES
(18, '8', '81', '811', '8111', 'Penggunaan SiLPA Periode-periode Sebelumnya'),
(19, '8', '81', '811', '8112', 'Hasil Penjualan Kekayaan UNDIP'),
(20, '8', '81', '811', '8113', 'Penerimaan Kembali Pinjaman'),
(21, '8', '82', '811', '8211', 'Pembayaran Pokok Pinjaman Dalam Negeri'),
(22, '8', '82', '811', '8212', 'Penyertaan Modal (Investasi) UNDIP'),
(23, '8', '82', '811', '8213', 'Pemberian Pinjaman'),
(24, '8', '82', '811', '8214', 'Pemberian Pinjaman kepada Badan Usaha Milik UNDIP (BUMU)'),
(25, '8', '82', '811', '8215', 'Pemberian Pinjaman kepada pihak lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_pembiayaan_6`
--

CREATE TABLE `akuntansi_pembiayaan_6` (
  `id_akuntansi_pembiayaan_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pembiayaan_6`
--

INSERT INTO `akuntansi_pembiayaan_6` (`id_akuntansi_pembiayaan_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`) VALUES
(69, '8', '81', '811', '8111', '811101', 'Penggunaan SiLPA Periode-periode Sebelumnya'),
(70, '8', '81', '811', '8112', '811201', 'Hasil Penjualan Kekayaan UNDIP'),
(71, '8', '81', '811', '8113', '811301', 'Penerimaan dari Pinjaman Dalam Negeri'),
(72, '8', '81', '811', '8113', '811302', 'Penerimaan Kembali Pinjaman dari Badan Usaha Milik UNDIP (BUMU)'),
(73, '8', '81', '811', '8113', '811303', 'Penerimaan Kembali Pinjaman dari pihak lainnya'),
(74, '8', '82', '811', '8211', '821101', 'Pembayaran Pokok Pinjaman Dalam Negeri- Pemerintah Pusat'),
(75, '8', '82', '811', '8211', '821102', 'Pembayaran Pokok Pinjaman Dalam Negeri- Pemerintah Lembaga Keuangan Bank'),
(76, '8', '82', '811', '8211', '821103', 'Pembayaran Pokok Pinjaman Dalam Negeri- Lembaga Keuangan Bukan Bank'),
(77, '8', '82', '811', '8211', '821104', 'Pembayaran Pokok Pinjaman Dalam Negeri- Obligasi'),
(78, '8', '82', '811', '8211', '821105', 'Pembayaran Pokok Pinjaman Dalam Negeri- Pemerintah Daerah'),
(79, '8', '82', '811', '8211', '821106', 'Pembayaran Pokok Pinjaman Dalam Negeri- Pemerintah Lainnya'),
(80, '8', '82', '811', '8212', '821201', 'Penyertaan Modal (Investasi) UNDIP'),
(81, '8', '82', '811', '8213', '821301', 'Pemberian Pinjaman'),
(82, '8', '82', '811', '8214', '821401', 'Pemberian Pinjaman kepada Badan Usaha Milik UNDIP (BUMU)'),
(83, '8', '82', '811', '8215', '821501', 'Pemberian Pinjaman kepada pihak lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_sal_1`
--

CREATE TABLE `akuntansi_sal_1` (
  `id_akuntansi_sal_1` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_sal_1`
--

INSERT INTO `akuntansi_sal_1` (`id_akuntansi_sal_1`, `akun_1`, `nama`) VALUES
(1, '9', 'SALDO ANGGARAN LEBIH');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_sal_2`
--

CREATE TABLE `akuntansi_sal_2` (
  `id_akuntansi_sal_2` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_sal_2`
--

INSERT INTO `akuntansi_sal_2` (`id_akuntansi_sal_2`, `akun_1`, `akun_2`, `nama`) VALUES
(1, '9', '91', 'SAL');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_sal_3`
--

CREATE TABLE `akuntansi_sal_3` (
  `id_akuntansi_sal_3` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_sal_3`
--

INSERT INTO `akuntansi_sal_3` (`id_akuntansi_sal_3`, `akun_1`, `akun_2`, `akun_3`, `nama`) VALUES
(1, '9', '91', '911', 'SAL');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_sal_4`
--

CREATE TABLE `akuntansi_sal_4` (
  `id_akuntansi_sal_4` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_sal_4`
--

INSERT INTO `akuntansi_sal_4` (`id_akuntansi_sal_4`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `nama`) VALUES
(1, '9', '91', '911', '9111', 'SAL'),
(2, '9', '91', '911', '9112', 'SiLPA');

-- --------------------------------------------------------

--
-- Table structure for table `akuntansi_sal_6`
--

CREATE TABLE `akuntansi_sal_6` (
  `id_akuntansi_sal_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_unit` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_sal_6`
--

INSERT INTO `akuntansi_sal_6` (`id_akuntansi_sal_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`, `kode_unit`) VALUES
(1, '9', '91', '911', '9111', '911101', 'SAL KBUU', 'all'),
(2, '9', '91', '911', '9111', '911102', 'SAL BP  FHU', '11'),
(3, '9', '91', '911', '9111', '911103', 'SAL BP  FEB', '12'),
(4, '9', '91', '911', '9111', '911104', 'SAL BP  FTE', '13'),
(5, '9', '91', '911', '9111', '911105', 'SAL BP  FKE', '14'),
(6, '9', '91', '911', '9111', '911106', 'SAL BP  FPP', '15'),
(7, '9', '91', '911', '9111', '911107', 'SAL BP  FIB', '16'),
(8, '9', '91', '911', '9111', '911108', 'SAL BP  FIS', '17'),
(9, '9', '91', '911', '9111', '911109', 'SAL BP  FSM', '18'),
(10, '9', '91', '911', '9111', '911110', 'SAL BP  FKM', '19'),
(11, '9', '91', '911', '9111', '911111', 'SAL BP  FPK', '20'),
(12, '9', '91', '911', '9111', '911112', 'SAL BP  FPS', '21'),
(13, '9', '91', '911', '9111', '911113', 'SAL BP  SPS', '31'),
(14, '9', '91', '911', '9111', '911114', 'SAL BP  SVO', '32'),
(15, '9', '91', '911', '9111', '911115', 'SAL BP  WR1', '41'),
(16, '9', '91', '911', '9111', '911116', 'SAL BP  WR2', '42'),
(17, '9', '91', '911', '9111', '911117', 'SAL BP  WR3', '43'),
(18, '9', '91', '911', '9111', '911118', 'SAL BP  WR4', '44'),
(19, '9', '91', '911', '9111', '911119', 'SAL BP  RSN', '51'),
(20, '9', '91', '911', '9111', '911120', 'SAL BP  BPS', '61'),
(21, '9', '91', '911', '9111', '911121', 'SAL BP  BKS', '62'),
(22, '9', '91', '911', '9111', '911122', 'SAL BP  LPM', '71'),
(23, '9', '91', '911', '9111', '911123', 'SAL BP  LMP', '72'),
(24, '9', '91', '911', '9111', '911124', 'SAL BP  MWA', '81'),
(25, '9', '91', '911', '9111', '911125', 'SAL BP  SPI', '82'),
(26, '9', '91', '911', '9111', '911126', 'SAL BP  PTN', '91'),
(27, '9', '91', '911', '9111', '911127', 'SAL BP  RMG', '92'),
(28, '9', '91', '911', '9112', '911201', 'SILPA', ''),
(29, '9', '91', '911', '9112', '911202', 'Koreksi Belanja Tahun Anggaran yang Lalu', ''),
(30, '9', '91', '911', '9112', '911203', 'Surplus/Defisit', ''),
(31, '9', '91', '911', '9112', '911204', 'Pembiayaan Netto', '');

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
-- Indexes for table `akuntansi_aset_bersih_1`
--
ALTER TABLE `akuntansi_aset_bersih_1`
  ADD PRIMARY KEY (`id_akuntansi_aset_bersih_1`);

--
-- Indexes for table `akuntansi_aset_bersih_2`
--
ALTER TABLE `akuntansi_aset_bersih_2`
  ADD PRIMARY KEY (`id_akuntansi_aset_bersih_2`);

--
-- Indexes for table `akuntansi_aset_bersih_3`
--
ALTER TABLE `akuntansi_aset_bersih_3`
  ADD PRIMARY KEY (`id_akuntansi_aset_bersih_3`);

--
-- Indexes for table `akuntansi_aset_bersih_4`
--
ALTER TABLE `akuntansi_aset_bersih_4`
  ADD PRIMARY KEY (`id_akuntansi_aset_bersih_4`);

--
-- Indexes for table `akuntansi_aset_bersih_6`
--
ALTER TABLE `akuntansi_aset_bersih_6`
  ADD PRIMARY KEY (`id_akuntansi_aset_bersih_6`);

--
-- Indexes for table `akuntansi_hutang_1`
--
ALTER TABLE `akuntansi_hutang_1`
  ADD PRIMARY KEY (`id_akuntansi_hutang_1`);

--
-- Indexes for table `akuntansi_hutang_2`
--
ALTER TABLE `akuntansi_hutang_2`
  ADD PRIMARY KEY (`id_akuntansi_hutang_2`);

--
-- Indexes for table `akuntansi_hutang_3`
--
ALTER TABLE `akuntansi_hutang_3`
  ADD PRIMARY KEY (`id_akuntansi_hutang_3`);

--
-- Indexes for table `akuntansi_hutang_4`
--
ALTER TABLE `akuntansi_hutang_4`
  ADD PRIMARY KEY (`id_akuntansi_hutang_4`);

--
-- Indexes for table `akuntansi_hutang_6`
--
ALTER TABLE `akuntansi_hutang_6`
  ADD PRIMARY KEY (`id_akuntansi_hutang_6`);

--
-- Indexes for table `akuntansi_lra_1`
--
ALTER TABLE `akuntansi_lra_1`
  ADD PRIMARY KEY (`id_akuntansi_lra_1`);

--
-- Indexes for table `akuntansi_lra_2`
--
ALTER TABLE `akuntansi_lra_2`
  ADD PRIMARY KEY (`id_akuntansi_lra_2`);

--
-- Indexes for table `akuntansi_lra_3`
--
ALTER TABLE `akuntansi_lra_3`
  ADD PRIMARY KEY (`id_akuntansi_lra_3`);

--
-- Indexes for table `akuntansi_lra_4`
--
ALTER TABLE `akuntansi_lra_4`
  ADD PRIMARY KEY (`id_akuntansi_lra_4`);

--
-- Indexes for table `akuntansi_lra_6`
--
ALTER TABLE `akuntansi_lra_6`
  ADD PRIMARY KEY (`id_akuntansi_lra_6`);

--
-- Indexes for table `akuntansi_pembiayaan_1`
--
ALTER TABLE `akuntansi_pembiayaan_1`
  ADD PRIMARY KEY (`id_akuntansi_pembiayaan_1`);

--
-- Indexes for table `akuntansi_pembiayaan_2`
--
ALTER TABLE `akuntansi_pembiayaan_2`
  ADD PRIMARY KEY (`id_akuntansi_pembiayaan_2`);

--
-- Indexes for table `akuntansi_pembiayaan_3`
--
ALTER TABLE `akuntansi_pembiayaan_3`
  ADD PRIMARY KEY (`id_akuntansi_pembiayaan_3`);

--
-- Indexes for table `akuntansi_pembiayaan_4`
--
ALTER TABLE `akuntansi_pembiayaan_4`
  ADD PRIMARY KEY (`id_akuntansi_pembiayaan_4`);

--
-- Indexes for table `akuntansi_pembiayaan_6`
--
ALTER TABLE `akuntansi_pembiayaan_6`
  ADD PRIMARY KEY (`id_akuntansi_pembiayaan_6`);

--
-- Indexes for table `akuntansi_sal_1`
--
ALTER TABLE `akuntansi_sal_1`
  ADD PRIMARY KEY (`id_akuntansi_sal_1`);

--
-- Indexes for table `akuntansi_sal_2`
--
ALTER TABLE `akuntansi_sal_2`
  ADD PRIMARY KEY (`id_akuntansi_sal_2`);

--
-- Indexes for table `akuntansi_sal_3`
--
ALTER TABLE `akuntansi_sal_3`
  ADD PRIMARY KEY (`id_akuntansi_sal_3`);

--
-- Indexes for table `akuntansi_sal_4`
--
ALTER TABLE `akuntansi_sal_4`
  ADD PRIMARY KEY (`id_akuntansi_sal_4`);

--
-- Indexes for table `akuntansi_sal_6`
--
ALTER TABLE `akuntansi_sal_6`
  ADD PRIMARY KEY (`id_akuntansi_sal_6`);

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
  MODIFY `id_akuntansi_aset_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `akuntansi_aset_bersih_1`
--
ALTER TABLE `akuntansi_aset_bersih_1`
  MODIFY `id_akuntansi_aset_bersih_1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_aset_bersih_2`
--
ALTER TABLE `akuntansi_aset_bersih_2`
  MODIFY `id_akuntansi_aset_bersih_2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akuntansi_aset_bersih_3`
--
ALTER TABLE `akuntansi_aset_bersih_3`
  MODIFY `id_akuntansi_aset_bersih_3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `akuntansi_aset_bersih_4`
--
ALTER TABLE `akuntansi_aset_bersih_4`
  MODIFY `id_akuntansi_aset_bersih_4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `akuntansi_aset_bersih_6`
--
ALTER TABLE `akuntansi_aset_bersih_6`
  MODIFY `id_akuntansi_aset_bersih_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `akuntansi_hutang_1`
--
ALTER TABLE `akuntansi_hutang_1`
  MODIFY `id_akuntansi_hutang_1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_hutang_2`
--
ALTER TABLE `akuntansi_hutang_2`
  MODIFY `id_akuntansi_hutang_2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akuntansi_hutang_3`
--
ALTER TABLE `akuntansi_hutang_3`
  MODIFY `id_akuntansi_hutang_3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `akuntansi_hutang_4`
--
ALTER TABLE `akuntansi_hutang_4`
  MODIFY `id_akuntansi_hutang_4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `akuntansi_hutang_6`
--
ALTER TABLE `akuntansi_hutang_6`
  MODIFY `id_akuntansi_hutang_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `akuntansi_lra_1`
--
ALTER TABLE `akuntansi_lra_1`
  MODIFY `id_akuntansi_lra_1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_lra_2`
--
ALTER TABLE `akuntansi_lra_2`
  MODIFY `id_akuntansi_lra_2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akuntansi_lra_3`
--
ALTER TABLE `akuntansi_lra_3`
  MODIFY `id_akuntansi_lra_3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `akuntansi_lra_4`
--
ALTER TABLE `akuntansi_lra_4`
  MODIFY `id_akuntansi_lra_4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `akuntansi_lra_6`
--
ALTER TABLE `akuntansi_lra_6`
  MODIFY `id_akuntansi_lra_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `akuntansi_pembiayaan_1`
--
ALTER TABLE `akuntansi_pembiayaan_1`
  MODIFY `id_akuntansi_pembiayaan_1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akuntansi_pembiayaan_2`
--
ALTER TABLE `akuntansi_pembiayaan_2`
  MODIFY `id_akuntansi_pembiayaan_2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `akuntansi_pembiayaan_3`
--
ALTER TABLE `akuntansi_pembiayaan_3`
  MODIFY `id_akuntansi_pembiayaan_3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `akuntansi_pembiayaan_4`
--
ALTER TABLE `akuntansi_pembiayaan_4`
  MODIFY `id_akuntansi_pembiayaan_4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `akuntansi_pembiayaan_6`
--
ALTER TABLE `akuntansi_pembiayaan_6`
  MODIFY `id_akuntansi_pembiayaan_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `akuntansi_sal_1`
--
ALTER TABLE `akuntansi_sal_1`
  MODIFY `id_akuntansi_sal_1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_sal_2`
--
ALTER TABLE `akuntansi_sal_2`
  MODIFY `id_akuntansi_sal_2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_sal_3`
--
ALTER TABLE `akuntansi_sal_3`
  MODIFY `id_akuntansi_sal_3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `akuntansi_sal_4`
--
ALTER TABLE `akuntansi_sal_4`
  MODIFY `id_akuntansi_sal_4` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `akuntansi_sal_6`
--
ALTER TABLE `akuntansi_sal_6`
  MODIFY `id_akuntansi_sal_6` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

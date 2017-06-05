-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2017 at 01:08 AM
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
-- Table structure for table `akuntansi_aset_6`
--

CREATE TABLE IF NOT EXISTS `akuntansi_aset_6` (
  `id_akuntansi_aset_6` int(11) NOT NULL,
  `akun_1` varchar(20) NOT NULL,
  `akun_2` varchar(20) NOT NULL,
  `akun_3` varchar(20) NOT NULL,
  `akun_4` varchar(20) NOT NULL,
  `akun_6` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_unit` varchar(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_aset_6`
--

INSERT INTO `akuntansi_aset_6` (`id_akuntansi_aset_6`, `akun_1`, `akun_2`, `akun_3`, `akun_4`, `akun_6`, `nama`, `kode_unit`) VALUES
(69, '1', '11', '111', '1111', '111101', 'Kas Bank Mandiri Operasional BLU No Rek. 1360020080005', 'all'),
(70, '1', '11', '111', '1111', '111102', 'Kas Bank Mandiri Operasional BLU BPP FH No Rek. 1360020080013', '11'),
(71, '1', '11', '111', '1111', '111103', 'Kas Bank Mandiri Operasional BLU BPP FE No Rek. 1360020080021', '12'),
(72, '1', '11', '111', '1111', '111104', 'Kas Bank Mandiri Operasional BLU BPP FT No Rek. 1360020080039', ''),
(73, '1', '11', '111', '1111', '111105', 'Kas Bank Mandiri Operasional BLU BPP FK No Rek. 1360020080047', ''),
(74, '1', '11', '111', '1111', '111106', 'Kas Bank Mandiri Operasional BLU BPP FP No Rek. 1360020080054', ''),
(75, '1', '11', '111', '1111', '111107', 'Kas Bank Mandiri Operasional BLU BPP FIB No Rek. 1360020080062', ''),
(76, '1', '11', '111', '1111', '111108', 'Kas Bank Mandiri Operasional BLU BPP FISIP No Rek. 1360020080070', ''),
(77, '1', '11', '111', '1111', '111109', 'Kas Bank Mandiri Operasional BLU BPP FMIPA No Rek. 1360020080088', ''),
(78, '1', '11', '111', '1111', '111110', 'Kas Bank Mandiri Operasional BLU BPP FKM No Rek. 1360020080096', ''),
(79, '1', '11', '111', '1111', '111111', 'Kas Bank Mandiri Operasional BLU BPP FPIK No Rek. 1360020080104', ''),
(80, '1', '11', '111', '1111', '111112', 'Kas Bank Mandiri Operasional BLU BPP FPSI No Rek. 1360020080112', ''),
(81, '1', '11', '111', '1111', '111113', 'Kas Bank Mandiri Operasional BLU BPP LPPM No Rek. 1360007101626', ''),
(82, '1', '11', '111', '1111', '111114', 'Kas Bank Mandiri Operasional BLU BPP LP2MP No Rek. 1360007117549', ''),
(83, '1', '11', '111', '1111', '111115', 'Kas Bank Mandiri Operasional BLU BPP KP I No Rek. 1360020080146', ''),
(84, '1', '11', '111', '1111', '111116', 'Kas Bank Mandiri Operasional BLU BPP RSND No Rek. 1360014046251', ''),
(85, '1', '11', '111', '1111', '111117', 'Kas Bank Mandiri BPn 026 UNDIP No Rek. 1360005599045', ''),
(86, '1', '11', '111', '1111', '111118', 'Kas Bank Mandiri Dana Kelolaan Penelitian dan Pengabdian No Rek. 1360006977653', ''),
(87, '1', '11', '111', '1111', '111119', 'Kas Bank Mandiri Operasional BLU Uji Kompetensi No Rek. 1360090044444', ''),
(88, '1', '11', '111', '1111', '111120', 'Kas Bank Mandiri Operasional BLU Pendaftaran Ujian Kompetensi No Rek. 1360014923632', ''),
(89, '1', '11', '111', '1111', '111121', 'Kas Bank Mandiri Operasional BLU Unicef No Rek. 1360015415000', ''),
(90, '1', '11', '111', '1112', '111201', 'Kas Bank BNI BPg 026 UNDIP Rek. 0040131479', ''),
(91, '1', '11', '111', '1112', '111202', 'Kas Bank BNI Operasional BLU BPP Pascasarjana No Rek. 8012345671', ''),
(92, '1', '11', '111', '1112', '111203', 'Kas Bank BNI BPn 026 Undip No Rek. 0033664282', ''),
(93, '1', '11', '111', '1112', '111204', 'Kas Bank BNI Dana Kelolaan BLU Pascasarjana No Rek. 8012345682', ''),
(94, '1', '11', '111', '1112', '111205', 'Kas Bank BNI Dana Kelolaan BLU No Rek. 00113147606', ''),
(95, '1', '11', '111', '1112', '111206', 'Kas Bank BNI Dana Kelolaan BP-SPBU No Rek. 0196949645', ''),
(96, '1', '11', '111', '1112', '111207', 'Kas Bank BNI Dana Kelolaan Kerjasama BPOM No Rek. 0259467775', ''),
(97, '1', '11', '111', '1113', '111301', 'Kas Bank BTN BPn 026 UNDIP No Rek. 0001301300004763', ''),
(98, '1', '11', '111', '1113', '111302', 'Kas Bank BTN Operasional RSND No Rek. 0000017501300000323', ''),
(99, '1', '11', '111', '1114', '111401', 'Kas Bank BCA Dana Kelolaan Kegiatan BLU No Rek. 0095310040', ''),
(100, '1', '11', '111', '1115', '111501', 'Kas Bank BRI BPn 026 UNDIP No Rek. 0000032501000988301', ''),
(101, '1', '11', '111', '1115', '111502', 'Kas Bank BRI Dana Kelolaan Beasiswa BUMN', ''),
(102, '1', '11', '111', '1116', '111601', 'Kas Bank BPD Dana Kelolaan Kerjasama/Beasiswa', ''),
(103, '1', '11', '112', '1121', '112101', 'Investasi Jangka Pendek Pada Deposito BNI', ''),
(104, '1', '11', '112', '1121', '112102', 'Investasi Jangka Pendek Pada Deposito BTN', ''),
(105, '1', '11', '112', '1121', '112103', 'Investasi Jangka Pendek Pada Deposito Mandiri', ''),
(106, '1', '11', '112', '1121', '112104', 'Investasi Jangka Pendek Pada Deposito BRI', ''),
(107, '1', '11', '112', '1121', '112105', 'Investasi Jangka Pendek Pada Deposito BCA', ''),
(108, '1', '11', '112', '1121', '112106', 'Investasi Jangka Pendek Pada Deposito BPD', ''),
(109, '1', '11', '112', '1122', '112201', ' Investasi Investasi Jangka Pendek Pada Reksadana ', ''),
(110, '1', '11', '112', '1123', '112301', 'Investasi Jangka Pendek Pada Saham Perusahaan ', ''),
(111, '1', '11', '113', '1131', '113101', 'Piutang Jasa Layanan Utama', ''),
(112, '1', '11', '113', '1131', '113102', 'Piutang Jasa Layanan Pendukung Pendidikan', ''),
(113, '1', '11', '113', '1132', '113201', 'Piutang Dari Masyarakat', ''),
(114, '1', '11', '113', '1132', '113202', 'Piutang Usaha PTNBH', ''),
(115, '1', '11', '113', '1132', '113203', 'Piutang Kerjasama Akademik', ''),
(116, '1', '11', '113', '1132', '113204', 'Piutang Pengelolaan Dana Abadi', ''),
(117, '1', '11', '113', '1132', '113205', 'Piutang Pengelolaan Kekayaan PTNBH', ''),
(118, '1', '11', '113', '1132', '113206', 'Piutang Bantuan dari Pemerintah Daerah', ''),
(119, '1', '11', '113', '1132', '113207', 'Piutang Lainnya', ''),
(120, '1', '11', '113', '1133', '113301', 'Penyisihan Piutang Tak Tertagih-Piutang Layanan', ''),
(121, '1', '11', '113', '1133', '113302', 'Penyisihan Piutang Tak Tertagih-Piutang Usaha Lainnya', ''),
(122, '1', '11', '114', '1141', '114101', 'Persediaan Barang Konsumsi', ''),
(123, '1', '11', '114', '1141', '114103', 'Bahan untuk Pemeliharaan', ''),
(124, '1', '11', '114', '1141', '114104', 'Suku Cadang', ''),
(125, '1', '11', '114', '1141', '114105', 'Hewan dan Tanaman untuk dijual atau diserahkan kepada Masyarakat', ''),
(126, '1', '11', '114', '1141', '114106', 'Barang Lainnya Untuk dijual atau diserahkan kepada Masyarakat', ''),
(127, '1', '11', '114', '1141', '114107', 'Bahan Baku', ''),
(128, '1', '11', '114', '1141', '114108', 'Persediaan untuk tujuan strategis/berjaga - jaga', ''),
(129, '1', '11', '114', '1141', '114109', 'Persediaan Operasi Pendidikan Lainnya', ''),
(130, '1', '11', '114', '1141', '114110', 'Materai dan Perangko', ''),
(131, '1', '11', '114', '1141', '114101', ' Bahan Habis Pakai Kesehatan (Rumah Sakit)', ''),
(132, '1', '11', '114', '1141', '114101', ' Obat-Obatan Rumah Sakit', ''),
(133, '1', '11', '114', '1141', '121101', ' Bahan Percobaan Laboratorium', ''),
(134, '1', '11', '114', '1141', '121101', ' Persediaan SPBU', ''),
(135, '1', '11', '114', '1211', '121101', ' Persediaan Cetak (UPT Undip Press)', ''),
(136, '1', '11', '115', '1151', '115101', 'Sewa Tanah Dibayar Dimuka', ''),
(137, '1', '11', '115', '1151', '115102', 'Sewa Gedung Dibayar Dimuka', ''),
(138, '1', '12', '121', '1211', '121101', 'Investasi Jangka Pendek Pada Deposito Mandiri', ''),
(139, '1', '12', '121', '1211', '121102', 'Investasi Jangka Pendek Pada Deposito BNI', ''),
(140, '1', '12', '121', '1211', '121103', 'Investasi Jangka Pendek Pada Deposito BTN', ''),
(141, '1', '12', '121', '1211', '121104', 'Investasi Jangka Pendek Pada Deposito BRI', ''),
(142, '1', '12', '121', '1211', '121105', 'Investasi Jangka Pendek Pada Deposito BCA', ''),
(143, '1', '12', '121', '1211', '121106', 'Investasi Jangka Pendek Pada Deposito BPD', ''),
(144, '1', '12', '121', '1212', '121201', 'Investasi Jangka Panjang Pada Reksadana', ''),
(145, '1', '12', '121', '1213', '121301', 'Investasi Jangka Panjang Pada Saham Perusahaan', ''),
(146, '1', '12', '122', '1221', '122101', 'Tanah Persial', ''),
(147, '1', '12', '122', '1221', '122102', 'Tanah Non Persil', ''),
(148, '1', '12', '122', '1221', '122103', 'Lapangan', ''),
(149, '1', '12', '122', '1222', '122201', 'Gedung  dan Bangunan Tempat Kerja', ''),
(150, '1', '12', '122', '1222', '122202', 'Gedung dan Bangunan Tempat Tinggal', ''),
(151, '1', '12', '122', '1222', '122203', 'Gedung dan Bangunan Monumen/Tugu', ''),
(152, '1', '12', '122', '1222', '122204', 'Bangunan Menara', ''),
(153, '1', '12', '122', '1223', '122301', 'Alat Besar', ''),
(154, '1', '12', '122', '1223', '122302', 'Alat Angkutan', ''),
(155, '1', '12', '122', '1223', '122303', 'Alat Bengkel dan Alat Ukur', ''),
(156, '1', '12', '122', '1223', '122304', 'Alat Pertanian', ''),
(157, '1', '12', '122', '1223', '122305', 'Alat Kantor dan Rumah Tangga', ''),
(158, '1', '12', '122', '1223', '122306', 'Alat Studio, Komunikasi Dan Pemancar', ''),
(159, '1', '12', '122', '1223', '122307', 'Alat Kedokteran', ''),
(160, '1', '12', '122', '1223', '122308', 'Alat Laboratorium', ''),
(161, '1', '12', '122', '1223', '122309', 'Alat Persenjataan', ''),
(162, '1', '12', '122', '1223', '122310', 'Alat Eksplorasi dan Produksi', ''),
(163, '1', '12', '122', '1223', '122311', 'Alat Keselamatan Kerja', ''),
(164, '1', '12', '122', '1223', '122312', 'Alat Kerja Penerbangan', ''),
(165, '1', '12', '122', '1223', '122313', 'Alat Peraga, Rambu-Rambu dan Alat Olah Raga', ''),
(166, '1', '12', '122', '1224', '122401', 'Jalan, Irigasi dan Jaringan', ''),
(167, '1', '12', '122', '1225', '122501', 'Aset Perpustakaan', ''),
(168, '1', '12', '122', '1225', '122502', 'Aset Bercorak Kesenian/Kebudayaan/Olahraga', ''),
(169, '1', '12', '122', '1225', '122503', 'Hewan dan Tanaman', ''),
(170, '1', '12', '122', '1225', '122504', 'Barang Koleksi Non Budaya', ''),
(171, '1', '12', '122', '1226', '122601', 'Konstruksi Dalam Pengerjaan', ''),
(172, '1', '12', '123', '1231', '123101', 'Software', ''),
(173, '1', '12', '123', '1231', '123102', 'Paten', ''),
(174, '1', '12', '123', '1231', '123103', 'Trandemark', ''),
(175, '1', '12', '123', '1231', '123104', 'HAKI', ''),
(176, '1', '12', '123', '1231', '123105', 'Goodwill', ''),
(177, '1', '12', '911', '9111', '911101', 'Akumulasi Penyusutan Gedung dan Bangunan', ''),
(178, '1', '12', '911', '9111', '911102', 'Akumulasi Penyusutan Peralatan dan Mesin', ''),
(179, '1', '12', '911', '9111', '911103', 'Akumulasi Penyusutan Jalan, Irigasi dan Jaringan', ''),
(180, '1', '12', '911', '9112', '911201', 'Akumulasi Amortisasi Aset Tak Berwujud', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_aset_6`
--
ALTER TABLE `akuntansi_aset_6`
  ADD PRIMARY KEY (`id_akuntansi_aset_6`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_aset_6`
--
ALTER TABLE `akuntansi_aset_6`
  MODIFY `id_akuntansi_aset_6` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=181;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table rsa.akuntansi_jenis_transaksi
CREATE TABLE IF NOT EXISTS `akuntansi_jenis_transaksi` (
  `id_jenis_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(50) DEFAULT '0',
  `nama_terjurnal` varchar(50) DEFAULT '0',
  `nama_notifikasi` varchar(50) DEFAULT NULL,
  `basis` varchar(50) DEFAULT '0',
  `has_pajak` int(1) NOT NULL DEFAULT '0',
  `has_pengembalian` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jenis_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table rsa.akuntansi_jenis_transaksi: ~16 rows (approximately)
DELETE FROM `akuntansi_jenis_transaksi`;
/*!40000 ALTER TABLE `akuntansi_jenis_transaksi` DISABLE KEYS */;
INSERT INTO `akuntansi_jenis_transaksi` (`id_jenis_transaksi`, `nama_jenis`, `nama_terjurnal`, `nama_notifikasi`, `basis`, `has_pajak`, `has_pengembalian`) VALUES
	(1, 'GUP Kuitansi', 'GP', 'gup', 'kuitansi', 1, 0),
	(2, 'GUP', 'GUP', 'gu', 'spm', 0, 0),
	(3, 'GUP Nihil', 'GUP_NIHIL', 'gup_nihil', 'kuitansi', 1, 0),
	(4, 'GUP Pengembalian', 'GUP_PENGEMBALIAN', 'gup_pengembalian', 'kuitansi', 1, 0),
	(5, 'UP', 'UP', 'up', 'kuitansi', 0, 0),
	(6, 'TUP', 'TUP', 'tup', 'spm', 0, 0),
	(7, 'TUP Nihil', 'TUP_NIHIL', 'tup_nihil', 'kuitansi', 1, 0),
	(8, 'PUP', 'PUP', 'pup', 'spm', 0, 0),
	(9, 'LS-Kontrak', 'LK', 'lk', 'kuitansi', 1, 0),
	(10, 'LS-Non Kontrak', 'LN', 'ln', 'kuitansi', 1, 0),
	(11, 'LSPG', 'NK', 'spm', 'spm', 1, 0),
	(12, 'Kerja Sama', 'KS', 'ks', 'spm', 0, 0),
	(13, 'E Money', 'EM', 'em', 'kuitansi', 0, 0),
	(14, 'RM Gaji', 'jurnal_umum', NULL, 'input', 1, 1),
	(15, 'Penerimaan', 'penerimaan', NULL, 'input', 0, 0),
	(16, 'Memorial', 'MEMORIAL', NULL, 'input', 1, 1),
	(17, 'TUP Pengembalian', 'TUP_PENGEMBALIAN', 'tup_pengembalian', 'kuitansi', 0, 0);
/*!40000 ALTER TABLE `akuntansi_jenis_transaksi` ENABLE KEYS */;

-- Dumping structure for table rsa.akuntansi_jenis_user
CREATE TABLE IF NOT EXISTS `akuntansi_jenis_user` (
  `id_jenis_user` int(11) NOT NULL AUTO_INCREMENT,
  `level_user` int(11) NOT NULL DEFAULT '0',
  `nama_jenis` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jenis_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table rsa.akuntansi_jenis_user: ~10 rows (approximately)
DELETE FROM `akuntansi_jenis_user`;
/*!40000 ALTER TABLE `akuntansi_jenis_user` DISABLE KEYS */;
INSERT INTO `akuntansi_jenis_user` (`id_jenis_user`, `level_user`, `nama_jenis`) VALUES
	(1, 1, 'Operator'),
	(2, 2, 'Verifikator'),
	(3, 3, 'LK Undip'),
	(4, 4, 'Monitoring  Universitas'),
	(5, 5, 'Operator RM Gaji'),
	(6, 6, 'Monitoring Unit'),
	(7, 7, 'Audit Undip'),
	(8, 8, 'Penerimaan'),
	(9, 9, 'Admin'),
	(10, 10, 'Auditor');
/*!40000 ALTER TABLE `akuntansi_jenis_user` ENABLE KEYS */;

-- Dumping structure for table rsa.akuntansi_menu
CREATE TABLE IF NOT EXISTS `akuntansi_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(80) NOT NULL,
  `alamat` text NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_parent` int(11) DEFAULT NULL,
  `notif` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table rsa.akuntansi_menu: ~27 rows (approximately)
DELETE FROM `akuntansi_menu`;
/*!40000 ALTER TABLE `akuntansi_menu` DISABLE KEYS */;
INSERT INTO `akuntansi_menu` (`id_menu`, `nama_menu`, `alamat`, `icon`, `urutan`, `parent_id`, `is_parent`, `notif`) VALUES
	(1, 'Monitoring', 'akuntansi/kuitansi/monitor', NULL, 1, NULL, NULL, NULL),
	(2, 'Laporan', '', NULL, 11, NULL, 1, NULL),
	(3, 'Buku Jurnal', 'akuntansi/laporan/rekap_jurnal', NULL, 1, 2, NULL, NULL),
	(4, 'Buku Besar', 'akuntansi/laporan/buku_besar', NULL, 2, 2, NULL, NULL),
	(5, 'Neraca Saldo', 'akuntansi/laporan/neraca_saldo', NULL, 3, 2, NULL, NULL),
	(6, 'Laporan Utama', 'akuntansi/laporan/lainnya', NULL, 12, NULL, NULL, NULL),
	(7, 'Rekap SPM Siak', 'akuntansi/dashboard/dashboard_spm_terjurnal', NULL, 15, NULL, NULL, NULL),
	(8, 'Rekap SPM diproses', '/akuntansi/dashboard/dashboard_proses/each', NULL, 17, NULL, NULL, NULL),
	(9, 'Koreksi SPM', 'akuntansi/checker/import_cek_spm_siak', NULL, 18, NULL, NULL, NULL),
	(10, 'Penerimaan', 'akuntansi/penerimaan/index', NULL, 2, NULL, NULL, NULL),
	(11, 'Import Penerimaan', 'akuntansi/penerimaan/import_penerimaan', NULL, 3, NULL, NULL, NULL),
	(12, 'Memorial', 'akuntansi/memorial/index', NULL, 6, NULL, NULL, NULL),
	(13, 'Jurnal APBN', 'akuntansi/jurnal_umum', NULL, 4, NULL, NULL, NULL),
	(14, 'Import Jurnal APBN', 'akuntansi/jurnal_umum/import_jurnal_umum', NULL, 5, NULL, NULL, NULL),
	(15, 'Administrasi', '', NULL, 16, NULL, 1, NULL),
	(16, 'Manj. User', 'akuntansi/user/manage', NULL, 1, 15, NULL, NULL),
	(17, 'Manj. Pejabat', 'akuntansi/pejabat/manage', NULL, 2, 15, NULL, NULL),
	(18, 'Manj. Akun', 'akuntansi/akun/list_akun', NULL, 3, 15, NULL, NULL),
	(19, 'Manj. Rekening', 'akuntansi/rekening/index', NULL, 4, 15, NULL, NULL),
	(20, 'Manj. Saldo', 'akuntansi/saldo/index', NULL, 5, 15, NULL, NULL),
	(21, 'Manj. Kuitansi Terjurnal ', 'akuntansi/editor/edit_kuitansi', NULL, 6, 15, NULL, NULL),
	(22, 'Verifikasi', 'akuntansi/kuitansi/jadi', NULL, 9, NULL, NULL, 'kuitansi_jadi'),
	(23, 'Posting', 'akuntansi/kuitansi/posting', NULL, 10, NULL, NULL, NULL),
	(24, 'Manj. Kuitansi Terjurnal (ver) ', 'akuntansi/editor/edit_kuitansi', NULL, 14, NULL, NULL, NULL),
	(25, 'Kuitansi Jadi', 'akuntansi/kuitansi/jadi', NULL, 7, NULL, NULL, 'kuitansi_jadi'),
	(26, 'Kuitansi', 'akuntansi/kuitansi/index', NULL, 8, NULL, NULL, 'kuitansi'),
	(27, 'Laporan Realisasi Anggaran', 'akuntansi/laporan/lra_unit', NULL, 13, NULL, NULL, NULL);
/*!40000 ALTER TABLE `akuntansi_menu` ENABLE KEYS */;

-- Dumping structure for table rsa.akuntansi_menu_by_level
CREATE TABLE IF NOT EXISTS `akuntansi_menu_by_level` (
  `id_menu` int(11) DEFAULT NULL,
  `level_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rsa.akuntansi_menu_by_level: ~40 rows (approximately)
DELETE FROM `akuntansi_menu_by_level`;
/*!40000 ALTER TABLE `akuntansi_menu_by_level` DISABLE KEYS */;
INSERT INTO `akuntansi_menu_by_level` (`id_menu`, `level_user`) VALUES
	(26, 1),
	(25, 1),
	(27, 1),
	(11, 1),
	(2, 1),
	(1, 1),
	(7, 1),
	(2, 2),
	(24, 2),
	(1, 2),
	(23, 2),
	(7, 2),
	(22, 2),
	(15, 3),
	(13, 3),
	(9, 3),
	(2, 3),
	(6, 3),
	(12, 3),
	(1, 3),
	(10, 3),
	(8, 3),
	(7, 3),
	(2, 4),
	(14, 5),
	(13, 5),
	(2, 5),
	(2, 6),
	(1, 6),
	(7, 6),
	(2, 7),
	(11, 8),
	(2, 8),
	(12, 8),
	(10, 8),
	(15, 9),
	(2, 10),
	(6, 10),
	(1, 10),
	(7, 10);
/*!40000 ALTER TABLE `akuntansi_menu_by_level` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

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

-- Dumping structure for table rsa_2018.akuntansi_relasi_unit
CREATE TABLE IF NOT EXISTS `akuntansi_relasi_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_akun` char(12) NOT NULL,
  `kode_unit` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- Dumping data for table rsa_2018.akuntansi_relasi_unit: ~0 rows (approximately)
DELETE FROM `akuntansi_relasi_unit`;
/*!40000 ALTER TABLE `akuntansi_relasi_unit` DISABLE KEYS */;
INSERT INTO `akuntansi_relasi_unit` (`id`, `kode_akun`, `kode_unit`) VALUES
	(1, '111112', '01'),
	(2, '111113', '02'),
	(3, '111114', '03'),
	(4, '111115', '04'),
	(5, '111116', '05'),
	(6, '111117', '06'),
	(7, '111118', '07'),
	(8, '111119', '08'),
	(9, '111121', '09'),
	(10, '111122', '10'),
	(11, '111123', '11'),
	(12, '111124', '19'),
	(13, '111125', '20'),
	(14, '111127', '18'),
	(15, '111139', '22'),
	(16, '111141', '21'),
	(17, '111142', '25'),
	(18, '111143', '24'),
	(19, '111144', '23'),
	(20, '111145', '01'),
	(21, '111146', '02'),
	(22, '111147', '03'),
	(23, '111148', '04'),
	(24, '111149', '05'),
	(25, '111151', '06'),
	(26, '111152', '07'),
	(27, '111153', '08'),
	(28, '111154', '09'),
	(29, '111155', '10'),
	(30, '111156', '11'),
	(31, '111157', '19'),
	(32, '111158', '20'),
	(33, '111159', '12'),
	(34, '111161', '13'),
	(35, '111162', '18'),
	(36, '111212', '12'),
	(37, '111312', '18'),
	(38, '911111', '01'),
	(39, '911112', '02'),
	(40, '911113', '03'),
	(41, '911114', '04'),
	(42, '911115', '05'),
	(43, '911116', '06'),
	(44, '911117', '07'),
	(45, '911118', '08'),
	(46, '911119', '09'),
	(47, '911121', '10'),
	(48, '911122', '11'),
	(49, '911123', '12'),
	(50, '911124', '13'),
	(51, '911125', '14'),
	(52, '911126', '15'),
	(53, '911127', '16'),
	(54, '911128', '17'),
	(55, '911129', '18'),
	(56, '911131', '24'),
	(57, '911132', '23'),
	(58, '911133', '19'),
	(59, '911134', '20'),
	(60, '911135', '21'),
	(61, '911136', '22'),
	(63, '911137', '25'),
	(64, '111135', '14'),
	(65, '111136', '15'),
	(66, '111137', '16'),
	(67, '111138', '17'),
	(68, '111163', 'all'),
	(69, '111222', 'all'),
	(70, '111315', 'all'),
	(71, '111514', 'all'),
	(72, '111223', 'all'),
	(73, '911211', 'all');
/*!40000 ALTER TABLE `akuntansi_relasi_unit` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

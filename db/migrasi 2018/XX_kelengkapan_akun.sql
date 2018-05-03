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

-- Dumping structure for view rsa_2018.akuntansi_aset_1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_1` (
	`id_akuntansi_aset_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_2
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_2` (
	`id_aset_aset_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_3
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_3` (
	`id_aset_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_4
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_4` (
	`id_aset_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_5
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_5` (
	`id_aset_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_6
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_6` (
	`id_aset_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_unit` VARCHAR(8) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_bersih_1` (
	`id_akuntansi_aset_bersih_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_2
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_bersih_2` (
	`id_aset_bersih_aset_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_3
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_bersih_3` (
	`id_aset_bersih_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_4
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_bersih_4` (
	`id_aset_bersih_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_5
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_bersih_5` (
	`id_aset_bersih_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_6
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_aset_bersih_6` (
	`id_aset_bersih_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_hutang_1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_hutang_1` (
	`id_akuntansi_hutang_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_hutang_2
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_hutang_2` (
	`id_hutang_aset_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_hutang_3
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_hutang_3` (
	`id_hutang_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_hutang_4
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_hutang_4` (
	`id_hutang_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_hutang_5
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_hutang_5` (
	`id_hutang_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_hutang_6
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_hutang_6` (
	`id_hutang_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_lra_1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_lra_1` (
	`id_akuntansi_lra_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_lra_2
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_lra_2` (
	`id_lra_aset_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_lra_3
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_lra_3` (
	`id_lra_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_lra_4
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_lra_4` (
	`id_lra_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_lra_5
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_lra_5` (
	`id_lra_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_lra_6
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_lra_6` (
	`id_lra_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_pembiayaan_1` (
	`id_akuntansi_pembiayaan_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_2
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_pembiayaan_2` (
	`id_pembiayaan_aset_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_3
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_pembiayaan_3` (
	`id_pembiayaan_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_4
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_pembiayaan_4` (
	`id_pembiayaan_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_5
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_pembiayaan_5` (
	`id_pembiayaan_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_6
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_pembiayaan_6` (
	`id_pembiayaan_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_sal_1
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_sal_1` (
	`id_akuntansi_sal_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_sal_2
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_sal_2` (
	`id_sal_aset_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_sal_3
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_sal_3` (
	`id_sal_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_sal_4
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_sal_4` (
	`id_sal_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_sal_5
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_sal_5` (
	`id_sal_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_sal_6
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akuntansi_sal_6` (
	`id_sal_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_1` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_2` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_3` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_4` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_5` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`akun_6` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_unit` VARCHAR(8) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akun_belanja
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `akun_belanja` (
	`id_akun_belanja` INT(11) NOT NULL,
	`kode_akun1digit` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_akun1digit` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_akun2digit` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_akun2digit` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_akun3digit` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_akun3digit` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_akun4digit` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_akun4digit` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_akun5digit` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_akun5digit` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`kode_akun` CHAR(12) NOT NULL COLLATE 'latin1_swedish_ci',
	`nama_akun` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`sumber_dana` ENUM('SELAIN-APBN','APBN-BPPTNBH','SPI-SILPA','APBN-LAINNYA') NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view rsa_2018.akuntansi_aset_1
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_1` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun1digit` AS `id_akuntansi_aset_1`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 1) ;

-- Dumping structure for view rsa_2018.akuntansi_aset_2
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_2` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun2digit` AS `id_aset_aset_2`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 1) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_3
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_3`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_3` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun3digit` AS `id_aset_3`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 1) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_4
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_4`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_4` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun4digit` AS `id_aset_4`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 1) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_5
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_5`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_5` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun5digit` AS `id_aset_5`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 1) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_6
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_6`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_6` AS select distinct `rb`.`kode_akun` AS `id_aset_6`,`rb`.`kode_akun1digit` AS `akun_1`,`rb`.`kode_akun2digit` AS `akun_2`,`rb`.`kode_akun3digit` AS `akun_3`,`rb`.`kode_akun4digit` AS `akun_4`,`rb`.`kode_akun5digit` AS `akun_5`,`rb`.`kode_akun` AS `akun_6`,`rb`.`nama_akun` AS `nama`,`ar`.`kode_unit` AS `kode_unit` from (`rba_2018`.`akun_belanja` `rb` left join `rsa_2018`.`akuntansi_relasi_unit` `ar` on((`rb`.`kode_akun` = `ar`.`kode_akun`))) where (`rb`.`kode_akun1digit` = 1) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_1
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_bersih_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_bersih_1` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun1digit` AS `id_akuntansi_aset_bersih_1`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 3) ;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_2
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_bersih_2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_bersih_2` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun2digit` AS `id_aset_bersih_aset_2`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 3) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_3
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_bersih_3`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_bersih_3` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun3digit` AS `id_aset_bersih_3`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 3) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_4
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_bersih_4`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_bersih_4` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun4digit` AS `id_aset_bersih_4`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 3) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_5
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_bersih_5`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_bersih_5` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun5digit` AS `id_aset_bersih_5`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 3) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_aset_bersih_6
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_aset_bersih_6`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_aset_bersih_6` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun` AS `id_aset_bersih_6`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`kode_akun` AS `akun_6`,`rba_2018`.`akun_belanja`.`nama_akun` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 3) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_hutang_1
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_hutang_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_hutang_1` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun1digit` AS `id_akuntansi_hutang_1`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 2) ;

-- Dumping structure for view rsa_2018.akuntansi_hutang_2
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_hutang_2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_hutang_2` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun2digit` AS `id_hutang_aset_2`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 2) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_hutang_3
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_hutang_3`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_hutang_3` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun3digit` AS `id_hutang_3`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 2) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_hutang_4
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_hutang_4`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_hutang_4` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun4digit` AS `id_hutang_4`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 2) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_hutang_5
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_hutang_5`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_hutang_5` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun5digit` AS `id_hutang_5`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 2) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_hutang_6
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_hutang_6`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_hutang_6` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun` AS `id_hutang_6`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`kode_akun` AS `akun_6`,`rba_2018`.`akun_belanja`.`nama_akun` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 2) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_lra_1
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_lra_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_lra_1` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun1digit` AS `id_akuntansi_lra_1`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 4) ;

-- Dumping structure for view rsa_2018.akuntansi_lra_2
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_lra_2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_lra_2` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun2digit` AS `id_lra_aset_2`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 4) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_lra_3
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_lra_3`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_lra_3` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun3digit` AS `id_lra_3`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 4) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_lra_4
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_lra_4`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_lra_4` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun4digit` AS `id_lra_4`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 4) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_lra_5
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_lra_5`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_lra_5` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun5digit` AS `id_lra_5`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 4) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_lra_6
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_lra_6`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_lra_6` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun` AS `id_lra_6`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`kode_akun` AS `akun_6`,`rba_2018`.`akun_belanja`.`nama_akun` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 4) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_1
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_pembiayaan_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_pembiayaan_1` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun1digit` AS `id_akuntansi_pembiayaan_1`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 8) ;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_2
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_pembiayaan_2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_pembiayaan_2` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun2digit` AS `id_pembiayaan_aset_2`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 8) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_3
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_pembiayaan_3`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_pembiayaan_3` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun3digit` AS `id_pembiayaan_3`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 8) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_4
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_pembiayaan_4`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_pembiayaan_4` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun4digit` AS `id_pembiayaan_4`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 8) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_5
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_pembiayaan_5`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_pembiayaan_5` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun5digit` AS `id_pembiayaan_5`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 8) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_pembiayaan_6
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_pembiayaan_6`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_pembiayaan_6` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun` AS `id_pembiayaan_6`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`kode_akun` AS `akun_6`,`rba_2018`.`akun_belanja`.`nama_akun` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 8) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_sal_1
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_sal_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_sal_1` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun1digit` AS `id_akuntansi_sal_1`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 9) ;

-- Dumping structure for view rsa_2018.akuntansi_sal_2
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_sal_2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_sal_2` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun2digit` AS `id_sal_aset_2`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 9) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_sal_3
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_sal_3`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_sal_3` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun3digit` AS `id_sal_3`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 9) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_sal_4
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_sal_4`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_sal_4` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun4digit` AS `id_sal_4`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 9) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_sal_5
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_sal_5`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_sal_5` AS select distinct `rba_2018`.`akun_belanja`.`kode_akun5digit` AS `id_sal_5`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `akun_1`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `akun_2`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `akun_3`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `akun_4`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `akun_5`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 9) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akuntansi_sal_6
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akuntansi_sal_6`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akuntansi_sal_6` AS select distinct `rb`.`kode_akun` AS `id_sal_6`,`rb`.`kode_akun1digit` AS `akun_1`,`rb`.`kode_akun2digit` AS `akun_2`,`rb`.`kode_akun3digit` AS `akun_3`,`rb`.`kode_akun4digit` AS `akun_4`,`rb`.`kode_akun5digit` AS `akun_5`,`rb`.`kode_akun` AS `akun_6`,`rb`.`nama_akun` AS `nama`,`ar`.`kode_unit` AS `kode_unit` from (`rba_2018`.`akun_belanja` `rb` join `rsa_2018`.`akuntansi_relasi_unit` `ar` on((`rb`.`kode_akun` = `ar`.`kode_akun`))) where (`rb`.`kode_akun1digit` = 9) order by `akun_1` ;

-- Dumping structure for view rsa_2018.akun_belanja
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `akun_belanja`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `akun_belanja` AS select * from rba_2018.akun_belanja where kode_akun1digit = 5 GROUP BY kode_akun ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

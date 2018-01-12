-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `akuntansi_anggaran`;
CREATE TABLE `akuntansi_anggaran` (
  `id_anggaran` int(11) NOT NULL AUTO_INCREMENT,
  `akun` char(12) NOT NULL,
  `kode_unit` char(6) NOT NULL,
  `anggaran` bigint(20) NOT NULL,
  `tahun` char(4) NOT NULL,
  `jenis_pembatasan_dana` varchar(50) NOT NULL,
  PRIMARY KEY (`id_anggaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2018-01-12 07:23:43

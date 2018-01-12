-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `setting_akuntansi`;
CREATE TABLE `setting_akuntansi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nilai` varchar(100) NOT NULL,
  `flag` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `setting_akuntansi` (`id`, `nama`, `nilai`, `flag`) VALUES
(1,	'TAHUN',	'2017',	1),
(2,	'TAHUN',	'2018',	0);

-- 2018-01-12 02:17:23

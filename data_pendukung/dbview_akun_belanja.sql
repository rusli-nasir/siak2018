-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `akun_belanja` (`id_akun_belanja` int(11), `kode_akun1digit` char(12), `nama_akun1digit` varchar(255), `kode_akun2digit` char(12), `nama_akun2digit` varchar(255), `kode_akun3digit` char(12), `nama_akun3digit` varchar(255), `kode_akun4digit` char(12), `nama_akun4digit` varchar(255), `kode_akun5digit` char(12), `nama_akun5digit` varchar(255), `kode_akun` char(12), `nama_akun` varchar(255), `sumber_dana` enum('SELAIN-APBN','APBN-BPPTNBH','SPI-SILPA','APBN-LAINNYA'));


DROP TABLE IF EXISTS `akun_belanja`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `akun_belanja` AS select `rba_2018`.`akun_belanja`.`id_akun_belanja` AS `id_akun_belanja`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `kode_akun1digit`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama_akun1digit`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `kode_akun2digit`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama_akun2digit`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `kode_akun3digit`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama_akun3digit`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `kode_akun4digit`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama_akun4digit`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `kode_akun5digit`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama_akun5digit`,`rba_2018`.`akun_belanja`.`kode_akun` AS `kode_akun`,`rba_2018`.`akun_belanja`.`nama_akun` AS `nama_akun`,`rba_2018`.`akun_belanja`.`sumber_dana` AS `sumber_dana` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = '5');

-- 2018-03-13 02:04:38

/*1_hapus_akun_dan_user_lama.sql*/
SET foreign_key_checks = 0;
DROP TABLE `akuntansi_aset_1`, `akuntansi_aset_2`, `akuntansi_aset_3`, `akuntansi_aset_4`, `akuntansi_aset_6`, `akuntansi_aset_bersih_1`, `akuntansi_aset_bersih_2`, `akuntansi_aset_bersih_3`, `akuntansi_aset_bersih_4`, `akuntansi_aset_bersih_6`, `akuntansi_hutang_1`, `akuntansi_hutang_2`, `akuntansi_hutang_3`, `akuntansi_hutang_4`, `akuntansi_hutang_6`, `akuntansi_lra_1`, `akuntansi_lra_2`, `akuntansi_lra_3`, `akuntansi_lra_4`, `akuntansi_lra_6`, `akuntansi_pembiayaan_1`, `akuntansi_pembiayaan_2`, `akuntansi_pembiayaan_3`, `akuntansi_pembiayaan_4`, `akuntansi_pembiayaan_6`, `akuntansi_sal_1`, `akuntansi_sal_2`, `akuntansi_sal_3`, `akuntansi_sal_4`, `akuntansi_sal_6`, `akun_belanja`, `akuntansi_user`;

/*2_flag_proses_akuntansi.sql*/
ALTER TABLE `trx_spm_gup_data`
ADD `flag_proses_akuntansi` int(1) NULL DEFAULT '0';

ALTER TABLE `trx_spm_em_data`
ADD `flag_proses_akuntansi` int(1) NULL DEFAULT '0';

/*3_akuntansi_user.sql*/

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table rsa_2018.akuntansi_user
CREATE TABLE IF NOT EXISTS `akuntansi_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level` int(1) NOT NULL,
  `kode_unit` varchar(10) NOT NULL,
  `kode_user` varchar(50) NOT NULL,
  `aktif` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;

-- Dumping data for table rsa_2018.akuntansi_user: ~119 rows (approximately)
DELETE FROM `akuntansi_user`;
/*!40000 ALTER TABLE `akuntansi_user` DISABLE KEYS */;
INSERT INTO `akuntansi_user` (`id`, `username`, `password`, `level`, `kode_unit`, `kode_user`, `aktif`) VALUES
	(2, 'verifikator11', '299a07b3520b2b641eaa4707c6c32b9dd6c14b98', 2, '01', 'FHU-01', 1),
	(7, 'verifikator', '89419c696ec663c93d47106d1d77841dd23be4d5', 2, '', 'X1', 1),
	(18, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 9, '', '', 1),
	(19, 'operator_fhu', '10e254b832608834ff53a67c0f4d0632083275fb', 1, '01', 'FHU-02', 1),
	(20, 'verifikator_fhu', 'ed82669667613fd46f9c5bb3d238500aa22ecaeb', 2, '01', 'FHU-03', 1),
	(21, 'kasubbag_fhu', '5a782af29a508ad6b4a7557a202ba8df77237e40', 6, '01', 'FHU-04', 1),
	(22, 'operator_feb', 'fc99836a88a2f85b502bef88a33161343d954dae', 1, '02', 'FEB-01', 1),
	(23, 'verifikator_feb', '23332e8f453bd248e1dda5a0db32019ccd2880df', 2, '02', 'FEB-02', 1),
	(24, 'kasubbag_feb', '4b18451d59144e6504f8f7184df9158f1e64298d', 6, '02', 'FEB-03', 1),
	(25, 'operator_fte', '2d3ef78506c66f43d371e70d8439ca1889936db7', 1, '03', 'FTE-01', 1),
	(26, 'verifikator_fte', '7023c11a4f1a9a5cb350b38c141309f8386bb5c0', 2, '03', 'FTE-02', 1),
	(27, 'kasubbag_fte', '96c1cc2b16041d4677032b45628206b28baa8668', 6, '03', 'FTE-03', 1),
	(28, 'operator_fke', '42a5b5fdc252842f633cd86cb93a449796fa6037', 1, '04', 'FKE-01', 1),
	(29, 'verifikator_fke', 'e50ea02acd30bc078e44a3c6549c7ed59035896c', 2, '04', 'FKE-02', 1),
	(30, 'kasubbag_fke', 'fd1e088b0d5b72a4538773eeb31dee13eca76ac5', 6, '04', 'FKE-03', 1),
	(31, 'operator_fpp', 'c213155886fb010d9a5ededcaa86f8c38985a0e4', 1, '05', 'FPP-01', 1),
	(32, 'verifikator_fpp', '9b7624a7819822f495b53f5a50dcbb039a7b2027', 2, '05', 'FPP-02', 1),
	(33, 'kasubbag_fpp', 'cd36bb4311d639816bf3ee55e3b106e09b258493', 6, '05', 'FPP-03', 1),
	(34, 'operator_fib', 'd9ac7b2d89c3303eefebe30303640920d0e8d213', 1, '06', 'FIB-01', 1),
	(35, 'verifikator_fib', 'bd06b508fae72b3a34fd4d4a65e24143aeecfc1f', 2, '06', 'FIB-02', 1),
	(36, 'kasubbag_fib', 'fea0cd3f116588c7eb237f2530066e8356a9918c', 6, '06', 'FIB-03', 1),
	(37, 'operator_fis', '0d8268560ae2463d71378bc2e54a9d2fa8dd132c', 1, '07', 'FIS-01', 1),
	(38, 'verifikator_fis', '455aa276aaf9c6a2e359ffd7b3642e548cdea2af', 2, '07', 'FIS-02', 1),
	(39, 'kasubbag_fis', 'bda65916266f3260c02b2bba0447fefe59eec586', 6, '07', 'FIS-03', 1),
	(40, 'operator_fsm', '81ce21be9162792a41ce48ce5d61c018b31086b0', 1, '08', 'FSM-01', 1),
	(41, 'verifikator_fsm', 'b3aac090131fbecc2bba958a9acc80e2274f6eb4', 2, '08', 'FSM-02', 1),
	(42, 'kasubbag_fsm', 'c7a29e0e014b84b67dc2c89e86744cc06399fccf', 6, '08', 'FSM-03', 1),
	(43, 'operator_fkm', 'e62cf2733a1b66f7d5176643c1154cc9d64e4b82', 1, '09', 'FKM-01', 1),
	(44, 'verifikator_fkm', '7486a2dd4517c232d9e0d024a8b70970c2e02516', 2, '09', 'FKM-02', 1),
	(45, 'kasubbag_fkm', '03c44779ffc5dfdf5287f81c5657468d868a70f3', 6, '09', 'FKM-03', 1),
	(46, 'operator_fpk', '4d0795b3d2ed82865afcc9628b56c0e9e0df15f0', 1, '10', 'FPK-01', 1),
	(47, 'verifikator_fpk', 'a2b6e6d185fdb5b7ec6ea3ee62a9c4c70d9b59ad', 2, '10', 'FPK-02', 1),
	(48, 'kasubbag_fpk', '349b04af678555e954f0608e93e194e77360cbcb', 6, '10', 'FPK-03', 1),
	(49, 'operator_fps', '43eec0021bf325cce6499946c57199e42408e76f', 1, '11', 'FPS-01', 1),
	(50, 'verifikator_fps', 'e0c7b0db1271f07a3deae060850186032f5ba59f', 2, '11', 'FPS-02', 1),
	(51, 'kasubbag_fps', '3de0348c3342f37ef76d254dd3be05b29f64507b', 6, '11', 'FPS-03', 1),
	(52, 'operator_sps', '3db867e3a34a7c5de901d427ae141064e37bfbbe', 1, '12', 'SPS-01', 1),
	(53, 'verifikator_sps', 'a0c96554e4a681a29f764741a73e1f591a714f7b', 2, '12', 'SPS-02', 1),
	(54, 'kasubbag_sps', 'cf0cf9d628b725e8ceac3f169ed49610b9a66be7', 6, '12', 'SPS-03', 1),
	(55, 'operator_svo', '45800fa89867a28c5c7295c17d36a0ea00e443e0', 1, '13', 'SVO-01', 1),
	(56, 'verifikator_svo', '99ad8d5aa1a421d4effa896abef5e1ca0e857dd5', 2, '13', 'SVO-02', 1),
	(57, 'kasubbag_svo', '58cdcd02cca31778bb8f6338f876ebeac6be308a', 6, '13', 'SVO-03', 1),
	(58, 'operator_wr1', '4f296e1ccb42aad8a2e639063d66a22e87c975b2', 1, '14', 'WR1-01', 1),
	(59, 'verifikator_wr1', '889ae608623dfd89c4410bcaa05daedf9fd95eb4', 2, '14', 'WR1-02', 1),
	(60, 'kasubbag_wr1', 'f2ae8c82f1beca96bcaf1ffaf343209978205e80', 6, '14', 'WR1-03', 1),
	(61, 'operator_wr2', '1046db9d30eb8727316a2c9c0145d8e5e225ea40', 1, '15', 'WR2-01', 1),
	(62, 'verifikator_wr2', 'c74f3c23848c80323406b32f1abfdd9bc5f69c75', 2, '15', 'WR2-02', 1),
	(63, 'kasubbag_wr2', 'a411b1c8ea75b30ee0576ed3de779c87c1b8e7ef', 6, '15', 'WR2-03', 1),
	(64, 'operator_wr3', 'ddff87a6a90ae33d7ecd6c2e7949a76215453e5e', 1, '16', 'WR3-01', 1),
	(65, 'verifikator_wr3', '19c2fdde660111289850343a052943e24228ab55', 2, '16', 'WR3-02', 1),
	(66, 'kasubbag_wr3', 'c06cd62b81f1f4dda35a11c0cad1a8f78151254c', 6, '16', 'WR3-03', 1),
	(67, 'operator_wr4', 'ec31bafd5dac05682ebae7921e53f6796353b7d8', 1, '17', 'WR4-01', 1),
	(68, 'verifikator_wr4', '0e08766ec221c5456fff349860d521c8205f8f43', 2, '17', 'WR4-02', 1),
	(69, 'kasubbag_wr4', 'b0973b29d2708dce80a08ca9a12eab666b1e612e', 6, '17', 'WR4-03', 1),
	(70, 'operator_rsn', 'fbf511962ce1586cbeb8f4b4ab966117f88f8b4d', 1, '18', 'RSN-01', 1),
	(71, 'verifikator_rsn', '9c10270e4fd0ffc139bcf0d4a7f48e06ff95727e', 2, '18', 'RSN-02', 1),
	(72, 'kasubbag_rsn', '66ded713032879bf4d601436e7271015ce809bfa', 6, '18', 'RSN-03', 1),
	(73, 'operator_bps', '02071623b4ab8afec94ca01b9ef759f0c958d248', 1, '24', 'BPS-01', 1),
	(74, 'verifikator_bps', 'f7a95a9b2fa051646fb3b5ff42d68d568288695b', 2, '24', 'BPS-02', 1),
	(75, 'kasubbag_bps', '71560cac9faf5f7227697114c920ecdf6956624e', 6, '24', 'BPS-03', 1),
	(76, 'operator_bks', '5c7a4c7c09eaf17e75da3a7ac5ca478ce8222613', 1, '23', 'BKS-01', 1),
	(77, 'verifikator_bks', 'b3eea2596518f9a76e9067c40a8441a350f54e9f', 2, '23', 'BKS-02', 1),
	(78, 'kasubbag_bks', 'd2ededf49531694335cc8a149bf48a4d9c88d3ae', 6, '23', 'BKS-03', 1),
	(79, 'operator_lpm', '2f5194b80c19b19ec259e0c5745eaf3ae66549a7', 1, '19', 'LPM-01', 1),
	(80, 'verifikator_lpm', '2123a49d5b652c01d7c372301329347d8a527809', 2, '19', 'LPM-02', 1),
	(81, 'kasubbag_lpm', '98a91cd9c1292c6838ed1aca44456769843f11db', 6, '19', 'LPM-03', 1),
	(82, 'operator_lmp', '2731ea1be21a724b039aee83f031449f961db709', 1, '20', 'LMP-01', 1),
	(83, 'verifikator_lmp', 'b562b96d964a33716ad2c9f307dcf59755bfe05f', 2, '20', 'LMP-02', 1),
	(84, 'kasubbag_lmp', '08d2adb7a825707c713432ee7e8ed10ca733d907', 6, '20', 'LMP-03', 1),
	(85, 'operator_mwa', '598aa48596196e95c90c1185e7626457a53b0eab', 1, '21', 'MWA-01', 1),
	(86, 'verifikator_mwa', '42d1feb57fac64b42d83358ed48305789192ca94', 2, '21', 'MWA-02', 1),
	(87, 'kasubbag_mwa', '6514ef693f746837ea77da6fd97f6097ef72d95e', 6, '21', 'MWA-03', 1),
	(88, 'operator_spi', '07fd961b70fbdd208e51f7bc06a7fc9e8116e832', 1, '22', 'SPI-01', 1),
	(89, 'verifikator_spi', '2be6eacb3fdaea4cbd6b74367a8b873dfaab74a5', 2, '22', 'SPI-02', 1),
	(90, 'kasubbag_spi', '92559586c96bd2c836c82917cc8ebb68f578396c', 6, '22', 'SPI-03', 1),
	(91, 'operator_ptn', '58219b2d65c6aa79187ae256f63bd72fe7df37b7', 1, '25', 'PTN-01', 1),
	(92, 'verifikator_ptn', '2f05cc7f10af128c33ab2a1ddd5ffab0e7c99563', 2, '25', 'PTN-02', 1),
	(93, 'kasubbag_ptn', '3fd51b7b2b4c2effba124b389f6463c343c56948', 6, '25', 'PTN-03', 1),
	(94, 'operator_rmg', 'ab5973e476837706c780b098d162234c982e6892', 5, '92', 'RMG-01', 1),
	(95, 'verifikator_rmg', '555ad9703b0a07bfe2178395d7764dab71d6b4ce', 2, '92', 'RMG-02', 1),
	(96, 'kasubbag_rmg', '8bb75cb93f431e1c53a331c1c1edfbe88ebce561', 6, '92', 'RMG-03', 1),
	(97, 'wd_fhu', '2220c4ebabd954c3a7816fc37bd81c142ef75f46', 6, '01', 'FHU-05', 1),
	(98, 'wd_feb', '1f83ea1edc4d63e16690f1bb828d53e81587c10b', 6, '02', 'FEB-04', 1),
	(99, 'wd_fte', '6efe99881fab54723c96d89c7b1fc9b66e4a4bb6', 6, '03', 'FTE-04', 1),
	(100, 'wd_fke', 'a5795409191c52f568a82a00af395b3f3f6a9ad3', 6, '04', 'FKE-04', 1),
	(101, 'wd_fpp', '9499f649a386e83de374584d1706fd0b4dc34cb3', 6, '05', 'FPP-04', 1),
	(102, 'wd_fib', '933c4b6ead5a6c61bb4d058401329af3488f6d0d', 6, '06', 'FIB-04', 1),
	(103, 'wd_fis', '58f57ceed9d5834e89059b3f5f105235ad07b881', 6, '07', 'FIS-04', 1),
	(104, 'wd_fsm', '6b62df591a8e78d710feb01da4ac77b68eacc42d', 6, '08', 'FSM-04', 1),
	(105, 'wd_fkm', 'ca26284cab0456b0456f42bea0a1f9f9ecdb65a6', 6, '09', 'FKM-04', 1),
	(106, 'wd_fpk', 'a1a5733b0fe4e7239e4212634b69bd94111109fa', 6, '10', 'FPK-04', 1),
	(107, 'wd_fps', 'f22d8be53951d7206774db0abd4275c860067857', 6, '11', 'FPS-04', 1),
	(108, 'wd_sps', '93a5fa9d64f4b0f44c640e43a49e94dd8b564033', 6, '12', 'SPS-04', 1),
	(109, 'wd_svo', '6221f1578b7f3f64fb02ffe9e9cc0d1ec346c95f', 6, '13', 'SVO-04', 1),
	(110, 'wd_wr1', 'c2495b0a3b22a0530d4a238c71f04cb73088d19f', 6, '14', 'WR1-04', 1),
	(111, 'wd_wr2', 'e27ae4e514d79e5e933d23a5b8da52041b5fdc00', 6, '15', 'WR2-04', 1),
	(112, 'wd_wr3', 'a9dbbd3d6cd69e0b1f1c25a054892d7139891538', 6, '16', 'WR3-04', 1),
	(113, 'wd_wr4', 'c595370b9c283cfbf3bf846dd4c7b7d78f94f3a5', 6, '17', 'WR4-04', 1),
	(114, 'wd_rsn', 'ec1653e23578ea079e4f37a0df5ad144587c07eb', 6, '18', 'RSN-04', 1),
	(115, 'wd_bps', '496e4a152dc41472782a5f2462b79f729a571289', 6, '23', 'BPS-04', 1),
	(116, 'wd_bks', '36ad558644e2aaf495811b3647acf0ec0aab2128', 6, '24', 'BKS-04', 1),
	(117, 'wd_lpm', 'db8c14d1a396e6ea2f1369d50db8e554a58be938', 6, '19', 'LPM-04', 1),
	(118, 'wd_lmp', '8419b108497365a9b0d3bce5468b67a1d597408f', 6, '20', 'LMP-04', 1),
	(119, 'wd_mwa', '8a53777b4bc1c6f2a8faa9cbc0ad6c6fcf0391ce', 6, '21', 'MWA-04', 1),
	(120, 'wd_spi', 'b36d9a7446c91635bdec23bc6611878e3569953a', 6, '22', 'SPI-04', 1),
	(121, 'wd_ptn', 'e543cca8b087ec099e5e3c6b176ec55b57ab7049', 6, '25', 'PTN-04', 1),
	(122, 'wd_rmg', '03e2ea65a06143ff35d3cea196c1dc920fd9fa84', 6, '92', 'RMG-04', 1),
	(123, 'rektor_undip', '6913141af463685300500edfdd05076075d61ac3', 4, '', '', 1),
	(124, 'kabag_akuntansi', '6a0919b775fad23e320f83e9199ab0a3fe2b6f7d', 4, '', '', 1),
	(125, 'kasubag_akuntansi', 'a019707b92fef9280aa6fa79c4b55acdb4867e94', 4, '', '', 1),
	(126, 'wr2_undip', 'wr2_undip', 4, '', '', 1),
	(127, 'audit_undip', '8ef8989d6c6aa39826e8dbd8ffb99b8b5581c892', 7, '', '', 1),
	(128, 'rm', '5cd7e29c88170aa3f16281e0dbf5772c137f6d8d', 5, '15', 'RM', 1),
	(129, 'lk_undip', '32b02120b86798edd848de6957fd962c931c5562', 3, '', '', 1),
	(130, 'penerimaan', '9cd64c607065706ddd24fa278c12b00696109ab4', 8, '9999', '', 1),
	(131, 'operator_spb', 'b1122344dcf70d4991633d63f6292ee7ba284651', 1, '63', 'SPB-01', 1),
	(132, 'verifikator_spb', 'cb99924cb9dce5860d1c3154925f943e27b8dff2', 2, '63', 'SPB-02', 1),
	(133, 'kasubbag_spb', 'b1e48f356a2811dac38919a55ae3832a080868e9', 1, '63', 'SPB-03', 1),
	(134, 'auditor', 'fb2d634f1868a1353228c05cf0bd1273c612f10e', 10, '', '', 1);
/*!40000 ALTER TABLE `akuntansi_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*4_akuntansi_relasi_unit.sql*/
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

/*5_kelengkapan_akun.sql*/
-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


CREATE VIEW akuntansi_aset_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_aset_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1;
CREATE VIEW akuntansi_aset_2 AS SELECT DISTINCT kode_akun2digit as id_aset_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_3 AS SELECT DISTINCT kode_akun3digit as id_aset_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_4 AS SELECT DISTINCT kode_akun4digit as id_aset_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_5 AS SELECT DISTINCT kode_akun5digit as id_aset_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_6 AS SELECT DISTINCT kode_akun as id_aset_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 1 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_hutang_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2;
CREATE VIEW akuntansi_hutang_2 AS SELECT DISTINCT kode_akun2digit as id_hutang_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_3 AS SELECT DISTINCT kode_akun3digit as id_hutang_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_4 AS SELECT DISTINCT kode_akun4digit as id_hutang_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_5 AS SELECT DISTINCT kode_akun5digit as id_hutang_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_hutang_6 AS SELECT DISTINCT kode_akun as id_hutang_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 2 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_aset_bersih_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3;
CREATE VIEW akuntansi_aset_bersih_2 AS SELECT DISTINCT kode_akun2digit as id_aset_bersih_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_3 AS SELECT DISTINCT kode_akun3digit as id_aset_bersih_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_4 AS SELECT DISTINCT kode_akun4digit as id_aset_bersih_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_5 AS SELECT DISTINCT kode_akun5digit as id_aset_bersih_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_aset_bersih_6 AS SELECT DISTINCT kode_akun as id_aset_bersih_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 3 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_lra_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4;
CREATE VIEW akuntansi_lra_2 AS SELECT DISTINCT kode_akun2digit as id_lra_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_3 AS SELECT DISTINCT kode_akun3digit as id_lra_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_4 AS SELECT DISTINCT kode_akun4digit as id_lra_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_5 AS SELECT DISTINCT kode_akun5digit as id_lra_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_lra_6 AS SELECT DISTINCT kode_akun as id_lra_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 4 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_pembiayaan_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8;
CREATE VIEW akuntansi_pembiayaan_2 AS SELECT DISTINCT kode_akun2digit as id_pembiayaan_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_3 AS SELECT DISTINCT kode_akun3digit as id_pembiayaan_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_4 AS SELECT DISTINCT kode_akun4digit as id_pembiayaan_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_5 AS SELECT DISTINCT kode_akun5digit as id_pembiayaan_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_pembiayaan_6 AS SELECT DISTINCT kode_akun as id_pembiayaan_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 8 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_1 AS SELECT DISTINCT kode_akun1digit as id_akuntansi_sal_1, kode_akun1digit as akun_1, nama_akun1digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9;
CREATE VIEW akuntansi_sal_2 AS SELECT DISTINCT kode_akun2digit as id_sal_aset_2, kode_akun1digit as akun_1, kode_akun2digit as akun_2, nama_akun2digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_3 AS SELECT DISTINCT kode_akun3digit as id_sal_3, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, nama_akun3digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_4 AS SELECT DISTINCT kode_akun4digit as id_sal_4, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, nama_akun4digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_5 AS SELECT DISTINCT kode_akun5digit as id_sal_5, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, nama_akun5digit as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;
CREATE VIEW akuntansi_sal_6 AS SELECT DISTINCT kode_akun as id_sal_6, kode_akun1digit as akun_1, kode_akun2digit as akun_2, kode_akun3digit as akun_3, kode_akun4digit as akun_4, kode_akun5digit as akun_5, kode_akun as akun_6, nama_akun as nama FROM rba_2018.akun_belanja WHERE kode_akun1digit = 9 ORDER BY akun_1;

DROP TABLE IF EXISTS `akun_belanja`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `akun_belanja` AS select `rba_2018`.`akun_belanja`.`id_akun_belanja` AS `id_akun_belanja`,`rba_2018`.`akun_belanja`.`kode_akun1digit` AS `kode_akun1digit`,`rba_2018`.`akun_belanja`.`nama_akun1digit` AS `nama_akun1digit`,`rba_2018`.`akun_belanja`.`kode_akun2digit` AS `kode_akun2digit`,`rba_2018`.`akun_belanja`.`nama_akun2digit` AS `nama_akun2digit`,`rba_2018`.`akun_belanja`.`kode_akun3digit` AS `kode_akun3digit`,`rba_2018`.`akun_belanja`.`nama_akun3digit` AS `nama_akun3digit`,`rba_2018`.`akun_belanja`.`kode_akun4digit` AS `kode_akun4digit`,`rba_2018`.`akun_belanja`.`nama_akun4digit` AS `nama_akun4digit`,`rba_2018`.`akun_belanja`.`kode_akun5digit` AS `kode_akun5digit`,`rba_2018`.`akun_belanja`.`nama_akun5digit` AS `nama_akun5digit`,`rba_2018`.`akun_belanja`.`kode_akun` AS `kode_akun`,`rba_2018`.`akun_belanja`.`nama_akun` AS `nama_akun`,`rba_2018`.`akun_belanja`.`sumber_dana` AS `sumber_dana` from `rba_2018`.`akun_belanja` where (`rba_2018`.`akun_belanja`.`kode_akun1digit` = 5) group by `rba_2018`.`akun_belanja`.`kode_akun`;

-- 2018-05-03 08:40:00

/*6_kelengkapan_menu.sql*/
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

-- Dumping structure for table rsa_2018.akuntansi_jenis_user
CREATE TABLE IF NOT EXISTS `akuntansi_jenis_user` (
  `id_jenis_user` int(11) NOT NULL AUTO_INCREMENT,
  `level_user` int(11) NOT NULL DEFAULT '0',
  `nama_jenis` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jenis_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table rsa_2018.akuntansi_jenis_user: ~10 rows (approximately)
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

-- Dumping structure for table rsa_2018.akuntansi_menu
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

-- Dumping data for table rsa_2018.akuntansi_menu: ~27 rows (approximately)
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

-- Dumping structure for table rsa_2018.akuntansi_menu_by_level
CREATE TABLE IF NOT EXISTS `akuntansi_menu_by_level` (
  `id_menu` int(11) DEFAULT NULL,
  `level_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rsa_2018.akuntansi_menu_by_level: ~40 rows (approximately)
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




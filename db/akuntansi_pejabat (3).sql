-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2017 at 11:07 PM
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
-- Table structure for table `akuntansi_pejabat`
--

CREATE TABLE `akuntansi_pejabat` (
  `id_pejabat` int(11) NOT NULL,
  `jabatan` varchar(60) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(40) NOT NULL,
  `scan_ttd` text,
  `unit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akuntansi_pejabat`
--

INSERT INTO `akuntansi_pejabat` (`id_pejabat`, `jabatan`, `nama`, `nip`, `scan_ttd`, `unit`) VALUES
(2, 'ppk', 'Andhi Susetyo, S.T.\n', '196906252007011001', NULL, '11'),
(3, 'ppk', 'Mia Prameswari, SE., M.Si\n', '197901142006042001', NULL, '12'),
(4, 'ppk', 'Fajar Purwanto, S.A.P.\n', '197301211995121001', NULL, '13'),
(5, 'ppk', 'Achmad Saefuddin, S.IP\n', '196907061993031001', NULL, '14'),
(6, 'ppk', 'Darwanto, S.H.\n', '196809271991031001', NULL, '15'),
(7, 'ppk', 'Zuhairina, S.E., M.M.\n', '196808241992032001', NULL, '16'),
(8, 'ppk', 'Ja''far Latif, S.Ag., M.Si.\n', '197510182008101001', NULL, '17'),
(9, 'ppk', 'Titik Eryanti, S.E.\n', '196707301992032001', NULL, '18'),
(10, 'ppk', 'Maricha Fitriantini, SE.\n', '197809032006042002', NULL, '19'),
(11, 'ppk', 'A. Ronin Hidayatullah, S.KM\n', '197704072009101002', NULL, '20'),
(12, 'ppk', 'Simon Puji Jatmiko, SH\n', '196406261985031003', NULL, '21'),
(13, 'ppk', 'Djoko Nugroho, S.H.\n', '196809272001121002', NULL, '31'),
(14, 'ppk', 'Clara Yully Diana Ekaristi, S.E., M.Acc.\n', '198107282005012003', NULL, '32'),
(15, 'ppk', 'Lilik Maryuni, S.E., M.Si.\n', '197808042001122001', NULL, '41'),
(16, 'ppk', 'Edy Surahmad, S.Pd., M.Si.\n', '196903121994031002', NULL, '42'),
(17, 'ppk', 'Lulut Handayani, SE.\n', '198305012005012001', NULL, '51'),
(18, 'ppk', 'Muhammad Muntafi’. S.Sos\n', '197007172007011002', NULL, '42'),
(19, 'ppk', 'Muhammad Muntafi’. S.Sos\n', '197007172007011002', NULL, '44'),
(20, 'ppk', 'Muhammad Muntafi’. S.Sos\n', '197007172007011002', NULL, '82'),
(21, 'ppk', 'Muhammad Muntafi’. S.Sos\n', '197007172007011002', NULL, '62'),
(22, 'ppk', 'Apip, SE\n', '197811162001121001', NULL, '41'),
(23, 'ppk', 'Apip, SE\n', '197811162001121001', NULL, '43'),
(24, 'ppk', 'Apip, SE\n', '197811162001121001', NULL, '61'),
(25, 'ppk', 'Apip, SE\n', '197811162001121001', NULL, '91'),
(26, 'ppk', 'Apip, SE\n', '197811162001121001', NULL, '81'),
(27, 'operator', 'Inda Hayuningtyas', '''H.7.1976050609082001', NULL, '11'),
(28, 'operator', 'Suryani', '''H.7.1986012409082011', NULL, '12'),
(29, 'operator', 'Sari Widyastuti, S.T.', '198401110214012081', NULL, '13'),
(30, 'operator', 'Yusmida', '''H.7.1981121709082005', NULL, '14'),
(31, 'operator', 'Domas Titis Anggit', '''H.7.1988060609082021', NULL, '15'),
(32, 'operator', 'Maharani Wulan Sari, S.E.', '198607150214062527', NULL, '16'),
(33, 'operator', 'Murni Julianti, S.E.', '199207180214062528', NULL, '17'),
(34, 'operator', 'Choiriyah, SE', '198508112010122002', NULL, '18'),
(35, 'operator', 'Syaidatina Zahroh, S.E.', '199209140216012025', NULL, '19'),
(36, 'operator', 'Novita Anugrah Listiyana', '''H.7.1987112609082017', NULL, '20'),
(37, 'operator', 'Resti Fitria Dewi', '''H.7.1988052309082020', NULL, '21'),
(38, 'operator', 'Feb Arylla Endra Devi', '''H.7.1978021709082002', NULL, '31'),
(39, 'operator', 'Nova Rosyada', '''H.7.1988111009082025', NULL, '32'),
(40, 'operator', 'Idha Rosalina', '''H.7.1985082610062038', NULL, '71'),
(41, 'operator', 'Sri Agung Wibowo', '''H.7.1984050410061031', NULL, '72'),
(42, 'operator', '-', '', NULL, '51'),
(43, 'operator', '-', '', NULL, '42'),
(44, 'operator', '-', '', NULL, '44'),
(45, 'operator', '-', '', NULL, '82'),
(46, 'operator', '-', '', NULL, '62'),
(47, 'operator', '-', '', NULL, '41'),
(48, 'operator', '-', '', NULL, '43'),
(49, 'operator', '-', '', NULL, '61'),
(50, 'operator', '-', '', NULL, '91'),
(51, 'operator', '-', '', NULL, '81'),
(52, 'kpa', 'Prof. Dr. R. Benny Riyanto, S.H.,M.Hum.,CN\n', '196204101987031003', NULL, '11'),
(53, 'kpa', 'Dr. Suharnomo, S.E., M.Si.\n', '197007221998021002', NULL, '12'),
(54, 'kpa', 'Ir. M. Agung Wibowo, MM, M.Sc, Ph.D\n', '196702081994031005', NULL, '13'),
(55, 'kpa', 'Prof.    Dr.    dr.    Tri    Nur\nKristina, DMM, M.Kes\n', '195905271986032001', NULL, '14'),
(56, 'kpa', 'Prof. Dr. Ir. Mukh Arifin, M.Sc.\n', '196107261987031003', NULL, '15'),
(57, 'kpa', 'Dr. Redyanto Noor, M.Hum\n', '195903071986031002', NULL, '16'),
(58, 'kpa', 'Dr. Sunarto, M.Si\n', '196607271992031001', NULL, '17'),
(59, 'kpa', 'Prof.  Dr.  Widowati  ,  S.Si.,\nM.Si\n', '196902141994032002', NULL, '18'),
(60, 'kpa', 'Hanifa Maher Denny, SKM, MPH, Ph.D\n', '196901021994032001', NULL, '19'),
(61, 'kpa', 'Prof. Dr. Ir. Agus Sabdono,\nM.Sc.\n', '195806151985031001', NULL, '20'),
(62, 'kpa', 'Dr.       Hastaning       Sakti,\nM.Kes.,Psikolog\n', '196007011991032001', NULL, '21'),
(63, 'kpa', 'Prof. Dr. Ir. Purwanto, DEA\n', '196112281986031004', NULL, '31'),
(64, 'kpa', 'Prof. Dr. Ir. Budiyono, M.Si\n', '196602201991021001', NULL, '32'),
(65, 'kpa', 'Prof.   Dr.   rer.   Nat.   Heru\nSusanto, S.T., M.M., M.T.\n', '197505291998021001', NULL, '71'),
(66, 'kpa', 'Prof.     Ir.     Edy     Rianto,\nM.Sc.,Ph.D\n', '195909141983121001', NULL, '72'),
(67, 'kpa', 'Prof. Dr. Dr. Susilo Wibowo,\nM.S., Med, Sp. And\n', '195403211980031002', NULL, '51'),
(68, 'kpa', 'Prof.   Dr.   Ir.   Muhammad\nZainuri, DEA\n', '196207131987031003', NULL, '41'),
(69, 'kpa', 'Purwati, SH.\n', '195705241978022001', NULL, '42'),
(70, 'kpa', 'Budi     Setiyono,     S.Sos., M.Pol.Admin., Ph.D\n', '197110111997021001', NULL, '43'),
(71, 'kpa', 'Prof.  Dr.  Ir.  Ambariyanto,\nM.Sc.\n', '196104131988031002', NULL, '44'),
(72, 'kpa', 'Dr.  Wisnu  Mawardi,  S.E.,\nM.M.\n', '196507171999031008', NULL, '62'),
(73, 'kpa', 'Prof.   Dr.   rer.   Nat.   Heru\nSusanto, S.T., M.M., M.T.\n', '197505291998021001', NULL, '61');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akuntansi_pejabat`
--
ALTER TABLE `akuntansi_pejabat`
  ADD PRIMARY KEY (`id_pejabat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akuntansi_pejabat`
--
ALTER TABLE `akuntansi_pejabat`
  MODIFY `id_pejabat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 11:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sertifikasi_hakim`
--

-- --------------------------------------------------------

--
-- Table structure for table `hakim_perikanan`
--

CREATE TABLE `hakim_perikanan` (
  `id` int(11) NOT NULL,
  `nama_hakim` varchar(255) NOT NULL,
  `id_pengadilan` int(11) NOT NULL,
  `status_perpanjangan` varchar(255) DEFAULT NULL,
  `tanggal_habis` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hakim_perikanan`
--

INSERT INTO `hakim_perikanan` (`id`, `nama_hakim`, `id_pengadilan`, `status_perpanjangan`, `tanggal_habis`) VALUES
(1, 'Hendra Adi Pramono, S.H., M.H.', 3, 'PERPANJANGAN 2X NOV 2024 HABIS 2029', '2029-11-30'),
(2, 'Warsita, S.H.', 3, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(3, 'Ir. Arnofi', 3, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(4, 'Sugeng Widodo, S.H.', 4, 'PERPANJANGAN 2X NOV 2024 HABIS 2029', '2029-11-30'),
(5, 'Ir Robert Napitupulu, S.H., MSc.', 4, 'PERPANJANGAN 2X NOV 2024 HABIS 2029', '2029-11-30'),
(6, 'Soniady Drajat Sadarisman, S.H., M.H.', 4, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(7, 'Ir. Raja Pasaribu, M.Sc.', 4, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(8, 'Syaiful Anam, S.H., M.H.', 4, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(9, 'Sigit Wibowo, S.Pi., M.Pi', 9, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(10, 'Handono, S.H.', 9, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(11, 'R.M. Pamam Nugroho T.J.W., S.Pi., S.H.', 9, 'PERPANJANGAN 2X NOV 2024 HABIS 2029', '2029-11-30'),
(12, 'Guntur Kurniawan, S.H.', 9, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(13, 'Emelda, S.H.', 9, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(14, 'Mulyono, S.H., M.H.', 9, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(15, 'Anwar, S.H., M.H.', 9, 'PERPANJANGAN 2X NOV 2024 HABIS 2029', '2029-11-30'),
(16, 'Gatot Amrioko, S.H.', 7, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(17, 'Dr. Nurhayati, S.Pi, S.H., M.Si.', 7, 'PERPANJANGAN 2X NOV 2024 HABIS 2029', '2029-11-30'),
(18, 'Nanang Dwi Sristanto, S.H.', 7, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(19, 'M. Arif Budiarto, S.Pi., S.H., M.H.', 7, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(20, 'Nobson, S.H., M.H.', 7, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(21, 'Ir. Isnaini, S.H., M.H.', 6, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(22, 'Dominggusmanto, S.H.', 6, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(23, 'Bambang Trivibiyono, S.H.', 6, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(24, 'Abdurrahman, S.H., M.H.', 6, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(25, 'Dr. Oslan H, S.H., M.H.', 6, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(26, 'Dr. Slamet Suripto, S.H., M.Hum.', 2, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(27, 'Lendriaty Janis, S.H., M.H.', 2, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(28, 'Muhammad Ramli, S.H., M.H.', 2, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(29, 'Agus Purwanto, S.H., M.Hum.', 2, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(30, 'Suwardi, S.H., M.H.', 10, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(31, 'Aminuddin, S.H., M.H.', 10, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(32, 'Relly D. H. Behuku, S.H.', 10, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(33, 'Abdul Azis, S.H., M.H.', 1, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(34, 'Gunawan, S.Pi., S.H.', 1, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(35, 'Johny Luther, S.H., M.Hum.', 1, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(36, 'Rusdi, S.H.', 8, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(37, 'Agus Hariadi, S.H., M.H.', 8, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(38, 'Achmad Fauzi, S.H., M.H.', 8, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(39, 'Marianus, S.H.', 5, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31'),
(40, 'Dr. Achmad Hananto, S.H., M.H.', 5, 'PERPANJANGAN 2X AGST 2027 HABIS 2032', '2032-08-31'),
(41, 'Anthony Soediarto, S.H., M.Hum.', 5, 'PERPANJANGAN 2X DES 2025 HABIS 2030', '2030-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhan_perikanan`
--

CREATE TABLE `kebutuhan_perikanan` (
  `id` int(11) NOT NULL,
  `id_pengadilan` int(11) NOT NULL,
  `hk_ad_hoc` int(11) NOT NULL,
  `rata_rata` int(11) NOT NULL,
  `ideal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kebutuhan_perikanan`
--

INSERT INTO `kebutuhan_perikanan` (`id`, `id_pengadilan`, `hk_ad_hoc`, `rata_rata`, `ideal`) VALUES
(1, 3, 3, 5, 3),
(2, 4, 5, 11, 3),
(3, 9, 7, 33, 4),
(4, 7, 5, 20, 3),
(5, 6, 5, 18, 3),
(6, 2, 4, 17, 3),
(7, 10, 3, 1, 3),
(8, 1, 3, 1, 3),
(9, 8, 3, 2, 3),
(10, 5, 3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pengadilan`
--

CREATE TABLE `pengadilan` (
  `id` int(11) NOT NULL,
  `nama_pengadilan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengadilan`
--

INSERT INTO `pengadilan` (`id`, `nama_pengadilan`) VALUES
(1, 'PN Ambon'),
(2, 'PN Bitung'),
(3, 'PN Jakarta Utara'),
(4, 'PN Medan'),
(5, 'PN Merauke'),
(6, 'PN Pontianak'),
(7, 'PN Ranai'),
(8, 'PN Sorong'),
(9, 'PN Tanjung Pinang'),
(10, 'PN Tual');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hakim_perikanan`
--
ALTER TABLE `hakim_perikanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengadilan` (`id_pengadilan`);

--
-- Indexes for table `kebutuhan_perikanan`
--
ALTER TABLE `kebutuhan_perikanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pengadilan` (`id_pengadilan`);

--
-- Indexes for table `pengadilan`
--
ALTER TABLE `pengadilan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_pengadilan` (`nama_pengadilan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hakim_perikanan`
--
ALTER TABLE `hakim_perikanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kebutuhan_perikanan`
--
ALTER TABLE `kebutuhan_perikanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengadilan`
--
ALTER TABLE `pengadilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hakim_perikanan`
--
ALTER TABLE `hakim_perikanan`
  ADD CONSTRAINT `hakim_perikanan_ibfk_1` FOREIGN KEY (`id_pengadilan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kebutuhan_perikanan`
--
ALTER TABLE `kebutuhan_perikanan`
  ADD CONSTRAINT `kebutuhan_perikanan_ibfk_1` FOREIGN KEY (`id_pengadilan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

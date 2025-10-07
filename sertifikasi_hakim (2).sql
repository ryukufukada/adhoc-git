-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 09:18 AM
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
  `nik` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_pengadilan` int(11) NOT NULL,
  `asal_org` varchar(255) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `kepres` varchar(255) DEFAULT NULL,
  `tgl_kepres` date DEFAULT NULL,
  `sk_dirjen` varchar(255) DEFAULT NULL,
  `tgl_sk_dirjen` date DEFAULT NULL,
  `masa_jabatan` varchar(50) DEFAULT NULL,
  `status_perpanjangan` varchar(255) DEFAULT NULL,
  `tanggal_habis` date DEFAULT NULL,
  `tmt_pn` date DEFAULT NULL,
  `tmt_hk` date DEFAULT NULL,
  `sk_pengangkatan_2` varchar(255) DEFAULT NULL,
  `tgl_sk_pengangkatan_2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hakim_perikanan`
--

INSERT INTO `hakim_perikanan` (`id`, `nama_hakim`, `nik`, `foto`, `id_pengadilan`, `asal_org`, `jabatan`, `kepres`, `tgl_kepres`, `sk_dirjen`, `tgl_sk_dirjen`, `masa_jabatan`, `status_perpanjangan`, `tanggal_habis`, `tmt_pn`, `tmt_hk`, `sk_pengangkatan_2`, `tgl_sk_pengangkatan_2`) VALUES
(1, 'Hendra Adi Pramono, S.H., M.H.', '3578090810760004', 'sq.png', 3, 'PUSDIKPOMAL KODIKDUKUM KODIKLATAL', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(2, 'Warsita, S.H.', '3515082010720008', NULL, 3, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', NULL, '2022-11-11', NULL, NULL),
(3, 'Ir. Arnofi', '1371082911630002', NULL, 3, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(4, 'Sugeng Widodo, S.H.,.', '3515070202640005', NULL, 4, 'TNI AL', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(5, 'Ir Robert Napitupulu, S.H.,MSc,.', '1271172509620001', NULL, 4, 'DINAS KELAUTAN DAN PERIKANAN', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(6, 'Soniady Drajat Sadarisman, S.H., M.H.', '3273162705690002', NULL, 4, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(7, 'Ir. Raja Pasaribu, M.Sc.', '3275022202600015', NULL, 4, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(8, 'Syaiful Anam, S.H., M.H.', '3578183101760001', NULL, 4, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(9, 'Sigit Wibowo, S.Pi., M.Pi', '3313131809790001', NULL, 9, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(10, 'Handono, S.H.', '3578130101650008', NULL, 9, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(11, 'Addullah, APi, MMA.', '1271161211610003', NULL, 9, 'BALAI PELATIHAN DAN PENYULUHAN PERIKANAN MEDAN', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(12, 'Ir. Raymond RM Bako, MA., QIA', '3174070305630006', NULL, 9, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(13, 'Wedy Novizar, S.H.', '3515072411690004', NULL, 9, 'TNI AL', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(14, 'Joko Supraptomo, A.Pi., M.M.', '3302260510630004', NULL, 9, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(15, 'Devi Arnita, S.Pi.,M.Si.', '1871124109800003', NULL, 9, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(16, 'Dr. Halomoan Freddy Sitinjak Alexandra, S.H.,M.H.', '3175101312630005', NULL, 7, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(17, 'Sutriyadi, S.H., M.Si', '3578162705610002', NULL, 7, 'PUSDIKPOMAL KODIKDUKUM KODIKLATAL', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(18, 'Sirodjuddin, S.H., M.H.', '3578040206700007', NULL, 7, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(19, 'Suriadi, S.H.,M.H.', '1371040205780005', NULL, 7, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(20, 'Endro Basuki Prabowo, A.Pi.', '1871132109620005', NULL, 7, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(21, 'Nur Syamsu, S.T., M.Eng', '7602122908750001', NULL, 6, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(22, 'Dr Urif Syarifudin, APi, MTA.', '7310042812700001', NULL, 6, 'BALAI PENGELOLAAN SUMBERDAYA PESISIR DAN LAUT MAKASSAR', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(23, 'Edi Utomo, S.H., M.H.', '3578091704710001', NULL, 6, 'TNI AL', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(24, 'Ir. Gatot Rudiyono, S.H., M.M.', '6171010301580001', NULL, 6, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(25, 'Dr. Nova Yuniarti, S.Pi., M.P.', '7371136506750009', NULL, 6, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(26, 'Ir. Ruslan, M.M.', '1963121902202211007', NULL, 1, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(27, 'Sugeng Triono, S.H., M.H.', '3302270705780002', NULL, 2, 'TNI AL', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(28, 'Temmy Fetrozian, SSt,Pi, M.H.', '1806010803770003', NULL, 2, 'PNS DINAS PENDIDIKAN PERIKANAN KABUPATEN TANGGAMUS', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(29, 'Musdamin, S.Pi.', '7471060107770029', NULL, 2, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(30, 'Alex Tarugi Tobing, S.H., M.H.', '3275041004670019', NULL, 2, 'KEMRNTRIAN KELAUTAN DAN PERIKANAN', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(31, 'Nursyamsi Junus, S.T., M.Sc.', '7371105310730004', NULL, 1, NULL, 'AD HOC', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(32, 'Sitti Muslimah Bachrum, S.Pi., M.P.', '7371144506710008', NULL, 1, NULL, 'AD HOC', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(33, 'Ir. Armain Naim, S.H., MSi.', '8271021807680001', NULL, 10, 'DITJEN PSDKP AMBON', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(34, 'Saptoyo, S.E., M.Sc.', '6171020910690009', NULL, 10, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(35, 'Dr. Ir. Irawan Muripto, M.Sc.', '3175042509510002', NULL, 10, NULL, 'AD HOC', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(36, 'Awaluddin, S.Pi', '1977031902202211004', NULL, 8, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(37, 'Asriadi, S.Kel., M.Si.', '7371140105780006', NULL, 8, 'BALAI PENGELOLAAN SUMBERDAYA PESISIR DAN LAUT(BPSPL)', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(38, 'Hunter Hosen, S.Pi., M.Si.', '7373090702680001', NULL, 8, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(39, 'Aco Harsandi, S.H., M.H.', '7371081512770004', NULL, 5, NULL, 'AD HOC PERIKANAN', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11', '2022-11-11', '2022-11-11', NULL, NULL),
(40, 'Unggul Senoaji, S.H.', '3201130912661001', NULL, 5, 'STASIUN PENGAWASAN SUMBERDAYA KELAUTAN DAN PERIKANAN CILACAP', 'AD HOC PERIKANAN', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17', '2020-01-17', '2020-01-17', NULL, NULL),
(41, 'Anthony Soediarto, S.H., M.Hum.', '3404101012550004', NULL, 5, NULL, 'AD HOC PERIKANAN', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14', '2021-01-14', '2021-01-14', NULL, NULL),
(46, 'bobi', '98787758847', 'hakim_1759481486_68df8e8e67e1d.png', 2, '', 'AD HOC PERIKANAN', '', NULL, '', NULL, '', '', NULL, NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhan_perikanan`
--

CREATE TABLE `kebutuhan_perikanan` (
  `id` int(11) NOT NULL,
  `id_pengadilan` int(11) NOT NULL,
  `hk_ad_hoc` int(11) NOT NULL,
  `perkara_2022` int(11) NOT NULL DEFAULT 0,
  `perkara_2023` int(11) NOT NULL DEFAULT 0,
  `perkara_2024` int(11) NOT NULL DEFAULT 0,
  `rata_rata` int(11) NOT NULL,
  `ideal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kebutuhan_perikanan`
--

INSERT INTO `kebutuhan_perikanan` (`id`, `id_pengadilan`, `hk_ad_hoc`, `perkara_2022`, `perkara_2023`, `perkara_2024`, `rata_rata`, `ideal`) VALUES
(1, 1, 3, 0, 0, 0, 1, 3),
(2, 2, 4, 0, 0, 0, 17, 3),
(3, 3, 3, 5, 8, 2, 5, 3),
(4, 4, 5, 10, 15, 8, 11, 3),
(5, 5, 3, 0, 0, 0, 1, 3),
(6, 6, 5, 0, 0, 0, 18, 3),
(7, 7, 5, 0, 0, 0, 20, 3),
(8, 8, 3, 0, 0, 0, 2, 3),
(9, 9, 7, 30, 35, 34, 33, 4),
(10, 10, 3, 0, 0, 0, 1, 3);

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

-- --------------------------------------------------------

--
-- Table structure for table `usulan_pindah`
--

CREATE TABLE `usulan_pindah` (
  `id` int(11) NOT NULL,
  `id_hakim` int(11) NOT NULL,
  `id_pengadilan_asal` int(11) NOT NULL,
  `id_pengadilan_tujuan` int(11) DEFAULT NULL,
  `tujuan_usul_text` varchar(255) DEFAULT NULL,
  `tanggal_usul` date NOT NULL,
  `no_surat` varchar(255) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `nama_berkas` varchar(255) DEFAULT NULL,
  `status` enum('Diajukan','Disetujui','Ditolak') NOT NULL DEFAULT 'Diajukan',
  `keterangan_status` text DEFAULT NULL,
  `tanggal_diproses` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usulan_pindah`
--

INSERT INTO `usulan_pindah` (`id`, `id_hakim`, `id_pengadilan_asal`, `id_pengadilan_tujuan`, `tujuan_usul_text`, `tanggal_usul`, `no_surat`, `tanggal_surat`, `alasan`, `nama_berkas`, `status`, `keterangan_status`, `tanggal_diproses`) VALUES
(1, 30, 1, NULL, 'bekasi', '2025-10-03', '14045', '2025-10-03', 'sd', '68df552838fc1-SKPP_SIGNED (1).pdf', 'Ditolak', 'full', '2025-10-06 09:40:30'),
(2, 30, 1, 2, 'bekasi', '2025-10-03', '14045', '2025-10-03', 'tes', '68df7c33aa187-SKPP_SIGNED (1).pdf', 'Disetujui', 'ke bitung dr ambon', '2025-10-03 09:34:36'),
(3, 26, 2, 1, 'ambon', '2025-10-06', '14045', NULL, 'baik', '68e3722b7194e-SKPP_SIGNED (1).pdf', 'Disetujui', '', '2025-10-06 09:39:54');

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
-- Indexes for table `usulan_pindah`
--
ALTER TABLE `usulan_pindah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usulan_hakim` (`id_hakim`),
  ADD KEY `fk_usulan_pengadilan_asal` (`id_pengadilan_asal`),
  ADD KEY `fk_usulan_pengadilan_tujuan` (`id_pengadilan_tujuan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hakim_perikanan`
--
ALTER TABLE `hakim_perikanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `kebutuhan_perikanan`
--
ALTER TABLE `kebutuhan_perikanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengadilan`
--
ALTER TABLE `pengadilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usulan_pindah`
--
ALTER TABLE `usulan_pindah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hakim_perikanan`
--
ALTER TABLE `hakim_perikanan`
  ADD CONSTRAINT `fk_hakim_pengadilan` FOREIGN KEY (`id_pengadilan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usulan_pindah`
--
ALTER TABLE `usulan_pindah`
  ADD CONSTRAINT `fk_usulan_hakim` FOREIGN KEY (`id_hakim`) REFERENCES `hakim_perikanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usulan_pengadilan_asal` FOREIGN KEY (`id_pengadilan_asal`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usulan_pengadilan_tujuan` FOREIGN KEY (`id_pengadilan_tujuan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

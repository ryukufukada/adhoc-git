-- HAPUS DATABASE LAMA JIKA ADA, LALU BUAT BARU
DROP DATABASE IF EXISTS `sertifikasi_hakim`;
CREATE DATABASE `sertifikasi_hakim` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sertifikasi_hakim`;

-- =================================================================
-- 1. TABEL `pengadilan`
-- =================================================================
CREATE TABLE `pengadilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengadilan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_pengadilan` (`nama_pengadilan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pengadilan` (`id`, `nama_pengadilan`) VALUES
(1, 'PN Ambon'), (2, 'PN Bitung'), (3, 'PN Jakarta Utara'), (4, 'PN Medan'), (5, 'PN Merauke'), 
(6, 'PN Pontianak'), (7, 'PN Ranai'), (8, 'PN Sorong'), (9, 'PN Tanjung Pinang'), (10, 'PN Tual');

-- =================================================================
-- 2. TABEL `kebutuhan_perikanan`
-- =================================================================
CREATE TABLE `kebutuhan_perikanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengadilan` int(11) NOT NULL,
  `hk_ad_hoc` int(11) NOT NULL,
  `rata_rata` int(11) NOT NULL,
  `ideal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_pengadilan` (`id_pengadilan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `kebutuhan_perikanan` (`id_pengadilan`, `hk_ad_hoc`, `rata_rata`, `ideal`) VALUES
(1, 3, 1, 3), (2, 4, 17, 3), (3, 3, 5, 3), (4, 5, 11, 3), (5, 3, 1, 3),
(6, 5, 18, 3), (7, 5, 20, 3), (8, 3, 2, 3), (9, 7, 33, 4), (10, 3, 1, 3);

-- =================================================================
-- 3. TABEL `hakim_perikanan`
-- =================================================================
CREATE TABLE `hakim_perikanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `tgl_sk_pengangkatan_2` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pengadilan` (`id_pengadilan`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `hakim_perikanan` (`id`, `nama_hakim`, `nik`, `asal_org`, `jabatan`, `id_pengadilan`, `tmt_pn`, `tmt_hk`, `kepres`, `tgl_kepres`, `sk_dirjen`, `tgl_sk_dirjen`, `masa_jabatan`, `status_perpanjangan`, `tanggal_habis`) VALUES
(1, 'Hendra Adi Pramono, S.H., M.H.', '3578090810760004', 'PUSDIKPOMAL KODIKDUKUM KODIKLATAL', 'AD HOC PERIKANAN', 3, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(2, 'Warsita, S.H.', '3515082010720008', NULL, 'AD HOC PERIKANAN', 3, NULL, '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(3, 'Ir. Arnofi', '1371082911630002', NULL, 'AD HOC PERIKANAN', 3, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(4, 'Sugeng Widodo, S.H.,.', '3515070202640005', 'TNI AL', 'AD HOC PERIKANAN', 4, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(5, 'Ir Robert Napitupulu, S.H.,MSc,.', '1271172509620001', 'DINAS KELAUTAN DAN PERIKANAN', 'AD HOC PERIKANAN', 4, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(6, 'Soniady Drajat Sadarisman, S.H., M.H.', '3273162705690002', NULL, 'AD HOC PERIKANAN', 4, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(7, 'Ir. Raja Pasaribu, M.Sc.', '3275022202600015', NULL, 'AD HOC PERIKANAN', 4, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(8, 'Syaiful Anam, S.H., M.H.', '3578183101760001', NULL, 'AD HOC PERIKANAN', 4, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(9, 'Sigit Wibowo, S.Pi., M.Pi', '3313131809790001', NULL, 'AD HOC PERIKANAN', 9, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(10, 'Handono, S.H.', '3578130101650008', NULL, 'AD HOC PERIKANAN', 9, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(11, 'Addullah, APi, MMA.', '1271161211610003', 'BALAI PELATIHAN DAN PENYULUHAN PERIKANAN MEDAN', 'AD HOC PERIKANAN', 9, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(12, 'Ir. Raymond RM Bako, MA., QIA', '3174070305630006', NULL, 'AD HOC PERIKANAN', 9, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(13, 'Wedy Novizar, S.H.', '3515072411690004', 'TNI AL', 'AD HOC PERIKANAN', 9, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(14, 'Joko Supraptomo, A.Pi., M.M.', '3302260510630004', NULL, 'AD HOC PERIKANAN', 9, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(15, 'Devi Arnita, S.Pi.,M.Si.', '1871124109800003', NULL, 'AD HOC PERIKANAN', 9, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(16, 'Dr. Halomoan Freddy Sitinjak Alexandra, S.H.,M.H.', '3175101312630005', NULL, 'AD HOC PERIKANAN', 7, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(17, 'Sutriyadi, S.H., M.Si', '3578162705610002', 'PUSDIKPOMAL KODIKDUKUM KODIKLATAL', 'AD HOC PERIKANAN', 7, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(18, 'Sirodjuddin, S.H., M.H.', '3578040206700007', NULL, 'AD HOC PERIKANAN', 7, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(19, 'Suriadi, S.H.,M.H.', '1371040205780005', NULL, 'AD HOC PERIKANAN', 7, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(20, 'Endro Basuki Prabowo, A.Pi.', '1871132109620005', NULL, 'AD HOC PERIKANAN', 7, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(21, 'Nur Syamsu, S.T., M.Eng', '7602122908750001', NULL, 'AD HOC PERIKANAN', 6, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(22, 'Dr Urif Syarifudin, APi, MTA.', '7310042812700001', 'BALAI PENGELOLAAN SUMBERDAYA PESISIR DAN LAUT MAKASSAR', 'AD HOC PERIKANAN', 6, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(23, 'Edi Utomo, S.H., M.H.', '3578091704710001', 'TNI AL', 'AD HOC PERIKANAN', 6, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(24, 'Ir. Gatot Rudiyono, S.H., M.M.', '6171010301580001', NULL, 'AD HOC PERIKANAN', 6, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(25, 'Dr. Nova Yuniarti, S.Pi., M.P.', '7371136506750009', NULL, 'AD HOC PERIKANAN', 6, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(26, 'Ir. Ruslan, M.M.', '1963121902202211007', NULL, 'AD HOC PERIKANAN', 2, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(27, 'Sugeng Triono, S.H., M.H.', '3302270705780002', 'TNI AL', 'AD HOC PERIKANAN', 2, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(28, 'Temmy Fetrozian, SSt,Pi, M.H.', '1806010803770003', 'PNS DINAS PENDIDIKAN PERIKANAN KABUPATEN TANGGAMUS', 'AD HOC PERIKANAN', 2, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(29, 'Musdamin, S.Pi.', '7471060107770029', NULL, 'AD HOC PERIKANAN', 2, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(30, 'Alex Tarugi Tobing, S.H., M.H.', '3275041004670019', 'KEMRNTRIAN KELAUTAN DAN PERIKANAN', 'AD HOC PERIKANAN', 1, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(31, 'Nursyamsi Junus, S.T., M.Sc.', '7371105310730004', NULL, 'AD HOC', 1, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(32, 'Sitti Muslimah Bachrum, S.Pi., M.P.', '7371144506710008', NULL, 'AD HOC', 1, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(33, 'Ir. Armain Naim, S.H., MSi.', '8271021807680001', 'DITJEN PSDKP AMBON', 'AD HOC PERIKANAN', 10, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(34, 'Saptoyo, S.E., M.Sc.', '6171020910690009', NULL, 'AD HOC PERIKANAN', 10, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(35, 'Dr. Ir. Irawan Muripto, M.Sc.', '3175042509510002', NULL, 'AD HOC', 10, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(36, 'Awaluddin, S.Pi', '1977031902202211004', NULL, 'AD HOC PERIKANAN', 8, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(37, 'Asriadi, S.Kel., M.Si.', '7371140105780006', 'BALAI PENGELOLAAN SUMBERDAYA PESISIR DAN LAUT(BPSPL)', 'AD HOC PERIKANAN', 8, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(38, 'Hunter Hosen, S.Pi., M.Si.', '7373090702680001', NULL, 'AD HOC PERIKANAN', 8, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14'),
(39, 'Aco Harsandi, S.H., M.H.', '7371081512770004', NULL, 'AD HOC PERIKANAN', 5, '2022-11-11', '2022-11-11', '96/P Tahun 2022', '2022-09-12', '326/KMA/SK/XI/2022', '2022-11-11', '2X', 'Perpanjangan 2x habis 11 November 2032', '2032-11-11'),
(40, 'Unggul Senoaji, S.H.', '3201130912661001', 'STASIUN PENGAWASAN SUMBERDAYA KELAUTAN DAN PERIKANAN CILACAP', 'AD HOC PERIKANAN', 5, '2020-01-17', '2020-01-17', 'KEPRES NO 128/P TAHUN 2019', '2019-11-21', '17/KMA/SK/II/2020', '2020-02-04', '2X', 'Perpanjangan 2x habis 17 Januari 2030', '2030-01-17'),
(41, 'Anthony Soediarto, S.H., M.Hum.', '3404101012550004', NULL, 'AD HOC PERIKANAN', 5, '2021-01-14', '2021-01-14', 'KEPRES NO 137/P TAHUN 2020', '2020-12-30', '04/KMA/SK/I/2021', '2021-01-14', '2X', 'Perpanjangan 2x habis 14 Januari 2031', '2031-01-14');

-- 4. TABEL `usulan_pindah`
CREATE TABLE `usulan_pindah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_hakim` int(11) NOT NULL,
  `id_pengadilan_asal` int(11) NOT NULL,
  `id_pengadilan_tujuan` int(11) NULL,
  `tujuan_usul_text` varchar(255) NULL,
  `tanggal_usul` date NOT NULL,
  `no_surat` varchar(255) NULL,
  `tanggal_surat` date NULL,
  `alasan` text DEFAULT NULL,
  `nama_berkas` varchar(255) DEFAULT NULL,
  `status` enum('Diajukan','Disetujui','Ditolak') NOT NULL DEFAULT 'Diajukan',
  `keterangan_status` text DEFAULT NULL,
  `tanggal_diproses` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- 5. FOREIGN KEYS
ALTER TABLE `kebutuhan_perikanan` ADD CONSTRAINT `fk_kebutuhan_pengadilan` FOREIGN KEY (`id_pengadilan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;
ALTER TABLE `hakim_perikanan` ADD CONSTRAINT `fk_hakim_pengadilan` FOREIGN KEY (`id_pengadilan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;
ALTER TABLE `usulan_pindah`
  ADD CONSTRAINT `fk_usulan_hakim` FOREIGN KEY (`id_hakim`) REFERENCES `hakim_perikanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usulan_pengadilan_asal` FOREIGN KEY (`id_pengadilan_asal`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usulan_pengadilan_tujuan` FOREIGN KEY (`id_pengadilan_tujuan`) REFERENCES `pengadilan` (`id`) ON DELETE CASCADE;

COMMIT;
-- --------------------------------------------------------
-- TABEL MODUL LABORATORIUM & RADIOLOGI
-- --------------------------------------------------------

-- Tabel Pemeriksaan Lab Master
CREATE TABLE `lab_pemeriksaan` (
  `id_lab_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pemeriksaan` varchar(20) NOT NULL,
  `nama_pemeriksaan` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `nilai_rujukan` text DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_lab_pemeriksaan`),
  UNIQUE KEY `kode_pemeriksaan` (`kode_pemeriksaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Order Laboratorium
CREATE TABLE `lab_order` (
  `id_lab_order` int(11) NOT NULL AUTO_INCREMENT,
  `no_lab` varchar(20) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL COMMENT 'Untuk rawat jalan',
  `id_pendaftaran_inap` int(11) DEFAULT NULL COMMENT 'Untuk rawat inap',
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tanggal_order` datetime NOT NULL,
  `diagnosa` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Batal') NOT NULL DEFAULT 'Menunggu',
  `tgl_selesai` datetime DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_lab_order`),
  UNIQUE KEY `no_lab` (`no_lab`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_pendaftaran_inap` (`id_pendaftaran_inap`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `lab_order_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran_rawat_jalan` (`id_pendaftaran`) ON DELETE SET NULL,
  CONSTRAINT `lab_order_ibfk_2` FOREIGN KEY (`id_pendaftaran_inap`) REFERENCES `pendaftaran_rawat_inap` (`id_pendaftaran_inap`) ON DELETE SET NULL,
  CONSTRAINT `lab_order_ibfk_3` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `lab_order_ibfk_4` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `lab_order_ibfk_5` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Order Laboratorium
CREATE TABLE `lab_order_detail` (
  `id_lab_order_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab_order` int(11) NOT NULL,
  `id_lab_pemeriksaan` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_lab_order_detail`),
  KEY `id_lab_order` (`id_lab_order`),
  KEY `id_lab_pemeriksaan` (`id_lab_pemeriksaan`),
  CONSTRAINT `lab_order_detail_ibfk_1` FOREIGN KEY (`id_lab_order`) REFERENCES `lab_order` (`id_lab_order`) ON DELETE CASCADE,
  CONSTRAINT `lab_order_detail_ibfk_2` FOREIGN KEY (`id_lab_pemeriksaan`) REFERENCES `lab_pemeriksaan` (`id_lab_pemeriksaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Hasil Lab
CREATE TABLE `lab_hasil` (
  `id_lab_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab_order` int(11) NOT NULL,
  `id_lab_order_detail` int(11) NOT NULL,
  `hasil` text DEFAULT NULL,
  `nilai_rujukan` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_hasil` datetime DEFAULT NULL,
  `id_petugas_lab` int(11) DEFAULT NULL,
  `validator` int(11) DEFAULT NULL COMMENT 'ID pengguna yang memvalidasi hasil',
  `tanggal_validasi` datetime DEFAULT NULL,
  `status` enum('Draft','Final','Divalidasi') NOT NULL DEFAULT 'Draft',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_lab_hasil`),
  KEY `id_lab_order` (`id_lab_order`),
  KEY `id_lab_order_detail` (`id_lab_order_detail`),
  KEY `id_petugas_lab` (`id_petugas_lab`),
  KEY `validator` (`validator`),
  CONSTRAINT `lab_hasil_ibfk_1` FOREIGN KEY (`id_lab_order`) REFERENCES `lab_order` (`id_lab_order`) ON DELETE CASCADE,
  CONSTRAINT `lab_hasil_ibfk_2` FOREIGN KEY (`id_lab_order_detail`) REFERENCES `lab_order_detail` (`id_lab_order_detail`) ON DELETE CASCADE,
  CONSTRAINT `lab_hasil_ibfk_3` FOREIGN KEY (`id_petugas_lab`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  CONSTRAINT `lab_hasil_ibfk_4` FOREIGN KEY (`validator`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Pemeriksaan Radiologi Master
CREATE TABLE `rad_pemeriksaan` (
  `id_rad_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pemeriksaan` varchar(20) NOT NULL,
  `nama_pemeriksaan` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `persiapan` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rad_pemeriksaan`),
  UNIQUE KEY `kode_pemeriksaan` (`kode_pemeriksaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Order Radiologi
CREATE TABLE `rad_order` (
  `id_rad_order` int(11) NOT NULL AUTO_INCREMENT,
  `no_rad` varchar(20) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL COMMENT 'Untuk rawat jalan',
  `id_pendaftaran_inap` int(11) DEFAULT NULL COMMENT 'Untuk rawat inap',
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tanggal_order` datetime NOT NULL,
  `diagnosa` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Batal') NOT NULL DEFAULT 'Menunggu',
  `tgl_selesai` datetime DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rad_order`),
  UNIQUE KEY `no_rad` (`no_rad`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_pendaftaran_inap` (`id_pendaftaran_inap`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `rad_order_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran_rawat_jalan` (`id_pendaftaran`) ON DELETE SET NULL,
  CONSTRAINT `rad_order_ibfk_2` FOREIGN KEY (`id_pendaftaran_inap`) REFERENCES `pendaftaran_rawat_inap` (`id_pendaftaran_inap`) ON DELETE SET NULL,
  CONSTRAINT `rad_order_ibfk_3` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `rad_order_ibfk_4` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `rad_order_ibfk_5` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Order Radiologi
CREATE TABLE `rad_order_detail` (
  `id_rad_order_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_rad_order` int(11) NOT NULL,
  `id_rad_pemeriksaan` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rad_order_detail`),
  KEY `id_rad_order` (`id_rad_order`),
  KEY `id_rad_pemeriksaan` (`id_rad_pemeriksaan`),
  CONSTRAINT `rad_order_detail_ibfk_1` FOREIGN KEY (`id_rad_order`) REFERENCES `rad_order` (`id_rad_order`) ON DELETE CASCADE,
  CONSTRAINT `rad_order_detail_ibfk_2` FOREIGN KEY (`id_rad_pemeriksaan`) REFERENCES `rad_pemeriksaan` (`id_rad_pemeriksaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Hasil Radiologi
CREATE TABLE `rad_hasil` (
  `id_rad_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_rad_order` int(11) NOT NULL,
  `id_rad_order_detail` int(11) NOT NULL,
  `hasil` text DEFAULT NULL,
  `kesan` text DEFAULT NULL,
  `file_hasil` varchar(255) DEFAULT NULL COMMENT 'Path file gambar',
  `keterangan` text DEFAULT NULL,
  `tanggal_hasil` datetime DEFAULT NULL,
  `id_petugas_rad` int(11) DEFAULT NULL,
  `validator` int(11) DEFAULT NULL COMMENT 'ID pengguna yang memvalidasi hasil',
  `tanggal_validasi` datetime DEFAULT NULL,
  `status` enum('Draft','Final','Divalidasi') NOT NULL DEFAULT 'Draft',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rad_hasil`),
  KEY `id_rad_order` (`id_rad_order`),
  KEY `id_rad_order_detail` (`id_rad_order_detail`),
  KEY `id_petugas_rad` (`id_petugas_rad`),
  KEY `validator` (`validator`),
  CONSTRAINT `rad_hasil_ibfk_1` FOREIGN KEY (`id_rad_order`) REFERENCES `rad_order` (`id_rad_order`) ON DELETE CASCADE,
  CONSTRAINT `rad_hasil_ibfk_2` FOREIGN KEY (`id_rad_order_detail`) REFERENCES `rad_order_detail` (`id_rad_order_detail`) ON DELETE CASCADE,
  CONSTRAINT `rad_hasil_ibfk_3` FOREIGN KEY (`id_petugas_rad`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  CONSTRAINT `rad_hasil_ibfk_4` FOREIGN KEY (`validator`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk lab pemeriksaan
INSERT INTO `lab_pemeriksaan` (`kode_pemeriksaan`, `nama_pemeriksaan`, `kategori`, `tarif`, `nilai_rujukan`, `satuan`, `status`) VALUES
('HB', 'Hemoglobin', 'Hematologi', 25000.00, 'Pria: 13.5-17.5, Wanita: 12.0-16.0', 'g/dL', 'aktif'),
('LED', 'Laju Endap Darah', 'Hematologi', 20000.00, 'Pria: < 10, Wanita: < 15', 'mm/jam', 'aktif'),
('LEUKOSIT', 'Leukosit', 'Hematologi', 20000.00, '4.500-11.000', 'sel/mm³', 'aktif'),
('TROMBOSIT', 'Trombosit', 'Hematologi', 25000.00, '150.000-450.000', 'sel/mm³', 'aktif'),
('HEMATOKRIT', 'Hematokrit', 'Hematologi', 20000.00, 'Pria: 40-50, Wanita: 37-47', '%', 'aktif'),
('ERITROSIT', 'Eritrosit', 'Hematologi', 20000.00, 'Pria: 4.5-5.5, Wanita: 4.0-5.0', 'juta/mm³', 'aktif'),
('SGOT', 'SGOT', 'Kimia Klinik', 35000.00, 'Pria: < 37, Wanita: < 31', 'U/L', 'aktif'),
('SGPT', 'SGPT', 'Kimia Klinik', 35000.00, 'Pria: < 42, Wanita: < 32', 'U/L', 'aktif'),
('GDS', 'Gula Darah Sewaktu', 'Kimia Klinik', 25000.00, '< 140', 'mg/dL', 'aktif'),
('GDP', 'Gula Darah Puasa', 'Kimia Klinik', 25000.00, '< 100', 'mg/dL', 'aktif'),
('KOLESTEROL', 'Kolesterol Total', 'Kimia Klinik', 30000.00, '< 200', 'mg/dL', 'aktif'),
('HDL', 'HDL Kolesterol', 'Kimia Klinik', 35000.00, '> 40', 'mg/dL', 'aktif'),
('LDL', 'LDL Kolesterol', 'Kimia Klinik', 35000.00, '< 100', 'mg/dL', 'aktif'),
('TRIGLISERIDA', 'Trigliserida', 'Kimia Klinik', 35000.00, '< 150', 'mg/dL', 'aktif'),
('UREUM', 'Ureum', 'Kimia Klinik', 30000.00, '10-50', 'mg/dL', 'aktif'),
('KREATININ', 'Kreatinin', 'Kimia Klinik', 30000.00, 'Pria: 0.7-1.3, Wanita: 0.6-1.1', 'mg/dL', 'aktif'),
('ASAM URAT', 'Asam Urat', 'Kimia Klinik', 30000.00, 'Pria: 3.5-7.0, Wanita: 2.5-6.0', 'mg/dL', 'aktif'),
('URINE RUTIN', 'Urine Rutin', 'Urinalisis', 35000.00, '-', '-', 'aktif');

-- Data default untuk radiologi pemeriksaan
INSERT INTO `rad_pemeriksaan` (`kode_pemeriksaan`, `nama_pemeriksaan`, `kategori`, `tarif`, `status`) VALUES
('RO-THORAX', 'Rontgen Thorax', 'Rontgen', 150000.00, 'aktif'),
('RO-BNO', 'Rontgen BNO', 'Rontgen', 150000.00, 'aktif'),
('RO-EKSTREMITAS', 'Rontgen Ekstremitas', 'Rontgen', 150000.00, 'aktif'),
('RO-KEPALA', 'Rontgen Kepala', 'Rontgen', 150000.00, 'aktif'),
('USG-ABDOMEN', 'USG Abdomen', 'USG', 250000.00, 'aktif'),
('USG-OBSTETRI', 'USG Obstetri', 'USG', 250000.00, 'aktif'),
('USG-MAMMAE', 'USG Mammae', 'USG', 250000.00, 'aktif'),
('USG-THYROID', 'USG Thyroid', 'USG', 250000.00, 'aktif'); 
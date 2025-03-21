-- --------------------------------------------------------
-- TABEL MODUL PENDAFTARAN PASIEN
-- --------------------------------------------------------

-- Tabel data pasien
CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL AUTO_INCREMENT,
  `no_rm` varchar(20) NOT NULL COMMENT 'Nomor Rekam Medis',
  `nik` varchar(20) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `golongan_darah` enum('A','B','AB','O','Tidak Tahu') DEFAULT 'Tidak Tahu',
  `alamat` text NOT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `status_pernikahan` enum('Belum Menikah','Menikah','Cerai Hidup','Cerai Mati') DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `nama_keluarga` varchar(100) DEFAULT NULL COMMENT 'Keluarga yang bisa dihubungi',
  `telp_keluarga` varchar(15) DEFAULT NULL,
  `hubungan_keluarga` varchar(50) DEFAULT NULL,
  `id_asuransi` int(11) DEFAULT NULL,
  `no_asuransi` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pasien`),
  UNIQUE KEY `no_rm` (`no_rm`),
  UNIQUE KEY `nik` (`nik`)
  -- Script untuk menambahkan kolom yang tidak ada di tabel pasien
ALTER TABLE `pasien` 
ADD COLUMN `no_identitas` VARCHAR(50) DEFAULT NULL AFTER `pekerjaan`,
ADD COLUMN `jenis_identitas` VARCHAR(20) DEFAULT NULL AFTER `no_identitas`,
ADD COLUMN `suku` VARCHAR(50) DEFAULT NULL AFTER `agama`,
ADD COLUMN `pendidikan` VARCHAR(50) DEFAULT NULL AFTER `status_pernikahan`,
ADD COLUMN `rhesus` VARCHAR(10) DEFAULT NULL AFTER `golongan_darah`,
ADD COLUMN `alergi` TEXT DEFAULT NULL AFTER `rhesus`,
ADD COLUMN `catatan_khusus` TEXT DEFAULT NULL AFTER `alergi`,
ADD COLUMN `tanggal_daftar` DATETIME DEFAULT NULL AFTER `status`;
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel asuransi
CREATE TABLE `asuransi` (
  `id_asuransi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_asuransi` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL COMMENT 'Person In Charge',
  `no_perjanjian` varchar(100) DEFAULT NULL,
  `tanggal_perjanjian` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_asuransi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pendaftaran rawat jalan
CREATE TABLE `pendaftaran_rawat_jalan` (
  `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT,
  `no_pendaftaran` varchar(20) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `id_poli` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_jadwal_dokter` int(11) DEFAULT NULL,
  `keluhan` text DEFAULT NULL,
  `id_asal_rujukan` int(11) DEFAULT NULL,
  `no_rujukan` varchar(50) DEFAULT NULL,
  `id_asuransi` int(11) DEFAULT NULL,
  `no_asuransi` varchar(50) DEFAULT NULL,
  `cara_bayar` enum('Tunai','Asuransi','Campuran') NOT NULL DEFAULT 'Tunai',
  `status_periksa` enum('Menunggu','Dilayani','Batal','Selesai') NOT NULL DEFAULT 'Menunggu',
  `id_petugas` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendaftaran`),
  UNIQUE KEY `no_pendaftaran` (`no_pendaftaran`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_poli` (`id_poli`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_asuransi` (`id_asuransi`),
  KEY `id_asal_rujukan` (`id_asal_rujukan`),
  CONSTRAINT `pendaftaran_rawat_jalan_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `pendaftaran_rawat_jalan_ibfk_4` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `pendaftaran_rawat_jalan_ibfk_5` FOREIGN KEY (`id_asuransi`) REFERENCES `asuransi` (`id_asuransi`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pendaftaran rawat inap
CREATE TABLE `pendaftaran_rawat_inap` (
  `id_pendaftaran_inap` int(11) NOT NULL AUTO_INCREMENT,
  `no_pendaftaran_inap` varchar(20) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `id_ruang` int(11) NOT NULL,
  `id_bed` int(11) NOT NULL,
  `id_dokter_pj` int(11) NOT NULL COMMENT 'Dokter Penanggung Jawab',
  `diagnosa_awal` text DEFAULT NULL,
  `id_asal_rujukan` int(11) DEFAULT NULL,
  `no_rujukan` varchar(50) DEFAULT NULL,
  `id_asuransi` int(11) DEFAULT NULL,
  `no_asuransi` varchar(50) DEFAULT NULL,
  `cara_bayar` enum('Tunai','Asuransi','Campuran') NOT NULL DEFAULT 'Tunai',
  `status_inap` enum('Aktif','Pulang','Meninggal','Dirujuk','APS') NOT NULL DEFAULT 'Aktif',
  `tanggal_keluar` datetime DEFAULT NULL,
  `resume_pulang` text DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `keterangan_pulang` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendaftaran_inap`),
  UNIQUE KEY `no_pendaftaran_inap` (`no_pendaftaran_inap`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_ruang` (`id_ruang`),
  KEY `id_dokter_pj` (`id_dokter_pj`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_asuransi` (`id_asuransi`),
  KEY `id_asal_rujukan` (`id_asal_rujukan`),
  KEY `id_bed` (`id_bed`),
  CONSTRAINT `pendaftaran_rawat_inap_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `pendaftaran_rawat_inap_ibfk_4` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `pendaftaran_rawat_inap_ibfk_5` FOREIGN KEY (`id_asuransi`) REFERENCES `asuransi` (`id_asuransi`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pembatalan transaksi
CREATE TABLE `pembatalan_transaksi` (
  `id_pembatalan` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_transaksi` enum('Rawat Jalan','Rawat Inap','Farmasi','Laboratorium','Radiologi') NOT NULL,
  `id_transaksi` int(11) NOT NULL COMMENT 'ID dari tabel terkait',
  `alasan_batal` text NOT NULL,
  `tanggal_batal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_petugas` int(11) NOT NULL,
  `id_approval` int(11) DEFAULT NULL,
  `status_approval` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `catatan_approval` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pembatalan`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_approval` (`id_approval`),
  CONSTRAINT `pembatalan_transaksi_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `pembatalan_transaksi_ibfk_2` FOREIGN KEY (`id_approval`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk asuransi
INSERT INTO `asuransi` (`nama_asuransi`, `status`) VALUES
('Umum/Pribadi', 'aktif'),
('BPJS Kesehatan', 'aktif'),
('Asuransi Mandiri', 'aktif'),
('Prudential', 'aktif'),
('Allianz', 'aktif'); 
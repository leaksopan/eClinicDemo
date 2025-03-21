-- Database: eClinic
CREATE DATABASE IF NOT EXISTS `eClinic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `eClinic`;

-- --------------------------------------------------------
-- TABEL PENGGUNA DAN HAK AKSES
-- --------------------------------------------------------

-- Tabel pengguna sistem
CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `terakhir_login` datetime DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel role/peran pengguna
CREATE TABLE `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `nama_role` (`nama_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel hak akses per role
CREATE TABLE `hak_akses` (
  `id_hak_akses` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `nama_modul` varchar(50) NOT NULL,
  `baca` tinyint(1) NOT NULL DEFAULT 0,
  `tulis` tinyint(1) NOT NULL DEFAULT 0,
  `ubah` tinyint(1) NOT NULL DEFAULT 0,
  `hapus` tinyint(1) NOT NULL DEFAULT 0,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_hak_akses`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `hak_akses_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel log aktivitas pengguna
CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABEL INFORMASI KLINIK
-- --------------------------------------------------------

-- Tabel info klinik
CREATE TABLE `info_klinik` (
  `id_klinik` int(11) NOT NULL AUTO_INCREMENT,
  `nama_klinik` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `no_izin` varchar(100) DEFAULT NULL,
  `direktur` varchar(100) DEFAULT NULL,
  `tgl_berdiri` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_klinik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk info klinik
INSERT INTO `info_klinik` (`nama_klinik`, `alamat`, `no_telp`, `email`, `website`, `direktur`) VALUES 
('eClinic', 'Jalan Kesehatan No. 123, Jakarta', '021-12345678', 'info@eclinic.com', 'www.eclinic.com', 'dr. Administrator');

-- Data default untuk role
INSERT INTO `role` (`nama_role`, `deskripsi`) VALUES
('Administrator', 'Akses penuh ke semua fitur sistem'),
('Dokter', 'Akses ke fitur medis dan rekam medis'),
('Perawat', 'Akses ke pendaftaran dan bantuan medis'),
('Apoteker', 'Akses ke modul farmasi'),
('Kasir', 'Akses ke modul kasir dan pembayaran'),
('Pendaftaran', 'Akses ke modul pendaftaran'),
('Laboratorium', 'Akses ke modul laboratorium'),
('Radiologi', 'Akses ke modul radiologi'),
('Keuangan', 'Akses ke modul keuangan'),
('Gudang', 'Akses ke modul inventaris'),
('Pasien', 'Akses terbatas ke data pribadi');

-- Admin default
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `id_role`, `status`) VALUES
('admin', '$2y$10$wXrUZpmzPHR9bKqXSN5RVeC5jfnhpAjIJk2.b0bvWlUqIeLaxnTmG', 'Administrator Sistem', 'admin@eclinic.com', 1, 'aktif');
-- Password: admin123 (dienkripsi dengan bcrypt) 
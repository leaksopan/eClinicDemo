-- --------------------------------------------------------
-- TABEL MODUL KLINIK
-- --------------------------------------------------------

-- Tabel Dokter
CREATE TABLE `dokter` (
  `id_dokter` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `sip` varchar(50) NOT NULL COMMENT 'Surat Izin Praktek',
  `spesialis` varchar(100) DEFAULT NULL,
  `tarif_konsultasi` decimal(12,2) NOT NULL DEFAULT 0.00,
  `komisi_persen` decimal(5,2) DEFAULT NULL,
  `status_praktek` enum('Aktif','Cuti','Berhenti') NOT NULL DEFAULT 'Aktif',
  `jatah_pasien` int(11) DEFAULT NULL COMMENT 'Jumlah maksimal pasien per hari',
  `gelar_depan` varchar(20) DEFAULT NULL,
  `gelar_belakang` varchar(20) DEFAULT NULL,
  `alumni` varchar(100) DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `mulai_praktek` date DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dokter`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Poli/Poliklinik
CREATE TABLE `poliklinik` (
  `id_poli` int(11) NOT NULL AUTO_INCREMENT,
  `kode_poli` varchar(10) NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_poli`),
  UNIQUE KEY `kode_poli` (`kode_poli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Parameter
CREATE TABLE `parameter` (
  `id_parameter` int(11) NOT NULL AUTO_INCREMENT,
  `kelompok` varchar(50) NOT NULL,
  `nama_parameter` varchar(100) NOT NULL,
  `nilai` text NOT NULL,
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_parameter`),
  UNIQUE KEY `kelompok_nama` (`kelompok`,`nama_parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Asal Rujukan
CREATE TABLE `asal_rujukan` (
  `id_asal_rujukan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_rujukan` varchar(20) NOT NULL,
  `nama_rujukan` varchar(100) NOT NULL,
  `jenis` enum('Puskesmas','Rumah Sakit','Klinik','Dokter','Lainnya') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_asal_rujukan`),
  UNIQUE KEY `kode_rujukan` (`kode_rujukan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Ruang Inap
CREATE TABLE `ruang_inap` (
  `id_ruang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_ruang` varchar(20) NOT NULL,
  `nama_ruang` varchar(100) NOT NULL,
  `kelas` enum('VVIP','VIP','Kelas I','Kelas II','Kelas III','ICU','HCU','Isolasi') NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 1,
  `terisi` int(11) NOT NULL DEFAULT 0,
  `tarif_per_hari` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fasilitas` text DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `status` enum('Tersedia','Penuh','Perbaikan','Nonaktif') NOT NULL DEFAULT 'Tersedia',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ruang`),
  UNIQUE KEY `kode_ruang` (`kode_ruang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Bed/Tempat Tidur
CREATE TABLE `bed` (
  `id_bed` int(11) NOT NULL AUTO_INCREMENT,
  `id_ruang` int(11) NOT NULL,
  `nomor_bed` varchar(10) NOT NULL,
  `status` enum('Kosong','Terisi','Rusak','Booking') NOT NULL DEFAULT 'Kosong',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bed`),
  UNIQUE KEY `id_ruang_nomor_bed` (`id_ruang`,`nomor_bed`),
  CONSTRAINT `bed_ibfk_1` FOREIGN KEY (`id_ruang`) REFERENCES `ruang_inap` (`id_ruang`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Jadwal Dokter
CREATE TABLE `jadwal_dokter` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `id_dokter` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_pasien` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_poli` (`id_poli`),
  CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_dokter_ibfk_2` FOREIGN KEY (`id_poli`) REFERENCES `poliklinik` (`id_poli`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk poliklinik
INSERT INTO `poliklinik` (`kode_poli`, `nama_poli`, `status`) VALUES
('UMUM', 'Poliklinik Umum', 'aktif'),
('GIGI', 'Poliklinik Gigi', 'aktif'),
('ANAK', 'Poliklinik Anak', 'aktif'),
('OBGYN', 'Poliklinik Kebidanan & Kandungan', 'aktif'),
('JANTUNG', 'Poliklinik Jantung', 'aktif'),
('MATA', 'Poliklinik Mata', 'aktif'),
('THT', 'Poliklinik THT', 'aktif'),
('KULIT', 'Poliklinik Kulit & Kelamin', 'aktif'),
('SARAF', 'Poliklinik Saraf', 'aktif'),
('PARU', 'Poliklinik Paru', 'aktif');

-- Data default untuk asal rujukan
INSERT INTO `asal_rujukan` (`kode_rujukan`, `nama_rujukan`, `jenis`, `status`) VALUES
('MANDIRI', 'Datang Sendiri/Mandiri', 'Lainnya', 'aktif'),
('IGD', 'Instalasi Gawat Darurat', 'Lainnya', 'aktif');

-- Data default untuk ruang inap
INSERT INTO `ruang_inap` (`kode_ruang`, `nama_ruang`, `kelas`, `kapasitas`, `tarif_per_hari`, `status`) VALUES
('VIP-01', 'Ruang VIP 1', 'VIP', 5, 750000.00, 'Tersedia'),
('K1-01', 'Ruang Kelas I', 'Kelas I', 10, 500000.00, 'Tersedia'),
('K2-01', 'Ruang Kelas II', 'Kelas II', 15, 300000.00, 'Tersedia'),
('K3-01', 'Ruang Kelas III', 'Kelas III', 20, 150000.00, 'Tersedia'),
('ICU-01', 'ICU 1', 'ICU', 5, 1500000.00, 'Tersedia');

-- Data default untuk parameter
INSERT INTO `parameter` (`kelompok`, `nama_parameter`, `nilai`, `keterangan`) VALUES
('sistem', 'nama_aplikasi', 'eClinic', 'Nama aplikasi yang ditampilkan di header'),
('sistem', 'footer_text', 'eClinic © 2023', 'Teks footer aplikasi'),
('sistem', 'format_no_rm', 'RM-{TAHUN}{BULAN}{NOMOR}', 'Format nomor rekam medis'),
('sistem', 'format_no_pendaftaran', 'REG-{TAHUN}{BULAN}{TANGGAL}-{NOMOR}', 'Format nomor pendaftaran'),
('sistem', 'format_no_resep', 'RX-{TAHUN}{BULAN}{TANGGAL}-{NOMOR}', 'Format nomor resep'),
('sistem', 'format_no_lab', 'LAB-{TAHUN}{BULAN}{TANGGAL}-{NOMOR}', 'Format nomor laboratorium'),
('sistem', 'format_no_rad', 'RAD-{TAHUN}{BULAN}{TANGGAL}-{NOMOR}', 'Format nomor radiologi'),
('sistem', 'format_no_faktur', 'INV-{TAHUN}{BULAN}{TANGGAL}-{NOMOR}', 'Format nomor faktur'),
('email', 'smtp_host', 'smtp.gmail.com', 'Host SMTP untuk email'),
('email', 'smtp_port', '587', 'Port SMTP'),
('email', 'smtp_user', 'info@eclinic.com', 'Username SMTP'),
('email', 'smtp_pass', '', 'Password SMTP'),
('email', 'smtp_crypto', 'tls', 'Enkripsi SMTP'),
('email', 'from_email', 'info@eclinic.com', 'Email pengirim'),
('email', 'from_name', 'eClinic', 'Nama pengirim email'); 
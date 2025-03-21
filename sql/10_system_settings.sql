-- --------------------------------------------------------
-- TABEL MODUL PENGATURAN SISTEM
-- --------------------------------------------------------

-- Tabel Pengaturan
CREATE TABLE `pengaturan` (
  `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) NOT NULL,
  `kunci` varchar(100) NOT NULL,
  `nilai` text DEFAULT NULL,
  `tipe` enum('text','number','boolean','json','file','date','time','datetime','textarea','select') NOT NULL DEFAULT 'text',
  `label` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `opsi` text DEFAULT NULL COMMENT 'Format JSON untuk opsi select',
  `is_public` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Dapat diakses publik tanpa login',
  `urutan` int(11) NOT NULL DEFAULT 0,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengaturan`),
  UNIQUE KEY `kunci` (`kunci`),
  KEY `kategori` (`kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Menu
CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `modul` varchar(50) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_menu`),
  UNIQUE KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Menu Role
CREATE TABLE `menu_role` (
  `id_menu_role` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `akses` tinyint(1) NOT NULL DEFAULT 1,
  `tambah` tinyint(1) NOT NULL DEFAULT 0,
  `edit` tinyint(1) NOT NULL DEFAULT 0,
  `hapus` tinyint(1) NOT NULL DEFAULT 0,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_menu_role`),
  UNIQUE KEY `id_menu_role` (`id_menu`,`id_role`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `menu_role_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE,
  CONSTRAINT `menu_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Backup
CREATE TABLE `backup` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT,
  `nama_file` varchar(255) NOT NULL,
  `ukuran` bigint(20) NOT NULL,
  `tipe` enum('database','sistem') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_backup`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `backup_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Notifikasi
CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('info','success','warning','danger') NOT NULL DEFAULT 'info',
  `url` varchar(255) DEFAULT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dibaca_pada` datetime DEFAULT NULL,
  PRIMARY KEY (`id_notifikasi`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Audit Trail
CREATE TABLE `audit_trail` (
  `id_audit` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) DEFAULT NULL,
  `aksi` enum('login','logout','create','update','delete','view','export','import','backup','restore','other') NOT NULL,
  `tabel` varchar(100) DEFAULT NULL,
  `id_record` varchar(100) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_audit`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk pengaturan sistem
INSERT INTO `pengaturan` (`kategori`, `kunci`, `nilai`, `tipe`, `label`, `deskripsi`, `is_public`, `urutan`) VALUES
('sistem', 'nama_aplikasi', 'eClinic System', 'text', 'Nama Aplikasi', 'Nama aplikasi yang akan ditampilkan pada title dan header', 1, 1),
('sistem', 'deskripsi_aplikasi', 'Sistem Informasi Klinik Terpadu', 'textarea', 'Deskripsi Aplikasi', 'Deskripsi singkat tentang aplikasi', 1, 2),
('sistem', 'logo_aplikasi', 'logo.png', 'file', 'Logo Aplikasi', 'Logo yang akan ditampilkan pada header dan laporan', 1, 3),
('sistem', 'favicon', 'favicon.ico', 'file', 'Favicon', 'Icon kecil yang tampil pada tab browser', 1, 4),
('sistem', 'tema', 'default', 'select', 'Tema Aplikasi', 'Tema warna untuk aplikasi', 0, 5),
('sistem', 'timezone', 'Asia/Jakarta', 'text', 'Timezone', 'Pengaturan zona waktu', 0, 6),
('sistem', 'format_tanggal', 'd-m-Y', 'text', 'Format Tanggal', 'Format penulisan tanggal', 0, 7),
('sistem', 'format_waktu', 'H:i:s', 'text', 'Format Waktu', 'Format penulisan waktu', 0, 8),
('sistem', 'maintenance_mode', '0', 'boolean', 'Mode Pemeliharaan', 'Aktifkan mode pemeliharaan saat maintenance', 0, 9),
('sistem', 'versi_aplikasi', '1.0.0', 'text', 'Versi Aplikasi', 'Versi aplikasi saat ini', 1, 10),
('klinik', 'nama_klinik', 'Klinik Sehat Sentosa', 'text', 'Nama Klinik', 'Nama klinik yang akan ditampilkan pada laporan dan kop surat', 1, 11),
('klinik', 'alamat_klinik', 'Jl. Contoh No. 123, Jakarta Selatan', 'textarea', 'Alamat Klinik', 'Alamat lengkap klinik', 1, 12),
('klinik', 'telepon_klinik', '021-1234567', 'text', 'Telepon Klinik', 'Nomor telepon klinik', 1, 13),
('klinik', 'email_klinik', 'info@kliniksehat.com', 'text', 'Email Klinik', 'Alamat email klinik', 1, 14),
('klinik', 'website_klinik', 'www.kliniksehat.com', 'text', 'Website Klinik', 'Alamat website klinik', 1, 15),
('klinik', 'logo_klinik', 'logo_klinik.png', 'file', 'Logo Klinik', 'Logo klinik untuk kop surat dan laporan', 1, 16),
('klinik', 'cap_klinik', 'cap_klinik.png', 'file', 'Cap Klinik', 'Gambar stempel/cap klinik', 0, 17),
('klinik', 'ttd_direktur', 'ttd_direktur.png', 'file', 'Tanda Tangan Direktur', 'Gambar tanda tangan direktur klinik', 0, 18),
('keuangan', 'mata_uang', 'IDR', 'text', 'Mata Uang', 'Kode mata uang yang digunakan', 0, 19),
('keuangan', 'format_angka', '#,##0.00', 'text', 'Format Angka', 'Format penulisan angka/nominal', 0, 20),
('keuangan', 'pajak', '10', 'number', 'Pajak (%)', 'Persentase pajak yang dikenakan', 0, 21),
('keuangan', 'diskon_maksimal', '25', 'number', 'Diskon Maksimal (%)', 'Persentase maksimal diskon yang diperbolehkan', 0, 22),
('pasien', 'format_no_rm', 'RM-{TAHUN}{BULAN}{URUTAN}', 'text', 'Format Nomor RM', 'Format penomoran rekam medis', 0, 23),
('pasien', 'panjang_urutan_no_rm', '4', 'number', 'Panjang Urutan No RM', 'Jumlah digit urutan nomor rekam medis', 0, 24),
('pasien', 'usia_minimum_dewasa', '17', 'number', 'Usia Minimum Dewasa', 'Usia minimum pasien dikategorikan dewasa', 0, 25),
('keamanan', 'login_attempts', '3', 'number', 'Percobaan Login', 'Jumlah maksimal percobaan login yang diperbolehkan', 0, 26),
('keamanan', 'lockout_time', '30', 'number', 'Waktu Lockout (menit)', 'Waktu pengguna terkunci setelah melebihi percobaan login', 0, 27),
('keamanan', 'password_expiry', '90', 'number', 'Masa Berlaku Password (hari)', 'Hari password harus diganti', 0, 28),
('keamanan', 'session_timeout', '30', 'number', 'Timeout Session (menit)', 'Waktu idle maksimum sebelum session berakhir', 0, 29),
('keamanan', 'enable_captcha', '1', 'boolean', 'Aktifkan Captcha', 'Mengaktifkan captcha pada form login', 0, 30),
('keamanan', 'log_aktivitas', '1', 'boolean', 'Log Aktivitas', 'Mencatat semua aktivitas pengguna', 0, 31);

-- Data default untuk menu
INSERT INTO `menu` (`parent_id`, `nama`, `slug`, `url`, `icon`, `urutan`, `status`, `modul`) VALUES
(NULL, 'Dashboard', 'dashboard', 'dashboard', 'fa fa-dashboard', 1, 'aktif', 'dashboard'),
(NULL, 'Pendaftaran', 'pendaftaran', '#', 'fa fa-user-plus', 2, 'aktif', 'pendaftaran'),
(2, 'Data Pasien', 'pendaftaran-pasien', 'pendaftaran/pasien', 'fa fa-users', 1, 'aktif', 'pendaftaran'),
(2, 'Pendaftaran Rawat Jalan', 'pendaftaran-rawat-jalan', 'pendaftaran/rawat_jalan', 'fa fa-stethoscope', 2, 'aktif', 'pendaftaran'),
(2, 'Pendaftaran Rawat Inap', 'pendaftaran-rawat-inap', 'pendaftaran/rawat_inap', 'fa fa-bed', 3, 'aktif', 'pendaftaran'),
(NULL, 'Klinik', 'klinik', '#', 'fa fa-hospital-o', 3, 'aktif', 'klinik'),
(6, 'Poliklinik', 'klinik-poli', 'klinik/poli', 'fa fa-stethoscope', 1, 'aktif', 'klinik'),
(6, 'Dokter', 'klinik-dokter', 'klinik/dokter', 'fa fa-user-md', 2, 'aktif', 'klinik'),
(6, 'Ruang Rawat Inap', 'klinik-ruang', 'klinik/ruang', 'fa fa-hospital-o', 3, 'aktif', 'klinik'),
(NULL, 'Rekam Medis', 'rekam-medis', '#', 'fa fa-heartbeat', 4, 'aktif', 'rekam_medis'),
(10, 'Rekam Medis Pasien', 'rekam-medis-pasien', 'rekam_medis/pasien', 'fa fa-file-text', 1, 'aktif', 'rekam_medis'),
(10, 'Diagnosa & ICD', 'rekam-medis-diagnosa', 'rekam_medis/diagnosa', 'fa fa-stethoscope', 2, 'aktif', 'rekam_medis'),
(10, 'Tindakan', 'rekam-medis-tindakan', 'rekam_medis/tindakan', 'fa fa-medkit', 3, 'aktif', 'rekam_medis'),
(NULL, 'Farmasi', 'farmasi', '#', 'fa fa-plus-square', 5, 'aktif', 'farmasi'),
(14, 'Antrian Resep', 'farmasi-antrian', 'farmasi/antrian', 'fa fa-list-ol', 1, 'aktif', 'farmasi'),
(14, 'Penjualan Obat', 'farmasi-penjualan', 'farmasi/penjualan', 'fa fa-shopping-cart', 2, 'aktif', 'farmasi'),
(14, 'Data Obat & BHP', 'farmasi-obat', 'farmasi/obat', 'fa fa-flask', 3, 'aktif', 'farmasi'),
(NULL, 'Laboratorium', 'laboratorium', '#', 'fa fa-flask', 6, 'aktif', 'laboratorium'),
(18, 'Permintaan Lab', 'laboratorium-permintaan', 'laboratorium/permintaan', 'fa fa-file-text', 1, 'aktif', 'laboratorium'),
(18, 'Hasil Pemeriksaan', 'laboratorium-hasil', 'laboratorium/hasil', 'fa fa-clipboard', 2, 'aktif', 'laboratorium'),
(18, 'Master Pemeriksaan', 'laboratorium-master', 'laboratorium/master', 'fa fa-list', 3, 'aktif', 'laboratorium'),
(NULL, 'Radiologi', 'radiologi', '#', 'fa fa-radiation', 7, 'aktif', 'radiologi'),
(22, 'Permintaan Radiologi', 'radiologi-permintaan', 'radiologi/permintaan', 'fa fa-file-text', 1, 'aktif', 'radiologi'),
(22, 'Hasil Pemeriksaan', 'radiologi-hasil', 'radiologi/hasil', 'fa fa-clipboard', 2, 'aktif', 'radiologi'),
(22, 'Master Pemeriksaan', 'radiologi-master', 'radiologi/master', 'fa fa-list', 3, 'aktif', 'radiologi'),
(NULL, 'Kasir', 'kasir', '#', 'fa fa-money', 8, 'aktif', 'kasir'),
(26, 'Pembayaran Rawat Jalan', 'kasir-rawat-jalan', 'kasir/rawat_jalan', 'fa fa-stethoscope', 1, 'aktif', 'kasir'),
(26, 'Pembayaran Rawat Inap', 'kasir-rawat-inap', 'kasir/rawat_inap', 'fa fa-bed', 2, 'aktif', 'kasir'),
(26, 'Pembayaran Farmasi', 'kasir-farmasi', 'kasir/farmasi', 'fa fa-plus-square', 3, 'aktif', 'kasir'),
(NULL, 'Keuangan', 'keuangan', '#', 'fa fa-dollar', 9, 'aktif', 'keuangan'),
(30, 'Pendapatan', 'keuangan-pendapatan', 'keuangan/pendapatan', 'fa fa-plus-circle', 1, 'aktif', 'keuangan'),
(30, 'Pengeluaran', 'keuangan-pengeluaran', 'keuangan/pengeluaran', 'fa fa-minus-circle', 2, 'aktif', 'keuangan'),
(30, 'Laporan Keuangan', 'keuangan-laporan', 'keuangan/laporan', 'fa fa-file-text', 3, 'aktif', 'keuangan'),
(NULL, 'Inventory', 'inventory', '#', 'fa fa-cubes', 10, 'aktif', 'inventory'),
(34, 'Purchase Order', 'inventory-po', 'inventory/po', 'fa fa-shopping-cart', 1, 'aktif', 'inventory'),
(34, 'Penerimaan Barang', 'inventory-penerimaan', 'inventory/penerimaan', 'fa fa-truck', 2, 'aktif', 'inventory'),
(34, 'Retur Pembelian', 'inventory-retur', 'inventory/retur', 'fa fa-reply', 3, 'aktif', 'inventory'),
(34, 'Stock Opname', 'inventory-opname', 'inventory/opname', 'fa fa-clipboard-check', 4, 'aktif', 'inventory'),
(NULL, 'Surat', 'surat', '#', 'fa fa-envelope', 11, 'aktif', 'surat'),
(39, 'Cetak Surat', 'surat-cetak', 'surat/cetak', 'fa fa-print', 1, 'aktif', 'surat'),
(39, 'Template Surat', 'surat-template', 'surat/template', 'fa fa-file-text', 2, 'aktif', 'surat'),
(NULL, 'Laporan', 'laporan', '#', 'fa fa-bar-chart', 12, 'aktif', 'laporan'),
(42, 'Laporan Kunjungan', 'laporan-kunjungan', 'laporan/kunjungan', 'fa fa-users', 1, 'aktif', 'laporan'),
(42, 'Laporan Rekam Medis', 'laporan-rekam-medis', 'laporan/rekam_medis', 'fa fa-heartbeat', 2, 'aktif', 'laporan'),
(42, 'Laporan Farmasi', 'laporan-farmasi', 'laporan/farmasi', 'fa fa-plus-square', 3, 'aktif', 'laporan'),
(42, 'Laporan Laboratorium', 'laporan-laboratorium', 'laporan/laboratorium', 'fa fa-flask', 4, 'aktif', 'laporan'),
(42, 'Laporan Radiologi', 'laporan-radiologi', 'laporan/radiologi', 'fa fa-radiation', 5, 'aktif', 'laporan'),
(42, 'Laporan Inventory', 'laporan-inventory', 'laporan/inventory', 'fa fa-cubes', 6, 'aktif', 'laporan'),
(NULL, 'Pengaturan', 'pengaturan', '#', 'fa fa-cogs', 13, 'aktif', 'pengaturan'),
(49, 'Profil Klinik', 'pengaturan-klinik', 'pengaturan/klinik', 'fa fa-hospital-o', 1, 'aktif', 'pengaturan'),
(49, 'Pengguna', 'pengaturan-pengguna', 'pengaturan/pengguna', 'fa fa-users', 2, 'aktif', 'pengaturan'),
(49, 'Hak Akses', 'pengaturan-hak-akses', 'pengaturan/hak_akses', 'fa fa-key', 3, 'aktif', 'pengaturan'),
(49, 'Backup & Restore', 'pengaturan-backup', 'pengaturan/backup', 'fa fa-database', 4, 'aktif', 'pengaturan'),
(49, 'Log Aktivitas', 'pengaturan-log', 'pengaturan/log', 'fa fa-history', 5, 'aktif', 'pengaturan'),
(49, 'Parameter Sistem', 'pengaturan-parameter', 'pengaturan/parameter', 'fa fa-sliders', 6, 'aktif', 'pengaturan'); 
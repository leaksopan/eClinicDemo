-- --------------------------------------------------------
-- TABEL MODUL KEUANGAN
-- --------------------------------------------------------

-- Tabel Akun
CREATE TABLE `coa` (
  `id_akun` int(11) NOT NULL AUTO_INCREMENT,
  `kode_akun` varchar(20) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `kategori` enum('Aset','Kewajiban','Modal','Pendapatan','Beban') NOT NULL,
  `tipe` enum('Header','Detail') NOT NULL DEFAULT 'Detail',
  `parent_id` int(11) DEFAULT NULL,
  `saldo_normal` enum('Debit','Kredit') NOT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_akun`),
  UNIQUE KEY `kode_akun` (`kode_akun`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `coa_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `coa` (`id_akun`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Jurnal
CREATE TABLE `jurnal` (
  `id_jurnal` int(11) NOT NULL AUTO_INCREMENT,
  `no_jurnal` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe_jurnal` enum('JU','JK','JM','JP') NOT NULL COMMENT 'JU=Jurnal Umum, JK=Jurnal Kas, JM=Jurnal Memorial, JP=Jurnal Penyesuaian',
  `keterangan` text DEFAULT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `id_pengguna` int(11) NOT NULL,
  `id_referensi` int(11) DEFAULT NULL COMMENT 'ID referensi dari transaksi terkait',
  `tabel_referensi` varchar(50) DEFAULT NULL COMMENT 'Nama tabel referensi',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_jurnal`),
  UNIQUE KEY `no_jurnal` (`no_jurnal`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Jurnal
CREATE TABLE `jurnal_detail` (
  `id_jurnal_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurnal` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_jurnal_detail`),
  KEY `id_jurnal` (`id_jurnal`),
  KEY `id_akun` (`id_akun`),
  CONSTRAINT `jurnal_detail_ibfk_1` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal` (`id_jurnal`) ON DELETE CASCADE,
  CONSTRAINT `jurnal_detail_ibfk_2` FOREIGN KEY (`id_akun`) REFERENCES `coa` (`id_akun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Pendapatan
CREATE TABLE `pendapatan` (
  `id_pendapatan` int(11) NOT NULL AUTO_INCREMENT,
  `no_kwitansi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `id_akun` int(11) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `metode_pembayaran` enum('Tunai','Transfer','Kartu Kredit','Kartu Debit','BPJS','Asuransi','Lainnya') NOT NULL DEFAULT 'Tunai',
  `no_referensi` varchar(50) DEFAULT NULL COMMENT 'Nomor kartu/referensi bank/dll',
  `id_pengguna` int(11) NOT NULL,
  `id_referensi` int(11) DEFAULT NULL COMMENT 'ID referensi dari invoice/transaksi terkait',
  `tabel_referensi` varchar(50) DEFAULT NULL COMMENT 'Nama tabel referensi',
  `id_jurnal` int(11) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendapatan`),
  UNIQUE KEY `no_kwitansi` (`no_kwitansi`),
  KEY `id_akun` (`id_akun`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_jurnal` (`id_jurnal`),
  CONSTRAINT `pendapatan_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `coa` (`id_akun`),
  CONSTRAINT `pendapatan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `pendapatan_ibfk_3` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal` (`id_jurnal`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Pengeluaran
CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT,
  `no_kwitansi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `id_akun` int(11) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `metode_pembayaran` enum('Tunai','Transfer','Kartu Kredit','Kartu Debit','Cek','Giro','Lainnya') NOT NULL DEFAULT 'Tunai',
  `no_referensi` varchar(50) DEFAULT NULL COMMENT 'Nomor kartu/referensi bank/dll',
  `id_pengguna` int(11) NOT NULL,
  `id_referensi` int(11) DEFAULT NULL COMMENT 'ID referensi dari invoice/transaksi terkait',
  `tabel_referensi` varchar(50) DEFAULT NULL COMMENT 'Nama tabel referensi',
  `id_jurnal` int(11) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengeluaran`),
  UNIQUE KEY `no_kwitansi` (`no_kwitansi`),
  KEY `id_akun` (`id_akun`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_jurnal` (`id_jurnal`),
  CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `coa` (`id_akun`),
  CONSTRAINT `pengeluaran_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `pengeluaran_ibfk_3` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal` (`id_jurnal`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Kas
CREATE TABLE `kas` (
  `id_kas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kas` varchar(100) NOT NULL,
  `jenis_kas` enum('Kas','Bank') NOT NULL DEFAULT 'Kas',
  `id_akun` int(11) NOT NULL,
  `saldo` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kas`),
  KEY `id_akun` (`id_akun`),
  CONSTRAINT `kas_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `coa` (`id_akun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Mutasi Kas
CREATE TABLE `mutasi_kas` (
  `id_mutasi` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_kas_sumber` int(11) NOT NULL,
  `id_kas_tujuan` int(11) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_jurnal` int(11) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mutasi`),
  KEY `id_kas_sumber` (`id_kas_sumber`),
  KEY `id_kas_tujuan` (`id_kas_tujuan`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_jurnal` (`id_jurnal`),
  CONSTRAINT `mutasi_kas_ibfk_1` FOREIGN KEY (`id_kas_sumber`) REFERENCES `kas` (`id_kas`),
  CONSTRAINT `mutasi_kas_ibfk_2` FOREIGN KEY (`id_kas_tujuan`) REFERENCES `kas` (`id_kas`),
  CONSTRAINT `mutasi_kas_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `mutasi_kas_ibfk_4` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal` (`id_jurnal`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Periode Akuntansi
CREATE TABLE `periode_akuntansi` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('aktif','tutup_buku','diarsipkan') NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_periode`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `periode_akuntansi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Saldo Awal
CREATE TABLE `saldo_awal` (
  `id_saldo_awal` int(11) NOT NULL AUTO_INCREMENT,
  `id_periode` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_saldo_awal`),
  UNIQUE KEY `id_periode_akun` (`id_periode`,`id_akun`),
  KEY `id_akun` (`id_akun`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `saldo_awal_ibfk_1` FOREIGN KEY (`id_periode`) REFERENCES `periode_akuntansi` (`id_periode`),
  CONSTRAINT `saldo_awal_ibfk_2` FOREIGN KEY (`id_akun`) REFERENCES `coa` (`id_akun`),
  CONSTRAINT `saldo_awal_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Pajak
CREATE TABLE `pajak` (
  `id_pajak` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pajak` varchar(100) NOT NULL,
  `tipe` enum('PPN','PPh21','PPh23','Lainnya') NOT NULL,
  `persentase` decimal(5,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pajak`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk akun (COA)
INSERT INTO `coa` (`kode_akun`, `nama_akun`, `kategori`, `tipe`, `parent_id`, `saldo_normal`, `level`, `status`) VALUES
('1-0000', 'ASET', 'Aset', 'Header', NULL, 'Debit', 1, 'aktif'),
('1-1000', 'Aset Lancar', 'Aset', 'Header', 1, 'Debit', 2, 'aktif'),
('1-1100', 'Kas & Bank', 'Aset', 'Header', 2, 'Debit', 3, 'aktif'),
('1-1101', 'Kas Kecil', 'Aset', 'Detail', 3, 'Debit', 4, 'aktif'),
('1-1102', 'Kas Besar', 'Aset', 'Detail', 3, 'Debit', 4, 'aktif'),
('1-1103', 'Bank BCA', 'Aset', 'Detail', 3, 'Debit', 4, 'aktif'),
('1-1104', 'Bank Mandiri', 'Aset', 'Detail', 3, 'Debit', 4, 'aktif'),
('1-1200', 'Piutang', 'Aset', 'Header', 2, 'Debit', 3, 'aktif'),
('1-1201', 'Piutang Pasien', 'Aset', 'Detail', 8, 'Debit', 4, 'aktif'),
('1-1202', 'Piutang Karyawan', 'Aset', 'Detail', 8, 'Debit', 4, 'aktif'),
('1-1203', 'Piutang BPJS', 'Aset', 'Detail', 8, 'Debit', 4, 'aktif'),
('1-1204', 'Piutang Asuransi', 'Aset', 'Detail', 8, 'Debit', 4, 'aktif'),
('1-1300', 'Persediaan', 'Aset', 'Header', 2, 'Debit', 3, 'aktif'),
('1-1301', 'Persediaan Obat', 'Aset', 'Detail', 13, 'Debit', 4, 'aktif'),
('1-1302', 'Persediaan BHP', 'Aset', 'Detail', 13, 'Debit', 4, 'aktif'),
('1-1303', 'Persediaan Umum', 'Aset', 'Detail', 13, 'Debit', 4, 'aktif'),
('1-2000', 'Aset Tetap', 'Aset', 'Header', 1, 'Debit', 2, 'aktif'),
('1-2100', 'Tanah', 'Aset', 'Detail', 17, 'Debit', 3, 'aktif'),
('1-2200', 'Gedung', 'Aset', 'Header', 17, 'Debit', 3, 'aktif'),
('1-2201', 'Gedung - Nilai Perolehan', 'Aset', 'Detail', 19, 'Debit', 4, 'aktif'),
('1-2202', 'Gedung - Akumulasi Penyusutan', 'Aset', 'Detail', 19, 'Kredit', 4, 'aktif'),
('1-2300', 'Peralatan Medis', 'Aset', 'Header', 17, 'Debit', 3, 'aktif'),
('1-2301', 'Peralatan Medis - Nilai Perolehan', 'Aset', 'Detail', 22, 'Debit', 4, 'aktif'),
('1-2302', 'Peralatan Medis - Akumulasi Penyusutan', 'Aset', 'Detail', 22, 'Kredit', 4, 'aktif'),
('1-2400', 'Kendaraan', 'Aset', 'Header', 17, 'Debit', 3, 'aktif'),
('1-2401', 'Kendaraan - Nilai Perolehan', 'Aset', 'Detail', 25, 'Debit', 4, 'aktif'),
('1-2402', 'Kendaraan - Akumulasi Penyusutan', 'Aset', 'Detail', 25, 'Kredit', 4, 'aktif'),
('1-2500', 'Inventaris Kantor', 'Aset', 'Header', 17, 'Debit', 3, 'aktif'),
('1-2501', 'Inventaris Kantor - Nilai Perolehan', 'Aset', 'Detail', 28, 'Debit', 4, 'aktif'),
('1-2502', 'Inventaris Kantor - Akumulasi Penyusutan', 'Aset', 'Detail', 28, 'Kredit', 4, 'aktif'),
('2-0000', 'KEWAJIBAN', 'Kewajiban', 'Header', NULL, 'Kredit', 1, 'aktif'),
('2-1000', 'Kewajiban Jangka Pendek', 'Kewajiban', 'Header', 31, 'Kredit', 2, 'aktif'),
('2-1100', 'Hutang Usaha', 'Kewajiban', 'Detail', 32, 'Kredit', 3, 'aktif'),
('2-1200', 'Hutang Supplier', 'Kewajiban', 'Detail', 32, 'Kredit', 3, 'aktif'),
('2-1300', 'Hutang Pajak', 'Kewajiban', 'Detail', 32, 'Kredit', 3, 'aktif'),
('2-1400', 'Hutang Gaji', 'Kewajiban', 'Detail', 32, 'Kredit', 3, 'aktif'),
('2-2000', 'Kewajiban Jangka Panjang', 'Kewajiban', 'Header', 31, 'Kredit', 2, 'aktif'),
('2-2100', 'Hutang Bank', 'Kewajiban', 'Detail', 37, 'Kredit', 3, 'aktif'),
('3-0000', 'MODAL', 'Modal', 'Header', NULL, 'Kredit', 1, 'aktif'),
('3-1000', 'Modal Disetor', 'Modal', 'Detail', 39, 'Kredit', 2, 'aktif'),
('3-2000', 'Laba Ditahan', 'Modal', 'Detail', 39, 'Kredit', 2, 'aktif'),
('3-3000', 'Laba Tahun Berjalan', 'Modal', 'Detail', 39, 'Kredit', 2, 'aktif'),
('4-0000', 'PENDAPATAN', 'Pendapatan', 'Header', NULL, 'Kredit', 1, 'aktif'),
('4-1000', 'Pendapatan Operasional', 'Pendapatan', 'Header', 43, 'Kredit', 2, 'aktif'),
('4-1100', 'Pendapatan Rawat Jalan', 'Pendapatan', 'Header', 44, 'Kredit', 3, 'aktif'),
('4-1101', 'Pendapatan Konsultasi Dokter', 'Pendapatan', 'Detail', 45, 'Kredit', 4, 'aktif'),
('4-1102', 'Pendapatan Tindakan Medis', 'Pendapatan', 'Detail', 45, 'Kredit', 4, 'aktif'),
('4-1200', 'Pendapatan Rawat Inap', 'Pendapatan', 'Header', 44, 'Kredit', 3, 'aktif'),
('4-1201', 'Pendapatan Kamar', 'Pendapatan', 'Detail', 48, 'Kredit', 4, 'aktif'),
('4-1202', 'Pendapatan Visite Dokter', 'Pendapatan', 'Detail', 48, 'Kredit', 4, 'aktif'),
('4-1203', 'Pendapatan Tindakan Rawat Inap', 'Pendapatan', 'Detail', 48, 'Kredit', 4, 'aktif'),
('4-1300', 'Pendapatan Farmasi', 'Pendapatan', 'Detail', 44, 'Kredit', 3, 'aktif'),
('4-1400', 'Pendapatan Laboratorium', 'Pendapatan', 'Detail', 44, 'Kredit', 3, 'aktif'),
('4-1500', 'Pendapatan Radiologi', 'Pendapatan', 'Detail', 44, 'Kredit', 3, 'aktif'),
('4-2000', 'Pendapatan Non-Operasional', 'Pendapatan', 'Header', 43, 'Kredit', 2, 'aktif'),
('4-2100', 'Pendapatan Bunga Bank', 'Pendapatan', 'Detail', 55, 'Kredit', 3, 'aktif'),
('4-2200', 'Pendapatan Lain-lain', 'Pendapatan', 'Detail', 55, 'Kredit', 3, 'aktif'),
('5-0000', 'BEBAN', 'Beban', 'Header', NULL, 'Debit', 1, 'aktif'),
('5-1000', 'Beban Operasional', 'Beban', 'Header', 58, 'Debit', 2, 'aktif'),
('5-1100', 'Beban Gaji', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-1200', 'Beban Administrasi', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-1300', 'Beban Listrik & Air', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-1400', 'Beban Telepon & Internet', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-1500', 'Beban Pemeliharaan', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-1600', 'Beban Penyusutan', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-1700', 'Beban Operasional Lainnya', 'Beban', 'Detail', 59, 'Debit', 3, 'aktif'),
('5-2000', 'Beban Non-Operasional', 'Beban', 'Header', 58, 'Debit', 2, 'aktif'),
('5-2100', 'Beban Pajak', 'Beban', 'Detail', 67, 'Debit', 3, 'aktif'),
('5-2200', 'Beban Bunga Bank', 'Beban', 'Detail', 67, 'Debit', 3, 'aktif'),
('5-2300', 'Beban Lain-lain', 'Beban', 'Detail', 67, 'Debit', 3, 'aktif');

-- Data default untuk kas
INSERT INTO `kas` (`nama_kas`, `jenis_kas`, `id_akun`, `saldo`, `status`) VALUES
('Kas Kecil', 'Kas', 4, 0.00, 'aktif'),
('Kas Besar', 'Kas', 5, 0.00, 'aktif'),
('Bank BCA', 'Bank', 6, 0.00, 'aktif'),
('Bank Mandiri', 'Bank', 7, 0.00, 'aktif');

-- Data default untuk pajak
INSERT INTO `pajak` (`nama_pajak`, `tipe`, `persentase`, `status`) VALUES
('PPN 11%', 'PPN', 11.00, 'aktif'),
('PPh 21', 'PPh21', 5.00, 'aktif'),
('PPh 23', 'PPh23', 2.00, 'aktif'); 
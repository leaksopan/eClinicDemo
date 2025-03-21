  -- --------------------------------------------------------
  -- TABEL MODUL FARMASI
  -- --------------------------------------------------------

  -- Tabel Obat/Item
  CREATE TABLE `item` (
    `id_item` int(11) NOT NULL AUTO_INCREMENT,
    `kode_item` varchar(20) NOT NULL,
    `barcode` varchar(50) DEFAULT NULL,
    `nama_item` varchar(100) NOT NULL,
    `kategori` enum('Obat','Alat Kesehatan','ATK','Lainnya') NOT NULL DEFAULT 'Obat',
    `jenis` enum('Generik','Paten','Herbal','Alkes','Lainnya') DEFAULT NULL,
    `satuan` varchar(20) NOT NULL,
    `kemasan` varchar(50) DEFAULT NULL,
    `harga_beli` decimal(12,2) NOT NULL DEFAULT 0.00,
    `harga_jual` decimal(12,2) NOT NULL DEFAULT 0.00,
    `stok_minimal` int(11) DEFAULT 0,
    `keterangan` text DEFAULT NULL,
    `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    `gambar` varchar(255) DEFAULT NULL,
    `tipe_obat` enum('Bebas','Bebas Terbatas','Keras','Narkotika','Psikotropika') DEFAULT NULL,
    `golongan` varchar(50) DEFAULT NULL,
    `dosis_dewasa` varchar(100) DEFAULT NULL,
    `dosis_anak` varchar(100) DEFAULT NULL,
    `efek_samping` text DEFAULT NULL,
    `cara_pakai` varchar(255) DEFAULT NULL,
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_item`),
    UNIQUE KEY `kode_item` (`kode_item`),
    UNIQUE KEY `barcode` (`barcode`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Tabel Supplier
  CREATE TABLE `supplier` (
    `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
    `kode_supplier` varchar(20) NOT NULL,
    `nama_supplier` varchar(100) NOT NULL,
    `alamat` text DEFAULT NULL,
    `no_telp` varchar(15) DEFAULT NULL,
    `email` varchar(100) DEFAULT NULL,
    `pic` varchar(100) DEFAULT NULL,
    `npwp` varchar(30) DEFAULT NULL,
    `bank` varchar(50) DEFAULT NULL,
    `no_rekening` varchar(30) DEFAULT NULL,
    `atas_nama` varchar(100) DEFAULT NULL,
    `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    `keterangan` text DEFAULT NULL,
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_supplier`),
    UNIQUE KEY `kode_supplier` (`kode_supplier`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Tabel Stok
  CREATE TABLE `stok` (
    `id_stok` int(11) NOT NULL AUTO_INCREMENT,
    `id_item` int(11) NOT NULL,
    `id_gudang` int(11) NOT NULL DEFAULT 1,
    `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
    `batch` varchar(50) DEFAULT NULL,
    `expired_date` date DEFAULT NULL,
    `harga_beli` decimal(12,2) DEFAULT NULL,
    `harga_jual` decimal(12,2) DEFAULT NULL,
    `keterangan` text DEFAULT NULL,
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_stok`),
    UNIQUE KEY `id_item_id_gudang_batch` (`id_item`,`id_gudang`,`batch`),
    KEY `id_gudang` (`id_gudang`),
    CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Tabel Gudang
  CREATE TABLE `gudang` (
    `id_gudang` int(11) NOT NULL AUTO_INCREMENT,
    `kode_gudang` varchar(20) NOT NULL,
    `nama_gudang` varchar(100) NOT NULL,
    `lokasi` varchar(100) DEFAULT NULL,
    `keterangan` text DEFAULT NULL,
    `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_gudang`),
    UNIQUE KEY `kode_gudang` (`kode_gudang`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Tabel Antrian Farmasi
  CREATE TABLE `antrian_farmasi` (
    `id_antrian` int(11) NOT NULL AUTO_INCREMENT,
    `no_antrian` varchar(10) NOT NULL,
    `id_resep` int(11) NOT NULL,
    `id_pasien` int(11) NOT NULL,
    `tanggal_antrian` datetime NOT NULL,
    `status` enum('Menunggu','Diproses','Selesai','Batal') NOT NULL DEFAULT 'Menunggu',
    `catatan` text DEFAULT NULL,
    `estimasi_selesai` time DEFAULT NULL,
    `id_petugas` int(11) DEFAULT NULL,
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_antrian`),
    UNIQUE KEY `no_antrian` (`no_antrian`,`tanggal_antrian`),
    KEY `id_resep` (`id_resep`),
    KEY `id_pasien` (`id_pasien`),
    KEY `id_petugas` (`id_petugas`),
    CONSTRAINT `antrian_farmasi_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`),
    CONSTRAINT `antrian_farmasi_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
    CONSTRAINT `antrian_farmasi_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Tabel Penjualan (Kasir Farmasi)
  CREATE TABLE `penjualan` (
    `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
    `no_faktur` varchar(20) NOT NULL,
    `tanggal_penjualan` datetime NOT NULL,
    `id_pasien` int(11) DEFAULT NULL COMMENT 'Null untuk umum',
    `id_resep` int(11) DEFAULT NULL COMMENT 'Null untuk non-resep',
    `total_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
    `diskon` decimal(12,2) NOT NULL DEFAULT 0.00,
    `ppn` decimal(12,2) NOT NULL DEFAULT 0.00,
    `total_bayar` decimal(12,2) NOT NULL DEFAULT 0.00,
    `dibayar` decimal(12,2) NOT NULL DEFAULT 0.00,
    `kembali` decimal(12,2) NOT NULL DEFAULT 0.00,
    `cara_bayar` enum('Tunai','Debit','Kredit','Transfer','BPJS') NOT NULL DEFAULT 'Tunai',
    `status` enum('Lunas','Batal') NOT NULL DEFAULT 'Lunas',
    `keterangan` text DEFAULT NULL,
    `id_petugas` int(11) NOT NULL,
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_penjualan`),
    UNIQUE KEY `no_faktur` (`no_faktur`),
    KEY `id_pasien` (`id_pasien`),
    KEY `id_resep` (`id_resep`),
    KEY `id_petugas` (`id_petugas`),
    CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE SET NULL,
    CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`) ON DELETE SET NULL,
    CONSTRAINT `penjualan_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Tabel Detail Penjualan
  CREATE TABLE `detail_penjualan` (
    `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT,
    `id_penjualan` int(11) NOT NULL,
    `id_item` int(11) NOT NULL,
    `id_stok` int(11) DEFAULT NULL,
    `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
    `satuan` varchar(20) NOT NULL,
    `harga` decimal(12,2) NOT NULL DEFAULT 0.00,
    `diskon` decimal(12,2) NOT NULL DEFAULT 0.00,
    `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
    `aturan_pakai` text DEFAULT NULL,
    `keterangan` text DEFAULT NULL,
    `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_detail_penjualan`),
    KEY `id_penjualan` (`id_penjualan`),
    KEY `id_item` (`id_item`),
    KEY `id_stok` (`id_stok`),
    CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE,
    CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`),
    CONSTRAINT `detail_penjualan_ibfk_3` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`) ON DELETE SET NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Data default untuk gudang
  INSERT INTO `gudang` (`id_gudang`, `kode_gudang`, `nama_gudang`, `status`) VALUES
  (1, 'MAIN', 'Gudang Utama', 'aktif'),
  (2, 'PHARM', 'Gudang Farmasi', 'aktif');

  -- Data default untuk supplier
  INSERT INTO `supplier` (`kode_supplier`, `nama_supplier`, `status`) VALUES
  ('SUP001', 'PT Supplier Sejahtera', 'aktif'),
  ('SUP002', 'PT Kimia Farma', 'aktif');

  -- Data default untuk obat/item
  INSERT INTO `item` (`kode_item`, `nama_item`, `kategori`, `jenis`, `satuan`, `harga_beli`, `harga_jual`, `stok_minimal`, `status`) VALUES
  ('OBT001', 'Paracetamol 500mg', 'Obat', 'Generik', 'Tablet', 500.00, 1000.00, 100, 'aktif'),
  ('OBT002', 'Amoxicillin 500mg', 'Obat', 'Generik', 'Kapsul', 1500.00, 3000.00, 50, 'aktif'),
  ('OBT003', 'Antasida Suspension', 'Obat', 'Generik', 'Botol', 10000.00, 15000.00, 20, 'aktif'),
  ('OBT004', 'Asam Mefenamat 500mg', 'Obat', 'Generik', 'Tablet', 800.00, 1500.00, 50, 'aktif'),
  ('OBT005', 'Ranitidin 150mg', 'Obat', 'Generik', 'Tablet', 700.00, 1200.00, 50, 'aktif'),
  ('OBT006', 'Metformin 500mg', 'Obat', 'Generik', 'Tablet', 600.00, 1000.00, 50, 'aktif'),
  ('OBT007', 'Captopril 25mg', 'Obat', 'Generik', 'Tablet', 500.00, 1000.00, 50, 'aktif'),
  ('OBT008', 'Amlodipine 10mg', 'Obat', 'Generik', 'Tablet', 800.00, 1500.00, 50, 'aktif'),
  ('OBT009', 'Cetirizine 10mg', 'Obat', 'Generik', 'Tablet', 700.00, 1200.00, 50, 'aktif'),
  ('OBT010', 'Dexamethasone 0.5mg', 'Obat', 'Generik', 'Tablet', 500.00, 1000.00, 50, 'aktif'),
  ('AK001', 'Spuit 3cc', 'Alat Kesehatan', 'Alkes', 'Pcs', 3000.00, 5000.00, 30, 'aktif'),
  ('AK002', 'Masker Medis', 'Alat Kesehatan', 'Alkes', 'Box', 25000.00, 35000.00, 10, 'aktif'),
  ('AK003', 'Handscoon', 'Alat Kesehatan', 'Alkes', 'Box', 65000.00, 80000.00, 5, 'aktif'),
  ('AK004', 'Kassa Steril', 'Alat Kesehatan', 'Alkes', 'Pack', 10000.00, 15000.00, 20, 'aktif'); 
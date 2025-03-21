-- --------------------------------------------------------
-- TABEL MODUL INVENTARIS KLINIK
-- --------------------------------------------------------

-- Tabel Purchase Order
CREATE TABLE `purchase_order` (
  `id_po` int(11) NOT NULL AUTO_INCREMENT,
  `no_po` varchar(20) NOT NULL,
  `tanggal_po` date NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(15,2) NOT NULL DEFAULT 0.00,
  `ppn` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Draft','Disetujui','Dikirim','Diterima','Dibatalkan') NOT NULL DEFAULT 'Draft',
  `catatan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_pengsetuju` int(11) DEFAULT NULL COMMENT 'Petugas yang menyetujui PO',
  `tanggal_setuju` datetime DEFAULT NULL,
  `catatan_setuju` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_po`),
  UNIQUE KEY `no_po` (`no_po`),
  KEY `id_supplier` (`id_supplier`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_pengsetuju` (`id_pengsetuju`),
  CONSTRAINT `purchase_order_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  CONSTRAINT `purchase_order_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `purchase_order_ibfk_3` FOREIGN KEY (`id_pengsetuju`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Purchase Order
CREATE TABLE `po_detail` (
  `id_po_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_po` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL,
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_po_detail`),
  KEY `id_po` (`id_po`),
  KEY `id_item` (`id_item`),
  CONSTRAINT `po_detail_ibfk_1` FOREIGN KEY (`id_po`) REFERENCES `purchase_order` (`id_po`) ON DELETE CASCADE,
  CONSTRAINT `po_detail_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Penerimaan Barang
CREATE TABLE `penerimaan_barang` (
  `id_penerimaan` int(11) NOT NULL AUTO_INCREMENT,
  `no_penerimaan` varchar(20) NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `id_po` int(11) DEFAULT NULL COMMENT 'Null untuk penerimaan non-PO',
  `id_supplier` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `no_surat_jalan` varchar(50) DEFAULT NULL,
  `tanggal_faktur` date DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Draft','Diterima','Dibatalkan') NOT NULL DEFAULT 'Draft',
  `catatan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_penerimaan`),
  UNIQUE KEY `no_penerimaan` (`no_penerimaan`),
  KEY `id_po` (`id_po`),
  KEY `id_supplier` (`id_supplier`),
  KEY `id_gudang` (`id_gudang`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `penerimaan_barang_ibfk_1` FOREIGN KEY (`id_po`) REFERENCES `purchase_order` (`id_po`) ON DELETE SET NULL,
  CONSTRAINT `penerimaan_barang_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  CONSTRAINT `penerimaan_barang_ibfk_3` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  CONSTRAINT `penerimaan_barang_ibfk_4` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Penerimaan Barang
CREATE TABLE `penerimaan_detail` (
  `id_penerimaan_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_penerimaan` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_po_detail` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL,
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_diterima` decimal(10,2) NOT NULL DEFAULT 0.00,
  `batch` varchar(50) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_penerimaan_detail`),
  KEY `id_penerimaan` (`id_penerimaan`),
  KEY `id_item` (`id_item`),
  KEY `id_po_detail` (`id_po_detail`),
  CONSTRAINT `penerimaan_detail_ibfk_1` FOREIGN KEY (`id_penerimaan`) REFERENCES `penerimaan_barang` (`id_penerimaan`) ON DELETE CASCADE,
  CONSTRAINT `penerimaan_detail_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`),
  CONSTRAINT `penerimaan_detail_ibfk_3` FOREIGN KEY (`id_po_detail`) REFERENCES `po_detail` (`id_po_detail`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Retur Pembelian
CREATE TABLE `retur_pembelian` (
  `id_retur` int(11) NOT NULL AUTO_INCREMENT,
  `no_retur` varchar(20) NOT NULL,
  `tanggal_retur` date NOT NULL,
  `id_penerimaan` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Draft','Diproses','Selesai','Dibatalkan') NOT NULL DEFAULT 'Draft',
  `alasan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_retur`),
  UNIQUE KEY `no_retur` (`no_retur`),
  KEY `id_penerimaan` (`id_penerimaan`),
  KEY `id_supplier` (`id_supplier`),
  KEY `id_gudang` (`id_gudang`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `retur_pembelian_ibfk_1` FOREIGN KEY (`id_penerimaan`) REFERENCES `penerimaan_barang` (`id_penerimaan`),
  CONSTRAINT `retur_pembelian_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  CONSTRAINT `retur_pembelian_ibfk_3` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  CONSTRAINT `retur_pembelian_ibfk_4` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Retur Pembelian
CREATE TABLE `retur_detail` (
  `id_retur_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_retur` int(11) NOT NULL,
  `id_penerimaan_detail` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL,
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `batch` varchar(50) DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_retur_detail`),
  KEY `id_retur` (`id_retur`),
  KEY `id_penerimaan_detail` (`id_penerimaan_detail`),
  KEY `id_item` (`id_item`),
  CONSTRAINT `retur_detail_ibfk_1` FOREIGN KEY (`id_retur`) REFERENCES `retur_pembelian` (`id_retur`) ON DELETE CASCADE,
  CONSTRAINT `retur_detail_ibfk_2` FOREIGN KEY (`id_penerimaan_detail`) REFERENCES `penerimaan_detail` (`id_penerimaan_detail`),
  CONSTRAINT `retur_detail_ibfk_3` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Mutasi Barang
CREATE TABLE `mutasi_barang` (
  `id_mutasi` int(11) NOT NULL AUTO_INCREMENT,
  `no_mutasi` varchar(20) NOT NULL,
  `tanggal_mutasi` date NOT NULL,
  `id_gudang_asal` int(11) NOT NULL,
  `id_gudang_tujuan` int(11) NOT NULL,
  `status` enum('Draft','Diproses','Selesai','Dibatalkan') NOT NULL DEFAULT 'Draft',
  `catatan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_penerima` int(11) DEFAULT NULL COMMENT 'Petugas gudang tujuan',
  `tanggal_diterima` datetime DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mutasi`),
  UNIQUE KEY `no_mutasi` (`no_mutasi`),
  KEY `id_gudang_asal` (`id_gudang_asal`),
  KEY `id_gudang_tujuan` (`id_gudang_tujuan`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_penerima` (`id_penerima`),
  CONSTRAINT `mutasi_barang_ibfk_1` FOREIGN KEY (`id_gudang_asal`) REFERENCES `gudang` (`id_gudang`),
  CONSTRAINT `mutasi_barang_ibfk_2` FOREIGN KEY (`id_gudang_tujuan`) REFERENCES `gudang` (`id_gudang`),
  CONSTRAINT `mutasi_barang_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `mutasi_barang_ibfk_4` FOREIGN KEY (`id_penerima`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Mutasi Barang
CREATE TABLE `mutasi_detail` (
  `id_mutasi_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_mutasi` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_stok` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL,
  `batch` varchar(50) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mutasi_detail`),
  KEY `id_mutasi` (`id_mutasi`),
  KEY `id_item` (`id_item`),
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `mutasi_detail_ibfk_1` FOREIGN KEY (`id_mutasi`) REFERENCES `mutasi_barang` (`id_mutasi`) ON DELETE CASCADE,
  CONSTRAINT `mutasi_detail_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`),
  CONSTRAINT `mutasi_detail_ibfk_3` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Penyesuaian Stok
CREATE TABLE `stok_opname` (
  `id_stok_opname` int(11) NOT NULL AUTO_INCREMENT,
  `no_stok_opname` varchar(20) NOT NULL,
  `tanggal_stok_opname` date NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `status` enum('Draft','Selesai','Dibatalkan') NOT NULL DEFAULT 'Draft',
  `catatan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_stok_opname`),
  UNIQUE KEY `no_stok_opname` (`no_stok_opname`),
  KEY `id_gudang` (`id_gudang`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `stok_opname_ibfk_1` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  CONSTRAINT `stok_opname_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Penyesuaian Stok
CREATE TABLE `stok_opname_detail` (
  `id_stok_opname_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_stok_opname` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_stok` int(11) DEFAULT NULL,
  `stok_sistem` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stok_fisik` decimal(10,2) NOT NULL DEFAULT 0.00,
  `selisih` decimal(10,2) NOT NULL DEFAULT 0.00,
  `batch` varchar(50) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_stok_opname_detail`),
  KEY `id_stok_opname` (`id_stok_opname`),
  KEY `id_item` (`id_item`),
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `stok_opname_detail_ibfk_1` FOREIGN KEY (`id_stok_opname`) REFERENCES `stok_opname` (`id_stok_opname`) ON DELETE CASCADE,
  CONSTRAINT `stok_opname_detail_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`),
  CONSTRAINT `stok_opname_detail_ibfk_3` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Waste / Barang Rusak
CREATE TABLE `waste` (
  `id_waste` int(11) NOT NULL AUTO_INCREMENT,
  `no_waste` varchar(20) NOT NULL,
  `tanggal_waste` date NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `alasan` text DEFAULT NULL,
  `status` enum('Draft','Diproses','Selesai','Dibatalkan') NOT NULL DEFAULT 'Draft',
  `id_pengguna` int(11) NOT NULL,
  `id_pengsetuju` int(11) DEFAULT NULL COMMENT 'Petugas yang menyetujui pemusnahan',
  `tanggal_setuju` datetime DEFAULT NULL,
  `catatan_setuju` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_waste`),
  UNIQUE KEY `no_waste` (`no_waste`),
  KEY `id_gudang` (`id_gudang`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_pengsetuju` (`id_pengsetuju`),
  CONSTRAINT `waste_ibfk_1` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  CONSTRAINT `waste_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  CONSTRAINT `waste_ibfk_3` FOREIGN KEY (`id_pengsetuju`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Waste
CREATE TABLE `waste_detail` (
  `id_waste_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_waste` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_stok` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL,
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `batch` varchar(50) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_waste_detail`),
  KEY `id_waste` (`id_waste`),
  KEY `id_item` (`id_item`),
  KEY `id_stok` (`id_stok`),
  CONSTRAINT `waste_detail_ibfk_1` FOREIGN KEY (`id_waste`) REFERENCES `waste` (`id_waste`) ON DELETE CASCADE,
  CONSTRAINT `waste_detail_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`),
  CONSTRAINT `waste_detail_ibfk_3` FOREIGN KEY (`id_stok`) REFERENCES `stok` (`id_stok`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Kartu Stok
CREATE TABLE `kartu_stok` (
  `id_kartu_stok` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` datetime NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `tipe_transaksi` enum('Penerimaan','Penjualan','Resep','Retur','Mutasi Masuk','Mutasi Keluar','Penyesuaian','Waste') NOT NULL,
  `id_referensi` int(11) NOT NULL COMMENT 'ID transaksi terkait',
  `referensi` varchar(50) NOT NULL COMMENT 'Nomor transaksi terkait',
  `batch` varchar(50) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `stok_awal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `masuk` decimal(10,2) NOT NULL DEFAULT 0.00,
  `keluar` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stok_akhir` decimal(10,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kartu_stok`),
  KEY `id_item` (`id_item`),
  KEY `id_gudang` (`id_gudang`),
  CONSTRAINT `kartu_stok_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`),
  CONSTRAINT `kartu_stok_ibfk_2` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
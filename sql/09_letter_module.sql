-- --------------------------------------------------------
-- TABEL MODUL CETAK SURAT
-- --------------------------------------------------------

-- Tabel Cetak Surat
CREATE TABLE `cetak_surat` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(50) NOT NULL,
  `kode_template` varchar(20) NOT NULL COMMENT 'Kode template yang tersimpan di aplikasi',
  `tanggal_surat` date NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_rekam_medis` int(11) DEFAULT NULL,
  `parameter_surat` text NOT NULL COMMENT 'Parameter JSON untuk isi surat',
  `isi_surat_final` text NOT NULL COMMENT 'Hasil render final surat',
  `tanggal_mulai` date DEFAULT NULL COMMENT 'Tanggal mulai sakit/istirahat',
  `tanggal_selesai` date DEFAULT NULL COMMENT 'Tanggal selesai sakit/istirahat',
  `lama_waktu` int(11) DEFAULT NULL COMMENT 'Lama waktu dalam hari',
  `diagnosa` text DEFAULT NULL,
  `tujuan` varchar(255) DEFAULT NULL COMMENT 'Tujuan surat/rujukan',
  `keterangan` text DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_surat`),
  UNIQUE KEY `no_surat` (`no_surat`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `cetak_surat_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `cetak_surat_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `cetak_surat_ibfk_3` FOREIGN KEY (`id_rekam_medis`) REFERENCES `rekam_medis` (`id_rekam_medis`) ON DELETE SET NULL,
  CONSTRAINT `cetak_surat_ibfk_4` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
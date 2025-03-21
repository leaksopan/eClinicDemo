<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Konfigurasi template surat
 * 
 * Berisi daftar kode template surat dan informasi detailnya
 * Template surat disimpan dalam kode PHP di folder application/templates/surat/
 */
$config['surat_templates'] = [
    'SKS-01' => [
        'kode' => 'SKS-01',
        'jenis' => 'Surat Sehat',
        'nama' => 'Surat Keterangan Sehat Umum',
        'file' => 'surat/SKS-01.php',
        'ttd_dokter' => true,
        'ttd_direktur' => false,
        'kop_surat' => true,
        'status' => 'aktif',
        'placeholder' => [
            "no_surat" => "Nomor Surat",
            "nama_klinik" => "Nama Klinik",
            "nama_pasien" => "Nama Pasien",
            "tempat_lahir" => "Tempat Lahir",
            "tanggal_lahir" => "Tanggal Lahir",
            "jenis_kelamin" => "Jenis Kelamin",
            "alamat_pasien" => "Alamat Pasien",
            "tanggal_periksa" => "Tanggal Pemeriksaan",
            "tujuan" => "Tujuan Surat",
            "kota" => "Kota",
            "tanggal_surat" => "Tanggal Surat",
            "nama_dokter" => "Nama Dokter",
            "sip_dokter" => "Nomor SIP Dokter",
            "kop_surat" => "Kop Surat",
            "alamat_klinik" => "Alamat Klinik",
            "telp_klinik" => "Telepon Klinik",
            "email_klinik" => "Email Klinik"
        ]
    ],
    'SKI-01' => [
        'kode' => 'SKI-01',
        'jenis' => 'Surat Sakit',
        'nama' => 'Surat Keterangan Sakit',
        'file' => 'surat/SKI-01.php',
        'ttd_dokter' => true,
        'ttd_direktur' => false,
        'kop_surat' => true,
        'status' => 'aktif',
        'placeholder' => [
            "no_surat" => "Nomor Surat",
            "nama_klinik" => "Nama Klinik", 
            "nama_pasien" => "Nama Pasien",
            "tempat_lahir" => "Tempat Lahir",
            "tanggal_lahir" => "Tanggal Lahir",
            "jenis_kelamin" => "Jenis Kelamin",
            "alamat_pasien" => "Alamat Pasien",
            "tanggal_periksa" => "Tanggal Pemeriksaan",
            "lama_waktu" => "Lama Waktu Istirahat",
            "tanggal_mulai" => "Tanggal Mulai Istirahat",
            "tanggal_selesai" => "Tanggal Selesai Istirahat",
            "diagnosa" => "Diagnosa",
            "kota" => "Kota",
            "tanggal_surat" => "Tanggal Surat",
            "nama_dokter" => "Nama Dokter",
            "sip_dokter" => "Nomor SIP Dokter",
            "kop_surat" => "Kop Surat",
            "alamat_klinik" => "Alamat Klinik",
            "telp_klinik" => "Telepon Klinik",
            "email_klinik" => "Email Klinik"
        ]
    ],
    'SRJ-01' => [
        'kode' => 'SRJ-01',
        'jenis' => 'Surat Rujukan',
        'nama' => 'Surat Rujukan Umum',
        'file' => 'surat/SRJ-01.php',
        'ttd_dokter' => true,
        'ttd_direktur' => false,
        'kop_surat' => true,
        'status' => 'aktif',
        'placeholder' => [
            "no_surat" => "Nomor Surat",
            "tujuan" => "Tujuan Rujukan",
            "nama_pasien" => "Nama Pasien",
            "tempat_lahir" => "Tempat Lahir",
            "tanggal_lahir" => "Tanggal Lahir",
            "jenis_kelamin" => "Jenis Kelamin",
            "alamat_pasien" => "Alamat Pasien",
            "no_rm" => "Nomor Rekam Medis",
            "hasil_pemeriksaan" => "Hasil Pemeriksaan",
            "diagnosa" => "Diagnosa",
            "tindakan_pengobatan" => "Tindakan/Pengobatan",
            "kota" => "Kota",
            "tanggal_surat" => "Tanggal Surat",
            "nama_dokter" => "Nama Dokter",
            "sip_dokter" => "Nomor SIP Dokter",
            "kop_surat" => "Kop Surat",
            "alamat_klinik" => "Alamat Klinik",
            "telp_klinik" => "Telepon Klinik",
            "email_klinik" => "Email Klinik"
        ]
    ]
]; 
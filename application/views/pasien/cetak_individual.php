<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - <?= $pasien->nama_lengkap ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
        }
        .title h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
        }
        table.data th, table.data td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        table.data th {
            background-color: #f5f5f5;
            text-align: left;
        }
        .photo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .photo-container img {
            max-width: 150px;
            border: 1px solid #ddd;
            padding: 3px;
        }
        .section-title {
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 5px;
            margin: 10px 0;
            border-left: 4px solid #4e73df;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print mb-3">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
            <a href="<?= base_url('pasien/lihat/' . $pasien->id_pasien) ?>" class="btn btn-warning btn-sm">Kembali</a>
        </div>
        
        <div class="header">
            <h2>e-CLINIC MANAGEMENT SYSTEM</h2>
            <p>Jl. Contoh No. 123, Kota, Indonesia</p>
            <p>Telp: 021-12345678 | Email: info@eclinic.com</p>
        </div>
        
        <div class="title">
            <h3>Data Pasien</h3>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="section-title">Informasi Pasien</div>
                <table class="data">
                    <tr>
                        <th width="30%">Nomor Rekam Medis</th>
                        <td width="70%"><?= $pasien->no_rm ?></td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><?= $pasien->nama_lengkap ?></td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td><?= $pasien->tempat_lahir ?>, <?= date('d F Y', strtotime($pasien->tanggal_lahir)) ?></td>
                    </tr>
                    <tr>
                        <th>Umur</th>
                        <td>
                            <?php
                            $tgl_lahir = new DateTime($pasien->tanggal_lahir);
                            $today = new DateTime('today');
                            $usia = $tgl_lahir->diff($today)->y;
                            echo $usia . ' tahun';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?= $pasien->jenis_kelamin ?></td>
                    </tr>
                    <tr>
                        <th>Golongan Darah</th>
                        <td><?= $pasien->golongan_darah ?> <?= $pasien->rhesus != 'Tidak Tahu' ? $pasien->rhesus : '' ?></td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td><?= $pasien->agama ?: '-' ?></td>
                    </tr>
                    <tr>
                        <th>Status Pernikahan</th>
                        <td><?= $pasien->status_pernikahan ?: '-' ?></td>
                    </tr>
                    <tr>
                        <th>Pendidikan</th>
                        <td><?= $pasien->pendidikan ?: '-' ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td><?= $pasien->pekerjaan ?: '-' ?></td>
                    </tr>
                    <tr>
                        <th>Identitas</th>
                        <td><?= $pasien->jenis_identitas ?> - <?= $pasien->no_identitas ?: '-' ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <div class="photo-container">
                    <?php if (!empty($pasien->foto) && file_exists($pasien->foto)) : ?>
                        <img src="<?= base_url($pasien->foto) ?>" alt="Foto Pasien">
                    <?php else : ?>
                        <img src="<?= base_url('assets/img/no-photo.jpg') ?>" alt="No Photo">
                    <?php endif; ?>
                    <div class="mt-2"><strong>Terdaftar: </strong><?= date('d F Y', strtotime($pasien->dibuat_pada)) ?></div>
                </div>
            </div>
        </div>
        
        <div class="section-title">Informasi Kontak</div>
        <table class="data">
            <tr>
                <th width="30%">Alamat</th>
                <td width="70%"><?= $pasien->alamat ?></td>
            </tr>
            <tr>
                <th>Kelurahan / Kecamatan</th>
                <td><?= $pasien->kelurahan ?: '-' ?> / <?= $pasien->kecamatan ?: '-' ?></td>
            </tr>
            <tr>
                <th>Kota / Provinsi</th>
                <td><?= $pasien->kota ?: '-' ?> / <?= $pasien->provinsi ?: '-' ?></td>
            </tr>
            <tr>
                <th>Kode Pos</th>
                <td><?= $pasien->kode_pos ?: '-' ?></td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td><?= $pasien->no_telp ?></td>
            </tr>
        </table>
        
        <div class="section-title">Kontak Darurat</div>
        <table class="data">
            <tr>
                <th width="30%">Nama Keluarga</th>
                <td width="70%"><?= $pasien->nama_keluarga ?: '-' ?></td>
            </tr>
            <tr>
                <th>Hubungan</th>
                <td><?= $pasien->hubungan_keluarga ?: '-' ?></td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td><?= $pasien->telp_keluarga ?: '-' ?></td>
            </tr>
        </table>
        
        <div class="section-title">Catatan Medis</div>
        <table class="data">
            <tr>
                <th width="30%">Alergi</th>
                <td width="70%"><?= $pasien->alergi ?: '-' ?></td>
            </tr>
            <tr>
                <th>Catatan Khusus</th>
                <td><?= $pasien->catatan_khusus ?: '-' ?></td>
            </tr>
        </table>
        
        <div class="footer">
            <div>Dicetak pada: <?= date('d F Y H:i:s') ?></div>
            <div>Oleh: Administrator</div>
        </div>
    </div>
</body>
</html> 
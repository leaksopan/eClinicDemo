<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pasien - <?= $pasien->nama_lengkap ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .patient-card {
            width: 85.6mm;
            height: 53.98mm;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 0 auto;
            position: relative;
            color: #333;
        }
        .card-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 20px;
            margin-right: 5px;
        }
        .card-body {
            padding: 10px 15px;
            display: flex;
        }
        .qr-code {
            margin-right: 10px;
        }
        .qr-code img {
            width: 70px;
            height: 70px;
            border: 1px solid #ddd;
        }
        .photo-container {
            margin-right: 10px;
            border: 1px solid #ddd;
            width: 70px;
            height: 70px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .photo-container img {
            max-width: 100%;
            max-height: 100%;
        }
        .patient-info {
            flex-grow: 1;
            font-size: 12px;
        }
        .patient-info table {
            width: 100%;
        }
        .patient-info td {
            padding: 1px 0;
            vertical-align: top;
        }
        .patient-info td:first-child {
            width: 30%;
        }
        .mr-rm {
            font-weight: bold;
            font-size: 14px;
            color: #4e73df;
            margin-bottom: 5px;
        }
        .card-footer {
            background: #f8f9fa;
            padding: 5px 15px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .registration-date {
            text-align: right;
            font-size: 10px;
            padding: 0 15px 5px;
            color: #666;
        }
        .address-line {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 180px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: none;
            }
            .no-print {
                display: none;
            }
            .patient-card {
                box-shadow: none;
                border: 1px solid #ddd;
                margin: 0;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print mb-3">
            <div class="btn-group mb-3">
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Cetak Kartu
                </button>
                <a href="<?= base_url('pasien/lihat/' . $pasien->id_pasien) ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="patient-card">
            <div class="card-header">
                <div class="logo-text">
                    <h4>E-CLINIC</h4>
                    <div>Kartu Identitas Pasien</div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="photo-container">
                    <?php if (!empty($pasien->foto) && file_exists($pasien->foto)) : ?>
                        <img src="<?= base_url($pasien->foto) ?>" alt="Foto Pasien">
                    <?php else : ?>
                        <img src="<?= base_url('assets/img/no-photo.jpg') ?>" alt="No Photo" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'70\' height=\'70\'%3E%3Crect width=\'70\' height=\'70\' fill=\'%23cccccc\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'18\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial\' fill=\'%23ffffff\'%3E?%3C/text%3E%3C/svg%3E';">
                    <?php endif; ?>
                </div>
                <div class="patient-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-center">
                            <strong class="d-block"><?= $pasien->no_rm ?></strong>
                            <small>No. RM</small>
                        </div>
                        <div class="text-center">
                            <strong class="d-block"><?= $pasien->nama_lengkap ?></strong>
                            <small>Nama Pasien</small>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td>Tgl Lahir</td>
                            <td>: <?= date('d-m-Y', strtotime($pasien->tanggal_lahir)) ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>: <?= $pasien->jenis_kelamin ?></td>
                        </tr>
                        <tr>
                            <td>Gol. Darah</td>
                            <td>: <?= $pasien->golongan_darah ?> <?= $pasien->rhesus != 'Tidak Tahu' ? $pasien->rhesus : '' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="registration-date">
                <div>Telp: <?= $pasien->no_telp ?: '-' ?></div>
                <div class="address-line"><?= $pasien->alamat ?></div>
            </div>
            
            <div class="card-footer">
                <div>Kartu ini adalah identitas pasien e-Clinic. Mohon dibawa saat berobat.</div>
                <div>Terdaftar: <?= date('d-m-Y', strtotime($pasien->dibuat_pada)) ?></div>
            </div>
        </div>
    </div>
</body>
</html> 
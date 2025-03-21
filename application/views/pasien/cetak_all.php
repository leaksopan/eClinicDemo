<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien - e-Clinic</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
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
            margin-bottom: 20px;
            font-size: 11px;
        }
        table.data th, table.data td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        table.data th {
            background-color: #f5f5f5;
            text-align: center;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .page-number {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-top: 10px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 15px;
            }
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="no-print mb-3">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
            <a href="<?= base_url('pasien') ?>" class="btn btn-warning btn-sm">Kembali</a>
        </div>
        
        <div class="header">
            <h2>e-CLINIC MANAGEMENT SYSTEM</h2>
            <p>Jl. Contoh No. 123, Kota, Indonesia</p>
            <p>Telp: 021-12345678 | Email: info@eclinic.com</p>
        </div>
        
        <div class="title">
            <h3>Daftar Pasien Terdaftar</h3>
            <p>Tanggal: <?= date('d F Y') ?></p>
        </div>
        
        <table class="data">
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="10%">No. RM</th>
                    <th width="20%">Nama Pasien</th>
                    <th width="10%">Tgl Lahir</th>
                    <th width="5%">L/P</th>
                    <th width="12%">No. Telepon</th>
                    <th width="25%">Alamat</th>
                    <th width="15%">Tgl Daftar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pasien)) : ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pasien</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($pasien as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $row->no_rm ?></td>
                            <td><?= $row->nama_pasien ?></td>
                            <td><?= date('d-m-Y', strtotime($row->tanggal_lahir)) ?></td>
                            <td class="text-center"><?= substr($row->jenis_kelamin, 0, 1) ?></td>
                            <td><?= $row->no_telp ?></td>
                            <td><?= $row->alamat ?></td>
                            <td><?= date('d-m-Y', strtotime($row->tanggal_daftar)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="8" class="text-right">Total Pasien: <?= count($pasien) ?> orang</th>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="text-center" style="margin-top: 30px;">
                    <p>
                        Kota, <?= date('d F Y') ?><br>
                        Administrator
                        <br><br><br><br>
                        _______________________<br>
                        NIP.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div>Dicetak pada: <?= date('d F Y H:i:s') ?></div>
            <div>Oleh: Administrator</div>
        </div>
        
        <div class="page-number">
            Halaman 1
        </div>
    </div>
</body>
</html> 
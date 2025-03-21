<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistik Pasien</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('pasien') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <i class="fas fa-users fa-5x"></i>
                                        </div>
                                        <div class="col-8 text-right">
                                            <h1><?= $total_pasien ?></h1>
                                            <div>Total Pasien</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <i class="fas fa-male fa-5x"></i>
                                        </div>
                                        <div class="col-8 text-right">
                                            <h1><?= isset($jenis_kelamin['Laki-laki']) ? $jenis_kelamin['Laki-laki'] : 0 ?></h1>
                                            <div>Pasien Laki-laki</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <i class="fas fa-female fa-5x"></i>
                                        </div>
                                        <div class="col-8 text-right">
                                            <h1><?= isset($jenis_kelamin['Perempuan']) ? $jenis_kelamin['Perempuan'] : 0 ?></h1>
                                            <div>Pasien Perempuan</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Distribusi Jenis Kelamin</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="chartJenisKelamin" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Distribusi Usia Pasien</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="chartUsia" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Statistik Pasien Berdasarkan Usia</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kelompok Usia</th>
                                                <th>Jumlah</th>
                                                <th>Persentase</th>
                                                <th>Grafik</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($usia) && !empty($usia)) {
                                                foreach ($usia as $kelompok => $jumlah) {
                                                    $persentase = ($jumlah / $total_pasien) * 100;
                                                    ?>
                                                    <tr>
                                                        <td><?= $kelompok ?></td>
                                                        <td><?= $jumlah ?> orang</td>
                                                        <td><?= number_format($persentase, 2) ?>%</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= $persentase ?>%" aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="4" class="text-center">Data tidak tersedia</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-right">
                            <a href="<?= base_url('pasien/cetak') ?>" class="btn btn-primary" target="_blank">
                                <i class="fas fa-print"></i> Cetak Laporan Pasien
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Data untuk chart jenis kelamin
        var dataJenisKelamin = {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    <?= isset($jenis_kelamin['Laki-laki']) ? $jenis_kelamin['Laki-laki'] : 0 ?>,
                    <?= isset($jenis_kelamin['Perempuan']) ? $jenis_kelamin['Perempuan'] : 0 ?>
                ],
                backgroundColor: [
                    '#28a745',
                    '#dc3545'
                ],
                hoverBackgroundColor: [
                    '#218838',
                    '#c82333'
                ]
            }]
        };

        // Data untuk chart usia
        var labels = [];
        var data = [];
        var backgroundColors = [];

        <?php
        if (isset($usia) && !empty($usia)) {
            $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1', '#fd7e14', '#20c9a6'];
            $i = 0;
            foreach ($usia as $kelompok => $jumlah) {
                $color = $colors[$i % count($colors)];
                echo "labels.push('$kelompok');";
                echo "data.push($jumlah);";
                echo "backgroundColors.push('$color');";
                $i++;
            }
        }
        ?>

        var dataUsia = {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
                hoverBackgroundColor: backgroundColors
            }]
        };

        // Chart jenis kelamin
        var ctxJenisKelamin = document.getElementById('chartJenisKelamin').getContext('2d');
        var chartJenisKelamin = new Chart(ctxJenisKelamin, {
            type: 'pie',
            data: dataJenisKelamin,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.raw || 0;
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = Math.round((value / total) * 100);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Chart usia
        var ctxUsia = document.getElementById('chartUsia').getContext('2d');
        var chartUsia = new Chart(ctxUsia, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: data,
                    backgroundColor: '#4e73df',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>

<?php $this->load->view('templates/footer'); ?> 
<?php $this->load->view('templates/header', ['title' => 'Statistik Dokter']); ?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2"></i> Statistik Dokter
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Tombol Kembali -->
                    <div class="mb-4">
                        <a href="<?= base_url('dokter') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                    
                    <!-- Kartu Statistik -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Dokter</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_dokter ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Dokter Aktif</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dokter_aktif ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Dokter Cuti</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dokter_cuti ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Dokter Tidak Aktif</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dokter_tidak_aktif ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chart Dokter -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Dokter</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="chartStatusDokter"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Aktif
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-warning"></i> Cuti
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-danger"></i> Tidak Aktif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <p><i class="fas fa-info-circle mr-1"></i> Informasi statistik dokter akan terus diperbarui sesuai dengan perubahan data dokter.</p>
                                    </div>
                                    <p>Statistik ini memberikan gambaran tentang jumlah dan status dokter yang terdaftar di sistem. Untuk informasi lebih detail tentang masing-masing dokter, silakan kembali ke halaman daftar dokter.</p>
                                    <p>Anda dapat menggunakan informasi ini untuk memantau ketersediaan dokter dan perencanaan penjadwalan di klinik.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Pie Chart Status Dokter
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("chartStatusDokter");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Aktif", "Cuti", "Tidak Aktif"],
            datasets: [{
                data: [<?= $dokter_aktif ?>, <?= $dokter_cuti ?>, <?= $dokter_tidak_aktif ?>],
                backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#17a673', '#e0ae1a', '#d32f2f'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
});
</script>

<?php $this->load->view('templates/footer'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Modul Klinik</h1>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Content Row -->
    <div class="row">
        <!-- Poliklinik Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Poliklinik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_poli ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hospital fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('klinik/poli') ?>" class="card-footer bg-primary text-white text-center">
                    <span>Kelola Poliklinik</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Dokter Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dokter</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_dokter ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('dokter') ?>" class="card-footer bg-success text-white text-center">
                    <span>Kelola Dokter</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Jadwal Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jadwal Dokter</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_jadwal ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('jadwal') ?>" class="card-footer bg-info text-white text-center">
                    <span>Kelola Jadwal</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Ruangan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Ruang Inap</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bed fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('klinik/ruangan') ?>" class="card-footer bg-warning text-white text-center">
                    <span>Kelola Ruangan</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Dokter Hari Ini</h6>
                    <a href="<?= base_url('jadwal') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-calendar"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <!-- Debug info -->
                    <?php if(isset($debug_hari) || isset($debug_jumlah_jadwal)): ?>
                    <div class="alert alert-info">
                        <p>Hari ini: <?= $debug_hari ?? 'tidak diketahui' ?></p>
                        <p>Jumlah jadwal hari ini: <?= $debug_jumlah_jadwal ?? '0' ?></p>
                        <?php if(isset($debug_jadwal_aktif)): ?>
                        <p>Total jadwal aktif: <?= $debug_jadwal_aktif ?></p>
                        <?php endif; ?> 
                        <?php if(empty($jadwal_hari_ini)): ?>
                        <p><strong>Catatan:</strong> Jadwal untuk hari ini tidak ditemukan. Menampilkan jadwal terdekat berikutnya.</p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Dokter</th>
                                    <th>Poli</th>
                                    <th>Hari</th>
                                    <th>Jam Praktik</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($jadwal_hari_ini)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada jadwal dokter hari ini</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach($jadwal_hari_ini as $jadwal): ?>
                                    <tr>
                                        <td><?= $jadwal->nama_dokter ?></td>
                                        <td><?= $jadwal->nama_poli ?></td>
                                        <td><?= $jadwal->hari ?></td>
                                        <td><?= substr($jadwal->jam_mulai, 0, 5) ?> - <?= substr($jadwal->jam_selesai, 0, 5) ?></td>
                                        <td>
                                            <?php if($jadwal->status == 'aktif'): ?>
                                                <span class="badge badge-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Ruang Inap</h6>
                    <a href="<?= base_url('klinik/ruangan') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-bed"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ruangan</th>
                                    <th>Kelas</th>
                                    <th>Kapasitas</th>
                                    <th>Terisi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data ruangan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<?php $this->load->view('templates/header', ['title' => 'Detail Dokter']); ?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md mr-2"></i> Detail Dokter
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Tombol Aksi -->
                    <div class="mb-3">
                        <a href="<?= base_url('dokter') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <a href="<?= base_url('dokter/edit/'.$dokter->id_dokter) ?>" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="<?= base_url('dokter/jadwal/'.$dokter->id_dokter) ?>" class="btn btn-info">
                            <i class="fas fa-calendar-alt mr-1"></i> Jadwal Praktek
                        </a>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Informasi Dokter</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th width="35%">Nama Lengkap</th>
                                            <td width="65%">
                                                <?php 
                                                    $nama_lengkap = '';
                                                    if (!empty($dokter->gelar_depan)) {
                                                        $nama_lengkap .= $dokter->gelar_depan . ' ';
                                                    }
                                                    $nama_lengkap .= $dokter->nama_lengkap;
                                                    if (!empty($dokter->gelar_belakang)) {
                                                        $nama_lengkap .= ', ' . $dokter->gelar_belakang;
                                                    }
                                                    echo $nama_lengkap;
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?= $dokter->email ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon</th>
                                            <td><?= $dokter->no_telp ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>SIP</th>
                                            <td><?= $dokter->sip ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Spesialis</th>
                                            <td><?= $dokter->spesialis ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status Praktek</th>
                                            <td>
                                                <?php if($dokter->status_praktek == 'Aktif'): ?>
                                                    <span class="badge badge-success">Aktif</span>
                                                <?php elseif($dokter->status_praktek == 'Cuti'): ?>
                                                    <span class="badge badge-warning">Cuti</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Informasi Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th width="35%">Tarif Konsultasi</th>
                                            <td width="65%">Rp <?= number_format($dokter->tarif_konsultasi, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Komisi</th>
                                            <td><?= $dokter->komisi_persen ?? '0' ?>%</td>
                                        </tr>
                                        <tr>
                                            <th>Jatah Pasien</th>
                                            <td><?= $dokter->jatah_pasien ?? '0' ?> pasien/hari</td>
                                        </tr>
                                        <tr>
                                            <th>Alumni</th>
                                            <td><?= $dokter->alumni ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tahun Lulus</th>
                                            <td><?= $dokter->tahun_lulus ?? '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mulai Praktek</th>
                                            <td><?= $dokter->mulai_praktek ? date('d-m-Y', strtotime($dokter->mulai_praktek)) : '-' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Jadwal Praktek -->
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Jadwal Praktek Dokter</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <a href="<?= base_url('dokter/tambah_jadwal/'.$dokter->id_dokter) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus-circle"></i> Tambah Jadwal
                                </a>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Hari</th>
                                            <th>Jam Praktek</th>
                                            <th>Poliklinik</th>
                                            <th>Kuota</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($jadwal)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada jadwal praktek</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $no = 1; foreach($jadwal as $j): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $j->hari ?></td>
                                                    <td><?= $j->jam_mulai ?> - <?= $j->jam_selesai ?></td>
                                                    <td><?= $j->nama_poli ?> (<?= $j->lokasi ?>)</td>
                                                    <td><?= isset($j->kuota_pasien) ? $j->kuota_pasien : '0' ?> pasien</td>
                                                    <td>
                                                        <?php if($j->status == 'aktif'): ?>
                                                            <span class="badge badge-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">Tidak Aktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('dokter/edit_jadwal/'.$j->id_jadwal) ?>" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" onclick="konfirmasiHapus('<?= base_url('dokter/hapus_jadwal/'.$j->id_jadwal) ?>')" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKonfirmasiLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus jadwal ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="btnHapus" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
function konfirmasiHapus(url) {
    $('#btnHapus').attr('href', url);
    $('#modalKonfirmasi').modal('show');
}
</script>

<?php $this->load->view('templates/footer'); ?> 
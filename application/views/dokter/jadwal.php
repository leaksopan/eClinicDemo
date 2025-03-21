<?php $this->load->view('templates/header', ['title' => 'Jadwal Praktek Dokter']); ?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt mr-2"></i> Jadwal Praktek Dokter
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
                    
                    <!-- Informasi Dokter -->
                    <div class="alert alert-info mb-4">
                        <h5>Informasi Dokter</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <strong>Nama:</strong> 
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
                                </p>
                                <p><strong>Spesialis:</strong> <?= $dokter->spesialis ?? '-' ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>SIP:</strong> <?= $dokter->sip ?></p>
                                <p><strong>Status:</strong> 
                                    <?php if($dokter->status_praktek == 'Aktif'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php elseif($dokter->status_praktek == 'Cuti'): ?>
                                        <span class="badge badge-warning">Cuti</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="mb-3">
                        <a href="<?= base_url('dokter/lihat/'.$dokter->id_dokter) ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Detail
                        </a>
                        <a href="<?= base_url('dokter/tambah_jadwal/'.$dokter->id_dokter) ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah Jadwal
                        </a>
                        <a href="<?= base_url('jadwal') ?>" class="btn btn-info">
                            <i class="fas fa-calendar-alt mr-1"></i> Lihat Semua Jadwal
                        </a>
                    </div>
                    
                    <!-- Tabel Jadwal -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="tabelJadwal">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Hari</th>
                                    <th width="20%">Jam Praktek</th>
                                    <th width="20%">Poliklinik</th>
                                    <th width="10%">Kuota</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Aksi</th>
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
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="#" onclick="konfirmasiHapus('<?= base_url('dokter/hapus_jadwal/'.$j->id_jadwal) ?>')" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
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
                Apakah Anda yakin ingin menghapus jadwal praktek ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="btnHapus" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tabelJadwal').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "responsive": true
    });
});

function konfirmasiHapus(url) {
    $('#btnHapus').attr('href', url);
    $('#modalKonfirmasi').modal('show');
}
</script>

<?php $this->load->view('templates/footer'); ?>
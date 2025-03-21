<?php $this->load->view('templates/header', ['title' => 'Daftar Dokter']); ?>

<div class="container-fluid my-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-md mr-2"></i> Daftar Dokter
            </h5>
        </div>
        <div class="card-body">
            <!-- Tombol Tambah dan Statistik -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <a href="<?= base_url('dokter/tambah') ?>" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Dokter
                    </a>
                    <a href="<?= base_url('dokter/statistik') ?>" class="btn btn-info ml-2">
                        <i class="fas fa-chart-bar"></i> Statistik
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('dokter/cari') ?>" method="post" class="form-inline float-right">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari dokter...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
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
            
            <!-- Tabel Dokter -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tabelDokter">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Dokter</th>
                            <th width="15%">Spesialis</th>
                            <th width="15%">SIP</th>
                            <th width="10%">No. Telepon</th>
                            <th width="15%">Tarif Konsultasi</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($dokter)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data dokter</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($dokter as $d): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php 
                                            $nama_lengkap = '';
                                            if (!empty($d->gelar_depan)) {
                                                $nama_lengkap .= $d->gelar_depan . ' ';
                                            }
                                            $nama_lengkap .= $d->nama_lengkap;
                                            if (!empty($d->gelar_belakang)) {
                                                $nama_lengkap .= ', ' . $d->gelar_belakang;
                                            }
                                            echo $nama_lengkap;
                                        ?>
                                    </td>
                                    <td><?= $d->spesialis ?? '-' ?></td>
                                    <td><?= $d->sip ?></td>
                                    <td><?= $d->no_telp ?? '-' ?></td>
                                    <td>Rp <?= number_format($d->tarif_konsultasi, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if($d->status_praktek == 'Aktif'): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php elseif($d->status_praktek == 'Cuti'): ?>
                                            <span class="badge badge-warning">Cuti</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('dokter/lihat/'.$d->id_dokter) ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('dokter/edit/'.$d->id_dokter) ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('dokter/jadwal/'.$d->id_dokter) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Jadwal Praktek">
                                                <i class="fas fa-calendar-alt"></i>
                                            </a>
                                            <a href="#" onclick="konfirmasiHapus('<?= base_url('dokter/hapus/'.$d->id_dokter) ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
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
                Apakah Anda yakin ingin menghapus data dokter ini?
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
    $('#tabelDokter').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "responsive": true
    });
    
    $('[data-toggle="tooltip"]').tooltip();
});

function konfirmasiHapus(url) {
    $('#btnHapus').attr('href', url);
    $('#modalKonfirmasi').modal('show');
}
</script>

<?php $this->load->view('templates/footer'); ?> 
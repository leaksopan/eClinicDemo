<?php $this->load->view('templates/header', ['title' => 'Daftar Pengguna']); ?>

<div class="container-fluid my-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-users mr-2"></i> Daftar Pengguna
            </h5>
        </div>
        <div class="card-body">
            <!-- Tombol Tambah -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <a href="<?= base_url('pengguna/tambah') ?>" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Pengguna
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('pengguna/cari') ?>" method="post" class="form-inline float-right">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari pengguna...">
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
            
            <!-- Tabel Pengguna -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="tabelPengguna">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Username</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="15%">Email</th>
                            <th width="10%">No. Telepon</th>
                            <th width="10%">Role</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($pengguna)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pengguna</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($pengguna as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $p->username ?></td>
                                    <td><?= $p->nama_lengkap ?></td>
                                    <td><?= $p->email ?></td>
                                    <td><?= $p->no_telp ?? '-' ?></td>
                                    <td><?= $p->nama_role ?></td>
                                    <td>
                                        <?php if($p->status == 'aktif'): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('pengguna/lihat/'.$p->id_pengguna) ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('pengguna/edit/'.$p->id_pengguna) ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('pengguna/reset_password/'.$p->id_pengguna) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Reset Password">
                                                <i class="fas fa-key"></i>
                                            </a>
                                            
                                            <?php if($p->status == 'aktif' && $p->username != 'admin'): ?>
                                                <a href="#" onclick="konfirmasiNonaktif('<?= base_url('pengguna/nonaktifkan/'.$p->id_pengguna) ?>')" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Nonaktifkan">
                                                    <i class="fas fa-user-slash"></i>
                                                </a>
                                            <?php elseif($p->status == 'nonaktif'): ?>
                                                <a href="<?= base_url('pengguna/aktifkan/'.$p->id_pengguna) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Aktifkan">
                                                    <i class="fas fa-user-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if($p->username != 'admin'): ?>
                                                <a href="#" onclick="konfirmasiHapus('<?= base_url('pengguna/hapus/'.$p->id_pengguna) ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
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
                Apakah Anda yakin ingin menghapus pengguna ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="btnHapus" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Nonaktif -->
<div class="modal fade" id="modalNonaktif" tabindex="-1" role="dialog" aria-labelledby="modalNonaktifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNonaktifLabel">Konfirmasi Nonaktifkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menonaktifkan pengguna ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="btnNonaktif" href="#" class="btn btn-warning">Nonaktifkan</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tabelPengguna').DataTable({
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

function konfirmasiNonaktif(url) {
    $('#btnNonaktif').attr('href', url);
    $('#modalNonaktif').modal('show');
}
</script>

<?php $this->load->view('templates/footer'); ?> 
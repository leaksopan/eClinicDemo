<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <?= isset($keyword) ? 'Hasil Pencarian: ' . $keyword : 'Daftar Pasien' ?>
            </h6>
            <div class="card-tools">
                <a href="<?= base_url('pasien/tambah') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Pasien Baru
                </a>
                <a href="<?= base_url('pasien/statistik') ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-chart-bar"></i> Statistik
                </a>
                <a href="<?= base_url('pasien/cetak') ?>" class="btn btn-success btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak
                </a>
            </div>
        </div>
        <div class="card-body">
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

            <div class="mb-3">
                <form action="<?= base_url('pasien/cari') ?>" method="get" class="form-inline">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Cari pasien (nama, no RM, alamat)..." value="<?= isset($keyword) ? $keyword : '' ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Tgl Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
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
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->no_rm ?></td>
                                    <td><?= $row->nama_lengkap ?></td>
                                    <td><?= date('d-m-Y', strtotime($row->tanggal_lahir)) ?></td>
                                    <td><?= $row->jenis_kelamin ?></td>
                                    <td><?= $row->no_telp ?></td>
                                    <td><?= $row->alamat ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('pasien/lihat/' . $row->id_pasien) ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('pasien/edit/' . $row->id_pasien) ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('pasien/kartu/' . $row->id_pasien) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Cetak Kartu" target="_blank">
                                            <i class="fas fa-id-card"></i>
                                        </a>
                                        <a href="<?= base_url('pasien/cetak/' . $row->id_pasien) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Cetak Data" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="#" onclick="confirmDelete('<?= $row->id_pasien ?>', '<?= $row->nama_lengkap ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <strong>Total: <?= count($pasien) ?> pasien</strong>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data pasien <strong id="pasienName"></strong>?</p>
                <p class="text-danger">Perhatian: Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="deleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "responsive": true
        });
        
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    function confirmDelete(id, name) {
        $('#pasienName').text(name);
        $('#deleteButton').attr('href', '<?= base_url("pasien/hapus/") ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>

<?php $this->load->view('templates/footer'); ?> 
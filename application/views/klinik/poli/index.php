<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Poliklinik</h1>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Poliklinik</h6>
            <a href="<?= base_url('klinik/tambah_poli') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Poliklinik
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Poliklinik</th>
                            <th>Lokasi</th>
                            <th>Jam Operasional</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($poli)) : ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data poliklinik</td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($poli as $p) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $p->kode_poli ?></td>
                                    <td><?= $p->nama_poli ?></td>
                                    <td><?= $p->lokasi ?: '-' ?></td>
                                    <td>
                                        <?php if (!empty($p->jam_buka) && !empty($p->jam_tutup)) : ?>
                                            <?= date('H:i', strtotime($p->jam_buka)) ?> - <?= date('H:i', strtotime($p->jam_tutup)) ?>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($p->status == 'aktif') : ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('klinik/edit_poli/' . $p->id_poli) ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-hapus" data-toggle="tooltip" title="Hapus" data-id="<?= $p->id_poli ?>" data-nama="<?= $p->nama_poli ?>">
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

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus poliklinik <strong id="nama-poli"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait poliklinik ini, termasuk jadwal dokter yang terkait.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="btn-hapus-confirm" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        
        $('.btn-hapus').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            
            $('#nama-poli').text(nama);
            $('#btn-hapus-confirm').attr('href', '<?= base_url('klinik/hapus_poli/') ?>' + id);
            
            $('#hapusModal').modal('show');
        });
        
        $('[data-toggle="tooltip"]').tooltip();
    });
</script> 
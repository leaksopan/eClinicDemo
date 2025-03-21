<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Surat</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('surat/buat') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Surat Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <table class="table table-bordered table-striped" id="tabel-surat">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nomor Surat</th>
                                <th>Jenis Surat</th>
                                <th>Tanggal</th>
                                <th>Tujuan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($surat as $s) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $s->nomor_surat ?></td>
                                    <td><?= $s->jenis_surat ?></td>
                                    <td><?= date('d F Y', strtotime($s->tanggal)) ?></td>
                                    <td><?= $s->tujuan ?></td>
                                    <td>
                                        <a href="<?= base_url('surat/lihat/' . $s->id) ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('surat/cetak/' . $s->id) ?>" class="btn btn-success btn-sm" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="<?= base_url('surat/hapus/' . $s->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabel-surat').DataTable();
    });
</script>

<?php $this->load->view('templates/footer'); ?> 
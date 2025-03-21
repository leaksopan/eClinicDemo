<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Pasien</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('pasien') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
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

                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="img-thumbnail p-2">
                                <?php if (!empty($pasien->foto) && file_exists($pasien->foto)) : ?>
                                    <img src="<?= base_url($pasien->foto) ?>" alt="Foto Pasien" class="img-fluid">
                                <?php else : ?>
                                    <img src="<?= base_url('assets/img/no-photo.jpg') ?>" alt="No Photo" class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <div class="btn-group">
                                    <a href="<?= base_url('pasien/edit/' . $pasien->id_pasien) ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('pasien/kartu/' . $pasien->id_pasien) ?>" class="btn btn-success" target="_blank">
                                        <i class="fas fa-id-card"></i> Kartu
                                    </a>
                                    <a href="<?= base_url('pasien/cetak/' . $pasien->id_pasien) ?>" class="btn btn-info" target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="badge badge-<?= $pasien->status == 'aktif' ? 'success' : 'warning' ?> p-2">
                                    Status: <?= ucfirst($pasien->status) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Pasien</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th width="40%">No. Rekam Medis</th>
                                                            <td width="60%"><strong class="text-primary"><?= $pasien->no_rm ?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Lengkap</th>
                                                            <td><?= $pasien->nama_lengkap ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tempat, Tgl Lahir</th>
                                                            <td><?= $pasien->tempat_lahir ?>, <?= date('d-m-Y', strtotime($pasien->tanggal_lahir)) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Umur</th>
                                                            <td>
                                                                <?php
                                                                $tgl_lahir = new DateTime($pasien->tanggal_lahir);
                                                                $today = new DateTime('today');
                                                                $usia = $tgl_lahir->diff($today)->y;
                                                                echo $usia . ' tahun';
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Jenis Kelamin</th>
                                                            <td><?= $pasien->jenis_kelamin ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th width="40%">Tgl Daftar</th>
                                                            <td width="60%"><?= date('d-m-Y', strtotime($pasien->tanggal_daftar)) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Golongan Darah</th>
                                                            <td><?= $pasien->golongan_darah ?> <?= $pasien->rhesus != 'Tidak Tahu' ? $pasien->rhesus : '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Agama</th>
                                                            <td><?= $pasien->agama ?: '-' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status Pernikahan</th>
                                                            <td><?= $pasien->status_pernikahan ?: '-' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pendidikan</th>
                                                            <td><?= $pasien->pendidikan ?: '-' ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th width="20%">Pekerjaan</th>
                                                            <td width="80%"><?= $pasien->pekerjaan ?: '-' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Identitas</th>
                                                            <td><?= $pasien->jenis_identitas ?> - <?= $pasien->no_identitas ?: '-' ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Informasi Kontak</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="20%">Alamat</th>
                                                    <td width="80%"><?= $pasien->alamat ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan / Kecamatan</th>
                                                    <td><?= $pasien->kelurahan ?: '-' ?> / <?= $pasien->kecamatan ?: '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kota / Provinsi</th>
                                                    <td><?= $pasien->kota ?: '-' ?> / <?= $pasien->provinsi ?: '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kode Pos</th>
                                                    <td><?= $pasien->kode_pos ?: '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No. Telepon</th>
                                                    <td><?= $pasien->no_telp ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-warning text-dark">
                                            <h5 class="mb-0"><i class="fas fa-phone"></i> Kontak Darurat</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Nama Keluarga</th>
                                                    <td width="60%"><?= $pasien->nama_keluarga ?: '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Hubungan</th>
                                                    <td><?= $pasien->hubungan_keluarga ?: '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No. Telepon</th>
                                                    <td><?= $pasien->telp_keluarga ?: '-' ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-danger text-white">
                                            <h5 class="mb-0"><i class="fas fa-notes-medical"></i> Catatan Medis</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Alergi</th>
                                                    <td width="60%"><?= $pasien->alergi ?: '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Catatan Khusus</th>
                                                    <td><?= $pasien->catatan_khusus ?: '-' ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('pasien/edit/' . $pasien->id_pasien) ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                    <a href="#" onclick="confirmDelete('<?= $pasien->id_pasien ?>', '<?= $pasien->nama_lengkap ?>')" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus Data
                    </a>
                </div>
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
                <p class="text-danger">Perhatian: Tindakan ini tidak dapat dibatalkan dan akan menghapus seluruh data pasien termasuk catatan medis yang terkait!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="deleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        $('#pasienName').text(name);
        $('#deleteButton').attr('href', '<?= base_url("pasien/hapus/") ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>

<?php $this->load->view('templates/footer'); ?> 
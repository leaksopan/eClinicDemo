<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Poliklinik</h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Poliklinik</h6>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors() ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('klinik/edit_poli/' . $poli->id_poli) ?>" method="post">
                        <div class="form-group row">
                            <label for="kode_poli" class="col-sm-2 col-form-label">Kode Poli <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kode_poli" name="kode_poli" placeholder="Masukkan kode poliklinik" value="<?= set_value('kode_poli', $poli->kode_poli) ?>" maxlength="10" required <?= ($poli->kode_poli == 'UMUM' || $poli->kode_poli == 'GIGI') ? 'readonly' : '' ?>>
                                <small class="text-muted">Kode unik untuk poliklinik, maksimal 10 karakter</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_poli" class="col-sm-2 col-form-label">Nama Poli <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_poli" name="nama_poli" placeholder="Masukkan nama poliklinik" value="<?= set_value('nama_poli', $poli->nama_poli) ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi poliklinik"><?= set_value('deskripsi', $poli->deskripsi) ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan lokasi poliklinik" value="<?= set_value('lokasi', $poli->lokasi) ?>">
                                <small class="text-muted">Contoh: Lantai 2, Gedung Utama</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="kapasitas" name="kapasitas" placeholder="Masukkan kapasitas poliklinik" value="<?= set_value('kapasitas', $poli->kapasitas) ?>" min="0">
                                <small class="text-muted">Jumlah maksimal pasien yang dapat ditangani sekaligus</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jam Operasional</label>
                            <div class="col-sm-5">
                                <input type="time" class="form-control" id="jam_buka" name="jam_buka" placeholder="Jam Buka" value="<?= set_value('jam_buka', $poli->jam_buka) ?>">
                                <small class="text-muted">Jam Buka</small>
                            </div>
                            <div class="col-sm-5">
                                <input type="time" class="form-control" id="jam_tutup" name="jam_tutup" placeholder="Jam Tutup" value="<?= set_value('jam_tutup', $poli->jam_tutup) ?>">
                                <small class="text-muted">Jam Tutup</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">Status <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="aktif" <?= set_select('status', 'aktif', ($poli->status == 'aktif')) ?>>Aktif</option>
                                    <option value="nonaktif" <?= set_select('status', 'nonaktif', ($poli->status == 'nonaktif')) ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="<?= base_url('klinik/poli') ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
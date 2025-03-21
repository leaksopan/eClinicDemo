<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pasien Baru</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('pasien') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?= form_open_multipart('pasien/tambah', ['class' => 'form-horizontal']); ?>
                    
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Data Pribadi</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama lengkap pasien" value="<?= set_value('nama_lengkap') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tempat Lahir<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat lahir" value="<?= set_value('tempat_lahir') ?>" required>
                                </div>
                                <label class="col-sm-2 col-form-label">Tanggal Lahir<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki') ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan') ?>>Perempuan</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Golongan Darah</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="golongan_darah">
                                        <option value="Tidak Tahu" <?= set_select('golongan_darah', 'Tidak Tahu', TRUE) ?>>Tidak Tahu</option>
                                        <option value="A" <?= set_select('golongan_darah', 'A') ?>>A</option>
                                        <option value="B" <?= set_select('golongan_darah', 'B') ?>>B</option>
                                        <option value="AB" <?= set_select('golongan_darah', 'AB') ?>>AB</option>
                                        <option value="O" <?= set_select('golongan_darah', 'O') ?>>O</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="rhesus">
                                        <option value="Tidak Tahu" <?= set_select('rhesus', 'Tidak Tahu', TRUE) ?>>Rhesus: Tidak Tahu</option>
                                        <option value="+" <?= set_select('rhesus', '+') ?>>Rhesus: +</option>
                                        <option value="-" <?= set_select('rhesus', '-') ?>>Rhesus: -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Agama</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="agama">
                                        <option value="" disabled selected>-- Pilih Agama --</option>
                                        <option value="Islam" <?= set_select('agama', 'Islam') ?>>Islam</option>
                                        <option value="Kristen" <?= set_select('agama', 'Kristen') ?>>Kristen</option>
                                        <option value="Katolik" <?= set_select('agama', 'Katolik') ?>>Katolik</option>
                                        <option value="Hindu" <?= set_select('agama', 'Hindu') ?>>Hindu</option>
                                        <option value="Buddha" <?= set_select('agama', 'Buddha') ?>>Buddha</option>
                                        <option value="Konghucu" <?= set_select('agama', 'Konghucu') ?>>Konghucu</option>
                                        <option value="Lainnya" <?= set_select('agama', 'Lainnya') ?>>Lainnya</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Status Pernikahan</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="status_pernikahan">
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="Belum Menikah" <?= set_select('status_pernikahan', 'Belum Menikah') ?>>Belum Menikah</option>
                                        <option value="Menikah" <?= set_select('status_pernikahan', 'Menikah') ?>>Menikah</option>
                                        <option value="Cerai Hidup" <?= set_select('status_pernikahan', 'Cerai Hidup') ?>>Cerai Hidup</option>
                                        <option value="Cerai Mati" <?= set_select('status_pernikahan', 'Cerai Mati') ?>>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pendidikan</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="pendidikan">
                                        <option value="" disabled selected>-- Pilih Pendidikan --</option>
                                        <option value="Tidak Sekolah" <?= set_select('pendidikan', 'Tidak Sekolah') ?>>Tidak Sekolah</option>
                                        <option value="SD" <?= set_select('pendidikan', 'SD') ?>>SD</option>
                                        <option value="SMP" <?= set_select('pendidikan', 'SMP') ?>>SMP</option>
                                        <option value="SMA" <?= set_select('pendidikan', 'SMA') ?>>SMA</option>
                                        <option value="D3" <?= set_select('pendidikan', 'D3') ?>>D3</option>
                                        <option value="S1" <?= set_select('pendidikan', 'S1') ?>>S1</option>
                                        <option value="S2" <?= set_select('pendidikan', 'S2') ?>>S2</option>
                                        <option value="S3" <?= set_select('pendidikan', 'S3') ?>>S3</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Pekerjaan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pekerjaan" placeholder="Pekerjaan" value="<?= set_value('pekerjaan') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nomor Identitas</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="no_identitas" placeholder="Nomor KTP/SIM/Paspor" value="<?= set_value('no_identitas') ?>">
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="jenis_identitas">
                                        <option value="KTP" <?= set_select('jenis_identitas', 'KTP', TRUE) ?>>KTP</option>
                                        <option value="SIM" <?= set_select('jenis_identitas', 'SIM') ?>>SIM</option>
                                        <option value="Paspor" <?= set_select('jenis_identitas', 'Paspor') ?>>Paspor</option>
                                        <option value="Lainnya" <?= set_select('jenis_identitas', 'Lainnya') ?>>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Foto Pasien</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto" name="foto">
                                        <label class="custom-file-label" for="foto">Pilih file...</label>
                                    </div>
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Maks 2MB</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status" required>
                                        <option value="aktif" <?= set_select('status', 'aktif', true) ?>>Aktif</option>
                                        <option value="nonaktif" <?= set_select('status', 'nonaktif') ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Data Kontak</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alamat<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat lengkap" required><?= set_value('alamat') ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kelurahan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="kelurahan" placeholder="Kelurahan/Desa" value="<?= set_value('kelurahan') ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">Kecamatan</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="kecamatan" placeholder="Kecamatan" value="<?= set_value('kecamatan') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kota/Kabupaten</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="kota" placeholder="Kota/Kabupaten" value="<?= set_value('kota') ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">Provinsi</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="provinsi">
                                        <option value="" disabled selected>-- Pilih Provinsi --</option>
                                        <?php foreach ($provinsi as $p) : ?>
                                            <option value="<?= $p ?>" <?= set_select('provinsi', $p) ?>><?= $p ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kode Pos</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="kode_pos" placeholder="Kode Pos" value="<?= set_value('kode_pos') ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">No. Telepon<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="no_telp" placeholder="Nomor telepon" value="<?= set_value('no_telp') ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Data Kontak Darurat</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Keluarga</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_keluarga" placeholder="Nama keluarga yang bisa dihubungi" value="<?= set_value('nama_keluarga') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Hubungan</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="hubungan_keluarga">
                                        <option value="" disabled selected>-- Pilih Hubungan --</option>
                                        <option value="Suami" <?= set_select('hubungan_keluarga', 'Suami') ?>>Suami</option>
                                        <option value="Istri" <?= set_select('hubungan_keluarga', 'Istri') ?>>Istri</option>
                                        <option value="Anak" <?= set_select('hubungan_keluarga', 'Anak') ?>>Anak</option>
                                        <option value="Orang Tua" <?= set_select('hubungan_keluarga', 'Orang Tua') ?>>Orang Tua</option>
                                        <option value="Saudara" <?= set_select('hubungan_keluarga', 'Saudara') ?>>Saudara</option>
                                        <option value="Lainnya" <?= set_select('hubungan_keluarga', 'Lainnya') ?>>Lainnya</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Telp. Keluarga</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="telp_keluarga" placeholder="Nomor telepon keluarga" value="<?= set_value('telp_keluarga') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Data Kesehatan</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alergi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="alergi" rows="2" placeholder="Alergi obat, makanan, dll"><?= set_value('alergi') ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Catatan Khusus</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="catatan_khusus" rows="3" placeholder="Penyakit bawaan, riwayat operasi, dll"><?= set_value('catatan_khusus') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Custom file input
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>

<?php $this->load->view('templates/footer'); ?> 
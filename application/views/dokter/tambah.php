<?php $this->load->view('templates/header', ['title' => 'Tambah Dokter']); ?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md mr-2"></i> Tambah Dokter
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors() ?>
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
                    
                    <form action="<?= base_url('dokter/tambah') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_pengguna">Pengguna <span class="text-danger">*</span></label>
                                    <select name="id_pengguna" id="id_pengguna" class="form-control" required>
                                        <option value="">Pilih Pengguna</option>
                                        <?php foreach($pengguna as $id => $nama): ?>
                                            <option value="<?= $id ?>" <?= set_select('id_pengguna', $id) ?>><?= $nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gelar_depan">Gelar Depan</label>
                                    <input type="text" name="gelar_depan" id="gelar_depan" class="form-control" value="<?= set_value('gelar_depan') ?>" placeholder="Contoh: dr.">
                                </div>
                                
                                <div class="form-group">
                                    <label for="gelar_belakang">Gelar Belakang</label>
                                    <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control" value="<?= set_value('gelar_belakang') ?>" placeholder="Contoh: Sp.PD">
                                </div>
                                
                                <div class="form-group">
                                    <label for="sip">SIP (Surat Izin Praktik) <span class="text-danger">*</span></label>
                                    <input type="text" name="sip" id="sip" class="form-control" value="<?= set_value('sip') ?>" required placeholder="Masukkan nomor SIP">
                                </div>
                                
                                <div class="form-group">
                                    <label for="spesialis">Spesialis</label>
                                    <input type="text" name="spesialis" id="spesialis" class="form-control" value="<?= set_value('spesialis') ?>" placeholder="Contoh: Penyakit Dalam">
                                </div>
                                
                                <div class="form-group">
                                    <label for="tarif_konsultasi">Tarif Konsultasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="tarif_konsultasi" id="tarif_konsultasi" class="form-control" value="<?= set_value('tarif_konsultasi') ?>" required placeholder="Masukkan tarif konsultasi">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="komisi_persen">Komisi (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="komisi_persen" id="komisi_persen" class="form-control" value="<?= set_value('komisi_persen', '0') ?>" placeholder="Masukkan persentase komisi">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status_praktek">Status Praktek <span class="text-danger">*</span></label>
                                    <select name="status_praktek" id="status_praktek" class="form-control" required>
                                        <option value="Aktif" <?= set_select('status_praktek', 'Aktif', TRUE) ?>>Aktif</option>
                                        <option value="Cuti" <?= set_select('status_praktek', 'Cuti') ?>>Cuti</option>
                                        <option value="Tidak Aktif" <?= set_select('status_praktek', 'Tidak Aktif') ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="jatah_pasien">Jatah Pasien per Hari</label>
                                    <input type="number" name="jatah_pasien" id="jatah_pasien" class="form-control" value="<?= set_value('jatah_pasien', '0') ?>" placeholder="Masukkan jatah pasien per hari">
                                </div>
                                
                                <div class="form-group">
                                    <label for="alumni">Alumni</label>
                                    <input type="text" name="alumni" id="alumni" class="form-control" value="<?= set_value('alumni') ?>" placeholder="Contoh: Universitas Indonesia">
                                </div>
                                
                                <div class="form-group">
                                    <label for="tahun_lulus">Tahun Lulus</label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control" value="<?= set_value('tahun_lulus') ?>" placeholder="Contoh: 2010">
                                </div>
                                
                                <div class="form-group">
                                    <label for="mulai_praktek">Mulai Praktek</label>
                                    <input type="date" name="mulai_praktek" id="mulai_praktek" class="form-control" value="<?= set_value('mulai_praktek', date('Y-m-d')) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="<?= base_url('dokter') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 
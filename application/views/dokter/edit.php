<?php $this->load->view('templates/header', ['title' => 'Edit Dokter']); ?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md mr-2"></i> Edit Dokter
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
                    
                    <form action="<?= base_url('dokter/edit/'.$dokter->id_dokter) ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pengguna</label>
                                    <input type="text" class="form-control" value="<?= $dokter->nama_lengkap ?>" readonly>
                                    <small class="text-muted">Pengguna tidak dapat diubah</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gelar_depan">Gelar Depan</label>
                                    <input type="text" name="gelar_depan" id="gelar_depan" class="form-control" value="<?= set_value('gelar_depan', $dokter->gelar_depan) ?>" placeholder="Contoh: dr.">
                                </div>
                                
                                <div class="form-group">
                                    <label for="gelar_belakang">Gelar Belakang</label>
                                    <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control" value="<?= set_value('gelar_belakang', $dokter->gelar_belakang) ?>" placeholder="Contoh: Sp.PD">
                                </div>
                                
                                <div class="form-group">
                                    <label for="sip">SIP (Surat Izin Praktik) <span class="text-danger">*</span></label>
                                    <input type="text" name="sip" id="sip" class="form-control" value="<?= set_value('sip', $dokter->sip) ?>" required placeholder="Masukkan nomor SIP">
                                </div>
                                
                                <div class="form-group">
                                    <label for="spesialis">Spesialis</label>
                                    <input type="text" name="spesialis" id="spesialis" class="form-control" value="<?= set_value('spesialis', $dokter->spesialis) ?>" placeholder="Contoh: Penyakit Dalam">
                                </div>
                                
                                <div class="form-group">
                                    <label for="tarif_konsultasi">Tarif Konsultasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="tarif_konsultasi" id="tarif_konsultasi" class="form-control" value="<?= set_value('tarif_konsultasi', $dokter->tarif_konsultasi) ?>" required placeholder="Masukkan tarif konsultasi">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="komisi_persen">Komisi (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="komisi_persen" id="komisi_persen" class="form-control" value="<?= set_value('komisi_persen', $dokter->komisi_persen) ?>" placeholder="Masukkan persentase komisi">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status_praktek">Status Praktek <span class="text-danger">*</span></label>
                                    <select name="status_praktek" id="status_praktek" class="form-control" required>
                                        <option value="Aktif" <?= set_select('status_praktek', 'Aktif', ($dokter->status_praktek == 'Aktif')) ?>>Aktif</option>
                                        <option value="Cuti" <?= set_select('status_praktek', 'Cuti', ($dokter->status_praktek == 'Cuti')) ?>>Cuti</option>
                                        <option value="Tidak Aktif" <?= set_select('status_praktek', 'Tidak Aktif', ($dokter->status_praktek == 'Tidak Aktif')) ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="jatah_pasien">Jatah Pasien per Hari</label>
                                    <input type="number" name="jatah_pasien" id="jatah_pasien" class="form-control" value="<?= set_value('jatah_pasien', $dokter->jatah_pasien) ?>" placeholder="Masukkan jatah pasien per hari">
                                </div>
                                
                                <div class="form-group">
                                    <label for="alumni">Alumni</label>
                                    <input type="text" name="alumni" id="alumni" class="form-control" value="<?= set_value('alumni', $dokter->alumni) ?>" placeholder="Contoh: Universitas Indonesia">
                                </div>
                                
                                <div class="form-group">
                                    <label for="tahun_lulus">Tahun Lulus</label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control" value="<?= set_value('tahun_lulus', $dokter->tahun_lulus) ?>" placeholder="Contoh: 2010">
                                </div>
                                
                                <div class="form-group">
                                    <label for="mulai_praktek">Mulai Praktek</label>
                                    <input type="date" name="mulai_praktek" id="mulai_praktek" class="form-control" value="<?= set_value('mulai_praktek', $dokter->mulai_praktek) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
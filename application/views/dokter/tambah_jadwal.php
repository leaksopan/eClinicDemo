<?php $this->load->view('templates/header', ['title' => $title]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt mr-1"></i> Tambah Jadwal Praktek Dokter
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi Jadwal:</div>
                            <a class="dropdown-item" href="<?= base_url('dokter/jadwal/'.$dokter->id_dokter) ?>">
                                <i class="fas fa-calendar fa-sm fa-fw mr-2 text-gray-400"></i>
                                Kembali ke Jadwal
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('dokter/lihat/'.$dokter->id_dokter) ?>">
                                <i class="fas fa-user-md fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil Dokter
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Dokter:</strong> <?= (!empty($dokter->gelar_depan) ? $dokter->gelar_depan . ' ' : '') . $dokter->nama_lengkap . (!empty($dokter->gelar_belakang) ? ', ' . $dokter->gelar_belakang : '') ?>
                        <?php if(!empty($dokter->spesialis)): ?>
                            <br><strong>Spesialis:</strong> <?= $dokter->spesialis ?>
                        <?php endif; ?>
                    </div>
                    
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
                    
                    <?php echo form_open('dokter/tambah_jadwal/'.$dokter->id_dokter); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari">Hari Praktek <span class="text-danger">*</span></label>
                                    <select class="form-control" id="hari" name="hari" required>
                                        <option value="">Pilih Hari</option>
                                        <?php 
                                        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                        foreach($hari as $h): 
                                        ?>
                                            <option value="<?= $h ?>" <?= set_select('hari', $h) ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?= set_value('jam_mulai') ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="<?= set_value('jam_selesai') ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_poli">Poliklinik <span class="text-danger">*</span></label>
                                    <select class="form-control" id="id_poli" name="id_poli" required>
                                        <option value="">Pilih Poliklinik</option>
                                        <?php 
                                        // Gunakan data poliklinik yang sudah dikirim dari controller
                                        if(!empty($poliklinik)): 
                                            foreach($poliklinik as $id => $nama): 
                                        ?>
                                            <option value="<?= $id ?>" <?= set_select('id_poli', $id) ?>><?= $nama ?></option>
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="kuota_pasien">Kuota Pasien</label>
                                    <input type="number" class="form-control" id="kuota_pasien" name="kuota_pasien" value="<?= set_value('kuota_pasien', 20) ?>" min="1">
                                    <small class="text-muted">Jumlah maksimal pasien yang dapat mendaftar pada jadwal ini</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="aktif" <?= set_select('status', 'aktif', TRUE) ?>>Aktif</option>
                                        <option value="tidak aktif" <?= set_select('status', 'tidak aktif') ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= set_value('keterangan') ?></textarea>
                            <small class="text-muted">Informasi tambahan tentang jadwal praktek ini (opsional)</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                            <a href="<?= base_url('dokter/jadwal/'.$dokter->id_dokter) ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Validasi ketika form disubmit
        $('form').on('submit', function(e) {
            var jamMulai = $('#jam_mulai').val();
            var jamSelesai = $('#jam_selesai').val();
            
            if(jamMulai >= jamSelesai) {
                alert('Jam selesai harus lebih besar dari jam mulai!');
                e.preventDefault();
            }
        });
    });
</script>

<?php $this->load->view('templates/footer'); ?> 
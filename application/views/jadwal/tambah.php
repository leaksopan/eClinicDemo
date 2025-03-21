<?php //$this->load->view('templates/header', ['title' => $title]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-plus mr-1"></i> Tambah Jadwal Praktek Dokter
                    </h6>
                </div>
                <div class="card-body">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Terjadi Kesalahan!</h4>
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
                    
                    <form action="<?= base_url('jadwal/tambah') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_dokter">Dokter <span class="text-danger">*</span></label>
                                    <select name="id_dokter" id="id_dokter" class="form-control select2" required>
                                        <option value="">Pilih Dokter</option>
                                        <?php foreach($dokter as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= set_select('id_dokter', $key) ?>><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="id_poli">Poliklinik <span class="text-danger">*</span></label>
                                    <select name="id_poli" id="id_poli" class="form-control select2" required>
                                        <option value="">Pilih Poliklinik</option>
                                        <?php foreach($poli as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= set_select('id_poli', $key) ?>><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="hari">Hari <span class="text-danger">*</span></label>
                                    <select name="hari" id="hari" class="form-control" required>
                                        <option value="">Pilih Hari</option>
                                        <?php foreach($hari as $h): ?>
                                            <option value="<?= $h ?>" <?= set_select('hari', $h) ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required value="<?= set_value('jam_mulai') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required value="<?= set_value('jam_selesai') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="kuota_pasien">Kuota Pasien</label>
                                    <input type="number" name="kuota_pasien" id="kuota_pasien" class="form-control" value="<?= set_value('kuota_pasien', 10) ?>" min="1">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"><?= set_value('keterangan') ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="aktif" <?= set_select('status', 'aktif', true) ?>>Aktif</option>
                                        <option value="nonaktif" <?= set_select('status', 'nonaktif') ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i> Pastikan jadwal yang ditambahkan tidak bentrok dengan jadwal praktek dokter yang sudah ada.
                        </div>
                        
                        <div class="form-group text-right">
                            <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        
        // Validasi jam
        $('#jam_selesai').on('change', function() {
            var jamMulai = $('#jam_mulai').val();
            var jamSelesai = $(this).val();
            
            if (jamMulai && jamSelesai && jamMulai >= jamSelesai) {
                alert('Jam selesai harus lebih besar dari jam mulai');
                $(this).val('');
            }
        });
        
        $('#jam_mulai').on('change', function() {
            var jamMulai = $(this).val();
            var jamSelesai = $('#jam_selesai').val();
            
            if (jamMulai && jamSelesai && jamMulai >= jamSelesai) {
                alert('Jam mulai harus lebih kecil dari jam selesai');
                $(this).val('');
            }
        });
    });
</script>

<?php $this->load->view('templates/footer'); ?> 
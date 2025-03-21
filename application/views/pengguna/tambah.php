<?php $this->load->view('templates/header', ['title' => 'Tambah Pengguna']); ?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna Baru
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Notifikasi Error Validasi -->
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Form Tambah Pengguna -->
                    <form action="<?= base_url('pengguna/tambah') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?= set_value('username') ?>" required minlength="5" placeholder="Minimal 5 karakter">
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                                </div>
                                
                                <div class="form-group">
                                    <label for="konfirmasi_password">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" required placeholder="Masukkan ulang password">
                                </div>
                                
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= set_value('nama_lengkap') ?>" required placeholder="Masukkan nama lengkap">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?= set_value('email') ?>" required placeholder="Masukkan email valid">
                                </div>
                                
                                <div class="form-group">
                                    <label for="no_telp">Nomor Telepon</label>
                                    <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= set_value('no_telp') ?>" placeholder="Masukkan nomor telepon">
                                </div>
                                
                                <div class="form-group">
                                    <label for="id_role">Role <span class="text-danger">*</span></label>
                                    <select name="id_role" id="id_role" class="form-control" required>
                                        <option value="">Pilih Role</option>
                                        <?php foreach($roles as $id => $nama): ?>
                                            <option value="<?= $id ?>" <?= set_select('id_role', $id) ?>><?= $nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"><?= set_value('alamat') ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Simpan
                                </button>
                                <a href="<?= base_url('pengguna') ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Validasi password match
    $('#konfirmasi_password').on('keyup', function() {
        var password = $('#password').val();
        var konfirm = $(this).val();
        
        if (password != konfirm) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 
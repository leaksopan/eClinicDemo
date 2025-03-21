<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="eClinic - Sistem Informasi Klinik">
    <meta name="author" content="eClinic">
    <title><?= $title ?? 'Lupa Password'; ?> | eClinic</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #4e73df 0%, #36b9cc 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .forgot-card {
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            overflow: hidden;
        }
        .forgot-header {
            background-color: #4e73df;
            padding: 2rem;
            color: white;
            text-align: center;
        }
        .forgot-body {
            padding: 2rem;
            background-color: white;
        }
        .btn-reset {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
            border-radius: 2rem;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }
        .clinic-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .bg-password-image {
            background: linear-gradient(rgba(78, 115, 223, 0.5), rgba(54, 185, 204, 0.5)), url('<?= base_url('assets/img/login-bg.jpg'); ?>');
            background-position: center;
            background-size: cover;
            min-height: 250px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card forgot-card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-flex flex-column justify-content-center forgot-header">
                                <div class="text-center">
                                    <i class="fas fa-clinic-medical clinic-icon"></i>
                                    <h1 class="h3 mb-4">e-Clinic</h1>
                                    <p class="mb-4">Sistem Manajemen Klinik Terpadu</p>
                                </div>
                            </div>
                            <div class="col-lg-6 forgot-body">
                                <div class="text-center mb-4">
                                    <h2 class="h4 text-gray-900">Lupa Password?</h2>
                                    <p class="text-muted">Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk reset password</p>
                                </div>
                                
                                <?php if($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('error'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                
                                <?= form_open('auth/forgot_password', ['class' => 'user']); ?>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat email" value="<?= set_value('email'); ?>">
                                        </div>
                                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-reset">
                                        <i class="fas fa-paper-plane mr-2"></i> Reset Password
                                    </button>
                                <?= form_close(); ?>
                                
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3 text-white">
                    <small>&copy; <?= date('Y'); ?> eClinic. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="eClinic - Sistem Informasi Klinik">
    <meta name="author" content="eClinic">
    <title><?= $title ?? 'Login'; ?> | eClinic</title>

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
        .login-card {
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            overflow: hidden;
        }
        .login-header {
            background-color: #4e73df;
            padding: 2rem;
            color: white;
            text-align: center;
        }
        .login-body {
            padding: 2rem;
            background-color: white;
        }
        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
            border-radius: 2rem;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }
        .form-control-user {
            border-radius: 10rem !important;
        }
        .login-image {
            background: url('<?= base_url('assets/img/login-bg.jpg'); ?>');
            background-position: center;
            background-size: cover;
            min-height: 250px;
        }
        .clinic-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card login-card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-flex flex-column justify-content-center login-header">
                                <div class="text-center">
                                    <i class="fas fa-clinic-medical clinic-icon"></i>
                                    <h1 class="h3 mb-4">e-Clinic</h1>
                                    <p class="mb-4">Sistem Manajemen Klinik Terpadu</p>
                                </div>
                            </div>
                            <div class="col-lg-6 login-body">
                                <div class="text-center mb-4">
                                    <h2 class="h4 text-gray-900">Selamat Datang!</h2>
                                    <p class="text-muted">Silakan login untuk melanjutkan</p>
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
                                
                                <?= form_open('auth', ['class' => 'user']); ?>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= set_value('username'); ?>">
                                        </div>
                                        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                        </div>
                                        <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember_me">
                                            <label class="custom-control-label" for="rememberMe">Ingat saya</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-login">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                                    </button>
                                <?= form_close(); ?>
                                
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgot_password'); ?>">
                                        <i class="fas fa-question-circle mr-1"></i> Lupa Password?
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
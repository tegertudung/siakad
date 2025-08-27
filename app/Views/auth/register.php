<?= $this->extend('template/header_footer_auth'); ?>
<?= $this->section('content-auth') ?>


<div class="register-box">
    <div class="register-logo">
        <h4>Registrasi Akun</h4>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="register-box-msg">Buat akun baru Anda</p>
            <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
            <?php endif; ?>

            <form action="<?= site_url('register/send') ?>" method="post">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="credential" placeholder="Email" value="<?= old('credential') ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username') ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= old('nama_lengkap') ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-id-card"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Daftar & Kirim OTP</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Non-AJAX form submission, no external JS -->
<?= $this->endSection() ?>
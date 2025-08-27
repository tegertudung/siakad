<?= $this->extend('template/header_footer_auth'); ?>
<?= $this->section('content-auth') ?>

<div class="login-box">
    <div class="login-logo">
        <h4>Verifikasi OTP</h4>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Masukkan kode OTP yang telah dikirim ke email Anda.</p>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= esc($error) ?>
            </div>
            <?php endif; ?>
            <form action="<?= site_url('register/verify') ?>" method="post">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="otp" placeholder="Kode OTP" maxlength="6" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-key"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

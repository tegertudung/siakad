<?= $this->extend('template/header_footer_auth'); ?>
<?= $this->section('content-auth') ?>

<div class="login-box">
    <div class="login-logo">
        <h4>Akses Dibatasi</h4>
    </div>
    <div class="card">
        <div class="card-body login-card-body text-center">
            <p class="login-box-msg">
                <i class="fas fa-lock fa-3x mb-3 text-danger"></i>
            </p>
            <p class="text-danger">
                <?= esc($message)
                ?>
            </p>

            <div id="countdown-timer" class="mt-3 font-weight-bold"></div>

            <hr>
            <a href="<?= base_url('/') ?>" id="back-to-login" class="btn btn-secondary btn-sm d-none">Kembali ke Halaman Login</a>
        </div>
    </div>
</div>

<script <?= csp_script_nonce() ?>>
    const expirationTime = <?= $expiration_time ?? 'null' ?>;

    if (expirationTime) {
        const countdownElement = document.getElementById('countdown-timer');
        const backToLoginButton = document.getElementById('back-to-login');

        const timer = setInterval(function() {
            const remainingSeconds = Math.round(expirationTime - (new Date().getTime() / 1000));

            if (remainingSeconds <= 0) {
                clearInterval(timer);
                countdownElement.innerHTML = "Anda sudah bisa mencoba login kembali.";
                backToLoginButton.classList.remove('d-none');
            } else {
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                countdownElement.innerHTML = 'Sisa waktu: ' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
            }
        }, 1000);
    }
</script>

<?= $this->endSection() ?>
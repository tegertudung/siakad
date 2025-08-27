<?= $this->extend('template/header_footer_auth'); ?>
<?= $this->section('content-auth') ?>


<div class="login-box">
    <div class="login-logo">
        <h4>Login Page</h4>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login untuk melanjutkan proses</p>
            
            <!-- Pesan sukses registrasi -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
            
            <!-- Idv pesan error defaulnya kita sembunyina dengan menambah kelas d-none ( di bootstrap d-none adalah menyembunyikan) -->
            <div id="pesan_error" class="alert alert-danger d-none"></div>
            <!-- focus form -->
            <form id="formLogin">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email atau Username" name="credential">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
            </form>

            <!-- focus end -->
            <div class="row">
                <div class="col-4">
                    <button type="button" class="btn btn-primary btn-block" id="loginbtn">Masuk</button>
                </div>
            </div>
            <div class="mt-3 text-center">
                <p>Belum punya akun? <a href="<?= site_url('register') ?>">Daftar di sini</a></p>
            </div>
        </div>
    </div>

    <script <?= csp_script_nonce() ?>>
        BaseUrlJsQ = "<?= base_url(); ?>"
    </script>
    <script src="<?= base_url(); ?>/jsQ/login.js"></script>

    <?= $this->endSection() ?>
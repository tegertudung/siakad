<?= $this->extend('template/header_footer_auth'); ?>
<?= $this->section('content-auth') ?>

<div class="login-box">

    <div class="card">
        <div class="card-body login-card-body text-center">
            <div class="login-logo">
                <h4>Akses Dilarang!!</h4>
            </div>
            <a href="<?= base_url('/') ?>" class="btn btn-secondary btn-sm ">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
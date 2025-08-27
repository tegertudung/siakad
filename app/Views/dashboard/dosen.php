<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Dosen</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Selamat Datang, <?= esc(session()->get('ses_nama')); ?>!</h4>
                        <p class="card-text">Ini adalah halaman dashboard Anda sebagai Dosen. Silakan gunakan menu di samping untuk mengakses fitur yang tersedia.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Di sini nanti bisa ditambahkan widget untuk jadwal mengajar, mahasiswa bimbingan, dll. -->
      </div>
    </section>
</div>
<?= $this->endSection(); ?>
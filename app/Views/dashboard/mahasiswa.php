<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Mahasiswa</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fas fa-bullhorn"></i>
                        Pengumuman Akademik
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info alert-dismissible">
                            <h5><i class="icon fas fa-info"></i> Jadwal Pengisian KRS!</h5>
                            Pengisian Kartu Rencana Studi (KRS) untuk semester Ganjil 2024/2025 akan dibuka mulai tanggal 1 s/d 15 September 2024.
                        </div>
                        <p>Selamat datang di Sistem Informasi Akademik. Pastikan Anda selalu memeriksa pengumuman terbaru di halaman ini.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">IPK Saat Ini</span>
                        <span class="info-box-number">3.75</span>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
</div>
<?= $this->endSection(); ?>
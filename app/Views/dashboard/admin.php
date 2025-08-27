<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard Administrator</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $jumlah_mahasiswa ?? 0; ?></h3>
                <p>Total Mahasiswa</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-stalker"></i>
              </div>
              <a href="/mahasiswa" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $jumlah_dosen ?? 0; ?></h3>
                <p>Total Dosen</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="/dosen" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $jumlah_jurusan ?? 0; ?></h3>
                <p>Total Jurusan</p>
              </div>
              <div class="icon">
                <i class="ion ion-university"></i>
              </div>
              <a href="/jurusan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $jumlah_matakuliah ?? 0; ?></h3>
                <p>Total Mata Kuliah</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a href="/matakuliah" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6">
                <!-- Akses Cepat -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Akses Cepat</h3>
                    </div>
                    <div class="card-body">
                        <a href="/mahasiswa/new" class="btn btn-app">
                            <i class="fas fa-user-plus"></i> Tambah Mahasiswa
                        </a>
                        <a href="/dosen/new" class="btn btn-app">
                            <i class="fas fa-user-tie"></i> Tambah Dosen
                        </a>
                        <a href="/matakuliah/new" class="btn btn-app">
                            <i class="fas fa-book"></i> Tambah Matkul
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Aktivitas Terbaru -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aktivitas Login Terbaru</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data ini masih statis, nanti akan kita buat dinamis -->
                                <tr>
                                    <td>admin</td>
                                    <td>26 Agu 2025, 11:45</td>
                                </tr>
                                <tr>
                                    <td>mahasiswa1</td>
                                    <td>26 Agu 2025, 11:40</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </section>
</div>
<?= $this->endSection(); ?>
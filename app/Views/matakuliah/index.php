<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= esc($title); ?></h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="<?= base_url('matakuliah/new'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php foreach ($matakuliah_per_jurusan as $nama_jurusan => $semesters) : ?>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Jurusan: <strong><?= esc($nama_jurusan); ?></strong></h3>
                    </div>
                    <div class="card-body p-0">
                        <?php ksort($semesters); // Urutkan semester dari 1, 2, 3, ... ?>
                        <?php foreach ($semesters as $semester => $matakuliah_list) : ?>
                            <?php if (!empty($matakuliah_list)): ?>
                                <h5 class="p-2 bg-light">Semester <?= esc($semester); ?></h5>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode MK</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>SKS</th>
                                            <th style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($matakuliah_list as $mk) : ?>
                                            <tr>
                                                <td><?= esc($mk['kode_mk']); ?></td>
                                                <td><?= esc($mk['nama_mk']); ?></td>
                                                <td><?= esc($mk['sks']); ?></td>
                                                <td>
                                                    <a href="<?= base_url('matakuliah/' . $mk['id'] . '/edit'); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="<?= base_url('matakuliah/' . $mk['id']); ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?');">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>
</div>
<?= $this->endSection(); ?>

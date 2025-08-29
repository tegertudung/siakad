<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pilih Mata Kuliah - Semester <?= esc($ta_aktif['nama_semester'] ?? 'Tidak Aktif'); ?></h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode MK</th>
                                <th>Mata Kuliah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($matakuliah_diajar as $mk): ?>
                            <tr>
                                <td><?= esc($mk['kode_mk']); ?></td>
                                <td><?= esc($mk['nama_mk']); ?></td>
                                <td>
                                    <a href="<?= base_url('nilai/detail/' . $mk['id']); ?>" class="btn btn-primary btn-sm">Input Nilai</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>
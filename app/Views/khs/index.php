<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <?php if (empty($khs_data)): ?>
                <div class="alert alert-warning">Belum ada data KHS untuk ditampilkan.</div>
            <?php else: ?>
                <?php foreach($khs_data as $tahun_akademik => $matakuliah): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Semester: <?= esc($tahun_akademik); ?></h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode MK</th>
                                    <th>Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($matakuliah as $mk): ?>
                                <tr>
                                    <td><?= esc($mk['kode_mk']); ?></td>
                                    <td><?= esc($mk['nama_mk']); ?></td>
                                    <td><?= esc($mk['sks']); ?></td>
                                    <td><?= esc($mk['nilai'] ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>
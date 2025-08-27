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
                    <h3 class="card-title">Daftar Tahun Akademik</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('tahunakademik/new'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tahun Akademik</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tahunakademik as $ta) : ?>
                                <tr>
                                    <td><?= esc($ta['tahun_akademik']); ?></td>
                                    <td><?= esc($ta['nama_semester']); ?></td>
                                    <td>
                                        <?php if ($ta['status'] == 1): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ta['status'] == 0): ?>
                                            <a href="<?= base_url('tahunakademik/setActive/' . $ta['id']); ?>" class="btn btn-info btn-sm">Aktifkan</a>
                                        <?php endif; ?>
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
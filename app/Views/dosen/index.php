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
                    <h3 class="card-title">Daftar Dosen</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('dosen/new'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIDN</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Mata Kuliah Diampu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dosen as $dsn) : ?>
                                <tr>
                                    <td><?= esc($dsn['nidn']); ?></td>
                                    <td><?= esc($dsn['nama_lengkap']); ?></td>
                                    <td><?= esc($dsn['nama_jurusan']); ?></td>
                                    <td>
                                        <?php if (!empty($dsn['mata_kuliah_diampu'])): ?>
                                            <ul>
                                                <?php foreach($dsn['mata_kuliah_diampu'] as $mk): ?>
                                                    <li><?= esc($mk); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <span class="text-muted">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('dosen/' . $dsn['id'] . '/edit'); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="<?= base_url('dosen/' . $dsn['id']); ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Menghapus dosen juga akan menghapus akun login mereka. Apakah Anda yakin?');">Hapus</button>
                                        </form>
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

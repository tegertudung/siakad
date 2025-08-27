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
                    <h3 class="card-title">Daftar Mata Kuliah</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('matakuliah/new'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Jurusan</th>
                                <th>SKS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matakuliah as $mk) : ?>
                                <tr>
                                    <td><?= esc($mk['kode_mk']); ?></td>
                                    <td><?= esc($mk['nama_mk']); ?></td>
                                    <td><?= esc($mk['nama_jurusan']); ?></td>
                                    <td><?= esc($mk['sks']); ?></td>
                                    <td class="text-center">
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
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>
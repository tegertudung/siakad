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
                    <h3 class="card-title">Daftar Mahasiswa</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('mahasiswa/new'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Jurusan</th>
                                <th>Angkatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mahasiswa as $mhs) : ?>
                                <tr>
                                    <td><?= esc($mhs['nim']); ?></td>
                                    <td><?= esc($mhs['nama_lengkap']); ?></td>
                                    <td><?= esc($mhs['nama_jurusan']); ?></td>
                                    <td><?= esc($mhs['angkatan']); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('mahasiswa/' . $mhs['id'] . '/edit'); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="<?= base_url('mahasiswa/' . $mhs['id']); ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Menghapus mahasiswa juga akan menghapus akun login mereka. Apakah Anda yakin?');">Hapus</button>
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

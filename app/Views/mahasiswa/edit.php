<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Formulir Edit Data Mahasiswa</h3></div>
                <form action="<?= base_url('mahasiswa/' . $mahasiswa['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        <!-- Tampilkan pesan error validasi -->
                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                <?php foreach (session('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <h5>Data Diri</h5>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= esc($mahasiswa['nama_lengkap']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" class="form-control" name="nim" value="<?= esc($mahasiswa['nim']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select name="jurusan_id" class="form-control" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php foreach($jurusan as $jrs): ?>
                                    <option value="<?= $jrs['id']; ?>" <?= ($mahasiswa['jurusan_id'] == $jrs['id']) ? 'selected' : '' ?>><?= $jrs['nama_jurusan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" value="<?= esc($mahasiswa['angkatan']); ?>" required>
                        </div>
                        <hr>
                        <h5>Akun Login</h5>
                        <div class="form-group">
                            <label>Username (Tidak dapat diubah)</label>
                            <input type="text" class="form-control" name="username" value="<?= esc($mahasiswa['username']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?= esc($mahasiswa['email']); ?>" required>
                        </div>
                         <p class="text-muted"><small>Untuk mengubah password, gunakan fitur "Reset Password".</small></p>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

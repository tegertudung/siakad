<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Formulir Data Mahasiswa</h3></div>
                <form action="<?= base_url('mahasiswa'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="card-body">
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
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" class="form-control" name="nim" value="<?= old('nim') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select name="jurusan_id" class="form-control" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php foreach($jurusan as $jrs): ?>
                                    <option value="<?= $jrs['id']; ?>" <?= (old('jurusan_id') == $jrs['id']) ? 'selected' : '' ?>><?= $jrs['nama_jurusan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" value="<?= old('angkatan') ?>" required>
                        </div>
                        <hr>
                        <h5>Akun Login</h5>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?= old('username') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?= old('email') ?>" required>
                        </div>
                         <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

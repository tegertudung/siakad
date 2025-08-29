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
                    <h3 class="card-title">Input Nilai Mahasiswa</h3>
                </div>
                <form action="<?= base_url('nilai/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($mahasiswa_krs as $mhs): ?>
                            <tr>
                                <td><?= esc($mhs['nim']); ?></td>
                                <td><?= esc($mhs['nama_lengkap']); ?></td>
                                <td>
                                    <input type="hidden" name="krs_id[]" value="<?= $mhs['id']; ?>">
                                    <select name="nilai[]" class="form-control">
                                        <option value="">--Pilih--</option>
                                        <option value="A" <?= ($mhs['nilai'] == 'A') ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?= ($mhs['nilai'] == 'B') ? 'selected' : ''; ?>>B</option>
                                        <option value="C" <?= ($mhs['nilai'] == 'C') ? 'selected' : ''; ?>>C</option>
                                        <option value="D" <?= ($mhs['nilai'] == 'D') ? 'selected' : ''; ?>>D</option>
                                        <option value="E" <?= ($mhs['nilai'] == 'E') ? 'selected' : ''; ?>>E</option>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    <a href="<?= base_url('nilai'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

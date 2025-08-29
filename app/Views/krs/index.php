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
                    <h3 class="card-title">Semester Aktif: <?= esc($ta_aktif['nama_semester'] ?? 'Periode KRS Belum Dibuka'); ?></h3>
                </div>
                
                <?php if ($ta_aktif): // Hanya tampilkan form jika ada semester aktif ?>
                <form action="<?= base_url('krs/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="mahasiswa_id" value="<?= $mahasiswa['id']; ?>">
                <input type="hidden" name="tahun_akademik" value="<?= $ta_aktif['tahun_akademik']; ?>">
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Pilih</th>
                                <th>Kode MK</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matakuliah as $mk) : ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="matakuliah_ids[]" value="<?= $mk['id']; ?>" <?= in_array($mk['id'], $matakuliah_sudah_diambil) ? 'checked' : '' ?>></td>
                                    <td><?= esc($mk['kode_mk']); ?></td>
                                    <td><?= esc($mk['nama_mk']); ?></td>
                                    <td><?= esc($mk['sks']); ?></td>
                                    <td><?= esc($mk['semester']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan KRS</button>
                </div>
                </form>
                <?php else: ?>
                <div class="card-body">
                    <div class="alert alert-danger">Saat ini periode pengisian KRS belum dibuka oleh Administrator.</div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>
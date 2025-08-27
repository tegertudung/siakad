<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Formulir Tahun Akademik</h3></div>
                <form action="<?= base_url('tahunakademik'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tahun Akademik (Contoh: 20251)</label>
                            <input type="text" class="form-control" name="tahun_akademik" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Semester (Contoh: Ganjil 2025/2026)</label>
                            <input type="text" class="form-control" name="nama_semester" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai KRS</label>
                            <input type="date" class="form-control" name="tgl_mulai_krs">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai KRS</label>
                            <input type="date" class="form-control" name="tgl_selesai_krs">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('tahunakademik'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

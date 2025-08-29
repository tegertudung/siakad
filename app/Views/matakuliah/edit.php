<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Formulir Edit Mata Kuliah</h3></div>
                <form action="<?= base_url('matakuliah/' . $matakuliah['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                         <div class="form-group">
                            <label for="jurusan_id">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php foreach($jurusan as $jrs): ?>
                                    <option value="<?= $jrs['id']; ?>" <?= ($jrs['id'] == $matakuliah['jurusan_id']) ? 'selected' : ''; ?>>
                                        <?= $jrs['nama_jurusan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode_mk">Kode MK</label>
                            <input type="text" class="form-control" id="kode_mk" name="kode_mk" value="<?= esc($matakuliah['kode_mk']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_mk">Nama Mata Kuliah</label>
                            <input type="text" class="form-control" id="nama_mk" name="nama_mk" value="<?= esc($matakuliah['nama_mk']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="sks">Jumlah SKS</label>
                            <input type="number" class="form-control" id="sks" name="sks" value="<?= esc($matakuliah['sks']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select name="semester" id="semester" class="form-control" required>
                                <option value="">-- Pilih Semester --</option>
                                <?php for($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i; ?>" <?= ($matakuliah['semester'] == $i) ? 'selected' : ''; ?>>Semester <?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url('matakuliah'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

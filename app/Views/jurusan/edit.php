<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Formulir Edit Jurusan</h3></div>
                <form action="<?= base_url('jurusan/' . $jurusan['id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <!-- Tambahkan method spoofing di sini -->
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_jurusan">Nama Jurusan</label>
                            <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="<?= esc($jurusan['nama_jurusan']); ?>" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= base_url('jurusan'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

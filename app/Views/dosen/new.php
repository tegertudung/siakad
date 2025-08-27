<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1><?= esc($title); ?></h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Formulir Data Dosen</h3></div>
                <form action="<?= base_url('dosen'); ?>" method="post">
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
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>NIDN</label>
                            <input type="text" class="form-control" name="nidn" value="<?= old('nidn') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php foreach($jurusan as $jrs): ?>
                                    <option value="<?= $jrs['id']; ?>"><?= $jrs['nama_jurusan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="matakuliah_ids">Mata Kuliah yang Diampu</label>
                            <select name="matakuliah_ids[]" id="matakuliah_ids" class="form-control" multiple>
                                <!-- Opsi akan diisi oleh JavaScript -->
                            </select>
                            <small class="form-text text-muted">Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu.</small>
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
                        <a href="<?= base_url('dosen'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>

<?= $this->section('pageScripts'); ?>
<script>
$(document).ready(function(){
    $('#jurusan_id').on('change', function(){
        var jurusanId = $(this).val();
        if(jurusanId) {
            $.ajax({
                url: '<?= base_url('dosen/getMataKuliahByJurusan') ?>/' + jurusanId,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#matakuliah_ids').empty();
                    if(data.length > 0) {
                        $.each(data, function(key, value){
                            $('#matakuliah_ids').append('<option value="'+ value.id +'">'+ value.nama_mk +'</option>');
                        });
                    } else {
                        $('#matakuliah_ids').append('<option value="">-- Tidak ada mata kuliah --</option>');
                    }
                }
            });
        } else {
            $('#matakuliah_ids').empty();
        }
    });
});
</script>
<?= $this->endSection(); ?>
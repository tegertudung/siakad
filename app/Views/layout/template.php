<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIAKAD | <?= $title ?? 'Halaman'; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- Section untuk CSS tambahan per halaman -->
  <?= $this->renderSection('pageStyles'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Memanggil Navbar dari file terpisah -->
  <?= $this->include('layout/navbar'); ?>

  <!-- Memanggil Sidebar dari file terpisah -->
  <?= $this->include('layout/sidebar'); ?>

  <!-- Area Konten Utama (akan diisi oleh halaman lain) -->
  <?= $this->renderSection('content'); ?>
  
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">SIAKAD Mahasiswa</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>/dokumen/AdminLTE3/dist/js/adminlte.js"></script>

<!-- Section untuk JavaScript tambahan per halaman -->
<?= $this->renderSection('pageScripts'); ?>
</body>
</html>
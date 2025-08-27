<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('dashboard'); ?>" class="nav-link">Home</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <div class="image d-inline">
                <img src="<?= base_url(); ?>/dokumen/AdminLTE3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px;">
            </div>
            <span class="d-none d-md-inline ml-2"><?= session()->get('ses_nama') ?? 'Nama Pengguna'; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
                <i class="fas fa-user-cog mr-2"></i> Profile Settings
            </a>
            <a href="#" class="dropdown-item">
                <i class="fas fa-question-circle mr-2"></i> Bantuan
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('logout'); ?>" class="dropdown-item dropdown-footer text-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
    </li>
  </ul>
</nav>
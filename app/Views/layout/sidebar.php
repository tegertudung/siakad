<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('dashboard'); ?>" class="brand-link">
    <img src="<?= base_url(); ?>/dokumen/AdminLTE3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SIAKAD</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url(); ?>/dokumen/AdminLTE3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= session()->get('ses_nama') ?? 'Nama Pengguna'; ?></a>
        <!-- Tampilkan Role di bawah nama -->
        <span class="text-info"><?= ucfirst(session()->get('ses_role')) ?? 'Role'; ?></span>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- =================================================== -->
        <!-- MENU UNTUK ADMIN -->
        <!-- =================================================== -->
        <?php if (session()->get('ses_role') == 'admin') : ?>
            <li class="nav-header">MENU UTAMA</li>
            <li class="nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Master Data
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('jurusan'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Jurusan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('matakuliah'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Mata Kuliah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('dosen'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Dosen</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('mahasiswa'); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Mahasiswa</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header">PROSES AKADEMIK</li>
             <li class="nav-item">
                <a href="<?= base_url('tahunakademik'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Tahun Akademik</p>
                </a>
            </li>

        <?php endif; ?>

        <!-- =================================================== -->
        <!-- MENU UNTUK MAHASISWA -->
        <!-- =================================================== -->
        <?php if (session()->get('ses_role') == 'mahasiswa') : ?>
            <li class="nav-header">MENU UTAMA</li>
            <li class="nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">AKADEMIK</li>
            <li class="nav-item">
                <a href="<?= base_url('krs'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>Isi KRS</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('khs'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Lihat KHS</p>
                </a>
            </li>
        <?php endif; ?>
        
        <!-- =================================================== -->
        <!-- MENU UNTUK DOSEN -->
        <!-- =================================================== -->
        <?php if (session()->get('ses_role') == 'dosen') : ?>
            <li class="nav-header">MENU UTAMA</li>
            <li class="nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">AKADEMIK</li>
            <li class="nav-item">
                <a href="<?= base_url('nilai'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>Input Nilai</p>
                </a>
            </li>
        <?php endif; ?>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

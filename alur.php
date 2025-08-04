<html>
=========================================================================================
Alur Instalasi ci4 :
1. Install CI4 dengan Cara Download dan Letakkan Folder ci4 di dalam folder Root Server Anda
2. Pindah semua file yang ada di folder public ke Folder utama
3. Cari file index.php rubah require FCPATH . '../app/Config/Paths.php'; menjadi require FCPATH . '/app/Config/Paths.php';
4. Aktifkan env dengan menambahi titik di depannya .env
5. Hilangkan # pada #CI_ENVIRONMENT = production dan jika dalam posisi develope maka rubah jadi CI_ENVIRONMENT = development untuk menampilkan error ,kalau Live sudah diakses secara umum maka jangan lupa ganti jadi CI_ENVIRONMENT = production agar tidak ada error yang muncul di halaman browser
6. Edit File App.php yang ada di folder app/Config/App.php ,rubah base urlnya sesuai nama folder aplikasi kalian ex: public string $baseURL = 'http://localhost/manajemenuser2';
7. Kalau sudah buka browser dan akses aplikasi kalian dengan url http://localhost/manajemenuser2
8. Jika sudah berhasil maka akan muncul halaman welcome dari ci4

=========================================================================================
Alur Aplikasi Pasang admin LTE 3 sebagai template css aplikasi
1. Download template admin lte di github https://github.com/jeypips/AdminLTE3
2. Buat folder di dalam folder utama dengan nama folder dokumen dan pindahkan hasil download adminlte ke dalamnya

=========================================================================================
Alur Pembuatan Aplikasi
1. Buat dulu route utama atau route basurl nya di file routes yang berada di aap/Config/Routes.php buat seperti ini $routes->get('/', 'Auth\Login::index');
2. (Buat View) Buat tampilan halaman loginnya dengan cara : Buat folder "auth" di dalam folder app/Views/ dan buat file login.php di dalam folder auth tersebut
3. Isi view login.php dengan file halaman login yang disediakan admin lte
4. Rubah penunjukan url pada css pada head dan js nya di footer di dalam file html halaman login,rubah dengan <?= base_url();
                                                                                                                '/dokumen/adminlte3/gantisama seperti yang sudah tertulis di hamalam login bawaan adminlte' ?>
5. (Buat Controller) Buat Folder Auth di dalam controler dan didalam folder Auth buat file Login.php
6. (Buat Model) Buat file UserModel.php

=========================================================================================
Alur interaksi MVC (MODEL VIEW CONTROLLER) secara umum
[Pengunjung akses manajemenuser2]
-->[Routes / baseurl ter panggil] -- ROUTES
-->{Akan memanggil filter jika menerapkan filter jika tidak ada filter langsung ke controller} -- MIDLEWARE
-->[Controller Login.php fungsi index terpanggil] -- cONTROLLER
-->{Controler dapat memanggil Model jika ada interaksi dengan database,jika tidak langsung ke view} -- MODEL
-->[view/aut/login.php terpanggil]-->Halaman Browser menampilkan ke pengunjung -- VIEW

Alur Proses Bisnis Sistem Login yang Kita buat
1. Pengunjung manajemenuser2
2. Routes / baseurl ter panggil
3.


</html>
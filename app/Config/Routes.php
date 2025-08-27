<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//akses baseurl maka diarahkan ke Controller Auth fungsi index

// Route utama aplikasi, mengarahkan '/' (baseurl) ke halaman login
$routes->get('/', 'Auth\Login::index', ['filter' => 'AntiBruteForce']); // Halaman utama, login, dengan filter anti brute force

// Route untuk proses login (POST), login form submit
$routes->post('/trxlogin', 'Auth\Login::eseclogin', ['filter' => 'AntiBruteForce']); // Proses login, juga dilindungi anti brute force

// ====================
// Registrasi dengan OTP
// ====================

// Tampilkan form registrasi
$routes->get('/register', 'Auth\Register::index');
// Proses submit form registrasi, generate OTP, simpan session
$routes->post('/register/send', 'Auth\Register::send');
// Tampilkan form verifikasi OTP
$routes->get('/register/verify', 'Auth\Register::verify');
// Proses submit OTP (verifikasi OTP)
$routes->post('/register/verify', 'Auth\Register::verify');


// ====================
// Route untuk halaman penguncian akun
// ====================

// Halaman locked, hanya bisa diakses jika lolos filter blockViewLocked
$routes->get('/locked', 'Auth\Login::locked', ['filter' => 'blockViewLocked']);
// Halaman blocked, menampilkan info akun diblokir
$routes->get('/blocked', 'Auth\Login::blocked');


$routes->get('/dashboard', 'DashboardController::index'); // Halaman dashboard, hanya untuk user terautentikasi

$routes->resource('jurusan');

$routes->resource('matakuliah');

$routes->get('dosen/getMataKuliahByJurusan/(:num)', 'Dosen::getMataKuliahByJurusan/$1');
$routes->resource('dosen');

$routes->resource('mahasiswa');

$routes->get('tahunakademik/setActive/(:num)', 'TahunAkademik::setActive/$1');
$routes->resource('tahunakademik');

// Rute untuk Mahasiswa
$routes->get('/khs', 'Khs::index', ['filter' => 'auth']);
$routes->get('/krs', 'Krs::index', ['filter' => 'auth']);
$routes->post('/krs/save', 'Krs::save', ['filter' => 'auth']);


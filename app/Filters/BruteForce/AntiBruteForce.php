<?php

namespace App\Filters\BruteForce;
//Lokasi Filter AntiBruteForce
//Filter ini digunakan untuk mencegah serangan brute force pada sistem login
//Dengan cara memblokir IP yang melakukan percobaan login berulang kali
//dan memberikan pesan kepada pengguna jika IP mereka diblokir
//atau jika mereka harus menunggu sebelum mencoba lagi

use CodeIgniter\Filters\FilterInterface;                                            // FilterInterface digunakan untuk membuat filter
use CodeIgniter\HTTP\RequestInterface;                                              // RequestInterface digunakan untuk mendapatkan informasi tentang permintaan HTTP       
use CodeIgniter\HTTP\ResponseInterface;                                             // ResponseInterface digunakan untuk mengirimkan respons HTTP
use App\Models\LoginLogModel;                                                       // LoginLogModel digunakan untuk mencatat log login pengguna
use App\Models\IpBlockModel;                                                        // IpBlockModel digunakan untuk memblokir IP pengguna yang melakukan percobaan login berulang kali

class AntiBruteForce implements FilterInterface                                     // FilterInterface digunakan untuk membuat filter
{
    /**
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request           // RequestInterface digunakan untuk mendapatkan informasi tentang permintaan HTTP
     */

    public function before(RequestInterface $request, $arguments = null)            // Before method is called before the controller method
    {
        $logModel = new LoginLogModel();                                            // LoginLogModel digunakan untuk mencatat log login pengguna
        $IpBlockModel = new IpBlockModel();                                         // IpBlockModel digunakan untuk memblokir IP pengguna yang melakukan percobaan login berulang kali     
        $ipAddress = $request->getIPAddress();                                      // Mendapatkan alamat IP pengguna dari permintaan HTTP    
        $response = service('response');                                            // Mendapatkan instance dari service response untuk mengirimkan respons HTTP

        // TAHAP 1 => CEK IP PENGGUNA APAKAH DI BLOKIR ATAU TIDA DENGAN TANDA DI TABEL IP BLOCK ADA IP PENGGUNA
        if ($IpBlockModel->isIpBlocked($ipAddress)) { //Cek di tabel IpBlockModel apakah IP pengguna sudah ada didalamnya
            session()->setFlashdata('Pesan_kirimke_halaman_locked_via_url', 'Alamat IP Anda telah diblokir secara permanen.');
            if ($request->isAJAX()) {
                return $response->setJSON(['Pesan_kirimke_ajax' => 'Anda tidak bisa login Selama lamanya :D', 'lempar_ke_url' => base_url('locked')]);
            } else {
                return redirect()->to(base_url('locked'));
            }
        }

        //JIKA IP PENGGUNA TIDAK ADA DI TABEL IP BLOCK MAKA LANJUT KE TAHAP 2
        //TAHAP KE 2 =>
        //AMBIL DATA TERAHIR KALI DIA LOGIN TERUS SUKSES--->AMBIL SATU BARIS DATA TERAHIR
        $terahirsukses = $logModel->where(['ip_address' => $ipAddress, 'is_success' => true])->orderBy('id', 'DESC')->first();

        //AMBIL DATA 1 KOLOM DALAM SATU ROW yang berhasil login terahir === DATA LOGIN_AT ATAU TANGGAL NYA AJAH...
        $tanggalterahirsukses = $terahirsukses ? $terahirsukses['login_at'] : '1970-01-01 00:00:00';

        //KITA BIKIN ARRAY 
        $dataWhere = [
            'ip_address' => $ipAddress,
            'is_success' => false,
            'login_at >' => $tanggalterahirsukses //KITA AMBIL DATA IP PENGGUNA YANG GAGAL LOGIN DARI TANGGAL TERAHIR DIA LOGIN SUKSES perhatikan tanda >
        ];

        //Ambil data dari tabel log yang kondisinya sesuai dengan $dataWhere
        $getdata = $logModel->where($dataWhere)
            ->orderBy('id', 'ASC')
            ->findAll();

        //HITUNG JUMLAH DATA GAGAL LOGIN
        $JumlahGagal = count($getdata);

        //SIAPKAN VARIABEL UNTUK PESAN TERKUNCI
        $PesanTerkunci = '';

        //KITA BIKIN VARIABEL SHOULDLOCK KITA ISI DEFAULT FALSE
        $KunciAkun = false;

        //PERSIAPAN VARIABEL UNTUK MENAMPUNG DATA GAGAL LOGIN DAN WAKTU GAGAL LOGIN
        //=================>
        //KITA MULAI DARI PERCOBAAN YANG TERAKHIR ===> SAYA BATASIN 15 X PERCOBAAN
        if ($JumlahGagal >= 15) {
            //JIKA PERCOBAAN GAGAL ITU LEBIH DARI 15 MAKA =>
            //KITA SIMPAN IP PENGGUNA KE DALAM TABEL IP BLOCK
            $IpBlockModel->save([
                'ip_address' => $ipAddress,
                'reason'     => 'Gagal login >= 15 kali secara beruntun.'
            ]);
            $PesanTerkunci = 'Alamat IP Anda telah diblokir secara permanen karena terlalu banyak percobaan login.';
            $KunciAkun = true;
        } elseif ($JumlahGagal >= 10) {
            //JIKA PERCOBAAN GAGAL ITU LEBIH DARI 10 MAKA =>
            //BUAT VARIABEL WaktuShortpadabasiske10 = UNTUK MENAMPUNG JAM ATAU WAKTU DI KOLOM LOGIN_AT
            $WaktuShortpadabasiske10 = strtotime($getdata[9]['login_at']);  //AMBIL WAKTU DARI LOGIN_AT baris ke 10 kenapa array diambil yang ke 9 karena array dihitung dari 0,maka jika ingin menunjuk yang array ke 10 maka nulisnya 9

            //KITA SET WAKTU TUNGGUNYA 10 MENIT ITU 600 UNTUK TRIAL SAYA SENGAJA KASIH 9 UNTUK 9 DETIK
            //time() adalah fungsi untuk mendapatkan waktu saat ini dalam format detik.
            //Jika selisih waktu antara sekarang dan waktu percobaan gagal ke-10 masih kurang dari 9 detik, maka (ganti detikannya agar sessuai dengan waktu yang diinginkan)
            if (time() - $WaktuShortpadabasiske10 < 9) {
                // maka siapkan pesan error penguncian dan aktifkan status 'terkunci
                $PesanTerkunci = 'Anda telah gagal login 10 kali. Silakan coba lagi dalam 10 menit.';
                $KunciAkun = true;
            }
        } elseif ($JumlahGagal >= 5) {
            //JIKA PERCOBAAN GAGAL LEBIH DARI 5 X 
            //BUAT VARIABEL WaktuShortpadabasiske10 = UNTUK MENAMPUNG JAM ATAU WAKTU DI KOLOM LOGIN_AT
            $WaktuShortpadabasiske5 = strtotime($getdata[4]['login_at']);
            //KITA SET WAKTU TUNGGUNYA 5 MENIT ITU 300 UNTUK TRIAL SAYA SENGAJA KASIH 6 UNTUK 6 DETIK
            //time() adalah fungsi untuk mendapatkan waktu saat ini dalam format detik.
            //Jika selisih waktu antara sekarang dan waktu percobaan gagal ke-5 masih kurang dari 6 detik, maka (ganti detikannya agar sessuai dengan waktu yang diinginkan)
            if (time() - $WaktuShortpadabasiske5 < 6) {
                // maka siapkan pesan error penguncian dan aktifkan status 'terkunci
                $PesanTerkunci = 'Anda telah gagal login 5 kali. Silakan coba lagi dalam 1 menit.';
                $KunciAkun = true;
            }
        }
        //============================>
        //ESEKUSI VARIABEL YANG SESUAI DENGAN KONDISI DI ATAS
        //=================>
        if ($KunciAkun) { //jika Variabel KunciAkun bernilai true, maka lakukan tindakan berikut
            if ($JumlahGagal >= 10) {
                $WaktuTerkunci = strtotime($getdata[9]['login_at']) + 9;
            } else {
                $WaktuTerkunci = strtotime($getdata[4]['login_at']) + 6;
            }

            $dataKirimKeViewLocked = [
                'pesanTerkunci' => $PesanTerkunci, //Pesan yang akan ditampilkan di halaman terkunci
                'WaktuTerkunci' => $WaktuTerkunci
            ];
            session()->set('sesi_dataTerkunci', $dataKirimKeViewLocked); //Simpan data penguncian ke dalam session

            if ($request->isAJAX()) {
                return $response->setJSON(['Pesan_kirimke_ajax' => 'terkuncidenganwaktu', 'lempar_ke_url' => base_url('locked')]);
            } else {
                return redirect()->to(base_url('locked'));
            }
        }
        //JIKA KONDISI DI ATAS TIDAK TERCAPAI MAKA TIDAK ADA YANG DIESEKUSI alias filter ini tidak menghalangi proses login
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

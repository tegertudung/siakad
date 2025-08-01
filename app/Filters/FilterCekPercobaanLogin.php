<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LoginLogModel;
use App\Models\IpBlockModel;

class FilterCekPercobaanLogin implements FilterInterface
{
    /**
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     */

    public function before(RequestInterface $request, $arguments = null)
    {
        //load model
        $logModel = new LoginLogModel();
        $IpBlockModel = new IpBlockModel();
        $ipAddress = $request->getIPAddress();
        $response = service('response');

        // TAHAP 1 => CEK IP PENGGUNA APAKAH DI BLOKIR ATAU TIDA DENGAN TANDA DI TABEL IP BLOCK ADA IP PENGGUNA
        //jika $ipadres itu yang ngakses itu sudah ada di tabel blockip 
        //kalau gak false atau null maka --->
        if ($IpBlockModel->isIpBlocked($ipAddress)) {
            //tampilkan pesan ini kita set ke dalam setFlashdata
            session()->setFlashdata('lock_message', 'Alamat IP Anda telah diblokir secara permanen.');

            if ($request->isAJAX()) {
                //JIKA DIA NGAKSES LEWAT PERMINTAAN AJAX MAKA
                //KITA AKAN ARAHIN KE HALAMAN LOCKED DENGAN PESAN PERMANENT = 'lock_type' = 'permanent'
                return $response->setJSON(['lock_type' => 'permanent', 'redirect_url' => base_url('locked')]);
            } else {
                //kalau dia ngakses baseurl tidak melalui ajax maka
                return redirect()->to(base_url('locked'));
            }
        }

        //KALAU TIDAK ADA DATA DI TABEL IP BLOCK MAKA LANJUT-->
        //TAHAP KE 2 =>
        //AMBIL DATA TERAHIR KALI DIA LOGIN TERUS SUKSES--->AMBIL SATU BARIS DATA TERAHIR
        $lastSuccess = $logModel->where(['ip_address' => $ipAddress, 'is_success' => true])->orderBy('id', 'DESC')->first();

        //AMBIL DATA 1 KOLOM DALAM SATU ROW yang berhasil login terahir === DATA LOGIN_AT ATAU TANGGAL NYA AJAH...
        $lastSuccessTime = $lastSuccess ? $lastSuccess['login_at'] : '1970-01-01 00:00:00';

        //KITA BIKIN ARRAY 
        $whereClauses = [
            'ip_address' => $ipAddress,
            'is_success' => false,
            'login_at >' => $lastSuccessTime
        ];

        //kemudian cek data yang TIDAK BERHASIL LOGIN 
        $failedAttempts = $logModel->where($whereClauses)
            ->orderBy('id', 'ASC')
            ->findAll();

        //HITUNG JUMLAH DATA GAGAL LOGIN
        $failedCount = count($failedAttempts);

        //SIAPKAN VARIABEL UNTUK PESAN TERKUNCI
        $lockMessage = '';

        //KITA BIKIN VARIABEL SHOULDLOCK KITA ISI DEFAULT FALSE
        $shouldLock = false;


        //=================>
        //KITA MULAI DARI PERCOBAAN YANG TERAKHIR ===> SAYA BATASIN 15 X PERCOBAAN
        if ($failedCount >= 15) {
            //KITA HITUNG PERCOBAAN GAGAL LEBI DARI 15 GAK,KALAU IYA MAKA==>

            //KITA MASUKKAN DATA IP PENGGUNA YANG GAGAL LOGIN 15 X KE DB TABEL IPBLOCKED--->
            $IpBlockModel->save([
                'ip_address' => $ipAddress,
                'reason'     => 'Gagal login >= 15 kali secara beruntun.'
            ]);
            $lockMessage = 'Alamat IP Anda telah diblokir secara permanen karena terlalu banyak percobaan login.';
            $shouldLock = true;
        } elseif ($failedCount >= 10) {
            //JIKA PERCOBAAN GAGAL ITU LEBIH DARI 10 MAKA =>
            //BUAT VARIABEL tenthFailTime = UNTUK MENAMPUNG JAM ATAU WAKTU DI KOLOM LOGIN_AT
            $tenthFailTime = strtotime($failedAttempts[9]['login_at']);

            //KITA SET WAKTU TUNGGUNYA 10 MENIT ITU 600 UNTUK TRIAL SAYA SENGAJA KASIH 9 UNTUK 9 DETIK
            if (time() - $tenthFailTime < 9) {
                //HITUNG MUNDUR --- DARI WAKTU YANG DITENTUKAN
                $lockMessage = 'Anda telah gagal login 10 kali. Silakan coba lagi dalam 10 menit.';
                $shouldLock = true;
            }
        } elseif ($failedCount >= 5) {
            //JIKA PERCOBAAN GAGAL LEBIH DARI 5 X 
            $fifthFailTime = strtotime($failedAttempts[4]['login_at']);
            //AMBIL WAKTU DARI LOGIN_AT
            if (time() - $fifthFailTime < 6) {
                //HITUNG MUNDUR --- DARI WAKTU YANG DITENTUKAN
                $lockMessage = 'Anda telah gagal login 5 kali. Silakan coba lagi dalam 1 menit.';
                $shouldLock = true;
            }
        }
        //INI SAYA BUAT UNTUK MENAMPILKAN PESAN GAGAL LOGIN DI HALAMAN LOGIN
        //DAN UNTUK MENAMPILKAN HITUNGAN MUNDUR WAKTU TUNGGU UNTUK LOGIN KEMBALI
        if ($shouldLock) {
            //JIKA TRUE MAKA =>
            if ($failedCount >= 10) {
                $lockExpiryTime = strtotime($failedAttempts[9]['login_at']) + 9;
            } else {
                $lockExpiryTime = strtotime($failedAttempts[4]['login_at']) + 6;
            }

            $lockData = [
                'message' => $lockMessage,
                'expiration_time' => $lockExpiryTime
            ];
            session()->set('lock_data', $lockData);

            if ($request->isAJAX()) {
                return $response->setJSON(['lock_type' => 'timed', 'redirect_url' => base_url('locked')]);
            } else {
                return redirect()->to(base_url('locked'));
            }
        }
        //JIKA KONDISI DI ATAS TIDAK TERCAPAI MAKA TIDAK ADA YANG DIESEKUSI
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoginLogModel;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }
    public function eseclogin()
    {

        //CEKING LOGIN TAHAP 1   =>
        //==================MULAI VALIDASI---->
        // $rules = [
        //     'ganti_dengan_name_inputan' => [
        //         'label' => 'ganti_label_bebas',
        //         'rules' => 'required|max_length[100]',
        //     ]
        // ];
        $rules = [
            'credential' => [
                'label' => 'Email atau Username',
                'rules' => 'required|max_length[100]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
            ],
        ];
        //==================AKHIR VALIDASI---->
        //Jka validasi di variabel $rule itu salah maka ! jika false atau null bukan hal benar
        if (!$this->validate($rules)) {
            //ini jika salah---->
            //return mengembalikan nilai dan menghentikan esekusi coding,,,,
            //var_dump();
            //exit();
            return $this->response->setJSON([
                'kondisi' => false,
                'pesan' => $this->validator->getErrors()['credential'] ?? $this->validator->getErrors()['password'],
                'csrf_baru' => csrf_hash(),
            ]);
        }

        // CEKING LOGIN TAHAP 2 =>
        $email = $this->request->getPost('credential');
        $password = $this->request->getPost('password');


        //kita ambil data user dulu dari database ===>
        $userModel = new UserModel();
        $user = $userModel->getDataUserByEmail($email);
        //=======>
        //masuk cek data---> 
        //jika var user itu null atau false atau password tidak sesuai  arti dari || or semua harus benar maka true jika salah satu salah maka false
        if (!$user || !password_verify($password, $user['password_hash'])) {
            //masukan data user yang mencoba login ke dalam tabel log
            $LoginLogModel = new LoginLogModel();
            $LoginLogModel->save([
                'user_id'         => $user['id'] ?? null,
                'ip_address'      => $this->request->getIPAddress(),
                'user_agent'      => $this->request->getUserAgent()->getAgentString(),
                'is_success'      => false,
                'credential_used' => $email,
            ]);


            // Buat Variabel untuk mencatat tanggal terahir si user berhasil Login
            $TanggalBerhasilLoginTerakhir = $LoginLogModel->where(['ip_address' => $this->request->getIPAddress(), 'is_success' => true])->orderBy('id', 'DESC')->first()['login_at'] ?? '1970-01-01';
            //Hitung Jumlah User Gagal Login dihitungdari terahir dia berhasil login
            $JumlahKegagalanLogin = $LoginLogModel->where(['ip_address' => $this->request->getIPAddress(), 'is_success' => false, 'login_at >' => $TanggalBerhasilLoginTerakhir])->countAllResults();

            return $this->response->setJSON([
                'kondisi'        => false,
                'pesan'       => 'Email atau Password Salah !',
                'jumlah_gagal_login'  => $JumlahKegagalanLogin,
                'csrf_baru' => csrf_hash()
            ]);
        }


        //CEK TAHAP 3 =>
        $aktif_user = $user['is_aktif'];
        if (!$aktif_user == 1) {
            return $this->response->setJSON([
                'kondisi' => false,
                'pesan' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                'csrf_baru' => csrf_hash()
            ]);
        }

        //TAHAP BERHASIL MELALUI TAHAP CEKING DATA---MAKA BOLEH LOGIN 
        //KITA SET SESI
        $session = session();
        $sessionData = [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'isLoggedIn' => true,
        ];
        $session->set($sessionData);

        //SET SESI SELESAI
        //MASUKKAN DATA KE TABEL USER,UNTUK MENANDAI JIKA BERHASIL LOGIN
        $LoginLogModel = new LoginLogModel();
        $LoginLogModel->save([
            'user_id'    => $user['id'],
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'is_success' => true,
            'credential_used' => $email,
        ]);
        //RETURN UNTUK MENGEMBALIKAN DATA DAN MENGHENTIKAN JALANNYA PROSES
        return $this->response->setJSON([
            'kondisi' => true,
            'pesan' => 'Login Berhasil!',
            // 'redirect_url' => base_url('dashboard'),
            'csrf_baru' => csrf_hash()
        ]);
    }

    public function locked()
    {
        $lockData = session()->get('lock_data');

        session()->remove('lock_data');
        $data['message'] = $lockData['message'] ?? 'Terlalu banyak percobaan login.';
        $data['expiration_time'] = $lockData['expiration_time'] ?? null;

        return view('auth/locked', $data);
    }
}

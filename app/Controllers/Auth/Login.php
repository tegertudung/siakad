<?php

namespace App\Controllers\Auth;                                                                 //Lokasi Controler Ini
//LOKASI FILE YANG AKAN DI LOAD
use App\Controllers\BaseController;                                                             //BaseControler tujuannya adalah penyedia shortcut dari ci yang kalian bisa gunakan misal ($this->request,$this->response,$this->logger,$this->session,$this->validate())                                                       
use App\Models\UserModel;                                                                       //Tabel User Akun
use App\Models\LoginLogModel;                                                                   //Tabel Log/Riwayat Login

class Login extends BaseController                                                              //Class Login yang menginduk ke Basecontroler jadi agar bisa menggunakan fasilitas yang disediakan oleh basecontroler
{
    public function index()                                                                     //Fungsi Public index untuk menampilkan halamna login yang dapat dipanggil Route
    {
        return view('auth/login');                                                              //Mengembalikan nilai dan menghentikan proses, untuk mengakses Folder View->Folder auth ->file login.php
    }
    public function eseclogin()                                                                 //Public fungsi eseclogin untuk memproses transaksi login pengguna
    {
        //LOAD YANG KITA BUTUHKAN
        $userModel = new UserModel();                                                           //Tabel User Akun
        $LoginLogModel = new LoginLogModel();                                                   //Tabel Log atau riwayat Login
        // ***************************************************** LOAD END *****************************************************
        // 
        //CEKING LOGIN TAHAP 1 ( Cek apakah entrian yang dilakukan sudah sesuai dengan aturan yang kita buat ) =>
        $rules = [
            'credential' => [                                                                   //Name sesuai inputan di halaman login
                'label' => 'Email atau Username',                                               //Label bebas mau di isi apa
                'rules' => 'required|max_length[100]',                                          //Load Rule dari validate bawaan ci ,bisa ditambah sesuai kebutuhan
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
            ],
        ];

        if (!$this->validate($rules)) {                                                         //Login pengecekan Validasi Fokus Ke False
            // KEMBALIKAN NILAI KE HALAMAN LOGIN DAN HENTIKAN PROSES
            return $this->response->setJSON([                                                   //Mengembalikan Nilai ke yang minta yaitu ajax dihalaman login serta menghentikan Proses
                'status' => false,                                                              //Buat Variabel status dengan nilai false
                'pesan' => $this->validator->getErrors()['credential'] ?? $this->validator->getErrors()['password'], //Buat Variabel pesan dengan nilai error dari validator beserta label
                'csrf_baru' => csrf_hash(),                                                     //Buat Variabel csrf_baru dengan nilai token yang baru dari ci4
            ]);
        }

        // ***************************************************** TAHAP 1 END *****************************************************
        // 
        // CEKING LOGIN TAHAP 2 ( Cek apakah Email dan Password Sesuai dengan yang ada di database )=>
        $email = $this->request->getPost('credential');                                         //Ambil Email dari inputan di halaman login
        $password = $this->request->getPost('password');                                        //Ambil Password dari inputan di halaman login

        $user = $userModel->getDataUserByEmail($email);                                         //Ambil data User dari tabel user berdasarkan email yang di inputkan

        if (!$user || !password_verify($password, $user['password_hash'])) {                    //Jika tidak ada user atau password tidak sesuai
            //Masukkan Ke Log/Riwayah Login Dengan Status /is_success false (gagal)
            $LoginLogModel->save([
                'user_id'         => $user['id'] ?? null,                                       //Masukkan data di kolom user_id jika email yang di inputkan benar maka akan ada idnya jika email salah maka id nya di isi null
                'ip_address'      => $this->request->getIPAddress(),                            //Masukkan data di kolom ip_address diambil dari ip_adress pengunjung yang login menggunakan fungsi bawaan ci4
                'user_agent'      => $this->request->getUserAgent()->getAgentString(),          //Masukkan data di kolom user_agent (login pakai browser tipe apa),dengan fungsi yang sudah di sediakan ci4
                'is_success'      => false,                                                     //Masukkan data false di kolom is_success
                'credential_used' => $email,                                                    //Masukkan email yang di inputkan oleh pengunjung ke kolom credential_used
            ]);
            //AMBIL DATA DARI TABEL LOG UNTUK DITAMPILKAN JUMLAH KEGAGALAN LOGIN DI HALAMAN LOGIN
            $TanggalBerhasilLoginTerakhir = $LoginLogModel->where(['ip_address' => $this->request->getIPAddress(), 'is_success' => true])->orderBy('id', 'DESC')->first()['login_at'] ?? '1970-01-01';
            $JumlahKegagalanLogin = $LoginLogModel->where(['ip_address' => $this->request->getIPAddress(), 'is_success' => false, 'login_at >' => $TanggalBerhasilLoginTerakhir])->countAllResults();
            // KEMBALIKAN NILAI KE HALAMAN LOGIN DAN HENTIKAN PROSES
            return $this->response->setJSON([
                'status'        => false,                                                       //Buat Variabel status dengan nilai false
                'pesan'       => 'Email atau Password Salah !',                                 //Buat Variabel pesan dengan nilai error dari validator beserta label
                'jumlah_kegagalan'  => $JumlahKegagalanLogin,                                   //Buat Variabel jumlah_kegagalan dengan nilai jumlah kegagalan login
                'csrf_baru' => csrf_hash()                                                      //Buat Variabel csrf_baru dengan nilai token yang baru dari ci4
            ]);
        }

        // ***************************************************** TAHAP 2 END *****************************************************
        // 
        // CEKING LOGIN TAHAP 3 ( Cek apakah Akun ini aktif atau tidak )=>
        $aktif_user = $user['is_aktif'];                                                        //Ambil data is_aktif dari tabel user berdasarkan email yang di inputkan
        if (!$aktif_user == 1) {                                                                //Jika tidak aktif 0 Jika Aktif 1  ,Jika tidak 1 maka
            //KEMBALIKAN NILAI KE HALAMAN LOGIN DAN HENTIKAN PROSES
            return $this->response->setJSON([
                'status' => false,                                                              //Buat Variabel status dengan nilai false
                'pesan' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',             //Buat Variabel pesan dengan nilai error dari validator beserta label
                'csrf_baru' => csrf_hash()                                                      //Buat Variabel csrf_baru dengan nilai token yang baru dari ci4
            ]);
        }
        // ***************************************************** TAHAP 3 END *****************************************************
        // 
        // TAHAP 4 LOLOS CEK LOGIN TAHAP 1-3 ( Proses Login dengan set sesi dan meneruskan ke halaman Dashboard )
        $sesi = session();                                                                      //panggil session dan simpan di variabel sessi
        $datasesi = [                                                                           //buat data array sesi sesuai dengan data yang ada di tabel user
            'ses_user_id'       => $user['id'],                                                 //Buat variabel ses_user_id dengan nilai id dari tabel user
            'ses_email'         => $user['email'],                                              //Buat variabel ses_email dengan nilai email dari tabel user
            'ses_username'      => $user['username'],                                           //Buat variabel ses_username dengan nilai username dari tabel user
            'ses_nama'          => $user['nama_lengkap'],                                       //Buat variabel ses_nama dengan nilai nama_lengkap dari tabel user
            'ses_isLoggedIn'    => true                                                         //Buat variabel ses_isLoggedIn dengan nilai true                             
        ];
        $sesi->set($datasesi);                                                                  //Set ke session

        //Masukkan Ke Log/Riwayah Login Dengan Status /is_success true (Berhasil)
        $LoginLogModel->save([
            'user_id'    => $user['id'],                                                        //Masukkan data di kolom user_id jika email yang di inputkan benar maka akan ada idnya jika email salah maka id nya di isi null
            'ip_address' => $this->request->getIPAddress(),                                     //Masukkan data di kolom ip_address diambil dari ip_adress pengunjung yang login menggunakan fungsi bawaan ci4
            'user_agent' => $this->request->getUserAgent()->getAgentString(),                   //Masukkan data di kolom user_agent (login pakai browser tipe apa),dengan fungsi yang sudah di sediakan ci4
            'is_success' => true,                                                               //Masukkan data true di kolom is_success
            'credential_used' => $email,                                                        //Masukkan email yang di inputkan oleh pengunjung ke kolom credential_used
        ]);
        //KEMBALIKAN NILAI KE HALAMAN LOGIN DAN HENTIKAN PROSES
        return $this->response->setJSON([
            'status' => true,                                                                   //Buat Variabel status dengan nilai true
            'pesan' => 'Login Berhasil!',                                                       //Buat Variabel pesan dengan
            'ke_route' => base_url('dashboard'),                                                //Buat Variabel ke_route dengan nilai route dashboard yang nantinya di panggil melalui jquery
            'csrf_baru' => csrf_hash()                                                          //Buat Variabel csrf_baru dengan nilai token yang baru dari ci4
        ]);
    }

    public function locked()
    {
        $dataSesi = session()->get('sesi_dataTerkunci'); //Ambil data sesi terkunci dari session yang diset dari filter AntiBruteForce
        session()->remove('sesi_dataTerkunci'); //Hapus data sesi terkunci dari session agar tidak mengganggu sesi lain(agar tidak terkunci terus jika waktu sudah habis)
        $data['pesanPercobaanLogin'] = $dataSesi['pesanTerkunci'] ?? 'Terlalu banyak percobaan login.';
        $data['WaktuTerkunci'] = $dataSesi['WaktuTerkunci'] ?? null;

        return view('auth/locked', $data);
    }
    public function blocked()
    {
        return view('blocked');
    }
    // === secutiry ====
    public function antibruteforce() {}
}

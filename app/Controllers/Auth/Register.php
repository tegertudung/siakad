<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\OtpModel;


// Controller untuk proses registrasi user baru dengan OTP email
class Register extends BaseController
{
    // Tampilkan form registrasi
    public function index()
    {
        // Memuat helper untuk form, url, dan CSRF agar bisa digunakan di view
        helper(['form', 'url', 'security']);
        // Tampilkan halaman form registrasi
        return view('auth/register');
    }

    // Proses pengiriman OTP setelah user submit form registrasi
    public function send()
    {
        // Memuat helper untuk form, url, dan CSRF
        helper(['form', 'url', 'security']);
        
        // Validasi input form
        $rules = [
            'credential'   => 'required|valid_email|is_unique[users.email]|max_length[100]', // Email harus unik
            'username'     => 'required|min_length[4]|max_length[30]|is_unique[users.username]', // Username harus unik
            'nama_lengkap' => 'required|min_length[4]|max_length[100]',
            'password'     => 'required|min_length[6]',
        ];
        // Jika validasi gagal, kembalikan ke form dengan error
        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors(),
                    'csrf_baru' => csrf_hash(),
                ]);
            }
            return view('auth/register', ['validation' => $this->validator]);
        }
        // Ambil data dari form
        $email        = $this->request->getPost('credential');
        $username     = $this->request->getPost('username');
        $namaLengkap  = $this->request->getPost('nama_lengkap');
        $password     = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // Enkripsi password
        // Generate OTP 6 digit dan waktu kadaluarsa 10 menit
        $otp       = rand(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        // Simpan OTP ke database
        $otpModel = new OtpModel();
        $otpModel->insert(['email' => $email, 'otp' => $otp, 'expires_at' => $expiresAt]);
        // Simpan data registrasi ke session untuk proses verifikasi OTP
        session()->set('register_data', [
            'email'        => $email,
            'username'     => $username,
            'nama_lengkap' => $namaLengkap,
            'password'     => $password,
        ]);
        
        // Untuk testing: set OTP di session agar bisa ditampilkan di halaman verifikasi
        session()->set('temp_otp_for_testing', $otp);
        
        // Kirim OTP ke email user
        if (!$this->sendEmailOtp($email, $otp)) {
            // Jika email gagal terkirim, tetap lanjutkan (untuk testing)
            log_message('warning', 'Email OTP failed to send, but continuing for testing purposes');
        }
        // Jika request AJAX, kirim response JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => true,
                'redirect_url' => site_url('register/verify'),
                'csrf_baru' => csrf_hash(),
            ]);
        }
        // Redirect ke halaman verifikasi OTP
        return redirect()->to('/register/verify');
    }

    // Fungsi untuk mengirim email OTP ke user
    private function sendEmailOtp(string $email, string $otp)
    {
        $emailService = \Config\Services::email(); // Ambil service email dari konfigurasi
        
        $emailService->setTo($email); // Tujuan email
        $emailService->setSubject('Kode OTP Registrasi - Manajemen User'); // Subjek email
        // Isi email HTML
        $emailService->setMessage("
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #007bff; text-align: center;'>Kode OTP Registrasi</h2>
                <div style='background: #f8f9fa; padding: 20px; border-radius: 5px; text-align: center;'>
                    <p style='font-size: 16px; margin-bottom: 20px;'>Terima kasih telah mendaftar. Gunakan kode OTP berikut untuk menyelesaikan registrasi Anda:</p>
                    <div style='background: #007bff; color: white; font-size: 32px; font-weight: bold; padding: 15px; border-radius: 5px; letter-spacing: 3px;'>{$otp}</div>
                    <p style='margin-top: 20px; color: #6c757d;'>Kode ini berlaku selama <strong>10 menit</strong></p>
                    <p style='margin-top: 10px; color: #dc3545; font-size: 14px;'>Jangan bagikan kode ini kepada siapapun!</p>
                </div>
                <p style='margin-top: 20px; font-size: 12px; color: #6c757d; text-align: center;'>
                    Email ini dikirim secara otomatis dari sistem Manajemen User. Jika Anda tidak melakukan registrasi, abaikan email ini.
                </p>
            </div>
        ");
        
        try {
            // Kirim email, jika sukses return true, jika gagal log error dan return false
            if ($emailService->send()) {
                log_message('info', 'OTP email sent successfully to: ' . $email);
                return true;
            } else {
                log_message('error', 'Failed to send OTP email to: ' . $email . ' - ' . $emailService->printDebugger());
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception while sending OTP email to: ' . $email . ' - ' . $e->getMessage());
            return false;
        }
    }

    // Form dan proses verifikasi OTP
    public function verify()
    {
        // Logging untuk debugging
        log_message('info', '=== VERIFY METHOD ACCESSED ===');
        log_message('info', 'Request method: ' . $this->request->getMethod());
        log_message('info', 'Request URI: ' . $this->request->getUri());
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        
        // Memuat helper untuk form, url, dan CSRF
        helper(['form', 'url', 'security']);
        
        $session = session();
        $regData = $session->get('register_data'); // Ambil data registrasi dari session
        
        log_message('info', 'Register data from session: ' . json_encode($regData));
        
        // Jika tidak ada data registrasi di session, redirect ke form register
        if (!$regData) {
            log_message('error', 'No register data found in session, redirecting to register');
            return redirect()->to('/register');
        }
        
        // Jika form OTP disubmit
        if ($this->request->getPost('otp') !== null) {
            log_message('info', 'POST request detected for OTP verification');
            $inputOtp = $this->request->getPost('otp');
            log_message('info', 'OTP verification attempt for email: ' . $regData['email'] . ' with OTP: ' . $inputOtp);
            
            $otpModel = new OtpModel();
            
            // Debug: cek semua data OTP di database untuk email ini
            $allOtpRecords = $otpModel->where('email', $regData['email'])->findAll();
            log_message('info', 'All OTP records for email ' . $regData['email'] . ': ' . json_encode($allOtpRecords));
            
            // Cari record OTP yang cocok
            $record = $otpModel->where('email', $regData['email'])->where('otp', $inputOtp)->first();
            log_message('info', 'OTP record found: ' . json_encode($record));
            
            // Jika OTP tidak cocok
            if (!$record) {
                log_message('error', 'OTP verification failed: OTP not found for email ' . $regData['email'] . ' with OTP ' . $inputOtp);
                return view('auth/verify_otp', ['error' => 'OTP salah.']);
            }
            
            // Jika OTP kadaluarsa
            if (date('Y-m-d H:i:s') > $record['expires_at']) {
                $otpModel->delete($record['id']);
                $session->remove('register_data');
                log_message('error', 'OTP verification failed: OTP expired for email ' . $regData['email']);
                return view('auth/verify_otp', ['error' => 'OTP kadaluarsa.']);
            }
            
            try {
                $userModel = new UserModel();
                
                // Debug: test koneksi database
                try {
                    $db = \Config\Database::connect();
                    log_message('info', 'Database connection successful');
                    log_message('info', 'Database name: ' . $db->getDatabase());
                } catch (\Exception $dbEx) {
                    log_message('error', 'Database connection failed: ' . $dbEx->getMessage());
                }
                
                // Data user yang akan disimpan ke database
                $insertData = [
                    'email'         => $regData['email'],
                    'username'      => $regData['username'],
                    'nama_lengkap'  => $regData['nama_lengkap'],
                    'password_hash' => $regData['password'],
                    'is_active'     => true,   // boolean
                    'is_aktif'      => 1,      // smallint (int2)
                ];
                
                // Debug: cek field tabel users
                $tableFields = $userModel->db->getFieldNames('auth.users');
                log_message('info', 'Users table fields: ' . json_encode($tableFields));
                
                log_message('info', 'Attempting to insert user data: ' . json_encode($insertData));
                $result = $userModel->insert($insertData);
                
                // Jika gagal insert, tampilkan error
                if (!$result) {
                    $errors = $userModel->errors();
                    log_message('error', 'User insert failed: ' . json_encode($errors));
                    return view('auth/verify_otp', ['error' => 'Gagal menyimpan data user: ' . implode(', ', $errors)]);
                }
                
                log_message('info', 'User successfully created with ID: ' . $result);
                // Hapus OTP dan data session registrasi
                $otpModel->delete($record['id']);
                $session->remove('register_data');
                $session->remove('temp_otp_for_testing');
                
                // Redirect ke halaman login dengan pesan sukses
                return redirect()->to('/')->with('success', 'Registrasi berhasil. Akun Anda sudah terdaftar, silakan login.');
                
            } catch (\Exception $e) {
                log_message('error', 'Exception during user creation: ' . $e->getMessage());
                return view('auth/verify_otp', ['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        }
        
        // Jika halaman diakses GET atau belum submit OTP, tampilkan form verifikasi
        log_message('info', 'Displaying OTP verification form');
        return view('auth/verify_otp');
    }
}


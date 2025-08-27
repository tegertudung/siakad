<?php

// Perbarui namespace agar sesuai dengan lokasi folder baru
namespace App\Filters\Auth;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika session 'ses_isLoggedIn' tidak ada atau nilainya bukan true
        if (session()->get('ses_isLoggedIn') != true) {
            // Maka paksa user kembali ke halaman login
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah controller dieksekusi
    }
}

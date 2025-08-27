<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use App\Models\JurusanModel;
use App\Models\MataKuliahModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role = session()->get('ses_role');
        $data = ['title' => 'Dashboard'];

        if ($role == 'admin') {
            // Panggil semua model yang dibutuhkan
            $mahasiswaModel = new MahasiswaModel();
            $dosenModel = new DosenModel();
            $jurusanModel = new JurusanModel();
            $mataKuliahModel = new MataKuliahModel();

            // Hitung jumlah data dan tambahkan ke array $data
            $data['jumlah_mahasiswa'] = $mahasiswaModel->countAllResults();
            $data['jumlah_dosen'] = $dosenModel->countAllResults();
            $data['jumlah_jurusan'] = $jurusanModel->countAllResults();
            $data['jumlah_matakuliah'] = $mataKuliahModel->countAllResults();
            
            return view('dashboard/admin', $data);

        } elseif ($role == 'dosen') {
            return view('dashboard/dosen', $data);
        } elseif ($role == 'mahasiswa') {
            return view('dashboard/mahasiswa', $data);
        } else {
            session()->destroy();
            return redirect()->to('/');
        }
    }
}
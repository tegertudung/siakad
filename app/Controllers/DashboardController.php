<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use App\Models\JurusanModel;
use App\Models\MataKuliahModel;
use App\Models\KrsModel; // <-- Pastikan ini ada

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
            // --- LOGIKA BARU UNTUK MAHASISWA ---
            helper('nilai'); // Panggil helper yang akan kita buat
            $mahasiswaModel = new MahasiswaModel();
            $krsModel = new KrsModel();

            $userId = session()->get('ses_user_id');
            $mahasiswa = $mahasiswaModel->where('user_id', $userId)->first();

            // Jika data mahasiswa tidak ditemukan, hentikan proses
            if (!$mahasiswa) {
                session()->destroy();
                return redirect()->to('/')->with('error', 'Data mahasiswa tidak ditemukan. Silakan login kembali.');
            }

            $krs = $krsModel->select('krs.tahun_akademik, krs.nilai, mata_kuliah.sks')
                           ->join('mata_kuliah', 'mata_kuliah.id = krs.matakuliah_id')
                           ->where('krs.mahasiswa_id', $mahasiswa['id'])
                           ->where('krs.nilai !=', null) // Hanya ambil yang sudah ada nilainya
                           ->findAll();
            
            // Hitung IPK dan siapkan data untuk chart
            $total_sks = 0;
            $total_bobot = 0;
            $ips_per_semester = [];

            foreach ($krs as $item) {
                $total_sks += $item['sks'];
                $total_bobot += konversi_nilai_ke_bobot($item['nilai']) * $item['sks'];

                // Kelompokkan SKS dan Bobot per semester untuk menghitung IPS
                if (!isset($ips_per_semester[$item['tahun_akademik']])) {
                    $ips_per_semester[$item['tahun_akademik']] = ['total_sks' => 0, 'total_bobot' => 0];
                }
                $ips_per_semester[$item['tahun_akademik']]['total_sks'] += $item['sks'];
                $ips_per_semester[$item['tahun_akademik']]['total_bobot'] += konversi_nilai_ke_bobot($item['nilai']) * $item['sks'];
            }

            $ipk = ($total_sks > 0) ? number_format($total_bobot / $total_sks, 2) : 0;
            
            // Siapkan data final untuk chart
            $chart_labels = [];
            $chart_data = [];
            foreach ($ips_per_semester as $semester => $values) {
                $chart_labels[] = $semester;
                $chart_data[] = ($values['total_sks'] > 0) ? number_format($values['total_bobot'] / $values['total_sks'], 2) : 0;
            }

            $data = [
                'title' => 'Dashboard Mahasiswa',
                'ipk' => $ipk,
                'chart_labels' => json_encode($chart_labels),
                'chart_data' => json_encode($chart_data),
            ];
            return view('dashboard/mahasiswa', $data);
            
        } else {
            session()->destroy();
            return redirect()->to('/');
        }
    }
}

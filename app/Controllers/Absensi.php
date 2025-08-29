<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\PengajaranModel;
use App\Models\TahunAkademikModel;
use App\Models\KrsModel;
use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    // Halaman untuk Dosen memilih mata kuliah
    public function index()
    {
        $dosenModel = new DosenModel();
        $pengajaranModel = new PengajaranModel();
        
        $userId = session()->get('ses_user_id');
        $dosen = $dosenModel->where('user_id', $userId)->first();

        $matakuliah_diajar = $pengajaranModel->select('mata_kuliah.id, mata_kuliah.kode_mk, mata_kuliah.nama_mk')
                                             ->join('mata_kuliah', 'mata_kuliah.id = pengajaran.matakuliah_id')
                                             ->where('pengajaran.dosen_id', $dosen['id'])
                                             ->findAll();
        
        $data = [
            'title' => 'Input Absensi',
            'matakuliah_diajar' => $matakuliah_diajar
        ];
        return view('absensi/index', $data);
    }

    // Halaman untuk Dosen menginput absensi
    public function detail($matakuliah_id)
    {
        $krsModel = new KrsModel();
        $taModel = new TahunAkademikModel();
        
        $ta_aktif = $taModel->where('status', 1)->first();

        $mahasiswa_krs = $krsModel->select('krs.id, mahasiswa.nim, users.nama_lengkap')
                                 ->join('mahasiswa', 'mahasiswa.id = krs.mahasiswa_id')
                                 ->join('auth.users', 'users.id = mahasiswa.user_id')
                                 ->where('krs.matakuliah_id', $matakuliah_id)
                                 ->where('krs.tahun_akademik', $ta_aktif['tahun_akademik'])
                                 ->findAll();
        
        $data = [
            'title' => 'Formulir Absensi',
            'mahasiswa_krs' => $mahasiswa_krs
        ];
        return view('absensi/detail', $data);
    }

    // Fungsi untuk menyimpan data absensi
    public function save()
    {
        $absensiModel = new AbsensiModel();
        $krs_ids = $this->request->getPost('krs_id');
        $pertemuan_ke = $this->request->getPost('pertemuan_ke');
        $tanggal = $this->request->getPost('tanggal');
        $status = $this->request->getPost('status');

        for ($i = 0; $i < count($krs_ids); $i++) {
            // Cek apakah data absensi untuk pertemuan ini sudah ada
            $existing = $absensiModel->where('krs_id', $krs_ids[$i])
                                     ->where('pertemuan_ke', $pertemuan_ke)
                                     ->first();
            
            $data = [
                'krs_id' => $krs_ids[$i],
                'pertemuan_ke' => $pertemuan_ke,
                'tanggal' => $tanggal,
                'status' => $status[$i]
            ];

            if ($existing) {
                // Jika sudah ada, update
                $absensiModel->update($existing['id'], $data);
            } else {
                // Jika belum ada, insert
                $absensiModel->save($data);
            }
        }

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil disimpan.');
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\PengajaranModel;
use App\Models\TahunAkademikModel;
use App\Models\KrsModel;

class Nilai extends BaseController
{
    public function index()
    {
        $dosenModel = new DosenModel();
        $pengajaranModel = new PengajaranModel();
        $taModel = new TahunAkademikModel();

        $userId = session()->get('ses_user_id');
        $dosen = $dosenModel->where('user_id', $userId)->first();
        
        $ta_aktif = $taModel->where('status', 1)->first();

        // Ambil daftar mata kuliah yang diajar oleh dosen ini di semester aktif
        $matakuliah_diajar = $pengajaranModel->select('mata_kuliah.id, mata_kuliah.kode_mk, mata_kuliah.nama_mk')
                                             ->join('mata_kuliah', 'mata_kuliah.id = pengajaran.matakuliah_id')
                                             ->where('pengajaran.dosen_id', $dosen['id'])
                                             ->findAll();
        
        $data = [
            'title' => 'Input Nilai',
            'ta_aktif' => $ta_aktif,
            'matakuliah_diajar' => $matakuliah_diajar
        ];
        return view('nilai/index', $data);
    }

    public function detail($matakuliah_id)
    {
        $krsModel = new KrsModel();
        $taModel = new TahunAkademikModel();
        
        $ta_aktif = $taModel->where('status', 1)->first();

        // Ambil daftar mahasiswa yang mengambil mata kuliah ini di semester aktif
        $mahasiswa_krs = $krsModel->select('krs.id, krs.nilai, mahasiswa.nim, users.nama_lengkap')
                                 ->join('mahasiswa', 'mahasiswa.id = krs.mahasiswa_id')
                                 ->join('auth.users', 'users.id = mahasiswa.user_id')
                                 ->where('krs.matakuliah_id', $matakuliah_id)
                                 ->where('krs.tahun_akademik', $ta_aktif['tahun_akademik'])
                                 ->findAll();
        
        $data = [
            'title' => 'Daftar Mahasiswa',
            'mahasiswa_krs' => $mahasiswa_krs
        ];
        return view('nilai/detail', $data);
    }

    public function save()
    {
        $krsModel = new KrsModel();
        $krs_ids = $this->request->getPost('krs_id');
        $nilai = $this->request->getPost('nilai');

        for ($i = 0; $i < count($krs_ids); $i++) {
            $krsModel->update($krs_ids[$i], ['nilai' => $nilai[$i]]);
        }

        return redirect()->to('/nilai')->with('success', 'Nilai berhasil disimpan.');
    }
}

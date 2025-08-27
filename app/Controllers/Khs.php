<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;

class Khs extends BaseController
{
    public function index()
    {
        $mahasiswaModel = new MahasiswaModel();
        
        $userId = session()->get('ses_user_id');
        $mahasiswa = $mahasiswaModel->where('user_id', $userId)->first();

        $db = \Config\Database::connect();
        $query = $db->table('krs')
                    ->select('krs.tahun_akademik, krs.nilai, mata_kuliah.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks')
                    ->join('mata_kuliah', 'mata_kuliah.id = krs.matakuliah_id')
                    ->where('krs.mahasiswa_id', $mahasiswa['id'])
                    ->orderBy('krs.tahun_akademik', 'ASC')
                    ->get()
                    ->getResultArray();
        
        $khs_data = [];
        foreach ($query as $row) {
            $khs_data[$row['tahun_akademik']][] = $row;
        }

        $data = [
            'title'    => 'Kartu Hasil Studi (KHS)',
            'mahasiswa'=> $mahasiswa,
            'khs_data' => $khs_data
        ];
        return view('khs/index', $data);
    }
}
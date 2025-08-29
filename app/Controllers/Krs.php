<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KrsModel;
use App\Models\MahasiswaModel;
use App\Models\TahunAkademikModel;
use App\Models\MataKuliahModel;

class Krs extends BaseController
{
    public function index()
    {
        $mahasiswaModel = new MahasiswaModel();
        $taModel = new TahunAkademikModel();
        $matakuliahModel = new MataKuliahModel();
        $krsModel = new KrsModel();

        $userId = session()->get('ses_user_id');
        $mahasiswa = $mahasiswaModel->where('user_id', $userId)->first();
        
        $ta_aktif = $taModel->where('status', 1)->first();

        $matakuliahTersedia = [];
        if ($ta_aktif) {
            // Tentukan jenis semester (Ganjil/Genap) dari tahun akademik
            // Contoh: 20251 -> Ganjil, 20252 -> Genap
            $jenisSemester = (int)substr($ta_aktif['tahun_akademik'], -1) % 2;

            if ($jenisSemester == 1) { // Ganjil
                $semesterDitawarkan = [1, 3, 5, 7];
            } else { // Genap
                $semesterDitawarkan = [2, 4, 6, 8];
            }

            // Ambil mata kuliah yang sesuai dengan jurusan dan semester yang ditawarkan
            $matakuliahTersedia = $matakuliahModel
                ->where('jurusan_id', $mahasiswa['jurusan_id'])
                ->whereIn('semester', $semesterDitawarkan)
                ->findAll();
        }

        // Ambil ID mata kuliah yang sudah diambil di semester ini
        $matakuliahSudahDiambil = [];
        if ($ta_aktif) {
            $krsData = $krsModel->where('mahasiswa_id', $mahasiswa['id'])
                                ->where('tahun_akademik', $ta_aktif['tahun_akademik'])
                                ->findAll();
            $matakuliahSudahDiambil = array_column($krsData, 'matakuliah_id');
        }

        $data = [
            'title'      => 'Kartu Rencana Studi (KRS)',
            'ta_aktif'   => $ta_aktif,
            'mahasiswa'  => $mahasiswa,
            'matakuliah' => $matakuliahTersedia,
            'matakuliah_sudah_diambil' => $matakuliahSudahDiambil
        ];

        return view('krs/index', $data);
    }

    public function save()
    {
        $krsModel = new KrsModel();
        $matakuliah_ids = $this->request->getPost('matakuliah_ids');
        $mahasiswa_id = $this->request->getPost('mahasiswa_id');
        $tahun_akademik = $this->request->getPost('tahun_akademik');

        // Hapus KRS lama di semester ini (jika ada)
        if (!empty($mahasiswa_id) && !empty($tahun_akademik)) {
            $krsModel->where('mahasiswa_id', $mahasiswa_id)
                     ->where('tahun_akademik', $tahun_akademik)
                     ->delete();
        }

        // Simpan KRS yang baru jika ada mata kuliah yang dipilih
        if (!empty($matakuliah_ids)) {
            foreach ($matakuliah_ids as $mk_id) {
                $krsModel->save([
                    'mahasiswa_id'   => $mahasiswa_id,
                    'matakuliah_id'  => $mk_id,
                    'tahun_akademik' => $tahun_akademik
                ]);
            }
        }

        return redirect()->to('/krs')->with('success', 'KRS berhasil disimpan.');
    }
}

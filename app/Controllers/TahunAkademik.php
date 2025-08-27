<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TahunAkademikModel;

class TahunAkademik extends BaseController
{
    public function index()
    {
        $model = new TahunAkademikModel();
        $data = [
            'title'         => 'Data Tahun Akademik',
            'tahunakademik' => $model->orderBy('tahun_akademik', 'DESC')->findAll()
        ];
        return view('tahunakademik/index', $data);
    }

    public function new()
    {
        $data = ['title' => 'Tambah Tahun Akademik'];
        return view('tahunakademik/new', $data);
    }

    public function create()
    {
        $model = new TahunAkademikModel();
        $data = [
            'tahun_akademik'  => $this->request->getPost('tahun_akademik'),
            'nama_semester'   => $this->request->getPost('nama_semester'),
            'tgl_mulai_krs'   => $this->request->getPost('tgl_mulai_krs'),
            'tgl_selesai_krs' => $this->request->getPost('tgl_selesai_krs'),
        ];
        $model->save($data);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil ditambahkan.');
    }

    public function setActive($id)
    {
        $model = new TahunAkademikModel();
        
        // 1. Nonaktifkan semua semester yang lain terlebih dahulu
        $model->where('status', 1)->set(['status' => 0])->update();
        
        // 2. Aktifkan semester yang dipilih
        $model->update($id, ['status' => 1]);
        
        return redirect()->to('/tahunakademik')->with('success', 'Tahun Akademik berhasil diaktifkan.');
    }
}
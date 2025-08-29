<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;
use App\Models\JurusanModel;

class MataKuliah extends BaseController
{
    public function index()
    {
        $jurusanModel = new JurusanModel();
        $mataKuliahModel = new MataKuliahModel();

        $jurusan = $jurusanModel->findAll();
        $grouped_matakuliah = [];

        foreach ($jurusan as $jrs) {
            $matakuliah = $mataKuliahModel->where('jurusan_id', $jrs['id'])
                                          ->orderBy('semester', 'ASC')
                                          ->findAll();
            
            // Kelompokkan mata kuliah berdasarkan semester
            $by_semester = [];
            foreach ($matakuliah as $mk) {
                $by_semester[$mk['semester']][] = $mk;
            }

            if (!empty($by_semester)) {
                $grouped_matakuliah[$jrs['nama_jurusan']] = $by_semester;
            }
        }

        $data = [
            'title'      => 'Data Mata Kuliah',
            'matakuliah_per_jurusan' => $grouped_matakuliah
        ];
        return view('matakuliah/index', $data);
    }

    public function new()
    {
        $jurusanModel = new JurusanModel();
        $data = [
            'title'   => 'Tambah Data Mata Kuliah',
            'jurusan' => $jurusanModel->findAll()
        ];
        return view('matakuliah/new', $data);
    }

    public function create()
    {
        $model = new MataKuliahModel();
        $data = [
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'kode_mk'    => $this->request->getPost('kode_mk'),
            'nama_mk'    => $this->request->getPost('nama_mk'),
            'sks'        => $this->request->getPost('sks'),
            'semester'   => $this->request->getPost('semester'),
        ];

        $model->save($data);
        return redirect()->to('/matakuliah')->with('success', 'Data Mata Kuliah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new MataKuliahModel();
        $jurusanModel = new JurusanModel();
        $data = [
            'title'      => 'Edit Data Mata Kuliah',
            'matakuliah' => $model->find($id),
            'jurusan'    => $jurusanModel->findAll()
        ];
        return view('matakuliah/edit', $data);
    }

    public function update($id)
    {
        $model = new MataKuliahModel();
        $data = [
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'kode_mk'    => $this->request->getPost('kode_mk'),
            'nama_mk'    => $this->request->getPost('nama_mk'),
            'sks'        => $this->request->getPost('sks'),
            'semester'   => $this->request->getPost('semester'),
        ];

        $model->update($id, $data);
        return redirect()->to('/matakuliah')->with('success', 'Data Mata Kuliah berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new MataKuliahModel();
        $model->delete($id);
        return redirect()->to('/matakuliah')->with('success', 'Data Mata Kuliah berhasil dihapus.');
    }
}

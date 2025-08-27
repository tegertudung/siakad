<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;
use App\Models\JurusanModel; // <-- Panggil JurusanModel

class MataKuliah extends BaseController
{
    public function index()
    {
        $model = new MataKuliahModel();
        
        // Query untuk join tabel mata_kuliah dengan jurusan
        $query = $model->select('mata_kuliah.*, jurusan.nama_jurusan')
                       ->join('jurusan', 'jurusan.id = mata_kuliah.jurusan_id', 'left') // 'left' join agar matkul tanpa jurusan tetap tampil
                       ->findAll();

        $data = [
            'title'      => 'Data Mata Kuliah',
            'matakuliah' => $query
        ];
        return view('matakuliah/index', $data);
    }

    public function new()
    {
        $jurusanModel = new JurusanModel();
        $data = [
            'title'   => 'Tambah Data Mata Kuliah',
            'jurusan' => $jurusanModel->findAll() // Ambil data jurusan
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

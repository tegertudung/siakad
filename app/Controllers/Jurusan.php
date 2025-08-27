<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class Jurusan extends BaseController
{
    public function index()
    {
        $model = new JurusanModel();
        $data = [
            'title'   => 'Data Jurusan',
            'jurusan' => $model->findAll()
        ];
        return view('jurusan/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Data Jurusan'
        ];
        return view('jurusan/new', $data);
    }

    public function create()
    {
        // 1. Atur aturan validasi
        $rules = [
            'nama_jurusan' => 'required|min_length[3]|max_length[100]'
        ];

        // 2. Jalankan validasi
        if (! $this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Jika validasi berhasil, simpan data
        $model = new JurusanModel();
        $data = [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
        ];

        $model->save($data);
        
        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->to('/jurusan')->with('success', 'Data Jurusan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new JurusanModel();
        $data = [
            'title'   => 'Edit Data Jurusan',
            'jurusan' => $model->find($id)
        ];
        return view('jurusan/edit', $data);
    }

    public function update($id)
    {
        $model = new JurusanModel();
        $data = [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
        ];

        $model->update($id, $data);
        return redirect()->to('/jurusan')->with('success', 'Data Jurusan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new JurusanModel();
        $model->delete($id);
        return redirect()->to('/jurusan')->with('success', 'Data Jurusan berhasil dihapus.');
    }
}

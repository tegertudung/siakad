<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\JurusanModel;
use App\Models\UserModel;

class Mahasiswa extends BaseController
{
    public function index()
    {
        $model = new MahasiswaModel();
        
        $query = $model->select('mahasiswa.*, users.nama_lengkap, users.email, jurusan.nama_jurusan')
                       ->join('auth.users', 'users.id = mahasiswa.user_id', 'left')
                       ->join('jurusan', 'jurusan.id = mahasiswa.jurusan_id', 'left')
                       ->findAll();

        $data = [
            'title'     => 'Data Mahasiswa',
            'mahasiswa' => $query
        ];
        return view('mahasiswa/index', $data);
    }

    public function new()
    {
        $jurusanModel = new JurusanModel();
        $data = [
            'title'   => 'Tambah Data Mahasiswa',
            'jurusan' => $jurusanModel->findAll()
        ];
        return view('mahasiswa/new', $data);
    }

    public function create()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'nim'          => 'required|is_unique[mahasiswa.nim]',
            'jurusan_id'   => 'required',
            'angkatan'     => 'required|integer',
            'username'     => 'required|is_unique[users.username]', // PERBAIKAN DI SINI
            'email'        => 'required|valid_email|is_unique[users.email]', // PERBAIKAN DI SINI
            'password'     => 'required|min_length[6]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $mahasiswaModel = new MahasiswaModel();

        $userData = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'mahasiswa'
        ];
        $userModel->save($userData);
        $userId = $userModel->getInsertID();

        $mahasiswaData = [
            'user_id'    => $userId,
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'nim'        => $this->request->getPost('nim'),
            'angkatan'   => $this->request->getPost('angkatan'),
        ];
        $mahasiswaModel->save($mahasiswaData);

        return redirect()->to('/mahasiswa')->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswaModel = new MahasiswaModel();
        $jurusanModel = new JurusanModel();
        
        $mahasiswa = $mahasiswaModel->select('mahasiswa.*, users.nama_lengkap, users.username, users.email')
                                   ->join('auth.users', 'users.id = mahasiswa.user_id')
                                   ->where('mahasiswa.id', $id)
                                   ->first();

        $data = [
            'title'     => 'Edit Data Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'jurusan'   => $jurusanModel->findAll()
        ];
        return view('mahasiswa/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $mahasiswaModel = new MahasiswaModel();
        
        $mahasiswa = $mahasiswaModel->find($id);
        $user = $userModel->find($mahasiswa['user_id']);

        // Aturan validasi untuk update
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'nim'          => "required|is_unique[mahasiswa.nim,id,{$id}]",
            'angkatan'     => 'required|integer',
            'email'        => "required|valid_email|is_unique[users.email,id,{$user['id']}]" // PERBAIKAN DI SINI
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
        ];
        $userModel->update($mahasiswa['user_id'], $userData);

        $mahasiswaData = [
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'nim'        => $this->request->getPost('nim'),
            'angkatan'   => $this->request->getPost('angkatan'),
        ];
        $mahasiswaModel->update($id, $mahasiswaData);

        return redirect()->to('/mahasiswa')->with('success', 'Data Mahasiswa berhasil diperbarui.');
    }

    public function delete($id)
    {
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->find($id);
        
        $userModel = new UserModel();
        $userModel->delete($mahasiswa['user_id']);

        return redirect()->to('/mahasiswa')->with('success', 'Data Mahasiswa berhasil dihapus.');
    }
}

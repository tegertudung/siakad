<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\JurusanModel;
use App\Models\MataKuliahModel;
use App\Models\PengajaranModel;
use App\Models\UserModel;

class Dosen extends BaseController
{
    public function index()
    {
        $dosenModel = new DosenModel();
        $pengajaranModel = new PengajaranModel();

        $dosenList = $dosenModel->select('dosen.*, users.nama_lengkap, jurusan.nama_jurusan')
                               ->join('auth.users', 'users.id = dosen.user_id', 'left')
                               ->join('jurusan', 'jurusan.id = dosen.jurusan_id', 'left')
                               ->findAll();

        foreach ($dosenList as $key => $dosen) {
            $mataKuliah = $pengajaranModel->select('mata_kuliah.nama_mk')
                                          ->join('mata_kuliah', 'mata_kuliah.id = pengajaran.matakuliah_id')
                                          ->where('pengajaran.dosen_id', $dosen['id'])
                                          ->findAll();
            $dosenList[$key]['mata_kuliah_diampu'] = array_column($mataKuliah, 'nama_mk');
        }

        $data = ['title' => 'Data Dosen', 'dosen' => $dosenList];
        return view('dosen/index', $data);
    }

    public function new()
    {
        $jurusanModel = new JurusanModel();
        $data = [
            'title'   => 'Tambah Data Dosen',
            'jurusan' => $jurusanModel->findAll()
        ];
        return view('dosen/new', $data);
    }

    public function create()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'nidn'         => 'required|is_unique[dosen.nidn]',
            'jurusan_id'   => 'required',
            'username'     => 'required|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $dosenModel = new DosenModel();

        $userData = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'dosen'
        ];
        $userModel->save($userData);
        $userId = $userModel->getInsertID();

        $dosenData = [
            'user_id'    => $userId,
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'nidn'       => $this->request->getPost('nidn'),
        ];
        $dosenModel->save($dosenData);

        return redirect()->to('/dosen')->with('success', 'Data Dosen berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $dosenModel = new DosenModel();
        $jurusanModel = new JurusanModel();
        $mataKuliahModel = new MataKuliahModel();
        $pengajaranModel = new PengajaranModel();
        
        $dosen = $dosenModel->select('dosen.*, users.nama_lengkap, users.username, users.email')
                           ->join('auth.users', 'users.id = dosen.user_id')
                           ->where('dosen.id', $id)
                           ->first();
        
        $mataKuliahDiampu = $pengajaranModel->where('dosen_id', $id)->findAll();
        $idMataKuliahDiampu = array_column($mataKuliahDiampu, 'matakuliah_id');

        $data = [
            'title'              => 'Edit Data Dosen',
            'dosen'              => $dosen,
            'jurusan'            => $jurusanModel->findAll(),
            'matakuliah'         => $mataKuliahModel->where('jurusan_id', $dosen['jurusan_id'])->findAll(),
            'id_matakuliah_diampu' => $idMataKuliahDiampu
        ];
        return view('dosen/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $dosenModel = new DosenModel();
        $pengajaranModel = new PengajaranModel();
        
        $dosen = $dosenModel->find($id);

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
        ];
        $userModel->update($dosen['user_id'], $userData);

        $dosenData = [
            'jurusan_id' => $this->request->getPost('jurusan_id'),
            'nidn'       => $this->request->getPost('nidn'),
        ];
        $dosenModel->update($id, $dosenData);

        $pengajaranModel->where('dosen_id', $id)->delete();
        $matakuliahIds = $this->request->getPost('matakuliah_ids') ?? [];
        foreach ($matakuliahIds as $matakuliahId) {
            $pengajaranModel->save(['dosen_id' => $id, 'matakuliah_id' => $matakuliahId]);
        }

        return redirect()->to('/dosen')->with('success', 'Data Dosen berhasil diperbarui.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->find($id);
        
        $userModel->delete($dosen['user_id']);

        return redirect()->to('/dosen')->with('success', 'Data Dosen berhasil dihapus.');
    }

    public function getMataKuliahByJurusan($jurusanId)
    {
        if ($this->request->isAJAX()) {
            $mataKuliahModel = new MataKuliahModel();
            $matakuliah = $mataKuliahModel->where('jurusan_id', $jurusanId)->findAll();
            return $this->response->setJSON($matakuliah);
        }
        return redirect()->to('/dosen');
    }
}

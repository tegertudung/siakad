<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }
    public function eseclogin()
    {

        // $userModel = new UserModel();
        $validation = \Config\Services::validation();
        // $request = \Config\Services::request();

        $rules = [
            'credential' => [
                'label' => 'Email atau Username',
                'rules' => 'required|max_length[100]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $validation->getErrors()['credential'] ?? $validation->getErrors()['password'],
                'csrf_hash_new' => csrf_hash(),
            ]);
        }
    }
}

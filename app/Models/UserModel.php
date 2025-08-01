<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'auth.users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'email', 'password_hash', 'nama_lengkap', 'is_active', 'is_aktif'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';


    public function getDataUserByEmail(string $parameter1)
    {
        return $this->where('email', $parameter1)
            ->orWhere('username', $parameter1)
            ->first();
    }
}

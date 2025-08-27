<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'auth.users';  // Include schema name
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'email', 'password_hash', 'nama_lengkap','role', 'is_active', 'is_aktif', 'created_at', 'updated_at'];
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

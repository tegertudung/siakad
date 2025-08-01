<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'auth.users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'email', 'password_hash', 'nama_lengkap', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';


    public function findUserByCredential(string $credential)
    {
        return $this->where('email', $credential)
            ->orWhere('username', $credential)
            ->first();
    }
}

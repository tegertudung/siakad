<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table      = 'otp_codes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['email', 'otp', 'expires_at'];

    // Tidak menggunakan timestamps otomatis
    protected $useTimestamps = false;
}

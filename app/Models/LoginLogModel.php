<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginLogModel extends Model
{
    protected $table            = 'auth.login_logs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'ip_address', 'user_agent', 'is_success', 'credential_used'];
    protected $useTimestamps    = false;
}

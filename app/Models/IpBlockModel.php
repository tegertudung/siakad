<?php

namespace App\Models;

use CodeIgniter\Model;

class IpBlockModel extends Model
{
    protected $table            = 'auth.ip_blocks';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['ip_address', 'reason', 'blocked_at'];
    protected $useTimestamps    = false;

    public function isIpBlocked(string $ipAddress): bool
    {
        return $this->where('ip_address', $ipAddress)->countAllResults() > 0;
    }
}

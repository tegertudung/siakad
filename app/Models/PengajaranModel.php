<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajaranModel extends Model
{
    protected $table            = 'pengajaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['dosen_id', 'matakuliah_id'];
}
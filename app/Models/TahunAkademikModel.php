<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAkademikModel extends Model
{
    protected $table            = 'tahun_akademik';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['tahun_akademik', 'nama_semester', 'status', 'tgl_mulai_krs', 'tgl_selesai_krs'];
}
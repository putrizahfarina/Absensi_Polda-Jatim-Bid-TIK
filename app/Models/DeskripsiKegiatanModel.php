<?php

namespace App\Models;

use CodeIgniter\Model;

class DeskripsiKegiatanModel extends Model
{
    protected $table         = 'deskripsi_kegiatan';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'tanggal',
        'deskripsi',
    ];
}

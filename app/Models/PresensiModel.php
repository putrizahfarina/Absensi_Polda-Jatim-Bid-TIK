<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'personel_id',
        'waktu_masuk',
        'status',
        'point_apel'
    ];

    public function getAttendanceTrend($days = 7)
    {
        return $this->db->table($this->table)
            ->select('DATE(waktu_masuk) as tanggal, COUNT(id) as total')
            ->where('status', 'Hadir')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->limit($days)
            ->get()
            ->getResultArray();
    }
}
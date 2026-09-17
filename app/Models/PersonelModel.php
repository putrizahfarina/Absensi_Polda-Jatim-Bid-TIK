<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonelModel extends Model
{
    // Pastikan nama tabel ini sesuai dengan yang ada di database Anda
    protected $table            = 'personel'; 
    protected $primaryKey       = 'id';
    
    // Aktifkan fitur soft delete karena di controller Anda memakai onlyDeleted()
    protected $useSoftDeletes   = true; 

    // Kolom-kolom yang boleh diisi (berdasarkan controller Anda)
    protected $allowedFields    = [
        'nrp_nip',
        'nama',
        'pangkat',
        'jabatan',
        'satker',
        'jenis_kelamin',
        'qr_code'
    ];

    // Pengaturan Tanggal (Wajib aktif jika pakai soft deletes)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
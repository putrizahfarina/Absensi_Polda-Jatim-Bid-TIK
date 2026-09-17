<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        // Check if data already exists (prevent duplicates on re-seed)
        $existing = $this->db->table('tb_kelas')->countAllResults();

        if ($existing === 0) {
           $data = [
    // Kelas X
    ['tingkat' => 'X', 'id_jurusan' => 2, 'index_kelas' => 'A'], // OTKP
    ['tingkat' => 'X', 'id_jurusan' => 3, 'index_kelas' => 'A'], // BDP
    ['tingkat' => 'X', 'id_jurusan' => 4, 'index_kelas' => 'A'], // AKL
    ['tingkat' => 'X', 'id_jurusan' => 5, 'index_kelas' => 'A'], // RPL

    // Kelas XI
    ['tingkat' => 'XI', 'id_jurusan' => 2, 'index_kelas' => 'A'], // OTKP
    ['tingkat' => 'XI', 'id_jurusan' => 3, 'index_kelas' => 'A'], // BDP
    ['tingkat' => 'XI', 'id_jurusan' => 4, 'index_kelas' => 'A'], // AKL
    ['tingkat' => 'XI', 'id_jurusan' => 5, 'index_kelas' => 'A'], // RPL

    // Kelas XII
    ['tingkat' => 'XII', 'id_jurusan' => 2, 'index_kelas' => 'A'], // OTKP
    ['tingkat' => 'XII', 'id_jurusan' => 3, 'index_kelas' => 'A'], // BDP
    ['tingkat' => 'XII', 'id_jurusan' => 4, 'index_kelas' => 'A'], // AKL
    ['tingkat' => 'XII', 'id_jurusan' => 5, 'index_kelas' => 'A'], // RPL
];

            // Using Query Builder for batch insert
            $this->db->table('tb_kelas')->insertBatch($data);
        }
    }
}
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRfidToSiswaGuru extends Migration
{
    public function up()
{
    $fields = [
        'rfid_code' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
            'default'    => null,
            'after'      => 'unique_code',
        ],
    ];

    // Tambahkan rfid_code ke tb_siswa jika belum ada
    if (!$this->db->fieldExists('rfid_code', 'tb_siswa')) {
        $this->forge->addColumn('tb_siswa', $fields);
    }

    // Tambahkan rfid_code ke tb_guru jika belum ada
    if (!$this->db->fieldExists('rfid_code', 'tb_guru')) {
        $this->forge->addColumn('tb_guru', $fields);
    }
}

    public function down()
    {
        $db = \Config\Database::connect();

        // Drop indexes first
        if ($db->fieldExists('rfid_code', 'tb_siswa')) {
            $this->forge->dropColumn('tb_siswa', 'rfid_code');
        }

        if ($db->fieldExists('rfid_code', 'tb_guru')) {
            $this->forge->dropColumn('tb_guru', 'rfid_code');
        }
    }
}

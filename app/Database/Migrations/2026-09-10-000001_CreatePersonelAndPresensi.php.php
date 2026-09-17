<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonelAndPresensi extends Migration
{
    public function up()
    {
        // Tabel Personel
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nrp_nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'pangkat' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'satker' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Bid TIK',
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
                'default'    => 'L',
            ],
            'qr_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('personel');

        // Tabel Presensi Absensi
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'personel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'waktu_masuk' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Hadir', 'Izin', 'Sakit', 'Alfa'],
                'default'    => 'Hadir',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('personel_id', 'personel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('presensi');
    }

    public function down()
    {
        $this->forge->dropTable('presensi');
        $this->forge->dropTable('personel');
    }
}
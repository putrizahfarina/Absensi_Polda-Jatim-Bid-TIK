<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWaliKelasToKelas extends Migration
{
    public function up()
    {
        // Tambahkan id_wali_kelas jika belum ada
        if (!$this->db->fieldExists('id_wali_kelas', 'tb_kelas')) {
            $this->forge->addColumn('tb_kelas', [
                'id_wali_kelas' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => false,
                    'null'       => true,
                    'after'      => 'index_kelas',
                ],
            ]);
        }

        // Tambahkan foreign key tb_kelas jika belum ada
        $checkKelasFK = $this->db->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = 'tb_kelas'
            AND CONSTRAINT_NAME = 'fk_tb_kelas_id_wali_kelas'
        ", [$this->db->getDatabase()])->getRow();

        if (!$checkKelasFK) {
            $this->db->query("
                ALTER TABLE tb_kelas
                ADD CONSTRAINT fk_tb_kelas_id_wali_kelas
                FOREIGN KEY (id_wali_kelas)
                REFERENCES tb_guru(id_guru)
                ON UPDATE NO ACTION
                ON DELETE RESTRICT
            ");
        }

        // Tambahkan id_guru ke users jika belum ada
        if (!$this->db->fieldExists('id_guru', 'users')) {
            $this->forge->addColumn('users', [
                'id_guru' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => false,
                    'null'       => true,
                    'after'      => 'id',
                ],
            ]);
        }

        // Tambahkan foreign key users jika belum ada
        $checkUserFK = $this->db->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = 'users'
            AND CONSTRAINT_NAME = 'fk_users_id_guru'
        ", [$this->db->getDatabase()])->getRow();

        if (!$checkUserFK) {
            $this->db->query("
                ALTER TABLE users
                ADD CONSTRAINT fk_users_id_guru
                FOREIGN KEY (id_guru)
                REFERENCES tb_guru(id_guru)
                ON UPDATE NO ACTION
                ON DELETE RESTRICT
            ");
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // Hapus FK users jika ada
        $checkUserFK = $db->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = 'users'
            AND CONSTRAINT_NAME = 'fk_users_id_guru'
        ", [$db->getDatabase()])->getRow();

        if ($checkUserFK) {
            $this->db->query(
                'ALTER TABLE users DROP FOREIGN KEY fk_users_id_guru'
            );
        }

        if ($this->db->fieldExists('id_guru', 'users')) {
            $this->forge->dropColumn('users', 'id_guru');
        }

        // Hapus FK tb_kelas jika ada
        $checkKelasFK = $db->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = 'tb_kelas'
            AND CONSTRAINT_NAME = 'fk_tb_kelas_id_wali_kelas'
        ", [$db->getDatabase()])->getRow();

        if ($checkKelasFK) {
            $this->db->query(
                'ALTER TABLE tb_kelas DROP FOREIGN KEY fk_tb_kelas_id_wali_kelas'
            );
        }

        if ($this->db->fieldExists('id_wali_kelas', 'tb_kelas')) {
            $this->forge->dropColumn('tb_kelas', 'id_wali_kelas');
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
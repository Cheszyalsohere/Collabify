<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Menyamakan tabel users lama (skema perpustakaan) dengan skema Campus Saver:
 * buang kolom id_member, role jadi string bebas (default 'mahasiswa').
 * Untuk instalasi baru, CreateUsersTable sudah langsung memakai skema ini,
 * jadi migrasi ini hanya bekerja kalau kolom id_member masih ada.
 */
class ModifyUsersTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('id_member', 'users')) {
            $this->db->table('users')->where('role', 'user')->update(['role' => 'mahasiswa']);
            return;
        }

        if ($this->db->DBDriver === 'SQLite3') {
            // SQLite tidak bisa DROP COLUMN pada kolom yang dipakai FOREIGN KEY: rebuild tabel.
            $this->db->query('
                CREATE TABLE users_new (
                    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT NOT NULL UNIQUE,
                    password TEXT NOT NULL,
                    role TEXT NOT NULL DEFAULT "mahasiswa",
                    created_at DATETIME,
                    updated_at DATETIME
                )
            ');
            $this->db->query('
                INSERT INTO users_new (id_user, name, email, password, role, created_at, updated_at)
                SELECT id_user, name, email, password, role, created_at, updated_at FROM users
            ');
            $this->db->query('DROP TABLE users');
            $this->db->query('ALTER TABLE users_new RENAME TO users');
        } else {
            // MySQL: lepas FK ke members (jika ada), buang kolom, longgarkan role dari ENUM.
            $fk = $this->db->query(
                "SELECT CONSTRAINT_NAME AS n FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'
                   AND COLUMN_NAME = 'id_member' AND REFERENCED_TABLE_NAME IS NOT NULL"
            )->getResultArray();
            foreach ($fk as $row) {
                $this->db->query('ALTER TABLE users DROP FOREIGN KEY `' . $row['n'] . '`');
            }
            $this->forge->dropColumn('users', 'id_member');
            $this->db->query("ALTER TABLE users MODIFY role VARCHAR(20) NOT NULL DEFAULT 'mahasiswa'");
        }

        $this->db->table('users')->where('role', 'user')->update(['role' => 'mahasiswa']);
    }

    public function down()
    {
        // Tidak ada rollback: kolom id_member milik skema perpustakaan lama.
    }
}

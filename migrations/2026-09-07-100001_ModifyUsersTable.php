<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        // SQLite tidak mengizinkan DROP COLUMN pada kolom yang masih
        // dipakai di definisi FOREIGN KEY tabel yang sama (id_member -> members).
        // Solusinya: rebuild tabel users tanpa kolom id_member.
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

        // Samakan nilai role lama: 'user' -> 'mahasiswa'
        $this->db->table('users')->where('role', 'user')->update(['role' => 'mahasiswa']);
    }

    public function down()
    {
        $this->forge->addColumn('users', [
            'id_member' => [
                'type' => 'INT',
                'null'  => true,
            ],
        ]);
    }
}

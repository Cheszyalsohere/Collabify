<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Menyesuaikan tabel `users` dari skema perpustakaan lama
 * ke skema portal proyek kelompok mahasiswa.
 *
 * - Kolom `id_member` (relasi ke tabel `members` lama) dihapus,
 *   karena entitas GROUPS/GROUP_MEMBERS menggantikan konsep member.
 * - Default `role` diubah dari 'user' menjadi 'mahasiswa'.
 *   Nilai role yang disarankan: mahasiswa, dosen, admin.
 */
class ModifyUsersTable extends Migration
{
    /**
     * Catatan: kolom `id_member` di tabel `users` didefinisikan dengan
     * foreign key ke `members` PADA TABEL YANG SAMA. SQLite tidak
     * mengizinkan DROP COLUMN pada kolom yang masih terikat FK constraint
     * di tabel itu sendiri, jadi kita rebuild tabelnya (buat tabel baru,
     * pindahkan data, ganti nama) — ini pola standar untuk kasus ini di
     * SQLite dan datanya tetap aman/utuh.
     */
    public function up()
    {
        $this->db->query('
            CREATE TABLE users_new (
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT \'mahasiswa\',
                created_at TEXT,
                updated_at TEXT
            )
        ');

        $this->db->query('
            INSERT INTO users_new (id_user, name, email, password, role, created_at, updated_at)
            SELECT id_user, name, email, password, role, created_at, updated_at FROM users
        ');

        $this->forge->dropTable('users', true);
        $this->db->query('ALTER TABLE users_new RENAME TO users');
    }

    public function down()
    {
        $this->db->query('
            CREATE TABLE users_old (
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT \'user\',
                id_member INTEGER,
                created_at TEXT,
                updated_at TEXT
            )
        ');

        $this->db->query('
            INSERT INTO users_old (id_user, name, email, password, role, created_at, updated_at)
            SELECT id_user, name, email, password, role, created_at, updated_at FROM users
        ');

        $this->forge->dropTable('users', true);
        $this->db->query('ALTER TABLE users_old RENAME TO users');
    }
}

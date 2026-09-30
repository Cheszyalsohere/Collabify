<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropLibraryTables extends Migration
{
    public function up()
    {
        $this->forge->dropTable('book_reviews', true);
        $this->forge->dropTable('wishlist', true);
        $this->forge->dropTable('pengajuan', true);
        $this->forge->dropTable('pengembalian', true);
        $this->forge->dropTable('peminjaman', true);
        $this->forge->dropTable('books', true);
        $this->forge->dropTable('members', true);
    }

    public function down()
    {
        // Tabel lama tidak direkonstruksi otomatis di sini.
        // Kalau butuh balikin skema & data perpus lama, restore dari
        // backup ci4_sqlite.sql yang sudah pernah dibuat sebelumnya.
    }
}

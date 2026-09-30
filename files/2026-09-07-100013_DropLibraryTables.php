<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Membersihkan seluruh tabel bekas sistem perpustakaan lama
 * setelah skema portal proyek kelompok selesai dibangun (Fase 1-2 s.d 12).
 *
 * PENTING: jalankan migration ini PALING TERAKHIR, dan pastikan kamu sudah
 * export/backup data lama (books, members, peminjaman, dst) jika masih
 * dibutuhkan, karena down() di sini hanya mengembalikan STRUKTUR tabel,
 * bukan data yang sudah terhapus.
 */
class DropLibraryTables extends Migration
{
    public function up()
    {
        // Urutan drop: anak dulu (yang punya FK), baru induk,
        // supaya tidak kena constraint error di DB yang menegakkan FK (mis. MySQL).
        $this->forge->dropTable('book_reviews', true);
        $this->forge->dropTable('wishlist', true);
        $this->forge->dropTable('pengembalian', true);
        $this->forge->dropTable('peminjaman', true);
        $this->forge->dropTable('pengajuan', true);
        $this->forge->dropTable('books', true);
        $this->forge->dropTable('members', true);
    }

    public function down()
    {
        // Rekonstruksi struktur tabel lama, urutan induk dulu baru anak.
        $this->forge->addField([
            'id_member' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name_member' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email_member' => ['type' => 'VARCHAR', 'constraint' => 150],
            'contact_member' => ['type' => 'VARCHAR', 'constraint' => 30],
            'status_member' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Aktif'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_member', true);
        $this->forge->addUniqueKey('email_member');
        $this->forge->createTable('members');

        $this->forge->addField([
            'id_book' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code_book' => ['type' => 'VARCHAR', 'constraint' => 50],
            'isbn_book' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'no_klasifikasi' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'title_book' => ['type' => 'VARCHAR', 'constraint' => 200],
            'author_book' => ['type' => 'VARCHAR', 'constraint' => 150],
            'publisher_book' => ['type' => 'VARCHAR', 'constraint' => 150],
            'kota_terbit' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'published_year' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'edisi' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'description_book' => ['type' => 'TEXT', 'null' => true],
            'stock' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
            'deskripsi_fisik' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'volume' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'subjek' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'tipe' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'fisik'],
            'file_digital' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cover' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id_book', true);
        $this->forge->createTable('books');

        $this->forge->addField([
            'id_pengajuan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_member' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_book' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_pengajuan' => ['type' => 'DATE'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'menunggu'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_pengajuan', true);
        $this->forge->addForeignKey('id_book', 'books', 'id_book', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_member', 'members', 'id_member', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan');

        $this->forge->addField([
            'id_peminjaman' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_member' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_book' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_peminjaman' => ['type' => 'DATE'],
            'tanggal_kembali' => ['type' => 'DATE'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_peminjaman', true);
        $this->forge->addForeignKey('id_book', 'books', 'id_book', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_member', 'members', 'id_member', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman');

        $this->forge->addField([
            'id_pengembalian' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_peminjaman' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_kembali_aktual' => ['type' => 'DATE'],
            'total_denda' => ['type' => 'INT', 'constraint' => 11],
        ]);
        $this->forge->addKey('id_pengembalian', true);
        $this->forge->createTable('pengembalian');

        $this->forge->addField([
            'id_wishlist' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_book' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_wishlist', true);
        $this->forge->addUniqueKey(['id_user', 'id_book']);
        $this->forge->addForeignKey('id_book', 'books', 'id_book', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wishlist');

        $this->forge->addField([
            'id_review' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_book' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'rating' => ['type' => 'INT', 'constraint' => 1, 'default' => 5],
            'comment' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_review', true);
        $this->forge->addUniqueKey(['id_user', 'id_book']);
        $this->forge->addForeignKey('id_book', 'books', 'id_book', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('book_reviews');
    }
}

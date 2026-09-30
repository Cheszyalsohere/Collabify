<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Melepas UNIQUE(id_template, id_user) di template_ratings supaya satu pengguna
 * bisa punya lebih dari satu komentar. Portabel (MySQL & SQLite), aman dijalankan ulang.
 */
class ModifyTemplateRatingsForComments extends Migration
{
    public function up()
    {
        if ($this->db->DBDriver === 'SQLite3') {
            $this->upSqlite();
            return;
        }

        $this->upMysql();
    }

    /**
     * MySQL: siapkan index biasa (dibutuhkan foreign key), lalu buang UNIQUE gabungan.
     */
    private function upMysql(): void
    {
        $table = 'template_ratings';

        foreach (['id_template', 'id_user'] as $column) {
            if (! $this->hasIndexStartingWith($table, $column)) {
                $this->db->query(
                    'CREATE INDEX idx_template_ratings_' . $column .
                    ' ON ' . $this->db->escapeIdentifiers($table) . ' (' . $column . ')'
                );
            }
        }

        // Index biasa sudah ada, jadi UNIQUE gabungan aman dibuang.
        foreach ($this->db->getIndexData($table) as $name => $index) {
            if (strtoupper($index->type) === 'UNIQUE' && array_values($index->fields) === ['id_template', 'id_user']) {
                $this->db->query(
                    'ALTER TABLE ' . $this->db->escapeIdentifiers($table) .
                    ' DROP INDEX ' . $this->db->escapeIdentifiers($name)
                );
            }
        }
    }

    /**
     * SQLite tidak bisa DROP constraint: bangun ulang tabel tanpa UNIQUE.
     */
    private function upSqlite(): void
    {
        $hasUnique = false;
        foreach ($this->db->getIndexData('template_ratings') as $index) {
            if (strtoupper($index->type) === 'UNIQUE' && array_values($index->fields) === ['id_template', 'id_user']) {
                $hasUnique = true;
            }
        }

        if (! $hasUnique) {
            return;
        }

        $this->db->query('PRAGMA foreign_keys = OFF');

        try {
            $this->db->query('ALTER TABLE template_ratings RENAME TO template_ratings_old');

            $this->db->query(
                'CREATE TABLE template_ratings (
                    id_rating INTEGER PRIMARY KEY AUTOINCREMENT,
                    id_template INTEGER NOT NULL,
                    id_user INTEGER NOT NULL,
                    rating INTEGER NOT NULL,
                    comment TEXT,
                    created_at DATETIME,
                    FOREIGN KEY (id_template) REFERENCES templates(id_template) ON DELETE CASCADE,
                    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
                )'
            );

            $this->db->query(
                'INSERT INTO template_ratings (id_rating, id_template, id_user, rating, comment, created_at)
                 SELECT id_rating, id_template, id_user, rating, comment, created_at FROM template_ratings_old'
            );

            $this->db->query('DROP TABLE template_ratings_old');
            $this->db->query('CREATE INDEX idx_template_ratings_template ON template_ratings(id_template)');
            $this->db->query('CREATE INDEX idx_template_ratings_user ON template_ratings(id_user)');
        } finally {
            $this->db->query('PRAGMA foreign_keys = ON');
        }
    }

    private function hasIndexStartingWith(string $table, string $column): bool
    {
        foreach ($this->db->getIndexData($table) as $index) {
            $fields = array_values($index->fields);

            // UNIQUE gabungan yang akan dibuang tidak dihitung sebagai pengganti.
            if ($fields === ['id_template', 'id_user']) {
                continue;
            }

            if (($fields[0] ?? null) === $column) {
                return true;
            }
        }

        return false;
    }

    public function down()
    {
        // Tidak ada rollback: data komentar bisa sudah berisi duplikat user + template.
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Kolom tambahan spin_history untuk track record:
 * - nomor_spin : spin ke-berapa di kelompok tersebut
 * - is_ulang   : 1 jika ada tugas yang sudah pernah di-spin sebelumnya
 * - kode       : kode verifikasi (ikut dicetak di gambar hasil)
 */
class AddSpinColumns extends Migration
{
    public function up()
    {
        $this->forge->addColumn('spin_history', [
            'nomor_spin' => ['type' => 'INT', 'default' => 1],
            'is_ulang'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spin_history', ['nomor_spin', 'is_ulang', 'kode']);
    }
}

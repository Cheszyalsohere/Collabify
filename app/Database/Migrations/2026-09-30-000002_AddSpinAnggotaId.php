<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Menyimpan id anggota penerima bagian pada setiap baris spin, supaya hasil
 * bisa dikirim ke Catatan pribadi anggota yang benar (nama bisa kembar).
 */
class AddSpinAnggotaId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('spin_history', [
            'id_anggota' => ['type' => 'INT', 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spin_history', 'id_anggota');
    }
}

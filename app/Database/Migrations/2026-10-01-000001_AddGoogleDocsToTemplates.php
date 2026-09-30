<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Template boleh menautkan dokumen Google (Docs/Sheets/Slides) sebagai sumber salinan.
 * Yang disimpan hanya jenis + ID dokumen; tautan salin dibuat oleh server.
 */
class AddGoogleDocsToTemplates extends Migration
{
    public function up()
    {
        $this->forge->addColumn('templates', [
            'gdoc_type' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'gdoc_id'   => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('templates', ['gdoc_type', 'gdoc_id']);
    }
}

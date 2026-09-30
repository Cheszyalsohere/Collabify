<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Riwayat "Gunakan template" lewat Google Docs, per pengguna.
 * doc_url diisi pengguna sendiri setelah menyalin (aplikasi tidak punya akses ke Drive-nya).
 */
class CreateWorkspaceHistory extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('workspace_history')) {
            return;
        }

        $this->forge->addField([
            'id_history'  => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_user'     => ['type' => 'INT'],
            'id_template' => ['type' => 'INT', 'null' => true],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'doc_url'     => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id_history');
        $this->forge->addKey('id_user');
        $this->forge->addKey('id_template');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_template', 'templates', 'id_template', 'SET NULL', 'CASCADE');
        $this->forge->createTable('workspace_history');
    }

    public function down()
    {
        $this->forge->dropTable('workspace_history', true);
    }
}

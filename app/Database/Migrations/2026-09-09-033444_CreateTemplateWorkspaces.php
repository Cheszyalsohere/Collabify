<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Workspace = salinan template milik kelompok/pengguna.
 * Ditulis dengan forge supaya jalan di MySQL maupun SQLite.
 */
class CreateTemplateWorkspaces extends Migration
{
    public function up()
    {
        // Database lama (mis. hasil impor) mungkin sudah punya tabel ini.
        if ($this->db->tableExists('template_workspaces')) {
            return;
        }

        $this->forge->addField([
            'id_workspace' => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_template'  => ['type' => 'INT'],
            'id_group'     => ['type' => 'INT', 'null' => true],
            'created_by'   => ['type' => 'INT'],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'       => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id_workspace');
        $this->forge->addKey('id_template');
        $this->forge->addKey('id_group');
        $this->forge->addKey('created_by');

        $this->forge->addForeignKey('id_template', 'templates', 'id_template', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id_user', 'CASCADE', 'CASCADE');

        $this->forge->createTable('template_workspaces');
    }

    public function down()
    {
        $this->forge->dropTable('template_workspaces', true);
    }
}

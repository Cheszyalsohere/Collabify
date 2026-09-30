<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTemplates extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_template'     => ['type' => 'INTEGER', 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 200],
            'kategori'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'       => ['type' => 'TEXT', 'null' => true],
            'file_path'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'uploaded_by'     => ['type' => 'INT'],
            'status'          => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'downloads_count' => ['type' => 'INT', 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_template');
        $this->forge->addForeignKey('uploaded_by', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('templates');
    }

    public function down()
    {
        $this->forge->dropTable('templates', true);
    }
}

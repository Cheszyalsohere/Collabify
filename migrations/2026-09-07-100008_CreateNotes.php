<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_note'    => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_group'   => ['type' => 'INT'],
            'content'    => ['type' => 'TEXT'],
            'warna'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'kuning'],
            'created_by' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_note');
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notes');
    }

    public function down()
    {
        $this->forge->dropTable('notes', true);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_task'     => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_group'    => ['type' => 'INT'],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'todo'],
            'assigned_to' => ['type' => 'INT', 'null' => true],
            'deadline'    => ['type' => 'DATE', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_task');
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('assigned_to', 'users', 'id_user', 'SET NULL', 'SET NULL');
        $this->forge->createTable('tasks');
    }

    public function down()
    {
        $this->forge->dropTable('tasks', true);
    }
}

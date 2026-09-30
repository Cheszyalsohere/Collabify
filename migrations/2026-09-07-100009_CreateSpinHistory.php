<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpinHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_spin'    => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_group'   => ['type' => 'INT'],
            'hasil'      => ['type' => 'TEXT'],
            'created_by' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_spin');
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spin_history');
    }

    public function down()
    {
        $this->forge->dropTable('spin_history', true);
    }
}

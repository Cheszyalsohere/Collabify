<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpinHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_spin' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_group' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'hasil' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_spin', true);
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spin_history');
    }

    public function down()
    {
        $this->forge->dropTable('spin_history');
    }
}

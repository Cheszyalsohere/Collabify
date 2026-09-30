<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupMembers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_group'  => ['type' => 'INT'],
            'id_user'   => ['type' => 'INT'],
            'peran'     => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'anggota'],
            'joined_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['id_group', 'id_user']);
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('group_members');
    }

    public function down()
    {
        $this->forge->dropTable('group_members', true);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupMembers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
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
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'peran' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'anggota', // ketua | anggota
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        // Satu user tidak boleh double-join ke grup yang sama
        $this->forge->addUniqueKey(['id_group', 'id_user']);
        $this->forge->addForeignKey('id_group', 'groups', 'id_group', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('group_members');
    }

    public function down()
    {
        $this->forge->dropTable('group_members');
    }
}

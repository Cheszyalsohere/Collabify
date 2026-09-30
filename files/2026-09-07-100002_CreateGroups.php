<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_group' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kelompok' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'kode_invite' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'dibuat_oleh' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_group', true);
        $this->forge->addUniqueKey('kode_invite');
        $this->forge->addForeignKey('dibuat_oleh', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('groups');
    }

    public function down()
    {
        $this->forge->dropTable('groups');
    }
}

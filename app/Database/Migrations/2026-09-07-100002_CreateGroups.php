<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_group'      => ['type' => 'INTEGER', 'auto_increment' => true],
            'nama_kelompok' => ['type' => 'VARCHAR', 'constraint' => 150],
            'kode_invite'   => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'dibuat_oleh'   => ['type' => 'INT'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_group');
        $this->forge->addForeignKey('dibuat_oleh', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('groups');
    }

    public function down()
    {
        $this->forge->dropTable('groups', true);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBadges extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_badge'   => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_user'    => ['type' => 'INT'],
            'nama_badge' => ['type' => 'VARCHAR', 'constraint' => 100],
            'earned_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_badge');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('badges');
    }

    public function down()
    {
        $this->forge->dropTable('badges', true);
    }
}

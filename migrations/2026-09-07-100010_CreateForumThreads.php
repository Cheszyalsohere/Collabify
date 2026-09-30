<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateForumThreads extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_thread'  => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_user'    => ['type' => 'INT'],
            'kategori'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'isi'        => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_thread');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('forum_threads');
    }

    public function down()
    {
        $this->forge->dropTable('forum_threads', true);
    }
}

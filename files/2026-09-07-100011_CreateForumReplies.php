<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateForumReplies extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_reply' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_thread' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_reply', true);
        $this->forge->addForeignKey('id_thread', 'forum_threads', 'id_thread', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('forum_replies');
    }

    public function down()
    {
        $this->forge->dropTable('forum_replies');
    }
}

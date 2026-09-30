<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateForumMessagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_message' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],

            'id_channel' => [
                'type'     => 'INTEGER',
            ],

            'id_user' => [
                'type'     => 'INTEGER',
            ],

            'message' => [
                'type' => 'TEXT',
            ],

            'reply_to' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],

            'edited_at' => [
                'type' => 'DATETIME',
                'null' => true,
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

        $this->forge->addKey('id_message', true);
        $this->forge->addKey('id_channel');
        $this->forge->addKey('id_user');
        $this->forge->addKey('reply_to');

        $this->forge->addForeignKey(
            'id_channel',
            'forum_channels',
            'id_channel',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_user',
            'users',
            'id_user',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'reply_to',
            'forum_messages',
            'id_message',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('forum_messages');
    }

    public function down()
    {
        $this->forge->dropTable('forum_messages', true);
    }
}
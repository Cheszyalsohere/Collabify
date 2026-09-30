<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVoiceParticipantsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_participant' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],

            'id_channel' => [
                'type'     => 'INTEGER',
            ],

            'id_user' => [
                'type'     => 'INTEGER',
            ],

            'joined_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'left_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'is_muted' => [
                'type'       => 'INTEGER',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id_participant', true);
        $this->forge->addKey('id_channel');
        $this->forge->addKey('id_user');

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

        $this->forge->createTable('voice_participants');
    }

    public function down()
    {
        $this->forge->dropTable('voice_participants', true);
    }
}
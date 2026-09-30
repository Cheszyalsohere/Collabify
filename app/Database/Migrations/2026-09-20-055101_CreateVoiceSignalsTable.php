<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVoiceSignalsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_signal' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'id_channel' => [
                'type'       => 'INTEGER',
                'constraint' => 11,
            ],

            'sender_id' => [
                'type'       => 'INTEGER',
                'constraint' => 11,
            ],

            'receiver_id' => [
                'type'       => 'INTEGER',
                'constraint' => 11,
            ],

            'signal_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],

            'signal_data' => [
                'type' => 'TEXT',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_signal', true);

        $this->forge->addKey([
            'id_channel',
            'receiver_id',
        ]);

        $this->forge->createTable('voice_signals');
    }

    public function down()
    {
        $this->forge->dropTable('voice_signals');
    }
}
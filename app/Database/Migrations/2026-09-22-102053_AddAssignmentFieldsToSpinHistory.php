<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAssignmentFieldsToSpinHistory extends Migration
{
    public function up()
    {
        $fields = [
            'id_task' => [
                'type' => 'INT',
                'null' => true,
            ],

            'session_id' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],

            'anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ];

        $this->forge->addColumn('spin_history', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('spin_history', [
            'id_task',
            'session_id',
            'anggota',
        ]);
    }
}
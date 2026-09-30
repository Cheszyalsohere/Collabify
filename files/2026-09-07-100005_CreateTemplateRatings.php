<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTemplateRatings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rating' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_template' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rating' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 5,
            ],
            'komentar' => [
                'type' => 'TEXT',
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

        $this->forge->addKey('id_rating', true);
        // Satu user hanya bisa kasih 1 rating per template
        $this->forge->addUniqueKey(['id_template', 'id_user']);
        $this->forge->addForeignKey('id_template', 'templates', 'id_template', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('template_ratings');
    }

    public function down()
    {
        $this->forge->dropTable('template_ratings');
    }
}

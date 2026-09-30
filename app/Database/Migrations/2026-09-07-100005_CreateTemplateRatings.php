<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTemplateRatings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rating'   => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_template' => ['type' => 'INT'],
            'id_user'     => ['type' => 'INT'],
            'rating'      => ['type' => 'INT'],
            'comment'     => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_rating');
        $this->forge->addUniqueKey(['id_template', 'id_user']);
        $this->forge->addForeignKey('id_template', 'templates', 'id_template', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('template_ratings');
    }

    public function down()
    {
        $this->forge->dropTable('template_ratings', true);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTemplateBookmarks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bookmark' => ['type' => 'INTEGER', 'auto_increment' => true],
            'id_user'     => ['type' => 'INT'],
            'id_template' => ['type' => 'INT'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_bookmark');
        $this->forge->addUniqueKey(['id_user', 'id_template']);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_template', 'templates', 'id_template', 'CASCADE', 'CASCADE');
        $this->forge->createTable('template_bookmarks');
    }

    public function down()
    {
        $this->forge->dropTable('template_bookmarks', true);
    }
}

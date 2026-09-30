<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateForumChannelsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_channel' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],

            'id_group' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],

            'nama_channel' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'text',
            ],

            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'dibuat_oleh' => [
                'type'     => 'INTEGER',
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

        $this->forge->addKey('id_channel', true);
        $this->forge->addKey('id_group');
        $this->forge->addKey('dibuat_oleh');

        $this->forge->addForeignKey(
            'id_group',
            'groups',
            'id_group',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'dibuat_oleh',
            'users',
            'id_user',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('forum_channels');
    }

    public function down()
    {
        $this->forge->dropTable('forum_channels', true);
    }
}
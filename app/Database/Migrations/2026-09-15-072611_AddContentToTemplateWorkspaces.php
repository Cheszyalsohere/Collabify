<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddContentToTemplateWorkspaces extends Migration
{
    public function up()
    {
        $this->forge->addColumn('template_workspaces', [
            'content' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'file_path',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn(
            'template_workspaces',
            'content'
        );
    }
}
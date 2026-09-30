<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Satu template + satu kelompok hanya boleh punya satu workspace.
 * Portabel (MySQL & SQLite) dan aman dijalankan ulang.
 */
class AddUniqueTemplateGroupWorkspace extends Migration
{
    private const INDEX = 'idx_unique_template_group_workspace';

    public function up()
    {
        if ($this->hasIndex('template_workspaces', self::INDEX)) {
            return;
        }

        $this->db->query(
            'CREATE UNIQUE INDEX ' . self::INDEX .
            ' ON ' . $this->db->escapeIdentifiers('template_workspaces') .
            ' (id_template, id_group)'
        );
    }

    public function down()
    {
        if (! $this->hasIndex('template_workspaces', self::INDEX)) {
            return;
        }

        $table = $this->db->escapeIdentifiers('template_workspaces');

        $this->db->query(
            $this->db->DBDriver === 'SQLite3'
                ? 'DROP INDEX IF EXISTS ' . self::INDEX
                : 'DROP INDEX ' . self::INDEX . ' ON ' . $table
        );
    }

    private function hasIndex(string $table, string $name): bool
    {
        return isset($this->db->getIndexData($table)[$name]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkspaceModel extends Model
{
    protected $table = 'template_workspaces';

    protected $primaryKey = 'id_workspace';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_template',
        'id_group',
        'created_by',
        'judul',
        'file_path',
        'content',
        'status',
    ];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkspaceHistoryModel extends Model
{
    protected $table            = 'workspace_history';
    protected $primaryKey       = 'id_history';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_user',
        'id_template',
        'judul',
        'doc_url',
        'created_at',
    ];
}

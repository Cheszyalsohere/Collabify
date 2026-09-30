<?php

namespace App\Models;

use CodeIgniter\Model;

class TemplateBookmarkModel extends Model
{
    protected $table = 'template_bookmarks';
    protected $primaryKey = 'id_bookmark';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_user',
        'id_template',
        'created_at',
    ];
}
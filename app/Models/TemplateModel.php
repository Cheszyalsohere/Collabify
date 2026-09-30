<?php

namespace App\Models;

use CodeIgniter\Model;

class TemplateModel extends Model
{
    protected $table            = 'templates';
    protected $primaryKey       = 'id_template';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'judul',
        'kategori',
        'deskripsi',
        'file_path',
        'uploaded_by',
        'status',
        'downloads_count',
        'gdoc_type',
        'gdoc_id',
    ];
}
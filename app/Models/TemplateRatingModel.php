<?php

namespace App\Models;

use CodeIgniter\Model;

class TemplateRatingModel extends Model
{
    protected $table = 'template_ratings';
    protected $primaryKey = 'id_rating';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_template',
        'id_user',
        'rating',
        'comment',
        'created_at',
    ];
}
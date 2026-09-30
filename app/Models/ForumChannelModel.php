<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumChannelModel extends Model
{
    protected $table = 'forum_channels';

    protected $primaryKey = 'id_channel';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_group',
        'nama_channel',
        'slug',
        'tipe',
        'deskripsi',
        'dibuat_oleh',
    ];
}
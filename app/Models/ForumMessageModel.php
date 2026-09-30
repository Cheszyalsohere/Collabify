<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumMessageModel extends Model
{
    protected $table = 'forum_messages';

    protected $primaryKey = 'id_message';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_channel',
        'id_user',
        'message',
        'reply_to',
        'edited_at',
    ];
}
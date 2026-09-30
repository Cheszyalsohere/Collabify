<?php

namespace App\Models;

use CodeIgniter\Model;

class VoiceParticipantModel extends Model
{
    protected $table = 'voice_participants';

    protected $primaryKey = 'id_participant';

    protected $allowedFields = [
        'id_channel',
        'id_user',
        'joined_at',
        'left_at',
        'is_muted',
    ];

    protected $useTimestamps = false;
}
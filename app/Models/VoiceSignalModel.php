<?php

namespace App\Models;

use CodeIgniter\Model;

class VoiceSignalModel extends Model
{
    protected $table = 'voice_signals';

    protected $primaryKey = 'id_signal';

    protected $allowedFields = [
        'id_channel',
        'sender_id',
        'receiver_id',
        'signal_type',
        'signal_data',
        'created_at',
    ];

    protected $useTimestamps = false;
}
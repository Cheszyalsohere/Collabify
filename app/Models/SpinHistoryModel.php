<?php

namespace App\Models;

use CodeIgniter\Model;

class SpinHistoryModel extends Model
{
    protected $table            = 'spin_history';
    protected $primaryKey       = 'id_spin';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_group',
        'id_task',
        'session_id',
        'anggota',
        'id_anggota',
        'hasil',
        'created_by',
        'nomor_spin',
        'is_ulang',
        'kode',
        'created_at',
    ];
}

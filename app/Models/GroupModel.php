<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table            = 'groups';
    protected $primaryKey       = 'id_group';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'nama_kelompok',
        'kode_invite',
        'dibuat_oleh',
    ];

    /**
     * Bikin kode invite unik 6 karakter (huruf besar + angka),
     * dicek dulu ke database biar nggak ada yang bentrok.
     */
    public function generateUniqueInviteCode(): string
    {
        do {
            $code = strtoupper(bin2hex(random_bytes(3))); // contoh: A1B2C3
        } while ($this->where('kode_invite', $code)->first());

        return $code;
    }

    /**
     * Ambil semua grup yang diikuti seorang user (lewat tabel group_members).
     */
    public function getGroupsForUser(int $idUser): array
    {
        return $this->select('groups.*, group_members.peran')
            ->join('group_members', 'group_members.id_group = groups.id_group')
            ->where('group_members.id_user', $idUser)
            ->orderBy('groups.created_at', 'DESC')
            ->findAll();
    }
}
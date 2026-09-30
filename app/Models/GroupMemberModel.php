<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupMemberModel extends Model
{
    protected $table            = 'group_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false; // pakai kolom joined_at manual, bukan created_at/updated_at

    protected $allowedFields = [
        'id_group',
        'id_user',
        'peran',
        'joined_at',
    ];

    public function isMember(int $idGroup, int $idUser): bool
    {
        return (bool) $this->where('id_group', $idGroup)
            ->where('id_user', $idUser)
            ->first();
    }

    /**
     * Daftar anggota satu grup, lengkap sama nama & email dari tabel users.
     */
    public function getMembersWithUser(int $idGroup): array
    {
        return $this->select('group_members.*, users.name, users.email')
            ->join('users', 'users.id_user = group_members.id_user')
            ->where('group_members.id_group', $idGroup)
            ->orderBy('group_members.joined_at', 'ASC')
            ->findAll();
    }

    public function countMembers(int $idGroup): int
    {
        return $this->where('id_group', $idGroup)->countAllResults();
    }
}
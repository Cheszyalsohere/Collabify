<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\GroupMemberModel;
use App\Models\WorkspaceModel;
use App\Models\ForumChannelModel;

class GroupController extends BaseController
{
protected GroupModel $groupModel;
protected GroupMemberModel $memberModel;
protected WorkspaceModel $workspaceModel;
protected ForumChannelModel $channelModel;

public function __construct()
{
    $this->groupModel = new GroupModel();
    $this->memberModel = new GroupMemberModel();
    $this->workspaceModel = new WorkspaceModel();
    $this->channelModel = new ForumChannelModel();
}


    /**
     * Daftar kelompok.
     *
     * Mahasiswa hanya melihat kelompok
     * yang diikuti.
     *
     * Dosen/admin dapat melihat semua kelompok.
     */
    public function index()
    {
        $role   = session()->get('role');
        $idUser = session()->get('id_user');

        if (in_array($role, ['dosen', 'admin'], true)) {

            $groups = $this->groupModel
                ->orderBy('created_at', 'DESC')
                ->findAll();

        } else {

            $groups = $this->groupModel
                ->getGroupsForUser($idUser);
        }

        return view('groups/index', [
            'groups' => $groups
        ]);
    }


    /**
     * Form membuat kelompok.
     */
    public function create()
    {
        return view('groups/create');
    }


    /**
     * Membuat kelompok baru.
     */
    public function store()
    {
        $rules = [
            'nama_kelompok' =>
                'required|min_length[3]|max_length[150]',
        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $idUser = session()->get('id_user');

        $kodeUnik =
            $this->groupModel
                ->generateUniqueInviteCode();

        $idGroup =
            $this->groupModel
                ->insert([
                    'nama_kelompok' =>
                        $this->request
                            ->getPost(
                                'nama_kelompok'
                            ),

                    'kode_invite' =>
                        $kodeUnik,

                    'dibuat_oleh' =>
                        $idUser,
                ]);

        /*
         * Pembuat kelompok otomatis
         * menjadi ketua.
         */
        $this->memberModel
        ->insert([
                'id_group' =>
                    $idGroup,

                'id_user' =>
                    $idUser,

                'peran' =>
                    'ketua',

                'joined_at' =>
                    date('Y-m-d H:i:s'),
            ]);
/*
 * Membuat channel forum default
 * untuk kelompok baru.
 */
$now = date('Y-m-d H:i:s');

$this->channelModel
    ->insertBatch([
        [
            'id_group' =>
                $idGroup,

            'nama_channel' =>
                'general',

            'slug' =>
                'general',

            'tipe' =>
                'text',

            'deskripsi' =>
                'Tempat ngobrol umum kelompok.',

            'dibuat_oleh' =>
                $idUser,

            'created_at' =>
                $now,

            'updated_at' =>
                $now,
        ],

        [
            'id_group' =>
                $idGroup,

            'nama_channel' =>
                'diskusi',

            'slug' =>
                'diskusi',

            'tipe' =>
                'text',

            'deskripsi' =>
                'Tempat berdiskusi bersama anggota kelompok.',

            'dibuat_oleh' =>
                $idUser,

            'created_at' =>
                $now,

            'updated_at' =>
                $now,
        ],

        [
            'id_group' =>
                $idGroup,

            'nama_channel' =>
                'Ruang Diskusi',

            'slug' =>
                'ruang-diskusi',

            'tipe' =>
                'voice',

            'deskripsi' =>
                'Ruang voice untuk berdiskusi bersama.',

            'dibuat_oleh' =>
                $idUser,

            'created_at' =>
                $now,

            'updated_at' =>
                $now,
        ],
    ]);
    
        return redirect()
            ->to('/groups/' . $idGroup)
            ->with(
                'success',
                "Kelompok berhasil dibuat! Kode invite: {$kodeUnik}"
            );
    }


    /**
     * Form join kelompok.
     */
    public function joinForm()
    {
        return view('groups/join');
    }


    /**
     * Join kelompok menggunakan kode invite.
     */
    public function join()
    {
        $rules = [
            'kode_invite' => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $kode =
            strtoupper(
                trim(
                    $this->request
                        ->getPost('kode_invite')
                )
            );

        $group =
            $this->groupModel
                ->where(
                    'kode_invite',
                    $kode
                )
                ->first();

        if (!$group) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Kode invite tidak ditemukan.'
                );
        }

        $idUser =
            session()->get('id_user');

        $idGroup =
            $group['id_group'];

        if (
            $this->memberModel
                ->isMember(
                    $idGroup,
                    $idUser
                )
        ) {

            return redirect()
                ->to('/groups/' . $idGroup)
                ->with(
                    'error',
                    'Kamu sudah jadi anggota kelompok ini.'
                );
        }

        $this->memberModel
            ->insert([
                'id_group' =>
                    $idGroup,

                'id_user' =>
                    $idUser,

                'peran' =>
                    'anggota',

                'joined_at' =>
                    date('Y-m-d H:i:s'),
            ]);

        return redirect()
            ->to('/groups/' . $idGroup)
            ->with(
                'success',
                'Berhasil gabung ke kelompok!'
            );
    }


    /**
     * Detail kelompok.
     *
     * Sekarang sekaligus mengambil
     * workspace yang dimiliki kelompok.
     */
    public function show($idGroup)
    {
        $group =
            $this->groupModel
                ->find($idGroup);

        if (!$group) {

            return redirect()
                ->to('/groups')
                ->with(
                    'error',
                    'Kelompok tidak ditemukan.'
                );
        }

        $role =
            session()->get('role');

        $idUser =
            session()->get('id_user');


        /*
         * Mahasiswa hanya boleh melihat
         * kelompok yang diikutinya.
         *
         * Admin dan dosen dapat melihat
         * semua kelompok.
         */
        if (
            !in_array(
                $role,
                ['dosen', 'admin'],
                true
            )
            &&
            !$this->memberModel
                ->isMember(
                    $idGroup,
                    $idUser
                )
        ) {

            return redirect()
                ->to('/groups')
                ->with(
                    'error',
                    'Kamu bukan anggota kelompok ini.'
                );
        }


        /*
         * Ambil anggota kelompok.
         */
        $members =
            $this->memberModel
                ->getMembersWithUser(
                    $idGroup
                );


        /*
         * Ambil semua workspace aktif
         * milik kelompok ini.
         */
        $workspaces =
            $this->workspaceModel
                ->select('
                    template_workspaces.*,
                    templates.judul AS template_asal,
                    templates.kategori,
                    users.name AS pembuat
                ')
                ->join(
                    'templates',
                    'templates.id_template = template_workspaces.id_template',
                    'left'
                )
                ->join(
                    'users',
                    'users.id_user = template_workspaces.created_by',
                    'left'
                )
                ->where(
                    'template_workspaces.id_group',
                    $idGroup
                )
                ->where(
                    'template_workspaces.status',
                    'active'
                )
                ->orderBy(
                    'template_workspaces.updated_at',
                    'DESC'
                )
                ->findAll();


        return view('groups/show', [
            'group' =>
                $group,

            'members' =>
                $members,

            'workspaces' =>
                $workspaces,
        ]);
    }


    /**
     * Data anggota kelompok dalam bentuk JSON.
     */
    public function members($idGroup)
    {
        $idUser =
            session()->get('id_user');

        $role =
            session()->get('role');

        if (
            !in_array(
                $role,
                ['admin', 'dosen'],
                true
            )
        ) {

            if (
                !$this->memberModel
                    ->isMember(
                        (int) $idGroup,
                        $idUser
                    )
            ) {

                return $this->response
                    ->setStatusCode(403)
                    ->setJSON([
                        'success' =>
                            false,

                        'message' =>
                            'Kamu bukan anggota kelompok ini.'
                    ]);
            }
        }

        $members =
            $this->memberModel
                ->getMembersWithUser(
                    (int) $idGroup
                );

        return $this->response
            ->setJSON([
                'success' =>
                    true,

                'members' =>
                    $members,
            ]);
    }
}
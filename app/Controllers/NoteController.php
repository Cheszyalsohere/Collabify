<?php

namespace App\Controllers;

use App\Models\NoteModel;
use App\Models\GroupModel;
use App\Models\GroupMemberModel;

class NoteController extends BaseController
{
    protected NoteModel $noteModel;
    protected GroupModel $groupModel;
    protected GroupMemberModel $memberModel;

    public function __construct()
    {
        $this->noteModel   = new NoteModel();
        $this->groupModel  = new GroupModel();
        $this->memberModel = new GroupMemberModel();
    }

    /**
     * Daftar catatan
     */
    public function index()
    {
        $idUser = session()->get('id_user');

        // Catatan bersifat pribadi: hanya pemilik yang boleh melihat.
        $notes = $this->noteModel
            ->select('notes.*, groups.nama_kelompok, users.name AS creator_name')
            ->join('groups', 'groups.id_group = notes.id_group', 'left')
            ->join('users', 'users.id_user = notes.created_by', 'left')
            ->where('notes.created_by', $idUser)
            ->orderBy('notes.created_at', 'DESC')
            ->findAll();

        return view('notes/index', [
            'title' => 'Catatan — COLLABIFY',
            'notes' => $notes,
        ]);
    }

    /**
     * Form tambah catatan
     */
    public function create()
    {
        $idUser = session()->get('id_user');
        $role   = session()->get('role');

        if (in_array($role, ['admin', 'dosen'], true)) {
            $groups = $this->groupModel
                ->orderBy('nama_kelompok', 'ASC')
                ->findAll();
        } else {
            $groups = $this->groupModel->getGroupsForUser($idUser);
        }

        return view('notes/create', [
            'title'  => 'Tambah Catatan — COLLABIFY',
            'groups' => $groups,
        ]);
    }

    /**
     * Simpan catatan
     */
    public function store()
    {
        $rules = [
            'id_group' => 'required|integer',
            'content'  => 'required|min_length[1]|max_length[5000]',
            'warna'    => 'required|in_list[kuning,hijau,biru,pink]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idUser  = session()->get('id_user');
        $role    = session()->get('role');
        $idGroup = (int) $this->request->getPost('id_group');

        // Pastikan mahasiswa memang anggota kelompok
        if (! in_array($role, ['admin', 'dosen'], true)) {
            if (! $this->memberModel->isMember($idGroup, $idUser)) {
                return redirect()->to('/notes')
                    ->with('error', 'Kamu bukan anggota kelompok tersebut.');
            }
        }

        $this->noteModel->insert([
            'id_group'   => $idGroup,
            'content'    => trim($this->request->getPost('content')),
            'warna'      => $this->request->getPost('warna'),
            'created_by' => $idUser,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/notes')
            ->with('success', 'Catatan berhasil ditambahkan.');
    }

    /**
     * Hapus catatan
     */
    public function delete($idNote)
    {
        $note = $this->noteModel->find($idNote);

        if (! $note) {
            return redirect()->to('/notes')
                ->with('error', 'Catatan tidak ditemukan.');
        }

        // Catatan bersifat pribadi: hanya pemilik yang boleh menghapus.
        if ((int) $note['created_by'] !== (int) session()->get('id_user')) {
            return redirect()->to('/notes')
                ->with('error', 'Kamu hanya dapat menghapus catatan milikmu sendiri.');
        }

        $this->noteModel->delete($idNote);

        return redirect()->to('/notes')
            ->with('success', 'Catatan berhasil dihapus.');
    }
}

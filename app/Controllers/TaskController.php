<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\GroupModel;
use App\Models\GroupMemberModel;

class TaskController extends BaseController
{
    protected TaskModel $taskModel;
    protected GroupModel $groupModel;
    protected GroupMemberModel $memberModel;

    public function __construct()
    {
        $this->taskModel   = new TaskModel();
        $this->groupModel  = new GroupModel();
        $this->memberModel = new GroupMemberModel();
    }

    /**
     * Daftar tugas
     */
    public function index()
    {
        $idUser = session()->get('id_user');
        $role   = session()->get('role');

        if (in_array($role, ['admin', 'dosen'], true)) {
            $tasks = $this->taskModel
                ->select('tasks.*, groups.nama_kelompok, users.name AS assigned_name')
                ->join('groups', 'groups.id_group = tasks.id_group', 'left')
                ->join('users', 'users.id_user = tasks.assigned_to', 'left')
                ->orderBy('tasks.deadline', 'ASC')
                ->findAll();
        } else {
            $tasks = $this->taskModel
                ->select('tasks.*, groups.nama_kelompok, users.name AS assigned_name')
                ->join('groups', 'groups.id_group = tasks.id_group', 'left')
                ->join('users', 'users.id_user = tasks.assigned_to', 'left')
                ->join(
                    'group_members',
                    'group_members.id_group = tasks.id_group'
                )
                ->where('group_members.id_user', $idUser)
                ->groupBy('tasks.id_task')
                ->orderBy('tasks.deadline', 'ASC')
                ->findAll();
        }

        return view('tasks/index', [
            'title' => 'Tugas — COLLABIFY',
            'tasks' => $tasks,
        ]);
    }

    /**
     * Form tambah tugas
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

        return view('tasks/create', [
            'title'  => 'Tambah Tugas — COLLABIFY',
            'groups' => $groups,
        ]);
    }

    /**
     * Simpan tugas
     */
    public function store()
    {
        $rules = [
            'id_group' => 'required|integer',
            'judul'    => 'required|min_length[3]|max_length[200]',
            'deskripsi' => 'permit_empty',
            'deadline' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idUser = session()->get('id_user');
        $role   = session()->get('role');
        $idGroup = (int) $this->request->getPost('id_group');

        // Pastikan mahasiswa memang anggota kelompok
        if (! in_array($role, ['admin', 'dosen'], true)) {
            if (! $this->memberModel->isMember($idGroup, $idUser)) {
                return redirect()->to('/tasks')
                    ->with('error', 'Kamu bukan anggota kelompok tersebut.');
            }
        }

        $assignedTo = $this->request->getPost('assigned_to');

        $this->taskModel->insert([
            'id_group'   => $idGroup,
            'judul'      => trim($this->request->getPost('judul')),
            'deskripsi'  => trim($this->request->getPost('deskripsi') ?? ''),
            'status'     => 'todo',
            'assigned_to' => !empty($assignedTo) ? (int) $assignedTo : null,
            'deadline'   => $this->request->getPost('deadline') ?: null,
        ]);

        return redirect()->to('/tasks')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Detail tugas
     */
    public function show($idTask)
    {
        $task = $this->taskModel
            ->select('tasks.*, groups.nama_kelompok, users.name AS assigned_name')
            ->join('groups', 'groups.id_group = tasks.id_group', 'left')
            ->join('users', 'users.id_user = tasks.assigned_to', 'left')
            ->where('tasks.id_task', $idTask)
            ->first();

        if (! $task) {
            return redirect()->to('/tasks')
                ->with('error', 'Tugas tidak ditemukan.');
        }

        $idUser = session()->get('id_user');
        $role   = session()->get('role');

        if (! in_array($role, ['admin', 'dosen'], true)) {
            if (! $this->memberModel->isMember((int) $task['id_group'], $idUser)) {
                return redirect()->to('/tasks')
                    ->with('error', 'Kamu tidak memiliki akses ke tugas ini.');
            }
        }

        return view('tasks/show', [
            'title' => 'Detail Tugas — COLLABIFY',
            'task'  => $task,
        ]);
    }

    /**
     * Update status tugas
     */
    public function updateStatus($idTask)
    {
        $task = $this->taskModel->find($idTask);

        if (! $task) {
            return redirect()->to('/tasks')
                ->with('error', 'Tugas tidak ditemukan.');
        }

        $idUser = session()->get('id_user');
        $role   = session()->get('role');

        if (! in_array($role, ['admin', 'dosen'], true)) {
            if (! $this->memberModel->isMember((int) $task['id_group'], $idUser)) {
                return redirect()->to('/tasks')
                    ->with('error', 'Kamu tidak memiliki akses.');
            }
        }

        $status = $this->request->getPost('status');

        $allowedStatus = [
            'todo',
            'in_progress',
            'done',
        ];

        if (! in_array($status, $allowedStatus, true)) {
            return redirect()->back()
                ->with('error', 'Status tugas tidak valid.');
        }

        $this->taskModel->update($idTask, [
            'status' => $status,
        ]);

        return redirect()->back()
            ->with('success', 'Status tugas berhasil diperbarui.');
    }
}

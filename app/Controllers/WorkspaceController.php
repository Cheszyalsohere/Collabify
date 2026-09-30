<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;
use App\Models\GroupModel;
use App\Libraries\DocxToHtml;
use App\Models\GroupMemberModel;
use App\Models\TemplateModel;

class WorkspaceController extends BaseController
{
    protected WorkspaceModel $workspaceModel;
    protected GroupModel $groupModel;
    protected GroupMemberModel $memberModel;
    protected TemplateModel $templateModel;

    public function __construct()
    {
        $this->workspaceModel = new WorkspaceModel();
        $this->groupModel = new GroupModel();
        $this->memberModel = new GroupMemberModel();
        $this->templateModel = new TemplateModel();
    }


    /**
     * Daftar workspace yang bisa diakses user.
     */
    public function index()
    {
        $idUser = session()->get('id_user');
        $role   = session()->get('role');

        if (!$idUser) {
            return redirect()->to('/login');
        }

        $builder = $this->workspaceModel
            ->select('
                template_workspaces.*,
                groups.nama_kelompok,
                templates.judul AS template_asal
            ')
            ->join(
                'groups',
                'groups.id_group = template_workspaces.id_group',
                'left'
            )
            ->join(
                'templates',
                'templates.id_template = template_workspaces.id_template',
                'left'
            );

        if (!in_array($role, ['admin', 'dosen'], true)) {

            $builder
                ->join(
                    'group_members',
                    'group_members.id_group = template_workspaces.id_group',
                    'left'
                )
                ->groupStart()
                    ->where(
                        'template_workspaces.created_by',
                        $idUser
                    )
                    ->orWhere(
                        'group_members.id_user',
                        $idUser
                    )
                ->groupEnd();
        }

        $workspaces = $builder
            ->where(
                'template_workspaces.status',
                'active'
            )
            ->orderBy(
                'template_workspaces.updated_at',
                'DESC'
            )
            ->findAll();

        $history = (new \App\Models\WorkspaceHistoryModel())
            ->select('workspace_history.*, templates.gdoc_type, templates.gdoc_id')
            ->join('templates', 'templates.id_template = workspace_history.id_template', 'left')
            ->where('workspace_history.id_user', (int) $idUser)
            ->orderBy('workspace_history.created_at', 'DESC')
            ->orderBy('workspace_history.id_history', 'DESC')
            ->findAll();

        return view('workspaces/index', [
            'title'      => 'Workspace — COLLABIFY',
            'workspaces' => $workspaces,
            'history'    => $history,
        ]);
    }

    /**
     * Simpan tautan dokumen Google milik pengguna ke satu baris riwayat.
     * Route: workspaces/riwayat/(:num)/link  (POST)
     */
    public function saveHistoryLink($idHistory)
    {
        $model = new \App\Models\WorkspaceHistoryModel();
        $row   = $model->where('id_history', (int) $idHistory)
            ->where('id_user', (int) session()->get('id_user'))
            ->first();

        if (! $row) {
            return redirect()->to('/workspaces')->with('error', 'Riwayat tidak ditemukan.');
        }

        $url = trim((string) $this->request->getPost('doc_url'));

        if ($url === '') {
            $model->update($row['id_history'], ['doc_url' => null]);

            return redirect()->to('/workspaces')->with('success', 'Tautan dihapus.');
        }

        $parsed = \App\Controllers\TemplateController::parseGoogleDocUrl($url);

        if ($parsed === null) {
            return redirect()->to('/workspaces')
                ->with('error', 'Tautan harus alamat dokumen dari docs.google.com (Docs, Sheets, atau Slides).');
        }

        // Disimpan dalam bentuk baku (tanpa parameter tambahan).
        $model->update($row['id_history'], [
            'doc_url' => 'https://docs.google.com/' . $parsed['type'] . '/d/' . $parsed['id'] . '/edit',
        ]);

        return redirect()->to('/workspaces')->with('success', 'Tautan Google Docs tersimpan.');
    }

    /**
     * Workspace tanpa template: buka dokumen Google KOSONG (docs.new) di tab baru.
     * Dokumen dibuat di Drive pengguna sendiri; aplikasi hanya mencatatnya di riwayat.
     * Route: workspaces/dokumen-kosong  (POST)
     */
    public function dokumenKosong()
    {
        $judul = trim((string) $this->request->getPost('judul'));
        $judul = $judul === '' ? 'Dokumen baru' : mb_substr($judul, 0, 200);

        (new \App\Models\WorkspaceHistoryModel())->insert([
            'id_user'     => (int) session()->get('id_user'),
            'id_template' => null,
            'judul'       => $judul,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('https://docs.new');
    }

    /**
     * Hapus satu baris riwayat (milik sendiri).
     * Route: workspaces/riwayat/(:num)/hapus  (POST)
     */
    public function deleteHistory($idHistory)
    {
        (new \App\Models\WorkspaceHistoryModel())
            ->where('id_history', (int) $idHistory)
            ->where('id_user', (int) session()->get('id_user'))
            ->delete();

        return redirect()->to('/workspaces')->with('success', 'Riwayat dihapus.');
    }


    /**
     * Halaman "Gunakan Template".
     *
     * Method ini dipanggil oleh route:
     * templates/(:num)/use
     */
    public function createFromTemplate($idTemplate)
    {
        $idUser = session()->get('id_user');

        if (!$idUser) {
            return redirect()->to('/login');
        }

        /*
         * Ambil template yang sudah approved.
         */
        $template = $this->templateModel
            ->where(
                'id_template',
                $idTemplate
            )
            ->where(
                'status',
                'approved'
            )
            ->first();

        if (!$template) {
            return redirect()
                ->to('/templates')
                ->with(
                    'error',
                    'Template tidak ditemukan.'
                );
        }

        /*
         * Pastikan file template tersedia.
         */
        if (
            empty($template['file_path']) ||
            !is_file(
                WRITEPATH . $template['file_path']
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'File template tidak tersedia.'
                );
        }

        /*
         * Ambil kelompok yang diikuti user.
         */
        $groups = $this->groupModel
            ->getGroupsForUser($idUser);

        /*
         * Cari workspace yang sudah ada
         * untuk template ini pada setiap kelompok.
         */
        $existingWorkspaces = [];

        foreach ($groups as $group) {

            $existing = $this->workspaceModel
                ->where(
                    'id_template',
                    $idTemplate
                )
                ->where(
                    'id_group',
                    $group['id_group']
                )
                ->where(
                    'status',
                    'active'
                )
                ->first();

            if ($existing) {
                $existingWorkspaces[
                    $group['id_group']
                ] = $existing;
            }
        }

        return view('workspaces/create', [
            'title'             => 'Gunakan Template',
            'template'          => $template,
            'groups'            => $groups,
            'existingWorkspaces' => $existingWorkspaces,
        ]);
    }


    /**
     * Menyimpan workspace baru.
     *
     * Route:
     * workspaces/store
     */
    public function store()
    {
        $idUser = session()->get('id_user');

        if (!$idUser) {
            return redirect()->to('/login');
        }

        $templateId = (int) $this->request
            ->getPost('id_template');

        $groupId = $this->request
            ->getPost('id_group');

        $judul = trim(
            $this->request->getPost('judul')
        );

        if (!$templateId) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Template tidak ditemukan.'
                );
        }

        // Kelompok opsional: kosong = workspace pribadi (id_group NULL).

        /*
         * Jika judul kosong,
         * gunakan judul template.
         */
        if ($judul === '') {

            $template = $this->templateModel
                ->where(
                    'id_template',
                    $templateId
                )
                ->where(
                    'status',
                    'approved'
                )
                ->first();

            if ($template) {
                $judul = $template['judul'];
            } else {
                $judul = 'Workspace Baru';
            }
        }

        return $this->createWorkspace(
            $templateId,
            (int) $groupId,
            $judul,
            $idUser
        );
    }


    /**
     * Membuat workspace untuk template + kelompok.
     */
    private function createWorkspace(
        int $templateId,
        int $groupId,
        string $judul,
        int $idUser
    ) {
        /*
         * Pastikan template valid.
         */
        $template = $this->templateModel
            ->where(
                'id_template',
                $templateId
            )
            ->where(
                'status',
                'approved'
            )
            ->first();

        if (!$template) {
            return redirect()
                ->to('/templates')
                ->with(
                    'error',
                    'Template tidak ditemukan.'
                );
        }

        /*
         * Pastikan user anggota kelompok.
         */
        $isMember = $groupId === 0
            || $this->memberModel->isMember($groupId, $idUser);

        if (!$isMember) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Kamu bukan anggota kelompok tersebut.'
                );
        }

        /*
         * =================================================
         * CEK WORKSPACE YANG SUDAH ADA
         * =================================================
         *
         * Satu template + satu kelompok
         * hanya boleh memiliki satu workspace.
         */
        $existingQuery = $this->workspaceModel->where('id_template', $templateId);

        if ($groupId > 0) {
            $existingQuery->where('id_group', $groupId);
        } else {
            // pribadi: satu workspace per pengguna per template
            $existingQuery->where('id_group', null)->where('created_by', $idUser);
        }

        $existingWorkspace = $existingQuery
            ->where(
                'status',
                'active'
            )
            ->first();

        /*
         * Kalau sudah ada,
         * langsung buka workspace tersebut.
         */
        if ($existingWorkspace) {

            return redirect()
                ->to(
                    '/workspaces/' .
                    $existingWorkspace['id_workspace']
                )
                ->with(
                    'success',
                    'Workspace kelompok sudah tersedia.'
                );
        }


        /*
         * =================================================
         * SALIN FILE TEMPLATE
         * =================================================
         */

        $sourcePath = WRITEPATH .
            $template['file_path'];

        if (!is_file($sourcePath)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'File template tidak ditemukan.'
                );
        }


        $workspaceFolder = WRITEPATH .
            'uploads/workspaces';


        if (!is_dir($workspaceFolder)) {

            mkdir(
                $workspaceFolder,
                0775,
                true
            );
        }


        $extension = pathinfo(
            $sourcePath,
            PATHINFO_EXTENSION
        );


        $newFileName =
            bin2hex(
                random_bytes(16)
            ) .
            (
                $extension
                    ? '.' . $extension
                    : ''
            );


        $destinationPath =
            $workspaceFolder .
            DIRECTORY_SEPARATOR .
            $newFileName;


        if (
            !copy(
                $sourcePath,
                $destinationPath
            )
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Gagal membuat salinan template.'
                );
        }


        /*
         * =================================================
         * SIMPAN WORKSPACE
         * =================================================
         */

        $workspaceId = $this->workspaceModel
            ->insert([
                'id_template' => $templateId,
                'id_group'    => $groupId > 0 ? $groupId : null,
                'created_by'  => $idUser,
                'judul'       => $judul,
                'file_path'   =>
                    'uploads/workspaces/' .
                    $newFileName,
                // Isi template ikut dimuat ke editor
                'content'     => DocxToHtml::sanitize(
                    DocxToHtml::fromFile($destinationPath)
                ),
                'status'      => 'active',
            ]);


        if (!$workspaceId) {

            if (
                is_file(
                    $destinationPath
                )
            ) {
                unlink($destinationPath);
            }

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Workspace gagal dibuat.'
                );
        }


        return redirect()
            ->to(
                '/workspaces/' .
                $workspaceId
            )
            ->with(
                'success',
                'Workspace berhasil dibuat.'
            );
    }


    /**
     * Detail workspace.
     */

    /**
 * Menyimpan isi editor workspace.
 */
public function save()
{
    $idUser = session()->get('id_user');

    if (!$idUser) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ]);
    }

    $idWorkspace = (int) $this->request
        ->getPost('id_workspace');

    $content = $this->request
        ->getPost('content');

    if (!$idWorkspace) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Workspace tidak ditemukan.'
            ]);
    }

    /*
     * Cari workspace.
     */
    $workspace = $this->workspaceModel
        ->where(
            'id_workspace',
            $idWorkspace
        )
        ->where(
            'status',
            'active'
        )
        ->first();

    if (!$workspace) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Workspace tidak ditemukan.'
            ]);
    }

    /*
     * Pastikan user memiliki akses.
     *
     * Pembuat workspace boleh menyimpan.
     * Anggota kelompok juga boleh menyimpan.
     */
    $isCreator =
        (int) $workspace['created_by']
        ===
        (int) $idUser;

    $isGroupMember = false;

    if (!empty($workspace['id_group'])) {

        $isGroupMember =
            $this->memberModel
                ->isMember(
                    (int) $workspace['id_group'],
                    $idUser
                );
    }

    if (!$isCreator && !$isGroupMember) {

        return $this->response
            ->setStatusCode(403)
            ->setJSON([
                'success' => false,
                'message' => 'Kamu tidak memiliki akses untuk mengedit workspace ini.'
            ]);
    }

    /*
     * Simpan isi editor.
     */
    $updated = $this->workspaceModel
        ->update(
            $idWorkspace,
            [
                'content' => DocxToHtml::sanitize((string) $content),
            ]
        );

    if (!$updated) {

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan workspace.'
            ]);
    }

    return $this->response
        ->setJSON([
            'success' => true,
            'message' => 'Workspace berhasil disimpan.',
            'saved_at' => date('Y-m-d H:i:s'),
        ]);
}
    public function show($idWorkspace)
    {
        $idUser = session()->get('id_user');
        $role   = session()->get('role');

        if (!$idUser) {
            return redirect()->to('/login');
        }

        $workspace = $this->workspaceModel
            ->select('
                template_workspaces.*,
                templates.judul AS template_asal,
                templates.kategori,
                groups.nama_kelompok,
                users.name AS pembuat
            ')
            ->join(
                'templates',
                'templates.id_template = template_workspaces.id_template',
                'left'
            )
            ->join(
                'groups',
                'groups.id_group = template_workspaces.id_group',
                'left'
            )
            ->join(
                'users',
                'users.id_user = template_workspaces.created_by',
                'left'
            )
            ->where(
                'template_workspaces.id_workspace',
                $idWorkspace
            )
            ->where(
                'template_workspaces.status',
                'active'
            )
            ->first();

        if (!$workspace) {

            return redirect()
                ->to('/workspaces')
                ->with(
                    'error',
                    'Workspace tidak ditemukan.'
                );
        }


        /*
         * Workspace yang dibuat sebelum konversi ada masih kosong:
         * isi sekali dari salinan template-nya.
         */
        // Editor kosong yang sempat tersimpan otomatis berisi mis. "<br>" atau "<p><br></p>",
        // jadi "kosong" berarti tidak ada teks sama sekali.
        $isBlank = trim(str_replace("\u{00A0}", ' ', html_entity_decode(strip_tags((string) ($workspace['content'] ?? ''))))) === '';

        if ($isBlank && !empty($workspace['file_path'])) {
            $file = WRITEPATH . $workspace['file_path'];
            $html = DocxToHtml::sanitize(DocxToHtml::fromFile($file));

            if ($html !== '') {
                $this->workspaceModel->update(
                    (int) $workspace['id_workspace'],
                    ['content' => $html]
                );
                $workspace['content'] = $html;
            }
        }

        /*
         * Admin dan dosen boleh melihat semua.
         */
        if (
            in_array(
                $role,
                ['admin', 'dosen'],
                true
            )
        ) {

            return view(
                'workspaces/show',
                [
                    'title'     =>
                        $workspace['judul'],
                    'workspace' =>
                        $workspace,
                ]
            );
        }


        /*
         * Pembuat workspace boleh masuk.
         */
        $isCreator =
            (int) $workspace['created_by']
            ===
            (int) $idUser;


        /*
         * Anggota kelompok juga boleh masuk.
         */
        $isGroupMember = false;

        if (
            !empty(
                $workspace['id_group']
            )
        ) {

            $isGroupMember =
                $this->memberModel
                    ->isMember(
                        (int) $workspace['id_group'],
                        $idUser
                    );
        }


        if (
            !$isCreator &&
            !$isGroupMember
        ) {

            return redirect()
                ->to('/workspaces')
                ->with(
                    'error',
                    'Kamu tidak memiliki akses ke workspace ini.'
                );
        }


        return view(
            'workspaces/show',
            [
                'title' =>
                    $workspace['judul'],

                'workspace' =>
                    $workspace,

                'isCreator' =>
                    $isCreator,

                'isGroupMember' =>
                    $isGroupMember,
            ]
        );
    }
}
<?php

namespace App\Controllers;

use App\Models\TemplateModel;
use App\Models\TemplateBookmarkModel;
use App\Models\TemplateRatingModel;

class TemplateController extends BaseController
{
    protected TemplateModel $templateModel;
    protected TemplateBookmarkModel $bookmarkModel;
    protected TemplateRatingModel $ratingModel;

    public function __construct()
    {
        $this->templateModel = new TemplateModel();
        $this->bookmarkModel = new TemplateBookmarkModel();
        $this->ratingModel   = new TemplateRatingModel();
    }

    public function index()
    {
        $templates = $this->templateModel
            ->select('
                templates.*,
                users.name AS uploader
            ')
            ->join(
                'users',
                'users.id_user = templates.uploaded_by',
                'left'
            )
            ->where('templates.status', 'approved')
            ->orderBy('templates.created_at', 'DESC')
            ->findAll();

        return view('templates/index', [
            'title'     => 'Template — COLLABIFY',
            'templates' => $templates,
        ]);
    }

    public function create()
    {
        return view('templates/create', [
            'title' => 'Upload Template — COLLABIFY',
        ]);
    }

    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[200]',

            'kategori' => 'required|max_length[100]',

            'deskripsi' => 'permit_empty|max_length[5000]',

            'file' => [
                'label' => 'File Template',
                'rules' => [
                    'uploaded[file]',
                    'max_size[file,20480]',
                    'ext_in[file,pdf,docx,pptx,xlsx,sav]',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');

        if (! $file || ! $file->isValid()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'File template tidak valid.');
        }

        /*
         * Folder penyimpanan:
         * writable/uploads/templates/
         */
        $uploadPath = WRITEPATH . 'uploads/templates';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        /*
         * Nama file dibuat acak agar tidak bentrok
         * dengan file milik pengguna lain.
         */
        $newName = $file->getRandomName();

        $file->move($uploadPath, $newName);

        $idUser = session()->get('id_user');

        $this->templateModel->insert([
            'judul'           => trim($this->request->getPost('judul')),
            'kategori'        => trim($this->request->getPost('kategori')),
            'deskripsi'       => trim(
                $this->request->getPost('deskripsi') ?? ''
            ),
            'file_path'       => 'uploads/templates/' . $newName,
            'uploaded_by'     => $idUser,
            'status'          => 'approved',
            'downloads_count' => 0,
        ]);

        return redirect()->to('/templates')
            ->with(
                'success',
                'Template berhasil diupload dan langsung tersedia.'
            );
    }

public function show($idTemplate)
{
    $idUser = session()->get('id_user');

    $template = $this->templateModel
        ->select('
            templates.*,
            users.name AS uploader
        ')
        ->join(
            'users',
            'users.id_user = templates.uploaded_by',
            'left'
        )
        ->where('templates.id_template', $idTemplate)
        ->first();

    if (! $template) {
        return redirect()->to('/templates')
            ->with('error', 'Template tidak ditemukan.');
    }


    // =========================
    // BOOKMARK
    // =========================

    $bookmark = $this->bookmarkModel
        ->where('id_user', $idUser)
        ->where('id_template', $idTemplate)
        ->first();

    $isBookmarked = ! empty($bookmark);


    // =========================
    // RATING
    // =========================

    $ratingSummary = $this->ratingModel
        ->select('
            AVG(rating) AS average_rating,
            COUNT(*) AS total_rating
        ')
        ->where('id_template', $idTemplate)
        ->first();


    // Rating milik user yang sedang login
    $myRating = $this->ratingModel
        ->where('id_user', $idUser)
        ->where('id_template', $idTemplate)
        ->first();


    // =========================
    // SEMUA KOMENTAR
    // =========================

    $ratings = $this->ratingModel
        ->select('
            template_ratings.*,
            users.name AS user_name
        ')
        ->join(
            'users',
            'users.id_user = template_ratings.id_user',
            'left'
        )
        ->where(
            'template_ratings.id_template',
            $idTemplate
        )
        ->orderBy(
            'template_ratings.created_at',
            'DESC'
        )
        ->findAll();


    // =========================
    // WORKSPACE KELOMPOK
    // =========================
    //
    // Cek apakah user sudah tergabung
    // dalam kelompok yang mempunyai
    // workspace untuk template ini.
    //

    $groupMemberModel =
        new \App\Models\GroupMemberModel();

    $workspaceModel =
        new \App\Models\WorkspaceModel();


    // Ambil kelompok yang diikuti user
    $userGroups = $groupMemberModel
        ->select('
            group_members.id_group,
            groups.nama_kelompok
        ')
        ->join(
            'groups',
            'groups.id_group = group_members.id_group'
        )
        ->where(
            'group_members.id_user',
            $idUser
        )
        ->findAll();


    $groupWorkspaces = [];


    if (! empty($userGroups)) {

        $groupIds = array_map(
            static function ($group) {
                return (int) $group['id_group'];
            },
            $userGroups
        );


        // Cari workspace template ini
        // pada kelompok yang diikuti user
        $workspaces = $workspaceModel
            ->select('
                template_workspaces.*,
                groups.nama_kelompok
            ')
            ->join(
                'groups',
                'groups.id_group = template_workspaces.id_group',
                'left'
            )
            ->where(
                'template_workspaces.id_template',
                $idTemplate
            )
            ->whereIn(
                'template_workspaces.id_group',
                $groupIds
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


        // Susun berdasarkan id_group
        foreach ($workspaces as $workspace) {

            $groupWorkspaces[
                (int) $workspace['id_group']
            ] = $workspace;
        }
    }


    return view('templates/show', [
        'title' =>
            'Detail Template — COLLABIFY',

        'template' =>
            $template,

        'isBookmarked' =>
            $isBookmarked,

        'ratingSummary' =>
            $ratingSummary,

        'myRating' =>
            $myRating,

        'ratings' =>
            $ratings,

        'userGroups' =>
            $userGroups,

        'groupWorkspaces' =>
            $groupWorkspaces,
    ]);
}

    /**
     * Download file template (hanya template approved).
     * Route: templates/(:num)/download
     */
    public function download($idTemplate)
    {
        $template = $this->templateModel
            ->where('id_template', (int) $idTemplate)
            ->where('status', 'approved')
            ->first();

        if (! $template) {
            return redirect()->to('/templates')
                ->with('error', 'Template tidak ditemukan.');
        }

        // Path dari database tidak dipercaya mentah-mentah: harus berada di writable/uploads.
        $base = realpath(WRITEPATH . 'uploads');
        $path = ! empty($template['file_path']) ? realpath(WRITEPATH . $template['file_path']) : false;

        if ($base === false || $path === false || ! is_file($path)
            || strncmp($path, $base . DIRECTORY_SEPARATOR, strlen($base) + 1) !== 0) {
            return redirect()->back()
                ->with('error', 'File template tidak tersedia di server.');
        }

        $this->templateModel
            ->where('id_template', (int) $idTemplate)
            ->set('downloads_count', 'downloads_count + 1', false)
            ->update();

        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        $name = trim(preg_replace('/[^\w\- ]+/u', '', $template['judul'])) ?: 'template';

        return $this->response->download($path, null)
            ->setFileName($name . ($ext !== '' ? '.' . $ext : ''));
    }

    /**
     * Simpan / hapus bookmark (toggle).
     * Route: templates/(:num)/bookmark
     */
    public function bookmark($idTemplate)
    {
        $idUser = (int) session()->get('id_user');

        $template = $this->templateModel
            ->where('id_template', (int) $idTemplate)
            ->where('status', 'approved')
            ->first();

        if (! $template) {
            return redirect()->to('/templates')
                ->with('error', 'Template tidak ditemukan.');
        }

        $existing = $this->bookmarkModel
            ->where('id_user', $idUser)
            ->where('id_template', (int) $idTemplate)
            ->first();

        if ($existing) {
            $this->bookmarkModel->delete($existing['id_bookmark']);
            $action = 'removed';
        } else {
            $this->bookmarkModel->insert([
                'id_user'     => $idUser,
                'id_template' => (int) $idTemplate,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
            $action = 'saved';
        }

        return redirect()->back()->with('bookmark_action', $action);
    }

    /**
     * Daftar template yang di-bookmark user.
     * Route: templates/bookmarks
     */
    public function bookmarks()
    {
        $templates = $this->templateModel
            ->select('templates.*, users.name AS uploader')
            ->join('template_bookmarks', 'template_bookmarks.id_template = templates.id_template')
            ->join('users', 'users.id_user = templates.uploaded_by', 'left')
            ->where('template_bookmarks.id_user', (int) session()->get('id_user'))
            ->where('templates.status', 'approved')
            ->orderBy('template_bookmarks.created_at', 'DESC')
            ->findAll();

        return view('templates/bookmarks', [
            'title'     => 'Template Tersimpan — COLLABIFY',
            'templates' => $templates,
        ]);
    }

    /**
     * Beri rating + komentar. Satu pengguna satu rating per template:
     * mengirim lagi akan memperbarui rating sebelumnya.
     * Route: templates/(:num)/rating
     */
    public function rating($idTemplate)
    {
        $idUser = (int) session()->get('id_user');

        $rules = [
            'rating'  => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->with('error', 'Pilih rating 1–5 bintang dulu.');
        }

        $template = $this->templateModel
            ->where('id_template', (int) $idTemplate)
            ->where('status', 'approved')
            ->first();

        if (! $template) {
            return redirect()->to('/templates')
                ->with('error', 'Template tidak ditemukan.');
        }

        $data = [
            'rating'  => (int) $this->request->getPost('rating'),
            'comment' => trim((string) $this->request->getPost('comment')),
        ];

        $existing = $this->ratingModel
            ->where('id_user', $idUser)
            ->where('id_template', (int) $idTemplate)
            ->first();

        if ($existing) {
            $this->ratingModel->update($existing['id_rating'], $data);
        } else {
            $this->ratingModel->insert($data + [
                'id_template' => (int) $idTemplate,
                'id_user'     => $idUser,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih, rating kamu tersimpan.');
    }

}

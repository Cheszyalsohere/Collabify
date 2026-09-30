<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Landing page
    public function index()
    {
        return view('landing page/index');
    }

    // Beranda COLLABIFY
    public function beranda()
    {
        $db = \Config\Database::connect();

        // Template terpopuler / terpercaya: gabungan rating, jumlah pemberi rating,
        // pemakaian (salinan ke workspace), dan download.
        $rows = $db->query("
            SELECT
                t.id_template, t.judul, t.kategori, t.deskripsi, t.status,
                t.downloads_count, t.created_at,
                u.name AS uploader,
                COALESCE(r.total_rating, 0)  AS total_rating,
                COALESCE(r.sum_rating, 0)    AS sum_rating,
                COALESCE(w.total_pakai, 0)   AS total_pakai
            FROM templates t
            LEFT JOIN users u ON u.id_user = t.uploaded_by
            LEFT JOIN (
                SELECT id_template, COUNT(*) AS total_rating, SUM(rating) AS sum_rating
                FROM template_ratings GROUP BY id_template
            ) r ON r.id_template = t.id_template
            LEFT JOIN (
                SELECT id_template, COUNT(*) AS total_pakai FROM (
                    SELECT id_template FROM template_workspaces
                    UNION ALL
                    SELECT id_template FROM workspace_history WHERE id_template IS NOT NULL
                ) pakai GROUP BY id_template
            ) w ON w.id_template = t.id_template
            WHERE t.status = 'approved'
        ")->getResultArray();

        // Rata-rata rating dikoreksi (Bayesian): template dengan 1 rating bintang 5
        // tidak otomatis mengalahkan template dengan banyak rating bagus.
        $prior = 3.0;      // rating awal netral
        $bobot = 3;        // setara 3 rating "netral"
        foreach ($rows as &$t) {
            $n   = (int) $t['total_rating'];
            $avg = $n > 0 ? ((float) $t['sum_rating']) / $n : 0.0;

            $t['average_rating'] = round($avg, 1);
            $bayes               = ($bobot * $prior + (float) $t['sum_rating']) / ($bobot + $n);
            $t['popularity']     = $bayes * 10
                                 + $n * 2
                                 + (int) $t['total_pakai'] * 3
                                 + (int) $t['downloads_count'];
            $t['terpercaya']     = $n >= 3 && $avg >= 4.0;
        }
        unset($t);

        usort($rows, static function ($a, $b) {
            return [$b['popularity'], $b['created_at']] <=> [$a['popularity'], $a['created_at']];
        });
        $templates = array_slice($rows, 0, 12);

        // Kelompok terbaru
        $groups = $db->table('groups')
            ->select('
                groups.id_group,
                groups.nama_kelompok,
                groups.kode_invite,
                groups.created_at,
                users.name AS pembuat
            ')
            ->join(
                'users',
                'users.id_user = groups.dibuat_oleh',
                'left'
            )
            ->orderBy('groups.created_at', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        // Task terbaru
        $tasks = $db->table('tasks')
            ->select('
                tasks.id_task,
                tasks.judul,
                tasks.deskripsi,
                tasks.status,
                tasks.deadline,
                tasks.created_at,
                groups.nama_kelompok
            ')
            ->join(
                'groups',
                'groups.id_group = tasks.id_group',
                'left'
            )
            ->orderBy('tasks.created_at', 'DESC')
            ->limit(8)
            ->get()
            ->getResultArray();

        return view('home/index', [
            'title'     => 'Beranda — COLLABIFY',
            'templates' => $templates,
            'groups'    => $groups,
            'tasks'     => $tasks,
        ]);
    }
}
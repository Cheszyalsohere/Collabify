<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Landing page: hanya untuk tamu. Yang sudah login langsung ke beranda (layout sidebar).
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/home');
        }

        return view('landing page/index');
    }

    // Beranda COLLABIFY: semua data dibatasi ke kelompok milik pengguna yang login.
    public function beranda()
    {
        $db     = \Config\Database::connect();
        $idUser = (int) session()->get('id_user');

        // ── Kelompok milik pengguna ───────────────────────────────
        $groupIds = array_map(
            static fn ($r) => (int) $r['id_group'],
            $db->table('group_members')->select('id_group')->where('id_user', $idUser)->get()->getResultArray()
        );

        // ── Template terpopuler / terpercaya ──────────────────────
        // Gabungan rating (dikoreksi Bayesian), jumlah pemberi rating, pemakaian, dan download.
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

        $groups = $tasks = $upcoming = $activity = [];
        $deadlineDays = [];
        $overdue = 0;

        if ($groupIds !== []) {
            // ── Kelompok terbaru ──────────────────────────────────
            $groups = $db->table('groups')
                ->select('groups.id_group, groups.nama_kelompok, groups.kode_invite, groups.created_at, users.name AS pembuat')
                ->join('users', 'users.id_user = groups.dibuat_oleh', 'left')
                ->whereIn('groups.id_group', $groupIds)
                ->orderBy('groups.created_at', 'DESC')
                ->limit(6)
                ->get()->getResultArray();

            // ── Tugas terbaru ─────────────────────────────────────
            $tasks = $db->table('tasks')
                ->select('tasks.id_task, tasks.judul, tasks.deskripsi, tasks.status, tasks.deadline, tasks.created_at, groups.nama_kelompok')
                ->join('groups', 'groups.id_group = tasks.id_group', 'left')
                ->whereIn('tasks.id_group', $groupIds)
                ->orderBy('tasks.created_at', 'DESC')
                ->limit(8)
                ->get()->getResultArray();

            // ── Deadline mendatang (belum selesai) ────────────────
            $today = date('Y-m-d');

            $upcoming = $db->table('tasks')
                ->select('tasks.id_task, tasks.judul, tasks.status, tasks.deadline, groups.nama_kelompok')
                ->join('groups', 'groups.id_group = tasks.id_group', 'left')
                ->whereIn('tasks.id_group', $groupIds)
                ->where('tasks.status !=', 'done')
                ->where('tasks.deadline >=', $today)
                ->orderBy('tasks.deadline', 'ASC')
                ->limit(6)
                ->get()->getResultArray();

            $overdue = $db->table('tasks')
                ->whereIn('id_group', $groupIds)
                ->where('status !=', 'done')
                ->where('deadline <', $today)
                ->countAllResults();

            // ── Hari bertanda di kalender (bulan berjalan) ────────
            $first = date('Y-m-01');
            $last  = date('Y-m-t');
            $month = $db->table('tasks')
                ->select('deadline, COUNT(*) AS n')
                ->whereIn('id_group', $groupIds)
                ->where('status !=', 'done')
                ->where('deadline >=', $first)
                ->where('deadline <=', $last)
                ->groupBy('deadline')
                ->get()->getResultArray();

            foreach ($month as $m) {
                $deadlineDays[(int) date('j', strtotime($m['deadline']))] = (int) $m['n'];
            }
        }

        // ── Aktivitas forum terbaru: channel komunitas + channel kelompokku ──
        $builder = $db->table('forum_messages fm')
            ->select('fm.message, fm.created_at, fc.id_channel, fc.nama_channel, fc.id_group, u.name AS pengirim')
            ->join('forum_channels fc', 'fc.id_channel = fm.id_channel')
            ->join('users u', 'u.id_user = fm.id_user', 'left')
            ->groupStart()
                ->where('fc.id_group', null);

        if ($groupIds !== []) {
            $builder->orWhereIn('fc.id_group', $groupIds);
        }

        $activity = $builder->groupEnd()
            ->orderBy('fm.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('home/index', [
            'title'        => 'Beranda — COLLABIFY',
            'templates'    => $templates,
            'groups'       => $groups,
            'tasks'        => $tasks,
            'upcoming'     => $upcoming,
            'overdue'      => $overdue,
            'deadlineDays' => $deadlineDays,
            'activity'     => $activity,
        ]);
    }
}

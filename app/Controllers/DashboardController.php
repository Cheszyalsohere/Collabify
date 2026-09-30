<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();

        // ─────────────────────────────────────────────
        // KPI COLLABIFY
        // ─────────────────────────────────────────────

        $totalUser = $db->table('users')
            ->countAllResults();

        $totalGroup = $db->table('groups')
            ->countAllResults();

        $totalTemplate = $db->table('templates')
            ->countAllResults();

        $totalTask = $db->table('tasks')
            ->countAllResults();

        // Template yang masih menunggu persetujuan
        $templatePending = $db->table('templates')
            ->where('status', 'pending')
            ->countAllResults();

        // Task berdasarkan status
        $taskSelesai = $db->table('tasks')
            ->whereIn('status', ['done', 'selesai', 'completed'])
            ->countAllResults();

        $taskBerjalan = $db->table('tasks')
            ->whereIn('status', ['todo', 'in_progress', 'proses'])
            ->countAllResults();

        // ─────────────────────────────────────────────
        // GRAFIK 7 HARI — TASK BARU
        // ─────────────────────────────────────────────

        $grafikLabels = [];
        $grafikData   = [];

        $namaHari = [
            'Min',
            'Sen',
            'Sel',
            'Rab',
            'Kam',
            'Jum',
            'Sab'
        ];

        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-{$i} days"));

            $dayLbl = $namaHari[
                (int) date('w', strtotime($tgl))
            ];

            $count = $db->table('tasks')
                ->where('DATE(created_at)', $tgl)
                ->countAllResults();

            $grafikLabels[] = $dayLbl;
            $grafikData[]   = (int) $count;
        }

        // ─────────────────────────────────────────────
        // DEADLINE TERDEKAT
        // ─────────────────────────────────────────────

        $deadline = $db->table('tasks t')
            ->select('
                t.id_task,
                t.judul,
                t.status,
                t.deadline,
                g.nama_kelompok
            ')
            ->join(
                'groups g',
                'g.id_group = t.id_group',
                'left'
            )
            ->where('t.deadline IS NOT NULL')
            ->orderBy('t.deadline', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // ─────────────────────────────────────────────
        // AKTIVITAS TERBARU
        // ─────────────────────────────────────────────

        $aktivitas = $db->query("
            SELECT
                'user' AS tipe,
                name AS judul,
                email AS detail,
                created_at AS waktu
            FROM users

            UNION ALL

            SELECT
                'group' AS tipe,
                nama_kelompok AS judul,
                'Grup baru dibuat' AS detail,
                created_at AS waktu
            FROM groups

            UNION ALL

            SELECT
                'template' AS tipe,
                judul AS judul,
                kategori AS detail,
                created_at AS waktu
            FROM templates

            UNION ALL

            SELECT
                'task' AS tipe,
                judul AS judul,
                status AS detail,
                created_at AS waktu
            FROM tasks

            ORDER BY waktu DESC
            LIMIT 8
        ")
        ->getResultArray();

        return view('dashboard', [
            'title'          => 'Dashboard',

            'totalUser'      => $totalUser,
            'totalGroup'     => $totalGroup,
            'totalTemplate'  => $totalTemplate,
            'totalTask'      => $totalTask,

            'templatePending'=> $templatePending,
            'taskSelesai'    => $taskSelesai,
            'taskBerjalan'   => $taskBerjalan,

            'grafikLabels'   => json_encode($grafikLabels),
            'grafikData'     => json_encode($grafikData),

            'deadline'       => $deadline,
            'aktivitas'      => $aktivitas,
        ]);
    }
}
<?php

namespace App\Controllers;

use App\Models\GroupMemberModel;
use App\Models\GroupModel;
use App\Models\NoteModel;
use App\Models\SpinHistoryModel;
use App\Models\TaskModel;

/**
 * Spin — pembagian bagian tugas yang adil & transparan.
 *
 * Tampilan roda dari tim UI, tetapi hasil TIDAK ditentukan di browser:
 * setiap putaran diminta ke server (random_int), langsung tersimpan sebagai
 * riwayat, dan roda hanya menganimasikan hasil itu. Saat semua anggota sudah
 * kebagian, server menutup sesi: kode verifikasi dibuat, penanda "spin ulang"
 * diberikan bila tugas yang sama pernah di-spin, dan bagian tiap anggota
 * otomatis masuk ke Catatan pribadi masing-masing.
 */
class SpinController extends BaseController
{
    private const MAX_OPTIONS = 50;

    protected SpinHistoryModel $spinModel;
    protected GroupModel $groupModel;
    protected GroupMemberModel $memberModel;
    protected TaskModel $taskModel;
    protected NoteModel $noteModel;

    public function __construct()
    {
        $this->spinModel   = new SpinHistoryModel();
        $this->groupModel  = new GroupModel();
        $this->memberModel = new GroupMemberModel();
        $this->taskModel   = new TaskModel();
        $this->noteModel   = new NoteModel();
    }

    /**
     * Halaman Spin: data kelompok, tugas, dan anggota dikirim ke view
     * (JavaScript memfilter berdasarkan kelompok yang dipilih).
     */
    public function index()
    {
        $idUser = (int) session()->get('id_user');
        $groups = $this->groupModel->getGroupsForUser($idUser);

        $tasks   = [];
        $members = [];

        foreach ($groups as $group) {
            $idGroup = (int) $group['id_group'];

            $tasks[$idGroup] = $this->taskModel
                ->where('id_group', $idGroup)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            $members[$idGroup] = $this->memberModel->getMembersWithUser($idGroup);
        }

        return view('spin/index', [
            'title'   => 'Spin — COLLABIFY',
            'groups'  => $groups,
            'tasks'   => $tasks,
            'members' => $members,
        ]);
    }

    /**
     * Satu putaran: server memilih anggota + bagian secara acak, menyimpannya,
     * dan mengembalikannya ke roda. Putaran terakhir menutup sesi.
     *
     * POST spin/step  (id_group, id_task, session_id, options = JSON array sisa bagian)
     */
    public function step()
    {
        $idUser    = (int) session()->get('id_user');
        $idGroup   = (int) $this->request->getPost('id_group');
        $idTask    = (int) $this->request->getPost('id_task');
        $sessionId = trim((string) $this->request->getPost('session_id'));
        $options   = json_decode((string) $this->request->getPost('options'), true);

        if (! $idGroup || ! $idTask || ! preg_match('/^[A-Za-z0-9_-]{8,64}$/', $sessionId)) {
            return $this->fail(400, 'Data spin belum lengkap.');
        }

        if (! is_array($options)) {
            return $this->fail(400, 'Daftar bagian tugas tidak valid.');
        }

        $options = array_values(array_filter(
            array_map(static fn ($o) => is_string($o) ? trim($o) : '', $options),
            static fn ($o) => $o !== '' && mb_strlen($o) <= 255
        ));

        if ($options === [] || count($options) > self::MAX_OPTIONS) {
            return $this->fail(400, 'Isi bagian tugas dulu (maksimal ' . self::MAX_OPTIONS . ').');
        }

        if (! $this->memberModel->isMember($idGroup, $idUser)) {
            return $this->fail(403, 'Kamu bukan anggota kelompok tersebut.');
        }

        $task = $this->taskModel->where('id_task', $idTask)->where('id_group', $idGroup)->first();
        if (! $task) {
            return $this->fail(404, 'Tugas tidak ditemukan pada kelompok tersebut.');
        }

        $members = $this->memberModel->getMembersWithUser($idGroup);
        if (count($members) < 2) {
            return $this->fail(422, 'Spin butuh minimal 2 anggota di kelompok.');
        }

        // Baris sesi yang sudah ada — harus milik sesi yang sama (kelompok, tugas, pemutar).
        $rows = $this->spinModel->where('session_id', $sessionId)->orderBy('id_spin', 'ASC')->findAll();
        foreach ($rows as $r) {
            if ((int) $r['id_group'] !== $idGroup || (int) $r['id_task'] !== $idTask || (int) $r['created_by'] !== $idUser) {
                return $this->fail(403, 'Sesi spin tidak valid.');
            }
        }

        $assignedIds = array_map(static fn ($r) => (int) $r['id_anggota'], $rows);
        $remaining   = array_values(array_filter(
            $members,
            static fn ($m) => ! in_array((int) $m['id_user'], $assignedIds, true)
        ));

        if ($remaining === []) {
            return $this->fail(409, 'Semua anggota sudah kebagian pada sesi ini.');
        }

        if (count($options) !== count($remaining)) {
            return $this->fail(422, 'Jumlah bagian harus sama dengan jumlah anggota yang belum kebagian (' . count($remaining) . ').');
        }

        // Pemilihan acak oleh server.
        $member = $remaining[random_int(0, count($remaining) - 1)];
        $option = $options[random_int(0, count($options) - 1)];
        $now    = date('Y-m-d H:i:s');

        // Nomor spin & penanda spin ulang ditentukan sekali, di putaran pertama sesi.
        if ($rows === []) {
            $nomor = $this->countSessions($idGroup) + 1;
            $ulang = $this->spinModel
                ->where('id_group', $idGroup)
                ->where('id_task', $idTask)
                ->countAllResults() > 0 ? 1 : 0;
        } else {
            $nomor = (int) $rows[0]['nomor_spin'];
            $ulang = (int) $rows[0]['is_ulang'];
        }

        $finished = count($remaining) === 1;
        $kode     = null;

        $db = \Config\Database::connect();
        $db->transStart();

        $idSpin = $this->spinModel->insert([
            'id_group'   => $idGroup,
            'id_task'    => $idTask,
            'session_id' => $sessionId,
            'anggota'    => $member['name'],
            'id_anggota' => (int) $member['id_user'],
            'hasil'      => $option,
            'created_by' => $idUser,
            'nomor_spin' => $nomor,
            'is_ulang'   => $ulang,
            'created_at' => $now,
        ], true);

        if ($finished) {
            $all  = $this->spinModel->where('session_id', $sessionId)->orderBy('id_spin', 'ASC')->findAll();
            $kode = self::kode($sessionId, $idGroup, $idTask, $nomor, $all);

            $this->spinModel->where('session_id', $sessionId)->set('kode', $kode)->update();

            $group = $this->groupModel->find($idGroup);
            foreach ($all as $r) {
                $this->noteModel->insert([
                    'id_group'   => $idGroup,
                    'content'    => "Hasil Spin #{$nomor} — {$group['nama_kelompok']}\n"
                                  . "Tugas: {$task['judul']}\n"
                                  . "Bagianmu: {$r['hasil']}\n"
                                  . "(Kode verifikasi: {$kode}" . ($ulang ? ', spin ulang' : '') . ')',
                    'warna'      => 'biru',
                    'created_by' => (int) $r['id_anggota'],
                    'created_at' => $now,
                ]);
            }
        }

        $db->transComplete();

        if (! $db->transStatus() || ! $idSpin) {
            return $this->fail(500, 'Gagal menyimpan hasil spin.');
        }

        return $this->response->setJSON([
            'success'     => true,
            'id_spin'     => (int) $idSpin,
            'session_id'  => $sessionId,
            'member_id'   => (int) $member['id_user'],
            'member_name' => $member['name'],
            'option'      => $option,
            'finished'    => $finished,
            'nomor_spin'  => $nomor,
            'is_ulang'    => (bool) $ulang,
            'kode'        => $kode,
        ]);
    }

    /**
     * Riwayat spin satu kelompok (JSON).
     */
    public function history($idGroup)
    {
        $idGroup = (int) $idGroup;

        if (! $this->memberModel->isMember($idGroup, (int) session()->get('id_user'))) {
            return $this->fail(403, 'Kamu bukan anggota kelompok tersebut.');
        }

        $history = $this->spinModel
            ->select('spin_history.*, tasks.judul AS task_judul')
            ->join('tasks', 'tasks.id_task = spin_history.id_task', 'left')
            ->where('spin_history.id_group', $idGroup)
            ->orderBy('spin_history.created_at', 'DESC')
            ->orderBy('spin_history.id_spin', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'history' => $history,
        ]);
    }

    /**
     * Simpan ringkasan hasil ke Catatan pribadi pemanggil.
     * (Bagian tiap anggota sudah otomatis masuk saat sesi selesai.)
     */
    public function saveNote()
    {
        $idUser  = (int) session()->get('id_user');
        $idGroup = (int) $this->request->getPost('id_group');
        $content = trim((string) $this->request->getPost('content'));

        if (! $idGroup || $content === '' || mb_strlen($content) > 5000) {
            return $this->fail(400, 'Data catatan tidak lengkap.');
        }

        if (! $this->memberModel->isMember($idGroup, $idUser)) {
            return $this->fail(403, 'Kamu bukan anggota kelompok ini.');
        }

        $id = $this->noteModel->insert([
            'id_group'   => $idGroup,
            'content'    => $content,
            'warna'      => 'biru',
            'created_by' => $idUser,
            'created_at' => date('Y-m-d H:i:s'),
        ], true);

        if (! $id) {
            return $this->fail(500, 'Gagal menyimpan hasil ke Catatan.');
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Hasil pembagian berhasil disimpan ke Catatan.',
            'id_note' => (int) $id,
        ]);
    }

    private function fail(int $status, string $message)
    {
        return $this->response->setStatusCode($status)->setJSON([
            'success' => false,
            'message' => $message,
        ]);
    }

    private function countSessions(int $idGroup): int
    {
        $row = \Config\Database::connect()
            ->table('spin_history')
            ->select('COUNT(DISTINCT session_id) AS n')
            ->where('id_group', $idGroup)
            ->get()
            ->getRowArray();

        return (int) ($row['n'] ?? 0);
    }

    /**
     * Kode verifikasi 10 karakter dari seluruh isi sesi.
     * Butuh encryption.key di .env agar tidak bisa dipalsukan dari source code.
     */
    private static function kode(string $sessionId, int $idGroup, int $idTask, int $nomor, array $rows): string
    {
        $payload = implode('|', [$sessionId, $idGroup, $idTask, $nomor]);
        foreach ($rows as $r) {
            $payload .= '|' . $r['id_anggota'] . ':' . $r['hasil'];
        }

        $secret = (string) config('Encryption')->key;

        return strtoupper(substr(
            hash_hmac('sha256', $payload, $secret !== '' ? $secret : 'collabify'),
            0,
            10
        ));
    }
}

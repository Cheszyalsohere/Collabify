<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\GroupMemberModel;
use App\Models\WorkspaceModel;
use App\Models\ForumChannelModel;
use App\Models\ForumMessageModel;
use App\Models\VoiceParticipantModel;
use App\Models\VoiceSignalModel;

class ForumController extends BaseController
{
    protected GroupModel $groupModel;
    protected GroupMemberModel $memberModel;
    protected WorkspaceModel $workspaceModel;
    protected ForumChannelModel $channelModel;
    protected ForumMessageModel $messageModel;
    protected VoiceParticipantModel $voiceParticipantModel;
    protected VoiceSignalModel $voiceSignalModel;

    public function __construct()
    {
        $this->groupModel = new GroupModel();
        $this->memberModel = new GroupMemberModel();
        $this->workspaceModel = new WorkspaceModel();
        $this->channelModel = new ForumChannelModel();
        $this->messageModel = new ForumMessageModel();
        $this->voiceParticipantModel = new VoiceParticipantModel();
        $this->voiceSignalModel = new VoiceSignalModel();
    }

    public function index()
    {
        $idUser = session()->get('id_user');

        $userGroups = $this->memberModel
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

        $groupIds = array_map(
            static function ($group) {
                return (int) $group['id_group'];
            },
            $userGroups
        );

        $builder = $this->channelModel
            ->orderBy('tipe', 'ASC')
            ->orderBy('nama_channel', 'ASC');

        if (! empty($groupIds)) {
            $builder->groupStart()
                ->where('id_group', null)
                ->orWhereIn('id_group', $groupIds)
                ->groupEnd();
        } else {
            $builder->where('id_group', null);
        }

        $channels = $builder->findAll();

        $communityChannels = [];
        $groupChannels = [];

        foreach ($channels as $channel) {
            if (empty($channel['id_group'])) {
                $communityChannels[] = $channel;
                continue;
            }

            $groupChannels[(int) $channel['id_group']][] = $channel;
        }

        return view('forum/index', [
            'title' => 'Forum — COLLABIFY',
            'userGroups' => $userGroups,
            'communityChannels' => $communityChannels,
            'groupChannels' => $groupChannels,
        ]);
    }

    public function group($idGroup)
    {
        $idUser = session()->get('id_user');
        $role = session()->get('role');

        $group = $this->groupModel->find($idGroup);

        if (!$group) {
            return redirect()->to('/forum');
        }

        if (
            !in_array($role, ['admin', 'dosen'], true)
            && !$this->memberModel->isMember($idGroup, $idUser)
        ) {
            return redirect()->to('/forum');
        }

        $channels = $this->channelModel
            ->where('id_group', $idGroup)
            ->orderBy('tipe', 'ASC')
            ->orderBy('nama_channel', 'ASC')
            ->findAll();

        $userGroups = $this->memberModel
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

        $communityChannels = $this->channelModel
            ->where('id_group', null)
            ->orderBy('tipe', 'ASC')
            ->orderBy('nama_channel', 'ASC')
            ->findAll();

        // View mengharapkan channel dikelompokkan per id_group (sama seperti index()).
        $groupChannels = [(int) $idGroup => $channels];

        $otherIds = array_diff(
            array_map(static fn ($g) => (int) $g['id_group'], $userGroups),
            [(int) $idGroup]
        );

        if ($otherIds !== []) {
            $others = $this->channelModel
                ->whereIn('id_group', $otherIds)
                ->orderBy('tipe', 'ASC')
                ->orderBy('nama_channel', 'ASC')
                ->findAll();

            foreach ($others as $channel) {
                $groupChannels[(int) $channel['id_group']][] = $channel;
            }
        }

        return view('forum/index', [
            'title' => $group['nama_kelompok'] . ' — Forum',
            'userGroups' => $userGroups,
            'communityChannels' => $communityChannels,
            'groupChannels' => $groupChannels,
            'selectedGroup' => $group,
            'selectedChannel' => null,
        ]);
    }

    public function channel($idChannel)
    {
        $idUser = session()->get('id_user');
        $role = session()->get('role');

        $channel = $this->channelModel->find($idChannel);

        if (!$channel) {
            return redirect()->to('/forum');
        }

        // Kalau channel milik group, cek apakah user punya akses
        if (!empty($channel['id_group'])) {
            if (
                !in_array($role, ['admin', 'dosen'], true)
                && !$this->memberModel->isMember(
                    $channel['id_group'],
                    $idUser
                )
            ) {
                return redirect()->to('/forum');
            }
        }

        $messages = $this->messageModel
            ->select('
                forum_messages.*,
                users.name AS user_name
            ')
            ->join(
                'users',
                'users.id_user = forum_messages.id_user',
                'left'
            )
            ->where(
                'forum_messages.id_channel',
                $idChannel
            )
            ->orderBy(
                'forum_messages.created_at',
                'ASC'
            )
            ->findAll();

        $userGroups = $this->memberModel
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

        $groupIds = array_map(
            static function ($group) {
                return (int) $group['id_group'];
            },
            $userGroups
        );

        $builder = $this->channelModel
            ->orderBy('tipe', 'ASC')
            ->orderBy('nama_channel', 'ASC');

        if (!empty($groupIds)) {
            $builder->groupStart()
                ->where('id_group', null)
                ->orWhereIn('id_group', $groupIds)
                ->groupEnd();
        } else {
            $builder->where('id_group', null);
        }

        $channels = $builder->findAll();

        $communityChannels = [];
        $groupChannels = [];

        foreach ($channels as $item) {
            if (empty($item['id_group'])) {
                $communityChannels[] = $item;
                continue;
            }

            $groupChannels[(int) $item['id_group']][] = $item;
        }

        return view('forum/channel', [
            'title' => '#' . $channel['nama_channel'] . ' — Forum COLLABIFY',
            'channel' => $channel,
            'messages' => $messages,
            'userGroups' => $userGroups,
            'communityChannels' => $communityChannels,
            'groupChannels' => $groupChannels,
        ]);
    }

/**
 * Mengambil pesan terbaru untuk auto-refresh chat
 */

    public function sendMessage()
    {
        $idUser = session()->get('id_user');

        if (!$idUser) {
            return redirect()->to('/login');
        }

        $idChannel = $this->request->getPost('id_channel');
        $message = trim(
            (string) $this->request->getPost('message')
        );

        if (!$idChannel || $message === '') {
            return redirect()->back();
        }

        $channel = $this->channelModel->find($idChannel);

        if (!$channel) {
            return redirect()->to('/forum');
        }

        // Cek akses kalau channel milik group
        if (!empty($channel['id_group'])) {
            $role = session()->get('role');

            if (
                !in_array($role, ['admin', 'dosen'], true)
                && !$this->memberModel->isMember(
                    $channel['id_group'],
                    $idUser
                )
            ) {
                return redirect()->to('/forum');
            }
        }

        $this->messageModel->insert([
            'id_channel' => $idChannel,
            'id_user'    => $idUser,
            'message'    => $message,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(
            '/forum/channel/' . $idChannel
        );
    }
    /**
     * Guard untuk endpoint JSON channel (pesan & voice).
     * Channel komunitas terbuka untuk semua user login; channel kelompok hanya
     * untuk anggota kelompok (admin/dosen ikut boleh, sama seperti halaman channel).
     * Mengembalikan response error, atau null kalau boleh lanjut.
     */
    private function denyChannelAccess($idChannel)
    {
        $idUser = (int) session()->get('id_user');
        $role   = session()->get('role');

        $channel = $this->channelModel->find($idChannel);

        if (! $channel) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Channel tidak ditemukan.',
            ]);
        }

        if (
            ! empty($channel['id_group'])
            && ! in_array($role, ['admin', 'dosen'], true)
            && ! $this->memberModel->isMember((int) $channel['id_group'], $idUser)
        ) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Kamu bukan anggota kelompok pemilik channel ini.',
            ]);
        }

        return null;
    }

    public function getMessages($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $channel = $this->channelModel->find($idChannel);

    if (!$channel) {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'Channel tidak ditemukan.'
        ]);
    }

    $messages = $this->messageModel
        ->select('
            forum_messages.id_message,
            forum_messages.id_channel,
            forum_messages.id_user,
            forum_messages.message,
            forum_messages.created_at,
            users.name AS user_name
        ')
        ->join(
            'users',
            'users.id_user = forum_messages.id_user',
            'left'
        )
        ->where(
            'forum_messages.id_channel',
            $idChannel
        )
        ->orderBy(
            'forum_messages.created_at',
            'ASC'
        )
        ->findAll();

    return $this->response->setJSON([
        'success' => true,
        'messages' => $messages
    ]);
}
public function joinVoice($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $idUser = session()->get('id_user');

    if (!$idUser) {
        return $this->response->setStatusCode(401)->setJSON([
            'success' => false,
            'message' => 'User belum login.'
        ]);
    }

    $channel = $this->channelModel->find($idChannel);

    if (!$channel || $channel['tipe'] !== 'voice') {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'Voice channel tidak ditemukan.'
        ]);
    }

    // Jangan membuat peserta yang sama dua kali
$existing = $this->voiceParticipantModel
    ->where('id_channel', $idChannel)
    ->where('id_user', $idUser)
    ->where('left_at', null)
    ->first();

    if (!$existing) {

        $this->voiceParticipantModel->insert([
            'id_channel' => $idChannel,
            'id_user' => $idUser,
            'joined_at' => date('Y-m-d H:i:s'),
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Berhasil bergabung ke voice channel.'
    ]);
}
public function voiceParticipants($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $participants = $this->voiceParticipantModel
        ->select('
            voice_participants.id_participant,
            voice_participants.id_user,
            voice_participants.joined_at,
            voice_participants.is_muted,
            users.name AS user_name
        ')
        ->join(
            'users',
            'users.id_user = voice_participants.id_user',
            'left'
        )
        ->where(
            'voice_participants.id_channel',
            $idChannel
        )
        ->where(
            'voice_participants.left_at IS NULL',
            null,
            false
        )
        ->orderBy(
            'voice_participants.joined_at',
            'ASC'
        )
        ->findAll();

    return $this->response->setJSON([
        'success' => true,
        'participants' => $participants
    ]);
}
public function leaveVoice($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $idUser = session()->get('id_user');

    if (!$idUser) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'User belum login.'
            ]);
    }

    $participant = $this->voiceParticipantModel
        ->where('id_channel', $idChannel)
        ->where('id_user', $idUser)
        ->where('left_at', null)
        ->first();

    if (!$participant) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Kamu tidak sedang berada di voice channel.'
        ]);
    }

    $updated = $this->voiceParticipantModel->update(
        $participant['id_participant'],
        [
            'left_at' => date('Y-m-d H:i:s')
        ]
    );

    if (!$updated) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal memperbarui status voice.'
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Berhasil keluar dari voice channel.'
    ]);
}
public function toggleMute($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $idUser = session()->get('id_user');

    if (!$idUser) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'User belum login.'
            ]);
    }

$participant = $this->voiceParticipantModel
    ->where('id_channel', $idChannel)
    ->where('id_user', $idUser)
    ->where('left_at', null)
    ->first();

    if (!$participant) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Kamu belum bergabung ke voice channel.'
        ]);
    }

    $newMuteStatus =
        ((int) $participant['is_muted'] === 1)
            ? 0
            : 1;

    $this->voiceParticipantModel
        ->update(
            $participant['id_participant'],
            [
                'is_muted' => $newMuteStatus
            ]
        );

    return $this->response->setJSON([
        'success' => true,
        'is_muted' => $newMuteStatus
    ]);
}
public function sendVoiceSignal($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $idUser = session()->get('id_user');

    if (!$idUser) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'User belum login.'
            ]);
    }

    $receiverId = $this->request->getPost('receiver_id');
    $signalType = $this->request->getPost('signal_type');
    $signalData = $this->request->getPost('signal_data');

    if (
        !$receiverId ||
        !$signalType ||
        !$signalData
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'success' => false,
                'message' => 'Data signaling tidak lengkap.'
            ]);
    }

    $channel = $this->channelModel->find($idChannel);

    if (!$channel || $channel['tipe'] !== 'voice') {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Voice channel tidak ditemukan.'
            ]);
    }

    $this->voiceSignalModel->insert([
        'id_channel' => $idChannel,
        'sender_id' => $idUser,
        'receiver_id' => $receiverId,
        'signal_type' => $signalType,
        'signal_data' => $signalData,
        'created_at' => date('Y-m-d H:i:s'),
    ]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Voice signal berhasil dikirim.'
    ]);
}

public function getVoiceSignals($idChannel)
{
        if ($deny = $this->denyChannelAccess($idChannel)) {
            return $deny;
        }

    $idUser = session()->get('id_user');

    if (!$idUser) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'User belum login.'
            ]);
    }

    $signals = $this->voiceSignalModel
        ->where('id_channel', $idChannel)
        ->where('receiver_id', $idUser)
        ->orderBy('id_signal', 'ASC')
        ->findAll();

    if (!empty($signals)) {
        $signalIds = array_column($signals, 'id_signal');

        $this->voiceSignalModel
            ->whereIn('id_signal', $signalIds)
            ->delete();
    }

    return $this->response->setJSON([
        'success' => true,
        'signals' => $signals
    ]);
}

}
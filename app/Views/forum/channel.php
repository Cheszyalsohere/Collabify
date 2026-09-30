<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="d-flex justify-content-between align-items-center">

    <div>
        <h1 class="page-title mb-1">
            <span class="text-muted">#</span>
            <?= esc($channel['nama_channel']) ?>
        </h1>

        <p class="page-sub mb-0">
            <?= $channel['tipe'] === 'voice'
                ? 'Voice channel'
                : 'Ruang diskusi' ?>
        </p>
    </div>

    <a
        href="<?= base_url('forum') ?>"
        class="btn btn-light"
    >
        <i class="ti ti-arrow-left mr-1"></i>
        Forum
    </a>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="forum-chat-card">

    <!-- =========================
         HEADER CHANNEL
    ========================== -->

    <div class="forum-chat-header">

        <div class="channel-title">

            <div class="channel-title-icon">
                <?php if ($channel['tipe'] === 'voice'): ?>
                    <i class="ti ti-volume"></i>
                <?php else: ?>
                    #
                <?php endif; ?>
            </div>

            <div>
                <strong>
                    <?= esc($channel['nama_channel']) ?>
                </strong>

                <span>
                    <?= $channel['tipe'] === 'voice'
                        ? 'Voice Channel'
                        : 'Text Channel' ?>
                </span>
            </div>

        </div>

    </div>


    <!-- =========================
         PESAN
    ========================== -->

    <div
        class="forum-messages"
        id="forumMessages"
    >

        <?php if (empty($messages)): ?>

            <div class="chat-empty">

                <div class="chat-empty-icon">
                    <?php if ($channel['tipe'] === 'voice'): ?>
                        <i class="ti ti-volume"></i>
                    <?php else: ?>
                        <i class="ti ti-message-circle"></i>
                    <?php endif; ?>
                </div>

                <h3>
                    <?= $channel['tipe'] === 'voice'
                        ? 'Voice Channel'
                        : 'Selamat datang di #' . esc($channel['nama_channel']) ?>
                </h3>

                <p>
                    <?php if ($channel['tipe'] === 'voice'): ?>

                        Masuk ke voice channel untuk
                        berkomunikasi dengan anggota lainnya.

                    <?php else: ?>

                        Belum ada pesan di channel ini.
                        Jadilah yang pertama memulai percakapan!

                    <?php endif; ?>
                </p>

            </div>

        <?php else: ?>

            <?php foreach ($messages as $message): ?>

                <div class="message-item">

                    <div class="message-avatar">
                        <?= strtoupper(
                            substr(
                                $message['user_name'] ?? 'U',
                                0,
                                1
                            )
                        ) ?>
                    </div>

                    <div class="message-content">

                        <div class="message-meta">

                            <strong>
                                <?= esc(
                                    $message['user_name']
                                    ?? 'Pengguna'
                                ) ?>
                            </strong>

                            <span>
                                <?= !empty($message['created_at'])
                                    ? date(
                                        'd M Y, H:i',
                                        strtotime(
                                            $message['created_at']
                                        )
                                    )
                                    : '' ?>
                            </span>

                        </div>

                        <div class="message-text">
                            <?= nl2br(
                                esc(
                                    $message['message']
                                )
                            ) ?>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>


    <!-- =========================
         INPUT / VOICE
    ========================== -->

    <?php if ($channel['tipe'] === 'text'): ?>

        <div class="forum-input-area">

            <form
                action="<?= base_url('forum/send-message') ?>"
                method="post"
                class="forum-message-form"
            >
                <?= csrf_field() ?>

                <input
                    type="hidden"
                    name="id_channel"
                    value="<?= esc($channel['id_channel']) ?>"
                >

                <input
                    type="text"
                    name="message"
                    class="forum-message-input"
                    placeholder="Tulis pesan di #<?= esc($channel['nama_channel']) ?>"
                    autocomplete="off"
                    required
                >

                <button
                    type="submit"
                    class="forum-send-button"
                    title="Kirim pesan"
                >
                    <i class="ti ti-send"></i>
                </button>

            </form>

        </div>

    <?php else: ?>

        <!-- =========================
             VOICE CHANNEL
        ========================== -->

        <div class="voice-placeholder" id="voiceArea">

            <div class="voice-placeholder-icon">
                <i class="ti ti-volume"></i>
            </div>

            <div class="voice-info">
                <strong>Voice Channel</strong>
                <p id="voiceStatus">
                    Bergabung untuk mulai menggunakan microphone.
                </p>
            </div>

            <div class="voice-controls">

                <button
                    type="button"
                    class="btn btn-success"
                    id="joinVoiceButton"
                >
                    <i class="ti ti-phone mr-1"></i>
                    Bergabung
                </button>

                <button
                    type="button"
                    class="btn btn-secondary"
                    id="muteVoiceButton"
                    style="display: none;"
                >
                    <i class="ti ti-microphone"></i>
                    Mute
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="leaveVoiceButton"
                    style="display: none;"
                >
                    <i class="ti ti-phone-off"></i>
                    Keluar
                </button>

            </div>

        </div>

        <div class="voice-participants-box">

            <div class="voice-participants-header">
                <span>
                    <i class="ti ti-users"></i>
                    Orang di voice
                </span>

                <span
                    id="voiceParticipantCount"
                    class="voice-participant-count"
                >
                    0
                </span>
            </div>

            <div
                id="voiceParticipants"
                class="voice-participants-list"
            >
                <div class="voice-empty">
                    Belum ada yang bergabung.
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>


<style>

/* ========================================
   FORUM CHANNEL — COLLABIFY UI
======================================== */

.forum-chat-card {
    --chat-bg: #FFFFFF;
    --chat-surface: #FFFFFF;
    --chat-surface-soft: #FAFAFA;
    --chat-text: #30323A;
    --chat-muted: #77777D;
    --chat-faint: #A2A3A8;
    --chat-border: #F0DFE1;
    --chat-border-strong: #E7D9DB;

    --chat-blue: #79A9D8;
    --chat-blue-dark: #5E91C4;
    --chat-blue-soft: #EAF3FA;

    --chat-pink: #FF677D;
    --chat-pink-soft: #FFF0F1;

    background: var(--chat-bg);
    border: 1px solid var(--chat-border);
    border-radius: 14px;

    height: calc(100vh - 175px);
    min-height: 520px;

    display: flex;
    flex-direction: column;

    overflow: hidden;

    color: var(--chat-text);

    box-shadow:
        0 8px 24px rgba(48, 50, 58, 0.05);
}


/* ========================================
   DARK MODE
======================================== */

body.collabify-dark .forum-chat-card {
    --chat-bg: #181A1F;
    --chat-surface: #202329;
    --chat-surface-soft: #24272D;
    --chat-text: #F1F2F4;
    --chat-muted: #A7AAB2;
    --chat-faint: #858993;
    --chat-border: #343841;
    --chat-border-strong: #424752;

    --chat-blue: #79A9D8;
    --chat-blue-dark: #5E91C4;
    --chat-blue-soft: #293541;

    --chat-pink: #FF677D;
    --chat-pink-soft: #34303A;

    background: var(--chat-bg);
    border-color: var(--chat-border);

    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.22),
        inset 0 1px 0 rgba(255, 255, 255, 0.025);
}


/* ========================================
   HEADER
======================================== */

.forum-chat-header {
    padding: 17px 22px;

    border-bottom: 1px solid var(--chat-border);
    background: var(--chat-surface);

    flex-shrink: 0;
}

.channel-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.channel-title-icon {
    width: 36px;
    height: 36px;

    border-radius: 10px;

    background: var(--chat-blue-soft);
    color: var(--chat-blue-dark);

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: 700;
    font-size: 18px;

    flex-shrink: 0;
}

.channel-title strong {
    display: block;

    font-size: 16px;
    font-weight: 600;

    color: var(--chat-text);
}

.channel-title span {
    display: block;

    margin-top: 2px;

    font-size: 12px;
    color: var(--chat-faint);
}


/* ========================================
   MESSAGE AREA
======================================== */

.forum-messages {
    flex: 1;

    overflow-y: auto;

    padding: 22px;

    background: var(--chat-bg);

    color: var(--chat-text);
}


/* scrollbar */

.forum-messages::-webkit-scrollbar {
    width: 7px;
}

.forum-messages::-webkit-scrollbar-track {
    background: transparent;
}

.forum-messages::-webkit-scrollbar-thumb {
    background: #D8D9DC;
    border-radius: 999px;
}

.forum-messages::-webkit-scrollbar-thumb:hover {
    background: #BFC1C6;
}

body.collabify-dark .forum-messages::-webkit-scrollbar-thumb {
    background: #444954;
}

body.collabify-dark .forum-messages::-webkit-scrollbar-thumb:hover {
    background: #555B68;
}


/* ========================================
   EMPTY STATE
======================================== */

.chat-empty {
    height: 100%;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    text-align: center;

    color: var(--chat-text);
}

.chat-empty-icon {
    width: 62px;
    height: 62px;

    border-radius: 18px;

    background: var(--chat-blue-soft);
    color: var(--chat-blue);

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 27px;

    margin-bottom: 15px;
}

.chat-empty h3 {
    font-size: 18px;
    font-weight: 600;

    margin-bottom: 7px;

    color: var(--chat-text);
}

.chat-empty p {
    max-width: 380px;

    color: var(--chat-muted);

    font-size: 13px;
    line-height: 1.6;

    margin: 0;
}


/* ========================================
   MESSAGE
======================================== */

.message-item {
    display: flex;

    gap: 12px;

    padding: 8px 6px;

    border-radius: 10px;

    transition:
        background .15s ease;
}

.message-item:hover {
    background: var(--chat-surface-soft);
}

.message-avatar {
    width: 38px;
    height: 38px;

    flex-shrink: 0;

    border-radius: 50%;

    background: var(--chat-blue-soft);
    color: var(--chat-blue-dark);

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 13px;
    font-weight: 700;
}

.message-content {
    min-width: 0;
}

.message-meta {
    display: flex;
    align-items: baseline;

    gap: 8px;

    margin-bottom: 3px;
}

.message-meta strong {
    color: var(--chat-text);

    font-size: 14px;
    font-weight: 600;
}

.message-meta span {
    color: var(--chat-faint);

    font-size: 11px;
}

.message-text {
    color: var(--chat-muted);

    font-size: 14px;
    line-height: 1.55;

    word-break: break-word;
}


/* ========================================
   INPUT
======================================== */

.forum-input-area {
    padding: 14px 18px 18px;

    border-top: 1px solid var(--chat-border);

    background: var(--chat-surface);

    flex-shrink: 0;
}

.forum-message-form {
    display: flex;

    align-items: center;

    gap: 9px;
}

.forum-message-input {
    flex: 1;

    height: 46px;

    border: 1px solid var(--chat-border-strong);
    border-radius: 11px;

    padding: 0 15px;

    background: var(--chat-surface-soft);

    color: var(--chat-text);

    font-size: 14px;

    outline: none;

    transition:
        border-color .15s ease,
        background .15s ease,
        box-shadow .15s ease;
}

.forum-message-input:focus {
    border-color: var(--chat-blue);

    background: var(--chat-surface);

    box-shadow:
        0 0 0 3px rgba(121, 169, 216, 0.12);
}

.forum-message-input::placeholder {
    color: var(--chat-faint);
}

.forum-send-button {
    width: 46px;
    height: 46px;

    border: none;
    border-radius: 11px;

    background: var(--chat-blue-dark);
    color: #FFFFFF;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    transition:
        opacity .15s ease,
        transform .15s ease;
}

.forum-send-button:hover {
    opacity: .9;
    transform: translateY(-1px);
}


/* ========================================
   VOICE PLACEHOLDER
======================================== */

.voice-placeholder {
    display: flex;

    align-items: center;

    gap: 13px;

    padding: 14px 18px;

    border-top: 1px solid var(--chat-border);

    background: var(--chat-surface-soft);

    color: var(--chat-text);
}

.voice-placeholder-icon {
    width: 40px;
    height: 40px;

    border-radius: 10px;

    background: var(--chat-blue-soft);
    color: var(--chat-blue);

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;
}

.voice-placeholder strong {
    display: block;

    font-size: 13px;

    color: var(--chat-text);
}

.voice-placeholder p {
    margin: 2px 0 0;

    font-size: 11px;

    color: var(--chat-faint);
}

.voice-placeholder .btn {
    margin-left: auto;
}


/* ========================================
   VOICE CONTROLS
======================================== */

.voice-info {
    min-width: 0;
    flex: 1;
}

.voice-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: auto;
}

.voice-participants-box {
    margin: 0 18px 18px;

    border: 1px solid var(--chat-border);
    border-radius: 14px;

    background: var(--chat-surface);

    overflow: hidden;
}

.voice-participants-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 14px 18px;

    border-bottom: 1px solid var(--chat-border);

    color: var(--chat-text);

    font-size: 14px;
    font-weight: 600;
}

.voice-participants-header i {
    margin-right: 6px;
}

.voice-participant-count {
    min-width: 28px;
    height: 28px;

    padding: 0 8px;

    border-radius: 999px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    background: var(--chat-blue-soft);
    color: var(--chat-blue-dark);

    font-size: 12px;
}

.voice-participants-list {
    padding: 8px;

    background: var(--chat-surface);
}

.voice-participant {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 9px 10px;

    border-radius: 10px;

    transition: background .15s ease;
}

.voice-participant:hover {
    background: var(--chat-surface-soft);
}

.voice-participant-avatar {
    width: 38px;
    height: 38px;

    flex-shrink: 0;

    border-radius: 50%;

    background: var(--chat-blue-soft);
    color: var(--chat-blue-dark);

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 13px;
    font-weight: 700;
}

.voice-participant-info {
    flex: 1;
    min-width: 0;
}

.voice-participant-name {
    color: var(--chat-text);

    font-size: 14px;
    font-weight: 600;
}

.voice-participant-status {
    margin-top: 2px;

    color: var(--chat-faint);

    font-size: 11px;
}

.voice-participant-mic {
    color: var(--chat-blue);

    font-size: 18px;
}

.voice-empty {
    padding: 16px;

    text-align: center;

    color: var(--chat-faint);

    font-size: 13px;

    background: var(--chat-surface);
}


/* ========================================
   BUTTON DI HEADER
======================================== */

.content-header .btn-light {
    background: #FFFFFF;
    border-color: #E7D9DB;
    color: #30323A;
}

.content-header .btn-light:hover {
    background: #FFF0F1;
    border-color: #FFCCD2;
    color: #B23A52;
}

body.collabify-dark .content-header .btn-light {
    background: #202329;
    border-color: #343841;
    color: #F1F2F4;
}

body.collabify-dark .content-header .btn-light:hover {
    background: #34303A;
    border-color: #FF677D;
    color: #FF9AA2;
}


/* ========================================
   DARK MODE — EXTRA TEXT SAFETY
======================================== */

body.collabify-dark .forum-chat-card strong {
    color: var(--chat-text);
}

body.collabify-dark .forum-chat-card p {
    color: var(--chat-muted);
}

body.collabify-dark .forum-chat-card span {
    color: var(--chat-muted);
}

body.collabify-dark .forum-chat-card .message-meta span,
body.collabify-dark .forum-chat-card .channel-title span,
body.collabify-dark .forum-chat-card .voice-placeholder p,
body.collabify-dark .forum-chat-card .voice-participant-status,
body.collabify-dark .forum-chat-card .voice-empty {
    color: var(--chat-faint);
}


/* ========================================
   MOBILE
======================================== */

@media (max-width: 768px) {

    .forum-chat-card {
        height: calc(100vh - 145px);
        border-radius: 10px;
    }

    .forum-messages {
        padding: 15px;
    }

    .forum-input-area {
        padding: 10px;
    }

    .voice-placeholder {
        flex-wrap: wrap;
    }

    .voice-controls {
        width: 100%;
        margin-left: 0;
    }

    .voice-controls .btn {
        flex: 1;
    }

}

</style>


<script>
let localStream = null;
const peerConnections = {};
const pendingIceCandidates = {};
const offerInProgress = {};
const channelId = <?= (int) $channel['id_channel'] ?>;

const rtcConfig = {
    iceServers: [
        {
            urls: 'stun:stun.l.google.com:19302'
        }
    ]
};

function createPeerConnection(remoteUserId) {
    if (peerConnections[remoteUserId]) {
        return peerConnections[remoteUserId];
    }

    const peerConnection = new RTCPeerConnection(rtcConfig);
    peerConnections[remoteUserId] = peerConnection;

    if (localStream) {
        localStream.getTracks().forEach(function (track) {
            peerConnection.addTrack(track, localStream);
        });
    }

    peerConnection.ontrack = function (event) {
        const remoteStream = event.streams[0];

        if (remoteStream) {
            playRemoteAudio(remoteUserId, remoteStream);
        }
    };

    peerConnection.onicecandidate = async function (event) {
        if (!event.candidate) {
            return;
        }

        try {
            await sendVoiceSignal(
                remoteUserId,
                'ice-candidate',
                JSON.stringify(event.candidate)
            );
        } catch (error) {
            console.error('Gagal mengirim ICE candidate:', error);
        }
    };

    peerConnection.onconnectionstatechange = function () {
        console.log(
            '[VOICE] WebRTC connection',
            remoteUserId,
            peerConnection.connectionState
        );

        if (
            peerConnection.connectionState === 'failed' ||
            peerConnection.connectionState === 'closed'
        ) {
            delete peerConnections[remoteUserId];
            delete offerInProgress[remoteUserId];
        }
    };

    peerConnection.oniceconnectionstatechange = function () {
        console.log(
            '[VOICE] ICE',
            remoteUserId,
            peerConnection.iceConnectionState
        );
    };

    peerConnection.onsignalingstatechange = function () {
        console.log(
            '[VOICE] Signaling',
            remoteUserId,
            peerConnection.signalingState
        );
    };

    return peerConnection;
}

document.addEventListener('DOMContentLoaded', function () {

    const messageContainer = document.getElementById('forumMessages');

    if (messageContainer) {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    const channelType = <?= json_encode($channel['tipe']) ?>;

    // ================================
    // TEXT CHANNEL AUTO REFRESH
    // ================================

    async function loadMessages() {
        if (channelType !== 'text') {
            return;
        }

        try {
            const response = await fetch(
                `<?= base_url('forum/channel/') ?>${channelId}/messages`,
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            const data = await response.json();

            if (!data.success || !messageContainer) {
                return;
            }

            const atBottom =
                messageContainer.scrollHeight -
                messageContainer.scrollTop -
                messageContainer.clientHeight < 80;

            if (data.messages.length === 0) {
                return;
            }

            messageContainer.innerHTML = data.messages.map(function (message) {
                const name = escapeHtml(message.user_name || 'Pengguna');
                const initial = (message.user_name || 'U').charAt(0).toUpperCase();
                const text = escapeHtml(message.message || '').replace(/\n/g, '<br>');
                const date = message.created_at
                    ? new Date(message.created_at.replace(' ', 'T')).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })
                    : '';

                return `
                    <div class="message-item">
                        <div class="message-avatar">${escapeHtml(initial)}</div>
                        <div class="message-content">
                            <div class="message-meta">
                                <strong>${name}</strong>
                                <span>${escapeHtml(date)}</span>
                            </div>
                            <div class="message-text">${text}</div>
                        </div>
                    </div>
                `;
            }).join('');

            if (atBottom) {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }

        } catch (error) {
            console.error('Gagal memuat pesan:', error);
        }
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    if (channelType === 'text') {
        setInterval(loadMessages, 2000);
    }

    // ================================
    // VOICE CHANNEL
    // ================================

    if (channelType !== 'voice') {
        return;
    }

    const joinButton = document.getElementById('joinVoiceButton');
    const muteButton = document.getElementById('muteVoiceButton');
    const leaveButton = document.getElementById('leaveVoiceButton');
    const voiceStatus = document.getElementById('voiceStatus');
    const participantContainer = document.getElementById('voiceParticipants');
    const participantCount = document.getElementById('voiceParticipantCount');

    if (!joinButton || !muteButton || !leaveButton || !voiceStatus) {
        console.error('Elemen kontrol voice tidak lengkap.');
        return;
    }

    async function loadVoiceParticipants() {
        try {
            const response = await fetch(
                `<?= base_url('forum/channel/') ?>${channelId}/voice-participants`,
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            const data = await response.json();

            if (!data.success) {
                return;
            }

            participantCount.textContent = data.participants.length;

            if (data.participants.length === 0) {
                participantContainer.innerHTML = `
                    <div class="voice-empty">
                        Belum ada yang bergabung.
                    </div>
                `;
                return;
            }

            participantContainer.innerHTML = data.participants.map(function (participant) {
                const name = participant.user_name || 'Pengguna';
                const initial = name.charAt(0).toUpperCase();
                const muted = Number(participant.is_muted) === 1;

                return `
                    <div class="voice-participant">
                        <div class="voice-participant-avatar">
                            ${escapeHtml(initial)}
                        </div>
                        <div class="voice-participant-info">
                            <div class="voice-participant-name">
                                ${escapeHtml(name)}
                            </div>
                            <div class="voice-participant-status">
                                Sedang berada di voice
                            </div>
                        </div>
                        <div class="voice-participant-mic">
                            <i class="ti ${muted ? 'ti-microphone-off' : 'ti-microphone'}"></i>
                        </div>
                    </div>
                `;
            }).join('');

            if (localStream && data.participants.length > 1) {
                await connectToParticipants();
            }

        } catch (error) {
            console.error('Gagal mengambil participant voice:', error);
        }
    }

    async function joinVoice() {
        joinButton.disabled = true;
        joinButton.innerHTML = '<i class="ti ti-loader-2"></i> Menghubungkan...';
        voiceStatus.textContent = 'Meminta akses microphone...';

        try {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Browser tidak mendukung akses microphone.');
            }

            localStream = await navigator.mediaDevices.getUserMedia({
                audio: true,
                video: false
            });

            voiceStatus.textContent =
                'Microphone aktif. Mendaftarkan kamu ke voice channel...';

            const response = await fetch(
                `<?= base_url('forum/channel/') ?>${channelId}/join-voice`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
                }
            );

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Gagal bergabung.');
            }

            voiceStatus.textContent =
                'Microphone aktif. Kamu sudah masuk voice channel.';

            joinButton.style.display = 'none';
            muteButton.style.display = 'inline-flex';
            leaveButton.style.display = 'inline-flex';

            muteButton.innerHTML =
                '<i class="ti ti-microphone"></i> Mute';
            muteButton.classList.remove('btn-warning');
            muteButton.classList.add('btn-secondary');

            await loadVoiceParticipants();

            // Beri server sedikit waktu untuk mencatat participant,
            // lalu mulai negosiasi WebRTC secara eksplisit.
            setTimeout(function () {
                console.log('[VOICE] Memulai pengecekan koneksi setelah join...');
                connectToParticipants();
            }, 500);

        } catch (error) {
            console.error('Voice error:', error);

            if (localStream) {
                localStream.getTracks().forEach(function (track) {
                    track.stop();
                });
                localStream = null;
            }

            voiceStatus.textContent =
                'Bergabung untuk mulai menggunakan microphone.';

            joinButton.disabled = false;
            joinButton.innerHTML =
                '<i class="ti ti-phone mr-1"></i> Bergabung';

            alert(
                'Microphone tidak bisa diakses.\n\nError: ' +
                error.message
            );
        }
    }

    async function toggleMute() {
        try {
            const response = await fetch(
                `<?= base_url('forum/channel/') ?>${channelId}/toggle-mute`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
                }
            );

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Gagal mengubah microphone.');
            }

            const muted = Number(data.is_muted) === 1;

            if (localStream) {
                localStream.getAudioTracks().forEach(function (track) {
                    track.enabled = !muted;
                });
            }

            if (muted) {
                muteButton.innerHTML =
                    '<i class="ti ti-microphone-off"></i> Unmute';
                muteButton.classList.remove('btn-secondary');
                muteButton.classList.add('btn-warning');
            } else {
                muteButton.innerHTML =
                    '<i class="ti ti-microphone"></i> Mute';
                muteButton.classList.remove('btn-warning');
                muteButton.classList.add('btn-secondary');
            }

            await loadVoiceParticipants();

        } catch (error) {
            console.error('Mute error:', error);
            alert('Gagal mengubah status microphone: ' + error.message);
        }
    }

    async function leaveVoice() {
        leaveButton.disabled = true;

        try {
            const response = await fetch(
                `<?= base_url('forum/channel/') ?>${channelId}/leave-voice`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
                }
            );

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Gagal keluar dari voice channel.');
            }

            if (localStream) {
                localStream.getTracks().forEach(function (track) {
                    track.stop();
                });
                localStream = null;
            }

            Object.keys(peerConnections).forEach(function (remoteUserId) {
                try {
                    peerConnections[remoteUserId].close();
                } catch (error) {
                    console.error('Gagal menutup peer connection:', error);
                }
                delete peerConnections[remoteUserId];
                delete offerInProgress[remoteUserId];
            });

            voiceStatus.textContent =
                'Kamu sudah keluar dari voice channel.';

            joinButton.style.display = 'inline-flex';
            joinButton.disabled = false;
            joinButton.innerHTML =
                '<i class="ti ti-phone mr-1"></i> Bergabung';

            muteButton.style.display = 'none';
            leaveButton.style.display = 'none';
            leaveButton.disabled = false;

            await loadVoiceParticipants();

        } catch (error) {
            leaveButton.disabled = false;
            console.error('Leave voice error:', error);
            alert('Gagal keluar dari voice channel: ' + error.message);
        }
    }

    joinButton.addEventListener('click', joinVoice);
    muteButton.addEventListener('click', toggleMute);
    leaveButton.addEventListener('click', leaveVoice);

    loadVoiceParticipants();
    setInterval(loadVoiceParticipants, 2000);
});

function playRemoteAudio(remoteUserId, stream) {
    let audio = document.getElementById(
        'remoteAudio-' + remoteUserId
    );

    if (!audio) {
        audio = document.createElement('audio');
        audio.id = 'remoteAudio-' + remoteUserId;
        audio.autoplay = true;
        audio.playsInline = true;
        audio.controls = false;
        document.body.appendChild(audio);
    }

    audio.srcObject = stream;

    audio.play().catch(function (error) {
        console.warn(
            'Autoplay audio diblokir browser untuk user ' +
            remoteUserId +
            '. Klik halaman sekali lalu coba lagi.',
            error
        );
    });
}

async function sendVoiceSignal(receiverId, signalType, signalData) {
    const response = await fetch(
        `<?= base_url('forum/channel/') ?>${channelId}/voice-signal`,
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body:
                '<?= csrf_token() ?>=' +
                encodeURIComponent('<?= csrf_hash() ?>') +
                '&receiver_id=' +
                encodeURIComponent(receiverId) +
                '&signal_type=' +
                encodeURIComponent(signalType) +
                '&signal_data=' +
                encodeURIComponent(signalData)
        }
    );

    const data = await response.json();

    console.log(
        '[VOICE] Signal POST:',
        signalType,
        '→ user',
        receiverId,
        '| HTTP',
        response.status,
        '| result:',
        data
    );

    if (!data.success) {
        console.error('Gagal mengirim voice signal:', data.message);
    }

    return data;
}

async function createOfferForUser(remoteUserId) {
    remoteUserId = Number(remoteUserId);

    if (!localStream) {
        console.warn('[VOICE] Tidak ada localStream, offer dibatalkan.');
        return;
    }

    if (peerConnections[remoteUserId]) {
        const state = peerConnections[remoteUserId].connectionState;
        if (state === 'connected' || state === 'connecting') {
            return;
        }
    }

    if (offerInProgress[remoteUserId]) {
        return;
    }

    offerInProgress[remoteUserId] = true;

    try {
        console.log('[VOICE] Membuat OFFER ke user:', remoteUserId);

        const peerConnection = createPeerConnection(remoteUserId);

        const offer = await peerConnection.createOffer({
            offerToReceiveAudio: true
        });

        await peerConnection.setLocalDescription(offer);

        console.log('[VOICE] OFFER siap, mengirim ke user:', remoteUserId);

        const result = await sendVoiceSignal(
            remoteUserId,
            'offer',
            JSON.stringify(peerConnection.localDescription)
        );

        if (!result || !result.success) {
            throw new Error(
                (result && result.message) ||
                'Server menolak voice signal.'
            );
        }

        console.log('[VOICE] OFFER berhasil dikirim ke user:', remoteUserId);

    } catch (error) {
        console.error(
            '[VOICE] Gagal membuat/mengirim OFFER ke user ' +
            remoteUserId + ':',
            error
        );

        if (peerConnections[remoteUserId]) {
            try {
                peerConnections[remoteUserId].close();
            } catch (closeError) {
                console.error(closeError);
            }
            delete peerConnections[remoteUserId];
        }
    } finally {
        delete offerInProgress[remoteUserId];
    }
}

async function connectToParticipants() {
    try {
        if (!localStream) {
            console.log('[VOICE] connectToParticipants: belum ada microphone.');
            return;
        }

        const response = await fetch(
            `<?= base_url('forum/channel/') ?>${channelId}/voice-participants`,
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        );

        const data = await response.json();

        if (!data.success) {
            console.warn('[VOICE] Gagal mengambil participant:', data.message);
            return;
        }

        const myUserId = Number(
            <?= (int) session()->get('id_user') ?>
        );

        const participants = data.participants
            .map(function (participant) {
                return {
                    id: Number(participant.id_user),
                    name: participant.user_name || 'Pengguna'
                };
            })
            .filter(function (participant) {
                return participant.id !== myUserId;
            })
            .sort(function (a, b) {
                return a.id - b.id;
            });

        console.log(
            '[VOICE] Saya:',
            myUserId,
            '| Remote participant:',
            participants
        );

        if (participants.length === 0) {
            return;
        }

        /*
         * Aturan initiator dibuat deterministik:
         * user dengan ID PALING KECIL dari seluruh participant
         * menjadi pihak yang membuat OFFER.
         *
         * Dengan ini kita tidak bergantung pada siapa yang
         * lebih dulu membuka halaman.
         */
        const allIds = data.participants
            .map(function (participant) {
                return Number(participant.id_user);
            })
            .sort(function (a, b) {
                return a - b;
            });

        const initiatorId = allIds[0];

        console.log(
            '[VOICE] Semua participant:',
            allIds,
            '| Initiator:',
            initiatorId
        );

        if (myUserId !== initiatorId) {
            console.log(
                '[VOICE] Saya bukan initiator. Menunggu OFFER dari user:',
                initiatorId
            );
            return;
        }

        for (const participant of participants) {
            await createOfferForUser(participant.id);
        }

    } catch (error) {
        console.error(
            '[VOICE] Gagal menghubungkan participant:',
            error
        );
    }
}

async function checkVoiceSignals() {
    try {
        const response = await fetch(
            `<?= base_url('forum/channel/') ?>${channelId}/voice-signals`,
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        );

        const data = await response.json();

        if (!data.success || !data.signals.length) {
            return;
        }

        for (const signal of data.signals) {
            await handleVoiceSignal(signal);
        }

    } catch (error) {
        console.error('Signal error:', error);
    }
}

async function handleVoiceSignal(signal) {
    try {
        const senderId = Number(signal.sender_id);
        const peerConnection = createPeerConnection(senderId);
        const signalData = JSON.parse(signal.signal_data);

        if (signal.signal_type === 'offer') {
            await peerConnection.setRemoteDescription(
                new RTCSessionDescription(signalData)
            );

            if (pendingIceCandidates[senderId]) {
                for (const candidate of pendingIceCandidates[senderId]) {
                    try {
                        await peerConnection.addIceCandidate(candidate);
                    } catch (error) {
                        console.error(
                            'Queued ICE candidate error:',
                            error
                        );
                    }
                }

                delete pendingIceCandidates[senderId];
            }

            const answer = await peerConnection.createAnswer();

            await peerConnection.setLocalDescription(answer);

            await sendVoiceSignal(
                senderId,
                'answer',
                JSON.stringify(answer)
            );

            return;
        }

        if (signal.signal_type === 'answer') {
            await peerConnection.setRemoteDescription(
                new RTCSessionDescription(signalData)
            );

            if (pendingIceCandidates[senderId]) {
                for (const candidate of pendingIceCandidates[senderId]) {
                    try {
                        await peerConnection.addIceCandidate(candidate);
                    } catch (error) {
                        console.error(
                            'Queued ICE candidate error:',
                            error
                        );
                    }
                }

                delete pendingIceCandidates[senderId];
            }

            return;
        }

        if (signal.signal_type === 'ice-candidate') {
            const candidate = new RTCIceCandidate(signalData);

            if (
                peerConnection.remoteDescription &&
                peerConnection.remoteDescription.type
            ) {
                try {
                    await peerConnection.addIceCandidate(candidate);
                } catch (error) {
                    console.error(
                        'ICE candidate error:',
                        error
                    );
                }
            } else {
                if (!pendingIceCandidates[senderId]) {
                    pendingIceCandidates[senderId] = [];
                }

                pendingIceCandidates[senderId].push(candidate);
            }
        }

    } catch (error) {
        console.error(
            'Gagal memproses voice signal:',
            signal,
            error
        );
    }
}

setInterval(checkVoiceSignals, 1000);
</script>

<?= $this->endSection() ?>

<?php
$title = $title ?? 'Forum';

$userGroups = $userGroups ?? [];
$groupChannels = $groupChannels ?? [];
$selectedGroup = $selectedGroup ?? null;
$communityChannels = $communityChannels ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?> - Collabify</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"
    >

    <style>
        :root {
            --bg: #FFF8F7;
            --surface: #FFFFFF;
            --surface-soft: #FAFAFA;

            --blue: #79A9D8;
            --blue-dark: #5E91C4;
            --blue-soft: #EAF3FA;

            --pink: #FF9AA2;
            --pink-dark: #FF677D;
            --pink-soft: #FFF0F1;

            --text: #30323A;
            --muted: #77777D;
            --faint: #A2A3A8;

            --border: #F0DFE1;

            --shadow-sm: 0 4px 14px rgba(48, 50, 58, 0.05);
            --shadow-md: 0 10px 28px rgba(48, 50, 58, 0.07);

            --scroll-thumb: #D8D9DC;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            overflow: hidden;
            transition:
                background-color .2s ease,
                color .2s ease;
        }

        button,
        input,
        textarea {
            font: inherit;
        }

        a {
            color: inherit;
            text-decoration: none !important;
        }

        /* =========================================================
           LAYOUT
        ========================================================= */

        .forum-layout {
            width: 100%;
            height: 100vh;

            display: grid;
            grid-template-columns: 230px 240px minmax(0, 1fr);

            overflow: hidden;

            background: var(--bg);
        }

        /* =========================================================
           LEFT SIDEBAR
        ========================================================= */

        .forum-sidebar {
            height: 100vh;
            min-width: 0;

            display: flex;
            flex-direction: column;

            background:
                linear-gradient(
                    180deg,
                    rgba(255, 255, 255, 0.98),
                    rgba(255, 248, 247, 0.96)
                );

            border-right: 1px solid var(--border);

            overflow: hidden;
        }

        .brand {
            padding: 22px 18px 18px;
            border-bottom: 1px solid var(--border);
        }

        .brand h2 {
            margin: 0;

            font-size: 18px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -0.03em;

            color: var(--text);
        }

        .brand span {
            display: block;
            margin-top: 5px;

            font-size: 11px;
            font-weight: 600;

            color: var(--faint);
            letter-spacing: .03em;
        }

        .sidebar-scroll {
            flex: 1;
            min-height: 0;

            padding: 14px 10px 18px;

            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-scroll::-webkit-scrollbar,
        .channel-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-track,
        .channel-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb,
        .channel-scroll::-webkit-scrollbar-thumb {
            background: var(--scroll-thumb);
            border-radius: 999px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover,
        .channel-scroll::-webkit-scrollbar-thumb:hover {
            background: #BFC1C6;
        }

        .section-title {
            padding: 0 9px;
            margin: 10px 0 8px;

            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;

            color: var(--faint);
        }

        .community-item {
            width: 100%;

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 11px;
            margin-bottom: 6px;

            border-radius: 12px;

            color: var(--text);
            font-size: 13px;
            font-weight: 700;

            transition:
                background-color .18s ease,
                color .18s ease,
                transform .18s ease;
        }

        .community-item:hover {
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .community-item.active {
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .community-icon {
            width: 30px;
            height: 30px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 30px;

            border-radius: 9px;

            background: var(--blue-soft);
            color: var(--blue-dark);

            font-size: 16px;
        }

        .community-item.active .community-icon {
            background: #DCECF9;
        }

        .group-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .group-item {
            width: 100%;

            display: flex;
            align-items: center;
            gap: 9px;

            padding: 9px 10px;

            border-radius: 11px;

            color: var(--muted);

            font-size: 12px;
            font-weight: 650;

            transition:
                background-color .18s ease,
                color .18s ease;
        }

        .group-item:hover {
            background: #F7F7F7;
            color: var(--text);
        }

        .group-item.active {
            background: var(--pink-soft);
            color: var(--pink-dark);
        }

        .group-item-icon {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 28px;

            border-radius: 8px;

            background: #F8F8F8;
            color: var(--muted);

            font-size: 14px;
        }

        .group-item.active .group-item-icon {
            background: #FFE1E4;
            color: var(--pink-dark);
        }

        .group-item-name {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .no-group {
            padding: 12px 10px;

            font-size: 12px;
            line-height: 1.6;

            color: var(--faint);
        }

        /* =========================================================
           CHANNEL SIDEBAR
        ========================================================= */

        .channel-sidebar {
            height: 100vh;
            min-width: 0;

            display: flex;
            flex-direction: column;

            background: var(--surface);

            border-right: 1px solid var(--border);

            overflow: hidden;
        }

        .channel-header {
            min-height: 73px;

            display: flex;
            align-items: center;

            padding: 18px;

            border-bottom: 1px solid var(--border);

            color: var(--text);
            font-size: 14px;
            font-weight: 800;
        }

        .channel-header-icon {
            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            margin-right: 10px;

            border-radius: 10px;

            background: var(--pink-soft);
            color: var(--pink-dark);

            font-size: 17px;
        }

        .channel-scroll {
            flex: 1;
            min-height: 0;

            padding: 14px 10px 18px;

            overflow-y: auto;
            overflow-x: hidden;
        }

        .channel-section {
            margin-bottom: 20px;
        }

        .channel-section-title {
            padding: 0 9px;
            margin: 4px 0 8px;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: .08em;
            text-transform: uppercase;

            color: var(--faint);
        }

        .channel-item {
            width: 100%;

            display: flex;
            align-items: center;
            gap: 9px;

            padding: 9px 10px;

            border-radius: 10px;

            color: var(--muted);

            font-size: 12px;
            font-weight: 650;

            transition:
                background-color .18s ease,
                color .18s ease;
        }

        .channel-item:hover {
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .channel-item.active {
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .channel-item i {
            width: 18px;
            text-align: center;

            font-size: 15px;
        }

        .channel-item span {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* =========================================================
           MAIN FORUM
        ========================================================= */

        .forum-main {
            height: 100vh;
            min-width: 0;

            display: flex;
            flex-direction: column;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(121, 169, 216, .12),
                    transparent 28%
                ),
                radial-gradient(
                    circle at bottom left,
                    rgba(255, 154, 162, .10),
                    transparent 26%
                ),
                var(--bg);

            overflow: hidden;
        }

        .chat-header {
            min-height: 73px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 15px 22px;

            background: rgba(255, 255, 255, .92);

            border-bottom: 1px solid var(--border);

            box-shadow: 0 2px 12px rgba(48, 50, 58, .03);

            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .chat-title {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chat-title-icon {
            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 34px;

            border-radius: 10px;

            background: var(--blue-soft);
            color: var(--blue-dark);

            font-size: 17px;
        }

        .chat-title-text {
            min-width: 0;
        }

        .chat-title strong {
            display: block;

            max-width: 100%;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            font-size: 14px;
            font-weight: 800;

            color: var(--text);
        }

        .chat-title span {
            display: block;

            margin-top: 2px;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            font-size: 11px;
            color: var(--muted);
        }

        .chat-content {
            flex: 1;
            min-height: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px;

            overflow: auto;
        }

        .empty-box {
            width: min(460px, 100%);

            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 18px;

            border-radius: 22px;

            background: var(--pink-soft);
            color: var(--pink-dark);

            font-size: 29px;

            box-shadow:
                0 10px 25px rgba(255, 103, 125, .08);
        }

        .empty-box h3 {
            margin: 0;

            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.02em;

            color: var(--text);
        }

        .empty-box p {
            max-width: 390px;

            margin: 9px auto 0;

            font-size: 13px;
            line-height: 1.65;

            color: var(--muted);
        }

        .fake-input-wrap {
            padding: 14px 20px 18px;
        }

        .fake-input {
            width: 100%;
            min-height: 48px;

            display: flex;
            align-items: center;

            padding: 0 15px;

            border: 1px solid var(--border);
            border-radius: 14px;

            background: rgba(255, 255, 255, .88);

            color: var(--faint);

            font-size: 12px;

            box-shadow: var(--shadow-sm);

            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .fake-input i {
            margin-right: 9px;
            font-size: 16px;
        }

        /* =========================================================
           DARK MODE
        ========================================================= */

        body.forum-dark {
            --bg: #181A1F;
            --surface: #202329;
            --surface-soft: #24272D;

            --text: #F1F2F4;
            --muted: #A7AAB2;
            --faint: #858993;

            --border: #343841;

            --blue-soft: #293541;
            --pink-soft: #34303A;

            --scroll-thumb: #444954;

            background: var(--bg);
            color: var(--text);

            color-scheme: dark;
        }

        body.forum-dark .forum-layout {
            background: var(--bg);
        }

        body.forum-dark .forum-sidebar {
            background: #202329;
            border-right-color: #343841;
        }

        body.forum-dark .brand {
            border-bottom-color: #343841;
        }

        body.forum-dark .brand h2 {
            color: #F1F2F4;
        }

        body.forum-dark .brand span,
        body.forum-dark .section-title {
            color: #858993;
        }

        body.forum-dark .community-item {
            color: #A7AAB2;
        }

        body.forum-dark .community-item:hover,
        body.forum-dark .community-item.active {
            background: #293541;
            color: #79A9D8;
        }

        body.forum-dark .community-icon {
            background: #293541;
            color: #79A9D8;
        }

        body.forum-dark .community-item.active .community-icon {
            background: #304050;
        }

        body.forum-dark .group-item {
            color: #A7AAB2;
        }

        body.forum-dark .group-item:hover {
            background: #292C32;
            color: #F1F2F4;
        }

        body.forum-dark .group-item.active {
            background: #34303A;
            color: #FF9AA2;
        }

        body.forum-dark .group-item-icon {
            background: #292C32;
            color: #858993;
        }

        body.forum-dark .group-item.active .group-item-icon {
            background: #46363A;
            color: #FF9AA2;
        }

        body.forum-dark .no-group {
            color: #858993;
        }

        body.forum-dark .channel-sidebar {
            background: #1D2025;
            border-right-color: #343841;
        }

        body.forum-dark .channel-header {
            color: #F1F2F4;
            border-bottom-color: #343841;
        }

        body.forum-dark .channel-header-icon {
            background: #34303A;
            color: #FF9AA2;
        }

        body.forum-dark .channel-section-title {
            color: #858993;
        }

        body.forum-dark .channel-item {
            color: #A7AAB2;
        }

        body.forum-dark .channel-item:hover {
            background: #293541;
            color: #79A9D8;
        }

        body.forum-dark .channel-item.active {
            background: #293541;
            color: #79A9D8;
        }

        body.forum-dark .forum-main {
            background:
                radial-gradient(
                    circle at top right,
                    rgba(121, 169, 216, .08),
                    transparent 28%
                ),
                radial-gradient(
                    circle at bottom left,
                    rgba(255, 154, 162, .07),
                    transparent 26%
                ),
                #181A1F;
        }

        body.forum-dark .chat-header {
            background: rgba(32, 35, 41, .96);
            border-bottom-color: #343841;

            box-shadow:
                0 2px 14px rgba(0, 0, 0, .16);
        }

        body.forum-dark .chat-title-icon {
            background: #293541;
            color: #79A9D8;
        }

        body.forum-dark .chat-title strong {
            color: #F1F2F4;
        }

        body.forum-dark .chat-title span {
            color: #858993;
        }

        body.forum-dark .empty-icon {
            background: #34303A;
            color: #FF9AA2;

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .16);
        }

        body.forum-dark .empty-box h3 {
            color: #F1F2F4;
        }

        body.forum-dark .empty-box p {
            color: #A7AAB2;
        }

        body.forum-dark .fake-input-wrap {
            background: transparent;
        }

        body.forum-dark .fake-input {
            background: #202329;
            border-color: #343841;
            color: #777C86;

            box-shadow:
                0 8px 20px rgba(0, 0, 0, .14);
        }

        body.forum-dark .sidebar-scroll::-webkit-scrollbar-thumb,
        body.forum-dark .channel-scroll::-webkit-scrollbar-thumb {
            background: #444954;
        }

        body.forum-dark .sidebar-scroll::-webkit-scrollbar-thumb:hover,
        body.forum-dark .channel-scroll::-webkit-scrollbar-thumb:hover {
            background: #555B68;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1050px) {
            .forum-layout {
                grid-template-columns: 210px 220px minmax(0, 1fr);
            }
        }

        @media (max-width: 850px) {
            .forum-layout {
                grid-template-columns: 200px minmax(0, 1fr);
            }

            .channel-sidebar {
                display: none;
            }
        }

        @media (max-width: 680px) {
            .forum-layout {
                grid-template-columns: 1fr;
            }

            .forum-sidebar {
                display: none;
            }

            .chat-header {
                padding: 14px 16px;
            }

            .chat-content {
                padding: 22px 16px;
            }

            .fake-input-wrap {
                padding: 12px 14px 15px;
            }
        }

        @media (max-width: 480px) {
            .chat-title-icon {
                width: 31px;
                height: 31px;
                flex-basis: 31px;
            }

            .chat-title strong {
                font-size: 13px;
            }

            .chat-title span {
                font-size: 10px;
            }

            .empty-icon {
                width: 62px;
                height: 62px;
                border-radius: 19px;
                font-size: 25px;
            }

            .empty-box h3 {
                font-size: 17px;
            }

            .empty-box p {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="forum-layout">

    <!-- =========================================================
         SIDEBAR KIRI
    ========================================================== -->

    <aside class="forum-sidebar">

        <div class="brand">
            <h2>COLLABIFY</h2>
            <span>FORUM KOLABORASI</span>
        </div>

        <div class="sidebar-scroll">

            <div class="section-title">
                Komunitas
            </div>

            <a
                href="<?= base_url('forum') ?>"
                class="community-item <?= empty($selectedGroup) ? 'active' : '' ?>"
            >
                <span class="community-icon">
                    <i class="ti ti-world"></i>
                </span>

                <span>Community</span>
            </a>

            <div class="section-title">
                Kelompok
            </div>

            <?php if (!empty($userGroups)): ?>

                <div class="group-list">

                    <?php foreach ($userGroups as $group): ?>

                        <?php
                        $idGroup = (int) $group['id_group'];
                        $channels = $groupChannels[$idGroup] ?? [];
                        ?>

                        <a
                            href="<?= base_url('forum/group/' . $idGroup) ?>"
                            class="group-item <?= ($selectedGroup && (int) $selectedGroup['id_group'] === $idGroup) ? 'active' : '' ?>"
                        >
                            <span class="group-item-icon">
                                <i class="ti ti-users-group"></i>
                            </span>

                            <span class="group-item-name">
                                <?= esc($group['nama_kelompok']) ?>
                            </span>
                        </a>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <div class="no-group">
                    Kamu belum bergabung dengan kelompok.
                </div>

            <?php endif; ?>

        </div>

    </aside>


    <!-- =========================================================
         SIDEBAR CHANNEL
    ========================================================== -->

    <aside class="channel-sidebar">

        <div class="channel-header">

            <span class="channel-header-icon">
                <i class="ti ti-message-circle"></i>
            </span>

            <span>
                <?= $selectedGroup
                    ? esc($selectedGroup['nama_kelompok'])
                    : 'Community'
                ?>
            </span>

        </div>

        <div class="channel-scroll">

            <?php if ($selectedGroup): ?>

                <?php
                $textChannels = [];
                $voiceChannels = [];

                foreach ($groupChannels[(int) $selectedGroup['id_group']] ?? [] as $channel) {
                    if (($channel['tipe'] ?? 'text') === 'voice') {
                        $voiceChannels[] = $channel;
                    } else {
                        $textChannels[] = $channel;
                    }
                }
                ?>

                <?php if (!empty($textChannels)): ?>

                    <div class="channel-section">

                        <div class="channel-section-title">
                            Text Channels
                        </div>

                        <?php foreach ($textChannels as $channel): ?>

                            <a
                                href="<?= base_url('forum/channel/' . (int) $channel['id_channel']) ?>"
                                class="channel-item"
                            >
                                <i class="ti ti-hash"></i>

                                <span>
                                    <?= esc($channel['nama_channel']) ?>
                                </span>
                            </a>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>


                <?php if (!empty($voiceChannels)): ?>

                    <div class="channel-section">

                        <div class="channel-section-title">
                            Voice Channels
                        </div>

                        <?php foreach ($voiceChannels as $channel): ?>

                            <a
                                href="<?= base_url('forum/channel/' . (int) $channel['id_channel']) ?>"
                                class="channel-item"
                            >
                                <i class="ti ti-volume"></i>

                                <span>
                                    <?= esc($channel['nama_channel']) ?>
                                </span>
                            </a>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>


            <?php else: ?>

                <?php
                $textChannels = [];
                $voiceChannels = [];

                foreach ($communityChannels as $channel) {
                    if (($channel['tipe'] ?? 'text') === 'voice') {
                        $voiceChannels[] = $channel;
                    } else {
                        $textChannels[] = $channel;
                    }
                }
                ?>

                <?php if (!empty($textChannels)): ?>

                    <div class="channel-section">

                        <div class="channel-section-title">
                            Text Channels
                        </div>

                        <?php foreach ($textChannels as $channel): ?>

                            <a
                                href="<?= base_url('forum/channel/' . (int) $channel['id_channel']) ?>"
                                class="channel-item"
                            >
                                <i class="ti ti-hash"></i>

                                <span>
                                    <?= esc($channel['nama_channel']) ?>
                                </span>
                            </a>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>


                <?php if (!empty($voiceChannels)): ?>

                    <div class="channel-section">

                        <div class="channel-section-title">
                            Voice Channels
                        </div>

                        <?php foreach ($voiceChannels as $channel): ?>

                            <a
                                href="<?= base_url('forum/channel/' . (int) $channel['id_channel']) ?>"
                                class="channel-item"
                            >
                                <i class="ti ti-volume"></i>

                                <span>
                                    <?= esc($channel['nama_channel']) ?>
                                </span>
                            </a>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    </aside>


    <!-- =========================================================
         MAIN CHAT
    ========================================================== -->

    <main class="forum-main">

        <header class="chat-header">

            <div class="chat-title">

                <span class="chat-title-icon">
                    <i class="ti ti-hash"></i>
                </span>

                <div class="chat-title-text">

                    <strong>
                        # general
                    </strong>

                    <span>
                        <?= $selectedGroup
                            ? esc($selectedGroup['nama_kelompok'])
                            : 'Community'
                        ?>
                    </span>

                </div>

            </div>

        </header>


        <div class="chat-content">

            <div class="empty-box">

                <div class="empty-icon">
                    <i class="ti ti-messages"></i>
                </div>

                <h3>
                    Belum ada percakapan
                </h3>

                <p>
                    Mulai diskusi dengan anggota kelompokmu.
                    Bagikan ide, tanyakan sesuatu, atau koordinasikan tugas bersama.
                </p>

            </div>

        </div>


        <div class="fake-input-wrap">

            <div class="fake-input">

                <i class="ti ti-message"></i>

                <span>
                    Ketik pesan untuk memulai diskusi...
                </span>

            </div>

        </div>

    </main>

</div>


<script>
(function () {

    function applyForumTheme(theme) {

        const currentTheme =
            theme ||
            localStorage.getItem('collabify-theme') ||
            'light';

        if (currentTheme === 'dark') {
            document.body.classList.add('forum-dark');
        } else {
            document.body.classList.remove('forum-dark');
        }
    }

    // Apply theme saat halaman Forum dibuka.
    applyForumTheme();

    // Sinkronisasi kalau theme berubah dari tab/window lain.
    window.addEventListener('storage', function (event) {

        if (event.key === 'collabify-theme') {
            applyForumTheme(event.newValue || 'light');
        }

    });

})();
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= esc($title ?? 'Collabify') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="<?= base_url('assets/tabler/tabler-icons.min.css') ?>">

    <style>
        :root{
            --blue:#79A9D8;
            --blue-deep:#5E91C4;
            --blue-soft:#EAF3FA;

            --pink:#FF9AA2;
            --pink-hot:#FF677D;
            --pink-soft:#FFF0F1;

            --yellow:#F9E79F;
            --peach:#FFCCB6;

            --bg:#FFF8F7;
            --surface:#FFFFFF;

            --ink:#30323A;
            --muted:#77777D;
            --faint:#A1A2A7;

            --border:#F0DFE1;

            --r-sm:10px;
            --r-md:14px;
            --r-lg:20px;
            --r-xl:26px;
            --pill:999px;

            --shadow-sm:0 2px 8px rgba(48,50,58,.05);
            --shadow-md:0 10px 28px rgba(48,50,58,.08);
            --shadow-lg:0 20px 50px rgba(48,50,58,.11);

            --mono:'Geist Mono',ui-monospace,monospace;
            --max:1280px;
            --ease:cubic-bezier(.2,.6,.2,1);
        }

        *,
        *::before,
        *::after{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            font-family:'Geist',system-ui,-apple-system,sans-serif;
            background-color:var(--bg);
            /* gradasi yang sama dengan halaman aplikasi, supaya beranda tidak terasa berbeda */
            background-image:
                radial-gradient(58% 44% at 4% 0%,    rgba(94,196,255,.24) 0%, rgba(94,196,255,0) 70%),
                radial-gradient(50% 40% at 100% 18%, rgba(255,140,198,.18) 0%, rgba(255,140,198,0) 68%),
                radial-gradient(54% 44% at 42% 100%, rgba(183,156,255,.16) 0%, rgba(183,156,255,0) 70%),
                linear-gradient(180deg,#fff8fc 0%,#f3f9ff 58%,#fef5fc 100%);
            color:var(--ink);
            min-height:100vh;
            display:flex;
            flex-direction:column;
            line-height:1.6;
            -webkit-font-smoothing:antialiased;
            text-rendering:optimizeLegibility;
        }

        a{
            color:inherit;
            text-decoration:none;
        }

        img{
            display:block;
            max-width:100%;
        }

        button,
        input{
            font-family:inherit;
        }

        ::selection{
            background:var(--pink-soft);
            color:var(--pink-hot);
        }

        .mono{
            font-family:var(--mono);
        }

        /* =========================================================
           NAVBAR
        ========================================================= */

        .cf-nav{
            position:sticky;
            top:0;
            z-index:100;
            background:rgba(255,248,247,.88);
            backdrop-filter:saturate(150%) blur(14px);
            -webkit-backdrop-filter:saturate(150%) blur(14px);
            border-bottom:1px solid rgba(240,223,225,.9);
        }

        .cf-nav-inner{
            width:100%;
            max-width:var(--max);
            margin:0 auto;
            padding:13px 28px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:22px;
        }

        .cf-nav-left{
            display:flex;
            align-items:center;
            gap:28px;
            min-width:0;
        }

        /* BRAND */

        .cf-brand{
            display:inline-flex;
            align-items:center;
            gap:9px;
            flex-shrink:0;
        }

        .cf-brand-mark{
            width:24px;
            height:24px;
            color:var(--blue-deep);
        }

        .cf-brand-text{
            font-weight:700;
            font-size:15px;
            letter-spacing:.16em;
            color:var(--ink);
        }

        /* NAV LINKS */

        .cf-links{
            display:flex;
            align-items:center;
            gap:7px;
        }

        .cf-links a{
            position:relative;
            padding:8px 10px;
            border-radius:10px;
            font-size:13.5px;
            color:var(--muted);
            font-weight:500;
            transition:
                color .15s var(--ease),
                background .15s var(--ease);
        }

        .cf-links a:hover{
            color:var(--blue-deep);
            background:var(--blue-soft);
        }

        .cf-links a.on{
            color:var(--ink);
            font-weight:600;
        }

        .cf-links a.on::after{
            content:"";
            position:absolute;
            left:10px;
            right:10px;
            bottom:3px;
            height:2px;
            border-radius:999px;
            background:var(--blue);
        }

        /* RIGHT NAV */

        .cf-nav-right{
            display:flex;
            align-items:center;
            gap:10px;
            flex-shrink:0;
        }

        .cf-search-trigger{
            display:flex;
            align-items:center;
            gap:8px;
            min-width:145px;
            border:1px solid var(--border);
            background:rgba(255,255,255,.82);
            color:var(--faint);
            border-radius:11px;
            padding:8px 11px;
            font-size:12.5px;
            cursor:pointer;
            transition:
                border-color .15s,
                box-shadow .15s,
                background .15s;
        }

        .cf-search-trigger:hover{
            background:#fff;
            border-color:#E5C9CD;
            box-shadow:var(--shadow-sm);
        }

        .cf-search-trigger .shortcut{
            margin-left:auto;
            font-family:var(--mono);
            font-size:9.5px;
            border:1px solid var(--border);
            border-radius:5px;
            padding:1px 5px;
            color:var(--faint);
        }

        .cf-nav-link{
            font-size:13px;
            font-weight:500;
            color:var(--ink);
            padding:8px 12px;
            border-radius:10px;
            transition:background .15s;
        }

        .cf-nav-link:hover{
            background:var(--pink-soft);
            color:var(--pink-hot);
        }

        .cf-register{
            background:var(--blue-deep);
            color:#fff;
            border-radius:11px;
            padding:9px 15px;
            font-size:13px;
            font-weight:600;
            box-shadow:0 6px 16px rgba(94,145,196,.20);
            transition:
                transform .15s var(--ease),
                box-shadow .15s var(--ease);
        }

        .cf-register:hover{
            transform:translateY(-1px);
            box-shadow:0 10px 22px rgba(94,145,196,.25);
        }

        .cf-avatar{
            width:32px;
            height:32px;
            border-radius:50%;
            background:var(--pink-soft);
            color:var(--pink-hot);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
            font-weight:700;
            border:1px solid #FFD8DC;
        }

        /* =========================================================
           MAIN
        ========================================================= */

        .cf-main{
            flex:1 0 auto;
            width:100%;
            max-width:var(--max);
            margin:0 auto;
            padding:34px 28px 64px;
        }

        /* =========================================================
           SHARED COMPONENTS
        ========================================================= */

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            font-family:inherit;
            font-weight:600;
            font-size:13.5px;
            border-radius:11px;
            padding:10px 18px;
            cursor:pointer;
            border:1px solid transparent;
            transition:
                transform .15s var(--ease),
                box-shadow .15s var(--ease),
                background .15s;
        }

        .btn:hover{
            transform:translateY(-1px);
        }

        .btn-primary{
            background:var(--blue-deep);
            color:#fff;
            box-shadow:0 7px 18px rgba(94,145,196,.18);
        }

        .btn-primary:hover{
            background:#527FAE;
            box-shadow:0 11px 24px rgba(94,145,196,.23);
        }

        .btn-ghost{
            background:#fff;
            color:var(--ink);
            border-color:var(--border);
        }

        .btn-ghost:hover{
            border-color:#E4C9CD;
            background:var(--pink-soft);
        }

        .btn-tint{
            background:var(--blue-soft);
            color:var(--blue-deep);
        }

        .btn-lg{
            padding:13px 22px;
            font-size:14px;
        }

        .btn-pink{
            background:var(--pink-hot);
            color:#fff;
        }

        .btn-blue{
            background:var(--blue-deep);
            color:#fff;
        }

        .btn-ghost.btn-blue{
            background:#fff;
            color:var(--ink);
        }

        .card{
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--r-lg);
            box-shadow:var(--shadow-sm);
        }

        .pill{
            display:inline-flex;
            align-items:center;
            gap:5px;
            font-family:var(--mono);
            font-size:10px;
            letter-spacing:.04em;
            color:var(--blue-deep);
            background:var(--blue-soft);
            padding:4px 9px;
            border-radius:8px;
        }

        .pill.muted{
            color:var(--muted);
            background:#FAFAFA;
            border:1px solid var(--border);
        }

        .pill.warn{
            color:#9A6A16;
            background:#FFF6D9;
        }

        /* PAGE HEADER */

        .phead{
            margin-bottom:26px;
        }

        .phead .ph-k{
            font-family:var(--mono);
            font-size:11px;
            letter-spacing:.16em;
            text-transform:uppercase;
            color:var(--blue-deep);
        }

        .phead h1{
            font-size:30px;
            font-weight:700;
            letter-spacing:-.025em;
            line-height:1.05;
            margin-top:6px;
        }

        .phead p{
            color:var(--muted);
            font-size:15px;
            margin-top:7px;
            max-width:560px;
        }

        /* SECTION HEADER */

        .seclabel{
            display:flex;
            align-items:baseline;
            justify-content:space-between;
            gap:15px;
            margin-bottom:16px;
        }

        .seclabel h2{
            font-size:19px;
            font-weight:700;
            letter-spacing:-.015em;
        }

        .seclabel a{
            font-size:13px;
            font-weight:600;
            color:var(--blue-deep);
        }

        .seclabel a:hover{
            color:var(--pink-hot);
        }

        /* FLASH */

        .flash{
            display:flex;
            align-items:center;
            gap:10px;
            border:1px solid var(--border);
            background:#fff;
            border-radius:var(--r-md);
            padding:13px 16px;
            font-size:14px;
            margin-bottom:22px;
            box-shadow:var(--shadow-sm);
            animation:cfUp .4s var(--ease) both;
        }

        .flash i{
            font-size:18px;
            flex-shrink:0;
        }

        .flash.ok{
            border:1px solid rgba(68,119,166,.35);
            background:#EEF5FB;
            color:#2F5A84;
        }

        .flash.ok i{
            color:#376590;
        }

        .flash.err{
            border:1px solid rgba(178,58,82,.35);
            background:#FDEEF1;
            color:#B23A52;
        }

        .flash.err i{
            color:var(--pink-hot);
        }

        /* EMPTY */

        .emptybox{
            background:#fff;
            border:1px solid var(--border);
            border-radius:var(--r-lg);
            padding:54px 30px;
            text-align:center;
            box-shadow:var(--shadow-sm);
        }

        .emptybox .em{
            font-size:30px;
            display:inline-flex;
            width:60px;
            height:60px;
            align-items:center;
            justify-content:center;
            background:var(--blue-soft);
            color:var(--blue-deep);
            border-radius:50%;
            margin-bottom:14px;
        }

        .emptybox h3{
            font-size:18px;
            font-weight:700;
            margin-bottom:6px;
        }

        .emptybox p{
            color:var(--muted);
            font-size:14px;
            margin-bottom:18px;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .cf-footer{
            border-top:1px solid var(--border);
            background:#fff;
            padding:30px 28px 18px;
            margin-top:auto;
        }

        .cf-footer-inner{
            width:100%;
            max-width:var(--max);
            margin:0 auto;
            display:grid;
            grid-template-columns:1.5fr 1fr 1fr 1fr;
            gap:30px;
        }

        .cf-footer-brand{
            max-width:320px;
        }

        .cf-footer-brand .brand-row{
            display:flex;
            align-items:center;
            gap:9px;
        }

        .cf-footer-brand .brand-row svg{
            width:22px;
            height:22px;
            color:var(--blue-deep);
        }

        .cf-footer-brand b{
            font-size:15px;
            font-weight:700;
            letter-spacing:.16em;
        }

        .cf-footer-brand p{
            color:var(--muted);
            font-size:12.5px;
            line-height:1.6;
            margin-top:9px;
        }

        .cf-footer-col h4{
            font-family:var(--mono);
            font-size:10px;
            letter-spacing:.14em;
            text-transform:uppercase;
            color:var(--faint);
            margin-bottom:10px;
        }

        .cf-footer-col a{
            display:block;
            width:max-content;
            max-width:100%;
            font-size:12.5px;
            color:var(--muted);
            margin-bottom:7px;
            transition:color .15s;
        }

        .cf-footer-col a:hover{
            color:var(--blue-deep);
        }

        .cf-footer-bottom{
            width:100%;
            max-width:var(--max);
            margin:22px auto 0;
            padding-top:14px;
            border-top:1px solid var(--border);
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        }

        .cf-footer-bottom span{
            font-family:var(--mono);
            font-size:10px;
            color:var(--faint);
            letter-spacing:.03em;
        }

        /* =========================================================
           SEARCH
        ========================================================= */

        .cf-search-overlay{
            position:fixed;
            inset:0;
            z-index:300;
            display:none;
            align-items:flex-start;
            justify-content:center;
            padding-top:14vh;
            background:rgba(48,50,58,.28);
            backdrop-filter:blur(4px);
            -webkit-backdrop-filter:blur(4px);
        }

        .cf-search-overlay.show{
            display:flex;
            animation:cfFade .18s var(--ease) both;
        }

        .cf-search-box{
            width:min(560px,92vw);
            background:#fff;
            border:1px solid var(--border);
            border-radius:var(--r-lg);
            box-shadow:var(--shadow-lg);
            overflow:hidden;
            animation:cfUp .22s var(--ease) both;
        }

        .cf-search-box form{
            display:flex;
            align-items:center;
            gap:11px;
            padding:15px 17px;
            border-bottom:1px solid var(--border);
        }

        .cf-search-box form > i{
            font-size:19px;
            color:var(--faint);
            flex:none;
        }

        .cf-search-box input{
            flex:1;
            min-width:0;
            border:0;
            outline:0;
            background:transparent;
            font-family:inherit;
            font-size:16px;
            color:var(--ink);
        }

        .cf-search-box input::placeholder{
            color:var(--faint);
        }

        .cf-search-go{
            font-family:var(--mono);
            font-size:10px;
            color:var(--blue-deep);
            background:var(--blue-soft);
            border:0;
            border-radius:7px;
            padding:6px 9px;
            cursor:pointer;
        }

        .cf-search-hint{
            padding:11px 17px;
            font-size:12px;
            color:var(--muted);
            background:#FFFCFB;
        }

        .cf-search-hint b{
            font-family:var(--mono);
            font-size:10px;
            color:var(--ink);
            background:#fff;
            border:1px solid var(--border);
            border-radius:5px;
            padding:1px 5px;
        }

        /* =========================================================
           ANIMATION
        ========================================================= */

        @keyframes cfFade{
            from{opacity:0;}
            to{opacity:1;}
        }

        @keyframes cfUp{
            from{
                opacity:0;
                transform:translateY(10px);
            }
            to{
                opacity:1;
                transform:none;
            }
        }

        @media(prefers-reduced-motion:reduce){
            *,
            *::before,
            *::after{
                animation:none!important;
                transition:none!important;
                scroll-behavior:auto!important;
            }
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media(max-width:980px){

            .cf-links{
                gap:2px;
            }

            .cf-links a{
                padding:8px 7px;
            }

            .cf-search-trigger{
                min-width:auto;
            }

            .cf-search-trigger .search-text,
            .cf-search-trigger .shortcut{
                display:none;
            }

            .cf-footer-inner{
                grid-template-columns:1fr 1fr 1fr;
            }

            .cf-footer-brand{
                grid-column:1 / -1;
            }
        }

        @media(max-width:760px){

            .cf-nav-inner{
                padding:12px 16px;
            }

            .cf-nav-left{
                gap:0;
            }

            .cf-links{
                display:none;
            }

            .cf-main{
                padding:24px 16px 50px;
            }

            .phead h1{
                font-size:25px;
            }

            .cf-register{
                padding:8px 11px;
            }

            .cf-nav-link{
                display:none;
            }

            .cf-footer{
                padding:26px 16px 16px;
            }

            .cf-footer-inner{
                grid-template-columns:1fr 1fr;
                gap:24px 18px;
            }

            .cf-footer-brand{
                grid-column:1 / -1;
                max-width:none;
            }

            .cf-footer-bottom{
                margin-top:20px;
            }
        }

        @media(max-width:460px){

            .cf-brand-text{
                font-size:14px;
            }

            .cf-search-trigger{
                padding:8px;
            }

            .cf-avatar{
                width:30px;
                height:30px;
            }

            .cf-footer-inner{
                grid-template-columns:1fr;
            }

            .cf-footer-brand{
                grid-column:auto;
            }
        }
    </style>

    <?= $this->renderSection('head') ?>

</head>

<body>

<!-- =========================================================
     REUSABLE COLLABIFY MARK
========================================================= -->

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="cf-mark" viewBox="0 0 100 100">
        <g
            fill="none"
            stroke="currentColor"
            stroke-width="7"
            stroke-linecap="round"
        >
            <line x1="92" y1="50" x2="61.9" y2="60.7"/>
            <line x1="71" y1="86.4" x2="46.7" y2="65.6"/>
            <line x1="29" y1="86.4" x2="34.8" y2="54.9"/>
            <line x1="8" y1="50" x2="38.1" y2="39.3"/>
            <line x1="29" y1="13.6" x2="53.3" y2="34.4"/>
            <line x1="71" y1="13.6" x2="65.2" y2="45.1"/>
        </g>
    </symbol>
</svg>


<?php
$logged  = session('isLoggedIn');
$isUser  = $logged && session('role') === 'user';
$isAdmin = $logged && session('role') === 'admin';
$uri     = uri_string();
?>


<!-- =========================================================
     NAVBAR
========================================================= -->

<header class="cf-nav">

    <div class="cf-nav-inner">

        <div class="cf-nav-left">

            <a href="<?= base_url('/') ?>" class="cf-brand">

                <svg class="cf-brand-mark">
                    <use href="#cf-mark"></use>
                </svg>

                <span class="cf-brand-text">
                    COLLABIFY
                </span>

            </a>


            <nav class="cf-links">

                <a
                    href="<?= base_url('home') ?>"
                    class="<?= $uri === 'home' ? 'on' : '' ?>"
                >
                    Beranda
                </a>

                <a
                    href="<?= base_url('groups') ?>"
                    class="<?= str_contains($uri, 'groups') ? 'on' : '' ?>"
                >
                    Kelompok
                </a>

                <a
                    href="<?= base_url('tasks') ?>"
                    class="<?= str_contains($uri, 'tasks') ? 'on' : '' ?>"
                >
                    Tugas
                </a>

                <a
                    href="<?= base_url('templates') ?>"
                    class="<?= str_contains($uri, 'templates') ? 'on' : '' ?>"
                >
                    Template
                </a>

                <a
                    href="<?= base_url('forum') ?>"
                    class="<?= str_contains($uri, 'forum') ? 'on' : '' ?>"
                >
                    Forum
                </a>

            </nav>

        </div>


        <div class="cf-nav-right">

            <button
                type="button"
                class="cf-search-trigger"
                onclick="cfOpenSearch()"
                aria-label="Cari"
            >
                <i class="ti ti-search" style="font-size:15px"></i>

                <span class="search-text">
                    Cari
                </span>

                <span class="shortcut">
                    Ctrl K
                </span>
            </button>


            <?php if ($logged): ?>

                <?php if ($isAdmin): ?>

                    <a
                        href="<?= base_url('dashboard') ?>"
                        class="cf-nav-link"
                    >
                        Dashboard
                    </a>

                <?php endif; ?>


                <a
                    href="<?= base_url('profil') ?>"
                    class="cf-avatar"
                    title="<?= esc(session('name')) ?>"
                >
                    <?= strtoupper(
                        mb_substr(session('name') ?? 'U', 0, 1)
                    ) ?>
                </a>


                <a
                    href="<?= base_url('logout') ?>"
                    class="cf-nav-link"
                    title="Keluar"
                >
                    <i
                        class="ti ti-logout"
                        style="font-size:17px;vertical-align:-3px"
                    ></i>
                </a>


            <?php else: ?>

                <a
                    href="<?= base_url('login') ?>"
                    class="cf-nav-link"
                >
                    Masuk
                </a>

                <a
                    href="<?= base_url('register') ?>"
                    class="cf-register"
                >
                    Daftar gratis
                </a>

            <?php endif; ?>

        </div>

    </div>

</header>


<!-- =========================================================
     MAIN
========================================================= -->

<main class="cf-main">

    <?php if (session('success')): ?>

        <div class="flash ok">
            <i class="ti ti-circle-check"></i>

            <?= esc(session('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session('error')): ?>

        <div class="flash err">
            <i class="ti ti-alert-triangle"></i>

            <?= esc(session('error')) ?>
        </div>

    <?php endif; ?>


    <?= $this->renderSection('content') ?>

</main>


<!-- =========================================================
     FOOTER
========================================================= -->

<footer class="cf-footer">

    <div class="cf-footer-inner">


        <!-- BRAND -->

        <div class="cf-footer-brand">

            <div class="brand-row">

                <svg>
                    <use href="#cf-mark"></use>
                </svg>

                <b>
                    COLLABIFY
                </b>

            </div>

            <p>
                Ruang kolaborasi untuk mengatur tugas,
                kelompok, template, dan aktivitas kuliah
                dalam satu tempat.
            </p>

        </div>


        <!-- KOLABORASI -->

        <div class="cf-footer-col">

            <h4>
                Kolaborasi
            </h4>

            <a href="<?= base_url('groups') ?>">
                Kelompok
            </a>

            <a href="<?= base_url('tasks') ?>">
                Tugas
            </a>

            <a href="<?= base_url('notes') ?>">
                Catatan
            </a>

        </div>


        <!-- SUMBER DAYA -->

        <div class="cf-footer-col">

            <h4>
                Sumber daya
            </h4>

            <a href="<?= base_url('templates') ?>">
                Template
            </a>

            <a href="<?= base_url('workspaces') ?>">
                Workspace
            </a>

            <a href="<?= base_url('forum') ?>">
                Forum
            </a>

        </div>


        <!-- AKUN -->

        <div class="cf-footer-col">

            <h4>
                Akun
            </h4>

            <a href="<?= base_url($logged ? 'profil' : 'login') ?>">
                <?= $logged ? 'Profil' : 'Masuk' ?>
            </a>

            <a href="<?= base_url($logged ? 'dashboard' : 'register') ?>">
                <?= $logged ? 'Dashboard' : 'Daftar' ?>
            </a>

            <?php if ($logged): ?>

                <a href="<?= base_url('logout') ?>">
                    Logout
                </a>

            <?php endif; ?>

        </div>


    </div>


    <div class="cf-footer-bottom">

        <span>
            COLLABIFY · Platform Kolaborasi Mahasiswa © <?= date('Y') ?>
        </span>

        <span>
            Dibuat untuk kerja bareng.
        </span>

    </div>

</footer>


<!-- =========================================================
     SEARCH OVERLAY
========================================================= -->

<div
    id="cfSearch"
    class="cf-search-overlay"
    role="dialog"
    aria-modal="true"
    aria-label="Pencarian"
>

    <div class="cf-search-box">

        <form
            action="<?= base_url('templates') ?>"
            method="get"
        >

            <i class="ti ti-search"></i>

            <input
                type="text"
                name="q"
                id="cfSearchInput"
                placeholder="Cari template, tugas, atau materi..."
                autocomplete="off"
            >

            <button
                type="submit"
                class="cf-search-go"
            >
                Enter
            </button>

        </form>


        <div class="cf-search-hint">

            Tekan
            <b>Enter</b>
            untuk mencari
            &nbsp;·&nbsp;
            <b>Esc</b>
            untuk menutup

        </div>

    </div>

</div>


<div id="toast"></div>


<script>

    function showToast(msg){

        var toast = document.getElementById('toast');

        if (!toast) return;

        toast.textContent = msg;

        toast.classList.add('show');

        clearTimeout(window._cfToastTimer);

        window._cfToastTimer = setTimeout(function(){

            toast.classList.remove('show');

        }, 2600);

    }


    function cfOpenSearch(){

        var overlay = document.getElementById('cfSearch');

        var input = document.getElementById('cfSearchInput');

        if (!overlay || !input) return;

        overlay.classList.add('show');

        setTimeout(function(){

            input.focus();
            input.select();

        }, 30);

    }


    function cfCloseSearch(){

        var overlay = document.getElementById('cfSearch');

        if (!overlay) return;

        overlay.classList.remove('show');

    }


    document.addEventListener('keydown', function(e){

        if (
            (e.metaKey || e.ctrlKey) &&
            e.key.toLowerCase() === 'k'
        ){

            e.preventDefault();

            cfOpenSearch();

        }


        if (e.key === 'Escape'){

            cfCloseSearch();

        }

    });


    var cfSearchOverlay = document.getElementById('cfSearch');

    if (cfSearchOverlay){

        cfSearchOverlay.addEventListener('click', function(e){

            if (e.target === this){

                cfCloseSearch();

            }

        });

    }

</script>


<?= $this->renderSection('js') ?>

</body>

</html>
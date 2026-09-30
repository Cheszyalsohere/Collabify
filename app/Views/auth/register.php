<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Daftar — COLLABIFY</title>

<link rel="icon" type="image/png" href="<?= base_url('assets/collabify/favicon.png') ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= base_url('assets/tabler/tabler-icons.min.css') ?>">

<style>
:root{
    --blue:#79A9D8;
    --blue-deep:#5E91C4;
    --blue-soft:#EAF3FA;

    --pink:#FF9AA2;
    --pink-hot:#FF677D;
    --pink-soft:#FFF0F1;

    --bg:#FFF8F7;
    --card:#FFFFFF;

    --text:#30323A;
    --muted:#77777D;
    --faint:#A4A4AA;

    --border:#F0DFE1;

    --mono:'Geist Mono',ui-monospace,monospace;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html,
body{
    min-height:100%;
}

body{
    font-family:'Geist',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    background:var(--bg);
    color:var(--text);
    -webkit-font-smoothing:antialiased;
    line-height:1.6;
    overflow-x:hidden;
}

a{
    color:inherit;
    text-decoration:none;
}

/* BACKGROUND */

.page-decoration{
    position:fixed;
    inset:0;
    pointer-events:none;
    overflow:hidden;
    z-index:0;
}

.blob{
    position:absolute;
    border-radius:999px;
}

.blob-blue{
    width:280px;
    height:280px;
    background:rgba(121,169,216,.17);
    top:-120px;
    right:-80px;
}

.blob-pink{
    width:230px;
    height:230px;
    background:rgba(255,154,162,.13);
    bottom:-100px;
    left:-80px;
}

/* TOP */

.top{
    position:relative;
    z-index:2;
    padding:26px 34px;
}

.brand{
    display:inline-flex;
    align-items:center;
    gap:10px;
}

.brand-mark{
    width:30px;
    height:30px;
    border-radius:10px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:var(--pink-soft);
    color:var(--pink-hot);
}

.brand-mark i{
    font-size:18px;
}

.brand-name{
    font-size:15px;
    font-weight:700;
    letter-spacing:.16em;
}

.brand-logo{
    width:34px;
    height:34px;
    object-fit:contain;
    display:block;
}

/* MAIN */

.wrap{
    position:relative;
    z-index:1;

    min-height:calc(100vh - 128px);

    display:flex;
    align-items:center;
    justify-content:center;

    padding:20px 24px 45px;
}

.card{
    width:100%;
    max-width:460px;

    background:rgba(255,255,255,.84);
    border:1px solid rgba(240,223,225,.95);
    border-radius:24px;

    padding:36px 38px 32px;

    box-shadow:
        0 20px 55px rgba(48,50,58,.07),
        inset 0 1px 0 rgba(255,255,255,.8);

    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);
}

/* HEADING */

.k{
    display:inline-flex;
    align-items:center;
    gap:7px;

    font-family:var(--mono);
    font-size:10px;
    font-weight:500;
    letter-spacing:.14em;
    text-transform:uppercase;

    color:var(--pink-hot);
}

.k::before{
    content:"";

    width:6px;
    height:6px;

    border-radius:50%;

    background:var(--blue);
}

h1{
    margin-top:9px;

    font-size:30px;
    line-height:1.2;
    font-weight:700;
    letter-spacing:-.035em;

    color:var(--text);
}

.sub{
    margin-top:8px;
    margin-bottom:25px;

    color:var(--muted);
    font-size:14px;
    line-height:1.6;
}

/* ERROR */

.flash{
    border:1px solid rgba(255,154,162,.35);
    border-left:3px solid var(--pink-hot);

    background:var(--pink-soft);

    border-radius:12px;

    padding:11px 14px;

    color:#B64C59;
    font-size:13px;

    margin-bottom:18px;
}

.flash ul{
    margin:0;
    padding-left:17px;
}

.flash li + li{
    margin-top:3px;
}

/* FORM */

.field{
    margin-bottom:15px;
}

.row2{
    display:flex;
    gap:12px;
}

.row2 .field{
    flex:1;
    min-width:0;
}

label{
    display:block;

    margin-bottom:7px;

    color:var(--text);
    font-size:12.5px;
    font-weight:600;
}

.optional{
    color:var(--faint);
    font-weight:400;
}

input{
    width:100%;
    height:46px;

    padding:0 14px;

    border:1px solid var(--border);
    border-radius:12px;

    background:#fff;

    color:var(--text);
    font-family:inherit;
    font-size:14px;

    outline:none;

    transition:
        border-color .18s ease,
        box-shadow .18s ease;
}

input::placeholder{
    color:var(--faint);
}

input:hover{
    border-color:#E5CBCD;
}

input:focus{
    border-color:var(--pink);
    box-shadow:0 0 0 4px rgba(255,154,162,.14);
}

/* BUTTON */

.btn{
    width:100%;
    height:48px;

    margin-top:7px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    border:0;
    border-radius:13px;

    background:var(--pink-hot);
    color:#fff;

    font-family:inherit;
    font-size:14px;
    font-weight:600;

    cursor:pointer;

    box-shadow:0 8px 20px rgba(255,103,125,.18);

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        background .18s ease;
}

.btn:hover{
    background:#F65D73;
    transform:translateY(-1px);
    box-shadow:0 12px 25px rgba(255,103,125,.24);
}

.btn:active{
    transform:translateY(0);
}

.btn i{
    font-size:17px;
}

/* LOGIN LINK */

.alt{
    margin-top:21px;

    text-align:center;

    color:var(--muted);
    font-size:13.5px;
}

.alt a{
    color:var(--blue-deep);
    font-weight:600;
}

.alt a:hover{
    text-decoration:underline;
    text-underline-offset:3px;
}

/* FOOTER */

.foot{
    position:relative;
    z-index:1;

    padding:0 24px 24px;

    text-align:center;

    font-family:var(--mono);
    font-size:10px;
    letter-spacing:.04em;

    color:var(--faint);
}

/* RESPONSIVE */

@media (max-width:600px){

    .top{
        padding:22px 20px;
    }

    .wrap{
        min-height:calc(100vh - 110px);
        padding:16px 16px 35px;
    }

    .card{
        padding:30px 22px 27px;
        border-radius:20px;
    }

    h1{
        font-size:27px;
    }

    .row2{
        flex-direction:column;
        gap:0;
    }

    .foot{
        padding-bottom:18px;
    }
}
</style>
</head>

<body>

<div class="page-decoration">
    <div class="blob blob-blue"></div>
    <div class="blob blob-pink"></div>
</div>

<div class="top">
    <a href="<?= base_url('/') ?>" class="brand">

        <img src="<?= base_url('assets/collabify/logo.png') ?>" alt="" class="brand-logo" width="34" height="34">

        <span class="brand-name">COLLABIFY</span>

    </a>
</div>

<div class="wrap">

    <div class="card">

        <div class="k">Daftar</div>

        <h1>Buat akun Collabify</h1>

        <div class="sub">
            Mulai berkolaborasi, atur tugas, dan kerjakan proyek bersama.
        </div>

        <?php if (session('errors')): ?>

            <div class="flash">

                <ul>
                    <?php foreach (session('errors') as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>

            </div>

        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">

            <?= csrf_field() ?>

            <div class="field">

                <label for="name">
                    Nama lengkap
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="<?= esc(old('name')) ?>"
                    placeholder="Nama kamu"
                    autocomplete="name"
                    required
                    autofocus
                >

            </div>

            <div class="field">

                <label for="email">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="<?= esc(old('email')) ?>"
                    placeholder="kamu@email.com"
                    autocomplete="email"
                    required
                >

            </div>

            <div class="field">

                <label for="contact">
                    No. kontak
                    <span class="optional">(opsional)</span>
                </label>

                <input
                    id="contact"
                    type="text"
                    name="contact"
                    value="<?= esc(old('contact')) ?>"
                    placeholder="08xxxxxxxxxx"
                    autocomplete="tel"
                >

            </div>

            <div class="row2">

                <div class="field">

                    <label for="password">
                        Kata sandi
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Min. 6 karakter"
                        autocomplete="new-password"
                        required
                    >

                </div>

                <div class="field">

                    <label for="pass_confirm">
                        Ulangi sandi
                    </label>

                    <input
                        id="pass_confirm"
                        type="password"
                        name="pass_confirm"
                        placeholder="••••••••"
                        autocomplete="new-password"
                        required
                    >

                </div>

            </div>

            <button type="submit" class="btn">

                Buat akun

                <i class="ti ti-arrow-right"></i>

            </button>

        </form>

        <div class="alt">

            Sudah punya akun?
            <a href="<?= base_url('login') ?>">Masuk</a>

        </div>

    </div>

</div>

<div class="foot">
    COLLABIFY · Kolaborasi lebih mudah © <?= date('Y') ?>
</div>

</body>
</html>
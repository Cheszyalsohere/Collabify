<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Masuk — COLLABIFY</title>

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

    --yellow:#F9E79F;

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

/* BACKGROUND DECOR */

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
    filter:blur(2px);
}

.blob-blue{
    width:260px;
    height:260px;
    background:rgba(121,169,216,.18);
    top:-110px;
    right:-80px;
}

.blob-pink{
    width:220px;
    height:220px;
    background:rgba(255,154,162,.14);
    bottom:-100px;
    left:-70px;
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
    background:var(--blue-soft);
    color:var(--blue-deep);
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

    padding:30px 24px 50px;
}

.card{
    width:100%;
    max-width:430px;

    background:rgba(255,255,255,.82);
    border:1px solid rgba(240,223,225,.95);
    border-radius:24px;

    padding:38px 38px 34px;

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

    color:var(--blue-deep);
}

.k::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:var(--pink);
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
    margin-bottom:28px;

    color:var(--muted);
    font-size:14px;
    line-height:1.6;
}

/* ALERT */

.flash{
    display:flex;
    align-items:flex-start;
    gap:9px;

    padding:11px 13px;
    margin-bottom:18px;

    background:var(--pink-soft);
    border:1px solid rgba(255,154,162,.35);
    border-radius:12px;

    color:#B64C59;
    font-size:13px;
    line-height:1.5;
}

.flash.ok{
    background:var(--blue-soft);
    border-color:rgba(121,169,216,.35);
    color:var(--blue-deep);
}

.flash i{
    flex-shrink:0;
    margin-top:2px;
    font-size:16px;
}

/* FORM */

.field{
    margin-bottom:16px;
}

label{
    display:block;

    margin-bottom:7px;

    color:var(--text);
    font-size:12.5px;
    font-weight:600;
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
        box-shadow .18s ease,
        transform .18s ease;
}

input::placeholder{
    color:var(--faint);
}

input:hover{
    border-color:#E5CBCD;
}

input:focus{
    border-color:var(--blue);
    box-shadow:0 0 0 4px rgba(121,169,216,.16);
}

/* BUTTON */

.btn{
    width:100%;
    height:48px;

    margin-top:8px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    border:0;
    border-radius:13px;

    background:var(--blue-deep);
    color:#fff;

    font-family:inherit;
    font-size:14px;
    font-weight:600;

    cursor:pointer;

    box-shadow:0 8px 20px rgba(94,145,196,.20);

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        background .18s ease;
}

.btn:hover{
    background:#5488BC;
    transform:translateY(-1px);
    box-shadow:0 12px 25px rgba(94,145,196,.25);
}

.btn:active{
    transform:translateY(0);
}

.btn i{
    font-size:17px;
}

/* REGISTER LINK */

.alt{
    margin-top:22px;

    text-align:center;

    color:var(--muted);
    font-size:13.5px;
}

.alt a{
    color:var(--pink-hot);
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
        padding:20px 16px 40px;
    }

    .card{
        padding:30px 22px 28px;
        border-radius:20px;
    }

    h1{
        font-size:27px;
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

        <div class="k">Masuk</div>

        <h1>Selamat datang kembali</h1>

        <div class="sub">
            Masuk dan lanjutkan kolaborasimu bersama kelompok.
        </div>

        <?php if (session('error')): ?>
            <div class="flash">
                <i class="ti ti-alert-triangle"></i>
                <span><?= esc(session('error')) ?></span>
            </div>
        <?php endif; ?>

        <?php if (session('success')): ?>
            <div class="flash ok">
                <i class="ti ti-circle-check"></i>
                <span><?= esc(session('success')) ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">

            <?= csrf_field() ?>

            <div class="field">
                <label for="email">Email</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="<?= esc(old('email')) ?>"
                    placeholder="kamu@email.com"
                    autocomplete="email"
                    required
                    autofocus
                >
            </div>

            <div class="field">
                <label for="password">Kata sandi</label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan kata sandi"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="btn">
                Masuk
                <i class="ti ti-arrow-right"></i>
            </button>

        </form>

        <div class="alt">
            Belum punya akun?
            <a href="<?= base_url('register') ?>">Daftar gratis</a>
        </div>

    </div>

</div>

<div class="foot">
    COLLABIFY · Kolaborasi lebih mudah © <?= date('Y') ?>
</div>

</body>
</html>
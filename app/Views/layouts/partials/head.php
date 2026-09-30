<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $title ?? 'Collabify' ?></title>

<!-- AdminLTE deps (Bootstrap grid + komponen JS dipertahankan) -->
<link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">

<!-- Collabify type -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/tabler/tabler-icons.min.css') ?>">
<link rel="icon" type="image/png" href="<?= base_url('assets/collabify/favicon.png') ?>">
<link rel="alternate icon" href="<?= base_url('favicon.ico') ?>">

<style>
  /* ════════ Collabify (over AdminLTE) ════════ */
 :root{
      /* ── Collabify Brand ── */
      --forest:#6F9FCB;
      --accent:#A8C7E8;
      --tint:#EAF3FA;

      --paper:#FAF9F5;
      --surface:#FFFFFF;

      --ink:#24262B;
      --muted:#62666D;
      --faint:#6E727A;

      --border:#E4E5E7;
      --border-2:#D9DBDE;

      /* ── Accent colors ── */
      --pink:#F2A7B5;
      --pink-hot:#E98298;
      --pink-soft:#FCE8EC;

      --yellow:#F5D96B;
      --peach:#F7D6D0;

      /* ── Status ── */
      --amber:#8A6417;
      --amber-bg:#FFF4CF;

      /* ── Typography ── */
      --mono:'Geist Mono',ui-monospace,monospace;

      /* ── Radius ── */
      --r-sm:9px;
      --r-md:12px;
      --r-lg:16px;

      /* ── Shadows ── */
      --sh-sm:0 1px 3px rgba(36,38,43,.05);
      --sh-md:0 8px 24px rgba(36,38,43,.07);
      --sh-lg:0 20px 48px rgba(36,38,43,.12);

      /* ── Legacy aliases ── */
      --y2k-blue:#A8C7E8;
      --y2k-blue-deep:#6F9FCB;
      --y2k-pink:#F2A7B5;
      --y2k-pink-hot:#E98298;
      --y2k-pink-soft:#FCE8EC;
      --y2k-cyan:#EAF3FA;
      --y2k-lime:#F5D96B;
      --y2k-yellow:#F5D96B;
      --y2k-peach:#F7D6D0;

      --y2k-bg:#FAF9F5;
      --y2k-surface:#FFFFFF;
      --y2k-ink:#24262B;
      --y2k-ink-soft:#777A80;
      --y2k-border:#E4E5E7;

      --ink-900:#24262B;
      --ink-700:#6F9FCB;
      --ink-500:#777A80;
      --ink-300:#A5A7AC;
      --ink-100:#EAF3FA;
      --ink-50:#FAF9F5;

      --surface:#FFFFFF;
      --border:#E4E5E7;
      --accent-2:#6F9FCB;
      --radius:12px;
  }
  body,.wrapper,.content-wrapper,.main-sidebar,.main-header,.card,.btn,.table,
  input,select,textarea,.modal,.nav-link,.brand-text,h1,h2,h3,h4,h5,h6,p,a,span,div,td,th,label{
    font-family:'Plus Jakarta Sains',system-ui,-apple-system,sans-serif;
  }
  .font-mono,.mono{font-family:var(--mono)!important;}
  body.hold-transition,.wrapper{background:var(--paper)!important;}
  body{color:var(--ink);-webkit-font-smoothing:antialiased;}
  ::selection{background:var(--tint);color:var(--forest);}
  a{color:var(--forest);}

  /* ── Sidebar (light, Notion-style) ── */
  .main-sidebar{background:var(--surface)!important;border-right:1px solid var(--border)!important;box-shadow:none!important;}
  .main-sidebar .brand-link{background:transparent!important;border-bottom:1px solid var(--border)!important;
    padding:15px 16px!important;display:flex;align-items:center;gap:9px;}
  .brand-link{display:flex!important;align-items:center;gap:10px;}
  .brand-link .brand-logo{width:28px;height:28px;object-fit:contain;flex-shrink:0;}
  .brand-link .brand-text{color:var(--ink)!important;font-weight:600!important;letter-spacing:.18em;font-size:15px;}
  .nav-sidebar .nav-header{color:var(--faint)!important;font-family:var(--mono);font-size:10px!important;
    letter-spacing:.14em!important;text-transform:uppercase;padding:16px 18px 7px!important;opacity:1;}
  .nav-sidebar .nav-header::before{content:none!important;}
  .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link,
  .nav-sidebar>.nav-item>.nav-link{color:var(--muted)!important;font-size:13.5px!important;font-weight:500!important;
    border-radius:9px!important;margin:2px 10px!important;padding:9px 12px!important;border:0!important;transform:none!important;transition:background .14s,color .14s;}
  .nav-sidebar>.nav-item>.nav-link:hover{background:var(--paper)!important;color:var(--ink)!important;transform:none!important;}
  .nav-sidebar>.nav-item>.nav-link.active{background:var(--tint)!important;color:var(--forest)!important;
    box-shadow:none!important;transform:none!important;font-weight:500!important;}
  .nav-sidebar .nav-icon{color:inherit!important;font-size:17px!important;margin-right:9px;}
  .brand-link img{filter:none!important;}

  /* ── Topbar ── */
  .main-header.navbar{background:var(--surface)!important;border-bottom:1px solid var(--border)!important;
    box-shadow:none!important;min-height:58px;}
  .main-header .nav-link{color:var(--muted)!important;}
  .main-header .nav-link:hover{color:var(--ink)!important;}

  /* ── Content ── */
  .content-wrapper{background:var(--paper)!important;background-image:none!important;}
  .content-header{padding:24px 28px 6px!important;}
  .content-header h1,.content-header .page-title{font-size:22px!important;font-weight:600!important;letter-spacing:-.02em!important;
    color:var(--ink)!important;text-shadow:none!important;}
  .content{padding:10px 28px 36px!important;}
  .page-sub{color:var(--muted)!important;}

  /* ── Header halaman: judul + subjudul, sama di semua halaman ──────── */
  .content-header .page-eyebrow,.content-header .group-eyebrow,.content-header .task-eyebrow,
  .content-header .notes-eyebrow,.content-header .template-eyebrow,.content-header .workspace-eyebrow,
  .content-header .profile-eyebrow{display:none!important;}
  .content-header h1:not(.cf-title),.content-header .page-title,.content-header .notes-title,
  .content-header .template-title,.content-header .workspace-title,.content-header .profile-title{
    font-size:28px!important;line-height:1.2!important;font-weight:700!important;
    letter-spacing:-.02em!important;color:#30323A!important;margin:0 0 6px!important;}
  .content-header p:not(.cf-sub),.content-header .page-sub,.content-header .notes-subtitle,
  .content-header .template-subtitle,.content-header .workspace-subtitle,.content-header .profile-subtitle{
    font-size:14px!important;line-height:1.5!important;color:#62666D!important;margin:0!important;max-width:65ch;}
  @media (max-width:640px){
    .content-header h1:not(.cf-title),.content-header .page-title,.content-header .notes-title,
    .content-header .template-title,.content-header .workspace-title,.content-header .profile-title{font-size:24px!important;}
  }


  /* ── Cards ── */
  .card,.lis-card{background:var(--surface)!important;border:1px solid var(--border)!important;
    border-radius:var(--r-lg)!important;box-shadow:var(--sh-sm)!important;margin-bottom:20px;transition:box-shadow .18s,transform .18s;}
  .card:hover,.lis-card:hover{box-shadow:var(--sh-md)!important;transform:none;}
  .card-header{background:transparent!important;border-bottom:1px solid var(--border)!important;padding:16px 20px!important;}
  .card-title,.card-header h3{font-size:15px!important;font-weight:600!important;color:var(--ink)!important;letter-spacing:-.01em;}
  .card-body,.lis-card-body{padding:18px 20px!important;}
  .card-tools .btn+.btn{margin-left:7px;}

  /* ── Buttons ── */
  .btn{border-radius:var(--r-sm)!important;font-weight:500!important;font-size:13px!important;
    border:1px solid transparent!important;box-shadow:none!important;padding:8px 15px!important;
    transition:transform .14s,background .14s,box-shadow .14s!important;}
  .btn:hover{transform:translateY(-1px);}
  .btn-sm{font-size:12px!important;padding:6px 11px!important;border-radius:8px!important;}
  .btn-primary,.btn-success{background:#4477A6!important;border-color:#4477A6!important;color:#fff!important;box-shadow:0 4px 12px rgba(111,159,203,.20)!important;}
  .btn-primary:hover,.btn-success:hover{background:#386791!important;border-color:#386791!important;}
  .btn-secondary,.btn-default,.btn-light{background:var(--surface)!important;border-color:var(--border-2)!important;color:var(--ink)!important;}
  .btn-secondary:hover,.btn-default:hover{border-color:var(--faint)!important;background:var(--paper)!important;}
  .btn-info,.btn-warning{background:var(--tint)!important;border-color:transparent!important;color:#376590!important;}
  .btn-danger{background:var(--amber-bg)!important;border-color:transparent!important;color:var(--amber)!important;}
  .btn-danger:hover{background:#ecddc4!important;}

  /* ── Tables ── */
  .table{color:var(--ink)!important;margin-bottom:0;}
  /* Header tabel SELALU putih & modern — netralkan kelas warna bawaan (bg-success/primary/dark/light, text-white) */
  .table thead,.table thead tr,.table thead th{background:transparent!important;background-color:transparent!important;}
  .table thead th{color:var(--faint)!important;font-family:var(--mono)!important;
    font-size:11px!important;letter-spacing:.05em;text-transform:uppercase;font-weight:500!important;
    border-top:0!important;border-bottom:1px solid var(--border)!important;padding:11px 14px!important;}
  .table td,.table th{border-color:var(--border)!important;border-top:1px solid var(--border)!important;
    vertical-align:middle!important;padding:12px 14px!important;font-size:13.5px;}
  .table-hover tbody tr{transition:background .12s;}
  .table-hover tbody tr:hover{background:var(--paper)!important;}
  .table-bordered,.table-bordered td,.table-bordered th{border-color:var(--border)!important;}
  .dataTables_wrapper .dataTables_filter input,.dataTables_wrapper .dataTables_length select{
    border:1px solid var(--border-2)!important;border-radius:8px!important;padding:6px 10px!important;}

  /* ── Forms ── */
  .form-control,.custom-select,select.form-control{border:1px solid var(--border-2)!important;border-radius:var(--r-sm)!important;
    color:var(--ink)!important;background:var(--surface)!important;box-shadow:none!important;height:calc(2.5rem + 2px);font-size:14px;}
  textarea.form-control{height:auto;}
  .form-control:focus,.custom-select:focus{border-color:var(--forest)!important;box-shadow:0 0 0 3px var(--tint)!important;}
  label{font-weight:500!important;color:var(--ink)!important;font-size:13px;margin-bottom:6px;}
  .form-group{margin-bottom:16px;}

  /* ── Modals ── */
  .modal-content{border:1px solid var(--border)!important;border-radius:var(--r-lg)!important;box-shadow:var(--sh-lg)!important;}
  .modal-header{background:transparent!important;border-bottom:1px solid var(--border)!important;padding:16px 20px!important;}
  .modal-title{font-size:16px!important;font-weight:600!important;color:var(--ink)!important;}
  .modal-header .close{color:var(--faint)!important;text-shadow:none!important;opacity:1;font-weight:400;}
  .modal-body{padding:20px!important;} .modal-footer{border-top:1px solid var(--border)!important;padding:14px 20px!important;}
  .modal-backdrop.show{background:rgba(24,36,27,.4)!important;opacity:1!important;}

  /* ── Badges / pills ── */
  .badge{border-radius:999px!important;font-weight:500!important;font-family:var(--mono);font-size:10.5px!important;
    letter-spacing:.02em;padding:.4em .8em!important;}
  .badge-success,.badge-primary{background:var(--tint)!important;color:#376590!important;}
  .btn-outline-success,.btn-outline-primary{color:#376590!important;border-color:#9DB9D4!important;background:transparent!important;}
  .btn-outline-success:hover,.btn-outline-primary:hover{background:var(--tint)!important;color:#2F5A84!important;border-color:#376590!important;}
  .text-success,.text-primary{color:#376590!important;}
  .badge-danger,.badge-warning{background:var(--amber-bg)!important;color:var(--amber)!important;}
  .badge-secondary,.badge-info{background:var(--paper)!important;color:var(--muted)!important;border:1px solid var(--border);}

  /* ── Pagination ── */
  .page-link{color:var(--ink)!important;border-color:var(--border)!important;border-radius:8px!important;margin:0 2px;}
  .page-item.active .page-link{background:var(--forest)!important;border-color:var(--forest)!important;color:#fff!important;}

  /* ── Alerts ── */
  .alert{border:1px solid var(--border)!important;border-radius:var(--r-md)!important;font-size:14px;box-shadow:var(--sh-sm)!important;}
  .alert-success{background:var(--surface)!important;border-left:3px solid var(--forest)!important;color:var(--forest)!important;}
  .alert-danger,.alert-warning{background:var(--surface)!important;border-left:3px solid var(--amber)!important;color:var(--amber)!important;}

  /* ── Footer ── */
  .main-footer{background:var(--surface)!important;border-top:1px solid var(--border)!important;color:var(--muted)!important;font-size:12px;font-family:var(--mono);letter-spacing:.03em;}
  .main-footer a{color:var(--forest)!important;}

  .text-muted{color:var(--muted)!important;}
  .text-dark{color:var(--ink)!important;}
  ::-webkit-scrollbar{width:11px;height:11px;}
  ::-webkit-scrollbar-thumb{background:#dcdcd6;border:3px solid var(--paper);border-radius:10px;}
  ::-webkit-scrollbar-thumb:hover{background:#c8c8c2;}

  /* ══════════ PERMUKAAN — satu sistem untuk semua halaman aplikasi ══════════
     Latar: gradasi lembut biru–pink–lilac seperti landing, dibuat redup supaya isi halaman terbaca.
     Kartu: lembaran putih semi-transparan dengan blur ringan (bukan kaca penuh).
     Kaca sungguhan hanya untuk "chrome" (sidebar & navbar), seperti navbar di landing. */
  body .wrapper{
    background:
      radial-gradient(58% 44% at 4% 0%,    rgba(94,196,255,.24) 0%, rgba(94,196,255,0) 70%),
      radial-gradient(50% 40% at 100% 18%, rgba(255,140,198,.18) 0%, rgba(255,140,198,0) 68%),
      radial-gradient(54% 44% at 42% 100%, rgba(183,156,255,.16) 0%, rgba(183,156,255,0) 70%),
      linear-gradient(180deg,#fff8fc 0%,#f3f9ff 58%,#fef5fc 100%)!important;
  }
  body .content-wrapper{background:transparent!important;background-image:none!important;}

  body .content-wrapper .card,
  body .content-wrapper .lis-card,
  body .content-wrapper .group-card,
  body .content-wrapper .task-card,
  body .content-wrapper .template-card,
  body .content-wrapper .workspace-card,
  body .content-wrapper .profile-card,
  body .content-wrapper .profile-info-card,
  body .content-wrapper .gh-item{
    background:rgba(255,255,255,.80)!important;
    border:1px solid rgba(255,255,255,.95)!important;
    border-radius:16px!important;
    -webkit-backdrop-filter:blur(10px);
    backdrop-filter:blur(10px);
    box-shadow:0 1px 2px rgba(40,60,90,.06),0 4px 8px rgba(40,60,90,.05)!important;
  }
  body .content-wrapper .note-card{
    background:color-mix(in srgb,var(--note-bg,#fff) 72%,#fff)!important;
    border:1px solid rgba(255,255,255,.95)!important;
    border-radius:16px!important;
    box-shadow:0 1px 2px rgba(40,60,90,.06),0 4px 8px rgba(40,60,90,.05)!important;
  }
  body .content-wrapper .group-card:hover,
  body .content-wrapper .task-card:hover,
  body .content-wrapper .template-card:hover,
  body .content-wrapper .workspace-card:hover,
  body .content-wrapper .note-card:hover{
    box-shadow:0 2px 4px rgba(40,60,90,.08),0 8px 8px rgba(40,60,90,.06)!important;
  }
  body .content-wrapper .card-header,
  body .content-wrapper .card-footer{background:transparent!important;border-color:rgba(40,60,90,.08)!important;}
  body .content-wrapper .form-control,
  body .content-wrapper .custom-select{background:#fff!important;border-color:#C9CDD3!important;}
  body .content-wrapper ::placeholder{color:#6E727A!important;opacity:1;}

  /* chrome: kaca sungguhan */
  body .main-sidebar{
    background:rgba(255,255,255,.72)!important;
    -webkit-backdrop-filter:blur(16px) saturate(130%);
    backdrop-filter:blur(16px) saturate(130%);
    border-right:1px solid rgba(255,255,255,.9)!important;
  }
  body .main-header{
    background:rgba(255,255,255,.70)!important;
    -webkit-backdrop-filter:blur(16px) saturate(130%);
    backdrop-filter:blur(16px) saturate(130%);
  }

  /* fokus keyboard yang selalu terlihat */
  body a:focus-visible,body button:focus-visible,body input:focus-visible,body select:focus-visible,
  body textarea:focus-visible,body summary:focus-visible,body [tabindex]:focus-visible{
    outline:3px solid rgba(68,119,166,.6)!important;outline-offset:2px!important;
  }

  /* hormati pengguna yang mematikan animasi */
  @media (prefers-reduced-motion:reduce){
    *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;
      transition-duration:.01ms!important;scroll-behavior:auto!important;}
  }
</style>

<link rel="stylesheet" href="<?= base_url('assets/css/collabify-ui.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/collabify-dark.css') ?>?v=10">

<?= $this->extend('layouts/public_template') ?>

<?= $this->section('head') ?>
<style>
/* =========================================================
   COLLABIFY — APPLE GLASS LANDING
   Visual redesign. Existing backend links are preserved.
========================================================= */
:root{
  --cf-ink:#243044;
  --cf-muted:#7f8aa0;
  --cf-blue:#8fd8ff;
  --cf-pink:#f4a8cf;
  --cf-lilac:#c9c2ff;
  --cf-glass:rgba(255,255,255,.54);
  --cf-glass-strong:rgba(255,255,255,.72);
  --cf-line:rgba(255,255,255,.78);
  --cf-shadow:0 24px 70px rgba(89,119,151,.13);
}

.cf-page{position:relative;overflow:hidden;padding:0 0 70px;color:var(--cf-ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"SF Pro Display",sans-serif;}
.cf-page:before,.cf-page:after{content:"";position:absolute;border-radius:999px;filter:blur(75px);pointer-events:none;z-index:-2;}
.cf-page:before{width:440px;height:440px;left:-160px;top:40px;background:rgba(143,216,255,.27);}
.cf-page:after{width:430px;height:430px;right:-170px;top:170px;background:rgba(244,168,207,.22);}
.cf-orb{position:absolute;width:280px;height:280px;right:20%;top:420px;border-radius:50%;background:rgba(201,194,255,.18);filter:blur(80px);z-index:-2;pointer-events:none;}

/* floating nav */
.cf-nav{position:sticky;top:16px;z-index:50;margin:8px auto 34px;max-width:1120px;padding:9px 12px;border:1px solid var(--cf-line);border-radius:24px;background:rgba(255,255,255,.52);backdrop-filter:blur(24px) saturate(150%);-webkit-backdrop-filter:blur(24px) saturate(150%);box-shadow:0 12px 42px rgba(72,91,118,.10);display:flex;align-items:center;gap:18px;}
.cf-brand{display:flex;align-items:center;gap:9px;text-decoration:none;color:var(--cf-ink);font-weight:750;letter-spacing:-.03em;margin-right:auto;}
.cf-brand img{width:36px;height:36px;object-fit:contain;filter:drop-shadow(0 5px 10px rgba(75,113,150,.12));}
.cf-brand span{font-size:16px;}
.cf-links{display:flex;align-items:center;gap:4px;}
.cf-links a{color:#7b8495;text-decoration:none;font-size:13px;font-weight:650;padding:9px 13px;border-radius:999px;transition:.22s ease;}
.cf-links a:hover,.cf-links a.active{background:rgba(255,255,255,.72);color:#52627b;box-shadow:0 5px 18px rgba(90,111,138,.08);}
.cf-profile{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:linear-gradient(145deg,#b8ebff,#f4bfdc);color:white;font-weight:800;box-shadow:0 8px 22px rgba(120,151,185,.16);}

/* hero */
.cf-hero{text-align:center;padding:18px 20px 8px;}
.cf-greeting{font-size:clamp(28px,4vw,46px);line-height:1.03;letter-spacing:-.055em;font-weight:760;margin:0;color:#66738a;}
.cf-greeting strong{color:#263449;}
.cf-sub{margin:10px auto 0;color:#98a1b1;font-size:14px;max-width:500px;}
.cf-art-wrap{position:relative;width:min(760px,92vw);margin:8px auto 0;min-height:350px;display:grid;place-items:center;}
.cf-art-wrap:before{content:"";position:absolute;width:430px;height:180px;border-radius:50%;background:rgba(130,211,255,.19);filter:blur(48px);top:38%;left:50%;transform:translate(-50%,-50%);}
.cf-art{position:relative;width:min(690px,92vw);max-height:430px;object-fit:contain;filter:drop-shadow(0 24px 28px rgba(83,153,203,.13));animation:cfFloat 5.5s ease-in-out infinite;z-index:2;}
@keyframes cfFloat{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-8px) rotate(-.35deg)}}
.cf-spark{position:absolute;border:1.5px solid rgba(255,255,255,.9);background:rgba(255,255,255,.35);box-shadow:0 0 24px rgba(255,255,255,.7);transform:rotate(45deg);animation:cfSpark 3.8s ease-in-out infinite;}
.cf-spark.s1{width:12px;height:12px;left:11%;top:25%;}.cf-spark.s2{width:9px;height:9px;right:13%;top:22%;animation-delay:1s}.cf-spark.s3{width:8px;height:8px;right:22%;bottom:14%;animation-delay:1.8s}
@keyframes cfSpark{0%,100%{opacity:.35;transform:rotate(45deg) scale(.8)}50%{opacity:1;transform:rotate(45deg) scale(1.15)}}

.cf-actions{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin-top:-4px;position:relative;z-index:3;}
.cf-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 19px;border-radius:16px;text-decoration:none;font-size:13px;font-weight:750;border:1px solid rgba(255,255,255,.85);transition:.22s ease;}
.cf-btn:hover{transform:translateY(-2px);box-shadow:0 13px 30px rgba(89,116,148,.13);}
.cf-btn.primary{background:linear-gradient(135deg,rgba(164,226,255,.9),rgba(242,190,218,.88));color:#4e6077;box-shadow:0 10px 25px rgba(116,168,201,.16);}
.cf-btn.secondary{background:rgba(255,255,255,.48);color:#69778c;backdrop-filter:blur(16px);}

/* section heading */
.cf-section{max-width:1120px;margin:58px auto 0;padding:0 8px;}
.cf-heading{display:flex;align-items:end;justify-content:space-between;margin-bottom:14px;}
.cf-heading h2{font-size:20px;letter-spacing:-.04em;margin:0;color:#3c4a61;}
.cf-heading p{font-size:11px;color:#a0a8b7;margin:4px 0 0;}
.cf-heading a{font-size:12px;color:#7892ae;text-decoration:none;font-weight:700;}

/* recently visited */
.cf-recent-shell{position:relative;overflow:hidden;padding:12px 2px 22px;}
.cf-recent-track{display:flex;align-items:center;gap:13px;overflow-x:auto;scroll-snap-type:x mandatory;padding:12px 28px 24px;scrollbar-width:none;cursor:grab;}
.cf-recent-track::-webkit-scrollbar{display:none;}
.cf-recent-track.dragging{cursor:grabbing;scroll-snap-type:none;}
.cf-recent-card{position:relative;flex:0 0 230px;min-height:154px;scroll-snap-align:center;border:1px solid rgba(255,255,255,.82);border-radius:26px;background:rgba(255,255,255,.43);backdrop-filter:blur(22px) saturate(145%);-webkit-backdrop-filter:blur(22px) saturate(145%);box-shadow:0 16px 42px rgba(83,106,136,.10);padding:19px;display:flex;flex-direction:column;justify-content:space-between;text-decoration:none;color:inherit;transition:transform .28s cubic-bezier(.2,.8,.2,1),opacity .28s ease,filter .28s ease,box-shadow .28s ease;transform-origin:center center;}
.cf-recent-card:not(.is-focus){transform:scale(.91);opacity:.68;filter:saturate(.78);}
.cf-recent-card.is-focus{transform:scale(1.035);opacity:1;box-shadow:0 22px 58px rgba(83,106,136,.16);}
.cf-card-top{display:flex;justify-content:space-between;align-items:center;gap:8px;color:#9aa5b5;font-size:10px;font-weight:750;text-transform:uppercase;letter-spacing:.08em;}
.cf-card-icon{width:31px;height:31px;border-radius:11px;display:grid;place-items:center;background:rgba(255,255,255,.66);color:#81b8da;box-shadow:0 7px 17px rgba(90,120,150,.09);}
.cf-card-title{font-size:17px;line-height:1.1;letter-spacing:-.035em;color:#43526a;font-weight:760;max-width:180px;}
.cf-card-meta{font-size:11px;color:#9aa4b3;margin-top:6px;}
.cf-recent-arrow{position:absolute;top:50%;transform:translateY(-50%);width:38px;height:38px;border-radius:50%;border:1px solid rgba(255,255,255,.85);background:rgba(255,255,255,.62);backdrop-filter:blur(15px);color:#78889d;box-shadow:0 10px 25px rgba(70,95,120,.10);z-index:4;cursor:pointer;}
.cf-recent-arrow.left{left:0}.cf-recent-arrow.right{right:0}

/* lower grid */
.cf-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:16px;align-items:stretch;}
.cf-glass{border:1px solid rgba(255,255,255,.84);background:rgba(255,255,255,.46);backdrop-filter:blur(24px) saturate(145%);-webkit-backdrop-filter:blur(24px) saturate(145%);box-shadow:var(--cf-shadow);border-radius:28px;}

/* calendar */
.cf-calendar{padding:21px;}
.cf-cal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;}
.cf-cal-title{font-weight:780;color:#405069;letter-spacing:-.035em;}
.cf-cal-month{font-size:11px;color:#9ca6b5;margin-top:3px;}
.cf-cal-nav{display:flex;gap:5px}.cf-cal-nav button{border:0;background:rgba(255,255,255,.55);width:30px;height:30px;border-radius:10px;color:#8190a5;cursor:pointer;}
.cf-week,.cf-days{display:grid;grid-template-columns:repeat(7,1fr);gap:5px;text-align:center;}
.cf-week{margin-bottom:7px;color:#a0a8b5;font-size:10px;font-weight:750;}
.cf-day{min-height:39px;border-radius:13px;display:grid;place-items:center;position:relative;color:#69778d;font-size:11px;cursor:pointer;transition:.18s ease;}
.cf-day:hover{background:rgba(255,255,255,.72);transform:translateY(-1px);}
.cf-day.today{background:linear-gradient(145deg,#b8eaff,#f3c5df);color:#fff;font-weight:800;box-shadow:0 9px 20px rgba(116,175,209,.16);}
.cf-day.has-event:after{content:"";position:absolute;bottom:5px;width:4px;height:4px;border-radius:50%;background:#9fdcff;}
.cf-agenda{margin-top:17px;padding-top:15px;border-top:1px solid rgba(128,145,165,.12);}
.cf-agenda-label{font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:#a0a8b5;font-weight:800;margin-bottom:8px;}
.cf-agenda-item{display:flex;gap:11px;align-items:center;padding:9px 0;}
.cf-agenda-dot{width:8px;height:8px;border-radius:50%;background:#f2b8d8;box-shadow:0 0 0 5px rgba(242,184,216,.12);flex:0 0 auto;}
.cf-agenda-item strong{display:block;font-size:12px;color:#526077}.cf-agenda-item span{display:block;font-size:10px;color:#a0a8b5;margin-top:2px;}

/* deadlines deck */
.cf-deadlines{padding:21px;position:relative;overflow:hidden;min-height:348px;}
.cf-deadline-head{display:flex;justify-content:space-between;align-items:start;position:relative;z-index:5;}
.cf-deadline-head h3{margin:0;font-size:18px;letter-spacing:-.04em;color:#45536a}.cf-deadline-head p{font-size:10px;color:#a0a8b5;margin:4px 0 0;}
.cf-deadline-count{padding:7px 10px;border-radius:999px;background:rgba(255,255,255,.54);font-size:10px;color:#9a7087;}
.cf-deck{position:relative;height:236px;margin-top:16px;}
.cf-deck-card{position:absolute;inset:8px 0 0;border-radius:23px;border:1px solid rgba(255,255,255,.82);background:linear-gradient(145deg,rgba(255,202,226,.83),rgba(246,225,239,.64));box-shadow:0 18px 45px rgba(170,111,143,.12);padding:19px;display:flex;flex-direction:column;justify-content:space-between;transform-origin:70% 50%;transition:transform .46s cubic-bezier(.2,.8,.2,1),opacity .35s ease;user-select:none;cursor:pointer;}
.cf-deck-card:nth-child(1){z-index:5}.cf-deck-card:nth-child(2){z-index:4;transform:translate(9px,10px) scale(.96) rotate(2deg);opacity:.7}.cf-deck-card:nth-child(3){z-index:3;transform:translate(17px,20px) scale(.92) rotate(4deg);opacity:.45}.cf-deck-card:nth-child(n+4){z-index:2;transform:translate(23px,28px) scale(.88) rotate(6deg);opacity:.25;}
.cf-deck-card.swiping{transform:translate(125%,-18%) rotate(13deg)!important;opacity:0!important;}
.cf-deck-card .type{font-size:9px;letter-spacing:.11em;text-transform:uppercase;color:#b18098;font-weight:850;}.cf-deck-card h4{font-size:22px;line-height:1.05;letter-spacing:-.05em;color:#6d5060;margin:8px 0 0;max-width:240px;}.cf-deck-card .due{font-size:11px;color:#9a7187;}.cf-deck-card .swipe{display:inline-flex;align-items:center;gap:7px;width:max-content;padding:9px 13px;border-radius:12px;background:rgba(255,255,255,.58);border:1px solid rgba(255,255,255,.75);font-size:10px;font-weight:800;color:#8d6178;box-shadow:0 7px 18px rgba(163,108,135,.09);cursor:grab;}
.cf-deck-card .swipe:active{cursor:grabbing;}

/* forum */
.cf-forum{margin-top:16px;padding:19px 21px;display:flex;align-items:center;gap:15px;}
.cf-forum-icon{width:46px;height:46px;border-radius:16px;display:grid;place-items:center;background:linear-gradient(145deg,rgba(173,226,255,.7),rgba(247,196,222,.7));color:white;box-shadow:0 10px 24px rgba(117,163,194,.12);flex:0 0 auto;}
.cf-forum-body{min-width:0;flex:1}.cf-forum-body .eyebrow{font-size:9px;text-transform:uppercase;letter-spacing:.1em;color:#9da7b5;font-weight:800}.cf-forum-body strong{display:block;font-size:13px;color:#526078;margin-top:4px}.cf-forum-body span{display:block;font-size:10px;color:#9ca6b5;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.cf-forum-open{font-size:11px;color:#7793af;font-weight:800;text-decoration:none;white-space:nowrap;}

@media(max-width:820px){.cf-nav{margin-left:10px;margin-right:10px}.cf-links a:nth-child(3){display:none}.cf-grid{grid-template-columns:1fr}.cf-recent-card{flex-basis:205px}.cf-art-wrap{min-height:280px}.cf-art{max-height:310px}}
@media(max-width:560px){.cf-nav{gap:8px;padding:7px 8px}.cf-links a{font-size:11px;padding:8px}.cf-brand span{display:none}.cf-greeting{font-size:30px}.cf-art-wrap{min-height:220px}.cf-art{width:100%}.cf-section{margin-top:42px}.cf-recent-track{padding-left:16px;padding-right:16px}.cf-recent-arrow{display:none}.cf-forum{align-items:flex-start}.cf-forum-open{display:none}}

/* =========================================================
   FINAL COLLABIFY LANDING TUNING V3
   - only Collabify navbar on this page
   - inactive nav = pink, active nav = blue, no gradients
   - deadline left / calendar right on one row
   - deadline uses the pink deck directly, no white inner panel
   - calendar controls are solid blue
========================================================= */
.cf-page{max-width:1180px;margin:0 auto;}
/* Legacy LIBRIS chrome is removed when this page is present. */
body:has(.cf-page) .main-header,
body:has(.cf-page) .main-sidebar,
body:has(.cf-page) .main-footer{display:none!important;}
body:has(.cf-page) .content-wrapper{margin-left:0!important;padding-top:0!important;}
/* Landing punya navbar & footer sendiri: sembunyikan yang dari layout publik supaya tidak dobel. */
body:has(.cf-page) > header.cf-nav,
body:has(.cf-page) > footer.cf-footer{display:none!important;}

.cf-nav{position:relative;top:auto;margin:14px auto 34px;max-width:1120px;min-height:58px;}
.cf-links{position:absolute;left:50%;transform:translateX(-50%);gap:5px;}
.cf-links a{position:relative;color:#d989ad;background:rgba(255,205,226,.24);transition:transform .2s ease,background .2s ease,color .2s ease,box-shadow .2s ease;}
.cf-links a:hover{transform:translateY(-1px);color:#4f89ad;background:#c8ecff;box-shadow:0 8px 20px rgba(108,174,211,.16);}
.cf-links a.active{color:#fff;background:#91d8ff;box-shadow:0 8px 22px rgba(108,174,211,.22),inset 0 1px 0 rgba(255,255,255,.35);}
.cf-profile{margin-left:auto;transition:transform .2s ease,box-shadow .2s ease;}
.cf-profile:hover{transform:scale(1.06);box-shadow:0 10px 28px rgba(120,151,185,.25);}

/* Main dashboard: deadline/task left + calendar right, same row. */
.cf-grid{display:grid;grid-template-columns:minmax(0,.92fr) minmax(0,1.08fr);gap:22px;align-items:stretch;}
.cf-page .cf-deadlines{grid-column:auto;grid-row:auto;}
.cf-page .cf-calendar{grid-column:auto;grid-row:auto;}

/* Pink deadline deck: remove the extra white card around it. */
.cf-deadlines{min-height:390px;background:transparent!important;border:0!important;box-shadow:none!important;padding:4px 8px 10px!important;overflow:visible;}
.cf-deadline-head{padding:0 2px;}
.cf-deadline-head h3{font-size:20px;color:#45536a;}
.cf-deck{height:270px;width:min(100%,430px);margin:20px auto 0;}
.cf-deck-card{inset:0;border-radius:26px;padding:22px;background:#f7bddb;border:1px solid rgba(255,255,255,.72);box-shadow:0 20px 48px rgba(190,111,151,.18);}
.cf-deck-card:nth-child(2){transform:translate(8px,10px) scale(.96) rotate(2deg);}
.cf-deck-card:nth-child(3){transform:translate(16px,20px) scale(.92) rotate(4deg);}
.cf-deck-card .type{color:#a76887;}
.cf-deck-card h4{color:#65475a;}
.cf-deck-card .due{color:#98657e;}
.cf-deck-card .swipe{background:rgba(255,255,255,.42);border-color:rgba(255,255,255,.65);color:#8a5570;}

/* Calendar controls = one blue, no gradient. */
.cf-page .cf-calendar{background:rgba(255,255,255,.42);}
.cf-page .cf-day.today{background:#91d8ff;border-color:rgba(255,255,255,.9);color:#fff;}
.cf-page .cf-day:hover{background:#dff5ff;border-color:rgba(145,216,255,.55);}
.cf-cal-nav button{border:0!important;background:#91d8ff!important;color:#fff!important;transition:.2s ease;}
.cf-cal-nav button:hover{background:#72c9f7!important;transform:translateY(-1px);}

/* Keep forum beneath the two upper cards. */
.cf-forum{margin-top:18px;}

@media(max-width:820px){
  .cf-links{position:static;transform:none;margin-left:auto;}
  .cf-grid{grid-template-columns:1fr;}
  .cf-page .cf-deadlines,.cf-page .cf-calendar{grid-column:auto;grid-row:auto;}
  .cf-deck{width:92%;}
}

/* =========================================================
   LATAR GRADASI — lebih hidup
   Sebelumnya hanya dua bola blur transparan (~25% opasitas) yang terpotong
   overflow:hidden sehingga warnanya pudar dan tepinya terlihat. Sekarang
   gradasi memenuhi seluruh layar (tidak terpotong) dengan warna lebih jenuh.
========================================================= */
body:has(.cf-page){
  background:
    radial-gradient(58% 52% at 8% 10%,  rgba(94,196,255,.62) 0%, rgba(94,196,255,0) 66%),
    radial-gradient(52% 50% at 96% 30%, rgba(255,140,198,.52) 0%, rgba(255,140,198,0) 64%),
    radial-gradient(48% 46% at 50% 96%, rgba(183,156,255,.42) 0%, rgba(183,156,255,0) 66%),
    radial-gradient(40% 36% at 78% 88%, rgba(255,190,150,.28) 0%, rgba(255,190,150,0) 68%),
    linear-gradient(180deg,#fff4fa 0%,#eef7ff 55%,#fdf1fb 100%);
}
.cf-page{overflow:visible;overflow-x:clip;}
.cf-page:before,.cf-page:after,.cf-orb{display:none;}
/* kaca tetap terbaca di atas gradasi yang lebih pekat */
.cf-page .cf-nav,.cf-page .cf-glass,.cf-page .cf-recent-card{background:rgba(255,255,255,.62);}

/* =========================================================
   NAVBAR PILL — perbaikan kotak di belakang teks saat hover
   Penyebab: navbar memakai backdrop-filter, sedangkan link di dalamnya
   di-translateY saat hover (dan wadahnya translateX). Kombinasi itu membuat
   teks dirender di layer terpisah sehingga muncul kotak persegi di belakang
   huruf. Hover sekarang tanpa transform; warna & latar didefinisikan sekali.
========================================================= */
.cf-page .cf-links{left:0;right:0;transform:none;justify-content:center;pointer-events:none;} /* pusat tanpa transform */
.cf-page .cf-links a{pointer-events:auto;}
.cf-page .cf-links a{
  transform:none!important;
  will-change:auto;
  -webkit-font-smoothing:antialiased;
  text-shadow:none;
  background-clip:padding-box;
  transition:background-color .2s ease,color .2s ease,box-shadow .2s ease;
}
.cf-page .cf-links a:hover{
  transform:none!important;
  color:#4f89ad;
  background:#c8ecff;
  box-shadow:0 8px 20px rgba(108,174,211,.16);
}
.cf-page .cf-links a.active,.cf-page .cf-links a.active:hover{
  color:#fff;
  background:#91d8ff;
  box-shadow:0 8px 22px rgba(108,174,211,.22),inset 0 1px 0 rgba(255,255,255,.35);
}
@media(max-width:820px){.cf-page .cf-links{position:static;left:auto;right:auto;justify-content:flex-start;pointer-events:auto;}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="cf-page">
  <div class="cf-orb"></div>

  <nav class="cf-nav">
    <a class="cf-brand" href="<?= base_url('/') ?>">
      <img src="<?= base_url('assets/collabify/logo.png') ?>" alt="Collabify">
      <span>Collabify</span>
    </a>
    <div class="cf-links">
      <a class="active" href="<?= base_url('/') ?>">Home</a>
      <a href="<?= base_url('spin') ?>">Tools</a>
      <a href="<?= base_url('templates') ?>">Templates</a>
      <a href="<?= base_url('forum') ?>">Forum</a>
    </div>
    <div class="cf-profile"><?= strtoupper(substr((string)(session()->get('name') ?? 'S'),0,1)) ?></div>
  </nav>

  <section class="cf-hero">
    <h1 class="cf-greeting">Hi, <strong><?= esc(session()->get('name') ?? 'there') ?>!</strong><br>How was your day?</h1>
    <p class="cf-sub">A soft little space to keep your tasks, groups, templates, and conversations together.</p>

    <div class="cf-art-wrap">
      <span class="cf-spark s1"></span><span class="cf-spark s2"></span><span class="cf-spark s3"></span>
      <img class="cf-art" src="<?= base_url('assets/collabify/lets-collab.png') ?>" alt="Let's Collab Together!">
    </div>

    <div class="cf-actions">
      <a class="cf-btn primary" href="<?= base_url('tasks') ?>">+ Buat Tugas Baru</a>
      <a class="cf-btn secondary" href="<?= base_url('groups') ?>">Lihat Kelompokku</a>
    </div>
  </section>

  <section class="cf-section">
    <div class="cf-heading">
      <div><h2>Recently visited</h2><p>Semua hal yang baru saja kamu buka.</p></div>
      <a href="#" id="cfClearRecent">Clear</a>
    </div>

    <div class="cf-recent-shell">
      <button class="cf-recent-arrow left" type="button" id="cfRecentPrev">‹</button>
      <div class="cf-recent-track" id="cfRecentTrack">
        <a class="cf-recent-card" href="<?= base_url('forum') ?>" data-recent-type="forum" data-recent-title="Forum kelompok" data-recent-url="<?= base_url('forum') ?>">
          <div class="cf-card-top"><span>Forum</span><span class="cf-card-icon">◌</span></div><div><div class="cf-card-title">Ruang diskusi kelompok</div><div class="cf-card-meta">Buka forum →</div></div>
        </a>
        <a class="cf-recent-card" href="<?= base_url('tasks') ?>" data-recent-type="task" data-recent-title="Tugas" data-recent-url="<?= base_url('tasks') ?>">
          <div class="cf-card-top"><span>Task</span><span class="cf-card-icon">✓</span></div><div><div class="cf-card-title">Tugas yang sedang dikerjakan</div><div class="cf-card-meta">Lihat tugas →</div></div>
        </a>
        <a class="cf-recent-card" href="<?= base_url('templates') ?>" data-recent-type="template" data-recent-title="Templates" data-recent-url="<?= base_url('templates') ?>">
          <div class="cf-card-top"><span>Template</span><span class="cf-card-icon">✦</span></div><div><div class="cf-card-title">Template kolaborasi</div><div class="cf-card-meta">Buka templates →</div></div>
        </a>
        <a class="cf-recent-card" href="<?= base_url('spin') ?>" data-recent-type="spin" data-recent-title="Spin" data-recent-url="<?= base_url('spin') ?>">
          <div class="cf-card-top"><span>Tools</span><span class="cf-card-icon">✧</span></div><div><div class="cf-card-title">Spin untuk menentukan sesuatu</div><div class="cf-card-meta">Buka spin →</div></div>
        </a>
      </div>
      <button class="cf-recent-arrow right" type="button" id="cfRecentNext">›</button>
    </div>
  </section>

  <section class="cf-section">
    <div class="cf-grid">
      <div class="cf-glass cf-deadlines">
        <div class="cf-deadline-head"><div><h3>Upcoming deadlines</h3><p>Tap a card or swipe it to finish.</p></div><span class="cf-deadline-count" id="cfDeadlineCount">3 deadlines</span></div>
        <div class="cf-deck" id="cfDeadlineDeck">
          <div class="cf-deck-card" data-task-id="1"><div><div class="type">Nearest deadline</div><h4>Proposal Penelitian Masinfo</h4></div><div><div class="due">Due today · 23:59</div><button class="swipe" type="button">↗ Swipe to mark</button></div></div>
          <div class="cf-deck-card" data-task-id="2"><div><div class="type">Next deadline</div><h4>Presentasi kelompok</h4></div><div><div class="due">Tomorrow · 16:00</div><button class="swipe" type="button">↗ Swipe to mark</button></div></div>
          <div class="cf-deck-card" data-task-id="3"><div><div class="type">Next deadline</div><h4>Review jurnal</h4></div><div><div class="due">In 2 days · 20:00</div><button class="swipe" type="button">↗ Swipe to mark</button></div></div>
        </div>
      </div>

      <div class="cf-glass cf-calendar">
        <div class="cf-cal-head"><div><div class="cf-cal-title">Your calendar</div><div class="cf-cal-month" id="cfMonthLabel"></div></div><div class="cf-cal-nav"><button type="button" id="cfPrevMonth">‹</button><button type="button" id="cfNextMonth">›</button></div></div>
        <div class="cf-week"><span>M</span><span>S</span><span>S</span><span>R</span><span>K</span><span>J</span><span>S</span></div>
        <div class="cf-days" id="cfCalendarDays"></div>
        <div class="cf-agenda"><div class="cf-agenda-label" id="cfAgendaLabel">Today</div><div id="cfAgendaList"><div class="cf-agenda-item"><i class="cf-agenda-dot"></i><div><strong>No scheduled activity</strong><span>Aktivitas dari task dan forum akan muncul di sini.</span></div></div></div></div>
      </div>
    </div>

    <div class="cf-glass cf-forum">
      <div class="cf-forum-icon">☷</div>
      <div class="cf-forum-body"><div class="eyebrow">Forum activity</div><strong>Kelompokmu sedang aktif</strong><span>Aktivitas forum terbaru akan tampil di sini setelah backend activity feed disambungkan.</span></div>
      <a class="cf-forum-open" href="<?= base_url('forum') ?>">Open forum →</a>
    </div>
  </section>
</div>

<script>
(function(){
  document.body.classList.add('collabify-page');
  document.querySelectorAll('.main-header, .main-sidebar, .main-footer').forEach(function(el){ el.style.display='none'; });
  /* Recently visited — visual interaction now; global persistence hook is ready. */
  const track=document.getElementById('cfRecentTrack');
  const cards=[...document.querySelectorAll('.cf-recent-card')];
  const prev=document.getElementById('cfRecentPrev');
  const next=document.getElementById('cfRecentNext');
  const clear=document.getElementById('cfClearRecent');
  let drag=false,startX=0,scrollStart=0;

  function focusCard(){
    const center=track.scrollLeft+track.clientWidth/2;
    let best=null,dist=Infinity;
    cards.forEach(c=>{const cc=c.offsetLeft+c.offsetWidth/2;const d=Math.abs(cc-center);if(d<dist){dist=d;best=c;}});
    cards.forEach(c=>c.classList.toggle('is-focus',c===best));
  }
  track.addEventListener('scroll',()=>requestAnimationFrame(focusCard),{passive:true});
  cards.forEach(c=>c.addEventListener('mouseenter',()=>cards.forEach(x=>x.classList.toggle('is-focus',x===c))));
  prev.addEventListener('click',()=>track.scrollBy({left:-260,behavior:'smooth'}));
  next.addEventListener('click',()=>track.scrollBy({left:260,behavior:'smooth'}));
  track.addEventListener('pointerdown',e=>{drag=true;startX=e.clientX;scrollStart=track.scrollLeft;track.classList.add('dragging');track.setPointerCapture(e.pointerId)});
  track.addEventListener('pointermove',e=>{if(!drag)return;track.scrollLeft=scrollStart-(e.clientX-startX)});
  track.addEventListener('pointerup',()=>{drag=false;track.classList.remove('dragging');focusCard()});
  clear.addEventListener('click',e=>{e.preventDefault();localStorage.removeItem('collabify_recent');});
  focusCard();

  /* Deadline deck — swipe/click rotates the card and marks the current item visually complete. */
  const deck=document.getElementById('cfDeadlineDeck');
  const count=document.getElementById('cfDeadlineCount');
  let cardsDeck=[...deck.querySelectorAll('.cf-deck-card')];
  function refreshDeck(){
    cardsDeck.forEach((c,i)=>{c.style.zIndex=String(10-i);c.classList.remove('swiping');if(i===0){c.style.transform='';c.style.opacity='';}else{c.style.transform=`translate(${i*9}px,${i*10}px) scale(${1-i*.04}) rotate(${i*2}deg)`;c.style.opacity=String(Math.max(.22,1-i*.24));}});
    count.textContent=cardsDeck.length+' deadlines';
  }
  function completeTop(){
    if(!cardsDeck.length)return;
    const top=cardsDeck[0]; top.classList.add('swiping');
    setTimeout(()=>{top.remove();cardsDeck.shift();refreshDeck()},360);
  }
  deck.addEventListener('click',e=>{if(e.target.closest('.swipe')){e.preventDefault();completeTop();}});
  let sx=0,sy=0,draggingCard=false;
  deck.addEventListener('pointerdown',e=>{const top=cardsDeck[0];if(!top||!top.contains(e.target))return;draggingCard=true;sx=e.clientX;sy=e.clientY;top.setPointerCapture(e.pointerId);});
  deck.addEventListener('pointerup',e=>{if(!draggingCard)return;draggingCard=false;if(Math.abs(e.clientX-sx)>70)completeTop();});
  refreshDeck();

  /* Calendar */
  const days=document.getElementById('cfCalendarDays'),label=document.getElementById('cfMonthLabel'),agendaLabel=document.getElementById('cfAgendaLabel');
  let view=new Date();view.setDate(1);
  function renderCal(){
    const y=view.getFullYear(),m=view.getMonth();
    label.textContent=new Intl.DateTimeFormat('id-ID',{month:'long',year:'numeric'}).format(view);
    days.innerHTML='';
    const first=(new Date(y,m,1).getDay()+6)%7, total=new Date(y,m+1,0).getDate(),today=new Date();
    for(let i=0;i<first;i++)days.insertAdjacentHTML('beforeend','<span></span>');
    for(let d=1;d<=total;d++){
      const el=document.createElement('button');el.type='button';el.className='cf-day';el.textContent=d;
      if(y===today.getFullYear()&&m===today.getMonth()&&d===today.getDate())el.classList.add('today');
      if([3,8,15,21,27].includes(d))el.classList.add('has-event');
      el.addEventListener('click',()=>{agendaLabel.textContent=`${d} ${new Intl.DateTimeFormat('id-ID',{month:'long'}).format(view)}`;});days.appendChild(el);
    }
  }
  document.getElementById('cfPrevMonth').addEventListener('click',()=>{view.setMonth(view.getMonth()-1);renderCal()});
  document.getElementById('cfNextMonth').addEventListener('click',()=>{view.setMonth(view.getMonth()+1);renderCal()});
  renderCal();
})();
</script>
<?= $this->endSection() ?>

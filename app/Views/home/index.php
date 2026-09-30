<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<style>
/* =========================================================
   COLLABIFY HOME
   ========================================================= */

.home-page{
    --home-blue:#79A9D8;
    --home-blue-deep:#376590;
    --home-blue-soft:#EAF3FA;

    --home-pink:#FF9AA2;
    --home-pink-hot:#B23A52;
    --home-pink-soft:#FFF0F1;

    --home-yellow:#F9E79F;
    --home-yellow-soft:#FFF9DF;

    --home-bg:#FFF8F7;
    --home-card:#FFFFFF;

    --home-text:#30323A;
    --home-muted:#62666D;
    --home-faint:#6E727A;

    --home-border:#F0DFE1;

    color:var(--home-text);
}


/* =========================================================
   HERO
   ========================================================= */

.home-hero{
    position:relative;

    display:grid;
    grid-template-columns:minmax(0,1.35fr) minmax(280px,.65fr);
    gap:24px;

    padding:22px 0 28px;

    align-items:stretch;
}

.home-hero-main{
    position:relative;

    min-height:300px;

    display:flex;
    flex-direction:column;
    justify-content:center;

    padding:34px 6px;
}

.home-kicker{
    display:inline-flex;
    align-items:center;
    gap:8px;

    width:max-content;

    font-family:var(--mono);
    font-size:10px;
    font-weight:500;
    letter-spacing:.15em;
    text-transform:uppercase;

    color:var(--home-blue-deep);
}

.home-kicker::before{
    content:"";

    width:7px;
    height:7px;

    border-radius:50%;

    background:var(--home-pink);
}

.home-hero h1{
    max-width:680px;

    margin:11px 0 12px;

    font-size:46px;
    line-height:1.03;
    letter-spacing:-.045em;
    font-weight:700;

    color:var(--home-text);
}

.home-hero h1 .accent{
    color:var(--home-blue-deep);
}

.home-hero-desc{
    max-width:590px;

    color:var(--home-muted);

    font-size:15px;
    line-height:1.7;
}

.home-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;

    margin-top:24px;
}

.home-btn{
    min-height:44px;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    padding:0 18px;

    border-radius:12px;

    font-size:13px;
    font-weight:600;

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        background .18s ease;
}

.home-btn:hover{
    transform:translateY(-2px);
}

.home-btn-primary{
    background:var(--home-blue-deep);
    color:#fff;

    box-shadow:0 8px 18px rgba(94,145,196,.18);
}

.home-btn-primary:hover{
    background:#5488BC;
    color:#fff;
    box-shadow:0 12px 24px rgba(94,145,196,.23);
}

.home-btn-secondary{
    background:#fff;
    color:var(--home-text);

    border:1px solid var(--home-border);
}

.home-btn-secondary:hover{
    background:var(--home-pink-soft);
    border-color:#FFD1D5;
    color:var(--home-pink-hot);
}


/* =========================================================
   HERO SIDE CARD
   ========================================================= */

.home-summary{
    position:relative;
    overflow:hidden;

    min-height:300px;

    padding:25px;

    border:1px solid rgba(121,169,216,.22);
    border-radius:22px;

    background:
        linear-gradient(
            145deg,
            rgba(234,243,250,.95),
            rgba(255,240,241,.75)
        );

    box-shadow:
        0 14px 35px rgba(48,50,58,.055);
}

.home-summary::after{
    content:"";

    position:absolute;

    width:130px;
    height:130px;

    right:-40px;
    bottom:-45px;

    border-radius:50%;

    background:rgba(255,154,162,.22);
}

.summary-top{
    position:relative;
    z-index:1;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.summary-label{
    font-family:var(--mono);
    font-size:10px;
    letter-spacing:.14em;
    text-transform:uppercase;

    color:var(--home-blue-deep);
}

.summary-icon{
    width:34px;
    height:34px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:11px;

    background:rgba(255,255,255,.7);
    color:var(--home-pink-hot);
}

.summary-content{
    position:relative;
    z-index:1;

    margin-top:30px;
}

.summary-title{
    font-size:22px;
    font-weight:700;
    letter-spacing:-.025em;

    color:var(--home-text);
}

.summary-desc{
    margin-top:5px;

    color:var(--home-muted);
    font-size:12.5px;
    line-height:1.5;
}

.summary-stats{
    position:relative;
    z-index:1;

    display:grid;
    grid-template-columns:1fr 1fr;

    gap:10px;

    margin-top:25px;
}

.summary-stat{
    padding:14px;

    border:1px solid rgba(255,255,255,.72);
    border-radius:14px;

    background:rgba(255,255,255,.6);
}

.summary-num{
    font-family:var(--mono);

    font-size:25px;
    line-height:1;

    color:var(--home-blue-deep);
}

.summary-stat:last-child .summary-num{
    color:var(--home-pink-hot);
}

.summary-text{
    margin-top:6px;

    font-size:10.5px;
    color:var(--home-muted);
}


/* =========================================================
   QUICK STATS
   ========================================================= */

.home-stats{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:12px;

    margin-bottom:32px;
}

.home-stat{
    position:relative;
    overflow:hidden;

    display:flex;
    align-items:center;
    gap:13px;

    min-width:0;

    padding:16px;

    background:var(--home-card);
    border:1px solid var(--home-border);
    border-radius:16px;

    box-shadow:0 5px 16px rgba(48,50,58,.035);

    transition:
        transform .18s ease,
        box-shadow .18s ease;
}

.home-stat:hover{
    transform:translateY(-2px);
    box-shadow:0 9px 22px rgba(48,50,58,.06);
}

.home-stat-icon{
    width:40px;
    height:40px;

    flex-shrink:0;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:12px;

    font-size:18px;
}

.home-stat:nth-child(1) .home-stat-icon{
    background:var(--home-blue-soft);
    color:var(--home-blue-deep);
}

.home-stat:nth-child(2) .home-stat-icon{
    background:var(--home-pink-soft);
    color:var(--home-pink-hot);
}

.home-stat:nth-child(3) .home-stat-icon{
    background:var(--home-yellow-soft);
    color:#A48627;
}

.home-stat-content{
    min-width:0;
}

.home-stat-num{
    font-family:var(--mono);
    font-size:22px;
    line-height:1;

    color:var(--home-text);
}

.home-stat-label{
    margin-top:5px;

    font-size:11px;
    color:var(--home-muted);
}


/* =========================================================
   SECTION HEADER
   ========================================================= */

.home-section-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:15px;

    margin:30px 0 14px;
}

.home-section-title{
    min-width:0;
}

.home-section-eyebrow{
    margin-bottom:3px;

    font-family:var(--mono);
    font-size:9px;
    letter-spacing:.13em;
    text-transform:uppercase;

    color:var(--home-faint);
}

.home-section-head h2{
    margin:0;

    font-size:19px;
    line-height:1.2;
    font-weight:700;
    letter-spacing:-.02em;

    color:var(--home-text);
}

.home-section-link{
    flex-shrink:0;

    display:inline-flex;
    align-items:center;
    gap:4px;

    font-size:11.5px;
    font-weight:600;

    color:var(--home-blue-deep);

    transition:color .15s ease;
}

.home-section-link:hover{
    color:var(--home-pink-hot);
}


/* =========================================================
   TEMPLATE
   ========================================================= */

.home-template-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:13px;
}

.home-template-card{
    display:flex;
    flex-direction:column;

    min-width:0;

    padding:17px;

    background:var(--home-card);
    border:1px solid var(--home-border);
    border-radius:16px;

    box-shadow:0 5px 16px rgba(48,50,58,.035);

    transition:
        transform .18s ease,
        border-color .18s ease,
        box-shadow .18s ease;
}

.home-template-card:hover{
    transform:translateY(-3px);

    border-color:#D8E8F5;

    box-shadow:0 12px 25px rgba(48,50,58,.065);
}

.home-template-icon{
    width:38px;
    height:38px;

    display:flex;
    align-items:center;
    justify-content:center;

    margin-bottom:13px;

    border-radius:11px;

    background:var(--home-blue-soft);
    color:var(--home-blue-deep);
}

.home-template-title{
    min-width:0;

    font-size:13.5px;
    font-weight:650;
    line-height:1.4;

    color:var(--home-text);

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.home-template-category{
    margin-top:5px;

    font-size:10.5px;
    color:var(--home-pink-hot);
    font-weight:500;
}

.home-template-desc{
    margin-top:9px;

    color:var(--home-muted);

    font-size:11.5px;
    line-height:1.5;

    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.home-template-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;

    margin-top:14px;
    padding-top:11px;

    border-top:1px solid var(--home-border);

    font-family:var(--mono);
    font-size:9px;

    color:var(--home-faint);
}

.home-template-footer span{
    min-width:0;

    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}


/* =========================================================
   BOTTOM CONTENT
   ========================================================= */

.home-bottom-grid{
    display:grid;
    grid-template-columns:minmax(0,.85fr) minmax(0,1.15fr);
    gap:16px;

    margin-bottom:25px;
}


/* GROUPS */

.home-group-list{
    display:grid;
    gap:10px;
}

.home-group-card{
    display:flex;
    align-items:center;
    gap:12px;

    min-width:0;

    padding:13px 14px;

    background:#fff;
    border:1px solid var(--home-border);
    border-radius:14px;

    transition:
        transform .18s ease,
        background .18s ease;
}

.home-group-card:hover{
    transform:translateX(2px);
    background:#FFFDFD;
}

.home-group-avatar{
    width:38px;
    height:38px;

    flex-shrink:0;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:12px;

    background:var(--home-pink-soft);
    color:var(--home-pink-hot);
}

.home-group-info{
    min-width:0;
    flex:1;
}

.home-group-name{
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    font-size:12.5px;
    font-weight:600;

    color:var(--home-text);
}

.home-group-meta{
    margin-top:3px;

    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    font-size:10.5px;
    color:var(--home-muted);
}

.home-group-code{
    flex-shrink:0;

    padding:5px 8px;

    border-radius:8px;

    background:var(--home-blue-soft);
    color:var(--home-blue-deep);

    font-family:var(--mono);
    font-size:8.5px;
}


/* TASKS */

.home-task-list{
    overflow:hidden;

    background:#fff;
    border:1px solid var(--home-border);
    border-radius:16px;
}

.home-task-item{
    display:flex;
    align-items:center;
    gap:11px;

    min-width:0;

    padding:13px 15px;

    border-top:1px solid var(--home-border);
}

.home-task-item:first-child{
    border-top:0;
}

.home-task-icon{
    width:34px;
    height:34px;

    flex-shrink:0;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:10px;

    background:var(--home-blue-soft);
    color:var(--home-blue-deep);
}

.home-task-main{
    min-width:0;
    flex:1;
}

.home-task-title{
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    font-size:12px;
    font-weight:600;

    color:var(--home-text);
}

.home-task-meta{
    margin-top:3px;

    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    font-size:10px;
    color:var(--home-muted);
}

.home-task-status{
    flex-shrink:0;

    padding:5px 8px;

    border-radius:8px;

    background:var(--home-pink-soft);
    color:var(--home-pink-hot);

    font-family:var(--mono);
    font-size:8.5px;
}


/* =========================================================
   EMPTY
   ========================================================= */

.home-empty{
    padding:28px 18px;

    text-align:center;

    color:var(--home-faint);

    font-size:12px;
}

.home-empty-icon{
    width:38px;
    height:38px;

    margin:0 auto 9px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:12px;

    background:#F7F7F7;

    color:var(--home-faint);

    font-size:17px;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width:950px){

    .home-hero{
        grid-template-columns:1fr;
    }

    .home-summary{
        min-height:auto;
    }

    .home-bottom-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:760px){

    .home-hero{
        padding-top:10px;
    }

    .home-hero-main{
        min-height:auto;
        padding:20px 2px 12px;
    }

    .home-hero h1{
        font-size:38px;
    }

    .home-stats{
        grid-template-columns:1fr;
    }

    .home-template-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:540px){

    .home-hero h1{
        font-size:32px;
    }

    .home-hero-desc{
        font-size:13.5px;
    }

    .home-actions{
        flex-direction:column;
    }

    .home-btn{
        width:100%;
    }

    .home-template-grid{
        grid-template-columns:1fr;
    }

    .home-section-head{
        align-items:center;
    }

    .home-section-head h2{
        font-size:17px;
    }

    .home-task-status{
        display:none;
    }

    .home-group-code{
        display:none;
    }
}
</style>



<div class="home-page">

    <!-- =====================================================
         HERO
         ===================================================== -->

    <section class="home-hero">

        <div class="home-hero-main">

            <div class="home-kicker">
                COLLABIFY HOME
            </div>

            <h1>
                Semua kolaborasi,<br>
                <span class="accent">lebih terorganisir.</span>
            </h1>

            <div class="home-hero-desc">
                Kelola tugas, kelompok, template, dan aktivitas
                perkuliahan dalam satu tempat yang lebih sederhana.
            </div>

            <div class="home-actions">

                <a
                    href="<?= base_url(session('role') === 'admin' ? 'dashboard' : 'workspaces') ?>"
                    class="home-btn home-btn-primary"
                >
                    <i class="ti ti-layout-dashboard"></i>
                    <?= session('role') === 'admin' ? 'Buka dashboard' : 'Buka workspace' ?>
                </a>

                <a
                    href="<?= base_url('groups') ?>"
                    class="home-btn home-btn-secondary"
                >
                    <i class="ti ti-users-group"></i>
                    Lihat kelompok
                </a>

            </div>

        </div>


        <!-- SUMMARY -->

        <div class="home-summary">

            <div class="summary-top">

                <div class="summary-label">
                    Ringkasan aktivitas
                </div>

                <div class="summary-icon">
                    <i class="ti ti-sparkles"></i>
                </div>

            </div>

            <div class="summary-content">

                <div class="summary-title">
                    Siap lanjut?
                </div>

                <div class="summary-desc">
                    Beberapa hal yang sedang aktif di Collabify.
                </div>

            </div>

            <div class="summary-stats">

                <div class="summary-stat">

                    <div class="summary-num">
                        <?= number_format(count($templates ?? [])) ?>
                    </div>

                    <div class="summary-text">
                        template terbaru
                    </div>

                </div>

                <div class="summary-stat">

                    <div class="summary-num">
                        <?= number_format(count($groups ?? [])) ?>
                    </div>

                    <div class="summary-text">
                        kelompok terbaru
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         QUICK STATS
         ===================================================== -->

    <div class="home-stats">

        <div class="home-stat">

            <div class="home-stat-icon">
                <i class="ti ti-file-description"></i>
            </div>

            <div class="home-stat-content">

                <div class="home-stat-num">
                    <?= number_format(count($templates ?? [])) ?>
                </div>

                <div class="home-stat-label">
                    Template tersedia
                </div>

            </div>

        </div>


        <div class="home-stat">

            <div class="home-stat-icon">
                <i class="ti ti-users-group"></i>
            </div>

            <div class="home-stat-content">

                <div class="home-stat-num">
                    <?= number_format(count($groups ?? [])) ?>
                </div>

                <div class="home-stat-label">
                    Kelompok terbaru
                </div>

            </div>

        </div>


        <div class="home-stat">

            <div class="home-stat-icon">
                <i class="ti ti-checkbox"></i>
            </div>

            <div class="home-stat-content">

                <div class="home-stat-num">
                    <?= number_format(count($tasks ?? [])) ?>
                </div>

                <div class="home-stat-label">
                    Tugas terbaru
                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         TEMPLATE
         ===================================================== -->

    <div class="home-section-head">

        <div class="home-section-title">

            <div class="home-section-eyebrow">
                Sumber daya
            </div>

            <h2>
                Template terpopuler
            </h2>

        </div>

        <a
            href="<?= base_url('templates') ?>"
            class="home-section-link"
        >
            Lihat semua
            <i class="ti ti-arrow-up-right"></i>
        </a>

    </div>


    <?php if (empty($templates)): ?>

        <div class="home-template-grid">

            <div class="home-template-card">

                <div class="home-empty">

                    <div class="home-empty-icon">
                        <i class="ti ti-file-off"></i>
                    </div>

                    Belum ada template yang tersedia.

                </div>

            </div>

        </div>

    <?php else: ?>

        <div class="home-template-grid">

            <?php foreach ($templates as $template): ?>

                <a
                    href="<?= base_url('templates/' . $template['id_template']) ?>"
                    class="home-template-card"
                >

                    <div class="home-template-icon">
                        <i class="ti ti-file-text"></i>
                    </div>

                    <div class="home-template-title">
                        <?= esc($template['judul']) ?>
                    </div>

                    <div class="home-template-category">
                        <?= esc($template['kategori']) ?>
                        <?php if (! empty($template['terpercaya'])): ?>
                            · <span title="Rating tinggi dari banyak pengguna"><i class="ti ti-shield-check"></i> Terpercaya</span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($template['deskripsi'])): ?>

                        <div class="home-template-desc">
                            <?= esc(mb_strimwidth(
                                $template['deskripsi'],
                                0,
                                110,
                                '…'
                            )) ?>
                        </div>

                    <?php endif; ?>

                    <div class="home-template-footer">

                        <span>
                            <?= esc($template['uploader'] ?? 'Pengguna') ?>
                        </span>

                        <span>
                            <?php if ((int) ($template['total_rating'] ?? 0) > 0): ?>
                                <i class="ti ti-star-filled"></i> <?= number_format($template['average_rating'], 1) ?>
                                (<?= (int) $template['total_rating'] ?>) ·
                            <?php endif; ?>
                            <?= number_format((int) ($template['total_pakai'] ?? 0)) ?> dipakai ·
                            <?= number_format((int) ($template['downloads_count'] ?? 0)) ?> download
                        </span>

                    </div>

                </a>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         GROUP + TASK
         ===================================================== -->

    <div class="home-bottom-grid">


        <!-- GROUPS -->

        <section>

            <div class="home-section-head">

                <div class="home-section-title">

                    <div class="home-section-eyebrow">
                        Kolaborasi
                    </div>

                    <h2>
                        Kelompok terbaru
                    </h2>

                </div>

                <a
                    href="<?= base_url('groups') ?>"
                    class="home-section-link"
                >
                    Lihat semua
                    <i class="ti ti-arrow-up-right"></i>
                </a>

            </div>


            <?php if (empty($groups)): ?>

                <div class="home-group-card">

                    <div class="home-empty">

                        <div class="home-empty-icon">
                            <i class="ti ti-users-off"></i>
                        </div>

                        Belum ada kelompok yang dibuat.

                    </div>

                </div>

            <?php else: ?>

                <div class="home-group-list">

                    <?php foreach ($groups as $group): ?>

                        <div class="home-group-card">

                            <div class="home-group-avatar">
                                <i class="ti ti-users-group"></i>
                            </div>

                            <div class="home-group-info">

                                <div class="home-group-name">
                                    <?= esc($group['nama_kelompok']) ?>
                                </div>

                                <div class="home-group-meta">
                                    Dibuat oleh
                                    <?= esc($group['pembuat'] ?? 'Pengguna') ?>
                                </div>

                            </div>

                            <div class="home-group-code">
                                <?= esc($group['kode_invite']) ?>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <!-- TASKS -->

        <section>

            <div class="home-section-head">

                <div class="home-section-title">

                    <div class="home-section-eyebrow">
                        Aktivitas
                    </div>

                    <h2>
                        Tugas terbaru
                    </h2>

                </div>

                <a
                    href="<?= base_url('tasks') ?>"
                    class="home-section-link"
                >
                    Lihat semua
                    <i class="ti ti-arrow-up-right"></i>
                </a>

            </div>


            <?php if (empty($tasks)): ?>

                <div class="home-task-list">

                    <div class="home-empty">

                        <div class="home-empty-icon">
                            <i class="ti ti-checkbox"></i>
                        </div>

                        Belum ada tugas.

                    </div>

                </div>

            <?php else: ?>

                <div class="home-task-list">

                    <?php foreach ($tasks as $task): ?>

                        <div class="home-task-item">

                            <div class="home-task-icon">
                                <i class="ti ti-checkbox"></i>
                            </div>

                            <div class="home-task-main">

                                <div class="home-task-title">
                                    <?= esc($task['judul']) ?>
                                </div>

                                <div class="home-task-meta">

                                    <?= esc(
                                        $task['nama_kelompok']
                                        ?? 'Tanpa kelompok'
                                    ) ?>

                                    <?php if (!empty($task['deadline'])): ?>

                                        · deadline
                                        <?= esc($task['deadline']) ?>

                                    <?php endif; ?>

                                </div>

                            </div>

                            <div class="home-task-status">
                                <?= esc($task['status']) ?>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>

    </div>

</div>

<?= $this->endSection() ?>
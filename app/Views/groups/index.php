<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="d-flex justify-content-between align-items-center flex-wrap">

    <div>
        <div class="group-eyebrow">
            <i class="ti ti-users-group"></i>
            COLLABORATION SPACE
        </div>

        <h1 class="page-title mb-1">
            Kelompok
        </h1>

        <p class="page-sub mb-0">
            Kelola kelompok belajar dan kolaborasimu dalam satu tempat.
        </p>
    </div>

    <div class="mt-2 mt-md-0 group-actions">

        <a href="<?= base_url('groups/join') ?>"
           class="btn btn-light group-join-btn">
            <i class="ti ti-link mr-1"></i>
            Gabung
        </a>

        <a href="<?= base_url('groups/create') ?>"
           class="btn btn-primary group-create-btn">
            <i class="ti ti-plus mr-1"></i>
            Buat Kelompok
        </a>

    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success group-alert">
        <i class="ti ti-circle-check mr-2"></i>
        <?= esc(session()->getFlashdata('success')) ?>
    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-danger group-alert">
        <i class="ti ti-alert-circle mr-2"></i>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>

<?php endif; ?>


<?php if (empty($groups)): ?>

    <!-- EMPTY STATE -->

    <div class="group-empty">

        <div class="group-empty-icon">
            <i class="ti ti-users-group"></i>
        </div>

        <h3>
            Belum ada kelompok
        </h3>

        <p>
            Buat kelompok baru atau bergabung menggunakan kode invite.
        </p>

        <div class="group-empty-actions">

            <a href="<?= base_url('groups/create') ?>"
               class="btn btn-primary group-create-btn">
                <i class="ti ti-plus mr-1"></i>
                Buat Kelompok
            </a>

            <a href="<?= base_url('groups/join') ?>"
               class="btn btn-light group-join-btn">
                <i class="ti ti-link mr-1"></i>
                Gabung Kelompok
            </a>

        </div>

    </div>


<?php else: ?>

    <!-- GROUP HEADER -->

    <div class="group-list-header">

        <div class="group-list-title">
            Kelompokmu
        </div>

        <div class="group-count">
            <?= count($groups) ?> kelompok
        </div>

    </div>


    <!-- GROUP CARDS -->

    <div class="row group-grid">

        <?php foreach ($groups as $group): ?>

            <div class="col-12 col-md-6 col-xl-4 mb-4">

                <div class="group-card h-100">

                    <div class="group-card-body">

                        <!-- TOP -->

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div class="group-icon">
                                <i class="ti ti-users-group"></i>
                            </div>


                            <?php if (($group['peran'] ?? '') === 'ketua'): ?>

                                <span class="group-role role-ketua">
                                    Ketua
                                </span>

                            <?php else: ?>

                                <span class="group-role role-anggota">
                                    Anggota
                                </span>

                            <?php endif; ?>

                        </div>


                        <!-- TITLE -->

                        <h3 class="group-title">
                            <?= esc($group['nama_kelompok']) ?>
                        </h3>


                        <!-- INVITE -->

                        <div class="group-invite">

                            <i class="ti ti-link"></i>

                            <span>
                                Kode invite
                            </span>

                            <span class="invite-code">
                                <?= esc($group['kode_invite']) ?>
                            </span>

                        </div>


                        <!-- DATE -->

                        <div class="group-meta">

                            <i class="ti ti-calendar"></i>

                            <span>
                                Dibuat
                                <?= !empty($group['created_at'])
                                    ? date('d M Y', strtotime($group['created_at']))
                                    : '-' ?>
                            </span>

                        </div>


                        <!-- ACTION -->

                        <a href="<?= base_url('groups/' . $group['id_group']) ?>"
                           class="group-open-btn">

                            <span>
                                Buka Kelompok
                            </span>

                            <i class="ti ti-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>


<style>

/* =====================================================
   GROUP PAGE
   ===================================================== */

.group-eyebrow {
    display: flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 7px;

    font-size: 11px;
    font-weight: 600;
    letter-spacing: .14em;
    color: #5E91C4;
}

.group-eyebrow i {
    font-size: 14px;
}


/* =====================================================
   HEADER ACTIONS
   ===================================================== */

.group-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.group-join-btn,
.group-create-btn {
    border-radius: 12px !important;
    padding: 10px 17px !important;
    font-weight: 600 !important;
    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease !important;
}

.group-join-btn {
    background: rgba(255,255,255,.82) !important;
    border: 1px solid rgba(255,255,255,.9) !important;
    color: #5E91C4 !important;

    box-shadow:
        0 6px 18px rgba(94,145,196,.07),
        inset 0 1px 0 rgba(255,255,255,.9);
}

.group-join-btn:hover {
    background: #EAF3FA !important;
    color: #5E91C4 !important;
    transform: translateY(-2px);
}

.group-create-btn {
    background: #5E91C4 !important;
    border-color: #5E91C4 !important;
    color: #fff !important;

    box-shadow:
        0 8px 18px rgba(94,145,196,.18);
}

.group-create-btn:hover {
    background: #4F83B6 !important;
    border-color: #4F83B6 !important;
    color: #fff !important;
    transform: translateY(-2px);
}


/* =====================================================
   ALERT
   ===================================================== */

.group-alert {
    border: 0 !important;
    border-radius: 14px !important;
    box-shadow: 0 6px 18px rgba(0,0,0,.04);
}


/* =====================================================
   GROUP LIST HEADER
   ===================================================== */

.group-list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-top: 28px;
    margin-bottom: 14px;

    padding: 0 2px;
}

.group-list-title {
    font-size: 15px;
    font-weight: 600;
    color: #30323A;
}

.group-count {
    font-size: 12px;
    color: #999BA1;
}


/* =====================================================
   GROUP CARD
   ===================================================== */

.group-card {
    position: relative;
    overflow: hidden;

    height: 100%;

    background: rgba(255,255,255,.72);

    border: 1px solid rgba(255,255,255,.88);
    border-radius: 18px;

    box-shadow:
        0 8px 24px rgba(94,145,196,.08),
        inset 0 1px 0 rgba(255,255,255,.9);

    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.group-card::after {
    content: "";

    position: absolute;

    width: 95px;
    height: 95px;

    right: -35px;
    bottom: -40px;

    border-radius: 50%;

    background: rgba(121,169,216,.08);

    pointer-events: none;
}

.group-card:hover {
    transform: translateY(-4px);

    box-shadow:
        0 15px 32px rgba(94,145,196,.13),
        inset 0 1px 0 rgba(255,255,255,.95);
}


/* =====================================================
   CARD BODY
   ===================================================== */

.group-card-body {
    position: relative;
    z-index: 1;

    padding: 20px;
}


/* =====================================================
   GROUP ICON
   ===================================================== */

.group-icon {
    width: 44px;
    height: 44px;

    border-radius: 13px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #EAF3FA;
    color: #5E91C4;

    font-size: 22px;
}


/* =====================================================
   ALTERNATING CARD — PINK
   ===================================================== */

.group-grid > div:nth-child(even) .group-icon {
    background: #FFF0F1;
    color: #FF677D;
}

.group-grid > div:nth-child(even) .group-card::after {
    background: rgba(255,154,162,.09);
}


/* =====================================================
   ROLE BADGE
   ===================================================== */

.group-role {
    display: inline-flex;
    align-items: center;

    padding: 6px 10px;

    border-radius: 999px;

    font-size: 11px;
    font-weight: 600;
}


/* Ketua */

.role-ketua {
    background: #FFF0F1;
    color: #FF677D;
}


/* Anggota */

.role-anggota {
    background: #EAF3FA;
    color: #5E91C4;
}


/* =====================================================
   TITLE
   ===================================================== */

.group-title {
    margin: 0 0 12px;

    font-size: 18px;
    font-weight: 650;

    color: #30323A;

    letter-spacing: -.01em;
}


/* =====================================================
   INVITE
   ===================================================== */

.group-invite {
    display: flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 14px;

    font-size: 12.5px;
    color: #77777D;
}

.group-invite > i {
    font-size: 15px;
    color: #8A8E96;
}

.invite-code {
    display: inline-flex;
    align-items: center;

    padding: 4px 7px;

    margin-left: 2px;

    border-radius: 7px;

    background: #F2F7FB;

    color: #5E91C4;

    font-family: var(--mono);
    font-size: 11px;
    font-weight: 500;
}


/* Pink card invite */

.group-grid > div:nth-child(even) .invite-code {
    background: #FFF0F1;
    color: #FF677D;
}


/* =====================================================
   META
   ===================================================== */

.group-meta {
    display: flex;
    align-items: center;
    gap: 7px;

    padding-top: 13px;

    border-top: 1px solid #F0DFE1;

    color: #999BA1;

    font-size: 12px;
}

.group-meta i {
    color: #5E91C4;
    font-size: 15px;
}

.group-grid > div:nth-child(even) .group-meta i {
    color: #FF677D;
}


/* =====================================================
   OPEN BUTTON
   ===================================================== */

.group-open-btn {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-top: 17px;

    padding: 11px 13px;

    border-radius: 12px;

    background: #EAF3FA;

    color: #5E91C4;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none !important;

    transition:
        background .2s ease,
        transform .2s ease;
}

.group-open-btn i {
    font-size: 17px;

    transition:
        transform .2s ease;
}

.group-open-btn:hover {
    background: #DDECF8;
    color: #4F83B6;
    text-decoration: none;
}

.group-open-btn:hover i {
    transform: translateX(3px);
}


/* Pink card button */

.group-grid > div:nth-child(even) .group-open-btn {
    background: #FFF0F1;
    color: #FF677D;
}

.group-grid > div:nth-child(even) .group-open-btn:hover {
    background: #FFE2E5;
    color: #F2556D;
}


/* =====================================================
   EMPTY STATE
   ===================================================== */

.group-empty {
    margin-top: 24px;

    padding: 55px 25px;

    text-align: center;

    background: rgba(255,255,255,.72);

    border: 1px solid rgba(255,255,255,.88);
    border-radius: 18px;

    box-shadow:
        0 8px 24px rgba(94,145,196,.08),
        inset 0 1px 0 rgba(255,255,255,.9);

    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

.group-empty-icon {
    width: 58px;
    height: 58px;

    margin: 0 auto 15px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background: #EAF3FA;
    color: #5E91C4;

    font-size: 27px;
}

.group-empty h3 {
    margin-bottom: 7px;

    font-size: 18px;
    font-weight: 600;

    color: #30323A;
}

.group-empty p {
    margin-bottom: 22px;

    color: #77777D;
    font-size: 13px;
}

.group-empty-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 767px) {

    .group-actions {
        width: 100%;
        margin-top: 14px;
    }

    .group-actions a {
        flex: 1;
        text-align: center;
    }

    .group-list-header {
        margin-top: 24px;
    }

    .group-card-body {
        padding: 18px;
    }

}

@media (max-width: 480px) {

    .group-empty-actions {
        flex-direction: column;
    }

    .group-empty-actions a {
        width: 100%;
    }

}

</style>


<?= $this->endSection() ?>
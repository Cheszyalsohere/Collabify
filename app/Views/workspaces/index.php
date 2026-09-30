<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="workspace-header">

    <div>
        <div class="workspace-eyebrow">
            RUANG KERJA
        </div>

        <h1 class="workspace-title">
            Workspace Saya
        </h1>

        <p class="workspace-subtitle">
            Tempat kerja dari template yang kamu gunakan.
        </p>
    </div>

    <a
        href="<?= base_url('templates') ?>"
        class="workspace-template-btn"
    >
        <i class="ti ti-file-description"></i>
        <span>Jelajahi Template</span>
    </a>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>

    <div class="workspace-alert">
        <i class="ti ti-alert-circle"></i>

        <span>
            <?= esc(session()->getFlashdata('error')) ?>
        </span>
    </div>

<?php endif; ?>


<?php if (! empty($workspaces)): ?>

    <div class="workspace-list-header">

        <div>
            <span class="workspace-list-label">
                WORKSPACE AKTIF
            </span>

            <span class="workspace-count">
                <?= count($workspaces) ?> workspace
            </span>
        </div>

    </div>


    <div class="workspace-grid">

        <?php foreach ($workspaces as $index => $workspace): ?>

            <?php
                $accentClass = ($index % 2 === 0)
                    ? 'workspace-accent-blue'
                    : 'workspace-accent-pink';
            ?>

            <div class="workspace-card <?= $accentClass ?>">

                <div class="workspace-card-inner">

                    <!-- TOP -->
                    <div class="workspace-card-top">

                        <div class="workspace-folder-icon">
                            <i class="ti ti-folder"></i>
                        </div>

                        <span class="workspace-status">
                            <span class="workspace-status-dot"></span>
                            Aktif
                        </span>

                    </div>


                    <!-- TITLE -->
                    <h3 class="workspace-card-title">
                        <?= esc($workspace['judul']) ?>
                    </h3>


                    <!-- TEMPLATE SOURCE -->
                    <div class="workspace-source">

                        <span class="workspace-source-icon">
                            <i class="ti ti-file-description"></i>
                        </span>

                        <div class="workspace-source-text">

                            <span class="workspace-meta-label">
                                Dari template
                            </span>

                            <span class="workspace-meta-value">
                                <?= esc($workspace['template_asal']) ?>
                            </span>

                        </div>

                    </div>


                    <!-- GROUP -->
                    <div class="workspace-group">

                        <i class="ti ti-users-group"></i>

                        <span>
                            <?= esc(
                                $workspace['nama_kelompok']
                                ?? 'Pribadi'
                            ) ?>
                        </span>

                    </div>


                    <!-- ACTION -->
                    <a
                        href="<?= base_url(
                            'workspaces/' .
                            $workspace['id_workspace']
                        ) ?>"
                        class="workspace-open-btn"
                    >
                        <span>
                            <i class="ti ti-edit"></i>
                            Buka Workspace
                        </span>

                        <i class="ti ti-arrow-right workspace-arrow"></i>
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>


<?php else: ?>

    <div class="workspace-empty">

        <div class="workspace-empty-icon">
            <i class="ti ti-folder-open"></i>
        </div>

        <h3>
            Belum ada workspace
        </h3>

        <p>
            Gunakan template untuk membuat workspace pertamamu
            dan mulai mengerjakan tugas bersama kelompok.
        </p>

        <a
            href="<?= base_url('templates') ?>"
            class="workspace-empty-btn"
        >
            <i class="ti ti-file-description"></i>
            Jelajahi Template
        </a>

    </div>

<?php endif; ?>


<style>

/* =====================================================
   COLLABIFY — WORKSPACE
   ===================================================== */

.workspace-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 20px;
    flex-wrap: wrap;
}

.workspace-eyebrow {
    margin-bottom: 6px;

    color: #5E91C4;

    font-size: 10px;
    font-weight: 700;
    letter-spacing: .12em;
}

.workspace-title {
    margin: 0 0 5px;

    color: #30323A;

    font-size: 28px;
    line-height: 1.2;
    font-weight: 700;
}

.workspace-subtitle {
    margin: 0;

    color: #77777D;

    font-size: 13px;
}


/* =========================
   TEMPLATE BUTTON
   ========================= */

.workspace-template-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    min-height: 40px;
    padding: 0 16px;

    border-radius: 11px;

    background: #79A9D8;
    color: #FFFFFF !important;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none !important;

    box-shadow: 0 6px 16px rgba(94,145,196,.18);

    transition:
        transform .18s ease,
        background .18s ease,
        box-shadow .18s ease;
}

.workspace-template-btn:hover {
    background: #5E91C4;

    transform: translateY(-1px);

    box-shadow: 0 9px 20px rgba(94,145,196,.23);
}

.workspace-template-btn i {
    font-size: 17px;
}


/* =========================
   ALERT
   ========================= */

.workspace-alert {
    display: flex;
    align-items: center;

    gap: 9px;

    margin-bottom: 18px;
    padding: 11px 14px;

    border: 1px solid #F6D5D9;
    border-radius: 12px;

    background: #FFF0F1;
    color: #D95A70;

    font-size: 13px;
    font-weight: 500;
}

.workspace-alert i {
    font-size: 17px;
}


/* =========================
   LIST HEADER
   ========================= */

.workspace-list-header {
    display: flex;
    align-items: center;

    margin: 22px 0 13px;
}

.workspace-list-header > div {
    display: flex;
    align-items: center;

    gap: 9px;
}

.workspace-list-label {
    color: #77777D;

    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
}

.workspace-count {
    padding: 3px 8px;

    border-radius: 999px;

    background: #F7F7F7;
    color: #77777D;

    font-size: 11px;
    font-weight: 600;
}


/* =========================
   GRID
   ========================= */

.workspace-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 16px;
}


/* =========================
   CARD
   ========================= */

.workspace-card {
    position: relative;

    min-width: 0;

    border: 1px solid rgba(255,255,255,.9);
    border-radius: 17px;

    background: rgba(255,255,255,.88);

    overflow: hidden;

    box-shadow:
        0 8px 22px rgba(48,50,58,.055),
        inset 0 1px 0 rgba(255,255,255,.9);

    transition:
        transform .18s ease,
        box-shadow .18s ease;
}

.workspace-card:hover {
    transform: translateY(-3px);

    box-shadow:
        0 14px 30px rgba(48,50,58,.09),
        inset 0 1px 0 rgba(255,255,255,.95);
}


/* accent */

.workspace-card::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;
    right: 0;

    height: 4px;
}

.workspace-accent-blue::before {
    background: #79A9D8;
}

.workspace-accent-pink::before {
    background: #FF9AA2;
}


.workspace-card-inner {
    display: flex;
    flex-direction: column;

    min-height: 290px;

    padding: 19px;
}


/* =========================
   TOP
   ========================= */

.workspace-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 12px;

    margin-bottom: 17px;
}

.workspace-folder-icon {
    width: 46px;
    height: 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: #EAF3FA;
    color: #5E91C4;

    font-size: 23px;
}

.workspace-accent-pink .workspace-folder-icon {
    background: #FFF0F1;
    color: #FF677D;
}


/* =========================
   STATUS
   ========================= */

.workspace-status {
    display: inline-flex;
    align-items: center;

    gap: 6px;

    padding: 5px 9px;

    border-radius: 999px;

    background: #F2F8F3;
    color: #4D805C;

    font-size: 10px;
    font-weight: 650;
}

.workspace-status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #65A875;
}


/* =========================
   TITLE
   ========================= */

.workspace-card-title {
    margin: 0 0 17px;

    color: #30323A;

    font-size: 17px;
    line-height: 1.4;
    font-weight: 650;

    overflow-wrap: anywhere;
}


/* =========================
   SOURCE
   ========================= */

.workspace-source {
    display: flex;
    align-items: center;

    gap: 9px;

    min-width: 0;

    padding: 11px;

    border-radius: 11px;

    background: #FAFAFA;

    border: 1px solid #F1F1F1;
}

.workspace-source-icon {
    width: 30px;
    height: 30px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #FFFFFF;
    color: #77777D;

    font-size: 14px;
}

.workspace-accent-blue .workspace-source-icon {
    color: #5E91C4;
}

.workspace-accent-pink .workspace-source-icon {
    color: #FF677D;
}

.workspace-source-text {
    min-width: 0;
}

.workspace-meta-label {
    display: block;

    margin-bottom: 2px;

    color: #999AA0;

    font-size: 9px;
}

.workspace-meta-value {
    display: block;

    max-width: 220px;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    color: #555760;

    font-size: 11px;
    font-weight: 600;
}


/* =========================
   GROUP
   ========================= */

.workspace-group {
    display: flex;
    align-items: center;

    gap: 7px;

    margin-top: 13px;

    color: #77777D;

    font-size: 11px;
}

.workspace-group i {
    color: #5E91C4;

    font-size: 15px;
}

.workspace-accent-pink .workspace-group i {
    color: #FF677D;
}


/* =========================
   OPEN BUTTON
   ========================= */

.workspace-open-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    margin-top: auto;
    padding: 10px 12px;

    border-radius: 10px;

    font-size: 11px;
    font-weight: 650;

    text-decoration: none !important;

    transition:
        transform .18s ease,
        background .18s ease;
}

.workspace-open-btn > span {
    display: inline-flex;
    align-items: center;

    gap: 6px;
}

.workspace-open-btn i {
    font-size: 15px;
}

.workspace-arrow {
    transition: transform .18s ease;
}

.workspace-open-btn:hover .workspace-arrow {
    transform: translateX(2px);
}

.workspace-accent-blue .workspace-open-btn {
    background: #EAF3FA;
    color: #5E91C4 !important;
}

.workspace-accent-blue .workspace-open-btn:hover {
    background: #DCECF8;
}

.workspace-accent-pink .workspace-open-btn {
    background: #FFF0F1;
    color: #FF677D !important;
}

.workspace-accent-pink .workspace-open-btn:hover {
    background: #FFE3E7;
}


/* =========================
   EMPTY
   ========================= */

.workspace-empty {
    margin-top: 18px;

    padding: 56px 24px;

    text-align: center;

    border: 1px solid #F0DFE1;
    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.94),
            rgba(255,248,247,.9)
        );

    box-shadow:
        0 8px 24px rgba(48,50,58,.045);
}

.workspace-empty-icon {
    width: 62px;
    height: 62px;

    margin: 0 auto 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background: #FFF0F1;
    color: #FF677D;

    font-size: 29px;
}

.workspace-empty h3 {
    margin: 0 0 7px;

    color: #30323A;

    font-size: 18px;
    font-weight: 650;
}

.workspace-empty p {
    max-width: 440px;

    margin: 0 auto 22px;

    color: #77777D;

    font-size: 13px;
    line-height: 1.6;
}

.workspace-empty-btn {
    display: inline-flex;
    align-items: center;

    gap: 7px;

    padding: 10px 15px;

    border-radius: 10px;

    background: #79A9D8;
    color: #FFFFFF !important;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none !important;
}

.workspace-empty-btn:hover {
    background: #5E91C4;
}


/* =========================
   RESPONSIVE
   ========================= */

@media (max-width: 1199px) {

    .workspace-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 767px) {

    .workspace-header {
        flex-direction: column;
        align-items: stretch;
    }

    .workspace-template-btn {
        width: 100%;
    }

    .workspace-title {
        font-size: 24px;
    }

    .workspace-grid {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 420px) {

    .workspace-card-inner {
        padding: 16px;
    }

}

</style>

<?= $this->endSection() ?>
<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="template-header">
    <div>
        <div class="template-eyebrow">SUMBER DAYA AKADEMIK</div>

        <h1 class="template-title">
            Template
        </h1>

        <p class="template-subtitle">
            Temukan dan bagikan template untuk membantu kebutuhan akademikmu.
        </p>
    </div>

    <a href="<?= base_url('templates/create') ?>" class="template-upload-btn">
        <i class="ti ti-upload"></i>
        <span>Upload Template</span>
    </a>
</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>

    <div class="template-alert template-alert-success">
        <i class="ti ti-circle-check"></i>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="template-alert template-alert-danger">
        <i class="ti ti-alert-circle"></i>
        <span><?= esc(session()->getFlashdata('error')) ?></span>
    </div>

<?php endif; ?>


<?php if (empty($templates)): ?>

    <div class="template-empty">

        <div class="template-empty-icon">
            <i class="ti ti-file-description"></i>
        </div>

        <h3>Belum ada template</h3>

        <p>
            Belum ada template yang tersedia saat ini.
            Kamu bisa menjadi yang pertama membagikannya.
        </p>

        <a
            href="<?= base_url('templates/create') ?>"
            class="template-empty-btn"
        >
            <i class="ti ti-upload"></i>
            Upload Template
        </a>

    </div>


<?php else: ?>

    <div class="template-list-header">

        <div>
            <span class="template-list-label">
                SEMUA TEMPLATE
            </span>

            <span class="template-count">
                <?= count($templates) ?> template
            </span>
        </div>

    </div>


    <div class="template-grid">

        <?php foreach ($templates as $index => $template): ?>

            <?php
                $accentClass = ($index % 2 === 0)
                    ? 'template-accent-blue'
                    : 'template-accent-pink';

                $deskripsi = $template['deskripsi'] ?? '';

                if (strlen($deskripsi) > 120) {
                    $deskripsi = substr($deskripsi, 0, 120) . '...';
                }
            ?>

            <div class="template-card <?= $accentClass ?>">

                <div class="template-card-inner">

                    <!-- TOP -->
                    <div class="template-card-top">

                        <div class="template-file-icon">
                            <i class="ti ti-file-description"></i>
                        </div>

                        <span class="template-category">
                            <?= esc($template['kategori']) ?>
                        </span>

                    </div>


                    <!-- TITLE -->
                    <h3 class="template-card-title">
                        <?= esc($template['judul']) ?>
                    </h3>


                    <!-- DESCRIPTION -->
                    <p class="template-card-description">

                        <?php if ($deskripsi !== ''): ?>

                            <?= esc($deskripsi) ?>

                        <?php else: ?>

                            <span class="template-no-description">
                                Tidak ada deskripsi.

                            </span>

                        <?php endif; ?>

                    </p>


                    <!-- META -->
                    <div class="template-meta">

                        <div class="template-meta-item">

                            <span class="template-meta-icon">
                                <i class="ti ti-user"></i>
                            </span>

                            <div>
                                <span class="template-meta-label">
                                    Diunggah oleh
                                </span>

                                <span class="template-meta-value">
                                    <?= esc($template['uploader'] ?? 'Pengguna') ?>
                                </span>
                            </div>

                        </div>


                        <div class="template-meta-item">

                            <span class="template-meta-icon">
                                <i class="ti ti-download"></i>
                            </span>

                            <div>
                                <span class="template-meta-label">
                                    Download
                                </span>

                                <span class="template-meta-value">
                                    <?= (int) $template['downloads_count'] ?>
                                </span>
                            </div>

                        </div>

                    </div>


                    <!-- FOOTER -->
                    <div class="template-card-footer">

                        <div class="template-date">

                            <?php if (!empty($template['created_at'])): ?>

                                <i class="ti ti-calendar"></i>

                                <?= date(
                                    'd M Y',
                                    strtotime($template['created_at'])
                                ) ?>

                            <?php endif; ?>

                        </div>


                        <a
                            href="<?= base_url('templates/' . $template['id_template']) ?>"
                            class="template-detail-btn"
                        >
                            Lihat Detail
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
   COLLABIFY — TEMPLATES
   ===================================================== */

.template-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.template-eyebrow {
    margin-bottom: 6px;

    font-size: 10px;
    font-weight: 700;
    letter-spacing: .12em;

    color: #5E91C4;
}

.template-title {
    margin: 0 0 5px;

    color: #30323A;

    font-size: 28px;
    line-height: 1.2;
    font-weight: 700;
}

.template-subtitle {
    margin: 0;

    color: #77777D;

    font-size: 13px;
}


/* =========================
   UPLOAD BUTTON
   ========================= */

.template-upload-btn {
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

.template-upload-btn:hover {
    background: #5E91C4;

    transform: translateY(-1px);

    box-shadow: 0 9px 20px rgba(94,145,196,.23);
}

.template-upload-btn i {
    font-size: 17px;
}


/* =========================
   ALERT
   ========================= */

.template-alert {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 18px;
    padding: 11px 14px;

    border-radius: 12px;

    font-size: 13px;
    font-weight: 500;
}

.template-alert-success {
    background: #EDF8F1;
    color: #3F7A55;
    border: 1px solid #D8EBDD;
}

.template-alert-danger {
    background: #FFF0F1;
    color: #D95A70;
    border: 1px solid #F6D5D9;
}

.template-alert i {
    font-size: 17px;
}


/* =========================
   LIST HEADER
   ========================= */

.template-list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin: 22px 0 13px;
}

.template-list-header > div {
    display: flex;
    align-items: center;
    gap: 9px;
}

.template-list-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;

    color: #77777D;
}

.template-count {
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

.template-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));

    gap: 16px;
}


/* =========================
   CARD
   ========================= */

.template-card {
    position: relative;

    min-width: 0;

    border: 1px solid rgba(255,255,255,.85);
    border-radius: 17px;

    background: #FFFFFF;

    overflow: hidden;

    box-shadow:
        0 8px 22px rgba(48,50,58,.055),
        inset 0 1px 0 rgba(255,255,255,.8);

    transition:
        transform .18s ease,
        box-shadow .18s ease;
}

.template-card:hover {
    transform: translateY(-3px);

    box-shadow:
        0 14px 30px rgba(48,50,58,.09),
        inset 0 1px 0 rgba(255,255,255,.9);
}


/* decorative accent */

.template-card::before {
    content: "";

    position: absolute;
    top: 0;
    left: 0;
    right: 0;

    height: 4px;
}

.template-accent-blue::before {
    background: #79A9D8;
}

.template-accent-pink::before {
    background: #FF9AA2;
}


.template-card-inner {
    display: flex;
    flex-direction: column;

    min-height: 320px;

    padding: 19px;
}


/* =========================
   CARD TOP
   ========================= */

.template-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 12px;

    margin-bottom: 17px;
}

.template-file-icon {
    width: 44px;
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #EAF3FA;
    color: #5E91C4;

    font-size: 22px;
}

.template-accent-pink .template-file-icon {
    background: #FFF0F1;
    color: #FF677D;
}


.template-category {
    max-width: 55%;

    padding: 5px 9px;

    border-radius: 999px;

    background: #F7F7F7;
    color: #666870;

    font-size: 10px;
    font-weight: 650;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


/* =========================
   TITLE
   ========================= */

.template-card-title {
    margin: 0 0 8px;

    color: #30323A;

    font-size: 17px;
    line-height: 1.4;
    font-weight: 650;

    overflow-wrap: anywhere;
}


/* =========================
   DESCRIPTION
   ========================= */

.template-card-description {
    min-height: 61px;

    margin: 0 0 18px;

    color: #77777D;

    font-size: 12px;
    line-height: 1.65;

    overflow-wrap: anywhere;
}

.template-no-description {
    color: #A0A1A6;
    font-style: italic;
}


/* =========================
   META
   ========================= */

.template-meta {
    display: flex;
    flex-direction: column;
    gap: 10px;

    padding: 13px 0;

    border-top: 1px solid #F0DFE1;
    border-bottom: 1px solid #F0DFE1;
}

.template-meta-item {
    display: flex;
    align-items: center;

    gap: 9px;

    min-width: 0;
}

.template-meta-icon {
    width: 29px;
    height: 29px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #F7F7F7;
    color: #77777D;

    font-size: 14px;
}

.template-accent-blue .template-meta-icon {
    color: #5E91C4;
}

.template-accent-pink .template-meta-icon {
    color: #FF677D;
}

.template-meta-item > div {
    min-width: 0;
}

.template-meta-label {
    display: block;

    margin-bottom: 1px;

    color: #999AA0;

    font-size: 9px;
}

.template-meta-value {
    display: block;

    max-width: 180px;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    color: #555760;

    font-size: 11px;
    font-weight: 600;
}


/* =========================
   FOOTER
   ========================= */

.template-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    margin-top: auto;
    padding-top: 15px;
}

.template-date {
    display: flex;
    align-items: center;
    gap: 5px;

    color: #92939A;

    font-size: 10px;
}

.template-date i {
    font-size: 12px;
}


/* =========================
   DETAIL BUTTON
   ========================= */

.template-detail-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 5px;

    padding: 8px 11px;

    border-radius: 9px;

    font-size: 11px;
    font-weight: 600;

    text-decoration: none !important;

    transition:
        background .18s ease,
        color .18s ease,
        transform .18s ease;
}

.template-accent-blue .template-detail-btn {
    background: #EAF3FA;
    color: #5E91C4 !important;
}

.template-accent-pink .template-detail-btn {
    background: #FFF0F1;
    color: #FF677D !important;
}

.template-detail-btn:hover {
    transform: translateY(-1px);
}

.template-accent-blue .template-detail-btn:hover {
    background: #DCECF8;
}

.template-accent-pink .template-detail-btn:hover {
    background: #FFE3E7;
}

.template-detail-btn i {
    font-size: 14px;
}


/* =========================
   EMPTY STATE
   ========================= */

.template-empty {
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

.template-empty-icon {
    width: 62px;
    height: 62px;

    margin: 0 auto 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background: #EAF3FA;
    color: #5E91C4;

    font-size: 29px;
}

.template-empty h3 {
    margin: 0 0 7px;

    color: #30323A;

    font-size: 18px;
    font-weight: 650;
}

.template-empty p {
    max-width: 430px;

    margin: 0 auto 22px;

    color: #77777D;

    font-size: 13px;
    line-height: 1.6;
}

.template-empty-btn {
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

.template-empty-btn:hover {
    background: #5E91C4;
}


/* =========================
   RESPONSIVE
   ========================= */

@media (max-width: 1199px) {

    .template-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 767px) {

    .template-header {
        flex-direction: column;
        align-items: stretch;
    }

    .template-upload-btn {
        width: 100%;
    }

    .template-title {
        font-size: 24px;
    }

    .template-grid {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 420px) {

    .template-card-inner {
        padding: 16px;
    }

    .template-card-footer {
        align-items: flex-end;
    }

}

</style>

<?= $this->endSection() ?>
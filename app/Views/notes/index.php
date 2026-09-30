<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="notes-header">
    <div>
        <h1 class="notes-title">Catatan</h1>
        <p class="notes-subtitle">
            Simpan ide, informasi, dan hal penting untuk setiap kelompok.
        </p>
    </div>

    <a href="<?= base_url('notes/create') ?>" class="notes-create-btn">
        <i class="ti ti-plus"></i>
        <span>Tambah Catatan</span>
    </a>
</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>

    <div class="notes-alert notes-alert-success">
        <i class="ti ti-circle-check"></i>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="notes-alert notes-alert-danger">
        <i class="ti ti-alert-circle"></i>
        <span><?= esc(session()->getFlashdata('error')) ?></span>
    </div>

<?php endif; ?>


<?php if (empty($notes)): ?>

    <div class="notes-empty">

        <div class="notes-empty-icon">
            <i class="ti ti-notes"></i>
        </div>

        <h3>Belum ada catatan</h3>

        <p>
            Tambahkan catatan untuk membantu kelompokmu mengingat
            ide dan informasi penting.
        </p>

        <a href="<?= base_url('notes/create') ?>" class="notes-empty-btn">
            <i class="ti ti-plus"></i>
            Buat Catatan
        </a>

    </div>


<?php else: ?>

    <div class="notes-list-header">

        <div>
            <span class="notes-list-label">SEMUA CATATAN</span>
            <span class="notes-count">
                <?= count($notes) ?> catatan
            </span>
        </div>

    </div>


    <div class="notes-grid">

        <?php foreach ($notes as $index => $note): ?>

            <?php
                $warna = [
                    'kuning' => '#FFF8C5',
                    'hijau'  => '#E8F5E9',
                    'biru'   => '#E3F2FD',
                    'pink'   => '#FCE4EC',
                ];

                $bg = $warna[$note['warna']] ?? '#FFF8C5';

                /*
                 * Blue / pink alternating accent.
                 * Warna asli catatan tetap dipertahankan sebagai background.
                 */
                $accentClass = ($index % 2 === 0)
                    ? 'note-accent-blue'
                    : 'note-accent-pink';
            ?>

            <div class="note-card <?= $accentClass ?>"
                 style="--note-bg: <?= $bg ?>;">

                <div class="note-card-inner">

                    <!-- TOP -->
                    <div class="note-top">

                        <span class="note-group">
                            <i class="ti ti-users-group"></i>
                            <?= esc($note['nama_kelompok'] ?? 'Kelompok') ?>
                        </span>

                        <span class="note-color">
                            <?= esc($note['warna']) ?>
                        </span>

                    </div>


                    <!-- CONTENT -->
                    <div class="note-content">
                        <?= esc($note['content']) ?>
                    </div>


                    <!-- FOOTER -->
                    <div class="note-footer">

                        <div class="note-author">

                            <div class="note-author-icon">
                                <i class="ti ti-user"></i>
                            </div>

                            <div>

                                <div class="note-author-name">
                                    <?= esc($note['creator_name'] ?? 'Pengguna') ?>
                                </div>

                                <?php if (!empty($note['created_at'])): ?>

                                    <div class="note-date">
                                        <i class="ti ti-clock"></i>
                                        <?= date(
                                            'd M Y, H:i',
                                            strtotime($note['created_at'])
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- DELETE -->
                        <form
                            action="<?= base_url('notes/' . $note['id_note'] . '/delete') ?>"
                            method="post"
                            onsubmit="return confirm('Yakin ingin menghapus catatan ini?');"
                        >

                            <?= csrf_field() ?>

                            <button
                                type="submit"
                                class="note-delete-btn"
                                title="Hapus catatan"
                            >
                                <i class="ti ti-trash"></i>
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>


<style>

/* =====================================================
   COLLABIFY — NOTES
   ===================================================== */

.notes-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.notes-eyebrow {
    margin-bottom: 6px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .12em;
    color: #376590;
}

.notes-title {
    margin: 0 0 5px;
    font-size: 28px;
    line-height: 1.2;
    font-weight: 700;
    color: #30323A;
}

.notes-subtitle {
    margin: 0;
    color: #62666D;
    font-size: 13px;
}


/* =========================
   CREATE BUTTON
   ========================= */

.notes-create-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    min-height: 40px;
    padding: 0 16px;

    border-radius: 11px;

    background: #4477A6;
    color: #FFFFFF !important;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none !important;

    box-shadow: 0 6px 16px rgba(94,145,196,.18);

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        background .18s ease;
}

.notes-create-btn:hover {
    background: #5E91C4;
    transform: translateY(-1px);
    box-shadow: 0 9px 20px rgba(94,145,196,.23);
}

.notes-create-btn i {
    font-size: 17px;
}


/* =========================
   ALERT
   ========================= */

.notes-alert {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 18px;
    padding: 11px 14px;

    border-radius: 12px;

    font-size: 13px;
    font-weight: 500;
}

.notes-alert-success {
    background: #EDF8F1;
    color: #3F7A55;
    border: 1px solid #D8EBDD;
}

.notes-alert-danger {
    background: #FFF0F1;
    color: #B23A52;
    border: 1px solid #F6D5D9;
}

.notes-alert i {
    font-size: 17px;
}


/* =========================
   LIST HEADER
   ========================= */

.notes-list-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin: 22px 0 13px;
}

.notes-list-header > div {
    display: flex;
    align-items: center;
    gap: 9px;
}

.notes-list-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    color: #62666D;
}

.notes-count {
    padding: 3px 8px;
    border-radius: 999px;

    background: #F7F7F7;
    color: #62666D;

    font-size: 11px;
    font-weight: 600;
}


/* =========================
   NOTES GRID
   ========================= */

.notes-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}


/* =========================
   NOTE CARD
   ========================= */

.note-card {
    position: relative;

    min-width: 0;
    min-height: 245px;

    border: 1px solid rgba(255,255,255,.85);
    border-radius: 17px;

    background: var(--note-bg);

    overflow: hidden;

    box-shadow:
        0 8px 22px rgba(48,50,58,.055),
        inset 0 1px 0 rgba(255,255,255,.7);

    transition:
        transform .18s ease,
        box-shadow .18s ease;
}

.note-card:hover {
    transform: translateY(-3px);

    box-shadow:
        0 14px 30px rgba(48,50,58,.09),
        inset 0 1px 0 rgba(255,255,255,.8);
}


/* decorative top line */

.note-card::before {
    content: "";

    position: absolute;
    top: 0;
    left: 0;
    right: 0;

    height: 4px;
}

.note-accent-blue::before {
    background: #79A9D8;
}

.note-accent-pink::before {
    background: #FF9AA2;
}


.note-card-inner {
    display: flex;
    flex-direction: column;

    height: 100%;
    min-height: 245px;

    padding: 18px;
}


/* =========================
   NOTE TOP
   ========================= */

.note-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 10px;

    margin-bottom: 16px;
}

.note-group {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    max-width: 72%;

    padding: 5px 9px;

    border-radius: 999px;

    background: rgba(255,255,255,.62);
    color: #5F6168;

    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.note-group i {
    flex-shrink: 0;
    font-size: 14px;
    color: #376590;
}

.note-accent-pink .note-group i {
    color: #B23A52;
}

.note-color {
    flex-shrink: 0;

    font-size: 10px;
    color: rgba(48,50,58,.45);

    text-transform: capitalize;
}


/* =========================
   NOTE CONTENT
   ========================= */

.note-content {
    flex: 1;

    color: #30323A;

    font-size: 14px;
    line-height: 1.7;

    white-space: pre-line;

    overflow-wrap: anywhere;
}


/* =========================
   FOOTER
   ========================= */

.note-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 12px;

    margin-top: 18px;
    padding-top: 13px;

    border-top: 1px solid rgba(48,50,58,.09);
}

.note-author {
    display: flex;
    align-items: center;

    min-width: 0;

    gap: 8px;
}

.note-author-icon {
    flex-shrink: 0;

    width: 31px;
    height: 31px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(255,255,255,.65);
    color: #376590;

    font-size: 15px;
}

.note-accent-pink .note-author-icon {
    color: #B23A52;
}

.note-author-name {
    max-width: 145px;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    color: #555760;

    font-size: 11px;
    font-weight: 600;
}

.note-date {
    display: flex;
    align-items: center;
    gap: 4px;

    margin-top: 2px;

    color: #888990;
    font-size: 10px;
}

.note-date i {
    font-size: 11px;
}


/* =========================
   DELETE
   ========================= */

.note-delete-btn {
    width: 34px;
    height: 34px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255,103,125,.22);
    border-radius: 9px;

    background: rgba(255,255,255,.52);
    color: #B23A52;

    cursor: pointer;

    transition:
        background .18s ease,
        color .18s ease,
        transform .18s ease;
}

.note-delete-btn:hover {
    background: #FFF0F1;
    color: #B23A52;

    transform: translateY(-1px);
}

.note-delete-btn i {
    font-size: 16px;
}


/* =========================
   EMPTY STATE
   ========================= */

.notes-empty {
    margin-top: 18px;
    padding: 56px 24px;

    text-align: center;

    border: 1px solid #F0DFE1;
    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.92),
            rgba(255,248,247,.88)
        );

    box-shadow:
        0 8px 24px rgba(48,50,58,.045);
}

.notes-empty-icon {
    width: 62px;
    height: 62px;

    margin: 0 auto 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background: #EAF3FA;
    color: #376590;

    font-size: 29px;
}

.notes-empty h3 {
    margin: 0 0 7px;

    color: #30323A;

    font-size: 18px;
    font-weight: 650;
}

.notes-empty p {
    max-width: 430px;

    margin: 0 auto 22px;

    color: #62666D;

    font-size: 13px;
    line-height: 1.6;
}

.notes-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 10px 15px;

    border-radius: 10px;

    background: #4477A6;
    color: #FFFFFF !important;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none !important;
}

.notes-empty-btn:hover {
    background: #5E91C4;
}


/* =========================
   RESPONSIVE
   ========================= */

@media (max-width: 1199px) {

    .notes-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 767px) {

    .notes-header {
        align-items: stretch;
        flex-direction: column;
    }

    .notes-create-btn {
        width: 100%;
        justify-content: center;
    }

    .notes-title {
        font-size: 24px;
    }

    .notes-grid {
        grid-template-columns: 1fr;
    }

    .note-card,
    .note-card-inner {
        min-height: 225px;
    }

}


@media (max-width: 420px) {

    .notes-list-header > div {
        flex-wrap: wrap;
    }

    .note-card-inner {
        padding: 16px;
    }

}

</style>

<?= $this->endSection() ?>
<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="d-flex justify-content-between align-items-center flex-wrap">

    <div>

        <h1 class="page-title mb-1">
            Tugas
        </h1>

        <p class="page-sub mb-0">
            Kelola tugas dan deadline kelompokmu.
        </p>
    </div>


    <div class="mt-2 mt-md-0">

        <a href="<?= base_url('tasks/create') ?>"
           class="task-create-btn">

            <i class="ti ti-plus"></i>

            <span>
                Tambah Tugas
            </span>

        </a>

    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>


<?php if (session()->getFlashdata('success')): ?>

    <div class="task-alert task-alert-success">

        <i class="ti ti-circle-check"></i>

        <span>
            <?= esc(session()->getFlashdata('success')) ?>
        </span>

    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="task-alert task-alert-danger">

        <i class="ti ti-alert-circle"></i>

        <span>
            <?= esc(session()->getFlashdata('error')) ?>
        </span>

    </div>

<?php endif; ?>


<?php if (empty($tasks)): ?>


    <!-- EMPTY STATE -->

    <div class="task-empty">

        <div class="task-empty-icon">
            <i class="ti ti-checklist"></i>
        </div>

        <h3>
            Belum ada tugas
        </h3>

        <p>
            Tambahkan tugas pertama untuk mulai mengatur pekerjaan kelompok.
        </p>

        <a href="<?= base_url('tasks/create') ?>"
           class="task-create-btn">

            <i class="ti ti-plus"></i>

            Tambah Tugas

        </a>

    </div>


<?php else: ?>


    <!-- LIST HEADER -->

    <div class="task-list-header">

        <div class="task-list-title">
            Semua Tugas
        </div>

        <div class="task-count">
            <?= count($tasks) ?> tugas
        </div>

    </div>


    <!-- TASK GRID -->

    <div class="row task-grid">

        <?php foreach ($tasks as $task): ?>

            <?php

                $status = $task['status'] ?? 'todo';

                $statusLabel = [
                    'todo'        => 'Belum dikerjakan',
                    'in_progress' => 'Sedang dikerjakan',
                    'done'        => 'Selesai',
                ][$status] ?? ucfirst($status);


                $statusClass = [
                    'todo'        => 'status-todo',
                    'in_progress' => 'status-progress',
                    'done'        => 'status-done',
                ][$status] ?? 'status-todo';


                $isOverdue = false;

                if (!empty($task['deadline']) && $status !== 'done') {

                    $isOverdue =
                        strtotime($task['deadline'])
                        <
                        strtotime(date('Y-m-d'));

                }

            ?>


            <div class="col-12 col-md-6 col-xl-4 mb-4">

                <div class="task-card h-100">


                    <div class="task-card-body">


                        <!-- TOP -->

                        <div class="task-card-top">

                            <span class="task-status <?= $statusClass ?>">

                                <?php if ($status === 'done'): ?>

                                    <i class="ti ti-circle-check"></i>

                                <?php elseif ($status === 'in_progress'): ?>

                                    <i class="ti ti-loader-2"></i>

                                <?php else: ?>

                                    <i class="ti ti-circle"></i>

                                <?php endif; ?>

                                <?= esc($statusLabel) ?>

                            </span>


                            <?php if ($isOverdue): ?>

                                <span class="task-overdue">

                                    <i class="ti ti-alert-triangle"></i>

                                    Terlambat

                                </span>

                            <?php endif; ?>

                        </div>


                        <!-- TITLE -->

                        <h3 class="task-title">
                            <?= esc($task['judul']) ?>
                        </h3>


                        <!-- DESCRIPTION -->

                        <?php if (!empty($task['deskripsi'])): ?>

                            <p class="task-description">

                                <?= esc(
                                    mb_strimwidth(
                                        $task['deskripsi'],
                                        0,
                                        110,
                                        '...'
                                    )
                                ) ?>

                            </p>

                        <?php else: ?>

                            <p class="task-description task-description-empty">
                                Tidak ada deskripsi tugas.
                            </p>

                        <?php endif; ?>


                        <!-- INFO -->

                        <div class="task-info">


                            <!-- GROUP -->

                            <div class="task-info-item">

                                <span class="task-info-icon blue">
                                    <i class="ti ti-users"></i>
                                </span>

                                <div class="task-info-text">

                                    <span class="task-info-label">
                                        Kelompok
                                    </span>

                                    <span class="task-info-value">
                                        <?= esc(
                                            $task['nama_kelompok']
                                            ?? 'Tanpa kelompok'
                                        ) ?>
                                    </span>

                                </div>

                            </div>


                            <!-- DEADLINE -->

                            <?php if (!empty($task['deadline'])): ?>

                                <div class="task-info-item">

                                    <span class="task-info-icon <?= $isOverdue ? 'pink' : 'blue' ?>">

                                        <i class="ti ti-calendar"></i>

                                    </span>

                                    <div class="task-info-text">

                                        <span class="task-info-label">
                                            Deadline
                                        </span>

                                        <span class="task-info-value <?= $isOverdue ? 'deadline-overdue' : '' ?>">

                                            <?= date(
                                                'd M Y',
                                                strtotime($task['deadline'])
                                            ) ?>

                                        </span>

                                    </div>

                                </div>

                            <?php else: ?>

                                <div class="task-info-item">

                                    <span class="task-info-icon">

                                        <i class="ti ti-calendar-off"></i>

                                    </span>

                                    <div class="task-info-text">

                                        <span class="task-info-label">
                                            Deadline
                                        </span>

                                        <span class="task-info-value">
                                            Tanpa deadline
                                        </span>

                                    </div>

                                </div>

                            <?php endif; ?>


                            <!-- ASSIGNED -->

                            <?php if (!empty($task['assigned_name'])): ?>

                                <div class="task-info-item">

                                    <span class="task-info-icon">

                                        <i class="ti ti-user"></i>

                                    </span>

                                    <div class="task-info-text">

                                        <span class="task-info-label">
                                            Dikerjakan oleh
                                        </span>

                                        <span class="task-info-value">
                                            <?= esc($task['assigned_name']) ?>
                                        </span>

                                    </div>

                                </div>

                            <?php endif; ?>


                        </div>


                        <!-- DETAIL BUTTON -->

                        <a href="<?= base_url('tasks/' . $task['id_task']) ?>"
                           class="task-detail-btn">

                            <span>
                                Lihat Detail
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
   TASK PAGE
   ===================================================== */

.task-eyebrow {

    display: flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 7px;

    font-size: 11px;
    font-weight: 600;

    letter-spacing: .14em;

    color: #376590;
}

.task-eyebrow i {
    font-size: 14px;
}


/* =====================================================
   CREATE BUTTON
   ===================================================== */

.task-create-btn {

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 40px;

    padding: 0 16px;

    border-radius: 12px;

    background: #4477A6;

    border: 1px solid #5E91C4;

    color: #fff !important;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none !important;

    box-shadow:
        0 7px 18px rgba(94,145,196,.18);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.task-create-btn:hover {

    background: #4477A6;

    border-color: #4F83B6;

    color: #fff !important;

    transform: translateY(-2px);

    box-shadow:
        0 10px 23px rgba(94,145,196,.24);
}

.task-create-btn i {
    font-size: 16px;
}


/* =====================================================
   ALERT
   ===================================================== */

.task-alert {

    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 18px;

    padding: 12px 15px;

    border-radius: 14px;

    font-size: 13px;

    border: 0;

    box-shadow:
        0 6px 18px rgba(0,0,0,.04);
}

.task-alert-success {
    color: #376590;
}

.task-alert-danger {
    color: #B23A52;
}

.task-alert i {
    font-size: 17px;
}


/* =====================================================
   LIST HEADER
   ===================================================== */

.task-list-header {

    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-top: 28px;
    margin-bottom: 14px;

    padding: 0 2px;
}

.task-list-title {

    font-size: 15px;
    font-weight: 600;

    color: #30323A;
}

.task-count {

    font-size: 12px;

    color: #62666D;
}


/* =====================================================
   TASK CARD
   ===================================================== */

.task-card {

    position: relative;

    height: 100%;

    overflow: hidden;

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

.task-card::after {

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

.task-card:hover {

    transform: translateY(-4px);

    box-shadow:
        0 15px 32px rgba(94,145,196,.13),
        inset 0 1px 0 rgba(255,255,255,.95);
}


/* =====================================================
   ALTERNATING PINK CARDS
   ===================================================== */

.task-grid > div:nth-child(even) .task-card::after {

    background: rgba(255,154,162,.09);
}


/* =====================================================
   CARD BODY
   ===================================================== */

.task-card-body {

    position: relative;
    z-index: 1;

    padding: 20px;
}


/* =====================================================
   TOP
   ===================================================== */

.task-card-top {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 10px;

    margin-bottom: 16px;
}


/* =====================================================
   STATUS
   ===================================================== */

.task-status {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 10px;

    border-radius: 999px;

    font-size: 10.5px;

    font-weight: 600;

    line-height: 1;
}

.task-status i {
    font-size: 13px;
}


/* Todo */

.status-todo {

    background: #F2F3F5;

    color: #62666D;
}


/* In progress */

.status-progress {

    background: #FFF7DC;

    color: #B18425;
}


/* Done */

.status-done {

    background: #EAF3FA;

    color: #376590;
}


/* =====================================================
   OVERDUE
   ===================================================== */

.task-overdue {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 9px;

    border-radius: 999px;

    background: #FFF0F1;

    color: #B23A52;

    font-size: 10.5px;

    font-weight: 600;

    white-space: nowrap;
}

.task-overdue i {
    font-size: 13px;
}


/* =====================================================
   TITLE
   ===================================================== */

.task-title {

    margin: 0 0 8px;

    font-size: 18px;

    line-height: 1.35;

    font-weight: 650;

    color: #30323A;

    letter-spacing: -.01em;

    word-break: break-word;
}


/* =====================================================
   DESCRIPTION
   ===================================================== */

.task-description {

    min-height: 42px;

    margin: 0 0 19px;

    color: #62666D;

    font-size: 13px;

    line-height: 1.6;
}

.task-description-empty {

    color: #A2A2A8;

    font-style: italic;
}


/* =====================================================
   INFO
   ===================================================== */

.task-info {

    display: flex;

    flex-direction: column;

    gap: 10px;

    padding-top: 14px;

    border-top: 1px solid #F0DFE1;
}


/* =====================================================
   INFO ITEM
   ===================================================== */

.task-info-item {

    display: flex;

    align-items: center;

    gap: 9px;

    min-width: 0;
}

.task-info-icon {

    width: 30px;
    height: 30px;

    flex: 0 0 30px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background: #F3F7FA;

    color: #8A9AA8;
}

.task-info-icon i {
    font-size: 15px;
}


/* Blue */

.task-info-icon.blue {

    background: #EAF3FA;

    color: #376590;
}


/* Pink */

.task-info-icon.pink {

    background: #FFF0F1;

    color: #B23A52;
}


/* =====================================================
   INFO TEXT
   ===================================================== */

.task-info-text {

    min-width: 0;

    display: flex;

    flex-direction: column;

    gap: 2px;
}

.task-info-label {

    font-size: 10px;

    color: #A0A0A6;

    text-transform: uppercase;

    letter-spacing: .04em;
}

.task-info-value {

    min-width: 0;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #555860;

    font-size: 12px;

    font-weight: 500;
}


/* =====================================================
   OVERDUE DATE
   ===================================================== */

.deadline-overdue {

    color: #B23A52;
}


/* =====================================================
   DETAIL BUTTON
   ===================================================== */

.task-detail-btn {

    position: relative;

    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    width: 100%;

    margin-top: 17px;

    padding: 11px 13px;

    border-radius: 12px;

    background: #EAF3FA;

    color: #376590;

    font-size: 13px;

    font-weight: 600;

    text-decoration: none !important;

    transition:
        background .2s ease,
        color .2s ease;
}

.task-detail-btn i {

    font-size: 17px;

    transition:
        transform .2s ease;
}

.task-detail-btn:hover {

    background: #DDECF8;

    color: #376590;

    text-decoration: none;
}

.task-detail-btn:hover i {

    transform: translateX(3px);
}


/* =====================================================
   ALTERNATING PINK BUTTON
   ===================================================== */

.task-grid > div:nth-child(even) .task-detail-btn {

    background: #FFF0F1;

    color: #B23A52;
}

.task-grid > div:nth-child(even) .task-detail-btn:hover {

    background: #FFE2E5;

    color: #B23A52;
}


/* =====================================================
   EMPTY STATE
   ===================================================== */

.task-empty {

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

.task-empty-icon {

    width: 58px;
    height: 58px;

    margin: 0 auto 15px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 17px;

    background: #EAF3FA;

    color: #376590;

    font-size: 27px;
}

.task-empty h3 {

    margin-bottom: 7px;

    font-size: 18px;

    font-weight: 600;

    color: #30323A;
}

.task-empty p {

    margin-bottom: 22px;

    color: #62666D;

    font-size: 13px;
}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 767px) {

    .task-card-body {
        padding: 18px;
    }

    .task-card-top {
        flex-wrap: wrap;
    }

}


@media (max-width: 480px) {

    .task-card-top {
        align-items: flex-start;
    }

    .task-status,
    .task-overdue {
        font-size: 10px;
    }

}

</style>


<?= $this->endSection() ?>
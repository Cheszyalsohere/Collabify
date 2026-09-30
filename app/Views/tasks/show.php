<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div>
    <div class="mb-2">
        <a href="<?= base_url('tasks') ?>" class="text-muted">
            <i class="ti ti-arrow-left mr-1"></i>
            Semua Tugas
        </a>
    </div>

    <div class="page-eyebrow">TASK MANAGEMENT</div>
    <h1 class="page-title mb-1">
        <?= esc($task['judul']) ?>
    </h1>

    <p class="page-sub mb-0">
        Detail tugas kelompok
    </p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
    $status = $task['status'] ?? 'todo';

    $statusLabel = [
        'todo'        => 'Belum dikerjakan',
        'in_progress' => 'Sedang dikerjakan',
        'done'        => 'Selesai',
    ][$status] ?? ucfirst($status);

    $statusClass = [
        'todo'        => 'badge-secondary',
        'in_progress' => 'badge-warning',
        'done'        => 'badge-success',
    ][$status] ?? 'badge-secondary';

    $isOverdue = false;

    if (!empty($task['deadline']) && $status !== 'done') {
        $isOverdue = strtotime($task['deadline']) < strtotime(date('Y-m-d'));
    }
?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="ti ti-circle-check mr-2"></i>
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="ti ti-alert-circle mr-2"></i>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div class="row">

    <div class="col-12 col-lg-8">

        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start mb-4">
                    <span class="badge <?= $statusClass ?>">
                        <?= esc($statusLabel) ?>
                    </span>

                    <?php if ($isOverdue): ?>
                        <span class="badge badge-danger">
                            <i class="ti ti-alert-triangle mr-1"></i>
                            Terlambat
                        </span>
                    <?php endif; ?>
                </div>

                <h2 class="detail-title">
                    <?= esc($task['judul']) ?>
                </h2>

                <div class="description-box">
                    <?php if (!empty($task['deskripsi'])): ?>
                        <?= nl2br(esc($task['deskripsi'])) ?>
                    <?php else: ?>
                        <span class="text-muted">
                            Tidak ada deskripsi tugas.
                        </span>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

    <div class="col-12 col-lg-4">

        <div class="card">
            <div class="card-body">

                <h3 class="side-title">
                    Informasi Tugas
                </h3>

                <div class="detail-item">
                    <span class="detail-label">
                        <i class="ti ti-users mr-1"></i>
                        Kelompok
                    </span>

                    <span class="detail-value">
                        <?= esc($task['nama_kelompok'] ?? '-') ?>
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        <i class="ti ti-calendar mr-1"></i>
                        Deadline
                    </span>

                    <span class="detail-value <?= $isOverdue ? 'text-danger' : '' ?>">
                        <?php if (!empty($task['deadline'])): ?>
                            <?= date('d M Y', strtotime($task['deadline'])) ?>
                        <?php else: ?>
                            Tidak ada
                        <?php endif; ?>
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">
                        <i class="ti ti-user mr-1"></i>
                        Ditugaskan kepada
                    </span>

                    <span class="detail-value">
                        <?= esc($task['assigned_name'] ?? 'Belum ditentukan') ?>
                    </span>
                </div>

                <hr>

                <h3 class="side-title mb-3">
                    Update Status
                </h3>

                <form action="<?= base_url('tasks/' . $task['id_task'] . '/status') ?>"
                      method="post">

                    <?= csrf_field() ?>

                    <select name="status"
                            class="form-control mb-3">

                        <option value="todo"
                            <?= $status === 'todo' ? 'selected' : '' ?>>
                            Belum dikerjakan
                        </option>

                        <option value="in_progress"
                            <?= $status === 'in_progress' ? 'selected' : '' ?>>
                            Sedang dikerjakan
                        </option>

                        <option value="done"
                            <?= $status === 'done' ? 'selected' : '' ?>>
                            Selesai
                        </option>

                    </select>

                    <button type="submit"
                            class="btn btn-primary btn-block">
                        <i class="ti ti-refresh mr-1"></i>
                        Perbarui Status
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

<style>
.detail-title {
    font-size: 22px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 20px;
}

.description-box {
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 18px;
    color: var(--ink);
    font-size: 14px;
    line-height: 1.7;
    min-height: 120px;
}

.side-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 18px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}

.detail-item:last-of-type {
    border-bottom: none;
}

.detail-label {
    color: var(--muted);
    font-size: 12px;
}

.detail-label i {
    color: var(--forest);
}

.detail-value {
    color: var(--ink);
    font-size: 13px;
    font-weight: 500;
}
</style>

<?= $this->endSection() ?>

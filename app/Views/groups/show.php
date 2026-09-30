<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <div>
        <div class="mb-2">
            <a href="<?= base_url('groups') ?>" class="text-muted">
                <i class="ti ti-arrow-left mr-1"></i>
                Semua Kelompok
            </a>
        </div>
        <h1 class="page-title mb-1">
            <?= esc($group['nama_kelompok']) ?>
        </h1>

        <p class="page-sub mb-0">
            Ruang kolaborasi kelompok
        </p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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

    <!-- INFO KELOMPOK -->
    <div class="col-12 col-lg-4">

        <div class="card">
            <div class="card-body">

                <div class="group-icon mb-3">
                    <i class="ti ti-users-group"></i>
                </div>

                <h3 class="group-name">
                    <?= esc($group['nama_kelompok']) ?>
                </h3>

                <p class="text-muted mb-4">
                    Dibuat
                    <?= !empty($group['created_at'])
                        ? date('d M Y', strtotime($group['created_at']))
                        : '-' ?>
                </p>

                <label>Kode Invite</label>

                <div class="invite-box">
                    <span id="inviteCode">
                        <?= esc($group['kode_invite']) ?>
                    </span>

                    <button
                        type="button"
                        class="btn btn-sm btn-light"
                        onclick="copyInvite()"
                        title="Salin kode">
                        <i class="ti ti-copy"></i>
                    </button>
                </div>

                <small class="text-muted d-block mt-2">
                    Bagikan kode ini kepada teman yang ingin bergabung.
                </small>

            </div>
        </div>

    </div>

    <!-- ANGGOTA -->
    <div class="col-12 col-lg-8">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="ti ti-users mr-1"></i>
                    Anggota Kelompok
                </h3>

                <span class="badge badge-secondary">
                    <?= count($members) ?> anggota
                </span>
            </div>

            <div class="card-body p-0">

                <?php if (empty($members)): ?>

                    <div class="text-center py-5">
                        <i class="ti ti-users-off"
                           style="font-size:32px;color:var(--faint);"></i>

                        <p class="text-muted mt-2 mb-0">
                            Belum ada anggota.
                        </p>
                    </div>

                <?php else: ?>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Anggota</th>
                                    <th>Email</th>
                                    <th>Peran</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($members as $member): ?>
                                    <tr>

                                        <td>
                                            <div class="member-name">
                                                <?= esc($member['name']) ?>
                                            </div>
                                        </td>

                                        <td class="text-muted">
                                            <?= esc($member['email']) ?>
                                        </td>

                                        <td>
                                            <?php if ($member['peran'] === 'ketua'): ?>
                                                <span class="badge badge-success">
                                                    Ketua
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">
                                                    Anggota
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-muted">
                                            <?= !empty($member['joined_at'])
                                                ? date('d M Y', strtotime($member['joined_at']))
                                                : '-' ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>

</div>

<!-- WORKSPACE KELOMPOK -->
<div class="card mt-3">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title mb-0">
            <i class="ti ti-folder-open mr-1"></i>
            Workspace Kelompok
        </h3>

        <span class="badge badge-success">
            <?= count($workspaces ?? []) ?> workspace
        </span>

    </div>


    <div class="card-body">

        <?php if (empty($workspaces)): ?>

            <div class="text-center py-4">

                <div
                    class="workspace-empty-icon"
                >
                    <i class="ti ti-folder-off"></i>
                </div>

                <p class="text-muted mt-3 mb-1">
                    Belum ada workspace kelompok.
                </p>

                <small class="text-muted">
                    Gunakan template untuk membuat
                    workspace pertama kelompok ini.
                </small>

            </div>

        <?php else: ?>

            <div class="workspace-list">

                <?php foreach ($workspaces as $workspace): ?>

                    <div class="workspace-item">

                        <div class="workspace-item-left">

                            <div class="workspace-icon">
                                <i class="ti ti-file-text"></i>
                            </div>

                            <div>

                                <div class="workspace-title">
                                    <?= esc(
                                        $workspace['judul']
                                    ) ?>
                                </div>

                                <div class="workspace-meta">

                                    Template:
                                    <?= esc(
                                        $workspace['template_asal']
                                        ?? '-'
                                    ) ?>

                                    <span class="mx-1">
                                        •
                                    </span>

                                    Dibuat oleh
                                    <?= esc(
                                        $workspace['pembuat']
                                        ?? '-'
                                    ) ?>

                                </div>

                            </div>

                        </div>


                        <a
                            href="<?= base_url(
                                'workspaces/' .
                                $workspace['id_workspace']
                            ) ?>"
                            class="btn btn-success btn-sm"
                        >

                            <i class="ti ti-folder-open mr-1"></i>

                            Buka Workspace

                        </a>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</div>


<style>
.group-icon {
    width: 48px;
    height: 48px;
    border-radius: 13px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.group-name {
    font-size: 20px;
    font-weight: 600;
    color: var(--ink);
}

.invite-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px dashed var(--border-2);
    background: var(--paper);
    border-radius: 10px;
    padding: 9px 10px 9px 14px;
}

.invite-box span {
    font-family: var(--mono);
    font-size: 18px;
    font-weight: 600;
    letter-spacing: .12em;
    color: var(--forest);
}

.member-name {
    font-weight: 500;
    color: var(--ink);
}


/* WORKSPACE */

.workspace-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.workspace-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 16px;
    border: 1px solid var(--border-2);
    border-radius: 12px;
    background: var(--paper);
    transition: .15s ease;
}

.workspace-item:hover {
    border-color: var(--forest);
    transform: translateY(-1px);
}

.workspace-item-left {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.workspace-icon {
    width: 44px;
    height: 44px;
    flex-shrink: 0;
    border-radius: 11px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
}

.workspace-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--ink);
}

.workspace-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    color: var(--muted);
    font-size: 13px;
}

.workspace-dot {
    opacity: .5;
}

.workspace-item-right {
    flex-shrink: 0;
}

.workspace-empty-icon {
    width: 58px;
    height: 58px;
    margin: 0 auto;
    border-radius: 15px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}

@media (max-width: 576px) {

    .workspace-item {
        align-items: flex-start;
        flex-direction: column;
    }

    .workspace-item-right {
        width: 100%;
    }

    .workspace-item-right .btn {
        width: 100%;
    }

}
.workspace-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.workspace-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 14px;
    border: 1px solid var(--border-2);
    border-radius: 12px;
    background: var(--paper);
}

.workspace-item-left {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.workspace-icon {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border-radius: 10px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.workspace-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 3px;
}

.workspace-meta {
    color: var(--muted);
    font-size: 12px;
}

.workspace-empty-icon {
    width: 46px;
    height: 46px;
    margin: 0 auto;
    border-radius: 12px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
}
</style>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>
function copyInvite() {
    const code = document.getElementById('inviteCode').innerText.trim();

    navigator.clipboard.writeText(code).then(function () {

        const btn = document.querySelector('.invite-box button');
        const original = btn.innerHTML;

        btn.innerHTML = '<i class="ti ti-check"></i>';

        setTimeout(function () {
            btn.innerHTML = original;
        }, 1500);

    });
}
</script>

<?= $this->endSection() ?>
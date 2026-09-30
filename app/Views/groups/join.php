<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div>
    <div class="page-eyebrow">COLLABORATION SPACE</div>
    <h1 class="page-title mb-1">Gabung Kelompok</h1>
    <p class="page-sub mb-0">Masukkan kode invite dari kelompokmu.</p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card">
            <div class="card-body">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle mr-2"></i>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="join-icon">
                    <i class="ti ti-link"></i>
                </div>

                <div class="text-center mb-4">
                    <h3 class="join-title">Punya kode invite?</h3>
                    <p class="text-muted mb-0">
                        Masukkan kode 6 karakter yang diberikan oleh ketua kelompok.
                    </p>
                </div>

                <form action="<?= base_url('groups/join') ?>" method="post">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="kode_invite">Kode Invite</label>

                        <input
                            type="text"
                            id="kode_invite"
                            name="kode_invite"
                            class="form-control invite-input"
                            value="<?= old('kode_invite') ?>"
                            placeholder="Contoh: A1B2C3"
                            maxlength="6"
                            autocomplete="off"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="ti ti-login mr-1"></i>
                        Gabung Kelompok
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="<?= base_url('groups') ?>" class="text-muted">
                        Kembali ke daftar kelompok
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.join-icon {
    width: 56px;
    height: 56px;
    margin: 5px auto 18px;
    border-radius: 15px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 27px;
}

.join-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--ink);
}

.invite-input {
    text-align: center;
    font-family: var(--mono) !important;
    font-size: 20px !important;
    font-weight: 600;
    letter-spacing: .18em;
    text-transform: uppercase;
}
</style>

<?= $this->endSection() ?>

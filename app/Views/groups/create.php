<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div>
    <div class="page-eyebrow">COLLABORATION SPACE</div>
    <h1 class="page-title mb-1">Buat Kelompok</h1>
    <p class="page-sub mb-0">Buat ruang kolaborasi baru untuk timmu.</p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card">
            <div class="card-body">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <strong>Periksa kembali:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('groups/store') ?>" method="post">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="nama_kelompok">
                            Nama Kelompok
                        </label>

                        <input
                            type="text"
                            id="nama_kelompok"
                            name="nama_kelompok"
                            class="form-control"
                            value="<?= old('nama_kelompok') ?>"
                            placeholder="Contoh: Kelompok Penelitian A"
                            maxlength="150"
                            required
                        >

                        <small class="form-text text-muted">
                            Gunakan nama yang mudah dikenali oleh anggota kelompok.
                        </small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url('groups') ?>" class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus mr-1"></i>
                            Buat Kelompok
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

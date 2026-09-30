<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div>
    <h1 class="page-title mb-1">Tambah Catatan</h1>
    <p class="page-sub mb-0">
        Buat catatan baru untuk kelompokmu.
    </p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>

        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <form action="<?= base_url('notes/store') ?>" method="post">

                    <?= csrf_field() ?>

                    <!-- KELOMPOK -->
                    <div class="form-group">

                        <label for="id_group">
                            Kelompok
                        </label>

                        <select
                            name="id_group"
                            id="id_group"
                            class="form-control"
                            required
                        >
                            <option value="">Pilih kelompok...</option>

                            <?php foreach ($groups as $group): ?>

                                <option
                                    value="<?= $group['id_group'] ?>"
                                    <?= old('id_group') == $group['id_group'] ? 'selected' : '' ?>
                                >
                                    <?= esc($group['nama_kelompok']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- WARNA -->
                    <div class="form-group">

                        <label for="warna">
                            Warna Catatan
                        </label>

                        <div class="row">

                            <?php
                                $colors = [
                                    'kuning' => 'Kuning',
                                    'hijau'  => 'Hijau',
                                    'biru'   => 'Biru',
                                    'pink'   => 'Pink',
                                ];
                            ?>

                            <?php foreach ($colors as $value => $label): ?>

                                <div class="col-md-3 col-6 mb-2">

                                    <label
                                        class="w-100"
                                        style="cursor:pointer;"
                                    >

                                        <input
                                            type="radio"
                                            name="warna"
                                            value="<?= $value ?>"
                                            <?= old('warna', 'kuning') === $value ? 'checked' : '' ?>
                                        >

                                        <span class="ml-1">
                                            <?= $label ?>
                                        </span>

                                    </label>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <!-- ISI CATATAN -->
                    <div class="form-group">

                        <label for="content">
                            Isi Catatan
                        </label>

                        <textarea
                            name="content"
                            id="content"
                            rows="8"
                            class="form-control"
                            placeholder="Tulis catatan penting di sini..."
                            required
                        ><?= esc(old('content')) ?></textarea>

                        <small class="text-muted">
                            Maksimal 5000 karakter.
                        </small>

                    </div>


                    <!-- BUTTON -->
                    <div class="d-flex justify-content-between mt-4">

                        <a
                            href="<?= base_url('notes') ?>"
                            class="btn btn-light"
                        >
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="fas fa-save mr-1"></i>
                            Simpan Catatan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>
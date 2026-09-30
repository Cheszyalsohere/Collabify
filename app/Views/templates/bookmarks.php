<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div>
    <div class="page-eyebrow">SUMBER DAYA AKADEMIK</div>
    <h1 class="page-title mb-1">Template Tersimpan</h1>

    <p class="page-sub mb-0">
        Template yang kamu simpan untuk digunakan nanti.
    </p>
</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>

<?php endif; ?>


<div class="row">

    <?php if (empty($templates)): ?>

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-5">

                    <i class="far fa-bookmark fa-3x text-muted mb-3"></i>

                    <h4>
                        Belum ada template tersimpan
                    </h4>

                    <p class="text-muted mb-4">
                        Simpan template yang menarik agar mudah
                        ditemukan kembali.
                    </p>

                    <a
                        href="<?= base_url('templates') ?>"
                        class="btn btn-success"
                    >
                        <i class="fas fa-file-alt mr-1"></i>
                        Jelajahi Template
                    </a>

                </div>

            </div>

        </div>

    <?php else: ?>

        <?php foreach ($templates as $template): ?>

            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                <div class="card h-100 border-0 shadow-sm">

                    <div class="card-body">

                        <div class="mb-3">

                            <span class="badge badge-success">
                                <?= esc($template['kategori']) ?>
                            </span>

                        </div>

                        <h4 class="mb-2">
                            <?= esc($template['judul']) ?>
                        </h4>

                        <p class="text-muted">

                            <?php
                            $deskripsi = $template['deskripsi'] ?? '';

                            if (strlen($deskripsi) > 120) {
                                echo esc(
                                    substr($deskripsi, 0, 120)
                                ) . '...';
                            } else {
                                echo esc($deskripsi);
                            }
                            ?>

                        </p>

                        <div class="small text-muted mb-4">

                            <div class="mb-1">

                                <i class="fas fa-user mr-1"></i>

                                <?= esc(
                                    $template['uploader']
                                    ?? 'Pengguna'
                                ) ?>

                            </div>

                            <div>

                                <i class="far fa-bookmark mr-1"></i>

                                Tersimpan

                            </div>

                        </div>

                        <div class="d-flex justify-content-end">

                            <a
                                href="<?= base_url(
                                    'templates/' .
                                    $template['id_template']
                                ) ?>"
                                class="btn btn-sm btn-outline-success"
                            >

                                Lihat Detail

                                <i class="fas fa-arrow-right ml-1"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>
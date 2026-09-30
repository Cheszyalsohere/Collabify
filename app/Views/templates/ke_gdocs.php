<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <div>
        <h1 class="page-title mb-1">Gunakan di Google</h1>
        <p class="page-sub mb-0"><?= esc($template['judul']) ?></p>
    </div>
    <a href="<?= base_url('templates/' . (int) $template['id_template']) ?>" class="btn btn-light mt-2 mt-md-0">
        <i class="ti ti-arrow-left mr-1"></i> Kembali
    </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card" style="max-width:760px">
    <div class="card-body">

        <?php if ($app === null): ?>
            <div class="alert alert-warning mb-0">
                Format <strong>.<?= esc($ext) ?></strong> tidak bisa dibuka langsung oleh Google Docs.
                Unduh filenya dari halaman template.
            </div>
        <?php else: ?>

            <p class="mb-4">
                File <strong>.<?= esc($ext) ?></strong> dibuka dengan <strong><?= esc($app[0]) ?></strong> lewat
                Google Drive milikmu, jadi <strong>kamu yang menjadi pemilik dokumennya</strong> dan template asli
                tetap aman. Caranya dua langkah:
            </p>

            <ol class="pl-3 mb-4" style="line-height:1.9">
                <li class="mb-3">
                    <strong>Unduh file template.</strong><br>
                    <a href="<?= base_url('templates/' . (int) $template['id_template'] . '/download') ?>" class="btn btn-primary btn-sm mt-1">
                        <i class="fas fa-download mr-1"></i> Unduh .<?= esc($ext) ?>
                    </a>
                </li>
                <li class="mb-3">
                    <strong>Unggah ke Google Drive lalu buka dengan <?= esc($app[1]) ?>.</strong><br>
                    <a href="https://drive.google.com/drive/my-drive" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm mt-1">
                        <i class="fab fa-google-drive mr-1"></i> Buka Google Drive
                    </a>
                    <div class="text-muted small mt-2">
                        Seret file yang baru diunduh ke jendela Drive, klik kanan file itu →
                        <em>Buka dengan</em> → <em><?= esc($app[1]) ?></em>.
                        <?php if ($ext === 'pdf'): ?>
                            Untuk PDF, Google mengubahnya menjadi teks yang bisa diedit (hasilnya mungkin perlu dirapikan).
                        <?php endif; ?>
                    </div>
                </li>
            </ol>

            <div class="alert alert-light border mb-0">
                Setelah dokumennya terbuka, salin alamatnya lalu tempel di <a href="<?= base_url('workspaces') ?>">Workspace</a>
                supaya muncul di riwayatmu.
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>

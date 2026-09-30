<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div>
    <h1 class="page-title mb-1">Upload Template</h1>
    <p class="page-sub mb-0">
        Bagikan template yang bermanfaat untuk kebutuhan akademik.
    </p>
</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

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


<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>

<?php endif; ?>


<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

        <form
          action="<?= base_url('templates/store') ?>"
          method="post"
          enctype="multipart/form-data"
        >

                    <?= csrf_field() ?>


                    <!-- =========================
                         JUDUL TEMPLATE
                    ========================== -->

                    <div class="form-group">

                        <label for="judul">
                            Judul Template
                        </label>

                        <input
                            type="text"
                            name="judul"
                            id="judul"
                            class="form-control"
                            value="<?= esc(old('judul')) ?>"
                            placeholder="Contoh: Template Proposal Penelitian"
                            required
                        >

                        <small class="text-muted">
                            Berikan judul yang jelas dan mudah dicari.
                        </small>

                    </div>


                    <!-- =========================
                         KATEGORI
                    ========================== -->

                    <div class="form-group">

                        <label for="kategori">
                            Kategori
                        </label>

                        <select
                            name="kategori"
                            id="kategori"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Pilih kategori...
                            </option>

                            <?php
                            $categories = [
                                'Makalah',
                                'Proposal',
                                'Laporan',
                                'Presentasi',
                                'Penelitian',
                                'Organisasi',
                                'Jadwal',
                                'Lainnya',
                            ];
                            ?>

                            <?php foreach ($categories as $category): ?>

                                <option
                                    value="<?= esc($category) ?>"
                                    <?= old('kategori') === $category ? 'selected' : '' ?>
                                >
                                    <?= esc($category) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- =========================
                         DESKRIPSI
                    ========================== -->

                    <div class="form-group">

                        <label for="deskripsi">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            id="deskripsi"
                            rows="6"
                            class="form-control"
                            maxlength="5000"
                            placeholder="Jelaskan kegunaan atau isi template ini..."
                        ><?= esc(old('deskripsi')) ?></textarea>

                        <small class="text-muted">
                            Jelaskan secara singkat template ini cocok
                            digunakan untuk apa.
                        </small>

                    </div>

                    <!-- =========================
                             TAUTAN GOOGLE DOCS
                    ========================== -->

                    <div class="form-group">

                        <label for="google_doc_url">
                            Tautan Google Docs
                            <span class="text-muted font-weight-normal">(opsional)</span>
                        </label>

                        <input
                            type="url"
                            name="google_doc_url"
                            id="google_doc_url"
                            class="form-control"
                            maxlength="500"
                            value="<?= esc(old('google_doc_url')) ?>"
                            placeholder="https://docs.google.com/document/d/..."
                        >

                        <small class="text-muted">
                            Kalau diisi, tombol <strong>Gunakan</strong> membuka dokumen ini di tab baru dan
                            pengguna diminta <strong>membuat salinan ke Drive miliknya sendiri</strong>
                            (pengguna jadi pemilik salinan, template asli tetap aman).
                            Di Google Docs: <em>Bagikan → Siapa saja yang memiliki link → <strong>Pelihat (Viewer)</strong></em>.
                            Mendukung Docs, Sheets, dan Slides.
                        </small>

                    </div>

                    <!-- =========================
                             FILE TEMPLATE
                    ========================== -->

<div class="form-group">

    <label for="file">
        File Template
        <span class="text-muted font-weight-normal">(wajib jika tidak ada tautan Google Docs)</span>
    </label>

    <div class="custom-file">

        <input
            type="file"
            name="file"
            id="file"
            class="custom-file-input"
            accept=".pdf,.docx,.pptx,.xlsx,.sav"
        >

        <label
            class="custom-file-label"
            for="file"
        >
            Pilih file...
        </label>

    </div>

    <small class="text-muted">
        Format yang didukung:
        PDF, DOCX, PPTX, XLSX, dan SAV (SPSS).
        Maksimal 20 MB.
    </small>

</div>

                    <!-- =========================
                         INFO TEMPLATE
                    ========================== -->

                    <div class="alert alert-light border">

                        <div class="d-flex align-items-start">

                            <div class="mr-3">
                                <i class="fas fa-bolt text-success"></i>
                            </div>

                            <div>

                                <strong>Template langsung tersedia</strong>

                                <p class="mb-0 mt-1 text-muted">
                                    Setelah diunggah, template akan langsung
                                    tersedia di bank template dan dapat ditemukan
                                    oleh mahasiswa lain.
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- =========================
                         TOMBOL
                    ========================== -->

                    <div class="d-flex justify-content-between mt-4">

                        <a
                            href="<?= base_url('templates') ?>"
                            class="btn btn-light"
                        >
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>


                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="fas fa-upload mr-1"></i>
                            Upload Template
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
document.getElementById('file').addEventListener('change', function () {

    const fileName = this.files.length
        ? this.files[0].name
        : 'Pilih file...';

    this.nextElementSibling.textContent = fileName;

});
</script>

<?= $this->endSection() ?>

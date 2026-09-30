<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="d-flex justify-content-between align-items-center">

    <div>
        <h1 class="page-title mb-1">Detail Template</h1>
        <p class="page-sub mb-0">
            Informasi lengkap mengenai template.
        </p>
    </div>

    <a
        href="<?= base_url('templates') ?>"
        class="btn btn-light"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Kembali
    </a>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>

<?php endif; ?>


<div class="row justify-content-center">

    <div class="col-lg-9">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <!-- KATEGORI -->

                <div class="mb-3">

                    <span class="badge badge-success px-3 py-2">

                        <?= esc($template['kategori']) ?>

                    </span>

                </div>


                <!-- JUDUL -->

                <h2 class="mb-3">

                    <?= esc($template['judul']) ?>

                </h2>


                <!-- DESKRIPSI -->

                <div class="mb-4">

                    <h5 class="font-weight-bold">
                        Deskripsi
                    </h5>

                    <?php if (! empty($template['deskripsi'])): ?>

                        <p class="text-muted mb-0">
                            <?= nl2br(esc($template['deskripsi'])) ?>
                        </p>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            Tidak ada deskripsi.
                        </p>

                    <?php endif; ?>

                </div>


                <hr>


                <!-- INFORMASI -->

                <div class="row mb-4">

                    <div class="col-md-4 mb-3 mb-md-0">

                        <div class="text-muted small mb-1">
                            Diunggah oleh
                        </div>

                        <div class="font-weight-bold">

                            <i class="fas fa-user mr-1"></i>

                            <?= esc($template['uploader'] ?? 'Pengguna') ?>

                        </div>

                    </div>


                    <div class="col-md-4 mb-3 mb-md-0">

                        <div class="text-muted small mb-1">
                            Jumlah download
                        </div>

                        <div class="font-weight-bold">

                            <i class="fas fa-download mr-1"></i>

                            <?= (int) $template['downloads_count'] ?>

                            kali

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="text-muted small mb-1">
                            Diunggah pada
                        </div>

                        <div class="font-weight-bold">

                            <i class="fas fa-calendar mr-1"></i>

                            <?php if (! empty($template['created_at'])): ?>

                                <?= date(
                                    'd M Y',
                                    strtotime($template['created_at'])
                                ) ?>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </div>

                    </div>

                </div>


                <!-- FILE -->

                <div class="p-3 border rounded mb-4">

                    <div class="d-flex align-items-center">

                        <div class="mr-3">

                            <i class="fas fa-file-alt fa-2x text-success"></i>

                        </div>

                        <div class="flex-grow-1">

                            <div class="font-weight-bold">
                                File Template
                            </div>

                            <small class="text-muted">

                                <?php
                                    $filePath = $template['file_path'] ?? '';
                                    $extension = $filePath
                                        ? strtoupper(
                                            pathinfo(
                                                $filePath,
                                                PATHINFO_EXTENSION
                                            )
                                        )
                                        : '-';
                                ?>

                                Format <?= esc($extension) ?>

                            </small>

                        </div>

                    </div>

                </div>
<!-- =========================
     RATING & ULASAN
========================== -->

<div class="rating-section mb-4">

    <h5 class="font-weight-bold mb-3">
        Rating & Ulasan
    </h5>


    <!-- RINGKASAN RATING -->

    <div class="d-flex align-items-center mb-4">

        <div class="mr-3">

            <div
                class="rating-average"
                id="ratingAverage"
            >
                <?php
                $averageRating = (float) (
                    $ratingSummary['average_rating'] ?? 0
                );
                ?>

                <?= number_format($averageRating, 1) ?>
            </div>

            <div class="rating-stars-small">

                <?php
                $roundedRating = round($averageRating);
                ?>

                <?php for ($i = 1; $i <= 5; $i++): ?>

                    <span>
                        <?= $i <= $roundedRating ? '★' : '☆' ?>
                    </span>

                <?php endfor; ?>

            </div>

        </div>


        <div class="text-muted">

            <?= (int) (
                $ratingSummary['total_rating'] ?? 0
            ) ?>

            ulasan

        </div>

    </div>


<!-- FORM KOMENTAR -->

<div class="rating-form p-3 border rounded">

    <?php if (session()->getFlashdata('rating_error')): ?>

        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('rating_error')) ?>
        </div>

    <?php endif; ?>


    <div class="font-weight-bold mb-2">
        Bagaimana menurutmu template ini?
    </div>

    <form
        action="<?= base_url(
            'templates/' .
            $template['id_template'] .
            '/rating'
        ) ?>"
        method="post"
        id="ratingForm"
    >

        <?= csrf_field() ?>


        <!-- BINTANG -->

        <div
            class="rating-input mb-3"
            id="ratingInput"
        >

            <?php for ($i = 1; $i <= 5; $i++): ?>

                <button
                    type="button"
                    class="rating-star"
                    data-rating="<?= $i ?>"
                    aria-label="<?= $i ?> bintang"
                >
                    ☆
                </button>

            <?php endfor; ?>

            <input
                type="hidden"
                name="rating"
                id="ratingValue"
                value="0"
            >

        </div>


        <!-- KOMENTAR -->

        <textarea
            name="comment"
            class="form-control mb-3"
            rows="4"
            maxlength="1000"
            placeholder="Tulis pengalaman atau pendapatmu tentang template ini..."
        ></textarea>


        <button
            type="submit"
            class="btn btn-success"
            id="submitRating"
        >
            <i class="fas fa-paper-plane mr-1"></i>
            Kirim Komentar
        </button>

    </form>

</div>

    <!-- DAFTAR ULASAN -->

    <?php if (! empty($ratings)): ?>

        <div class="mt-4">

<?php foreach ($ratings as $rating): ?>

    <div class="comment-item">

        <!-- AVATAR -->

        <div class="comment-avatar">
            <i class="fas fa-user"></i>
        </div>


        <!-- ISI KOMENTAR -->

        <div class="comment-content">

            <div class="d-flex justify-content-between align-items-start">

                <strong class="comment-name">
                    <?= esc(
                        $rating['user_name']
                        ?? 'Pengguna'
                    ) ?>
                </strong>

                <small class="text-muted">
                    <?= date(
                        'd M Y',
                        strtotime($rating['created_at'])
                    ) ?>
                </small>

            </div>


            <!-- RATING -->

            <div class="review-stars">

                <?php for ($i = 1; $i <= 5; $i++): ?>

                    <span>
                        <?= $i <= $rating['rating']
                            ? '★'
                            : '☆' ?>
                    </span>

                <?php endfor; ?>

            </div>


            <!-- KOMENTAR -->

            <?php if (! empty($rating['comment'])): ?>

                <p class="comment-text mb-0 mt-1">
                    <?= nl2br(
                        esc($rating['comment'])
                    ) ?>
                </p>

            <?php endif; ?>

        </div>

    </div>

<?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

                <!-- ACTION -->

                <div class="d-flex flex-wrap" style="gap: 10px;">

                    <?php if (! empty($template['file_path'])): ?>

                        <a
                            href="<?= base_url(
                                'templates/' .
                                $template['id_template'] .
                                '/download'
                            ) ?>"
                            class="btn btn-success"
                        >

                            <i class="fas fa-download mr-1"></i>

                            Download

                        </a>

                    <?php endif; ?>


<form
    action="<?= base_url(
        'templates/' .
        $template['id_template'] .
        '/bookmark'
    ) ?>"
    method="post"
    class="d-inline"
    id="bookmarkForm"
>
    <?= csrf_field() ?>

    <button
        type="submit"
        id="bookmarkButton"
        class="bookmark-btn <?= $isBookmarked ? 'is-bookmarked' : '' ?>"
        aria-label="<?= $isBookmarked ? 'Hapus bookmark' : 'Simpan bookmark' ?>"
    >

        <i
            id="bookmarkIcon"
            class="<?= $isBookmarked
                ? 'fas fa-bookmark'
                : 'far fa-bookmark'
            ?>"
        ></i>

        <span id="bookmarkText">
            <?= $isBookmarked ? 'Tersimpan' : 'Bookmark' ?>
        </span>

        <!-- Percikan -->
        <span class="bookmark-sparkles" aria-hidden="true">
            <span>✦</span>
            <span>✦</span>
            <span>✦</span>
            <span>✦</span>
            <span>✦</span>
            <span>✦</span>
        </span>

    </button>

</form>


<?php if (! empty($template['gdoc_id'])): ?>

    <!-- Buka salinan Google di tab baru: pengguna yang menyalin = pemilik dokumen -->
    <form
        action="<?= base_url('templates/' . $template['id_template'] . '/gunakan-google') ?>"
        method="post"
        target="_blank"
        class="d-inline"
    >
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-primary">
            <i class="fab fa-google-drive mr-1"></i>
            Gunakan di Google Docs
        </button>
    </form>

<?php endif; ?>

<?php if (! empty($template['file_path'])): ?>

    <a
        href="<?= base_url(
            'templates/' .
            $template['id_template'] .
            '/use'
        ) ?>"
        class="btn btn-outline-success"
    >
        <i class="fas fa-edit mr-1"></i>
        <?= ! empty($template['gdoc_id']) ? 'Buka di editor aplikasi' : 'Gunakan Template' ?>
    </a>

<?php endif; ?>

                </div>

                <?php
                    $bolehUbahGdoc = (int) ($template['uploaded_by'] ?? 0) === (int) session('id_user')
                        || session('role') === 'admin';
                ?>

                <?php if (empty($template['gdoc_id'])): ?>
                    <p class="text-muted small mt-3 mb-2">
                        Template ini belum tertaut ke Google Docs, jadi "Gunakan" membuka editor di aplikasi.
                        <?= $bolehUbahGdoc
                            ? 'Tempel tautan dokumennya di bawah supaya pengguna bisa langsung menyalinnya ke Google Docs.'
                            : 'Minta pengunggah template menambahkan tautan Google Docs.' ?>
                    </p>
                <?php endif; ?>

                <?php if ($bolehUbahGdoc): ?>
                    <details class="mt-2" <?= empty($template['gdoc_id']) ? 'open' : '' ?>>
                        <summary class="small font-weight-bold" style="cursor:pointer">
                            <?= empty($template['gdoc_id']) ? 'Tautkan ke Google Docs' : 'Ubah tautan Google Docs' ?>
                        </summary>
                        <form
                            action="<?= base_url('templates/' . (int) $template['id_template'] . '/gdoc') ?>"
                            method="post"
                            class="mt-2"
                        >
                            <?= csrf_field() ?>
                            <div class="input-group">
                                <input
                                    type="url"
                                    name="google_doc_url"
                                    class="form-control"
                                    maxlength="500"
                                    placeholder="https://docs.google.com/document/d/..."
                                    value="<?= ! empty($template['gdoc_id'])
                                        ? esc('https://docs.google.com/' . $template['gdoc_type'] . '/d/' . $template['gdoc_id'] . '/edit', 'attr')
                                        : '' ?>"
                                >
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                            <small class="text-muted">
                                Bagikan dokumennya sebagai <strong>Pelihat (Viewer)</strong> untuk siapa saja yang punya link.
                                Mengosongkan kolom menghapus tautan (hanya bila template punya file).
                            </small>
                        </form>
                    </details>
                <?php endif; ?>




            </div>

        </div>

    </div>

</div>
<style>

.bookmark-btn {
    position: relative;
    overflow: visible;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 6px;

    padding: 8px 16px;

    border: 1px solid #6c757d;
    border-radius: 6px;

    background: #fff;
    color: #6c757d;

    cursor: pointer;

    transition:
        background-color 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease,
        transform 0.15s ease;
}


/* Hover */

.bookmark-btn:hover {
    transform: translateY(-1px);
}


/* =========================
   SUDAH DISIMPAN
========================= */

.bookmark-btn.is-bookmarked {
    background: #4477A6;
    border-color: #5E91C4;
    color: #fff;
}


/* Icon */

.bookmark-btn i {
    transition:
        transform 0.2s ease,
        color 0.2s ease;
}


/* =========================
   POP ANIMATION
========================= */

.bookmark-btn.bookmark-pop {
    animation: bookmarkPop 0.45s ease;
}


@keyframes bookmarkPop {

    0% {
        transform: scale(1);
    }

    40% {
        transform: scale(1.15);
    }

    70% {
        transform: scale(0.96);
    }

    100% {
        transform: scale(1);
    }

}


/* =========================
   ICON POP
========================= */

.bookmark-btn.bookmark-pop i {
    animation: iconPop 0.45s ease;
}


@keyframes iconPop {

    0% {
        transform: scale(0.7);
    }

    50% {
        transform: scale(1.35);
    }

    100% {
        transform: scale(1);
    }

}


/* =========================
   SPARKLES
========================= */

.bookmark-sparkles {
    position: absolute;

    inset: 0;

    pointer-events: none;
}


.bookmark-sparkles span {
    position: absolute;

    left: 50%;
    top: 50%;

    font-size: 13px;

    color: #F5D96B;
    text-shadow: 0 0 6px rgba(246, 201, 69, 0.45);

    opacity: 0;

    transform:
        translate(-50%, -50%)
        scale(0.3);
}

/* posisi masing-masing bintang */

.bookmark-sparkles span:nth-child(1) {
    --x: -25px;
    --y: -18px;
}

.bookmark-sparkles span:nth-child(2) {
    --x: 25px;
    --y: -20px;
}

.bookmark-sparkles span:nth-child(3) {
    --x: -32px;
    --y: 5px;
}

.bookmark-sparkles span:nth-child(4) {
    --x: 32px;
    --y: 5px;
}

.bookmark-sparkles span:nth-child(5) {
    --x: -18px;
    --y: 22px;
}

.bookmark-sparkles span:nth-child(6) {
    --x: 20px;
    --y: 20px;
}


/* aktif ketika bookmark */

.bookmark-btn.bookmark-pop .bookmark-sparkles span {
    animation: sparkle 0.65s ease-out forwards;
}


@keyframes sparkle {

    0% {
        opacity: 0;
        transform:
            translate(-50%, -50%)
            scale(0.2);
    }

    25% {
        opacity: 1;
    }

    100% {
        opacity: 0;

        transform:
            translate(
                calc(-50% + var(--x)),
                calc(-50% + var(--y))
            )
            scale(1);
    }

}
/* =========================
   RATING
========================= */

.rating-average {
    font-size: 32px;
    font-weight: 700;
    line-height: 1;
}

.rating-stars-small,
.review-stars {
    color: #F5D96B;
    letter-spacing: 2px;
}

.rating-stars-small {
    font-size: 16px;
    margin-top: 5px;
}


/* Input bintang */

.rating-input {
    display: flex;
    align-items: center;
    gap: 3px;
}

.rating-star {
    border: none;
    background: transparent;

    padding: 0 2px;

    font-size: 30px;
    line-height: 1;

    color: #D5D8D5;

    cursor: pointer;

    transition:
        transform 0.15s ease,
        color 0.15s ease;
}

.rating-star:hover {
    transform: scale(1.15);
}

.rating-star.active {
    color: #F5D96B;
}

.rating-star.hovered {
    color: #F5D96B;
}
/* =========================
   COMMENT LIST
========================= */

.comment-item {
    display: flex;
    gap: 12px;
    padding: 16px 0;
    border-bottom: 1px solid #ECECEC;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-avatar {
    width: 38px;
    height: 38px;
    min-width: 38px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #EAF3FA;
    color: #376590;

    font-size: 15px;
}

.comment-content {
    flex: 1;
    min-width: 0;
}

.comment-name {
    font-size: 14px;
    color: #30323A;
}

.comment-text {
    color: #4B5563;
    font-size: 14px;
    line-height: 1.6;
    white-space: normal;
}

.comment-item .review-stars {
    font-size: 13px;
    margin-top: 2px;
    letter-spacing: 1px;
}
</style>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const bookmarkForm =
        document.getElementById('bookmarkForm');

    const bookmarkButton =
        document.getElementById('bookmarkButton');

    const bookmarkIcon =
        document.getElementById('bookmarkIcon');

    const bookmarkText =
        document.getElementById('bookmarkText');


    if (!bookmarkForm || !bookmarkButton) {
        return;
    }


    /*
     * Kalau halaman baru saja melakukan bookmark,
     * jalankan animasi sekali.
     */
    const bookmarkAction =
        <?= json_encode(
            session()->getFlashdata('bookmark_action')
        ) ?>;


    if (bookmarkAction === 'saved') {

        bookmarkButton.classList.add('bookmark-pop');

        setTimeout(function () {

            bookmarkButton.classList.remove(
                'bookmark-pop'
            );

        }, 700);

    }


    /*
     * Kalau baru saja melakukan unbookmark,
     * beri pop kecil tanpa sparkle.
     */
    if (bookmarkAction === 'removed') {

        bookmarkButton.classList.add('bookmark-pop');

        setTimeout(function () {

            bookmarkButton.classList.remove(
                'bookmark-pop'
            );

        }, 500);

    }

});

</script>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const ratingStars =
        document.querySelectorAll('.rating-star');

    const ratingValue =
        document.getElementById('ratingValue');


    if (!ratingStars.length || !ratingValue) {
        return;
    }


    ratingStars.forEach(function (star) {

        star.addEventListener('mouseenter', function () {

            const rating =
                parseInt(this.dataset.rating);

            ratingStars.forEach(function (item) {

                const itemRating =
                    parseInt(item.dataset.rating);

                item.textContent =
                    itemRating <= rating
                        ? '★'
                        : '☆';

                item.classList.toggle(
                    'hovered',
                    itemRating <= rating
                );

            });

        });


        star.addEventListener('click', function () {

            const rating =
                parseInt(this.dataset.rating);

            ratingValue.value = rating;

            ratingStars.forEach(function (item) {

                const itemRating =
                    parseInt(item.dataset.rating);

                item.textContent =
                    itemRating <= rating
                        ? '★'
                        : '☆';

                item.classList.toggle(
                    'active',
                    itemRating <= rating
                );

            });

        });

    });


    const ratingInput =
        document.getElementById('ratingInput');

    ratingInput.addEventListener(
        'mouseleave',
        function () {

            const selectedRating =
                parseInt(ratingValue.value);

            ratingStars.forEach(function (item) {

                const itemRating =
                    parseInt(item.dataset.rating);

                item.textContent =
                    itemRating <= selectedRating
                        ? '★'
                        : '☆';

                item.classList.remove('hovered');

                item.classList.toggle(
                    'active',
                    itemRating <= selectedRating
                );

            });

        }
    );

});

</script>
<?= $this->endSection() ?>
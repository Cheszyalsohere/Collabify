<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="d-flex justify-content-between align-items-center">

    <div>
        <div class="page-eyebrow">RUANG KERJA</div>
        <h1 class="page-title mb-1">Gunakan Template</h1>

        <p class="page-sub mb-0">
            Buat workspace baru dari template ini.
        </p>
    </div>

    <a
        href="<?= base_url(
            'templates/' .
            $template['id_template']
        ) ?>"
        class="btn btn-light"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Kembali
    </a>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">
                <?= esc(
                    session()->getFlashdata('error')
                ) ?>
            </div>

        <?php endif; ?>


        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <!-- TEMPLATE ASAL -->

                <div class="template-preview mb-4">

                    <div class="template-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>

                    <div>

                        <div class="small text-muted mb-1">
                            Template yang digunakan
                        </div>

                        <h4 class="mb-1">
                            <?= esc(
                                $template['judul']
                            ) ?>
                        </h4>

                        <span class="badge badge-success">
                            <?= esc(
                                $template['kategori']
                            ) ?>
                        </span>

                    </div>

                </div>


                <hr>


                <!-- FORM -->

                <form
                    action="<?= base_url(
                        'workspaces/store'
                    ) ?>"
                    method="post"
                >

                    <?= csrf_field() ?>


                    <input
                        type="hidden"
                        name="id_template"
                        value="<?= (int) $template['id_template'] ?>"
                    >


                    <!-- JUDUL -->

                    <div class="form-group">

                        <label
                            for="judul"
                            class="font-weight-bold"
                        >
                            Nama Workspace
                        </label>

                        <input
                            type="text"
                            name="judul"
                            id="judul"
                            class="form-control"
                            value="<?= old(
                                'judul',
                                $template['judul'] . ' — Workspace'
                            ) ?>"
                            maxlength="255"
                            required
                        >

                        <small class="form-text text-muted">
                            Nama ini digunakan untuk membedakan
                            workspace milikmu.
                        </small>

                    </div>


                    <!-- KELOMPOK -->

                    <div class="form-group">

                        <label
                            for="id_group"
                            class="font-weight-bold"
                        >
                            Hubungkan dengan Kelompok
                        </label>

                        <select
                            name="id_group"
                            id="id_group"
                            class="form-control"
                        >

                            <option value="">
                                Workspace pribadi
                            </option>

                            <?php foreach ($groups as $group): ?>

                                <option
                                    value="<?= (int) $group['id_group'] ?>"
                                    <?= old('id_group') == $group['id_group']
                                        ? 'selected'
                                        : '' ?>
                                >
                                    <?= esc(
                                        $group['nama_kelompok']
                                    ) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                        <small class="form-text text-muted">
                            Pilih kelompok jika template ini
                            akan digunakan untuk tugas bersama.
                        </small>

                    </div>


                    <!-- INFO -->

                    <div class="workspace-info mb-4">

                        <div class="workspace-info-icon">
                            <i class="fas fa-copy"></i>
                        </div>

                        <div>

                            <strong>
                                Template asli tetap aman
                            </strong>

                            <p class="mb-0 text-muted small">
                                COLLABIFY akan membuat salinan
                                baru dari file template. Perubahan
                                pada workspace tidak akan mengubah
                                template asli.
                            </p>

                        </div>

                    </div>


                    <!-- BUTTON -->

                    <div class="d-flex justify-content-end">

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="fas fa-plus mr-1"></i>
                            Buat Workspace
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<style>

.template-preview {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px;
    background: #EAF3FA;
    border-radius: 10px;
}

.template-icon {
    width: 52px;
    height: 52px;

    border-radius: 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #5E91C4;
    color: #fff;

    font-size: 21px;
}

.workspace-info {
    display: flex;
    align-items: flex-start;
    gap: 12px;

    padding: 15px;

    border: 1px solid #E2E2DE;
    border-radius: 8px;

    background: #FAFAF8;
}

.workspace-info-icon {
    color: #5E91C4;
    font-size: 18px;
    padding-top: 1px;
}

</style>

<?= $this->endSection() ?>
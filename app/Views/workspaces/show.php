<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>

<div class="d-flex justify-content-between align-items-center flex-wrap">

    <div>
        <div class="mb-2">
            <a href="<?= base_url('workspaces') ?>" class="text-muted">
                <i class="ti ti-arrow-left mr-1"></i>
                Workspace Saya
            </a>
        </div>

        <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">

            <div class="page-eyebrow">RUANG KERJA</div>
            <h1 class="page-title mb-0">
                <?= esc($workspace['judul']) ?>
            </h1>

            <?php if (!empty($workspace['nama_kelompok'])): ?>
                <span class="workspace-group-badge">
                    <i class="ti ti-users mr-1"></i>
                    <?= esc($workspace['nama_kelompok']) ?>
                </span>
            <?php else: ?>
                <span class="workspace-group-badge">
                    <i class="ti ti-user mr-1"></i>
                    Pribadi
                </span>
            <?php endif; ?>

        </div>

        <p class="page-sub mb-0 mt-1">
            Template:
            <?= esc($workspace['template_asal'] ?? '-') ?>
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


<div class="workspace-layout">

    <!-- EDITOR -->
    <div class="workspace-main">

        <div class="card editor-card">

            <!-- EDITOR HEADER -->
            <div class="editor-header">

                <div>
                    <div class="editor-label">
                        <i class="ti ti-edit mr-1"></i>
                        Editor Workspace
                    </div>

                    <div class="editor-subtitle">
                        Perubahan akan tersimpan otomatis.
                    </div>
                </div>

                <div class="save-status" id="saveStatus">

                    <span class="save-dot"></span>

                    <span id="saveStatusText">
                        Tersimpan
                    </span>

                </div>

            </div>


            <!-- TOOLBAR -->
            <div class="editor-toolbar">

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('bold')"
                    title="Bold"
                >
                    <i class="ti ti-bold"></i>
                </button>

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('italic')"
                    title="Italic"
                >
                    <i class="ti ti-italic"></i>
                </button>

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('underline')"
                    title="Underline"
                >
                    <i class="ti ti-underline"></i>
                </button>

                <div class="toolbar-divider"></div>


                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('formatBlock', 'H2')"
                    title="Heading"
                >
                    <i class="ti ti-heading"></i>
                </button>

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('formatBlock', 'P')"
                    title="Paragraph"
                >
                    <i class="ti ti-letter-p"></i>
                </button>

                <div class="toolbar-divider"></div>


                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('insertUnorderedList')"
                    title="Bullet List"
                >
                    <i class="ti ti-list"></i>
                </button>

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('insertOrderedList')"
                    title="Numbered List"
                >
                    <i class="ti ti-list-numbers"></i>
                </button>

                <div class="toolbar-divider"></div>


                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('justifyLeft')"
                    title="Rata kiri"
                >
                    <i class="ti ti-align-left"></i>
                </button>

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('justifyCenter')"
                    title="Rata tengah"
                >
                    <i class="ti ti-align-center"></i>
                </button>

                <button
                    type="button"
                    class="editor-btn"
                    onclick="formatText('justifyRight')"
                    title="Rata kanan"
                >
                    <i class="ti ti-align-right"></i>
                </button>

                <div class="toolbar-spacer"></div>

                <button
                    type="button"
                    class="btn btn-success btn-sm save-now-btn"
                    onclick="saveNow()"
                >
                    <i class="ti ti-device-floppy mr-1"></i>
                    Simpan
                </button>

            </div>


            <!-- DOCUMENT -->
            <div class="editor-wrapper">

                <div
                    id="editor"
                    class="document-editor"
                    contenteditable="true"
                    spellcheck="true"
                    data-placeholder="Mulai menulis isi tugas atau dokumen di sini..."
                ></div>

            </div>

        </div>

    </div>


    <!-- SIDEBAR -->
    <div class="workspace-sidebar">

        <!-- INFORMASI -->
        <div class="card">

            <div class="card-body">

                <h3 class="sidebar-title">
                    Informasi Workspace
                </h3>


                <div class="info-row">

                    <span class="info-label">
                        Template asal
                    </span>

                    <strong>
                        <?= esc($workspace['template_asal'] ?? '-') ?>
                    </strong>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Kelompok
                    </span>

                    <strong>
                        <?= esc(
                            $workspace['nama_kelompok']
                            ?? 'Pribadi'
                        ) ?>
                    </strong>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Dibuat oleh
                    </span>

                    <strong>
                        <?= esc(
                            $workspace['pembuat']
                            ?? 'Pengguna'
                        ) ?>
                    </strong>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Dibuat pada
                    </span>

                    <strong>

                        <?php if (!empty($workspace['created_at'])): ?>

                            <?= date(
                                'd M Y',
                                strtotime(
                                    $workspace['created_at']
                                )
                            ) ?>

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </strong>

                </div>

            </div>

        </div>


        <!-- KOLABORASI -->
        <div class="card mt-3">

            <div class="card-body">

                <div class="collab-icon">
                    <i class="ti ti-users-group"></i>
                </div>

                <h3 class="sidebar-title mt-3">
                    Workspace Kolaboratif
                </h3>

                <?php if (!empty($workspace['nama_kelompok'])): ?>

                    <p class="text-muted small mb-0">
                        Semua anggota kelompok dapat
                        membuka dan mengedit workspace ini.
                        Perubahan akan tersimpan pada workspace
                        yang sama.
                    </p>

                <?php else: ?>

                    <p class="text-muted small mb-0">
                        Workspace ini bersifat pribadi.
                    </p>

                <?php endif; ?>

            </div>

        </div>


        <!-- FILE -->
        <?php if (!empty($workspace['file_path'])): ?>

            <div class="card mt-3">

                <div class="card-body">

                    <h3 class="sidebar-title">
                        File Template
                    </h3>

                    <div class="file-box">

                        <div class="file-icon">
                            <i class="ti ti-file-text"></i>
                        </div>

                        <div>

                            <strong>
                                Salinan Template
                            </strong>

                            <div class="small text-muted">
                                File asli tidak akan diubah.
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>


<style>

/* =====================================================
   LAYOUT
===================================================== */

.workspace-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 300px;
    gap: 20px;
    align-items: start;
}

.workspace-main {
    min-width: 0;
}


/* =====================================================
   HEADER
===================================================== */

.workspace-group-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 999px;
    background: var(--tint);
    color: var(--forest);
    font-size: 12px;
    font-weight: 600;
}


/* =====================================================
   EDITOR CARD
===================================================== */

.editor-card {
    overflow: hidden;
}

.editor-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-2);
}

.editor-label {
    font-weight: 600;
    color: var(--ink);
    font-size: 15px;
}

.editor-subtitle {
    color: var(--muted);
    font-size: 12px;
    margin-top: 3px;
}


/* =====================================================
   SAVE STATUS
===================================================== */

.save-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    color: var(--muted);
    white-space: nowrap;
}

.save-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #8C8C8C;
}

.save-status.saving {
    color: #9A6A00;
}

.save-status.saving .save-dot {
    background: #D69E2E;
    animation: savePulse 1s infinite;
}

.save-status.saved {
    color: var(--forest);
}

.save-status.saved .save-dot {
    background: var(--forest);
}

.save-status.error {
    color: #B42318;
}

.save-status.error .save-dot {
    background: #B42318;
}

@keyframes savePulse {

    0% {
        opacity: 1;
    }

    50% {
        opacity: .35;
    }

    100% {
        opacity: 1;
    }

}


/* =====================================================
   TOOLBAR
===================================================== */

.editor-toolbar {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 9px 12px;
    background: var(--paper);
    border-bottom: 1px solid var(--border-2);
}

.editor-btn {
    width: 34px;
    height: 32px;
    border: 1px solid transparent;
    border-radius: 7px;
    background: transparent;
    color: var(--ink);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .15s ease;
}

.editor-btn:hover {
    background: var(--tint);
    color: var(--forest);
    border-color: var(--border-2);
}

.toolbar-divider {
    width: 1px;
    height: 22px;
    background: var(--border-2);
    margin: 0 5px;
}

.toolbar-spacer {
    flex: 1;
}

.save-now-btn {
    border-radius: 7px;
}


/* =====================================================
   DOCUMENT
===================================================== */

.editor-wrapper {
    background: #F6F6F4;
    padding: 30px;
    min-height: 650px;
}

.document-editor {
    width: 100%;
    min-height: 590px;
    background: #FFFFFF;
    border: 1px solid #E5E5E2;
    border-radius: 4px;
    padding: 55px 65px;
    color: var(--ink);
    font-size: 15px;
    line-height: 1.8;
    outline: none;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .03);
}

.document-editor:focus {
    border-color: var(--forest);
}

.document-editor:empty::before {
    content: attr(data-placeholder);
    color: #A7AAA5;
    pointer-events: none;
}

.document-editor h2 {
    font-size: 24px;
    line-height: 1.3;
    margin-top: 0;
    margin-bottom: 15px;
    color: var(--ink);
}

.document-editor p {
    margin-bottom: 12px;
}

.document-editor ul,
.document-editor ol {
    padding-left: 28px;
    margin-bottom: 15px;
}

.document-editor blockquote {
    border-left: 3px solid var(--forest);
    padding-left: 15px;
    margin-left: 0;
    color: var(--muted);
}


/* =====================================================
   SIDEBAR
===================================================== */

.workspace-sidebar {
    min-width: 0;
}

.sidebar-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 15px;
}

.info-row {
    display: flex;
    flex-direction: column;
    gap: 3px;
    padding: 11px 0;
    border-bottom: 1px solid var(--border-2);
}

.info-row:first-of-type {
    padding-top: 0;
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    color: var(--muted);
    font-size: 12px;
}

.info-row strong {
    color: var(--ink);
    font-size: 13px;
    font-weight: 600;
}


.collab-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}


.file-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border: 1px solid var(--border-2);
    border-radius: 10px;
}

.file-icon {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    background: var(--tint);
    color: var(--forest);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 992px) {

    .workspace-layout {
        grid-template-columns: 1fr;
    }

    .workspace-sidebar {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .workspace-sidebar .mt-3 {
        margin-top: 0 !important;
    }

}

@media (max-width: 768px) {

    .editor-wrapper {
        padding: 12px;
    }

    .document-editor {
        padding: 35px 25px;
        min-height: 500px;
    }

    .editor-toolbar {
        flex-wrap: wrap;
    }

    .save-now-btn {
        margin-left: auto;
    }

}

@media (max-width: 576px) {

    .workspace-sidebar {
        grid-template-columns: 1fr;
    }

    .editor-header {
        align-items: flex-start;
        gap: 10px;
        flex-direction: column;
    }

    .document-editor {
        padding: 25px 18px;
    }

}

</style>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>

/* =====================================================
   DATA WORKSPACE
===================================================== */

const workspaceId =
    <?= (int) $workspace['id_workspace'] ?>;

const editor =
    document.getElementById('editor');

const saveStatus =
    document.getElementById('saveStatus');

const saveStatusText =
    document.getElementById('saveStatusText');


/* =====================================================
   ISI WORKSPACE
===================================================== */

const savedContent =
    <?= json_encode(
        $workspace['content'] ?? '',
        JSON_HEX_TAG |
        JSON_HEX_APOS |
        JSON_HEX_AMP |
        JSON_HEX_QUOT
    ) ?>;

editor.innerHTML = savedContent;


/* =====================================================
   CSRF TOKEN
===================================================== */

let csrfToken =
    '<?= csrf_hash() ?>';


/* =====================================================
   FORMAT TEXT
===================================================== */

function formatText(command, value = null)
{
    editor.focus();

    document.execCommand(
        command,
        false,
        value
    );

    scheduleSave();
}


/* =====================================================
   STATUS
===================================================== */

function setSaving()
{
    saveStatus.className =
        'save-status saving';

    saveStatusText.innerText =
        'Menyimpan...';
}


function setSaved()
{
    saveStatus.className =
        'save-status saved';

    saveStatusText.innerText =
        'Tersimpan';
}


function setError()
{
    saveStatus.className =
        'save-status error';

    saveStatusText.innerText =
        'Gagal menyimpan';
}


/* =====================================================
   AUTOSAVE
===================================================== */

let saveTimer = null;

let isSaving = false;

let saveAgain = false;


function scheduleSave()
{
    clearTimeout(saveTimer);

    setSaving();

    saveTimer = setTimeout(function () {

        saveContent();

    }, 1000);
}


/* =====================================================
   SAVE CONTENT
===================================================== */

function saveContent()
{
    if (isSaving) {

        saveAgain = true;

        return;
    }

    isSaving = true;

    setSaving();


    const formData =
        new FormData();

    formData.append(
        'id_workspace',
        workspaceId
    );

    formData.append(
        'content',
        editor.innerHTML
    );


    /*
     * Token CSRF dikirim melalui FormData.
     */
    formData.append(
        '<?= csrf_token() ?>',
        csrfToken
    );


    fetch(
        '<?= base_url('workspaces/save') ?>',
        {
            method: 'POST',

            body: formData,

            headers: {
                'X-Requested-With':
                    'XMLHttpRequest',

                'X-CSRF-TOKEN':
                    csrfToken
            }
        }
    )
    .then(function(response) {

        /*
         * Kalau server menolak request,
         * jangan langsung dianggap JSON.
         */
        if (!response.ok) {

            throw new Error(
                'HTTP ' + response.status
            );
        }

        return response.json();

    })
    .then(function(data) {

        if (data.success) {

            setSaved();

        } else {

            console.error(
                'Save failed:',
                data
            );

            setError();

        }

    })
    .catch(function(error) {

        console.error(
            'Autosave error:',
            error
        );

        setError();

    })
    .finally(function() {

        isSaving = false;

        if (saveAgain) {

            saveAgain = false;

            saveContent();

        }

    });
}


/* =====================================================
   SIMPAN SEKARANG
===================================================== */

function saveNow()
{
    clearTimeout(saveTimer);

    saveContent();
}


/* =====================================================
   KETIKA USER MENGETIK
===================================================== */

editor.addEventListener(
    'input',
    function() {

        scheduleSave();

    }
);


/* =====================================================
   CTRL / CMD + S
===================================================== */

document.addEventListener(
    'keydown',
    function(event) {

        if (
            (event.metaKey || event.ctrlKey) &&
            event.key.toLowerCase() === 's'
        ) {

            event.preventDefault();

            saveNow();

        }

    }
);


/* =====================================================
   PASTE
===================================================== */

editor.addEventListener(
    'paste',
    function() {

        setTimeout(
            scheduleSave,
            50
        );

    }
);


/* =====================================================
   SIMPAN SEKARANG
===================================================== */

function saveNow()
{
    clearTimeout(saveTimer);

    saveContent();
}


/* =====================================================
   KETIKA USER MENGETIK
===================================================== */

editor.addEventListener(
    'input',
    function() {

        scheduleSave();

    }
);


/* =====================================================
   CTRL / CMD + S
===================================================== */

document.addEventListener(
    'keydown',
    function(event) {

        if (
            (event.metaKey || event.ctrlKey) &&
            event.key.toLowerCase() === 's'
        ) {

            event.preventDefault();

            saveNow();

        }

    }
);


/* =====================================================
   PASTE
===================================================== */

editor.addEventListener(
    'paste',
    function() {

        /*
         * Tunggu sampai browser selesai memasukkan
         * teks yang dipaste, lalu autosave.
         */
        setTimeout(
            scheduleSave,
            50
        );

    }
);

</script>

<?= $this->endSection() ?>
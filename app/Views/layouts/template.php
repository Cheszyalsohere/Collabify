<!DOCTYPE html>
<html lang="id">

<head>

    <?= $this->include('layouts/partials/head') ?>

</head>


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

<div class="wrapper">


    <!-- NAVBAR -->

    <?= $this->include('layouts/partials/navbar') ?>


    <!-- SIDEBAR -->

    <?= $this->include('layouts/partials/sidebar') ?>


    <!-- CONTENT -->

    <div class="content-wrapper">


        <!-- PAGE HEADER -->

        <section class="content-header">

            <div class="container-fluid">

                <?= $this->renderSection('header') ?>

            </div>

        </section>


        <!-- PAGE CONTENT -->

        <section class="content">

            <div class="container-fluid">

                <?= $this->renderSection('content') ?>

            </div>

        </section>


    </div>


    <!-- FOOTER -->

    <?= $this->include('layouts/partials/footer') ?>


</div>


<!-- SCRIPTS -->

<?= $this->include('layouts/partials/script') ?>


<?= $this->renderSection('js') ?>


<style>

/* =====================================================
   COLLABIFY FIXED APP LAYOUT
   ===================================================== */

html,
body {

    height: 100%;

}


body {

    overflow: hidden;

}


/* =====================================================
   NAVBAR
   ===================================================== */

.main-header {

    position: fixed !important;

    top: 0;

    right: 0;

    z-index: 1035 !important;

}


/* =====================================================
   SIDEBAR
   ===================================================== */

.main-sidebar {

    position: fixed !important;

    top: 0;

    bottom: 0;

    z-index: 1038 !important;
}


/* =====================================================
   CONTENT
   ===================================================== */

.content-wrapper {

    height: calc(100vh - 57px);

    min-height: 0 !important;

    overflow-y: auto;

    overflow-x: hidden;

    margin-top: 57px !important;

    padding-bottom: 20px;

}


/* =====================================================
   CONTENT HEADER
   ===================================================== */

.content-header {

    flex-shrink: 0;

}


/* =====================================================
   FOOTER
   ===================================================== */

.main-footer {

    display: none;

}


/* =====================================================
   SCROLLBAR
   ===================================================== */

.content-wrapper::-webkit-scrollbar {

    width: 7px;

}


.content-wrapper::-webkit-scrollbar-track {

    background: transparent;

}


.content-wrapper::-webkit-scrollbar-thumb {

    background: #D8D9DC;

    border-radius: 999px;

}


.content-wrapper::-webkit-scrollbar-thumb:hover {

    background: #BFC1C6;

}


/* =====================================================
   DARK CONTENT
   ===================================================== */

body.collabify-dark .content-wrapper {

    background: #181A1F !important;

}


body.collabify-dark .content-header {

    background: #181A1F !important;

}


body.collabify-dark .content-wrapper::-webkit-scrollbar-thumb {

    background: #444954;

}


body.collabify-dark .content-wrapper::-webkit-scrollbar-thumb:hover {

    background: #555B68;

}

</style>


</body>

</html>
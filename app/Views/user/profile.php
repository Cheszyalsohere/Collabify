<?= $this->extend('layouts/template') ?>


<?= $this->section('header') ?>

<div class="profile-heading">

    <div>

        <h1 class="profile-title">
            Profil Saya
        </h1>

        <p class="profile-subtitle">
            Kelola informasi akun dan data pribadi kamu.
        </p>
    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>


<style>

/* =====================================================
   COLLABIFY — PROFILE
   ===================================================== */

.profile-page{
    width:100%;
    max-width:920px;
}


/* =====================================================
   HEADING
   ===================================================== */

.profile-heading{
    margin-bottom:20px;
}

.profile-eyebrow{
    margin-bottom:5px;

    color:#376590;

    font-size:10px;
    font-weight:750;

    letter-spacing:.1em;
    text-transform:uppercase;
}

.profile-title{
    margin:0;

    color:#30323A;

    font-size:27px;
    font-weight:700;

    letter-spacing:-.03em;
}

.profile-subtitle{
    margin:6px 0 0;

    color:#62666D;

    font-size:12px;
}


/* =====================================================
   PROFILE GRID
   ===================================================== */

.profile-grid{
    display:grid;

    grid-template-columns:
        minmax(0, 1fr)
        260px;

    gap:16px;

    align-items:start;
}


/* =====================================================
   MAIN CARD
   ===================================================== */

.profile-card{

    min-width:0;

    background:rgba(255,255,255,.78);

    border:1px solid rgba(255,255,255,.9);

    border-radius:20px;

    box-shadow:
        0 10px 30px rgba(94,145,196,.08),
        inset 0 1px 0 rgba(255,255,255,.95);

    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);

    overflow:hidden;
}


.profile-card-inner{
    padding:22px;
}


/* =====================================================
   PROFILE HEADER
   ===================================================== */

.profile-user{
    display:flex;
    align-items:center;

    gap:13px;

    padding-bottom:19px;

    border-bottom:1px solid #F0EAEB;
}


.profile-avatar{

    width:56px;
    height:56px;

    flex-shrink:0;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:17px;

    background:
        linear-gradient(
            135deg,
            #79A9D8,
            #5E91C4
        );

    color:#FFFFFF;

    font-size:21px;
    font-weight:700;

    box-shadow:
        0 8px 18px rgba(94,145,196,.18);
}


.profile-user-info{
    min-width:0;
}


.profile-name{
    margin:0;

    color:#30323A;

    font-size:17px;
    font-weight:700;
}


.profile-role{
    display:inline-flex;
    align-items:center;

    gap:5px;

    margin-top:5px;

    padding:4px 9px;

    border-radius:999px;

    background:#EAF3FA;

    color:#376590;

    font-size:9px;
    font-weight:700;

    letter-spacing:.06em;

    text-transform:uppercase;
}


/* =====================================================
   FLASH MESSAGE
   ===================================================== */

.profile-alert{
    display:flex;
    align-items:flex-start;

    gap:9px;

    margin-top:18px;
    margin-bottom:18px;

    padding:11px 13px;

    border-radius:11px;

    font-size:12px;
    line-height:1.5;
}


.profile-alert-success{
    background:#EAF3FA;

    color:#376590;

    border:1px solid #D9EAF7;
}


.profile-alert-error{
    background:#FFF0F1;

    color:#B23A52;

    border:1px solid #FFDADD;
}


.profile-alert ul{
    margin:0;

    padding-left:17px;
}


/* =====================================================
   FORM
   ===================================================== */

.profile-form{
    margin-top:20px;
}


.profile-field{
    margin-bottom:17px;
}


.profile-field label{

    display:block;

    margin-bottom:7px;

    color:#30323A;

    font-size:12px;
    font-weight:650;
}


.profile-field input{

    width:100%;
    height:44px;

    padding:0 13px;

    border:1px solid #ECE7E8;

    border-radius:11px;

    background:rgba(255,255,255,.88);

    color:#30323A;

    font-family:inherit;

    font-size:13px;

    outline:none;

    transition:
        border-color .16s ease,
        box-shadow .16s ease,
        background .16s ease;
}


.profile-field input::placeholder{
    color:#62666D;
}


.profile-field input:hover{
    border-color:#DADBDD;
}


.profile-field input:focus{

    border-color:#79A9D8;

    background:#FFFFFF;

    box-shadow:
        0 0 0 3px #EAF3FA;
}


/* =====================================================
   SAVE BUTTON
   ===================================================== */

.profile-save{

    display:inline-flex;
    align-items:center;

    gap:7px;

    min-height:42px;

    margin-top:3px;

    padding:0 17px;

    border:0;
    border-radius:11px;

    background:#4477A6;

    color:#FFFFFF;

    font-size:12px;
    font-weight:650;

    box-shadow:
        0 7px 17px rgba(94,145,196,.18);

    transition:
        transform .16s ease,
        background .16s ease,
        box-shadow .16s ease;
}


.profile-save:hover{

    background:#4477A6;

    color:#FFFFFF;

    transform:translateY(-1px);

    box-shadow:
        0 10px 20px rgba(94,145,196,.22);
}


.profile-save:focus{
    outline:none;

    box-shadow:
        0 0 0 3px #EAF3FA,
        0 7px 17px rgba(94,145,196,.18);
}


/* =====================================================
   SIDE INFO
   ===================================================== */

.profile-side{

    min-width:0;

    display:grid;

    gap:12px;
}


.profile-info-card{

    padding:17px;

    background:rgba(255,255,255,.7);

    border:1px solid rgba(255,255,255,.9);

    border-radius:17px;

    box-shadow:
        0 8px 24px rgba(48,50,58,.05),
        inset 0 1px 0 rgba(255,255,255,.9);

    backdrop-filter:blur(14px);
    -webkit-backdrop-filter:blur(14px);
}


.profile-info-icon{

    width:34px;
    height:34px;

    display:flex;
    align-items:center;
    justify-content:center;

    margin-bottom:11px;

    border-radius:10px;

    background:#FFF0F1;

    color:#B23A52;

    font-size:16px;
}


.profile-info-card:nth-child(2) .profile-info-icon{

    background:#EAF3FA;

    color:#376590;
}


.profile-info-title{

    margin:0 0 5px;

    color:#30323A;

    font-size:12px;
    font-weight:700;
}


.profile-info-text{

    margin:0;

    color:#62666D;

    font-size:10.5px;
    line-height:1.6;
}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media(max-width:900px){

    .profile-grid{
        grid-template-columns:1fr;
    }

    .profile-side{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

}


@media(max-width:600px){

    .profile-title{
        font-size:24px;
    }

    .profile-card-inner{
        padding:17px;
    }

    .profile-side{
        grid-template-columns:1fr;
    }

    .profile-avatar{
        width:50px;
        height:50px;
    }

}

</style>


<div class="profile-page">


    <div class="profile-grid">


        <!-- =================================================
             PROFILE FORM
             ================================================= -->

        <div class="profile-card">

            <div class="profile-card-inner">


                <!-- USER HEADER -->

                <div class="profile-user">

                    <div class="profile-avatar">

                        <?= strtoupper(
                            mb_substr(
                                session('name') ?? 'U',
                                0,
                                1
                            )
                        ) ?>

                    </div>


                    <div class="profile-user-info">

                        <div class="profile-name">

                            <?= esc(
                                session('name') ?? 'User'
                            ) ?>

                        </div>


                        <span class="profile-role">

                            <i
                                class="ti ti-user"
                                style="font-size:11px"
                            ></i>

                            <?= esc(
                                session('role') ?? 'User'
                            ) ?>

                        </span>

                    </div>

                </div>


                <!-- FLASH SUCCESS -->

                <?php if (session('success')): ?>

                    <div class="profile-alert profile-alert-success">

                        <i
                            class="ti ti-circle-check"
                            style="font-size:16px"
                        ></i>

                        <span>
                            <?= esc(
                                session('success')
                            ) ?>
                        </span>

                    </div>

                <?php endif; ?>


                <!-- FLASH ERROR -->

                <?php if (session('errors')): ?>

                    <div class="profile-alert profile-alert-error">

                        <i
                            class="ti ti-alert-circle"
                            style="font-size:16px"
                        ></i>

                        <ul>

                            <?php foreach (
                                session('errors')
                                as $e
                            ): ?>

                                <li>
                                    <?= esc($e) ?>
                                </li>

                            <?php endforeach; ?>

                        </ul>

                    </div>

                <?php endif; ?>


                <!-- FORM -->

                <form
                    action="<?= base_url('profil') ?>"
                    method="post"
                    class="profile-form"
                >

                    <?= csrf_field() ?>


                    <!-- NAME -->

                    <div class="profile-field">

                        <label>
                            Nama lengkap
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="<?= esc(
                                old(
                                    'name',
                                    $user['name'] ?? ''
                                )
                            ) ?>"
                            required
                        >

                    </div>


                    <!-- EMAIL -->

                    <div class="profile-field">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="<?= esc(
                                old(
                                    'email',
                                    $user['email'] ?? ''
                                )
                            ) ?>"
                            required
                        >

                    </div>


                    <!-- CONTACT -->

<!-- SAVE -->

                    <button
                        type="submit"
                        class="profile-save"
                    >

                        <i class="ti ti-device-floppy"></i>

                        Simpan perubahan

                    </button>


                </form>


            </div>

        </div>


        <!-- =================================================
             SIDE INFORMATION
             ================================================= -->

        <div class="profile-side">


            <div class="profile-info-card">

                <div class="profile-info-icon">

                    <i class="ti ti-user-circle"></i>

                </div>

                <h3 class="profile-info-title">
                    Informasi akun
                </h3>

                <p class="profile-info-text">
                    Data nama dan email digunakan
                    sebagai identitas kamu di Collabify.
                </p>

            </div>


            <div class="profile-info-card">

                <div class="profile-info-icon">

                    <i class="ti ti-users-group"></i>

                </div>

                <h3 class="profile-info-title">
                    Profil kolaborasi
                </h3>

                <p class="profile-info-text">
                    Informasi profil dapat digunakan
                    dalam aktivitas kelompok dan
                    kolaborasi kamu.
                </p>

            </div>


        </div>


    </div>


</div>


<?= $this->endSection() ?>
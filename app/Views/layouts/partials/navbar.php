<nav class="main-header navbar navbar-expand navbar-white navbar-light collabify-navbar">

    <!-- LEFT -->
    <ul class="navbar-nav align-items-center navbar-left">

        <li class="nav-item">
            <a
                class="nav-link"
                data-widget="pushmenu"
                href="#"
                role="button"
                style="padding:8px 12px"
            >
                <i class="ti ti-menu-2 collabify-menu-icon"></i>
            </a>
        </li>

        <!-- SEARCH -->
        <li class="nav-item collabify-search-wrap">

            <span
                onclick="if(window.showToast){showToast('Pencarian cepat segera hadir')}"
                class="collabify-search"
            >

                <i class="ti ti-search"></i>

                <span class="collabify-search-text">
                    Cari tugas, kelompok, catatan...
                </span>

                <span class="collabify-search-shortcut">
                    ⌘K
                </span>

            </span>

        </li>

    </ul>


    <!-- RIGHT -->
    <ul class="navbar-nav ml-auto align-items-center collabify-navbar-right">

        <!-- THEME TOGGLE -->
        <li class="nav-item">

            <button
                type="button"
                class="collabify-theme-toggle"
                id="themeToggle"
                title="Ganti mode tampilan"
                aria-label="Ganti mode tampilan"
            >
                <i
                    class="ti ti-sun"
                    id="themeIcon"
                ></i>
            </button>

        </li>


        <!-- NOTIFICATION -->
        <li class="nav-item">

            <a
                href="#"
                class="nav-link collabify-icon-button"
                role="button"
                title="Notifikasi"
            >
                <i class="ti ti-bell"></i>
            </a>

        </li>


        <!-- USER -->
        <li class="nav-item dropdown">

            <a
                class="nav-link dropdown-toggle d-flex align-items-center collabify-user-menu"
                href="#"
                data-toggle="dropdown"
            >

                <span class="collabify-avatar">

                    <?= strtoupper(
                        mb_substr(
                            session('name') ?? 'A',
                            0,
                            1
                        )
                    ) ?>

                </span>

                <span class="collabify-user-name">
                    <?= esc(session('name') ?? 'Admin') ?>
                </span>

                <i class="ti ti-chevron-down collabify-chevron"></i>

            </a>


            <div class="dropdown-menu dropdown-menu-right collabify-dropdown">

                <a
                    href="<?= base_url('profil') ?>"
                    class="dropdown-item"
                >
                    <i class="ti ti-user-circle"></i>
                    <span>Profil</span>
                </a>

                <div class="dropdown-divider"></div>

                <a
                    href="<?= base_url('logout') ?>"
                    class="dropdown-item collabify-logout"
                >
                    <i class="ti ti-logout"></i>
                    <span>Keluar</span>
                </a>

            </div>

        </li>

    </ul>

</nav>


<style>

/* =====================================================
   COLLABIFY NAVBAR
   ===================================================== */

.collabify-navbar {

    min-height: 58px;

    border-bottom: 1px solid #F0DFE1 !important;

    background: #FFFFFF !important;

    padding: 0 14px;

    z-index: 1035 !important;
}


/* =====================================================
   LEFT
   ===================================================== */

.navbar-left {

    flex: 1 1 auto;

    min-width: 0;
}


.collabify-menu-icon {

    font-size: 20px;

    color: #77777D;

    transition:
        color .16s ease,
        transform .16s ease;
}


.nav-link:hover .collabify-menu-icon {

    color: #5E91C4;

    transform: scale(1.04);
}


/* =====================================================
   SEARCH
   ===================================================== */

.collabify-search-wrap {

    flex: 1 1 auto;

    min-width: 0;

    margin-left: 4px;

    margin-right: 18px;
}


.collabify-search {

    width: 100%;

    max-width: none;

    min-height: 40px;

    display: flex;

    align-items: center;

    gap: 9px;

    padding: 0 13px;

    border: 1px solid #F0DFE1;

    border-radius: 11px;

    background: #FFF8F7;

    color: #9A9AA0;

    font-size: 12.5px;

    cursor: pointer;

    transition:
        border-color .16s ease,
        background .16s ease,
        box-shadow .16s ease;
}


.collabify-search:hover {

    border-color: #D7E7F4;

    background: #FFFFFF;

    box-shadow:
        0 4px 12px rgba(94,145,196,.06);
}


.collabify-search > i {

    flex-shrink: 0;

    color: #9A9AA0;

    font-size: 16px;
}


.collabify-search-text {

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}


.collabify-search-shortcut {

    flex-shrink: 0;

    margin-left: auto;

    padding: 2px 6px;

    border: 1px solid #E7E1E2;

    border-radius: 5px;

    background: #FFFFFF;

    color: #9A9AA0;

    font-family: var(--mono);

    font-size: 9px;
}


/* =====================================================
   RIGHT
   ===================================================== */

.collabify-navbar-right {

    gap: 4px;

    flex-shrink: 0;
}


/* =====================================================
   THEME
   ===================================================== */

.collabify-theme-toggle {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: 0;

    border-radius: 10px;

    background: transparent;

    color: #77777D;

    cursor: pointer;

    transition:
        background .16s ease,
        color .16s ease,
        transform .16s ease;
}


.collabify-theme-toggle:hover {

    background: #FFF0F1;

    color: #FF677D;

    transform: translateY(-1px);
}


.collabify-theme-toggle i {

    font-size: 18px;
}


/* =====================================================
   NOTIFICATION
   ===================================================== */

.collabify-icon-button {

    width: 38px;

    height: 38px;

    display: flex !important;

    align-items: center;

    justify-content: center;

    padding: 0 !important;

    border-radius: 10px;

    color: #77777D !important;

    transition:
        background .16s ease,
        color .16s ease;
}


.collabify-icon-button:hover {

    background: #EAF3FA;

    color: #5E91C4 !important;
}


.collabify-icon-button i {

    font-size: 18px;
}


/* =====================================================
   USER
   ===================================================== */

.collabify-user-menu {

    gap: 8px;

    padding: 5px 7px 5px 6px !important;

    border-radius: 10px;

    color: #30323A !important;
}


.collabify-user-menu:hover {

    background: #F8F8F8;
}


.collabify-avatar {

    width: 31px;

    height: 31px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 10px;

    background: #79A9D8;

    color: #FFFFFF;

    font-size: 12px;

    font-weight: 700;
}


.collabify-user-name {

    max-width: 130px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    color: #30323A;

    font-size: 13px;

    font-weight: 600;
}


.collabify-chevron {

    color: #9A9AA0;

    font-size: 14px;
}


/* =====================================================
   DROPDOWN
   ===================================================== */

.collabify-dropdown {

    min-width: 180px;

    margin-top: 8px;

    padding: 6px;

    border: 1px solid #F0DFE1;

    border-radius: 12px;

    background: #FFFFFF;

    box-shadow:
        0 18px 40px rgba(48,50,58,.12);
}


.collabify-dropdown .dropdown-item {

    display: flex;

    align-items: center;

    gap: 9px;

    padding: 9px 11px;

    border-radius: 8px;

    color: #30323A;

    font-size: 13px;

    font-weight: 500;
}


.collabify-dropdown .dropdown-item i {

    color: #77777D;

    font-size: 16px;
}


.collabify-dropdown .dropdown-item:hover {

    background: #EAF3FA;

    color: #5E91C4;
}


.collabify-dropdown .dropdown-item:hover i {

    color: #5E91C4;
}


.collabify-dropdown .dropdown-divider {

    margin: 5px 6px;

    border-top: 1px solid #F0DFE1;
}


.collabify-dropdown .collabify-logout:hover {

    background: #FFF0F1;

    color: #FF677D;
}


.collabify-dropdown .collabify-logout:hover i {

    color: #FF677D;
}


/* =====================================================
   DARK NAVBAR
   ===================================================== */

body.collabify-dark .collabify-navbar {

    background: #202329 !important;

    border-bottom-color: #343841 !important;
}


body.collabify-dark .collabify-menu-icon {

    color: #A7AAB2;
}


body.collabify-dark .collabify-search {

    background: #181A1F;

    border-color: #343841;

    color: #858993;
}


body.collabify-dark .collabify-search:hover {

    background: #24272D;

    border-color: #4B5360;
}


body.collabify-dark .collabify-search-shortcut {

    background: #24272D;

    border-color: #3C414B;

    color: #858993;
}


body.collabify-dark .collabify-user-menu {

    color: #F1F2F4 !important;
}


body.collabify-dark .collabify-user-menu:hover {

    background: #292C32;
}


body.collabify-dark .collabify-user-name {

    color: #F1F2F4;
}


body.collabify-dark .collabify-theme-toggle {

    color: #A7AAB2;
}


body.collabify-dark .collabify-theme-toggle:hover {

    background: #34303A;

    color: #FF9AA2;
}


body.collabify-dark .collabify-icon-button {

    color: #A7AAB2 !important;
}


body.collabify-dark .collabify-icon-button:hover {

    background: #293541;

    color: #79A9D8 !important;
}


body.collabify-dark .collabify-dropdown {

    background: #22252B;

    border-color: #343841;
}


body.collabify-dark .collabify-dropdown .dropdown-item {

    color: #F1F2F4;
}


body.collabify-dark .collabify-dropdown .dropdown-item i {

    color: #A7AAB2;
}


body.collabify-dark .collabify-dropdown .dropdown-item:hover {

    background: #293541;

    color: #79A9D8;
}


body.collabify-dark .collabify-dropdown .dropdown-item:hover i {

    color: #79A9D8;
}


body.collabify-dark .collabify-dropdown .dropdown-divider {

    border-top-color: #343841;
}


/* =====================================================
   RESPONSIVE
   ===================================================== */

@media (max-width: 767px) {

    .collabify-search-wrap {

        margin-right: 7px;
    }

    .collabify-search-shortcut {

        display: none;
    }

    .collabify-user-name {

        display: none;
    }

}


@media (max-width: 480px) {

    .collabify-navbar {

        padding: 0 7px;
    }

    .collabify-search-text {

        font-size: 11.5px;
    }

}

</style>


<script>

(function () {

    const body = document.body;
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    if (!toggle || !icon) {
        return;
    }


    function applyTheme(theme) {

        if (theme === 'dark') {

            body.classList.add('collabify-dark');

            icon.className = 'ti ti-moon';

        } else {

            body.classList.remove('collabify-dark');

            icon.className = 'ti ti-sun';

        }

    }


    const savedTheme =
        localStorage.getItem('collabify-theme') || 'light';


    applyTheme(savedTheme);


    toggle.addEventListener('click', function () {

        const isDark =
            body.classList.contains('collabify-dark');

        const nextTheme =
            isDark ? 'light' : 'dark';


        localStorage.setItem(
            'collabify-theme',
            nextTheme
        );


        applyTheme(nextTheme);

    });

})();

</script>
<?php $u = uri_string(); ?>

<aside class="main-sidebar sidebar-light-primary elevation-1">

    <a href="<?= base_url('/dashboard') ?>" class="brand-link">
        <span class="brand-text font-weight-bold">COLLABIFY</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu">

                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a href="<?= base_url('/dashboard') ?>"
                       class="nav-link <?= $u === 'dashboard' ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-layout-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- KELOMPOK -->
                <li class="nav-header">KOLABORASI</li>

                <li class="nav-item">
                    <a href="<?= base_url('/groups') ?>"
                       class="nav-link <?= str_contains($u, 'groups') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-users-group"></i>
                        <p>Kelompok</p>
                    </a>
                </li>

                <!-- TUGAS -->
                <li class="nav-item">
                    <a href="<?= base_url('/tasks') ?>"
                       class="nav-link <?= str_contains($u, 'tasks') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-checkbox"></i>
                        <p>Tugas</p>
                    </a>
                </li>

                <!-- CATATAN -->
                <li class="nav-item">
                    <a href="<?= base_url('/notes') ?>"
                       class="nav-link <?= str_contains($u, 'notes') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-notes"></i>
                        <p>Catatan</p>
                    </a>
                </li>

                <!-- TEMPLATE -->
                <li class="nav-header">SUMBER DAYA</li>

                <li class="nav-item">
                    <a href="<?= base_url('/templates') ?>"
                       class="nav-link <?= str_contains($u, 'templates') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-file-description"></i>
                        <p>Template</p>
                    </a>
                </li>

                <li class="nav-item">

    <a
        href="<?= base_url('workspaces') ?>"
        class="nav-link"
    >

        <i class="nav-icon fas fa-folder-open"></i>

        <p>
            Workspace
        </p>

    </a>

</li>

                <!-- FORUM -->
                <li class="nav-header">KOMUNITAS</li>

                <li class="nav-item">
                    <a href="<?= base_url('/forum') ?>"
                       class="nav-link <?= str_contains($u, 'forum') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-message-circle"></i>
                        <p>Forum</p>
                    </a>
                </li>

                <!-- SPIN -->
                <li class="nav-item">
                    <a href="<?= base_url('/spin') ?>"
                       class="nav-link <?= str_contains($u, 'spin') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-dice-5"></i>
                        <p>Spin Pembagian Tugas</p>
                    </a>
                </li>

                <!-- PROFIL -->
                <li class="nav-header">AKUN</li>

                <li class="nav-item">
                    <a href="<?= base_url('/profil') ?>"
                       class="nav-link <?= str_contains($u, 'profil') ? 'active' : '' ?>">
                        <i class="nav-icon ti ti-user"></i>
                        <p>Profil</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/logout') ?>" class="nav-link">
                        <i class="nav-icon ti ti-logout"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
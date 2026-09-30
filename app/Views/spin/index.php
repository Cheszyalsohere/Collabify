<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div>
    <div class="page-eyebrow">TOOLS</div>
    <h1 class="page-title mb-1">Spin Pembagian Tugas</h1>
    <p class="page-sub mb-0">Bagi bagian tugas ke anggota kelompok secara adil dan transparan.</p>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

                    <style>
                    /* =========================================================
                       COLLABIFY — SPIN
                       ========================================================= */
                    .spin-page {
                        --spin-primary: #5E91C4;
                        --spin-primary-dark: #4A7DB0;
                        --spin-soft: #EAF3FA;
                        --spin-border: #e7e5ef;
                        --spin-text: #242336;
                        --spin-muted: #858397;
                        --spin-success: #27b07d;
                        --spin-bg: #f8f8fc;
                        padding: 28px;
                        background: var(--spin-bg);
                        min-height: calc(100vh - 70px);
                    }

                    .spin-header {
                        margin-bottom: 24px;
                    }

                    .spin-header h1 {
                        margin: 0;
                        font-size: 28px;
                        font-weight: 800;
                        color: var(--spin-text);
                    }

                    .spin-header p {
                        margin: 6px 0 0;
                        color: var(--spin-muted);
                    }/* =========================
                       TOP CONTROL
                       ========================= */
                    .spin-settings {
                        background: #fff;
                        border: 1px solid var(--spin-border);
                        border-radius: 20px;
                        padding: 22px;
                        margin-bottom: 22px;
                        box-shadow: 0 8px 30px rgba(50, 40, 100, .04);
                    }

                    .spin-settings-title {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        font-weight: 750;
                        color: var(--spin-text);
                        margin-bottom: 18px;
                    }

                    .spin-settings-title i {
                        width: 34px;
                        height: 34px;
                        border-radius: 10px;
                        background: var(--spin-soft);
                        color: var(--spin-primary);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .spin-select-grid {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 16px;
                    }

                    .spin-field label {
                        display: block;
                        font-size: 13px;
                        font-weight: 700;
                        color: #5f5b70;
                        margin-bottom: 7px;
                    }

                    .spin-field select {
                        width: 100%;
                        height: 46px;
                        border: 1px solid #dddbe7;
                        border-radius: 12px;
                        padding: 0 14px;
                        background: #fff;
                        color: var(--spin-text);
                        outline: none;
                        transition: .2s;
                    }

                    .spin-field select:focus {
                        border-color: var(--spin-primary);
                        box-shadow: 0 0 0 4px rgba(94,145,196, .10);
                    }/* =========================
                       TASK INFO
                       ========================= */
                    .task-info {
                        margin-top: 18px;
                        padding: 15px 16px;
                        background: #faf9ff;
                        border: 1px solid #ebe8ff;
                        border-radius: 14px;
                        display: none;
                    }

                    .task-info.active {
                        display: flex;
                        gap: 13px;
                        align-items: flex-start;
                    }

                    .task-info-icon {
                        width: 38px;
                        height: 38px;
                        flex: 0 0 38px;
                        border-radius: 11px;
                        background: #e9e5ff;
                        color: var(--spin-primary);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .task-info-title {
                        font-weight: 750;
                        color: var(--spin-text);
                    }

                    .task-info-description {
                        margin-top: 3px;
                        font-size: 13px;
                        color: var(--spin-muted);
                    }/* =========================
                       MAIN GRID
                       ========================= */
                    .spin-main-grid {
                        display: grid;
                        grid-template-columns: minmax(0, 1.3fr) minmax(310px, .7fr);
                        gap: 22px;
                        align-items: start;
                    }

                    .spin-wheel-card, .spin-side-card, .history-card {
                        background: #fff;
                        border: 1px solid var(--spin-border);
                        border-radius: 22px;
                        box-shadow: 0 8px 30px rgba(50, 40, 100, .04);
                    }/* =========================
                       WHEEL
                       ========================= */
                    .spin-wheel-card {
                        padding: 24px;
                        position: relative;
                        overflow: hidden;
                    }

                    .wheel-status {
                        display: flex;
                        justify-content: center;
                        margin-bottom: 12px;
                    }

                    .wheel-status span {
                        display: inline-flex;
                        align-items: center;
                        gap: 7px;
                        background: #f5f4fa;
                        border: 1px solid #eae8f0;
                        color: #777387;
                        padding: 7px 13px;
                        border-radius: 999px;
                        font-size: 12px;
                        font-weight: 700;
                    }

                    .wheel-stage {
                        width: min(500px, 100%);
                        aspect-ratio: 1;
                        margin: 0 auto;
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    #wheelCanvas {
                        width: 100%;
                        height: 100%;
                        display: block;
                        transform-origin: center center;
                        will-change: transform;
                        filter: drop-shadow(0 15px 30px rgba(70, 60, 120, .12));
                    }

                    .wheel-pointer {
                        position: absolute;
                        z-index: 5;
                        top: -3px;
                        left: 50%;
                        transform: translateX(-50%);
                        width: 0;
                        height: 0;
                        border-left: 17px solid transparent;
                        border-right: 17px solid transparent;
                        border-top: 35px solid #2f2c40;
                        filter: drop-shadow(0 4px 5px rgba(0, 0, 0, .16));
                    }

                    .wheel-center {
                        position: absolute;
                        width: 68px;
                        height: 68px;
                        border-radius: 50%;
                        background: white;
                        border: 7px solid rgba(255, 255, 255, .85);
                        box-shadow: 0 7px 20px rgba(50, 40, 100, .18);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: var(--spin-primary);
                        font-size: 26px;
                        z-index: 3;
                        pointer-events: none;
                    }

                    .spin-button-wrap {
                        text-align: center;
                        margin-top: 14px;
                    }

                    .spin-button {
                        border: 0;
                        background: linear-gradient(135deg, var(--spin-primary), #8FB8E3);
                        color: #fff;
                        border-radius: 14px;
                        padding: 13px 30px;
                        font-size: 15px;
                        font-weight: 800;
                        cursor: pointer;
                        box-shadow: 0 10px 22px rgba(94,145,196, .24);
                        transition: transform .2s, box-shadow .2s, opacity .2s;
                    }

                    .spin-button:hover:not(:disabled) {
                        transform: translateY(-2px);
                        box-shadow: 0 14px 28px rgba(94,145,196, .30);
                    }

                    .spin-button:disabled {
                        cursor: not-allowed;
                        opacity: .5;
                        box-shadow: none;
                    }

                    .spin-helper {
                        margin-top: 9px;
                        font-size: 12px;
                        color: var(--spin-muted);
                    }/* =========================
                       SIDE PANEL
                       ========================= */
                    .spin-side-card {
                        padding: 20px;
                    }

                    .side-section + .side-section {
                        margin-top: 24px;
                    }

                    .side-title {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 11px;
                    }

                    .side-title strong {
                        color: var(--spin-text);
                        font-size: 14px;
                    }

                    .side-count {
                        background: #f0eefc;
                        color: var(--spin-primary);
                        border-radius: 999px;
                        padding: 4px 9px;
                        font-size: 11px;
                        font-weight: 800;
                    }

                    .member-list, .option-list {
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                    }

                    .member-item, .option-item {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 10px 11px;
                        border: 1px solid #eceaf1;
                        border-radius: 12px;
                        background: #fff;
                        animation: itemIn .25s ease both;
                    }

                    @keyframes itemIn {
                        from {
                            opacity: 0;
                            transform: translateY(5px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    .member-avatar {
                        width: 31px;
                        height: 31px;
                        flex: 0 0 31px;
                        border-radius: 50%;
                        background: linear-gradient(135deg, #ece9ff, #dcd7ff);
                        color: var(--spin-primary-dark);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 12px;
                        font-weight: 800;
                    }

                    .member-name, .option-name {
                        font-size: 13px;
                        font-weight: 650;
                        color: #403d4d;
                    }

                    .option-input-row {
                        display: flex;
                        gap: 7px;
                        align-items: center;
                    }

                    .option-input {
                        flex: 1;
                        height: 39px;
                        border: 1px solid #e0dee7;
                        border-radius: 10px;
                        padding: 0 11px;
                        font-size: 13px;
                        outline: none;
                    }

                    .option-input:focus {
                        border-color: var(--spin-primary);
                        box-shadow: 0 0 0 3px rgba(94,145,196, .08);
                    }

                    .option-remove {
                        width: 32px;
                        height: 32px;
                        border: 0;
                        background: #f5f3f8;
                        color: #9893a5;
                        border-radius: 9px;
                        cursor: pointer;
                    }

                    .add-option {
                        width: 100%;
                        margin-top: 9px;
                        border: 1px dashed #c9c5d8;
                        background: #F7FAFD;
                        color: #706b80;
                        border-radius: 10px;
                        padding: 9px;
                        cursor: pointer;
                        font-size: 12px;
                        font-weight: 700;
                    }

                    .option-warning {
                        margin-top: 10px;
                        font-size: 12px;
                        color: #c26a32;
                        background: #fff8f2;
                        border: 1px solid #f8e1d0;
                        border-radius: 10px;
                        padding: 9px 11px;
                        display: none;
                    }

                    .option-warning.show {
                        display: block;
                    }/* =========================
                       PROGRESS
                       ========================= */
                    .assignment-progress {
                        margin-top: 17px;
                        display: none;
                    }

                    .assignment-progress.show {
                        display: block;
                    }

                    .progress-label {
                        display: flex;
                        justify-content: space-between;
                        font-size: 12px;
                        color: #777286;
                        margin-bottom: 7px;
                    }

                    .progress-track {
                        height: 7px;
                        background: #eeecf3;
                        border-radius: 99px;
                        overflow: hidden;
                    }

                    .progress-fill {
                        height: 100%;
                        width: 0;
                        background: linear-gradient(90deg, #5E91C4, #A8C7E8);
                        border-radius: inherit;
                        transition: width .4s ease;
                    }/* =========================
                       HISTORY
                       ========================= */
                    .history-card {
                        margin-top: 22px;
                        padding: 22px;
                    }

                    .history-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 16px;
                    }

                    .history-header h2 {
                        margin: 0;
                        font-size: 17px;
                        color: var(--spin-text);
                    }

                    .history-header p {
                        margin: 4px 0 0;
                        font-size: 12px;
                        color: var(--spin-muted);
                    }

                    .history-empty {
                        padding: 30px 15px;
                        text-align: center;
                        color: #9994a6;
                        font-size: 13px;
                        background: #faf9fc;
                        border-radius: 15px;
                    }

                    .history-session {
                        border: 1px solid #eae8ef;
                        border-radius: 16px;
                        overflow: hidden;
                        margin-bottom: 11px;
                    }

                    .history-session-head {
                        padding: 14px 15px;
                        background: #F7FAFD;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        cursor: pointer;
                    }

                    .history-session-title {
                        font-weight: 750;
                        font-size: 13px;
                        color: var(--spin-text);
                    }

                    .history-session-meta {
                        margin-top: 3px;
                        font-size: 11px;
                        color: #9792a3;
                    }

                    .history-complete {
                        font-size: 10px;
                        font-weight: 800;
                        color: #16825d;
                        background: #e8f8f1;
                        border-radius: 999px;
                        padding: 5px 8px;
                    }

                    .history-body {
                        padding: 10px 15px 14px;
                        display: none;
                    }

                    .history-session.open .history-body {
                        display: block;
                    }

                    .history-row {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 12px;
                        padding: 10px 0;
                        border-bottom: 1px solid #f0eef3;
                        font-size: 12px;
                    }

                    .history-row:last-child {
                        border-bottom: 0;
                    }

                    .history-person {
                        font-weight: 700;
                        color: #484454;
                    }

                    .history-result {
                        color: #716c7c;
                    }/* =========================
                       RESULT MODAL
                       ========================= */
                    .result-overlay {
                        position: fixed;
                        inset: 0;
                        z-index: 9999;
                        background: rgba(27, 24, 42, .56);
                        backdrop-filter: blur(7px);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 20px;
                        opacity: 0;
                        visibility: hidden;
                        transition: opacity .25s ease, visibility .25s ease;
                    }

                    .result-overlay.show {
                        opacity: 1;
                        visibility: visible;
                    }

                    .result-modal {
                        width: min(420px, 100%);
                        background: #fff;
                        border-radius: 26px;
                        padding: 30px;
                        text-align: center;
                        box-shadow: 0 30px 80px rgba(0, 0, 0, .22);
                        transform: translateY(18px) scale(.94);
                        transition: transform .35s cubic-bezier(.2, .9, .2, 1);
                        position: relative;
                        overflow: hidden;
                    }

                    .result-overlay.show .result-modal {
                        transform: translateY(0) scale(1);
                    }

                    .result-glow {
                        position: absolute;
                        width: 220px;
                        height: 220px;
                        border-radius: 50%;
                        background: rgba(94,145,196, .12);
                        filter: blur(25px);
                        left: 50%;
                        top: -120px;
                        transform: translateX(-50%);
                    }

                    .result-icon {
                        position: relative;
                        width: 68px;
                        height: 68px;
                        margin: 0 auto 15px;
                        border-radius: 50%;
                        background: linear-gradient(135deg, #D5E6F5, #EAF3FA);
                        color: var(--spin-primary);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 29px;
                        animation: winnerPop .55s cubic-bezier(.2, 1.4, .4, 1);
                    }

                    @keyframes winnerPop {
                        0% {
                            transform: scale(.4) rotate(-15deg);
                            opacity: 0;
                        }

                        100% {
                            transform: scale(1) rotate(0);
                            opacity: 1;
                        }
                    }

                    .result-small {
                        position: relative;
                        color: #8a8596;
                        font-size: 12px;
                        font-weight: 700;
                    }

                    .result-name {
                        position: relative;
                        margin-top: 4px;
                        font-size: 29px;
                        font-weight: 850;
                        color: var(--spin-text);
                    }

                    .result-sub {
                        position: relative;
                        color: #8b8697;
                        font-size: 13px;
                        margin-top: 3px;
                    }

                    .result-task {
                        position: relative;
                        margin: 20px auto;
                        background: linear-gradient(135deg, #f0edff, #f8f6ff);
                        border: 1px solid #e3dfff;
                        border-radius: 15px;
                        padding: 14px;
                        color: var(--spin-primary-dark);
                        font-size: 16px;
                        font-weight: 800;
                    }

                    .result-button {
                        position: relative;
                        width: 100%;
                        border: 0;
                        background: var(--spin-primary);
                        color: white;
                        border-radius: 13px;
                        padding: 12px 18px;
                        font-weight: 800;
                        cursor: pointer;
                    }

                    .result-button:hover {
                        background: var(--spin-primary-dark);
                    }

                    .confetti {
                        position: fixed;
                        pointer-events: none;
                        z-index: 10001;
                        width: 7px;
                        height: 12px;
                        border-radius: 2px;
                        animation: confettiFall 1.25s ease-out forwards;
                    }

                    @keyframes confettiFall {
                        from {
                            opacity: 1;
                            transform: translate(0, 0) rotate(0deg);
                        }

                        to {
                            opacity: 0;
                            transform: translate(var(--x), var(--y)) rotate(520deg);
                        }
                    }/* =========================
                       CONCLUSION
                       ========================= */
                    .conclusion-section {
                        display: none;
                        margin-top: 22px;
                    }

                    .conclusion-section.show {
                        display: block;
                        animation: conclusionIn .5s ease both;
                    }

                    @keyframes conclusionIn {
                        from {
                            opacity: 0;
                            transform: translateY(15px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    .conclusion-card {
                        background: #fff;
                        border: 1px solid var(--spin-border);
                        border-radius: 24px;
                        padding: 28px;
                        box-shadow: 0 10px 35px rgba(50, 40, 100, .06);
                    }

                    .conclusion-success {
                        text-align: center;
                        margin-bottom: 22px;
                    }

                    .conclusion-check {
                        width: 62px;
                        height: 62px;
                        margin: 0 auto 12px;
                        border-radius: 50%;
                        background: #e7f8f0;
                        color: #1b9b6e;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 27px;
                    }

                    .conclusion-success h2 {
                        margin: 0;
                        font-size: 22px;
                        color: var(--spin-text);
                    }

                    .conclusion-success p {
                        margin: 5px 0 0;
                        color: var(--spin-muted);
                        font-size: 13px;
                    }

                    .receipt-preview {
                        width: min(520px, 100%);
                        margin: 0 auto;
                        padding: 24px;
                        border-radius: 20px;
                        background:
                        radial-gradient(circle at 10% 0%, rgba(125, 110, 255, .18), transparent 30%), radial-gradient(circle at 100% 100%, rgba(95, 205, 190, .14), transparent 30%), #fbfaff;
                        border: 1px solid #e8e5f2;
                    }

                    .receipt-brand {
                        font-size: 11px;
                        letter-spacing: .12em;
                        font-weight: 900;
                        color: var(--spin-primary);
                        text-transform: uppercase;
                    }

                    .receipt-title {
                        font-size: 22px;
                        font-weight: 850;
                        color: var(--spin-text);
                        margin-top: 8px;
                    }

                    .receipt-task {
                        margin-top: 4px;
                        font-size: 14px;
                        color: #787285;
                    }

                    .receipt-divider {
                        height: 1px;
                        background: #e7e4ee;
                        margin: 19px 0;
                    }

                    .receipt-row {
                        display: grid;
                        grid-template-columns: 1fr 1.15fr;
                        gap: 14px;
                        padding: 10px 0;
                        border-bottom: 1px solid #eeeaf2;
                    }

                    .receipt-row:last-child {
                        border-bottom: 0;
                    }

                    .receipt-member {
                        font-size: 13px;
                        font-weight: 800;
                        color: #454151;
                    }

                    .receipt-result {
                        font-size: 13px;
                        color: #696475;
                    }

                    .receipt-footer {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-top: 17px;
                        color: #9893a3;
                        font-size: 10px;
                    }

                    .conclusion-actions {
                        width: min(520px, 100%);
                        margin: 17px auto 0;
                        display: grid;
                        grid-template-columns: 1.2fr 1fr;
                        gap: 9px;
                    }

                    .action-button {
                        border: 0;
                        border-radius: 12px;
                        padding: 11px 13px;
                        font-size: 12px;
                        font-weight: 800;
                        cursor: pointer;
                    }

                    .action-primary {
                        background: var(--spin-primary);
                        color: #fff;
                    }

                    .action-secondary {
                        background: #f0eef6;
                        color: #5f5a6d;
                    }

                    .action-full {
                        grid-column: 1 / -1;
                    }

                    .action-button:disabled {
                        opacity: .5;
                        cursor: not-allowed;
                    }

                    .note-status {
                        width: min(520px, 100%);
                        margin: 9px auto 0;
                        font-size: 12px;
                        text-align: center;
                        color: #238263;
                        min-height: 18px;
                    }/* =========================
                       EMPTY STATE
                       ========================= */
                    .spin-empty {
                        padding: 35px 20px;
                        text-align: center;
                        color: #938e9f;
                    }

                    .spin-empty i {
                        font-size: 35px;
                        display: block;
                        margin-bottom: 8px;
                    }/* =========================
                       RESPONSIVE
                       ========================= */
                    @media (max-width: 900px) {
                        .spin-main-grid {
                            grid-template-columns: 1fr;
                        }

                        .spin-side-card {
                            order: 2;
                        }
                    }

                    @media (max-width: 650px) {
                        .spin-page {
                            padding: 17px;
                        }

                        .spin-select-grid {
                            grid-template-columns: 1fr;
                        }

                        .spin-wheel-card, .spin-side-card, .history-card, .conclusion-card {
                            border-radius: 18px;
                            padding: 17px;
                        }

                        .spin-header h1 {
                            font-size: 23px;
                        }

                        .conclusion-actions {
                            grid-template-columns: 1fr;
                        }

                        .action-full {
                            grid-column: auto;
                        }
                    }
                    </style>

                    <div class="spin-page">

                        <!-- judul halaman sudah ada di header layout -->

                        <!-- =========================
                                 SETTINGS
                                 ========================= -->
                        <div class="spin-settings">

                            <div class="spin-settings-title">
                                <i class="ti ti-adjustments"></i>
                                <span>Pengaturan Spin</span>
                            </div>

                            <div class="spin-select-grid">

                                <div class="spin-field">
                                    <label for="groupSelect">Pilih kelompok</label>

                                    <select id="groupSelect">
                                        <option value="">-- Pilih kelompok --</option>

                                        <?php foreach ($groups as $g): ?>
                                            <option value="<?= (int) $g['id_group'] ?>"><?= esc($g['nama_kelompok']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="spin-field">
                                    <label for="taskSelect">Pilih tugas</label>

                                    <select id="taskSelect" disabled>
                                        <option value="">-- Pilih tugas --</option>
                                    </select>
                                </div>

                            </div>

                            <div id="taskInfo" class="task-info">

                                <div class="task-info-icon">
                                    <i class="ti ti-file-description"></i>
                                </div>

                                <div>
                                    <div id="taskInfoTitle" class="task-info-title"></div>
                                    <div id="taskInfoDescription" class="task-info-description"></div>
                                </div>

                            </div>

                        </div>

                        <!-- =========================
                                 MAIN
                                 ========================= -->
                        <div class="spin-main-grid">

                            <!-- WHEEL -->
                            <div class="spin-wheel-card">

                                <div class="wheel-status">
                                    <span id="wheelStatus">
                                        <i class="ti ti-circle-check"></i>

                                                            Siap untuk spin
                                                        
                                    </span>
                                </div>

                                <div class="wheel-stage">

                                    <canvas id="wheelCanvas" width="700" height="700">
                                    </canvas>

                                    <div class="wheel-pointer"></div>

                                    <div class="wheel-center">
                                        <i class="ti ti-dice-5"></i>
                                    </div>

                                </div>

                                <div class="spin-button-wrap">

                                    <button type="button" id="spinButton" class="spin-button" disabled>
                                        <i class="ti ti-player-play-filled"></i>

                                                            Mulai Spin
                                                        
                                    </button>

                                    <div class="spin-helper" id="spinHelper">
                                                        Pilih kelompok dan tugas terlebih dahulu.
                                                    </div>

                                </div>

                                <div id="assignmentProgress" class="assignment-progress">

                                    <div class="progress-label">
                                        <span>Pembagian tugas</span>
                                        <span id="progressText">0 / 0</span>
                                    </div>

                                    <div class="progress-track">
                                        <div id="progressFill" class="progress-fill"></div>
                                    </div>

                                </div>

                            </div>

                            <!-- SIDE -->
                            <div class="spin-side-card">

                                <div class="side-section">

                                    <div class="side-title">
                                        <strong>Anggota tersisa</strong>
                                        <span id="memberCount" class="side-count">0</span>
                                    </div>

                                    <div id="memberList" class="member-list">
                                        <div class="spin-empty">
                                            <i class="ti ti-users"></i>

                                                                    Pilih kelompok terlebih dahulu.
                                                                
                                        </div>
                                    </div>

                                </div>

                                <div class="side-section">

                                    <div class="side-title">
                                        <strong>Bagian tugas</strong>
                                        <span id="optionCount" class="side-count">0</span>
                                    </div>

                                    <div id="optionList" class="option-list"></div>

                                    <button type="button" id="addOption" class="add-option">
                                        <i class="ti ti-plus"></i>

                                                            Tambah bagian tugas
                                                        
                                    </button>

                                    <div id="optionWarning" class="option-warning">
                                                        Jumlah bagian tugas harus sama dengan jumlah anggota.
                                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- =========================
                                 CONCLUSION
                                 ========================= -->
                        <div id="conclusionSection" class="conclusion-section">

                            <div class="conclusion-card">

                                <div class="conclusion-success">

                                    <div class="conclusion-check">
                                        <i class="ti ti-check"></i>
                                    </div>

                                    <h2>Pembagian Tugas Selesai!</h2>

                                    <p>
                                                        Semua anggota sudah mendapatkan bagian tugas.
                                                    </p>

                                </div>

                                <div id="receiptPreview" class="receipt-preview">

                                    <div class="receipt-brand">
                                                        COLLABIFY
                                                    </div>

                                    <div class="receipt-title">
                                                        Hasil Pembagian Tugas
                                                    </div>

                                    <div id="receiptTask" class="receipt-task"></div>

                                    <div class="receipt-divider"></div>

                                    <div id="receiptRows"></div>

                                    <div class="receipt-divider"></div>

                                    <div class="receipt-footer">
                                        <span id="receiptDate"></span>
                                        <span>Dibuat melalui COLLABIFY</span>
                                    </div>

                                </div>

                                <div class="conclusion-actions">

                                    <button type="button" id="shareResult" class="action-button action-primary">
                                        <i class="ti ti-share-3"></i>

                                                            Bagikan sebagai gambar
                                                        
                                    </button>

                                    <button type="button" id="copyResult" class="action-button action-secondary">
                                        <i class="ti ti-copy"></i>

                                                            Salin
                                                        
                                    </button>

                                    <button type="button" id="saveNote" class="action-button action-secondary action-full">
                                        <i class="ti ti-notes"></i>

                                                            Simpan ke Catatan
                                                        
                                    </button>

                                    <button type="button" id="restartSpin" class="action-button action-secondary action-full">
                                        <i class="ti ti-refresh"></i>

                                                            Spin Ulang
                                                        
                                    </button>

                                </div>

                                <div id="noteStatus" class="note-status"></div>

                            </div>

                        </div>

                        <!-- =========================
                                 HISTORY
                                 ========================= -->
                        <div class="history-card">

                            <div class="history-header">

                                <div>
                                    <h2>Riwayat Spin</h2>
                                    <p>
                                                        Riwayat pembagian ditampilkan berdasarkan sesi.
                                                    </p>
                                </div>

                            </div>

                            <div id="historyContainer">
                                <div class="history-empty">
                                                Pilih kelompok untuk melihat riwayat pembagian.
                                            </div>
                            </div>

                        </div>

                    </div>

                    <!-- =========================
                         RESULT MODAL
                         ========================= -->

                    <div id="resultOverlay" class="result-overlay">

                        <div class="result-modal">

                            <div class="result-glow"></div>

                            <div class="result-icon">
                                <i class="ti ti-trophy"></i>
                            </div>

                            <div class="result-small">
                                        HASIL SPIN
                                    </div>

                            <div id="resultName" class="result-name"></div>

                            <div class="result-sub">
                                        mendapat bagian tugas
                                    </div>

                            <div id="resultTask" class="result-task"></div>

                            <button type="button" id="continueSpin" class="result-button">
                                        Lanjut Spin
                                    </button>

                        </div>

                    </div>

                    
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
const SPIN_URL = {
    save: "<?= base_url('spin/step') ?>",
    saveNote: "<?= base_url('spin/save-note') ?>",
    history: "<?= base_url('spin/history') ?>"
};
// Token CSRF selalu diambil dari cookie terbaru (tidak di-hardcode).
function csrfToken() {
    const m = document.cookie.match(/(?:^|; )csrf_cookie_name=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : "<?= csrf_hash() ?>";
}
</script>
<script>

                    document.addEventListener('DOMContentLoaded', function () {

                        /* =====================================================
                           DATA DARI PHP
                           ===================================================== */

                        const tasksData = <?= json_encode((object) $tasks, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
                        const membersData = <?= json_encode((object) $members, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;


                        /* =====================================================
                           ELEMENT
                           ===================================================== */

                        const groupSelect = document.getElementById('groupSelect');
                        const taskSelect = document.getElementById('taskSelect');

                        const taskInfo = document.getElementById('taskInfo');
                        const taskInfoTitle = document.getElementById('taskInfoTitle');
                        const taskInfoDescription = document.getElementById('taskInfoDescription');

                        const memberList = document.getElementById('memberList');
                        const memberCount = document.getElementById('memberCount');

                        const optionList = document.getElementById('optionList');
                        const optionCount = document.getElementById('optionCount');
                        const addOption = document.getElementById('addOption');
                        const optionWarning = document.getElementById('optionWarning');

                        const wheelCanvas = document.getElementById('wheelCanvas');
                        const wheelCtx = wheelCanvas.getContext('2d');

                        const spinButton = document.getElementById('spinButton');
                        const spinHelper = document.getElementById('spinHelper');
                        const wheelStatus = document.getElementById('wheelStatus');

                        const assignmentProgress = document.getElementById('assignmentProgress');
                        const progressText = document.getElementById('progressText');
                        const progressFill = document.getElementById('progressFill');

                        const resultOverlay = document.getElementById('resultOverlay');
                        const resultName = document.getElementById('resultName');
                        const resultTask = document.getElementById('resultTask');
                        const continueSpin = document.getElementById('continueSpin');

                        const conclusionSection = document.getElementById('conclusionSection');
                        const receiptTask = document.getElementById('receiptTask');
                        const receiptRows = document.getElementById('receiptRows');
                        const receiptDate = document.getElementById('receiptDate');

                        const shareResult = document.getElementById('shareResult');
                        const copyResult = document.getElementById('copyResult');
                        const saveNote = document.getElementById('saveNote');
                        const restartSpin = document.getElementById('restartSpin');
                        const noteStatus = document.getElementById('noteStatus');

                        const historyContainer = document.getElementById('historyContainer');


                        /* =====================================================
                           STATE
                           ===================================================== */

                        let selectedGroupId = null;
                        let selectedTaskId = null;

                        let remainingMembers = [];
                        let remainingOptions = [];

                        let assignments = [];

                        let sessionId = '';
                        let serverError = '';
                        let spinMeta = null;
                        let spinning = false;

                        let wheelRotation = 0;

                        let originalMemberCount = 0;

                        let currentWinner = null;


                        /* =====================================================
                           COLORS
                           ===================================================== */

                        const wheelColors = [
                            '#6F9FCB',
                            '#F2A7B5',
                            '#A8C7E8',
                            '#F7D6D0',
                            '#C9B8F5',
                            '#8FD8C8',
                            '#F5D96B',
                            '#E98298'
                        ];


                        /* =====================================================
                           UTILITY
                           ===================================================== */

                        function escapeHtml(value) {

                            return String(value ?? '')
                                .replace(/&/g, '&amp;')
                                .replace(/</g, '&lt;')
                                .replace(/>/g, '&gt;')
                                .replace(/"/g, '&quot;')
                                .replace(/'/g, '&#039;');

                        }


                        function makeSessionId() {

                            return (
                                Date.now().toString(36) +
                                Math.random().toString(36).substring(2, 10)
                            ).toUpperCase();

                        }


                        function getSelectedTask() {

                            if (!selectedGroupId || !selectedTaskId) {
                                return null;
                            }

                            const groupTasks = tasksData[selectedGroupId] || [];

                            return groupTasks.find(function (task) {
                                return Number(task.id_task) === Number(selectedTaskId);
                            }) || null;

                        }


                        function getOptionsFromInputs() {

                            return Array.from(
                                optionList.querySelectorAll('.option-input')
                            )
                            .map(function (input) {
                                return input.value.trim();
                            })
                            .filter(Boolean);

                        }


                        function resetSession() {

                            assignments = [];
                            currentWinner = null;
                            spinMeta = null;

                            sessionId = makeSessionId();

                            remainingMembers = JSON.parse(
                                JSON.stringify(
                                    membersData[selectedGroupId] || []
                                )
                            );

                            originalMemberCount = remainingMembers.length;

                            remainingOptions = getOptionsFromInputs();

                            conclusionSection.classList.remove('show');

                            updateMemberList();
                            updateCounts();
                            updateProgress();

                            drawWheel();

                            updateSpinAvailability();

                        }


                        /* =====================================================
                           GROUP CHANGE
                           ===================================================== */

                        groupSelect.addEventListener('change', function () {

                            selectedGroupId = this.value || null;

                            selectedTaskId = null;

                            taskSelect.innerHTML =
                                '<option value="">-- Pilih tugas --</option>';

                            taskSelect.disabled = !selectedGroupId;

                            taskInfo.classList.remove('active');

                            if (!selectedGroupId) {

                                remainingMembers = [];
                                remainingOptions = [];
                                assignments = [];

                                updateMemberList();
                                updateCounts();
                                drawWheel();
                                updateSpinAvailability();

                                historyContainer.innerHTML = `
                                    <div class="history-empty">
                                        Pilih kelompok untuk melihat riwayat pembagian.
                                    </div>
                                `;

                                return;
                            }


                            /* =========================
                               TASKS
                               ========================= */

                            const groupTasks =
                                tasksData[selectedGroupId] || [];

                            groupTasks.forEach(function (task) {

                                const option =
                                    document.createElement('option');

                                option.value = task.id_task;
                                option.textContent = task.judul;

                                taskSelect.appendChild(option);

                            });


                            /* =========================
                               MEMBERS
                               ========================= */

                            remainingMembers = JSON.parse(
                                JSON.stringify(
                                    membersData[selectedGroupId] || []
                                )
                            );

                            originalMemberCount = remainingMembers.length;

                            assignments = [];

                            updateMemberList();

                            updateCounts();

                            drawWheel();

                            updateSpinAvailability();

                            loadHistory();

                        });


                        /* =====================================================
                           TASK CHANGE
                           ===================================================== */

                        taskSelect.addEventListener('change', function () {

                            selectedTaskId = this.value || null;

                            const task = getSelectedTask();

                            if (!task) {

                                taskInfo.classList.remove('active');

                                spinHelper.textContent =
                                    'Pilih tugas terlebih dahulu.';

                                updateSpinAvailability();

                                return;

                            }


                            taskInfo.classList.add('active');

                            taskInfoTitle.textContent =
                                task.judul || 'Tugas';

                            taskInfoDescription.textContent =
                                task.deskripsi ||
                                'Tidak ada deskripsi tugas.';


                            /*
                             * Kalau belum ada pilihan tugas,
                             * buat beberapa input awal sesuai jumlah anggota.
                             */
                            if (
                                optionList.querySelectorAll('.option-input').length === 0
                                &&
                                remainingMembers.length > 0
                            ) {

                                for (
                                    let i = 0;
                                    i < remainingMembers.length;
                                    i++
                                ) {
                                    createOptionInput('');
                                }

                            }


                            resetSession();

                            spinHelper.textContent =
                                'Isi bagian tugas, lalu mulai spin.';

                        });


                        /* =====================================================
                           OPTION INPUT
                           ===================================================== */

                        function createOptionInput(value = '') {

                            const wrapper =
                                document.createElement('div');

                            wrapper.className =
                                'option-input-row';

                            wrapper.innerHTML = `
                                <input
                                    type="text"
                                    class="option-input"
                                    placeholder="Contoh: Cari jurnal"
                                    value="${escapeHtml(value)}"
                                >

                                <button
                                    type="button"
                                    class="option-remove"
                                    title="Hapus"
                                >
                                    <i class="ti ti-x"></i>
                                </button>
                            `;

                            const input =
                                wrapper.querySelector('.option-input');

                            const remove =
                                wrapper.querySelector('.option-remove');


                            input.addEventListener('input', function () {

                                if (!spinning) {

                                    remainingOptions =
                                        getOptionsFromInputs();

                                    drawWheel();

                                    updateCounts();

                                    updateSpinAvailability();

                                }

                            });


                            remove.addEventListener('click', function () {

                                if (spinning) {
                                    return;
                                }

                                wrapper.remove();

                                remainingOptions =
                                    getOptionsFromInputs();

                                drawWheel();

                                updateCounts();

                                updateSpinAvailability();

                            });


                            optionList.appendChild(wrapper);

                        }


                        addOption.addEventListener('click', function () {

                            if (spinning) {
                                return;
                            }

                            createOptionInput('');

                            remainingOptions =
                                getOptionsFromInputs();

                            drawWheel();

                            updateCounts();

                            updateSpinAvailability();

                        });


                        /* =====================================================
                           MEMBER LIST
                           ===================================================== */

                        function updateMemberList() {

                            memberList.innerHTML = '';

                            if (!selectedGroupId) {

                                memberList.innerHTML = `
                                    <div class="spin-empty">
                                        <i class="ti ti-users"></i>
                                        Pilih kelompok terlebih dahulu.
                                    </div>
                                `;

                                return;

                            }


                            if (remainingMembers.length === 0) {

                                memberList.innerHTML = `
                                    <div class="spin-empty">
                                        <i class="ti ti-check"></i>
                                        Semua anggota sudah mendapat bagian.
                                    </div>
                                `;

                                return;

                            }


                            remainingMembers.forEach(function (member) {

                                const name =
                                    member.name || 'Anggota';

                                const initial =
                                    name.charAt(0).toUpperCase();

                                const item =
                                    document.createElement('div');

                                item.className = 'member-item';

                                item.innerHTML = `
                                    <div class="member-avatar">
                                        ${escapeHtml(initial)}
                                    </div>

                                    <div class="member-name">
                                        ${escapeHtml(name)}
                                    </div>
                                `;

                                memberList.appendChild(item);

                            });

                        }


                        /* =====================================================
                           COUNTS
                           ===================================================== */

                        function updateCounts() {

                            memberCount.textContent =
                                remainingMembers.length;

                            optionCount.textContent =
                                getOptionsFromInputs().length;

                            const members =
                                remainingMembers.length;

                            const options =
                                getOptionsFromInputs().length;

                            if (
                                members > 0 &&
                                options > 0 &&
                                members !== options
                            ) {

                                optionWarning.classList.add('show');

                                optionWarning.textContent =
                                    `Masih ada ${members} anggota tetapi ${options} bagian tugas. Jumlah harus sama.`;

                            } else {

                                optionWarning.classList.remove('show');

                            }

                        }


                        /* =====================================================
                           PROGRESS
                           ===================================================== */

                        function updateProgress() {

                            const total =
                                originalMemberCount;

                            const done =
                                assignments.length;

                            if (!total) {

                                assignmentProgress.classList.remove('show');

                                return;

                            }

                            assignmentProgress.classList.add('show');

                            progressText.textContent =
                                `${done} / ${total}`;

                            progressFill.style.width =
                                `${Math.min(100, (done / total) * 100)}%`;

                        }


                        /* =====================================================
                           WHEEL DRAW
                           ===================================================== */

                        function drawWheel() {

                            const size = wheelCanvas.width;

                            const center = size / 2;

                            const radius = center - 18;

                            wheelCtx.clearRect(
                                0,
                                0,
                                size,
                                size
                            );


                            const options =
                                getOptionsFromInputs();


                            if (!options.length) {

                                wheelCtx.beginPath();

                                wheelCtx.arc(
                                    center,
                                    center,
                                    radius,
                                    0,
                                    Math.PI * 2
                                );

                                wheelCtx.fillStyle =
                                    '#efedf5';

                                wheelCtx.fill();

                                wheelCtx.fillStyle =
                                    '#aaa6b5';

                                wheelCtx.font =
                                    '700 22px Arial';

                                wheelCtx.textAlign =
                                    'center';

                                wheelCtx.textBaseline =
                                    'middle';

                                wheelCtx.fillText(
                                    'Tambahkan bagian tugas',
                                    center,
                                    center
                                );

                                return;

                            }


                            const slice =
                                (Math.PI * 2) / options.length;


                            options.forEach(function (label, index) {

                                const start =
                                    -Math.PI / 2 +
                                    index * slice;

                                const end =
                                    start + slice;


                                wheelCtx.beginPath();

                                wheelCtx.moveTo(
                                    center,
                                    center
                                );

                                wheelCtx.arc(
                                    center,
                                    center,
                                    radius,
                                    start,
                                    end
                                );

                                wheelCtx.closePath();

                                wheelCtx.fillStyle =
                                    wheelColors[index % wheelColors.length];

                                wheelCtx.fill();


                                wheelCtx.strokeStyle =
                                    'rgba(255,255,255,.8)';

                                wheelCtx.lineWidth = 5;

                                wheelCtx.stroke();


                                /* =========================
                                   LABEL
                                   ========================= */

                                wheelCtx.save();

                                wheelCtx.translate(
                                    center,
                                    center
                                );

                                const angle =
                                    start + slice / 2;

                                wheelCtx.rotate(angle);

                                wheelCtx.textAlign =
                                    'right';

                                wheelCtx.textBaseline =
                                    'middle';

                                wheelCtx.fillStyle =
                                    '#fff';

                                wheelCtx.font =
                                    '800 20px Arial';


                                let text =
                                    String(label);

                                if (text.length > 22) {
                                    text =
                                        text.substring(0, 21) + '…';
                                }


                                wheelCtx.fillText(
                                    text,
                                    radius - 26,
                                    0
                                );

                                wheelCtx.restore();

                            });


                            /* =========================
                               OUTER RING
                               ========================= */

                            wheelCtx.beginPath();

                            wheelCtx.arc(
                                center,
                                center,
                                radius,
                                0,
                                Math.PI * 2
                            );

                            wheelCtx.strokeStyle =
                                '#fff';

                            wheelCtx.lineWidth = 10;

                            wheelCtx.stroke();

                        }


                        /* =====================================================
                           SPIN AVAILABILITY
                           ===================================================== */

                        function updateSpinAvailability() {

                            if (!selectedGroupId) {

                                spinButton.disabled = true;

                                spinHelper.textContent =
                                    'Pilih kelompok terlebih dahulu.';

                                return;

                            }


                            if (!selectedTaskId) {

                                spinButton.disabled = true;

                                spinHelper.textContent =
                                    'Pilih tugas terlebih dahulu.';

                                return;

                            }


                            const options =
                                getOptionsFromInputs();

                            const members =
                                remainingMembers.length;


                            if (!members) {

                                spinButton.disabled = true;

                                spinHelper.textContent =
                                    'Semua anggota sudah mendapat bagian.';

                                return;

                            }


                            if (options.length !== members) {

                                spinButton.disabled = true;

                                spinHelper.textContent =
                                    'Jumlah bagian tugas harus sama dengan jumlah anggota.';

                                return;

                            }


                            if (options.some(function (item) {
                                return !item;
                            })) {

                                spinButton.disabled = true;

                                return;

                            }


                            spinButton.disabled =
                                spinning;


                            spinHelper.textContent =
                                spinning
                                    ? 'Roda sedang berputar...'
                                    : 'Semua siap. Klik Mulai Spin.';

                        }


                        /* =====================================================
                           SPIN
                           ===================================================== */

                        spinButton.addEventListener('click', startSpin);


                        async function startSpin() {

                            if (spinning) {
                                return;
                            }


                            const options =
                                getOptionsFromInputs();


                            if (
                                !selectedGroupId ||
                                !selectedTaskId ||
                                remainingMembers.length === 0 ||
                                options.length !== remainingMembers.length
                            ) {

                                updateSpinAvailability();

                                return;

                            }


                            spinning = true;

                            spinButton.disabled = true;

                            wheelStatus.innerHTML = `
                                <i class="ti ti-loader-2"></i>
                                Memutar...
                            `;

                            spinHelper.textContent =
                                'Roda sedang mencari hasil secara acak...';


                            /*
                             * Anggota & bagian dipilih SERVER (CSPRNG) lalu langsung
                             * tersimpan sebagai riwayat. Roda hanya menganimasikan
                             * hasil yang sudah ditentukan, jadi tidak bisa direkayasa
                             * dari browser.
                             */
                            const picked = await requestServerStep(options);

                            if (!picked) {

                                spinning = false;

                                wheelStatus.innerHTML = `
                                    <i class="ti ti-alert-triangle"></i>
                                    Gagal memutar
                                `;

                                spinHelper.textContent =
                                    serverError ||
                                    'Spin gagal disimpan. Coba lagi.';

                                updateSpinAvailability();

                                return;

                            }

                            const memberIndex =
                                Math.max(0, remainingMembers.findIndex(function (member) {
                                    return Number(member.id_user) === Number(picked.member_id);
                                }));

                            const selectedMember =
                                remainingMembers[memberIndex];

                            const optionIndex =
                                Math.max(0, options.indexOf(picked.option));

                            const selectedOption =
                                options[optionIndex];

                            if (picked.finished) {
                                spinMeta = {
                                    kode: picked.kode,
                                    nomor: picked.nomor_spin,
                                    ulang: !!picked.is_ulang
                                };
                            }


                            /*
                             * Rotasi wheel.
                             *
                             * Kita tambah 5–8 putaran supaya terasa
                             * seperti wheel sungguhan.
                             */
                            const fullTurns =
                                5 +
                                Math.floor(
                                    Math.random() * 4
                                );

                            const slice =
                                360 / options.length;


                            /*
                             * Target posisi agar tengah slice
                             * berhenti tepat di pointer atas.
                             */
                            const targetWithin =
                                360 -
                                (
                                    optionIndex * slice +
                                    slice / 2
                                );


                            const currentNormalized =
                                ((wheelRotation % 360) + 360) % 360;


                            let delta =
                                (
                                    fullTurns * 360
                                ) +
                                (
                                    targetWithin -
                                    currentNormalized
                                );


                            if (delta < fullTurns * 360) {
                                delta += 360;
                            }


                            wheelRotation += delta;


                            /*
                             * Custom cubic-bezier:
                             * cepat di awal → melambat natural.
                             */
                            wheelCanvas.style.transition =
                                'transform 5.8s cubic-bezier(.12,.78,.16,1)';

                            wheelCanvas.style.transform =
                                `rotate(${wheelRotation}deg)`;


                            setTimeout(async function () {

                                spinning = false;

                                currentWinner = {
                                    memberIndex: memberIndex,
                                    member: selectedMember,
                                    option: selectedOption
                                };


                                /*
                                 * Highlight sebentar sebelum popup.
                                 */
                                wheelStatus.innerHTML = `
                                    <i class="ti ti-sparkles"></i>
                                    Hasil ditemukan!
                                `;


                                showWinnerModal(
                                    selectedMember.name,
                                    selectedOption
                                );


                            }, 5900);

                        }


                        /* =====================================================
                           SPIN — SERVER MEMILIH HASIL
                           ===================================================== */

                        async function requestServerStep(options) {

                            serverError = '';

                            try {

                                const response = await fetch(SPIN_URL.save, {
                                    method: 'POST',

                                    headers: {
                                        'Content-Type':
                                            'application/x-www-form-urlencoded; charset=UTF-8',
                                        'X-Requested-With':
                                            'XMLHttpRequest'
                                    },

                                    body: new URLSearchParams({
                                        'csrf_test_name': csrfToken(),
                                        id_group: selectedGroupId,
                                        id_task: selectedTaskId,
                                        session_id: sessionId,
                                        options: JSON.stringify(options)
                                    })
                                });

                                const data = await response.json();

                                if (!response.ok || !data.success) {

                                    serverError = data.message || '';

                                    console.error('Gagal spin:', data);

                                    return null;

                                }

                                return data;

                            } catch (error) {

                                console.error('Spin error:', error);

                                return null;

                            }

                        }


                        /* =====================================================
                           RESULT MODAL
                           ===================================================== */

                        function showWinnerModal(
                            memberName,
                            taskName
                        ) {

                            resultName.textContent =
                                memberName;

                            resultTask.textContent =
                                taskName;


                            resultOverlay.classList.add('show');


                            createConfetti();


                            /*
                             * Hapus kandidat hanya setelah
                             * popup muncul dan user melihat hasil.
                             */

                        }


                        function createConfetti() {

                            const pieces = 26;

                            for (
                                let i = 0;
                                i < pieces;
                                i++
                            ) {

                                const confetti =
                                    document.createElement('div');

                                confetti.className =
                                    'confetti';

                                const colors = [
                                    '#5E91C4',
                                    '#8f7fff',
                                    '#5cc8bd',
                                    '#f2c75c',
                                    '#ee8eaa'
                                ];

                                confetti.style.background =
                                    colors[
                                        Math.floor(
                                            Math.random() *
                                            colors.length
                                        )
                                    ];

                                confetti.style.left =
                                    `${45 + Math.random() * 10}%`;

                                confetti.style.top =
                                    '42%';

                                confetti.style.setProperty(
                                    '--x',
                                    `${(Math.random() - .5) * 500}px`
                                );

                                confetti.style.setProperty(
                                    '--y',
                                    `${100 + Math.random() * 300}px`
                                );

                                confetti.style.animationDelay =
                                    `${Math.random() * .15}s`;

                                document.body.appendChild(
                                    confetti
                                );


                                setTimeout(function () {
                                    confetti.remove();
                                }, 1500);

                            }

                        }


                        /* =====================================================
                           CONTINUE SPIN
                           ===================================================== */

                        continueSpin.addEventListener(
                            'click',
                            continueAfterWinner
                        );


                        async function continueAfterWinner() {

                            if (!currentWinner) {
                                return;
                            }


                            resultOverlay.classList.remove('show');


                            const memberName =
                                currentWinner.member.name;

                            const option =
                                currentWinner.option;


                            /*
                             * Tambahkan assignment lokal.
                             */
                            assignments.push({

                                anggota:
                                    memberName,

                                hasil:
                                    option

                            });


                            /*
                             * Hapus anggota yang baru dapat tugas.
                             */
                            remainingMembers =
                                remainingMembers.filter(
                                    function (member) {

                                        return Number(member.id_user)
                                            !== Number(
                                                currentWinner.member.id_user
                                            );

                                    }
                                );


                            /*
                             * Hapus option dari input.
                             */
                            removeOptionFromInputs(
                                option
                            );


                            remainingOptions =
                                getOptionsFromInputs();


                            currentWinner = null;


                            updateMemberList();

                            updateCounts();

                            updateProgress();

                            drawWheel();


                            if (
                                remainingMembers.length === 0
                            ) {

                                finishSpin();

                                return;

                            }


                            wheelStatus.innerHTML = `
                                <i class="ti ti-player-play"></i>
                                Siap untuk spin berikutnya
                            `;


                            spinHelper.textContent =
                                `${remainingMembers.length} anggota masih menunggu bagian.`;


                            updateSpinAvailability();


                            /*
                             * Scroll sedikit ke wheel.
                             */
                            document.querySelector(
                                '.spin-wheel-card'
                            )?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                        }


                        /* =====================================================
                           REMOVE OPTION
                           ===================================================== */

                        function removeOptionFromInputs(
                            selectedValue
                        ) {

                            const rows =
                                Array.from(
                                    optionList.querySelectorAll(
                                        '.option-input-row'
                                    )
                                );


                            rows.forEach(function (row) {

                                const input =
                                    row.querySelector(
                                        '.option-input'
                                    );


                                if (
                                    input &&
                                    input.value.trim() ===
                                    selectedValue
                                ) {

                                    row.remove();

                                }

                            });

                        }


                        /* =====================================================
                           FINISH
                           ===================================================== */

                        function finishSpin() {

                            spinning = false;

                            wheelStatus.innerHTML = `
                                <i class="ti ti-circle-check"></i>
                                Semua anggota sudah mendapat bagian
                            `;

                            spinHelper.textContent =
                                'Pembagian selesai!';


                            spinButton.disabled = true;


                            buildConclusion();


                            /*
                             * Refresh history setelah semua selesai.
                             */
                            loadHistory();


                            setTimeout(function () {

                                conclusionSection
                                    .scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'start'
                                    });

                            }, 250);

                        }


                        /* =====================================================
                           CONCLUSION
                           ===================================================== */

                        function buildConclusion() {

                            const task =
                                getSelectedTask();


                            receiptTask.textContent =
                                task
                                    ? task.judul
                                    : 'Pembagian tugas';


                            receiptRows.innerHTML = '';


                            assignments.forEach(function (item) {

                                const row =
                                    document.createElement('div');

                                row.className =
                                    'receipt-row';

                                row.innerHTML = `
                                    <div class="receipt-member">
                                        ${escapeHtml(item.anggota)}
                                    </div>

                                    <div class="receipt-result">
                                        ${escapeHtml(item.hasil)}
                                    </div>
                                `;

                                receiptRows.appendChild(row);

                            });


                            receiptDate.textContent =
                                formatDate(
                                    new Date()
                                ) + (spinMeta
                                    ? ' · Kode ' + spinMeta.kode + (spinMeta.ulang ? ' · SPIN ULANG' : '')
                                    : '');


                            conclusionSection.classList.add(
                                'show'
                            );

                        }


                        function formatDate(date) {

                            return date.toLocaleDateString(
                                'id-ID',
                                {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                }
                            );

                        }


                        /* =====================================================
                           COPY RESULT
                           ===================================================== */

                        copyResult.addEventListener(
                            'click',
                            async function () {

                                const text =
                                    makeConclusionText();


                                try {

                                    await navigator.clipboard.writeText(
                                        text
                                    );

                                    copyResult.innerHTML =
                                        '<i class="ti ti-check"></i> Tersalin!';


                                    setTimeout(function () {

                                        copyResult.innerHTML =
                                            '<i class="ti ti-copy"></i> Salin';

                                    }, 1600);


                                } catch (error) {

                                    alert(
                                        'Browser tidak mengizinkan penyalinan otomatis.'
                                    );

                                }

                            }
                        );


                        function makeConclusionText() {

                            const task =
                                getSelectedTask();


                            let text =
                                `HASIL PEMBAGIAN TUGAS\n\n`;


                            text +=
                                `${task ? task.judul : 'Pembagian Tugas'}\n`;

                            text +=
                                `${formatDate(new Date())}\n\n`;


                            assignments.forEach(function (item) {

                                text +=
                                    `${item.anggota} — ${item.hasil}\n`;

                            });


                            text +=
                                (spinMeta ? `\nKode verifikasi: ${spinMeta.kode}` + (spinMeta.ulang ? ' (SPIN ULANG)' : '') : '') + `\nDibuat melalui COLLABIFY`;


                            return text;

                        }


                        /* =====================================================
                           RECEIPT IMAGE
                           ===================================================== */

                        async function generateReceiptImage() {

                            const width = 1080;
                            const height = 1350;

                            const canvas =
                                document.createElement('canvas');

                            canvas.width = width;
                            canvas.height = height;

                            const ctx =
                                canvas.getContext('2d');


                            /*
                             * Background.
                             */
                            const background =
                                ctx.createLinearGradient(
                                    0,
                                    0,
                                    width,
                                    height
                                );

                            background.addColorStop(
                                0,
                                '#f8f7ff'
                            );

                            background.addColorStop(
                                1,
                                '#eef8f7'
                            );

                            ctx.fillStyle =
                                background;

                            ctx.fillRect(
                                0,
                                0,
                                width,
                                height
                            );


                            /*
                             * Decorative blobs.
                             */
                            ctx.globalAlpha = .18;

                            ctx.fillStyle = '#7766ff';

                            ctx.beginPath();

                            ctx.arc(
                                90,
                                90,
                                210,
                                0,
                                Math.PI * 2
                            );

                            ctx.fill();


                            ctx.fillStyle = '#55bcb0';

                            ctx.beginPath();

                            ctx.arc(
                                1000,
                                1200,
                                260,
                                0,
                                Math.PI * 2
                            );

                            ctx.fill();

                            ctx.globalAlpha = 1;


                            /*
                             * Receipt card.
                             */
                            const cardX = 70;
                            const cardY = 70;
                            const cardW = 940;
                            const cardH = 1210;


                            roundedRect(
                                ctx,
                                cardX,
                                cardY,
                                cardW,
                                cardH,
                                38
                            );

                            ctx.fillStyle =
                                '#ffffff';

                            ctx.fill();


                            /*
                             * Brand.
                             */
                            ctx.fillStyle =
                                '#5E91C4';

                            ctx.font =
                                '900 28px Arial';

                            ctx.fillText(
                                'COLLABIFY',
                                cardX + 70,
                                cardY + 82
                            );


                            ctx.fillStyle =
                                '#242336';

                            ctx.font =
                                '900 46px Arial';

                            ctx.fillText(
                                'Hasil Pembagian Tugas',
                                cardX + 70,
                                cardY + 145
                            );


                            const task =
                                getSelectedTask();


                            ctx.fillStyle =
                                '#7f7a8d';

                            ctx.font =
                                '500 25px Arial';

                            ctx.fillText(
                                task
                                    ? task.judul
                                    : 'Pembagian Tugas',
                                cardX + 70,
                                cardY + 190
                            );


                            ctx.fillText(
                                `${formatDate(new Date())} · ${assignments.length} anggota` + (spinMeta && spinMeta.ulang ? ' · SPIN ULANG' : ''),
                                cardX + 70,
                                cardY + 230
                            );


                            /*
                             * Divider.
                             */
                            ctx.strokeStyle =
                                '#e8e5ee';

                            ctx.lineWidth = 2;

                            ctx.beginPath();

                            ctx.moveTo(
                                cardX + 70,
                                cardY + 275
                            );

                            ctx.lineTo(
                                cardX + cardW - 70,
                                cardY + 275
                            );

                            ctx.stroke();


                            /*
                             * Table headings.
                             */
                            ctx.fillStyle =
                                '#9a95a5';

                            ctx.font =
                                '700 20px Arial';

                            ctx.fillText(
                                'ANGGOTA',
                                cardX + 70,
                                cardY + 325
                            );

                            ctx.fillText(
                                'BAGIAN TUGAS',
                                cardX + 500,
                                cardY + 325
                            );


                            let y =
                                cardY + 380;


                            assignments.forEach(function (item) {

                                ctx.strokeStyle =
                                    '#eeeaf2';

                                ctx.lineWidth = 1;

                                ctx.beginPath();

                                ctx.moveTo(
                                    cardX + 70,
                                    y + 35
                                );

                                ctx.lineTo(
                                    cardX + cardW - 70,
                                    y + 35
                                );

                                ctx.stroke();


                                ctx.fillStyle =
                                    '#373342';

                                ctx.font =
                                    '800 24px Arial';

                                ctx.fillText(
                                    truncateText(
                                        item.anggota,
                                        28
                                    ),
                                    cardX + 70,
                                    y
                                );


                                ctx.fillStyle =
                                    '#6e6979';

                                ctx.font =
                                    '500 23px Arial';

                                ctx.fillText(
                                    truncateText(
                                        item.hasil,
                                        31
                                    ),
                                    cardX + 500,
                                    y
                                );


                                y += 85;

                            });


                            /*
                             * Footer.
                             */
                            ctx.fillStyle =
                                '#9a95a5';

                            ctx.font =
                                '500 19px Arial';

                            ctx.fillText(
                                'Dibuat melalui COLLABIFY' + (spinMeta ? ' · Kode ' + spinMeta.kode : ''),
                                cardX + 70,
                                cardY + cardH - 75
                            );


                            ctx.fillStyle =
                                '#5E91C4';

                            ctx.font =
                                '800 19px Arial';

                            ctx.fillText(
                                (spinMeta && spinMeta.nomor ? 'SPIN #' + spinMeta.nomor : 'SPIN'),
                                cardX + cardW - (spinMeta && spinMeta.nomor ? 175 : 135),
                                cardY + cardH - 75
                            );


                            return new Promise(function (resolve) {

                                canvas.toBlob(
                                    function (blob) {
                                        resolve(blob);
                                    },
                                    'image/png'
                                );

                            });

                        }


                        function roundedRect(
                            ctx,
                            x,
                            y,
                            width,
                            height,
                            radius
                        ) {

                            ctx.beginPath();

                            ctx.moveTo(
                                x + radius,
                                y
                            );

                            ctx.lineTo(
                                x + width - radius,
                                y
                            );

                            ctx.quadraticCurveTo(
                                x + width,
                                y,
                                x + width,
                                y + radius
                            );

                            ctx.lineTo(
                                x + width,
                                y + height - radius
                            );

                            ctx.quadraticCurveTo(
                                x + width,
                                y + height,
                                x + width - radius,
                                y + height
                            );

                            ctx.lineTo(
                                x + radius,
                                y + height
                            );

                            ctx.quadraticCurveTo(
                                x,
                                y + height,
                                x,
                                y + height - radius
                            );

                            ctx.lineTo(
                                x,
                                y + radius
                            );

                            ctx.quadraticCurveTo(
                                x,
                                y,
                                x + radius,
                                y
                            );

                            ctx.closePath();

                        }


                        function truncateText(
                            text,
                            max
                        ) {

                            text =
                                String(text || '');

                            if (text.length <= max) {
                                return text;
                            }

                            return (
                                text.substring(
                                    0,
                                    max - 1
                                ) + '…'
                            );

                        }


                        /* =====================================================
                           SHARE AS IMAGE
                           ===================================================== */

                        shareResult.addEventListener(
                            'click',
                            async function () {

                                shareResult.disabled = true;

                                shareResult.innerHTML =
                                    '<i class="ti ti-loader-2"></i> Menyiapkan gambar...';


                                try {

                                    const blob =
                                        await generateReceiptImage();


                                    const file =
                                        new File(
                                            [
                                                blob
                                            ],
                                            'hasil-pembagian-tugas.png',
                                            {
                                                type: 'image/png'
                                            }
                                        );


                                    /*
                                     * Mobile / browser yang mendukung Web Share.
                                     */
                                    if (
                                        navigator.share &&
                                        navigator.canShare &&
                                        navigator.canShare({
                                            files: [file]
                                        })
                                    ) {

                                        await navigator.share({

                                            title:
                                                'Hasil Pembagian Tugas',

                                            text:
                                                'Hasil pembagian tugas dari COLLABIFY.',

                                            files: [file]

                                        });


                                    } else {

                                        /*
                                         * Fallback:
                                         * langsung download PNG.
                                         */
                                        const url =
                                            URL.createObjectURL(
                                                blob
                                            );

                                        const link =
                                            document.createElement('a');

                                        link.href = url;

                                        link.download =
                                            'hasil-pembagian-tugas.png';

                                        document.body.appendChild(
                                            link
                                        );

                                        link.click();

                                        link.remove();

                                        URL.revokeObjectURL(
                                            url
                                        );

                                    }


                                } catch (error) {

                                    /*
                                     * User menutup share sheet
                                     * bukan error yang perlu ditampilkan.
                                     */
                                    console.log(
                                        'Share cancelled:',
                                        error
                                    );

                                }


                                shareResult.disabled = false;

                                shareResult.innerHTML =
                                    '<i class="ti ti-share-3"></i> Bagikan sebagai gambar';

                            }
                        );


                        /* =====================================================
                           SAVE TO NOTES
                           ===================================================== */

                        saveNote.addEventListener(
                            'click',
                            async function () {

                                if (!selectedGroupId) {
                                    return;
                                }


                                saveNote.disabled = true;

                                noteStatus.textContent =
                                    'Menyimpan hasil ke Catatan...';


                                try {

                                    const response =
                                        await fetch(
                                            SPIN_URL.saveNote,
                                            {
                                                method: 'POST',

                                                headers: {
                                                    'Content-Type':
                                                        'application/x-www-form-urlencoded; charset=UTF-8',

                                                    'X-Requested-With':
                                                        'XMLHttpRequest'
                                                },

                                               body:
                        new URLSearchParams({
                            'csrf_test_name': csrfToken(),

                            id_group:
                                selectedGroupId,

                            content:
                                makeConclusionText()
                        })
                                            }
                                        );


                                    const data =
                                        await response.json();


                                    if (
                                        !response.ok ||
                                        !data.success
                                    ) {

                                        throw new Error(
                                            data.message ||
                                            'Gagal menyimpan catatan.'
                                        );

                                    }


                                    noteStatus.textContent =
                                        '✓ Hasil pembagian berhasil disimpan ke Catatan.';


                                    saveNote.innerHTML =
                                        '<i class="ti ti-check"></i> Tersimpan di Catatan';


                                } catch (error) {

                                    console.error(
                                        'Save note error:',
                                        error
                                    );

                                    noteStatus.textContent =
                                        error.message ||
                                        'Gagal menyimpan hasil ke Catatan.';


                                    saveNote.disabled = false;

                                }

                            }
                        );


                        /* =====================================================
                           RESTART
                           ===================================================== */

                        /* =====================================================
                       RESTART
                       ===================================================== */

                    restartSpin.addEventListener(
                        'click',
                        function () {

                            remainingMembers = JSON.parse(
                                JSON.stringify(
                                    membersData[selectedGroupId] || []
                                )
                            );

                            originalMemberCount =
                                remainingMembers.length;

                            optionList.innerHTML = '';

                            const oldOptions =
                                assignments.map(function (item) {
                                    return item.hasil;
                                });

                            oldOptions.forEach(function (option) {
                                createOptionInput(option);
                            });

                            assignments = [];

                            sessionId =
                                makeSessionId();

                            remainingOptions =
                                getOptionsFromInputs();

                            conclusionSection.classList.remove('show');

                            noteStatus.textContent = '';

                            saveNote.disabled = false;

                            saveNote.innerHTML =
                                '<i class="ti ti-notes"></i> Simpan ke Catatan';

                            updateMemberList();
                            updateCounts();
                            updateProgress();
                            drawWheel();

                            wheelStatus.innerHTML =
                                '<i class="ti ti-circle-check"></i> Siap untuk spin baru';

                            updateSpinAvailability();

                            const wheelCard =
                                document.querySelector('.spin-wheel-card');

                            if (wheelCard) {
                                wheelCard.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }

                        }
                    );

                        /* =====================================================
                           HISTORY
                           ===================================================== */

                        async function loadHistory() {

                            if (!selectedGroupId) {
                                return;
                            }


                            historyContainer.innerHTML = `
                                <div class="history-empty">
                                    <i class="ti ti-loader-2"></i>
                                    Memuat riwayat...
                                </div>
                            `;


                            try {

                                const response =
                                    await fetch(
                                        `${SPIN_URL.history}/${selectedGroupId}`,
                                        {
                                            headers: {
                                                'X-Requested-With':
                                                    'XMLHttpRequest'
                                            }
                                        }
                                    );


                                const data =
                                    await response.json();


                                if (
                                    !response.ok ||
                                    !data.success
                                ) {

                                    throw new Error(
                                        data.message ||
                                        'Gagal mengambil riwayat.'
                                    );

                                }


                                renderHistory(
                                    data.history || []
                                );


                            } catch (error) {

                                console.error(
                                    'History error:',
                                    error
                                );


                                historyContainer.innerHTML = `
                                    <div class="history-empty">
                                        Riwayat belum dapat dimuat.
                                    </div>
                                `;

                            }

                        }


                    function renderHistory(history) {

                        if (!history.length) {

                            historyContainer.innerHTML = `
                                <div class="history-empty">
                                    Belum ada riwayat pembagian untuk kelompok ini.
                                </div>
                            `;

                            return;
                        }


                        const sessions = {};


                        history.forEach(function (item) {

                            const session =
                                item.session_id ||
                                'legacy-' + item.id_spin;


                            if (!sessions[session]) {

                                sessions[session] = {

                                    task:
                                        item.task_judul ||
                                        'Pembagian tugas',

                                    created_at:
                                        item.created_at,

                                    kode:
                                        item.kode || '',

                                    nomor:
                                        item.nomor_spin || '',

                                    ulang:
                                        Number(item.is_ulang) === 1,

                                    items: []

                                };

                            }


                            sessions[session].items.push(item);

                        });


                        historyContainer.innerHTML = '';


                        Object.entries(sessions).forEach(function (
                            [sessionId, session],
                            index
                        ) {

                            const card =
                                document.createElement('div');


                            card.className =
                                'history-session' +
                                (
                                    index === 0
                                        ? ' open'
                                        : ''
                                );


                            const date =
                                session.created_at
                                    ? formatDate(
                                        new Date(
                                            session.created_at
                                        )
                                    )
                                    : 'Tanggal tidak tersedia';


                            const count =
                                session.items.length;


                            card.innerHTML = `

                                <div class="history-session-head">

                                    <div>

                                        <div class="history-session-title">
                                            ${escapeHtml(session.task)}
                                        </div>

                                        <div class="history-session-meta">
                                            ${escapeHtml(date)}
                                            ·
                                            ${count} anggota
                                            ${session.nomor ? '· spin #' + escapeHtml(String(session.nomor)) : ''}
                                            ${session.kode ? '· <code>' + escapeHtml(session.kode) + '</code>' : ''}
                                            ${session.ulang ? '· <b style="color:#b45309">spin ulang</b>' : ''}
                                        </div>

                                    </div>

                                    <span class="history-complete">
                                        Selesai
                                    </span>

                                </div>


                                <div class="history-body">

                                    ${session.items.map(function (item) {

                                        return `

                                            <div class="history-row">

                                                <div class="history-person">
                                                    ${escapeHtml(
                                                        item.anggota ||
                                                        'Anggota'
                                                    )}
                                                </div>

                                                <div class="history-result">
                                                    ${escapeHtml(
                                                        item.hasil ||
                                                        '-'
                                                    )}
                                                </div>

                                            </div>

                                        `;

                                    }).join('')}

                                </div>

                            `;


                            card.querySelector(
                                '.history-session-head'
                            ).addEventListener(
                                'click',
                                function () {

                                    card.classList.toggle(
                                        'open'
                                    );

                                }
                            );


                            historyContainer.appendChild(
                                card
                            );

                        });

                    }




                        /* =====================================================
                           INITIAL
                           ===================================================== */

                        drawWheel();

                        updateMemberList();

                        updateCounts();

                        updateSpinAvailability();

                    });
                    </script>
<?= $this->endSection() ?>

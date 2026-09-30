<?= $this->extend('layouts/template') ?>


<?= $this->section('header') ?>

<div class="cf-dashboard-heading">

    <div>

        <div class="cf-eyebrow">
            <?= date('l, d F Y') ?>
        </div>

        <h1 class="cf-title">
            Hai, <?= esc(session('name') ?? 'Admin') ?>! 👋
        </h1>

        <p class="cf-subtitle">
            Yuk, lanjutkan project kamu hari ini.
        </p>

    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('content') ?>


<?php
/*
|--------------------------------------------------------------------------
| DATA UNTUK KALENDER
|--------------------------------------------------------------------------
*/

$calendarDeadlines = [];

if (!empty($deadline)) {

    foreach ($deadline as $item) {

        $date = $item['deadline'] ?? null;

        if (!$date) {
            continue;
        }

        $dateOnly = substr((string) $date, 0, 10);

        $calendarDeadlines[] = [
            'date'  => $dateOnly,
            'title' => $item['judul'] ?? 'Tugas',
            'group' => $item['nama_kelompok'] ?? '-',
        ];

    }

}
?>


<style>

/* =========================================================
   COLLABIFY DASHBOARD
   ========================================================= */

:root{

    --cf-blue:#79A9D8;
    --cf-blue-dark:#5E91C4;
    --cf-blue-soft:#EAF3FA;

    --cf-pink:#FF9AA2;
    --cf-pink-dark:#FF677D;
    --cf-pink-soft:#FFF0F1;

    --cf-yellow:#F9E79F;
    --cf-peach:#FFCCB6;

    --cf-bg:#FFF8F7;

    --cf-card:rgba(255,255,255,.78);

    --cf-text:#30323A;
    --cf-muted:#77777D;
    --cf-faint:#A5A5AB;

    --cf-border:rgba(255,255,255,.9);

    --cf-shadow:
        0 10px 30px rgba(94,145,196,.08),
        inset 0 1px 0 rgba(255,255,255,.95);
}


/* =========================================================
   BACKGROUND
   ========================================================= */

.content-wrapper{

    background:
        radial-gradient(
            circle at 90% 3%,
            rgba(255,154,162,.13),
            transparent 25%
        ),
        radial-gradient(
            circle at 10% 25%,
            rgba(121,169,216,.12),
            transparent 28%
        ),
        var(--cf-bg) !important;

}

/* =====================================================
   DASHBOARD — RAPATKAN GRID AGAR SEJAJAR DENGAN HERO
   ===================================================== */

.dash-2{
    width:100%;
    max-width:100%;
    min-width:0;

    display:grid;
    grid-template-columns:minmax(0, 1.55fr) minmax(0, 1fr);
    gap:14px;
    box-sizing:border-box;
}

.dash-2 > *{
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}

.dcard{
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}

/* Kalender jangan memaksa container melebar */
.dcard:has(.calendar),
.calendar,
.calendar-grid{
    min-width:0;
    max-width:100%;
}

/* Supaya isi kalender tetap muat di dalam card */
.dcard table{
    width:100%;
    table-layout:fixed;
}

.dcard td,
.dcard th{
    overflow:hidden;
}

/* Mobile */
@media(max-width:900px){
    .dash-2{
        grid-template-columns:1fr;
    }
}

/* =========================================================
   HEADER
   ========================================================= */

.cf-dashboard-heading{

    display:flex;
    align-items:flex-end;
    justify-content:space-between;

    gap:20px;

    margin-bottom:4px;

}


.cf-eyebrow{

    font-size:10px;
    font-weight:600;

    letter-spacing:.15em;

    text-transform:uppercase;

    color:var(--cf-blue-dark);

    margin-bottom:5px;

}


.cf-title{

    margin:0 !important;

    font-size:30px !important;

    line-height:1.15;

    font-weight:700 !important;

    letter-spacing:-.035em;

    color:var(--cf-text) !important;

}


.cf-subtitle{

    margin:7px 0 0;

    font-size:13px;

    color:var(--cf-muted);

}


/* =========================================================
   HERO
   ========================================================= */

.cf-hero{

    position:relative;

    overflow:hidden;

    margin-bottom:18px;

    padding:22px 24px;

    min-height:126px;

    border-radius:24px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.90),
            rgba(255,240,241,.78)
        );

    border:1px solid var(--cf-border);

    box-shadow:var(--cf-shadow);

    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);

}


.cf-hero-content{

    position:relative;

    z-index:2;

    max-width:65%;

}


.cf-hero-label{

    display:inline-flex;

    align-items:center;

    gap:6px;

    padding:6px 10px;

    border-radius:999px;

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

    font-size:10px;

    font-weight:600;

    letter-spacing:.04em;

}


.cf-hero-title{

    margin:10px 0 4px;

    font-size:21px;

    font-weight:700;

    color:var(--cf-text);

}


.cf-hero-text{

    margin:0;

    font-size:12.5px;

    line-height:1.6;

    color:var(--cf-muted);

}


/* HERO DECORATION */

.cf-hero-decoration{

    position:absolute;

    right:25px;

    top:50%;

    transform:translateY(-50%);

    width:150px;

    height:100px;

}


.cf-blob{

    position:absolute;

    border-radius:50%;

}


.cf-blob.blue{

    width:82px;
    height:82px;

    right:35px;
    top:5px;

    background:rgba(121,169,216,.25);

}


.cf-blob.pink{

    width:52px;
    height:52px;

    right:5px;
    bottom:2px;

    background:rgba(255,154,162,.38);

}


.cf-blob.yellow{

    width:30px;
    height:30px;

    left:20px;
    top:8px;

    background:rgba(249,231,159,.75);

}


.cf-star{

    position:absolute;

    color:var(--cf-pink-dark);

    font-size:22px;

}


.cf-star.one{

    right:76px;
    top:22px;

}


.cf-star.two{

    left:48px;
    bottom:15px;

    color:var(--cf-blue-dark);

    font-size:14px;

}


/* =========================================================
   STATISTICS
   ========================================================= */

.cf-stats{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:14px;

    margin-bottom:18px;

}


.cf-stat{

    position:relative;

    overflow:hidden;

    min-height:128px;

    padding:18px 19px;

    border-radius:20px;

    background:var(--cf-card);

    border:1px solid var(--cf-border);

    box-shadow:var(--cf-shadow);

    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);

    transition:
        transform .2s ease,
        box-shadow .2s ease;

}


.cf-stat:hover{

    transform:translateY(-3px);

    box-shadow:
        0 16px 35px rgba(94,145,196,.12),
        inset 0 1px 0 rgba(255,255,255,1);

}


.cf-stat-icon{

    width:38px;
    height:38px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:12px;

    font-size:18px;

}


.cf-stat:nth-child(1) .cf-stat-icon,
.cf-stat:nth-child(3) .cf-stat-icon{

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

}


.cf-stat:nth-child(2) .cf-stat-icon,
.cf-stat:nth-child(4) .cf-stat-icon{

    background:var(--cf-pink-soft);

    color:var(--cf-pink-dark);

}


.cf-stat-label{

    margin-top:13px;

    font-size:11.5px;

    color:var(--cf-muted);

}


.cf-stat-value{

    margin-top:2px;

    font-size:25px;

    line-height:1;

    font-weight:700;

    letter-spacing:-.03em;

    color:var(--cf-text);

}


.cf-stat-note{

    margin-top:6px;

    font-size:10.5px;

    color:var(--cf-faint);

}


/* =========================================================
   CARD
   ========================================================= */

.cf-card{

    background:var(--cf-card);

    border:1px solid var(--cf-border);

    border-radius:20px;

    box-shadow:var(--cf-shadow);

    backdrop-filter:blur(16px);

    -webkit-backdrop-filter:blur(16px);

}


.cf-card-inner{

    padding:19px 20px;

}


/* =========================================================
   SECTION HEADER
   ========================================================= */

.cf-section-head{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:12px;

}


.cf-section-title{

    margin:0;

    font-size:16px;

    font-weight:700;

    color:var(--cf-text);

}


.cf-section-link{

    font-size:11px;

    font-weight:600;

    color:var(--cf-blue-dark);

    text-decoration:none;

}


.cf-section-link:hover{

    color:var(--cf-pink-dark);

    text-decoration:none;

}


/* =========================================================
   MAIN TWO COLUMN
   ========================================================= */

/* =========================================================
   MAIN DASHBOARD GRID
   ========================================================= */

.cf-main-grid{
    display:grid;

    grid-template-columns:
        minmax(0, 1.55fr)
        minmax(0, .9fr);

    gap:16px;

    width:100%;
    max-width:100%;

    margin-bottom:16px;

    box-sizing:border-box;
}


/* Kolom wajib boleh mengecil */
.cf-left-column,
.cf-right-column{
    width:100%;
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}


/* Semua card mengikuti kolom */
.cf-left-column > .cf-card,
.cf-right-column > .cf-card{
    width:100%;
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}


/* Isi card juga tidak boleh mendorong keluar */
.cf-card,
.cf-card-inner{
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}


/* =========================================================
   CHART
   ========================================================= */

.cf-chart-wrap{

    height:225px;

    margin-top:5px;

}


.cf-chart-meta{

    display:flex;

    align-items:center;

    gap:8px;

    font-size:10px;

    color:var(--cf-faint);

}


.cf-chart-dot{

    width:7px;
    height:7px;

    border-radius:50%;

    background:var(--cf-blue);

}


/* =========================================================
   CALENDAR
   ========================================================= */

.cf-calendar-card{

    min-height:0;

}


.cf-calendar-top{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:13px;

}


.cf-calendar-month{

    font-size:14px;

    font-weight:700;

    color:var(--cf-text);

}


.cf-calendar-nav{

    display:flex;

    gap:5px;

}


.cf-calendar-btn{

    width:27px;
    height:27px;

    display:flex;

    align-items:center;
    justify-content:center;

    border:0;

    border-radius:8px;

    background:#F7F7F8;

    color:var(--cf-muted);

    cursor:pointer;

    transition:.2s ease;

}


.cf-calendar-btn:hover{

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

}


.cf-calendar-grid{

    display:grid;

    grid-template-columns:repeat(7,1fr);

    gap:4px;

}


.cf-calendar-week{

    margin-bottom:5px;

}


.cf-calendar-day-name{

    text-align:center;

    font-size:9px;

    font-weight:600;

    color:var(--cf-faint);

}


.cf-calendar-day{

    position:relative;

    min-height:32px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:9px;

    font-size:10.5px;

    color:var(--cf-text);

}


.cf-calendar-day.muted{

    color:#D0D0D4;

}


.cf-calendar-day.today{

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

    font-weight:700;

}


.cf-calendar-day.has-task::after{

    content:"";

    position:absolute;

    bottom:4px;

    width:4px;
    height:4px;

    border-radius:50%;

    background:var(--cf-pink-dark);

}


/* =========================================================
   DEADLINE REMINDER
   ========================================================= */

.cf-calendar-deadlines{

    margin-top:14px;

    padding-top:12px;

    border-top:1px solid #F0E8E9;

}


.cf-deadline-title{

    margin-bottom:7px;

    font-size:10px;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:.08em;

    color:var(--cf-faint);

}


.cf-deadline-list{

    display:grid;

}


.cf-deadline-item{

    display:flex;

    align-items:center;

    gap:9px;

    padding:8px 0;

}


.cf-deadline-dot{

    width:7px;
    height:7px;

    flex-shrink:0;

    border-radius:50%;

    background:var(--cf-pink);

}


.cf-deadline-info{

    flex:1;

    min-width:0;

}


.cf-deadline-name{

    overflow:hidden;

    white-space:nowrap;

    text-overflow:ellipsis;

    font-size:11.5px;

    font-weight:600;

    color:var(--cf-text);

}


.cf-deadline-group{

    margin-top:1px;

    font-size:9.5px;

    color:var(--cf-muted);

}


.cf-deadline-date{

    font-family:var(--mono);

    font-size:9px;

    color:var(--cf-faint);

    white-space:nowrap;

}


/* =========================================================
   TUGAS MENDATANG
   ========================================================= */

.cf-upcoming-card{

    min-height:0;

}


.cf-task-list{

    display:grid;

    gap:8px;

}


.cf-task{

    display:flex;

    align-items:center;

    gap:10px;

    padding:10px;

    border-radius:13px;

    background:rgba(255,255,255,.55);

    border:1px solid rgba(255,255,255,.85);

    transition:.2s ease;

}


.cf-task:hover{

    transform:translateX(3px);

    background:#fff;

}


.cf-task-icon{

    width:35px;
    height:35px;

    flex-shrink:0;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:11px;

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

    font-size:16px;

}


.cf-task:nth-child(even) .cf-task-icon{

    background:var(--cf-pink-soft);

    color:var(--cf-pink-dark);

}


.cf-task-main{

    flex:1;

    min-width:0;

}


.cf-task-name{

    overflow:hidden;

    white-space:nowrap;

    text-overflow:ellipsis;

    font-size:11.5px;

    font-weight:600;

    color:var(--cf-text);

}


.cf-task-group{

    margin-top:2px;

    font-size:9.5px;

    color:var(--cf-muted);

}


/* =========================================================
   UPCOMING TASK — PREVENT OVERFLOW
   ========================================================= */

.cf-task{
    width:100%;
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
}

.cf-task-main{
    flex:1 1 auto;
    min-width:0;
    overflow:hidden;
}

.cf-task-side{
    flex:0 1 auto;
    min-width:0;
    max-width:42%;
}

.cf-task-date{
    flex-shrink:1;
    min-width:0;
    overflow:hidden;
    text-overflow:ellipsis;
}

.cf-task-action{
    flex-shrink:0;
    white-space:nowrap;
}


.cf-task-date{

    font-family:var(--mono);

    font-size:8.5px;

    color:var(--cf-faint);

    white-space:nowrap;

}


.cf-task-action{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:3px;

    min-height:28px;

    padding:0 9px;

    border-radius:999px;

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

    font-size:9px;

    font-weight:700;

    text-decoration:none;

    transition:.18s ease;

}


.cf-task:nth-child(even) .cf-task-action{

    background:var(--cf-pink-soft);

    color:var(--cf-pink-dark);

}


.cf-task-action:hover{

    background:var(--cf-blue-dark);

    color:#fff;

    text-decoration:none;

}


.cf-task:nth-child(even) .cf-task-action:hover{

    background:var(--cf-pink-dark);

    color:#fff;

}


/* =========================================================
   AKTIVITAS TERBARU
   ========================================================= */

.cf-activity-card{

    min-height:280px;

}


.cf-activity-list{

    display:grid;

    gap:2px;

}


.cf-activity{

    display:flex;

    gap:11px;

    padding:12px 0;

    border-top:1px solid #F1EAEB;

}


.cf-activity:first-child{

    border-top:0;

}


.cf-activity-icon{

    width:36px;
    height:36px;

    flex-shrink:0;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:11px;

    background:var(--cf-pink-soft);

    color:var(--cf-pink-dark);

}


.cf-activity:nth-child(even) .cf-activity-icon{

    background:var(--cf-blue-soft);

    color:var(--cf-blue-dark);

}


.cf-activity-main{

    flex:1;

    min-width:0;

}


.cf-activity-text{

    font-size:12px;

    line-height:1.45;

    color:var(--cf-muted);

}


.cf-activity-text strong{

    color:var(--cf-text);

    font-weight:650;

}


.cf-activity-time{

    margin-top:3px;

    font-size:9.5px;

    color:var(--cf-faint);

}


/* =========================================================
   EMPTY
   ========================================================= */

.cf-empty{

    padding:24px 10px;

    text-align:center;

    color:var(--cf-faint);

    font-size:11.5px;

}


.cf-empty-icon{

    width:40px;
    height:40px;

    display:flex;

    align-items:center;
    justify-content:center;

    margin:0 auto 8px;

    border-radius:13px;

    background:#F7F7F8;

    font-size:18px;

}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width:1100px){

    .cf-stats{

        grid-template-columns:repeat(2,1fr);

    }

    .cf-main-grid{

        grid-template-columns:1fr;

    }

}


@media(max-width:700px){

    .cf-stats{

        grid-template-columns:1fr;

    }

    .cf-title{

        font-size:24px !important;

    }

    .cf-hero{

        padding:18px;

    }

    .cf-hero-content{

        max-width:100%;

    }

    .cf-hero-decoration{

        opacity:.35;

    }

    .cf-card-inner{

        padding:16px;

    }

    .cf-task-side{

        flex-direction:column;

        align-items:flex-end;

    }

}

/* =========================================================
   COLLABIFY DASHBOARD — DARK MODE OVERRIDE
   ========================================================= */

body.collabify-dark {

    --cf-bg: #181A1F;

    --cf-card: rgba(32, 35, 41, .94);

    --cf-text: #F1F2F4;
    --cf-muted: #A7AAB2;
    --cf-faint: #858993;

    --cf-border: rgba(255,255,255,.08);

    --cf-blue-soft: #293541;
    --cf-pink-soft: #34303A;

    --cf-shadow:
        0 12px 30px rgba(0,0,0,.22),
        inset 0 1px 0 rgba(255,255,255,.025);
}


/* =========================================================
   DASHBOARD BACKGROUND
   ========================================================= */

body.collabify-dark .content-wrapper {

    background:
        radial-gradient(
            circle at 90% 3%,
            rgba(255,103,125,.08),
            transparent 25%
        ),
        radial-gradient(
            circle at 10% 25%,
            rgba(121,169,216,.08),
            transparent 28%
        ),
        #181A1F !important;

    color: #F1F2F4 !important;
}


/* =========================================================
   HERO
   ========================================================= */

body.collabify-dark .cf-hero {

    background:
        linear-gradient(
            135deg,
            rgba(38,43,51,.96),
            rgba(43,39,46,.96)
        ) !important;

    border-color: rgba(255,255,255,.08) !important;

    box-shadow:
        0 12px 30px rgba(0,0,0,.20),
        inset 0 1px 0 rgba(255,255,255,.035) !important;
}

body.collabify-dark .cf-hero-title,
body.collabify-dark .cf-hero-content,
body.collabify-dark .cf-hero-description {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-hero-label {

    background: #293541 !important;
    color: #79A9D8 !important;
}


/* =========================================================
   STAT / KPI CARDS
   ========================================================= */

body.collabify-dark .cf-stat {

    background: rgba(32,35,41,.94) !important;

    border-color: rgba(255,255,255,.08) !important;

    box-shadow:
        0 10px 28px rgba(0,0,0,.20),
        inset 0 1px 0 rgba(255,255,255,.025) !important;
}

body.collabify-dark .cf-stat-label {

    color: #A7AAB2 !important;
}

body.collabify-dark .cf-stat-value {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-stat-note {

    color: #858993 !important;
}


/* =========================================================
   ALL DASHBOARD CARDS
   ========================================================= */

body.collabify-dark .cf-card {

    background: rgba(32,35,41,.94) !important;

    border-color: rgba(255,255,255,.08) !important;

    color: #F1F2F4 !important;

    box-shadow:
        0 12px 30px rgba(0,0,0,.20),
        inset 0 1px 0 rgba(255,255,255,.025) !important;
}

body.collabify-dark .cf-card-inner {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-section-title {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-section-link {

    color: #79A9D8 !important;
}

body.collabify-dark .cf-section-link:hover {

    color: #FF677D !important;
}


/* =========================================================
   CALENDAR
   ========================================================= */

body.collabify-dark .cf-calendar-month {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-calendar-day-name {

    color: #858993 !important;
}

body.collabify-dark .cf-calendar-day {

    color: #D9DBDF !important;
}

body.collabify-dark .cf-calendar-day.muted {

    color: #555A63 !important;
}

body.collabify-dark .cf-calendar-day.today {

    background: #293541 !important;
    color: #79A9D8 !important;
}

body.collabify-dark .cf-calendar-btn {

    background: #292C32 !important;
    color: #A7AAB2 !important;
}

body.collabify-dark .cf-calendar-btn:hover {

    background: #34303A !important;
    color: #FF9AA2 !important;
}

body.collabify-dark .cf-calendar-deadlines {

    border-top-color: #343841 !important;
}

body.collabify-dark .cf-deadline-title {

    color: #858993 !important;
}

body.collabify-dark .cf-deadline-name {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-deadline-group {

    color: #A7AAB2 !important;
}

body.collabify-dark .cf-deadline-date {

    color: #858993 !important;
}


/* =========================================================
   UPCOMING TASKS
   ========================================================= */

body.collabify-dark .cf-task {

    background: rgba(39,42,48,.92) !important;

    border-color: rgba(255,255,255,.07) !important;

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-task:hover {

    background: #2C3037 !important;
}

body.collabify-dark .cf-task-name {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-task-group {

    color: #A7AAB2 !important;
}

body.collabify-dark .cf-task-date {

    color: #858993 !important;
}


/* =========================================================
   TASK ICONS
   ========================================================= */

body.collabify-dark .cf-task-icon {

    background: #293541 !important;
    color: #79A9D8 !important;
}

body.collabify-dark .cf-task:nth-child(even) .cf-task-icon {

    background: #34303A !important;
    color: #FF9AA2 !important;
}


/* =========================================================
   ACTIVITY
   ========================================================= */

body.collabify-dark .cf-activity {

    border-top-color: #343841 !important;
}

body.collabify-dark .cf-activity-text {

    color: #A7AAB2 !important;
}

body.collabify-dark .cf-activity-text strong {

    color: #F1F2F4 !important;
}

body.collabify-dark .cf-activity-time {

    color: #858993 !important;
}

body.collabify-dark .cf-activity-icon {

    background: #34303A !important;
    color: #FF9AA2 !important;
}

body.collabify-dark .cf-activity:nth-child(even) .cf-activity-icon {

    background: #293541 !important;
    color: #79A9D8 !important;
}


/* =========================================================
   EMPTY STATE
   ========================================================= */

body.collabify-dark .cf-empty {

    color: #858993 !important;
}

body.collabify-dark .cf-empty-icon {

    background: #292C32 !important;
    color: #858993 !important;
}


/* =========================================================
   CHART
   ========================================================= */

body.collabify-dark .cf-chart-meta {

    color: #858993 !important;
}


/* =========================================================
   DEADLINE DOT
   ========================================================= */

body.collabify-dark .cf-deadline-dot {

    background: #FF677D !important;
}


/* =========================================================
   HERO DECORATION
   ========================================================= */

body.collabify-dark .cf-hero-decoration {

    opacity: .55;
}

</style>


<!-- =======================================================
     HERO
     ======================================================= -->

<div class="cf-hero">

    <div class="cf-hero-content">

        <div class="cf-hero-label">

            <i class="ti ti-sparkles"></i>

            COLLABIFY

        </div>


        <div class="cf-hero-title">

            Make it together.

        </div>


        <p class="cf-hero-text">

            Atur tugas, kelompok, catatan, dan project kamu
            dalam satu ruang kolaborasi.

        </p>

    </div>


    <div class="cf-hero-decoration">

        <div class="cf-blob blue"></div>

        <div class="cf-blob pink"></div>

        <div class="cf-blob yellow"></div>

        <span class="cf-star one">✦</span>

        <span class="cf-star two">✦</span>

    </div>

</div>


<!-- =======================================================
     QUICK STATS
     ======================================================= -->

<div class="cf-stats">


    <!-- PENGGUNA -->

    <div class="cf-stat">

        <div class="cf-stat-icon">

            <i class="ti ti-users"></i>

        </div>


        <div class="cf-stat-label">

            Pengguna terdaftar

        </div>


        <div class="cf-stat-value">

            <?= number_format($totalUser) ?>

        </div>


        <div class="cf-stat-note">

            pengguna

        </div>

    </div>


    <!-- KELOMPOK -->

    <div class="cf-stat">

        <div class="cf-stat-icon">

            <i class="ti ti-users-group"></i>

        </div>


        <div class="cf-stat-label">

            Kelompok aktif

        </div>


        <div class="cf-stat-value">

            <?= number_format($totalGroup) ?>

        </div>


        <div class="cf-stat-note">

            kelompok

        </div>

    </div>


    <!-- TEMPLATE -->

    <div class="cf-stat">

        <div class="cf-stat-icon">

            <i class="ti ti-file-description"></i>

        </div>


        <div class="cf-stat-label">

            Template tersedia

        </div>


        <div class="cf-stat-value">

            <?= number_format($totalTemplate) ?>

        </div>


        <div class="cf-stat-note">

            <?= number_format($templatePending) ?>
            menunggu review

        </div>

    </div>


    <!-- TUGAS -->

    <div class="cf-stat">

        <div class="cf-stat-icon">

            <i class="ti ti-checkbox"></i>

        </div>


        <div class="cf-stat-label">

            Total tugas

        </div>


        <div class="cf-stat-value">

            <?= number_format($totalTask) ?>

        </div>


        <div class="cf-stat-note">

            <?= number_format($taskSelesai) ?>
            selesai

        </div>

    </div>

</div>


<!-- =======================================================
     MAIN DASHBOARD
     ======================================================= -->

<div class="cf-main-grid">


    <!-- ===================================================
         LEFT COLUMN
         =================================================== -->

    <div class="cf-left-column">


        <!-- AKTIVITAS TUGAS -->

        <div class="cf-card">

            <div class="cf-card-inner">

                <div class="cf-section-head">

                    <div>

                        <h2 class="cf-section-title">

                            Aktivitas tugas

                        </h2>


                        <div class="cf-chart-meta">

                            <span class="cf-chart-dot"></span>

                            7 hari terakhir

                        </div>

                    </div>


                    <i class="ti ti-chart-line"
                       style="
                           font-size:18px;
                           color:var(--cf-blue-dark)
                       ">
                    </i>

                </div>


                <div class="cf-chart-wrap">

                    <canvas id="taskChart"></canvas>

                </div>

            </div>

        </div>


        <!-- AKTIVITAS TERBARU -->

        <div class="cf-card cf-activity-card">

            <div class="cf-card-inner">

                <div class="cf-section-head">

                    <h2 class="cf-section-title">

                        Aktivitas terbaru

                    </h2>


                    <a
                        href="<?= base_url('/tasks') ?>"
                        class="cf-section-link"
                    >
                        Lihat semua →
                    </a>

                </div>


                <?php if (empty($aktivitas)): ?>


                    <div class="cf-empty">

                        <div class="cf-empty-icon">

                            <i class="ti ti-activity"></i>

                        </div>

                        Belum ada aktivitas tercatat.

                    </div>


                <?php else: ?>


                    <div class="cf-activity-list">


                        <?php foreach (
                            array_slice($aktivitas, 0, 6)
                            as $act
                        ): ?>


                            <?php

                            $icon = match ($act['tipe']) {

                                'user'
                                    => 'user-plus',

                                'group'
                                    => 'users',

                                'template'
                                    => 'file-description',

                                'task'
                                    => 'checkbox',

                                default
                                    => 'activity',

                            };

                            ?>


                            <div class="cf-activity">


                                <div class="cf-activity-icon">

                                    <i class="ti ti-<?= $icon ?>"></i>

                                </div>


                                <div class="cf-activity-main">


                                    <div class="cf-activity-text">

                                        <strong>

                                            <?= esc(
                                                $act['judul']
                                            ) ?>

                                        </strong>


                                        <?= esc(
                                            $act['detail']
                                        ) ?>

                                    </div>


                                    <div class="cf-activity-time">

                                        <?= isset($act['waktu'])
                                            ? time_ago($act['waktu'])
                                            : '-' ?>

                                    </div>

                                </div>

                            </div>


                        <?php endforeach; ?>


                    </div>


                <?php endif; ?>

            </div>

        </div>

    </div>


    <!-- ===================================================
         RIGHT COLUMN
         =================================================== -->

    <div class="cf-right-column">


        <!-- =================================================
             KALENDER
             ================================================= -->

        <div class="cf-card cf-calendar-card">

            <div class="cf-card-inner">


                <div class="cf-section-head">

                    <h2 class="cf-section-title">

                        Kalender tugas

                    </h2>


                    <i
                        class="ti ti-calendar"
                        style="
                            font-size:18px;
                            color:var(--cf-pink-dark)
                        "
                    ></i>

                </div>


                <div class="cf-calendar-top">


                    <div
                        id="calendarMonth"
                        class="cf-calendar-month"
                    >
                    </div>


                    <div class="cf-calendar-nav">


                        <button
                            type="button"
                            class="cf-calendar-btn"
                            id="calendarPrev"
                            aria-label="Bulan sebelumnya"
                        >

                            <i class="ti ti-chevron-left"></i>

                        </button>


                        <button
                            type="button"
                            class="cf-calendar-btn"
                            id="calendarNext"
                            aria-label="Bulan berikutnya"
                        >

                            <i class="ti ti-chevron-right"></i>

                        </button>


                    </div>

                </div>


                <div
                    class="cf-calendar-grid cf-calendar-week"
                >

                    <div class="cf-calendar-day-name">
                        Sen
                    </div>

                    <div class="cf-calendar-day-name">
                        Sel
                    </div>

                    <div class="cf-calendar-day-name">
                        Rab
                    </div>

                    <div class="cf-calendar-day-name">
                        Kam
                    </div>

                    <div class="cf-calendar-day-name">
                        Jum
                    </div>

                    <div class="cf-calendar-day-name">
                        Sab
                    </div>

                    <div class="cf-calendar-day-name">
                        Min
                    </div>

                </div>


                <div
                    id="calendarDays"
                    class="cf-calendar-grid"
                >
                </div>


                <!-- DEADLINE REMINDER -->

                <div class="cf-calendar-deadlines">


                    <div class="cf-deadline-title">

                        Deadline mendatang

                    </div>


                    <?php if (empty($deadline)): ?>


                        <div
                            class="cf-empty"
                            style="padding:10px 0"
                        >

                            Belum ada deadline tugas.

                        </div>


                    <?php else: ?>


                        <div class="cf-deadline-list">


                            <?php foreach (
                                array_slice($deadline, 0, 3)
                                as $item
                            ): ?>


                                <div class="cf-deadline-item">


                                    <span
                                        class="cf-deadline-dot"
                                    ></span>


                                    <div
                                        class="cf-deadline-info"
                                    >

                                        <div
                                            class="cf-deadline-name"
                                        >

                                            <?= esc(
                                                $item['judul']
                                            ) ?>

                                        </div>


                                        <div
                                            class="cf-deadline-group"
                                        >

                                            <?= esc(
                                                $item['nama_kelompok']
                                                ?? '-'
                                            ) ?>

                                        </div>

                                    </div>


                                    <div
                                        class="cf-deadline-date"
                                    >

                                        <?= esc(
                                            substr(
                                                (string) (
                                                    $item['deadline']
                                                    ?? '-'
                                                ),
                                                0,
                                                10
                                            )
                                        ) ?>

                                    </div>

                                </div>


                            <?php endforeach; ?>


                        </div>


                    <?php endif; ?>


                </div>

            </div>

        </div>


        <!-- =================================================
             TUGAS MENDATANG
             ================================================= -->

        <div class="cf-card cf-upcoming-card">

            <div class="cf-card-inner">


                <div class="cf-section-head">

                    <h2 class="cf-section-title">

                        Tugas mendatang

                    </h2>


                    <a
                        href="<?= base_url('/tasks') ?>"
                        class="cf-section-link"
                    >
                        Lihat semua →
                    </a>

                </div>


                <?php if (empty($deadline)): ?>


                    <div class="cf-empty">

                        <div class="cf-empty-icon">

                            <i class="ti ti-checkbox"></i>

                        </div>

                        Belum ada tugas mendatang.

                    </div>


                <?php else: ?>


                    <div class="cf-task-list">


                        <?php foreach (
                            array_slice($deadline, 0, 4)
                            as $item
                        ): ?>


                            <div class="cf-task">


                                <div class="cf-task-icon">

                                    <i class="ti ti-checkbox"></i>

                                </div>


                                <div class="cf-task-main">


                                    <div class="cf-task-name">

                                        <?= esc(
                                            $item['judul']
                                        ) ?>

                                    </div>


                                    <div class="cf-task-group">

                                        <?= esc(
                                            $item['nama_kelompok']
                                            ?? '-'
                                        ) ?>

                                    </div>

                                </div>


                                <div class="cf-task-side">


                                    <div class="cf-task-date">

                                        <?= esc(
                                            substr(
                                                (string) (
                                                    $item['deadline']
                                                    ?? '-'
                                                ),
                                                0,
                                                10
                                            )
                                        ) ?>

                                    </div>


                                    <a
                                        href="<?= !empty($item['id_task'])
                                            ? base_url(
                                                '/tasks/' .
                                                $item['id_task']
                                            )
                                            : base_url('/tasks') ?>"
                                        class="cf-task-action"
                                    >

                                        Kerjakan

                                        <i
                                            class="ti ti-arrow-right"
                                        ></i>

                                    </a>


                                </div>

                            </div>


                        <?php endforeach; ?>


                    </div>


                <?php endif; ?>


            </div>

        </div>


    </div>

</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>


<script>

/* =========================================================
   CHART AKTIVITAS TUGAS
   ========================================================= */

(function(){

    var cv =
        document.getElementById('taskChart');

    if(!cv) return;


    var ctx =
        cv.getContext('2d');


    var grad =
        ctx.createLinearGradient(
            0,
            0,
            0,
            225
        );


    grad.addColorStop(
        0,
        'rgba(121,169,216,.22)'
    );


    grad.addColorStop(
        1,
        'rgba(121,169,216,0)'
    );


    new Chart(
        cv,
        {

            type:'line',

            data:{

                labels:
                    <?= $grafikLabels ?>,

                datasets:[{

                    label:'Tugas',

                    data:
                        <?= $grafikData ?>,

                    borderColor:
                        '#5E91C4',

                    backgroundColor:
                        grad,

                    fill:true,

                    tension:.42,

                    borderWidth:2.5,

                    pointBackgroundColor:
                        '#79A9D8',

                    pointBorderColor:
                        '#FFFFFF',

                    pointBorderWidth:2,

                    pointRadius:3.5,

                    pointHoverRadius:6

                }]

            },


            options:{

                responsive:true,

                maintainAspectRatio:false,


                interaction:{

                    intersect:false,

                    mode:'index'

                },


                plugins:{

                    legend:{

                        display:false

                    },


                    tooltip:{

                        backgroundColor:
                            '#30323A',

                        cornerRadius:10,

                        padding:10,

                        displayColors:false,


                        callbacks:{

                            label:function(c){

                                return
                                    ' ' +
                                    c.parsed.y +
                                    ' tugas';

                            }

                        }

                    }

                },


                scales:{

                    x:{

                        grid:{

                            display:false

                        },

                        border:{

                            display:false

                        },

                        ticks:{

                            color:'#9999A0',

                            font:{

                                size:10

                            }

                        }

                    },


                    y:{

                        beginAtZero:true,

                        grid:{

                            color:
                                'rgba(48,50,58,.06)'

                        },

                        border:{

                            display:false

                        },

                        ticks:{

                            stepSize:1,

                            color:'#A5A5AB',

                            font:{

                                size:9

                            }

                        }

                    }

                }

            }

        }

    );

})();



/* =========================================================
   KALENDER
   ========================================================= */

(function(){

    var calendarData =
        <?= json_encode(
            $calendarDeadlines,
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_AMP |
            JSON_HEX_QUOT
        ) ?>;


    var currentDate =
        new Date();


    var monthNames = [

        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'

    ];


    var monthLabel =
        document.getElementById(
            'calendarMonth'
        );


    var daysContainer =
        document.getElementById(
            'calendarDays'
        );


    var prevButton =
        document.getElementById(
            'calendarPrev'
        );


    var nextButton =
        document.getElementById(
            'calendarNext'
        );


    if(
        !monthLabel ||
        !daysContainer ||
        !prevButton ||
        !nextButton
    ){

        return;

    }


    function pad(number){

        return String(number)
            .padStart(2,'0');

    }


    function dateKey(
        year,
        month,
        day
    ){

        return year +
            '-' +
            pad(month + 1) +
            '-' +
            pad(day);

    }


    function renderCalendar(){

        var year =
            currentDate.getFullYear();


        var month =
            currentDate.getMonth();


        monthLabel.textContent =
            monthNames[month] +
            ' ' +
            year;


        daysContainer.innerHTML = '';


        /*
         * Sunday = 0
         * Kita ubah supaya Monday = 0
         */

        var firstDay =
            new Date(
                year,
                month,
                1
            ).getDay();


        var offset =
            firstDay === 0
                ? 6
                : firstDay - 1;


        var daysInMonth =
            new Date(
                year,
                month + 1,
                0
            ).getDate();


        var daysInPreviousMonth =
            new Date(
                year,
                month,
                0
            ).getDate();


        var today =
            new Date();


        var todayKey =
            dateKey(
                today.getFullYear(),
                today.getMonth(),
                today.getDate()
            );


        var deadlineMap = {};


        calendarData.forEach(
            function(item){

                if(!item.date){
                    return;
                }


                if(
                    !deadlineMap[item.date]
                ){

                    deadlineMap[item.date] = [];

                }


                deadlineMap[item.date]
                    .push(item);

            }
        );


        /*
         * Previous month
         */

        for(
            var i = offset - 1;
            i >= 0;
            i--
        ){

            var day =
                daysInPreviousMonth - i;


            var el =
                document.createElement(
                    'div'
                );


            el.className =
                'cf-calendar-day muted';


            el.textContent =
                day;


            daysContainer
                .appendChild(el);

        }


        /*
         * Current month
         */

        for(
            var day = 1;
            day <= daysInMonth;
            day++
        ){

            var key =
                dateKey(
                    year,
                    month,
                    day
                );


            var el =
                document.createElement(
                    'div'
                );


            el.className =
                'cf-calendar-day';


            el.textContent =
                day;


            if(
                key === todayKey
            ){

                el.classList.add(
                    'today'
                );

            }


            if(
                deadlineMap[key]
            ){

                el.classList.add(
                    'has-task'
                );


                var titles =
                    deadlineMap[key]
                        .map(
                            function(item){

                                return item.title;

                            }
                        )
                        .join(', ');


                el.title =
                    'Deadline: ' +
                    titles;

            }


            daysContainer
                .appendChild(el);

        }


        /*
         * Next month
         */

        var totalCells =
            offset +
            daysInMonth;


        var remaining =
            totalCells % 7 === 0
                ? 0
                : 7 -
                    (
                        totalCells % 7
                    );


        for(
            var j = 1;
            j <= remaining;
            j++
        ){

            var nextEl =
                document.createElement(
                    'div'
                );


            nextEl.className =
                'cf-calendar-day muted';


            nextEl.textContent =
                j;


            daysContainer
                .appendChild(nextEl);

        }

    }


    prevButton.addEventListener(
        'click',
        function(){

            currentDate.setMonth(
                currentDate.getMonth() - 1
            );

            renderCalendar();

        }
    );


    nextButton.addEventListener(
        'click',
        function(){

            currentDate.setMonth(
                currentDate.getMonth() + 1
            );

            renderCalendar();

        }
    );


    renderCalendar();

})();

</script>


<?= $this->endSection() ?>
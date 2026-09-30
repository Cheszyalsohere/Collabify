<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Publik ──────────────────────────────────────────────
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::showLogin');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::showRegister');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// ── Admin ───────────────────────────────────────────────
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'role:admin']);

// ── Wajib login ─────────────────────────────────────────
$routes->group('', ['filter' => 'auth'], static function ($routes) {

    $routes->get('home', 'Home::beranda');

    $routes->get('profil', 'UserController::profile');
    $routes->post('profil', 'UserController::updateProfile');

    // Groups
    $routes->get('groups', 'GroupController::index');
    $routes->get('groups/create', 'GroupController::create');
    $routes->post('groups/store', 'GroupController::store');
    $routes->get('groups/join', 'GroupController::joinForm');
    $routes->post('groups/join', 'GroupController::join');
    $routes->get('groups/(:num)', 'GroupController::show/$1');
    $routes->get('groups/(:num)/members', 'GroupController::members/$1');

    // Tasks
    $routes->get('tasks', 'TaskController::index');
    $routes->get('tasks/create', 'TaskController::create');
    $routes->post('tasks/store', 'TaskController::store');
    $routes->get('tasks/(:num)', 'TaskController::show/$1');
    $routes->post('tasks/(:num)/status', 'TaskController::updateStatus/$1');

    // Notes
    $routes->get('notes', 'NoteController::index');
    $routes->get('notes/create', 'NoteController::create');
    $routes->post('notes/store', 'NoteController::store');
    $routes->post('notes/(:num)/delete', 'NoteController::delete/$1');

    // Spin (pembagian tugas adil)
    $routes->get('spin', 'SpinController::index');
    $routes->post('spin/step', 'SpinController::step');
    $routes->get('spin/history/(:num)', 'SpinController::history/$1');
    $routes->post('spin/save-note', 'SpinController::saveNote');

    // Templates
    $routes->get('templates', 'TemplateController::index');
    $routes->get('templates/create', 'TemplateController::create');
    $routes->post('templates/store', 'TemplateController::store');
    $routes->get('templates/bookmarks', 'TemplateController::bookmarks');
    $routes->get('templates/(:num)', 'TemplateController::show/$1');
    $routes->get('templates/(:num)/download', 'TemplateController::download/$1');
    $routes->post('templates/(:num)/bookmark', 'TemplateController::bookmark/$1');
    $routes->post('templates/(:num)/rating', 'TemplateController::rating/$1');
    $routes->get('templates/(:num)/use', 'WorkspaceController::createFromTemplate/$1');
    $routes->post('templates/(:num)/gunakan-google', 'TemplateController::gunakanGoogle/$1');
    $routes->post('templates/(:num)/gdoc', 'TemplateController::setGoogleDoc/$1');
    $routes->get('templates/(:num)/ke-gdocs', 'TemplateController::keGdocs/$1');

    // Workspaces
    $routes->get('workspaces', 'WorkspaceController::index');
    $routes->post('workspaces/store', 'WorkspaceController::store');
    $routes->post('workspaces/save', 'WorkspaceController::save');
    $routes->post('workspaces/riwayat/(:num)/link', 'WorkspaceController::saveHistoryLink/$1');
    $routes->post('workspaces/dokumen-kosong', 'WorkspaceController::dokumenKosong');
    $routes->post('workspaces/riwayat/(:num)/hapus', 'WorkspaceController::deleteHistory/$1');
    $routes->get('workspaces/(:num)', 'WorkspaceController::show/$1');

    // Forum (community + group channel, chat & voice)
    $routes->get('forum', 'ForumController::index');
    $routes->get('forum/group/(:num)', 'ForumController::group/$1');
    $routes->get('forum/channel/(:num)', 'ForumController::channel/$1');
    $routes->post('forum/channel/(:num)/message', 'ForumController::sendMessage/$1');
    $routes->post('forum/send-message', 'ForumController::sendMessage');
    $routes->get('forum/channel/(:num)/messages', 'ForumController::getMessages/$1');
    $routes->post('forum/channel/(:num)/join-voice', 'ForumController::joinVoice/$1');
    $routes->get('forum/channel/(:num)/voice-participants', 'ForumController::voiceParticipants/$1');
    $routes->post('forum/channel/(:num)/leave-voice', 'ForumController::leaveVoice/$1');
    $routes->post('forum/channel/(:num)/toggle-mute', 'ForumController::toggleMute/$1');
    $routes->post('forum/channel/(:num)/voice-signal', 'ForumController::sendVoiceSignal/$1');
    $routes->get('forum/channel/(:num)/voice-signals', 'ForumController::getVoiceSignals/$1');
});

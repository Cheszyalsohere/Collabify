<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Cek login + role yang diizinkan.
     *
     * Cara pakai di Routes.php:
     *   $routes->get('dashboard', 'AdminController::index', ['filter' => 'role:admin']);
     *   $routes->get('groups', 'GroupController::index', ['filter' => 'role:mahasiswa,dosen,admin']);
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login dulu.');
        }

        // Kalau argument role nggak diisi di route, cukup cek sudah login aja.
        if (empty($arguments)) {
            return;
        }

        $allowedRoles = $arguments; // contoh: ['admin'] atau ['mahasiswa', 'dosen']
        $userRole     = session()->get('role');

        if (! in_array($userRole, $allowedRoles, true)) {
            return redirect()->to('/home')->with('error', 'Kamu tidak punya akses ke halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu apa-apa setelah request selesai.
    }
}
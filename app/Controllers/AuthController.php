<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function showLogin()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }
        return view('auth/login');
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->findByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        $this->setUserSession($user);
        return $this->redirectByRole();
    }

    public function showRegister()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole();
        }
        return view('auth/register');
    }

    public function register()
    {
        $rules = [
            'name'         => 'required|min_length[3]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name  = $this->request->getPost('name');
        $email = $this->request->getPost('email');

        // Peran default untuk pendaftar baru selalu 'mahasiswa'.
        // Role 'dosen' dan 'admin' hanya diberikan manual lewat panel admin,
        // supaya orang tidak bisa daftar sendiri sebagai dosen/admin.
        $userModel = new UserModel();
        $userModel->insert([
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'mahasiswa',
        ]);

        $user = $userModel->findByEmail($email);
        $this->setUserSession($user);

        return redirect()->to('/home')->with('success', 'Akun berhasil dibuat. Selamat datang di COLLABIFY!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Kamu sudah keluar. Sampai jumpa lagi!');
    }

    private function setUserSession(array $user): void
    {
        session()->set([
            'isLoggedIn' => true,
            'id_user'    => $user['id_user'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
        ]);
    }

    private function redirectByRole()
    {
        return session()->get('role') === 'admin'
            ? redirect()->to('/dashboard')
            : redirect()->to('/home');
    }
}
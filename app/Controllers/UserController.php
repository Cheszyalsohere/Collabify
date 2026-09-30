<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    // Halaman profil
    public function profile()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session('id_user'));

        if (!$user) {
            return redirect()->to('/login');
        }

        return view('user/profile', [
            'title' => 'Profil Saya — COLLABIFY',
            'user'  => $user,
        ]);
    }

    // Update profil
    public function updateProfile()
    {
        $id = session('id_user');

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id_user,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->update($id, [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);

        // Segarkan data session
        session()->set([
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);

        return redirect()->to('/profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Membuat akun admin pertama.
 *
 * Email & password dibaca dari .env (ADMIN_EMAIL, ADMIN_PASSWORD). Kalau password
 * tidak diisi, dibuat acak dan DITAMPILKAN SEKALI di layar — tidak ada password
 * bawaan yang bisa ditebak orang.
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        $email    = (string) (env('ADMIN_EMAIL') ?: 'admin@collabify.test');
        $password = (string) env('ADMIN_PASSWORD');
        $generated = false;

        if ($password === '') {
            $password  = bin2hex(random_bytes(8));
            $generated = true;
        }

        // Hindari duplikat kalau seeder dijalankan dua kali
        if ($this->db->table('users')->where('email', $email)->countAllResults() > 0) {
            return;
        }

        $this->db->table('users')->insert([
            'name'       => 'Administrator',
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        echo "\nAkun admin dibuat: {$email}\n";
        if ($generated) {
            echo "Password (catat sekarang, tidak ditampilkan lagi): {$password}\n";
        }
        echo "\n";
    }
}

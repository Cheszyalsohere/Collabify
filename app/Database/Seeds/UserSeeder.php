<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Hindari duplikat kalau seeder dijalankan dua kali
        $exists = $this->db->table('users')->where('email', 'admin@campussaver.test')->countAllResults();
        if ($exists > 0) {
            return;
        }

        $this->db->table('users')->insert([
            'name'       => 'Administrator',
            'email'      => 'admin@campussaver.test',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

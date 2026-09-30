<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ForumChannelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // =========================
            // COMMUNITY TEXT
            // =========================

            [
                'id_group'     => null,
                'nama_channel' => 'general',
                'slug'         => 'general',
                'tipe'         => 'text',
                'deskripsi'    => 'Tempat ngobrol umum mahasiswa.',
                'dibuat_oleh'  => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            [
                'id_group'     => null,
                'nama_channel' => 'akademik',
                'slug'         => 'akademik',
                'tipe'         => 'text',
                'deskripsi'    => 'Diskusi seputar perkuliahan dan akademik.',
                'dibuat_oleh'  => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            [
                'id_group'     => null,
                'nama_channel' => 'tanya-jawab',
                'slug'         => 'tanya-jawab',
                'tipe'         => 'text',
                'deskripsi'    => 'Tempat bertanya dan membantu sesama mahasiswa.',
                'dibuat_oleh'  => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // =========================
            // COMMUNITY VOICE
            // =========================

            [
                'id_group'     => null,
                'nama_channel' => 'Ruang Diskusi',
                'slug'         => 'ruang-diskusi',
                'tipe'         => 'voice',
                'deskripsi'    => 'Ruang voice untuk berdiskusi.',
                'dibuat_oleh'  => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            [
                'id_group'     => null,
                'nama_channel' => 'Santai',
                'slug'         => 'santai',
                'tipe'         => 'voice',
                'deskripsi'    => 'Ruang voice untuk ngobrol santai.',
                'dibuat_oleh'  => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db
            ->table('forum_channels')
            ->insertBatch($data);
    }
}
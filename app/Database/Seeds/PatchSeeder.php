<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PatchSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_paket' => 'Security Update',
                'versi' => '1.0.1',
                'prioritas' => 'High',
                'deskripsi' => 'Perbaikan keamanan untuk mengatasi celah XSS pada form pencarian.',
                'tanggal_rilis' => '2023-06-15',
                'ukuran' => '2.5 MB',
                'jumlah_unduhan' => 120,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket' => 'UI Enhancement',
                'versi' => '1.1.0',
                'prioritas' => 'Medium',
                'deskripsi' => 'Peningkatan antarmuka pengguna pada halaman dashboard dan katalog.',
                'tanggal_rilis' => '2023-06-20',
                'ukuran' => '4.2 MB',
                'jumlah_unduhan' => 85,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket' => 'Bug Fix',
                'versi' => '1.0.2',
                'prioritas' => 'Low',
                'deskripsi' => 'Perbaikan bug pada fitur pencetakan laporan bulanan.',
                'tanggal_rilis' => '2023-06-25',
                'ukuran' => '1.8 MB',
                'jumlah_unduhan' => 50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data to table
        $this->db->table('patches')->insertBatch($data);
    }
}
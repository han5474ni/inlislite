<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Panduan Pengguna Revisi 16062016 – Modul Lengkap',
                'description' => 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3',
                'file_name' => 'panduan_pengguna_lengkap.pdf',
                'file_path' => 'uploads/documents/panduan_pengguna_lengkap.pdf',
                'file_size' => '12 MB',
                'file_type' => 'PDF',
                'version' => 'V3.2.1',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Pengaturan Administrasi di INLISLite v3',
                'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
                'file_name' => 'panduan_administrasi.pdf',
                'file_path' => 'uploads/documents/panduan_administrasi.pdf',
                'file_size' => '1.8 MB',
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3',
                'description' => 'Panduan langkah demi langkah untuk mengelola koleksi bahan pustaka',
                'file_name' => 'panduan_bahan_pustaka.pdf',
                'file_path' => 'uploads/documents/panduan_bahan_pustaka.pdf',
                'file_size' => '1.8 MB',
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Manajemen Keanggotaan di INLISLite v3',
                'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
                'file_name' => 'panduan_keanggotaan.pdf',
                'file_path' => 'uploads/documents/panduan_keanggotaan.pdf',
                'file_size' => '1.7 MB',
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Manajemen Sirkulasi di INLISLite v3',
                'description' => 'Panduan untuk mengelola peminjaman dan pengembalian buku',
                'file_name' => 'panduan_sirkulasi.pdf',
                'file_path' => 'uploads/documents/panduan_sirkulasi.pdf',
                'file_size' => '1.7 MB',
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Pembuatan Survei di INLISLite v3',
                'description' => 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan',
                'file_name' => 'panduan_survei.pdf',
                'file_path' => 'uploads/documents/panduan_survei.pdf',
                'file_size' => '1.4 MB',
                'file_type' => 'PDF',
                'version' => 'V3.1.5',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data using Query Builder
        $this->db->table('documents')->insertBatch($data);
    }
}

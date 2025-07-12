<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFiturTable extends Migration
{
    public function up()
    {
        // Create fitur table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'default' => 'bi-star',
            ],
            'color' => [
                'type' => 'ENUM',
                'constraint' => ['blue', 'green', 'orange', 'purple'],
                'default' => 'blue',
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['feature', 'module'],
                'default' => 'feature',
            ],
            'module_type' => [
                'type' => 'ENUM',
                'constraint' => ['application', 'database', 'utility'],
                'null' => true,
                'default' => null,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('type');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('fitur');

        // Insert sample data
        $this->insertSampleData();
    }

    public function down()
    {
        $this->forge->dropTable('fitur');
    }

    private function insertSampleData()
    {
        $data = [
            // Features
            [
                'title' => 'Form Entri Katalog Sederhana',
                'description' => 'Menyediakan form entri katalog berbasis MARC yang disederhanakan untuk memudahkan pustakawan dalam menginput data bibliografi dengan cepat dan akurat.',
                'icon' => 'bi-file-text',
                'color' => 'blue',
                'type' => 'feature',
                'module_type' => null,
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Kardek Terbitan Teknologi',
                'description' => 'Fitur back-end untuk mendukung pengelolaan koleksi berbasis teknologi dengan sistem tracking dan monitoring yang terintegrasi.',
                'icon' => 'bi-cpu',
                'color' => 'green',
                'type' => 'feature',
                'module_type' => null,
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Sistem Sirkulasi Otomatis',
                'description' => 'Manajemen peminjaman dan pengembalian buku secara otomatis dengan notifikasi real-time dan sistem denda terintegrasi.',
                'icon' => 'bi-arrow-repeat',
                'color' => 'blue',
                'type' => 'feature',
                'module_type' => null,
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'OPAC (Online Public Access Catalog)',
                'description' => 'Katalog online yang memungkinkan pengguna mencari dan mengakses informasi koleksi perpustakaan dari mana saja.',
                'icon' => 'bi-search',
                'color' => 'orange',
                'type' => 'feature',
                'module_type' => null,
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Manajemen Keanggotaan',
                'description' => 'Sistem pengelolaan data anggota perpustakaan dengan fitur registrasi online, perpanjangan membership, dan kartu anggota digital.',
                'icon' => 'bi-people',
                'color' => 'purple',
                'type' => 'feature',
                'module_type' => null,
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Laporan dan Statistik',
                'description' => 'Sistem pelaporan komprehensif dengan dashboard analitik untuk monitoring aktivitas perpustakaan dan pengambilan keputusan.',
                'icon' => 'bi-graph-up',
                'color' => 'green',
                'type' => 'feature',
                'module_type' => null,
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Modules
            [
                'title' => 'Portal Aplikasi Inlislite',
                'description' => 'Navigasi utama ke semua modul sistem dengan dashboard terpusat dan akses cepat ke fitur-fitur utama.',
                'icon' => 'bi-house-door',
                'color' => 'green',
                'type' => 'module',
                'module_type' => 'application',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Back Office',
                'description' => 'Manajemen data perpustakaan internal termasuk pengaturan sistem, konfigurasi, dan administrasi pengguna.',
                'icon' => 'bi-gear',
                'color' => 'blue',
                'type' => 'module',
                'module_type' => 'application',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Modul Katalogisasi',
                'description' => 'Sistem katalogisasi lengkap dengan standar MARC21, Dublin Core, dan format metadata internasional lainnya.',
                'icon' => 'bi-book',
                'color' => 'blue',
                'type' => 'module',
                'module_type' => 'application',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Database Management System',
                'description' => 'Sistem manajemen database yang robust dengan fitur backup otomatis, replikasi, dan optimasi performa.',
                'icon' => 'bi-database',
                'color' => 'green',
                'type' => 'module',
                'module_type' => 'database',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'API Gateway',
                'description' => 'Interface pemrograman aplikasi untuk integrasi dengan sistem eksternal dan pengembangan aplikasi pihak ketiga.',
                'icon' => 'bi-cloud',
                'color' => 'green',
                'type' => 'module',
                'module_type' => 'database',
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Mobile Application',
                'description' => 'Aplikasi mobile untuk akses perpustakaan digital dengan fitur pencarian, peminjaman, dan notifikasi push.',
                'icon' => 'bi-phone',
                'color' => 'orange',
                'type' => 'module',
                'module_type' => 'application',
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('fitur')->insertBatch($data);
    }
}
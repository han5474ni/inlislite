<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTentangCardsTable extends Migration
{
    public function up()
    {
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
                'comment' => 'Title of the about card'
            ],
            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Subtitle of the about card'
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false,
                'comment' => 'Content of the about card (HTML allowed)'
            ],
            'category' => [
                'type' => 'ENUM',
                'constraint' => ['overview', 'legal', 'features', 'technical', 'other'],
                'default' => 'overview',
                'comment' => 'Category of the about card'
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Bootstrap icon class'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'comment' => 'Card status'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
                'comment' => 'Display order'
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
        $this->forge->addKey('category');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->addKey(['status', 'sort_order']);
        
        $this->forge->createTable('tentang_cards');

        // Insert default tentang cards
        $defaultCards = [
            [
                'title' => 'INLISLite Version 3',
                'subtitle' => 'Library Automation System Overview',
                'content' => '<p>INLISLite Version 3 adalah sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia. Sistem ini dirancang untuk membantu perpustakaan dalam mengelola koleksi, anggota, dan layanan perpustakaan secara digital dan terintegrasi.</p><p>Dengan teknologi terkini dan antarmuka yang user-friendly, INLISLite v3 memberikan solusi komprehensif untuk kebutuhan manajemen perpustakaan modern.</p>',
                'category' => 'overview',
                'icon' => 'bi-info-circle',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Legal Framework',
                'subtitle' => 'Dasar Hukum dan Regulasi',
                'content' => '<ul><li>Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan</li><li>Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan UU Perpustakaan</li><li>Peraturan Kepala Perpustakaan Nasional RI tentang Standar Nasional Perpustakaan</li><li>Kebijakan pengembangan sistem informasi perpustakaan nasional</li></ul>',
                'category' => 'legal',
                'icon' => 'bi-shield-check',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Key Features',
                'subtitle' => 'Fitur Utama Sistem',
                'content' => '<ul><li><strong>Katalogisasi:</strong> Sistem katalog digital dengan standar internasional</li><li><strong>Sirkulasi:</strong> Manajemen peminjaman dan pengembalian otomatis</li><li><strong>Keanggotaan:</strong> Pengelolaan data anggota perpustakaan</li><li><strong>Inventarisasi:</strong> Tracking dan monitoring koleksi perpustakaan</li><li><strong>Laporan:</strong> Sistem pelaporan komprehensif dan real-time</li><li><strong>OPAC:</strong> Online Public Access Catalog untuk pencarian koleksi</li></ul>',
                'category' => 'features',
                'icon' => 'bi-star',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'System Requirements',
                'subtitle' => 'Kebutuhan Sistem Minimum',
                'content' => '<p><strong>Server Requirements:</strong></p><ul><li>Operating System: Linux/Windows Server</li><li>Web Server: Apache/Nginx</li><li>Database: MySQL/PostgreSQL</li><li>PHP Version: 8.0 atau lebih tinggi</li><li>Memory: Minimum 4GB RAM</li><li>Storage: Minimum 20GB free space</li></ul><p><strong>Client Requirements:</strong></p><ul><li>Web Browser: Chrome, Firefox, Safari, Edge (versi terbaru)</li><li>JavaScript: Enabled</li><li>Internet Connection: Stable broadband</li></ul>',
                'category' => 'technical',
                'icon' => 'bi-gear',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('tentang_cards')->insertBatch($defaultCards);
    }

    public function down()
    {
        $this->forge->dropTable('tentang_cards');
    }
}
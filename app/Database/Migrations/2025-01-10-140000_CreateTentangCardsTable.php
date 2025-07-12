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
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Description of the about card'
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Bootstrap icon class'
            ],
            'color_class' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'CSS color class'
            ],
            'background_color' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'comment' => 'Background color'
            ],
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Image URL'
            ],
            'link_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Link URL'
            ],
            'link_text' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Link text'
            ],
            'card_type' => [
                'type' => 'ENUM',
                'constraint' => ['info', 'feature', 'contact', 'technical'],
                'default' => 'info',
                'comment' => 'Type of the about card'
            ],
            'card_size' => [
                'type' => 'ENUM',
                'constraint' => ['small', 'medium', 'large'],
                'default' => 'medium',
                'comment' => 'Size of the card'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => 'Card active status'
            ],
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Featured card status'
            ],
            'card_key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'Unique card key'
            ],
            'statistics' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Card statistics data'
            ],
            'features' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Card features data'
            ],
            'metadata' => [
                'type' => 'JSON',
                'null' => true,
                'comment' => 'Additional metadata'
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
        $this->forge->addKey('card_type');
        $this->forge->addKey('is_active');
        $this->forge->addKey('sort_order');
        $this->forge->addKey(['is_active', 'sort_order']);
        
        $this->forge->createTable('tentang_cards');

        // Insert default tentang cards
        $defaultCards = [
            [
                'title' => 'INLISLite Version 3',
                'subtitle' => 'Library Automation System Overview',
                'content' => '<p>INLISLite Version 3 adalah sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia. Sistem ini dirancang untuk membantu perpustakaan dalam mengelola koleksi, anggota, dan layanan perpustakaan secara digital dan terintegrasi.</p><p>Dengan teknologi terkini dan antarmuka yang user-friendly, INLISLite v3 memberikan solusi komprehensif untuk kebutuhan manajemen perpustakaan modern.</p>',
                'card_type' => 'info',
                'icon' => 'bi-info-circle',
                'is_active' => 1,
                'sort_order' => 1,
                'card_key' => 'inlislite_overview',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Legal Framework',
                'subtitle' => 'Dasar Hukum dan Regulasi',
                'content' => '<ul><li>Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan</li><li>Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan UU Perpustakaan</li><li>Peraturan Kepala Perpustakaan Nasional RI tentang Standar Nasional Perpustakaan</li><li>Kebijakan pengembangan sistem informasi perpustakaan nasional</li></ul>',
                'card_type' => 'info',
                'icon' => 'bi-shield-check',
                'is_active' => 1,
                'sort_order' => 2,
                'card_key' => 'legal_framework',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Key Features',
                'subtitle' => 'Fitur Utama Sistem',
                'content' => '<ul><li><strong>Katalogisasi:</strong> Sistem katalog digital dengan standar internasional</li><li><strong>Sirkulasi:</strong> Manajemen peminjaman dan pengembalian otomatis</li><li><strong>Keanggotaan:</strong> Pengelolaan data anggota perpustakaan</li><li><strong>Inventarisasi:</strong> Tracking dan monitoring koleksi perpustakaan</li><li><strong>Laporan:</strong> Sistem pelaporan komprehensif dan real-time</li><li><strong>OPAC:</strong> Online Public Access Catalog untuk pencarian koleksi</li></ul>',
                'card_type' => 'feature',
                'icon' => 'bi-star',
                'is_active' => 1,
                'sort_order' => 3,
                'card_key' => 'key_features',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'System Requirements',
                'subtitle' => 'Kebutuhan Sistem Minimum',
                'content' => '<p><strong>Server Requirements:</strong></p><ul><li>Operating System: Linux/Windows Server</li><li>Web Server: Apache/Nginx</li><li>Database: MySQL/PostgreSQL</li><li>PHP Version: 8.0 atau lebih tinggi</li><li>Memory: Minimum 4GB RAM</li><li>Storage: Minimum 20GB free space</li></ul><p><strong>Client Requirements:</strong></p><ul><li>Web Browser: Chrome, Firefox, Safari, Edge (versi terbaru)</li><li>JavaScript: Enabled</li><li>Internet Connection: Stable broadband</li></ul>',
                'card_type' => 'technical',
                'icon' => 'bi-gear',
                'is_active' => 1,
                'sort_order' => 4,
                'card_key' => 'system_requirements',
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
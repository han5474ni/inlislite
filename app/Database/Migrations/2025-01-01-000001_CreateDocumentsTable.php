<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'file_size' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'file_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'version' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'download_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('file_type');
        $this->forge->addKey('status');
        $this->forge->addKey('created_at');
        
        $this->forge->createTable('documents');
        
        // Insert sample data
        $data = [
            [
                'title' => 'Panduan Pengguna Revisi 16062016 – Modul Lengkap',
                'description' => 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3',
                'file_name' => 'panduan_lengkap_v3.2.1.pdf',
                'file_path' => 'uploads/documents/panduan_lengkap_v3.2.1.pdf',
                'file_size' => 12582912,
                'file_type' => 'PDF',
                'version' => 'V3.2.1',
                'download_count' => 0,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Pengaturan Administrasi di INLISLite v3',
                'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
                'file_name' => 'panduan_admin_v3.2.0.pdf',
                'file_path' => 'uploads/documents/panduan_admin_v3.2.0.pdf',
                'file_size' => 1887436,
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'download_count' => 0,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3',
                'description' => 'Panduan untuk mengelola koleksi bahan pustaka secara efektif',
                'file_name' => 'panduan_bahan_pustaka_v3.2.0.pdf',
                'file_path' => 'uploads/documents/panduan_bahan_pustaka_v3.2.0.pdf',
                'file_size' => 1887436,
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'download_count' => 0,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Manajemen Keanggotaan di INLISLite v3',
                'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
                'file_name' => 'panduan_keanggotaan_v3.2.0.pdf',
                'file_path' => 'uploads/documents/panduan_keanggotaan_v3.2.0.pdf',
                'file_size' => 1782579,
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'download_count' => 0,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Sistem Sirkulasi di INLISLite v3',
                'description' => 'Panduan untuk mengelola peminjaman dan pengembalian buku',
                'file_name' => 'panduan_sirkulasi_v3.2.0.pdf',
                'file_path' => 'uploads/documents/panduan_sirkulasi_v3.2.0.pdf',
                'file_size' => 1782579,
                'file_type' => 'PDF',
                'version' => 'V3.2.0',
                'download_count' => 0,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Panduan Praktis – Pembuatan Survei di INLISLite v3',
                'description' => 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan',
                'file_name' => 'panduan_survei_v3.1.5.pdf',
                'file_path' => 'uploads/documents/panduan_survei_v3.1.5.pdf',
                'file_size' => 1468006,
                'file_type' => 'PDF',
                'version' => 'V3.1.5',
                'download_count' => 0,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('documents')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('documents');
    }
}

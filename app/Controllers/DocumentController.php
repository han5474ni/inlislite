<?php

namespace App\Controllers;

class DocumentController extends BaseController
{
    public function index(): string
    {
        $stats = ['total' => 0];
        $documents = [];
        
        try {
            $documentModel = new \App\Models\DocumentModel();
            $stats = $documentModel->getTotalStats();
            $documents = $documentModel->orderBy('created_at', 'DESC')->findAll();
        } catch (\Exception $e) {
            // Table doesn't exist yet, use default values
            $stats = ['total' => 0];
            $documents = [];
        }
        
        $data = [
            'title' => 'Panduan - INLISLite v3.0',
            'page_title' => 'Panduan Penggunaan INLISLite Versi 3 PHP Opensource',
            'page_subtitle' => 'Dokumentasi resmi dan panduan praktis untuk membantu Anda menggunakan semua fitur sistem manajemen perpustakaan INLISLite v3 secara efektif.',
            'stats' => $stats,
            'documents' => $documents
        ];
        
        return view('panduan', $data);
    }

    public function getDocuments(): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            $documents = $documentModel->orderBy('created_at', 'DESC')->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'documents' => $documents
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'documents' => []
            ]);
        }
    }

    public function getDocument($id): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            $document = $documentModel->find($id);
            
            if ($document) {
                return $this->response->setJSON([
                    'success' => true,
                    'document' => $document
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function addDocument(): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'file_size' => $this->request->getPost('file_size'),
                'version' => $this->request->getPost('version'),
                'file_type' => 'PDF', // Default type
                'is_active' => 1
            ];
            
            $result = $documentModel->insert($data);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dokumen berhasil ditambahkan!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan dokumen'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateDocument($id): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'file_size' => $this->request->getPost('file_size'),
                'version' => $this->request->getPost('version')
            ];
            
            $result = $documentModel->update($id, $data);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dokumen berhasil diupdate!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate dokumen'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteDocument($id): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            $result = $documentModel->delete($id);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dokumen berhasil dihapus!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus dokumen'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadDocument($id): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            $document = $documentModel->find($id);
            
            if ($document) {
                // In a real application, this would serve the actual file
                // For demo purposes, we'll just return document info
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Download started for: ' . $document['title'],
                    'document' => $document
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Dokumen tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function searchDocuments(): string
    {
        try {
            $documentModel = new \App\Models\DocumentModel();
            $query = $this->request->getPost('query');
            
            if (empty($query)) {
                $documents = $documentModel->orderBy('created_at', 'DESC')->findAll();
            } else {
                $documents = $documentModel
                    ->like('title', $query)
                    ->orLike('description', $query)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
            }
            
            return $this->response->setJSON([
                'success' => true,
                'documents' => $documents
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'documents' => []
            ]);
        }
    }

    public function setupDatabase(): string
    {
        try {
            $forge = \Config\Database::forge();
            
            // Create documents table
            $fields = [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'file_size' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'version' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'file_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => 'PDF',
                ],
                'is_active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ];
            
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('documents');
            
            // Insert sample data
            $documentModel = new \App\Models\DocumentModel();
            $sampleDocuments = [
                [
                    'title' => 'Panduan Penggunaan Dasar INLISLite v3',
                    'description' => 'Panduan komprehensif untuk menggunakan fitur-fitur dasar INLISLite v3',
                    'file_size' => '12 MB',
                    'version' => '3.2.0',
                    'file_type' => 'PDF',
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'title' => 'Panduan Praktis - Katalogisasi di INLISLite v3',
                    'description' => 'Panduan langkah demi langkah untuk melakukan katalogisasi buku dan materi perpustakaan',
                    'file_size' => '18 MB',
                    'version' => '3.2.1',
                    'file_type' => 'PDF',
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'title' => 'Panduan Praktis - Sirkulasi di INLISLite v3',
                    'description' => 'Panduan lengkap untuk mengelola sistem sirkulasi peminjaman dan pengembalian',
                    'file_size' => '15 MB',
                    'version' => '3.2.1',
                    'file_type' => 'PDF',
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'title' => 'Panduan Praktis - Manajemen Keanggotaan di INLISLite v3',
                    'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
                    'file_size' => '17 MB',
                    'version' => '3.2.0',
                    'file_type' => 'PDF',
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];
            
            foreach ($sampleDocuments as $document) {
                $documentModel->insert($document);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Database dan data contoh berhasil dibuat!'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class DocumentController extends Controller
{
    protected $documentModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
    }

    public function index()
    {
        try {
            // Check if table exists, if not create it
            if (!$this->checkTableExists()) {
                $this->createDocumentsTable();
            }
            
            $data = [
                'title' => 'Panduan - INLISLite v3',
                'page_title' => 'Panduan',
                'page_subtitle' => 'Paket unduhan dan instalasi',
                'documents' => $this->documentModel->getActiveDocuments(),
                'document_count' => $this->documentModel->getDocumentCount()
            ];
            
        } catch (\Exception $e) {
            // Fallback data if table doesn't exist
            $data = [
                'title' => 'Panduan - INLISLite v3',
                'page_title' => 'Panduan',
                'page_subtitle' => 'Paket unduhan dan instalasi',
                'documents' => [],
                'document_count' => 0,
                'setup_required' => true,
                'error_message' => 'Database table belum dibuat. Silakan jalankan setup database.'
            ];
        }
        
        return view('panduan', $data);
    }
    
    /**
     * Check if documents table exists
     */
    private function checkTableExists()
    {
        $db = \Config\Database::connect();
        return $db->tableExists('documents');
    }
    
    /**
     * Create documents table with sample data
     */
    private function createDocumentsTable()
    {
        $db = \Config\Database::connect();
        
        // Create table SQL
        $sql = "
        CREATE TABLE `documents` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `description` text,
          `file_name` varchar(255) NOT NULL,
          `file_path` varchar(500) NOT NULL,
          `file_size` int(11) NOT NULL,
          `file_type` varchar(10) NOT NULL,
          `version` varchar(50) DEFAULT NULL,
          `download_count` int(11) DEFAULT 0,
          `status` enum('active','inactive') NOT NULL DEFAULT 'active',
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `idx_file_type` (`file_type`),
          KEY `idx_status` (`status`),
          KEY `idx_created_at` (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";
        
        $db->query($sql);
        
        // Insert sample data
        $insertSql = "
        INSERT INTO `documents` (`title`, `description`, `file_name`, `file_path`, `file_size`, `file_type`, `version`, `download_count`, `status`) VALUES
        ('Panduan Pengguna Revisi 16062016 – Modul Lengkap', 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3', 'panduan_lengkap_v3.2.1.pdf', 'uploads/documents/panduan_lengkap_v3.2.1.pdf', 12582912, 'PDF', 'V3.2.1', 0, 'active'),
        ('Panduan Praktis – Pengaturan Administrasi di INLISLite v3', 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif', 'panduan_admin_v3.2.0.pdf', 'uploads/documents/panduan_admin_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0', 0, 'active'),
        ('Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3', 'Panduan untuk mengelola koleksi bahan pustaka secara efektif', 'panduan_bahan_pustaka_v3.2.0.pdf', 'uploads/documents/panduan_bahan_pustaka_v3.2.0.pdf', 1887436, 'PDF', 'V3.2.0', 0, 'active'),
        ('Panduan Praktis – Manajemen Keanggotaan di INLISLite v3', 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan', 'panduan_keanggotaan_v3.2.0.pdf', 'uploads/documents/panduan_keanggotaan_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0', 0, 'active'),
        ('Panduan Praktis – Sistem Sirkulasi di INLISLite v3', 'Panduan untuk mengelola peminjaman dan pengembalian buku', 'panduan_sirkulasi_v3.2.0.pdf', 'uploads/documents/panduan_sirkulasi_v3.2.0.pdf', 1782579, 'PDF', 'V3.2.0', 0, 'active'),
        ('Panduan Praktis – Pembuatan Survei di INLISLite v3', 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan', 'panduan_survei_v3.1.5.pdf', 'uploads/documents/panduan_survei_v3.1.5.pdf', 1468006, 'PDF', 'V3.1.5', 0, 'active')
        ";
        
        $db->query($insertSql);
    }

    /**
     * Get all documents (AJAX)
     */
    public function getDocuments()
    {
        if ($this->request->isAJAX()) {
            try {
                $search = $this->request->getGet('search');
                $documents = $this->documentModel->searchDocuments($search);
                
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $documents,
                    'count' => count($documents)
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
        
        return redirect()->to('/panduan');
    }

    /**
     * Get single document (AJAX)
     */
    public function getDocument($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID dokumen tidak valid.'
                ]);
            }

            try {
                $document = $this->documentModel->getDocument($id);

                if (!$document) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Dokumen tidak ditemukan.'
                    ]);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'data' => $document
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return redirect()->to('/panduan');
    }

    /**
     * Add new document (AJAX)
     */
    public function addDocument()
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'permit_empty|max_length[1000]',
                'version' => 'permit_empty|max_length[50]',
                'file_type' => 'required|in_list[PDF,DOC,DOCX]',
                'document_file' => 'uploaded[document_file]|max_size[document_file,51200]|ext_in[document_file,pdf,doc,docx]'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            try {
                $file = $this->request->getFile('document_file');
                
                // Handle file upload
                $uploadResult = $this->documentModel->handleFileUpload($file);
                
                if (!$uploadResult['success']) {
                    return $this->response->setJSON($uploadResult);
                }

                // Prepare document data
                $data = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'file_name' => $uploadResult['file_name'],
                    'file_path' => $uploadResult['file_path'],
                    'file_size' => $file->getSize(),
                    'file_type' => $this->request->getPost('file_type'),
                    'version' => $this->request->getPost('version'),
                    'download_count' => 0,
                    'status' => 'active'
                ];

                // Save to database
                $result = $this->documentModel->createDocument($data);
                
                if ($result['success']) {
                    // Get the newly created document
                    $newDocument = $this->documentModel->find($result['id']);
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => $result['message'],
                        'data' => $newDocument
                    ]);
                } else {
                    return $this->response->setJSON($result);
                }

            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan dokumen: ' . $e->getMessage()
                ]);
            }
        }

        return redirect()->to('/panduan');
    }

    /**
     * Update document (AJAX)
     */
    public function updateDocument($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID dokumen tidak valid.'
                ]);
            }

            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'permit_empty|max_length[1000]',
                'version' => 'permit_empty|max_length[50]',
                'file_type' => 'required|in_list[PDF,DOC,DOCX]'
            ];

            // Check if new file is uploaded
            $file = $this->request->getFile('document_file');
            if ($file && $file->isValid()) {
                $rules['document_file'] = 'max_size[document_file,51200]|ext_in[document_file,pdf,doc,docx]';
            }

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            try {
                // Get existing document
                $existingDocument = $this->documentModel->find($id);
                if (!$existingDocument) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Dokumen tidak ditemukan.'
                    ]);
                }

                // Prepare update data
                $data = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'file_type' => $this->request->getPost('file_type'),
                    'version' => $this->request->getPost('version')
                ];

                // Handle file upload if new file provided
                if ($file && $file->isValid()) {
                    $uploadResult = $this->documentModel->handleFileUpload($file);
                    
                    if ($uploadResult['success']) {
                        // Delete old file if exists
                        $oldFilePath = WRITEPATH . $existingDocument['file_path'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }

                        // Update file data
                        $data['file_name'] = $uploadResult['file_name'];
                        $data['file_path'] = $uploadResult['file_path'];
                        $data['file_size'] = $file->getSize();
                    } else {
                        return $this->response->setJSON($uploadResult);
                    }
                }

                // Update document
                $result = $this->documentModel->updateDocument($id, $data);
                
                if ($result['success']) {
                    // Get updated document
                    $updatedDocument = $this->documentModel->find($id);
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => $result['message'],
                        'data' => $updatedDocument
                    ]);
                } else {
                    return $this->response->setJSON($result);
                }

            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate dokumen: ' . $e->getMessage()
                ]);
            }
        }

        return redirect()->to('/panduan');
    }

    /**
     * Delete document (AJAX)
     */
    public function deleteDocument($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID dokumen tidak valid.'
                ]);
            }

            try {
                $document = $this->documentModel->find($id);
                if (!$document) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Dokumen tidak ditemukan.'
                    ]);
                }

                $result = $this->documentModel->deleteDocument($id);
                return $this->response->setJSON($result);

            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus dokumen: ' . $e->getMessage()
                ]);
            }
        }

        return redirect()->to('/panduan');
    }

    /**
     * Download document
     */
    public function downloadDocument($id = null)
    {
        if ($id === null) {
            // Redirect with error message instead of 404
            return redirect()->to('/panduan')->with('error', 'ID dokumen tidak valid.');
        }

        try {
            $document = $this->documentModel->find($id);
            
            if (!$document) {
                return redirect()->to('/panduan')->with('error', 'Dokumen tidak ditemukan.');
            }

            // Try different file path locations
            $possiblePaths = [
                WRITEPATH . $document['file_path'],
                WRITEPATH . 'uploads/documents/' . $document['file_name'],
                FCPATH . $document['file_path'],
                FCPATH . 'uploads/documents/' . $document['file_name']
            ];
            
            // For PDF files, also check for HTML version
            if ($document['file_type'] === 'PDF') {
                $htmlFileName = str_replace('.pdf', '.html', $document['file_name']);
                $possiblePaths[] = WRITEPATH . 'uploads/documents/' . $htmlFileName;
                $possiblePaths[] = FCPATH . 'uploads/documents/' . $htmlFileName;
            }
            
            $filePath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $filePath = $path;
                    break;
                }
            }
            
            if (!$filePath) {
                // Create a sample file if not exists for demo purposes
                $sampleFilePath = $this->createSampleFile($document);
                if ($sampleFilePath) {
                    $filePath = $sampleFilePath;
                } else {
                    return redirect()->to('/panduan')->with('error', 'File dokumen tidak ditemukan di server.');
                }
            }

            // Increment download count
            $this->documentModel->incrementDownloadCount($id);

            // Get original filename for download - use original name if available
            $downloadName = $document['file_name'];
            
            // Try to get original filename from database or use current filename
            if (strpos($downloadName, '_') !== false && is_numeric(substr($downloadName, strrpos($downloadName, '_') + 1, 10))) {
                // If filename has timestamp, try to reconstruct original name
                $parts = explode('_', $downloadName);
                if (count($parts) >= 2) {
                    array_pop($parts); // Remove timestamp part
                    $baseName = implode('_', $parts);
                    $extension = pathinfo($downloadName, PATHINFO_EXTENSION);
                    $downloadName = $baseName . '.' . $extension;
                }
            }
            
            // Determine content type based on file extension
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            
            if ($fileExtension === 'html') {
                // For HTML files, let them open in browser
                $this->response->setHeader('Content-Type', 'text/html');
                $this->response->setHeader('Content-Disposition', 'inline; filename="' . $downloadName . '"');
                return $this->response->setBody(file_get_contents($filePath));
            } else {
                // For other files, force download
                $this->response->setHeader('Content-Type', 'application/octet-stream');
                $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
                $this->response->setHeader('Content-Length', filesize($filePath));
                return $this->response->download($filePath, $downloadName);
            }

        } catch (\Exception $e) {
            log_message('error', 'Download error: ' . $e->getMessage());
            return redirect()->to('/panduan')->with('error', 'Terjadi kesalahan saat mengunduh file.');
        }
    }
    
    /**
     * Create sample file for demo purposes
     */
    private function createSampleFile($document)
    {
        try {
            $uploadDir = WRITEPATH . 'uploads/documents/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // For PDF files, create HTML file with .html extension for proper viewing
            if ($document['file_type'] === 'PDF') {
                $htmlFileName = str_replace('.pdf', '.html', $document['file_name']);
                $filePath = $uploadDir . $htmlFileName;
            } else {
                $filePath = $uploadDir . $document['file_name'];
            }
            
            // Create sample content based on file type
            $content = $this->generateSampleContent($document);
            
            if (file_put_contents($filePath, $content)) {
                return $filePath;
            }
            
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to create sample file: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Generate sample content for different file types
     */
    private function generateSampleContent($document)
    {
        $title = $document['title'];
        $description = $document['description'] ?? '';
        $version = $document['version'] ?? '';
        $date = date('d F Y');
        
        if ($document['file_type'] === 'PDF') {
            // Create HTML content that can be printed as PDF
            $content = "Deskripsi:\n{$description}\n\n" .
                      "--- KONTEN DOKUMEN PANDUAN ---\n\n" .
                      "Ini adalah file sample untuk demonstrasi download.\n" .
                      "Dalam implementasi nyata, file ini akan berisi panduan lengkap\n" .
                      "untuk penggunaan sistem INLISLite v3.\n\n" .
                      "File ini di-generate otomatis oleh sistem untuk keperluan demo.\n" .
                      "Timestamp: " . date('Y-m-d H:i:s') . "\n\n" .
                      "FITUR UTAMA SISTEM:\n" .
                      "- Manajemen koleksi digital\n" .
                      "- Sistem sirkulasi otomatis\n" .
                      "- Katalog online\n" .
                      "- Laporan statistik\n" .
                      "- User management\n" .
                      "- Document management\n\n" .
                      "CARA PENGGUNAAN:\n" .
                      "1. Login ke sistem dengan akun yang valid\n" .
                      "2. Navigasi ke menu yang diinginkan\n" .
                      "3. Ikuti panduan yang tersedia\n" .
                      "4. Hubungi administrator jika ada kendala\n\n" .
                      "Untuk informasi lebih lanjut, silakan hubungi administrator sistem.";
                      
            $metadata = [
                'version' => $version,
                'date' => $date
            ];
            
            // Generate HTML instead of PDF for better compatibility
            return \App\Libraries\SimplePDFGenerator::generateHTMLForPDF($title, $content, $metadata);
        } else {
            // For DOC/DOCX files - create RTF format for better compatibility
            return "{\\rtf1\\ansi\\deff0 {\\fonttbl {\\f0 Times New Roman;}}".
                   "\\f0\\fs24 {$title}\\par\\par " .
                   "Versi: {$version}\\par " .
                   "Tanggal: {$date}\\par\\par " .
                   "{$description}\\par\\par " .
                   "--- SAMPLE DOCUMENT ---\\par\\par " .
                   "This is a sample document file.\\par " .
                   "Generated at: " . date('Y-m-d H:i:s') . "\\par}";
        }
    }

    /**
     * Search documents (AJAX)
     */
    public function searchDocuments()
    {
        if ($this->request->isAJAX()) {
            try {
                $keyword = $this->request->getPost('keyword') ?? $this->request->getGet('keyword');
                
                if (empty($keyword)) {
                    $documents = $this->documentModel->getActiveDocuments();
                } else {
                    $documents = $this->documentModel->searchDocuments($keyword);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'data' => $documents,
                    'count' => count($documents)
                ]);

            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }

        return redirect()->to('/panduan');
    }

    /**
     * Setup database table (for auto-fix)
     */
    public function setupDatabase()
    {
        try {
            if (!$this->checkTableExists()) {
                $this->createDocumentsTable();
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Database table berhasil dibuat dengan sample data!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Database table sudah ada.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}

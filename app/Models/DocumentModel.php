<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table            = 'documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'description',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'version',
        'download_count',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'file_type' => 'required|in_list[PDF,DOC,DOCX]',
        'status' => 'in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul dokumen harus diisi.',
            'min_length' => 'Judul dokumen minimal 3 karakter.',
            'max_length' => 'Judul dokumen maksimal 255 karakter.'
        ],
        'file_type' => [
            'required' => 'Tipe file harus dipilih.',
            'in_list' => 'Tipe file harus PDF, DOC, atau DOCX.'
        ]
    ];

    // Callbacks
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        if (isset($data['data']['status']) && empty($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        return $data;
    }

    /**
     * Get all active documents
     */
    public function getActiveDocuments()
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get document by ID
     */
    public function getDocument($id)
    {
        return $this->where('id', $id)
                    ->where('status', 'active')
                    ->first();
    }

    /**
     * Search documents
     */
    public function searchDocuments($keyword)
    {
        return $this->where('status', 'active')
                    ->groupStart()
                        ->like('title', $keyword)
                        ->orLike('description', $keyword)
                        ->orLike('version', $keyword)
                    ->groupEnd()
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get document count
     */
    public function getDocumentCount()
    {
        return $this->where('status', 'active')->countAllResults();
    }

    /**
     * Create new document
     */
    public function createDocument($data)
    {
        try {
            $this->db->transStart();
            
            $result = $this->insert($data);
            
            $this->db->transComplete();
            
            if ($this->db->transStatus() === false) {
                return [
                    'success' => false,
                    'message' => 'Gagal menyimpan dokumen.'
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Dokumen berhasil disimpan.',
                'id' => $result
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update document
     */
    public function updateDocument($id, $data)
    {
        try {
            $this->db->transStart();
            
            $result = $this->update($id, $data);
            
            $this->db->transComplete();
            
            if ($this->db->transStatus() === false) {
                return [
                    'success' => false,
                    'message' => 'Gagal mengupdate dokumen.'
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Dokumen berhasil diupdate.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete document (soft delete)
     */
    public function deleteDocument($id)
    {
        try {
            $this->db->transStart();
            
            $result = $this->delete($id);
            
            $this->db->transComplete();
            
            if ($this->db->transStatus() === false) {
                return [
                    'success' => false,
                    'message' => 'Gagal menghapus dokumen.'
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Dokumen berhasil dihapus.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format file size for display
     */
    public function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount($id)
    {
        $document = $this->find($id);
        if ($document) {
            $currentCount = $document['download_count'] ?? 0;
            return $this->update($id, ['download_count' => $currentCount + 1]);
        }
        return false;
    }

    /**
     * Handle file upload
     */
    public function handleFileUpload($file)
    {
        if (!$file->isValid()) {
            return [
                'success' => false,
                'message' => 'File tidak valid.'
            ];
        }

        // Create upload directory if not exists
        $uploadPath = WRITEPATH . 'uploads/documents/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Keep original filename with timestamp to avoid conflicts
        $originalName = $file->getClientName();
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $fileName = $baseName . '_' . time() . '.' . $extension;
        
        try {
            // Move file to upload directory
            $file->move($uploadPath, $fileName);
            
            return [
                'success' => true,
                'file_name' => $fileName,
                'file_path' => 'uploads/documents/' . $fileName,
                'file_size' => $file->getSize(), // Return actual size in bytes
                'original_name' => $originalName
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage()
            ];
        }
    }
}

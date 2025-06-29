<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title', 'description', 'file_size', 'version', 'file_type', 'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getTotalStats()
    {
        $query = $this->db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive
            FROM documents
        ");

        $result = $query->getRowArray();
        return $result ?: ['total' => 0, 'active' => 0, 'inactive' => 0];
    }

    public function searchDocuments($query)
    {
        return $this->like('title', $query)
                   ->orLike('description', $query)
                   ->where('is_active', 1)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getActiveDocuments()
    {
        return $this->where('is_active', 1)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getDocumentsByType($type)
    {
        return $this->where('file_type', $type)
                   ->where('is_active', 1)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function toggleStatus($id)
    {
        $document = $this->find($id);
        if ($document) {
            $newStatus = $document['is_active'] ? 0 : 1;
            return $this->update($id, ['is_active' => $newStatus]);
        }
        return false;
    }
}

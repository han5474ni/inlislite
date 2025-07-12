<?php

namespace App\Models;

use CodeIgniter\Model;

class BimbinganModel extends Model
{
    protected $table = 'bimbingan_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'description',
        'duration',
        'participants',
        'price',
        'topics',
        'status',
        'sort_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul bimbingan harus diisi',
            'max_length' => 'Judul bimbingan terlalu panjang'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['beforeInsert'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['beforeUpdate'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get all active training programs ordered by sort_order
     */
    public function getActivePrograms()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Update sort order
     */
    public function updateSortOrder($programId, $sortOrder)
    {
        return $this->update($programId, ['sort_order' => $sortOrder]);
    }

    /**
     * Get next sort order
     */
    public function getNextSortOrder()
    {
        $result = $this->selectMax('sort_order')->first();
        return ($result['sort_order'] ?? 0) + 1;
    }

    /**
     * Before insert callback
     */
    protected function beforeInsert(array $data)
    {
        $data = $this->setDefaultValues($data);
        return $data;
    }

    /**
     * Before update callback
     */
    protected function beforeUpdate(array $data)
    {
        return $data;
    }

    /**
     * Set default values
     */
    private function setDefaultValues(array $data)
    {
        if (!isset($data['data']['sort_order'])) {
            $data['data']['sort_order'] = $this->getNextSortOrder();
        }

        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }

        return $data;
    }
}
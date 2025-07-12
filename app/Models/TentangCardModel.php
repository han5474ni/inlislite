<?php

namespace App\Models;

use CodeIgniter\Model;

class TentangCardModel extends Model
{
    protected $table = 'tentang_cards';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'card_key',
        'title',
        'subtitle',
        'description',
        'content',
        'icon',
        'color_class',
        'background_color',
        'image_url',
        'link_url',
        'link_text',
        'card_type',
        'card_size',
        'is_active',
        'is_featured',
        'sort_order',
        'statistics',
        'features',
        'metadata'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'content' => 'required',
        'card_type' => 'permit_empty|in_list[info,feature,contact,technical]',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul kartu harus diisi',
            'max_length' => 'Judul kartu terlalu panjang'
        ],
        'content' => [
            'required' => 'Konten kartu harus diisi'
        ],
        'card_type' => [
            'in_list' => 'Tipe kartu tidak valid'
        ],
        'is_active' => [
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
     * Get all active cards ordered by sort_order
     */
    public function getActiveCards()
    {
        return $this->where('is_active', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get cards by category
     */
    public function getCardsByCategory($category)
    {
        return $this->where('card_type', $category)
                   ->where('is_active', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Update sort order
     */
    public function updateSortOrder($cardId, $sortOrder)
    {
        return $this->update($cardId, ['sort_order' => $sortOrder]);
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

        if (!isset($data['data']['is_active'])) {
            $data['data']['is_active'] = 1;
        }

        if (!isset($data['data']['card_type'])) {
            $data['data']['card_type'] = 'info';
        }

        if (!isset($data['data']['card_size'])) {
            $data['data']['card_size'] = 'medium';
        }

        if (!isset($data['data']['is_featured'])) {
            $data['data']['is_featured'] = 0;
        }

        return $data;
    }
}
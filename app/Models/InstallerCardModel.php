<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallerCardModel extends Model
{
    protected $table = 'installer_cards';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'package_name',
        'version',
        'release_date',
        'file_size',
        'download_link',
        'description',
        'requirements',
        'default_username',
        'default_password',
        'card_type',
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
        'package_name' => 'required|max_length[255]',
        'version' => 'required|max_length[50]',
        'card_type' => 'required|in_list[source,installer,database,documentation]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'package_name' => [
            'required' => 'Nama paket harus diisi',
            'max_length' => 'Nama paket terlalu panjang'
        ],
        'version' => [
            'required' => 'Versi harus diisi',
            'max_length' => 'Versi terlalu panjang'
        ],
        'card_type' => [
            'required' => 'Tipe kartu harus dipilih',
            'in_list' => 'Tipe kartu tidak valid'
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
     * Get all active cards ordered by sort_order
     */
    public function getActiveCards()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get cards by type
     */
    public function getCardsByType($type)
    {
        return $this->where('card_type', $type)
                   ->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Get card with requirements parsed
     */
    public function getCardWithRequirements($id)
    {
        $card = $this->find($id);
        if ($card && !empty($card['requirements'])) {
            $card['requirements_array'] = json_decode($card['requirements'], true) ?: [];
        } else {
            $card['requirements_array'] = [];
        }
        return $card;
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

        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }

        if (!isset($data['data']['card_type'])) {
            $data['data']['card_type'] = 'source';
        }

        return $data;
    }
}
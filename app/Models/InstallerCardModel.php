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
        'nama_paket',
        'deskripsi',
        'versi',
        'ukuran',
        'tipe',
        'url_download',
        'icon',
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
        'nama_paket' => 'required|max_length[255]',
        'tipe' => 'required|in_list[installer,source,database,documentation]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'nama_paket' => [
            'required' => 'Nama paket harus diisi',
            'max_length' => 'Nama paket terlalu panjang'
        ],
        'tipe' => [
            'required' => 'Tipe paket harus dipilih',
            'in_list' => 'Tipe paket tidak valid'
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
     * Get all active installer cards ordered by sort_order
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
        return $this->where('tipe', $type)
                   ->where('status', 'active')
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

        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }

        if (!isset($data['data']['tipe'])) {
            $data['data']['tipe'] = 'installer';
        }

        return $data;
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class AplikasiModel extends Model
{
    protected $table = 'aplikasi_pendukung';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_aplikasi',
        'deskripsi',
        'versi',
        'platform',
        'ukuran',
        'kategori',
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
        'nama_aplikasi' => 'required|max_length[255]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'nama_aplikasi' => [
            'required' => 'Nama aplikasi harus diisi',
            'max_length' => 'Nama aplikasi terlalu panjang'
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
     * Get all active applications ordered by sort_order
     */
    public function getActiveApplications()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get applications by category
     */
    public function getApplicationsByCategory($category)
    {
        return $this->where('kategori', $category)
                   ->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Get applications by platform
     */
    public function getApplicationsByPlatform($platform)
    {
        return $this->where('platform', $platform)
                   ->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->findAll();
    }

    /**
     * Update sort order
     */
    public function updateSortOrder($appId, $sortOrder)
    {
        return $this->update($appId, ['sort_order' => $sortOrder]);
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
<?php

namespace App\Models;

use CodeIgniter\Model;

class PatchModel extends Model
{
    protected $table = 'patches';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_patch',
        'versi',
        'deskripsi',
        'ukuran',
        'prioritas',
        'tanggal_rilis',
        'url_download',
        'status',
        'jumlah_unduhan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_patch' => 'required|max_length[255]',
        'versi' => 'required|max_length[50]',
        'prioritas' => 'required|in_list[low,medium,high,critical]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'nama_patch' => [
            'required' => 'Nama patch harus diisi',
            'max_length' => 'Nama patch terlalu panjang'
        ],
        'versi' => [
            'required' => 'Versi harus diisi',
            'max_length' => 'Versi terlalu panjang'
        ],
        'prioritas' => [
            'required' => 'Prioritas harus dipilih',
            'in_list' => 'Prioritas tidak valid'
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
     * Get all active patches ordered by release date
     */
    public function getActivePatches()
    {
        return $this->where('status', 'active')
                   ->orderBy('tanggal_rilis', 'DESC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get patches by priority
     */
    public function getPatchesByPriority($priority)
    {
        return $this->where('prioritas', $priority)
                   ->where('status', 'active')
                   ->orderBy('tanggal_rilis', 'DESC')
                   ->findAll();
    }

    /**
     * Increment download count
     */
    public function incrementDownload($patchId)
    {
        $patch = $this->find($patchId);
        if ($patch) {
            $newCount = ($patch['jumlah_unduhan'] ?? 0) + 1;
            return $this->update($patchId, ['jumlah_unduhan' => $newCount]);
        }
        return false;
    }

    /**
     * Get download statistics
     */
    public function getDownloadStats()
    {
        return [
            'total_patches' => $this->where('status', 'active')->countAllResults(),
            'total_downloads' => $this->selectSum('jumlah_unduhan')->first()['jumlah_unduhan'] ?? 0,
            'critical_patches' => $this->where(['status' => 'active', 'prioritas' => 'critical'])->countAllResults(),
            'latest_patch' => $this->where('status', 'active')->orderBy('tanggal_rilis', 'DESC')->first()
        ];
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
        if (!isset($data['data']['status'])) {
            $data['data']['status'] = 'active';
        }

        if (!isset($data['data']['prioritas'])) {
            $data['data']['prioritas'] = 'medium';
        }

        if (!isset($data['data']['jumlah_unduhan'])) {
            $data['data']['jumlah_unduhan'] = 0;
        }

        if (!isset($data['data']['tanggal_rilis'])) {
            $data['data']['tanggal_rilis'] = date('Y-m-d');
        }

        return $data;
    }
}
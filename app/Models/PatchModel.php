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
        'nama_paket',
        'versi',
        'prioritas',
        'tanggal_rilis',
        'ukuran',
        'jumlah_unduhan',
        'deskripsi',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_paket' => 'required|min_length[3]|max_length[255]',
        'versi' => 'required|min_length[1]|max_length[50]',
        'prioritas' => 'required|in_list[High,Medium,Low]',
        'tanggal_rilis' => 'required|valid_date[Y-m-d]',
        'ukuran' => 'required|min_length[1]|max_length[50]',
        'deskripsi' => 'required|min_length[10]|max_length[1000]',
        'jumlah_unduhan' => 'permit_empty|is_natural'
    ];

    protected $validationMessages = [
        'nama_paket' => [
            'required' => 'Nama paket harus diisi.',
            'min_length' => 'Nama paket minimal 3 karakter.',
            'max_length' => 'Nama paket maksimal 255 karakter.'
        ],
        'versi' => [
            'required' => 'Versi harus diisi.',
            'min_length' => 'Versi minimal 1 karakter.',
            'max_length' => 'Versi maksimal 50 karakter.'
        ],
        'prioritas' => [
            'required' => 'Prioritas harus dipilih.',
            'in_list' => 'Prioritas harus High, Medium, atau Low.'
        ],
        'tanggal_rilis' => [
            'required' => 'Tanggal rilis harus diisi.',
            'valid_date' => 'Format tanggal tidak valid.'
        ],
        'ukuran' => [
            'required' => 'Ukuran file harus diisi.',
            'min_length' => 'Ukuran file minimal 1 karakter.',
            'max_length' => 'Ukuran file maksimal 50 karakter.'
        ],
        'deskripsi' => [
            'required' => 'Deskripsi harus diisi.',
            'min_length' => 'Deskripsi minimal 10 karakter.',
            'max_length' => 'Deskripsi maksimal 1000 karakter.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert = ['setDefaults'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get patches with optional filters
     */
    public function getPatches(array $filters = []): array
    {
        $builder = $this->builder();

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                    ->like('nama_paket', $search)
                    ->orLike('deskripsi', $search)
                    ->orLike('versi', $search)
                    ->groupEnd();
        }

        // Apply priority filter
        if (!empty($filters['priority'])) {
            $builder->where('prioritas', $filters['priority']);
        }

        return $builder->orderBy('created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get patch statistics
     */
    public function getStatistics(): array
    {
        return [
            'total_patches' => $this->countAll(),
            'high_priority' => $this->where('prioritas', 'High')->countAllResults(false),
            'medium_priority' => $this->where('prioritas', 'Medium')->countAllResults(false),
            'low_priority' => $this->where('prioritas', 'Low')->countAllResults(false),
            'total_downloads' => $this->selectSum('jumlah_unduhan')->get()->getRow()->jumlah_unduhan ?? 0
        ];
    }

    /**
     * Set default values before insert
     */
    protected function setDefaults(array $data): array
    {
        if (!isset($data['data']['jumlah_unduhan'])) {
            $data['data']['jumlah_unduhan'] = 0;
        }

        return $data;
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount(int $id): bool
    {
        return $this->where('id', $id)
                   ->set('jumlah_unduhan', 'jumlah_unduhan + 1', false)
                   ->update();
    }

    /**
     * Get most downloaded patches
     */
    public function getMostDownloaded(int $limit = 10): array
    {
        return $this->orderBy('jumlah_unduhan', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get recent patches
     */
    public function getRecent(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }
}
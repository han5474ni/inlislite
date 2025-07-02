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
        'version',
        'title',
        'description',
        'changelog',
        'file_path',
        'file_size',
        'release_date',
        'is_critical',
        'downloads',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'version' => 'required|is_unique[patches.version,id,{id}]',
        'title' => 'required|min_length[5]|max_length[255]',
        'description' => 'required|min_length[10]',
        'release_date' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'version' => [
            'required' => 'Versi patch harus diisi',
            'is_unique' => 'Versi patch sudah ada'
        ],
        'title' => [
            'required' => 'Judul patch harus diisi',
            'min_length' => 'Judul patch minimal 5 karakter',
            'max_length' => 'Judul patch maksimal 255 karakter'
        ],
        'description' => [
            'required' => 'Deskripsi patch harus diisi',
            'min_length' => 'Deskripsi patch minimal 10 karakter'
        ],
        'release_date' => [
            'required' => 'Tanggal rilis harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Get active patches
     */
    public function getActivePatches()
    {
        return $this->where('is_active', 1)
                   ->orderBy('release_date', 'DESC')
                   ->findAll();
    }

    /**
     * Get critical patches
     */
    public function getCriticalPatches()
    {
        return $this->where('is_critical', 1)
                   ->where('is_active', 1)
                   ->orderBy('release_date', 'DESC')
                   ->findAll();
    }

    /**
     * Get latest patch
     */
    public function getLatestPatch()
    {
        return $this->where('is_active', 1)
                   ->orderBy('release_date', 'DESC')
                   ->first();
    }

    /**
     * Increment download counter
     */
    public function incrementDownload($id)
    {
        $patch = $this->find($id);
        if ($patch) {
            return $this->update($id, ['downloads' => $patch['downloads'] + 1]);
        }
        return false;
    }

    /**
     * Get patch statistics
     */
    public function getStats()
    {
        $total = $this->countAll();
        $active = $this->where('is_active', 1)->countAllResults();
        $critical = $this->where('is_critical', 1)->where('is_active', 1)->countAllResults();
        $totalDownloads = $this->selectSum('downloads')->first()['downloads'] ?? 0;

        return [
            'total' => $total,
            'active' => $active,
            'critical' => $critical,
            'total_downloads' => $totalDownloads
        ];
    }

    /**
     * Search patches
     */
    public function searchPatches($keyword)
    {
        return $this->like('title', $keyword)
                   ->orLike('description', $keyword)
                   ->orLike('version', $keyword)
                   ->where('is_active', 1)
                   ->orderBy('release_date', 'DESC')
                   ->findAll();
    }

    /**
     * Get patches by date range
     */
    public function getPatchesByDateRange($startDate, $endDate)
    {
        return $this->where('release_date >=', $startDate)
                   ->where('release_date <=', $endDate)
                   ->where('is_active', 1)
                   ->orderBy('release_date', 'DESC')
                   ->findAll();
    }

    // Legacy methods for backward compatibility
    public function getPatches(array $filters = []): array
    {
        $builder = $this->builder();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('description', $search)
                    ->orLike('version', $search)
                    ->groupEnd();
        }

        if (!empty($filters['priority'])) {
            $builder->where('is_critical', $filters['priority'] === 'High' ? 1 : 0);
        }

        return $builder->orderBy('created_at', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    public function getStatistics(): array
    {
        return [
            'total_patches' => $this->countAll(),
            'high_priority' => $this->where('is_critical', 1)->countAllResults(false),
            'medium_priority' => $this->where('is_critical', 0)->where('is_active', 1)->countAllResults(false),
            'low_priority' => $this->where('is_active', 0)->countAllResults(false),
            'total_downloads' => $this->selectSum('downloads')->get()->getRow()->downloads ?? 0
        ];
    }

    public function incrementDownloadCount(int $id): bool
    {
        return $this->incrementDownload($id);
    }

    public function getMostDownloaded(int $limit = 10): array
    {
        return $this->orderBy('downloads', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getRecent(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'slug',
        'description',
        'version',
        'file_size',
        'file_path',
        'icon',
        'color',
        'category',
        'downloads',
        'is_active',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|alpha_dash|is_unique[applications.slug,id,{id}]',
        'description' => 'required|min_length[10]',
        'version' => 'required',
        'category' => 'required|in_list[gateway,utility,service,plugin]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama aplikasi harus diisi',
            'min_length' => 'Nama aplikasi minimal 3 karakter',
            'max_length' => 'Nama aplikasi maksimal 255 karakter'
        ],
        'slug' => [
            'required' => 'Slug harus diisi',
            'alpha_dash' => 'Slug hanya boleh berisi huruf, angka, dash, dan underscore',
            'is_unique' => 'Slug sudah digunakan'
        ],
        'description' => [
            'required' => 'Deskripsi harus diisi',
            'min_length' => 'Deskripsi minimal 10 karakter'
        ],
        'version' => [
            'required' => 'Versi harus diisi'
        ],
        'category' => [
            'required' => 'Kategori harus dipilih',
            'in_list' => 'Kategori tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    /**
     * Generate slug from name
     */
    protected function generateSlug(array $data)
    {
        if (isset($data['data']['name']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['name'], '-', true);
        }
        return $data;
    }

    /**
     * Get active applications
     */
    public function getActiveApplications()
    {
        return $this->where('is_active', 1)->orderBy('downloads', 'DESC')->findAll();
    }

    /**
     * Get applications by category
     */
    public function getByCategory($category)
    {
        return $this->where('category', $category)
                   ->where('is_active', 1)
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    /**
     * Get application by slug
     */
    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->where('is_active', 1)->first();
    }

    /**
     * Increment download counter
     */
    public function incrementDownload($id)
    {
        $app = $this->find($id);
        if ($app) {
            return $this->update($id, ['downloads' => $app['downloads'] + 1]);
        }
        return false;
    }

    /**
     * Get most downloaded applications
     */
    public function getMostDownloaded($limit = 5)
    {
        return $this->where('is_active', 1)
                   ->orderBy('downloads', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get application statistics
     */
    public function getStats()
    {
        $total = $this->where('is_active', 1)->countAllResults();
        $totalDownloads = $this->selectSum('downloads')->where('is_active', 1)->first()['downloads'] ?? 0;
        
        $categories = $this->select('category, COUNT(*) as count')
                          ->where('is_active', 1)
                          ->groupBy('category')
                          ->findAll();

        return [
            'total_applications' => $total,
            'total_downloads' => $totalDownloads,
            'categories' => $categories
        ];
    }

    /**
     * Search applications
     */
    public function searchApplications($keyword)
    {
        return $this->like('name', $keyword)
                   ->orLike('description', $keyword)
                   ->where('is_active', 1)
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class FiturModel extends Model
{
    protected $table = 'fitur';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'description',
        'icon',
        'color',
        'type',
        'module_type',
        'status',
        'sort_order',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[10]',
        'icon' => 'required|max_length[100]',
        'color' => 'required|in_list[blue,green,orange,purple]',
        'type' => 'required|in_list[feature,module]',
        'module_type' => 'permit_empty|in_list[application,database,utility]',
        'status' => 'permit_empty|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul harus diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'description' => [
            'required' => 'Deskripsi harus diisi',
            'min_length' => 'Deskripsi minimal 10 karakter'
        ],
        'icon' => [
            'required' => 'Icon harus diisi',
            'max_length' => 'Icon maksimal 100 karakter'
        ],
        'color' => [
            'required' => 'Warna harus dipilih',
            'in_list' => 'Warna tidak valid'
        ],
        'type' => [
            'required' => 'Tipe harus dipilih',
            'in_list' => 'Tipe tidak valid'
        ],
        'module_type' => [
            'in_list' => 'Tipe modul tidak valid'
        ],
        'status' => [
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
    protected $afterFind = ['afterFind'];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get all features
     */
    public function getFeatures($status = 'active')
    {
        return $this->where('type', 'feature')
                   ->where('status', $status)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get all modules
     */
    public function getModules($status = 'active')
    {
        return $this->where('type', 'module')
                   ->where('status', $status)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get modules by type
     */
    public function getModulesByType($moduleType, $status = 'active')
    {
        return $this->where('type', 'module')
                   ->where('module_type', $moduleType)
                   ->where('status', $status)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Search features and modules
     */
    public function search($keyword, $type = null, $status = 'active')
    {
        $builder = $this->where('status', $status);
        
        if ($type) {
            $builder->where('type', $type);
        }
        
        $builder->groupStart()
                ->like('title', $keyword)
                ->orLike('description', $keyword)
                ->groupEnd();
        
        return $builder->orderBy('sort_order', 'ASC')
                      ->orderBy('created_at', 'DESC')
                      ->findAll();
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $stats = [];
        
        // Total features
        $stats['total_features'] = $this->where('type', 'feature')
                                       ->where('status', 'active')
                                       ->countAllResults();
        
        // Total modules
        $stats['total_modules'] = $this->where('type', 'module')
                                      ->where('status', 'active')
                                      ->countAllResults();
        
        // Application modules
        $stats['app_modules'] = $this->where('type', 'module')
                                    ->where('module_type', 'application')
                                    ->where('status', 'active')
                                    ->countAllResults();
        
        // Database modules
        $stats['db_modules'] = $this->where('type', 'module')
                                   ->where('module_type', 'database')
                                   ->where('status', 'active')
                                   ->countAllResults();
        
        // Utility modules
        $stats['utility_modules'] = $this->where('type', 'module')
                                        ->where('module_type', 'utility')
                                        ->where('status', 'active')
                                        ->countAllResults();
        
        return $stats;
    }

    /**
     * Get next sort order
     */
    public function getNextSortOrder($type)
    {
        $result = $this->where('type', $type)
                      ->selectMax('sort_order')
                      ->first();
        
        return ($result['sort_order'] ?? 0) + 1;
    }

    /**
     * Update sort orders
     */
    public function updateSortOrders($items)
    {
        $this->db->transStart();
        
        foreach ($items as $index => $item) {
            $this->update($item['id'], [
                'sort_order' => $index + 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $this->db->transComplete();
        
        return $this->db->transStatus();
    }

    /**
     * Before insert callback
     */
    protected function beforeInsert(array $data)
    {
        $data = $this->setTimestamps($data);
        $data = $this->formatIcon($data);
        $data = $this->setSortOrder($data);
        
        return $data;
    }

    /**
     * Before update callback
     */
    protected function beforeUpdate(array $data)
    {
        $data = $this->setTimestamps($data, 'update');
        $data = $this->formatIcon($data);
        
        return $data;
    }

    /**
     * After find callback
     */
    protected function afterFind($data)
    {
        // Debug logging - remove after fixing
        log_message('debug', 'FiturModel::afterFind called with data type: ' . gettype($data) . ', data: ' . json_encode($data));
        
        // Early return if data is empty, null, or not an array
        if (empty($data) || !is_array($data)) {
            log_message('debug', 'FiturModel::afterFind - early return for empty/non-array data (type: ' . gettype($data) . ')');
            return $data;
        }
        
        try {
            if (isset($data['data'])) {
                // Handle findAll() results - $data['data'] is array of items
                if (is_array($data['data'])) {
                    foreach ($data['data'] as &$item) {
                        if (is_array($item) && isset($item['id'])) {
                            $item = $this->formatItem($item);
                        } else {
                            log_message('debug', 'FiturModel::afterFind - skipping non-array item in data[data]: ' . json_encode($item));
                        }
                    }
                }
            } elseif (isset($data['id']) && is_array($data)) {
                // Handle find() results - $data is the item itself
                $data = $this->formatItem($data);
            } else {
                // Handle direct array results
                if (is_array($data) && !empty($data)) {
                    // Check if it's an array of items (multiple results)
                    if (isset($data[0]) && is_array($data[0])) {
                        foreach ($data as &$item) {
                            if (is_array($item) && isset($item['id'])) {
                                $item = $this->formatItem($item);
                            } else {
                                log_message('debug', 'FiturModel::afterFind - skipping non-array item in direct results: ' . json_encode($item));
                            }
                        }
                    } else {
                        // Single item result - ensure it has required fields before formatting
                        if (isset($data['id'])) {
                            $data = $this->formatItem($data);
                        } else {
                            log_message('debug', 'FiturModel::afterFind - skipping single item without id: ' . json_encode($data));
                        }
                    }
                }
            }
        } catch (Exception $e) {
            log_message('error', 'FiturModel::afterFind - Exception: ' . $e->getMessage() . ', data: ' . json_encode($data));
        }
        
        return $data;
    }

    /**
     * Set timestamps
     */
    private function setTimestamps(array $data, $type = 'insert')
    {
        $now = date('Y-m-d H:i:s');
        
        if ($type === 'insert') {
            $data['data']['created_at'] = $now;
        }
        
        $data['data']['updated_at'] = $now;
        
        return $data;
    }

    /**
     * Format icon to ensure bi- prefix
     */
    private function formatIcon(array $data)
    {
        if (isset($data['data']['icon']) && !str_starts_with($data['data']['icon'], 'bi-')) {
            $data['data']['icon'] = 'bi-' . $data['data']['icon'];
        }
        
        return $data;
    }

    /**
     * Set sort order if not provided
     */
    private function setSortOrder(array $data)
    {
        if (!isset($data['data']['sort_order']) && isset($data['data']['type'])) {
            $data['data']['sort_order'] = $this->getNextSortOrder($data['data']['type']);
        }
        
        return $data;
    }

    /**
     * Format item for display
     */
    private function formatItem(array $item)
    {
        // Format dates
        if (isset($item['created_at'])) {
            $item['created_at_formatted'] = date('d M Y H:i', strtotime($item['created_at']));
        }
        
        if (isset($item['updated_at'])) {
            $item['updated_at_formatted'] = date('d M Y H:i', strtotime($item['updated_at']));
        }
        
        // Add display labels
        if (isset($item['color'])) {
            $colorLabels = [
                'blue' => 'Biru',
                'green' => 'Hijau',
                'orange' => 'Orange',
                'purple' => 'Ungu'
            ];
            $item['color_label'] = $colorLabels[$item['color']] ?? $item['color'];
        }
        
        if (isset($item['type'])) {
            $typeLabels = [
                'feature' => 'Fitur',
                'module' => 'Modul'
            ];
            $item['type_label'] = $typeLabels[$item['type']] ?? $item['type'];
        }
        
        if (isset($item['module_type'])) {
            $moduleTypeLabels = [
                'application' => 'Application-based',
                'database' => 'Database/Backend',
                'utility' => 'Utility'
            ];
            $item['module_type_label'] = $moduleTypeLabels[$item['module_type']] ?? $item['module_type'];
        }
        
        if (isset($item['status'])) {
            $statusLabels = [
                'active' => 'Aktif',
                'inactive' => 'Tidak Aktif'
            ];
            $item['status_label'] = $statusLabels[$item['status']] ?? $item['status'];
        }
        
        return $item;
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class InstallerModel extends Model
{
    protected $table = 'installer_downloads';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'package_type',
        'filename',
        'file_size',
        'description',
        'download_date',
        'user_agent',
        'ip_address',
        'download_count',
        'session_id',
        'referrer'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'package_type' => 'required|in_list[source,php,sql]',
        'filename' => 'required|max_length[255]',
        'download_date' => 'required|valid_date',
        'ip_address' => 'permit_empty|valid_ip'
    ];

    protected $validationMessages = [
        'package_type' => [
            'required' => 'Package type is required',
            'in_list' => 'Invalid package type'
        ],
        'filename' => [
            'required' => 'Filename is required',
            'max_length' => 'Filename too long'
        ],
        'download_date' => [
            'required' => 'Download date is required',
            'valid_date' => 'Invalid date format'
        ],
        'ip_address' => [
            'valid_ip' => 'Invalid IP address format'
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
     * Record a download
     */
    public function recordDownload($data)
    {
        // Check if this IP has downloaded this package before
        $existing = $this->where([
            'ip_address' => $data['ip_address'],
            'package_type' => $data['package_type']
        ])->orderBy('download_date', 'DESC')->first();

        if ($existing) {
            // Update existing record
            $this->update($existing['id'], [
                'download_count' => $existing['download_count'] + 1,
                'download_date' => $data['download_date'],
                'user_agent' => $data['user_agent'],
                'session_id' => $data['session_id'] ?? null,
                'referrer' => $data['referrer'] ?? null
            ]);
            return $existing['id'];
        } else {
            // Insert new record
            return $this->insert($data);
        }
    }

    /**
     * Get download statistics
     */
    public function getDownloadStats($packageType = null)
    {
        $builder = $this->builder();
        
        if ($packageType) {
            $builder->where('package_type', $packageType);
        }

        $stats = $builder->select('package_type, SUM(download_count) as total_downloads, COUNT(DISTINCT ip_address) as unique_downloads')
                        ->groupBy('package_type')
                        ->get()
                        ->getResultArray();

        $result = [];
        foreach ($stats as $stat) {
            $result[$stat['package_type']] = [
                'total_downloads' => (int)$stat['total_downloads'],
                'unique_downloads' => (int)$stat['unique_downloads']
            ];
        }

        return $packageType ? ($result[$packageType] ?? ['total_downloads' => 0, 'unique_downloads' => 0]) : $result;
    }

    /**
     * Get recent downloads
     */
    public function getRecentDownloads($limit = 10)
    {
        return $this->orderBy('download_date', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get downloads by date range
     */
    public function getDownloadsByDateRange($startDate, $endDate, $packageType = null)
    {
        $builder = $this->builder();
        $builder->where('download_date >=', $startDate)
                ->where('download_date <=', $endDate);

        if ($packageType) {
            $builder->where('package_type', $packageType);
        }

        return $builder->orderBy('download_date', 'DESC')->findAll();
    }

    /**
     * Get top downloading IPs
     */
    public function getTopDownloadingIPs($limit = 10)
    {
        return $this->builder()
                   ->select('ip_address, SUM(download_count) as total_downloads, COUNT(*) as package_types')
                   ->groupBy('ip_address')
                   ->orderBy('total_downloads', 'DESC')
                   ->limit($limit)
                   ->get()
                   ->getResultArray();
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
        if (!isset($data['data']['download_date'])) {
            $data['data']['download_date'] = date('Y-m-d H:i:s');
        }

        if (!isset($data['data']['download_count'])) {
            $data['data']['download_count'] = 1;
        }

        return $data;
    }
}

/**
 * Installer Settings Model
 */
class InstallerSettingsModel extends Model
{
    protected $table = 'installer_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
        'is_editable'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'setting_key' => 'required|max_length[100]|is_unique[installer_settings.setting_key,id,{id}]',
        'setting_type' => 'required|in_list[string,integer,boolean,json,array]'
    ];

    protected $validationMessages = [
        'setting_key' => [
            'required' => 'Setting key is required',
            'max_length' => 'Setting key too long',
            'is_unique' => 'Setting key already exists'
        ],
        'setting_type' => [
            'required' => 'Setting type is required',
            'in_list' => 'Invalid setting type'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $this->parseSettingValue($setting['setting_value'], $setting['setting_type']);
    }

    /**
     * Set setting value
     */
    public function setSetting($key, $value, $type = 'string', $description = null)
    {
        $existing = $this->where('setting_key', $key)->first();
        
        $data = [
            'setting_key' => $key,
            'setting_value' => $this->formatSettingValue($value, $type),
            'setting_type' => $type,
            'description' => $description
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['is_editable'] = true;
            return $this->insert($data);
        }
    }

    /**
     * Get all settings as key-value pairs
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $this->parseSettingValue(
                $setting['setting_value'], 
                $setting['setting_type']
            );
        }

        return $result;
    }

    /**
     * Get editable settings
     */
    public function getEditableSettings()
    {
        return $this->where('is_editable', true)->findAll();
    }

    /**
     * Update download stats
     */
    public function updateDownloadStats($packageType)
    {
        $stats = $this->getSetting('download_stats', ['source' => 0, 'php' => 0, 'sql' => 0]);
        
        if (isset($stats[$packageType])) {
            $stats[$packageType]++;
            $this->setSetting('download_stats', $stats, 'json', 'Download statistics counter');
        }

        return $stats;
    }

    /**
     * Parse setting value based on type
     */
    private function parseSettingValue($value, $type)
    {
        switch ($type) {
            case 'integer':
                return (int)$value;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'json':
            case 'array':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Format setting value for storage
     */
    private function formatSettingValue($value, $type)
    {
        switch ($type) {
            case 'json':
            case 'array':
                return json_encode($value);
            case 'boolean':
                return $value ? '1' : '0';
            default:
                return (string)$value;
        }
    }
}
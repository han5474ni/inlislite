<?php

namespace App\Models\Traits;

trait ModelTrait
{
    /**
     * Set timestamps for insert/update operations
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
        if (!isset($data['data']['sort_order'])) {
            if (isset($data['data']['type']) && method_exists($this, 'getNextSortOrder')) {
                // For FiturModel with type parameter
                $data['data']['sort_order'] = $this->getNextSortOrder($data['data']['type']);
            } else {
                // For other models without type parameter
                $data['data']['sort_order'] = $this->getNextSortOrder();
            }
        }
        
        return $data;
    }

    /**
     * Update sort orders for multiple items
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
     * Reorder items after deletion
     */
    public function reorderAfterDeletion($deletedOrder)
    {
        $this->db->transStart();
        
        $items = $this->where('sort_order >', $deletedOrder)
                     ->orderBy('sort_order', 'ASC')
                     ->findAll();

        foreach ($items as $item) {
            $this->update($item['id'], [
                'sort_order' => $item['sort_order'] - 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $this->db->transComplete();
        
        return $this->db->transStatus();
    }

    /**
     * Fix sort order numbering (make sequential)
     */
    public function fixSortOrders()
    {
        $this->db->transStart();
        
        $items = $this->orderBy('sort_order', 'ASC')
                     ->orderBy('id', 'ASC')
                     ->findAll();

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
     * Format item for display with common labels
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
        
        if (isset($item['status'])) {
            $statusLabels = [
                'active' => 'Aktif',
                'inactive' => 'Tidak Aktif'
            ];
            $item['status_label'] = $statusLabels[$item['status']] ?? $item['status'];
        }
        
        // Handle type labels
        if (isset($item['type'])) {
            $typeLabels = [
                'feature' => 'Fitur',
                'module' => 'Modul'
            ];
            $item['type_label'] = $typeLabels[$item['type']] ?? $item['type'];
        }
        
        // Handle module type labels
        if (isset($item['module_type'])) {
            $moduleTypeLabels = [
                'application' => 'Application-based',
                'database' => 'Database/Backend',
                'utility' => 'Utility'
            ];
            $item['module_type_label'] = $moduleTypeLabels[$item['module_type']] ?? $item['module_type'];
        }
        
        return $item;
    }

    /**
     * Common afterFind callback logic
     */
    protected function processAfterFind($data)
    {
        if (empty($data) || !is_array($data)) {
            return $data;
        }

        try {
            if (isset($data['data'])) {
                // Handle findAll() results
                if (is_array($data['data'])) {
                    foreach ($data['data'] as &$item) {
                        if (is_array($item) && isset($item['id'])) {
                            $item = $this->formatItem($item);
                        }
                    }
                }
            } elseif (isset($data['id']) && is_array($data)) {
                // Handle find() results
                $data = $this->formatItem($data);
            } else {
                // Handle direct array results
                if (is_array($data) && !empty($data)) {
                    if (isset($data[0]) && is_array($data[0])) {
                        foreach ($data as &$item) {
                            if (is_array($item) && isset($item['id'])) {
                                $item = $this->formatItem($item);
                            }
                        }
                    } else {
                        if (isset($data['id'])) {
                            $data = $this->formatItem($data);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            log_message('error', get_class($this) . '::afterFind - Exception: ' . $e->getMessage());
        }
        
        return $data;
    }

    /**
     * Common search functionality
     */
    public function search($keyword, $status = 'active')
    {
        $builder = $this->where('status', $status);
        
        $builder->groupStart()
                ->like('title', $keyword)
                ->orLike('description', $keyword)
                ->groupEnd();
        
        return $builder->orderBy('sort_order', 'ASC')
                      ->orderBy('created_at', 'DESC')
                      ->findAll();
    }

    /**
     * Common validation rules
     */
    protected function getCommonValidationRules()
    {
        return [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'icon' => 'required|max_length[100]',
            'color' => 'required|in_list[blue,green,orange,purple]',
            'status' => 'permit_empty|in_list[active,inactive]'
        ];
    }

    /**
     * Common validation messages
     */
    protected function getCommonValidationMessages()
    {
        return [
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
            'status' => [
                'in_list' => 'Status tidak valid'
            ]
        ];
    }
}

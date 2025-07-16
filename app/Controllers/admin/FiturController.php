<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FeatureModel;
use App\Models\ModuleModel;
use App\Models\FiturModel;

class FiturController extends BaseController
{
    protected $featureModel;
    protected $moduleModel;
    protected $fiturModel; // Keep for backward compatibility
    protected $session;

    public function __construct()
    {
        $this->featureModel = new FeatureModel();
        $this->moduleModel = new ModuleModel();
        $this->fiturModel = new FiturModel(); // Keep for backward compatibility
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    /**
     * Display features and modules page
     */
    public function index()
    {
        $data = [
            'title' => 'Fitur dan Modul Program - INLISLite v3.0',
            'page_title' => 'Fitur dan Modul Program'
        ];

        return view('admin/fitur_new', $data);
    }

    /**
     * Display management page
     */
    public function edit()
    {
        $data = [
            'title' => 'Manajemen Fitur dan Modul - INLISLite v3.0',
            'page_title' => 'Manajemen Fitur dan Modul'
        ];

        return view('admin/fitur-edit', $data);
    }

    /**
     * Get all features and modules (API endpoint)
     */
    public function getData()
    {
        try {
            $type = $this->request->getGet('type'); // 'feature', 'module', or null for all
            $status = $this->request->getGet('status') ?? 'active';

            $data = [];
            
            if ($type === 'feature') {
                $data = $this->featureModel->getAll($status);
            } elseif ($type === 'module') {
                $data = $this->moduleModel->getAll($status);
            } else {
                // Return both features and modules if no type specified
                $features = $this->featureModel->getAll($status);
                $modules = $this->moduleModel->getAll($status);
                $data = array_merge($features, $modules);
                
                // Sort by sort_order
                usort($data, function($a, $b) {
                    return $a['sort_order'] - $b['sort_order'];
                });
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting fitur data: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Gagal mengambil data'
            ]);
        }
    }

    
    /**
     * Get statistics (API endpoint)
     */
    public function getStatistics()
    {
        try {
            $totalFeatures = $this->featureModel->where('status', 'active')
                                               ->countAllResults();

            $moduleStats = $this->moduleModel->getStatistics();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'total_features' => $totalFeatures,
                    'total_modules' => $moduleStats['total_modules'],
                    'app_modules' => $moduleStats['app_modules'],
                    'db_modules' => $moduleStats['db_modules']
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting statistics: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Gagal mengambil statistik'
            ]);
        }
    }

    /**
     * Create new feature or module (API endpoint)
     */
    public function store()
    {
        try {
            $type = $this->request->getPost('type');
            
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'icon' => 'required|max_length[100]',
                'color' => 'required|in_list[blue,green,orange,purple]',
                'type' => 'required|in_list[feature,module]'
            ];

            if ($type === 'module') {
                $rules['module_type'] = 'required|in_list[application,database,utility]';
            }

            if (!$this->validate($rules)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'icon' => $this->request->getPost('icon'),
                'color' => $this->request->getPost('color'),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Ensure icon has bi- prefix
            if (!str_starts_with($data['icon'], 'bi-')) {
                $data['icon'] = 'bi-' . $data['icon'];
            }

            $id = null;
            $newItem = null;

            if ($type === 'feature') {
                // Set sort order for feature
                $data['sort_order'] = $this->featureModel->getNextSortOrder();
                $id = $this->featureModel->insert($data);
                if ($id) {
                    $newItem = $this->featureModel->find($id);
                }
            } else {
                // Set sort order for module and module type
                $data['module_type'] = $this->request->getPost('module_type');
                $data['sort_order'] = $this->moduleModel->getNextSortOrder();
                $id = $this->moduleModel->insert($data);
                if ($id) {
                    $newItem = $this->moduleModel->find($id);
                }
            }

            if ($id && $newItem) {
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'create_' . $type,
                    "Created new {$type}: {$data['title']}"
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => ucfirst($type) . ' berhasil ditambahkan',
                    'data' => $newItem
                ]);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error creating fitur: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }

    /**
     * Update feature or module (API endpoint)
     */
    public function update($id)
    {
        try {
            // First try to find in features table
            $item = $this->featureModel->find($id);
            $isFeature = true;
            
            if (!$item) {
                // If not found in features, try modules table
                $item = $this->moduleModel->find($id);
                $isFeature = false;
            }
            
            if (!$item) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'icon' => 'required|max_length[100]',
                'color' => 'required|in_list[blue,green,orange,purple]'
            ];

            if (!$isFeature) {
                $rules['module_type'] = 'required|in_list[application,database,utility]';
            }

            if (!$this->validate($rules)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'icon' => $this->request->getPost('icon'),
                'color' => $this->request->getPost('color'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$isFeature) {
                $data['module_type'] = $this->request->getPost('module_type');
            }

            // Ensure icon has bi- prefix
            if (!str_starts_with($data['icon'], 'bi-')) {
                $data['icon'] = 'bi-' . $data['icon'];
            }

            $model = $isFeature ? $this->featureModel : $this->moduleModel;
            $type = $isFeature ? 'feature' : 'module';
            
            if ($model->update($id, $data)) {
                $updatedItem = $model->find($id);
                
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'update_' . $type,
                    "Updated {$type}: {$data['title']}"
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => ucfirst($type) . ' berhasil diperbarui',
                    'data' => $updatedItem
                ]);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui data'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating fitur: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }

    /**
     * Delete feature or module (API endpoint)
     */
    public function delete($id)
    {
        try {
            // First try to find in features table
            $item = $this->featureModel->find($id);
            $isFeature = true;
            
            if (!$item) {
                // If not found in features, try modules table
                $item = $this->moduleModel->find($id);
                $isFeature = false;
            }
            
            if (!$item) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $model = $isFeature ? $this->featureModel : $this->moduleModel;
            $type = $isFeature ? 'feature' : 'module';
            
            if ($model->delete($id)) {
                // Reorder sort_order after deletion using the appropriate model
                $model->reorderAfterDeletion($item['sort_order']);
                
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'delete_' . $type,
                    "Deleted {$type}: {$item['title']}"
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => ucfirst($type) . ' berhasil dihapus'
                ]);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus data'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error deleting fitur: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }

    /**
     * Update sort order (API endpoint)
     */
    public function updateSortOrder()
    {
        try {
            $items = $this->request->getPost('items');
            
            // Decode JSON string if it's a string
            if (is_string($items)) {
                $items = json_decode($items, true);
            }
            
            if (!$items || !is_array($items)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak valid'
                ]);
            }

            // Group items by type for separate processing
            $featureItems = [];
            $moduleItems = [];
            
            foreach ($items as $index => $item) {
                // Check if item exists in features table
                $featureItem = $this->featureModel->find($item['id']);
                if ($featureItem) {
                    $featureItems[] = ['id' => $item['id'], 'sort_order' => $index + 1];
                } else {
                    $moduleItems[] = ['id' => $item['id'], 'sort_order' => $index + 1];
                }
            }

            // Update features sort order
            if (!empty($featureItems)) {
                if (!$this->featureModel->updateSortOrders($featureItems)) {
                    return $this->response->setStatusCode(500)->setJSON([
                        'success' => false,
                        'message' => 'Gagal memperbarui urutan fitur'
                    ]);
                }
            }

            // Update modules sort order
            if (!empty($moduleItems)) {
                if (!$this->moduleModel->updateSortOrders($moduleItems)) {
                    return $this->response->setStatusCode(500)->setJSON([
                        'success' => false,
                        'message' => 'Gagal memperbarui urutan modul'
                    ]);
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error updating sort order: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ]);
        }
    }


    /**
     * Log user activity
     */
    private function logActivity($userId, $action, $description)
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('activity_logs');
            
            $builder->insert([
                'user_id' => $userId,
                'action' => $action,
                'description' => $description,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error logging activity: ' . $e->getMessage());
        }
    }
}
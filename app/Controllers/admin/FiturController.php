<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FiturModel;

class FiturController extends BaseController
{
    protected $fiturModel;
    protected $session;

    public function __construct()
    {
        $this->fiturModel = new FiturModel();
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

        return view('admin/fitur', $data);
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

            $builder = $this->fiturModel->where('status', $status);
            
            if ($type) {
                $builder->where('type', $type);
            }

            $data = $builder->orderBy('sort_order', 'ASC')
                           ->orderBy('created_at', 'DESC')
                           ->findAll();

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
            $totalFeatures = $this->fiturModel->where('type', 'feature')
                                             ->where('status', 'active')
                                             ->countAllResults();

            $totalModules = $this->fiturModel->where('type', 'module')
                                            ->where('status', 'active')
                                            ->countAllResults();

            $appModules = $this->fiturModel->where('type', 'module')
                                          ->where('module_type', 'application')
                                          ->where('status', 'active')
                                          ->countAllResults();

            $dbModules = $this->fiturModel->where('type', 'module')
                                         ->where('module_type', 'database')
                                         ->where('status', 'active')
                                         ->countAllResults();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'total_features' => $totalFeatures,
                    'total_modules' => $totalModules,
                    'app_modules' => $appModules,
                    'db_modules' => $dbModules
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
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'icon' => 'required|max_length[100]',
                'color' => 'required|in_list[blue,green,orange,purple]',
                'type' => 'required|in_list[feature,module]'
            ];

            if ($this->request->getPost('type') === 'module') {
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
                'type' => $this->request->getPost('type'),
                'module_type' => $this->request->getPost('module_type'),
                'status' => 'active',
                'sort_order' => $this->getNextSortOrder($this->request->getPost('type')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Ensure icon has bi- prefix
            if (!str_starts_with($data['icon'], 'bi-')) {
                $data['icon'] = 'bi-' . $data['icon'];
            }

            $id = $this->fiturModel->insert($data);

            if ($id) {
                $newItem = $this->fiturModel->find($id);
                
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'create_' . $data['type'],
                    "Created new {$data['type']}: {$data['title']}"
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => ucfirst($data['type']) . ' berhasil ditambahkan',
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
            $item = $this->fiturModel->find($id);
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

            if ($item['type'] === 'module') {
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

            if ($item['type'] === 'module') {
                $data['module_type'] = $this->request->getPost('module_type');
            }

            // Ensure icon has bi- prefix
            if (!str_starts_with($data['icon'], 'bi-')) {
                $data['icon'] = 'bi-' . $data['icon'];
            }

            if ($this->fiturModel->update($id, $data)) {
                $updatedItem = $this->fiturModel->find($id);
                
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'update_' . $item['type'],
                    "Updated {$item['type']}: {$data['title']}"
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => ucfirst($item['type']) . ' berhasil diperbarui',
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
            $item = $this->fiturModel->find($id);
            if (!$item) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            if ($this->fiturModel->delete($id)) {
                // Log activity
                $this->logActivity(
                    $this->session->get('admin_user_id'),
                    'delete_' . $item['type'],
                    "Deleted {$item['type']}: {$item['title']}"
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => ucfirst($item['type']) . ' berhasil dihapus'
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
            
            if (!$items || !is_array($items)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Data tidak valid'
                ]);
            }

            $this->fiturModel->db->transStart();

            foreach ($items as $index => $item) {
                $this->fiturModel->update($item['id'], [
                    'sort_order' => $index + 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->fiturModel->db->transComplete();

            if ($this->fiturModel->db->transStatus() === false) {
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui urutan'
                ]);
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
     * Get next sort order for a type
     */
    private function getNextSortOrder($type)
    {
        if (!$type) {
            return 1; // Default sort order if type is null
        }
        
        $maxOrder = $this->fiturModel->where('type', $type)
                                   ->selectMax('sort_order')
                                   ->first();
        
        return ($maxOrder['sort_order'] ?? 0) + 1;
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
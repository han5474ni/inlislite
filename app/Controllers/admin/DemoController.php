<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DemoModel;

class DemoController extends BaseController
{
    protected $demoModel;
    protected $session;
    
    public function __construct()
    {
        $this->demoModel = new DemoModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display demo management page
     */
    public function index()
    {
        $data = [
            'title' => 'Demo Program - INLISLite v3.0',
            'page_title' => 'Demo Program',
            'page_subtitle' => 'Kelola demo program perpustakaan'
        ];
        
        return view('admin/demo', $data);
    }
    
    /**
     * Display demo edit page
     */
    public function edit()
    {
        $data = [
            'title' => 'Kelola Demo Program - INLISLite v3.0'
        ];
        
        return view('admin/demo-edit', $data);
    }
    
    /**
     * Get demo data for DataTable
     */
    public function getData()
    {
        try {
            $demos = $this->demoModel->orderBy('sort_order', 'ASC')
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $demos
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get demo data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data demo'
            ]);
        }
    }
    
    /**
     * Get statistics for demo
     */
    public function getStatistics()
    {
        try {
            $totalDemo = $this->demoModel->countAll();
            $activeDemo = $this->demoModel->where('status', 'active')->countAllResults();
            $inactiveDemo = $this->demoModel->where('status', 'inactive')->countAllResults();
            
            return $this->response->setJSON([
                'success' => true,
                'statistics' => [
                    'total' => $totalDemo,
                    'active' => $activeDemo,
                    'inactive' => $inactiveDemo
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get demo statistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat statistik demo'
            ]);
        }
    }
    
    /**
     * Store new demo
     */
    public function store()
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Validate required fields
            if (empty($input['title'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Judul demo harus diisi'
                ]);
            }
            
            // Prepare data for insertion
            $data = [
                'title' => $input['title'],
                'subtitle' => $input['subtitle'] ?? '',
                'description' => $input['description'] ?? '',
                'category' => $input['category'] ?? '',
                'demo_type' => $input['demo_type'] ?? '',
                'version' => $input['version'] ?? '',
                'demo_url' => $input['demo_url'] ?? '',
                'icon' => $input['icon'] ?? '',
                'features' => $input['features'] ?? '',
                'access_level' => $input['access_level'] ?? 'public',
                'status' => $input['status'] ?? 'active',
                'sort_order' => $input['sort_order'] ?? 1,
                'is_featured' => $input['is_featured'] ?? 0
            ];
            
            // Handle file upload if present
            $file = $this->request->getFile('demo_file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/demo', $newName);
                
                $data['file_name'] = $file->getClientName();
                $data['file_path'] = 'uploads/demo/' . $newName;
                $data['file_size'] = $file->getSize();
                $data['file_type'] = $file->getClientMimeType();
            }
            
            $demoId = $this->demoModel->insert($data);
            
            if ($demoId) {
                $this->logActivity('create', 'demo', $demoId, "Menambahkan demo: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Demo berhasil ditambahkan',
                    'data' => array_merge(['id' => $demoId], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan demo'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to store demo: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan demo'
            ]);
        }
    }
    
    /**
     * Update existing demo
     */
    public function update($id)
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Check if demo exists
            $existingDemo = $this->demoModel->find($id);
            if (!$existingDemo) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Demo tidak ditemukan'
                ]);
            }
            
            // Validate required fields
            if (empty($input['title'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Judul demo harus diisi'
                ]);
            }
            
            // Prepare data for update
            $data = [
                'title' => $input['title'],
                'subtitle' => $input['subtitle'] ?? $existingDemo['subtitle'] ?? '',
                'description' => $input['description'] ?? $existingDemo['description'],
                'category' => $input['category'] ?? $existingDemo['category'] ?? '',
                'demo_type' => $input['demo_type'] ?? $existingDemo['demo_type'] ?? '',
                'version' => $input['version'] ?? $existingDemo['version'],
                'demo_url' => $input['demo_url'] ?? $existingDemo['demo_url'] ?? '',
                'icon' => $input['icon'] ?? $existingDemo['icon'] ?? '',
                'features' => $input['features'] ?? $existingDemo['features'],
                'access_level' => $input['access_level'] ?? $existingDemo['access_level'] ?? 'public',
                'status' => $input['status'] ?? $existingDemo['status'],
                'sort_order' => $input['sort_order'] ?? $existingDemo['sort_order'],
                'is_featured' => $input['is_featured'] ?? $existingDemo['is_featured'] ?? 0,
                'file_name' => $existingDemo['file_name'] ?? null,
                'file_path' => $existingDemo['file_path'] ?? null,
                'file_size' => $existingDemo['file_size'] ?? null,
                'file_type' => $existingDemo['file_type'] ?? null
            ];
            
            // Handle file upload if present
            $file = $this->request->getFile('demo_file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Delete old file if exists
                if (!empty($existingDemo['file_path']) && file_exists(ROOTPATH . 'public/' . $existingDemo['file_path'])) {
                    unlink(ROOTPATH . 'public/' . $existingDemo['file_path']);
                }
                
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/demo', $newName);
                
                $data['file_name'] = $file->getClientName();
                $data['file_path'] = 'uploads/demo/' . $newName;
                $data['file_size'] = $file->getSize();
                $data['file_type'] = $file->getClientMimeType();
            }
            
            // Handle file removal if requested
            if (isset($input['remove_file']) && $input['remove_file'] === true) {
                // Delete file if exists
                if (!empty($existingDemo['file_path']) && file_exists(ROOTPATH . 'public/' . $existingDemo['file_path'])) {
                    unlink(ROOTPATH . 'public/' . $existingDemo['file_path']);
                }
                
                $data['file_name'] = null;
                $data['file_path'] = null;
                $data['file_size'] = null;
                $data['file_type'] = null;
            }
            
            $updated = $this->demoModel->update($id, $data);
            
            if ($updated) {
                $this->logActivity('update', 'demo', $id, "Mengupdate demo: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Demo berhasil diupdate',
                    'data' => array_merge(['id' => $id], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate demo'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update demo: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate demo'
            ]);
        }
    }
    
    /**
     * Delete demo
     */
    public function delete($id)
    {
        try {
            $demo = $this->demoModel->find($id);
            if (!$demo) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Demo tidak ditemukan'
                ]);
            }
            
            // Delete associated file if exists
            if (!empty($demo['file_path']) && file_exists(ROOTPATH . 'public/' . $demo['file_path'])) {
                unlink(ROOTPATH . 'public/' . $demo['file_path']);
            }
            
            $deleted = $this->demoModel->delete($id);
            
            if ($deleted) {
                $this->logActivity('delete', 'demo', $id, "Menghapus demo: {$demo['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Demo berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus demo'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete demo: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus demo'
            ]);
        }
    }
    
    /**
     * Update sort order for demo
     */
    public function updateSortOrder()
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input || !isset($input['items'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data pengurutan tidak valid'
                ]);
            }
            
            $db = \Config\Database::connect();
            $db->transStart();
            
            foreach ($input['items'] as $item) {
                $this->demoModel->update($item['id'], ['sort_order' => $item['sort_order']]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan demo'
                ]);
            }
            
            $this->logActivity('update', 'demo', null, 'Mengupdate urutan demo');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan demo berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update demo sort order: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate urutan'
            ]);
        }
    }
    
    /**
     * Log activity
     */
    private function logActivity($action, $module, $itemId, $description)
    {
        try {
            $activityData = [
                'user_id' => $this->session->get('admin_id'),
                'username' => $this->session->get('admin_username'),
                'action' => $action,
                'module' => $module,
                'item_id' => $itemId,
                'description' => $description,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db = \Config\Database::connect();
            if ($db->tableExists('admin_activity_log')) {
                $db->table('admin_activity_log')->insert($activityData);
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to log activity: ' . $e->getMessage());
        }
    }
}

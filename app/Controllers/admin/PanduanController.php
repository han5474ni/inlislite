<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PanduanModel;

class PanduanController extends BaseController
{
    protected $panduanModel;
    protected $session;
    
    public function __construct()
    {
        $this->panduanModel = new PanduanModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display panduan management page
     */
    public function index()
    {
        $data = [
            'title' => 'Panduan - INLISLite v3.0',
            'page_title' => 'Panduan',
            'page_subtitle' => 'Kelola dokumen panduan sistem perpustakaan'
        ];
        
        return view('admin/panduan', $data);
    }
    
    /**
     * Display panduan edit page
     */
    public function edit()
    {
        $data = [
            'title' => 'Kelola Panduan - INLISLite v3.0'
        ];
        
        return view('admin/panduan-edit', $data);
    }
    
    /**
     * Get panduan data for DataTable
     */
    public function getData()
    {
        try {
            $panduan = $this->panduanModel->orderBy('sort_order', 'ASC')
                                        ->orderBy('created_at', 'DESC')
                                        ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $panduan
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get panduan data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data panduan'
            ]);
        }
    }
    
    /**
     * Get statistics for panduan
     */
    public function getStatistics()
    {
        try {
            $totalPanduan = $this->panduanModel->countAll();
            $activePanduan = $this->panduanModel->where('status', 'active')->countAllResults();
            $inactivePanduan = $this->panduanModel->where('status', 'inactive')->countAllResults();
            
            // Count by category
            $categories = $this->panduanModel->select('category, COUNT(*) as count')
                                           ->groupBy('category')
                                           ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'statistics' => [
                    'total' => $totalPanduan,
                    'active' => $activePanduan,
                    'inactive' => $inactivePanduan,
                    'categories' => $categories
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get panduan statistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat statistik panduan'
            ]);
        }
    }
    
    /**
     * Store new panduan
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
                    'message' => 'Judul panduan harus diisi'
                ]);
            }
            
            // Prepare data for insertion
            $data = [
                'title' => $input['title'],
                'description' => $input['description'] ?? '',
                'category' => $input['category'] ?? '',
                'file_path' => $input['file_path'] ?? '',
                'file_size' => $input['file_size'] ?? '',
                'version' => $input['version'] ?? '',
                'status' => $input['status'] ?? 'active',
                'sort_order' => $input['sort_order'] ?? 1
            ];
            
            $panduanId = $this->panduanModel->insert($data);
            
            if ($panduanId) {
                $this->logActivity('create', 'panduan', $panduanId, "Menambahkan panduan: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Panduan berhasil ditambahkan',
                    'data' => array_merge(['id' => $panduanId], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan panduan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to store panduan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan panduan'
            ]);
        }
    }
    
    /**
     * Update existing panduan
     */
    public function update($id)
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Check if panduan exists
            $existingPanduan = $this->panduanModel->find($id);
            if (!$existingPanduan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Panduan tidak ditemukan'
                ]);
            }
            
            // Validate required fields
            if (empty($input['title'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Judul panduan harus diisi'
                ]);
            }
            
            // Prepare data for update
            $data = [
                'title' => $input['title'],
                'description' => $input['description'] ?? $existingPanduan['description'],
                'category' => $input['category'] ?? $existingPanduan['category'],
                'file_path' => $input['file_path'] ?? $existingPanduan['file_path'],
                'file_size' => $input['file_size'] ?? $existingPanduan['file_size'],
                'version' => $input['version'] ?? $existingPanduan['version'],
                'status' => $input['status'] ?? $existingPanduan['status'],
                'sort_order' => $input['sort_order'] ?? $existingPanduan['sort_order']
            ];
            
            $updated = $this->panduanModel->update($id, $data);
            
            if ($updated) {
                $this->logActivity('update', 'panduan', $id, "Mengupdate panduan: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Panduan berhasil diupdate',
                    'data' => array_merge(['id' => $id], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate panduan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update panduan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate panduan'
            ]);
        }
    }
    
    /**
     * Delete panduan
     */
    public function delete($id)
    {
        try {
            $panduan = $this->panduanModel->find($id);
            if (!$panduan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Panduan tidak ditemukan'
                ]);
            }
            
            $deleted = $this->panduanModel->delete($id);
            
            if ($deleted) {
                $this->logActivity('delete', 'panduan', $id, "Menghapus panduan: {$panduan['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Panduan berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus panduan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete panduan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus panduan'
            ]);
        }
    }
    
    /**
     * Update sort order for panduan
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
                $this->panduanModel->update($item['id'], ['sort_order' => $item['sort_order']]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan panduan'
                ]);
            }
            
            $this->logActivity('update', 'panduan', null, 'Mengupdate urutan panduan');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan panduan berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update panduan sort order: ' . $e->getMessage());
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

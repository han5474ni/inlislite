<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DukunganModel;

class DukunganController extends BaseController
{
    protected $dukunganModel;
    protected $session;
    
    public function __construct()
    {
        $this->dukunganModel = new DukunganModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display dukungan management page
     */
    public function index()
    {
        $data = [
            'title' => 'Dukungan - INLISLite v3.0',
            'page_title' => 'Dukungan',
            'page_subtitle' => 'Kelola item dukungan sistem perpustakaan'
        ];
        
        return view('admin/dukungan', $data);
    }
    
    /**
     * Display dukungan edit page
     */
    public function edit()
    {
        $data = [
            'title' => 'Kelola Dukungan - INLISLite v3.0'
        ];
        
        return view('admin/dukungan-edit', $data);
    }
    
    /**
     * Get dukungan data for DataTable
     */
    public function getData()
    {
        try {
            $dukungan = $this->dukunganModel->orderBy('sort_order', 'ASC')
                                          ->orderBy('created_at', 'DESC')
                                          ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $dukungan
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get dukungan data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data dukungan'
            ]);
        }
    }
    
    /**
     * Get statistics for dukungan
     */
    public function getStatistics()
    {
        try {
            $totalDukungan = $this->dukunganModel->countAll();
            $activeDukungan = $this->dukunganModel->where('status', 'active')->countAllResults();
            $inactiveDukungan = $this->dukunganModel->where('status', 'inactive')->countAllResults();
            
            // Count by category
            $categories = $this->dukunganModel->select('category, COUNT(*) as count')
                                            ->groupBy('category')
                                            ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'statistics' => [
                    'total' => $totalDukungan,
                    'active' => $activeDukungan,
                    'inactive' => $inactiveDukungan,
                    'categories' => $categories
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get dukungan statistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat statistik dukungan'
            ]);
        }
    }
    
    /**
     * Store new dukungan
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
                    'message' => 'Judul dukungan harus diisi'
                ]);
            }
            
            // Prepare data for insertion
            $data = [
                'title' => $input['title'],
                'description' => $input['description'] ?? '',
                'category' => $input['category'] ?? '',
                'contact_info' => $input['contact_info'] ?? '',
                'response_time' => $input['response_time'] ?? '',
                'availability' => $input['availability'] ?? '',
                'icon' => $input['icon'] ?? 'bi-support',
                'status' => $input['status'] ?? 'active',
                'sort_order' => $input['sort_order'] ?? 1
            ];
            
            $dukunganId = $this->dukunganModel->insert($data);
            
            if ($dukunganId) {
                $this->logActivity('create', 'dukungan', $dukunganId, "Menambahkan dukungan: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dukungan berhasil ditambahkan',
                    'data' => array_merge(['id' => $dukunganId], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan dukungan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to store dukungan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan dukungan'
            ]);
        }
    }
    
    /**
     * Update existing dukungan
     */
    public function update($id)
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Check if dukungan exists
            $existingDukungan = $this->dukunganModel->find($id);
            if (!$existingDukungan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Dukungan tidak ditemukan'
                ]);
            }
            
            // Validate required fields
            if (empty($input['title'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Judul dukungan harus diisi'
                ]);
            }
            
            // Prepare data for update
            $data = [
                'title' => $input['title'],
                'description' => $input['description'] ?? $existingDukungan['description'],
                'category' => $input['category'] ?? $existingDukungan['category'],
                'contact_info' => $input['contact_info'] ?? $existingDukungan['contact_info'],
                'response_time' => $input['response_time'] ?? $existingDukungan['response_time'],
                'availability' => $input['availability'] ?? $existingDukungan['availability'],
                'icon' => $input['icon'] ?? $existingDukungan['icon'],
                'status' => $input['status'] ?? $existingDukungan['status'],
                'sort_order' => $input['sort_order'] ?? $existingDukungan['sort_order']
            ];
            
            $updated = $this->dukunganModel->update($id, $data);
            
            if ($updated) {
                $this->logActivity('update', 'dukungan', $id, "Mengupdate dukungan: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dukungan berhasil diupdate',
                    'data' => array_merge(['id' => $id], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate dukungan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update dukungan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate dukungan'
            ]);
        }
    }
    
    /**
     * Delete dukungan
     */
    public function delete($id)
    {
        try {
            $dukungan = $this->dukunganModel->find($id);
            if (!$dukungan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Dukungan tidak ditemukan'
                ]);
            }
            
            $deleted = $this->dukunganModel->delete($id);
            
            if ($deleted) {
                $this->logActivity('delete', 'dukungan', $id, "Menghapus dukungan: {$dukungan['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dukungan berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus dukungan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete dukungan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus dukungan'
            ]);
        }
    }
    
    /**
     * Update sort order for dukungan
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
                $this->dukunganModel->update($item['id'], ['sort_order' => $item['sort_order']]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan dukungan'
                ]);
            }
            
            $this->logActivity('update', 'dukungan', null, 'Mengupdate urutan dukungan');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan dukungan berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update dukungan sort order: ' . $e->getMessage());
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

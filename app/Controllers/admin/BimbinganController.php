<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BimbinganModel;

class BimbinganController extends BaseController
{
    protected $bimbinganModel;
    protected $session;
    
    public function __construct()
    {
        $this->bimbinganModel = new BimbinganModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display bimbingan management page
     */
    public function index()
    {
        $data = [
            'title' => 'Bimbingan Teknis - INLISLite v3.0',
            'page_title' => 'Bimbingan Teknis',
            'page_subtitle' => 'Kelola program bimbingan teknis perpustakaan'
        ];
        
        return view('admin/bimbingan', $data);
    }
    
    /**
     * Display bimbingan edit page
     */
    public function edit()
    {
        $data = [
            'title' => 'Kelola Bimbingan Teknis - INLISLite v3.0'
        ];
        
        return view('admin/bimbingan-edit', $data);
    }
    
    /**
     * Get bimbingan data for DataTable
     */
    public function getData()
    {
        try {
            $bimbingan = $this->bimbinganModel->orderBy('sort_order', 'ASC')
                                           ->orderBy('created_at', 'DESC')
                                           ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $bimbingan
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get bimbingan data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data bimbingan'
            ]);
        }
    }
    
    /**
     * Get statistics for bimbingan
     */
    public function getStatistics()
    {
        try {
            $totalBimbingan = $this->bimbinganModel->countAll();
            $activeBimbingan = $this->bimbinganModel->where('status', 'active')->countAllResults();
            $inactiveBimbingan = $this->bimbinganModel->where('status', 'inactive')->countAllResults();
            
            return $this->response->setJSON([
                'success' => true,
                'statistics' => [
                    'total' => $totalBimbingan,
                    'active' => $activeBimbingan,
                    'inactive' => $inactiveBimbingan
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get bimbingan statistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat statistik bimbingan'
            ]);
        }
    }
    
    /**
     * Store new bimbingan
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
                    'message' => 'Judul bimbingan harus diisi'
                ]);
            }
            
            // Prepare data for insertion
            $data = [
                'title' => $input['title'],
                'description' => $input['description'] ?? '',
                'duration' => $input['duration'] ?? '',
                'participants' => $input['participants'] ?? '',
                'price' => $input['price'] ?? '',
                'topics' => $input['topics'] ?? '',
                'status' => $input['status'] ?? 'active',
                'sort_order' => $input['sort_order'] ?? 1
            ];
            
            $bimbinganId = $this->bimbinganModel->insert($data);
            
            if ($bimbinganId) {
                $this->logActivity('create', 'bimbingan', $bimbinganId, "Menambahkan bimbingan: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Bimbingan berhasil ditambahkan',
                    'data' => array_merge(['id' => $bimbinganId], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan bimbingan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to store bimbingan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan bimbingan'
            ]);
        }
    }
    
    /**
     * Update existing bimbingan
     */
    public function update($id)
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Check if bimbingan exists
            $existingBimbingan = $this->bimbinganModel->find($id);
            if (!$existingBimbingan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Bimbingan tidak ditemukan'
                ]);
            }
            
            // Validate required fields
            if (empty($input['title'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Judul bimbingan harus diisi'
                ]);
            }
            
            // Prepare data for update
            $data = [
                'title' => $input['title'],
                'description' => $input['description'] ?? $existingBimbingan['description'],
                'duration' => $input['duration'] ?? $existingBimbingan['duration'],
                'participants' => $input['participants'] ?? $existingBimbingan['participants'],
                'price' => $input['price'] ?? $existingBimbingan['price'],
                'topics' => $input['topics'] ?? $existingBimbingan['topics'],
                'status' => $input['status'] ?? $existingBimbingan['status'],
                'sort_order' => $input['sort_order'] ?? $existingBimbingan['sort_order']
            ];
            
            $updated = $this->bimbinganModel->update($id, $data);
            
            if ($updated) {
                $this->logActivity('update', 'bimbingan', $id, "Mengupdate bimbingan: {$data['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Bimbingan berhasil diupdate',
                    'data' => array_merge(['id' => $id], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate bimbingan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update bimbingan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate bimbingan'
            ]);
        }
    }
    
    /**
     * Delete bimbingan
     */
    public function delete($id)
    {
        try {
            $bimbingan = $this->bimbinganModel->find($id);
            if (!$bimbingan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Bimbingan tidak ditemukan'
                ]);
            }
            
            $deleted = $this->bimbinganModel->delete($id);
            
            if ($deleted) {
                $this->logActivity('delete', 'bimbingan', $id, "Menghapus bimbingan: {$bimbingan['title']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Bimbingan berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus bimbingan'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete bimbingan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus bimbingan'
            ]);
        }
    }
    
    /**
     * Update sort order for bimbingan
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
                $this->bimbinganModel->update($item['id'], ['sort_order' => $item['sort_order']]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan bimbingan'
                ]);
            }
            
            $this->logActivity('update', 'bimbingan', null, 'Mengupdate urutan bimbingan');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan bimbingan berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update bimbingan sort order: ' . $e->getMessage());
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

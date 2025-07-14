<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AplikasiModel;

class AplikasiController extends BaseController
{
    protected $aplikasiModel;
    protected $session;
    
    public function __construct()
    {
        $this->aplikasiModel = new AplikasiModel();
        $this->session = \Config\Services::session();
    }
    
    /**
     * Display aplikasi management page
     */
    public function index()
    {
        $data = [
            'title' => 'Aplikasi Pendukung - INLISLite v3.0',
            'page_title' => 'Aplikasi Pendukung',
            'page_subtitle' => 'Kelola aplikasi pendukung sistem perpustakaan'
        ];
        
        return view('admin/aplikasi', $data);
    }
    
    /**
     * Display aplikasi edit page
     */
    public function edit()
    {
        $data = [
            'title' => 'Kelola Aplikasi Pendukung - INLISLite v3.0'
        ];
        
        return view('admin/aplikasi-edit', $data);
    }
    
    /**
     * Get aplikasi data for DataTable
     */
    public function getData()
    {
        try {
            $aplikasi = $this->aplikasiModel->orderBy('sort_order', 'ASC')
                                          ->orderBy('created_at', 'DESC')
                                          ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $aplikasi
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get aplikasi data: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat data aplikasi'
            ]);
        }
    }
    
    /**
     * Get statistics for aplikasi
     */
    public function getStatistics()
    {
        try {
            $totalAplikasi = $this->aplikasiModel->countAll();
            $activeAplikasi = $this->aplikasiModel->where('status', 'active')->countAllResults();
            $inactiveAplikasi = $this->aplikasiModel->where('status', 'inactive')->countAllResults();
            
            // Count by category
            $categories = $this->aplikasiModel->select('kategori, COUNT(*) as count')
                                            ->groupBy('kategori')
                                            ->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'statistics' => [
                    'total' => $totalAplikasi,
                    'active' => $activeAplikasi,
                    'inactive' => $inactiveAplikasi,
                    'categories' => $categories
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get aplikasi statistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat statistik aplikasi'
            ]);
        }
    }
    
    /**
     * Store new aplikasi
     */
    public function store()
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Validate required fields
            if (empty($input['nama_aplikasi'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama aplikasi harus diisi'
                ]);
            }
            
            // Prepare data for insertion
            $data = [
                'nama_aplikasi' => $input['nama_aplikasi'],
                'deskripsi' => $input['deskripsi'] ?? '',
                'versi' => $input['versi'] ?? '',
                'platform' => $input['platform'] ?? '',
                'ukuran' => $input['ukuran'] ?? '',
                'kategori' => $input['kategori'] ?? 'aplikasi',
                'url_download' => $input['url_download'] ?? '',
                'icon' => $input['icon'] ?? 'bi-app',
                'status' => $input['status'] ?? 'active',
                'sort_order' => $input['sort_order'] ?? 1
            ];
            
            $aplikasiId = $this->aplikasiModel->insert($data);
            
            if ($aplikasiId) {
                $this->logActivity('create', 'aplikasi', $aplikasiId, "Menambahkan aplikasi: {$data['nama_aplikasi']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Aplikasi berhasil ditambahkan',
                    'data' => array_merge(['id' => $aplikasiId], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan aplikasi'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to store aplikasi: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan aplikasi'
            ]);
        }
    }
    
    /**
     * Update existing aplikasi
     */
    public function update($id)
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$input) {
                $input = $this->request->getPost();
            }
            
            // Check if aplikasi exists
            $existingAplikasi = $this->aplikasiModel->find($id);
            if (!$existingAplikasi) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Aplikasi tidak ditemukan'
                ]);
            }
            
            // Validate required fields
            if (empty($input['nama_aplikasi'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama aplikasi harus diisi'
                ]);
            }
            
            // Prepare data for update
            $data = [
                'nama_aplikasi' => $input['nama_aplikasi'],
                'deskripsi' => $input['deskripsi'] ?? $existingAplikasi['deskripsi'],
                'versi' => $input['versi'] ?? $existingAplikasi['versi'],
                'platform' => $input['platform'] ?? $existingAplikasi['platform'],
                'ukuran' => $input['ukuran'] ?? $existingAplikasi['ukuran'],
                'kategori' => $input['kategori'] ?? $existingAplikasi['kategori'],
                'url_download' => $input['url_download'] ?? $existingAplikasi['url_download'],
                'icon' => $input['icon'] ?? $existingAplikasi['icon'],
                'status' => $input['status'] ?? $existingAplikasi['status'],
                'sort_order' => $input['sort_order'] ?? $existingAplikasi['sort_order']
            ];
            
            $updated = $this->aplikasiModel->update($id, $data);
            
            if ($updated) {
                $this->logActivity('update', 'aplikasi', $id, "Mengupdate aplikasi: {$data['nama_aplikasi']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Aplikasi berhasil diupdate',
                    'data' => array_merge(['id' => $id], $data)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate aplikasi'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update aplikasi: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate aplikasi'
            ]);
        }
    }
    
    /**
     * Delete aplikasi
     */
    public function delete($id)
    {
        try {
            $aplikasi = $this->aplikasiModel->find($id);
            if (!$aplikasi) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Aplikasi tidak ditemukan'
                ]);
            }
            
            $deleted = $this->aplikasiModel->delete($id);
            
            if ($deleted) {
                $this->logActivity('delete', 'aplikasi', $id, "Menghapus aplikasi: {$aplikasi['nama_aplikasi']}");
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Aplikasi berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus aplikasi'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to delete aplikasi: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus aplikasi'
            ]);
        }
    }
    
    /**
     * Update sort order for aplikasi
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
                $this->aplikasiModel->update($item['id'], ['sort_order' => $item['sort_order']]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan aplikasi'
                ]);
            }
            
            $this->logActivity('update', 'aplikasi', null, 'Mengupdate urutan aplikasi');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan aplikasi berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to update aplikasi sort order: ' . $e->getMessage());
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

<?php

namespace App\Controllers;

use App\Models\PatchModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

class PatchUpdater extends BaseController
{
    protected $model;
    protected $validation;

    public function __construct()
    {
        $this->model = new PatchModel();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Display patches with optional filters
     */
    public function index()
    {
        try {
            $filters = $this->getFilters();
            
            // Sample data - replace with your database model
            $patches = [
                [
                    'id' => 1,
                    'nama_paket' => 'INLISLite Core Update',
                    'versi' => '3.1.2',
                    'deskripsi' => 'Pembaruan inti sistem dengan perbaikan bug dan peningkatan performa',
                    'prioritas' => 'High',
                    'jumlah_unduhan' => 1250,
                    'ukuran' => '15.2 MB',
                    'tanggal_rilis' => '2024-01-15'
                ],
                [
                    'id' => 2,
                    'nama_paket' => 'Security Patch',
                    'versi' => '3.1.1',
                    'deskripsi' => 'Patch keamanan untuk mengatasi vulnerabilitas sistem',
                    'prioritas' => 'High',
                    'jumlah_unduhan' => 890,
                    'ukuran' => '8.7 MB',
                    'tanggal_rilis' => '2024-01-10'
                ],
                [
                    'id' => 3,
                    'nama_paket' => 'UI Enhancement',
                    'versi' => '3.0.8',
                    'deskripsi' => 'Peningkatan antarmuka pengguna dan pengalaman pengguna',
                    'prioritas' => 'Medium',
                    'jumlah_unduhan' => 567,
                    'ukuran' => '12.4 MB',
                    'tanggal_rilis' => '2024-01-05'
                ]
            ];

            $data = [
                'title' => 'Patch and Updater',
                'search' => $filters['search'] ?? '',
                'priority' => $filters['priority'] ?? '',
                'patches' => $patches,
                'total_patches' => count($patches),
                'error' => session('error'),
                'success' => session('success')
            ];

            return view('patch', $data);
        } catch (Exception $e) {
            log_message('error', 'PatchUpdater index error: ' . $e->getMessage());
            return view('patch', [
                'title' => 'Patch and Updater',
                'patches' => [],
                'error' => 'Terjadi kesalahan saat memuat data patch.'
            ]);
        }
    }

    /**
     * Create new patch (form submission)
     */
    public function create()
    {
        if (!$this->request->isSecure() && ENVIRONMENT === 'production') {
            return redirect()->to('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }

        try {
            if (!$this->validatePatchData()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Data tidak valid: ' . implode(', ', $this->validation->getErrors()));
            }

            $data = $this->getPatchData();
            $data['jumlah_unduhan'] = 0;
            $data['created_at'] = date('Y-m-d H:i:s');

            if (!$this->model->insert($data)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan patch: ' . implode(', ', $this->model->errors()));
            }

            return redirect()
                ->to('/patch-updater')
                ->with('success', 'Patch berhasil ditambahkan!');

        } catch (Exception $e) {
            log_message('error', 'PatchUpdater create error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan patch.');
        }
    }

    /**
     * Handle AJAX requests for CRUD operations
     */
    public function ajaxHandler()
    {
        // Security checks
        if (!$this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => false,
                    'error' => 'Akses tidak sah. Hanya AJAX request yang diizinkan.'
                ]);
        }

        // CSRF Protection
        if (!$this->validateCSRF()) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => false,
                    'error' => 'CSRF token tidak valid.'
                ]);
        }

        $action = $this->request->getPost('action');
        $id = $this->request->getPost('id');

        try {
            switch ($action) {
                case 'create':
                    return $this->handleCreateAction();
                
                case 'update':
                    return $this->handleUpdateAction($id);
                
                case 'delete':
                    return $this->handleDeleteAction($id);
                
                case 'get':
                    return $this->handleGetAction($id);
                
                case 'download':
                    return $this->handleDownloadAction($id);
                
                default:
                    return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'success' => false,
                            'error' => 'Aksi tidak dikenali: ' . esc($action)
                        ]);
            }
        } catch (Exception $e) {
            log_message('error', 'PatchUpdater AJAX error: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'error' => 'Terjadi kesalahan server.'
                ]);
        }
    }

    /**
     * API endpoint for saving patch
     */
    public function save()
    {
        if (!$this->request->isAJAX()) {
            throw new PageNotFoundException();
        }

        try {
            if (!$this->validatePatchData()) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Validasi gagal',
                        'errors' => $this->validation->getErrors()
                    ]);
            }

            $data = $this->getPatchData();
            $data['jumlah_unduhan'] = 0;
            $data['created_at'] = date('Y-m-d H:i:s');

            if (!$this->model->insert($data)) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal menyimpan patch',
                        'errors' => $this->model->errors()
                    ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Patch berhasil disimpan',
                'data' => ['id' => $this->model->getInsertID()]
            ]);

        } catch (Exception $e) {
            log_message('error', 'PatchUpdater save error: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan server'
                ]);
        }
    }

    // Private helper methods

    /**
     * Validate CSRF token
     */
    private function validateCSRF(): bool
    {
        $token = $this->request->getPost(csrf_token());
        return hash_equals(csrf_hash(), $token);
    }

    /**
     * Validate patch data
     */
    private function validatePatchData(): bool
    {
        $rules = [
            'nama_paket' => [
                'label' => 'Nama Paket',
                'rules' => 'required|min_length[3]|max_length[255]|alpha_numeric_punct',
            ],
            'versi' => [
                'label' => 'Versi',
                'rules' => 'required|min_length[1]|max_length[50]|regex_match[/^[0-9]+(\.[0-9]+)*$/]',
            ],
            'prioritas' => [
                'label' => 'Prioritas',
                'rules' => 'required|in_list[High,Medium,Low]',
            ],
            'tanggal_rilis' => [
                'label' => 'Tanggal Rilis',
                'rules' => 'required|valid_date[Y-m-d]',
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required|min_length[1]|max_length[50]',
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'rules' => 'required|min_length[10]|max_length[1000]',
            ],
        ];

        return $this->validation->setRules($rules)->withRequest($this->request)->run();
    }

    /**
     * Get filters from request with sanitization
     */
    private function getFilters(): array
    {
        $search = $this->request->getGet('search');
        $priority = $this->request->getGet('priority');

        return [
            'search' => $search ? esc(trim($search)) : null,
            'priority' => in_array($priority, ['High', 'Medium', 'Low']) ? $priority : null,
        ];
    }

    /**
     * Get patch data from request with sanitization
     */
    private function getPatchData(): array
    {
        return [
            'nama_paket' => esc(trim($this->request->getPost('nama_paket'))),
            'versi' => esc(trim($this->request->getPost('versi'))),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal_rilis' => $this->request->getPost('tanggal_rilis'),
            'ukuran' => esc(trim($this->request->getPost('ukuran'))),
            'deskripsi' => esc(trim($this->request->getPost('deskripsi'))),
        ];
    }

    /**
     * Handle create action via AJAX
     */
    private function handleCreateAction()
    {
        if (!$this->validatePatchData()) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'error' => 'Validasi gagal',
                    'errors' => $this->validation->getErrors()
                ]);
        }

        $data = $this->getPatchData();
        $data['jumlah_unduhan'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');

        if ($this->model->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Patch berhasil ditambahkan.',
                'data' => ['id' => $this->model->getInsertID()]
            ]);
        }

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'error' => 'Gagal menambahkan patch.',
                'details' => $this->model->errors()
            ]);
    }

    /**
     * Handle update action via AJAX
     */
    private function handleUpdateAction($id)
    {
        if (!$id || !is_numeric($id)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'error' => 'ID patch tidak valid.'
                ]);
        }

        // Check if patch exists
        if (!$this->model->find($id)) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'error' => 'Patch tidak ditemukan.'
                ]);
        }

        if (!$this->validatePatchData()) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'error' => 'Validasi gagal',
                    'errors' => $this->validation->getErrors()
                ]);
        }

        $data = $this->getPatchData();
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->model->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Patch berhasil diupdate.'
            ]);
        }

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'error' => 'Gagal mengupdate patch.',
                'details' => $this->model->errors()
            ]);
    }

    /**
     * Handle delete action via AJAX
     */
    private function handleDeleteAction($id)
    {
        if (!$id || !is_numeric($id)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'error' => 'ID patch tidak valid.'
                ]);
        }

        // Check if patch exists
        $patch = $this->model->find($id);
        if (!$patch) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'error' => 'Patch tidak ditemukan.'
                ]);
        }

        if ($this->model->delete($id)) {
            // Log the deletion
            log_message('info', "Patch deleted: ID {$id}, Name: {$patch['nama_paket']}");
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Patch berhasil dihapus.'
            ]);
        }

        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'error' => 'Gagal menghapus patch.'
            ]);
    }

    /**
     * Handle get action via AJAX
     */
    private function handleGetAction($id)
    {
        if (!$id || !is_numeric($id)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'error' => 'ID patch tidak valid.'
                ]);
        }

        $patch = $this->model->find($id);

        if ($patch) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $patch
            ]);
        }

        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'error' => 'Patch tidak ditemukan.'
            ]);
    }

    /**
     * Handle download action via AJAX
     */
    private function handleDownloadAction($id)
    {
        if (!$id || !is_numeric($id)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'error' => 'ID patch tidak valid.'
                ]);
        }

        $patch = $this->model->find($id);

        if (!$patch) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'error' => 'Patch tidak ditemukan.'
                ]);
        }

        try {
            // Increment download count atomically
            $this->model->where('id', $id)
                       ->set('jumlah_unduhan', 'jumlah_unduhan + 1', false)
                       ->update();

            // Get updated count
            $updatedPatch = $this->model->find($id);
            $newDownloadCount = $updatedPatch['jumlah_unduhan'];

            // Generate download URL (customize based on your file storage)
            $filename = $this->generateFilename($patch);
            $downloadUrl = $this->generateDownloadUrl($patch, $filename);

            // Log the download
            log_message('info', "Patch downloaded: ID {$id}, Name: {$patch['nama_paket']}, Count: {$newDownloadCount}");

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Download dimulai.',
                'data' => [
                    'new_count' => $newDownloadCount,
                    'download_url' => $downloadUrl,
                    'filename' => $filename
                ]
            ]);

        } catch (Exception $e) {
            log_message('error', 'Download error: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'error' => 'Gagal memproses download.'
                ]);
        }
    }

    /**
     * Generate filename for download
     */
    private function generateFilename(array $patch): string
    {
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $patch['nama_paket']);
        return $safeName . '_v' . $patch['versi'] . '.7z';
    }

    /**
     * Generate download URL
     */
    private function generateDownloadUrl(array $patch, string $filename): string
    {
        // Customize this based on your file storage system
        // This could be a local path, S3 URL, etc.
        return base_url('downloads/patches/' . $filename);
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use DateTime;

class Patch extends Controller
{
    protected $patchModel;
    protected $validation;
    protected $request;
    protected $session;

    public function __construct()
    {
        $this->patchModel = new \App\Models\PatchModel();
        $this->validation = \Config\Services::validation();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
    }

    /**
     * Display patch list
     */
    public function index()
    {
        $data = [
            'search' => $this->request->getGet('search'),
            'priority' => $this->request->getGet('priority'),
            'patches' => $this->patchModel->getPatches([
                'search' => $this->request->getGet('search'),
                'priority' => $this->request->getGet('priority')
            ]),
            'error' => $this->session->getFlashdata('error')
        ];
        
        return view('patch/patch', $data);
    }

    /**
     * AJAX handler for patch operations
     */
    public function ajaxHandler()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $action = $this->request->getPost('action');
        
        switch ($action) {
            case 'create':
                return $this->createPatch();
            case 'update':
                return $this->updatePatch();
            case 'delete':
                return $this->deletePatch();
            case 'get':
                return $this->getPatch();
            case 'download':
                return $this->downloadPatch();
            case 'bulk_delete':
                return $this->bulkDeletePatch();
            default:
                return $this->jsonResponse(['success' => false, 'error' => 'Invalid action']);
        }
    }

    /**
     * Create new patch
     */
    private function createPatch()
    {
        $rules = [
            'nama_paket' => 'required|trim|max_length[255]',
            'versi' => 'required|trim|max_length[50]',
            'prioritas' => 'required|in_list[High,Medium,Low]',
            'tanggal_rilis' => ['required', 'validateDate'],
            'ukuran' => 'permit_empty|max_length[50]',
            'deskripsi' => 'required|trim|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return $this->jsonResponse([
                'success' => false,
                'error' => 'Validation failed',
                'messages' => $this->validation->getErrors()
            ]);
        }

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'versi' => $this->request->getPost('versi'),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal_rilis' => $this->request->getPost('tanggal_rilis'),
            'ukuran' => $this->request->getPost('ukuran') ?: null,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah_unduhan' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->patchModel->createPatch($data);
        
        if ($result) {
            return $this->jsonResponse(['success' => true, 'id' => $result]);
        }
        return $this->jsonResponse(['success' => false, 'error' => 'Failed to save patch']);
    }

    /**
     * Update existing patch
     */
    private function updatePatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !$this->patchModel->patchExists($id)) {
            return $this->jsonResponse(['success' => false, 'error' => 'Patch not found']);
        }

        $rules = [
            'nama_paket' => 'required|trim|max_length[255]',
            'versi' => 'required|trim|max_length[50]',
            'prioritas' => 'required|in_list[High,Medium,Low]',
            'tanggal_rilis' => ['required', 'validateDate'],
            'ukuran' => 'permit_empty|max_length[50]',
            'deskripsi' => 'required|trim|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return $this->jsonResponse([
                'success' => false,
                'error' => 'Validation failed',
                'messages' => $this->validation->getErrors()
            ]);
        }

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'versi' => $this->request->getPost('versi'),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal_rilis' => $this->request->getPost('tanggal_rilis'),
            'ukuran' => $this->request->getPost('ukuran') ?: null,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->patchModel->updatePatch($id, $data);
        
        if ($result) {
            return $this->jsonResponse(['success' => true]);
        }
        return $this->jsonResponse(['success' => false, 'error' => 'Failed to update patch']);
    }

    /**
     * Delete patch
     */
    private function deletePatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !$this->patchModel->patchExists($id)) {
            return $this->jsonResponse(['success' => false, 'error' => 'Patch not found']);
        }

        $result = $this->patchModel->deletePatch($id);
        
        if ($result) {
            return $this->jsonResponse(['success' => true]);
        }
        return $this->jsonResponse(['success' => false, 'error' => 'Failed to delete patch']);
    }

    /**
     * Get patch data
     */
    private function getPatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invalid patch ID']);
        }

        $patch = $this->patchModel->getPatchById($id);
        
        if ($patch) {
            return $this->jsonResponse(['success' => true, 'data' => $patch]);
        }
        return $this->jsonResponse(['success' => false, 'error' => 'Patch not found']);
    }

    /**
     * Handle patch download
     */
    private function downloadPatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !$this->patchModel->patchExists($id)) {
            return $this->jsonResponse(['success' => false, 'error' => 'Patch not found']);
        }

        $newCount = $this->patchModel->incrementDownloadCount($id);
        $patch = $this->patchModel->getPatchById($id);
        $downloadUrl = base_url('patches/files/' . $patch['id'] . '_' . $patch['versi'] . '.zip');
        
        return $this->jsonResponse([
            'success' => true,
            'new_count' => $newCount,
            'download_url' => $downloadUrl,
            'filename' => $patch['nama_paket'] . '_v' . $patch['versi'] . '.zip'
        ]);
    }

    /**
     * Bulk delete patches
     */
    private function bulkDeletePatch()
    {
        $ids = $this->request->getPost('ids');
        
        if (!$ids || !is_array($ids)) {
            return $this->jsonResponse(['success' => false, 'error' => 'Invalid patch IDs']);
        }

        $result = $this->patchModel->bulkDeletePatches($ids);
        
        if ($result) {
            return $this->jsonResponse(['success' => true, 'deleted_count' => count($ids)]);
        }
        return $this->jsonResponse(['success' => false, 'error' => 'Failed to delete patches']);
    }

    /**
     * Export patches to CSV
     */
    public function export()
    {
        $filters = [
            'search' => $this->request->getGet('search'),
            'priority' => $this->request->getGet('priority')
        ];
        
        $patches = $this->patchModel->getPatches($filters);
        $filename = 'patches_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, [
            'ID', 'Nama Paket', 'Versi', 'Prioritas', 'Tanggal Rilis',
            'Ukuran', 'Deskripsi', 'Jumlah Unduhan', 'Dibuat', 'Diupdate'
        ]);
        
        foreach ($patches as $patch) {
            fputcsv($output, [
                $patch['id'], $patch['nama_paket'], $patch['versi'],
                $patch['prioritas'], $patch['tanggal_rilis'], $patch['ukuran'],
                $patch['deskripsi'], $patch['jumlah_unduhan'],
                $patch['created_at'], $patch['updated_at']
            ]);
        }
        
        fclose($output);
    }

    /**
     * Validate date format
     */
    public function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if (!$d || $d->format('Y-m-d') !== $date) {
            $this->validation->setError('tanggal_rilis', 'Date must be in YYYY-MM-DD format');
            return false;
        }
        
        if ($d > new DateTime()) {
            $this->validation->setError('tanggal_rilis', 'Date cannot be in the future');
            return false;
        }
        
        return true;
    }

    /**
     * Send JSON response
     */
    private function jsonResponse($data)
    {
        return $this->response->setJSON($data);
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PatchController extends Controller
{
    public function index()
    {
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
            'patches' => $patches
        ];

        return view('patch/index', $data);
    }

    public function ajaxHandler()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Only AJAX requests allowed']);
        }

        $action = $this->request->getPost('action');

        try {
            switch ($action) {
                case 'create':
                    return $this->createPatch();
                case 'get':
                    return $this->getPatch();
                case 'update':
                    return $this->updatePatch();
                case 'delete':
                    return $this->deletePatch();
                case 'download':
                    return $this->downloadPatch();
                default:
                    throw new \Exception('Invalid action');
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function createPatch()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama_paket' => 'required|min_length[3]|max_length[255]',
            'versi' => 'required|min_length[1]|max_length[50]',
            'prioritas' => 'required|in_list[High,Medium,Low]',
            'ukuran' => 'required|min_length[1]|max_length[50]',
            'tanggal_rilis' => 'required|valid_date',
            'deskripsi' => 'required|min_length[10]|max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validation->getErrors()));
        }

        // Here you would typically save to database
        // Example: $this->patchModel->save($this->request->getPost());

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Patch berhasil ditambahkan'
        ]);
    }

    private function getPatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !is_numeric($id)) {
            throw new \Exception('Invalid patch ID');
        }

        // Here you would typically fetch from database
        // Example: $patch = $this->patchModel->find($id);
        
        // Sample data for demonstration
        $patch = [
            'id' => $id,
            'nama_paket' => 'Sample Patch',
            'versi' => '1.0.0',
            'prioritas' => 'High',
            'ukuran' => '10 MB',
            'tanggal_rilis' => '2024-01-15',
            'deskripsi' => 'Sample description'
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $patch
        ]);
    }

    private function updatePatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !is_numeric($id)) {
            throw new \Exception('Invalid patch ID');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama_paket' => 'required|min_length[3]|max_length[255]',
            'versi' => 'required|min_length[1]|max_length[50]',
            'prioritas' => 'required|in_list[High,Medium,Low]',
            'ukuran' => 'required|min_length[1]|max_length[50]',
            'tanggal_rilis' => 'required|valid_date',
            'deskripsi' => 'required|min_length[10]|max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            throw new \Exception('Validation failed: ' . implode(', ', $validation->getErrors()));
        }

        // Here you would typically update in database
        // Example: $this->patchModel->update($id, $this->request->getPost());

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Patch berhasil diupdate'
        ]);
    }

    private function deletePatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !is_numeric($id)) {
            throw new \Exception('Invalid patch ID');
        }

        // Here you would typically delete from database
        // Example: $this->patchModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Patch berhasil dihapus'
        ]);
    }

    private function downloadPatch()
    {
        $id = $this->request->getPost('id');
        
        if (!$id || !is_numeric($id)) {
            throw new \Exception('Invalid patch ID');
        }

        // Here you would typically get patch info from database and update download count
        // Example: 
        // $patch = $this->patchModel->find($id);
        // $this->patchModel->incrementDownloadCount($id);

        $filename = 'patch_' . $id . '.7z';
        $downloadUrl = base_url('downloads/patches/' . $filename);

        return $this->response->setJSON([
            'success' => true,
            'download_url' => $downloadUrl,
            'filename' => $filename
        ]);
    }
}

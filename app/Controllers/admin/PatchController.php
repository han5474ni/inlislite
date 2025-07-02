<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatchModel;

class PatchController extends BaseController
{
    protected $patchModel;
    
    public function __construct()
    {
        $this->patchModel = new PatchModel();
    }
    
    public function index()
    {
        $patches = $this->patchModel->orderBy('release_date', 'DESC')->findAll();
        
        $data = [
            'title' => 'Patch Management - INLISLite v3',
            'patches' => $patches,
            'stats' => $this->patchModel->getStats()
        ];
        
        return view('admin/patch/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Create New Patch - INLISLite v3'
        ];
        
        return view('admin/patch/create', $data);
    }
    
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'version' => 'required|is_unique[patches.version]',
            'title' => 'required|min_length[5]|max_length[255]',
            'description' => 'required|min_length[10]',
            'release_date' => 'required|valid_date',
            'patch_file' => 'uploaded[patch_file]|max_size[patch_file,51200]|ext_in[patch_file,zip,tar,gz]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $file = $this->request->getFile('patch_file');
        $fileName = null;
        $fileSize = null;
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/patches/', $fileName);
            $fileSize = $this->formatBytes($file->getSize());
        }
        
        $data = [
            'version' => $this->request->getPost('version'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'changelog' => $this->request->getPost('changelog'),
            'release_date' => $this->request->getPost('release_date'),
            'is_critical' => $this->request->getPost('is_critical') ? 1 : 0,
            'file_path' => $fileName,
            'file_size' => $fileSize
        ];
        
        if ($this->patchModel->insert($data)) {
            return redirect()->to('/admin/patches')->with('success', 'Patch berhasil dibuat!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat patch');
        }
    }
    
    public function edit($id)
    {
        $patch = $this->patchModel->find($id);
        
        if (!$patch) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patch tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Patch - INLISLite v3',
            'patch' => $patch
        ];
        
        return view('admin/patch/edit', $data);
    }
    
    public function update($id)
    {
        $patch = $this->patchModel->find($id);
        
        if (!$patch) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patch tidak ditemukan');
        }
        
        $rules = [
            'version' => "required|is_unique[patches.version,id,{$id}]",
            'title' => 'required|min_length[5]|max_length[255]',
            'description' => 'required|min_length[10]',
            'release_date' => 'required|valid_date'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'version' => $this->request->getPost('version'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'changelog' => $this->request->getPost('changelog'),
            'release_date' => $this->request->getPost('release_date'),
            'is_critical' => $this->request->getPost('is_critical') ? 1 : 0
        ];
        
        // Handle file upload if new file is provided
        $file = $this->request->getFile('patch_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old file
            if ($patch['file_path'] && file_exists(WRITEPATH . 'uploads/patches/' . $patch['file_path'])) {
                unlink(WRITEPATH . 'uploads/patches/' . $patch['file_path']);
            }
            
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/patches/', $fileName);
            
            $data['file_path'] = $fileName;
            $data['file_size'] = $this->formatBytes($file->getSize());
        }
        
        if ($this->patchModel->update($id, $data)) {
            return redirect()->to('/admin/patches')->with('success', 'Patch berhasil diupdate!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate patch');
        }
    }
    
    public function delete($id)
    {
        $patch = $this->patchModel->find($id);
        
        if (!$patch) {
            return redirect()->back()->with('error', 'Patch tidak ditemukan');
        }
        
        // Delete file
        if ($patch['file_path'] && file_exists(WRITEPATH . 'uploads/patches/' . $patch['file_path'])) {
            unlink(WRITEPATH . 'uploads/patches/' . $patch['file_path']);
        }
        
        if ($this->patchModel->delete($id)) {
            return redirect()->to('/admin/patches')->with('success', 'Patch berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus patch');
        }
    }
    
    public function download($id)
    {
        $patch = $this->patchModel->find($id);
        
        if (!$patch || !$patch['file_path']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File patch tidak ditemukan');
        }
        
        $filePath = WRITEPATH . 'uploads/patches/' . $patch['file_path'];
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File patch tidak ditemukan');
        }
        
        // Increment download counter
        $this->patchModel->incrementDownload($id);
        
        return $this->response->download($filePath, null);
    }
    
    public function toggle($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        
        $patch = $this->patchModel->find($id);
        
        if (!$patch) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patch tidak ditemukan'
            ]);
        }
        
        $newStatus = $patch['is_active'] ? 0 : 1;
        
        if ($this->patchModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status patch berhasil diubah',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status patch'
            ]);
        }
    }
    
    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
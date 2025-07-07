<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfileModel;
use App\Models\ActivityLogModel;

class ProfileDebugController extends BaseController
{
    public function uploadPhoto()
    {
        try {
            log_message('info', 'ProfileDebugController::uploadPhoto called');
            
            // Debug: Check if file was uploaded
            $file = $this->request->getFile('profile_photo');
            
            if (!$file) {
                log_message('error', 'No file received in profile_photo field');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No file received',
                    'debug' => 'File object is null'
                ]);
            }
            
            log_message('info', 'File received: ' . $file->getName());
            log_message('info', 'File size: ' . $file->getSize());
            log_message('info', 'File type: ' . $file->getMimeType());
            log_message('info', 'File is valid: ' . ($file->isValid() ? 'yes' : 'no'));
            
            if (!$file->isValid()) {
                $error = $file->getErrorString();
                log_message('error', 'File validation failed: ' . $error);
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File tidak valid: ' . $error,
                    'debug' => [
                        'error_code' => $file->getError(),
                        'error_string' => $error,
                        'file_name' => $file->getName(),
                        'file_size' => $file->getSize()
                    ]
                ]);
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                log_message('error', 'Invalid file type: ' . $file->getMimeType());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, atau GIF',
                    'debug' => [
                        'received_type' => $file->getMimeType(),
                        'allowed_types' => $allowedTypes
                    ]
                ]);
            }
            
            // Validate file size (max 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                log_message('error', 'File too large: ' . $file->getSize());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ukuran file terlalu besar. Maksimal 2MB',
                    'debug' => [
                        'file_size' => $file->getSize(),
                        'max_size' => 2 * 1024 * 1024
                    ]
                ]);
            }
            
            // Create upload directory if not exists
            $uploadPath = ROOTPATH . 'archive/Images/profile';
            if (!is_dir($uploadPath)) {
                log_message('info', 'Creating upload directory: ' . $uploadPath);
                mkdir($uploadPath, 0755, true);
            }
            
            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'profile_debug_' . time() . '.' . $extension;
            
            log_message('info', 'Attempting to move file to: ' . $uploadPath . '/' . $filename);
            
            // Move file
            if ($file->move($uploadPath, $filename)) {
                log_message('info', 'File moved successfully');
                
                $photoUrl = base_url('images/profile/' . $filename);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Foto profil berhasil diupload!',
                    'photo_url' => $photoUrl,
                    'debug' => [
                        'filename' => $filename,
                        'upload_path' => $uploadPath,
                        'full_path' => $uploadPath . '/' . $filename,
                        'file_exists' => file_exists($uploadPath . '/' . $filename)
                    ]
                ]);
            } else {
                log_message('error', 'Failed to move file');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupload file',
                    'debug' => [
                        'upload_path' => $uploadPath,
                        'filename' => $filename,
                        'is_writable' => is_writable($uploadPath)
                    ]
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Exception in uploadPhoto: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'debug' => [
                    'exception' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }
    
    public function testUpload()
    {
        $data = [
            'title' => 'Profile Upload Test'
        ];
        
        return view('admin/profile_upload_test', $data);
    }
}
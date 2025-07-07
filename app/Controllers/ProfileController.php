<?php

namespace App\Controllers;

class ProfileController extends BaseController
{
    public function uploadPhoto()
    {
        // Set JSON response header
        $this->response->setContentType('application/json');
        
        try {
            log_message('info', 'Profile photo upload started');
            
            // Check if user is authenticated (for debugging)
            $session = \Config\Services::session();
            $isLoggedIn = $session->get('admin_logged_in');
            
            log_message('info', 'User authentication status: ' . ($isLoggedIn ? 'logged in' : 'not logged in'));
            
            // For now, skip authentication check for testing
            // In production, you should ensure proper authentication
            
            // Initialize models
            $profileModel = new \App\Models\ProfileModel();
            
            // Get the uploaded file
            $file = $this->request->getFile('profile_photo');
            
            // Validate file upload
            if (!$file || !$file->isValid() || $file->hasMoved()) {
                $error = $file ? $file->getErrorString() : 'No file received';
                log_message('error', 'File upload error: ' . $error);
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File upload error: ' . $error
                ]);
            }
            
            log_message('info', 'File details - Name: ' . $file->getName() . ', Size: ' . $file->getSize() . ', Type: ' . $file->getMimeType());
            
            // Validate file type
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $fileMime = $file->getMimeType();
            
            if (!in_array($fileMime, $allowedMimes)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File type not allowed. Please use JPG, PNG, or GIF'
                ]);
            }
            
            // Validate file size (max 2MB)
            $maxSize = 2 * 1024 * 1024; // 2MB
            if ($file->getSize() > $maxSize) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File size too large. Maximum 2MB allowed'
                ]);
            }
            
            // Create upload directory
            $uploadPath = FCPATH . 'uploads/profiles';
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0755, true)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to create upload directory'
                    ]);
                }
            }
            
            // Get current profile (try by username first)
            $currentProfile = $profileModel->getByUsername('admin');
            if (!$currentProfile) {
                // Try by ID as fallback
                $currentProfile = $profileModel->find(1);
            }
            
            if (!$currentProfile) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Profile not found'
                ]);
            }
            
            log_message('info', 'Found profile ID: ' . $currentProfile['id']);
            
            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'profile_' . $currentProfile['id'] . '_' . time() . '.' . $extension;
            
            // Move uploaded file
            if (!$file->move($uploadPath, $filename)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to move uploaded file'
                ]);
            }
            
            log_message('info', 'File moved successfully to: ' . $uploadPath . '/' . $filename);
            
            // Delete old photo if exists
            if (!empty($currentProfile['foto'])) {
                $oldPhotoPath = $uploadPath . '/' . $currentProfile['foto'];
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                    log_message('info', 'Deleted old photo: ' . $oldPhotoPath);
                }
            }
            
            // Update database
            $updateData = ['foto' => $filename];
            $result = $profileModel->update($currentProfile['id'], $updateData);
            
            if (!$result) {
                // If database update fails, delete the uploaded file
                if (file_exists($uploadPath . '/' . $filename)) {
                    unlink($uploadPath . '/' . $filename);
                }
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update database'
                ]);
            }
            
            log_message('info', 'Database updated successfully');
            
            // Log activity (optional, don't fail if this fails)
            try {
                $activityLogModel = new \App\Models\ActivityLogModel();
                $activityLogModel->logActivity(
                    $currentProfile['id'],
                    'photo_upload',
                    'User uploaded new profile photo: ' . $filename
                );
            } catch (\Exception $e) {
                log_message('warning', 'Failed to log activity: ' . $e->getMessage());
            }
            
            // Generate photo URL
            $photoUrl = base_url('uploads/profiles/' . $filename);
            
            log_message('info', 'Photo upload completed successfully. URL: ' . $photoUrl);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profile photo uploaded successfully!',
                'photo_url' => $photoUrl,
                'filename' => $filename
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Profile photo upload exception: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Test method to check if the controller is accessible
     */
    public function index()
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'ProfileController is accessible',
            'method' => $this->request->getMethod(),
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
}
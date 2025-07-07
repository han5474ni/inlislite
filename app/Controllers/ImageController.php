<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class ImageController extends BaseController
{
    /**
     * Serve profile images from archive folder
     */
    public function profile($filename)
    {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        
        // Build the full path to the image
        $imagePath = ROOTPATH . 'archive/Images/profile/' . $filename;
        
        // Check if file exists
        if (!file_exists($imagePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Get file info
        $fileInfo = pathinfo($imagePath);
        $extension = strtolower($fileInfo['extension']);
        
        // Set appropriate content type
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp'
        ];
        
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';
        
        // Set headers
        $this->response->setHeader('Content-Type', $contentType);
        $this->response->setHeader('Content-Length', filesize($imagePath));
        $this->response->setHeader('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year
        $this->response->setHeader('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        
        // Output the image
        $this->response->setBody(file_get_contents($imagePath));
        
        return $this->response;
    }
    
    /**
     * Serve any image from archive folder with security checks
     */
    public function serve($folder, $filename)
    {
        // Sanitize inputs
        $folder = basename($folder);
        $filename = basename($filename);
        
        // Only allow specific folders for security
        $allowedFolders = ['profile', 'documents', 'patches'];
        if (!in_array($folder, $allowedFolders)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Build the full path
        $imagePath = ROOTPATH . 'archive/Images/' . $folder . '/' . $filename;
        
        // Check if file exists
        if (!file_exists($imagePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Get file info
        $fileInfo = pathinfo($imagePath);
        $extension = strtolower($fileInfo['extension']);
        
        // Only allow image files
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($extension, $allowedExtensions)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Set appropriate content type
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp'
        ];
        
        $contentType = $mimeTypes[$extension];
        
        // Set headers
        $this->response->setHeader('Content-Type', $contentType);
        $this->response->setHeader('Content-Length', filesize($imagePath));
        $this->response->setHeader('Cache-Control', 'public, max-age=31536000'); // Cache for 1 year
        $this->response->setHeader('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        
        // Add security headers
        $this->response->setHeader('X-Content-Type-Options', 'nosniff');
        
        // Output the image
        $this->response->setBody(file_get_contents($imagePath));
        
        return $this->response;
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

class AplikasiPendukung extends BaseController
{
    protected $applications;

    public function __construct()
    {
        // Sample applications data - replace with your database model
        $this->applications = [
            'oai-pmh' => [
                'id' => 'oai-pmh',
                'name' => 'OAI-PMH Service',
                'description' => 'Protokol Interoperabilitas Arsip Terbuka untuk Pengambilan Metadata',
                'icon' => 'bi-diamond-fill',
                'color' => 'primary',
                'version' => '1.0.0',
                'size' => 'Built-in',
                'downloads' => 0
            ],
            'sms-gateway' => [
                'id' => 'sms-gateway',
                'name' => 'SMS Gateway Service',
                'description' => 'Pemberitahuan SMS otomatis menggunakan Gammu SMS Gateway',
                'icon' => 'bi-chat-square-text-fill',
                'color' => 'success',
                'version' => '1.33.0',
                'size' => '4 MB',
                'downloads' => 1250
            ],
            'rfid-gateway' => [
                'id' => 'rfid-gateway',
                'name' => 'RFID Gateway Service (SIP2)',
                'description' => 'Menghubungkan database INLISLite dengan terminal peminjaman mandiri berbasis RFID',
                'icon' => 'bi-wifi',
                'color' => 'info',
                'version' => '2.0.0',
                'size' => '208 KB',
                'downloads' => 890
            ],
            'data-migrator' => [
                'id' => 'data-migrator',
                'name' => 'Data Migrator (V212 to V3)',
                'description' => 'Utilitas desktop untuk memigrasi data dari INLISLite versi 2.1.2 ke versi 3',
                'icon' => 'bi-gear-fill',
                'color' => 'primary',
                'version' => '3.0.0',
                'size' => '179 KB',
                'downloads' => 567
            ],
            'elasticsearch' => [
                'id' => 'elasticsearch',
                'name' => 'Record Indexing (ElasticSearch)',
                'description' => 'Meningkatkan kecepatan pencarian OPAC melalui mesin ElasticSearch',
                'icon' => 'bi-search',
                'color' => 'primary',
                'version' => '6.2.2',
                'size' => '68.8 MB',
                'downloads' => 423
            ]
        ];
    }

    /**
     * Display applications page
     */
    public function index()
    {
        try {
            $data = [
                'title' => 'Aplikasi Pendukung',
                'applications' => $this->applications,
                'total_applications' => count($this->applications),
                'total_downloads' => array_sum(array_column($this->applications, 'downloads')),
                'error' => session('error'),
                'success' => session('success')
            ];

            return view('admin/aplikasi', $data);
        } catch (Exception $e) {
            log_message('error', 'AplikasiPendukung index error: ' . $e->getMessage());
            return view('admin/aplikasi', [
                'title' => 'Aplikasi Pendukung',
                'applications' => [],
                'error' => 'Terjadi kesalahan saat memuat data aplikasi.'
            ]);
        }
    }

    /**
     * Display application detail
     */
    public function detail($appId)
    {
        if (!isset($this->applications[$appId])) {
            throw new PageNotFoundException("Aplikasi tidak ditemukan");
        }

        $data = [
            'title' => $this->applications[$appId]['name'],
            'application' => $this->applications[$appId],
            'related_apps' => array_slice($this->applications, 0, 3)
        ];

        return view('aplikasi_detail', $data);
    }

    /**
     * Handle download requests
     */
    public function download($appId)
    {
        if (!isset($this->applications[$appId])) {
            return redirect()->back()->with('error', 'Aplikasi tidak ditemukan');
        }

        $app = $this->applications[$appId];
        
        // Log download
        log_message('info', "Application downloaded: {$app['name']} by user");

        // In a real application, you would:
        // 1. Increment download counter in database
        // 2. Generate actual download URL
        // 3. Track user downloads
        
        // For demo purposes, redirect to a placeholder
        $downloadUrl = $this->generateDownloadUrl($appId);
        
        return redirect()->to($downloadUrl)->with('success', "Download {$app['name']} dimulai");
    }

    /**
     * Handle AJAX requests
     */
    public function ajaxHandler()
    {
        if (!$this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => false,
                    'error' => 'Akses tidak sah. Hanya AJAX request yang diizinkan.'
                ]);
        }

        $action = $this->request->getPost('action');
        $appId = $this->request->getPost('app_id');

        try {
            switch ($action) {
                case 'get_info':
                    return $this->handleGetInfo($appId);
                
                case 'download':
                    return $this->handleDownloadAction($appId);
                
                case 'get_stats':
                    return $this->handleGetStats();
                
                default:
                    return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'success' => false,
                            'error' => 'Aksi tidak dikenali: ' . esc($action)
                        ]);
            }
        } catch (Exception $e) {
            log_message('error', 'AplikasiPendukung AJAX error: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'error' => 'Terjadi kesalahan server.'
                ]);
        }
    }

    /**
     * Handle get application info
     */
    private function handleGetInfo($appId)
    {
        if (!isset($this->applications[$appId])) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'error' => 'Aplikasi tidak ditemukan.'
                ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $this->applications[$appId]
        ]);
    }

    /**
     * Handle download action via AJAX
     */
    private function handleDownloadAction($appId)
    {
        if (!isset($this->applications[$appId])) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'error' => 'Aplikasi tidak ditemukan.'
                ]);
        }

        $app = $this->applications[$appId];
        
        // Generate download URL
        $downloadUrl = $this->generateDownloadUrl($appId);
        
        // Log download
        log_message('info', "Application downloaded via AJAX: {$app['name']}");

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Download dimulai.',
            'data' => [
                'download_url' => $downloadUrl,
                'filename' => $this->generateFilename($app),
                'app_name' => $app['name']
            ]
        ]);
    }

    /**
     * Handle get statistics
     */
    private function handleGetStats()
    {
        $stats = [
            'total_applications' => count($this->applications),
            'total_downloads' => array_sum(array_column($this->applications, 'downloads')),
            'most_downloaded' => $this->getMostDownloaded(),
            'latest_version' => $this->getLatestVersion()
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Generate download URL
     */
    private function generateDownloadUrl($appId)
    {
        // In a real application, this would generate actual download URLs
        // For demo purposes, return a placeholder
        return base_url("downloads/applications/{$appId}.zip");
    }

    /**
     * Generate filename for download
     */
    private function generateFilename($app)
    {
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $app['name']);
        return $safeName . '_v' . $app['version'] . '.zip';
    }

    /**
     * Get most downloaded application
     */
    private function getMostDownloaded()
    {
        $mostDownloaded = null;
        $maxDownloads = 0;

        foreach ($this->applications as $app) {
            if ($app['downloads'] > $maxDownloads) {
                $maxDownloads = $app['downloads'];
                $mostDownloaded = $app;
            }
        }

        return $mostDownloaded;
    }

    /**
     * Get latest version info
     */
    private function getLatestVersion()
    {
        // Return version info for the main system
        return [
            'version' => '3.0.0',
            'release_date' => '2024-01-15',
            'changelog_url' => base_url('changelog')
        ];
    }
}

<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\TentangCardModel;
use App\Models\FiturModel;
use App\Models\InstallerCardModel;
use App\Models\PatchModel;
use App\Models\AplikasiModel;
use App\Models\PanduanModel;
use App\Models\DukunganModel;
use App\Models\BimbinganModel;
use App\Models\DemoModel;

class PublicController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'INLISLite v3 - Sistem Otomasi Perpustakaan',
            'page_title' => 'Home',
            'meta_description' => 'Sistem otomasi perpustakaan modern dengan teknologi terdepan untuk mengelola perpustakaan secara digital dan terintegrasi.'
        ];
        
        return view('public/homepage', $data);
    }
    
    public function tentang()
    {
        try {
            $tentangModel = new TentangCardModel();
            $aboutContent = $tentangModel->getActiveCards();
        } catch (\Exception $e) {
            log_message('error', 'Error loading tentang data: ' . $e->getMessage());
            $aboutContent = $this->getDefaultAboutContent();
        }
        
        $data = [
            'title' => 'Tentang Kami - INLISLite v3',
            'page_title' => 'Tentang Kami',
            'meta_description' => 'Informasi lengkap tentang INLISLite v3, sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional RI.',
            'about_content' => $aboutContent
        ];
        
        return view('public/tentang_dynamic', $data);
    }
    
    public function fitur()
    {
        try {
            $fiturModel = new FiturModel();
            
            $features = $fiturModel->getFeatures('active');
            $modules = $fiturModel->getModules('active');
            
            // Combine and sort by sort_order
            $allItems = array_merge($features, $modules);
            usort($allItems, function($a, $b) {
                return $a['sort_order'] - $b['sort_order'];
            });
            
        } catch (\Exception $e) {
            log_message('error', 'Error loading fitur data: ' . $e->getMessage());
            $features = $this->getDefaultFeatures();
            $modules = $this->getDefaultModules();
            $allItems = array_merge($features, $modules);
        }
        
        $data = [
            'title' => 'Fitur & Modul - INLISLite v3',
            'page_title' => 'Fitur & Modul',
            'meta_description' => 'Fitur lengkap dan modul-modul canggih dalam sistem INLISLite v3 untuk manajemen perpustakaan modern.',
            'features' => $features ?? [],
            'modules' => $modules ?? [],
            'all_items' => $allItems
        ];
        
        return view('public/fitur', $data);
    }
    
    public function installer()
    {
        try {
            $installerModel = new InstallerCardModel();
            $packages = $installerModel->where('status', 'active')
                                      ->orderBy('sort_order', 'ASC')
                                      ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading installer data: ' . $e->getMessage());
            $packages = $this->getDefaultInstallerPackages();
        }
        
        $data = [
            'title' => 'Installer - INLISLite v3',
            'page_title' => 'Installer',
            'meta_description' => 'Download installer dan paket instalasi INLISLite v3. Dapatkan sistem perpustakaan terbaru.',
            'packages' => $packages
        ];
        
        return view('public/installer', $data);
    }
    
    public function patch()
    {
        try {
            $patchModel = new PatchModel();
            $patches = $patchModel->where('status', 'active')
                                 ->orderBy('tanggal_rilis', 'DESC')
                                 ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading patch data: ' . $e->getMessage());
            $patches = $this->getDefaultPatchData();
        }
        
        $data = [
            'title' => 'Patch & Updater - INLISLite v3',
            'page_title' => 'Patch & Updater',
            'meta_description' => 'Download patch dan update terbaru untuk INLISLite v3. Dapatkan fitur terbaru dan perbaikan bug.',
            'patches' => $patches,
            'current_version' => '3.0.5',
            'latest_version' => '3.0.8'
        ];
        
        return view('public/patch', $data);
    }
    
    public function aplikasi()
    {
        try {
            $aplikasiModel = new AplikasiModel();
            $applications = $aplikasiModel->where('status', 'active')
                                         ->orderBy('sort_order', 'ASC')
                                         ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading aplikasi data: ' . $e->getMessage());
            $applications = $this->getDefaultApplicationData();
        }
        
        $data = [
            'title' => 'Aplikasi Pendukung - INLISLite v3',
            'page_title' => 'Aplikasi Pendukung',
            'meta_description' => 'Download aplikasi pendukung dan tools untuk INLISLite v3. Tingkatkan produktivitas dengan aplikasi tambahan.',
            'applications' => $applications
        ];
        
        return view('public/aplikasi', $data);
    }
    
    public function panduan()
    {
        try {
            $panduanModel = new PanduanModel();
            $guides = $panduanModel->where('status', 'active')
                                  ->orderBy('sort_order', 'ASC')
                                  ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading panduan data: ' . $e->getMessage());
            $guides = $this->getDefaultGuideData();
        }
        
        $data = [
            'title' => 'Panduan - INLISLite v3',
            'page_title' => 'Panduan',
            'meta_description' => 'Panduan lengkap instalasi, konfigurasi, dan penggunaan INLISLite v3. Tutorial step-by-step untuk pemula.',
            'guides' => $guides
        ];
        
        return view('public/panduan', $data);
    }
    
    public function dukungan()
    {
        try {
            $dukunganModel = new DukunganModel();
            $supportChannels = $dukunganModel->where('status', 'active')
                                            ->orderBy('sort_order', 'ASC')
                                            ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading dukungan data: ' . $e->getMessage());
            $supportChannels = $this->getDefaultSupportChannels();
        }
        
        $data = [
            'title' => 'Dukungan Teknis - INLISLite v3',
            'page_title' => 'Dukungan Teknis',
            'meta_description' => 'Dapatkan dukungan teknis untuk INLISLite v3. Tim support siap membantu mengatasi masalah teknis Anda.',
            'support_channels' => $supportChannels,
            'faq' => $this->getDefaultFaqData()
        ];
        
        return view('public/dukungan', $data);
    }
    
    public function bimbingan()
    {
        try {
            $bimbinganModel = new BimbinganModel();
            $trainingPrograms = $bimbinganModel->where('status', 'active')
                                              ->orderBy('sort_order', 'ASC')
                                              ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading bimbingan data: ' . $e->getMessage());
            $trainingPrograms = $this->getDefaultTrainingPrograms();
        }
        
        $data = [
            'title' => 'Bimbingan Teknis - INLISLite v3',
            'page_title' => 'Bimbingan Teknis',
            'meta_description' => 'Layanan bimbingan teknis dan pelatihan untuk INLISLite v3. Tingkatkan kemampuan tim perpustakaan Anda.',
            'training_programs' => $trainingPrograms,
            'schedules' => $this->getDefaultTrainingSchedules()
        ];
        
        return view('public/bimbingan', $data);
    }
    
    public function demo()
    {
        try {
            $demoModel = new DemoModel();
            $demos = $demoModel->where('status', 'active')
                              ->orderBy('sort_order', 'ASC')
                              ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error loading demo data: ' . $e->getMessage());
            $demos = $this->getDefaultDemoPrograms();
        }
        
        $data = [
            'title' => 'Demo Program - INLISLite v3',
            'page_title' => 'Demo Program',
            'meta_description' => 'Coba demo INLISLite v3 secara online. Jelajahi fitur-fitur lengkap sebelum menggunakan sistem.',
            'demos' => $demos
        ];
        
        return view('public/demo', $data);
    }
    
    /**
     * Get demo details by ID
     * 
     * @param int $id Demo ID
     * @return \CodeIgniter\HTTP\Response
     */
    public function demoDetails($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID demo tidak valid'
            ]);
        }
        
        try {
            $demoModel = new DemoModel();
            $demo = $demoModel->find($id);
            
            if (!$demo) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Demo tidak ditemukan'
                ]);
            }
            
            // Increment view count
            $demoModel->update($id, [
                'view_count' => ($demo['view_count'] ?? 0) + 1
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'demo' => $demo
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting demo details: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat detail demo'
            ]);
        }
    }
    
    /**
     * Download demo file
     * 
     * @param int $id Demo ID
     * @return \CodeIgniter\HTTP\DownloadResponse|\CodeIgniter\HTTP\Response
     */
    public function downloadDemo($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID demo tidak valid'
            ]);
        }
        
        try {
            $demoModel = new DemoModel();
            $demo = $demoModel->find($id);
            
            if (!$demo || !isset($demo['file_path']) || !isset($demo['file_name'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File demo tidak ditemukan'
                ]);
            }
            
            $filePath = FCPATH . $demo['file_path'];
            
            if (!file_exists($filePath)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File demo tidak ditemukan di server'
                ]);
            }
            
            // Track download
            $demoModel->update($id, [
                'download_count' => ($demo['download_count'] ?? 0) + 1
            ]);
            
            return $this->response->download($filePath, null);
        } catch (\Exception $e) {
            log_message('error', 'Error downloading demo file: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengunduh file demo'
            ]);
        }
    }
    
    /**
     * Track demo access
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function trackDemoAccess()
    {
        $url = $this->request->getJSON(true)['url'] ?? null;
        
        if (!$url) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'URL tidak valid'
            ]);
        }
        
        // Log access for analytics
        log_message('info', 'Demo accessed: ' . $url);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Akses demo berhasil dicatat'
        ]);
    }
    
    // Default/fallback data methods
    private function getDefaultAboutContent()
    {
        return [
            [
                'id' => 1,
                'title' => 'INLISLite Version 3',
                'subtitle' => 'Library Automation System Overview',
                'content' => 'INLISLite Version 3 adalah sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia.',
                'icon' => 'bi-info-circle'
            ]
        ];
    }
    
    private function getDefaultFeatures()
    {
        return [
            [
                'id' => 1,
                'title' => 'Katalogisasi',
                'description' => 'Sistem katalogisasi digital dengan standar MARC21',
                'icon' => 'bi-book',
                'color' => 'blue',
                'type' => 'feature',
                'sort_order' => 1
            ]
        ];
    }
    
    private function getDefaultModules()
    {
        return [
            [
                'id' => 1,
                'title' => 'Portal Aplikasi',
                'description' => 'Navigasi utama ke semua modul sistem',
                'icon' => 'bi-house-door',
                'color' => 'green',
                'type' => 'module',
                'module_type' => 'application',
                'sort_order' => 2
            ]
        ];
    }
    
    private function getDefaultInstallerPackages()
    {
        return [
            [
                'id' => 1,
                'nama_paket' => 'INLISLite v3.0 Full Package',
                'deskripsi' => 'Paket lengkap instalasi INLISLite v3.0',
                'versi' => '3.0.0',
                'ukuran' => '25 MB',
                'tipe' => 'installer'
            ]
        ];
    }
    
    private function getDefaultPatchData()
    {
        return [
            [
                'id' => 1,
                'nama_patch' => 'Security Update v3.0.8',
                'versi' => '3.0.8',
                'deskripsi' => 'Update keamanan terbaru',
                'ukuran' => '12 MB',
                'prioritas' => 'high'
            ]
        ];
    }
    
    private function getDefaultApplicationData()
    {
        return [
            [
                'id' => 1,
                'nama_aplikasi' => 'INLISLite Desktop Client',
                'deskripsi' => 'Aplikasi desktop untuk akses offline',
                'versi' => '3.0.5',
                'platform' => 'Windows'
            ]
        ];
    }
    
    private function getDefaultGuideData()
    {
        return [
            [
                'id' => 1,
                'title' => 'Panduan Instalasi',
                'description' => 'Panduan lengkap instalasi INLISLite v3',
                'category' => 'installation'
            ]
        ];
    }
    
    private function getDefaultSupportChannels()
    {
        return [
            [
                'id' => 1,
                'title' => 'Email Support',
                'description' => 'Kirim pertanyaan melalui email',
                'contact_info' => 'support@inlislite.perpusnas.go.id',
                'response_time' => '24 jam'
            ]
        ];
    }
    
    private function getDefaultTrainingPrograms()
    {
        return [
            [
                'id' => 1,
                'title' => 'Basic Training',
                'description' => 'Pelatihan dasar penggunaan INLISLite v3',
                'duration' => '2 hari',
                'price' => 'Gratis'
            ]
        ];
    }
    
    private function getDefaultDemoPrograms()
    {
        return [
            [
                'id' => 1,
                'title' => 'Demo INLISLite v3 Opensource',
                'description' => 'Platform demo lengkap untuk sistem manajemen perpustakaan',
                'platform' => 'PHP Open Source',
                'version' => 'v3.0'
            ]
        ];
    }
    
    private function getDefaultFaqData()
    {
        return [
            [
                'question' => 'Bagaimana cara menginstall INLISLite v3?',
                'answer' => 'Anda dapat mengikuti panduan instalasi lengkap di halaman Panduan.'
            ]
        ];
    }
    
    private function getDefaultTrainingSchedules()
    {
        return [
            [
                'date' => '2024-02-15',
                'program' => 'Basic Training',
                'location' => 'Jakarta',
                'registered' => 12,
                'capacity' => 25,
                'status' => 'Available'
            ],
            [
                'date' => '2024-03-05',
                'program' => 'Advanced Cataloguing',
                'location' => 'Bandung',
                'registered' => 25,
                'capacity' => 25,
                'status' => 'Full'
            ],
            [
                'date' => '2024-03-20',
                'program' => 'Digital Library Management',
                'location' => 'Yogyakarta',
                'registered' => 5,
                'capacity' => 20,
                'status' => 'Available'
            ]
        ];
    }
}
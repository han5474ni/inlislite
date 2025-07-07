<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        $data = [
            'title' => 'Tentang Kami - INLISLite v3',
            'page_title' => 'Tentang Kami',
            'meta_description' => 'Informasi lengkap tentang INLISLite v3, sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional RI.',
            'about_content' => $this->getAboutContent()
        ];
        
        return view('public/tentang', $data);
    }
    
    public function patch()
    {
        $data = [
            'title' => 'Patch & Updater - INLISLite v3',
            'page_title' => 'Patch & Updater',
            'meta_description' => 'Download patch dan update terbaru untuk INLISLite v3. Dapatkan fitur terbaru dan perbaikan bug.',
            'patches' => $this->getPatchData(),
            'current_version' => '3.0.5',
            'latest_version' => '3.0.8'
        ];
        
        return view('public/patch', $data);
    }
    
    public function aplikasi()
    {
        $data = [
            'title' => 'Aplikasi Pendukung - INLISLite v3',
            'page_title' => 'Aplikasi Pendukung',
            'meta_description' => 'Download aplikasi pendukung dan tools untuk INLISLite v3. Tingkatkan produktivitas dengan aplikasi tambahan.',
            'applications' => $this->getApplicationData()
        ];
        
        return view('public/aplikasi', $data);
    }
    
    public function panduan()
    {
        $data = [
            'title' => 'Panduan - INLISLite v3',
            'page_title' => 'Panduan',
            'meta_description' => 'Panduan lengkap instalasi, konfigurasi, dan penggunaan INLISLite v3. Tutorial step-by-step untuk pemula.',
            'guides' => $this->getGuideData()
        ];
        
        return view('public/panduan', $data);
    }
    
    public function dukungan()
    {
        $data = [
            'title' => 'Dukungan Teknis - INLISLite v3',
            'page_title' => 'Dukungan Teknis',
            'meta_description' => 'Dapatkan dukungan teknis untuk INLISLite v3. Tim support siap membantu mengatasi masalah teknis Anda.',
            'support_channels' => $this->getSupportChannels(),
            'faq' => $this->getFaqData()
        ];
        
        return view('public/dukungan', $data);
    }
    
    public function bimbingan()
    {
        $data = [
            'title' => 'Bimbingan Teknis - INLISLite v3',
            'page_title' => 'Bimbingan Teknis',
            'meta_description' => 'Layanan bimbingan teknis dan pelatihan untuk INLISLite v3. Tingkatkan kemampuan tim perpustakaan Anda.',
            'training_programs' => $this->getTrainingPrograms(),
            'schedules' => $this->getTrainingSchedules()
        ];
        
        return view('public/bimbingan', $data);
    }
    
    public function demo()
    {
        $data = [
            'title' => 'Demo Program - INLISLite v3',
            'page_title' => 'Demo Program',
            'meta_description' => 'Coba demo INLISLite v3 secara online. Jelajahi fitur-fitur lengkap sebelum menggunakan sistem.',
            'demos' => $this->getDemoPrograms()
        ];
        
        return view('public/demo', $data);
    }
    
    private function getAboutContent()
    {
        return [
            [
                'id' => 1,
                'title' => 'INLISLite Version 3',
                'subtitle' => 'Library Automation System Overview',
                'content' => 'INLISLite Version 3 adalah sistem otomasi perpustakaan yang dikembangkan oleh Perpustakaan Nasional Republik Indonesia. Sistem ini dirancang untuk membantu perpustakaan dalam mengelola koleksi, anggota, dan layanan perpustakaan secara digital dan terintegrasi.\n\nDengan teknologi terkini dan antarmuka yang user-friendly, INLISLite v3 memberikan solusi komprehensif untuk kebutuhan manajemen perpustakaan modern.',
                'icon' => 'bi-info-circle'
            ],
            [
                'id' => 2,
                'title' => 'Legal Framework',
                'subtitle' => 'Dasar Hukum dan Regulasi',
                'content' => '• Undang-Undang Nomor 43 Tahun 2007 tentang Perpustakaan\n• Peraturan Pemerintah Nomor 24 Tahun 2014 tentang Pelaksanaan UU Perpustakaan\n• Peraturan Kepala Perpustakaan Nasional RI tentang Standar Nasional Perpustakaan\n• Kebijakan pengembangan sistem informasi perpustakaan nasional',
                'icon' => 'bi-shield-check'
            ],
            [
                'id' => 3,
                'title' => 'Key Features',
                'subtitle' => 'Fitur Utama Sistem',
                'content' => '• Katalogisasi: Sistem katalog digital dengan standar internasional\n• Sirkulasi: Manajemen peminjaman dan pengembalian otomatis\n• Keanggotaan: Pengelolaan data anggota perpustakaan\n• Inventarisasi: Tracking dan monitoring koleksi perpustakaan\n• Laporan: Sistem pelaporan komprehensif dan real-time\n• OPAC: Online Public Access Catalog untuk pencarian koleksi',
                'icon' => 'bi-gear'
            ],
            [
                'id' => 4,
                'title' => 'System Requirements',
                'subtitle' => 'Kebutuhan Sistem Minimum',
                'content' => 'Server Requirements:\n• Operating System: Linux/Windows Server\n• Web Server: Apache/Nginx\n• Database: MySQL/PostgreSQL\n• PHP Version: 8.0 atau lebih tinggi\n• Memory: Minimum 4GB RAM\n• Storage: Minimum 20GB free space\n\nClient Requirements:\n• Web Browser: Chrome, Firefox, Safari, Edge (versi terbaru)\n• JavaScript: Enabled\n• Internet Connection: Stable broadband',
                'icon' => 'bi-cpu'
            ]
        ];
    }
    
    private function getPatchData()
    {
        return [
            [
                'version' => '3.0.8',
                'release_date' => '2024-01-15',
                'type' => 'Major Update',
                'size' => '45.2 MB',
                'description' => 'Update besar dengan fitur baru dan perbaikan performa',
                'features' => [
                    'Fitur backup otomatis',
                    'Peningkatan keamanan sistem',
                    'Interface baru untuk mobile',
                    'Optimasi database query'
                ],
                'download_url' => '#',
                'status' => 'latest'
            ],
            [
                'version' => '3.0.7',
                'release_date' => '2024-01-01',
                'type' => 'Security Update',
                'size' => '12.8 MB',
                'description' => 'Perbaikan keamanan dan bug fixes',
                'features' => [
                    'Perbaikan vulnerability XSS',
                    'Update library dependencies',
                    'Perbaikan bug pada modul sirkulasi'
                ],
                'download_url' => '#',
                'status' => 'stable'
            ],
            [
                'version' => '3.0.6',
                'release_date' => '2023-12-15',
                'type' => 'Feature Update',
                'size' => '28.5 MB',
                'description' => 'Penambahan fitur baru dan peningkatan UX',
                'features' => [
                    'Modul pelaporan advanced',
                    'Export data ke Excel',
                    'Notifikasi email otomatis',
                    'Dashboard analytics'
                ],
                'download_url' => '#',
                'status' => 'stable'
            ]
        ];
    }
    
    private function getApplicationData()
    {
        return [
            [
                'name' => 'INLISLite Desktop Client',
                'version' => '3.0.5',
                'platform' => 'Windows',
                'size' => '125 MB',
                'description' => 'Aplikasi desktop untuk akses offline dan sinkronisasi data',
                'features' => [
                    'Mode offline',
                    'Sinkronisasi otomatis',
                    'Backup lokal',
                    'Print management'
                ],
                'download_url' => '#',
                'icon' => 'bi-laptop'
            ],
            [
                'name' => 'INLISLite Mobile App',
                'version' => '1.2.0',
                'platform' => 'Android/iOS',
                'size' => '45 MB',
                'description' => 'Aplikasi mobile untuk akses perpustakaan di mana saja',
                'features' => [
                    'Pencarian katalog',
                    'Reservasi buku',
                    'Notifikasi push',
                    'QR Code scanner'
                ],
                'download_url' => '#',
                'icon' => 'bi-phone'
            ],
            [
                'name' => 'Barcode Generator',
                'version' => '2.1.0',
                'platform' => 'Web/Desktop',
                'size' => '15 MB',
                'description' => 'Tool untuk generate barcode dan label buku',
                'features' => [
                    'Multiple barcode formats',
                    'Batch generation',
                    'Custom templates',
                    'Print preview'
                ],
                'download_url' => '#',
                'icon' => 'bi-upc-scan'
            ],
            [
                'name' => 'Data Migration Tool',
                'version' => '1.5.0',
                'platform' => 'Windows/Linux',
                'size' => '32 MB',
                'description' => 'Tool untuk migrasi data dari sistem lama',
                'features' => [
                    'Multiple format support',
                    'Data validation',
                    'Progress tracking',
                    'Error reporting'
                ],
                'download_url' => '#',
                'icon' => 'bi-arrow-left-right'
            ]
        ];
    }
    
    private function getGuideData()
    {
        return [
            [
                'category' => 'Installation',
                'title' => 'Panduan Instalasi',
                'icon' => 'bi-download',
                'guides' => [
                    [
                        'title' => 'Instalasi Server Requirements',
                        'description' => 'Persiapan server dan environment untuk INLISLite v3',
                        'duration' => '30 menit',
                        'difficulty' => 'Beginner',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Instalasi Database',
                        'description' => 'Setup dan konfigurasi database MySQL/PostgreSQL',
                        'duration' => '45 menit',
                        'difficulty' => 'Intermediate',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Instalasi Aplikasi',
                        'description' => 'Install dan konfigurasi aplikasi INLISLite v3',
                        'duration' => '60 menit',
                        'difficulty' => 'Intermediate',
                        'url' => '#'
                    ]
                ]
            ],
            [
                'category' => 'Configuration',
                'title' => 'Konfigurasi Sistem',
                'icon' => 'bi-gear',
                'guides' => [
                    [
                        'title' => 'Konfigurasi Dasar',
                        'description' => 'Setting awal sistem dan parameter dasar',
                        'duration' => '20 menit',
                        'difficulty' => 'Beginner',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Konfigurasi User & Permission',
                        'description' => 'Setup user, role, dan permission sistem',
                        'duration' => '40 menit',
                        'difficulty' => 'Intermediate',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Konfigurasi Advanced',
                        'description' => 'Setting lanjutan untuk optimasi performa',
                        'duration' => '90 menit',
                        'difficulty' => 'Advanced',
                        'url' => '#'
                    ]
                ]
            ],
            [
                'category' => 'Usage',
                'title' => 'Panduan Penggunaan',
                'icon' => 'bi-book',
                'guides' => [
                    [
                        'title' => 'Modul Katalogisasi',
                        'description' => 'Cara menggunakan fitur katalogisasi buku',
                        'duration' => '45 menit',
                        'difficulty' => 'Beginner',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Modul Sirkulasi',
                        'description' => 'Panduan peminjaman dan pengembalian buku',
                        'duration' => '30 menit',
                        'difficulty' => 'Beginner',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Modul Pelaporan',
                        'description' => 'Generate dan customize laporan sistem',
                        'duration' => '60 menit',
                        'difficulty' => 'Intermediate',
                        'url' => '#'
                    ]
                ]
            ]
        ];
    }
    
    private function getSupportChannels()
    {
        return [
            [
                'name' => 'Email Support',
                'description' => 'Kirim pertanyaan melalui email untuk mendapat bantuan',
                'contact' => 'support@inlislite.perpusnas.go.id',
                'response_time' => '24 jam',
                'availability' => '24/7',
                'icon' => 'bi-envelope'
            ],
            [
                'name' => 'Live Chat',
                'description' => 'Chat langsung dengan tim support',
                'contact' => 'Chat Widget',
                'response_time' => '5 menit',
                'availability' => 'Senin-Jumat 08:00-17:00',
                'icon' => 'bi-chat-dots'
            ],
            [
                'name' => 'Phone Support',
                'description' => 'Hubungi hotline untuk bantuan urgent',
                'contact' => '+62-21-xxxx-xxxx',
                'response_time' => 'Langsung',
                'availability' => 'Senin-Jumat 08:00-17:00',
                'icon' => 'bi-telephone'
            ],
            [
                'name' => 'Forum Komunitas',
                'description' => 'Diskusi dengan komunitas pengguna INLISLite',
                'contact' => 'forum.inlislite.perpusnas.go.id',
                'response_time' => 'Bervariasi',
                'availability' => '24/7',
                'icon' => 'bi-people'
            ]
        ];
    }
    
    private function getFaqData()
    {
        return [
            [
                'question' => 'Bagaimana cara menginstall INLISLite v3?',
                'answer' => 'Anda dapat mengikuti panduan instalasi lengkap di halaman Panduan. Pastikan server memenuhi system requirements yang diperlukan.'
            ],
            [
                'question' => 'Apakah INLISLite v3 gratis?',
                'answer' => 'Ya, INLISLite v3 adalah software open source yang dapat digunakan secara gratis oleh perpustakaan di Indonesia.'
            ],
            [
                'question' => 'Bagaimana cara backup data?',
                'answer' => 'Sistem menyediakan fitur backup otomatis dan manual. Anda dapat mengatur jadwal backup di menu Administrasi > Backup.'
            ],
            [
                'question' => 'Apakah bisa import data dari sistem lama?',
                'answer' => 'Ya, tersedia tool migrasi data yang mendukung berbagai format dari sistem perpustakaan lama.'
            ]
        ];
    }
    
    private function getTrainingPrograms()
    {
        return [
            [
                'title' => 'Basic Training',
                'description' => 'Pelatihan dasar penggunaan INLISLite v3',
                'duration' => '2 hari',
                'participants' => 'Max 20 orang',
                'price' => 'Gratis',
                'topics' => [
                    'Pengenalan sistem',
                    'Modul katalogisasi',
                    'Modul sirkulasi',
                    'Manajemen anggota'
                ]
            ],
            [
                'title' => 'Advanced Training',
                'description' => 'Pelatihan lanjutan untuk administrator',
                'duration' => '3 hari',
                'participants' => 'Max 15 orang',
                'price' => 'Rp 500.000/orang',
                'topics' => [
                    'Konfigurasi advanced',
                    'Customization sistem',
                    'Troubleshooting',
                    'Performance tuning'
                ]
            ],
            [
                'title' => 'Train the Trainer',
                'description' => 'Pelatihan untuk calon trainer internal',
                'duration' => '5 hari',
                'participants' => 'Max 10 orang',
                'price' => 'Rp 1.500.000/orang',
                'topics' => [
                    'Metodologi pelatihan',
                    'Materi training',
                    'Praktik mengajar',
                    'Sertifikasi trainer'
                ]
            ]
        ];
    }
    
    private function getTrainingSchedules()
    {
        return [
            [
                'date' => '2024-02-15',
                'program' => 'Basic Training',
                'location' => 'Jakarta',
                'status' => 'Available',
                'registered' => 12,
                'capacity' => 20
            ],
            [
                'date' => '2024-02-22',
                'program' => 'Advanced Training',
                'location' => 'Surabaya',
                'status' => 'Available',
                'registered' => 8,
                'capacity' => 15
            ],
            [
                'date' => '2024-03-01',
                'program' => 'Basic Training',
                'location' => 'Medan',
                'status' => 'Full',
                'registered' => 20,
                'capacity' => 20
            ]
        ];
    }
    
    private function getDemoPrograms()
    {
        return [
            [
                'id' => 1,
                'title' => 'Demo INLISLite v3 Opensource',
                'description' => 'Platform demo lengkap untuk sistem manajemen perpustakaan INLISLite versi 3 dengan teknologi PHP dan MySQL.',
                'platform' => 'PHP Open Source',
                'version' => 'v3.0',
                'url' => 'https://demo.inlislite.perpusnas.go.id',
                'username' => 'admin',
                'password' => 'demo123',
                'features' => [
                    'Katalogisasi lengkap',
                    'Sistem sirkulasi',
                    'Manajemen anggota',
                    'Laporan dan statistik',
                    'OPAC (Online Public Access Catalog)'
                ]
            ],
            [
                'id' => 2,
                'title' => 'Demo INLISLite .NET Framework',
                'description' => 'Demo sistem perpustakaan berbasis .NET Framework dengan fitur enterprise dan performa tinggi.',
                'platform' => '.NET Framework',
                'version' => 'v2.5',
                'url' => 'https://demo-net.inlislite.perpusnas.go.id',
                'username' => 'administrator',
                'password' => 'demo456',
                'features' => [
                    'Interface Windows Forms',
                    'Integrasi database SQL Server',
                    'Sistem backup otomatis',
                    'Multi-user support',
                    'Reporting tools'
                ]
            ],
            [
                'id' => 3,
                'title' => 'Demo Mobile App INLISLite',
                'description' => 'Aplikasi mobile untuk akses perpustakaan digital dengan fitur pencarian dan peminjaman online.',
                'platform' => 'Mobile App',
                'version' => 'v1.2',
                'url' => 'https://mobile-demo.inlislite.perpusnas.go.id',
                'username' => 'user',
                'password' => 'mobile123',
                'features' => [
                    'Pencarian katalog mobile',
                    'Reservasi buku online',
                    'Notifikasi push',
                    'Riwayat peminjaman',
                    'QR Code scanner'
                ]
            ],
            [
                'id' => 4,
                'title' => 'Demo OPAC Public',
                'description' => 'Demo Online Public Access Catalog untuk akses publik ke katalog perpustakaan.',
                'platform' => 'Web Public',
                'version' => 'v3.0',
                'url' => 'https://opac-demo.inlislite.perpusnas.go.id',
                'username' => 'guest',
                'password' => 'public123',
                'features' => [
                    'Pencarian advanced',
                    'Filter kategori',
                    'Detail koleksi',
                    'Informasi ketersediaan',
                    'Wishlist dan favorit'
                ]
            ]
        ];
    }
}
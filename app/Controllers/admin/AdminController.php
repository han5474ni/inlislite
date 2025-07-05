<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    protected $session;
    
    public function __construct()
    {
        $this->session = \Config\Services::session();
        // Add authentication check here when implemented
    }
    
    public function index()
    {
        $data = [
            'title' => 'Admin Dashboard - INLISLite v3',
            'page_title' => 'Admin Dashboard',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda'
        ];
        
        return view('admin/dashboard', $data);
    }
    
    public function modernDashboard()
    {
        $data = [
            'title' => 'INLISLite v3.0 Dashboard - Sistem Perpustakaan Modern',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('admin/modern_dashboard', $data);
    }
    
    public function login()
    {
        $data = [
            'title' => 'Admin Login - INLISLite v3'
        ];
        
        return view('admin/login', $data);
    }
    
    public function logout()
    {
        // Implement logout logic
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
    
    public function tentang()
    {
        $data = [
            'title' => 'About INLISLite Version 3 - INLISlite v3.0',
            'page_title' => 'About INLISLite Version 3',
            'page_subtitle' => 'Detailed information about the library automation system'
        ];
        
        return view('admin/tentang', $data);
    }
    
    public function patch_updater()
    {
        $data = [
            'title' => 'Patch and Updater - INLISlite v3.0',
            'page_title' => 'Patch and Updater',
            'page_subtitle' => 'Download and install patch packages',
            'patches' => [
                [
                    'id' => 1,
                    'nama_paket' => 'INLISLite v3.2 Cumulative Updater',
                    'versi' => '3.2.1',
                    'prioritas' => 'High',
                    'ukuran' => '15.2 MB',
                    'tanggal_rilis' => '2024-01-15',
                    'deskripsi' => 'Updater ini ditujukan untuk memperbaharui paket instalasi INLISLite v3 sebelumnya dengan fitur terbaru dan perbaikan bug.',
                    'jumlah_unduhan' => 1250
                ],
                [
                    'id' => 2,
                    'nama_paket' => 'Security Patch v3.1.8',
                    'versi' => '3.1.8',
                    'prioritas' => 'High',
                    'ukuran' => '8.7 MB',
                    'tanggal_rilis' => '2024-01-10',
                    'deskripsi' => 'Patch keamanan penting untuk memperbaiki vulnerabilitas yang ditemukan pada versi sebelumnya.',
                    'jumlah_unduhan' => 2100
                ],
                [
                    'id' => 3,
                    'nama_paket' => 'Performance Enhancement Pack',
                    'versi' => '3.1.5',
                    'prioritas' => 'Medium',
                    'ukuran' => '12.4 MB',
                    'tanggal_rilis' => '2024-01-05',
                    'deskripsi' => 'Peningkatan performa sistem dan optimasi database untuk pengalaman pengguna yang lebih baik.',
                    'jumlah_unduhan' => 890
                ],
                [
                    'id' => 4,
                    'nama_paket' => 'UI/UX Improvements',
                    'versi' => '3.1.2',
                    'prioritas' => 'Low',
                    'ukuran' => '5.8 MB',
                    'tanggal_rilis' => '2023-12-28',
                    'deskripsi' => 'Perbaikan antarmuka pengguna dan pengalaman pengguna untuk kemudahan navigasi.',
                    'jumlah_unduhan' => 650
                ]
            ]
        ];
        
        return view('admin/patch', $data);
    }
    
    public function panduan()
    {
        $data = [
            'title' => 'Panduan - INLISLite v3',
            'page_title' => 'Panduan Penggunaan',
            'page_subtitle' => 'Dokumentasi dan panduan sistem',
            'documents' => [
                [
                    'id' => 1,
                    'title' => 'Panduan Instalasi INLISLite v3',
                    'description' => 'Langkah-langkah lengkap instalasi sistem INLISLite v3 pada server PHP dengan konfigurasi database MySQL.',
                    'file_size' => '2.5 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 2,
                    'title' => 'Konfigurasi Sistem dan Database',
                    'description' => 'Panduan konfigurasi sistem, pengaturan database, dan optimasi performa untuk instalasi INLISLite v3.',
                    'file_size' => '1.8 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 3,
                    'title' => 'Manajemen Pengguna dan Hak Akses',
                    'description' => 'Cara mengelola pengguna sistem, mengatur role dan permission, serta konfigurasi keamanan akses.',
                    'file_size' => '3.2 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 4,
                    'title' => 'Katalogisasi dan Metadata',
                    'description' => 'Panduan lengkap katalogisasi bahan pustaka, input metadata, dan standar MARC21 dalam INLISLite v3.',
                    'file_size' => '4.1 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 5,
                    'title' => 'Sirkulasi dan Peminjaman',
                    'description' => 'Panduan operasional sirkulasi, peminjaman, pengembalian, dan manajemen denda dalam sistem.',
                    'file_size' => '2.9 MB',
                    'version' => '3.0'
                ],
                [
                    'id' => 6,
                    'title' => 'Laporan dan Statistik',
                    'description' => 'Cara membuat laporan, analisis statistik, dan export data dalam berbagai format untuk keperluan administrasi.',
                    'file_size' => '3.7 MB',
                    'version' => '3.0'
                ]
            ]
        ];
        
        return view('admin/panduan', $data);
    }
    
    public function dukungan()
    {
        $data = [
            'title' => 'Layanan Dukungan Teknis - INLISLite v3',
            'page_title' => 'Layanan Dukungan Teknis',
            'page_subtitle' => 'Pusat bantuan dan dukungan teknis untuk sistem INLISLite v3'
        ];
        
        return view('admin/dukungan', $data);
    }
}
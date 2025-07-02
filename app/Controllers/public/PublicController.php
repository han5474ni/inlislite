<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;

class PublicController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'INLISLite v3 - Sistem Otomasi Perpustakaan',
            'page_title' => 'Selamat Datang di INLISLite v3',
            'page_subtitle' => 'Sistem Otomasi Perpustakaan Modern'
        ];
        
        return view('public/homepage', $data);
    }
    
    public function tentang()
    {
        $data = [
            'title' => 'Tentang INLISLite v3 - Sistem Otomasi Perpustakaan',
            'page_title' => 'Tentang INLISLite Versi 3',
            'page_subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan'
        ];
        
        return view('public/tentang', $data);
    }
    
    public function panduan()
    {
        $data = [
            'title' => 'Panduan Pengguna - INLISLite v3',
            'page_title' => 'Panduan Pengguna',
            'page_subtitle' => 'Petunjuk penggunaan sistem'
        ];
        
        return view('public/panduan', $data);
    }
    
    public function aplikasi()
    {
        $data = [
            'title' => 'Aplikasi Pendukung - INLISLite v3',
            'page_title' => 'Aplikasi Pendukung',
            'page_subtitle' => 'Download aplikasi pendukung sistem'
        ];
        
        return view('public/aplikasi', $data);
    }
    
    public function patch()
    {
        $data = [
            'title' => 'Patch & Update - INLISLite v3',
            'page_title' => 'Patch & Update',
            'page_subtitle' => 'Download patch dan update terbaru'
        ];
        
        return view('public/patch', $data);
    }
}
<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard - INLISLite v3',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('dashboard', $data);
    }

    public function dashboard(): string
    {
        $data = [
            'title' => 'Dashboard - INLISLite v3',
            'page_title' => 'Selamat Datang di InlisLite!',
            'page_subtitle' => 'Kelola sistem perpustakaan Anda dengan alat dan analitik yang lengkap.'
        ];
        
        return view('dashboard', $data);
    }

    public function userManagement(): string
    {
        $data = [
            'title' => 'User Management - INLISLite v3'
        ];
        
        return view('user_management', $data);
    }

    public function registration(): string
    {
        $data = [
            'title' => 'Registration - INLISLite v3'
        ];
        
        return view('registration', $data);
    }

    public function patchUpdater(): string
    {
        $data = [
            'title' => 'Patch Updater - INLISLite v3'
        ];
        
        return view('patch_updater', $data);
    }

    public function patchUpdaterSubmit(): string
    {
        $data = [
            'title' => 'Patch Updater Submit - INLISLite v3'
        ];
        
        return view('patch_updater_submit', $data);
    }

    public function patchUpdaterSubmitProcess(): string
    {
        $data = [
            'title' => 'Patch Updater Process - INLISLite v3'
        ];
        
        return view('patch_updater_submit_process', $data);
    }

    public function tentang(): string
    {
        $data = [
            'title' => 'Tentang INLISLite v3 - Sistem Otomasi Perpustakaan',
            'page_title' => 'Tentang INLISLite Versi 3',
            'page_subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan'
        ];
        
        return view('tentang', $data);
    }

    public function panduan(): string
    {
        $data = [
            'title' => 'Panduan - INLISLite v3',
            'page_title' => 'Panduan',
            'page_subtitle' => 'Paket unduhan dan instalasi'
        ];
        
        return view('panduan', $data);
    }
}

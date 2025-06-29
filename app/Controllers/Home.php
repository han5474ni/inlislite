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
        $builder = \Config\Database::connect()->table('users');
        $users = $builder->get()->getResultArray();

        $data = [
            'title' => 'User Management - INLISLite v3',
            'users' => $users
        ];
        
        return view('user_management', $data);
    }

    public function registration(): string
    {
        $stats = ['total' => 0, 'verified' => 0, 'pending' => 0];
        $registrations = [];
        
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $stats = $registrationModel->getTotalStats();
            $registrations = $registrationModel->findAll();
        } catch (\Exception $e) {
            // Table doesn't exist yet, use default values
            $stats = ['total' => 0, 'verified' => 0, 'pending' => 0];
            $registrations = [];
        }
        
        $data = [
            'title' => 'Registration - INLISLite v3',
            'stats' => $stats,
            'registrations' => $registrations
        ];
        
        return view('registration', $data);
    }

    public function getRegistrationStats(): string
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $year = $this->request->getGet('year') ?? date('Y');
            
            // Debug logging
            log_message('info', 'Getting registration stats for year: ' . $year);
            
            $monthlyStats = $registrationModel->getMonthlyStats($year);
            
            // Debug logging
            log_message('info', 'Monthly stats result: ' . json_encode($monthlyStats));
            
            return $this->response->setJSON($monthlyStats);
        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error getting registration stats: ' . $e->getMessage());
            
            // Return empty data if table doesn't exist
            $emptyData = [];
            for ($i = 1; $i <= 12; $i++) {
                $emptyData[] = [
                    'month' => $i,
                    'total' => 0,
                    'verified' => 0,
                    'pending' => 0
                ];
            }
            return $this->response->setJSON($emptyData);
        }
    }

    public function addRegistration()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            
            $data = [
                'library_name' => $this->request->getPost('library_name'),
                'province' => $this->request->getPost('province'),
                'city' => $this->request->getPost('city'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'status' => 'pending'
            ];
            
            $result = $registrationModel->insert($data);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Registrasi berhasil disimpan!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan registrasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateRegistrationStatus()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $id = $this->request->getPost('id');
            $status = $this->request->getPost('status');
            
            $data = ['status' => $status];
            if ($status === 'verified') {
                $data['verified_at'] = date('Y-m-d H:i:s');
            }
            
            $result = $registrationModel->update($id, $data);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status berhasil diupdate!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupdate status'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteRegistration($id)
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $result = $registrationModel->delete($id);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Registrasi berhasil dihapus!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus registrasi'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getRegistrationData()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            
            $stats = $registrationModel->getTotalStats();
            $registrations = $registrationModel->orderBy('created_at', 'DESC')->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'stats' => $stats,
                'registrations' => $registrations
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'stats' => ['total' => 0, 'verified' => 0, 'pending' => 0],
                'registrations' => []
            ]);
        }
    }

    public function getAvailableYears()
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            $years = $registrationModel->getAvailableYears();
            
            return $this->response->setJSON([
                'success' => true,
                'years' => $years
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'years' => [date('Y')]
            ]);
        }
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

    public function debugDatabase(): string
    {
        try {
            $registrationModel = new \App\Models\RegistrationModel();
            
            // Get all registrations
            $allRegistrations = $registrationModel->findAll();
            
            // Get available years
            $years = $registrationModel->getAvailableYears();
            
            // Get current year stats
            $currentYear = date('Y');
            $currentYearStats = $registrationModel->getMonthlyStats($currentYear);
            
            $debugData = [
                'total_records' => count($allRegistrations),
                'sample_records' => array_slice($allRegistrations, 0, 5),
                'available_years' => $years,
                'current_year' => $currentYear,
                'current_year_stats' => $currentYearStats
            ];
            
            return $this->response->setJSON($debugData);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DemoController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Demo Program - INLISLite v3',
            'demos' => $this->getDemoData()
        ];
        
        return view('admin/demo/index', $data);
    }
    
    public function cataloging()
    {
        $data = [
            'title' => 'Demo Katalogisasi - INLISLite v3',
            'demo_type' => 'cataloging',
            'sample_data' => $this->getCatalogingSampleData()
        ];
        
        return view('admin/demo/cataloging', $data);
    }
    
    public function circulation()
    {
        $data = [
            'title' => 'Demo Sirkulasi - INLISLite v3',
            'demo_type' => 'circulation',
            'sample_data' => $this->getCirculationSampleData()
        ];
        
        return view('admin/demo/circulation', $data);
    }
    
    public function membership()
    {
        $data = [
            'title' => 'Demo Keanggotaan - INLISLite v3',
            'demo_type' => 'membership',
            'sample_data' => $this->getMembershipSampleData()
        ];
        
        return view('admin/demo/membership', $data);
    }
    
    public function reporting()
    {
        $data = [
            'title' => 'Demo Pelaporan - INLISLite v3',
            'demo_type' => 'reporting',
            'sample_data' => $this->getReportingSampleData()
        ];
        
        return view('admin/demo/reporting', $data);
    }
    
    public function opac()
    {
        $data = [
            'title' => 'Demo OPAC - INLISLite v3',
            'demo_type' => 'opac',
            'sample_data' => $this->getOpacSampleData()
        ];
        
        return view('admin/demo/opac', $data);
    }
    
    public function generateSampleData()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        
        $type = $this->request->getPost('type');
        $count = (int) $this->request->getPost('count', FILTER_SANITIZE_NUMBER_INT) ?: 10;
        
        try {
            switch ($type) {
                case 'books':
                    $data = $this->generateSampleBooks($count);
                    break;
                case 'members':
                    $data = $this->generateSampleMembers($count);
                    break;
                case 'transactions':
                    $data = $this->generateSampleTransactions($count);
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid sample data type');
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => "Berhasil generate {$count} sample {$type}",
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal generate sample data: ' . $e->getMessage()
            ]);
        }
    }
    
    private function getDemoData()
    {
        return [
            'cataloging' => [
                'title' => 'Katalogisasi',
                'description' => 'Demo fitur katalogisasi buku dan koleksi perpustakaan',
                'icon' => 'bi-book',
                'color' => 'primary',
                'features' => [
                    'Input bibliografi',
                    'MARC21 format',
                    'Import/Export data',
                    'Barcode generation'
                ]
            ],
            'circulation' => [
                'title' => 'Sirkulasi',
                'description' => 'Demo sistem peminjaman dan pengembalian buku',
                'icon' => 'bi-arrow-repeat',
                'color' => 'success',
                'features' => [
                    'Peminjaman buku',
                    'Pengembalian buku',
                    'Perpanjangan',
                    'Denda otomatis'
                ]
            ],
            'membership' => [
                'title' => 'Keanggotaan',
                'description' => 'Demo manajemen anggota perpustakaan',
                'icon' => 'bi-people',
                'color' => 'info',
                'features' => [
                    'Registrasi anggota',
                    'Kartu anggota',
                    'Kategori anggota',
                    'Status keanggotaan'
                ]
            ],
            'reporting' => [
                'title' => 'Pelaporan',
                'description' => 'Demo sistem pelaporan dan statistik',
                'icon' => 'bi-graph-up',
                'color' => 'warning',
                'features' => [
                    'Laporan sirkulasi',
                    'Statistik koleksi',
                    'Laporan anggota',
                    'Export ke Excel/PDF'
                ]
            ],
            'opac' => [
                'title' => 'OPAC',
                'description' => 'Demo Online Public Access Catalog',
                'icon' => 'bi-search',
                'color' => 'secondary',
                'features' => [
                    'Pencarian katalog',
                    'Detail koleksi',
                    'Reservasi online',
                    'Riwayat peminjaman'
                ]
            ]
        ];
    }
    
    private function getCatalogingSampleData()
    {
        return [
            'total_books' => 1250,
            'total_categories' => 45,
            'recent_additions' => [
                [
                    'title' => 'Pemrograman Web dengan PHP',
                    'author' => 'John Doe',
                    'isbn' => '978-123-456-789-0',
                    'category' => 'Teknologi Informasi',
                    'date_added' => '2024-01-15'
                ],
                [
                    'title' => 'Database Management Systems',
                    'author' => 'Jane Smith',
                    'isbn' => '978-987-654-321-0',
                    'category' => 'Teknologi Informasi',
                    'date_added' => '2024-01-14'
                ]
            ]
        ];
    }
    
    private function getCirculationSampleData()
    {
        return [
            'active_loans' => 89,
            'overdue_items' => 12,
            'returns_today' => 23,
            'recent_transactions' => [
                [
                    'member_name' => 'Ahmad Wijaya',
                    'book_title' => 'Pemrograman Web dengan PHP',
                    'type' => 'Peminjaman',
                    'date' => '2024-01-15',
                    'due_date' => '2024-01-29'
                ],
                [
                    'member_name' => 'Siti Nurhaliza',
                    'book_title' => 'Database Management Systems',
                    'type' => 'Pengembalian',
                    'date' => '2024-01-15',
                    'status' => 'Tepat waktu'
                ]
            ]
        ];
    }
    
    private function getMembershipSampleData()
    {
        return [
            'total_members' => 456,
            'active_members' => 398,
            'new_registrations' => 15,
            'member_categories' => [
                'Mahasiswa' => 234,
                'Dosen' => 45,
                'Staff' => 67,
                'Umum' => 110
            ]
        ];
    }
    
    private function getReportingSampleData()
    {
        return [
            'monthly_circulation' => [
                'loans' => 234,
                'returns' => 198,
                'overdue' => 23
            ],
            'popular_books' => [
                [
                    'title' => 'Pemrograman Web dengan PHP',
                    'loans' => 45
                ],
                [
                    'title' => 'Database Management Systems',
                    'loans' => 38
                ]
            ],
            'collection_stats' => [
                'total_items' => 1250,
                'available' => 1089,
                'on_loan' => 161
            ]
        ];
    }
    
    private function getOpacSampleData()
    {
        return [
            'search_results' => [
                [
                    'title' => 'Pemrograman Web dengan PHP',
                    'author' => 'John Doe',
                    'publisher' => 'Tech Publisher',
                    'year' => '2023',
                    'availability' => 'Tersedia'
                ],
                [
                    'title' => 'Database Management Systems',
                    'author' => 'Jane Smith',
                    'publisher' => 'Academic Press',
                    'year' => '2023',
                    'availability' => 'Dipinjam'
                ]
            ],
            'popular_searches' => [
                'PHP', 'Database', 'Web Programming', 'JavaScript', 'Python'
            ]
        ];
    }
    
    private function generateSampleBooks($count)
    {
        $books = [];
        $titles = [
            'Pemrograman Web dengan PHP',
            'Database Management Systems',
            'Algoritma dan Struktur Data',
            'Jaringan Komputer',
            'Sistem Operasi',
            'Rekayasa Perangkat Lunak',
            'Kecerdasan Buatan',
            'Machine Learning',
            'Data Mining',
            'Cyber Security'
        ];
        
        $authors = [
            'John Doe', 'Jane Smith', 'Ahmad Wijaya', 'Siti Nurhaliza',
            'Budi Santoso', 'Rina Kartika', 'Dedi Kurniawan', 'Maya Sari'
        ];
        
        for ($i = 0; $i < $count; $i++) {
            $books[] = [
                'title' => $titles[array_rand($titles)],
                'author' => $authors[array_rand($authors)],
                'isbn' => '978-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(0, 9),
                'year' => rand(2020, 2024),
                'category' => 'Teknologi Informasi'
            ];
        }
        
        return $books;
    }
    
    private function generateSampleMembers($count)
    {
        $members = [];
        $names = [
            'Ahmad Wijaya', 'Siti Nurhaliza', 'Budi Santoso', 'Rina Kartika',
            'Dedi Kurniawan', 'Maya Sari', 'Andi Pratama', 'Dewi Lestari'
        ];
        
        $categories = ['Mahasiswa', 'Dosen', 'Staff', 'Umum'];
        
        for ($i = 0; $i < $count; $i++) {
            $members[] = [
                'name' => $names[array_rand($names)],
                'member_id' => 'M' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'category' => $categories[array_rand($categories)],
                'join_date' => date('Y-m-d', strtotime('-' . rand(1, 365) . ' days')),
                'status' => 'Aktif'
            ];
        }
        
        return $members;
    }
    
    private function generateSampleTransactions($count)
    {
        $transactions = [];
        $types = ['Peminjaman', 'Pengembalian', 'Perpanjangan'];
        
        for ($i = 0; $i < $count; $i++) {
            $transactions[] = [
                'member_name' => 'Member ' . ($i + 1),
                'book_title' => 'Book Title ' . ($i + 1),
                'type' => $types[array_rand($types)],
                'date' => date('Y-m-d', strtotime('-' . rand(1, 30) . ' days')),
                'status' => rand(0, 1) ? 'Selesai' : 'Aktif'
            ];
        }
        
        return $transactions;
    }
}
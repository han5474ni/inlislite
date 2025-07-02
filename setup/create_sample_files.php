<?php
/**
 * Script untuk membuat sample files untuk testing download
 */

// Load CodeIgniter libraries
require_once 'app/Libraries/SimplePDFGenerator.php';
use App\Libraries\SimplePDFGenerator;

echo "Creating sample files for INLISLite v3 documents...\n";

// Pastikan direktori ada
$uploadDir = 'writable/uploads/documents/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    echo "Created directory: {$uploadDir}\n";
}

// Sample files data
$sampleFiles = [
    [
        'filename' => 'panduan_lengkap_v3.2.1.pdf',
        'title' => 'Panduan Pengguna Revisi 16062016 – Modul Lengkap',
        'type' => 'PDF',
        'version' => 'V3.2.1',
        'description' => 'Panduan komprehensif yang mencakup semua modul dan fitur INLISLite v3',
        'content' => "DAFTAR ISI:\n" .
                     "1. Pendahuluan\n2. Instalasi\n3. Konfigurasi\n4. Penggunaan\n5. Troubleshooting\n\n" .
                     "--- BAB 1: PENDAHULUAN ---\n\n" .
                     "INLISLite v3 adalah sistem manajemen perpustakaan modern yang dikembangkan\n" .
                     "dengan teknologi terkini untuk memenuhi kebutuhan perpustakaan digital.\n\n" .
                     "FITUR UTAMA:\n" .
                     "- Manajemen koleksi digital\n" .
                     "- Sistem sirkulasi otomatis\n" .
                     "- Katalog online\n" .
                     "- Laporan statistik\n" .
                     "- User management\n" .
                     "- Document management\n\n" .
                     "Generated: " . date('Y-m-d H:i:s')
    ],
    [
        'filename' => 'panduan_admin_v3.2.0.pdf',
        'title' => 'Panduan Praktis – Pengaturan Administrasi di INLISLite v3',
        'type' => 'PDF',
        'version' => 'V3.2.0',
        'description' => 'Panduan langkah demi langkah untuk mengonfigurasi pengaturan administratif',
        'content' => "TOPIK PEMBAHASAN:\n" .
                     "1. User Management\n2. System Configuration\n3. Database Management\n4. Security Settings\n\n" .
                     "--- KONFIGURASI PENGGUNA ---\n\n" .
                     "Untuk mengelola pengguna sistem:\n" .
                     "1. Login sebagai Super Admin\n" .
                     "2. Akses menu User Management\n" .
                     "3. Tambah/Edit/Hapus pengguna sesuai kebutuhan\n\n" .
                     "--- KONFIGURASI SISTEM ---\n\n" .
                     "Setting dasar sistem meliputi:\n" .
                     "- Database connection\n" .
                     "- Email configuration\n" .
                     "- Backup settings\n" .
                     "- Security policies\n\n" .
                     "Generated: " . date('Y-m-d H:i:s')
    ],
    [
        'filename' => 'panduan_bahan_pustaka_v3.2.0.pdf',
        'title' => 'Panduan Praktis – Manajemen Bahan Pustaka di INLISLite v3',
        'type' => 'PDF',
        'version' => 'V3.2.0',
        'description' => 'Panduan untuk mengelola koleksi bahan pustaka secara efektif',
        'content' => "MATERI:\n" .
                     "1. Katalogisasi\n2. Klasifikasi\n3. Input Bahan Pustaka\n4. Pencarian Koleksi\n\n" .
                     "--- KATALOGISASI ---\n\n" .
                     "Proses katalogisasi meliputi:\n" .
                     "- Input metadata buku\n" .
                     "- Penentuan nomor klasifikasi\n" .
                     "- Upload cover buku\n" .
                     "- Validasi data\n\n" .
                     "Generated: " . date('Y-m-d H:i:s')
    ],
    [
        'filename' => 'panduan_keanggotaan_v3.2.0.pdf',
        'title' => 'Panduan Praktis – Manajemen Keanggotaan di INLISLite v3',
        'type' => 'PDF',
        'version' => 'V3.2.0',
        'description' => 'Manual pengguna untuk mengelola akun dan profil anggota perpustakaan',
        'content' => "FITUR KEANGGOTAAN:\n" .
                     "1. Registrasi Anggota\n2. Perpanjangan Membership\n3. Kartu Anggota Digital\n4. History Aktivitas\n\n" .
                     "--- REGISTRASI ANGGOTA BARU ---\n\n" .
                     "Langkah-langkah:\n" .
                     "1. Isi form registrasi\n" .
                     "2. Upload foto anggota\n" .
                     "3. Verifikasi dokumen\n" .
                     "4. Generate kartu anggota\n\n" .
                     "Generated: " . date('Y-m-d H:i:s')
    ],
    [
        'filename' => 'panduan_sirkulasi_v3.2.0.pdf',
        'title' => 'Panduan Praktis – Sistem Sirkulasi di INLISLite v3',
        'type' => 'PDF',
        'version' => 'V3.2.0',
        'description' => 'Panduan untuk mengelola peminjaman dan pengembalian buku',
        'content' => "MODUL SIRKULASI:\n" .
                     "1. Peminjaman Buku\n2. Pengembalian\n3. Perpanjangan\n4. Denda dan Sanksi\n\n" .
                     "--- PROSES PEMINJAMAN ---\n\n" .
                     "Alur peminjaman:\n" .
                     "1. Scan kartu anggota\n" .
                     "2. Scan barcode buku\n" .
                     "3. Konfirmasi data\n" .
                     "4. Cetak bukti peminjaman\n\n" .
                     "Generated: " . date('Y-m-d H:i:s')
    ],
    [
        'filename' => 'panduan_survei_v3.1.5.pdf',
        'title' => 'Panduan Praktis – Pembuatan Survei di INLISLite v3',
        'type' => 'PDF',
        'version' => 'V3.1.5',
        'description' => 'Panduan untuk membuat dan mengelola survei serta umpan balik perpustakaan',
        'content' => "FITUR SURVEI:\n" .
                     "1. Builder Survei\n2. Distribusi Online\n3. Analisis Hasil\n4. Export Laporan\n\n" .
                     "--- MEMBUAT SURVEI ---\n\n" .
                     "Cara membuat survei:\n" .
                     "1. Tentukan tujuan survei\n" .
                     "2. Buat pertanyaan\n" .
                     "3. Set target responden\n" .
                     "4. Publikasikan survei\n\n" .
                     "Generated: " . date('Y-m-d H:i:s')
    ]
];

// Buat files
foreach ($sampleFiles as $file) {
    $filepath = $uploadDir . $file['filename'];
    
    // Generate content based on file type
    if (isset($file['type']) && $file['type'] === 'PDF') {
        // Generate HTML for PDF files (better compatibility)
        $metadata = [
            'version' => $file['version'] ?? '',
            'date' => date('d F Y')
        ];
        $content = SimplePDFGenerator::generateHTMLForPDF($file['title'], $file['content'], $metadata);
        
        // Change filename to .html for better browser support
        $filepath = str_replace('.pdf', '.html', $filepath);
    } else {
        // Use original content
        $content = $file['content'];
    }
    
    if (file_put_contents($filepath, $content)) {
        $size = filesize($filepath);
        echo "✓ Created: {$file['filename']} ({$size} bytes)\n";
    } else {
        echo "✗ Failed to create: {$file['filename']}\n";
    }
}

echo "\nSample files creation completed!\n";
echo "You can now test the download functionality in the application.\n";
?>

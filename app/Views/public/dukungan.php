<?= view('public/layout/header', ['page_title' => $page_title ?? 'Dukungan Teknis']) ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <div class="page-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h1 class="page-title">Dukungan Teknis</h1>
                    <p class="page-subtitle">
                        Dapatkan dukungan teknis profesional untuk INLISLite v3. Tim support berpengalaman siap membantu mengatasi masalah teknis Anda
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dukungan Teknis</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Support Channels -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h2 class="mb-0">
                            <i class="bi bi-chat-dots me-2"></i>
                            Saluran Dukungan
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="lead text-center mb-5">
                            Pilih saluran dukungan yang sesuai dengan kebutuhan Anda
                        </p>
                        
                        <?php if (isset($support_channels) && is_array($support_channels)): ?>
                            <div class="row g-4">
                                <?php foreach ($support_channels as $index => $channel): ?>
                                    <div class="col-lg-6">
                                        <div class="support-channel-card border rounded p-4 h-100 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                                            <div class="d-flex align-items-start">
                                                <div class="channel-icon me-3">
                                                    <i class="<?= $channel['icon'] ?>" style="font-size: 2.5rem; color: #667eea;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-2"><?= esc($channel['name']) ?></h4>
                                                    <p class="text-muted mb-3"><?= esc($channel['description']) ?></p>
                                                    
                                                    <div class="channel-details">
                                                        <div class="row text-center mb-3">
                                                            <div class="col-4">
                                                                <div class="detail-item">
                                                                    <i class="bi bi-clock text-primary"></i>
                                                                    <div class="small text-muted">Response</div>
                                                                    <div class="fw-bold"><?= esc($channel['response_time']) ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="detail-item">
                                                                    <i class="bi bi-calendar text-success"></i>
                                                                    <div class="small text-muted">Availability</div>
                                                                    <div class="fw-bold"><?= esc($channel['availability']) ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="contact-info bg-light p-3 rounded mb-3">
                                                            <strong>Kontak:</strong> <?= esc($channel['contact']) ?>
                                                        </div>
                                                        
                                                        <div class="d-grid">
                                                            <?php if ($channel['name'] === 'Email Support'): ?>
                                                                <a href="mailto:<?= esc($channel['contact']) ?>" class="btn btn-primary-gradient">
                                                                    <i class="bi bi-envelope me-2"></i>
                                                                    Kirim Email
                                                                </a>
                                                            <?php elseif ($channel['name'] === 'Live Chat'): ?>
                                                                <button class="btn btn-primary-gradient" onclick="openLiveChat()">
                                                                    <i class="bi bi-chat-dots me-2"></i>
                                                                    Mulai Chat
                                                                </button>
                                                            <?php elseif ($channel['name'] === 'Phone Support'): ?>
                                                                <a href="tel:<?= esc($channel['contact']) ?>" class="btn btn-primary-gradient">
                                                                    <i class="bi bi-telephone me-2"></i>
                                                                    Hubungi Sekarang
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?= esc($channel['contact']) ?>" class="btn btn-primary-gradient" target="_blank">
                                                                    <i class="bi bi-people me-2"></i>
                                                                    Kunjungi Forum
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Form -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-envelope me-2"></i>
                            Kirim Tiket Support
                        </h3>
                    </div>
                    <div class="card-body">
                        <form id="supportForm" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="name" required>
                                    <div class="invalid-feedback">
                                        Nama lengkap wajib diisi.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" required>
                                    <div class="invalid-feedback">
                                        Email valid wajib diisi.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="organization" class="form-label">Nama Perpustakaan/Organisasi</label>
                                    <input type="text" class="form-control" id="organization">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Kategori Masalah *</label>
                                    <select class="form-select" id="category" required>
                                        <option value="">Pilih kategori...</option>
                                        <option value="installation">Instalasi</option>
                                        <option value="configuration">Konfigurasi</option>
                                        <option value="usage">Penggunaan</option>
                                        <option value="bug">Bug Report</option>
                                        <option value="performance">Performance</option>
                                        <option value="security">Keamanan</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Kategori masalah wajib dipilih.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Prioritas *</label>
                                    <select class="form-select" id="priority" required>
                                        <option value="">Pilih prioritas...</option>
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Prioritas wajib dipilih.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek *</label>
                                <input type="text" class="form-control" id="subject" required>
                                <div class="invalid-feedback">
                                    Subjek wajib diisi.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Masalah *</label>
                                <textarea class="form-control" id="description" rows="5" required placeholder="Jelaskan masalah yang Anda alami secara detail..."></textarea>
                                <div class="invalid-feedback">
                                    Deskripsi masalah wajib diisi.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Lampiran (Screenshot/Log File)</label>
                                <input type="file" class="form-control" id="attachment" multiple accept=".jpg,.jpeg,.png,.pdf,.txt,.log">
                                <div class="form-text">
                                    Format yang didukung: JPG, PNG, PDF, TXT, LOG. Maksimal 10MB per file.
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreement" required>
                                    <label class="form-check-label" for="agreement">
                                        Saya setuju dengan <a href="#" class="text-decoration-none">syarat dan ketentuan</a> layanan dukungan teknis *
                                    </label>
                                    <div class="invalid-feedback">
                                        Anda harus menyetujui syarat dan ketentuan.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-gradient btn-lg">
                                    <i class="bi bi-send me-2"></i>
                                    Kirim Tiket Support
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-question-circle me-2"></i>
                            Frequently Asked Questions
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($faq) && is_array($faq)): ?>
                            <div class="accordion" id="faqAccordion">
                                <?php foreach ($faq as $index => $item): ?>
                                    <div class="accordion-item border-0 mb-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $index + 1 ?>">
                                                <?= esc($item['question']) ?>
                                            </button>
                                        </h2>
                                        <div id="faq<?= $index + 1 ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <?= esc($item['answer']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted">Tidak menemukan jawaban yang Anda cari?</p>
                            <a href="#supportForm" class="btn btn-outline-primary">
                                <i class="bi bi-envelope me-2"></i>
                                Kirim Pertanyaan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Knowledge Base -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-book me-2"></i>
                            Knowledge Base
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="kb-item border rounded p-4 h-100">
                                    <div class="kb-icon mb-3">
                                        <i class="bi bi-gear" style="font-size: 2.5rem; color: #667eea;"></i>
                                    </div>
                                    <h5>Troubleshooting</h5>
                                    <p class="text-muted">Panduan mengatasi masalah umum yang sering terjadi</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-right me-1"></i>
                                        Lihat Artikel
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="kb-item border rounded p-4 h-100">
                                    <div class="kb-icon mb-3">
                                        <i class="bi bi-shield-check" style="font-size: 2.5rem; color: #28a745;"></i>
                                    </div>
                                    <h5>Security Best Practices</h5>
                                    <p class="text-muted">Tips keamanan untuk melindungi sistem perpustakaan</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-right me-1"></i>
                                        Lihat Artikel
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="kb-item border rounded p-4 h-100">
                                    <div class="kb-icon mb-3">
                                        <i class="bi bi-speedometer2" style="font-size: 2.5rem; color: #ffc107;"></i>
                                    </div>
                                    <h5>Performance Optimization</h5>
                                    <p class="text-muted">Cara mengoptimalkan performa sistem</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-right me-1"></i>
                                        Lihat Artikel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Statistik Dukungan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-ticket" style="font-size: 3rem; color: #667eea;"></i>
                                    <h3 class="stat-number text-primary mt-3">15,234</h3>
                                    <p class="stat-label text-muted">Tiket Diselesaikan</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-clock" style="font-size: 3rem; color: #28a745;"></i>
                                    <h3 class="stat-number text-success mt-3">2.5 Jam</h3>
                                    <p class="stat-label text-muted">Rata-rata Response Time</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-emoji-smile" style="font-size: 3rem; color: #ffc107;"></i>
                                    <h3 class="stat-number text-warning mt-3">98.5%</h3>
                                    <p class="stat-label text-muted">Customer Satisfaction</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="stat-item">
                                    <i class="bi bi-people" style="font-size: 3rem; color: #dc3545;"></i>
                                    <h3 class="stat-number text-danger mt-3">24/7</h3>
                                    <p class="stat-label text-muted">Support Availability</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    submitSupportForm();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function submitSupportForm() {
    const submitBtn = document.querySelector('#supportForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
    submitBtn.disabled = true;
    
    // Simulate form submission
    setTimeout(() => {
        showToast('Tiket support berhasil dikirim! Kami akan merespon dalam 24 jam.', 'success');
        document.getElementById('supportForm').reset();
        document.getElementById('supportForm').classList.remove('was-validated');
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
}

function openLiveChat() {
    // Simulate opening live chat
    showToast('Membuka live chat...', 'info');
    setTimeout(() => {
        showToast('Live chat akan tersedia dalam versi mendatang.', 'warning');
    }, 1000);
}
</script>

<?= view('public/layout/footer') ?>
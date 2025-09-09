<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <div class="page-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <h1 class="page-title">Bimbingan Teknis</h1>
                    <p class="page-subtitle">
                        Layanan bimbingan teknis dan pelatihan profesional untuk INLISLite v3. Tingkatkan kemampuan tim perpustakaan Anda
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
                <li class="breadcrumb-item active" aria-current="page">Bimbingan Teknis</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container">
        <!-- Introduction -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-body text-center">
                        <h2 class="mb-3">Program Pelatihan Komprehensif</h2>
                        <p class="lead">
                            Kami menyediakan berbagai program pelatihan yang dirancang khusus untuk meningkatkan kompetensi 
                            pengelola perpustakaan dalam menggunakan INLISLite v3 secara optimal.
                        </p>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <i class="bi bi-award text-primary" style="font-size: 2.5rem;"></i>
                                <h6 class="mt-2">Sertifikat Resmi</h6>
                                <p class="text-muted small">Dapatkan sertifikat yang diakui</p>
                            </div>
                            <div class="col-md-4">
                                <i class="bi bi-people text-success" style="font-size: 2.5rem;"></i>
                                <h6 class="mt-2">Trainer Berpengalaman</h6>
                                <p class="text-muted small">Dibimbing oleh ahli perpustakaan</p>
                            </div>
                            <div class="col-md-4">
                                <i class="bi bi-laptop text-warning" style="font-size: 2.5rem;"></i>
                                <h6 class="mt-2">Hands-on Practice</h6>
                                <p class="text-muted small">Praktik langsung dengan sistem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Training Programs -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-calendar-event me-2"></i>
                            Program Pelatihan
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($training_programs) && is_array($training_programs)): ?>
                            <div class="row g-4">
                                <?php foreach ($training_programs as $index => $program): ?>
                                    <div class="col-lg-4">
                                        <div class="training-card border rounded p-4 h-100 animate-on-scroll" style="animation-delay: <?= $index * 0.1 ?>s;">
                                            <div class="training-header mb-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h4 class="mb-0"><?= esc($program['title']) ?></h4>
                                                    <span class="badge <?= $program['price'] === 'Gratis' ? 'bg-success' : 'bg-primary' ?> fs-6">
                                                        <?= esc($program['price']) ?>
                                                    </span>
                                                </div>
                                                <p class="text-muted mt-2"><?= esc($program['description']) ?></p>
                                            </div>
                                            
                                            <div class="training-details mb-4">
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <i class="bi bi-clock text-primary"></i>
                                                        <div class="small text-muted">Durasi</div>
                                                        <div class="fw-bold"><?= esc($program['duration']) ?></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <i class="bi bi-people text-success"></i>
                                                        <div class="small text-muted">Peserta</div>
                                                        <div class="fw-bold"><?= esc($program['participants']) ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="training-topics mb-4">
                                                <h6 class="mb-2">Materi Pelatihan:</h6>
                                                <ul class="list-unstyled">
                                                    <?php foreach ($program['topics'] as $topic): ?>
                                                        <li class="mb-1">
                                                            <i class="bi bi-check-circle text-success me-2"></i>
                                                            <?= esc($topic) ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            
                                            <div class="d-grid">
                                                <button class="btn btn-primary-gradient" onclick="registerTraining('<?= esc($program['title']) ?>')">
                                                    <i class="bi bi-calendar-plus me-2"></i>
                                                    Daftar Sekarang
                                                </button>
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

        <!-- Training Schedule -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header">
                        <h3 class="mb-0">
                            <i class="bi bi-calendar3 me-2"></i>
                            Jadwal Pelatihan
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($schedules) && is_array($schedules)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Program</th>
                                            <th>Lokasi</th>
                                            <th>Peserta</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schedules as $schedule): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= date('d M Y', strtotime($schedule['date'])) ?></strong>
                                                </td>
                                                <td><?= esc($schedule['program']) ?></td>
                                                <td>
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    <?= esc($schedule['location']) ?>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar" style="width: <?= ($schedule['registered'] / $schedule['capacity']) * 100 ?>%">
                                                            <?= $schedule['registered'] ?>/<?= $schedule['capacity'] ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $schedule['status'] === 'Available' ? 'bg-success' : 'bg-danger' ?>">
                                                        <?= esc($schedule['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($schedule['status'] === 'Available'): ?>
                                                        <button class="btn btn-sm btn-primary-gradient" onclick="registerSchedule('<?= esc($schedule['date']) ?>', '<?= esc($schedule['program']) ?>')">
                                                            <i class="bi bi-calendar-plus me-1"></i>
                                                            Daftar
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            <i class="bi bi-x-circle me-1"></i>
                                                            Penuh
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Jadwal dapat berubah sewaktu-waktu. Silakan hubungi tim kami untuk konfirmasi jadwal terbaru.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-person-plus me-2"></i>
                            Formulir Pendaftaran
                        </h3>
                    </div>
                    <div class="card-body">
                        <form id="trainingRegistrationForm" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="participantName" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="participantName" required>
                                    <div class="invalid-feedback">
                                        Nama lengkap wajib diisi.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="participantEmail" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="participantEmail" required>
                                    <div class="invalid-feedback">
                                        Email valid wajib diisi.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="participantPhone" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" id="participantPhone" required>
                                    <div class="invalid-feedback">
                                        Nomor telepon wajib diisi.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="participantPosition" class="form-label">Jabatan *</label>
                                    <input type="text" class="form-control" id="participantPosition" required>
                                    <div class="invalid-feedback">
                                        Jabatan wajib diisi.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="libraryName" class="form-label">Nama Perpustakaan *</label>
                                    <input type="text" class="form-control" id="libraryName" required>
                                    <div class="invalid-feedback">
                                        Nama perpustakaan wajib diisi.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="libraryType" class="form-label">Jenis Perpustakaan *</label>
                                    <select class="form-select" id="libraryType" required>
                                        <option value="">Pilih jenis...</option>
                                        <option value="public">Perpustakaan Umum</option>
                                        <option value="academic">Perpustakaan Perguruan Tinggi</option>
                                        <option value="school">Perpustakaan Sekolah</option>
                                        <option value="special">Perpustakaan Khusus</option>
                                        <option value="corporate">Perpustakaan Perusahaan</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Jenis perpustakaan wajib dipilih.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="trainingProgram" class="form-label">Program Pelatihan *</label>
                                    <select class="form-select" id="trainingProgram" required>
                                        <option value="">Pilih program...</option>
                                        <option value="basic">Basic Training</option>
                                        <option value="advanced">Advanced Training</option>
                                        <option value="trainer">Train the Trainer</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Program pelatihan wajib dipilih.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="preferredDate" class="form-label">Tanggal Preferensi</label>
                                    <input type="date" class="form-control" id="preferredDate">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="experience" class="form-label">Pengalaman dengan INLISLite</label>
                                <select class="form-select" id="experience">
                                    <option value="">Pilih tingkat pengalaman...</option>
                                    <option value="none">Belum pernah menggunakan</option>
                                    <option value="beginner">Pemula (< 6 bulan)</option>
                                    <option value="intermediate">Menengah (6 bulan - 2 tahun)</option>
                                    <option value="advanced">Mahir (> 2 tahun)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="expectations" class="form-label">Harapan dari Pelatihan</label>
                                <textarea class="form-control" id="expectations" rows="3" placeholder="Jelaskan apa yang ingin Anda pelajari dari pelatihan ini..."></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="trainingAgreement" required>
                                    <label class="form-check-label" for="trainingAgreement">
                                        Saya setuju dengan <a href="#" class="text-decoration-none">syarat dan ketentuan</a> pelatihan *
                                    </label>
                                    <div class="invalid-feedback">
                                        Anda harus menyetujui syarat dan ketentuan.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-gradient btn-lg">
                                    <i class="bi bi-send me-2"></i>
                                    Daftar Pelatihan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-star me-2"></i>
                            Keuntungan Mengikuti Pelatihan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="benefit-item text-center">
                                    <div class="benefit-icon mb-3">
                                        <i class="bi bi-trophy" style="font-size: 3rem; color: #ffc107;"></i>
                                    </div>
                                    <h5>Sertifikat Resmi</h5>
                                    <p class="text-muted">Dapatkan sertifikat yang diakui secara nasional</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="benefit-item text-center">
                                    <div class="benefit-icon mb-3">
                                        <i class="bi bi-people" style="font-size: 3rem; color: #28a745;"></i>
                                    </div>
                                    <h5>Networking</h5>
                                    <p class="text-muted">Bertemu dengan praktisi perpustakaan lainnya</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="benefit-item text-center">
                                    <div class="benefit-icon mb-3">
                                        <i class="bi bi-book" style="font-size: 3rem; color: #667eea;"></i>
                                    </div>
                                    <h5>Materi Lengkap</h5>
                                    <p class="text-muted">Modul pelatihan dan dokumentasi komprehensif</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="benefit-item text-center">
                                    <div class="benefit-icon mb-3">
                                        <i class="bi bi-headset" style="font-size: 3rem; color: #dc3545;"></i>
                                    </div>
                                    <h5>Support Berkelanjutan</h5>
                                    <p class="text-muted">Dukungan teknis setelah pelatihan selesai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials -->
        <div class="row">
            <div class="col-12">
                <div class="content-card animate-on-scroll">
                    <div class="card-header text-center">
                        <h3 class="mb-0">
                            <i class="bi bi-chat-quote me-2"></i>
                            Testimoni Peserta
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <div class="testimonial-item border rounded p-4 h-100">
                                    <div class="testimonial-content mb-3">
                                        <p class="fst-italic">"Pelatihan sangat membantu dalam memahami fitur-fitur INLISLite v3. Trainer sangat kompeten dan materi mudah dipahami."</p>
                                    </div>
                                    <div class="testimonial-author d-flex align-items-center">
                                        <div class="author-avatar me-3">
                                            <i class="bi bi-person-circle" style="font-size: 2.5rem; color: #667eea;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Siti Nurhaliza</h6>
                                            <small class="text-muted">Kepala Perpustakaan Universitas ABC</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="testimonial-item border rounded p-4 h-100">
                                    <div class="testimonial-content mb-3">
                                        <p class="fst-italic">"Program Train the Trainer sangat bermanfaat. Sekarang saya bisa melatih tim di perpustakaan dengan lebih efektif."</p>
                                    </div>
                                    <div class="testimonial-author d-flex align-items-center">
                                        <div class="author-avatar me-3">
                                            <i class="bi bi-person-circle" style="font-size: 2.5rem; color: #28a745;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Ahmad Wijaya</h6>
                                            <small class="text-muted">IT Manager Perpustakaan Daerah XYZ</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="testimonial-item border rounded p-4 h-100">
                                    <div class="testimonial-content mb-3">
                                        <p class="fst-italic">"Materi pelatihan sangat praktis dan langsung bisa diterapkan. Support setelah pelatihan juga sangat responsif."</p>
                                    </div>
                                    <div class="testimonial-author d-flex align-items-center">
                                        <div class="author-avatar me-3">
                                            <i class="bi bi-person-circle" style="font-size: 2.5rem; color: #ffc107;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Rina Kartika</h6>
                                            <small class="text-muted">Pustakawan SMA Negeri 123</small>
                                        </div>
                                    </div>
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
                    submitTrainingRegistration();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function registerTraining(programName) {
    document.getElementById('trainingProgram').value = programName.toLowerCase().replace(' ', '');
    document.getElementById('trainingRegistrationForm').scrollIntoView({ behavior: 'smooth' });
    showToast(`Program ${programName} dipilih. Silakan lengkapi formulir pendaftaran.`, 'info');
}

function registerSchedule(date, program) {
    document.getElementById('preferredDate').value = date;
    document.getElementById('trainingProgram').value = program.toLowerCase().replace(' ', '');
    document.getElementById('trainingRegistrationForm').scrollIntoView({ behavior: 'smooth' });
    showToast(`Jadwal ${program} pada ${date} dipilih. Silakan lengkapi formulir pendaftaran.`, 'info');
}

function submitTrainingRegistration() {
    const submitBtn = document.querySelector('#trainingRegistrationForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';
    submitBtn.disabled = true;
    
    // Simulate form submission
    setTimeout(() => {
        showToast('Pendaftaran pelatihan berhasil! Kami akan menghubungi Anda untuk konfirmasi.', 'success');
        document.getElementById('trainingRegistrationForm').reset();
        document.getElementById('trainingRegistrationForm').classList.remove('was-validated');
        
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
}
</script>

<?= $this->endSection() ?>
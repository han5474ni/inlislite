<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/profile.css') ?>" rel="stylesheet">
<style>
/* Harmonize cards with other admin pages */
.card { border: 1px solid var(--gray-200); border-radius: var(--radius-lg); box-shadow: var(--shadow); }
.card-header { background: #fff; border-bottom: 1px solid var(--gray-200); padding: 1rem 1.25rem; }
.card-title { margin: 0; font-weight: 700; color: var(--gray-800); }
.card-footer { background: #fff; border-top: 1px solid var(--gray-200); }
.list-group-item { border: 0; border-bottom: 1px solid #eef2f7; }
.list-group-item:last-child { border-bottom: 0; }
/* Keep forms compact and consistent */
.form-label { font-weight: 600; color: var(--gray-700); }
.btn + .btn { margin-left: .5rem; }
/* Reduce excessive whitespace on large cards */
.card > .card-body { padding: 1.25rem; }
.card .list-group-item { padding-left: 0; padding-right: 0; }
/* Ensure grid spacing is tighter */
.row.gy-4 { --bs-gutter-y: 1.25rem; }
/* Prevent full-height stretch causing big gaps */
.col-lg-4 .card, .col-lg-8 .card { height: auto !important; }
/* Align footer buttons neatly */
.card-footer { padding: .875rem 1.25rem; }     
/* Remove transitions to prevent subtle hover animations */
#mainNavbar, .card, .profile-detail-card, .profile-avatar, .profile-photo, .btn, .list-group-item { transition: none !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Profil Pengguna',
    'subtitle' => 'Kelola informasi akun dan pengaturan Anda',
    'icon' => 'person-circle',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row gy-4">
  <!-- Left: Profile summary -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title"><i class="bi bi-person-circle me-2"></i>Informasi Profil</h5>
      </div>
      <div class="card-body">
        <!-- Avatar / Photo -->
        <div class="text-center mb-4">
          <?php if (!empty($user['foto_url'])): ?>
            <img src="<?= esc($user['foto_url']) ?>" alt="Foto Profil" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;" onerror="this.style.display='none';this.nextElementSibling?.classList.remove('d-none');">
            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center d-none" style="width: 120px; height: 120px; font-size: 40px; font-weight: 700;">
              <?= esc($user['avatar_initials'] ?? 'U') ?>
            </div>
          <?php else: ?>
            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 40px; font-weight: 700;">
              <?= esc($user['avatar_initials'] ?? 'U') ?>
            </div>
          <?php endif; ?>
          <div class="mt-3">
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
              <i class="bi bi-camera"></i> Ganti Foto
            </button>
          </div>
        </div>

        <!-- Details -->
        <div class="list-group list-group-flush">
          <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
            <div class="text-muted">Nama Lengkap</div>
            <div class="fw-semibold ms-3 text-end"><?= esc($user['nama_lengkap'] ?? $user['nama'] ?? '-') ?></div>
          </div>
          <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
            <div class="text-muted">Username</div>
            <div class="fw-semibold ms-3 text-end">@<?= esc($user['nama_pengguna'] ?? $user['username'] ?? '-') ?></div>
          </div>
          <div class="list-group-item px-0 d-flex align-items-center justify-content-between">
            <div class="text-muted">Email</div>
            <div class="fw-semibold ms-3 text-end"><?= esc($user['email'] ?? '-') ?></div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Right: Forms -->
  <div class="col-lg-8">
    <!-- Edit Profile -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h5>
      </div>
      <div class="card-body">
        <form id="profileForm" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= esc($user['nama_lengkap'] ?? '') ?>" required>
              <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
            </div>
            <div class="col-md-6">
              <label for="nama_pengguna" class="form-label">Username <?= (($user['role'] ?? '') !== 'Super Admin') ? '<span class="text-muted small">(Hanya Super Admin yang bisa mengubah)</span>' : '' ?></label>
              <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?= esc($user['nama_pengguna'] ?? $user['username'] ?? '') ?>" <?= ($user['role'] ?? '') !== 'Super Admin' ? 'readonly' : 'required' ?>>
              <?php if (($user['role'] ?? '') === 'Super Admin'): ?>
                <div class="invalid-feedback">Username wajib diisi.</div>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email <?= (($user['role'] ?? '') !== 'Super Admin') ? '<span class="text-muted small">(Hanya Super Admin yang bisa mengubah)</span>' : '' ?></label>
              <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email'] ?? '') ?>" <?= ($user['role'] ?? '') !== 'Super Admin' ? 'readonly' : 'required' ?>>
              <?php if (($user['role'] ?? '') === 'Super Admin'): ?>
                <div class="invalid-feedback">Email tidak valid.</div>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Nomor Telepon</label>
              <input type="text" class="form-control" id="phone" name="phone" value="<?= esc($user['phone'] ?? '') ?>">
            </div>
            <div class="col-12">
              <label for="address" class="form-label">Alamat</label>
              <textarea class="form-control" id="address" name="address" rows="2"><?= esc($user['address'] ?? '') ?></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <button type="submit" form="profileForm" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
        <button type="button" class="btn btn-secondary" onclick="history.back()"><i class="bi bi-arrow-left me-1"></i>Kembali</button>
      </div>
    </div>

    <!-- Change Password -->
    <div class="card">
      <div class="card-header">
        <h5 class="card-title"><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>
      </div>
      <div class="card-body">
        <form id="passwordForm" class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="current_password" class="form-label">Password Saat Ini</label>
              <input type="password" class="form-control" id="current_password" name="current_password" required>
              <div class="invalid-feedback">Wajib diisi.</div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
              <label for="new_password" class="form-label">Password Baru</label>
              <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" required>
              <div class="form-text">Minimal 8 karakter.</div>
              <div class="invalid-feedback">Password minimal 8 karakter.</div>
            </div>
            <div class="col-md-6">
              <label for="confirm_password" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
              <div class="invalid-feedback">Harus sama dengan password baru.</div>
            </div>
          </div>
        </form>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <button type="submit" form="passwordForm" class="btn btn-success"><i class="bi bi-check2-circle me-1"></i>Perbarui Password</button>
      </div>
    </div>
  </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-camera me-2"></i>Unggah Foto Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="file" class="form-control" accept="image/*">
        <div class="form-text mt-2">Format yang didukung: JPG, PNG. Maks 2MB.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary">Unggah</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Basic front-end validation hooks
(function() {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function(form) {
    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      // simple confirm match
      if (form.id === 'passwordForm') {
        const np = document.getElementById('new_password');
        const cp = document.getElementById('confirm_password');
        if (np && cp && np.value !== cp.value) {
          event.preventDefault();
          event.stopPropagation();
          cp.setCustomValidity('Passwords do not match');
          cp.reportValidity();
        } else if (cp) {
          cp.setCustomValidity('');
        }
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
<?= $this->endSection() ?>


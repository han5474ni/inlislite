<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/users-edit.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Edit Pengguna',
    'subtitle' => (string)($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'Pengguna') . ' · ' . (string)($user['email'] ?? '-'),
    'icon' => 'person-gear',
    'backUrl' => base_url('admin/users'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3" id="editUserPage">
  <div class="row g-3">
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header"><strong>Data Pengguna</strong></div>
        <div class="card-body">
          <form method="post" action="<?= base_url('admin/users/update/' . ($user['id'] ?? '')) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama_lengkap" value="<?= esc($user['nama_lengkap'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="nama_pengguna" value="<?= esc($user['nama_pengguna'] ?? $user['username'] ?? '') ?>" required minlength="3" maxlength="50">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" value="<?= esc($user['email'] ?? '') ?>" readonly>
              <div class="form-text">Email tidak dapat diubah dari sini.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <?php $status = strtolower($user['status'] ?? ''); ?>
              <select class="form-select" name="status" required>
                <option value="Aktif" <?= $status === 'aktif' ? 'selected' : '' ?>>Active</option>
                <option value="Non-Aktif" <?= $status === 'non-aktif' ? 'selected' : '' ?>>Non-Active</option>
              </select>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan</button>
              <a href="<?= base_url('admin/users/history/' . ($user['id'] ?? '')) ?>" class="btn btn-outline-secondary"><i class="bi bi-clock-history me-1"></i>Riwayat</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <?= $this->include('admin/hak-akses') ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

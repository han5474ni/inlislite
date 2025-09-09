<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/user_create.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Tambah Pengguna',
    'subtitle' => 'Buat akun pengguna baru',
    'icon' => 'person-plus',
    'backUrl' => base_url('admin/users'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3" id="addUserPage">
  <div class="row g-3">
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header"><strong>Data Pengguna</strong></div>
        <div class="card-body">
          <form method="post" action="<?= base_url('admin/users/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama_lengkap" value="<?= esc(old('nama_lengkap','')) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="nama_pengguna" value="<?= esc(old('nama_pengguna','')) ?>" required minlength="3" maxlength="50">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" value="<?= esc(old('email','')) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kata Sandi</label>
              <input type="password" class="form-control" name="password" required minlength="6">
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-select" name="status" required>
                <option value="" <?= old('status')===''?'selected':'' ?>>Pilih Status</option>
                <option value="Aktif" <?= old('status')==='Aktif'?'selected':'' ?>>Aktif</option>
                <option value="Non-Aktif" <?= old('status')==='Non-Aktif'?'selected':'' ?>>Non-Aktif</option>
              </select>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-success" type="submit"><i class="bi bi-plus-circle me-1"></i>Simpan</button>
              <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <?php $userId = null; $current = []; $featureList = $featureList ?? [ 'user.read' => 'Lihat Pengguna', 'user.update' => 'Ubah Pengguna', 'demo.access' => 'Akses Demo' ]; ?>
      <?= $this->include('admin/hak-akses') ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

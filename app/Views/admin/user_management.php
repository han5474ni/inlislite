<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/users.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Manajemen User INLISLite',
    'subtitle' => 'Kelola pengguna sistem dan hak aksesnya',
    'icon' => 'people',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/users/edit'),
    'actionText' => 'Kelola',
    'actionIcon' => 'sliders',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0" id="userListPage">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm align-middle" id="usersTable">
          <thead>
            <tr>
              <?php if (!empty($is_edit_mode)): ?>
                <th class="text-center" style="width:60px">No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th class="text-center" style="width:140px">Status</th>
                <th class="text-center" style="width:180px">Last Login</th>
                <th class="text-center" style="width:90px">History</th>
                <th class="text-center" style="width:120px">Action</th>
              <?php else: ?>
                <th class="text-center" style="width:60px">No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th class="text-center" style="width:140px">Status</th>
                <th class="text-center" style="width:180px">Last Login</th>
                <th class="text-center" style="width:90px">History</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users ?? [])): ?>
              <?php foreach (($users ?? []) as $index => $u): ?>
                <tr>
                  <?php if (!empty($is_edit_mode)): ?>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td title="<?= esc($u['nama_lengkap'] ?? $u['full_name'] ?? '') ?>"><?= esc($u['nama_lengkap'] ?? $u['full_name'] ?? '') ?></td>
                    <td title="<?= esc($u['nama_pengguna'] ?? $u['username'] ?? '') ?>"><?= esc($u['nama_pengguna'] ?? $u['username'] ?? '') ?></td>
                    <td title="<?= esc($u['email'] ?? '') ?>"><?= esc($u['email'] ?? '') ?></td>
                    <td class="text-center">
                      <?php $st = strtolower($u['status'] ?? ''); ?>
                      <span class="status-badge <?= $st === 'aktif' ? 'status-active' : ($st === 'non-aktif' ? 'status-inactive' : 'status-unknown') ?>"><?= esc($u['status'] ?? '-') ?></span>
                    </td>
                    <td class="text-center"><?= esc($u['last_login'] ?? '-') ?></td>
                    <td class="text-center">
                      <a href="<?= base_url('admin/users/history/' . ($u['id'] ?? '')) ?>" class="btn btn-sm btn-outline-secondary" title="Riwayat">
                        <i class="bi bi-clock-history"></i>
                      </a>
                    </td>
                    <td class="text-center">
                      <a href="<?= base_url('admin/users/edit/' . ($u['id'] ?? '')) ?>" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil"></i></a>
                      <a href="<?= base_url('admin/users/delete/' . ($u['id'] ?? '')) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                  <?php else: ?>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td title="<?= esc($u['nama_lengkap'] ?? $u['full_name'] ?? '') ?>"><?= esc($u['nama_lengkap'] ?? $u['full_name'] ?? '') ?></td>
                    <td title="<?= esc($u['email'] ?? '') ?>"><?= esc($u['email'] ?? '') ?></td>
                    <td class="text-center">
                      <?php $st = strtolower($u['status'] ?? ''); ?>
                      <span class="status-badge <?= $st === 'aktif' ? 'status-active' : ($st === 'non-aktif' ? 'status-inactive' : 'status-unknown') ?>"><?= esc($u['status'] ?? '-') ?></span>
                    </td>
                    <td class="text-center"><?= esc($u['last_login'] ?? '-') ?></td>
                    <td class="text-center">
                      <a href="<?= base_url('admin/users/history/' . ($u['id'] ?? '')) ?>" class="btn btn-sm btn-outline-secondary" title="Riwayat">
                        <i class="bi bi-clock-history"></i>
                      </a>
                    </td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('assets/js/admin/users.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/user-history.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Riwayat Aktivitas',
    'subtitle' => (string)($user['nama_lengkap'] ?? $user['nama_pengguna'] ?? 'Pengguna') . ' · ' . 'Email: ' . (string)($user['email'] ?? '-'),
    'icon' => 'clock-history',
    'backUrl' => base_url('admin/users'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3">
  <div class="card">
    <div class="card-body p-0">
      <?php if (!empty($activities)): ?>
        <?php foreach ($activities as $log): ?>
          <?php 
            $badge = 'bg-secondary';
            $color = $log['color'] ?? 'secondary';
            if (in_array($color, ['success','primary','warning','secondary','info'])) { $badge = 'bg-' . $color; }
          ?>
          <div class="activity-item">
            <div class="activity-icon <?= esc($badge) ?>">
              <i class="bi <?= esc($log['icon'] ?? 'bi-activity') ?>"></i>
            </div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between">
                <div>
                  <strong class="text-dark text-capitalize"><?= esc($log['action'] ?? '-') ?></strong>
                  <div><?= esc($log['description'] ?? '-') ?></div>
                </div>
                <div class="text-end activity-meta">
                  <small><i class="bi bi-clock me-1"></i><?= esc($log['created_at_formatted'] ?? ($log['created_at'] ?? '')) ?></small><br>
                  <small><i class="bi bi-pc-display me-1"></i><?= esc($log['ip_address'] ?? '-') ?> · <?= esc($log['user_agent'] ?? '') ?></small>
                </div>
              </div>
              <?php if (!empty($log['old_data_decoded']) || !empty($log['new_data_decoded'])): ?>
                <div class="row mt-2 g-2">
                  <?php if (!empty($log['old_data_decoded'])): ?>
                    <div class="col-md-6">
                      <div class="diff-block">
                        <div class="fw-semibold mb-1">Data Lama</div>
                        <pre class="mb-0"><?= esc(json_encode($log['old_data_decoded'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) ?></pre>
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($log['new_data_decoded'])): ?>
                    <div class="col-md-6">
                      <div class="diff-block">
                        <div class="fw-semibold mb-1">Data Baru</div>
                        <pre class="mb-0"><?= esc(json_encode($log['new_data_decoded'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) ?></pre>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="p-4 text-center text-muted">Belum ada aktivitas untuk pengguna ini.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/admin/user-history.js') ?>"></script>
<?= $this->endSection() ?>

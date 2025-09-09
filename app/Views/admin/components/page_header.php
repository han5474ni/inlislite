<?php
/**
 * Reusable Admin Page Header
 * Usage: echo view('admin/components/page_header', [
 *   'title' => 'Tentang Inlislite Versi 3',
 *   'subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan',
 *   'icon' => 'book', // bootstrap icon name without 'bi-'
 *   'backUrl' => base_url('admin'),
 *   'bg' => 'green', // green|blue|purple|orange (optional)
 * ]);
 */

$bg = $bg ?? 'green';
$icon = $icon ?? 'info-circle';
?>
<div class="admin-page-header admin-page-header-<?= esc($bg) ?>">
  <div class="d-flex align-items-center gap-3">
    <a href="<?= esc($backUrl ?? 'javascript:history.back()') ?>" class="admin-back-btn" aria-label="Kembali">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div class="icon-48 tile-bg-<?= esc($bg === 'green' ? 'success' : ($bg === 'blue' ? 'primary' : ($bg === 'purple' ? 'purple' : 'orange'))) ?>">
      <i class="bi bi-<?= esc($icon) ?> text-white"></i>
    </div>
    <div>
      <h1 class="admin-page-title mb-0"><?= esc($title ?? '') ?></h1>
      <?php if (!empty($subtitle)): ?>
        <div class="admin-page-subtitle"><?= esc($subtitle) ?></div>
      <?php endif; ?>
    </div>
  </div>
  <?php if (!empty($actionUrl ?? null)): ?>
    <div class="ms-auto d-flex align-items-center">
      <a href="<?= esc($actionUrl) ?>" class="btn btn-outline-light">
        <i class="bi bi-<?= esc($actionIcon ?? 'gear') ?> me-2"></i><?= esc($actionText ?? 'Kelola') ?>
      </a>
    </div>
  <?php endif; ?>
</div>
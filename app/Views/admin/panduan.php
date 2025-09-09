<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/panduan.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Panduan Pengguna',
    'subtitle' => 'Dokumentasi dan tutorial',
    'icon' => 'book',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/panduan-edit'),
    'actionText' => 'Kelola',
    'actionIcon' => 'sliders',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="container">




        <section class="content-section">
            <div class="row g-4" id="contentContainer">
                <!-- Content will be loaded here -->
            </div>
        </section>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/admin/panduan.js') ?>"></script>
<?= $this->endSection() ?>
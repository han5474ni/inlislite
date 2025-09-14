<?= $this->extend('layout') ?>

<?= $this->section('page_header') ?>
<header class="page-header page-header--image page-header--with-overlay page-header--bg-fixed text-center" style="--header-bg-url: url('<?= base_url('assets/images/hero.jpeg') ?>');">
    <div class="page-header__overlay"></div>
    <div class="container">
        <h1 class="page-title page-title--md fw-bold mb-2 text-white"><?= esc($page_title ?? 'Tentang Kami') ?></h1>
        <p class="page-subtitle page-subtitle--md text-white-50">Informasi ringkas tentang INLISLite v3</p>
    </div>
</header>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <?php $cards = (array) ($about_content ?? []); ?>
        <?php if (empty($cards)): ?>
            <div class="text-center text-muted py-5">Belum ada konten yang ditampilkan.</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($cards as $card): ?>
                    <?php
                        $iconClass   = trim($card['icon'] ?? 'bi-info-circle');
                        $title       = $card['title'] ?? '';
                        $subtitle    = $card['subtitle'] ?? '';
                        $desc        = $card['description'] ?? '';
                        $content     = $card['content'] ?? '';
                        $type        = $card['card_type'] ?? 'info';
                        $linkUrl     = $card['link_url'] ?? '';
                        $linkText    = $card['link_text'] ?? '';
                        $headerColor = $card['background_color'] ?? '#2563eb';
                    ?>
                    <div class="col-12">
                        <div class="tt-card shadow-sm">
                            <div class="tt-card-header" style="background-color: <?= esc($headerColor) ?>;">
                                <div class="tt-icon"><i class="bi <?= esc($iconClass) ?>"></i></div>
                                <h3 class="tt-title mb-0">
                                    <?= esc($title) ?>
                                </h3>
                            </div>
                            <div class="tt-card-body">
                                <p class="tt-desc mb-0">
                                    <?php if ($desc): ?>
                                        <?= esc($desc) ?>
                                    <?php else: ?>
                                        <?= nl2br(esc(mb_strimwidth(strip_tags($content), 0, 480, '…'))) ?>
                                    <?php endif; ?>
                                </p>
                                <?php if (!empty($linkUrl) && !empty($linkText)): ?>
                                <div class="mt-3">
                                    <a class="btn btn-primary" href="<?= esc($linkUrl) ?>" target="_blank" rel="noopener"><?= esc($linkText) ?></a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>
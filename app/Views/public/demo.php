<?= view('public/layout/header', ['page_title' => $page_title ?? 'Demo Program']) ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        
        </div>
    </div>
</section>

<!-- Demo Details Modal -->
<div class="modal fade" id="demoDetailsModal" tabindex="-1" aria-labelledby="demoDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoDetailsModalLabel">Detail Demo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="demoDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary-gradient" id="accessDemoBtn">
                    <i class="bi bi-play-circle me-2"></i>
                    Akses Demo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Demo Page JavaScript -->
<script src="<?= base_url('assets/js/public/demo.js') ?>"></script>

<?= view('public/layout/footer') ?>
<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<!-- Page CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-table-theme.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/admin-fixes.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/admin/dashboard.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Kelola Demo Program',
    'subtitle' => 'Tambah, ubah, dan atur urutan demo program',
    'icon' => 'tv',
    'backUrl' => base_url('admin/demo'),
    'bg' => 'green',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
  <div class="panel-content">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h3 class="panel-title m-0">Manajemen Demo</h3>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDemoModal">
        <i class="bi bi-plus-circle me-2"></i>Tambah Demo
      </button>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-striped table-sm align-middle table-admin table-theme-green" id="demosTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Icon</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Versi</th>
            <th>Status</th>
            <th>Diunggulkan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Demo Modal -->
<div class="modal fade" id="addDemoModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Demo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addDemoForm">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="demoTitle" class="form-label">Judul *</label>
                <input type="text" class="form-control" id="demoTitle" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="demoSubtitle" class="form-label">Subtitle</label>
                <input type="text" class="form-control" id="demoSubtitle">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="demoDescription" class="form-label">Deskripsi *</label>
            <textarea class="form-control" id="demoDescription" rows="4" required></textarea>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="demoCategory" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="demoCategory" placeholder="cataloging/circulation/...">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="demoVersion" class="form-label">Versi</label>
                <input type="text" class="form-control" id="demoVersion" placeholder="1.0">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="demoStatus" class="form-label">Status</label>
                <select class="form-select" id="demoStatus">
                  <option value="active">Aktif</option>
                  <option value="inactive">Tidak Aktif</option>
                  <option value="draft">Draft</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="demoUrl" class="form-label">URL Demo</label>
                <input type="url" class="form-control" id="demoUrl" placeholder="https://...">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="demoIcon" class="form-label">Icon (Bootstrap Icons)</label>
                <input type="text" class="form-control" id="demoIcon" placeholder="bi-tv">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSaveDemo">Simpan</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
(function() {
  'use strict';
  const table = new DataTable('#demosTable', {
    ajax: {
      url: '<?= base_url('admin/demo/data') ?>',
      dataSrc: function(json){ return json?.data || []; }
    },
    columns: [
      { data: 'id' },
      { data: 'icon', render: d => d ? `<i class="bi ${d}"></i>` : '' },
      { data: 'title' },
      { data: 'category' },
      { data: 'version' },
      { data: 'status', render: d => d ? d.charAt(0).toUpperCase()+d.slice(1) : '' },
      { data: 'is_featured', render: d => d ? 'Ya' : 'Tidak' },
      { data: null, orderable: false, render: (row) => `
          <div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-outline-primary" data-id="${row.id}" onclick="editDemo(${row.id})"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-outline-danger" data-id="${row.id}" onclick="deleteDemo(${row.id})"><i class="bi bi-trash"></i></button>
          </div>` }
    ]
  });

  document.getElementById('btnSaveDemo').addEventListener('click', async () => {
    const payload = {
      title: document.getElementById('demoTitle').value,
      subtitle: document.getElementById('demoSubtitle').value,
      description: document.getElementById('demoDescription').value,
      category: document.getElementById('demoCategory').value,
      version: document.getElementById('demoVersion').value,
      status: document.getElementById('demoStatus').value,
      demo_url: document.getElementById('demoUrl').value,
      icon: document.getElementById('demoIcon').value,
    };
    try {
      const res = await fetch('<?= base_url('admin/demo/store') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const json = await res.json();
      if (json.success) {
        bootstrap.Modal.getInstance(document.getElementById('addDemoModal'))?.hide();
        table.ajax.reload();
      } else {
        alert(json.message || 'Gagal menyimpan data');
      }
    } catch (e) {
      alert('Terjadi kesalahan saat menyimpan');
    }
  });
})();

// Placeholder handlers; can be wired to update/delete endpoints later
function editDemo(id){
  // Open modal and populate via AJAX as needed
}
function deleteDemo(id){
  if(!confirm('Hapus demo ini?')) return;
  fetch('<?= base_url('admin/demo/delete') ?>/' + id)
    .then(() => location.reload());
}
</script>
<?= $this->endSection() ?>
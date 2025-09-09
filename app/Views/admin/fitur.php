<?= $this->extend('layout') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/admin/fitur.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
<?= view('admin/components/page_header', [
    'title' => 'Fitur dan Modul Program',
    'subtitle' => 'Informasi lengkap tentang sistem otomasi perpustakaan',
    'icon' => 'puzzle-fill',
    'backUrl' => base_url('admin'),
    'bg' => 'green',
    'actionUrl' => base_url('admin/fitur#managementSection'),
    'actionText' => 'Kelola',
    'actionIcon' => 'sliders',
]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="container">




        <section class="features-section mb-5">
            <div class="features-grid">
                <div class="row g-4" id="featuresContainer">
                    <!-- Features will be loaded here -->
                </div>
            </div>
        </section>

        <!-- Manajemen Inline (gabungan dari fitur-edit) -->
        <section id="managementSection" class="mb-5">
            <div class="section-header mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="section-title mb-0">Kelola Fitur & Modul</h2>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshAll()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFeatureModal">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Fitur
                        </button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Modul
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">Manajemen Fitur</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="featuresTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px" class="text-center">#</th>
                                            <th style="width:60px" class="text-center">Icon</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th style="width:100px" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody><!-- dynamic --></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">Manajemen Modul</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="modulesTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px" class="text-center">#</th>
                                            <th style="width:60px" class="text-center">Icon</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th style="width:140px" class="text-center">Tipe</th>
                                            <th style="width:100px" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody><!-- dynamic --></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="modules-section">
            <div class="modules-grid">
                <div class="row g-4" id="modulesContainer">
                    <!-- Modules will be loaded here -->
                </div>
            </div>
        </section>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  window.baseUrl = "<?= base_url() ?>";

  // Simple fetch + render using existing endpoints handled by Admin\FiturController
  function refreshContent() { refreshFeatures(); refreshModules(); }
  function refreshAll() { refreshContent(); }

  async function fetchJSON(url, opts = {}) {
    const res = await fetch(url, opts);
    if (!res.ok) throw new Error('HTTP ' + res.status);
    return res.json();
  }

  function iconHtml(icon) { return `<i class="bi ${icon || 'bi-star'}"></i>`; }

  function featureRowHtml(item, idx) {
    return `<tr>
      <td class="text-center">${idx}</td>
      <td class="text-center">${iconHtml(item.icon)}</td>
      <td>${item.title || ''}</td>
      <td>${item.description || ''}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-outline-primary" onclick="openEdit('feature', ${item.id})"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('feature', ${item.id})"><i class="bi bi-trash"></i></button>
      </td>
    </tr>`;
  }

  function moduleRowHtml(item, idx) {
    return `<tr>
      <td class="text-center">${idx}</td>
      <td class="text-center">${iconHtml(item.icon)}</td>
      <td>${item.title || ''}</td>
      <td>${item.description || ''}</td>
      <td class="text-center">${item.module_type || '-'}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-outline-primary" onclick="openEdit('module', ${item.id})"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger" onclick="removeItem('module', ${item.id})"><i class="bi bi-trash"></i></button>
      </td>
    </tr>`;
  }

  async function refreshFeatures() {
    try {
      const data = await fetchJSON(`${baseUrl}/admin/fitur/data?type=feature`);
      if (!data.success) return;
      const tbody = document.querySelector('#featuresTable tbody');
      if (!tbody) return;
      tbody.innerHTML = (data.data || []).map((it, i) => featureRowHtml(it, i+1)).join('');
    } catch (e) { console.error(e); }
  }

  async function refreshModules() {
    try {
      const data = await fetchJSON(`${baseUrl}/admin/fitur/data?type=module`);
      if (!data.success) return;
      const tbody = document.querySelector('#modulesTable tbody');
      if (!tbody) return;
      tbody.innerHTML = (data.data || []).map((it, i) => moduleRowHtml(it, i+1)).join('');
    } catch (e) { console.error(e); }
  }

  function openEdit(type, id) {
    alert('Edit ' + type + ' #' + id + ' — form inline bisa ditambahkan sesuai kebutuhan.');
  }

  async function removeItem(type, id) {
    if (!confirm('Hapus ' + type + ' #' + id + '?')) return;
    try {
      const res = await fetch(`${baseUrl}/admin/fitur/delete/` + id, { method: 'POST' });
      const data = await res.json();
      if (data.success) {
        refreshContent();
      } else {
        alert(data.message || 'Gagal menghapus');
      }
    } catch (e) {
      alert('Gagal menghapus');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    refreshContent();
  });
</script>

<!-- Modals (inline, ringkas) -->
<div class="modal fade" id="addFeatureModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Tambah Fitur</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="addFeatureForm">
          <?= csrf_field() ?>
          <div class="mb-2"><label class="form-label">Judul</label><input name="title" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3" required></textarea></div>
          <div class="mb-2"><label class="form-label">Icon</label><input name="icon" class="form-control" placeholder="bi-star" required></div>
          <div class="mb-2"><label class="form-label">Warna</label>
            <select name="color" class="form-select" required>
              <option value="blue">Biru</option>
              <option value="green">Hijau</option>
              <option value="orange">Orange</option>
              <option value="purple">Ungu</option>
            </select>
          </div>
          <input type="hidden" name="type" value="feature">
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" onclick="submitAdd('feature')">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addModuleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Tambah Modul</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <form id="addModuleForm">
          <?= csrf_field() ?>
          <div class="mb-2"><label class="form-label">Judul</label><input name="title" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3" required></textarea></div>
          <div class="mb-2"><label class="form-label">Icon</label><input name="icon" class="form-control" placeholder="bi-gear" required></div>
          <div class="mb-2"><label class="form-label">Warna</label>
            <select name="color" class="form-select" required>
              <option value="blue">Biru</option>
              <option value="green">Hijau</option>
              <option value="orange">Orange</option>
              <option value="purple">Ungu</option>
            </select>
          </div>
          <div class="mb-2"><label class="form-label">Tipe</label>
            <select name="module_type" class="form-select" required>
              <option value="application">Application</option>
              <option value="database">Database</option>
              <option value="utility">Utility</option>
            </select>
          </div>
          <input type="hidden" name="type" value="module">
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-success" onclick="submitAdd('module')">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
  async function submitAdd(kind) {
    const form = document.getElementById(kind === 'feature' ? 'addFeatureForm' : 'addModuleForm');
    const fd = new FormData(form);
    try {
      const res = await fetch(`${baseUrl}/admin/fitur/store`, { method: 'POST', body: fd });
      const data = await res.json();
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById(kind === 'feature' ? 'addFeatureModal' : 'addModuleModal')).hide();
        refreshContent();
      } else {
        alert(data.message || 'Gagal menyimpan');
      }
    } catch (e) { alert('Gagal menyimpan'); }
  }
</script>
<?= $this->endSection() ?>
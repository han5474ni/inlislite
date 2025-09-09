<?php
/**
 * Partial: hak-akses.php
 * Reusable feature access toggles for a user
 * Expected vars: $user (array: id, nama_lengkap,...)
 */
helper('feature_access');
$featureList = [
  'tentang'   => 'Tentang',
  'patch'     => 'Patch & Updater',
  'fitur'     => 'Fitur',
  'aplikasi'  => 'Aplikasi',
  'panduan'   => 'Panduan',
  'dukungan'  => 'Dukungan',
  'bimbingan' => 'Bimbingan',
  'demo'      => 'Demo',
  'installer' => 'Installer',
];
$userId = $user['id'] ?? null;
$current = get_user_features($userId);
?>
<style>
  .toggle { position:relative; width:52px; height:30px; background:#e5e7eb; border-radius:999px; cursor:pointer; transition:.2s; display:inline-flex; align-items:center; padding:4px; }
  .toggle.active { background:#e0e7ff; }
  .toggle .knob { width:22px; height:22px; background:#6366f1; border-radius:999px; transition:.2s; transform: translateX(0); }
  .toggle.active .knob { transform: translateX(22px); }
  .feature-row { display:flex; align-items:center; justify-content:space-between; padding:.5rem .75rem; border:1px solid #e5e7eb; border-radius:10px; }
  .feature-row + .feature-row { margin-top:.5rem; } 
  .toggle, .btn, .feature-row { transition: none !important; }
</style>
<div class="card" id="featureAccessCard">
  <div class="card-header"><strong>Hak Akses Fitur</strong></div>
  <div class="card-body">
    <div class="row g-3">
      <?php foreach ($featureList as $key => $label): $on = in_array($key, $current ?? []); ?>
        <div class="col-md-6">
          <div class="feature-row" data-feature="<?= esc($key) ?>">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-shield-check text-primary"></i>
              <span><?= esc($label) ?></span>
            </div>
            <div class="toggle <?= $on ? 'active' : '' ?>" role="switch" aria-checked="<?= $on ? 'true' : 'false' ?>">
              <div class="knob"></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-end mt-3">
      <button id="btnSaveFeatures" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>Simpan Hak Akses
      </button>
    </div>
  </div>
</div>
<script>
(function(){
  const container = document.getElementById('featureAccessCard');
  if (!container) return;

  const endpoint = '<?= base_url('admin/users/ajax/features/' . ($userId ?? 0)) ?>';
  const btn = container.querySelector('#btnSaveFeatures');

  function collectFeatures(){
    const rows = container.querySelectorAll('.feature-row');
    const features = [];
    rows.forEach(r => {
      const f = r.getAttribute('data-feature');
      const active = r.querySelector('.toggle').classList.contains('active');
      if (active) features.push(f);
    });
    return features;
  }

  async function save(features, isAuto=false){
    try {
      if (!isAuto) { btn.disabled = true; btn.innerHTML = 'Menyimpan...'; }
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ features })
      });
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const data = await res.json();
      if (!data?.success) throw new Error(data?.message || 'Gagal menyimpan');
      if (!isAuto) {
        btn.innerHTML = 'Tersimpan';
        setTimeout(()=>{ btn.innerHTML = '<i class="bi bi-save me-1"></i>Simpan Hak Akses'; btn.disabled = false; }, 1000);
      }
    } catch(err) {
      if (!isAuto) {
        alert(err.message || 'Terjadi kesalahan');
        btn.innerHTML = '<i class="bi bi-save me-1"></i>Simpan Hak Akses';
        btn.disabled = false;
      } else {
        console.error('Gagal auto-save hak akses:', err);
      }
    }
  }

  // Toggle interactions + auto-save
  const toggles = container.querySelectorAll('.feature-row .toggle');
  toggles.forEach(t => t.addEventListener('click', () => {
    t.classList.toggle('active');
    t.setAttribute('aria-checked', t.classList.contains('active') ? 'true' : 'false');
    // Auto-save on toggle change
    const features = collectFeatures();
    save(features, true);
  }));

  // Manual save button
  btn?.addEventListener('click', () => save(collectFeatures(), false));
})();
</script>

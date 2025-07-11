<?php $this->extend('layout/admin_layout'); ?>

<?php $this->section('content'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Database Replication</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Database Replication</li>
    </ol>
    
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-database me-1"></i>
                        Status Replikasi
                    </div>
                    <div>
                        <button id="refreshStatus" class="btn btn-sm btn-primary">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <a href="/admin/replication/settings" class="btn btn-sm btn-secondary">
                            <i class="fas fa-cog"></i> Pengaturan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!$status['enabled']) : ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Replikasi database saat ini tidak aktif. Aktifkan di halaman pengaturan.
                        </div>
                    <?php else : ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Informasi Replikasi</h5>
                                        <table class="table table-sm">
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="badge bg-success">Aktif</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mode</th>
                                                <td>
                                                    <?php if ($status['mode'] === 'master-slave') : ?>
                                                        <span class="badge bg-info">Master-Slave</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-info">Master-Master</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Master Server</th>
                                                <td><?= $status['master']['connected'] ? '<span class="text-success"><i class="fas fa-check-circle"></i> Terhubung</span>' : '<span class="text-danger"><i class="fas fa-times-circle"></i> Tidak Terhubung</span>' ?></td>
                                            </tr>
                                            <tr>
                                                <th>Slave Servers</th>
                                                <td><?= count($status['slaves']) ?> server</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Status Master</h5>
                                        <?php if ($status['master']['connected']) : ?>
                                            <?php if (isset($status['master']['info']) && !empty($status['master']['info'])) : ?>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <th>Binary Log File</th>
                                                        <td><?= $status['master']['info']['File'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Position</th>
                                                        <td><?= $status['master']['info']['Position'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Binlog_Do_DB</th>
                                                        <td><?= $status['master']['info']['Binlog_Do_DB'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Binlog_Ignore_DB</th>
                                                        <td><?= $status['master']['info']['Binlog_Ignore_DB'] ?? 'N/A' ?></td>
                                                    </tr>
                                                </table>
                                            <?php else : ?>
                                                <div class="alert alert-info">
                                                    Tidak dapat mengambil informasi master status.
                                                </div>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="alert alert-danger">
                                                <i class="fas fa-exclamation-circle"></i> Tidak dapat terhubung ke master server.
                                                <?php if (isset($status['master']['error'])) : ?>
                                                    <br>Error: <?= $status['master']['error'] ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($status['slaves'])) : ?>
                            <h5>Slave Servers</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>IO Thread</th>
                                            <th>SQL Thread</th>
                                            <th>Master Log File</th>
                                            <th>Read Position</th>
                                            <th>Exec Position</th>
                                            <th>Lag</th>
                                            <th>Last Error</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($status['slaves'] as $index => $slave) : ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <?php if ($slave['connected']) : ?>
                                                        <?php if (isset($slave['running']) && $slave['running']) : ?>
                                                            <span class="badge bg-success">Running</span>
                                                        <?php else : ?>
                                                            <span class="badge bg-warning">Not Running</span>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <span class="badge bg-danger">Not Connected</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (isset($slave['info']['Slave_IO_Running'])) : ?>
                                                        <?php if ($slave['info']['Slave_IO_Running'] === 'Yes') : ?>
                                                            <span class="text-success"><i class="fas fa-check-circle"></i> Yes</span>
                                                        <?php else : ?>
                                                            <span class="text-danger"><i class="fas fa-times-circle"></i> No</span>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (isset($slave['info']['Slave_SQL_Running'])) : ?>
                                                        <?php if ($slave['info']['Slave_SQL_Running'] === 'Yes') : ?>
                                                            <span class="text-success"><i class="fas fa-check-circle"></i> Yes</span>
                                                        <?php else : ?>
                                                            <span class="text-danger"><i class="fas fa-times-circle"></i> No</span>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $slave['info']['Master_Log_File'] ?? 'N/A' ?></td>
                                                <td><?= $slave['info']['Read_Master_Log_Pos'] ?? 'N/A' ?></td>
                                                <td><?= $slave['info']['Exec_Master_Log_Pos'] ?? 'N/A' ?></td>
                                                <td>
                                                    <?php if (isset($slave['info']['Seconds_Behind_Master'])) : ?>
                                                        <?php if ($slave['info']['Seconds_Behind_Master'] === NULL) : ?>
                                                            N/A
                                                        <?php elseif ($slave['info']['Seconds_Behind_Master'] == 0) : ?>
                                                            <span class="badge bg-success">0s</span>
                                                        <?php elseif ($slave['info']['Seconds_Behind_Master'] < 60) : ?>
                                                            <span class="badge bg-info"><?= $slave['info']['Seconds_Behind_Master'] ?>s</span>
                                                        <?php elseif ($slave['info']['Seconds_Behind_Master'] < 300) : ?>
                                                            <span class="badge bg-warning"><?= floor($slave['info']['Seconds_Behind_Master'] / 60) ?>m <?= $slave['info']['Seconds_Behind_Master'] % 60 ?>s</span>
                                                        <?php else : ?>
                                                            <span class="badge bg-danger"><?= floor($slave['info']['Seconds_Behind_Master'] / 60) ?>m <?= $slave['info']['Seconds_Behind_Master'] % 60 ?>s</span>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (isset($slave['info']['Last_Error']) && !empty($slave['info']['Last_Error'])) : ?>
                                                        <span class="text-danger"><?= $slave['info']['Last_Error'] ?></span>
                                                    <?php else : ?>
                                                        <span class="text-success">No errors</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <?php if ($status['mode'] === 'master-slave') : ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Tidak ada slave server yang dikonfigurasi. Tambahkan slave server di halaman pengaturan.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        // Refresh status button
        $('#refreshStatus').on('click', function() {
            location.reload();
        });
        
        // Auto refresh status every 60 seconds
        setInterval(function() {
            $.ajax({
                url: '/admin/replication/check-status',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // You could update the UI here without a full page reload
                    // For simplicity, we'll just reload the page
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error checking replication status:', error);
                }
            });
        }, 60000); // 60 seconds
    });
</script>
<?php $this->endSection(); ?>
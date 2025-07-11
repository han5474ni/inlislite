<?php $this->extend('layout/admin_layout'); ?>

<?php $this->section('content'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Pengaturan Replikasi Database</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/replication">Database Replication</a></li>
        <li class="breadcrumb-item active">Pengaturan</li>
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
                <div class="card-header">
                    <i class="fas fa-cog me-1"></i>
                    Konfigurasi Replikasi
                </div>
                <div class="card-body">
                    <form action="/admin/replication/update-settings" method="post" id="replicationForm">
                        <?= csrf_field() ?>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Pengaturan ini hanya mengubah konfigurasi aplikasi. Untuk mengatur replikasi MySQL, gunakan skrip setup di <code>tools/database/setup_replication.php</code>.
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status Replikasi</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" <?= $config->enabled ? 'checked' : '' ?>>
                                <label class="form-check-label" for="enabled">Aktifkan Replikasi Database</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="mode" class="form-label">Mode Replikasi</label>
                            <select class="form-select" id="mode" name="mode">
                                <option value="master-slave" <?= $config->mode === 'master-slave' ? 'selected' : '' ?>>Master-Slave</option>
                                <option value="master-master" <?= $config->mode === 'master-master' ? 'selected' : '' ?>>Master-Master</option>
                            </select>
                            <div class="form-text">Master-Slave: Satu server utama (write) dengan beberapa server slave (read-only). Master-Master: Beberapa server yang dapat melakukan write.</div>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Konfigurasi Master Server</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="master_hostname" class="form-label">Hostname</label>
                                <input type="text" class="form-control" id="master_hostname" name="master_hostname" value="<?= $config->master['hostname'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="master_port" class="form-label">Port</label>
                                <input type="number" class="form-control" id="master_port" name="master_port" value="<?= $config->master['port'] ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="master_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="master_username" name="master_username" value="<?= $config->master['username'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="master_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="master_password" name="master_password" value="<?= $config->master['password'] ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="master_database" class="form-label">Database</label>
                                <input type="text" class="form-control" id="master_database" name="master_database" value="<?= $config->master['database'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="master_server_id" class="form-label">Server ID</label>
                                <input type="number" class="form-control" id="master_server_id" name="master_server_id" value="<?= $config->master['server_id'] ?>" required>
                                <div class="form-text">ID unik untuk server ini dalam konfigurasi replikasi MySQL.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" id="testMasterConnection" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plug"></i> Test Koneksi Master
                            </button>
                            <span id="masterConnectionResult" class="ms-2"></span>
                        </div>
                        
                        <div id="slaveServersContainer">
                            <h4 class="mt-4 mb-3">Konfigurasi Slave Servers</h4>
                            <div class="alert alert-warning" id="noSlavesMessage" style="<?= !empty($config->slaves) ? 'display:none;' : '' ?>">
                                <i class="fas fa-exclamation-triangle"></i> Tidak ada slave server yang dikonfigurasi.
                            </div>
                            
                            <?php foreach ($config->slaves as $index => $slave) : ?>
                                <div class="card mb-3 slave-server-card" data-index="<?= $index ?>">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>Slave Server #<?= $index + 1 ?></span>
                                        <button type="button" class="btn btn-sm btn-danger remove-slave-btn">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hostname</label>
                                                <input type="text" class="form-control" name="slave_<?= $index ?>_hostname" value="<?= $slave['hostname'] ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Port</label>
                                                <input type="number" class="form-control" name="slave_<?= $index ?>_port" value="<?= $slave['port'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="slave_<?= $index ?>_username" value="<?= $slave['username'] ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="slave_<?= $index ?>_password" value="<?= $slave['password'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Database</label>
                                                <input type="text" class="form-control" name="slave_<?= $index ?>_database" value="<?= $slave['database'] ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Server ID</label>
                                                <input type="number" class="form-control" name="slave_<?= $index ?>_server_id" value="<?= $slave['server_id'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm test-slave-connection" data-index="<?= $index ?>">
                                                <i class="fas fa-plug"></i> Test Koneksi
                                            </button>
                                            <span class="slave-connection-result ms-2"></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <input type="hidden" id="slave_count" name="slave_count" value="<?= count($config->slaves) ?>">
                        
                        <div class="mb-4">
                            <button type="button" id="addSlaveBtn" class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> Tambah Slave Server
                            </button>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Tabel yang Direplikasi</h4>
                        <div class="mb-3">
                            <label for="tables" class="form-label">Tabel yang Direplikasi</label>
                            <textarea class="form-control" id="tables" name="tables" rows="3"><?= implode(", ", $config->tables) ?></textarea>
                            <div class="form-text">Daftar tabel yang akan direplikasi, dipisahkan dengan koma. Kosongkan untuk mereplikasi semua tabel.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exclude_tables" class="form-label">Tabel yang Dikecualikan</label>
                            <textarea class="form-control" id="exclude_tables" name="exclude_tables" rows="3"><?= implode(", ", $config->excludeTables) ?></textarea>
                            <div class="form-text">Daftar tabel yang tidak akan direplikasi, dipisahkan dengan koma.</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="/admin/replication" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for new slave server -->
<template id="slaveServerTemplate">
    <div class="card mb-3 slave-server-card" data-index="{index}">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Slave Server #{number}</span>
            <button type="button" class="btn btn-sm btn-danger remove-slave-btn">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hostname</label>
                    <input type="text" class="form-control" name="slave_{index}_hostname" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Port</label>
                    <input type="number" class="form-control" name="slave_{index}_port" value="3306" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="slave_{index}_username" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="slave_{index}_password" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Database</label>
                    <input type="text" class="form-control" name="slave_{index}_database" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Server ID</label>
                    <input type="number" class="form-control" name="slave_{index}_server_id" required>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-outline-primary btn-sm test-slave-connection" data-index="{index}">
                    <i class="fas fa-plug"></i> Test Koneksi
                </button>
                <span class="slave-connection-result ms-2"></span>
            </div>
        </div>
    </div>
</template>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        // Add slave server button
        $('#addSlaveBtn').on('click', function() {
            const slaveCount = parseInt($('#slave_count').val());
            const newIndex = slaveCount;
            const template = $('#slaveServerTemplate').html()
                .replace(/{index}/g, newIndex)
                .replace(/{number}/g, newIndex + 1);
            
            $('#slaveServersContainer').append(template);
            $('#slave_count').val(newIndex + 1);
            $('#noSlavesMessage').hide();
            
            // Re-bind event handlers for the new elements
            bindSlaveEvents();
        });
        
        // Function to bind events to slave server elements
        function bindSlaveEvents() {
            // Remove slave server button
            $('.remove-slave-btn').off('click').on('click', function() {
                $(this).closest('.slave-server-card').remove();
                
                // Renumber the remaining slave servers
                $('.slave-server-card').each(function(index) {
                    $(this).find('.card-header span').text('Slave Server #' + (index + 1));
                });
                
                // Update slave count
                $('#slave_count').val($('.slave-server-card').length);
                
                // Show message if no slaves
                if ($('.slave-server-card').length === 0) {
                    $('#noSlavesMessage').show();
                }
            });
            
            // Test slave connection button
            $('.test-slave-connection').off('click').on('click', function() {
                const index = $(this).data('index');
                const card = $(this).closest('.slave-server-card');
                const resultSpan = card.find('.slave-connection-result');
                
                resultSpan.html('<i class="fas fa-spinner fa-spin"></i> Testing connection...');
                
                $.ajax({
                    url: '/admin/replication/test-connection',
                    type: 'POST',
                    data: {
                        hostname: card.find(`input[name="slave_${index}_hostname"]`).val(),
                        username: card.find(`input[name="slave_${index}_username"]`).val(),
                        password: card.find(`input[name="slave_${index}_password"]`).val(),
                        database: card.find(`input[name="slave_${index}_database"]`).val(),
                        port: card.find(`input[name="slave_${index}_port"]`).val()
                    },
                    success: function(response) {
                        if (response.success) {
                            resultSpan.html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                            
                            // Show server info
                            if (response.server_info) {
                                let infoHtml = '<div class="mt-2 small">';
                                infoHtml += `<div>MySQL Version: ${response.server_info.version}</div>`;
                                infoHtml += `<div>Server ID: ${response.server_info.server_id}</div>`;
                                infoHtml += `<div>Binary Logging: ${response.server_info.binary_logging ? '<span class="text-success">Enabled</span>' : '<span class="text-warning">Disabled</span>'}</div>`;
                                infoHtml += '</div>';
                                
                                resultSpan.append(infoHtml);
                                
                                // Set server ID if not already set
                                const serverIdInput = card.find(`input[name="slave_${index}_server_id"]`);
                                if (!serverIdInput.val() && response.server_info.server_id) {
                                    serverIdInput.val(response.server_info.server_id);
                                }
                            }
                        } else {
                            resultSpan.html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        resultSpan.html('<span class="text-danger"><i class="fas fa-times-circle"></i> Error: ' + error + '</span>');
                    }
                });
            });
        }
        
        // Test master connection button
        $('#testMasterConnection').on('click', function() {
            const resultSpan = $('#masterConnectionResult');
            
            resultSpan.html('<i class="fas fa-spinner fa-spin"></i> Testing connection...');
            
            $.ajax({
                url: '/admin/replication/test-connection',
                type: 'POST',
                data: {
                    hostname: $('#master_hostname').val(),
                    username: $('#master_username').val(),
                    password: $('#master_password').val(),
                    database: $('#master_database').val(),
                    port: $('#master_port').val()
                },
                success: function(response) {
                    if (response.success) {
                        resultSpan.html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                        
                        // Show server info
                        if (response.server_info) {
                            let infoHtml = '<div class="mt-2 small">';
                            infoHtml += `<div>MySQL Version: ${response.server_info.version}</div>`;
                            infoHtml += `<div>Server ID: ${response.server_info.server_id}</div>`;
                            infoHtml += `<div>Binary Logging: ${response.server_info.binary_logging ? '<span class="text-success">Enabled</span>' : '<span class="text-warning">Disabled</span>'}</div>`;
                            infoHtml += '</div>';
                            
                            resultSpan.append(infoHtml);
                            
                            // Set server ID if not already set
                            if (!$('#master_server_id').val() && response.server_info.server_id) {
                                $('#master_server_id').val(response.server_info.server_id);
                            }
                        }
                    } else {
                        resultSpan.html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</span>');
                    }
                },
                error: function(xhr, status, error) {
                    resultSpan.html('<span class="text-danger"><i class="fas fa-times-circle"></i> Error: ' + error + '</span>');
                }
            });
        });
        
        // Mode change handler
        $('#mode').on('change', function() {
            const mode = $(this).val();
            if (mode === 'master-master') {
                $('#slaveServersContainer').hide();
                $('#addSlaveBtn').hide();
            } else {
                $('#slaveServersContainer').show();
                $('#addSlaveBtn').show();
            }
        });
        
        // Initialize event handlers
        bindSlaveEvents();
        
        // Trigger mode change handler on load
        $('#mode').trigger('change');
    });
</script>
<?php $this->endSection(); ?>
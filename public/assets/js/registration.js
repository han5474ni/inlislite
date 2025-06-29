document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('input[placeholder="Cari berdasarkan nama perpustakaan atau provinsi..."]');
    const tableBody = document.getElementById('registrationTableBody');
    const sortableHeaders = document.querySelectorAll('.table .sortable');
    const registrationForm = document.getElementById('registrationForm');
    const saveRegistrationBtn = document.getElementById('saveRegistration');
    const registrationModal = new bootstrap.Modal(document.getElementById('registrationModal'));
    
    // Edit modal elements
    const editRegistrationForm = document.getElementById('editRegistrationForm');
    const updateRegistrationBtn = document.getElementById('updateRegistration');
    const editRegistrationModal = new bootstrap.Modal(document.getElementById('editRegistrationModal'));
    
    let tableRows = Array.from(tableBody.querySelectorAll('tr[data-id]'));

    // --- Live Search ---
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const searchTerm = this.value.toLowerCase();
            tableRows.forEach(row => {
                const libraryName = row.cells[0].textContent.toLowerCase();
                const province = row.cells[1].textContent.toLowerCase();
                if (libraryName.includes(searchTerm) || province.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // --- Sorting ---
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const sortColumn = this.dataset.sort;
            const currentOrder = this.dataset.order || 'desc';
            const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
            this.dataset.order = newOrder;

            sortableHeaders.forEach(h => {
                h.classList.remove('asc', 'desc');
                h.querySelector('i').className = 'fa-solid fa-sort';
            });

            this.classList.add(newOrder);
            this.querySelector('i').className = newOrder === 'asc' ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down';

            sortTable(sortColumn, newOrder);
        });
    });

    function sortTable(column, order) {
        const isDate = column === 'date';
        tableRows.sort((a, b) => {
            const valA = a.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
            const valB = b.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();

            if (isDate) {
                return order === 'asc' ? new Date(valA) - new Date(valB) : new Date(valB) - new Date(valA);
            }
            return order === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });
        tableRows.forEach(row => tableBody.appendChild(row));
    }

    function getColumnIndex(columnName) {
        let index = 0;
        document.querySelectorAll('thead th').forEach((th, i) => {
            if (th.dataset.sort === columnName) {
                index = i + 1;
            }
        });
        return index;
    }

    // --- Download Data ---
    const downloadCSVBtn = document.getElementById('downloadCSV');
    const downloadExcelBtn = document.getElementById('downloadExcel');
    
    if(downloadCSVBtn) {
        downloadCSVBtn.addEventListener('click', function(e) {
            e.preventDefault();
            downloadRegistrationData('csv');
        });
    }
    
    if(downloadExcelBtn) {
        downloadExcelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            downloadRegistrationData('excel');
        });
    }

    // --- Registration Statistics Chart ---
    let registrationChart;
    const ctx = document.getElementById('registrationChart');
    const yearSelector = document.getElementById('yearSelector');

    function initChart() {
        if (ctx) {
            registrationChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Total Registrasi',
                            data: [],
                            backgroundColor: '#4472C4',
                            borderColor: '#4472C4',
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false
                        },
                        {
                            label: 'Terverifikasi',
                            data: [],
                            backgroundColor: '#E07C24',
                            borderColor: '#E07C24',
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false
                        },
                        {
                            label: 'Menunggu Verifikasi',
                            data: [],
                            backgroundColor: '#A5A5A5',
                            borderColor: '#A5A5A5',
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: 'normal'
                                },
                                color: '#666'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#E5E5E5',
                                lineWidth: 1
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 12
                                },
                                color: '#666'
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'rect',
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: 'normal'
                                },
                                color: '#333'
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#ccc',
                            borderWidth: 1,
                            cornerRadius: 6,
                            displayColors: true
                        }
                    },
                    layout: {
                        padding: {
                            top: 20,
                            bottom: 10,
                            left: 10,
                            right: 10
                        }
                    },
                    elements: {
                        bar: {
                            borderWidth: 0
                        }
                    }
                }
            });
            
            loadChartData(yearSelector.value);
        }
    }

    function loadChartData(year) {
        console.log('Loading chart data for year:', year);
        fetch(`registration-stats?year=${year}`)
            .then(response => response.json())
            .then(data => {
                console.log('Chart data received:', data);
                const totalData = data.map(item => item.total);
                const verifiedData = data.map(item => item.verified);
                const pendingData = data.map(item => item.pending);

                console.log('Total data:', totalData);
                console.log('Verified data:', verifiedData);
                console.log('Pending data:', pendingData);

                registrationChart.data.datasets[0].data = totalData;
                registrationChart.data.datasets[1].data = verifiedData;
                registrationChart.data.datasets[2].data = pendingData;
                registrationChart.update();
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
            });
    }

    if (yearSelector) {
        yearSelector.addEventListener('change', function() {
            loadChartData(this.value);
        });
    }

    // Load available years first, then initialize chart
    loadAvailableYears();
    
    // Handle responsive chart resize
    window.addEventListener('resize', debounce(function() {
        if (registrationChart) {
            registrationChart.resize();
        }
    }, 250));

    // --- Registration Form Handling ---
    if (saveRegistrationBtn) {
        saveRegistrationBtn.addEventListener('click', function() {
            const formData = new FormData(registrationForm);
            
            // Validate required fields
            const requiredFields = ['library_name', 'province', 'city', 'email'];
            let isValid = true;
            
            requiredFields.forEach(field => {
                const input = document.getElementById(field === 'library_name' ? 'libraryName' : field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return;
            }
            
            // Disable button during submission
            saveRegistrationBtn.disabled = true;
            saveRegistrationBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            
            fetch('registration/add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    registrationModal.hide();
                    registrationForm.reset();
                    // Refresh page to show new data
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            })
            .finally(() => {
                saveRegistrationBtn.disabled = false;
                saveRegistrationBtn.innerHTML = 'Simpan';
            });
        });
    }

    // --- Edit Registration Form Handling ---
    if (updateRegistrationBtn) {
        updateRegistrationBtn.addEventListener('click', function() {
            const formData = new FormData(editRegistrationForm);
            
            // Validate required fields
            const requiredFields = [
                { field: 'library_name', id: 'editLibraryName' },
                { field: 'province', id: 'editProvince' },
                { field: 'city', id: 'editCity' },
                { field: 'email', id: 'editEmail' },
                { field: 'status', id: 'editStatus' }
            ];
            let isValid = true;
            
            requiredFields.forEach(item => {
                const input = document.getElementById(item.id);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return;
            }
            
            // Disable button during submission
            updateRegistrationBtn.disabled = true;
            updateRegistrationBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            
            const id = document.getElementById('editRegistrationId').value;
            
            fetch(`registration/update/${id}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    editRegistrationModal.hide();
                    editRegistrationForm.reset();
                    // Refresh page to show updated data
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengupdate data');
            })
            .finally(() => {
                updateRegistrationBtn.disabled = false;
                updateRegistrationBtn.innerHTML = 'Simpan Perubahan';
            });
        });
    }

    // --- Status Dropdown Handling ---
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('status-dropdown')) {
            const dropdown = e.target;
            const id = dropdown.dataset.id;
            const newStatus = dropdown.value;
            const oldStatus = dropdown.dataset.oldValue || dropdown.querySelector('option[selected]')?.value;
            
            // Store old value for potential rollback
            dropdown.dataset.oldValue = oldStatus;
            
            updateStatus(id, newStatus, dropdown);
        }
    });

    // --- Action Button Handling ---
    document.addEventListener('click', function(e) {
        // Edit button
        if (e.target.classList.contains('edit-btn') || e.target.closest('.edit-btn')) {
            e.preventDefault();
            const btn = e.target.classList.contains('edit-btn') ? e.target : e.target.closest('.edit-btn');
            const id = btn.dataset.id;
            loadRegistrationForEdit(id);
        }
        
        // Delete button
        if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
            e.preventDefault();
            const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
            const id = btn.dataset.id;
            
            if (confirm('Apakah Anda yakin ingin menghapus registrasi ini?')) {
                deleteRegistration(id);
            }
        }
    });

    function updateStatus(id, status, dropdown = null) {
        // Disable dropdown during update
        if (dropdown) {
            dropdown.disabled = true;
        }
        
        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);
        
        fetch('registration/update-status', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update statistics and chart without full page reload
                refreshStatistics();
                loadChartData(yearSelector.value);
                
                // Show success message briefly
                showToast('Status berhasil diupdate!', 'success');
            } else {
                // Rollback dropdown value on error
                if (dropdown && dropdown.dataset.oldValue) {
                    dropdown.value = dropdown.dataset.oldValue;
                }
                showToast('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Rollback dropdown value on error
            if (dropdown && dropdown.dataset.oldValue) {
                dropdown.value = dropdown.dataset.oldValue;
            }
            showToast('Terjadi kesalahan saat mengupdate status', 'error');
        })
        .finally(() => {
            // Re-enable dropdown
            if (dropdown) {
                dropdown.disabled = false;
            }
        });
    }

    function deleteRegistration(id) {
        fetch(`registration/delete/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus data');
        });
    }

    // --- Auto-refresh functions ---
    function refreshStatistics() {
        fetch('registration-data')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update statistics cards
                    updateStatisticsCards(data.stats);
                }
            })
            .catch(error => {
                console.error('Error refreshing statistics:', error);
            });
    }

    function updateStatisticsCards(stats) {
        const totalElement = document.querySelector('.stat-card:nth-child(1) .card-text');
        const verifiedElement = document.querySelector('.stat-card:nth-child(2) .card-text');
        const pendingElement = document.querySelector('.stat-card:nth-child(3) .card-text');

        if (totalElement) totalElement.textContent = (stats.total || 0).toLocaleString();
        if (verifiedElement) verifiedElement.textContent = (stats.verified || 0).toLocaleString();
        if (pendingElement) pendingElement.textContent = (stats.pending || 0).toLocaleString();
    }

    // --- Toast notification function ---
    function showToast(message, type = 'info') {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '1055';
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        
        const toastHTML = `
            <div class="toast ${bgClass} text-white" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <strong>${message}</strong>
                    <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        // Initialize and show toast
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        toast.show();
        
        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', function() {
            toastElement.remove();
        });
    }

    // --- Periodic refresh ---
    function startAutoRefresh() {
        const indicator = document.getElementById('autoRefreshIndicator');
        
        // Show indicator briefly when page loads
        if (indicator) {
            indicator.classList.add('active');
            setTimeout(() => indicator.classList.remove('active'), 3000);
        }
        
        setInterval(() => {
            // Show refresh indicator
            if (indicator) {
                indicator.classList.add('active');
                indicator.innerHTML = '<i class="fa-solid fa-sync-alt fa-spin me-1"></i>Memperbarui...';
            }
            
            refreshStatistics();
            loadChartData(yearSelector.value);
            // Also refresh year dropdown in case new years were added
            updateYearDropdown();
            
            // Hide indicator after refresh
            setTimeout(() => {
                if (indicator) {
                    indicator.innerHTML = '<i class="fa-solid fa-sync-alt me-1"></i>Auto-refresh aktif';
                    indicator.classList.remove('active');
                }
            }, 2000);
        }, 30000); // Refresh every 30 seconds
    }

    // --- Update table rows after any changes ---
    function updateTableRows() {
        tableRows = Array.from(tableBody.querySelectorAll('tr[data-id]'));
    }

    // --- Load Registration for Edit ---
    function loadRegistrationForEdit(id) {
        fetch(`registration/get/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.registration) {
                    const registration = data.registration;
                    
                    // Populate edit form
                    document.getElementById('editRegistrationId').value = registration.id;
                    document.getElementById('editLibraryName').value = registration.library_name || '';
                    document.getElementById('editProvince').value = registration.province || '';
                    document.getElementById('editCity').value = registration.city || '';
                    document.getElementById('editEmail').value = registration.email || '';
                    document.getElementById('editPhone').value = registration.phone || '';
                    document.getElementById('editStatus').value = registration.status || 'pending';
                    
                    // Clear any previous validation errors
                    editRegistrationForm.querySelectorAll('.is-invalid').forEach(input => {
                        input.classList.remove('is-invalid');
                    });
                    
                    // Show modal
                    editRegistrationModal.show();
                } else {
                    alert('Error: Tidak dapat memuat data registrasi');
                }
            })
            .catch(error => {
                console.error('Error loading registration:', error);
                alert('Terjadi kesalahan saat memuat data registrasi');
            });
    }

    // --- Load Available Years ---
    function loadAvailableYears() {
        fetch('registration-years')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.years.length > 0) {
                    populateYearDropdown(data.years, true);
                    // Initialize chart after years are loaded
                    initChart();
                } else {
                    // Fallback to current year if no data
                    const currentYear = new Date().getFullYear();
                    populateYearDropdown([currentYear], true);
                    initChart();
                }
            })
            .catch(error => {
                console.error('Error loading available years:', error);
                // Fallback to current year
                const currentYear = new Date().getFullYear();
                populateYearDropdown([currentYear], true);
                initChart();
            });
    }

    function updateYearDropdown() {
        const currentValue = yearSelector.value;
        fetch('registration-years')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.years.length > 0) {
                    populateYearDropdown(data.years, false, currentValue);
                }
            })
            .catch(error => {
                console.error('Error updating year dropdown:', error);
            });
    }

    function populateYearDropdown(years, selectCurrent = false, preserveValue = null) {
        const currentYear = new Date().getFullYear();
        const currentValue = preserveValue || (selectCurrent ? currentYear : yearSelector.value);
        
        console.log('Populating dropdown - Current year:', currentYear, 'Years:', years, 'Select current:', selectCurrent);
        
        yearSelector.innerHTML = '';
        years.forEach(year => {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            
            // Prefer the most recent year that has data, or current year if no data
            if (selectCurrent) {
                // If current year exists in data, select it; otherwise select the first (most recent) year
                if (years.includes(currentYear)) {
                    option.selected = (year == currentYear);
                } else {
                    option.selected = (year == years[0]); // Select first year (most recent)
                }
            } else {
                option.selected = (year == currentValue);
            }
            yearSelector.appendChild(option);
        });
        
        console.log('Selected year in dropdown:', yearSelector.value);
    }

    // --- Debug Button ---
    const debugBtn = document.getElementById('debugBtn');
    if (debugBtn) {
        debugBtn.addEventListener('click', function() {
            console.log('=== DEBUG INFO ===');
            console.log('Current year selector value:', yearSelector.value);
            console.log('Current year from Date:', new Date().getFullYear());
            
            // Test debug endpoint
            fetch('debug-database')
                .then(response => response.json())
                .then(data => {
                    console.log('Debug database response:', data);
                    alert('Debug info logged to console. Check browser console (F12).');
                })
                .catch(error => {
                    console.error('Debug error:', error);
                });
        });
    }

    // --- Download Registration Data ---
    function downloadRegistrationData(format = 'csv') {
        const isCSV = format === 'csv';
        const button = isCSV ? downloadCSVBtn : downloadExcelBtn;
        const originalText = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses...';
        
        fetch('registration-data')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.registrations) {
                    if (isCSV) {
                        generateCSVDownload(data.registrations);
                    } else {
                        generateExcelDownload(data.registrations);
                    }
                } else {
                    alert('Gagal mengunduh data registrasi');
                }
            })
            .catch(error => {
                console.error('Error downloading data:', error);
                alert('Terjadi kesalahan saat mengunduh data');
            })
            .finally(() => {
                // Restore button state
                button.innerHTML = originalText;
            });
    }

    function generateCSVDownload(registrations) {
        // CSV headers
        const headers = [
            'ID',
            'Nama Perpustakaan',
            'Provinsi', 
            'Kota/Kabupaten',
            'Email',
            'Nomor Telepon',
            'Status',
            'Tanggal Registrasi',
            'Tanggal Verifikasi'
        ];
        
        // Convert data to CSV format
        let csvContent = headers.join(',') + '\n';
        
        registrations.forEach(registration => {
            const row = [
                registration.id || '',
                `"${(registration.library_name || '').replace(/"/g, '""')}"`,
                `"${(registration.province || '').replace(/"/g, '""')}"`,
                `"${(registration.city || '').replace(/"/g, '""')}"`,
                `"${(registration.email || '').replace(/"/g, '""')}"`,
                `"${(registration.phone || '').replace(/"/g, '""')}"`,
                getStatusText(registration.status),
                formatDateTime(registration.created_at),
                registration.verified_at ? formatDateTime(registration.verified_at) : ''
            ];
            csvContent += row.join(',') + '\n';
        });
        
        // Create and trigger download
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `registrasi_data_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showToast('Data berhasil diunduh!', 'success');
        } else {
            alert('Browser Anda tidak mendukung fitur download otomatis');
        }
    }

    function generateExcelDownload(registrations) {
        // Create Excel-compatible HTML table
        const headers = [
            'ID',
            'Nama Perpustakaan',
            'Provinsi', 
            'Kota/Kabupaten',
            'Email',
            'Nomor Telepon',
            'Status',
            'Tanggal Registrasi',
            'Tanggal Verifikasi'
        ];
        
        let excelContent = `
            <table border="1">
                <thead>
                    <tr>
                        ${headers.map(header => `<th>${header}</th>`).join('')}
                    </tr>
                </thead>
                <tbody>
        `;
        
        registrations.forEach(registration => {
            excelContent += `
                <tr>
                    <td>${registration.id || ''}</td>
                    <td>${escapeHtml(registration.library_name || '')}</td>
                    <td>${escapeHtml(registration.province || '')}</td>
                    <td>${escapeHtml(registration.city || '')}</td>
                    <td>${escapeHtml(registration.email || '')}</td>
                    <td>${escapeHtml(registration.phone || '')}</td>
                    <td>${getStatusText(registration.status)}</td>
                    <td>${formatDateTime(registration.created_at)}</td>
                    <td>${registration.verified_at ? formatDateTime(registration.verified_at) : ''}</td>
                </tr>
            `;
        });
        
        excelContent += `
                </tbody>
            </table>
        `;
        
        // Create and trigger download
        const blob = new Blob([excelContent], { 
            type: 'application/vnd.ms-excel;charset=utf-8;' 
        });
        const link = document.createElement('a');
        
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `registrasi_data_${new Date().toISOString().split('T')[0]}.xls`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showToast('Data Excel berhasil diunduh!', 'success');
        } else {
            alert('Browser Anda tidak mendukung fitur download otomatis');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function getStatusText(status) {
        switch(status) {
            case 'verified': return 'Terverifikasi';
            case 'pending': return 'Menunggu Verifikasi';
            case 'rejected': return 'Ditolak';
            default: return status || '';
        }
    }

    function formatDateTime(dateString) {
        if (!dateString) return '';
        try {
            const date = new Date(dateString);
            return date.toLocaleString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        } catch (error) {
            return dateString;
        }
    }

    // --- Utility Functions ---
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Detect mobile device
    function isMobile() {
        return window.innerWidth < 768;
    }

    // Handle mobile-specific UI adjustments
    function adjustForMobile() {
        if (isMobile()) {
            // Mobile-specific adjustments
            const pageHeader = document.querySelector('.page-header-um');
            if (pageHeader) {
                pageHeader.style.flexDirection = 'column';
                pageHeader.style.alignItems = 'flex-start';
            }
            
            // Adjust table for mobile
            const tableContainer = document.querySelector('.table-responsive');
            if (tableContainer) {
                tableContainer.style.fontSize = '0.875rem';
            }
            
            // Adjust modal for mobile
            const modal = document.querySelector('.modal-dialog');
            if (modal) {
                modal.style.margin = '1rem 0.5rem';
            }
        }
    }

    // Handle screen orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            adjustForMobile();
            if (registrationChart) {
                registrationChart.resize();
            }
        }, 100);
    });

    // Initial mobile adjustment
    adjustForMobile();

    // Setup auto dropup functionality
    setupAutoDropup();

    // --- Auto Dropup Functionality ---
    function setupAutoDropup() {
        // Function to check and adjust dropdown position
        function adjustDropdownPosition(dropdownElement) {
            const dropdown = dropdownElement.closest('.dropdown');
            if (!dropdown) return;
            
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            if (!dropdownMenu) return;
            
            // Get dropdown button position
            const buttonRect = dropdownElement.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const viewportWidth = window.innerWidth;
            
            // Calculate actual dropdown dimensions if possible
            let dropdownHeight = 200; // Default fallback
            let dropdownWidth = 180; // Default fallback
            
            // Try to get actual dimensions
            if (dropdownMenu.offsetHeight > 0) {
                dropdownHeight = dropdownMenu.offsetHeight;
            }
            if (dropdownMenu.offsetWidth > 0) {
                dropdownWidth = dropdownMenu.offsetWidth;
            }
            
            const buffer = 20; // Safety buffer
            
            // Calculate space below and above
            const spaceBelow = viewportHeight - buttonRect.bottom;
            const spaceAbove = buttonRect.top;
            const spaceRight = viewportWidth - buttonRect.right;
            const spaceLeft = buttonRect.left;
            
            // Store original classes
            const wasDropup = dropdown.classList.contains('dropup');
            const wasDropdownEnd = dropdownMenu.classList.contains('dropdown-menu-end');
            
            // Remove existing positioning classes
            dropdown.classList.remove('dropup');
            dropdownMenu.classList.remove('dropdown-menu-end');
            
            // Always ensure dropdown class is present
            if (!dropdown.classList.contains('dropdown')) {
                dropdown.classList.add('dropdown');
            }
            
            // Determine vertical positioning
            const shouldUseDropup = spaceBelow < dropdownHeight + buffer && spaceAbove > spaceBelow;
            
            if (shouldUseDropup) {
                dropdown.classList.remove('dropdown');
                dropdown.classList.add('dropup');
                console.log('Switched to dropup - Space below:', spaceBelow, 'Space above:', spaceAbove);
            } else {
                console.log('Using dropdown - Space below:', spaceBelow, 'Space above:', spaceAbove);
            }
            
            // Determine horizontal positioning
            const shouldUseEnd = spaceRight < dropdownWidth + buffer && spaceLeft > spaceRight;
            
            if (shouldUseEnd) {
                dropdownMenu.classList.add('dropdown-menu-end');
                console.log('Using dropdown-menu-end - Space right:', spaceRight, 'Space left:', spaceLeft);
            }
            
            // Log changes for debugging
            const nowDropup = dropdown.classList.contains('dropup');
            const nowDropdownEnd = dropdownMenu.classList.contains('dropdown-menu-end');
            
            if (wasDropup !== nowDropup || wasDropdownEnd !== nowDropdownEnd) {
                console.log('Dropdown position changed:', {
                    element: dropdownElement,
                    wasDropup,
                    nowDropup,
                    wasDropdownEnd,
                    nowDropdownEnd,
                    buttonRect,
                    spaceBelow,
                    spaceAbove,
                    spaceRight,
                    spaceLeft
                });
            }
        }
        
        // Add event listeners to all dropdown buttons
        function attachDropdownListeners() {
            const dropdownButtons = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            
            dropdownButtons.forEach(button => {
                // Remove existing listeners to prevent duplicates
                button.removeEventListener('show.bs.dropdown', handleDropdownShow);
                button.removeEventListener('click', handleDropdownClick);
                
                // Add new listeners
                button.addEventListener('show.bs.dropdown', handleDropdownShow);
                button.addEventListener('click', handleDropdownClick);
            });
        }
        
        function handleDropdownShow(e) {
            adjustDropdownPosition(this);
        }
        
        function handleDropdownClick(e) {
            // Small delay to ensure Bootstrap has processed the click
            setTimeout(() => {
                adjustDropdownPosition(this);
            }, 10);
        }
        
        // Initial setup
        attachDropdownListeners();
        
        // Re-attach listeners when table content changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Check if new dropdown buttons were added
                    const hasNewDropdowns = Array.from(mutation.addedNodes).some(node => {
                        return node.nodeType === 1 && (
                            node.querySelector && node.querySelector('[data-bs-toggle="dropdown"]') ||
                            node.matches && node.matches('[data-bs-toggle="dropdown"]')
                        );
                    });
                    
                    if (hasNewDropdowns) {
                        attachDropdownListeners();
                    }
                }
            });
        });
        
        // Observe table body for changes
        const tableBody = document.getElementById('registrationTableBody');
        if (tableBody) {
            observer.observe(tableBody, {
                childList: true,
                subtree: true
            });
        }
        
        // Re-check positions on window resize or scroll
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                openDropdowns.forEach(menu => {
                    const button = menu.previousElementSibling;
                    if (button && button.hasAttribute('data-bs-toggle')) {
                        adjustDropdownPosition(button);
                    }
                });
            }, 100);
        });
        
        // Also check on scroll
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                openDropdowns.forEach(menu => {
                    const button = menu.previousElementSibling;
                    if (button && button.hasAttribute('data-bs-toggle')) {
                        adjustDropdownPosition(button);
                    }
                });
            }, 50);
        });
    }

    // Start auto-refresh
    startAutoRefresh();
});
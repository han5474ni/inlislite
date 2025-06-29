document.addEventListener('DOMContentLoaded', function () {
    // --- CSRF Token Helper ---
    const csrf_token = document.querySelector('input[name="csrf_test_name"]').value;
    const base_url = window.location.origin;
    
    // --- Notification Helper ---
    function showNotification(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
        notification.innerHTML = `
            <i class="fa-solid ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
    
    // --- Responsive Table Helper ---
    function makeTableResponsive() {
        const table = document.querySelector('.table-responsive .table');
        if (!table) return;
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        table.querySelectorAll('tbody tr:not(#no-data-row)').forEach(row => {
            row.querySelectorAll('td').forEach((cell, index) => {
                cell.setAttribute('data-label', headers[index]);
            });
        });
    }
    
    // --- Table Row Builder ---
    function buildUserRow(user) {
        const initial = user.nama_lengkap.charAt(0).toUpperCase();
        const roleColors = {
            'Super Admin': 'primary',
            'Admin': 'info',
            'Pustakawan': 'success',
            'Staff': 'secondary'
        };
        const statusColors = {
            'Aktif': 'primary',
            'Non-Aktif': 'secondary',
            'Ditangguhkan': 'warning'
        };
        
        const roleColor = roleColors[user.role] || 'secondary';
        const statusColor = statusColors[user.status] || 'secondary';
        const createdTimestamp = user.created_at ? new Date(user.created_at).getTime() / 1000 : 0;
        const lastLoginTimestamp = user.last_login ? new Date(user.last_login).getTime() / 1000 : 0;
        
        return `
            <tr data-id="${user.id}"
                data-name="${user.nama_lengkap}"
                data-username="${user.nama_pengguna}"
                data-email="${user.email}"
                data-role="${user.role}"
                data-status="${user.status}"
                data-last-login="${user.last_login || ''}"
                data-created="${user.created_at || ''}"
                data-created-timestamp="${createdTimestamp}"
                data-last-login-timestamp="${lastLoginTimestamp}">
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-${initial.toLowerCase()}">${initial}</div>
                        <div class="ms-3 user-info">
                            <div class="user-name">${user.nama_lengkap}</div>
                            <div class="user-email">${user.email}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-role-${roleColor}">${user.role}</span></td>
                <td><span class="badge rounded-pill badge-status-${statusColor}">${user.status}</span></td>
                <td class="date-column">
                    ${user.last_login ? `
                        <div class="date-primary" 
                             data-bs-toggle="tooltip" 
                             data-bs-placement="top" 
                             title="${new Date(user.last_login).toLocaleString('id-ID')} WIB">
                            ${new Date(user.last_login).toLocaleDateString('id-ID')}
                        </div>
                        <small class="date-time">${new Date(user.last_login).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})} WIB</small>
                    ` : `
                        <span class="never-login" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="top" 
                              title="User ini belum pernah melakukan login">
                            Belum pernah masuk
                        </span>
                    `}
                </td>
                <td class="date-column">
                    <div class="fw-bold" 
                         data-bs-toggle="tooltip" 
                         data-bs-placement="top" 
                         title="Dibuat pada ${new Date(user.created_at).toLocaleString('id-ID')} WIB">
                        ${new Date(user.created_at).toLocaleDateString('id-ID')}
                    </div>
                    <small class="date-time">${new Date(user.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})} WIB</small>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="true" id="dropdownMenuButton${user.id}" aria-haspopup="true">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-start shadow" aria-labelledby="dropdownMenuButton${user.id}">
                            <div class="dropdown-header">Aksi</div>
                            <a class="dropdown-item edit-user-btn" href="#" data-bs-toggle="modal" data-bs-target="#userModal">
                                <i class="fa-solid fa-pencil me-2"></i>Edit User
                            </a>
                            <a class="dropdown-item text-danger delete-user-btn" href="#" data-user-id="${user.id}">
                                <i class="fa-solid fa-trash me-2"></i>Hapus
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        `;
    }

    // --- Modal Edit Logic ---
    const userModal = document.getElementById('userModal');
    if (userModal) {
        const modalTitle = userModal.querySelector('.modal-title');
        const modalSubTitle = userModal.querySelector('.modal-subtitle');
        const submitButton = userModal.querySelector('.modal-footer .btn-success');
        const form = userModal.querySelector('form');
        const passwordInput = form.querySelector('#kata_sandi');
        const userIdInput = form.querySelector('#userId');

        const resetModal = () => {
            modalTitle.textContent = 'Tambahkan pengguna baru';
            modalSubTitle.textContent = 'Buat akun pengguna baru dan tetapkan izin akses.';
            submitButton.textContent = 'Tambahkan User';
            form.reset();
            passwordInput.disabled = false;
            passwordInput.required = true;
            userIdInput.value = '';
            form.action = window.location.origin + '/usermanagement/addUser';
        };

        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const row = event.target.closest('tr');
                const userData = row.dataset;
                modalTitle.textContent = 'Edit User';
                modalSubTitle.textContent = 'Perbarui informasi pengguna dan hak aksesnya.';
                submitButton.textContent = 'Update User';
                form.action = window.location.origin + '/usermanagement/editUser/' + userData.id;
                userIdInput.value = userData.id;
                form.querySelector('#nama_lengkap').value = userData.name;
                form.querySelector('#nama_pengguna').value = userData.username;
                form.querySelector('#email').value = userData.email;
                form.querySelector('#role').value = userData.role;
                form.querySelector('#status').value = userData.status;
                passwordInput.value = '';
                passwordInput.disabled = true;
                passwordInput.required = false;
                var modal = bootstrap.Modal.getInstance(userModal);
                modal.show();
            });
        });

        // Submit button handler - AJAX
        submitButton.addEventListener('click', function(event) {
            event.preventDefault();
            submitUserForm();
        });

        document.querySelector('button[data-bs-target="#userModal"]').addEventListener('click', resetModal);
        userModal.addEventListener('hidden.bs.modal', resetModal);
    }
    
    // --- AJAX Form Handler ---
    function submitUserForm() {
        const form = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitUserBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnSpinner = submitBtn.querySelector('.btn-spinner');
        const formErrors = document.getElementById('form-errors');
        const formSuccess = document.getElementById('form-success');
        const userId = document.getElementById('userId').value;
        
        // Clear previous messages
        formErrors.classList.add('d-none');
        formSuccess.classList.add('d-none');
        
        // Show loading state
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        submitBtn.disabled = true;
        
        const formData = new FormData(form);
        const isEdit = userId && userId !== '';
        const url = isEdit ? `${base_url}/usermanagement/editUserAjax/${userId}` : `${base_url}/usermanagement/addUserAjax`;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                
                if (isEdit) {
                    // Update existing row
                    updateUserRow(data.data);
                } else {
                    // Add new row
                    addUserRow(data.data);
                }
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(userModal);
                modal.hide();
                
                // Refresh filters
                applyFiltersAndSort();
            } else {
                if (data.errors) {
                    let errorHtml = '<strong>Terjadi kesalahan:</strong><ul class="mb-0 mt-2">';
                    for (const [field, error] of Object.entries(data.errors)) {
                        errorHtml += `<li>${error}</li>`;
                    }
                    errorHtml += '</ul>';
                    formErrors.innerHTML = errorHtml;
                    formErrors.classList.remove('d-none');
                } else {
                    showNotification(data.message || 'Terjadi kesalahan', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat menyimpan data', 'error');
        })
        .finally(() => {
            // Reset button state
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
            submitBtn.disabled = false;
        });
    }
    
    // --- Update User Row ---
    function updateUserRow(userData) {
        const existingRow = document.querySelector(`tr[data-id="${userData.id}"]`);
        if (existingRow) {
            const newRowHtml = buildUserRow(userData);
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newRowHtml;
            const newRow = tempDiv.firstElementChild;
            
            existingRow.parentNode.replaceChild(newRow, existingRow);
            attachRowEventListeners(newRow);
        }
    }
    
    // --- Add User Row ---
    function addUserRow(userData) {
        const tableBody = document.querySelector('.table tbody');
        const noDataRow = document.getElementById('no-data-row');
        
        const newRowHtml = buildUserRow(userData);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newRowHtml;
        const newRow = tempDiv.firstElementChild;
        
        // Insert before no-data row
        tableBody.insertBefore(newRow, noDataRow);
        attachRowEventListeners(newRow);
        
        // Update table rows array
        tableRows.push(newRow);
    }
    
    // --- Attach Event Listeners to Row ---
    function attachRowEventListeners(row) {
        // Edit button
        const editBtn = row.querySelector('.edit-user-btn');
        if (editBtn) {
            editBtn.addEventListener('click', function(event) {
                event.preventDefault();
                const userData = row.dataset;
                
                const modalTitle = userModal.querySelector('.modal-title');
                const modalSubTitle = userModal.querySelector('.modal-subtitle');
                const submitButton = userModal.querySelector('.modal-footer .btn-success .btn-text');
                const form = userModal.querySelector('form');
                const passwordInput = form.querySelector('#kata_sandi');
                const userIdInput = form.querySelector('#userId');
                
                modalTitle.textContent = 'Edit User';
                modalSubTitle.textContent = 'Perbarui informasi pengguna dan hak aksesnya.';
                submitButton.textContent = 'Update User';
                userIdInput.value = userData.id;
                form.querySelector('#nama_lengkap').value = userData.name;
                form.querySelector('#nama_pengguna').value = userData.username;
                form.querySelector('#email').value = userData.email;
                form.querySelector('#role').value = userData.role;
                form.querySelector('#status').value = userData.status;
                passwordInput.value = '';
                passwordInput.disabled = true;
                passwordInput.required = false;
                
                const modal = new bootstrap.Modal(userModal);
                modal.show();
            });
        }
        
        // Delete button
        const deleteBtn = row.querySelector('.delete-user-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(event) {
                event.preventDefault();
                const userId = this.getAttribute('data-user-id');
                deleteUser(userId);
            });
        }
    }

    // --- Delete User Logic with AJAX ---
    function deleteUser(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            fetch(`${base_url}/usermanagement/deleteUserAjax/${userId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    csrf_test_name: csrf_token
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    
                    // Remove row from table
                    const row = document.querySelector(`tr[data-id="${userId}"]`);
                    if (row) {
                        row.remove();
                        // Update table rows array
                        const index = tableRows.indexOf(row);
                        if (index > -1) {
                            tableRows.splice(index, 1);
                        }
                    }
                    
                    // Refresh filters
                    applyFiltersAndSort();
                } else {
                    showNotification(data.message || 'Gagal menghapus pengguna', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menghapus pengguna', 'error');
            });
        }
    }
    
    // Attach event listeners to existing rows
    document.querySelectorAll('.table tbody tr:not(#no-data-row)').forEach(row => {
        attachRowEventListeners(row);
    });

    // --- Filtering and Sorting Logic ---
    const searchInput = document.querySelector('input[placeholder="Cari pengguna..."]');
    const roleFilter = document.querySelectorAll('.form-select')[0];
    const statusFilter = document.querySelectorAll('.form-select')[1];
    const lastLoginFilter = document.getElementById('lastLoginFilter');
    const tableBody = document.querySelector('.table tbody');
    const tableRows = Array.from(tableBody.querySelectorAll('tr:not(#no-data-row)'));
    const noDataRow = document.getElementById('no-data-row');
    const sortableHeaders = document.querySelectorAll('.table .sortable');

    function applyFiltersAndSort() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value;
        const selectedStatus = statusFilter.value;
        const selectedLastLogin = lastLoginFilter.value;
        let visibleRows = 0;

        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
        const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);

        tableRows.forEach(row => {
            const searchMatch = row.dataset.name.toLowerCase().includes(searchTerm) || 
                              row.dataset.email.toLowerCase().includes(searchTerm) || 
                              row.dataset.username.toLowerCase().includes(searchTerm);
            const roleMatch = selectedRole === 'Semua Role' || row.dataset.role === selectedRole;
            const statusMatch = selectedStatus === 'Semua Status' || row.dataset.status === selectedStatus;
            
            let lastLoginMatch = true;
            if (selectedLastLogin) {
                const lastLoginTimestamp = parseInt(row.dataset.lastLoginTimestamp);
                const lastLoginDate = lastLoginTimestamp ? new Date(lastLoginTimestamp * 1000) : null;
                
                switch(selectedLastLogin) {
                    case 'today':
                        lastLoginMatch = lastLoginDate && lastLoginDate >= today;
                        break;
                    case 'week':
                        lastLoginMatch = lastLoginDate && lastLoginDate >= weekAgo;
                        break;
                    case 'month':
                        lastLoginMatch = lastLoginDate && lastLoginDate >= monthAgo;
                        break;
                    case 'never':
                        lastLoginMatch = !lastLoginDate || lastLoginTimestamp === 0;
                        break;
                }
            }

            if (searchMatch && roleMatch && statusMatch && lastLoginMatch) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        noDataRow.style.display = visibleRows === 0 ? '' : 'none';
        
        // Update user count
        const userCountElement = document.querySelector('.card-title');
        if (userCountElement) {
            userCountElement.textContent = `User(${visibleRows})`;
        }
    }

    function sortTable(column, order) {
        tableRows.sort((a, b) => {
            let valA, valB;
            
            if (column === 'last_login') {
                valA = parseInt(a.dataset.lastLoginTimestamp) || 0;
                valB = parseInt(b.dataset.lastLoginTimestamp) || 0;
            } else if (column === 'created') {
                valA = parseInt(a.dataset.createdTimestamp) || 0;
                valB = parseInt(b.dataset.createdTimestamp) || 0;
            } else {
                valA = a.dataset[column] ? a.dataset[column].toLowerCase() : '';
                valB = b.dataset[column] ? b.dataset[column].toLowerCase() : '';
            }
            
            if (valA < valB) return order === 'asc' ? -1 : 1;
            if (valA > valB) return order === 'asc' ? 1 : -1;
            return 0;
        });
        tableRows.forEach(row => tableBody.appendChild(row));
    }

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

    [searchInput, roleFilter, statusFilter, lastLoginFilter].forEach(el => {
        if (el) el.addEventListener('input', applyFiltersAndSort);
        if (el && el.tagName === 'SELECT') el.addEventListener('change', applyFiltersAndSort);
    });

    makeTableResponsive();
    applyFiltersAndSort(); // Initial filter on load
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add loading state for refresh button
    const refreshBtn = document.querySelector('.btn-outline-secondary');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const originalClass = icon.className;
            icon.className = 'fa-solid fa-spinner fa-spin me-1';
            this.disabled = true;
            
            setTimeout(() => {
                icon.className = originalClass;
                this.disabled = false;
                location.reload();
            }, 1000);
        });
    }
    
    // Add export functionality 
    const exportBtn = document.querySelector('.btn-outline-primary');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const originalClass = icon.className;
            icon.className = 'fa-solid fa-spinner fa-spin me-1';
            
            setTimeout(() => {
                icon.className = originalClass;
                // Export logic here
                alert('Export functionality would be implemented here');
            }, 1500);
        });
    }
    
    // Add smooth animations for table rows
    function addRowAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 50);
                }
            });
        });
        
        tableRows.forEach(row => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            row.style.transition = 'all 0.3s ease';
            observer.observe(row);
        });
    }
    
    addRowAnimations();
    
    // Fix dropdown visibility issues
    document.addEventListener('click', function(e) {
        // Close other dropdowns when clicking outside
        const dropdowns = document.querySelectorAll('.dropdown-menu.show');
        dropdowns.forEach(dropdown => {
            if (!dropdown.closest('.dropdown').contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    });
    
    // Ensure dropdown toggle works properly
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdown = this.nextElementSibling;
            const isShown = dropdown.classList.contains('show');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
                menu.style.display = 'none';
            });
            
            // Toggle current dropdown
            if (!isShown) {
                dropdown.classList.add('show');
                
                // Position the dropdown below and to the right
                const buttonRect = this.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                const dropdownWidth = 180; // max-width from CSS
                
                // Check if there's enough space on the right
                const spaceOnRight = viewportWidth - buttonRect.right;
                
                if (spaceOnRight >= dropdownWidth) {
                    // Position to the right (normal)
                    dropdown.classList.remove('dropdown-menu-start');
                    dropdown.classList.add('dropdown-menu-end');
                } else {
                    // Position to the left if not enough space on right
                    dropdown.classList.remove('dropdown-menu-end');
                    dropdown.classList.add('dropdown-menu-start');
                }
                
                // Force display
                setTimeout(() => {
                    dropdown.style.display = 'block';
                    dropdown.style.opacity = '1';
                    dropdown.style.visibility = 'visible';
                }, 10);
            }
        });
    });
});

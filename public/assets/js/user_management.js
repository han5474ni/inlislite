document.addEventListener('DOMContentLoaded', function () {
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

    // --- Modal Edit Logic ---
    const userModal = document.getElementById('userModal');
    if (userModal) {
        const modalTitle = userModal.querySelector('.modal-title');
        const modalSubTitle = userModal.querySelector('.modal-subtitle');
        const submitButton = userModal.querySelector('.modal-footer .btn-success');
        const form = userModal.querySelector('form');
        const passwordInput = form.querySelector('#password');

        const resetModal = () => {
            modalTitle.textContent = 'Tambahkan pengguna baru';
            modalSubTitle.textContent = 'Buat akun pengguna baru dan tetapkan izin akses.';
            submitButton.textContent = 'Tambahkan User';
            form.reset();
            passwordInput.disabled = false;
            passwordInput.placeholder = '';
        };

        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', function (event) {
                const row = event.target.closest('tr');
                const userData = row.dataset;
                modalTitle.textContent = 'Edit User';
                modalSubTitle.textContent = 'Perbarui informasi pengguna dan hak aksesnya.';
                submitButton.textContent = 'Update User';
                form.querySelector('#fullName').value = userData.name;
                form.querySelector('#username').value = userData.username;
                form.querySelector('#email').value = userData.email;
                form.querySelector('#role').value = userData.role;
                form.querySelector('#status').value = userData.status;
                passwordInput.value = '';
                passwordInput.placeholder = '**********';
                passwordInput.disabled = true;
            });
        });
        document.querySelector('button[data-bs-target="#userModal"]').addEventListener('click', resetModal);
        userModal.addEventListener('hidden.bs.modal', resetModal);
    }

    // --- Filtering and Sorting Logic ---
    const searchInput = document.querySelector('input[placeholder="Cari pengguna..."]');
    const roleFilter = document.querySelectorAll('.form-select')[0];
    const statusFilter = document.querySelectorAll('.form-select')[1];
    const tableBody = document.querySelector('.table tbody');
    const tableRows = Array.from(tableBody.querySelectorAll('tr:not(#no-data-row)'));
    const noDataRow = document.getElementById('no-data-row');
    const sortableHeaders = document.querySelectorAll('.table .sortable');

    function applyFiltersAndSort() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value;
        const selectedStatus = statusFilter.value;
        let visibleRows = 0;

        tableRows.forEach(row => {
            const searchMatch = row.dataset.name.toLowerCase().includes(searchTerm) || row.dataset.email.toLowerCase().includes(searchTerm);
            const roleMatch = selectedRole === 'Semua Role' || row.dataset.role === selectedRole;
            const statusMatch = selectedStatus === 'Semua Status' || row.dataset.status === selectedStatus;

            if (searchMatch && roleMatch && statusMatch) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        noDataRow.style.display = visibleRows === 0 ? '' : 'none';
    }

    function sortTable(column, order) {
        const isDate = column === 'last_login' || column === 'created';
        tableRows.sort((a, b) => {
            const valA = isDate ? new Date(a.dataset[column]) : a.dataset[column].toLowerCase();
            const valB = isDate ? new Date(b.dataset[column]) : b.dataset[column].toLowerCase();
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

    [searchInput, roleFilter, statusFilter].forEach(el => {
        if (el) el.addEventListener('input', applyFiltersAndSort);
        if (el && el.tagName === 'SELECT') el.addEventListener('change', applyFiltersAndSort);
    });

    makeTableResponsive();
    applyFiltersAndSort(); // Initial filter on load
});
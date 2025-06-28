document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('input[placeholder="Cari berdasarkan nama perpustakaan atau provinsi..."]');
    const tableBody = document.querySelector('.table tbody');
    const tableRows = Array.from(tableBody.querySelectorAll('tr'));
    const sortableHeaders = document.querySelectorAll('.table .sortable');

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

    // --- Download Data (Placeholder) ---
    const downloadBtn = document.querySelector('.btn-outline-secondary');
    if(downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            alert('Fitur download data sedang dalam pengembangan.');
            // In a real application, this would trigger a file download.
            // For example, by creating a CSV from the table data.
        });
    }

    // --- Statistics Chart (Placeholder) ---
    // In a real application, you would use a library like Chart.js here.
    // Example:
    // const ctx = document.getElementById('registrationChart');
    // if (ctx) {
    //     new Chart(ctx, {
    //         type: 'bar',
    //         data: {
    //             labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    //             datasets: [{
    //                 label: '# of Registrations',
    //                 data: [120, 190, 300, 50, 200, 30],
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     });
    // }
});
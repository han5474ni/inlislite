(function() {
  if (!window.jQuery) return;
  const $ = window.jQuery;

  const $table = $('#usersTable');
  if (!$table.length) return;

  const colCount = $table.find('thead th').length;
  const lastHeaderText = $table.find('thead th').last().text().trim().toLowerCase();
  const hasAction = lastHeaderText === 'action' || lastHeaderText === 'aksi';
  const historyIdx = hasAction ? colCount - 2 : colCount - 1;

  // Center column index: first and last 2-3 columns (status, last login, history, action)
  const centerIdx = [0];
  for (let i = colCount - 1; i >= Math.max(colCount - 3, 1); i--) centerIdx.push(i);

  // Non-orderable columns: history and action
  const nonOrderable = [historyIdx];
  if (hasAction) nonOrderable.push(colCount - 1);

  $table.DataTable({
    dom: "<'dt-toolbar'lf>t<'dt-footer'ip>",
    paging: true,
    pageLength: 10,
    lengthChange: true,
    ordering: true,
    order: [[0, 'asc']],
    info: true,
    searching: true,
    autoWidth: true, // biarkan DataTables hitung lebar kolom
    scrollX: false,
    columns: $table.find('thead th').map(function(){
      const text = $(this).text().trim().toLowerCase();
      // Kolom teks panjang diberi shrink + ellipsis via CSS
      if (['nama lengkap','username','email'].includes(text)) {
        return { width: null }; // fleksibel menyesuaikan header
      }
      return { width: null };
    }).get(),
    columnDefs: [
      { targets: centerIdx, className: 'text-center' },
      { targets: nonOrderable, orderable: false }
    ],
    language: {
      lengthMenu: 'Tampilkan _MENU_ data',
      zeroRecords: 'Tidak ada data',
      info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
      infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
      infoFiltered: '(disaring dari _MAX_ total data)',
      search: 'Cari:'
    }
  });
})();
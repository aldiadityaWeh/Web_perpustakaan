document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    const tableContainer = document.getElementById('table-container');

    if (searchInput && searchForm && tableContainer) {
        let timeout = null;

        // Mendengarkan event saat user mengetik
        searchInput.addEventListener('keyup', function() {
            clearTimeout(timeout);

            // Memberikan efek visual sedikit redup saat sedang memuat data
            tableContainer.style.opacity = '0.5';
            tableContainer.style.transition = 'opacity 0.3s ease';

            // Menunggu 500ms setelah user berhenti mengetik (Debounce) agar tidak spam ke server
            timeout = setTimeout(() => {
                const url = new URL(searchForm.action);
                url.searchParams.set('search', this.value);

                // Melakukan request AJAX ke server
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Mengubah text HTML menjadi elemen DOM
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Mengambil hanya bagian tabel dari halaman baru dan menimpanya ke tabel lama
                    const newTableContent = doc.getElementById('table-container').innerHTML;
                    tableContainer.innerHTML = newTableContent;

                    // Mengembalikan tampilan tabel menjadi terang normal
                    tableContainer.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Terjadi kesalahan saat mencari data:', error);
                    tableContainer.style.opacity = '1';
                });
            }, 500);
        });

        // Mencegah halaman reload ketika menekan tombol "Enter" di keyboard
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }
});

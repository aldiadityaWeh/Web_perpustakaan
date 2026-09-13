document.addEventListener('DOMContentLoaded', function() {
    const kolomPencarian = document.getElementById('searchInputPeminjaman');
    const formPencarian = document.getElementById('searchFormPeminjaman');
    const wadahTabel = document.getElementById('table-container-peminjaman');
    const labelCari = document.getElementById('searchLabelPeminjaman');
    const ikonLoading = document.getElementById('loadingSpinnerPeminjaman');

    const urlDasar = formPencarian ? formPencarian.getAttribute('data-url') : '';
    let batasWaktu = null;

    if (formPencarian) {
        formPencarian.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    if (kolomPencarian && wadahTabel) {
        kolomPencarian.addEventListener('input', function() {
            clearTimeout(batasWaktu);

            wadahTabel.style.opacity = '0.5';
            if (labelCari) labelCari.classList.add('hidden');
            if (ikonLoading) ikonLoading.classList.remove('hidden');

            batasWaktu = setTimeout(() => {
                const kueri = this.value;

                // TAMBAHAN BARU: Ambil nilai filter yang sedang aktif
                const filterInput = document.getElementById('filterPeminjaman');
                const filterValue = filterInput ? filterInput.value : 'semua';

                // Sisipkan nilai filter ke dalam URL pencarian AJAX
                const urlTujuan = `${urlDasar}?search=${encodeURIComponent(kueri)}&filter=${encodeURIComponent(filterValue)}`;

                fetch(urlTujuan, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(respon => respon.text())
                .then(html => {
                    const parser = new DOMParser();
                    const dokumenBaru = parser.parseFromString(html, 'text/html');

                    const wadahTabelBaru = dokumenBaru.getElementById('table-container-peminjaman');
                    if (wadahTabelBaru) {
                        wadahTabel.innerHTML = wadahTabelBaru.innerHTML;
                    }

                    wadahTabel.style.opacity = '1';
                    if (labelCari) labelCari.classList.remove('hidden');
                    if (ikonLoading) ikonLoading.classList.add('hidden');

                    window.history.pushState(null, '', urlTujuan);
                })
                .catch(err => {
                    console.error('Terjadi kesalahan:', err);
                    wadahTabel.style.opacity = '1';
                    if (labelCari) labelCari.classList.remove('hidden');
                    if (ikonLoading) ikonLoading.classList.add('hidden');
                });
            }, 300);
        });
    }
});

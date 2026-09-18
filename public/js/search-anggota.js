document.addEventListener('DOMContentLoaded', function() {
    const kolomPencarian = document.getElementById('searchInput');
    const formPencarian = document.getElementById('searchForm');
    const wadahTabel = document.getElementById('table-container');
    const labelCari = document.getElementById('searchLabel');
    const ikonLoading = document.getElementById('loadingSpinner');

    // Mengambil URL tujuan dari atribut data-url pada form
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

            // Efek visual redup saat mulai mengetik
            wadahTabel.style.opacity = '0.5';
            if (labelCari) labelCari.classList.add('hidden');
            if (ikonLoading) ikonLoading.classList.remove('hidden');

            // Menunda request selama 300ms agar server tidak terbebani setiap ketukan
            batasWaktu = setTimeout(() => {
                const kueri = this.value;
                const urlTujuan = `${urlDasar}?search=${encodeURIComponent(kueri)}`;

                fetch(urlTujuan, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(respon => respon.text())
                .then(html => {
                    const parser = new DOMParser();
                    const dokumenBaru = parser.parseFromString(html, 'text/html');

                    const wadahTabelBaru = dokumenBaru.getElementById('table-container');
                    if (wadahTabelBaru) {
                        wadahTabel.innerHTML = wadahTabelBaru.innerHTML;
                    }

                    // Mengembalikan tampilan tombol ke normal
                    wadahTabel.style.opacity = '1';
                    if (labelCari) labelCari.classList.remove('hidden');
                    if (ikonLoading) ikonLoading.classList.add('hidden');

                    // Memperbarui URL di browser tanpa reload halaman
                    window.history.pushState(null, '', urlTujuan);
                })
                .catch(err => {
                    console.error('Terjadi kesalahan saat mencari data:', err);
                    wadahTabel.style.opacity = '1';
                    if (labelCari) labelCari.classList.remove('hidden');
                    if (ikonLoading) ikonLoading.classList.add('hidden');
                });
            }, 300);
        });
    }
});

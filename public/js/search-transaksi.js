document.addEventListener('DOMContentLoaded', function() {
    const wadahTabel = document.getElementById('table-container');
    let batasWaktu = null;

    if (!wadahTabel) return;

    // Gunakan Event Delegation agar listener tidak hilang meski DOM diperbarui
    wadahTabel.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'searchForm') {
            e.preventDefault();
        }
    });

    wadahTabel.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'searchInput') {
            const kolomPencarian = e.target;
            const formPencarian = kolomPencarian.closest('form');
            const urlDasar = formPencarian ? formPencarian.getAttribute('action') : window.location.pathname;

            clearTimeout(batasWaktu);

            // Beri efek loading hanya pada tbody agar input pencarian tidak ikut buram
            const tbodySaatIni = wadahTabel.querySelector('tbody');
            if (tbodySaatIni) tbodySaatIni.style.opacity = '0.4';

            batasWaktu = setTimeout(() => {
                const kueri = kolomPencarian.value;
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

                    // 1. Perbarui hanya isi tabel (tbody) agar kursor di #searchInput tidak terganggu
                    const tbodyBaru = dokumenBaru.querySelector('#table-container tbody');
                    if (tbodyBaru && tbodySaatIni) {
                        tbodySaatIni.innerHTML = tbodyBaru.innerHTML;
                        tbodySaatIni.style.opacity = '1';
                    }

                    // 2. Perbarui area pagination
                    const paginationSaatIni = document.getElementById('area-pagination');
                    const paginationBaru = dokumenBaru.getElementById('area-pagination');
                    if (paginationBaru && paginationSaatIni) {
                        paginationSaatIni.innerHTML = paginationBaru.innerHTML;
                    }

                    window.history.pushState(null, '', urlTujuan);
                })
                .catch(err => {
                    console.error('Terjadi kesalahan pencarian AJAX:', err);
                    if (tbodySaatIni) tbodySaatIni.style.opacity = '1';
                });
            }, 300);
        }
    });
});

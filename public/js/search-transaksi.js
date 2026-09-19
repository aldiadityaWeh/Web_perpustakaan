document.addEventListener('DOMContentLoaded', function() {
    const kolomPencarian = document.getElementById('searchInput');
    const formPencarian = kolomPencarian ? kolomPencarian.closest('form') : null;
    const wadahTabel = document.getElementById('table-container');

    // Otomatis membaca URL dari form action di Blade kas denda
    const urlDasar = formPencarian ? formPencarian.getAttribute('action') : window.location.pathname;
    let batasWaktu = null;

    if (formPencarian) {
        formPencarian.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    if (kolomPencarian && wadahTabel) {
        kolomPencarian.addEventListener('input', function() {
            clearTimeout(batasWaktu);

            // Efek buram saat memuat
            wadahTabel.style.opacity = '0.5';

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

                    // Kembalikan opacity ke normal
                    wadahTabel.style.opacity = '1';
                    window.history.pushState(null, '', urlTujuan);
                })
                .catch(err => {
                    console.error('Terjadi kesalahan pencarian AJAX:', err);
                    wadahTabel.style.opacity = '1';
                });
            }, 300);
        });
    }
});

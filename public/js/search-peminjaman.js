document.addEventListener('DOMContentLoaded', function() {
    // 1. Cari elemen berdasarkan ID yang benar di Blade
    const kolomPencarian = document.getElementById('searchInput');
    const formPencarian = kolomPencarian ? kolomPencarian.closest('form') : null;
    const wadahTabel = document.getElementById('table-container');

    // Ambil URL tujuan dari form action (misal: /admin/peminjaman)
    const urlDasar = formPencarian ? formPencarian.getAttribute('action') : window.location.pathname;
    let batasWaktu = null;

    // Cegah reload halaman saat tombol enter/cari ditekan
    if (formPencarian) {
        formPencarian.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    if (kolomPencarian && wadahTabel) {
        kolomPencarian.addEventListener('input', function() {
            clearTimeout(batasWaktu);

            // Beri efek buram saat sedang mencari
            wadahTabel.style.opacity = '0.5';

            // Jeda 300ms agar server tidak kelebihan beban saat mengetik cepat
            batasWaktu = setTimeout(() => {
                const kueri = this.value;
                const urlTujuan = `${urlDasar}?search=${encodeURIComponent(kueri)}`;

                // Jalankan AJAX ke Controller
                fetch(urlTujuan, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(respon => respon.text())
                .then(html => {
                    // Ubah teks HTML dari server menjadi elemen DOM
                    const parser = new DOMParser();
                    const dokumenBaru = parser.parseFromString(html, 'text/html');

                    // Ambil isi tabel baru dan gantikan ke tabel lama
                    const wadahTabelBaru = dokumenBaru.getElementById('table-container');
                    if (wadahTabelBaru) {
                        wadahTabel.innerHTML = wadahTabelBaru.innerHTML;
                    }

                    // Kembalikan efek buram
                    wadahTabel.style.opacity = '1';

                    // Ubah URL di browser tanpa reload (agar rapi)
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

document.addEventListener('DOMContentLoaded', function() {
    const kolomPencarianBuku = document.getElementById('searchInputBuku');
    const formPencarianBuku = document.getElementById('searchFormBuku');
    const wadahTabelBuku = document.getElementById('table-container-buku');
    const labelCariBuku = document.getElementById('searchLabelBuku');
    const ikonLoadingBuku = document.getElementById('loadingSpinnerBuku');

    // Mengambil URL tujuan dari atribut data-url pada form
    const urlDasarBuku = formPencarianBuku ? formPencarianBuku.getAttribute('data-url') : '';
    let batasWaktuBuku = null;

    if (formPencarianBuku) {
        formPencarianBuku.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }

    if (kolomPencarianBuku && wadahTabelBuku) {
        kolomPencarianBuku.addEventListener('input', function() {
            clearTimeout(batasWaktuBuku);

            // Efek visual redup saat mulai mengetik
            wadahTabelBuku.style.opacity = '0.5';
            if (labelCariBuku) labelCariBuku.classList.add('hidden');
            if (ikonLoadingBuku) ikonLoadingBuku.classList.remove('hidden');

            // Menunda request selama 300ms agar server tidak terbebani
            batasWaktuBuku = setTimeout(() => {
                const kueri = this.value;
                const urlTujuan = `${urlDasarBuku}?search=${encodeURIComponent(kueri)}`;

                fetch(urlTujuan, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(respon => respon.text())
                .then(html => {
                    const parser = new DOMParser();
                    const dokumenBaru = parser.parseFromString(html, 'text/html');

                    const wadahTabelBaru = dokumenBaru.getElementById('table-container-buku');
                    if (wadahTabelBaru) {
                        wadahTabelBuku.innerHTML = wadahTabelBaru.innerHTML;
                    }

                    // Mengembalikan tampilan tombol ke normal
                    wadahTabelBuku.style.opacity = '1';
                    if (labelCariBuku) labelCariBuku.classList.remove('hidden');
                    if (ikonLoadingBuku) ikonLoadingBuku.classList.add('hidden');

                    // Memperbarui URL di browser tanpa reload halaman
                    window.history.pushState(null, '', urlTujuan);
                })
                .catch(err => {
                    console.error('Terjadi kesalahan saat mencari data buku:', err);
                    wadahTabelBuku.style.opacity = '1';
                    if (labelCariBuku) labelCariBuku.classList.remove('hidden');
                    if (ikonLoadingBuku) ikonLoadingBuku.classList.add('hidden');
                });
            }, 300);
        });
    }
});

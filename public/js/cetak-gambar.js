/**
 * Script untuk mendownload elemen HTML menjadi gambar PNG
 * Membutuhkan library html2canvas
 */

function downloadAsImage(elementId, fileName) {
    // 1. Cari elemen HTML yang ingin dijadikan gambar
    const element = document.getElementById(elementId);

    if (!element) {
        console.error("Elemen dengan ID " + elementId + " tidak ditemukan!");
        return;
    }

    // 2. Eksekusi html2canvas secara diam-diam (tanpa pop-up)
    html2canvas(element, {
        scale: 3, // Kualitas HD
        backgroundColor: '#ffffff'
    }).then(canvas => {
        // 3. Buat link download otomatis
        let link = document.createElement('a');
        link.download = fileName;
        link.href = canvas.toDataURL('image/png');
        link.click();
    }).catch(err => {
        console.error("Terjadi kesalahan saat memproses gambar:", err);
    });
}

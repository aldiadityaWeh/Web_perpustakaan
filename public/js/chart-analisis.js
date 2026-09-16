document.addEventListener('DOMContentLoaded', function() {

    // Pastikan data dari Laravel tersedia sebelum merender
    if (typeof window.analisisData !== 'undefined') {
        const data = window.analisisData;

        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#9ca3af';

        // 1. Line Chart (Tren Peminjaman)
        const ctxLine = document.getElementById('lineChartPeminjaman');
        if (ctxLine) {
            let gradientLine = ctxLine.getContext('2d').createLinearGradient(0, 0, 0, 300);
            gradientLine.addColorStop(0, 'rgba(139, 92, 246, 0.4)');
            gradientLine.addColorStop(1, 'rgba(139, 92, 246, 0.05)');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: data.chartDates,
                    datasets: [{
                        label: 'Peminjaman',
                        data: data.chartData,
                        borderColor: '#8b5cf6',
                        backgroundColor: gradientLine,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#8b5cf6',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { borderDash: [4, 4] } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 2. Donut Chart (Distribusi Kategori)
        const ctxDonut = document.getElementById('donutChartKategori');
        if (ctxDonut) {
            // Generate warna otomatis sesuai jumlah data
            const colors = ['#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#ec4899'];

            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: data.labelKategori,
                    datasets: [{
                        data: data.dataKategori,
                        backgroundColor: colors.slice(0, data.dataKategori.length),
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    }
});

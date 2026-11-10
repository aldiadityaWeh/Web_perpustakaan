document.addEventListener('DOMContentLoaded', function() {

    // Pastikan data dari Laravel tersedia sebelum merender
    if (typeof window.analisisData !== 'undefined') {
        const data = window.analisisData;

        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#9ca3af';

        // 1. Line Chart (Tren Peminjaman)
        const ctxLine = document.getElementById('lineChartPeminjaman');
        if (ctxLine) {
            // Hancurkan chart lama pada canvas ini jika sudah pernah dirender
            const existingLineChart = Chart.getChart(ctxLine);
            if (existingLineChart) {
                existingLineChart.destroy();
            }

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
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Buku Dipinjam';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, precision: 0 },
                            border: { dash: [4, 4] },
                            grid: {
                                borderDash: [4, 4],
                                color: 'rgba(156, 163, 175, 0.15)'
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Donut Chart (Distribusi Kategori)
        const ctxDonut = document.getElementById('donutChartKategori');
        if (ctxDonut) {
            const existingDonutChart = Chart.getChart(ctxDonut);
            if (existingDonutChart) {
                existingDonutChart.destroy();
            }

            // 10 warna berbeda untuk mengakomodasi seluruh 10 Kategori DDC (000 - 900)
            const colors = [
                '#8b5cf6', // 000 - Ungu
                '#3b82f6', // 100 - Biru
                '#10b981', // 200 - Emerald
                '#f59e0b', // 300 - Amber
                '#ef4444', // 400 - Merah
                '#ec4899', // 500 - Pink
                '#06b6d4', // 600 - Cyan
                '#6366f1', // 700 - Indigo
                '#14b8a6', // 800 - Teal
                '#f97316'  // 900 - Oranye
            ];

            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: data.labelKategori,
                    datasets: [{
                        data: data.dataKategori,
                        backgroundColor: data.dataKategori.map((_, i) => colors[i % colors.length]),
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 14,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed + ' Judul';
                                }
                            }
                        }
                    }
                }
            });
        }
    }
});

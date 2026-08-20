import Chart from 'chart.js/auto';

const WARNA_BRAND = '#348362';
const WARNA_GOLD = '#d9a93c';
const WARNA_ABU = '#a8a29e';

const formatAngka = new Intl.NumberFormat('id-ID');

function ambilData(el) {
    try {
        return JSON.parse(el.dataset.json);
    } catch {
        return null;
    }
}

function tooltipDefault() {
    return {
        backgroundColor: '#1c1917',
        titleColor: '#e7e5e4',
        bodyColor: '#e7e5e4',
        padding: 10,
        cornerRadius: 10,
        displayColors: false,
    };
}

function inisialisasiPengunjung(canvas) {
    const data = ambilData(canvas);
    if (!data) {
        return;
    }

    const ctx = canvas.getContext('2d');
    const gradien = ctx.createLinearGradient(0, 0, 0, 260);
    gradien.addColorStop(0, 'rgba(52, 131, 98, 0.28)');
    gradien.addColorStop(1, 'rgba(52, 131, 98, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Pengunjung',
                data: data.values,
                borderColor: WARNA_BRAND,
                backgroundColor: gradien,
                fill: true,
                tension: 0.35,
                borderWidth: 2,
                pointRadius: 2.5,
                pointBackgroundColor: WARNA_BRAND,
                pointHoverRadius: 5,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipDefault(),
                    callbacks: {
                        title: (items) => items[0]?.label ?? '',
                        label: (item) => `${formatAngka.format(item.parsed.y)} kunjungan`,
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#a8a29e',
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 10,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0ede9' },
                    border: { display: false },
                    ticks: {
                        color: '#a8a29e',
                        precision: 0,
                        callback: (v) => formatAngka.format(v),
                    },
                },
            },
        },
    });
}

function inisialisasiBarang(canvas) {
    const data = ambilData(canvas);
    if (!data) {
        return;
    }

    new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.values,
                backgroundColor: [WARNA_BRAND, WARNA_ABU],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        color: '#57534e',
                        padding: 16,
                        font: { size: 12, weight: 600 },
                    },
                },
                tooltip: {
                    ...tooltipDefault(),
                    callbacks: {
                        label: (item) => ` ${item.label}: ${formatAngka.format(item.parsed)} barang`,
                    },
                },
            },
        },
    });
}

function inisialisasiUlasan(canvas) {
    const data = ambilData(canvas);
    if (!data) {
        return;
    }

    new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Ulasan',
                data: data.values,
                backgroundColor: WARNA_GOLD,
                hoverBackgroundColor: '#c8902a',
                borderRadius: 6,
                maxBarThickness: 26,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipDefault(),
                    callbacks: {
                        title: (items) => items[0]?.label ?? '',
                        label: (item) => `${formatAngka.format(item.parsed.y)} ulasan`,
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#a8a29e',
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 8,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0ede9' },
                    border: { display: false },
                    ticks: {
                        color: '#a8a29e',
                        precision: 0,
                        callback: (v) => formatAngka.format(v),
                    },
                },
            },
        },
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const pengunjung = document.getElementById('chart-pengunjung');
    const barang = document.getElementById('chart-barang');
    const ulasan = document.getElementById('chart-ulasan');

    if (pengunjung) {
        inisialisasiPengunjung(pengunjung);
    }
    if (barang) {
        inisialisasiBarang(barang);
    }
    if (ulasan) {
        inisialisasiUlasan(ulasan);
    }
});

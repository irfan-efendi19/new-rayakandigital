import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('visitorChart');
    if (!canvas) return;

    const labels = JSON.parse(canvas.dataset.labels || '[]');
    const totals = JSON.parse(canvas.dataset.totals || '[]');
    const uniques = JSON.parse(canvas.dataset.uniques || '[]');

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Kunjungan',
                    data: totals,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.3,
                },
                {
                    label: 'Pengunjung Unik',
                    data: uniques,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                    },
                },
            },
        },
    });
});

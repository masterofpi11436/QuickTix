import Chart from 'chart.js/auto';

function initLineChart(id, labels, data, label) {
    const el = document.getElementById(id);
    if (!el) return;

    new Chart(el, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label,
                data,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const createdEl = document.getElementById('createdChart');
    const completedEl = document.getElementById('completedChart');

    if (createdEl) {
        const labels = JSON.parse(createdEl.dataset.labels || '[]');
        const data = JSON.parse(createdEl.dataset.data || '[]');
        initLineChart('createdChart', labels, data, 'Created');
    }

    if (completedEl) {
        const labels = JSON.parse(completedEl.dataset.labels || '[]');
        const data = JSON.parse(completedEl.dataset.data || '[]');
        initLineChart('completedChart', labels, data, 'Completed');
    }
});

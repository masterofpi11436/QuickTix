(function () {
    const el = document.getElementById('completedDeptTrend');
    if (!el) return;

    const labels = JSON.parse(el.dataset.labels || '[]');
    const data = JSON.parse(el.dataset.data || '[]');

    if (window.__completedDeptTrendChart) {
        window.__completedDeptTrendChart.destroy();
    }

    window.__completedDeptTrendChart = new Chart(el, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Completed',
                data,
                tension: 0.25,
                fill: false,
                pointRadius: 0,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
})();

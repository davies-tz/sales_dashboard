<?php
// Prepare chart data
$monthLabels  = array_column($monthly_revenue, 'month');
$monthRevenue = array_column($monthly_revenue, 'revenue');
$catLabels    = array_column($sales_by_category, 'category');
$catRevenue   = array_column($sales_by_category, 'revenue');

$growth = 0;
if (!empty($month_comparison['last_month']) && $month_comparison['last_month'] > 0) {
    $growth = (($month_comparison['this_month'] - $month_comparison['last_month']) / $month_comparison['last_month']) * 100;
}
?>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card kpi-primary">
        <div class="kpi-label">Total Revenue</div>
        <div class="kpi-value">TZS <?= number_format($total_revenue) ?></div>
        <div class="kpi-badge <?= $growth >= 0 ? 'badge-up' : 'badge-down' ?>">
            <?= $growth >= 0 ? '↑' : '↓' ?> <?= abs(round($growth, 1)) ?>% vs last month
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Total Orders</div>
        <div class="kpi-value"><?= number_format($total_orders) ?></div>
        <div class="kpi-badge">All time</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Customers</div>
        <div class="kpi-value"><?= number_format($total_customers) ?></div>
        <div class="kpi-badge">Registered</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Avg. Order Value</div>
        <div class="kpi-value">TZS <?= number_format($avg_order_value) ?></div>
        <div class="kpi-badge">Per transaction</div>
    </div>
</div>

<!-- Charts Row -->
<div class="charts-row">
    <div class="chart-card chart-large">
        <div class="chart-header">
            <h3>Revenue Trend</h3>
            <span class="chart-subtitle">Last 12 months</span>
        </div>
        <canvas id="revenueChart" height="120"></canvas>
    </div>
    <div class="chart-card chart-small">
        <div class="chart-header">
            <h3>By Category</h3>
            <span class="chart-subtitle">Revenue split</span>
        </div>
        <canvas id="categoryChart" height="180"></canvas>
        <div class="legend" id="catLegend"></div>
    </div>
</div>

<!-- Bottom Row -->
<div class="bottom-row">
    <!-- Top Products -->
    <div class="card">
        <div class="card-header">
            <h3>Top Products</h3>
        </div>
        <table class="data-table">
            <thead><tr><th>Product</th><th>Category</th><th>Units</th><th>Revenue</th></tr></thead>
            <tbody>
            <?php foreach ($top_products as $i => $p): ?>
            <tr>
                <td>
                    <span class="rank-badge"><?= $i+1 ?></span>
                    <?= htmlspecialchars($p['name']) ?>
                </td>
                <td><span class="tag"><?= htmlspecialchars($p['category']) ?></span></td>
                <td><?= number_format($p['units_sold']) ?></td>
                <td class="text-right">TZS <?= number_format($p['revenue']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Recent Sales -->
    <div class="card">
        <div class="card-header">
            <h3>Recent Transactions</h3>
            <a href="<?= BASE_URL ?>/sales" class="btn-link">View all →</a>
        </div>
        <table class="data-table">
            <thead><tr><th>#</th><th>Customer</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($recent_sales as $s): ?>
            <tr>
                <td class="text-muted"><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['customer_name']) ?></td>
                <td>TZS <?= number_format($s['total_amount']) ?></td>
                <td><span class="status-badge status-<?= $s['status'] ?>"><?= $s['status'] ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($monthLabels) ?>,
        datasets: [{
            label: 'Revenue (TZS)',
            data: <?= json_encode($monthRevenue) ?>,
            borderColor: '#6EE7B7',
            backgroundColor: 'rgba(110,231,183,0.1)',
            borderWidth: 2.5,
            pointBackgroundColor: '#6EE7B7',
            pointRadius: 4,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94a3b8', font: {family:'DM Sans'} } },
            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94a3b8', font: {family:'DM Sans'}, callback: v => 'TZS ' + Number(v).toLocaleString() } }
        }
    }
});

// Category Donut Chart
const catCtx = document.getElementById('categoryChart').getContext('2d');
const catColors = ['#6EE7B7','#38BDF8','#F472B6','#FBBF24','#A78BFA'];
new Chart(catCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($catLabels) ?>,
        datasets: [{
            data: <?= json_encode($catRevenue) ?>,
            backgroundColor: catColors,
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        cutout: '68%',
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ' TZS ' + ctx.raw.toLocaleString() } }
        }
    }
});

// Custom legend
const labels = <?= json_encode($catLabels) ?>;
const colors = catColors;
const legend = document.getElementById('catLegend');
labels.forEach((l,i) => {
    legend.innerHTML += `<span class="legend-item"><span class="legend-dot" style="background:${colors[i]}"></span>${l}</span>`;
});
</script>

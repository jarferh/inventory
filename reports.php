<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/functions.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Reports";
$currentPage = "reports";

// Get database connection
$db = Database::getInstance()->getConnection();

// Initialize variables
$startDate = $_GET['start_date'] ?? date('Y-m-01'); // First day of current month
$endDate = $_GET['end_date'] ?? date('Y-m-d');
$reportType = $_GET['report_type'] ?? 'sales';

// Initialize reports data
$reportData = [];
$summary = [];

try {
    switch ($reportType) {
        case 'sales':
            // Sales Report Query
            $query = "
                SELECT 
                    s.invoice_number,
                    s.created_at,
                    COALESCE(c.name, 'Walk-in Customer') as customer_name,
                    s.total_amount,
                    s.amount_paid,
                    s.payment_status,
                    COUNT(si.id) as items_count,
                    SUM(si.quantity * (si.selling_price - p.buying_price)) as profit
                FROM sales s
                LEFT JOIN customers c ON s.customer_id = c.id
                LEFT JOIN sale_items si ON s.id = si.sale_id
                LEFT JOIN products p ON si.product_id = p.id
                WHERE DATE(s.created_at) BETWEEN ? AND ?
                GROUP BY s.id
                ORDER BY s.created_at DESC
            ";

            $stmt = $db->prepare($query);
            $stmt->execute([$startDate, $endDate]);
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculate summary
            $summary = [
                'total_sales' => array_sum(array_column($reportData, 'total_amount')),
                'total_profit' => array_sum(array_column($reportData, 'profit')),
                'total_paid' => array_sum(array_column($reportData, 'amount_paid')),
                'total_pending' => array_sum(array_map(function ($row) {
                    return $row['total_amount'] - $row['amount_paid'];
                }, $reportData)),
                'total_transactions' => count($reportData)
            ];
            break;

        case 'inventory':
            // Inventory Report Query
            $query = "
                SELECT 
                    p.code,
                    p.name,
                    c.name as category_name,
                    p.quantity,
                    p.min_stock_level,
                    p.unit_type,
                    p.buying_price,
                    p.selling_price,
                    (p.quantity * p.buying_price) as stock_value,
                    CASE 
                        WHEN p.quantity <= p.min_stock_level THEN 'Low Stock'
                        WHEN p.quantity = 0 THEN 'Out of Stock'
                        ELSE 'In Stock'
                    END as stock_status
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.quantity <= p.min_stock_level DESC, p.name ASC
            ";

            $reportData = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

            // Calculate summary
            $summary = [
                'total_products' => count($reportData),
                'total_stock_value' => array_sum(array_column($reportData, 'stock_value')),
                'low_stock_items' => count(array_filter($reportData, fn($item) => $item['stock_status'] === 'Low Stock')),
                'out_of_stock_items' => count(array_filter($reportData, fn($item) => $item['stock_status'] === 'Out of Stock'))
            ];
            break;

        case 'financial':
            // Financial Report Query
            $query = "
                SELECT 
                    DATE(s.created_at) as date,
                    COUNT(DISTINCT s.id) as transactions,
                    SUM(s.total_amount) as revenue,
                    SUM(s.amount_paid) as collected,
                    SUM(si.quantity * (si.selling_price - p.buying_price)) as gross_profit
                FROM sales s
                LEFT JOIN sale_items si ON s.id = si.sale_id
                LEFT JOIN products p ON si.product_id = p.id
                WHERE DATE(s.created_at) BETWEEN ? AND ?
                GROUP BY DATE(s.created_at)
                ORDER BY date DESC
            ";

            $stmt = $db->prepare($query);
            $stmt->execute([$startDate, $endDate]);
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculate summary
            $summary = [
                'total_revenue' => array_sum(array_column($reportData, 'revenue')),
                'total_collected' => array_sum(array_column($reportData, 'collected')),
                'total_profit' => array_sum(array_column($reportData, 'gross_profit')),
                'average_daily_revenue' => count($reportData) ? array_sum(array_column($reportData, 'revenue')) / count($reportData) : 0
            ];
            break;
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    error_log($e->getMessage());
}

include 'templates/header.php';
?>

<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Reports & Analytics
                    </h2>
                </div>
                <!-- <div class="col-auto ms-auto d-print-none">
                    <button type="button" class="btn btn-primary" onclick="window.print();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                            <rect x="7" y="13" width="10" height="8" rx="2" />
                        </svg>
                        Print Report
                    </button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Filter Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="get" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Report Type</label>
                            <select class="form-select" name="report_type" onchange="this.form.submit()">
                                <option value="sales" <?= $reportType === 'sales' ? 'selected' : '' ?>>Sales Report</option>
                                <option value="inventory" <?= $reportType === 'inventory' ? 'selected' : '' ?>>Inventory Report</option>
                                <option value="financial" <?= $reportType === 'financial' ? 'selected' : '' ?>>Financial Report</option>
                            </select>
                        </div>
                        <?php if ($reportType !== 'inventory'): ?>
                            <div class="col-md-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="<?= htmlspecialchars($startDate) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($endDate) ?>">
                            </div>
                            <!-- Update the Generate Report button -->
                            <!-- Update the Generate Report buttons -->
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="btn-group w-100">
                                    <a href="actions/generate_report.php?report_type=<?= $reportType ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>&format=csv" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M8 11h8v7h-8z" />
                                            <path d="M8 15h8" />
                                            <path d="M11 11v7" />
                                        </svg>
                                        Export to Excel
                                    </a>
                                    <a href="actions/generate_report.php?report_type=<?= $reportType ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>&format=pdf" target="_blank" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M9 7h1" />
                                            <path d="M9 13h6" />
                                            <path d="M13 17h2" />
                                        </svg>
                                        Print PDF
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row row-deck row-cards mb-4">
                <?php if ($reportType === 'sales'): ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Sales</div>
                                </div>
                                <div class="h1 mb-3">₦<?= number_format($summary['total_sales'], 2) ?></div>
                                <div class="d-flex mb-2">
                                    <div>Transactions</div>
                                    <div class="ms-auto"><?= $summary['total_transactions'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Profit</div>
                                </div>
                                <div class="h1 mb-3">₦<?= number_format($summary['total_profit'], 2) ?></div>
                                <div class="d-flex mb-2">
                                    <div>Profit Margin</div>
                                    <div class="ms-auto"><?= $summary['total_sales'] > 0 ? number_format(($summary['total_profit'] / $summary['total_sales']) * 100, 1) : '0' ?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($reportType === 'inventory'): ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Stock Value</div>
                                </div>
                                <div class="h1 mb-3">₦<?= number_format($summary['total_stock_value'], 2) ?></div>
                                <div class="d-flex mb-2">
                                    <div>Total Products</div>
                                    <div class="ms-auto"><?= $summary['total_products'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Stock Alerts</div>
                                </div>
                                <div class="h1 mb-3"><?= $summary['low_stock_items'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>Out of Stock</div>
                                    <div class="ms-auto"><?= $summary['out_of_stock_items'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Revenue</div>
                                </div>
                                <div class="h1 mb-3">₦<?= number_format($summary['total_revenue'], 2) ?></div>
                                <div class="d-flex mb-2">
                                    <div>Daily Average</div>
                                    <div class="ms-auto">₦<?= number_format($summary['average_daily_revenue'], 2) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Collected</div>
                                </div>
                                <div class="h1 mb-3">₦<?= number_format($summary['total_collected'], 2) ?></div>
                                <div class="d-flex mb-2">
                                    <div>Collection Rate</div>
                                    <div class="ms-auto"><?= $summary['total_revenue'] > 0 ? number_format(($summary['total_collected'] / $summary['total_revenue']) * 100, 1) : '0' ?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Report Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table" id="reportTable">
                            <?php if ($reportType === 'sales'): ?>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Amount</th>
                                        <th>Profit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reportData as $row): ?>
                                        <tr>
                                            <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                                            <td><?= htmlspecialchars($row['invoice_number']) ?></td>
                                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                            <td><?= $row['items_count'] ?></td>
                                            <td>₦<?= number_format($row['total_amount'], 2) ?></td>
                                            <td>₦<?= number_format($row['profit'], 2) ?></td>
                                            <td>
                                                <span class="badge bg-<?= match ($row['payment_status']) {
                                                                            'paid' => 'success',
                                                                            'partial' => 'warning',
                                                                            'pending' => 'danger'
                                                                        } ?>-lt">
                                                    <?= ucfirst($row['payment_status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($reportType === 'inventory'): ?>
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Stock Level</th>
                                        <th>Unit Type</th>
                                        <th>Value</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reportData as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['code']) ?></td>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                                            <td>
                                                <?= $row['quantity'] ?> / <?= $row['min_stock_level'] ?>
                                                <div class="progress progress-sm">
                                                    <?php
                                                    $stockPercentage = ($row['quantity'] / max($row['min_stock_level'] * 2, 1)) * 100;
                                                    $progressClass = $stockPercentage <= 25 ? 'danger' : ($stockPercentage <= 50 ? 'warning' : 'success');
                                                    ?>
                                                    <div class="progress-bar bg-<?= $progressClass ?>" style="width: <?= min($stockPercentage, 100) ?>%"></div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($row['unit_type']) ?></td>
                                            <td>₦<?= number_format($row['stock_value'], 2) ?></td>
                                            <td>
                                                <?php
                                                $statusClass = match ($row['stock_status']) {
                                                    'In Stock' => 'success',
                                                    'Low Stock' => 'warning',
                                                    default => 'danger'
                                                };
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>-lt">
                                                    <?= $row['stock_status'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php else: ?>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Transactions</th>
                                        <th>Revenue</th>
                                        <th>Collected</th>
                                        <th>Pending</th>
                                        <th>Gross Profit</th>
                                        <th>Margin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reportData as $row): ?>
                                        <tr>
                                            <td><?= $row['date'] ?></td>
                                            <td><?= $row['transactions'] ?></td>
                                            <td>₦<?= number_format($row['revenue'], 2) ?></td>
                                            <td>₦<?= number_format($row['collected'], 2) ?></td>
                                            <td>₦<?= number_format($row['revenue'] - $row['collected'], 2) ?></td>
                                            <td>₦<?= number_format($row['gross_profit'], 2) ?></td>
                                            <td>
                                                <?php
                                                $margin = $row['revenue'] > 0 ? ($row['gross_profit'] / $row['revenue']) * 100 : 0;
                                                $marginClass = $margin < 15 ? 'danger' : ($margin < 25 ? 'warning' : 'success');
                                                ?>
                                                <span class="badge bg-<?= $marginClass ?>-lt">
                                                    <?= number_format($margin, 1) ?>%
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="reportChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        const table = new DataTable('#reportTable', {
            pageLength: 25,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        // Prepare chart data based on report type
        const ctx = document.getElementById('reportChart').getContext('2d');
        <?php if ($reportType === 'sales' || $reportType === 'financial'): ?>
            const timeSeriesData = {
                labels: <?= json_encode(array_map(fn($row) => isset($row['date']) ? $row['date'] : date('Y-m-d', strtotime($row['created_at'])), array_reverse($reportData))) ?>,
                datasets: [{
                        label: 'Revenue',
                        data: <?= json_encode(array_map(fn($row) => isset($row['revenue']) ? $row['revenue'] : $row['total_amount'], array_reverse($reportData))) ?>,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    },
                    {
                        label: 'Profit',
                        data: <?= json_encode(array_map(fn($row) => $row['gross_profit'] ?? $row['profit'], array_reverse($reportData))) ?>,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    }
                ]
            };
        <?php else: ?>
            const inventoryData = {
                labels: <?= json_encode(array_map(fn($row) => $row['name'], $reportData)) ?>,
                datasets: [{
                    label: 'Stock Level',
                    data: <?= json_encode(array_map(fn($row) => $row['quantity'], $reportData)) ?>,
                    backgroundColor: <?= json_encode(array_map(function ($row) {
                                            return match ($row['stock_status']) {
                                                'In Stock' => 'rgba(75, 192, 192, 0.2)',
                                                'Low Stock' => 'rgba(255, 205, 86, 0.2)',
                                                default => 'rgba(255, 99, 132, 0.2)'
                                            };
                                        }, $reportData)) ?>,
                    borderColor: <?= json_encode(array_map(function ($row) {
                                        return match ($row['stock_status']) {
                                            'In Stock' => 'rgb(75, 192, 192)',
                                            'Low Stock' => 'rgb(255, 205, 86)',
                                            default => 'rgb(255, 99, 132)'
                                        };
                                    }, $reportData)) ?>,
                    borderWidth: 1
                }]
            };
        <?php endif; ?>

        new Chart(ctx, {
            type: <?= $reportType === 'inventory' ? "'bar'" : "'line'" ?>,
            data: <?= ($reportType === 'sales' || $reportType === 'financial') ? 'timeSeriesData' : 'inventoryData' ?>,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?php include 'templates/footer.php'; ?>
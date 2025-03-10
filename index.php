<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/functions.php';

// At the top of your index.php, after includes
$currentPage = 'dashboard'; // This should match the menu item title in lowercase
// Initialize Auth and check login
// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Dashboard";
$currentPage = "dashboard";

// Current system values
$CURRENT_TIME = date('Y-m-d H:i:s');
$CURRENT_USER = $_SESSION['username'] ?? 'jarferh';

try {
    // Get database connection
    $db = Database::getInstance()->getConnection();

    // Initialize default values
    $todaySales = [
        'count' => 0,
        'total' => 0,
        'paid_amount' => 0
    ];
    
    $todayProfit = ['total_profit' => 0];
    $lowStock = ['count' => 0];
    $recentSales = [];
    $activities = [];

    // Today's sales query
    $salesStmt = $db->prepare("
        SELECT 
            COUNT(*) as count,
            COALESCE(SUM(total_amount), 0) as total,
            COALESCE(SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END), 0) as paid_amount
        FROM sales 
        WHERE DATE(created_at) = CURRENT_DATE
    ");
    $salesStmt->execute();
    $todaySales = $salesStmt->fetch(PDO::FETCH_ASSOC);

    // Low stock query
    $stockStmt = $db->prepare("
        SELECT COUNT(*) as count 
        FROM products 
        WHERE quantity <= min_stock_level
    ");
    $stockStmt->execute();
    $lowStock = $stockStmt->fetch(PDO::FETCH_ASSOC);

    // Today's profit query
    $profitStmt = $db->prepare("
        SELECT 
            COALESCE(SUM((si.selling_price - p.buying_price) * si.quantity), 0) as total_profit
        FROM sales s
        JOIN sale_items si ON s.id = si.sale_id
        JOIN products p ON si.product_id = p.id
        WHERE DATE(s.created_at) = CURRENT_DATE
    ");
    $profitStmt->execute();
    $todayProfit = $profitStmt->fetch(PDO::FETCH_ASSOC);

    // Recent sales query
    $recentStmt = $db->prepare("
        SELECT 
            s.*,
            c.name as customer_name,
            u.username as created_by_user
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.id
        LEFT JOIN users u ON s.created_by = u.id
        ORDER BY s.created_at DESC
        LIMIT 5
    ");
    $recentStmt->execute();
    $recentSales = $recentStmt->fetchAll(PDO::FETCH_ASSOC);

    // Activities query
    $activityStmt = $db->prepare("
        SELECT 
            al.*,
            u.username
        FROM activity_log al
        LEFT JOIN users u ON al.user_id = u.id
        ORDER BY al.created_at DESC
        LIMIT 5
    ");
    $activityStmt->execute();
    $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    error_log($e->getMessage());
    // Initialize empty arrays if queries fail
    $todaySales = ['count' => 0, 'total' => 0, 'paid_amount' => 0];
    $todayProfit = ['total_profit' => 0];
    $lowStock = ['count' => 0];
    $recentSales = [];
    $activities = [];
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
                        Dashboard Overview
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Stats Row -->
            <div class="row row-deck row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Today's Sales</div>
                                <div class="ms-auto lh-1">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Today</a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item active" href="#">Today</a>
                                            <a class="dropdown-item" href="#">Yesterday</a>
                                            <a class="dropdown-item" href="#">Last 7 days</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mb-3">₦<?= number_format($todaySales['total'], 2) ?></div>
                            <div class="d-flex mb-2">
                                <div>Transactions</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        <?= $todaySales['count'] ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: <?= min(100, ($todaySales['count'] * 10)) ?>%" role="progressbar" aria-valuenow="<?= $todaySales['count'] ?>" aria-valuemin="0" aria-valuemax="100">
                                    <span class="visually-hidden"><?= $todaySales['count'] ?>% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Today's Profit</div>
                            </div>
                            <div class="h1 mb-3">₦<?= number_format($todayProfit['total_profit'], 2) ?></div>
                            <div class="d-flex mb-2">
                                <div>Profit Margin</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        <?= number_format(($todayProfit['total_profit'] / max(1, $todaySales['total'])) * 100, 1) ?>%
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: <?= ($todayProfit['total_profit'] / max(1, $todaySales['total'])) * 100 ?>%" role="progressbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Low Stock Items</div>
                            </div>
                            <div class="h1 mb-3"><?= $lowStock['count'] ?></div>
                            <div class="d-flex mb-2">
                                <div>Items below minimum</div>
                                <div class="ms-auto">
                                    <span class="text-yellow d-inline-flex align-items-center lh-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 9v2m0 4v.01" />
                                            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: <?= min(100, ($lowStock['count'] * 5)) ?>%" role="progressbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Payment Status</div>
                            </div>
                            <div class="h1 mb-3">
                                <?= number_format(($todaySales['paid_amount'] / max(1, $todaySales['total'])) * 100, 1) ?>%
                            </div>
                            <div class="d-flex mb-2">
                                <div>Completed Payments</div>
                                <div class="ms-auto">
                                    <span class="text-info d-inline-flex align-items-center lh-1">
                                        ₦<?= number_format($todaySales['paid_amount'], 2) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-info" style="width: <?= ($todaySales['paid_amount'] / max(1, $todaySales['total'])) * 100 ?>%" role="progressbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Main Content Column -->
                <div class="col-lg-8">
                    <!-- Recent Transactions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Recent Transactions</h3>
                            <div class="card-actions">
                                <a href="sales.php" class="btn btn-primary btn-sm">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentSales as $sale): ?>
                                        <tr>
                                            <td>
                                                <a href="sale_details.php?id=<?= $sale['id'] ?>" class="text-reset">
                                                    <?= htmlspecialchars($sale['invoice_number']) ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($sale['customer_name'] ?? 'Walk-in Customer') ?></td>
                                            <td>₦<?= number_format($sale['total_amount'], 2) ?></td>
                                            <td>
                                                <?php
                                                $statusClass = match($sale['payment_status']) {
                                                    'paid' => 'success',
                                                    'partial' => 'warning',
                                                    default => 'danger'
                                                };
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>-lt">
                                                    <?= ucfirst($sale['payment_status']) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($sale['created_by_user']) ?></td>
                                            <td class="text-muted">
                                                <?= date('H:i', strtotime($sale['created_at'])) ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Timeline -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Activity</h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <?php foreach ($activities as $activity): ?>
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-primary"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="fw-bold"><?= htmlspecialchars($activity['action']) ?></span>
                                            <small class="text-muted"><?= date('H:i', strtotime($activity['created_at'])) ?></small>
                                        </div>
                                        <p class="text-muted mb-1"><?= htmlspecialchars($activity['description']) ?></p>
                                        <span class="badge bg-primary-lt">
                                            <?= htmlspecialchars($activity['username']) ?>
                                        </span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Content Column -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="sales.php?action=new" class="btn btn-primary w-100 btn-icon">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg> -->
                                        New Sale
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="products.php?action=new" class="btn btn-success w-100 btn-icon">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-package" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"></polyline>
                                            <line x1="12" y1="12" x2="20" y2="7.5"></line>
                                            <line x1="12" y1="12" x2="12" y2="21"></line>
                                            <line x1="12" y1="12" x2="4" y2="7.5"></line>
                                        </svg> -->
                                        Add Product
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="customers.php?action=new" class="btn btn-info w-100 btn-icon">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 11h6m-3 -3v6"></path>
                                        </svg> -->
                                        Add Customer
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="reports.php" class="btn btn-warning w-100 btn-icon">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                            <path d="M8 5a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2z"></path>
                                            <line x1="10" y1="12" x2="14" y2="12"></line>
                                        </svg> -->
                                        View Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">System Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Current Time (UTC)</div>
                                    <div class="datagrid-content" id="currentTimeDisplay">
                                        <?= $CURRENT_TIME ?>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Active User</div>
                                    <div class="datagrid-content">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-xs me-2 rounded"><?= substr($CURRENT_USER, 0, 2) ?></span>
                                            <?= htmlspecialchars($CURRENT_USER) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">System Status</div>
                                    <div class="datagrid-content">
                                        <span class="status status-green">
                                            Operational
                                        </span>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Backup</div>
                                    <div class="datagrid-content">
                                        <?= date('Y-m-d H:i', strtotime('-1 hour')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Performance Chart -->
                    <!-- <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales Performance</h3>
                        </div>
                        <div class="card-body">
                            <div id="salesChart" style="height: 220px"></div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page specific scripts -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Update current time
    function updateTime() {
        const now = new Date('<?= $CURRENT_TIME ?>');
        now.setSeconds(now.getSeconds() + 1);
        document.getElementById('currentTimeDisplay').textContent = 
            now.toISOString().slice(0, 19).replace('T', ' ');
    }
    setInterval(updateTime, 1000);

    // Initialize sales chart
    var options = {
        series: [{
            name: 'Sales',
            data: [30, 40, 35, 50, 49, 60, 70]
        }, {
            name: 'Profit',
            data: [12, 15, 14, 20, 19, 24, 28]
        }],
        chart: {
            type: 'area',
            height: 220,
            toolbar: {
                show: false,
            },
            stacked: false
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.6,
                opacityTo: 0.1,
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center'
        },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return '₦' + value.toFixed(0) + 'k';
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return '₦' + value.toFixed(2) + 'k';
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();

    // Initialize DataTables
    if ($.fn.DataTable) {
        $('.datatable').DataTable({
            pageLength: 5,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            responsive: true
        });
    }
});
</script>
<!-- Core JS -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle mobile sidebar toggle
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbar = document.querySelector('.navbar-vertical');
    const overlay = document.querySelector('.navbar-overlay');
    
    function toggleSidebar() {
        navbar.classList.toggle('show');
        overlay.classList.toggle('show');
        document.body.classList.toggle('overflow-hidden');
    }
    
    navbarToggler.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleSidebar();
    });
    
    // Close sidebar when clicking overlay
    overlay.addEventListener('click', toggleSidebar);
    
    // Update current date and time
    function updateDateTime() {
        const now = new Date();
        const formatted = now.getFullYear() + '-' + 
                         String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                         String(now.getDate()).padStart(2, '0') + ' ' + 
                         String(now.getHours()).padStart(2, '0') + ':' + 
                         String(now.getMinutes()).padStart(2, '0') + ':' + 
                         String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('currentDateTime').textContent = formatted;
    }
    
    // Update time every second
    setInterval(updateDateTime, 1000);
    updateDateTime(); // Initial update
});
</script>

<?php include 'templates/footer.php'; ?>
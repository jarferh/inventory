<?php
session_start();
$CURRENT_TIME = "2025-02-21 18:34:12";
$CURRENT_USER = $_SESSION['username'] ?? "musty131311";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Inventory System</title>
    
    <script src="assets/js/add-product.js"></script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 0.8rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
        }
        .sidebar .nav-link:hover {
            background: #34495e;
        }
        .sidebar .nav-link.active {
            background: #3498db;
        }
        .content-wrapper {
            background: #f8f9fa;
        }
        .stats-card {
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .product-action-btn {
            width: 38px;
            height: 38px;
            padding: 0;
            line-height: 38px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar position-fixed">
            <div class="px-3 py-4 text-white">
                <h5 class="mb-0">Inventory System</h5>
                <small class="d-block mb-3">Welcome, <?= htmlspecialchars($CURRENT_USER) ?></small>
            </div>
            <nav class="nav flex-column px-2">
                <a class="nav-link active" href="#dashboard">
                    <i class="fas fa-dashboard me-2"></i> Dashboard
                </a>
                <a class="nav-link" href="#products">
                    <i class="fas fa-boxes me-2"></i> Products
                </a>
                <a class="nav-link" href="#sales">
                    <i class="fas fa-shopping-cart me-2"></i> Sales
                </a>
                <a class="nav-link" href="#users">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-auto content-wrapper">
            <!-- Top Bar -->
            <div class="row py-3 px-4 border-bottom bg-white">
                <div class="col-md-6">
                    <h4 class="mb-0">Product Management</h4>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-inline-block me-3">
                        <small class="text-muted d-block">Current Time (UTC)</small>
                        <strong id="currentTime"><?= $CURRENT_TIME ?></strong>
                    </div>
                    <div class="d-inline-block">
                        <small class="text-muted d-block">Logged in as</small>
                        <strong><?= htmlspecialchars($CURRENT_USER) ?></strong>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row p-4 g-3">
                <div class="col-md-3">
                    <div class="card stats-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Products</h6>
                                    <h3 class="mb-0" id="totalProducts">0</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-boxes text-primary fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Low Stock Items</h6>
                                    <h3 class="mb-0 text-warning" id="lowStockCount">0</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Today's Sales</h6>
                                    <h3 class="mb-0" id="todaySales">₦0</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-chart-line text-success fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Active Users</h6>
                                    <h3 class="mb-0" id="activeUsers">0</h3>
                                </div>
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-users text-info fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="row px-4 pb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Products List</h5>
                                </div>
                                <div class="col text-end">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                        <i class="fas fa-plus me-2"></i>Add Product
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Stock</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Products will be loaded dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal content will continue... -->
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Initialize system time display
const SYSTEM_TIME = "<?= $CURRENT_TIME ?>";
const CURRENT_USER = "<?= $CURRENT_USER ?>";

// Update time display
function updateTime() {
    const now = new Date(SYSTEM_TIME);
    now.setSeconds(now.getSeconds() + 1);
    document.getElementById('currentTime').textContent = 
        now.toISOString().slice(0, 19).replace('T', ' ');
}

setInterval(updateTime, 1000);
</script>

</body>
</html>
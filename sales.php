<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/functions.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Sales Management";
$currentPage = "sales";

// Initialize variables
$sales = [];
$error = '';
$success = '';
$CURRENT_TIME = date('Y-m-d H:i:s');
$CURRENT_USER = $_SESSION['username'] ?? 'jarferh';

// Initialize totals
$totals = [
    'sales' => 0,
    'profit' => 0,
    'paid' => 0,
    'pending' => 0
];

try {
    // Get database connection
    $db = Database::getInstance()->getConnection();

    // Check if sales table exists
    $stmt = $db->query("SHOW TABLES LIKE 'sales'");
    if ($stmt->rowCount() == 0) {
        // Load and execute the SQL file to create tables
        $sql = file_get_contents(__DIR__ . '/database/create_sales_tables.sql');
        $db->exec($sql);
    }

    // Handle date filters
    $startDate = $_GET['start_date'] ?? date('Y-m-d');
    $endDate = $_GET['end_date'] ?? date('Y-m-d');
    $status = $_GET['status'] ?? '';

    // Fetch sales with related information
    $query = "
        SELECT 
            s.*,
            u.username as created_by_user,
            c.name as customer_name,
            COUNT(si.id) as item_count,
            COALESCE(SUM(si.quantity * (si.selling_price - p.buying_price)), 0) as profit
        FROM sales s
        LEFT JOIN users u ON s.created_by = u.id
        LEFT JOIN customers c ON s.customer_id = c.id
        LEFT JOIN sale_items si ON s.id = si.sale_id
        LEFT JOIN products p ON si.product_id = p.id
        WHERE DATE(s.created_at) BETWEEN ? AND ?
    ";
    
    $params = [$startDate, $endDate];
    
    if ($status) {
        $query .= " AND s.payment_status = ?";
        $params[] = $status;
    }
    
    $query .= " GROUP BY s.id ORDER BY s.created_at DESC";
    
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate totals
    foreach ($sales as $sale) {
        $totals['sales'] += floatval($sale['total_amount']);
        $totals['profit'] += floatval($sale['profit']);
        if ($sale['payment_status'] === 'paid') {
            $totals['paid'] += floatval($sale['total_amount']);
        } else {
            $totals['pending'] += floatval($sale['total_amount']);
        }
    }

} catch(PDOException $e) {
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
                        Sales Management
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#newSaleModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            New Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <!-- Sales Statistics Cards -->
            <div class="row row-deck row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Total Sales</div>
                            </div>
                            <div class="h1 mb-3">₦<?= number_format($totals['sales'], 2) ?></div>
                            <div class="d-flex mb-2">
                                <div>Number of Transactions</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        <?= count($sales) ?>
                                    </span>
                                </div>
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
                            <div class="h1 mb-3">₦<?= number_format($totals['profit'], 2) ?></div>
                            <div class="d-flex mb-2">
                                <div>Profit Margin</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        <?= $totals['sales'] > 0 ? number_format(($totals['profit'] / $totals['sales']) * 100, 1) : '0' ?>%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Paid Amount</div>
                            </div>
                            <div class="h1 mb-3">₦<?= number_format($totals['paid'], 2) ?></div>
                            <div class="d-flex mb-2">
                                <div>Payment Rate</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        <?= $totals['sales'] > 0 ? number_format(($totals['paid'] / $totals['sales']) * 100, 1) : '0' ?>%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Pending Amount</div>
                            </div>
                            <div class="h1 mb-3">₦<?= number_format($totals['pending'], 2) ?></div>
                            <div class="d-flex mb-2">
                                <div>Outstanding Rate</div>
                                <div class="ms-auto">
                                    <span class="text-yellow d-inline-flex align-items-center lh-1">
                                        <?= $totals['sales'] > 0 ? number_format(($totals['pending'] / $totals['sales']) * 100, 1) : '0' ?>%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="get" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="<?= htmlspecialchars($startDate) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($endDate) ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="paid" <?= $status === 'paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="partial" <?= $status === 'partial' ? 'selected' : '' ?>>Partial</option>
                                <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Profit</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Date</th>
                                    <th class="w-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $sale): ?>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset" data-bs-toggle="modal" data-bs-target="#viewSaleModal" data-sale-id="<?= $sale['id'] ?>">
                                            <?= htmlspecialchars($sale['invoice_number']) ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($sale['customer_name'] ?? 'Walk-in Customer') ?></td>
                                    <td><?= $sale['item_count'] ?? '0' ?></td>
                                    <td>₦<?= number_format($sale['total_amount'], 2) ?></td>
                                    <td>₦<?= number_format($sale['profit'], 2) ?></td>
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
                                    <td><?= date('Y-m-d H:i', strtotime($sale['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="#" class="btn btn-icon btn-primary" onclick="printInvoice(<?= $sale['id'] ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                    <rect x="7" y="13" width="10" height="8" rx="2" />
                                                </svg>
                                            </a>
                                            <?php if ($sale['payment_status'] !== 'paid'): ?>
                                            <a href="#" class="btn btn-icon btn-success" data-bs-toggle="modal" data-bs-target="#addPaymentModal" data-sale-id="<?= $sale['id'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <rect x="7" y="9" width="14" height="10" rx="2" />
                                                    <circle cx="14" cy="14" r="2" />
                                                    <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                                                </svg>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                        </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Sale Modal -->
<div class="modal modal-blur fade" id="newSaleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newSaleForm" action="actions/sale_actions.php" method="post">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Customer</label>
                            <select class="form-select" name="customer_id">
                                <option value="">Walk-in Customer</option>
                                <!-- Populate with customers -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="payment_status" required>
                                <option value="paid">Paid</option>
                                <option value="partial">Partial Payment</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <label class="form-label">Items</label>
                            <button type="button" class="btn btn-sm btn-primary" id="addItemRow">
                                Add Item
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Items will be added here -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">Subtotal:</td>
                                        <td>₦<span id="subtotal">0.00</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Tax (0%):</td>
                                        <td>₦<span id="tax">0.00</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Total:</td>
                                        <td>₦<span id="total">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" class="form-control" name="amount_paid" step="0.01" value="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <select class="form-select" name="payment_method">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="transfer">Bank Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Sale</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Sale Modal -->
<div class="modal modal-blur fade" id="viewSaleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sale Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="saleDetails">
                <!-- Sale details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal modal-blur fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPaymentForm" action="actions/sale_actions.php" method="post">
                <input type="hidden" name="action" value="add_payment">
                <input type="hidden" name="sale_id" id="payment_sale_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = new DataTable('.table', {
        pageLength: 10,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Handle View Sale Modal
    const viewSaleModal = document.getElementById('viewSaleModal');
    if (viewSaleModal) {
        viewSaleModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const saleId = button.getAttribute('data-sale-id');
            
            // Load sale details
            fetch(`actions/get_sale_details.php?id=${saleId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('saleDetails').innerHTML = html;
                });
        });
    }

    // Handle Add Payment Modal
    const addPaymentModal = document.getElementById('addPaymentModal');
    if (addPaymentModal) {
        addPaymentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const saleId = button.getAttribute('data-sale-id');
            document.getElementById('payment_sale_id').value = saleId;
        });
    }

    // Handle New Sale Form
    const newSaleForm = document.getElementById('newSaleForm');
    if (newSaleForm) {
        // Add item row
        document.getElementById('addItemRow').addEventListener('click', function() {
            const tbody = document.querySelector('#itemsTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select class="form-select product-select" name="items[product_id][]" required>
                        <option value="">Select Product</option>
                        <!-- Products will be loaded via AJAX -->
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity-input" name="items[quantity][]" 
                           min="1" step="0.01" required>
                </td>
                <td>
                    <input type="number" class="form-control price-input" name="items[price][]" 
                           step="0.01" required readonly>
                </td>
                <td>₦<span class="row-total">0.00</span></td>
                <td>
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" 
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" 
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            
            // Load products for the new row
            loadProducts(row.querySelector('.product-select'));
        });

        // Calculate totals
        function calculateTotals() {
            let subtotal = 0;
            document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const total = quantity * price;
                row.querySelector('.row-total').textContent = total.toFixed(2);
                subtotal += total;
            });

            const tax = 0; // Calculate tax if needed
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
        }

        // Load products function
        function loadProducts(select) {
            fetch('actions/get_products.php')
                .then(response => response.json())
                .then(products => {
                    products.forEach(product => {
                        const option = new Option(
                            `${product.name} (${product.quantity} ${product.unit_type} available)`, 
                            product.id
                        );
                        option.dataset.price = product.selling_price;
                        select.appendChild(option);
                    });
                });
        }

        // Handle product selection
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const row = e.target.closest('tr');
                const option = e.target.selectedOptions[0];
                if (option.dataset.price) {
                    row.querySelector('.price-input').value = option.dataset.price;
                    calculateTotals();
                }
            }
        });

        // Handle quantity changes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                calculateTotals();
            }
        });

        // Remove row function
        window.removeRow = function(button) {
            button.closest('tr').remove();
            calculateTotals();
        };

        // Form submission
        newSaleForm.addEventListener('submit', function(e) {
            if (!newSaleForm.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            newSaleForm.classList.add('was-validated');
        });
    }

    // Print invoice function
    window.printInvoice = function(saleId) {
        window.open(`print_invoice.php?id=${saleId}`, '_blank');
    };
});
</script>

<?php include 'templates/footer.php'; ?>
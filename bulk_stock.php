<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/functions.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Bulk Stock Update";
$currentPage = "bulk_stock";

// Get database connection
$db = Database::getInstance()->getConnection();

// Initialize variables
$products = [];
$categories = [];
$error = '';
$success = '';

try {
    // Fetch categories for filter
    $stmt = $db->query("SELECT * FROM categories ORDER BY name");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all active products
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE p.status = 'active'
              ORDER BY p.name";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

include 'templates/header.php';
?>

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Bulk Stock Update</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="products.php" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                            </svg>
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form action="actions/bulk_stock_update.php" method="post" class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Multiple Products Stock</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter" id="bulkStockTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Current Stock</th>
                                    <th>New Stock</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar me-2 bg-primary-lt">
                                                    <?= strtoupper(substr($product['name'], 0, 2)) ?>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium"><?= htmlspecialchars($product['name']) ?></div>
                                                    <div class="text-muted"><?= htmlspecialchars($product['code']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= number_format($product['quantity'], 2) ?> <?= htmlspecialchars($product['unit_type']) ?>
                                            <input type="hidden" name="products[<?= $product['id'] ?>][current_stock]" value="<?= $product['quantity'] ?>">
                                            <input type="hidden" name="products[<?= $product['id'] ?>][unit_type]" value="<?= $product['unit_type'] ?>">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="products[<?= $product['id'] ?>][new_stock]" step="0.01">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="products[<?= $product['id'] ?>][notes]" placeholder="Optional notes">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize DataTable
    new DataTable('#bulkStockTable', {
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>

<?php include 'templates/footer.php'; ?>

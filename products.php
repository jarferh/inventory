<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/functions.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Products Management";
$currentPage = "products";

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

    // Handle search and filters
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    $status = $_GET['status'] ?? '';

    // Build query
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE 1=1";
    $params = [];

    if ($search) {
        $query .= " AND (p.name LIKE ? OR p.code LIKE ? OR p.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    if ($category) {
        $query .= " AND p.category_id = ?";
        $params[] = $category;
    }

    if ($status) {
        $query .= " AND p.status = ?";
        $params[] = $status;
    }

    $query .= " ORDER BY p.created_at DESC";

    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
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
                        Products Management
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#addProductModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add New Product
                        </a>
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#addCategoryModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add Category
                        </a>
                        <!-- Add Stock Button -->
                        <a href="#" class="btn btn-success d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#addStockModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5" />
                                <path d="M12 12l8 -4.5" />
                                <path d="M12 12v9" />
                                <path d="M12 12l-8 -4.5" />
                            </svg>
                            Add Stock
                        </a>
                        <!-- Replace Add Stock button with Bulk Stock Update link -->
                        <a href="bulk_stock.php" class="btn btn-success d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5" />
                                <path d="M12 12l8 -4.5" />
                                <path d="M12 12v9" />
                                <path d="M12 12l-8 -4.5" />
                            </svg>
                            Bulk Stock Update
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

            <!-- Filter Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="get" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search"
                                value="<?= htmlspecialchars($search) ?>" placeholder="Search products...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Buying Price</th>
                                    <th>Selling Price</th>
                                    <th>Status</th>
                                    <th class="w-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['code']) ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar me-2 bg-primary-lt">
                                                    <?= strtoupper(substr($product['name'], 0, 2)) ?>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">
                                                        <?= htmlspecialchars($product['name']) ?></div>
                                                    <div class="text-muted">
                                                        <?= htmlspecialchars($product['category_name']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                                        <td>
                                            <?php
                                            $quantity = floatval($product['quantity']);
                                            $minStock = floatval($product['min_stock_level']);
                                            $stockClass = $quantity <= $minStock ? 'text-danger' : 'text-success';
                                            ?>
                                            <span class="<?= $stockClass ?>">
                                                <?= number_format($quantity, 2) ?>
                                                <?= htmlspecialchars($product['unit_type']) ?>
                                            </span>
                                        </td>
                                        <td>₦<?= number_format($product['buying_price'], 2) ?></td>
                                        <td>₦<?= number_format($product['selling_price'], 2) ?></td>
                                        <td>
                                            <span
                                                class="badge bg-<?= $product['status'] === 'active' ? 'success' : 'danger' ?>-lt">
                                                <?= ucfirst($product['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editProductModal"
                                                    data-product='<?= json_encode($product) ?>'>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-edit" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                        </path>
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                        </path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                </a>
                                                <a href="#" class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteProductModal"
                                                    data-product-id="<?= $product['id'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 7l16 0"></path>
                                                        <path d="M10 11l0 6"></path>
                                                        <path d="M14 11l0 6"></path>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                </a>
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
<!-- Edit Product Modal -->
<div class="modal modal-blur fade" id="editProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/product_actions.php" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Product Code</label>
                            <input type="text" class="form-control" name="code" id="edit_code" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Product Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Category</label>
                            <select class="form-select" name="category_id" id="edit_category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Unit Type</label>
                            <select class="form-select" name="unit_type" id="edit_unit_type" required>
                                <option value="piece">Piece</option>
                                <option value="kg">Kilogram</option>
                                <option value="liter">Liter</option>
                                <option value="box">Box</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label required">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="edit_quantity" step="0.01"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Minimum Stock Level</label>
                            <input type="number" class="form-control" name="min_stock_level" id="edit_min_stock_level"
                                step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="edit_status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Buying Price</label>
                            <input type="number" class="form-control" name="buying_price" id="edit_buying_price"
                                step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Selling Price</label>
                            <input type="number" class="form-control" name="selling_price" id="edit_selling_price"
                                step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Product Modal -->
<div class="modal modal-blur fade" id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductForm" action="actions/product_actions.php" method="post">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Product Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="code" id="product_code" required readonly>
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                        <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                        <rect x="5" y="11" width="1" height="2" />
                                        <line x1="10" y1="11" x2="10" y2="13" />
                                        <rect x="14" y="11" width="1" height="2" />
                                        <line x1="19" y1="11" x2="19" y2="13" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Product Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Category</label>
                            <div class="input-group">
                                <select class="form-select" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($categories as $category):
                                    ?>
                                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#addCategoryModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                    New
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Unit Type</label>
                            <select class="form-select" name="unit_type" required>
                                <option value="piece">Piece</option>
                                <option value="kg">Kilogram</option>
                                <option value="liter">Liter</option>
                                <option value="box">Box</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label required">Quantity</label>
                            <input type="number" class="form-control" name="quantity" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Minimum Stock Level</label>
                            <input type="number" class="form-control" name="min_stock_level" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Buying Price</label>
                            <input type="number" class="form-control" name="buying_price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Selling Price</label>
                            <input type="number" class="form-control" name="selling_price" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal modal-blur fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/product_actions.php" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="add_category">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                        <div class="invalid-feedback">Please provide a category name.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="category_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- <div class="modal modal-blur fade" id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/product_actions.php" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="add">
                <!-- Rest of your product form fields -->
</form>
</div>
</div>
</div> -->
<!-- Add Category Modal -->
<div class="modal modal-blur fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCategoryForm" action="actions/product_actions.php" method="post">
                <input type="hidden" name="action" value="add_category">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="category_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal modal-blur fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/product_actions.php" method="post">
                <input type="hidden" name="action" value="edit_category">
                <input type="hidden" name="category_id" id="edit_category_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Category Name</label>
                        <input type="text" class="form-control" name="category_name" id="edit_category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="category_description" id="edit_category_description"
                            rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Product Modal -->
<div class="modal modal-blur fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">Are you sure?</div>
                <div>You are about to delete this product. This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger ms-auto" id="confirmDelete">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="4" y1="7" x2="20" y2="7" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                    </svg>
                    Yes, delete product
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Add Stock Modal -->
<div class="modal modal-blur fade" id="addStockModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="actions/product_actions.php" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="add_stock">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Select Product</label>
                        <select class="form-select" name="product_id" required>
                            <option value="">Select a product...</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>"
                                    data-current-stock="<?= $product['quantity'] ?>"
                                    data-unit="<?= htmlspecialchars($product['unit_type']) ?>">
                                    <?= htmlspecialchars($product['name']) ?>
                                    (Current: <?= $product['quantity'] ?> <?= $product['unit_type'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Quantity to Add</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="quantity" step="0.01" required>
                            <span class="input-group-text unit-type">units</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Enter any notes about this stock addition"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Initialize DataTable and handle modals -->
<script>
    // Add this to your existing script section
    document.addEventListener('DOMContentLoaded', function() {
        // Handle unit type display in Add Stock modal
        const stockModal = document.getElementById('addStockModal');
        if (stockModal) {
            const productSelect = stockModal.querySelector('select[name="product_id"]');
            const unitSpan = stockModal.querySelector('.unit-type');

            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const unit = selectedOption.getAttribute('data-unit');
                unitSpan.textContent = unit || 'units';
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Add this at the beginning of your DOMContentLoaded event listener
        const CURRENT_TIME = '2025-03-10 13:05:04';
        const CURRENT_USER = 'jarferh';

        // Handle Add Product Modal
        const addProductModal = document.getElementById('addProductModal');
        if (addProductModal) {
            // Generate product code when modal opens
            addProductModal.addEventListener('show.bs.modal', function(event) {
                const productCodeInput = document.getElementById('product_code');

                // Show loading state
                productCodeInput.value = 'Generating...';
                productCodeInput.disabled = true;

                // Generate new product code
                fetch('actions/generate_product_code.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.code) {
                            productCodeInput.value = data.code;
                        } else {
                            throw new Error(data.error || 'Failed to generate product code');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Fallback code generation
                        const timestamp = Date.now();
                        const fallbackCode = 'PRD' + timestamp.toString().slice(-6);
                        productCodeInput.value = fallbackCode;
                        // Show error message but don't prevent form submission
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-warning alert-dismissible fade show mt-2';
                        alertDiv.innerHTML = `
                    Warning: Using fallback product code. The system will still work.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                        productCodeInput.parentNode.appendChild(alertDiv);
                    })
                    .finally(() => {
                        productCodeInput.disabled = false;
                    });
            });

            // Handle form submission
            const addProductForm = document.getElementById('addProductForm');
            if (addProductForm) {
                addProductForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    formData.append('created_at', CURRENT_TIME);
                    formData.append('created_by', CURRENT_USER);

                    // Ensure we have a product code
                    if (!formData.get('code')) {
                        const timestamp = Date.now();
                        formData.set('code', 'PRD' + timestamp.toString().slice(-6));
                    }

                    fetch('actions/product_actions.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(result => {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(addProductModal);
                            modal.hide();

                            // Show success message
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                            alertDiv.innerHTML = `
                    Product added successfully
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                            document.querySelector('.container-xl').insertBefore(alertDiv, document.querySelector('.card'));

                            // Reload page after brief delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error adding product: ' + error.message);
                        });
                });
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add this at the top of your JavaScript code
        const CURRENT_TIME = '2025-03-10 13:12:07';
        const CURRENT_USER = 'jarferh';

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            const table = new DataTable('.table', {
                pageLength: 10,
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Log the current time and user for verification
            console.log('System Time:', CURRENT_TIME);
            console.log('Current User:', CURRENT_USER);

            // Rest of your existing code...
        });
        // Add this to your existing DOMContentLoaded event listener
        const addProductModal = document.getElementById('addProductModal');
        if (addProductModal) {
            addProductModal.addEventListener('show.bs.modal', function(event) {
                // Generate new product code
                fetch('actions/generate_product_code.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.code) {
                            document.getElementById('product_code').value = data.code;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
        // Handle Add Product Form
        const addProductForm = document.getElementById('addProductForm');
        if (addProductForm) {
            addProductForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('created_at', CURRENT_TIME);
                formData.append('created_by', CURRENT_USER);

                fetch('actions/product_actions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(result => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
                        modal.hide();
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error adding product: ' + error.message);
                    });
            });
        }

        // Handle Edit Product Modal
        const editProductModal = document.getElementById('editProductModal');
        if (editProductModal) {
            editProductModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const product = JSON.parse(button.getAttribute('data-product'));

                // Populate form fields
                const form = this.querySelector('form');
                form.querySelector('#edit_id').value = product.id;
                form.querySelector('#edit_code').value = product.code;
                form.querySelector('#edit_name').value = product.name;
                form.querySelector('#edit_category_id').value = product.category_id;
                form.querySelector('#edit_unit_type').value = product.unit_type;
                form.querySelector('#edit_quantity').value = product.quantity;
                form.querySelector('#edit_min_stock_level').value = product.min_stock_level;
                form.querySelector('#edit_buying_price').value = product.buying_price;
                form.querySelector('#edit_selling_price').value = product.selling_price;
                form.querySelector('#edit_status').value = product.status;
                form.querySelector('#edit_description').value = product.description || '';
            });

            // Handle Edit Form Submit
            const editForm = editProductModal.querySelector('form');
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('updated_at', CURRENT_TIME);
                formData.append('updated_by', CURRENT_USER);

                fetch('actions/product_actions.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(result => {
                        const modal = bootstrap.Modal.getInstance(editProductModal);
                        modal.hide();
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating product: ' + error.message);
                    });
            });
        }

        // Handle Delete Product
        const deleteProductModal = document.getElementById('deleteProductModal');
        if (deleteProductModal) {
            // Set product ID when delete modal opens
            deleteProductModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');
                document.getElementById('delete_product_id').value = productId;
            });

            // Handle delete form submission
            const deleteForm = document.getElementById('deleteProductForm');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(result => {
                            // Close the modal
                            const modal = bootstrap.Modal.getInstance(deleteProductModal);
                            modal.hide();

                            // Show success message
                            const successDiv = document.createElement('div');
                            successDiv.className = 'alert alert-success';
                            successDiv.textContent = 'Product deleted successfully';
                            document.querySelector('.container-xl').insertBefore(successDiv, document.querySelector('.card'));

                            // Reload the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting product: ' + error.message);
                        });
                });
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // Log form submission
                    console.log('Form submitted:', new FormData(form));
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Display session messages
        <?php if (isset($_SESSION['error'])): ?>
            alert('Error: <?= addslashes($_SESSION['error']) ?>');
        <?php unset($_SESSION['error']);
        endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            alert('Success: <?= addslashes($_SESSION['success']) ?>');
        <?php unset($_SESSION['success']);
        endif; ?>
    });
</script>
<?php
// Create the product actions handler
$productActionsFile = 'actions/product_actions.php';
if (!file_exists($productActionsFile)) {
    $productActionsContent = <<<'PHP'
<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add':
                // Validate input
                $required = ['code', 'name', 'category_id', 'unit_type', 'quantity', 'min_stock_level', 'buying_price', 'selling_price'];
                foreach ($required as $field) {
                    if (empty($_POST[$field])) {
                        throw new Exception("Field {$field} is required");
                    }
                }
                
                // Insert product
                $stmt = $db->prepare("
                    INSERT INTO products (code, name, category_id, unit_type, quantity, min_stock_level, 
                                       buying_price, selling_price, description, status, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                
                $stmt->execute([
                    $_POST['code'],
                    $_POST['name'],
                    $_POST['category_id'],
                    $_POST['unit_type'],
                    $_POST['quantity'],
                    $_POST['min_stock_level'],
                    $_POST['buying_price'],
                    $_POST['selling_price'],
                    $_POST['description'] ?? '',
                    $_POST['status'] ?? 'active'
                ]);
                
                $_SESSION['success'] = "Product added successfully";
                break;
                
            case 'edit':
                // Validate input
                if (empty($_POST['id'])) {
                    throw new Exception("Product ID is required");
                }
                
                // Update product
                $stmt = $db->prepare("
                    UPDATE products 
                    SET code = ?, name = ?, category_id = ?, unit_type = ?,
                        quantity = ?, min_stock_level = ?, buying_price = ?,
                        selling_price = ?, description = ?, status = ?,
                        updated_at = NOW()
                    WHERE id = ?
                ");
                
                $stmt->execute([
                    $_POST['code'],
                    $_POST['name'],
                    $_POST['category_id'],
                    $_POST['unit_type'],
                    $_POST['quantity'],
                    $_POST['min_stock_level'],
                    $_POST['buying_price'],
                    $_POST['selling_price'],
                    $_POST['description'] ?? '',
                    $_POST['status'] ?? 'active',
                    $_POST['id']
                ]);
                
                $_SESSION['success'] = "Product updated successfully";
                break;
                
            case 'delete':
                if (empty($_POST['id'])) {
                    throw new Exception("Product ID is required");
                }
                
                $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                
                $_SESSION['success'] = "Product deleted successfully";
                break;
                
            default:
                throw new Exception("Invalid action");
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header('Location: ../products.php');
exit;
PHP;
    file_put_contents($productActionsFile, $productActionsContent);
}

include 'templates/footer.php';
?>
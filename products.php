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
        $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
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
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add New Product
                        </a>
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add Category
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
                            <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search products...">
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                                    <div class="font-weight-medium"><?= htmlspecialchars($product['name']) ?></div>
                                                    <div class="text-muted"><?= htmlspecialchars($product['category_name']) ?></div>
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
                                                <?= number_format($quantity, 2) ?> <?= htmlspecialchars($product['unit_type']) ?>
                                            </span>
                                        </td>
                                        <td>₦<?= number_format($product['buying_price'], 2) ?></td>
                                        <td>₦<?= number_format($product['selling_price'], 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $product['status'] === 'active' ? 'success' : 'danger' ?>-lt">
                                                <?= ucfirst($product['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product='<?= json_encode($product) ?>'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                </a>
                                                <a href="#" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-product-id="<?= $product['id'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                            <input type="text" class="form-control" name="code" required>
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
                                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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


<!-- Add Product Modal -->
<div class="modal modal-blur fade" id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
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
</div>
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
                        <textarea class="form-control" name="category_description" id="edit_category_description" rows="3"></textarea>
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
                <form id="deleteProductForm" action="actions/product_actions.php" method="post">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="delete_product_id">
                    <button type="submit" class="btn btn-danger">Yes, delete product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Initialize DataTable and handle modals -->
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

        // Handle Edit Modal
        const editModal = document.getElementById('editProductModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const product = JSON.parse(button.getAttribute('data-product'));

                // Populate form fields
                document.getElementById('edit_id').value = product.id;
                document.getElementById('edit_code').value = product.code;
                document.getElementById('edit_name').value = product.name;
                // ... populate other fields
            });
        }

        // Handle Delete Modal
        const deleteModal = document.getElementById('deleteProductModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');
                document.getElementById('delete_product_id').value = productId;
            });
        }

        // Form Validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });

        // Success Message Auto-hide
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }, 3000);
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Add Category Form submission
        const addCategoryForm = document.getElementById('addCategoryForm');
        if (addCategoryForm) {
            addCategoryForm.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this)
                    })
                    .then(response => response.text())
                    .then(result => {
                        // Refresh the categories dropdown
                        fetch('actions/get_categories.php')
                            .then(response => response.json())
                            .then(categories => {
                                const select = document.querySelector('select[name="category_id"]');
                                select.innerHTML = '<option value="">Select Category</option>';
                                categories.forEach(category => {
                                    select.innerHTML += `<option value="${category.id}">${category.name}</option>`;
                                });
                            });

                        // Close modal and show success message
                        bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
                        this.reset();

                        // Show success message
                        const toast = new bootstrap.Toast(document.createElement('div'));
                        toast.show();
                    })
                    .catch(error => console.error('Error:', error));
            });
        }

        // Form validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                this.classList.add('was-validated');
            });
        });
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
    <?php unset($_SESSION['error']); endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
    alert('Success: <?= addslashes($_SESSION['success']) ?>');
    <?php unset($_SESSION['success']); endif; ?>
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
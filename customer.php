<?php
// Display errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'includes/Auth.php';
require_once 'includes/Database.php';
require_once 'config/config.php';

// Initialize auth
$auth = new Auth();
$auth->requireLogin();

// Get Database connection
$db = Database::getInstance()->getConnection();

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    
    switch ($action) {
        case 'add':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            
            if (empty($name)) {
                $message = 'Customer name is required';
                $messageType = 'danger';
            } else {
                try {
                    $sql = "INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute([$name, $email, $phone, $address]);
                    
                    if ($result) {
                        $message = 'Customer added successfully';
                        $messageType = 'success';
                    } else {
                        $message = 'Failed to add customer';
                        $messageType = 'danger';
                    }
                } catch (Exception $e) {
                    $message = 'Error: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            break;
            
        case 'edit':
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            
            if (empty($id) || empty($name)) {
                $message = 'Customer ID and name are required';
                $messageType = 'danger';
            } else {
                try {
                    $sql = "UPDATE customers SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute([$name, $email, $phone, $address, $id]);
                    
                    if ($result) {
                        $message = 'Customer updated successfully';
                        $messageType = 'success';
                    } else {
                        $message = 'Failed to update customer';
                        $messageType = 'danger';
                    }
                } catch (Exception $e) {
                    $message = 'Error: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            break;
            
        case 'delete':
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                $message = 'Customer ID is required';
                $messageType = 'danger';
            } else {
                try {
                    $sql = "DELETE FROM customers WHERE id = ?";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute([$id]);
                    
                    if ($result) {
                        $message = 'Customer deleted successfully';
                        $messageType = 'success';
                    } else {
                        $message = 'Failed to delete customer';
                        $messageType = 'danger';
                    }
                } catch (Exception $e) {
                    $message = 'Error: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            break;
    }
}

// Fetch all customers
try {
    $sql = "SELECT * FROM customers ORDER BY name ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $message = 'Error fetching customers: ' . $e->getMessage();
    $messageType = 'danger';
    $customers = [];
}

include 'templates/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'templates/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Customer Management</h1>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add New Customer</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Customer</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Customer List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($customers)): ?>
                                            <?php foreach ($customers as $customer): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                                <td><?php echo htmlspecialchars($customer['email'] ?? '-'); ?></td>
                                                <td><?php echo htmlspecialchars($customer['phone'] ?? '-'); ?></td>
                                                <td>
                                                    <form method="post" action="" class="d-inline">
                                                        <input type="hidden" name="action" value="edit">
                                                        <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="editCustomer(<?php echo htmlspecialchars(json_encode($customer)); ?>)">
                                                            <i class="bi bi-pencil"></i> Edit
                                                        </button>
                                                    </form>
                                                    <form method="post" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No customers found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm">
                    <input type="hidden" id="editCustomerId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Customer Name *</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="editPhone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editAddress" name="address" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditCustomer">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Include customer.js -->
<script src="assets/js/customer_new.js"></script>

<?php include 'templates/footer.php'; ?>

<div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<script>
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('#alertContainer').append(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('#alertContainer .alert:first-child').alert('close');
    }, 5000);
}
</script>

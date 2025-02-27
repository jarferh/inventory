<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/functions.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Set page variables
$pageTitle = "Settings";
$currentPage = "settings";

// Get database connection
$db = Database::getInstance()->getConnection();

// Get current user data
$userData = $auth->getCurrentUserData();

// Initialize messages
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// Get system settings
try {
    $stmt = $db->query("SELECT * FROM settings WHERE is_active = 1");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    error_log($e->getMessage());
    $settings = [];
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
                        Settings
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Profile Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Profile Settings</h3>
                        </div>
                        <div class="card-body">
                            <form action="actions/settings_actions.php" method="post" class="needs-validation" novalidate>
                                <input type="hidden" name="action" value="update_profile">
                                <div class="mb-3">
                                    <label class="form-label required">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($userData['full_name']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password (leave blank to keep current)</label>
                                    <input type="password" class="form-control" name="password" minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password_confirm">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php if ($auth->isAdmin()): ?>
                <div class="col-12 col-md-6">
                    <!-- System Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">System Settings</h3>
                        </div>
                        <div class="card-body">
                            <form action="actions/settings_actions.php" method="post">
                                <input type="hidden" name="action" value="update_system">
                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" 
                                           value="<?= htmlspecialchars($settings['company_name'] ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Company Address</label>
                                    <textarea class="form-control" name="company_address" rows="2"><?= htmlspecialchars($settings['company_address'] ?? '') ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" name="contact_email" 
                                           value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control" name="contact_phone" 
                                           value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Currency Symbol</label>
                                    <input type="text" class="form-control" name="currency_symbol" 
                                           value="<?= htmlspecialchars($settings['currency_symbol'] ?? '₦') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Low Stock Alert Threshold</label>
                                    <input type="number" class="form-control" name="low_stock_threshold" 
                                           value="<?= htmlspecialchars($settings['low_stock_threshold'] ?? '10') ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Save System Settings</button>
                            </form>
                        </div>
                    </div>

                    <!-- Backup & Maintenance -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Backup & Maintenance</h3>
                        </div>
                        <div class="card-body">
                            <form action="actions/settings_actions.php" method="post">
                                <input type="hidden" name="action" value="backup_db">
                                <p class="text-muted">Last backup: 
                                    <?= isset($settings['last_backup']) ? date('Y-m-d H:i:s', strtotime($settings['last_backup'])) : 'Never' ?>
                                </p>
                                <button type="submit" class="btn btn-primary mb-3">Create Database Backup</button>
                            </form>
                            
                            <form action="actions/settings_actions.php" method="post" class="mt-3">
                                <input type="hidden" name="action" value="clear_logs">
                                <p class="text-muted">Clear system logs older than:</p>
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <select name="days" class="form-select">
                                            <option value="30">30 days</option>
                                            <option value="60">60 days</option>
                                            <option value="90">90 days</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-warning">Clear Logs</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            // Password confirmation validation
            const password = form.querySelector('input[name="password"]');
            const confirmPassword = form.querySelector('input[name="password_confirm"]');
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                event.preventDefault();
                alert('Passwords do not match!');
                return false;
            }

            form.classList.add('was-validated');
        }, false);
    });
});
</script>

<?php include 'templates/footer.php'; ?>
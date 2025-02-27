<?php
$currentPage = $currentPage ?? '';
$currentUser = $_SESSION['username'] ?? 'musty131311';
$currentTime = '2025-02-18 18:14:59';
?>
<div class="sidebar bg-white">
    <!-- User Profile Section -->
    <div class="sidebar-header text-center p-3">
        <div class="user-profile mb-3">
            <div class="avatar-circle mx-auto mb-2">
                <i class="fas fa-user-circle fa-2x text-primary"></i>
            </div>
            <h6 class="mb-1"><?= htmlspecialchars($currentUser) ?></h6>
            <small class="text-muted"><?= htmlspecialchars($_SESSION['role'] ?? 'User') ?></small>
        </div>
        <div class="system-time small">
            <div class="text-muted">System Time (UTC)</div>
            <div class="fw-bold" id="sidebarTime"><?= $currentTime ?></div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a href="index.php" class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="sales.php" class="nav-link <?= $currentPage === 'sales' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart me-2"></i>
                <span>Sales</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="products.php" class="nav-link <?= $currentPage === 'products' ? 'active' : '' ?>">
                <i class="fas fa-box me-2"></i>
                <span>Products</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="customers.php" class="nav-link <?= $currentPage === 'customers' ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i>
                <span>Customers</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="inventory.php" class="nav-link <?= $currentPage === 'inventory' ? 'active' : '' ?>">
                <i class="fas fa-warehouse me-2"></i>
                <span>Inventory</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="reports.php" class="nav-link <?= $currentPage === 'reports' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar me-2"></i>
                <span>Reports</span>
            </a>
        </li>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="nav-item">
            <a href="settings.php" class="nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog me-2"></i>
                <span>Settings</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <!-- Bottom Info -->
    <div class="sidebar-footer p-3 text-center">
        <div class="small text-muted">
            <div>Samah Agrovet POS</div>
            <div>Version 2.0</div>
        </div>
    </div>
</div>

<style>
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 60px;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    z-index: 1000;
    overflow-y: auto;
}

.sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-link {
    padding: 12px 20px;
    color: #333;
    display: flex;
    align-items: center;
    transition: all 0.3s;
}

.nav-link:hover, .nav-link.active {
    background-color: #f8f9fa;
    color: #0d6efd;
    text-decoration: none;
}

.avatar-circle {
    width: 64px;
    height: 64px;
    background-color: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-footer {
    border-top: 1px solid #e9ecef;
    margin-top: auto;
}

.system-time {
    background-color: #f8f9fa;
    padding: 8px;
    border-radius: 6px;
}
</style>
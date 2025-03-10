<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required files if not already included
require_once __DIR__ . '/../includes/menu_config.php';
require_once __DIR__ . '/../includes/Auth.php';

// Initialize Auth
$auth = new Auth();

// Get user role and menu items
$userRole = $_SESSION['role'] ?? 'cashier';
$menuItems = getMenuByRole($userRole);

// Set current time
$CURRENT_TIME = date('Y-m-d H:i:s');
$CURRENT_USER = $_SESSION['username'] ?? 'Guest';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Sahama Agrovet POS</title>

    <!-- CSS files -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --tblr-primary: #206bc4;
            --tblr-primary-rgb: 32, 107, 196;
        }
        
        .navbar-vertical.navbar-dark {
            background: #1a2234;
            border-right: 1px solid rgba(98, 105, 118, 0.16);
        }
        
        .navbar-dark .navbar-brand {
            color: #ffffff;
        }
        
        .navbar-dark .nav-link {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .navbar-dark .nav-link:hover,
        .navbar-dark .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-vertical.navbar-dark .navbar-nav .nav-link.active:before {
            border-left-color: var(--tblr-primary);
        }
        
        .card {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 991.98px) {
            .navbar-vertical.navbar-expand-lg {
                position: fixed;
                top: 0;
                left: -18rem;
                bottom: 0;
                width: 18rem;
                transition: left 0.3s ease;
                z-index: 1050;
            }

            .navbar-vertical.navbar-expand-lg.show {
                left: 0;
            }

            .navbar-vertical.navbar-expand-lg + .page {
                margin-left: 0;
            }

            .navbar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.3);
                z-index: 1040;
                animation: fadeIn 0.2s ease;
                display: none;
            }

            .navbar-overlay.show {
                display: block;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="navbar-overlay"></div>
    <div class="page">
        <!-- Dark Sidebar -->
        <aside class="navbar navbar-vertical navbar-dark navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler ms-auto" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="index.php">
                        <span>Sahama Agrovet POS</span>
                    </a>
                </h1>
                <div class="navbar-collapse collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <?php if (isset($menuItems) && is_array($menuItems)): ?>
                            <?php foreach ($menuItems as $menuItem): ?>
                                <?php if ($auth->hasPermission($menuItem['permission'])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($currentPage === strtolower($menuItem['title'])) ? 'active' : '' ?>" 
                                           href="<?= htmlspecialchars($menuItem['link']) ?>">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <i class="ti ti-<?= htmlspecialchars($menuItem['icon']) ?>"></i>
                                            </span>
                                            <span class="nav-link-title"><?= htmlspecialchars($menuItem['title']) ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>


        <div class="page-wrapper">
            <!-- Top navbar -->
            <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
                <div class="container-xl">
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="d-none d-md-flex me-3">
                            <div class="nav-item px-3 py-2">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-clock me-2"></i>
                                    <span id="currentDateTime">
                                        <?= date('Y-m-d H:i:s') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm bg-primary-lt">
                                    <?= strtoupper(substr($_SESSION['username'], 0, 2)) ?>
                                </span>
                                <div class="d-none d-xl-block ps-2">
                                    <div class="fw-bold"><?= htmlspecialchars($_SESSION['username']) ?></div>
                                    <div class="mt-1 small text-muted"><?= ucfirst($_SESSION['role']) ?></div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="profile.php" class="dropdown-item">
                                    <i class="ti ti-user me-2"></i>Profile
                                </a>
                                <a href="settings.php" class="dropdown-item">
                                    <i class="ti ti-settings me-2"></i>Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="logout.php" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
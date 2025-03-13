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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Sahama Agrovet POS</title>

    <!-- CSS files -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet" />

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
                transition: all 0.3s ease-in-out;
                z-index: 1030;
                background: #1a2234;
            }

            .navbar-vertical.navbar-expand-lg.show {
                left: 0;
            }

            /* Remove overlay related styles */
            /*.navbar-overlay {
        display: none;
    }*/

            .navbar-collapse {
                transition: all 0.3s ease-in-out;
            }

            .navbar-collapse:not(.show) {
                display: none;
            }

            .navbar-collapse.show {
                display: block;
            }

            /* Ensure content remains clickable */
            .page-wrapper {
                position: relative;
                z-index: 1;
            }

            /* Ensure mobile header stays above content */
            header.navbar {
                position: sticky;
                top: 0;
                z-index: 1020;
                background: #1a2234;
            }
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                transition: all 0.3s ease-in-out;
            }

            .navbar-collapse:not(.show) {
                display: none;
            }

            .navbar-collapse.show {
                display: block;
            }

            /* Prevent body scroll when menu is open */
            body.navbar-open {
                overflow: hidden;
            }
        }

        .navbar-dark {
            background: #1a2234;
        }

        .navbar-vertical.navbar-dark {
            border-right: 1px solid rgba(98, 105, 118, 0.16);
        }

        @media (min-width: 992px) {
            .navbar-vertical.navbar-expand-lg {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 15rem;
                z-index: 1030;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Desktop Sidebar - Only visible on lg screens and up -->
        <aside class="navbar navbar-vertical navbar-dark navbar-expand-lg d-none d-lg-flex">
            <div class="container-fluid">
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="index.php">
                        <span>Sahama Agrovet POS</span>
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu-desktop">
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

        <!-- Mobile Header and Navigation -->
        <div class="d-lg-none">
            <!-- Mobile Top Header -->
            <header class="navbar navbar-expand-md navbar-dark d-print-none">
                <div class="container-xl">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1 class="navbar-brand navbar-brand-autodark">
                        <a href="index.php">
                            <span>Sahama Agrovet POS</span>
                        </a>
                    </h1>
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm bg-primary-lt">
                                    <?= strtoupper(substr($_SESSION['username'], 0, 2)) ?>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="profile.php" class="dropdown-item">
                                    <i class="ti ti-user me-2"></i>Profile
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

            <!-- Mobile Navigation Menu -->
            <div class="navbar-expand-md">
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="navbar navbar-dark">
                        <div class="container-xl">
                            <ul class="navbar-nav">
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
                </div>
            </div>
        </div>

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Desktop Header -->
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
                                <div class="dropdown-divider"></div>
                                <a href="logout.php" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
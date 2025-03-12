<?php
function getMenuByRole($role)
{
    $defaultMenus = [
        [
            'title' => 'Dashboard',
            'icon' => 'dashboard',
            'link' => 'index.php',
            'permission' => 'view_dashboard'
        ]
    ];

    $menus = [
        'admin' => [
            [
                'title' => 'Dashboard',
                'icon' => 'dashboard',
                'link' => 'index.php',
                'permission' => 'view_dashboard'
            ],
            [
                'title' => 'Products',
                'icon' => 'package',
                'link' => 'products.php',
                'permission' => 'manage_products'
            ],
            [
                'title' => 'Sales',
                'icon' => 'shopping-cart',
                'link' => 'sales.php',
                'permission' => 'manage_sales'
            ],
            [
                'title' => 'Reports',
                'icon' => 'report-analytics',
                'link' => 'reports.php',
                'permission' => 'view_reports'
            ],
            [
                'title' => 'Users',
                'icon' => 'users',
                'link' => 'users.php',
                'permission' => 'manage_users'
            ],
            [
                'title' => 'Profile',
                'icon' => 'ti ti-user',
                'link' => 'profile.php',
                'permission' => 'profile'
            ],
            [
                'title' => 'Settings',
                'icon' => 'settings',
                'link' => 'settings.php',
                'permission' => 'manage_settings'
            ]
        ],
        'manager' => [
            [
                'title' => 'Dashboard',
                'icon' => 'dashboard',
                'link' => 'index.php',
                'permission' => 'view_dashboard'
            ],
            [
                'title' => 'Products',
                'icon' => 'package',
                'link' => 'products.php',
                'permission' => 'manage_products'
            ],
            [
                'title' => 'Sales',
                'icon' => 'shopping-cart',
                'link' => 'sales.php',
                'permission' => 'manage_sales'
            ],
            [
                'title' => 'Reports',
                'icon' => 'report-analytics',
                'link' => 'reports.php',
                'permission' => 'view_reports'
            ],
            [
                'title' => 'Profile',
                'icon' => 'ti ti-user',
                'link' => 'profile.php',
                'permission' => 'profile'
            ]
        ],
        'cashier' => [
            [
                'title' => 'Dashboard',
                'icon' => 'dashboard',
                'link' => 'index.php',
                'permission' => 'view_dashboard'
            ],
            [
                'title' => 'Sales',
                'icon' => 'shopping-cart',
                'link' => 'sales.php',
                'permission' => 'manage_sales'
            ],
            [
                'title' => 'Profile',
                'icon' => 'ti ti-user',
                'link' => 'profile.php',
                'permission' => 'profile'
            ]
        ]
    ];

    return $menus[$role] ?? $defaultMenus;
}

// Function to check if menu item should be visible
function shouldShowMenuItem($menuItem, $currentUserPermissions)
{
    return isset($menuItem['permission']) &&
        in_array($menuItem['permission'], $currentUserPermissions);
}

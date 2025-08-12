<?php
function getMenuByRole($role)
{
    $defaultMenus = [
        [
            'title' => 'Dashboard',
            'icon' => 'ti ti-dashboard',
            'link' => 'index.php',
            'permission' => 'view_dashboard'
        ],
        [
            'title' => 'Customers',
            'icon' => 'ti ti-users',
            'link' => 'customer.php',
            'permission' => 'manage_customers'
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
                'icon' => 'ti ti-package',
                'link' => 'products.php',
                'permission' => 'manage_products'
            ],
            [
                'title' => 'Sales',
                'icon' => 'ti ti-shopping-cart',
                'link' => 'sales.php',
                'permission' => 'manage_sales'
            ],
            [
                'title' => 'Proforma Invoice',
                'icon' => 'report-analytics',
                'link' => 'proforma_invoice.php',
                'permission' => 'proforma_invoice'
            ],
            [
                'title' => 'Reports',
                'icon' => 'ti ti-report-analytics',
                'link' => 'reports.php',
                'permission' => 'view_reports'
            ],
            [
                'title' => 'Users',
                'icon' => 'ti ti-users',
                'link' => 'users.php',
                'permission' => 'manage_users'
            ],
            [
                'title' => 'Customers',
                'icon' => 'ti ti-users',

                'link' => 'customer.php',
                'permission' => 'manage_customers'
            ],
            [
                'title' => 'Profile',
                'icon' => 'ti ti-user',
                'link' => 'profile.php',
                'permission' => 'profile'
            ],
            [
                'title' => 'Settings',
                'icon' => 'ti ti-settings',
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
                'title' => 'Proforma Invoice',
                'icon' => 'shopping-cart',
                'link' => 'proforma_invoice.php',
                'permission' => 'proforma_invoice'
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
            ],
            [
                'title' => 'Customers',
                'icon' => 'ti ti-users',
                'link' => 'customer.php',
                'permission' => 'manage_customers'
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
                'title' => 'Proforma Invoice',
                'icon' => 'shopping-cart',
                'link' => 'proforma_invoice.php',
                'permission' => 'proforma_invoice'
            ],
            [
                'title' => 'Profile',
                'icon' => 'ti ti-user',
                'link' => 'profile.php',
                'permission' => 'profile'
            ],
            [
                'title' => 'Customers',
                'icon' => 'ti ti-users',

                'link' => 'customer.php',
                'permission' => 'manage_customers'
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

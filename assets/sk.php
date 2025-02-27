<?php
require_once '../config/config.php';
require_once '../includes/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // First, ensure roles exist
    $roles = [
        ['name' => 'admin', 'permissions' => json_encode([
            'view_dashboard', 'manage_users', 'manage_products', 
            'manage_sales', 'view_reports', 'manage_settings'
        ])],
        ['name' => 'manager', 'permissions' => json_encode([
            'view_dashboard', 'manage_products', 'manage_sales', 'view_reports'
        ])],
        ['name' => 'cashier', 'permissions' => json_encode([
            'view_dashboard', 'manage_sales', 'view_products'
        ])]
    ];

    foreach ($roles as $role) {
        $db->prepare("
            INSERT INTO roles (name, permissions) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE permissions = VALUES(permissions)
        ")->execute([$role['name'], $role['permissions']]);
    }

    // Get role IDs
    $roleIds = [];
    $stmt = $db->query("SELECT id, name FROM roles");
    while ($row = $stmt->fetch()) {
        $roleIds[$row['name']] = $row['id'];
    }

    // Initial users
    $users = [
        [
            'username' => 'admin',
            'password' => 'Admin@123',
            'email' => 'admin@samahagrovet.com',
            'full_name' => 'System Administrator',
            'role_id' => $roleIds['admin'],
            'status' => 'active'
        ],
        [
            'username' => 'manager',
            'password' => 'Manager@123',
            'email' => 'manager@samahagrovet.com',
            'full_name' => 'Store Manager',
            'role_id' => $roleIds['manager'],
            'status' => 'active'
        ],
        [
            'username' => 'cashier1',
            'password' => 'Cashier@123',
            'email' => 'cashier1@samahagrovet.com',
            'full_name' => 'First Cashier',
            'role_id' => $roleIds['cashier'],
            'status' => 'active'
        ],
        [
            'username' => 'cashier2',
            'password' => 'Cashier@123',
            'email' => 'cashier2@samahagrovet.com',
            'full_name' => 'Second Cashier',
            'role_id' => $roleIds['cashier'],
            'status' => 'active'
        ]
    ];

    // Insert users
    $stmt = $db->prepare("
        INSERT INTO users (
            username, password, email, full_name, 
            role_id, status, created_at
        ) VALUES (
            :username, :password, :email, :full_name, 
            :role_id, :status, NOW()
        ) ON DUPLICATE KEY UPDATE
        email = VALUES(email),
        full_name = VALUES(full_name),
        role_id = VALUES(role_id),
        status = VALUES(status)
    ");

    foreach ($users as $user) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $stmt->execute($user);
        echo "Created/Updated user: {$user['username']}\n";
    }

    echo "\nInitial users created successfully!\n";
    echo "\nLogin credentials:\n";
    echo "Admin: admin / Admin@123\n";
    echo "Manager: manager / Manager@123\n";
    echo "Cashier1: cashier1 / Cashier@123\n";
    echo "Cashier2: cashier2 / Cashier@123\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
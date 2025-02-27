<?php
header('Content-Type: application/json');
session_start();

require_once '../../config/database.php';
require_once '../../includes/auth.php';

// System values
$CURRENT_TIME = "2025-02-21 18:44:29";
$CURRENT_USER = $_SESSION['username'] ?? "musty131311";

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate required fields
    $required_fields = ['name', 'code', 'category_id', 'unit', 'buying_price', 'selling_price', 'quantity', 'min_stock_level'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Field '$field' is required");
        }
    }

    // Check if product code already exists
    $stmt = $db->prepare("SELECT id FROM products WHERE code = ?");
    $stmt->execute([$_POST['code']]);
    if ($stmt->fetch()) {
        throw new Exception("Product code already exists");
    }

    // Insert new product
    $sql = "INSERT INTO products (
        name, code, category_id, description,
        buying_price, selling_price, quantity,
        min_stock_level, unit, barcode,
        created_at, created_by
    ) VALUES (
        :name, :code, :category_id, :description,
        :buying_price, :selling_price, :quantity,
        :min_stock_level, :unit, :barcode,
        :created_at, :created_by
    )";

    $stmt = $db->prepare($sql);
    
    $stmt->execute([
        'name' => $_POST['name'],
        'code' => $_POST['code'],
        'category_id' => $_POST['category_id'],
        'description' => $_POST['description'] ?? '',
        'buying_price' => $_POST['buying_price'],
        'selling_price' => $_POST['selling_price'],
        'quantity' => $_POST['quantity'],
        'min_stock_level' => $_POST['min_stock_level'],
        'unit' => $_POST['unit'],
        'barcode' => $_POST['barcode'] ?? '',
        'created_at' => $CURRENT_TIME,
        'created_by' => $CURRENT_USER
    ]);

    // Log activity
    $activity_sql = "INSERT INTO activity_logs (
        action, description, created_at, created_by
    ) VALUES (
        'create_product',
        :description,
        :created_at,
        :created_by
    )";

    $stmt = $db->prepare($activity_sql);
    $stmt->execute([
        'description' => "Created new product: {$_POST['name']}",
        'created_at' => $CURRENT_TIME,
        'created_by' => $CURRENT_USER
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Product added successfully',
        'product_id' => $db->lastInsertId()
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
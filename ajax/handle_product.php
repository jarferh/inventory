<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Current system values
$CURRENT_TIME = "2025-02-18 20:04:51";
$CURRENT_USER = "musty131311";

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

try {
    $db = Database::getInstance()->getConnection();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'create':
                $stmt = $db->prepare("
                    INSERT INTO products (
                        name, code, description, quantity, 
                        buying_price, selling_price, min_stock_level, 
                        category_id, unit, barcode,
                        created_at, created_by
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $_POST['name'],
                    $_POST['code'],
                    $_POST['description'],
                    $_POST['quantity'],
                    $_POST['buying_price'],
                    $_POST['selling_price'],
                    $_POST['min_stock_level'],
                    $_POST['category_id'],
                    $_POST['unit'],
                    $_POST['barcode'],
                    $CURRENT_TIME,
                    $CURRENT_USER
                ]);

                // Log the activity
                logActivity('product_create', "Created new product: {$_POST['name']}", $CURRENT_TIME, $CURRENT_USER);

                $response['success'] = true;
                $response['message'] = 'Product created successfully';
                break;

            case 'update':
                $stmt = $db->prepare("
                    UPDATE products SET 
                        name = ?, 
                        code = ?,
                        description = ?,
                        buying_price = ?,
                        selling_price = ?,
                        min_stock_level = ?,
                        category_id = ?,
                        unit = ?,
                        barcode = ?,
                        updated_at = ?,
                        updated_by = ?
                    WHERE id = ?
                ");

                $stmt->execute([
                    $_POST['name'],
                    $_POST['code'],
                    $_POST['description'],
                    $_POST['buying_price'],
                    $_POST['selling_price'],
                    $_POST['min_stock_level'],
                    $_POST['category_id'],
                    $_POST['unit'],
                    $_POST['barcode'],
                    $CURRENT_TIME,
                    $CURRENT_USER,
                    $_POST['id']
                ]);

                logActivity('product_update', "Updated product: {$_POST['name']}", $CURRENT_TIME, $CURRENT_USER);

                $response['success'] = true;
                $response['message'] = 'Product updated successfully';
                break;

            case 'adjust_stock':
                $db->beginTransaction();

                try {
                    // Get current stock
                    $stmt = $db->prepare("SELECT quantity, name FROM products WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                    $product = $stmt->fetch();

                    $newQuantity = $product['quantity'] + $_POST['adjustment_quantity'];

                    // Update product stock
                    $stmt = $db->prepare("
                        UPDATE products SET 
                            quantity = ?,
                            updated_at = ?,
                            updated_by = ?
                        WHERE id = ?
                    ");

                    $stmt->execute([
                        $newQuantity,
                        $CURRENT_TIME,
                        $CURRENT_USER,
                        $_POST['id']
                    ]);

                    // Record stock adjustment
                    $stmt = $db->prepare("
                        INSERT INTO stock_adjustments (
                            product_id, quantity_changed, reason, 
                            previous_quantity, new_quantity,
                            created_at, created_by
                        ) VALUES (?, ?, ?, ?, ?, ?, ?)
                    ");

                    $stmt->execute([
                        $_POST['id'],
                        $_POST['adjustment_quantity'],
                        $_POST['reason'],
                        $product['quantity'],
                        $newQuantity,
                        $CURRENT_TIME,
                        $CURRENT_USER
                    ]);

                    logActivity(
                        'stock_adjust',
                        "Adjusted stock for {$product['name']}: {$_POST['adjustment_quantity']} units",
                        $CURRENT_TIME,
                        $CURRENT_USER
                    );

                    $db->commit();
                    $response['success'] = true;
                    $response['message'] = 'Stock adjusted successfully';
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
                break;

            case 'delete':
                $stmt = $db->prepare("SELECT name FROM products WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $product = $stmt->fetch();

                $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
                $stmt->execute([$_POST['id']]);

                logActivity(
                    'product_delete', 
                    "Deleted product: {$product['name']}", 
                    $CURRENT_TIME, 
                    $CURRENT_USER
                );

                $response['success'] = true;
                $response['message'] = 'Product deleted successfully';
                break;
        }
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Error: ' . $e->getMessage();
    error_log($e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);
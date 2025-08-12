<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);

header('Content-Type: application/json');

require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    if (empty($_POST['id'])) {
        throw new Exception('Product ID is required');
    }

    $db->beginTransaction();

    // Check if product exists and if it has any sales
    $stmt = $db->prepare("
        SELECT p.id, 
               CASE WHEN si.product_id IS NOT NULL THEN 1 ELSE 0 END as has_sales
        FROM products p
        LEFT JOIN sale_items si ON p.id = si.product_id
        WHERE p.id = ?
        LIMIT 1
    ");
    $stmt->execute([$_POST['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception('Product not found');
    }

    if ($product['has_sales']) {
        // If product has sales, perform soft delete
        $stmt = $db->prepare("UPDATE products SET status = 'deleted', updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$_POST['id']]);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Product has been marked as deleted because it has associated sales records'
            ]);
            $db->commit();
            exit;
        }
        throw new Exception('Failed to update product status');
    }

    // If no sales, proceed with hard delete
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $result = $stmt->execute([$_POST['id']]);

    if (!$result) {
        throw new Exception('Failed to delete product');
    }

    $db->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Product deleted successfully'
    ]);

} catch (Exception $e) {
    error_log("Error in delete_product.php: " . $e->getMessage());
    
    if ($db && $db->inTransaction()) {
        $db->rollBack();
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

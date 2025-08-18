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

    // Check for references in sale_items
    $stmt = $db->prepare("SELECT COUNT(*) FROM sale_items WHERE product_id = ?");
    $stmt->execute([$_POST['id']]);
    $saleItemsCount = (int)$stmt->fetchColumn();

    // Check for references in stock_history
    $stmt = $db->prepare("SELECT COUNT(*) FROM stock_history WHERE product_id = ?");
    $stmt->execute([$_POST['id']]);
    $stockHistoryCount = (int)$stmt->fetchColumn();

    if ($saleItemsCount > 0 || $stockHistoryCount > 0) {
        // Can't hard delete because of foreign key constraints — perform soft delete
        $stmt = $db->prepare("UPDATE products SET status = 'deleted', updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$_POST['id']]);

        if ($result) {
            $msg = 'Product has been marked as deleted';
            if ($saleItemsCount > 0) $msg .= ' (has associated sales)';
            if ($stockHistoryCount > 0) $msg .= ' (has stock history entries)';

            echo json_encode([
                'success' => true,
                'message' => $msg
            ]);
            $db->commit();
            exit;
        }

        throw new Exception('Failed to update product status');
    }

    // No references found — safe to hard delete
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

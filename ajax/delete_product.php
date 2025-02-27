<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

header('Content-Type: application/json');

session_start();
$auth = new Auth();

// Check if user is logged in and has admin rights
if (!$auth->isAdmin()) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Product ID is required']);
    exit;
}

try {
    $db = Database::getInstance()->getConnection();
    
    // Get current time in UTC
    $currentTime = gmdate('Y-m-d H:i:s');
    $userId = $_SESSION['user_id'];
    
    // Start transaction
    $db->beginTransaction();

    // Log the deletion
    $logStmt = $db->prepare("
        INSERT INTO activity_log (user_id, action, description, created_at)
        VALUES (?, 'delete_product', ?, ?)
    ");
    
    // Get product details before deletion
    $getStmt = $db->prepare("SELECT name, code FROM products WHERE id = ?");
    $getStmt->execute([$_POST['id']]);
    $product = $getStmt->fetch();

    if ($product) {
        // Delete the product
        $delStmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $delStmt->execute([$_POST['id']]);

        // Log the activity
        $description = "Deleted product: {$product['name']} ({$product['code']})";
        $logStmt->execute([$userId, $description, $currentTime]);

        $db->commit();
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Product not found');
    }
} catch (Exception $e) {
    $db->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Error deleting product']);
    error_log($e->getMessage());
}
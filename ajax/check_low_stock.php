<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Current system values
$CURRENT_TIME = "2025-02-18 20:04:51";
$CURRENT_USER = "musty131311";

$response = [
    'success' => false,
    'low_stock_items' => [],
    'message' => ''
];

try {
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->query("
        SELECT 
            id,
            name,
            quantity,
            min_stock_level,
            unit
        FROM products 
        WHERE quantity <= min_stock_level
        ORDER BY (quantity / min_stock_level) ASC
    ");
    
    $response['low_stock_items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true;
    
    // Log if low stock items found
    if (count($response['low_stock_items']) > 0) {
        logActivity(
            'low_stock_alert',
            "Low stock alert for " . count($response['low_stock_items']) . " items",
            $CURRENT_TIME,
            $CURRENT_USER
        );
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    error_log($e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);
<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Current system values
$CURRENT_TIME = "2025-02-18 20:04:51";
$CURRENT_USER = "musty131311";

$response = [
    'success' => false,
    'data' => null,
    'message' => ''
];

try {
    if (isset($_GET['id'])) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT 
                p.*,
                c.name as category_name,
                COALESCE(s.total_sold, 0) as total_sold,
                COALESCE(s.last_sale_date, 'Never') as last_sale_date
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN (
                SELECT 
                    product_id,
                    SUM(quantity) as total_sold,
                    MAX(created_at) as last_sale_date
                FROM sale_items si
                JOIN sales s ON si.sale_id = s.id
                GROUP BY product_id
            ) s ON p.id = s.product_id
            WHERE p.id = ?
        ");
        
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            $response['success'] = true;
            $response['data'] = $product;
        } else {
            $response['message'] = 'Product not found';
        }
    } else {
        $response['message'] = 'Product ID not provided';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    error_log($e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);
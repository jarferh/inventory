<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

header('Content-Type: application/json');

try {
    // Get database connection
    $db = Database::getInstance()->getConnection();
    
    // Fetch active products with their details and category names
    $query = "
        SELECT 
            p.*,
            c.name as category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = 'active'
        AND p.quantity > 0
        ORDER BY p.name ASC
    ";
    
    $stmt = $db->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format products for display
    $formattedProducts = array_map(function($product) {
        return [
            'id' => $product['id'],
            'code' => $product['code'],
            'name' => $product['name'],
            'category' => $product['category_name'],
            'unit_type' => $product['unit_type'],
            'quantity' => $product['quantity'],
            'selling_price' => $product['selling_price'],
            'buying_price' => $product['buying_price'],
            'display_name' => sprintf(
                "%s - %s (%s %s available) - ₦%s", 
                $product['code'],
                $product['name'],
                $product['quantity'],
                $product['unit_type'],
                number_format($product['selling_price'], 2)
            )
        ];
    }, $products);
    
    echo json_encode($formattedProducts);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
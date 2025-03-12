<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception('Sale ID is required');
    }

    $sale_id = $_GET['id'];

    // Get sale details with precise decimal handling
    $stmt = $db->prepare("
        SELECT 
            s.id,
            s.invoice_number,
            CAST(s.total_amount AS DECIMAL(10,2)) as total_amount,
            CAST(s.amount_paid AS DECIMAL(10,2)) as amount_paid,
            s.payment_status,
            s.payment_method,
            s.notes,
            CAST((s.total_amount - s.amount_paid) AS DECIMAL(10,2)) as remaining_amount
        FROM sales s
        WHERE s.id = ?
    ");
    
    $stmt->execute([$sale_id]);
    $sale = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sale) {
        throw new Exception('Sale not found');
    }

    echo json_encode($sale);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
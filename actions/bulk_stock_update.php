<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Get database connection
$db = Database::getInstance()->getConnection();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db->beginTransaction();
        
        foreach ($_POST['products'] as $productId => $data) {
            if (!empty($data['new_stock']) && is_numeric($data['new_stock'])) {
                // Get current stock
                $stmt = $db->prepare("SELECT quantity FROM products WHERE id = ?");
                $stmt->execute([$productId]);
                $currentStock = $stmt->fetchColumn();
                
                // Calculate new stock level (add to existing stock)
                $newStock = $currentStock + floatval($data['new_stock']);
                
                // Update product stock
                $stmt = $db->prepare("UPDATE products SET quantity = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$newStock, $productId]);
                
                // Log stock update
                $stmt = $db->prepare("
                    INSERT INTO stock_history (
                        product_id, 
                        previous_quantity,
                        new_quantity,
                        change_quantity,
                        change_type,
                        notes, 
                        created_by, 
                        created_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                
                $stmt->execute([
                    $productId,
                    $currentStock,
                    $newStock,
                    floatval($data['new_stock']),
                    'bulk_update',
                    $data['notes'] ?? 'Bulk stock update',
                    $_SESSION['user_id']
                ]);
            }
        }
        
        $db->commit();
        $_SESSION['success'] = "Stock levels updated successfully";
    }
} catch (Exception $e) {
    $db->rollBack();
    $_SESSION['error'] = "Error updating stock: " . $e->getMessage();
}

header('Location: ../bulk_stock.php');
exit;

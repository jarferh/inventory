<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
// At the top of product_actions.php, after the initial requires
error_log("Request received: " . print_r($_POST, true));

// Add this function for debugging
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'add_category':
                if (empty($_POST['category_name'])) {
                    throw new Exception("Category name is required");
                }

                $stmt = $db->prepare("
                    INSERT INTO categories (name, description, created_by)
                    VALUES (?, ?, ?)
                ");

                $stmt->execute([
                    $_POST['category_name'],
                    $_POST['category_description'] ?? '',
                    $_SESSION['user_id'] ?? 1
                ]);

                $_SESSION['success'] = "Category added successfully";
                break;

            case 'add':
                // Validate required fields
                $required = ['code', 'name', 'category_id', 'unit_type', 'quantity', 'min_stock_level', 'buying_price', 'selling_price'];
                foreach ($required as $field) {
                    if (empty($_POST[$field])) {
                        throw new Exception("Field {$field} is required");
                    }
                }

                $stmt = $db->prepare("
                    INSERT INTO products (
                        code, name, category_id, unit_type, quantity, 
                        min_stock_level, buying_price, selling_price, 
                        description, status, created_by
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $_POST['code'],
                    $_POST['name'],
                    $_POST['category_id'],
                    $_POST['unit_type'],
                    $_POST['quantity'],
                    $_POST['min_stock_level'],
                    $_POST['buying_price'],
                    $_POST['selling_price'],
                    $_POST['description'] ?? '',
                    $_POST['status'] ?? 'active',
                    $_SESSION['user_id'] ?? 1
                ]);

                $_SESSION['success'] = "Product added successfully";
                break;

            case 'edit':
                if (empty($_POST['id'])) {
                    throw new Exception("Product ID is required");
                }

                $stmt = $db->prepare("
                    UPDATE products 
                    SET code = ?, name = ?, category_id = ?, unit_type = ?,
                        quantity = ?, min_stock_level = ?, buying_price = ?,
                        selling_price = ?, description = ?, status = ?,
                        updated_at = NOW(), updated_by = ?
                    WHERE id = ?
                ");

                $stmt->execute([
                    $_POST['code'],
                    $_POST['name'],
                    $_POST['category_id'],
                    $_POST['unit_type'],
                    $_POST['quantity'],
                    $_POST['min_stock_level'],
                    $_POST['buying_price'],
                    $_POST['selling_price'],
                    $_POST['description'] ?? '',
                    $_POST['status'] ?? 'active',
                    $_SESSION['user_id'] ?? 1,
                    $_POST['id']
                ]);

                $_SESSION['success'] = "Product updated successfully";
                break;

            case 'delete':
                if (empty($_POST['id'])) {
                    throw new Exception("Product ID is required");
                }

                try {
                    // Start transaction
                    $db->beginTransaction();

                    // Check if product exists
                    $stmt = $db->prepare("SELECT id FROM products WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                    if (!$stmt->fetch()) {
                        throw new Exception("Product not found");
                    }

                    // Delete the product
                    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
                    $result = $stmt->execute([$_POST['id']]);

                    if (!$result) {
                        throw new Exception("Failed to delete product");
                    }

                    $db->commit();
                    $_SESSION['success'] = "Product deleted successfully";

                    // Return success response
                    http_response_code(200);
                    echo "Success";
                } catch (Exception $e) {
                    $db->rollBack();
                    http_response_code(500);
                    echo "Error: " . $e->getMessage();
                    exit;
                }
                break;
                case 'add_stock':
                    if (empty($_POST['product_id']) || !isset($_POST['quantity'])) {
                        throw new Exception("Product and quantity are required");
                    }
                    
                    // Start transaction
                    $db->beginTransaction();
                    try {
                        // Get current quantity
                        $stmt = $db->prepare("SELECT quantity FROM products WHERE id = ?");
                        $stmt->execute([$_POST['product_id']]);
                        $currentStock = $stmt->fetchColumn();
                        
                        if ($currentStock === false) {
                            throw new Exception("Product not found");
                        }
                        
                        // Calculate new stock level
                        $quantity = floatval($_POST['quantity']);
                        $newStock = $currentStock + $quantity;
                        
                        // Update product quantity
                        $stmt = $db->prepare("UPDATE products SET quantity = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$newStock, $_POST['product_id']]);
                        
                        // Log stock history
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
                            ) VALUES (?, ?, ?, ?, 'single_update', ?, ?, NOW())
                        ");
                        
                        $stmt->execute([
                            $_POST['product_id'],
                            $currentStock,
                            $newStock,
                            $quantity,
                            $_POST['notes'] ?? 'Stock update',
                            $_SESSION['user_id']
                        ]);
                        
                        $db->commit();
                        $_SESSION['success'] = "Stock updated successfully";
                    } catch (Exception $e) {
                        $db->rollBack();
                        throw $e;
                    }
                    break;
            case 'bulk_stock_update':
                if (empty($_POST['products'])) {
                    throw new Exception("No products selected for update");
                }

                // Create stock_history table if it doesn't exist
                $createTableSQL = file_get_contents(__DIR__ . '/../database/create_stock_history.sql');
                $db->exec($createTableSQL);

                $db->beginTransaction();
                try {
                    foreach ($_POST['products'] as $productData) {
                        if (empty($productData['quantity'])) {
                            continue; // Skip if no quantity provided
                        }

                        // Get current quantity
                        $stmt = $db->prepare("SELECT quantity FROM products WHERE id = ?");
                        $stmt->execute([$productData['id']]);
                        $currentQty = $stmt->fetchColumn();

                        // Calculate new quantity (adding to existing)
                        $newQty = $currentQty + floatval($productData['quantity']);

                        // Update product quantity
                        $stmt = $db->prepare("UPDATE products SET quantity = ?, updated_at = NOW() WHERE id = ?");
                        $stmt->execute([$newQty, $productData['id']]);

                        // Log stock update with proper fields
                        $stmt = $db->prepare("
                            INSERT INTO stock_history (
                                product_id, 
                                quantity_change,
                                quantity_before,
                                quantity_after,
                                notes, 
                                created_by
                            ) VALUES (?, ?, ?, ?, ?, ?)
                        ");
                        $stmt->execute([
                            $productData['id'],
                            $productData['quantity'],
                            $currentQty,
                            $newQty,
                            $productData['notes'] ?? 'Bulk stock update',
                            $_SESSION['user_id']
                        ]);
                    }
                    
                    $db->commit();
                    $_SESSION['success'] = "Stock levels updated successfully";
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
                break;

            default:
                throw new Exception("Invalid action");
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

// Redirect back
header('Location: ../products.php');
exit;

<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Debug log function
function debugLog($message, $data = null) {
    $logMessage = date('Y-m-d H:i:s') . " - " . $message;
    if ($data) {
        $logMessage .= " - Data: " . print_r($data, true);
    }
    error_log($logMessage . "\n", 3, "../logs/debug.log");
}

try {
    debugLog("Request Method: " . $_SERVER['REQUEST_METHOD']);
    debugLog("POST Data", $_POST);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        debugLog("Action: " . $action);
        
        switch ($action) {
            case 'add_category':
                debugLog("Processing add_category");
                if (empty($_POST['category_name'])) {
                    throw new Exception("Category name is required");
                }
                
                try {
                    // Check if category exists
                    $stmt = $db->prepare("SELECT id FROM categories WHERE name = ?");
                    $stmt->execute([$_POST['category_name']]);
                    if ($stmt->rowCount() > 0) {
                        throw new Exception("Category already exists");
                    }

                    // Insert category
                    $stmt = $db->prepare("
                        INSERT INTO categories (name, description, created_by)
                        VALUES (?, ?, ?)
                    ");
                    
                    $result = $stmt->execute([
                        $_POST['category_name'],
                        $_POST['category_description'] ?? '',
                        $_SESSION['user_id'] ?? 1
                    ]);

                    if (!$result) {
                        throw new Exception("Failed to insert category: " . implode(" ", $stmt->errorInfo()));
                    }

                    $_SESSION['success'] = "Category added successfully";
                    debugLog("Category added successfully", [
                        'id' => $db->lastInsertId(),
                        'name' => $_POST['category_name']
                    ]);
                    
                } catch (PDOException $e) {
                    debugLog("Database Error: " . $e->getMessage());
                    throw new Exception("Database error: " . $e->getMessage());
                }
                break;

            case 'add':
                debugLog("Processing add product");
                try {
                    // Validate required fields
                    $required = ['code', 'name', 'category_id', 'unit_type', 'quantity', 'min_stock_level', 'buying_price', 'selling_price'];
                    foreach ($required as $field) {
                        if (!isset($_POST[$field]) || $_POST[$field] === '') {
                            throw new Exception("Field {$field} is required");
                        }
                    }

                    // Check if product code exists
                    $stmt = $db->prepare("SELECT id FROM products WHERE code = ?");
                    $stmt->execute([$_POST['code']]);
                    if ($stmt->rowCount() > 0) {
                        throw new Exception("Product code already exists");
                    }

                    // Insert product
                    $stmt = $db->prepare("
                        INSERT INTO products (
                            code, name, category_id, unit_type, 
                            quantity, min_stock_level, buying_price, 
                            selling_price, description, status, 
                            created_by
                        ) VALUES (
                            ?, ?, ?, ?, 
                            ?, ?, ?, 
                            ?, ?, ?,
                            ?
                        )
                    ");
                    
                    $result = $stmt->execute([
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

                    if (!$result) {
                        throw new Exception("Failed to insert product: " . implode(" ", $stmt->errorInfo()));
                    }

                    $_SESSION['success'] = "Product added successfully";
                    debugLog("Product added successfully", [
                        'id' => $db->lastInsertId(),
                        'code' => $_POST['code']
                    ]);
                    
                } catch (PDOException $e) {
                    debugLog("Database Error: " . $e->getMessage());
                    throw new Exception("Database error: " . $e->getMessage());
                }
                break;
        }
    }
} catch (Exception $e) {
    debugLog("Error: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
}

// Debug the redirect
$redirect = $_SERVER['HTTP_REFERER'] ?? '../products.php';
debugLog("Redirecting to: " . $redirect);

// Redirect back
header('Location: ' . $redirect);
exit;
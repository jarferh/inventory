<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get database connection
$db = Database::getInstance()->getConnection();

// Debug log function
function debugLog($message, $data = null)
{
    $logMessage = date('Y-m-d H:i:s') . " - " . $message;
    if ($data) {
        $logMessage .= " - Data: " . print_r($data, true);
    }
    error_log($logMessage . "\n", 3, "../logs/sales_debug.log");
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        debugLog("Action received: " . $action);

        switch ($action) {
            case 'add':
                // Begin transaction
                $db->beginTransaction();

                try {
                    // Generate invoice number
                    $year = date('Y');
                    $month = date('m');
                    $stmt = $db->query("SELECT COUNT(*) FROM sales WHERE YEAR(created_at) = $year AND MONTH(created_at) = $month");
                    $count = $stmt->fetchColumn();
                    $invoice_number = sprintf("INV-%s%s-%04d", $year, $month, $count + 1);

                    // Validate items array
                    if (empty($_POST['items']['product_id']) || !is_array($_POST['items']['product_id'])) {
                        throw new Exception("No items selected");
                    }

                    // Calculate totals
                    $total_amount = 0;
                    $items = [];
                    foreach ($_POST['items']['product_id'] as $key => $product_id) {
                        $quantity = floatval($_POST['items']['quantity'][$key]);
                        $price = floatval($_POST['items']['price'][$key]);
                        $total_amount += ($quantity * $price);

                        // Validate stock availability
                        $stmt = $db->prepare("SELECT quantity FROM products WHERE id = ?");
                        $stmt->execute([$product_id]);
                        $current_stock = $stmt->fetchColumn();

                        if ($quantity > $current_stock) {
                            throw new Exception("Insufficient stock for product ID: $product_id");
                        }

                        $items[] = [
                            'product_id' => $product_id,
                            'quantity' => $quantity,
                            'selling_price' => $price
                        ];
                    }

                    // Insert sale record
                    $stmt = $db->prepare("
                        INSERT INTO sales (
                            invoice_number, customer_id, total_amount, 
                            amount_paid, payment_status, payment_method,
                            notes, created_by, created_at
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");

                    $stmt->execute([
                        $invoice_number,
                        $_POST['customer_id'] ?: null,
                        $total_amount,
                        $_POST['amount_paid'] ?? 0,
                        $_POST['payment_status'],
                        $_POST['payment_method'],
                        $_POST['notes'] ?? '',
                        $_SESSION['user_id']
                    ]);

                    $sale_id = $db->lastInsertId();

                    // Insert sale items and update stock
                    foreach ($items as $item) {
                        // Insert sale item
                        $stmt = $db->prepare("
                            INSERT INTO sale_items (
                                sale_id, product_id, quantity, 
                                selling_price, created_at
                            ) VALUES (?, ?, ?, ?, NOW())
                        ");

                        $stmt->execute([
                            $sale_id,
                            $item['product_id'],
                            $item['quantity'],
                            $item['selling_price']
                        ]);

                        // Update product stock
                        $stmt = $db->prepare("
                            UPDATE products 
                            SET quantity = quantity - ?, 
                                updated_at = NOW() 
                            WHERE id = ?
                        ");

                        $stmt->execute([
                            $item['quantity'],
                            $item['product_id']
                        ]);
                    }

                    // Commit transaction
                    $db->commit();
                    $_SESSION['success'] = "Sale completed successfully. Invoice: " . $invoice_number;
                    debugLog("Sale completed", ['invoice' => $invoice_number, 'amount' => $total_amount]);
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
                break;

            case 'add_payment':
                // Begin transaction
                $db->beginTransaction();

                try {
                    if (empty($_POST['sale_id']) || !isset($_POST['amount'])) {
                        throw new Exception("Sale ID and amount are required");
                    }

                    $sale_id = $_POST['sale_id'];
                    $payment_amount = floatval($_POST['amount']);
                    $current_time = '2025-03-12 13:08:12';

                    // Get current user ID from the users table
                    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
                    $stmt->execute(['jarferh']);
                    $current_user_id = $stmt->fetchColumn();

                    if (!$current_user_id) {
                        throw new Exception("User not found");
                    }

                    // Get current sale details
                    $stmt = $db->prepare("
                            SELECT 
                                id,
                                CAST(total_amount AS DECIMAL(10,2)) as total_amount,
                                CAST(amount_paid AS DECIMAL(10,2)) as amount_paid,
                                payment_status
                            FROM sales 
                            WHERE id = ?");
                    $stmt->execute([$sale_id]);
                    $sale = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$sale) {
                        throw new Exception("Sale not found");
                    }

                    // Calculate new amounts
                    $total_amount = floatval($sale['total_amount']);
                    $current_paid = floatval($sale['amount_paid']);
                    $new_amount_paid = $current_paid + $payment_amount;

                    // Validate payment
                    if ($payment_amount <= 0) {
                        throw new Exception("Payment amount must be greater than zero");
                    }

                    if ($new_amount_paid > $total_amount) {
                        throw new Exception("Payment amount exceeds remaining balance");
                    }

                    // Determine payment status
                    $payment_status = 'partial';
                    if ($new_amount_paid >= $total_amount) {
                        $payment_status = 'paid';
                        $new_amount_paid = $total_amount; // Ensure we don't exceed total
                    }

                    // Insert payment record
                    $stmt = $db->prepare("
                            INSERT INTO payments (
                                sale_id,
                                amount,
                                payment_method,
                                notes,
                                created_by,
                                created_at
                            ) VALUES (?, ?, ?, ?, ?, ?)
                        ");

                    $stmt->execute([
                        $sale_id,
                        $payment_amount,
                        $_POST['payment_method'],
                        $_POST['notes'] ?? '',
                        $current_user_id,
                        $current_time
                    ]);

                    // Update sale
                    $stmt = $db->prepare("
                            UPDATE sales 
                            SET 
                                amount_paid = ?,
                                payment_status = ?,
                                updated_at = ?
                            WHERE id = ?
                        ");

                    $stmt->execute([
                        $new_amount_paid,
                        $payment_status,
                        $current_time,
                        $sale_id
                    ]);

                    // Commit transaction
                    $db->commit();

                    // Clear any output buffered content
                    ob_clean();

                    // Send JSON response
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => sprintf(
                            "Payment of ₦%s added successfully. New balance: ₦%s",
                            number_format($payment_amount, 2),
                            number_format($total_amount - $new_amount_paid, 2)
                        ),
                        'new_status' => $payment_status,
                        'new_amount_paid' => $new_amount_paid,
                        'remaining' => $total_amount - $new_amount_paid
                    ]);
                    exit;
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
            default:
                throw new Exception("Invalid action");
        }
    }
} catch (Exception $e) {
    debugLog("Error: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
}

// Create payments table if it doesn't exist
try {
    $db->query("
        CREATE TABLE IF NOT EXISTS payments (
            id INT PRIMARY KEY AUTO_INCREMENT,
            sale_id INT NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            payment_method ENUM('cash','card','transfer') NOT NULL,
            notes TEXT,
            created_by INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sale_id) REFERENCES sales(id),
            FOREIGN KEY (created_by) REFERENCES users(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
} catch (Exception $e) {
    debugLog("Error creating payments table: " . $e->getMessage());
}

// Redirect back
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;

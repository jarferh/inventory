<?php
require_once '../config/config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();
$auth->requireAdmin();

// Get database connection
$db = Database::getInstance()->getConnection();

// Debug logging function
function debugLog($message, $data = null) {
    $log = date('Y-m-d H:i:s') . " - " . $message;
    if ($data) {
        $log .= " - Data: " . print_r($data, true);
    }
    error_log($log . "\n", 3, "../logs/user_actions.log");
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        debugLog("Action received", ['action' => $action, 'post_data' => $_POST]);
        
        switch ($action) {
            case 'add':
                // Validate required fields
                $required = ['username', 'full_name', 'email', 'password', 'role_id'];
                foreach ($required as $field) {
                    if (empty($_POST[$field])) {
                        throw new Exception("Field {$field} is required");
                    }
                }
                
                // Check if username or email already exists
                $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$_POST['username'], $_POST['email']]);
                if ($stmt->rowCount() > 0) {
                    throw new Exception("Username or email already exists");
                }
                
                // Hash password
                $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                
                // Insert user
                $stmt = $db->prepare("
                    INSERT INTO users (
                        username, full_name, email, password,
                        role_id, status, created_by, created_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                
                $stmt->execute([
                    $_POST['username'],
                    $_POST['full_name'],
                    $_POST['email'],
                    $password_hash,
                    $_POST['role_id'],
                    $_POST['status'] ?? 'active',
                    $_SESSION['user_id']
                ]);
                
                $_SESSION['success'] = "User added successfully";
                debugLog("User added successfully", ['user_id' => $db->lastInsertId()]);
                break;
                
            case 'edit':
                // Validate required fields
                if (empty($_POST['id'])) {
                    throw new Exception("User ID is required");
                }
                
                // Check if editing self
                if ($_POST['id'] == $_SESSION['user_id'] && $_POST['status'] == 'inactive') {
                    throw new Exception("You cannot deactivate your own account");
                }
                
                // Check if username or email already exists for other users
                $stmt = $db->prepare("
                    SELECT id FROM users 
                    WHERE (username = ? OR email = ?) 
                    AND id != ?
                ");
                $stmt->execute([
                    $_POST['username'],
                    $_POST['email'],
                    $_POST['id']
                ]);
                if ($stmt->rowCount() > 0) {
                    throw new Exception("Username or email already exists");
                }
                
                // Build update query
                $query = "
                    UPDATE users SET 
                        username = ?,
                        full_name = ?,
                        email = ?,
                        role_id = ?,
                        status = ?,
                        updated_at = NOW()
                ";
                $params = [
                    $_POST['username'],
                    $_POST['full_name'],
                    $_POST['email'],
                    $_POST['role_id'],
                    $_POST['status'] ?? 'active'
                ];
                
                // Add password to update if provided
                if (!empty($_POST['password'])) {
                    $query .= ", password = ?";
                    $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
                
                $query .= " WHERE id = ?";
                $params[] = $_POST['id'];
                
                // Update user
                $stmt = $db->prepare($query);
                $stmt->execute($params);
                
                $_SESSION['success'] = "User updated successfully";
                debugLog("User updated successfully", ['user_id' => $_POST['id']]);
                break;
                
            case 'delete':
                if (empty($_POST['id'])) {
                    throw new Exception("User ID is required");
                }
                
                // Prevent self-deletion
                if ($_POST['id'] == $_SESSION['user_id']) {
                    throw new Exception("You cannot delete your own account");
                }
                
                // Check if user exists
                $stmt = $db->prepare("SELECT role_id FROM users WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$user) {
                    throw new Exception("User not found");
                }
                
                // Check if user has any sales
                $stmt = $db->prepare("SELECT COUNT(*) FROM sales WHERE created_by = ?");
                $stmt->execute([$_POST['id']]);
                if ($stmt->fetchColumn() > 0) {
                    // If user has sales, just deactivate
                    $stmt = $db->prepare("
                        UPDATE users 
                        SET status = 'inactive', updated_at = NOW() 
                        WHERE id = ?
                    ");
                    $stmt->execute([$_POST['id']]);
                    $_SESSION['success'] = "User has been deactivated due to existing sales records";
                } else {
                    // If no sales, delete the user
                    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                    $_SESSION['success'] = "User deleted successfully";
                }
                debugLog("User action completed", ['user_id' => $_POST['id'], 'type' => 'delete']);
                break;
                
            default:
                throw new Exception("Invalid action");
        }
    }
} catch (Exception $e) {
    debugLog("Error in user action", ['error' => $e->getMessage()]);
    $_SESSION['error'] = $e->getMessage();
}

// Redirect back
header('Location: ../users.php');
exit;
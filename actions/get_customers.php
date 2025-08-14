<?php
require_once '../includes/Auth.php';
require_once '../includes/Database.php';
require_once '../config/config.php';

// Initialize auth
$auth = new Auth();
$auth->requireLogin();

// Get Database connection
$db = Database::getInstance()->getConnection();

try {
    // Fetch customers
    $stmt = $db->query("SELECT id, name, email, phone FROM customers ORDER BY name ASC");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($customers);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

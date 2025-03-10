<?php
require_once '../config/config.php';
require_once '../includes/Database.php';

header('Content-Type: application/json');

try {
    $db = Database::getInstance()->getConnection();
    
    // Get the latest product code
    $stmt = $db->query("SELECT code FROM products WHERE code REGEXP '^PRD[0-9]{6}$' ORDER BY code DESC LIMIT 1");
    $lastCode = $stmt->fetchColumn();
    
    if ($lastCode) {
        // Extract the number part and increment
        $number = intval(substr($lastCode, 3)) + 1;
    } else {
        // Start with 1 if no existing codes
        $number = 1;
    }
    
    // Generate new code (PRD + 6 digits)
    $newCode = 'PRD' . str_pad($number, 6, '0', STR_PAD_LEFT);
    
    echo json_encode([
        'success' => true,
        'code' => $newCode,
        'timestamp' => '2025-03-10 13:05:04',
        'user' => 'jarferh'
    ]);
} catch (Exception $e) {
    http_response_code(200); // Change to 200 to handle error in JavaScript
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
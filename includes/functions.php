<?php
// Get current UTC timestamp
function getCurrentUTCTime() {
    return gmdate(DATE_FORMAT);
}

// Format currency with Naira symbol
function formatCurrency($amount) {
    return CURRENCY . ' ' . number_format($amount, 2);
}

// Format date/time to system format
function formatDateTime($datetime) {
    if (!$datetime) {
        return '';
    }
    $date = new DateTime($datetime, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone(TIMEZONE));
    return $date->format(DATE_FORMAT);
}

// Get logged in user details
function getLoggedInUser() {
    return [
        'username' => $_SESSION['username'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'full_name' => $_SESSION['full_name'] ?? null,
        'id' => $_SESSION['user_id'] ?? null
    ];
}

// Sanitize output
function sanitize($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Generate unique invoice number
function generateInvoiceNumber() {
    return 'INV-' . date('Ymd') . '-' . substr(uniqid(), -5);
}

// Check if user has permission
// function hasPermission($permission) {
//     $auth = new Auth();
//     return $auth->checkPermission($permission);
// }

function canViewProfit() {
    // Get user's role from session
    $userRole = $_SESSION['role'] ?? '';
    $roleId = $_SESSION['role_id'] ?? 0;
    
    // Allow admin and manager roles
    $allowedRoles = ['admin', 'manager'];
    return in_array($userRole, $allowedRoles) || in_array($roleId, [1, 2]); // 1 for admin, 2 for manager
}

// Log system activity
function logActivity($action, $description) {
    $db = Database::getInstance()->getConnection();
    $userId = $_SESSION['user_id'] ?? null;
    $currentTime = getCurrentUTCTime();
    
    try {
        $stmt = $db->prepare("
            INSERT INTO activity_log (user_id, action, description, created_at)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $action, $description, $currentTime]);
    } catch (PDOException $e) {
        error_log("Error logging activity: " . $e->getMessage());
    }
}
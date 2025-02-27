<?php
require_once 'config/config.php';
require_once 'includes/Database.php';

session_start();

if (isset($_SESSION['user_id'])) {
    try {
        $db = Database::getInstance()->getConnection();
        
        // Log the logout
        $stmt = $db->prepare("
            INSERT INTO activity_log (user_id, action, description, ip_address)
            VALUES (?, 'logout', 'User logged out', ?)
        ");
        $stmt->execute([$_SESSION['user_id'], $_SERVER['REMOTE_ADDR']]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
}

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: login.php');
exit();
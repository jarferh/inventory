<?php
require_once '../config/config.php';
require_once '../includes/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Create profiles table if it doesn't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS profiles (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL UNIQUE,
            avatar VARCHAR(255) DEFAULT NULL,
            phone VARCHAR(20) DEFAULT NULL,
            address TEXT DEFAULT NULL,
            bio TEXT DEFAULT NULL,
            date_of_birth DATE DEFAULT NULL,
            gender ENUM('male', 'female', 'other') DEFAULT NULL,
            position VARCHAR(100) DEFAULT NULL,
            department VARCHAR(100) DEFAULT NULL,
            last_password_change TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            theme_preference VARCHAR(20) DEFAULT 'light',
            language_preference VARCHAR(10) DEFAULT 'en',
            notification_preferences JSON DEFAULT NULL,
            social_links JSON DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            INDEX idx_user_id (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    // Get all users without profiles
    $stmt = $db->query("
        SELECT u.id 
        FROM users u 
        LEFT JOIN profiles p ON u.id = p.user_id 
        WHERE p.id IS NULL
    ");
    
    $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Create profiles for users
    if (!empty($users)) {
        $stmt = $db->prepare("
            INSERT INTO profiles (user_id, created_at) 
            VALUES (?, '2025-03-12 14:19:47')
        ");

        foreach ($users as $user_id) {
            $stmt->execute([$user_id]);
        }

        echo "Created profiles for " . count($users) . " users.\n";
    } else {
        echo "No new profiles needed to be created.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
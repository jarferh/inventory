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
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'update_profile':
                // Validate required fields
                if (empty($_POST['full_name']) || empty($_POST['email'])) {
                    throw new Exception("Name and email are required");
                }

                // Start building query
                $query = "UPDATE users SET full_name = ?, email = ?, updated_at = NOW()";
                $params = [$_POST['full_name'], $_POST['email']];

                // Add password update if provided
                if (!empty($_POST['password'])) {
                    $query .= ", password = ?";
                    $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                $query .= " WHERE id = ?";
                $params[] = $_SESSION['user_id'];

                // Update user
                $stmt = $db->prepare($query);
                $stmt->execute($params);

                $_SESSION['success'] = "Profile updated successfully";
                break;

            case 'update_system':
                // Require admin privileges
                if (!$auth->isAdmin()) {
                    throw new Exception("Administrative privileges required");
                }

                // Update each setting
                $settings = [
                    'company_name',
                    'company_address',
                    'contact_email',
                    'contact_phone',
                    'currency_symbol',
                    'low_stock_threshold'
                ];

                foreach ($settings as $setting) {
                    if (isset($_POST[$setting])) {
                        $stmt = $db->prepare("
                            INSERT INTO settings (setting_key, setting_value, updated_by) 
                            VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE 
                            setting_value = VALUES(setting_value),
                            updated_by = VALUES(updated_by)
                        ");
                        $stmt->execute([$setting, $_POST[$setting], $_SESSION['user_id']]);
                    }
                }

                $_SESSION['success'] = "System settings updated successfully";
                break;

            case 'backup_db':
                // Require admin privileges
                if (!$auth->isAdmin()) {
                    throw new Exception("Administrative privileges required");
                }

                // Create backup directory if it doesn't exist
                $backupDir = '../backups';
                if (!is_dir($backupDir)) {
                    mkdir($backupDir, 0755, true);
                }

                // Generate backup filename
                $filename = $backupDir . '/backup_' . date('Y-m-d_H-i-s') . '.sql';

                // Create backup using mysqldump
                $command = sprintf(
                    'mysqldump -h %s -u %s -p%s %s > %s',
                    DB_HOST,
                    DB_USER,
                    DB_PASS,
                    DB_NAME,
                    $filename
                );

                exec($command, $output, $return);

                if ($return !== 0) {
                    throw new Exception("Database backup failed");
                }

                // Update last backup time
                $stmt = $db->prepare("
                    INSERT INTO settings (setting_key, setting_value, updated_by) 
                    VALUES ('last_backup', NOW(), ?)
                    ON DUPLICATE KEY UPDATE 
                    setting_value = VALUES(setting_value),
                    updated_by = VALUES(updated_by)
                ");
                $stmt->execute([$_SESSION['user_id']]);

                $_SESSION['success'] = "Database backup created successfully";
                break;

            case 'clear_logs':
                // Require admin privileges
                if (!$auth->isAdmin()) {
                    throw new Exception("Administrative privileges required");
                }

                $days = intval($_POST['days'] ?? 30);
                
                // Clear old logs
                $stmt = $db->prepare("
                    DELETE FROM activity_log 
                    WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)
                ");
                $stmt->execute([$days]);

                $_SESSION['success'] = "Old logs cleared successfully";
                break;

            default:
                throw new Exception("Invalid action");
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

// Redirect back
header('Location: ../settings.php');
exit;
<?php
require_once 'SystemConfig.php';

class ActivityLogger {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function log($action, $description, $data = null) {
        try {
            $systemValues = SystemConfig::getSystemValues();
            
            $stmt = $this->db->prepare("
                INSERT INTO activity_logs (
                    action, description, user_id, ip_address,
                    user_agent, additional_data, created_at, created_by
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $userId = $this->getUserId($systemValues['CURRENT_USER']);
            
            $stmt->execute([
                $action,
                $description,
                $userId,
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null,
                $data ? json_encode($data) : null,
                $systemValues['CURRENT_TIME'],
                $systemValues['CURRENT_USER']
            ]);

            return true;
        } catch (Exception $e) {
            error_log("Activity Log Error: " . $e->getMessage());
            return false;
        }
    }

    private function getUserId($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }
}
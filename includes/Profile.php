<?php
class Profile {
    private $db;
    private $user_id;

    public function __construct($user_id = null) {
        $this->db = Database::getInstance()->getConnection();
        $this->user_id = $user_id;
        $this->ensureProfileExists();
    }

    private function ensureProfileExists() {
        if ($this->user_id) {
            $stmt = $this->db->prepare("
                INSERT IGNORE INTO profiles (user_id, created_at) 
                VALUES (?, CURRENT_TIMESTAMP)
            ");
            $stmt->execute([$this->user_id]);
        }
    }

    public function getProfile($user_id = null) {
        $id = $user_id ?? $this->user_id;
        $stmt = $this->db->prepare("
            SELECT 
                p.*,
                u.username,
                u.full_name,
                u.email,
                u.role,
                u.status,
                u.last_login
            FROM profiles p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($data) {
        $allowedFields = [
            'phone', 'address', 'bio', 'date_of_birth', 
            'gender', 'position', 'department', 'theme_preference',
            'language_preference', 'notification_preferences', 'social_links'
        ];

        $updates = [];
        $params = [];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                if (in_array($field, ['notification_preferences', 'social_links'])) {
                    $updates[] = "$field = ?";
                    $params[] = json_encode($data[$field]);
                } else {
                    $updates[] = "$field = ?";
                    $params[] = $data[$field];
                }
            }
        }

        if (empty($updates)) {
            return false;
        }

        $params[] = $this->user_id;
        $query = "UPDATE profiles SET " . implode(', ', $updates) . " WHERE user_id = ?";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function updateAvatar($avatar_path) {
        $stmt = $this->db->prepare("
            UPDATE profiles 
            SET avatar = ? 
            WHERE user_id = ?
        ");
        return $stmt->execute([$avatar_path, $this->user_id]);
    }

    public function updatePassword($current_password, $new_password) {
        // Verify current password
        $stmt = $this->db->prepare("
            SELECT password 
            FROM users 
            WHERE id = ?
        ");
        $stmt->execute([$this->user_id]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current_password, $user['password'])) {
            return false;
        }

        // Update password
        $stmt = $this->db->prepare("
            UPDATE users 
            SET password = ? 
            WHERE id = ?
        ");
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        if ($stmt->execute([$hashed_password, $this->user_id])) {
            // Update last password change timestamp
            $stmt = $this->db->prepare("
                UPDATE profiles 
                SET last_password_change = CURRENT_TIMESTAMP 
                WHERE user_id = ?
            ");
            return $stmt->execute([$this->user_id]);
        }
        return false;
    }
}
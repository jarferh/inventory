<?php
class Auth {
    private $db;
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: index.php'); // Changed to index.php
            exit();
        }
        
        // Verify user exists and is active
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, r.name as role_name, r.permissions 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.id = ? AND u.status = 'active'
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                $this->logout();
                return false;
            }
            
            // Update session with fresh user data
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['permissions'] = json_decode($user['permissions'], true);
            
            // Log activity
            $this->logActivity('session_check', 'User session verified');
            
            return true;
        } catch (PDOException $e) {
            error_log("Auth Error: " . $e->getMessage());
            return false;
        }
    }

    public function requireAdmin() {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $_SESSION['error'] = "You don't have permission to access this page.";
            header('Location: index.php');
            exit;
        }
        return true;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin' &&
               $this->hasPermission('admin_access');
    }
    
    public function login($username, $password) {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, r.name as role_name, r.permissions 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.username = ? AND u.status = 'active'
            ");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $user['role_name'];
                $_SESSION['permissions'] = json_decode($user['permissions'], true);
                
                // Update last login timestamp
                $this->updateLastLogin($user['id']);
                
                // Log successful login
                $this->logActivity('login', 'User logged in successfully');
                return true;
            }
            
            // Log failed login attempt
            $this->logActivity('login_failed', "Failed login attempt for username: $username", null);
            return false;
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $this->logActivity('logout', 'User logged out');
        }
        
        session_unset();
        session_destroy();
        
        header('Location: index.php'); // Changed to index.php
        exit();
    }
    
    public function hasPermission($permission) {
        return isset($_SESSION['permissions']) && 
               in_array($permission, $_SESSION['permissions']);
    }

    private function updateLastLogin($userId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE users 
                SET last_login = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Update Last Login Error: " . $e->getMessage());
        }
    }
    
    private function logActivity($action, $description, $user_id = null) {
        try {
            if ($user_id === null && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
            }
            
            $stmt = $this->db->prepare("
                INSERT INTO activity_log (user_id, action, description, ip_address)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id,
                $action,
                $description,
                $_SERVER['REMOTE_ADDR']
            ]);
        } catch (PDOException $e) {
            error_log("Activity Log Error: " . $e->getMessage());
        }
    }

    // New helper methods for role and permission management
    public function getUserRoles() {
        try {
            $stmt = $this->db->query("SELECT * FROM roles ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get Roles Error: " . $e->getMessage());
            return [];
        }
    }

    public function getCurrentUserData() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return $_SESSION['user'] ?? null;
    }
}

// Make sure to have this SQL for the roles table if you haven't already:
/*
CREATE TABLE IF NOT EXISTS roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    permissions JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin role
INSERT INTO roles (name, permissions) VALUES 
('admin', '["admin_access", "manage_users", "manage_roles", "manage_products", "manage_sales", "view_reports"]'),
('user', '["manage_products", "manage_sales", "view_reports"]')
ON DUPLICATE KEY UPDATE permissions = VALUES(permissions);

-- Add last_login column to users table if not exists
ALTER TABLE users ADD COLUMN IF NOT EXISTS last_login TIMESTAMP NULL;
*/
<?php
require_once 'config/config.php';
require_once 'includes/Database.php';

session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    try {
        $db = Database::getInstance()->getConnection();
        
        // Get user with role information
        $stmt = $db->prepare("
            SELECT 
                u.*,
                r.name as role_name,
                r.permissions
            FROM users u
            JOIN roles r ON u.role_id = r.id
            WHERE u.username = ? AND u.status = 'active'
        ");
        
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Log successful login
            $stmt = $db->prepare("
                INSERT INTO activity_log (user_id, action, description, ip_address)
                VALUES (?, 'login', 'User logged in successfully', ?)
            ");
            $stmt->execute([$user['id'], $_SERVER['REMOTE_ADDR']]);
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['permissions'] = json_decode($user['permissions'], true);
            
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid username or password';
            
            // Log failed login attempt
            $stmt = $db->prepare("
                INSERT INTO activity_log (action, description, ip_address)
                VALUES ('login_failed', ?, ?)
            ");
            $stmt->execute(["Failed login attempt for username: $username", $_SERVER['REMOTE_ADDR']]);
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $error = 'An error occurred. Please try again later.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Login - Samah Agrovet POS</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet"/>
    <style>
        .login-bg {
            background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%);
        }
        .btn-login {
            padding: 0.75rem 1.25rem;
            font-weight: 500;
        }
        .login-wrapper {
            min-height: 100vh;
        }
        .auth-side-wrapper {
            background-image: url('assets/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="border-top-wide border-primary d-flex align-items-center">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login to your account</h2>
                    
                    <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 9v2m0 4v.01"></path>
                                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                                </svg>
                            </div>
                            <div><?= htmlspecialchars($error) ?></div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                    <?php endif; ?>
                    
                    <form method="post" action="" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                                <span class="form-label-description">
                                    <a href="forgot-password.php">Forgot password?</a>
                                </span>
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="12" cy="12" r="2" />
                                            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input"/>
                                <span class="form-check-label">Remember me</span>
                            </label>
                        </div>
                        
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100 btn-login">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center text-muted mt-3">
                <a href="contact.php">Need help?</a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.querySelector('a[title="Show password"]');
        const passwordInput = document.querySelector('input[name="password"]');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('.icon').classList.toggle('icon-eye');
                this.querySelector('.icon').classList.toggle('icon-eye-off');
            });
        }
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>
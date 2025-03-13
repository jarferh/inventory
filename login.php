<?php
require_once 'config/config.php';
require_once 'includes/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/Auth.php';
$auth = new Auth();

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($username, $password)) {
        // Get redirect URL from session or default to index.php
        $redirect = $_SESSION['redirect_url'] ?? 'index.php';
        unset($_SESSION['redirect_url']); // Clear stored URL

        header("Location: $redirect");
        exit();
    } else {
        $error = 'Invalid username or password';
    }
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
            // In your login processing file (e.g., login.php or auth.php)
            $_SESSION['user_role'] = $user['role']; // Make sure your users table has a 'role' column
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login - Samah Agrovet POS</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-color: #0061f2;
            --secondary-color: #6900f2;
            --border-radius: 10px;
        }

        body {
            background: #f5f7fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            margin: 1rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .login-sidebar {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 3rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            min-height: 600px;
        }

        .login-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('assets/img/pattern.svg') center/cover;
            opacity: 0.1;
        }

        .login-form-container {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .login-header img {
            max-width: 150px;
            margin-bottom: 1rem;
        }

        .form-control {
            border: 1px solid #e6e8eb;
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 97, 242, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .welcome-text {
            position: relative;
            z-index: 1;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 0;
                border-radius: 0;
            }

            .login-sidebar {
                min-height: 200px;
                padding: 2rem;
            }

            .login-form-container {
                padding: 2rem;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }
        }

        .input-group-text {
            background: none;
            border-left: none;
        }

        .password-toggle {
            cursor: pointer;
            color: #6b7280;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .alert {
            border-radius: var(--border-radius);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="login-container animate__animated animate__fadeIn">
        <div class="login-sidebar">
            <div class="welcome-text">
                <h1>Welcome Back!</h1>
                <p>Sign in to manage your inventory, track sales, and access reports. Your business management journey starts here.</p>
            </div>
        </div>

        <div class="login-form-container">
            <div class="login-header">
                <img src="assets/img/logo.png" alt="Samah Agrovet" class="mb-4">
                <h2>Sign in to your account</h2>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div class="me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 9v2m0 4v.01"></path>
                                <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                            </svg>
                        </div>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                    <button class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label d-flex justify-content-between">
                        Password
                        <a href="forgot-password.php" class="text-muted text-decoration-none">Forgot password?</a>
                    </label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <span class="input-group-text password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="12" r="2" />
                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input">
                        <span class="form-check-label">Remember me</span>
                    </label>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="text-center text-muted mt-3">
                Need help? <a href="contact.php" class="text-decoration-none">Contact support</a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.querySelector('.password-toggle');
            const passwordInput = document.querySelector('input[name="password"]');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Update icon
                    const icon = this.querySelector('.icon');
                    if (type === 'text') {
                        icon.innerHTML = `
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="3" y1="3" x2="21" y2="21" />
                        <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                        <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                    `;
                    } else {
                        icon.innerHTML = `
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="12" r="2" />
                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                    `;
                    }
                });
            }

            // Automatically dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>

</html>
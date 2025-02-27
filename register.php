<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$auth = new Auth();
$errors = [];
$success = false;

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Function to sanitize input (replacement for deprecated FILTER_SANITIZE_STRING)
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = Database::getInstance()->getConnection();

        // Validate and sanitize input using modern methods
        $username = sanitizeInput($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $fullName = sanitizeInput($_POST['full_name'] ?? '');
        $phone = sanitizeInput($_POST['phone'] ?? '');

        // Store original values for form repopulation
        $formData = [
            'username' => $username,
            'email' => $email,
            'full_name' => $fullName,
            'phone' => $phone
        ];

        // Validation rules
        if (empty($username)) {
            $errors['username'] = 'Username is required';
        } elseif (strlen($username) < 3) {
            $errors['username'] = 'Username must be at least 3 characters long';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors['username'] = 'Username can only contain letters, numbers, and underscores';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters long';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $errors['password'] = 'Password must contain at least one uppercase letter, one lowercase letter, and one number';
        }

        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (empty($fullName)) {
            $errors['full_name'] = 'Full name is required';
        }

        // Check for existing username or email
        if (empty($errors)) {
            $stmt = $db->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                if ($existing['username'] === $username) {
                    $errors['username'] = 'Username already exists';
                }
                if ($existing['email'] === $email) {
                    $errors['email'] = 'Email already exists';
                }
            }
        }

        // Proceed with registration if no errors
        if (empty($errors)) {
            $db->beginTransaction();

            try {
                // Get default role ID (cashier)
                $stmt = $db->prepare("SELECT id FROM roles WHERE name = 'cashier' LIMIT 1");
                $stmt->execute();
                $defaultRoleId = $stmt->fetchColumn();

                if (!$defaultRoleId) {
                    throw new Exception('Default role not found');
                }

                // Insert user with prepared statement
                $stmt = $db->prepare("
                    INSERT INTO users (
                        username, 
                        password, 
                        email, 
                        full_name, 
                        phone, 
                        role_id, 
                        status, 
                        created_at, 
                        updated_at
                    ) VALUES (
                        :username,
                        :password,
                        :email,
                        :full_name,
                        :phone,
                        :role_id,
                        'active',
                        UTC_TIMESTAMP(),
                        UTC_TIMESTAMP()
                    )
                ");

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':email' => $email,
                    ':full_name' => $fullName,
                    ':phone' => $phone,
                    ':role_id' => $defaultRoleId
                ]);

                $userId = $db->lastInsertId();

                // Log the registration
                $stmt = $db->prepare("
                    INSERT INTO activity_log (
                        user_id, 
                        action, 
                        description, 
                        created_at
                    ) VALUES (
                        :user_id,
                        'user_registration',
                        :description,
                        UTC_TIMESTAMP()
                    )
                ");

                $stmt->execute([
                    ':user_id' => $userId,
                    ':description' => "New user registration: $username"
                ]);

                $db->commit();
                $success = true;

                // Clear form data after successful registration
                $formData = [];
            } catch (Exception $e) {
                $db->rollBack();
                error_log("Registration error: " . $e->getMessage());
                $errors['system'] = 'An error occurred during registration. Please try again.';
            }
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $errors['system'] = 'A database error occurred. Please try again later.';
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Register - Samah Agrovet POS</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />

    <!-- Add custom styles for the registration form -->
    <style>
        .form-control:focus {
            border-color: var(--tblr-primary);
            box-shadow: 0 0 0 0.25rem rgba(32, 107, 196, 0.25);
        }

        .error-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: var(--tblr-danger);
        }

        .password-strength-meter {
            height: 4px;
            background: #eee;
            margin-top: 5px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .password-strength-meter div {
            height: 100%;
            border-radius: 2px;
            transition: all 0.3s ease;
            width: 0;
        }
    </style>
</head>

<body class="d-flex flex-column bg-light">
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <!-- Form content here (same as before) -->
                <?php if ($success): ?>
                    <!-- Success message -->
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="mb-3">Registration Successful!</h3>
                            <p class="text-muted">Your account has been created successfully.</p>
                            <a href="login.php" class="btn btn-primary">Proceed to Login</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Registration form -->
                    <form class="card card-md" method="post" action="" id="registrationForm">
                        <!-- Form fields here (same as before but with error handling) -->
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Decorative half -->
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <div class="bg-primary-subtle h-100 d-flex flex-column justify-content-center position-relative">
                <!-- Add any decorative content or images here -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registrationForm');
            const passwordInput = document.getElementById('password');

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                if (password.length >= 8) strength++;
                return strength;
            }

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const strength = checkPasswordStrength(this.value);
                    const meter = document.querySelector('.password-strength-meter div');

                    meter.style.width = (strength * 20) + '%';
                    meter.className = '';
                    if (strength >= 5) meter.classList.add('bg-success');
                    else if (strength >= 3) meter.classList.add('bg-warning');
                    else meter.classList.add('bg-danger');
                });
            }

            // Form validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    let hasError = false;
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;

                    if (password !== confirmPassword) {
                        e.preventDefault();
                        hasError = true;
                        document.querySelector('.password-mismatch-error').style.display = 'block';
                    }

                    if (!hasError) {
                        // Show loading state
                        const submitBtn = form.querySelector('button[type="submit"]');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating account...';
                    }
                });
            }
        });
    </script>
</body>

</html>
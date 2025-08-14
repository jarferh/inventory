<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'inv2');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application Configuration
define('SITE_NAME', 'Samah Agrovet POS');
define('CURRENCY', '₦'); // Nigerian Naira
define('TIMEZONE', 'Africa/Lagos'); // Nigerian timezone
define('DATE_FORMAT', 'Y-m-d H:i:s');

// File Upload Configuration
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('ALLOWED_FILES', ['jpg', 'jpeg', 'png', 'pdf']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set(TIMEZONE);

// Profile settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('DEFAULT_AVATAR', 'assets/img/default-avatar.png');

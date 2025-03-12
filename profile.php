<?php
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/Profile.php';

// Initialize Auth
$auth = new Auth();
$auth->requireLogin();

// In profile.php, add this near the top
$uploadDir = 'uploads/avatars/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
// Set page variables
$pageTitle = "Profile Management";
$currentPage = "profile";

// Initialize Profile
$profile = new Profile($_SESSION['user_id']);
$profileData = $profile->getProfile();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        switch ($action) {
            case 'update_profile':
                if ($profile->updateProfile($_POST)) {
                    $_SESSION['success'] = "Profile updated successfully";
                } else {
                    throw new Exception("Failed to update profile");
                }
                break;

            case 'update_password':
                if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
                    throw new Exception("All password fields are required");
                }

                if ($_POST['new_password'] !== $_POST['confirm_password']) {
                    throw new Exception("New passwords do not match");
                }

                if ($profile->updatePassword($_POST['current_password'], $_POST['new_password'])) {
                    $_SESSION['success'] = "Password updated successfully";
                } else {
                    throw new Exception("Current password is incorrect");
                }
                break;

            case 'update_avatar':
                if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception("No file uploaded or upload error");
                }

                $file = $_FILES['avatar'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024; // 5MB

                if (!in_array($file['type'], $allowedTypes)) {
                    throw new Exception("Invalid file type. Only JPG, PNG and GIF are allowed");
                }

                if ($file['size'] > $maxSize) {
                    throw new Exception("File is too large. Maximum size is 5MB");
                }

                $uploadDir = 'uploads/avatars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = uniqid() . '_' . basename($file['name']);
                $uploadPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    if ($profile->updateAvatar($uploadPath)) {
                        $_SESSION['success'] = "Avatar updated successfully";
                    } else {
                        throw new Exception("Failed to update avatar in database");
                    }
                } else {
                    throw new Exception("Failed to upload file");
                }
                break;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    // Refresh profile data
    $profileData = $profile->getProfile();
}

include 'templates/header.php';
?>

<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Profile Settings
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <span class="avatar avatar-xl rounded" style="background-image: url(<?= htmlspecialchars($profileData['avatar'] ?? 'assets/img/default-avatar.png') ?>)"></span>
                            </div>
                            <div class="card-title mb-1"><?= htmlspecialchars($profileData['full_name']) ?></div>
                            <div class="text-muted"><?= htmlspecialchars($profileData['position'] ?? 'No position set') ?></div>
                        </div>
                        <div class="d-flex">
                            <form action="" method="post" enctype="multipart/form-data" class="p-3 w-100">
                                <input type="hidden" name="action" value="update_avatar">
                                <div class="row">
                                    <div class="col">
                                        <input type="file" name="avatar" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form action="" method="post" class="card">
                        <input type="hidden" name="action" value="update_profile">
                        <div class="card-header">
                            <h3 class="card-title">Profile Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($profileData['full_name']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="<?= htmlspecialchars($profileData['email']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($profileData['phone'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Position</label>
                                        <input type="text" name="position" class="form-control" value="<?= htmlspecialchars($profileData['position'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Department</label>
                                        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($profileData['department'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($profileData['date_of_birth'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($profileData['address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Bio</label>
                                        <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($profileData['bio'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>

                    <form action="" method="post" class="card mt-3">
                        <input type="hidden" name="action" value="update_password">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" name="confirm_password" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
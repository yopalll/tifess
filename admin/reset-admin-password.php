<?php 
/**
 * Fitur Reset Password Admin (Khusus Superadmin)
 * Balikin password admin ke default: admin-tifess-1234
 */

require_once "../function.php";
requireLogin();
requireSuperAdmin();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $newPassword = isset($_POST['password']) ? $_POST['password'] : 'admin-tifess-1234';
} else {
    // Fallback for GET request (legacy/direct link support)
    $userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $newPassword = 'admin-tifess-1234';
}

$user = getUserById($userId);

if (!$user) {
    header("Location: manage-admins.php?error=Admin tidak ditemukan");
    exit;
}

// Reset password using the custom password
$result = resetAdminPassword($userId, $newPassword);

if ($result['success']) {
    header("Location: manage-admins.php?success=" . urlencode("Password admin " . $user['username'] . " berhasil direset ke: " . $newPassword));
} else {
    header("Location: manage-admins.php?error=" . urlencode($result['message']));
}
exit;
?>

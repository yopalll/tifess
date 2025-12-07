<?php
/**
 * Hapus Admin (Khusus Superadmin)
 * Menghapus admin yang sudah di-approve
 */

require_once "../function.php";

// Harus login dan harus superadmin
requireLogin();
requireSuperAdmin();

// Pastikan ada ID
if (!isset($_GET['id'])) {
    header("Location: manage-admins.php");
    exit;
}

$adminId = intval($_GET['id']);

// Cek datanya ada ga di database
$admin = getUserById($adminId);

if (!$admin) {
    header("Location: manage-admins.php?error=Admin tidak ditemukan");
    exit;
}

// Gaboleh hapus akun sendiri
startSession();
if ($adminId == $_SESSION['admin_id']) {
    header("Location: manage-admins.php?error=Anda tidak dapat menghapus akun Anda sendiri!");
    exit;
}

// Gaboleh hapus superadmin lain
if ($admin['role'] === 'superadmin') {
    header("Location: manage-admins.php?error=Tidak dapat menghapus superadmin!");
    exit;
}

// Hapus admin dari sistem
if (deleteAdminById($adminId)) {
    header("Location: manage-admins.php?success=Admin berhasil dihapus");
} else {
    header("Location: manage-admins.php?error=Gagal menghapus admin");
}
exit;
?>

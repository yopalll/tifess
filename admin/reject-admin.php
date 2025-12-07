<?php
/**
 * Tolak Admin Baru
 */

require_once "../function.php";

requireLogin();
requireSuperAdmin();

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    rejectAdmin($userId);
}

header("Location: manage-admins.php");
exit;

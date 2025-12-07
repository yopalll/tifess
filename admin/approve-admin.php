<?php
/**
 * ACC Admin
 */

require_once "../function.php";

requireLogin();
requireSuperAdmin();

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    approveAdmin($userId);
}

header("Location: manage-admins.php");
exit;

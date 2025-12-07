<?php
/**
 * Endpoint Hapus Confess
 * Hapus confess dari database permanen
 */

require_once "../function.php";

// Cek login dulu
requireLogin();

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

if ($id) {
    // Hapus data pake fungsi
    deleteConfess($id);
    
    // Balikin ke halaman sebelumnya
    $from = $_GET['from'] ?? 'approved';
    
    if ($from == 'rejected') {
        header("Location: rejected.php?success=deleted");
    } else {
        header("Location: approved.php?success=deleted");
    }
    exit;
} else {
    // Kalo ga ada ID, balik ke dashboard
    header("Location: index.php");
    exit;
}

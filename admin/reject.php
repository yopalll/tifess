<?php
/**
 *  buat Reject Confess
 * Ubah status confess jadi 'reject'
 */

require_once "../function.php";

// Cek login dulu
requireLogin();

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

if ($id) {
    // Reject confess pake fungsi
    rejectConfess($id);
    
    // Balikin ke halaman asal
    $from = $_GET['from'] ?? 'pending';
    
    if ($from == 'approved') {
        header("Location: approved.php?success=rejected");
    } else {
        header("Location: pending.php?success=rejected");
    }
    exit;
} else {
    // Kalo ga ada ID, balik ke dashboard
    header("Location: index.php");
    exit;
}

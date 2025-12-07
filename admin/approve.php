<?php
/**
 * Endpoint untuk Menyetujui Confess
 * Ubah status confess menjadi 'acc'
 */

require_once "../function.php";

// Cek login dulu
requireLogin();

// Ambil ID confess dari parameter GET
$id = $_GET['id'] ?? '';

if ($id) {
    // Approve confess pake fungsi
    approveConfess($id);
    
    // Balikin ke halaman asal
    $from = $_GET['from'] ?? 'pending';
    
    if ($from == 'rejected') {
        header("Location: rejected.php?success=approved");
    } else {
        header("Location: pending.php?success=approved");
    }
    exit;
} else {
    // Jika ID tidak ada, redirect ke dashboard
    header("Location: index.php");
    exit;
}

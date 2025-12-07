<?php

require_once "function.php";

$isi      = $_POST['isi'] ?? '';
$kategori = $_POST['kategori'] ?? '';

// Cek ada isinya ga
if ($isi) {
    // Simpan confess baru
    $nomor = insertConfess($isi, $kategori);
    
    // Sukses, balikin ke form dengan nomor tiket
    header("Location: form-confess.php?success=1&nomor=" . urlencode($nomor));
    exit;
} else {
    // Gagal, balikin error
    header("Location: form-confess.php?error=1");
    exit;
}

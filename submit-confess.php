<?php

require_once "function.php";
startSession();

$isi      = $_POST['isi'] ?? '';
$kategori = $_POST['kategori'] ?? '';
$captcha_input = $_POST['captcha_input'] ?? '';

if (!verifyMathCaptcha($captcha_input)) {
    header("Location: form-confess.php?error=captcha");
    exit;
}

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

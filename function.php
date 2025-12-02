<?php


// TIMEZONE - Set ke WIB
date_default_timezone_set('Asia/Jakarta');


error_reporting(0);
ini_set('display_errors', 0);



// Settingan Database - Localhost
$host     = "localhost";
$user     = "root";
$password = "";
$dbname   = "tifess";



// Sambung ke Database
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti.");
}

mysqli_set_charset($conn, "utf8mb4");
mysqli_query($conn, "SET time_zone = '+07:00'");

// FUNGSI UTAMA (Query & Helper)

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// FUNGSI CONFESS (CRUD)

function generateNomorConfess() {
    $last = query("SELECT nomor FROM confess ORDER BY id DESC LIMIT 1");

    if (!$last) {
        return "CF-00001";
    }

    $lastNomor = $last[0]["nomor"];
    $angka = intval(substr($lastNomor, 3));
    $baru = $angka + 1;
    
    return "CF-" . str_pad($baru, 5, "0", STR_PAD_LEFT);
}

function insertConfess($isi, $kategori) {
    global $conn;

    $isi      = mysqli_real_escape_string($conn, $isi);
    $kategori = mysqli_real_escape_string($conn, $kategori);

    $nomor = generateNomorConfess();

    $query = "INSERT INTO confess (nomor, isi, kategori, status, tanggal)
              VALUES ('$nomor', '$isi', '$kategori', 'pending', NOW())";

    mysqli_query($conn, $query);

    return $nomor;
}

function cekStatus($nomor) {
    global $conn;
    $nomor = mysqli_real_escape_string($conn, $nomor);

    $data = query("SELECT * FROM confess WHERE nomor='$nomor'");

    if (!$data) {
        return null;
    }

    return $data[0];
}

function deleteConfess($id) {
    global $conn;
    $id = intval($id);
    mysqli_query($conn, "DELETE FROM confess WHERE id=$id");
    return true;
}

function getPending() {
    return query("SELECT * FROM confess WHERE status='pending' ORDER BY id DESC");
}

function getAcc() {
    return query("SELECT * FROM confess WHERE status='acc' ORDER BY id DESC");
}

function getAccWithPagination($page = 1, $perPage = 9) {
    $offset = ($page - 1) * $perPage;
    return query("SELECT * FROM confess WHERE status='acc' ORDER BY id DESC LIMIT $perPage OFFSET $offset");
}

function getTotalAccCount() {
    $result = query("SELECT COUNT(*) as total FROM confess WHERE status='acc'");
    return $result[0]['total'];
}

function getReject() {
    return query("SELECT * FROM confess WHERE status='reject' ORDER BY id DESC");
}

function getTotalPending() {
    $result = query("SELECT COUNT(*) as total FROM confess WHERE status='pending'");
    return $result[0]['total'];
}

function getTotalAcc() {
    $result = query("SELECT COUNT(*) as total FROM confess WHERE status='acc'");
    return $result[0]['total'];
}

function getTotalReject() {
    $result = query("SELECT COUNT(*) as total FROM confess WHERE status='reject'");
    return $result[0]['total'];
}

function approveConfess($id) {
    global $conn;
    $id = intval($id);
    mysqli_query($conn, "UPDATE confess SET status='acc' WHERE id=$id");
}

function rejectConfess($id) {
    global $conn;
    $id = intval($id);
    mysqli_query($conn, "UPDATE confess SET status='reject' WHERE id=$id");
}

// FUNGSI USER & AUTH (Login/Session)

function getUserByUsername($username) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);

    $data = query("SELECT * FROM users WHERE username='$username'");
    return $data ? $data[0] : null;
}

function verifyLogin($username, $password) {
    $user = getUserByUsername($username);

    if (!$user) {
        return false;
    }

    if (!password_verify($password, $user['password'])) {
        return false;
    }

    if ($user['role'] !== 'superadmin' && !$user['is_approved']) {
        return ['error' => 'pending_approval'];
    }

    return $user;
}

function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn() {
    startSession();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function setAdminSession($user) {
    startSession();
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];
    $_SESSION['admin_role'] = $user['role'];
}

function clearAdminSession() {
    startSession();
    session_unset();
    session_destroy();
}

function requireLogin($redirectTo = '../login.php') {
    if (!isLoggedIn()) {
        header("Location: $redirectTo");
        exit;
    }
}

function isSuperAdmin() {
    startSession();
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'superadmin';
}

function requireSuperAdmin($redirectTo = 'index.php') {
    if (!isSuperAdmin()) {
        header("Location: $redirectTo");
        exit;
    }
}

// FUNGSI KELOLA ADMIN

function getPendingAdmins() {
    return query("SELECT * FROM users WHERE role='admin' AND is_approved=FALSE ORDER BY created_at DESC");
}

function getApprovedAdmins() {
    return query("SELECT * FROM users WHERE role='admin' AND is_approved=TRUE ORDER BY created_at DESC");
}

function approveAdmin($userId) {
    global $conn;
    startSession();
    $adminId = intval($_SESSION['admin_id']);
    $userId = intval($userId);
    
    mysqli_query($conn, "UPDATE users SET is_approved=TRUE, approved_by=$adminId, approved_at=NOW() WHERE id=$userId");
}

function rejectAdmin($userId) {
    global $conn;
    $userId = intval($userId);
    mysqli_query($conn, "DELETE FROM users WHERE id=$userId");
}

function getUserById($userId) {
    global $conn;
    $userId = intval($userId);
    $data = query("SELECT * FROM users WHERE id=$userId");
    return $data ? $data[0] : null;
}

function deleteAdminById($userId) {
    global $conn;
    $userId = intval($userId);
    mysqli_query($conn, "DELETE FROM users WHERE id=$userId");
    return mysqli_affected_rows($conn) > 0;
}

// FUNGSI PRODUK (Merchandise)

function getProducts() {
    return query("SELECT * FROM products ORDER BY created_at DESC");
}

function getProductsWithPagination($page = 1, $perPage = 9) {
    $offset = ($page - 1) * $perPage;
    return query("SELECT * FROM products ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
}

function getTotalProductsCount() {
    $result = query("SELECT COUNT(*) as total FROM products");
    return $result[0]['total'];
}

function getProductById($id) {
    global $conn;
    $id = intval($id);
    $data = query("SELECT * FROM products WHERE id=$id");
    return $data ? $data[0] : null;
}

function insertProduct($name, $description, $price, $stock, $image) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $price = floatval($price);
    $stock = intval($stock);
    $image = mysqli_real_escape_string($conn, $image);
    
    $query = "INSERT INTO products (name, description, price, stock, image, created_at) 
              VALUES ('$name', '$description', $price, $stock, '$image', NOW())";
    
    return mysqli_query($conn, $query);
}

function updateProduct($id, $name, $description, $price, $stock, $image = null) {
    global $conn;
    $id = intval($id);
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $price = floatval($price);
    $stock = intval($stock);
    
    if ($image) {
        $image = mysqli_real_escape_string($conn, $image);
        $query = "UPDATE products SET name='$name', description='$description', price=$price, stock=$stock, image='$image' WHERE id=$id";
    } else {
        $query = "UPDATE products SET name='$name', description='$description', price=$price, stock=$stock WHERE id=$id";
    }
    
    return mysqli_query($conn, $query);
}

function deleteProduct($id) {
    global $conn;
    $id = intval($id);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    return true;
}

// FUNGSI ORDER

function generateOrderNumber() {
    $last = query("SELECT order_number FROM orders ORDER BY id DESC LIMIT 1");
    
    if (!$last) {
        return "ORD-00001";
    }
    
    $lastNumber = $last[0]["order_number"];
    $angka = intval(substr($lastNumber, 4));
    $baru = $angka + 1;
    
    return "ORD-" . str_pad($baru, 5, "0", STR_PAD_LEFT);
}

function insertOrder($buyerName, $buyerPhone, $buyerAddress, $productItems, $totalPrice) {
    global $conn;
    
    $buyerName = mysqli_real_escape_string($conn, $buyerName);
    $buyerPhone = mysqli_real_escape_string($conn, $buyerPhone);
    $buyerAddress = mysqli_real_escape_string($conn, $buyerAddress);
    $productItems = mysqli_real_escape_string($conn, $productItems);
    $totalPrice = floatval($totalPrice);
    
    $orderNumber = generateOrderNumber();
    
    $query = "INSERT INTO orders (order_number, buyer_name, buyer_phone, buyer_address, product_items, total_price, created_at)
              VALUES ('$orderNumber', '$buyerName', '$buyerPhone', '$buyerAddress', '$productItems', $totalPrice, NOW())";
    
    mysqli_query($conn, $query);
    
    return $orderNumber;
}

function getOrders() {
    return query("SELECT * FROM orders ORDER BY created_at DESC");
}

// FUNGSI RESET & UBAH PASSWORD

function changePassword($userId, $oldPassword, $newPassword) {
    global $conn;
    
    $userId = intval($userId);
    $user = getUserById($userId);
    
    if (!$user) {
        return ['success' => false, 'message' => 'User tidak ditemukan'];
    }
    
    // Verifikasi password lama
    if (!password_verify($oldPassword, $user['password'])) {
        return ['success' => false, 'message' => 'Password lama salah'];
    }
    
    // Hash password baru
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $hashedPassword = mysqli_real_escape_string($conn, $hashedPassword);
    
    // Update password
    $query = "UPDATE users SET password='$hashedPassword' WHERE id=$userId";
    
    if (mysqli_query($conn, $query)) {
        return ['success' => true, 'message' => 'Password berhasil diubah'];
    } else {
        return ['success' => false, 'message' => 'Gagal mengubah password'];
    }
}

function resetAdminPassword($userId, $resetPassword = 'admin-tifess-1234')
// kalo mau ganti pw reset admin ganti diatas ces   ^^^^^^^^^^^^^^^^^^^^^
{
    global $conn;
    
    $userId = intval($userId);
    $user = getUserById($userId);
    
    if (!$user) {
        return ['success' => false, 'message' => 'User tidak ditemukan'];
    }
    
    // Tidak bisa reset superadmin
    if ($user['role'] === 'superadmin') {
        return ['success' => false, 'message' => 'Tidak dapat mereset password superadmin'];
    }
    
    // Hash password default
    $hashedPassword = password_hash($resetPassword, PASSWORD_DEFAULT);
    $hashedPassword = mysqli_real_escape_string($conn, $hashedPassword);
    
    // Update password
    $query = "UPDATE users SET password='$hashedPassword' WHERE id=$userId";
    
    if (mysqli_query($conn, $query)) {
        return ['success' => true, 'message' => 'Password berhasil direset ke default'];
    } else {
        return ['success' => false, 'message' => 'Gagal mereset password'];
    }
}

function changeSuperAdminUsername($userId, $newUsername) {
    global $conn;
    
    $userId = intval($userId);
    $newUsername = mysqli_real_escape_string($conn, $newUsername);
    
    // Cek apakah user adalah superadmin
    $user = getUserById($userId);
    if (!$user || $user['role'] !== 'superadmin') {
        return false;
    }
    
    // Cek apakah sudah pernah ganti username
    if ($user['is_username_changed']) {
        return false;
    }
    
    // Update username dan set flag changed
    $query = "UPDATE users SET username='$newUsername', is_username_changed=TRUE WHERE id=$userId";
    return mysqli_query($conn, $query);
}



function generateMathCaptcha() {
    startSession();
    $angka1 = rand(1, 10);
    $angka2 = rand(1, 10);
    $_SESSION['captcha_answer'] = $angka1 + $angka2;
    return "$angka1 + $angka2 = ?";
}

function verifyMathCaptcha($input) {
    startSession();
    $answer = $_SESSION['captcha_answer'] ?? 0;
    
    return isset($input) && intval($input) === intval($answer);
}


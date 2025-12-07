<?php

require_once 'function.php';

session_start();

// Cek kalo udah login, langsung ke dashboard
if (isLoggedIn()) {
    header("Location: admin/index.php");
    exit;
}

$error = '';

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verifikasi login pake fungsi
    $user = verifyLogin($username, $password);

    if ($user && isset($user['error']) && $user['error'] === 'pending_approval') {
        $error = 'Akun Anda masih menunggu persetujuan dari superadmin. Silakan hubungi admin.';
    } elseif ($user) {
        // Set session dan masuk ke dashboard
        setAdminSession($user);
        header("Location: admin/index.php");
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login Admin — TIFESS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/pink-theme.css">

<link rel="stylesheet" href="assets/css/animations.css">

<link rel="stylesheet" href="assets/css/dark-mode.css">

<style>
    font-family: 'Poppins', sans-serif;
  }

  html {
    scroll-behavior: smooth;
  }

  body {
    background: linear-gradient(135deg, #FFE6F2 0%, #FFF0F6 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow-x: hidden;
  }

  body::before {
    content: '';
    position: fixed;
    top: -50%;
    right: -50%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255, 79, 157, 0.1), transparent);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite;
    z-index: -1;
  }

  body::after {
    content: '';
    position: fixed;
    bottom: -30%;
    left: -30%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(140, 82, 255, 0.1), transparent);
    border-radius: 50%;
    animation: float 10s ease-in-out infinite;
    animation-delay: 2s;
    z-index: -1;
  }

  .login-container {
    width: 100%;
    max-width: 420px;
    z-index: 10;
    animation: scaleUp 0.6s ease-out;
  }

  .login-card {
    border-radius: 25px;
    border: none;
    box-shadow: 0 20px 60px rgba(255, 79, 157, 0.2);
    background: white;
    overflow: hidden;
    position: relative;
  }

  .login-card:hover {
    transform: none !important;
    box-shadow: 0 20px 60px rgba(255, 79, 157, 0.2) !important;
  }

  .login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #FF4F9D, #8C52FF, #FF4F9D);
    animation: shimmer 3s infinite;
  }

  .card-body {
    padding: 3.5rem 2.5rem;
  }

  .login-header {
    text-align: center;
    margin-bottom: 2rem;
    animation: slideInDown 0.6s ease-out;
  }

  .login-header h2 {
    background: linear-gradient(135deg, #FF4F9D 0%, #8C52FF 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
  }

  .login-header p {
    color: #666;
    font-weight: 500;
    margin: 0;
  }

  .heart-icon {
    font-size: 1.5rem;
    display: inline-block;
    animation: heartPulse 1s ease-in-out infinite;
    margin: 0 5px;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    color: #FF4F9D;
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    margin-bottom: 0.8rem;
    display: block;
  }

  .form-control {
    background: white;
    border: 2px solid #E8D5E8;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.95rem;
    color: #333;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .form-control:focus {
    background: white;
    border-color: #FF4F9D;
    color: #333;
    box-shadow: 0 0 0 0.3rem rgba(255, 79, 157, 0.15);
  }

  .form-control::placeholder {
    color: #bbb;
  }

  .input-group .form-control {
    border-left: none;
  }

  .input-group-text {
    background: linear-gradient(135deg, #FFE6F2, #FFF0F6);
    border: 2px solid #E8D5E8;
    border-right: none;
    color: #FF4F9D;
    border-radius: 12px 0 0 12px;
    font-weight: 600;
  }

  .btn-submit {
    background: linear-gradient(135deg, #FF4F9D, #FF2F88);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 28px;
    font-weight: 700;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 0.95rem;
    margin-bottom: 1rem;
  }

  .btn-submit:hover {
    background: linear-gradient(135deg, #FF2F88, #FF1A75);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 79, 157, 0.3);
    color: white;
  }

  .btn-submit:active {
    transform: translateY(-1px);
  }

  .btn-dark-mode {
    background: transparent;
    border: 2px solid #E8D5E8;
    color: #FF4F9D;
    border-radius: 12px;
    padding: 10px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    margin-bottom: 1rem;
    font-size: 0.9rem;
  }

  .btn-dark-mode:hover {
    background: #FFE6F2;
    border-color: #FF4F9D;
    color: #FF4F9D;
  }

  .login-footer {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #E8D5E8;
  }

  .login-footer a {
    color: #FF4F9D;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .login-footer a:hover {
    color: #FF2F88;
  }

  .back-link {
    display: inline-block;
    color: #666;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
  }

  .back-link:hover {
    color: #FF4F9D;
  }

  .alert {
    border-radius: 12px;
    border: none;
    margin-bottom: 1.5rem;
    animation: slideInDown 0.4s ease-out;
    border-left: 5px solid;
  }

  .alert-danger {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(255, 75, 75, 0.1));
    color: #c92a2a;
    border-left-color: #FF6B6B;
  }

  .alert-info {
    background: linear-gradient(135deg, rgba(255, 79, 157, 0.1), rgba(140, 82, 255, 0.1));
    color: #FF4F9D;
    border-left-color: #FF4F9D;
  }

  body.dark-mode {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
  }

  body.dark-mode .login-card {
    background: #0f3460;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
  }

  body.dark-mode .form-control {
    background: #16213e;
    border-color: rgba(255, 79, 157, 0.3);
    color: #ddd;
  }

  body.dark-mode .form-control:focus {
    background: #0f3460;
    border-color: #FF4F9D;
    box-shadow: 0 0 0 0.3rem rgba(255, 79, 157, 0.2);
  }

  body.dark-mode .input-group-text {
    background: rgba(255, 79, 157, 0.1);
    border-color: rgba(255, 79, 157, 0.3);
  }

  body.dark-mode .form-label,
  body.dark-mode .login-header p {
    color: #FFB6D9;
  }

  body.dark-mode .login-footer {
    border-top-color: rgba(255, 79, 157, 0.2);
  }

  body.dark-mode .login-footer a {
    color: #FFB6D9;
  }

  @media (max-width: 480px) {
    .login-container {
      max-width: 100%;
      margin: 0 20px;
    }

    .card-body {
      padding: 2.5rem 1.5rem;
    }

    .login-header h2 {
      font-size: 1.5rem;
    }
    .login-header h2 {
      font-size: 1.5rem;
    }
  }

  .password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
    transition: color 0.3s ease;
    z-index: 10;
    font-size: 1rem;
  }

  .password-toggle:hover {
    color: #FF4F9D;
  }

  .password-field-wrapper {
    position: relative;
  }

  .password-field-wrapper .form-control {
    padding-right: 40px;
  }
</style>
</head>
<body>

<div class="login-container">
  <div class="card login-card">
    <div class="card-body">

      
      <a href="index.php" class="back-link">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Homepage
      </a>

      
      <div class="login-header">
        <h2>
          <span class="heart-icon">💕</span> TIFESS <span class="heart-icon">💕</span>
        </h2>
        <p>Panel Login Admin</p>
      </div>

      
      <?php if ($error): ?>
      <div class="alert alert-danger fade-in">
        <div class="d-flex align-items-center">
          <i class="fas fa-exclamation-circle me-2"></i>
          <div><?= htmlspecialchars($error) ?></div>
        </div>
      </div>
      <?php endif; ?>

      
      <form method="POST">
        
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-user me-1"></i> Username
          </label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-user"></i>
            </span>
            <input
              type="text"
              name="username"
              class="form-control"
              placeholder="Masukkan username"
              required
              autofocus
              style="border-radius: 0 12px 12px 0;"
            >
          </div>
        </div>

        
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-lock me-1"></i> Password
          </label>
          <div class="input-group password-field-wrapper">
            <span class="input-group-text">
              <i class="fas fa-lock"></i>
            </span>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              placeholder="Masukkan password"
              required
              style="border-radius: 0 12px 12px 0;"
            >
            <i class="fas fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
          </div>
        </div>

        
        <button type="button" id="darkModeToggle" class="btn-dark-mode">
          <i class="fas fa-moon me-1"></i> Dark Mode
        </button>

        
        <button type="submit" class="btn-submit">
          <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Dashboard
        </button>

        
        <div class="login-footer">
          <small style="color: #666;">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
          </small>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/jquery/jquery.min.js"></script>

<script src="assets/js/dark-mode.js"></script>

<script>
function togglePassword(fieldId, icon) {
  const passwordField = document.getElementById(fieldId);
  
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    passwordField.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>

</body>
</html>

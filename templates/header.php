<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TIFESS — Confess Platform Teknologi Informasi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="assets/img/favicon.png">
<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
<link rel="apple-touch-icon" href="assets/img/favicon.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/pink-theme.css">

<link rel="stylesheet" href="assets/css/animations.css">

<link rel="stylesheet" href="assets/css/dark-mode.css">

<style>
  html {
    scroll-behavior: smooth;
  }

  :root {
    --primary-pink: #FF4F9D;
    --dark-pink: #FF2F88;
    --light-pink: #FFE6F2;
  }

  * {
    font-family: 'Poppins', sans-serif;
  }

  body {
    overflow-x: hidden;
  }

  .floating-heart {
    position: fixed;
    pointer-events: none;
    font-size: 1.5rem;
    opacity: 0.3;
    z-index: -1;
    animation: float 4s ease-in-out infinite;
  }

  @keyframes slideInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .navbar {
    animation: slideInDown 0.6s ease-out;
  }

  .nav-link:hover i {
    color: #FF4F9D;
    animation: bounce 0.5s ease;
  }

  .navbar-light {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  }

  .navbar-light .nav-link {
    color: #555;
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s ease;
    position: relative;
    padding-bottom: 8px !important;
  }

  .navbar-light .nav-link::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #FF4F9D, #8C52FF);
    border-radius: 10px;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
  }

  .navbar-light .nav-link:hover {
    color: #FF4F9D;
  }

  .navbar-light .nav-link:hover::after {
    width: 100%;
  }

  body.dark-mode .navbar-light {
    background: rgba(22, 33, 62, 0.95);
  }

  body.dark-mode .navbar-light .nav-link {
    color: #ddd;
  }

  body.dark-mode .navbar-light .nav-link:hover {
    color: #FFB6D9;
  }

  @media (max-width: 768px) {
    .navbar-brand {
      font-size: 1.2rem;
    }

    .nav-link {
      font-size: 0.9rem;
    }
  }
</style>

<script src="assets/js/dark-mode.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top py-3">
  <div class="container-fluid">

    
    <a class="navbar-brand fw-bold ms-md-3 fade-in" href="index.php">
      <i class="fas fa-heart text-pink me-2" style="animation: heartPulse 1s ease-in-out infinite;"></i>
      <span style="background: linear-gradient(135deg, #FF4F9D 0%, #8C52FF 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
        TIFESS
      </span>
      <div style="font-size: 10px; color: #8C52FF; margin-top: -2px; letter-spacing: 5px;">
        CONFESS PLATFORM
      </div>
    </a>

    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border-color: #FF4F9D;">
      <span class="navbar-toggler-icon"></span>
    </button>

    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto me-md-3">
        <li class="nav-item">
          <a class="nav-link fade-in" href="index.php">
            <i class="fas fa-home me-1"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fade-in" href="mading.php">
            <i class="fas fa-comments me-1"></i> Mading
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fade-in" href="form-confess.php">
            <i class="fas fa-feather me-1"></i> Confess
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fade-in" href="merchandise.php">
            <i class="fas fa-gift me-1"></i> Merchandise
          </a>
        </li>
        <li class="nav-item">
          <button id="darkModeToggle" class="nav-link btn btn-link" style="border: none; background: none; cursor: pointer; padding: 0.5rem 1rem;">
            <i class="fas fa-moon me-1"></i> <span>Dark</span>
          </button>
        </li>
        <li class="nav-item">
          <a class="btn btn-pink btn-sm" href="login.php" style="margin-top: 0.25rem;">
            <i class="fas fa-sign-in-alt me-1"></i> Login
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>



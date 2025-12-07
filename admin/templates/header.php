<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TIFESS Admin Dashboard</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">

  <!-- Google Font - Poppins -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800">

  <!-- Pink Theme CSS -->
  <link rel="stylesheet" href="../assets/css/pink-theme.css">
  
  <!-- Animations CSS -->
  <link rel="stylesheet" href="../assets/css/animations.css">

  <!-- Custom Admin Styles -->
  <style>
    :root {
      --primary-pink: #FF4F9D;
      --dark-pink: #FF2F88;
      --light-pink: #FFE6F2;
      --pale-pink: #FFF0F6;
      --purple-accent: #8C52FF;
    }

    * {
      font-family: 'Poppins', sans-serif;
    }

    /* Main Navbar */
    .main-header.navbar {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 240, 246, 0.95));
      backdrop-filter: blur(10px);
      border-bottom: 2px solid rgba(255, 79, 157, 0.15);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    /* Sidebar */
    .sidebar {
      background: linear-gradient(180deg, rgba(255, 79, 157, 0.1), rgba(140, 82, 255, 0.1));
      border-right: 2px solid rgba(255, 79, 157, 0.1);
    }

    .sidebar-dark-primary {
      background: linear-gradient(180deg, #1a1a2e, #16213e);
      border-right: 2px solid rgba(255, 79, 157, 0.2);
    }

    .sidebar-dark-primary .nav-link.active {
      background: linear-gradient(135deg, var(--primary-pink), var(--dark-pink));
      border-radius: 10px;
      margin: 5px 10px;
      padding-left: 15px;
      font-weight: 600;
      color: white !important;
      box-shadow: 0 4px 12px rgba(255, 79, 157, 0.3);
    }

    .sidebar-dark-primary .nav-link:hover {
      background: rgba(255, 79, 157, 0.15);
      border-radius: 10px;
      margin: 5px 10px;
      transition: all 0.3s ease;
    }

    /* Custom Scrollbar for Sidebar */
    .sidebar::-webkit-scrollbar {
      width: 8px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: rgba(255, 79, 157, 0.1);
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, var(--primary-pink), var(--purple-accent));
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, var(--dark-pink), #8C52FF);
    }

    /* Firefox Scrollbar */
    .sidebar {
      scrollbar-width: thin;
      scrollbar-color: var(--primary-pink) rgba(255, 79, 157, 0.1);
    }

    /* Brand Area */
    .brand-link {
      background: linear-gradient(135deg, var(--primary-pink), var(--dark-pink));
      border-bottom: 2px solid rgba(255, 79, 157, 0.2);
      font-weight: 800;
      font-size: 1.1rem;
      padding: 1.5rem;
      color: white;
    }

    .brand-link:hover {
      background: linear-gradient(135deg, var(--dark-pink), #FF1A75);
    }

    /* Content Header */
    .content-header {
      background: linear-gradient(135deg, rgba(255, 230, 242, 0.5), rgba(255, 240, 246, 0.5));
      border-bottom: 1px solid rgba(255, 79, 157, 0.15);
      padding: 1.5rem;
    }

    .content-header h1 {
      color: var(--primary-pink);
      font-weight: 700;
      font-size: 1.8rem;
    }

    /* Cards */
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .card:hover {
      box-shadow: 0 8px 20px rgba(255, 79, 157, 0.15);
      transform: translateY(-3px);
    }

    .card-header {
      background: linear-gradient(135deg, var(--light-pink), var(--pale-pink));
      border-bottom: 2px solid rgba(255, 79, 157, 0.2);
      color: var(--primary-pink);
      font-weight: 700;
      padding: 1.25rem;
    }

    /* Small Box */
    .small-box {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }

    .small-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .small-box.bg-warning {
      background: linear-gradient(135deg, #FFD93D, #FFB833) !important;
    }

    .small-box.bg-success {
      background: linear-gradient(135deg, #4ECDC4, #36A39D) !important;
    }

    .small-box.bg-danger {
      background: linear-gradient(135deg, #FF6B6B, #FF4757) !important;
    }

    .small-box.bg-info {
      background: linear-gradient(135deg, #FF4F9D, #8C52FF) !important;
    }

    /* Table */
    .table {
      border-color: rgba(255, 79, 157, 0.1);
    }

    .table thead {
      background: linear-gradient(135deg, rgba(255, 79, 157, 0.1), rgba(140, 82, 255, 0.1));
      color: var(--primary-pink);
      font-weight: 700;
    }

    .table tbody tr:hover {
      background: rgba(255, 79, 157, 0.05);
      transition: all 0.2s ease;
    }

    /* Buttons */
    .btn-primary {
      background: linear-gradient(135deg, var(--primary-pink), var(--dark-pink)) !important;
      border: none;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(255, 79, 157, 0.3);
    }

    .btn-danger {
      background: linear-gradient(135deg, #FF6B6B, #FF4757) !important;
      border: none;
      font-weight: 600;
      border-radius: 10px;
    }

    .btn-success {
      background: linear-gradient(135deg, #4ECDC4, #36A39D) !important;
      border: none;
      font-weight: 600;
      border-radius: 10px;
    }

    .btn-warning {
      background: linear-gradient(135deg, #FFD93D, #FFB833) !important;
      border: none;
      font-weight: 600;
      border-radius: 10px;
      color: #333 !important;
    }

    /* Badges */
    .badge {
      border-radius: 20px;
      padding: 6px 12px;
      font-weight: 600;
    }

    /* Dark Mode Support */
    body.dark-mode {
      background: linear-gradient(135deg, #1a1a2e, #16213e);
    }

    body.dark-mode .main-header.navbar {
      background: rgba(22, 33, 62, 0.95);
      border-bottom-color: rgba(255, 79, 157, 0.3);
    }

    body.dark-mode .content-header {
      background: rgba(15, 52, 96, 0.5);
    }

    body.dark-mode .card {
      background: #0f3460;
      color: #ddd;
    }

    body.dark-mode .card-header {
      background: rgba(255, 79, 157, 0.15);
      color: #FFB6D9;
    }

    body.dark-mode .table {
      color: #ddd;
      border-color: rgba(255, 79, 157, 0.2);
    }

    body.dark-mode .table thead {
      background: rgba(255, 79, 157, 0.1);
      color: #FFB6D9;
    }

    body.dark-mode .table tbody tr:hover {
      background: rgba(255, 79, 157, 0.15);
    }

    /* Responsive Design for Mobile & Tablet */
    @media (max-width: 768px) {
      /* Navbar - More Spacious */
      .main-header.navbar {
        padding: 0.75rem 0.5rem;
      }

      .navbar-brand {
        font-size: 0.9rem !important;
        margin-left: 0.5rem !important;
      }

      .navbar-brand i {
        font-size: 0.85rem;
      }

      /* Navbar Items - Better Touch Targets */
      .navbar-nav .nav-item .nav-link {
        padding: 10px 12px;
        font-size: 0.85rem;
      }

      /* Hide text on mobile, keep icons */
      .navbar-nav .nav-link span {
        display: none;
      }

      .navbar-nav .nav-link i {
        margin-right: 0 !important;
      }

      /* Content Header - Less Cramped */
      .content-header {
        padding: 1rem !important;
      }

      .content-header h1 {
        font-size: 1.3rem !important;
        margin-bottom: 0.5rem;
      }

      /* Card Headers */
      .card-header {
        padding: 0.875rem !important;
        font-size: 0.95rem;
      }

      /* Buttons - Touch Friendly */
      .btn {
        min-height: 44px;
        padding: 10px 16px;
        font-size: 0.85rem;
      }

      .btn-sm {
        min-height: 40px;
        padding: 8px 14px;
        font-size: 0.8rem;
      }

      /* Table */
      .table {
        font-size: 0.85rem;
      }

      .table thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.8rem;
      }

      .table tbody td {
        padding: 0.75rem 0.5rem;
      }

      /* Small Box Stats */
      .small-box {
        margin-bottom: 1rem;
      }

      .small-box .inner h3 {
        font-size: 1.5rem;
      }

      .small-box .inner p {
        font-size: 0.85rem;
      }
    }

    /* Tablet Optimization */
    @media (max-width: 991px) and (min-width: 769px) {
      .main-header.navbar {
        padding: 0.875rem 0.75rem;
      }

      .navbar-brand {
        font-size: 1rem !important;
      }

      .content-header {
        padding: 1.25rem !important;
      }

      .content-header h1 {
        font-size: 1.5rem !important;
      }

      .navbar-nav .nav-link {
        font-size: 0.9rem;
        padding: 10px 14px;
      }
    }

    /* Extra Small Devices */
    @media (max-width: 576px) {
      .brand-link {
        padding: 1rem !important;
        font-size: 0.95rem !important;
      }

      .content-header h1 {
        font-size: 1.1rem !important;
      }

      /* Make action buttons stack */
      .btn-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
      }

      .btn-group .btn {
        width: 100%;
        margin-bottom: 0;
      }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-dark-primary">

<?php
/**
 * Header Admin Panel
 * Cek session login dan include function.php
 */

require_once "../function.php";

// Redirect ke login jika belum login
requireLogin();
?>

<div class="wrapper">

<!-- NAVBAR -->
<nav class="main-header navbar navbar-expand navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars text-pink"></i>
      </a>
    </li>
  </ul>

  <!-- Brand -->
  <div class="navbar-brand ms-3">
    <i class="fas fa-heart text-pink me-2" style="animation: heartPulse 1s ease-in-out infinite;"></i>
    <span style="background: linear-gradient(135deg, var(--primary-pink), var(--purple-accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">
      TIFESS Admin
    </span>
  </div>

  <!-- Right navbar links -->
  <ul class="navbar-nav ms-auto">
    <li class="nav-item">
      <a href="../index.php" class="nav-link" target="_blank" style="color: var(--primary-pink); font-weight: 600;">
        <i class="fas fa-eye me-1"></i> Lihat Website
      </a>
    </li>
    <li class="nav-item">
      <a href="../logout.php" class="nav-link" style="color: #FF6B6B; font-weight: 600;">
        <i class="fas fa-sign-out-alt me-1"></i> Logout
      </a>
    </li>
  </ul>
</nav>

<?php include "sidebar.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

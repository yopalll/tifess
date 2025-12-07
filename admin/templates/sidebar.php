<!-- SIDEBAR AdminLTE -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link text-center" style="background:#FF4F9D;">
    <span class="brand-text font-weight-bold" style="color:white;">TIFESS Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar" style="overflow-y: auto; max-height: calc(100vh - 100px); padding-bottom: 20px;">
    
    <!-- Informasi User -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <i class="fas fa-user-shield fa-2x text-white"></i>
      </div>
      <div class="info">
        <a href="#" class="d-block text-white">
          <?php 
          // Tampilkan username admin yang sedang login
          startSession();
          echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin'; 
          ?>
        </a>
        <small class="text-muted">
          <?php 
          // Tampilkan role
          echo isSuperAdmin() ? 'Superadmin' : 'Administrator'; 
          ?>
        </small>
      </div>
    </div>

    <!-- Menu Sidebar -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Pending Confess -->
        <li class="nav-item">
          <a href="pending.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pending.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-clock"></i>
            <p>
              Pending Confess
              <?php
              // Tampilkan badge jumlah pending
              $totalPending = getTotalPending();
              if ($totalPending > 0) {
                  echo "<span class='badge badge-warning right'>$totalPending</span>";
              }
              ?>
            </p>
          </a>
        </li>

        <!-- Approved Confess -->
        <li class="nav-item">
          <a href="approved.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'approved.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-check-circle"></i>
            <p>Approved Confess</p>
          </a>
        </li>

        <!-- Rejected Confess -->
        <li class="nav-item">
          <a href="rejected.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'rejected.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-times-circle"></i>
            <p>Rejected Confess</p>
          </a>
        </li>

        <li class="nav-header">MERCHANDISE</li>

        <!-- Products (All Admins) -->
        <li class="nav-item">
          <a href="products.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>Products</p>
          </a>
        </li>

        <?php if (isSuperAdmin()): ?>
        <li class="nav-header">SUPERADMIN</li>

        <!-- Manage Admins (Superadmin Only) -->
        <li class="nav-item">
          <a href="manage-admins.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage-admins.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Manage Admins
              <?php
              // Badge untuk pending admins
              $pendingCount = count(getPendingAdmins());
              if ($pendingCount > 0) {
                  echo "<span class='badge badge-danger right'>$pendingCount</span>";
              }
              ?>
            </p>
          </a>
        </li>
        <?php endif; ?>

        <li class="nav-header">AKSI</li>

        <!-- Change Password -->
        <li class="nav-item">
          <a href="change-password.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'change-password.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-key"></i>
            <p>Ganti Password</p>
          </a>
        </li>

        <!-- Lihat Website -->
        <li class="nav-item">
          <a href="../index.php" target="_blank" class="nav-link">
            <i class="nav-icon fas fa-external-link-alt"></i>
            <p>Lihat Website</p>
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="../logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>

  </div>
</aside>

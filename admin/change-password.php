<?php 
/**
 * Halaman Ganti Password
 * Mengizinkan semua admin untuk mengganti password mereka sendiri
 */

require_once "../function.php";
requireLogin();

$error = '';
$success = '';

// Proses ganti password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Cek data lengkap ga
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'Semua field harus diisi!';
    } else if ($newPassword !== $confirmPassword) {
        $error = 'Password baru dan konfirmasi password tidak cocok!';
    } else if (strlen($newPassword) < 6) {
        $error = 'Password baru minimal 6 karakter!';
    } else {
        // Proses ganti password
        startSession();
        $userId = $_SESSION['admin_id'];
        $result = changePassword($userId, $oldPassword, $newPassword);
        
        if ($result['success']) {
            $success = $result['message'];
        } else {
            $error = $result['message'];
        }
    }
}

include "templates/header.php";
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ganti Password</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item active">Ganti Password</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Cek superadmin blom pernah ganti username -->
    <?php if (isSuperAdmin() && !getUserById($_SESSION['admin_id'])['is_username_changed']): ?>
    <div class="row mb-3">
      <div class="col-12">
        <div class="alert alert-warning">
          <h5><i class="icon fas fa-exclamation-triangle"></i> Ganti Username (Sekali Pakai)</h5>
          Anda belum mengubah username default Superadmin. Fitur ini hanya tersedia satu kali.
          <br>
          <a href="change-username.php" class="btn btn-outline-dark mt-2">Ganti Username Sekarang</a>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            
            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fas fa-check-circle"></i> <?= $success ?>
            </div>
            <?php endif; ?>

            <form method="POST">
              <div class="form-group">
                <label>Password Lama *</label>
                <div style="position: relative;">
                  <input type="password" name="old_password" id="old_password" class="form-control" required style="padding-right: 45px;">
                  <button type="button" class="btn-toggle-password" onclick="togglePassword('old_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 5px;">
                    <i class="fas fa-eye" style="color: #FF4F9D; font-size: 1.2rem;"></i>
                  </button>
                </div>
              </div>

              <div class="form-group">
                <label>Password Baru *</label>
                <div style="position: relative;">
                  <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6" style="padding-right: 45px;">
                  <button type="button" class="btn-toggle-password" onclick="togglePassword('new_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 5px;">
                    <i class="fas fa-eye" style="color: #FF4F9D; font-size: 1.2rem;"></i>
                  </button>
                </div>
                <small class="text-muted">Minimal 6 karakter</small>
              </div>

              <div class="form-group">
                <label>Konfirmasi Password Baru *</label>
                <div style="position: relative;">
                  <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6" style="padding-right: 45px;">
                  <button type="button" class="btn-toggle-password" onclick="togglePassword('confirm_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 5px;">
                    <i class="fas fa-eye" style="color: #FF4F9D; font-size: 1.2rem;"></i>
                  </button>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Ganti Password
                </button>
                <a href="index.php" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Batal
                </a>
              </div>
            </form>

            <script>
            function togglePassword(fieldId, button) {
              const field = document.getElementById(fieldId);
              const icon = button.querySelector('i');
              
              if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
              } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
              }
            }
            </script>

            <style>
            .btn-toggle-password:hover i {
              color: #FF2F88 !important;
            }
            
            .btn-toggle-password:focus {
              outline: none;
            }
            </style>

          </div>
        </div>

        <!-- Info Card -->
        <div class="card">
          <div class="card-header bg-info text-white">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Keamanan</h3>
          </div>
          <div class="card-body">
            <ul class="mb-0">
              <li>Gunakan password yang kuat dan unik</li>
              <li>Jangan bagikan password Anda kepada siapapun</li>
              <li>Ganti password secara berkala untuk keamanan</li>
              <li>Password minimal 6 karakter</li>
              <li>Hubungi SuperAdmin jika ada masalah</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "templates/footer.php"; ?>

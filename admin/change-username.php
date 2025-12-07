<?php
/**
 * Halaman Ganti Username (Khusus Superadmin - Sekali Pakai)
 */

require_once "../function.php";
requireLogin();
requireSuperAdmin();

$adminId = $_SESSION['admin_id'];
$user = getUserById($adminId);

// Cek apakah sudah pernah ganti username
if ($user['is_username_changed']) {
    header("Location: change-password.php?error=Username hanya bisa diganti satu kali!");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['new_username'] ?? '');
    
    // Cek input bener ga
    if (empty($newUsername)) {
        $error = 'Username baru tidak boleh kosong!';
    } else if (strlen($newUsername) < 4) {
        $error = 'Username minimal 4 karakter!';
    } else if (!preg_match('/^[a-zA-Z0-9_-]+$/', $newUsername)) {
        $error = 'Username hanya boleh huruf, angka, strip, dan underscore!';
    } else if (getUserByUsername($newUsername)) {
        $error = 'Username sudah digunakan!';
    } else {
        // Proses ganti username
        if (changeSuperAdminUsername($adminId, $newUsername)) {
            // Update session
            $_SESSION['admin_username'] = $newUsername;
            header("Location: change-password.php?success=Username berhasil diganti menjadi $newUsername. Perubahan ini permanen.");
            exit;
        } else {
            $error = 'Gagal mengganti username!';
        }
    }
}

include "templates/header.php";
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ganti Username</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="change-password.php">Profile</a></li>
          <li class="breadcrumb-item active">Ganti Username</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> PERINGATAN PENTING</h3>
          </div>
          <div class="card-body">
            <p>Fitur ini hanya dapat digunakan <strong>SATU KALI SAJA</strong>.</p>
            <p>Setelah Anda mengubah username, Anda <strong>TIDAK DAPAT</strong> mengubahnya lagi di masa depan.</p>
            <p>Username saat ini: <strong><?= htmlspecialchars($user['username']) ?></strong></p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <?php if ($error): ?>
            <div class="alert alert-danger">
              <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
            <?php endif; ?>

            <form method="POST">
              <div class="form-group">
                <label>Username Baru *</label>
                <input type="text" name="new_username" class="form-control" required minlength="4" placeholder="Masukkan username baru">
                <small class="text-muted">Hanya huruf, angka, strip (-), dan underscore (_). Min 4 karakter.</small>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-warning" onclick="return confirm('Yakin ingin mengganti username? Perubahan ini PERMANEN dan hanya bisa dilakukan SEKALI.')">
                  <i class="fas fa-save"></i> Simpan Permanen
                </button>
                <a href="change-password.php" class="btn btn-secondary">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "templates/footer.php"; ?>

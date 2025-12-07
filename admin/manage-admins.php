<?php 
/**
 * Halaman Manage  Admins (Superadmin Only)
 * Untuk menyetujui atau menolak admin yang mendaftar
 */

require_once "../function.php";

// Harus login dan harus superadmin
requireLogin();
requireSuperAdmin();

// Ambil data pending dan approved admins
$pendingAdmins = getPendingAdmins();
$approvedAdmins = getApprovedAdmins();

include "templates/header.php"; 
?>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Manage Admins</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item active">Manage Admins</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    
    <!-- Notifikasi Sukses/Gagal -->
    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
      </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>
    
    <!-- Daftar Admin yang Masih Pending -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background:#FF4F9D; color:white;">
            <h3 class="card-title"><i class="fas fa-user-clock"></i> Pending Admin Approval</h3>
          </div>
          <div class="card-body">
            <?php if (empty($pendingAdmins)): ?>
              <p class="text-muted text-center">Tidak ada admin yang menunggu persetujuan.</p>
            <?php else: ?>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="80">ID</th>
                    <th>Username</th>
                    <th width="200">Tanggal Daftar</th>
                    <th width="150">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pendingAdmins as $admin): ?>
                  <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><strong><?= htmlspecialchars($admin['username']) ?></strong></td>
                    <td><?= date('d M Y H:i', strtotime($admin['created_at'])) ?> WIB</td>
                    <td>
                      <a href="approve-admin.php?id=<?= $admin['id'] ?>" class="btn btn-success btn-sm" 
                         onclick="return confirm('Setujui admin ini?')">
                        <i class="fas fa-check"></i> Approve
                      </a>
                      <a href="reject-admin.php?id=<?= $admin['id'] ?>" class="btn btn-danger btn-sm" 
                         onclick="return confirm('Tolak dan hapus admin ini?')">
                        <i class="fas fa-times"></i> Reject
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>


    <div class="row mt-3">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-success text-white">
            <h3 class="card-title"><i class="fas fa-user-check"></i> Approved Admins</h3>
          </div>
          <div class="card-body">
            <?php if (empty($approvedAdmins)): ?>
              <p class="text-muted text-center">Belum ada admin yang disetujui.</p>
            <?php else: ?>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="80">ID</th>
                    <th>Username</th>
                    <th width="200">Tanggal Daftar</th>
                    <th width="200">Disetujui Pada</th>
                    <th width="180">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($approvedAdmins as $admin): ?>
                  <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><strong><?= htmlspecialchars($admin['username']) ?></strong></td>
                    <td><?= date('d M Y H:i', strtotime($admin['created_at'])) ?> WIB</td>
                    <td>
                      <?php if ($admin['approved_at']): ?>
                        <?= date('d M Y H:i', strtotime($admin['approved_at'])) ?> WIB
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <button type="button" 
                              class="btn btn-warning btn-sm btn-reset-password" 
                              data-id="<?= $admin['id'] ?>"
                              data-username="<?= htmlspecialchars($admin['username']) ?>"
                              title="Reset Password">
                        <i class="fas fa-key"></i>
                      </button>
                      <a href="delete-admin.php?id=<?= $admin['id'] ?>" 
                         class="btn btn-danger btn-sm" 
                         onclick="return confirm('PERINGATAN: Hapus admin <?= htmlspecialchars($admin['username']) ?>? Tindakan ini tidak dapat dibatalkan!')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php include "templates/footer.php"; ?>

<!-- Modal Reset Password -->
<div class="modal fade" id="modalResetPassword" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="fas fa-key"></i> Reset Password Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="reset-admin-password.php" method="POST">
        <div class="modal-body">
          <input type="hidden" name="id" id="reset_admin_id">
          
          <p>Anda akan mereset password untuk admin: <strong id="reset_admin_username"></strong></p>
          
          <div class="form-group">
            <label>Password Baru (Default / Custom)</label>
            <input type="text" name="password" class="form-control" value="admin-tifess-1234" required>
            <small class="text-muted">Ganti password di atas jika ingin menggunakan password custom.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Reset Password</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.btn-reset-password').click(function() {
      var id = $(this).data('id');
      var username = $(this).data('username');
      
      $('#reset_admin_id').val(id);
      $('#reset_admin_username').text(username);
      $('#modalResetPassword').modal('show');
    });
  });
</script>

<?php 
/**
 * Halaman Pending Confess
 * List Confess yang Belum Di-ACC
 */

require_once "../function.php";
session_start();

// Cek udah login belum
if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit;
}

include "templates/header.php"; 

// Ambil data confess yang masih pending
$pending = getPending();

// Cek pesan notifikasi
$success = $_GET['success'] ?? '';
?>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pending Confess</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item active">Pending</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    
    <!-- Notifikasi Success -->
    <?php if ($success == 'approved'): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check-circle"></i> Confess berhasil di-approve!
      </div>
    <?php elseif ($success == 'rejected'): ?>
      <div class="alert alert-info alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-times-circle"></i> Confess berhasil di-reject!
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header" style="background:#FF4F9D; color:white;">
        <h3 class="card-title">
          <i class="fas fa-clock"></i> Daftar Confess Pending (<?= count($pending) ?>)
        </h3>
      </div>
      <div class="card-body">
        <?php if (empty($pending)): ?>
          <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <p class="text-muted">Tidak ada confess pending saat ini.</p>
          </div>
        <?php else: ?>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="100">No</th>
                <th width="120">Nomor</th>
                <th>Isi Confess</th>
                <th width="150">Kategori</th>
                <th width="180">Tanggal</th>
                <th width="120">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              foreach ($pending as $c): 
              ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><code><?= htmlspecialchars($c['nomor']) ?></code></td>
                <td><?= nl2br(htmlspecialchars($c['isi'])) ?></td>
                <td>
                  <?php if ($c['kategori']): ?>
                    <span class="badge badge-secondary"><?= htmlspecialchars($c['kategori']) ?></span>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td><?= date('d M Y H:i', strtotime($c['tanggal'])) ?> WIB</td>
                <td>
                  <a href="approve.php?id=<?= $c['id'] ?>" 
                     class="btn btn-success btn-sm mb-1" 
                     onclick="return confirm('Approve confess ini?')"
                     title="Approve">
                    <i class="fas fa-check"></i>
                  </a>
                  <a href="reject.php?id=<?= $c['id'] ?>" 
                     class="btn btn-danger btn-sm mb-1" 
                     onclick="return confirm('Reject confess ini?')"
                     title="Reject">
                    <i class="fas fa-times"></i>
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
</section>

<?php include "templates/footer.php"; ?>

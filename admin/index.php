<?php 
/**
 * Dashboard Admin
 * Menampilkan statistik dan confess pending terbaru
 */

// Include function SEBELUM header untuk session
require_once "../function.php";
session_start();

// Cek apakah admin sudah login
if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit;
}

include "templates/header.php"; 

// Ambil statistik
$totalPending = getTotalPending();
$totalAcc = getTotalAcc();
$totalReject = getTotalReject();

// Ambil 5 confess pending terbaru
$recentPending = array_slice(getPending(), 0, 5);
?>

<!-- Header Halaman -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Isi Konten Utama -->
<section class="content">
  <div class="container-fluid">
    
    <!-- Card Statistik -->
    <div class="row">
      
      <!-- Card Pending -->
      <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= $totalPending ?></h3>
            <p>Pending Confess</p>
          </div>
          <div class="icon">
            <i class="fas fa-clock"></i>
          </div>
          <a href="pending.php" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Card Approved -->
      <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $totalAcc ?></h3>
            <p>Approved Confess</p>
          </div>
          <div class="icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <a href="approved.php" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Card Rejected -->
      <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= $totalReject ?></h3>
            <p>Rejected Confess</p>
          </div>
          <div class="icon">
            <i class="fas fa-times-circle"></i>
          </div>
          <a href="rejected.php" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    </div>

    <!-- Tabel Confess Pending Terbaru -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background:#FF4F9D; color:white;">
            <h3 class="card-title"><i class="fas fa-list"></i> Confess Pending Terbaru</h3>
          </div>
          <div class="card-body">
            <?php if (empty($recentPending)): ?>
              <p class="text-muted text-center">Tidak ada confess pending saat ini.</p>
            <?php else: ?>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="120">Nomor</th>
                    <th>Isi Confess</th>
                    <th width="150">Kategori</th>
                    <th width="180">Tanggal</th>
                    <th width="150">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($recentPending as $c): ?>
                  <tr>
                    <td><code><?= htmlspecialchars($c['nomor']) ?></code></td>
                    <td>
                      <?php 
                      // Tampilkan preview isi confess (100 karakter pertama)
                      $isi = htmlspecialchars($c['isi']);
                      echo strlen($isi) > 100 ? substr($isi, 0, 100) . '...' : $isi;
                      ?>
                    </td>
                    <td>
                      <?php if ($c['kategori']): ?>
                        <span class="badge badge-secondary"><?= htmlspecialchars($c['kategori']) ?></span>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>
                    <td><?= date('d M Y H:i', strtotime($c['tanggal'])) ?> WIB</td>
                    <td>
                      <a href="approve.php?id=<?= $c['id'] ?>" class="btn btn-success btn-sm" 
                         onclick="return confirm('Approve confess ini?')">
                        <i class="fas fa-check"></i>
                      </a>
                      <a href="reject.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" 
                         onclick="return confirm('Reject confess ini?')">
                        <i class="fas fa-times"></i>
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <div class="mt-3 text-center">
                <a href="pending.php" class="btn btn-outline-primary">
                  Lihat Semua Pending <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php include "templates/footer.php"; ?>

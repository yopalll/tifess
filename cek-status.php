<?php

require_once "function.php";
session_start();

include "templates/header.php";

$nomor = $_GET['nomor'] ?? '';

$data  = $nomor ? cekStatus($nomor) : null;
?>

<div class="container py-5 fade-in" style="max-width: 700px; min-height: 75vh;">

  
  <div class="text-center mb-5 slide-in-down">
    <h2 class="fw-bold display-5 mb-3">
      <i class="fas fa-search text-pink me-2" style="animation: bounce 1s ease-in-out infinite;"></i>
      <span style="background: linear-gradient(135deg, #FF4F9D, #8C52FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
        Cek Status Confess
      </span>
    </h2>
    <p class="lead text-muted">Masukkan nomor confess kamu untuk melihat status moderasi</p>
  </div>

  
  <div class="card border-0 shadow-sm mb-4 scale-up" style="border-radius: 20px; overflow: hidden;">
    <div style="height: 5px; background: linear-gradient(90deg, #FF4F9D, #8C52FF, #FF4F9D); animation: shimmer 3s infinite;"></div>

    <div class="card-body p-4">
      <form method="GET" class="d-flex gap-2">
        <input
          type="text"
          name="nomor"
          class="form-control"
          placeholder="Contoh: CONF-20250001"
          value="<?= htmlspecialchars($nomor) ?>"
          style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500;"
          required
        >
        <button class="btn btn-pink px-4" type="submit" style="border-radius: 12px; font-weight: 700;">
          <i class="fas fa-check-circle me-1"></i> Cek
        </button>
      </form>
    </div>
  </div>

  
  <?php if (!$nomor): ?>
    <div class="text-center py-5 fade-in">
      <i class="fas fa-inbox text-pink" style="font-size: 3rem; opacity: 0.5; margin-bottom: 1rem;"></i>
      <p class="text-muted" style="font-weight: 500; margin-bottom: 0.5rem;">
        Silakan masukkan nomor confess terlebih dahulu
      </p>
      <small class="text-muted">
        Nomor confess diberikan saat kamu mengirim confess baru
      </small>
      <div class="mt-4">
        <a href="form-confess.php" class="btn btn-outline-pink">
          <i class="fas fa-feather me-1"></i> Kirim Confess Baru
        </a>
      </div>
    </div>

  
  <?php elseif (!$data): ?>
    <div class="alert alert-danger border-0 shadow-sm scale-up" style="border-radius: 15px; border-left: 5px solid #FF6B6B;">
      <div class="d-flex align-items-center">
        <i class="fas fa-times-circle me-3" style="font-size: 1.5rem;"></i>
        <div>
          <strong style="display: block; margin-bottom: 4px;">Nomor Tidak Ditemukan</strong>
          <small>Nomor confess <strong><?= htmlspecialchars($nomor) ?></strong> tidak ditemukan dalam sistem kami.</small>
          <br>
          <small>Pastikan nomor yang Anda masukkan sudah benar.</small>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="form-confess.php" class="btn btn-pink">
        <i class="fas fa-feather me-1"></i> Kirim Confess Baru
      </a>
    </div>

  
  <?php else: ?>
    
    <div class="card border-0 shadow-sm scale-up" style="border-radius: 20px; overflow: hidden;">
      <div style="height: 5px; background: linear-gradient(90deg, #8C52FF, #FF4F9D, #8C52FF); animation: shimmer 3s infinite; animation-delay: 0.3s;"></div>

      <div class="card-body p-4">
        
        <div class="text-center mb-4">
          <?php if($data['status'] == 'pending'): ?>
            <div style="display: inline-block; background: linear-gradient(135deg, rgba(255, 217, 61, 0.15), rgba(255, 193, 7, 0.15)); padding: 15px 30px; border-radius: 15px;">
              <i class="fas fa-hourglass-half text-warning" style="font-size: 2rem;"></i>
              <p class="fw-bold text-warning mt-2" style="font-size: 1.1rem;">Menunggu Moderasi</p>
              <small class="text-muted">Confess Anda sedang dalam proses review</small>
            </div>
          <?php elseif($data['status'] == 'acc'): ?>
            <div style="display: inline-block; background: linear-gradient(135deg, rgba(78, 205, 196, 0.15), rgba(54, 163, 157, 0.15)); padding: 15px 30px; border-radius: 15px;">
              <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
              <p class="fw-bold text-success mt-2" style="font-size: 1.1rem;">Diterima ✓</p>
              <small class="text-muted">Confess Anda telah dipublikasikan di Mading</small>
            </div>
          <?php else: ?>
            <div style="display: inline-block; background: linear-gradient(135deg, rgba(255, 107, 107, 0.15), rgba(255, 75, 75, 0.15)); padding: 15px 30px; border-radius: 15px;">
              <i class="fas fa-times-circle text-danger" style="font-size: 2rem;"></i>
              <p class="fw-bold text-danger mt-2" style="font-size: 1.1rem;">Ditolak</p>
              <small class="text-muted">Confess Anda tidak memenuhi kriteria</small>
            </div>
          <?php endif; ?>
        </div>

        
        <hr style="border-color: rgba(255, 79, 157, 0.2);">

        
        <div class="mt-4">
          
          <div class="mb-4 p-3" style="background: #FFE6F2; border-radius: 12px; border-left: 4px solid #FF4F9D;">
            <small class="text-muted d-block" style="margin-bottom: 4px;">Nomor Confess</small>
            <p class="fw-bold text-pink mb-0" style="font-size: 1.1rem;">
              <?= htmlspecialchars($data['nomor']) ?>
            </p>
          </div>

          
          <div class="row mb-4">
            <div class="col-6">
              <small class="text-muted d-block" style="margin-bottom: 4px;">Kategori</small>
              <p class="fw-bold mb-0">
                <?php if (!empty($data['kategori'])): ?>
                  <span class="badge badge-pink">
                    <?= htmlspecialchars($data['kategori']) ?>
                  </span>
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </p>
            </div>
            <div class="col-6 text-end">
              <small class="text-muted d-block" style="margin-bottom: 4px;">Tanggal Dikirim</small>
              <p class="fw-bold mb-0 small">
                <?= date('d M Y H:i', strtotime($data['tanggal'])) ?> WIB
              </p>
            </div>
          </div>

          
          <div>
            <small class="text-muted d-block" style="margin-bottom: 8px;">Isi Confess</small>
            <div class="p-3 rounded" style="background: linear-gradient(135deg, #FFE6F2, #FFF0F6); border-left: 4px solid #8C52FF;">
              <p style="white-space: pre-line; color: #555; font-weight: 500; margin-bottom: 0;">
                <?= htmlspecialchars($data['isi']) ?>
              </p>
            </div>
          </div>
        </div>

        
        <div class="text-center mt-4 pt-4" style="border-top: 1px solid rgba(255, 79, 157, 0.2);">
          <a href="form-confess.php" class="btn btn-pink btn-sm">
            <i class="fas fa-feather me-1"></i> Kirim Confess Lagi
          </a>
          <a href="mading.php" class="btn btn-outline-pink btn-sm ms-2">
            <i class="fas fa-comments me-1"></i> Lihat Mading
          </a>
        </div>
      </div>
    </div>

  <?php endif; ?>

</div>

<style>
  @keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
  }

  body.dark-mode .card {
    background: #0f3460;
    color: #ddd;
  }

  body.dark-mode .card-body {
    color: #ddd;
  }

  body.dark-mode .form-control {
    background: #16213e;
    border-color: rgba(255, 79, 157, 0.3);
    color: #ddd;
  }

  body.dark-mode .text-muted {
    color: #aaa !important;
  }

  body.dark-mode [style*="background: #FFE6F2"] {
    background: rgba(255, 79, 157, 0.2) !important;
  }

  @media (max-width: 768px) {
    .card-body form.d-flex {
      display: flex;
      flex-wrap: wrap;
    }

    .card-body form input.form-control {
      flex: 1 1 100%;
      min-height: 48px;
      font-size: 16px;
      margin-bottom: 12px;
    }

    .card-body form button.btn {
      flex: 1 1 100%;
      min-height: 48px;
      padding: 14px 20px !important;
    }
  }

  @media (max-width: 991px) and (min-width: 769px) {
    .card-body form input.form-control {
      min-height: 46px;
    }

    .card-body form button.btn {
      min-height: 46px;
      padding: 12px 24px !important;
    }
  }
</style>

<?php include "templates/footer.php"; ?>

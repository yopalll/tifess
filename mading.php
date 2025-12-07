<?php
require_once "function.php";
session_start();

$perPage = 9;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalConfess = getTotalAccCount();
$totalPages = ceil($totalConfess / $perPage);
$data = getAccWithPagination($page, $perPage);

include "templates/header.php";
?>

<div class="container py-5 fade-in" style="min-height: 75vh;">

  <div class="text-center mb-5 slide-in-down">
    <h2 class="fw-bold mb-3 display-5">
      <i class="fas fa-comments text-pink me-2" style="animation: bounce 1s ease-in-out infinite;"></i>
      <span style="background: linear-gradient(135deg, #FF4F9D, #8C52FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
        Mading TIFESS
      </span>
    </h2>
    <p class="lead" style="color: #666; font-weight: 500;">
      <i class="fas fa-heart text-pink me-2" style="animation: heartPulse 1s ease-in-out infinite;"></i>
      Confess yang telah di-ACC akan muncul di sini
    </p>
  </div>

  <div class="row g-4">
    <?php
    $itemCount = 0;

    if (empty($data)) {
        echo "
        <div class='col-12 text-center py-5'>
          <i class='fas fa-inbox text-pink' style='font-size: 3rem; opacity: 0.5;'></i>
          <p class='text-muted mt-3' style='font-weight: 500;'>Belum ada confess yang dipublikasikan.</p>
          <p class='small text-muted'>Jadilah yang pertama untuk membagikan ceritamu! 💕</p>
          <a href='form-confess.php' class='btn btn-pink btn-sm mt-3'>
            <i class='fas fa-feather me-1'></i> Kirim Confess
          </a>
        </div>
        ";
    }

    foreach ($data as $c):
      $itemCount++;
    ?>
    <div class="col-12 col-md-6 col-lg-4 stagger-item">
      <div class="card border-0 card-confess h-100" style="border-radius: 20px; overflow: hidden; position: relative;">

        <div style="height: 4px; background: linear-gradient(90deg, #FF4F9D, #8C52FF, #FF4F9D); animation: shimmer 3s infinite;"></div>

        <div class="card-body">
          <div class="mb-3">
            <i class="fas fa-heart text-pink" style="font-size: 1.3rem; animation: heartPulse 0.8s ease-in-out infinite; opacity: 0.8;"></i>
          </div>

          <p class="card-text" style="white-space: pre-line; color: #918f8fff; line-height: 1.6; font-weight: 500;">
            <?= htmlspecialchars($c['isi']) ?>
          </p>

          <hr style="border-color: rgba(255, 79, 157, 0.2);">

          <?php if (!empty($c['kategori'])): ?>
          <div class="mb-3">
            <span class="badge badge-pink" style="animation: pulse 2s ease-in-out infinite;">
              <i class="fas fa-tag me-1"></i> <?= htmlspecialchars($c['kategori']) ?>
            </span>
          </div>
          <?php endif; ?>

          <div class="mt-4 pt-3" style="border-top: 1px solid rgba(255, 79, 157, 0.1);">
            <small class="text-muted d-flex align-items-center">
              <i class="fas fa-clock me-2" style="color: #FF4F9D;"></i>
              <?= date('d M Y H:i', strtotime($c['tanggal'])); ?> WIB
            </small>
          </div>
        </div>

        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255, 79, 157, 0.02), rgba(140, 82, 255, 0.02)); pointer-events: none; border-radius: 20px;"></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <?php if ($totalPages > 1): ?>
  <div class="row mt-5">
    <div class="col-12">
      <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
  <?php endif; ?>

  <?php if (!empty($data)): ?>
  <div class="row mt-5 pt-5 fade-in">
    <div class="col-12 text-center">
      <div class="card border-0 shadow-sm no-hover" style="border-radius: 20px; background: linear-gradient(135deg, rgba(255, 79, 157, 0.05), rgba(140, 82, 255, 0.05));">
        <div class="card-body py-5 px-4">
          <h5 class="text-pink fw-bold mb-3">Ingin Berbagi Cerita?</h5>
          <p class="text-muted mb-4">Curhatkan cerita, perasaan, atau rahasia kamu secara anonim dan aman.</p>
          <a href="form-confess.php" class="btn btn-pink btn-lg px-5 hover-lift">
            <i class="fas fa-feather me-2"></i> Kirim Confess Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<style>
  .card-confess {
    background: white;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .card-confess:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(255, 79, 157, 0.2);
  }

  .badge-pink {
    background: linear-gradient(135deg, #FF4F9D, #FF2F88);
    color: white;
    padding: 8px 16px;
    border-radius: 30px;
    font-weight: 600;
  }

  .card.no-hover {
    transition: none !important;
  }

  .card.no-hover:hover {
    transform: none !important;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
  }

  .card.border-0.shadow-sm.no-hover:hover {
    transform: none !important;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
  }

  body.dark-mode .card-confess {
    background: rgba(255, 79, 157, 0.02);
    color: #eee;
  }

  body.dark-mode .card-confess .card-text {
    color: #ddd;
  }

  body.dark-mode .card-confess hr {
    border-color: rgba(255, 79, 157, 0.3);
  }

  .stagger-item {
    animation: fadeIn 0.6s ease-out;
  }

  .stagger-item:nth-child(1) { animation-delay: 0.1s; }
  .stagger-item:nth-child(2) { animation-delay: 0.2s; }
  .stagger-item:nth-child(3) { animation-delay: 0.3s; }
  .stagger-item:nth-child(4) { animation-delay: 0.4s; }
  .stagger-item:nth-child(5) { animation-delay: 0.5s; }
  .stagger-item:nth-child(6) { animation-delay: 0.6s; }
  .stagger-item:nth-child(n+7) { animation-delay: 0.7s; }

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

  @keyframes shimmer {
    0% {
      background-position: -1000px 0;
    }
    100% {
      background-position: 1000px 0;
    }
  }

  .slide-in-down {
    animation: slideInDown 0.6s ease-out;
  }

  .pagination {
    gap: 15px;
    align-items: center;
    padding: 20px 0;
  }

  .pagination .page-item {
    margin: 0;
  }

  .pagination .page-link {
    width: 40px;
    height: 40px;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    color: #FF4F9D;
    background: white;
    border: none;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 5px 15px rgba(255, 79, 157, 0.15);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
    position: relative;
    z-index: 1;
  }

  .pagination .page-link:hover {
    transform: scale(1.2);
    background: #fff;
    color: #FF2F88;
    box-shadow: 0 8px 20px rgba(255, 79, 157, 0.3);
    z-index: 2;
  }

  .pagination .page-item.active .page-link {
    transform: scale(1.35);
    background: linear-gradient(135deg, #FF4F9D, #8C52FF);
    color: white;
    box-shadow: 0 10px 25px rgba(255, 79, 157, 0.4);
    z-index: 3;
  }

  .pagination .page-item.active .page-link:hover {
    transform: scale(1.35);
    box-shadow: 0 12px 30px rgba(255, 79, 157, 0.5);
  }

  body.dark-mode .pagination .page-link {
    background: transparent;
    color: #FFB6D9;
    box-shadow: none;
    border: 1px solid rgba(255, 79, 157, 0.2);
  }

  body.dark-mode .pagination .page-link:hover {
    background: rgba(255, 79, 157, 0.1);
    color: white;
    border-color: #FF4F9D;
    box-shadow: 0 0 15px rgba(255, 79, 157, 0.4);
  }

  body.dark-mode .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #FF4F9D, #8C52FF);
    color: white;
    border: none;
    box-shadow: 0 0 20px rgba(255, 79, 157, 0.6);
  }
</style>

<?php include "templates/footer.php"; ?>

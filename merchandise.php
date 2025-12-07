<?php
require_once "function.php";
session_start();

$perPage = 9;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalProducts = getTotalProductsCount();
$totalPages = ceil($totalProducts / $perPage);
$products = getProductsWithPagination($page, $perPage);

include "templates/header.php";
?>

<div class="container py-5 fade-in">
  <div class="text-center mb-5 slide-in-down">
    <h1 class="fw-bold display-4 mb-3" style="display: flex; justify-content: center; align-items: center;">
      <i class="fas fa-gift text-pink me-2" style="animation: bounce 1s ease-in-out infinite;"></i>
      <span style="background: linear-gradient(135deg, #FF4F9D, #8C52FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-left: -60px;">
        TIFESS Merchandise
      </span>
    </h1>
    <p class="lead text-muted">Koleksi merchandise official eksklusif dari TIFESS</p>
    <p class="text-muted small">
      <i class="fas fa-heart text-pink me-1" style="animation: heartPulse 1s ease-in-out infinite;"></i>
      Setiap pembelian adalah dukungan untuk kami
    </p>
  </div>

  <?php if (empty($products)): ?>
    <div class="text-center py-5 fade-in">
      <i class="fas fa-shopping-bag text-pink" style="font-size: 3rem; opacity: 0.5; margin-bottom: 1rem;"></i>
      <h5 class="text-muted fw-bold mb-2">Belum ada produk tersedia</h5>
      <p class="text-muted small mb-4">
        Kami sedang mempersiapkan koleksi merchandise terbaru untuk kalian. Tunggu sebentar!
      </p>
      <a href="index.php" class="btn btn-pink">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Home
      </a>
    </div>

  <?php else: ?>
    <div class="row g-4">
      <?php
        $itemCount = 0;
        foreach ($products as $product):
          $itemCount++;
      ?>
      <div class="col-md-6 col-lg-4 stagger-item">
        <div class="card h-100 product-card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; position: relative;">

          <div style="height: 4px; background: linear-gradient(90deg, #FF4F9D, #8C52FF, #FF4F9D); animation: shimmer 3s infinite;"></div>

          <div style="position: relative; overflow: hidden; height: 250px; background: linear-gradient(135deg, #FFE6F2, #FFF0F6);">
            <?php if ($product['image']): ?>
              <img src="<?= htmlspecialchars($product['image']) ?>"
                   class="card-img-top hover-scale"
                   alt="<?= htmlspecialchars($product['name']) ?>"
                   style="height: 100%; object-fit: cover; width: 100%; transition: all 0.3s ease;">
            <?php else: ?>
              <div class="d-flex align-items-center justify-content-center h-100">
                <div class="text-center">
                  <i class="fas fa-image text-pink" style="font-size: 2.5rem; opacity: 0.5;"></i>
                  <p class="text-muted small mt-2">Tidak ada gambar</p>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($product['stock'] > 0): ?>
              <div style="position: absolute; top: 12px; right: 12px;">
                <span class="badge badge-success" style="background: linear-gradient(135deg, #4ECDC4, #36A39D); padding: 8px 12px; font-weight: 700;">
                  <i class="fas fa-check-circle me-1"></i> In Stock
                </span>
              </div>
            <?php else: ?>
              <div style="position: absolute; top: 12px; right: 12px;">
                <span class="badge badge-danger" style="background: linear-gradient(135deg, #FF6B6B, #FF4757); padding: 8px 12px; font-weight: 700;">
                  <i class="fas fa-times-circle me-1"></i> Out of Stock
                </span>
              </div>
            <?php endif; ?>
          </div>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title fw-bold text-pink mb-2" style="font-size: 1.1rem;">
              <?= htmlspecialchars($product['name']) ?>
            </h5>

            <p class="card-text text-muted small flex-grow-1" style="line-height: 1.5;">
              <?= htmlspecialchars($product['description']) ?>
            </p>

            <hr style="border-color: rgba(255, 79, 157, 0.2); margin: 1rem 0;">

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <small class="text-muted d-block">Harga</small>
                <h4 class="mb-0" style="color: #FF4F9D; font-weight: 700;">
                  Rp <?= number_format($product['price'], 0, ',', '.') ?>
                </h4>
              </div>
              <?php if ($product['stock'] > 0): ?>
                <small class="text-muted text-end d-block">
                  <i class="fas fa-boxes text-pink me-1"></i>
                  <?= $product['stock'] ?> tersedia
                </small>
              <?php endif; ?>
            </div>
          </div>

          <div class="card-footer bg-white border-top-0 p-3">
            <?php if ($product['stock'] > 0): ?>
              <a href="order-form.php?product_id=<?= $product['id'] ?>"
                 class="btn btn-pink w-100 hover-lift"
                 style="border-radius: 12px; font-weight: 700;">
                <i class="fas fa-shopping-cart me-2"></i> Pesan Sekarang
              </a>
            <?php else: ?>
              <button class="btn btn-secondary w-100" disabled style="border-radius: 12px; font-weight: 700; opacity: 0.6;">
                <i class="fas fa-times me-2"></i> Stok Habis
              </button>
            <?php endif; ?>
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

    <div class="row mt-5 pt-5 fade-in">
      <div class="col-12">
        <div class="card border-0 shadow-sm no-hover" style="border-radius: 20px; background: linear-gradient(135deg, rgba(255, 79, 157, 0.05), rgba(140, 82, 255, 0.05)); overflow: hidden;">
          <div style="height: 4px; background: linear-gradient(90deg, #8C52FF, #FF4F9D, #8C52FF); animation: shimmer 3s infinite;"></div>

          <div class="card-body py-5 px-4 text-center">
            <h5 class="text-pink fw-bold mb-3">
              <i class="fas fa-heart me-2" style="animation: heartPulse 1s ease-in-out infinite;"></i>
              Ingin berbagi dukungan?
            </h5>
            <p class="text-muted mb-4">
              Setiap pembelian merchandise membantu kami untuk terus berkembang dan melayani komunitas dengan lebih baik.
            </p>
            <a href="form-confess.php" class="btn btn-pink btn-lg px-5 hover-lift">
              <i class="fas fa-feather me-2"></i> Kirim Confess
            </a>
          </div>
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

  .product-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(255, 79, 157, 0.2);
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

  body.dark-mode .product-card {
    background: #0f3460;
  }

  body.dark-mode .card-title {
    color: #FFB6D9 !important;
  }

  body.dark-mode .card-text {
    color: #ddd;
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

  .pagination .page-link {
    color: #FF4F9D;
    border: 1px solid rgba(255, 79, 157, 0.3);
    margin: 0 3px;
    border-radius: 8px;
  }

  .pagination .page-link:hover {
    background: rgba(255, 79, 157, 0.1);
    border-color: #FF4F9D;
  }

  .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #FF4F9D, #8C52FF);
    border-color: #FF4F9D;
  }

  body.dark-mode .pagination .page-link {
    background: rgba(255, 79, 157, 0.05);
    color: #FFB6D9;
  }

  body.dark-mode .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #FF4F9D, #8C52FF);
    color: white;

  }
</style>

<?php include "templates/footer.php"; ?>

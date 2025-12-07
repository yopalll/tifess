<?php 
/**
 * Halaman Products Management
 * Buat Atur Produk Merchandise TIFESS
 */

require_once "../function.php";

// Harus login
requireLogin();

// Ambil semua produk
$products = getProducts();


$success = isset($_GET['success']) ? $_GET['success'] : '';

include "templates/header.php"; 
?>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Merchandise Products</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item active">Products</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    
    <?php if ($success): ?>
    <div class="alert alert-success">
      <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
    </div>
    <?php endif; ?>

    <!-- Tombol Buat Tambah Produk -->
    <div class="row mb-3">
      <div class="col-12">
        <a href="add-product.php" class="btn btn-primary">
          <i class="fas fa-plus"></i> Add New Product
        </a>
      </div>
    </div>

    <!-- List Produk yang Ada -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background:#FF4F9D; color:white;">
            <h3 class="card-title"><i class="fas fa-shopping-bag"></i> All Products</h3>
          </div>
          <div class="card-body">
            <?php if (empty($products)): ?>
              <p class="text-muted text-center">Belum ada produk. Klik tombol "Add New Product" untuk menambahkan.</p>
            <?php else: ?>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="80">ID</th>
                    <th width="100">Image</th>
                    <th>Name</th>
                    <th width="150">Price</th>
                    <th width="100">Stock</th>
                    <th width="180">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($products as $product): ?>
                  <tr>
                    <td><?= $product['id'] ?></td>
                    <td>
                      <?php if ($product['image']): ?>
                        <img src="../<?= htmlspecialchars(ltrim($product['image'], '/')) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="img-thumbnail" style="max-height:60px;">
                      <?php else: ?>
                        <span class="text-muted">No image</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <strong><?= htmlspecialchars($product['name']) ?></strong>
                      <br><small class="text-muted"><?= htmlspecialchars(substr($product['description'], 0, 60)) ?>...</small>
                    </td>
                    <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                    <td>
                      <?php if ($product['stock'] > 0): ?>
                        <span class="badge badge-success"><?= $product['stock'] ?> in stock</span>
                      <?php else: ?>
                        <span class="badge badge-danger">Out of stock</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="edit-product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="delete-product.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" 
                         onclick="return confirm('Delete this product?')">
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

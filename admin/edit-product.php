<?php 
/**
 * Halaman Edit Produk
 */

require_once "../function.php";
requireLogin();

$error = '';
$success = '';

// Ambil ID produk
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = getProductById($productId);

if (!$product) {
    header("Location: products.php");
    exit;
}

// Update data ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    
    // Cek input lengkap ga
    if (empty($name) || empty($price)) {
        $error = 'Name and price are required!';
    } else {
        // Cek ada gambar baru ga
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../assets/img/products/';
            
            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            // Cek tipe file
            $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    // Hapus gambar lama
                    if ($product['image']) {
                        $oldImagePath = ltrim($product['image'], '/');
                        if (file_exists('../' . $oldImagePath)) {
                            unlink('../' . $oldImagePath);
                        }
                    }
                    $imagePath = '/assets/img/products/' . $fileName;
                } else {
                    $error = 'Failed to upload image!';
                }
            } else {
                $error = 'Only JPG, JPEG, PNG & GIF files are allowed!';
            }
        }
        
        if (!$error) {
            // Update produk
            if (updateProduct($productId, $name, $description, $price, $stock, $imagePath)) {
                header("Location: products.php?success=Product updated successfully");
                exit;
            } else {
                $error = 'Failed to update product!';
            }
        }
    }
}

include "templates/header.php";
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Product</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="products.php">Products</a></li>
          <li class="breadcrumb-item active">Edit Product</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header" style="background:#FF4F9D; color:white;">
            <h3 class="card-title"><i class="fas fa-edit"></i> Edit Product Details</h3>
          </div>
          <div class="card-body">
            
            <?php if ($error): ?>
            <div class="alert alert-danger">
              <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" class="form-control" required 
                       value="<?= htmlspecialchars($product['name']) ?>">
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Price (Rp) *</label>
                    <input type="number" name="price" class="form-control" required min="0"
                           value="<?= $product['price'] ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="<?= $product['stock'] ?>">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Current Image</label>
                <div class="mb-2">
                  <?php if ($product['image']): ?>
                    <img src="../<?= htmlspecialchars(ltrim($product['image'], '/')) ?>" 
                         class="img-thumbnail" style="max-height:150px;">
                  <?php else: ?>
                    <span class="text-muted">No image</span>
                  <?php endif; ?>
                </div>
                <label>Change Image (optional)</label>
                <input type="file" name="image" class="form-control-file" accept="image/*">
                <small class="text-muted">Leave empty to keep current image. Max 2MB. Formats: JPG, PNG, GIF</small>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Update Product
                </button>
                <a href="products.php" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Cancel
                </a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "templates/footer.php"; ?>

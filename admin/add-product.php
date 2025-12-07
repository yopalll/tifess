<?php 
/**
 * Add Product Page
 */

require_once "../function.php";
requireLogin();

$error = '';
$success = '';

// Proses tambah produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    
    // Cek data lengkap ga
    if (empty($name) || empty($price)) {
        $error = 'Name and price are required!';
    } else {
        // Upload gambar
        $imagePath = '';
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
                    $imagePath = '/assets/img/products/' . $fileName;
                } else {
                    $error = 'Failed to upload image!';
                }
            } else {
                $error = 'Only JPG, JPEG, PNG & GIF files are allowed!';
            }
        }
        
        if (!$error) {
            // Simpan produk
            if (insertProduct($name, $description, $price, $stock, $imagePath)) {
                header("Location: products.php?success=Product added successfully");
                exit;
            } else {
                $error = 'Failed to add product!';
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
        <h1 class="m-0">Add New Product</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="products.php">Products</a></li>
          <li class="breadcrumb-item active">Add Product</li>
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
            <h3 class="card-title"><i class="fas fa-plus"></i> Product Details</h3>
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
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Price (Rp) *</label>
                    <input type="number" name="price" class="form-control" required min="0">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" value="0" min="0">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" class="form-control-file" accept="image/*">
                <small class="text-muted">Max 2MB. Formats: JPG, PNG, GIF</small>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Save Product
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

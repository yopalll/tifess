<?php

require_once "function.php";
session_start();

$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$product = $productId ? getProductById($productId) : null;

// Kalo ga ada produk, balik ke katalog
if (!$product) {
    header("Location: merchandise.php");
    exit;
}

$whatsappNumber = '6282163257580'; // +62 821-6325-7580

$error = '';

// Proses pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buyerName = trim($_POST['buyer_name'] ?? '');
    $buyerPhone = trim($_POST['buyer_phone'] ?? '');
    $deliveryMethod = $_POST['delivery_method'] ?? '';
    // Cek input data bener ga
    if (!verifyMathCaptcha($_POST['captcha_input'] ?? '')) {
        $error = 'Jawaban keamanan (captcha) salah!';
    }
    elseif (empty($buyerName) || empty($buyerPhone)) {
        $error = 'Nama dan nomor telepon harus diisi!';
    }
    elseif (empty($deliveryMethod)) {
        $error = 'Pilih metode pengambilan/pengiriman!';
    }
    elseif ($deliveryMethod === 'delivery' && empty($buyerAddress)) {
        $error = 'Alamat harus diisi untuk pengiriman ke rumah!';
    }
    elseif (strlen($buyerName) < 3) {
        $error = 'Nama minimal 3 karakter!';
    }
    elseif (strlen($buyerPhone) < 9) {
        $error = 'Nomor telepon minimal 9 digit!';
    }
    elseif ($deliveryMethod === 'delivery' && strlen($buyerAddress) < 10) {
        $error = 'Alamat terlalu pendek, minimal 10 karakter!';
    }
    elseif (preg_match('/<[^>]*>/', $buyerName) || preg_match('/<[^>]*>/', $buyerPhone) || ($deliveryMethod === 'delivery' && preg_match('/<[^>]*>/', $buyerAddress))) {
        $error = 'Input tidak boleh mengandung tag HTML!';
    }
    elseif (preg_match('/https?:\/\/|www\./i', $buyerName) || preg_match('/https?:\/\/|www\./i', $buyerPhone) || ($deliveryMethod === 'delivery' && preg_match('/https?:\/\/|www\./i', $buyerAddress))) {
        $error = 'Input tidak boleh mengandung link/URL!';
    }
    elseif (preg_match('/script|javascript:|onerror|onclick/i', $buyerName . $buyerPhone . $buyerAddress)) {
        $error = 'Input tidak valid. Terdeteksi konten berbahaya!';
    }
    elseif (!preg_match('/^[0-9+\-\s()]+$/', $buyerPhone)) {
        $error = 'Nomor telepon hanya boleh berisi angka, +, -, dan spasi!';
    }
    elseif ($quantity < 1) {
        $error = 'Kuantitas minimal 1!';
    }
    elseif ($quantity > $product['stock']) {
        $error = 'Kuantitas melebihi stok yang tersedia!';
    }
    else {
        $buyerName = htmlspecialchars($buyerName, ENT_QUOTES, 'UTF-8');
        $buyerPhone = htmlspecialchars($buyerPhone, ENT_QUOTES, 'UTF-8');
        $buyerAddress = $deliveryMethod === 'delivery' ? htmlspecialchars($buyerAddress, ENT_QUOTES, 'UTF-8') : 'Ambil di FASILKOM-TI USU';

        $totalPrice = $product['price'] * $quantity;

        // Buat detail item
        $productItems = json_encode([
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'quantity' => $quantity,
            'price' => $product['price']
        ]);

        // Simpan order ke database
        $orderNumber = insertOrder($buyerName, $buyerPhone, $buyerAddress, $productItems, $totalPrice);

        // Format pesan WhatsApp
        $message .= "*Produk:* " . $product['name'] . "\n";
        $message .= "*Kuantitas:* " . $quantity . "\n";
        $message .= "*Harga per item:* Rp " . number_format($product['price'], 0, ',', '.') . "\n";
        $message .= "*Total Harga:* Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n";
        $message .= "*Informasi Pembeli:*\n";
        $message .= "Nama: " . $buyerName . "\n";
        $message .= "Telepon: " . $buyerPhone . "\n";

        if ($deliveryMethod === 'pickup') {
            $message .= "Metode: 🏫 Ambil di FASILKOM-TI USU\n";
        } else {
            $message .= "Metode: 🚚 Kirim ke Rumah\n";
            $message .= "Alamat: " . $buyerAddress . "\n";
        }

        $message .= "\nNomor Order: " . $orderNumber;

        $whatsappMsg = urlencode($message);
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMsg}";

        header("Location: $whatsappUrl");
        exit;
    }
}

include "templates/header.php";

$captcha_question = generateMathCaptcha();
?>

<div class="container py-5 fade-in" style="max-width: 850px;">

  <!-- Header -->
  <div class="text-center mb-5 slide-in-down">
    <h2 class="fw-bold display-5 mb-2">
      <i class="fas fa-shopping-cart text-pink me-2" style="animation: bounce 1s ease-in-out infinite;"></i>
      <span style="background: linear-gradient(135deg, #FF4F9D, #8C52FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
        Form Pemesanan
      </span>
    </h2>
    <p class="text-muted">Lengkapi data kamu dan checkout via WhatsApp</p>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">

        <!-- Decorative Header Bar -->
        <div style="height: 6px; background: linear-gradient(90deg, #FF4F9D, #8C52FF, #FF4F9D); animation: shimmer 3s infinite;"></div>

        <div class="card-body p-5">

          <!-- Product Info Section -->
          <div class="row mb-5 pb-4" style="border-bottom: 2px solid rgba(255, 79, 157, 0.1);">
            <div class="col-md-4 mb-3 mb-md-0">
              <?php if ($product['image']): ?>
                <img src="<?= htmlspecialchars($product['image']) ?>"
                     class="img-fluid rounded hover-scale"
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     style="border-radius: 15px; box-shadow: 0 8px 20px rgba(255, 79, 157, 0.15);">
              <?php else: ?>
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; border-radius: 15px; background: linear-gradient(135deg, #FFE6F2, #FFF0F6);">
                  <i class="fas fa-image text-pink" style="font-size: 2rem; opacity: 0.5;"></i>
                </div>
              <?php endif; ?>
            </div>

            <div class="col-md-8">
              <h4 class="fw-bold text-pink mb-2" style="font-size: 1.3rem;">
                <?= htmlspecialchars($product['name']) ?>
              </h4>
              <p class="text-muted" style="font-weight: 500; line-height: 1.6; margin-bottom: 1rem;">
                <?= htmlspecialchars($product['description']) ?>
              </p>

              <div class="mb-3">
                <h5 style="color: #FF4F9D; font-weight: 700; font-size: 1.5rem;">
                  Rp <?= number_format($product['price'], 0, ',', '.') ?>
                </h5>
              </div>

              <div class="d-flex gap-3">
                <div style="background: linear-gradient(135deg, rgba(78, 205, 196, 0.1), rgba(54, 163, 157, 0.1)); padding: 10px 16px; border-radius: 10px;">
                  <small class="text-muted d-block">Stok Tersedia</small>
                  <strong class="text-success"><?= $product['stock'] ?> unit</strong>
                </div>
              </div>
            </div>
          </div>

          <!-- Error Alert -->
          <?php if ($error): ?>
          <div class="alert alert-danger border-0" style="border-radius: 12px; border-left: 5px solid #FF6B6B;">
            <div class="d-flex align-items-center">
              <i class="fas fa-exclamation-circle me-2" style="font-size: 1.2rem;"></i>
              <div><?= htmlspecialchars($error) ?></div>
            </div>
          </div>
          <?php endif; ?>

          <!-- Order Form -->
          <form method="POST" id="orderForm" onsubmit="return validateForm()">
            <h5 class="fw-bold text-pink mb-4" style="font-size: 1.1rem;">
              <i class="fas fa-user-circle me-2"></i>Data Pemesan
            </h5>

            <!-- Full Name -->
            <div class="form-group mb-4">
              <label class="form-label text-pink fw-bold">
                <i class="fas fa-user me-1"></i> Nama Lengkap <span style="color: #FF4F9D;">*</span>
              </label>
              <input
                type="text"
                name="buyer_name"
                id="buyer_name"
                class="form-control"
                placeholder="Masukkan nama lengkap kamu"
                style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500;"
                minlength="3"
                maxlength="100"
                required
              >
              <small class="form-text text-muted">Minimal 4 karakter</small>
            </div>

            <!-- Phone Number -->
            <div class="form-group mb-4">
              <label class="form-label text-pink fw-bold">
                <i class="fas fa-phone me-1"></i> Nomor Telepon <span style="color: #FF4F9D;">*</span>
              </label>
              <input
                type="tel"
                name="buyer_phone"
                id="buyer_phone"
                class="form-control"
                placeholder="Contoh: 08123456789"
                style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500;"
                pattern="[0-9+\-\s()]+"
                minlength="10"
                maxlength="20"
                required
              >
              <small class="form-text text-muted">Nomor WhatsApp yang aktif (9-20 digit)</small>
            </div>

            <!-- Delivery Method -->
            <div class="form-group mb-4">
              <label class="form-label text-pink fw-bold">
                <i class="fas fa-truck me-1"></i> Metode Pengambilan/Pengiriman <span style="color: #FF4F9D;">*</span>
              </label>

              <div class="row g-3">
                <div class="col-md-6">
                  <input
                    type="radio"
                    name="delivery_method"
                    id="pickup"
                    value="pickup"
                    class="btn-check"
                    onchange="toggleAddressField()"
                    required
                  >
                  <label class="btn btn-outline-pink w-100" for="pickup" style="border-radius: 12px; padding: 15px; border-width: 2px;">
                    <i class="fas fa-building fa-2x mb-2 d-block"></i>
                    <strong>Ambil Sendiri</strong>
                    <small class="d-block text-muted mt-1">di FASILKOM-TI USU</small>
                  </label>
                </div>

                <div class="col-md-6">
                  <input
                    type="radio"
                    name="delivery_method"
                    id="delivery"
                    value="delivery"
                    class="btn-check"
                    onchange="toggleAddressField()"
                    required
                  >
                  <label class="btn btn-outline-pink w-100" for="delivery" style="border-radius: 12px; padding: 15px; border-width: 2px;">
                    <i class="fas fa-home fa-2x mb-2 d-block"></i>
                    <strong>Kirim ke Rumah</strong>
                    <small class="d-block text-muted mt-1">Ongkir ditentukan kemudian</small>
                  </label>
                </div>
              </div>
            </div>

            <!-- Delivery Address (Hidden by default) -->
            <div class="form-group mb-4" id="addressField" style="display: none;">
              <label class="form-label text-pink fw-bold">
                <i class="fas fa-map-marker-alt me-1"></i> Alamat Pengiriman <span style="color: #FF4F9D;">*</span>
              </label>
              <textarea
                name="buyer_address"
                id="buyer_address"
                class="form-control"
                rows="3"
                placeholder="Masukkan alamat lengkap dengan detail (Jalan, No., RT/RW, Kelurahan, Kecamatan, Kota, Provinsi)"
                style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500;"
                minlength="10"
                maxlength="500"
              ></textarea>
              <small class="form-text text-muted">Minimal 10 karakter</small>
            </div>

            <!-- Quantity -->
            <div class="form-group mb-4">
              <label class="form-label text-pink fw-bold">
                <i class="fas fa-boxes me-1"></i> Jumlah <span style="color: #FF4F9D;">*</span>
              </label>
              <div class="input-group" style="border-radius: 12px; overflow: hidden;">
                <button type="button" class="btn btn-outline-pink" onclick="decrementQuantity()">
                  <i class="fas fa-minus"></i>
                </button>
                <input
                  type="number"
                  name="quantity"
                  class="form-control text-center"
                  value="1"
                  min="1"
                  max="<?= $product['stock'] ?>"
                  required
                  id="quantity"
                  onchange="updateTotal()"
                  style="border: 2px solid #E8D5E8; font-weight: 700; border-radius: 0;"
                >
                <button type="button" class="btn btn-outline-pink" onclick="incrementQuantity()">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <small class="form-text text-muted mt-2">Maksimal: <?= $product['stock'] ?> unit</small>
            </div>

            <!-- Total Price -->
            <div class="alert alert-info border-0 p-4 mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(255, 79, 157, 0.1), rgba(140, 82, 255, 0.1));">
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-muted fw-bold">Total Pembayaran:</h6>
                <h4 class="mb-0 fw-bold" style="color: #FF4F9D;">
                  <span id="totalPrice">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                </h4>
              </div>

            </div>

            <div class="form-group mb-4">
              <label class="form-label text-pink fw-bold">
                <i class="fas fa-calculator me-1"></i> Pertanyaan Keamanan <span style="color: #FF4F9D;">*</span>
              </label>
              <div class="d-flex align-items-center gap-3">
                 <div class="px-4 py-2 text-center" style="background: #f8f9fa; border: 2px solid #E8D5E8; border-radius: 12px; min-width: 120px;">
                    <span style="font-size: 1.25rem; font-weight: 800; color: #555;"><?= $captcha_question ?></span>
                 </div>
                 <input type="number" name="captcha_input" class="form-control" placeholder="Hasilnya berapa?" required style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500; height: 50px;">
              </div>
            </div>

            <!-- Buttons -->
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-pink btn-lg" style="border-radius: 12px; font-weight: 700; padding: 12px; font-size: 1rem;">
                <i class="fab fa-whatsapp me-2"></i> Checkout via WhatsApp
              </button>
              <a href="merchandise.php" class="btn btn-outline-secondary" style="border-radius: 12px; font-weight: 700; padding: 12px;">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
              </a>
            </div>

            <!-- Info Box -->
            <div class="mt-4 p-3" style="background: linear-gradient(135deg, rgba(78, 205, 196, 0.1), rgba(54, 163, 157, 0.1)); border-radius: 12px; border-left: 4px solid #4ECDC4;">
              <small style="color: #1a7a73; display: block; margin-bottom: 4px;">
                <i class="fas fa-info-circle me-1"></i> <strong>Informasi</strong>
              </small>
              <small style="color: #666;">
                Kamu akan diarahkan ke WhatsApp untuk melanjutkan proses pemesanan dan pembayaran.
              </small>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

</div>

<script>
  const pricePerItem = <?= $product['price'] ?>;
  const maxStock = <?= $product['stock'] ?>;

  function updateTotal() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const total = pricePerItem * quantity;
    document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
  }

  function incrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    if (currentValue < maxStock) {
      input.value = currentValue + 1;
      updateTotal();
    }
  }

  function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    if (currentValue > 1) {
      input.value = currentValue - 1;
      updateTotal();
    }
  }

  function toggleAddressField() {
    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
    const addressField = document.getElementById('addressField');
    const addressTextarea = document.getElementById('buyer_address');

    if (deliveryMethod && deliveryMethod.value === 'delivery') {
      addressField.style.display = 'block';
      addressTextarea.setAttribute('required', 'required');
    } else {
      addressField.style.display = 'none';
      addressTextarea.removeAttribute('required');
      addressTextarea.value = '';
    }
  }

  function validateForm() {
    const buyerName = document.getElementById('buyer_name').value.trim();
    const buyerPhone = document.getElementById('buyer_phone').value.trim();
    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
    const buyerAddress = document.getElementById('buyer_address').value.trim();

    if (!buyerName || !buyerPhone) {
      alert('Nama dan nomor telepon harus diisi!');
      return false;
    }

    if (!deliveryMethod) {
      alert('Pilih metode pengambilan/pengiriman!');
      return false;
    }

    if (deliveryMethod.value === 'delivery' && !buyerAddress) {
      alert('Alamat harus diisi untuk pengiriman ke rumah!');
      return false;
    }

    if (buyerName.length < 3) {
      alert('Nama minimal 3 karakter!');
      return false;
    }

    if (buyerPhone.length < 10) {
      alert('Nomor telepon minimal 10 digit!');
      return false;
    }

    if (deliveryMethod.value === 'delivery' && buyerAddress.length < 10) {
      alert('Alamat terlalu pendek, minimal 10 karakter!');
      return false;
    }

    const htmlPattern = /<[^>]*>/;
    if (htmlPattern.test(buyerName) || htmlPattern.test(buyerPhone) || (deliveryMethod.value === 'delivery' && htmlPattern.test(buyerAddress))) {
      alert('Input tidak boleh mengandung tag HTML!');
      return false;
    }

    const urlPattern = /https?:\/\/|www\./i;
    if (urlPattern.test(buyerName) || urlPattern.test(buyerPhone) || (deliveryMethod.value === 'delivery' && urlPattern.test(buyerAddress))) {
      alert('Input tidak boleh mengandung link/URL!');
      return false;
    }

    const scriptPattern = /script|javascript:|onerror|onclick/i;
    const combinedInput = deliveryMethod.value === 'delivery' ? (buyerName + buyerPhone + buyerAddress) : (buyerName + buyerPhone);
    if (scriptPattern.test(combinedInput)) {
      alert('Input tidak valid. Terdeteksi konten berbahaya!');
      return false;
    }

    const phonePattern = /^[0-9+\-\s()]+$/;
    if (!phonePattern.test(buyerPhone)) {
      alert('Nomor telepon hanya boleh berisi angka, +, -, dan spasi!');
      return false;
    }

    return true;
  }
</script>

<style>
  @keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
  }

  body.dark-mode .card {
    background: #0f3460;
    color: #ddd;
  }

  body.dark-mode .form-control,
  body.dark-mode .form-label {
    color: #ddd;
  }

  body.dark-mode .form-control {
    background: #16213e;
    border-color: rgba(255, 79, 157, 0.3);
  }

  body.dark-mode .form-control:focus {
    background: #0f3460;
    border-color: #FF4F9D;
  }
</style>

<?php include "templates/footer.php"; ?>

<?php

require_once "function.php";
session_start();

include "templates/header.php";


$nomorBaru = generateNomorConfess();

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
$nomorConfess = $_GET['nomor'] ?? '';

// panggil math captcha
$captcha_question = generateMathCaptcha();
?>

<div class="container py-5 fade-in" style="max-width: 750px; min-height: 75vh;">

  
  <div class="text-center mb-5 slide-in-down">
    <h2 class="fw-bold display-5 mb-3">
      <i class="fas fa-feather text-pink me-2" style="animation: bounce 1s ease-in-out infinite;"></i>
      <span style="background: linear-gradient(135deg, #FF4F9D, #8C52FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
        Kirim Confess Kamu
      </span>
    </h2>
    <p class="lead text-muted">
      Bagikan cerita dan perasaanmu secara anonim dan aman
    </p>
  </div>

  
  <?php if ($success): ?>
    
    <div class="alert alert-success border-0 shadow-sm scale-up" style="border-radius: 15px; border-left: 5px solid #4ECDC4;">
      <div class="d-flex align-items-center">
        <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
        <div>
          <strong style="display: block; margin-bottom: 5px;">✨ Confess berhasil dikirim!</strong>
          <small>Nomor confess kamu: <strong style="color: #4ECDC4; font-size: 0.95rem;"><?= htmlspecialchars($nomorConfess) ?></strong></small>
          <br>
          <small>Catat nomor ini untuk mengecek status confess kamu nanti.</small>
        </div>
      </div>
    </div>
  <?php elseif ($error): ?>
    
    <div class="alert alert-danger border-0 shadow-sm scale-up" style="border-radius: 15px; border-left: 5px solid #FF6B6B;">
      <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-circle me-3" style="font-size: 1.5rem;"></i>
        <div>
          <strong style="display: block;">Oops! Gagal mengirim confess</strong>
          <small>Pastikan kamu mengisi isi confess dengan lengkap.</small>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['error']) && $_GET['error'] == 'captcha'): ?>
    <div class="alert alert-warning border-0 shadow-sm scale-up" style="border-radius: 15px; border-left: 5px solid #FFC107;">
      <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
        <div>
          <strong style="display: block;">Captcha Salah!</strong>
          <small>Silakan masukkan kode keamanan yang benar.</small>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <style>
  @keyframes shimmer {
    0% {
      background-position: -1000px 0;
    }
    100% {
      background-position: 1000px 0;
    }
  }

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

  .slide-in-down {
    animation: slideInDown 0.6s ease-out;
  }

  .accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, rgba(255, 79, 157, 0.08), rgba(140, 82, 255, 0.08));
    color: #FF4F9D;
  }

  .accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(255, 79, 157, 0.15);
  }

  body.dark-mode .accordion-item {
    background: #1f1f1f;
    border: 1px solid #333 !important;
  }

  body.dark-mode .accordion-button {
    background: #1f1f1f;
    color: #FFB6D9;
  }

  body.dark-mode .accordion-button:not(.collapsed) {
    background: #2a2a2a;
    color: #ff4f9d;
  }

  body.dark-mode .accordion-body {
    background: #1f1f1f;
    color: #e0e0e0;
    border-color: #333 !important;
  }

  @media (max-width: 768px) {
    .confess-form-card:hover,
    .check-status-card:hover {
      transform: translateY(-4px) !important;
    }

    .card-body.p-md-5 {
      padding: 1.5rem !important;
    }

    .btn-lg.w-100 {
      font-size: 14px;
    }

    .check-status-card .input-group {
      display: flex;
      flex-wrap: wrap;
    }

    .check-status-card .input-group input.form-control {
      flex: 1 1 100%;
      border-radius: 12px !important;
      border: 2px solid #E8D5E8 !important;
      min-height: 48px;
      margin-bottom: 12px;
    }

    .check-status-card .input-group button.btn {
      flex: 1 1 100%;
      border-radius: 12px !important;
      min-height: 48px;
    }
  }

  @media (max-width: 991px) and (min-width: 769px) {
    .check-status-card .input-group input.form-control {
      min-height: 46px;
    }

    .check-status-card .input-group button.btn {
      min-height: 46px;
      padding: 12px 20px;
    }
  }
</style>

  
  <div class="card border-0 shadow-sm scale-up confess-form-card" style="border-radius: 20px; overflow: hidden; transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)';">

    
    <div style="height: 5px; background: linear-gradient(90deg, #FF4F9D, #8C52FF, #FF4F9D); animation: shimmer 3s infinite;"></div>

    <div class="card-body p-5 p-md-5 p-sm-4">
      
      <form action="submit-confess.php" method="POST" id="confessForm">

        
        <div class="form-group mb-4">
          <label class="form-label" style="color: #FF4F9D; font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
            <i class="fas fa-pen-fancy me-2"></i> Isi Confess <span style="color: #FF4F9D;">*</span>
          </label>
          <textarea
            name="isi"
            class="form-control"
            rows="7"
            placeholder="From         :
To              :
Message : "
            required
            style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500;"
          ></textarea>
          <small class="text-muted mt-2 d-block">Minimal 5 karakter, maksimal 5000 karakter</small>
        </div>

        
        <div class="form-group mb-4">
          <label class="form-label" style="color: #FF4F9D; font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
            <i class="fas fa-tag me-2"></i> Kategori (Opsional)
          </label>
          <select
            name="kategori"
            class="form-control"
            style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500;"
          >
            <option value="">— Pilih kategori —</option>
            <option value="Crush">💘 Crush / Cinta</option>
            <option value="Keluh Kesah">😮‍💨 Keluh Kesah</option>
            <option value="Teman">👥 Teman</option>
            <option value="Keluarga">👪 Keluarga</option>
            <option value="Kampus">🎓 Kampus</option>
            <option value="Kesehatan">🏥 Kesehatan</option>
            <option value="Random">🎲 Random</option>
          </select>
          <small class="text-muted mt-2 d-block">Pilih kategori yang sesuai agar confess kamu lebih tertarget</small>
        </div>

        <div class="form-group mb-4">
          <label class="form-label" style="color: #FF4F9D; font-weight: 700; font-size: 0.95rem; letter-spacing: 0.5px;">
            <i class="fas fa-calculator me-2"></i> Pertanyaan Keamanan <span style="color: #FF4F9D;">*</span>
          </label>
          <div style="display: flex; gap: 12px; align-items: center;">
            <div style="padding: 0 16px; text-align: center; background: #f8f9fa; border: 2px solid #E8D5E8; border-radius: 12px; flex-shrink: 0; width: 160px; height: 50px; display: flex; align-items: center; justify-content: center;">
              <span style="font-size: 1.25rem; font-weight: 800; color: #555;"><?= $captcha_question ?></span>
            </div>
            <input type="number" name="captcha_input" class="form-control" placeholder="Hasilnya berapa?" required style="border-radius: 12px; border: 2px solid #E8D5E8; font-weight: 500; height: 50px; flex: 1;">
          </div>
          <small class="text-muted mt-2 d-block">Jawab pertanyaan di atas untuk membuktikan kamu bukan robot</small>
        </div>

        
        <button type="submit" class="btn btn-pink btn-lg w-100 py-3 hover-lift" style="border-radius: 12px; font-weight: 700; letter-spacing: 0.5px;">
          <i class="fas fa-paper-plane me-2"></i> Kirim Confess
        </button>

        
        <div class="mt-4 p-3" style="background: linear-gradient(135deg, rgba(255, 79, 157, 0.05), rgba(140, 82, 255, 0.05)); border-radius: 12px; border-left: 4px solid #FF4F9D;">
          <small style="color: #666; display: block; margin-bottom: 8px;">
            <i class="fas fa-shield-alt text-pink me-2"></i> <strong>Privasi Terjamin</strong>
          </small>
          <small style="color: #777; display: block;">
            Identitas kamu dijaga ketat. Semua confess akan ditinjau sebelum dipublikasikan.
          </small>
        </div>
      </form>
    </div>
  </div>

  
  <div class="card border-0 shadow-sm mt-4 scale-up check-status-card" style="border-radius: 20px; overflow: hidden; transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)';">

    
    <div style="height: 5px; background: linear-gradient(90deg, #8C52FF, #FF4F9D, #8C52FF); animation: shimmer 3s infinite; animation-delay: 0.3s;"></div>

    <div class="card-body p-5 p-md-5 p-sm-4">
      <h5 class="mb-3" style="color: #FF4F9D; font-weight: 700; font-size: 1.1rem;">
        <i class="fas fa-search text-pink me-2"></i> Cek Status Confess
      </h5>
      <p class="text-muted small mb-4">
        Masukkan nomor confess yang sudah kamu catat untuk melihat status moderasi
      </p>

      <form action="cek-status.php" method="GET">
        <div class="input-group" style="border-radius: 12px; overflow: hidden;">
          <input
            type="text"
            name="nomor"
            class="form-control"
            placeholder="Contoh: CF-00001"
            required
            style="border: 2px solid #E8D5E8; border-right: none; border-radius: 12px 0 0 12px; font-weight: 500;"
          >
          <button class="btn btn-outline-pink" type="submit" style="border-radius: 0 12px 12px 0; font-weight: 700;">
            <i class="fas fa-check-circle me-1"></i> Cek
          </button>
        </div>
      </form>
    </div>
  </div>

  
  <div class="mt-5 fade-in">
    <h6 style="color: #FF4F9D; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; margin-bottom: 1.5rem;">
      <i class="fas fa-question-circle me-2"></i> PERTANYAAN YANG SERING DIAJUKAN
    </h6>

    <div class="accordion" id="faqAccordion">
      <div class="accordion-item border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="color: #FF4F9D;">
            <i class="fas fa-heart me-2"></i> Apakah identitas saya terjaga?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Ya, 100% anonim. Kami tidak menyimpan informasi pribadi kamu. Semua confess diproses tanpa identitas.
          </div>
        </div>
      </div>

      <div class="accordion-item border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="color: #FF4F9D;">
            <i class="fas fa-clock me-2"></i> Berapa lama confess saya akan di-ACC?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Biasanya dalam 1-24 jam, tergantung dari beban hidup admin dan isi confess yang kamu kirimkan.
          </div>
        </div>
      </div>

      <div class="accordion-item border-0 shadow-sm" style="border-radius: 12px;">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" style="color: #FF4F9D;">
            <i class="fas fa-ban me-2"></i> Konten apa yang tidak boleh dikirim?
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Konten yang mengandung SARA, kekerasan, spam, atau konten berbahaya lainnya akan ditolak.
          </div>
        </div>
      </div>
    </div>
  </div>

</div>



<?php include "templates/footer.php"; ?>

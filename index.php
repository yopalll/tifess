<?php include "templates/header.php"; ?>

<div class="container py-5 fade-in" style="min-height: 70vh; display: flex; align-items: center;">
<style>
  @media (max-width: 768px) {
    .hero-section {
      min-height: 50vh !important;
    }
    .hero-illustration {
      height: 250px !important;
      margin-top: 20px;
    }
    .hero-illustration img,
    .hero-illustration svg {
      max-height: 220px !important;
    }
  }
</style>
  <div class="row align-items-center w-100">

    <div class="col-md-6 mb-4 mb-md-0 slide-in-left">
      <h1 class="fw-bold mb-3 display-4">
        <span style="background: linear-gradient(135deg, #FF4F9D 0%, #8C52FF 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
          TIFESS
        </span>
      </h1>

      <p class="lead mb-4" style="color: #666; font-weight: 500; line-height: 1.8;">
        <i class="fas fa-heart text-pink me-2" style="animation: heartPulse 1s ease-in-out infinite;"></i>
        <strong>Confess Platform</strong> Teknologi Informasi
      </p>

      <p class="mb-5" style="color: #777; font-size: 1rem; line-height: 1.7;">
        Tempat aman untuk berbagi cerita, keresahan, dan rahasia secara anonim.
        Curhatkan hatimu dengan bebas tanpa takut diketahui identitas.
        <span style="color: #FF4F9D; font-weight: 600;">Suara kamu penting bagi kami.</span>
      </p>

      <div class="d-flex flex-column flex-sm-row flex-wrap gap-3">
        <a href="mading.php" class="btn btn-pink btn-lg px-4 hover-lift">
          <i class="fas fa-comments me-2"></i> Lihat Mading
        </a>

        <a href="form-confess.php" class="btn btn-outline-pink btn-lg px-4 hover-lift">
          <i class="fas fa-feather me-2"></i> Kirim Confess
        </a>
      </div>

      <div class="row mt-5">
        <div class="col-6 col-md-4 mb-3">
          <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)';">
            <div class="card-body text-center">
              <i class="fas fa-lock text-pink" style="font-size: 1.8rem;"></i>
              <p class="mt-2 small fw-bold">Anonim</p>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 mb-3">
          <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)';">
            <div class="card-body text-center">
              <i class="fas fa-heart text-pink" style="font-size: 1.8rem; animation: heartPulse 1s ease-in-out infinite;"></i>
              <p class="mt-2 small fw-bold">Supportif</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 mb-3">
          <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)';">
            <div class="card-body text-center">
              <i class="fas fa-users text-pink" style="font-size: 1.8rem;"></i>
              <p class="mt-2 small fw-bold">Komunitas</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 text-center slide-in-right" style="position: relative;">
      <div class="hero-illustration" style="position: relative; height: 400px; display: flex; align-items: center; justify-content: center;">

        <div style="position: absolute; width: 300px; height: 300px; background: linear-gradient(135deg, rgba(255, 79, 157, 0.1), rgba(140, 82, 255, 0.1)); border-radius: 50%; animation: float 4s ease-in-out infinite;"></div>

        <?php if (file_exists('assets/img/hero-pink.png')): ?>
          <img src="assets/img/hero-pink.png" class="img-fluid hover-lift" style="max-height: 380px; z-index: 10; position: relative;" alt="hero">
        <?php else: ?>
          <svg width="300" height="300" viewBox="0 0 300 300" style="z-index: 10; position: relative;" class="floating">
            <path d="M150 280 C75 220 25 170 25 110 C25 75 45 55 65 55 C85 55 105 70 150 110 C195 70 215 55 235 55 C255 55 275 75 275 110 C275 170 225 220 150 280 Z"
                  fill="#FF4F9D" opacity="0.9"/>
            <circle cx="80" cy="80" r="3" fill="#FFB6D9" opacity="0.8"/>
            <circle cx="220" cy="100" r="3" fill="#FFB6D9" opacity="0.8"/>
            <circle cx="150" cy="50" r="4" fill="#8C52FF" opacity="0.7"/>
          </svg>
        <?php endif; ?>

        <div style="position: absolute; animation: float 3s ease-in-out infinite; animation-delay: 0s; font-size: 2rem; opacity: 0.5;">💕</div>
        <div style="position: absolute; top: 50px; right: 30px; animation: float 4s ease-in-out infinite; animation-delay: 1s; font-size: 1.5rem; opacity: 0.4;">💗</div>
        <div style="position: absolute; bottom: 60px; left: 20px; animation: float 3.5s ease-in-out infinite; animation-delay: 0.5s; font-size: 1.5rem; opacity: 0.4;">💝</div>
      </div>
    </div>

  </div>
</div>

<section class="py-5" style="background: linear-gradient(135deg, rgba(255, 79, 157, 0.05) 0%, rgba(140, 82, 255, 0.05) 100%);">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold fade-in">
      Mengapa Memilih <span style="color: #FF4F9D;">TIFESS</span>?
    </h2>

    <div class="row g-4">
      <div class="col-md-6 col-lg-4 mb-3 stagger-item">
        <div class="card border-0 h-100 shadow-sm" style="border-radius: 20px; overflow: hidden; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.25rem 0.5rem rgba(0, 0, 0, 0.08)';">
          <div style="height: 120px; background: linear-gradient(135deg, #FFE6F2, #FFF0F6); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-shield-alt text-pink" style="font-size: 3rem; opacity: 0.8;"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title text-pink mb-3">Privasi Terjamin</h5>
            <p class="card-text text-muted">
              Semua confess dikirim dengan anonim, tidak ada data pribadi yang terkumpul.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4 mb-3 stagger-item">
        <div class="card border-0 h-100 shadow-sm" style="border-radius: 20px; overflow: hidden; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.25rem 0.5rem rgba(0, 0, 0, 0.08)';">
          <div style="height: 120px; background: linear-gradient(135deg, #FFE6F2, #FFF0F6); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-check-circle text-pink" style="font-size: 3rem; opacity: 0.8;"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title text-pink mb-3">Moderasi Ketat</h5>
            <p class="card-text text-muted">
              Setiap confess melalui proses verifikasi admin sebelum dipublikasikan.
            </p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4 mb-3 stagger-item">
        <div class="card border-0 h-100 shadow-sm" style="border-radius: 20px; overflow: hidden; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 50px rgba(255, 79, 157, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0.25rem 0.5rem rgba(0, 0, 0, 0.08)';">
          <div style="height: 120px; background: linear-gradient(135deg, #FFE6F2, #FFF0F6); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-bolt text-pink" style="font-size: 3rem; opacity: 0.8; animation: pulse 2s ease-in-out infinite;"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title text-pink mb-3">Cepat </h5>
            <p class="card-text text-muted">
              Cepat dan mudah untuk berbagi.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "templates/footer.php"; ?>

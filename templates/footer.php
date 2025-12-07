
<footer class="text-center py-5 mt-5 fade-in">
  <div class="container">
    
    <div class="mb-4">
      <h6 style="color: #FF4F9D; font-weight: 700; font-size: 1.1rem; letter-spacing: 1px;">
        <i class="fas fa-heart text-pink me-2" style="animation: heartPulse 1s ease-in-out infinite;"></i>
        SUPPORTED BY
        <i class="fas fa-heart text-pink ms-2" style="animation: heartPulse 1s ease-in-out infinite; animation-delay: 0.3s;"></i>
      </h6>
    </div>

    
    <div class="d-flex justify-content-center flex-wrap mb-4">
      <?php 
        $logos = [
          ['name' => 'f1', 'instagram' => 'https://www.instagram.com/official.usu/'],
          ['name' => 'f2', 'instagram' => 'https://www.instagram.com/himatifusu/'],
          ['name' => 'f3', 'instagram' => 'https://www.instagram.com/itlgsquad/'],
          ['name' => 'f4', 'instagram' => 'https://www.instagram.com/itcoma25/'],
          ['name' => 'f5', 'instagram' => 'https://www.instagram.com/mhsw.25/']
        ];
        $delay = 0.1;
        foreach($logos as $logo):
      ?>
      <div class="stagger-item" style="animation-delay: <?= $delay ?>s;">
        <a href="<?= $logo['instagram'] ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: none; display: inline-block;">
          <img src="assets/img/<?= $logo['name'] ?>.png" class="m-2 hover-scale footer-logo" alt="<?= $logo['name'] ?>" style="cursor: pointer; transition: all 0.3s ease;">
        </a>
      </div>
      <?php $delay += 0.1; endforeach; ?>
    </div>

    
    <div class="border-top pt-4" style="border-color: rgba(255, 79, 157, 0.2);">
      <p class="mt-3 small text-muted mb-2" style="font-weight: 500;">
        <i class="fas fa-envelope me-2" style="color: #FF4F9D;"></i>
        Confess Platform Teknologi Informasi
      </p>
      <p class="small text-muted" style="font-size: 0.85rem;">
        © 2025 TIFESS — Powered with <i class="fas fa-heart text-pink" style="animation: heartPulse 0.8s ease-in-out infinite;"></i>  by Kelompok 6 ProWeb
      </p>
    </div>

    
    <div class="mt-4">
      <a href="index.php" class="text-pink me-3 hover-pink" style="font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease;">
        <i class="fas fa-home"></i> Home
      </a>
      <a href="mading.php" class="text-pink me-3 hover-pink" style="font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease;">
        <i class="fas fa-comments"></i> Mading
      </a>
      <a href="form-confess.php" class="text-pink hover-pink" style="font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease;">
        <i class="fas fa-feather"></i> Confess
      </a>
    </div>
  </div>
</footer>

<style>
  footer {
    background: linear-gradient(135deg, rgba(255, 230, 242, 0.8) 0%, rgba(255, 240, 246, 0.8) 100%);
    border-top: 2px solid rgba(255, 79, 157, 0.15);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }

  footer a:hover {
    transform: translateY(-3px);
  }

  body.dark-mode footer {
    background: linear-gradient(135deg, rgba(22, 33, 62, 0.95) 0%, rgba(15, 52, 96, 0.95) 100%);
    border-top-color: rgba(255, 79, 157, 0.3);
  }

  body.dark-mode footer .text-muted {
    color: #aaa !important;
  }

  footer img {
    filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1));
  }

  footer img:hover {
    filter: drop-shadow(0 4px 12px rgba(255, 79, 157, 0.3));
  }

  
  .footer-logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border-radius: 12px;
    background: white;
    padding: 8px;
    transition: all 0.3s ease;
    opacity: 0.8;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .footer-logo:hover {
    opacity: 1;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(255, 79, 157, 0.25);
  }

  body.dark-mode footer img {
    opacity: 0.7;
  }

  body.dark-mode .footer-logo {
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  }

  body.dark-mode footer img:hover {
    opacity: 0.9;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/jquery/jquery.min.js"></script>

<script src="assets/js/dark-mode.js"></script>

<script>
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
</script>

</body>
</html>

/**
 * Script Buat Gonta-ganti Dark Mode
 * Ngurusin fitur biar bisa gelap-terang, simpen di localStorage biar webnya inget pilihan user.
 */

const DARK_MODE_KEY = 'tifess_dark_mode';

/**
 * Cek dulu user sebelumnya milih gelap apa terang
 */
function isDarkModeEnabled() {
  const value = localStorage.getItem(DARK_MODE_KEY);
  return value === 'enabled';
}

/**
 * Nyalain Dark Mode
 */
function enableDarkMode() {
  document.documentElement.classList.add('dark-mode');
  if (document.body) {
    document.body.classList.add('dark-mode');
  }
  localStorage.setItem(DARK_MODE_KEY, 'enabled');
  updateToggleButton();
}

/**
 * Matiin Dark Mode (Balik ke Terang)
 */
function disableDarkMode() {
  document.documentElement.classList.remove('dark-mode');
  if (document.body) {
    document.body.classList.remove('dark-mode');
  }
  localStorage.setItem(DARK_MODE_KEY, 'disabled');
  updateToggleButton();
}

/**
 * Fungsi buat switch on/off,
 */
function toggleDarkMode() {
  console.log('Toggle dark mode dipencet, status skrg:', isDarkModeEnabled());
  if (isDarkModeEnabled()) {
    disableDarkMode();
    console.log('Udah ganti ke mode terang');
  } else {
    enableDarkMode();
    console.log('Udah ganti ke mode gelap');
  }
}

/**
 * Ganti ikon tombolnya (Matahari/Bulan) biar sesuai sama mode
 */
function updateToggleButton() {
  const toggleBtn = document.getElementById('darkModeToggle');
  if (!toggleBtn) {
    console.warn('Waduh, tombol togglenya gak ketemu cuy');
    return;
  }

  if (isDarkModeEnabled()) {
    toggleBtn.innerHTML = '<i class="fas fa-sun me-1"></i> <span>Light</span>';
    toggleBtn.setAttribute('aria-label', 'Ganti ke mode terang');
  } else {
    toggleBtn.innerHTML = '<i class="fas fa-moon me-1"></i> <span>Dark</span>';
    toggleBtn.setAttribute('aria-label', 'Ganti ke mode gelap');
  }
}

/**
 * Jalanin pas loading awal 
 */
function initDarkMode() {
  console.log('Inisialisasi dark mode, nilai disimpen:', localStorage.getItem(DARK_MODE_KEY));

  // Langsung setel modenya biar gak silau (flicker) pas refresh
  if (isDarkModeEnabled()) {
    document.documentElement.classList.add('dark-mode');
    if (document.body) {
      document.body.classList.add('dark-mode');
    }
  }

  // Nunggu elemen HTML baru pasang tombol
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupDarkModeToggle);
  } else {
    setupDarkModeToggle();
  }
}

/**
 * Pasang listener di tombol biar bisa diklik
 */
function setupDarkModeToggle() {
  const toggleBtn = document.getElementById('darkModeToggle');
  if (toggleBtn) {
    console.log('Tombol dark mode ketemu nih, siap dipasang event listener');

    // Hapus listener lama (kalo ada) biar gak dobel-dobel
    const newToggleBtn = toggleBtn.cloneNode(true);
    toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);

    // Pasang listener klik yang baru
    newToggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      toggleDarkMode();
    });

    updateToggleButton();
  } else {
    console.warn('Yah, tombol dark mode nya gak ada di HTML cuy');
  }
}

// langsung jalanin pas script ini keload
initDarkMode();

// jalanin lagi pas DOM udah full loaded
document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM udah load, cek lagi perlu init ulang gak');
  if (isDarkModeEnabled() && document.body) {
    document.body.classList.add('dark-mode');
  }
  updateToggleButton();
});

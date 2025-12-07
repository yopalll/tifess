# 📝 TIFESS - Confess Platform Teknologi Informasi

**TIFESS** adalah platform untuk berbagi cerita, keresahan, dan rahasia secara **anonim**. Aplikasi ini dirancang khusus untuk Prodi Teknologi Informasi USU sebagai tempat yang aman untuk mengekspresikan diri tanpa khawatir identitas terbongkar.

## ✨ Fitur Utama

- 🎭 **Anonim Penuh** - Kirim confess tanpa mengungkapkan identitas Anda
- 📌 **Mading Board** - Lihat semua confess yang telah disetujui
- 🔍 **Cek Status** - Lacak status confess Anda dengan nomor unik
- 🌙 **Dark Mode** - Mode gelap untuk kenyamanan mata (FIXED!)
- 🛍️ **Merchandise** - Toko merchandise dengan checkout via WhatsApp
- 🔐 **Password Manager** - Ganti password sendiri & Reset password (Superadmin)
- 📂 **Kategori** - Organisir confess berdasarkan kategori:
  - 💘 Crush
  - 🥰 Crush
  - 😮 Keluh Kesah
  - 👥 Teman
  - 👪 Keluarga
  - 🎲 Random
- 📱 **WhatsApp Checkout** - Pesan merchandise langsung terhubung ke WhatsApp Admin
- 👨‍💼 **Admin Panel** - Moderasi dan kelola confess masuk
- 👥 **Multi-Admin System** - Sistem persetujuan admin oleh superadmin
- 📦 **Product Management** - Kelola produk merchandise


## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP Native
- **Database**: MySQL/MariaDB
- **Frontend**: HTML, CSS, JavaScript
- **Framework CSS**: Bootstrap 4 & 5, AdminLTE (dashboard Admin)
- **Icons**: FontAwesome

## 📂 Struktur File

```
tifess-01/
├── index.php                # Halaman utama
├── form-confess.php         # Form pengiriman confess
├── submit-confess.php       # Proses submit confess
├── cek-status.php           # Halaman cek status
├── mading.php               # Board semua confess
├── merchandise.php          # Halaman toko merchandise
├── order-form.php           # Form pemesanan produk
├── login.php                # Halaman login admin
├── register.php             # Halaman registrasi admin
├── logout.php               # Proses logout
├── function.php             # Fungsi-fungsi utama
├── gen_hash.php             # Tool generate password hash
├── README.md                # File ini
│
├── admin/                   # Panel admin
│   ├── index.php            # Dashboard admin
│   ├── pending.php          # Confess pending
│   ├── approved.php         # Confess approved
│   ├── rejected.php         # Confess rejected
│   ├── approve.php          # Proses approve
│   ├── reject.php           # Proses reject
│   ├── delete.php           # Proses delete
│   ├── products.php         # Kelola produk
│   ├── add-product.php      # Tambah produk
│   ├── edit-product.php     # Edit produk
│   ├── delete-product.php   # Hapus produk
│   ├── manage-admins.php    # Kelola admin (superadmin only)
│   ├── approve-admin.php    # Approve admin baru
│   ├── reject-admin.php     # Reject admin baru
│   ├── delete-admin.php     # Hapus admin
│   ├── change-password.php  # Ganti password admin
│   ├── reset-admin-password.php # Reset password admin
│   ├── change-username.php  # Ganti username superadmin
│   └── templates/
│       ├── header.php
│       ├── sidebar.php
│       └── footer.php
│
├── database/                # File database
│   └── tifess.sql           # Database schema & data
│
├── templates/               # Template umum
│   ├── header.php           # Header
│   └── footer.php           # Footer
│
└── assets/                  # File statis
    ├── css/
    │   ├── style.css        # Style utama
    │   ├── pink-theme.css   # Theme pink
    │   └── dark-mode.css    # Dark mode styling
    ├── img/                 # Gambar/aset
    │   └── products/        # Gambar produk
    ├── js/
    │   ├── darkmode.js      # Script dark mode (secondary)
    │   └── dark-mode.js     # Script dark mode (primary)
    └── plugins/             # Library eksternal
        ├── bootstrap/       # Bootstrap 5
        ├── bootstrap4/      # Bootstrap 4
        ├── fontawesome-free/# Font Awesome
        └── jquery/          # jQuery
```

## 🚀 Cara Install & Setup

### 1. Clone Repository

```bash
git clone https://github.com/yopalll/tifess.git
cd tifess
```

### 2. Setup Database

**Opsi A: Import file SQL (Recommended)**

```bash
# Via terminal
mysql -u root < database/tifess.sql

# Atau via phpMyAdmin
# 1. Buat database baru bernama 'tifess'
# 2. Import file database/tifess.sql
```

**Opsi B: Manual SQL**

```sql
-- Jalankan query di database/tifess.sql
-- File sudah include semua tabel dan data sample
```

### 3. Konfigurasi Database (Opsional)

Jika menggunakan konfigurasi database berbeda, edit file `function.php`:

```php
$host     = "localhost";  // Host database
$user     = "root";       // Username database
$password = "";           // Password database
$dbname   = "tifess";     // Nama database
```

### 4. Jalankan Aplikasi

- Pastikan Laragon/XAMPP/WAMP sudah running
- Akses: `http://localhost/tifess-01`

### 5. Login Admin

**Default Superadmin:**

- Username: `TF-KOMA-06`
- Password: `KEL06PROWEB-KOMA-25`

## 🔄 Penjelasan CRUD (Create, Read, Update, Delete)

Berikut adalah rincian lengkap bagaimana setiap operasi Create, Read, Update, dan Delete diimplementasikan pada fitur-fitur utama:

### 1. Confess Management (Inti Aplikasi)

Ini adalah fitur utama untuk mengirim dan mengelola pesan confess.

| Operasi    | File / Fungsi Terkait                                                                                    | Deskripsi Alur                                                                                                                                                  |
| :--------- | :------------------------------------------------------------------------------------------------------- | :-------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **CREATE** | `form-confess.php` → `submit-confess.php` <br> `function.php`: `insertConfess()`                         | User mengisi form. Data (`isi`, `kategori`) disimpan ke tabel `confess` dengan status default **'pending'**.                                                    |
| **READ**   | `mading.php` <br> `cek-status.php` <br> `admin/index.php` <br> `function.php`: `getAcc()`, `cekStatus()` | **User**: Melihat di `mading.php` (hanya status 'acc') atau cek status via nomor tiket.<br>**Admin**: Melihat semua status (pending, acc, reject) di dashboard. |
| **UPDATE** | `admin/approve.php` <br> `admin/reject.php` <br> `function.php`: `approveConfess()`, `rejectConfess()`   | Admin mengubah kolom `status` pada tabel `confess` dari 'pending' menjadi **'acc'** (disetujui) atau **'reject'** (ditolak).                                    |
| **DELETE** | `admin/delete.php` <br> `function.php`: `deleteConfess()`                                                | Admin menghapus baris data confess dari database secara permanen berdasarkan ID.                                                                                |

### 2. Merchandise & Product System

Fitur toko online sederhana untuk menjual merchandise.

| Operasi    | File / Fungsi Terkait                                                                           | Deskripsi Alur                                                                                   |
| :--------- | :---------------------------------------------------------------------------------------------- | :----------------------------------------------------------------------------------------------- |
| **CREATE** | `admin/add-product.php` <br> `function.php`: `insertProduct()`                                  | Admin menginput nama, deskripsi, harga, stok, dan upload gambar. Data masuk ke tabel `products`. |
| **READ**   | `merchandise.php` (User) <br> `admin/products.php` (Admin) <br> `function.php`: `getProducts()` | Menampilkan katalog produk yang tersedia di database.                                            |
| **UPDATE** | `admin/edit-product.php` <br> `function.php`: `updateProduct()`                                 | Admin mengedit detail produk. Jika gambar baru diupload, gambar lama diganti.                    |
| **DELETE** | `admin/delete-product.php` <br> `function.php`: `deleteProduct()`                               | Admin menghapus produk yang tidak lagi dijual.                                                   |

### 3. User & Admin Management

Sistem manajemen pengguna (admin) dengan role superadmin.

| Operasi    | File / Fungsi Terkait                                                                                                | Deskripsi Alur                                                                                                                          |
| :--------- | :------------------------------------------------------------------------------------------------------------------- | :-------------------------------------------------------------------------------------------------------------------------------------- |
| **CREATE** | `register.php`                                                                                                       | User mendaftar akun admin baru. Data masuk tabel `users` dengan `is_approved=0` (False).                                                |
| **READ**   | `admin/manage-admins.php` <br> `function.php`: `getPendingAdmins()`                                                  | Superadmin melihat daftar pendaftar yang menunggu persetujuan (approval).                                                               |
| **UPDATE** | `admin/approve-admin.php` <br> `admin/change-password.php` <br> `function.php`: `approveAdmin()`, `changePassword()` | **Approve**: Superadmin mengubah `is_approved` menjadi True.<br>**Change Password**: Admin mengupdate hash password mereka di database. |
| **DELETE** | `admin/reject-admin.php` <br> `admin/delete-admin.php` <br> `function.php`: `deleteAdminById()`                      | Superadmin menolak pendaftaran atau menghapus admin yang sudah ada.                                                                     |

### 4. Order System (Pemesanan)

Sistem pencatatan pesanan sebelum dialihkan ke WhatsApp.

| Operasi    | File / Fungsi Terkait                                 | Deskripsi Alur                                                                                                     |
| :--------- | :---------------------------------------------------- | :----------------------------------------------------------------------------------------------------------------- |
| **CREATE** | `order-form.php` <br> `function.php`: `insertOrder()` | Saat user checkout, data pembeli dan item disimpan ke tabel `orders` untuk arsip sebelum redirect ke API WhatsApp. |
| **READ**   | `function.php`: `getOrders()`                         | Data order tersimpan di database dan dapat diakses (backend function available) untuk rekapitulasi penjualan.      |

---

## 📖 Dokumentasi Fitur

### Kirim Confess

1. Klik tombol "✍️ Kirim Confess"
2. Isi form dengan cerita Anda
3. Pilih kategori (opsional)
4. Klik "Kirim Confess"
5. Catat **nomor confess** yang diberikan untuk tracking

### Cek Status Confess

1. Masuk ke halaman "Kirim Confess"
2. Scroll ke bagian "Cek Status Confess"
3. Masukkan nomor confess Anda
4. Klik "Cek" untuk melihat status

**Status yang tersedia:**

- ⏳ **Pending** - Sedang menunggu persetujuan admin
- ✅ **Acc** - Sudah disetujui dan ditampilkan di mading
- ❌ **Reject** - Ditolak oleh admin

### Lihat Mading

Halaman `mading.php` menampilkan semua confess yang telah disetujui (status: acc) beserta kategorinya.

### Admin Panel

Panel admin untuk moderasi confess:

- Melihat confess pending
- Menerima (approve) confess
- Menolak (reject) confess
- Mengelola data merchandise (Tambah/Edit/Hapus)
- Mengelola akun admin (Approve/Reject/Reset Password) - _Khusus Superadmin_

## 🔧 Fungsi Utama dalam `function.php`

### Confess Management

| Fungsi                           | Deskripsi                                             |
| -------------------------------- | ----------------------------------------------------- |
| `query($query)`                  | Menjalankan query dan mengembalikan hasil dalam array |
| `generateNomorConfess()`         | Generate nomor unik untuk confess (CF-XXXXX)          |
| `insertConfess($isi, $kategori)` | Menyimpan confess baru ke database                    |
| `cekStatus($nomor)`              | Mengecek status confess berdasarkan nomor             |
| `deleteConfess($id)`             | Menghapus confess berdasarkan ID                      |
| `getPending()`                   | Mengambil semua confess dengan status pending         |
| `getAcc()`                       | Mengambil semua confess yang sudah disetujui          |
| `getReject()`                    | Mengambil semua confess yang ditolak                  |
| `approveConfess($id)`            | Menyetujui confess (ubah status ke 'acc')             |
| `rejectConfess($id)`             | Menolak confess (ubah status ke 'reject')             |

### Authentication & Session

| Fungsi                              | Deskripsi                                       |
| ----------------------------------- | ----------------------------------------------- |
| `getUserByUsername($username)`      | Mencari user admin berdasarkan username         |
| `verifyLogin($username, $password)` | Verifikasi login admin dengan password_verify() |
| `startSession()`                    | Memulai session jika belum dimulai              |
| `isLoggedIn()`                      | Mengecek apakah admin sudah login               |
| `setAdminSession($user)`            | Set session admin setelah login berhasil        |
| `clearAdminSession()`               | Menghapus session admin (logout)                |
| `requireLogin($redirectTo)`         | Redirect jika belum login                       |
| `isSuperAdmin()`                    | Cek apakah user adalah superadmin               |
| `requireSuperAdmin($redirectTo)`    | Redirect jika bukan superadmin                  |

### Admin Management (Superadmin Only)

| Fungsi                  | Deskripsi                              |
| ----------------------- | -------------------------------------- |
| `getPendingAdmins()`    | Mengambil admin yang menunggu approval |
| `getApprovedAdmins()`   | Mengambil admin yang sudah disetujui   |
| `approveAdmin($userId)` | Approve admin baru                     |
| `rejectAdmin($userId)`  | Reject/delete admin                    |

### Product & Order Management

| Fungsi                                                     | Deskripsi                        |
| ---------------------------------------------------------- | -------------------------------- |
| `getProducts()`                                            | Mengambil semua produk           |
| `getProductById($id)`                                      | Mengambil produk berdasarkan ID  |
| `insertProduct($name, $desc, $price, $stock, $image)`      | Menambah produk baru             |
| `updateProduct($id, $name, $desc, $price, $stock, $image)` | Update produk                    |
| `deleteProduct($id)`                                       | Menghapus produk                 |
| `generateOrderNumber()`                                    | Generate nomor order (ORD-XXXXX) |
| `insertOrder($name, $phone, $address, $items, $total)`     | Menyimpan order baru             |
| `getOrders()`                                              | Mengambil semua orders           |

### Password Management

| Fungsi                            | Deskripsi                                             |
| --------------------------------- | ----------------------------------------------------- |
| `changePassword($old, $new)`      | Admin mengganti password sendiri                      |
| `resetAdminPassword($id, $newPw)` | Superadmin mereset password admin lain (customizable) |

### Superadmin Settings

- **One-Time Username Change**: Superadmin dapat mengubah username default mereka **SATU KALI SAJA**. Setelah diubah, username akan terkunci permanen demi keamanan.

## 🎨 Tema & Styling

Aplikasi menggunakan **pink theme** sebagai warna utama dengan beberapa komponen:

- **Primary Color**: Pink (#FF4F9D)
- **Framework**: Bootstrap untuk responsive design
- **Dark Mode**: Tersedia untuk user preference

## 🔒 Keamanan

### Implementasi Saat Ini:

- ✅ Input sanitization menggunakan `mysqli_real_escape_string()`
- ✅ Password hashing dengan `password_hash()` & `password_verify()`
- ✅ Session management untuk autentikasi
- ✅ Role-based access control (superadmin vs admin)
- ✅ Admin approval system (prevent unauthorized access)
- ✅ Database connection error handling

## 🆕 Changelog

### Version 2.2 - 02 Dec 2025

- 🔄 **UPDATE**: Perubahan kredensial default Superadmin
- ✨ **FEATURE**: Fitur Ganti Username Superadmin (Sekali Pakai)
- 🔐 **FEATURE**: Fitur ganti password untuk semua admin
- 🔐 **FEATURE**: Fitur reset password admin oleh Superadmin (Default)
- 🛍️ **FEATURE**: Integrasi checkout WhatsApp untuk merchandise
- 🐛 **FIXED**: Perbaikan alignment UI pada header/navbar
- ✨ **FEATURE**: **Custom Reset Password** - Superadmin bisa set password bebas saat reset akun admin
- 👁️ **FEATURE**: **Password Visibility Toggle** - Ikon mata di form login & register
- 📝 **DOCS**: Update dokumentasi fitur & changelog

### Version 2.1 - 28 Nov 2025

- 🔄 **RENAMED**: Halaman "Madding" → "Mading" (ejaan yang benar)
  - File `madding.php` → `mading.php`
  - Semua referensi dan link diupdate
  - Dokumentasi diperbarui

### Version 2.0 - 27 Nov 2025

- ✅ **FIXED**: Dark mode tidak berfungsi
  - Script `dark-mode.js` dipindah dari `<head>` ke sebelum `</body>`
  - Button ID diperbaiki di `darkmode.js`
- ✅ **FIXED**: Password superadmin salah
  - Hash password diupdate dengan yang benar
  - Login: /
- ✨ **NEW**: Merchandise system dengan product management
- ✨ **NEW**: Multi-admin system dengan approval workflow
- ✨ **NEW**: Order management system
- ✨ **NEW**: Admin dashboard dengan statistik
- 🎨 **IMPROVED**: UI/UX dengan dark mode yang berfungsi penuh

### Version 1.0 - Initial Release

- 🎭 Anonymous confess platform
- 📌 Mading board
- 🔍 Status tracking
- 👨‍💼 Basic admin panel

## 👨‍💻 Tim Pengembang

| No | Nama | NIM | Role | GitHub |
|---|---|---|---|---|
| 1 | Yosua Valentino Gulo | 251402055 | 🚀 Project Leader, Fullstack Dev | [@yopalll](https://github.com/yopalll) |
| 2 | Muhammad Vasha Nadar | 251402019 | 🎨 UI/UX Dev | - |
| 3 | Rodotua Naomi Mutiara Simamora | 251402030 | 📚 Dokumentasi & Asset Creator | - |
| 4 | Muhammad Kevin Ramadhan | 251402013 | 🔧 Helper | - |
| 5 | Ray Nathan Saragih | 251402046 | 🔧 Helper | - |
| 6 | Naufal Awan Harahap | 251402145 | 🔧 Helper | - |

**Repository**: [tifess](https://github.com/yopalll/tifess)

**Team**: Kelompok 6 ProWeb KOMA 25 TI USU

## 📞 Support & Contact

Jika menemukan bug atau ingin berkontribusi:

- 📧 Contact: [GitHub Profile](https://github.com/yopalll)

## 📄 Lisensi

Proyek ini adalah milik **Kelompok 6 ProWeb KOMA 25 TI USU**

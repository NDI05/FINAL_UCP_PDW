# Panduan Deployment cPanel - NDI Portal & CMS

Dokumen ini berisi panduan langkah demi langkah untuk meng-online-kan website Nusa Data Indonesia ke layanan *hosting* cPanel.

## Persyaratan Sistem (cPanel)
- **PHP Version:** Minimal PHP 8.1 (Disarankan PHP 8.2)
- **Ekstensi PHP:** `mysqli`, `pdo_mysql`, `mbstring`, `fileinfo`, `gd` atau `imagick`
- **Database:** MySQL / MariaDB

---

## Langkah 1: Upload File ke cPanel
1. Login ke akun cPanel Anda.
2. Masuk ke menu **File Manager**.
3. Navigasi ke dalam folder **`public_html`** (Ini adalah folder utama website Anda).
4. Klik tombol **Upload** di bagian atas, lalu pilih file `NDI_cPanel_Deploy.zip`.
5. Setelah upload selesai (100%), kembali ke File Manager.
6. Klik kanan pada file `NDI_cPanel_Deploy.zip` dan pilih **Extract**.
7. Pastikan seluruh struktur folder (seperti `app/`, `config/`, `public/`) langsung berada di bawah `public_html/`.

*(Opsional: Anda bisa memindahkan isi folder `public/` ke luar ke `public_html/` jika Anda tidak ingin URL memiliki embel-embel `/public`. Namun cara paling aman adalah membiarkan strukturnya, dan melakukan Pointing Domain).*

---

## Langkah 2: Pembuatan Database MySQL
1. Di cPanel, masuk ke menu **MySQL® Databases**.
2. Buat database baru (misal: `namauser_ndicms`).
3. Scroll ke bawah, buat **MySQL User** baru beserta *password*-nya (ingat baik-baik password ini).
4. Tambahkan User tersebut ke Database yang baru dibuat (Add User To Database).
5. Centang **ALL PRIVILEGES** saat memberikan izin.

---

## Langkah 3: Impor Tabel Database
1. Buka file `config/database.php` dari File Manager cPanel (Klik kanan -> Edit).
2. Sesuaikan konfigurasi berikut dengan data yang baru Anda buat:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'namauser_userdbanda');
   define('DB_PASS', 'password_yang_anda_buat');
   define('DB_NAME', 'namauser_ndicms');
   ```
   Simpan perubahan.
3. Kembali ke cPanel, buka menu **phpMyAdmin**.
4. Di bilah kiri, klik nama database Anda (`namauser_ndicms`).
5. Klik tab **Import** di menu atas.
6. Upload file `database/schema.sql` (atau ekspor dari localhost Anda) lalu klik **Go**.

*(Catatan: Anda juga dapat mengakses file `setup.php` di browser seperti `https://domainanda.com/setup.php` untuk menginisialisasi tabel secara otomatis).*

---

## Langkah 4: Pengaturan Folder Uploads (Permissions)
Di cPanel, biasanya hak akses otomatis disesuaikan (0755). Namun jika gambar gagal di-upload:
1. Masuk ke File Manager cPanel.
2. Cari folder `public/uploads/`.
3. Klik kanan pada folder tersebut -> **Change Permissions**.
4. Pastikan diset ke `755`. Jika masih gagal, ubah sementara menjadi `777` (meskipun 755 adalah standar teraman di cPanel).

---

## Langkah 5: Login Admin
- Akses website Anda: `https://domainanda.com/public/admin`
- Default Username: `admin`
- Default Password: `password`

Selesai! Website sudah siap digunakan secara publik.

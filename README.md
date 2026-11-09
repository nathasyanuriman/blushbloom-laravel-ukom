# Blush & Bloom — Sistem Manajemen Makeup Artist

Project web untuk UKOM menggunakan **Laravel 12, PHP, Blade, CSS, JavaScript, dan MySQL**. Tampilan mengikuti screenshot mockup yang diberikan: warna ivory, pink pastel, plum, ilustrasi kosmetik, kartu layanan, serta dashboard admin/customer.

## Fitur
- Landing page dan daftar layanan makeup.
- Registrasi customer dan login dengan password hash.
- Booking dengan pilihan layanan, tanggal, jam, jenis acara, lokasi, dan catatan.
- Dashboard customer untuk melihat status dan membatalkan booking yang masih menunggu.
- Dashboard Admin/MUA, pengelolaan layanan, update status booking, serta status pembayaran/transaksi.
- Validasi input, proteksi CSRF, middleware role, dan database migration.

## Persyaratan
- PHP 8.2 atau lebih baru dengan ekstensi standar Laravel (PDO MySQL, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo).
- Composer 2.
- MySQL/MariaDB. XAMPP dapat digunakan untuk MySQL.
- Browser modern.

## Cara menjalankan di Windows
1. Ekstrak folder project ke lokasi kerja, misalnya `C:\laragon\www\BlushBloom-Laravel` atau folder kerja lain. Jangan masukkan folder ini ke `htdocs` jika hanya ingin menjalankan dengan `artisan serve`; Laravel akan dijalankan dari terminal.
2. Jalankan MySQL dari XAMPP. Buka `http://localhost/phpmyadmin`, buat database baru bernama `blush_bloom` dengan collation `utf8mb4_unicode_ci`.
3. Buka terminal pada folder project. Jalankan `composer install`.
4. Salin `.env.example` menjadi `.env` (di PowerShell: `Copy-Item .env.example .env`).
5. Jalankan `php artisan key:generate`.
6. Pastikan konfigurasi database pada `.env`: `DB_DATABASE=blush_bloom`, `DB_USERNAME=root`, `DB_PASSWORD=` (sesuaikan jika MySQL kamu memakai password).
7. Jalankan `php artisan migrate --seed`.
8. Jalankan `php artisan serve`, lalu buka `http://127.0.0.1:8000`.

## Akun demo lokal
Seeder membuat akun untuk uji coba. Ganti password dan jangan gunakan kredensial ini untuk website publik.
- Admin: `admin@blushbloom.test` / `Admin12345!`
- Customer: `customer@blushbloom.test` / `Customer12345!`

## Catatan penting
- Folder `vendor` sengaja tidak disertakan agar ZIP lebih kecil. `composer install` perlu dijalankan sebelum aplikasi digunakan.
- Project ini adalah source awal yang disiapkan berdasarkan screenshot. Karena lingkungan ini tidak memiliki Composer dan dependency Laravel belum terpasang, aplikasi belum bisa dijalankan end-to-end di sini. Jalankan langkah instalasi, lalu jika ada error terminal, kirim teks error lengkap untuk diperbaiki.
- Untuk akses Admin, gunakan akun admin demo atau ubah role pengguna yang sudah ada melalui database. Registrasi publik selalu membuat role `customer`.
- Harga demo dan data layanan bisa kamu ubah melalui halaman Layanan di area admin.

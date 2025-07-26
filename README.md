API Toko Online Sederhana (Backend)
Ini adalah backend API untuk aplikasi toko online sederhana yang dibangun menggunakan Laravel. API ini menyediakan fungsionalitas untuk autentikasi pengguna, manajemen produk, proses checkout, dan statistik untuk dasbor admin.

Fitur Utama
Autentikasi JWT: Sistem login dan registrasi yang aman menggunakan JSON Web Tokens.

Manajemen Peran: Peran terpisah untuk Admin (mengelola toko) dan Customer (melakukan transaksi).

CRUD Produk: Fungsionalitas penuh untuk membuat, membaca, memperbarui, dan menghapus produk, termasuk unggah gambar.

Sistem Order: Logika untuk memproses checkout, mengurangi stok secara otomatis, dan mencatat transaksi.

Endpoint Dasbor: Menyediakan data statistik agregat untuk ditampilkan di dasbor admin.

Teknologi yang Digunakan
Framework: Laravel

Database: MySQL

Autentikasi: tymon/jwt-auth

Panduan Instalasi
Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

1. Prasyarat
   PHP (versi 8.1 atau lebih baru)

Composer

Server Database (MySQL atau MariaDB)

2. Instalasi Proyek
   Clone repository ini:

git clone https://github.com/ezz001-dev/simple-store-api.git
cd simple-store-api

Instal dependensi PHP:

composer install

Buat file .env:
Salin file .env.example menjadi .env.

cp .env.example .env

Konfigurasi Database di .env:
Sesuaikan variabel berikut dengan konfigurasi database lokal Anda.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_online_db
DB_USERNAME=root
DB_PASSWORD=

Pastikan Anda sudah membuat database toko_online_db di MySQL Anda.

Generate Kunci Aplikasi & JWT:

php artisan key:generate
php artisan jwt:secret

Jalankan Migrasi dan Seeder:
Perintah ini akan membuat semua tabel yang diperlukan dan mengisinya dengan data dummy (1 admin, 1 customer, dan beberapa produk).

php artisan migrate:fresh --seed

Buat Symbolic Link untuk Storage:
Ini penting agar gambar produk yang diunggah dapat diakses dari web.

php artisan storage:link

3. Menjalankan Server
   Jalankan server pengembangan Laravel:

php artisan serve

API akan tersedia di http://127.0.0.1:8000.

Akun Demo
Setelah menjalankan seeder, Anda dapat menggunakan akun berikut untuk login:

Admin:

Email: admin@gmail.com

Password: password123

Customer:

Email: customer@gmail.com

Password: password123

Hormat : Adisunjana443@gmail.com

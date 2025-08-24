# Topup Game

![Build Status](https://img.shields.io/badge/build-passing-brightgreen)
![Laravel Version](https://img.shields.io/badge/laravel-11.x-blue)
![License](https://img.shields.io/badge/license-MIT-green)

## Deskripsi

Topup Game adalah platform web yang dibangun menggunakan **Laravel 11** untuk memudahkan pengguna melakukan top-up kredit game online. Dengan antarmuka yang responsif dan aman, sistem ini mengintegrasikan manajemen akun, transaksi, dan notifikasi otomatis, sehingga ideal untuk developer, penyedia layanan top-up, dan gamer.

## Fitur Utama

* 🔐 **Autentikasi & Otorisasi**: Laravel Breeze memfasilitasi registrasi, login, dan manajemen peran (Admin & User).
* 💳 **Top-up Otomatis**: Pengguna dapat memilih metode pembayaran dan top-up game secara real-time.
* 📊 **Dashboard Admin**: Melihat laporan transaksi harian, status top-up, dan statistik pengguna.
* 📧 **Notifikasi Email**: Konfirmasi transaksi dikirim otomatis setelah pembayaran berhasil.
* 🗄️ **Migrasi & Seeder**: Pengaturan database mudah dengan Laravel Migration dan Seeder.
* 🔔 **Webhooks & Event**: Pemrosesan asynchronous untuk meningkatkan performa.

## Instalasi

1. **Clone Repository**

   ```bash
   git clone https://github.com/Wz-00/topup_game.git
   cd topup_game
   ```
2. **Install Dependencies**

   ```bash
   composer install
   npm install && npm run build
   ```
3. **Konfigurasi Lingkungan**

   * Salin `.env.example` menjadi `.env`
   * Sesuaikan konfigurasi database, mail, dan API pembayaran:

     ```dotenv
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=topup_game
     DB_USERNAME=root
     DB_PASSWORD=

     MAIL_MAILER=smtp
     MAIL_HOST=smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=your_username
     MAIL_PASSWORD=your_password
     MAIL_ENCRYPTION=tls
     ```
4. **Generate App Key**

   ```bash
   php artisan key:generate
   ```
5. **Migrasi & Seeder**

   ```bash
   php artisan migrate --seed
   ```
6. **Jalankan Server**

   ```bash
   php artisan serve
   ```

## Penggunaan

* Akses halaman utama di `http://localhost:8000`
* Daftar akun baru atau login dengan akun yang sudah ada
* Untuk Admin, kunjungi `/admin/dashboard` untuk melihat laporan dan kelola transaksi
* Pengguna dapat memilih game, nominal top-up, dan metode pembayaran

## Struktur Folder

```
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Events/Listeners/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── assets/
└── routes/
    └── web.php
```

## Teknologi

* **Bahasa**: PHP 8.x
* **Framework**: Laravel 11
* **Database**: MySQL
* **Front-end**: Blade, Tailwind CSS, Alpine.js
* **Notifikasi**: Laravel Mail & Events

## Kontribusi

Kontribusi sangat kami hargai! Silakan ajukan *pull request* atau buat *issue* untuk fitur baru dan perbaikan bug.

## Lisensi

Proyek ini dilisensikan di bawah [CC-BY-NC 4.0](LICENSE).

## Kontak

Dikembangkan oleh Wizz Sendpai. Untuk pertanyaan atau kolaborasi, hubungi:

* Email: `wildanjk14@gmail.com`
* GitHub: [Wz-00](https://github.com/Wz-00)

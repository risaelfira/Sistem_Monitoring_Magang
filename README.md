# Sistem Monitoring Magang — Laravel 12

## Instalasi
1. Pastikan PHP 8.2+, Composer, dan MySQL tersedia.
2. Jalankan:
   composer install
3. Salin `.env.example` menjadi `.env`.
4. Buat database MySQL bernama `monitoring_magang`.
5. Jalankan:
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
6. Jalankan:
   php artisan serve

Buka http://127.0.0.1:8000

## Modul
- Registrasi & Login
- Dashboard
- Progres Magang Mingguan
- Dokumentasi Foto
- Progres Bab 1–5
- Dokumen Penunjang Sidang
- Progres Harian Tugas Akhir
# Sistem_Monitoring_Magang

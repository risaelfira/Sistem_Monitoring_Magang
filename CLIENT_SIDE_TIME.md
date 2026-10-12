# Client-Side Time

Perubahan pada sistem Monitoring Magang:

- Waktu aksi form diambil dari browser menggunakan JavaScript `new Date()`.
- Nilai dikirim melalui field tersembunyi `client_datetime` dalam format ISO-8601 beserta timezone offset.
- Controller menggunakan `clientNow()` sebagai sumber waktu untuk timestamp data baru/perubahan.
- Progres Harian mengisi tanggal default berdasarkan tanggal perangkat.
- Riwayat perubahan status Proyek Akhir menggunakan waktu client.
- Jika browser tidak mengirim waktu client, aplikasi tetap memiliki fallback ke waktu server.

Catatan:
- `created_at` dan `updated_at` tetap disimpan pada kolom Laravel yang sudah ada, sehingga tidak perlu migration tambahan.
- Waktu dari client dapat dimanipulasi oleh pengguna. Untuk sistem internal monitoring pribadi/magang ini biasanya cukup; untuk audit keamanan tinggi, waktu server tetap lebih tepat.

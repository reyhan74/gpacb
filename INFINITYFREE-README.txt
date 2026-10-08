GPA SMK Canda Bhirawa Pare - Paket InfinityFree

1. Upload seluruh isi folder `htdocs` ke folder `htdocs` InfinityFree.
2. Upload folder aplikasi: app, bootstrap, config, database, lang, resources, routes, storage, vendor, artisan, composer.json ke SATU LEVEL DI ATAS folder htdocs.
3. Salin `.env.infinity.example` menjadi `.env` di folder aplikasi.
4. Isi APP_KEY dengan nilai acak 32 karakter berawalan base64: (buat lokal, jangan kirim ke chat).
5. Isi DB_* sesuai MySQL InfinityFree. Jangan gunakan credential contoh.
6. Set APP_URL ke domain InfinityFree.
7. Import database lokal melalui phpMyAdmin. Jangan jalankan migration produksi tanpa backup.
8. Pastikan folder `storage/framework/cache`, `storage/framework/sessions`, `storage/framework/views`, `storage/logs`, `htdocs/storage` writable.
9. Karena InfinityFree tidak mendukung SSH/Composer, folder vendor sudah disertakan.
10. Buka domain. Login memakai akun yang sudah ada dari database import.

Struktur:
  app-package/       source Laravel + vendor
  htdocs/            isi web root InfinityFree

Catatan:
- Queue worker, scheduler, dan systemd tidak tersedia di InfinityFree gratis.
- Fitur yang memerlukan worker background tidak berjalan otomatis.
- Jangan upload file .env produksi atau credential ke arsip publik.
- Untuk file upload, paket ini memakai htdocs/storage sebagai public disk.

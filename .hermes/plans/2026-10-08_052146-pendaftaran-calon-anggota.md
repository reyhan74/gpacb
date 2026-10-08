# Pendaftaran Calon Anggota GPA Implementation Plan

> **For Hermes:** Use subagent-driven-development skill to implement this plan task-by-task.

**Goal:** Menambahkan alur calon anggota GPA dari pendaftaran, pematerian, Diklat Ruang, hingga Diklat SAR; NIA hanya diterbitkan setelah calon mengikuti/lulus Diklat SAR.

**Architecture:** Buat entitas `candidate_registrations` terpisah dari `members`, dengan workflow tahap pendidikan yang statusnya dapat diaudit. Pengunjung mendaftar; pengurus memverifikasi dan mencatat kehadiran/kelulusan pada setiap tahap. Kandidat belum menjadi anggota resmi, belum memiliki NIA, dan belum mendapat akses anggota sampai tahap Diklat SAR dinyatakan selesai/lulus. Setelah itu Superadmin menyetujui penerbitan NIA serta membuat akun user + record member dalam satu transaksi.

**Tech Stack:** Laravel, MySQL, Blade, Bootstrap 5, Form Request/validation, Eloquent transaction, PHPUnit Feature tests.

---

## Keputusan Alur

1. Menu publik: **Pendaftaran Calon Anggota**.
2. Form publik tidak memerlukan login.
3. Field wajib awal:
   - Nama lengkap
   - Nama lapangan/nama panggilan
   - NIS
   - Tempat dan tanggal lahir
   - Jenis kelamin
   - Agama
   - Nomor WhatsApp
   - Alamat
   - Angkatan yang dipilih
   - Persetujuan mengikuti proses seleksi
4. Field opsional:
   - Email
   - Foto
   - Kontak darurat
   - Catatan motivasi
5. Tahapan wajib calon:
   - `registered`: baru mendaftar
   - `materi`: mengikuti pematerian
   - `diklat_ruang`: mengikuti/lulus Diklat Ruang
   - `diklat_sar`: mengikuti/lulus Diklat SAR
   - `nia_eligible`: seluruh syarat terpenuhi, siap diterbitkan NIA
   - `member`: sudah menjadi anggota resmi dan memiliki NIA
   - `rejected`: ditolak/gugur, wajib menyimpan alasan
6. Setiap tahap menyimpan status `not_started`, `scheduled`, `attended`, `passed`, atau `failed`, bersama tanggal, catatan, dan petugas yang memverifikasi.
7. Urutan wajib: pendaftaran → pematerian → Diklat Ruang → Diklat SAR. Kandidat tidak dapat melompat tahap.
8. NIA tidak diisi publik dan tidak diterbitkan saat pendaftaran, pematerian, atau Diklat Ruang. NIA hanya dibuat setelah Diklat SAR berstatus `passed`/lulus dan Superadmin mengonfirmasi penerbitan.
9. Kandidat tidak langsung menjadi anggota dan tidak langsung memperoleh akses login.
10. Data publik hanya menampilkan form dan status milik pendaftar; tidak menampilkan tabel kandidat atau anggota.

---

## Task 1: Model data kandidat

**Files:**
- Create: `database/migrations/YYYY_MM_DD_HHMMSS_create_candidate_registrations_table.php`
- Create: `app/Models/CandidateRegistration.php`
- Modify: `app/Models/User.php` bila relasi diperlukan
- Modify: `app/Models/Member.php` bila relasi kandidat diperlukan

**Kolom yang disarankan:**

```text
id
registration_code unique
nama
nama_lapangan nullable
nis nullable
email nullable
no_hp
tempat_lahir nullable
tanggal_lahir nullable
ttl_raw nullable
jenis_kelamin nullable
agama nullable
alamat nullable
angkatan
motivasi nullable
kontak_darurat nullable
foto nullable
status default registered
materi_status default not_started
materi_date nullable
materi_notes nullable
diklat_ruang_status default not_started
diklat_ruang_date nullable
diklat_ruang_notes nullable
diklat_sar_status default not_started
diklat_sar_date nullable
diklat_sar_notes nullable
review_notes nullable
rejection_reason nullable
reviewed_by nullable foreign users
reviewed_at nullable
nia_eligible_at nullable
nia_issued_at nullable
approved_member_id nullable foreign members
approved_by nullable foreign users
approved_at nullable
current_stage nullable
consent_at nullable
consent_ip nullable
created_at
updated_at
```

**Validasi:** enum status dibatasi di aplikasi/database; `registration_code` dibuat acak dan tidak memakai ID berurutan yang mudah ditebak.

**Test:** migration berjalan tanpa mengubah data produksi; unique constraint kode pendaftaran terbukti.

---

## Task 2: Form Request dan layanan pendaftaran

**Files:**
- Create: `app/Http/Requests/StoreCandidateRegistrationRequest.php`
- Create: `app/Services/CandidateRegistrationService.php`
- Create: `app/Rules/UniqueCandidateContact.php` bila diperlukan

**Implementasi:**

- Validasi server-side semua field.
- Normalisasi nomor WhatsApp.
- Validasi file foto: JPG/PNG/WebP, maksimal 2 MB.
- Simpan upload melalui disk `public` ke `candidate-registrations/`.
- Buat `registration_code` aman, misalnya `GPA-CALON-` + random uppercase.
- Simpan kandidat memakai transaction.
- Jangan membuat user/member saat submit publik.
- Lindungi endpoint dari spam dengan rate limit dan honeypot/captcha sederhana bila diperlukan.

**Test RED-GREEN:**

- Form valid tersimpan sebagai `pending`.
- Field wajib kosong ditolak.
- File non-gambar/terlalu besar ditolak.
- Kode pendaftaran unik.
- Submit berulang dengan kontak yang sama ditangani secara jelas.

---

## Task 3: Halaman publik dan menu pengunjung

**Files:**
- Create: `app/Http/Controllers/CandidateRegistrationController.php`
- Create: `resources/views/public/candidate-register.blade.php`
- Create: `resources/views/public/candidate-status.blade.php`
- Modify: `resources/views/public/partials/navbar.blade.php`
- Modify: `resources/views/public/home.blade.php`
- Modify: `routes/web.php`

**Routes:**

```text
GET  /pendaftaran-calon-anggota       public.candidates.create
POST /pendaftaran-calon-anggota       public.candidates.store
GET  /pendaftaran-calon-anggota/status public.candidates.status
```

**UI:**

- Gunakan navbar publik terpusat yang sudah ada.
- Tambahkan tombol/menu **Daftar Calon Anggota**.
- Tampilkan instruksi seleksi sebelum form.
- Setelah berhasil, tampilkan kode pendaftaran dan langkah berikutnya.
- Status lookup menggunakan kode pendaftaran + nomor WhatsApp/email, bukan kode saja.
- Jangan tampilkan NIA atau data anggota lain sebelum disetujui.

**Test:** GET form HTTP 200; POST valid redirect ke halaman hasil; guest dapat membuka form; data anggota tidak bocor.

---

## Task 4: Workflow tahapan pendidikan calon

**Files:**
- Create: `app/Services/CandidateStageService.php`
- Create: `app/Http/Requests/UpdateCandidateStageRequest.php`
- Create: `database/migrations/YYYY_MM_DD_HHMMSS_add_candidate_stage_records_table.php` bila riwayat per tahap dipisahkan
- Create: `app/Models/CandidateStageRecord.php` bila memakai tabel riwayat

**Tahapan dan aturan:**

1. `registered` → calon baru terdaftar.
2. `materi` → calon mengikuti pematerian sebelum diklat.
3. `diklat_ruang` → calon mengikuti dan dinyatakan lulus Diklat Ruang.
4. `diklat_sar` → calon mengikuti dan dinyatakan lulus Diklat SAR.
5. Setelah Diklat SAR lulus, sistem mengubah status menjadi `nia_eligible`.
6. Hanya Superadmin yang dapat menerbitkan NIA dan mengubah status menjadi `member`.

**Aturan transisi:**

- Tidak boleh mencatat Diklat Ruang sebelum pematerian lulus/selesai.
- Tidak boleh mencatat Diklat SAR sebelum Diklat Ruang lulus/selesai.
- Status `failed` mengharuskan catatan dan tidak dapat maju ke tahap berikutnya sebelum diulang/lulus.
- Setiap perubahan menyimpan petugas, waktu, hasil, catatan, dan tanggal pelaksanaan.
- Riwayat tahap tidak boleh dihapus; koreksi dilakukan melalui catatan/audit.

**Test:** transisi loncat ditolak; tahap valid berhasil; Diklat SAR `passed` menghasilkan `nia_eligible`; perubahan tercatat.

---

## Task 5: Menu dan workflow Superadmin

**Files:**
- Modify: `config/gpa_navigation.php`
- Modify: `routes/web.php`
- Modify: `app/Http/Controllers/MemberAdminController.php` atau buat `app/Http/Controllers/CandidateAdminController.php`
- Create: `resources/views/manage/candidates/index.blade.php`
- Create: `resources/views/manage/candidates/show.blade.php`

**Routes dengan middleware:**

```text
GET   /manage/candidates                         manage.candidates.index
GET   /manage/candidates/{candidate}             manage.candidates.show
PATCH /manage/candidates/{candidate}/stage      manage.candidates.stage
PATCH /manage/candidates/{candidate}/review      manage.candidates.review
PATCH /manage/candidates/{candidate}/issue-nia  manage.candidates.issue-nia
PATCH /manage/candidates/{candidate}/reject      manage.candidates.reject
```

**Fitur daftar:**

- Filter tahap/status: Registered, Pematerian, Diklat Ruang, Diklat SAR, Siap NIA, Anggota, Ditolak.
- Search nama, kode pendaftaran, NIS, nomor HP.
- Pagination dengan `withQueryString()`.
- Badge tahap dan status kelulusan.
- Hanya Superadmin yang boleh mencatat kelulusan final dan menerbitkan NIA.

**Fitur detail:**

- Tampilkan data kandidat dan timeline tahap.
- Form catat kehadiran/hasil pematerian.
- Form catat hasil Diklat Ruang.
- Form catat hasil Diklat SAR.
- Tombol `Terbitkan NIA` hanya aktif jika Diklat SAR `passed`.
- Tolak/gugurkan wajib mengisi alasan.
- Record `member`/NIA terbit tidak dapat diproses ulang.

**Test:** role tidak berwenang menerima 403; filter/pagination mempertahankan query; tahap loncat ditolak; tombol penerbitan NIA terkunci sebelum SAR lulus.

---

## Task 6: Konversi calon menjadi anggota resmi dan penerbitan NIA

**Files:**
- Modify: `app/Services/CandidateRegistrationService.php`
- Modify: `app/Services/MemberService.php` jika generator user/member dapat dipakai ulang
- Modify: `app/Http/Controllers/CandidateAdminController.php`
- Create: migration bila perlu menambah `candidate_registration_id` pada `members`

**Prasyarat mutlak:**

- Status kandidat `nia_eligible`.
- `materi_status = passed` atau hasil selesai yang ditentukan GPA.
- `diklat_ruang_status = passed`.
- `diklat_sar_status = passed`.
- Belum ada `approved_member_id` atau NIA terbit.

**Transaksi penerbitan NIA:**

1. Lock row kandidat.
2. Validasi ulang seluruh prasyarat di dalam transaksi.
3. Generate NIA unik berdasarkan angkatan.
4. Buat user dengan role anggota.
5. Set password awal sesuai kebijakan aplikasi; jangan tampilkan credential di halaman publik.
6. Set `must_change_password = true`.
7. Buat record `members` menggunakan data calon.
8. Set kandidat `member`, `nia_issued_at`, `approved_member_id`, `approved_by`, `approved_at`.
9. Commit.

Jika satu langkah gagal, seluruh transaksi rollback. Penerbitan kedua harus ditolak/no-op dan tidak membuat akun atau NIA ganda.

**Test:** kandidat tanpa Diklat SAR lulus tidak dapat memperoleh NIA; kandidat lengkap membuat tepat satu member + user + NIA unik; penerbitan ulang ditolak; kegagalan transaksi tidak meninggalkan record parsial.

---

## Task 7: Penolakan, notifikasi, dan keamanan data

**Files:**
- Create/modify notification class sesuai channel yang sudah tersedia
- Modify: `app/Http/Controllers/CandidateRegistrationController.php`
- Modify: `resources/views/public/candidate-status.blade.php`

**Aturan:**

- Status publik menampilkan tahap terakhir, bukan NIA sebelum NIA resmi diterbitkan.
- Alasan penolakan hanya terlihat pendaftar terkait dan Superadmin.
- Setelah Diklat SAR lulus, status dapat menampilkan `Siap penerbitan NIA`.
- NIA baru ditampilkan setelah penerbitan selesai.
- Jangan kirim password melalui WhatsApp/email.
- Foto kandidat disajikan melalui route terproteksi untuk Superadmin.

---

## Task 8: UX, navigasi, dan dokumentasi

**Files:**
- Modify: `resources/views/public/home.blade.php`
- Modify: `resources/views/manage/dashboard.blade.php`
- Modify: `resources/views/manage/candidates/index.blade.php`
- Create: `resources/views/manage/candidates/partials/stage-timeline.blade.php`

**UI:**

- CTA publik menjelaskan urutan: Daftar → Pematerian → Diklat Ruang → Diklat SAR → NIA.
- Dashboard Superadmin menampilkan counter per tahap.
- Gunakan istilah konsisten: `Calon Anggota`, `Pematerian`, `Diklat Ruang`, `Diklat SAR`, `Siap NIA`, `Anggota Resmi`.
- Timeline detail menunjukkan tanggal, hasil, catatan, dan petugas.
- Tombol `Terbitkan NIA` diberi penjelasan jika masih terkunci.

---

## Task 9: Validasi menyeluruh

**Commands:**

```bash
cd /root/generasi-pencinta-alam
/root/.config/herd-lite/bin/php artisan migrate --force
/root/.config/herd-lite/bin/php artisan optimize:clear
/root/.config/herd-lite/bin/php artisan view:cache
/root/.config/herd-lite/bin/php artisan route:list
/root/.config/herd-lite/bin/php artisan test
```

**Skenario acceptance:**

- Pengunjung mengisi pendaftaran.
- Calon terlihat sebagai `registered`.
- Pengurus mencatat pematerian.
- Sistem menolak Diklat SAR sebelum Diklat Ruang selesai.
- Pengurus mencatat Diklat Ruang lulus.
- Pengurus mencatat Diklat SAR lulus.
- Status berubah menjadi `nia_eligible`.
- Superadmin menerbitkan NIA.
- Sistem membuat tepat satu akun user dan satu record member.
- NIA tampil pada status calon setelah penerbitan.
- Kandidat wajib mengganti password pada login pertama.
- Penerbitan ulang tidak menggandakan data.
- Data kandidat/anggota tidak terbuka ke publik.

---

## Task 10: Keputusan yang perlu dikunci

1. Apakah “lulus pematerian” wajib, atau cukup hadir?
2. Apakah Diklat Ruang dan Diklat SAR punya nilai/absensi minimum?
3. Siapa yang boleh mencatat hasil tahap: Superadmin saja atau Admin/Pengurus tertentu?
4. Apakah calon yang gagal dapat mengulang tahap yang sama?
5. Apakah NIA diterbitkan langsung oleh Superadmin setelah SAR lulus, atau menunggu verifikasi akhir?
6. Apakah Diklat SAR merupakan satu kegiatan atau memiliki beberapa sesi/gelombang?
7. Apakah periode pendaftaran dibuka/tutup oleh Superadmin?

**Rekomendasi default:** hadir dan lulus pada setiap tahap, Admin boleh mencatat kehadiran tetapi Superadmin mengunci hasil akhir, tahap gagal dapat diulang, NIA hanya diterbitkan Superadmin setelah verifikasi Diklat SAR.

---

## Catatan implementasi

Task lama 4–10 pada dokumen sebelumnya digantikan oleh workflow bertahap di atas. Jangan membuat `members` atau menerbitkan NIA saat calon baru mendaftar.

---

## Arsip rincian sebelumnya

Rincian field form, proteksi upload, rate limit, dan route publik tetap berlaku dari bagian task sebelumnya; implementasi harus mengikuti prasyarat penerbitan NIA di atas.

---

## Task 11: Validasi akhir deployment

**Acceptance tambahan:**

- Jalankan `php artisan route:list` dan pastikan semua route pendaftaran/stage/NIA bernama.
- Uji guest, Admin, dan Superadmin.
- Uji database transaction approval dengan data uji terisolasi.
- Pastikan production tidak diubah tanpa backup dan verifikasi terlebih dahulu.

---

## Keputusan lama yang tetap berlaku

1. NIA format tetap mengikuti format GPA yang sudah dipakai, misalnya `GPA.XXVI.001`.
2. Pendaftaran publik tidak menampilkan tabel anggota.
3. Credential tidak ditampilkan dalam plan atau halaman publik.
4. Upload foto harus tervalidasi dan disimpan pada disk public/route aman sesuai kebutuhan.
5. Pagination/search admin harus mempertahankan query string.

---

## Pertanyaan terbuka

1. Apakah calon memperoleh nomor pendaftaran setelah submit atau setelah diverifikasi pengurus?
2. Apakah satu nomor WhatsApp boleh dipakai beberapa calon dalam satu periode?
3. Apakah calon lama dapat dipindahkan ke angkatan berikutnya?
4. Berapa lama riwayat calon disimpan?

**Default implementasi bila belum ada keputusan tambahan:** nomor pendaftaran diterbitkan saat submit, satu kontak boleh dipakai satu pendaftaran aktif, calon gagal dapat mendaftar ulang setelah status lama ditutup, riwayat disimpan.

---

## Handoff

Plan sudah disesuaikan dengan alur: daftar → pematerian → Diklat Ruang → Diklat SAR → penerbitan NIA. Implementasi berikutnya harus dimulai dari model/tabel kandidat dan riwayat tahap, lalu route publik dan workflow Superadmin.

---

## Lampiran: cakupan awal form publik

Field minimal tetap: nama, nama lapangan, NIS, TTL, jenis kelamin, agama, nomor WhatsApp, alamat, angkatan, persetujuan proses seleksi. Field foto, email, kontak darurat, dan motivasi tetap opsional.

---

## Lampiran: aturan keamanan

- Authorization policy untuk detail kandidat.
- Foto kandidat tidak boleh menjadi URL publik tanpa kontrol.
- Jangan mengirim password.
- Lock kandidat saat penerbitan NIA.
- Audit seluruh perubahan tahap.
- Gunakan transaction dan unique constraint untuk NIA/user.

---

## Lampiran: referensi file aktif

- `routes/web.php`
- `config/gpa_navigation.php`
- `app/Models/Member.php`
- `app/Services/MemberService.php`
- `app/Http/Controllers/MemberAdminController.php`
- `resources/views/public/partials/navbar.blade.php`
- `resources/views/manage/members/index.blade.php`

**Files:**
- Modify: `config/gpa_navigation.php`
- Modify: `routes/web.php`
- Modify: `app/Http/Controllers/MemberAdminController.php` atau buat `app/Http/Controllers/CandidateAdminController.php`
- Create: `resources/views/manage/candidates/index.blade.php`
- Create: `resources/views/manage/candidates/show.blade.php`

**Routes dengan middleware:**

```text
GET   /manage/candidates                    manage.candidates.index
GET   /manage/candidates/{candidate}        manage.candidates.show
PATCH /manage/candidates/{candidate}/review manage.candidates.review
PATCH /manage/candidates/{candidate}/approve manage.candidates.approve
PATCH /manage/candidates/{candidate}/reject  manage.candidates.reject
```

**Fitur daftar:**

- Filter status.
- Search nama, kode pendaftaran, NIS, nomor HP.
- Pagination dengan `withQueryString()`.
- Badge status.
- Hanya Superadmin yang boleh approve/reject; Admin dapat diberi akses review jika diputuskan kemudian.

**Fitur detail:**

- Tampilkan seluruh data kandidat dan foto melalui route/storage aman.
- Tombol **Mulai Review**, **Setujui**, **Tolak**.
- Tolak wajib mengisi alasan.
- Record terminal (`approved`/`rejected`) tidak dapat diproses ulang.

**Test:** role yang tidak berwenang menerima 403; filter/pagination mempertahankan query; rejection tanpa alasan ditolak.

---

## Task 5: Konversi kandidat menjadi anggota resmi

**Files:**
- Modify: `app/Services/CandidateRegistrationService.php`
- Modify: `app/Services/MemberService.php` jika generator user/member dapat dipakai ulang
- Modify: `app/Http/Controllers/CandidateAdminController.php`
- Create: migration bila perlu menambah `candidate_registration_id` pada `members`

**Transaksi persetujuan:**

1. Lock row kandidat.
2. Pastikan status masih `pending`/`review`.
3. Generate NIA unik berdasarkan angkatan.
4. Buat user dengan role anggota.
5. Set password awal sesuai kebijakan yang sudah dipakai aplikasi, tanpa menampilkan credential di halaman publik.
6. Set `must_change_password = true`.
7. Buat record `members` memakai data kandidat.
8. Set kandidat `approved`, `approved_member_id`, `reviewed_by`, `reviewed_at`.
9. Commit.

Jika satu langkah gagal, seluruh transaksi rollback. Approval kedua harus no-op/ditolak, bukan membuat akun ganda.

**Test:** approval membuat tepat satu user/member; NIA unik; approval ulang ditolak; kegagalan transaksi tidak meninggalkan record parsial.

---

## Task 6: Penolakan, notifikasi, dan keamanan data

**Files:**
- Create/modify notification class sesuai channel yang sudah tersedia
- Modify: `app/Http/Controllers/CandidateRegistrationController.php`
- Modify: `resources/views/public/candidate-status.blade.php`

**Aturan:**

- Alasan penolakan hanya terlihat oleh pendaftar terkait dan Superadmin.
- Jangan kirim password melalui WhatsApp/email.
- Notifikasi persetujuan hanya menyampaikan kode/NIA dan instruksi login aman.
- Jika provider notifikasi belum siap, simpan status dan tampilkan pesan internal tanpa menggagalkan approval.
- Foto kandidat disajikan melalui route terproteksi untuk Superadmin, bukan URL publik bebas.
- Terapkan authorization policy pada seluruh detail/update kandidat.

**Test:** kandidat A tidak dapat melihat status kandidat B; URL foto tanpa otorisasi ditolak; credential tidak muncul di HTML/log.

---

## Task 7: UX, navigasi, dan dokumentasi

**Files:**
- Modify: `resources/views/public/home.blade.php`
- Modify: `resources/views/manage/dashboard.blade.php`
- Modify: `resources/views/manage/candidates/index.blade.php`
- Create: `resources/views/manage/candidates/partials/status-badge.blade.php` bila diperlukan

**UI:**

- Tambah CTA di landing page.
- Tampilkan counter calon `pending` di dashboard Superadmin.
- Gunakan istilah konsisten: **Calon Anggota**, **Pendaftaran**, **Diterima**, **Ditolak**.
- Responsive Bootstrap dan dark mode.
- Empty state ketika belum ada pendaftar.

**Verifikasi:** semua menu baru punya named route, view, middleware, dan endpoint valid.

---

## Task 8: Validasi menyeluruh

**Commands:**

```bash
cd /root/generasi-pencinta-alam
/root/.config/herd-lite/bin/php artisan migrate --force
/root/.config/herd-lite/bin/php artisan optimize:clear
/root/.config/herd-lite/bin/php artisan view:cache
/root/.config/herd-lite/bin/php artisan route:list
/root/.config/herd-lite/bin/php artisan test
```

**Skenario acceptance:**

- Pengunjung membuka form.
- Pengunjung mengirim data valid.
- Kode pendaftaran tampil.
- Status dapat dicek dengan kredensial verifikasi yang benar.
- Superadmin melihat kandidat `pending`.
- Superadmin melakukan review.
- Reject tanpa alasan gagal.
- Reject dengan alasan berhasil.
- Approve membuat satu member + satu user + NIA unik.
- Kandidat wajib mengganti password pada login pertama.
- Approval ulang tidak menggandakan data.
- Filter/pagination admin tetap mempertahankan query.
- Halaman publik tidak menampilkan tabel anggota/kandidat.

---

## Risiko dan Keputusan yang Perlu Dikunci Sebelum Implementasi

1. Apakah pendaftaran terbuka sepanjang tahun atau hanya periode tertentu?
2. Apakah Admin boleh melakukan review/approve, atau hanya Superadmin?
3. Field seleksi tambahan: asal sekolah, tinggi badan, kondisi kesehatan, pengalaman organisasi, dan kontak wali.
4. Apakah foto wajib atau opsional?
5. Format NIA untuk angkatan baru: otomatis berdasarkan `angkatan`, atau input manual Superadmin?
6. Apakah notifikasi memakai email, WhatsApp, atau cukup status di website?
7. Apakah calon yang ditolak boleh mendaftar ulang dengan nomor HP/email yang sama?
8. Berapa lama data calon ditahan sebelum dihapus/diarsipkan?

**Rekomendasi default:** pendaftaran terbuka, approve hanya Superadmin, foto opsional, NIA otomatis, notifikasi status tanpa password, kandidat ditolak boleh mendaftar ulang setelah status lama diarsipkan.

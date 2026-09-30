# Collabify (Campus Saver)

Portal kolaborasi tugas kuliah (CodeIgniter 4.7 · PHP 8.2+ · MySQL).

## Fitur
- **Groups** — buat kelompok, kode invite unik, join lewat kode.
- **Tasks** — tugas per kelompok: penanggung jawab, deadline, status.
- **Notes** — catatan pribadi (private).
- **Templates** — bank template dengan rating, bookmark, download; "Gunakan" menyalin ke Workspace.
- **Workspaces** — ruang kerja hasil salinan template.
- **Forum** — channel komunitas + channel privat per kelompok (chat & voice).
- **Spin** — bagi bagian tugas ke anggota lewat roda. Anggota & bagian dipilih server (bukan browser), tiap putaran tersimpan, sesi selesai → kode verifikasi + penanda *spin ulang* + bagian otomatis masuk ke Catatan tiap anggota + struk gambar untuk dibagikan.

## Menjalankan
```
composer install
copy env .env      # isi baseURL & database.default.*
php spark migrate
php spark db:seed DatabaseSeeder
php spark serve
```
Admin awal dari `UserSeeder` (`admin@campussaver.test`) — **ganti passwordnya** setelah login pertama.

## Catatan
- Auth: session custom, filter `auth` dan `role:admin`. Role: `admin`, `dosen`, `mahasiswa`.
- CSRF aktif global (`app/Config/Filters.php`).
- Sebelumnya project ini digabung dengan aplikasi perpustakaan LIBRIS; semua kode LIBRIS sudah dibuang.



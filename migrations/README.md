# Migration GroupProject (dari skema perpustakaan lama)

Sudah dites langsung terhadap `database.db` kamu (alur rebuild `users`, insert
group -> group_members -> tasks, semua berhasil tanpa error FK).

## Cara pakai

1. Copy semua file `.php` di folder ini (KECUALI README ini) ke:
   `app/Database/Migrations/`

2. Jalankan lewat terminal, dari root project:
   ```
   php spark migrate
   ```

3. Kalau belum yakin mau hapus tabel perpustakaan lama sekarang, cukup
   copy file #1 sampai #12 dulu, skip `2026-09-07-100013_DropLibraryTables.php`.
   Nanti tinggal dicopy & migrate lagi kapan pun udah siap.

## Urutan & isi tiap file

| # | File | Isi |
|---|---|---|
| 1 | ModifyUsersTable | Rebuild tabel `users`, hapus kolom `id_member`, samakan role lama `user` -> `mahasiswa` |
| 2 | CreateGroups | Tabel kelompok + kode invite |
| 3 | CreateGroupMembers | Anggota per kelompok + peran (ketua/anggota) |
| 4 | CreateTemplates | Katalog template tugas (upload, kategori, status approval) |
| 5 | CreateTemplateRatings | Rating & ulasan template |
| 6 | CreateTemplateBookmarks | Template yang di-bookmark user |
| 7 | CreateTasks | Task tracker per kelompok |
| 8 | CreateNotes | Papan catatan kolaboratif per kelompok |
| 9 | CreateSpinHistory | Riwayat hasil spin pembagi tugas/kelompok |
| 10 | CreateForumThreads | Thread forum diskusi |
| 11 | CreateForumReplies | Balasan tiap thread |
| 12 | CreateBadges | Badge/gamifikasi user |
| 13 | DropLibraryTables | Hapus semua tabel perpustakaan lama (books, members, peminjaman, pengajuan, pengembalian, wishlist, book_reviews) |

## Catatan penting

- File #1 pakai raw SQL (bukan `$this->forge->dropColumn()`) karena SQLite
  menolak drop kolom yang masih ada di definisi FOREIGN KEY tabel yang sama
  (`id_member` -> `members`). Solusinya rebuild tabel: bikin tabel baru tanpa
  kolom itu, pindahin data, drop yang lama, rename yang baru.
- Semua tabel baru pakai `ON DELETE CASCADE` ke parent-nya (grup/user),
  kecuali `tasks.assigned_to` yang pakai `SET NULL` (biar task nggak ikut
  kehapus kalau user-nya dihapus, cuma assignee-nya jadi kosong).
- Rollback (`php spark migrate:rollback`) untuk file #13 sengaja dikosongkan
  di method `down()` karena data lama sudah tidak ada; kalau butuh balikin,
  restore dari backup `.sql` yang sebelumnya sudah dibuat.

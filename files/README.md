# Migration — Perpustakaan → Portal Proyek Kelompok Mahasiswa

## Cara pakai
1. Copy semua file `.php` di folder ini ke `app/Database/Migrations/` di project CI4 kamu.
2. **Backup dulu** `database.db` (atau database production kamu) sebelum menjalankan migration ini — Fase 13 akan **menghapus** tabel-tabel perpustakaan lama (`books`, `members`, `peminjaman`, `pengajuan`, `pengembalian`, `wishlist`, `book_reviews`).
3. Jalankan:
   ```
   php spark migrate
   ```
   Semua migration akan jalan berurutan sesuai timestamp nama file (100001 → 100013).
4. Kalau mau rollback semua: `php spark migrate:rollback` (rollback per-batch, bisa dipanggil berkali-kali).

## Urutan & isi tiap file
| # | File | Isi |
|---|------|-----|
| 1 | `ModifyUsersTable` | Rebuild tabel `users`: hapus kolom `id_member`, default `role` jadi `mahasiswa` |
| 2 | `CreateGroups` | Tabel `groups` |
| 3 | `CreateGroupMembers` | Tabel `group_members` (relasi user ↔ grup) |
| 4 | `CreateTemplates` | Tabel `templates` |
| 5 | `CreateTemplateRatings` | Tabel `template_ratings` |
| 6 | `CreateTemplateBookmarks` | Tabel `template_bookmarks` |
| 7 | `CreateTasks` | Tabel `tasks` |
| 8 | `CreateNotes` | Tabel `notes` |
| 9 | `CreateSpinHistory` | Tabel `spin_history` |
| 10 | `CreateForumThreads` | Tabel `forum_threads` |
| 11 | `CreateForumReplies` | Tabel `forum_replies` |
| 12 | `CreateBadges` | Tabel `badges` |
| 13 | `DropLibraryTables` | Hapus tabel-tabel perpustakaan lama (jalankan **paling terakhir**, setelah kamu yakin semua modul baru sudah siap) |

## Catatan penting
- Migration #1 dan #13 memakai pendekatan **rebuild tabel** (raw SQL) khusus untuk SQLite, karena SQLite tidak bisa `DROP COLUMN` pada kolom yang terikat foreign key di tabel yang sama. Sudah saya uji langsung terhadap `database.db` kamu — data existing (2 baris user) tetap utuh setelah migration jalan.
- Kalau kamu belum yakin mau langsung hapus data perpustakaan lama, **jangan jalankan migration #13 dulu** — tetap bisa develop modul baru dengan tabel lama masih nangkring di database, baru dibersihkan belakangan pas semua sudah beres.
- Semua FK pakai `ON DELETE CASCADE` (kecuali `tasks.assigned_to` pakai `SET NULL`, supaya kalau user dihapus, task-nya tidak ikut hilang, cuma jadi unassigned).
- Field `role` di `users` sekarang bebas isi string (`mahasiswa`, `dosen`, `admin`, dst) — kalau mau lebih ketat, bisa ditambah validasi di level Model/Controller.

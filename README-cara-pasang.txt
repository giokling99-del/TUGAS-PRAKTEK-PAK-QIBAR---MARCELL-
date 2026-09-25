CARA PASANG FINDMYLEAGUE (PHP + MySQL)
======================================

FILE YANG ADA:
  findmyleague.html  -> website (frontend)
  api.php            -> backend (letakkan SEJAJAR dengan HTML)
  database.sql       -> skema database

LANGKAH:
1. Buat database:
   - Buka phpMyAdmin -> Import -> pilih database.sql
   (atau lewat terminal: mysql -u root -p < database.sql)

2. Edit koneksi di api.php (baris paling atas):
   $DB_HOST = 'localhost';
   $DB_NAME = 'findmyleague';
   $DB_USER = 'root';
   $DB_PASS = '';   <- isi password MySQL kamu

3. Upload semua file ke hosting PHP (XAMPP/Hostinger/dll)
   dalam SATU folder yang sama.

4. Buka findmyleague.html lewat server PHP, contoh:
   http://localhost/findmyleague/findmyleague.html

CATATAN:
- Jika api.php tidak ditemukan / database belum siap,
  website OTOMATIS jalan mode demo pakai localStorage.
- Password di PHP pakai password_hash() (standar industri),
  jadi hash-nya berbeda dengan versi demo — itu normal.

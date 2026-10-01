from pathlib import Path

readme = """# FindMyLeague

Website untuk mencari **tournament** dan **sparring** olahraga.

## Cara Menjalankan

1. Jalankan **Laragon** → Start **Apache** dan **MySQL**.
2. Masukkan project ke:
   `C:\\laragon\\www\\findmyleague`
3. Buat database `findmyleague` dan jalankan SQL yang disediakan.
4. Pastikan `api.php` ada di folder yang sama dengan homepage.
5. Buka:
   `http://localhost/findmyleague/`

## Cara Menggunakan

### Login / Register
- Klik **Login**.
- Pilih **Register** untuk membuat akun baru.
- Masukkan email dan password untuk login.

### Browse
- **All** → melihat semua posting.
- **Tournaments** → melihat tournament.
- **Sparring** → mencari sparring.

### Create Post
1. Login.
2. Klik **+ Create Post**.
3. Pilih **Tournament** atau **Sparring**.
4. Isi informasi event.
5. Klik **Publish**.

### Dashboard
Klik **Dashboard** untuk melihat:
- Informasi akun.
- Statistik posting.
- Create Post.
- Community.
- Profile.

### Community
Klik **Community** untuk melihat member lain dan membuka profile mereka.

### Dark / Light Mode
Klik tombol ☀️/🌙 untuk mengganti tema.

## Teknologi

**HTML • CSS • JavaScript • PHP • MySQL • Laragon**

**FindMyLeague © 2026**
"""

path = Path("/mnt/data/README_FindMyLeague_Singkat.md")
path.write_text(readme, encoding="utf-8")
print(path, path.exists(), path.stat().st_size)

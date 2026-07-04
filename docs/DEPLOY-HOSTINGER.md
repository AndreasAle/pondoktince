# Deploy ke Hostinger via Git Push (auto-deploy)

Target: **pondoktince.com** di Hostinger Business Web Hosting (shared, ada SSH).
Cara kerja: kamu `git push production main` dari lokal → server otomatis checkout kode,
`composer install`, `migrate`, dan rebuild cache lewat hook `post-receive`.

Detail SSH kamu (dari hPanel):
```
IP       : 145.79.14.195
Port     : 65002
Username : u598194357
```

> Catatan penting soal shared hosting:
> - **Tidak ada Node/npm** → asset (CSS/JS) di-build DI LOKAL, hasilnya (`public/build`) ikut di-commit.
> - **Database pakai MySQL** Hostinger (bukan SQLite). Buat DB di hPanel dulu.
> - **PHP harus 8.2+** (Laravel 12 + Filament). Set di hPanel → PHP Configuration bila perlu.

---

## BAGIAN 1 — LOKAL (sekali saja, sudah sebagian disiapkan)

Di folder project (`...\pondoktince`), pakai PowerShell:

```powershell
# 1. Build asset produksi (WAJIB sebelum commit yang menyentuh CSS/JS)
npm run build

# 2. Inisialisasi git + commit pertama  (kalau belum)
git init
git branch -M main
git add .
git commit -m "Initial commit: Pondok Tince + Pempek Tince website"
```

Remote `production` ditambahkan NANTI (setelah bare repo di server dibuat, Bagian 3).

---

## BAGIAN 2 — SERVER: siapkan bare repo + hook (sekali saja)

Masuk SSH:
```bash
ssh -p 65002 u598194357@145.79.14.195
```

Cek PHP (harus 8.2+):
```bash
php -v
# kalau bukan 8.2+, cek: ls /usr/bin/php* ; lalu set PHP_BIN di hook, atau ubah versi di hPanel
```

Buat bare repo + folder app:
```bash
mkdir -p ~/repos/pondoktince.git ~/pondoktince
cd ~/repos/pondoktince.git
git init --bare
```

Buat hook `post-receive`. Isi file dengan konten dari `deploy/post-receive` di repo ini.
Cara cepat pakai nano:
```bash
nano ~/repos/pondoktince.git/hooks/post-receive
# tempel isi file deploy/post-receive, simpan (Ctrl+O, Enter, Ctrl+X)
chmod +x ~/repos/pondoktince.git/hooks/post-receive
```

---

## BAGIAN 3 — Push pertama + konfigurasi .env

### 3a. Tambah remote & push (dari LOKAL)
```powershell
git remote add production ssh://u598194357@145.79.14.195:65002/home/u598194357/repos/pondoktince.git
git push production main
```
Push pertama: kode masuk ke `~/pondoktince`, `composer install` jalan. Migrate di-SKIP
otomatis karena `.env` belum ada (hook aman, tidak error).

### 3b. Buat database MySQL (hPanel)
hPanel → **Databases → MySQL Databases** → buat database + user (catat nama, user, password).
Biasanya diawali prefix, mis. `u598194357_pondoktince` / `u598194357_admin`.

### 3c. Buat .env di server
```bash
ssh -p 65002 u598194357@145.79.14.195
cd ~/pondoktince
cp .env.production.example .env
nano .env      # isi APP_URL, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### 3d. Bootstrap Laravel (sekali)
```bash
cd ~/pondoktince
php artisan key:generate
php artisan migrate --seed --force     # buat tabel + isi konten awal + admin
php artisan storage:link
php artisan optimize:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## BAGIAN 4 — Arahkan domain ke folder `public` Laravel

Web root Hostinger = `public_html`. Laravel harus dilayani dari `~/pondoktince/public`.
Cari dulu lokasi web root kamu:
```bash
ls -la ~            # lihat apakah ada public_html di sini
ls -la ~/domains 2>/dev/null   # atau di ~/domains/pondoktince.com/public_html
```

**Cara paling andal — symlink** (ganti path public_html sesuai hasil di atas):
```bash
# backup dulu isi lama (jangan langsung hapus)
mv ~/public_html ~/public_html_backup_$(date +%s)
ln -s ~/pondoktince/public ~/public_html
```

Kalau `public_html` ada di `~/domains/pondoktince.com/public_html`, sesuaikan:
```bash
mv ~/domains/pondoktince.com/public_html ~/domains/pondoktince.com/public_html_backup_$(date +%s)
ln -s ~/pondoktince/public ~/domains/pondoktince.com/public_html
```

> Alternatif (kalau symlink tidak dihormati): di hPanel ada opsi ubah **Document Root**
> domain ke `pondoktince/public`. Gunakan itu bila tersedia.

Buka https://pondoktince.com → harusnya tampil. Admin: https://pondoktince.com/admin
(login `admin@pondoktince.com` / `password` → **segera ganti password**).

---

## BAGIAN 5 — Alur harian (setelah semua siap)

Tiap ada perubahan di lokal:
```powershell
npm run build                 # HANYA jika mengubah CSS/JS
git add .
git commit -m "pesan perubahan"
git push production main       # <-- otomatis deploy ke server
```
Hook di server otomatis: checkout → composer install → migrate → cache. Selesai.

---

## Troubleshooting

| Masalah | Solusi |
|---|---|
| `500` / layar putih | `cd ~/pondoktince && php artisan optimize:clear`, cek `storage/logs/laravel.log`, pastikan `APP_DEBUG=false` & `.env` benar |
| CSS/JS tidak muncul | Pastikan `npm run build` sudah dijalankan di lokal & `public/build` ter-commit. Cek symlink `public/storage` ada |
| `route:cache` error | Sudah diamankan (tidak ada closure di routes). Kalau tetap error: `php artisan route:clear` |
| Migrate gagal | Cek kredensial DB di `.env`, pastikan DB sudah dibuat di hPanel |
| PHP version error | hPanel → PHP Configuration → set 8.2+/8.3, dan set `PHP_BIN` di hook bila CLI beda |
| Gambar upload tidak tampil | `php artisan storage:link` di server |
| Permission denied storage | `chmod -R 775 storage bootstrap/cache` |

## Keamanan produksi
- Ganti password admin (`/admin`) & password SSH.
- `APP_DEBUG=false`, `APP_ENV=production`.
- `.env` TIDAK pernah masuk git (sudah di `.gitignore`).
- Isi data asli `[GANTI]` lewat `/admin` (lihat `docs/README-PROJECT.md` bagian 14).

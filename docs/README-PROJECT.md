# Pondok Tince & Pempek Tince — Website + CMS

Website bisnis kuliner untuk ekosistem brand **Pondok Tince** (rumah makan khas Palembang)
dan sub-brand **Pempek Tince** (pempek, oleh-oleh, frozen, pesan online).

Stack: **Laravel 12 + Filament 3 + Blade + Tailwind CSS v4 + Alpine.js + Vite**.
Database default dev: **SQLite** (siap dipindah ke MySQL/MariaDB untuk produksi).

---

## 1. Ringkasan Arsitektur

- **Frontend publik**: Blade server-rendered, mobile-first, Tailwind v4, Alpine.js untuk interaksi ringan
  (mobile menu, accordion FAQ, filter menu). Aset di-build dengan Vite.
- **CMS/Admin**: Filament panel di `/admin`. Semua konten penting editable tanpa sentuh kode.
- **SEO engine**: `SeoManager` (meta/OG/Twitter/canonical/robots) + `SchemaService` (JSON-LD)
  di-render dari `<head>` layout. Sitemap XML & robots.txt dinamis. Redirect manager via middleware.
- **WhatsApp CTA system**: `WhatsAppService` mem-build wa.me link per-brand; setiap klik dilacak
  ke `whatsapp_click_logs` lewat beacon `POST /track/whatsapp-click`.
- **Lead capture**: form Booking & Kontak menyimpan ke DB, booking otomatis redirect ke WhatsApp
  dengan pesan terisi.

Brand architecture: satu domain, sub-brand Pempek Tince sebagai subfolder `/pempek-tince`
(otoritas SEO terkumpul dalam satu domain).

---

## 2. Struktur Folder (bagian penting)

```
app/
  Filament/
    Pages/ManageSiteSettings.php          # halaman pengaturan (singleton)
    Resources/*                           # 17 resource CRUD
    Resources/PageResource/RelationManagers/SectionsRelationManager.php  # page builder
    Widgets/StatsOverviewWidget.php, LatestBookingsWidget.php
  Http/
    Controllers/                          # Home, Menu, Booking, Contact, Page, PempekTince, Article, Seo, Tracking
    Middleware/HandleRedirects.php
    Requests/StoreBookingRequest.php, StoreContactRequest.php
  Models/                                 # 19 model Eloquent
  Providers/AppServiceProvider.php        # bind SeoManager + view composer nav/settings
  Providers/Filament/AdminPanelProvider.php
  Services/WhatsAppService.php, SeoManager.php, SchemaService.php
  Support/helpers.php                     # settings(), seo(), wa_url(), media_url(), rupiah()
database/
  migrations/2026_07_04_1000xx_*          # 19 migrasi
  seeders/DatabaseSeeder.php, ContentSeeder.php
resources/
  css/app.css                             # tema (maroon/gold/cream) + komponen
  js/app.js                               # Alpine + trackWhatsApp()
  views/
    layouts/public.blade.php
    partials/header, footer, flash, page-section
    components/                           # wa-button, page-hero, section-heading, menu-card, package-card, faq-list, breadcrumbs
    pages/                                # home, menu, booking, lokasi, paket-acara, galeri, kontak, pillar, pempek-tince, pempek-sub, articles-index, article-show, cms
    seo/sitemap.blade.php
routes/web.php
```

---

## 3. Database — Migrasi & Schema

19 tabel: `site_settings`, `brands`, `navigation_menus`, `redirects`, `article_categories`,
`whatsapp_contacts`, `whatsapp_click_logs`, `booking_leads`, `contact_leads`, `articles`,
`pages`, `page_sections`, `menu_categories`, `menu_items`, `product_packages`, `galleries`,
`testimonials`, `faqs`, `promos`.

Fitur: soft deletes untuk data penting (brands, pages, menu_items, product_packages, articles,
booking/contact leads), index pada slug/status/brand_id/published_at, unique slug per-brand,
kolom JSON untuk konten fleksibel (opening_hours, contents, gallery, settings, custom_schema),
`sort_order` untuk semua konten berurutan.

---

## 4. Model & Relasi Eloquent

- `Brand` hasMany MenuCategory, MenuItem, ProductPackage, Gallery, Testimonial.
- `Page` hasMany PageSection, FAQ.
- `MenuCategory` hasMany MenuItem; `MenuItem` belongsTo Brand, MenuCategory.
- `Article` belongsTo ArticleCategory.
- `Faq` belongsTo Brand, Page. `Gallery`/`Testimonial`/`Promo`/`ProductPackage` belongsTo Brand.
- `NavigationMenu` self-referencing (parent/children).
- `SiteSetting` singleton dengan cache (`SiteSetting::current()`), auto-flush saat disimpan.
- Scopes umum: `active()`, `ordered()`, `published()`, `forBrandKey()`.

---

## 5. Route List (publik)

`GET /` · `GET /menu` · `GET|POST /booking` · `GET /lokasi` · `GET /paket-acara` ·
`GET /galeri` · `GET|POST /kontak` · `GET /artikel` · `GET /artikel/{slug}` ·
`GET /kuliner-palembang` · `GET /pempek-palembang` · `GET /makanan-enak-palembang` ·
`GET /pempek-tince` (+ `/menu`, `/paket-pempek`, `/oleh-oleh-palembang`, `/pempek-frozen`, `/pesan-online`, `/lokasi`) ·
`GET /sitemap.xml` · `GET /robots.txt` · `POST /track/whatsapp-click` ·
`GET /{slug}` (catch-all → CMS page, mendukung supporting SEO pages).

Admin: `/admin` (Filament).

---

## 6. Controller

`HomeController`, `MenuController`, `BookingController`, `ContactController`, `PageController`
(lokasi, paket-acara, galeri, pillar, catch-all CMS), `PempekTinceController`, `ArticleController`,
`SeoController` (sitemap/robots), `TrackingController`.

---

## 7. Filament Resources

Brands, Menu Categories, Menu Items, Product Packages, Pages (+ Sections page-builder),
Galleries, Testimonials, FAQs, Promos, Articles, Article Categories, Booking Leads, Contact Leads,
WhatsApp Contacts, WhatsApp Click Logs (read-only), Navigation Menus, Redirects.
Plus halaman **Site Settings** dan 2 widget dashboard (Stats Overview + Latest Bookings).
Navigasi dikelompokkan: Pengaturan, Konten Website, Menu & Produk, Media & Sosial Proof,
Leads & WhatsApp, Blog/Artikel, SEO & Teknis.

---

## 8. Blade Components/Layout

Layout: `layouts.public`. Komponen: `<x-wa-button>` (CTA WhatsApp ter-track), `<x-page-hero>`,
`<x-section-heading>`, `<x-menu-card>`, `<x-package-card>`, `<x-faq-list>` (accordion + FAQ schema),
`<x-breadcrumbs>`. Page builder: `partials/page-section.blade.php` merender 15 tipe section.

---

## 9. SEO

- Meta title/description dinamis (auto-generate dari judul + brand / excerpt bila kosong).
- Canonical, Open Graph, Twitter Card, robots (noindex untuk draft/nonaktif).
- JSON-LD: WebSite, Organization, Restaurant/LocalBusiness, BreadcrumbList, FAQPage, Product/MenuItem, Article.
- `GET /sitemap.xml` (cache 1 jam, mencakup static routes + CMS pages `in_sitemap` + artikel published).
- `GET /robots.txt` (disallow `/admin`, menunjuk sitemap).
- Redirect manager (`redirects` table) via middleware `HandleRedirects` (cached).
- Field SEO lengkap per Page & Article (focus keyword, canonical, OG, schema type, custom schema JSON, sitemap priority/freq).

---

## 10. WhatsApp Tracking

`<x-wa-button>` merender anchor ke wa.me + `@click="window.trackWhatsApp({...})"`.
`trackWhatsApp()` mengirim `navigator.sendBeacon` ke `POST /track/whatsapp-click`
(dikecualikan dari CSRF, throttle 60/menit). `TrackingController` menyimpan log dengan
visitor id ter-anonimisasi (`sha256(ip|ua|app_key)`). Nomor tujuan & pesan berbeda per brand/halaman
via `WhatsAppService`.

---

## 11. Seeder Konten Awal

`DatabaseSeeder` membuat **Super Admin** lalu memanggil `ContentSeeder`:
site settings, 2 brand, ~28 page (fungsional + pillar + pempek + supporting SEO),
kategori & item menu (Pondok + Pempek), 3 paket pempek, FAQ, testimoni, navigasi (header/footer/mobile),
6 artikel SEO. Idempotent (`updateOrCreate`) — aman dijalankan ulang. Tanpa Lorem Ipsum.

---

## 12. Instalasi & Menjalankan

Prasyarat: PHP 8.2+, Composer, Node 18+, (MySQL/MariaDB untuk produksi).

```bash
composer install
cp .env.example .env          # sudah otomatis saat create-project
php artisan key:generate
php artisan migrate --seed    # buat schema + isi konten awal
php artisan storage:link      # agar gambar upload tampil publik
npm install
npm run build                 # atau: npm run dev (mode dev)
php artisan serve
```

Login admin: `http://localhost:8000/admin`
Kredensial default (GANTI setelah login pertama):
- Email: `admin@pondoktince.com`
- Password: `password`

### Pindah ke MySQL (produksi)
Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pondoktince
DB_USERNAME=root
DB_PASSWORD=
```
Lalu `php artisan migrate:fresh --seed`. Atur `APP_URL` ke domain final (mempengaruhi canonical, sitemap, OG).

---

## 13. Checklist Testing

- [x] Website jalan tanpa error (semua route publik 200; 404 untuk slug tak dikenal).
- [x] Admin Filament bisa login (Super Admin).
- [x] Semua halaman utama editable dari CMS (Pages + Sections builder).
- [x] Menu Pondok Tince & Pempek Tince dikelola dari CMS.
- [x] Paket Pempek dikelola dari CMS.
- [x] Booking form menyimpan ke DB + redirect WhatsApp dengan pesan otomatis (diuji: lead tersimpan, 302 → wa.me).
- [x] Klik WhatsApp terlacak (diuji: log tersimpan via beacon).
- [x] `/kuliner-palembang`, `/pempek-palembang`, `/makanan-enak-palembang` aktif & SEO-ready.
- [x] `/pempek-tince` aktif sebagai sub-brand + sub-halaman.
- [x] Meta title/description dinamis; JSON-LD ada (WebSite/Organization/Restaurant/…).
- [x] `sitemap.xml` & `robots.txt` tersedia (dinamis).
- [x] Responsive mobile (mobile nav, floating WA button).
- [x] Tanpa Lorem Ipsum; placeholder visual rapi (fallback nama brand/menu).

Cara uji cepat:
```bash
php artisan serve
curl -I http://127.0.0.1:8000/            # 200
curl http://127.0.0.1:8000/sitemap.xml    # XML
curl http://127.0.0.1:8000/robots.txt     # rules + sitemap
```

---

## 14. Data yang HARUS Diganti dengan Data Asli Client `[GANTI]`

Cari penanda `[GANTI]` di `database/seeders/ContentSeeder.php`, atau edit langsung via admin:

1. **Site Settings** (`/admin` → Site Settings):
   - Nomor WhatsApp Pondok Tince & Pempek Tince (saat ini `6281234567890`).
   - Alamat lengkap, email, jam buka.
   - Google Maps embed (src iframe) & link Maps.
   - Logo, favicon, default OG image.
   - Google Search Console verification.
2. **Brands** → nomor WhatsApp masing-masing brand.
3. **Menu Items & Product Packages** → harga (saat ini `null` = "Menyesuaikan"), foto, deskripsi final.
4. **Galeri** → upload foto asli (makanan, tempat, acara, pempek).
5. **Testimoni** → ganti dengan testimoni asli terverifikasi.
6. **FAQ Lokasi** → detail alamat/patokan/parkir.
7. **Kredensial Super Admin** → ganti email & password.
8. **Klaim "sejak 1998"** untuk Pempek Tince → tambahkan HANYA bila terverifikasi dari data client/IG.
9. **APP_URL** di `.env` → domain final (mempengaruhi canonical/sitemap/OG).

> Semua konten teks awal sudah natural (bahasa Indonesia), tinggal disesuaikan. Foto memakai
> fallback rapi bila belum diupload sehingga layout tetap premium.

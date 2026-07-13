<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Brand;
use App\Models\Faq;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\NavigationMenu;
use App\Models\Page;
use App\Models\ProductPackage;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds natural, editable starter content (no Lorem Ipsum).
 * Everything here can be edited from the Filament admin panel.
 *
 * NOTE for client hand-off: values tagged with [GANTI] are placeholders and
 * should be replaced with real business data (address, WhatsApp number, prices,
 * photos, etc.). See docs/README-PROJECT.md.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        [$pondok, $pempek] = $this->seedBrands();
        $this->seedPages();
        $this->seedMenus($pondok, $pempek);
        $this->seedPackages($pempek);
        $this->seedFaqs($pondok, $pempek);
        $this->seedTestimonials($pondok, $pempek);
        $this->seedNavigation();
        $this->seedArticles();
    }

    protected function seedSettings(): void
    {
        SiteSetting::updateOrCreate(['id' => 1], [
            'site_name' => 'Pondok Tince',
            'tagline' => 'Kuliner khas Palembang untuk keluarga, acara, dan oleh-oleh.',
            'primary_color' => '#b8161b',
            'accent_color' => '#c79a3a',
            'address' => 'Palembang, Sumatera Selatan. [GANTI dengan alamat lengkap]',
            'email' => 'halo@pondoktince.com', // [GANTI]
            'whatsapp_number' => '6281234567890', // [GANTI]
            'whatsapp_number_pempek' => '6281234567890', // [GANTI]
            'opening_hours' => [
                ['day' => 'Senin - Jumat', 'hours' => '10.00 - 22.00'],
                ['day' => 'Sabtu - Minggu', 'hours' => '09.00 - 22.00'],
            ],
            'instagram_pondok' => 'https://www.instagram.com/pondoktince.plg/',
            'instagram_pempek' => 'https://www.instagram.com/pempektince/',
            'default_seo_title' => 'Pondok Tince | Kuliner Khas Palembang',
            'default_seo_description' => 'Pondok Tince, tempat makan khas Palembang untuk keluarga, tamu luar kota, dan acara. Terhubung dengan Pempek Tince untuk oleh-oleh dan pesanan pempek.',
        ]);
        SiteSetting::flushCache();
    }

    /** @return array{0:Brand,1:Brand} */
    protected function seedBrands(): array
    {
        $pondok = Brand::updateOrCreate(['key' => Brand::KEY_PONDOK], [
            'name' => 'Pondok Tince',
            'slug' => 'pondok-tince',
            'description' => 'Tempat makan khas Palembang untuk dine-in bersama keluarga, rombongan, dan acara. Cita rasa autentik dengan suasana yang nyaman.',
            'brand_color' => '#b8161b',
            'instagram' => 'https://www.instagram.com/pondoktince.plg/',
            'whatsapp_number' => '6281234567890', // [GANTI]
            'whatsapp_default_message' => 'Halo Pondok Tince, saya ingin bertanya.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $pempek = Brand::updateOrCreate(['key' => Brand::KEY_PEMPEK], [
            'name' => 'Pempek Tince',
            'slug' => 'pempek-tince',
            'description' => 'Pempek khas Palembang untuk oleh-oleh, frozen, dan pemesanan online. Praktis dikirim ke luar kota untuk keluarga di rumah.',
            'brand_color' => '#a83d33',
            'instagram' => 'https://www.instagram.com/pempektince/',
            'whatsapp_number' => '6281234567890', // [GANTI]
            'whatsapp_default_message' => 'Halo Pempek Tince, saya ingin pesan pempek.',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        return [$pondok, $pempek];
    }

    protected function seedPages(): void
    {
        $pages = [
            // Functional pages (rendered by dedicated templates; CMS supplies hero/SEO).
            ['home', 'Beranda', 'global', 'landing', 0.9],
            ['menu', 'Menu Pondok Tince', 'pondok-tince', 'normal', 0.9],
            ['booking', 'Booking Tempat & Acara', 'pondok-tince', 'normal', 0.7],
            ['lokasi', 'Lokasi & Jam Buka', 'pondok-tince', 'normal', 0.7, 'Restaurant'],
            ['paket-acara', 'Paket Acara', 'pondok-tince', 'landing', 0.7],
            ['galeri', 'Galeri', 'global', 'normal', 0.5],
            ['kontak', 'Kontak', 'global', 'normal', 0.4],

            // SEO pillars
            ['kuliner-palembang', 'Kuliner Palembang', 'pondok-tince', 'seo_pillar', 0.9, 'Restaurant'],
            ['pempek-palembang', 'Pempek Palembang', 'pempek-tince', 'seo_pillar', 0.9],
            ['makanan-enak-palembang', 'Makanan Enak Palembang', 'pondok-tince', 'seo_pillar', 0.9],

            // Pempek Tince sub-brand
            ['pempek-tince', 'Pempek Tince', 'pempek-tince', 'landing', 0.9],
            ['pempek-tince/menu', 'Menu Pempek Tince', 'pempek-tince', 'normal', 0.7],
            ['pempek-tince/paket-pempek', 'Paket Pempek', 'pempek-tince', 'normal', 0.7],
            ['pempek-tince/oleh-oleh-palembang', 'Oleh-Oleh Palembang', 'pempek-tince', 'normal', 0.6],
            ['pempek-tince/pempek-frozen', 'Pempek Frozen', 'pempek-tince', 'normal', 0.6],
            ['pempek-tince/pesan-online', 'Pesan Pempek Online', 'pempek-tince', 'normal', 0.6],
            ['pempek-tince/lokasi', 'Lokasi Pempek Tince', 'pempek-tince', 'normal', 0.5],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p[0]], [
                'title' => $p[1],
                'brand_scope' => $p[2],
                'page_type' => $p[3],
                'sitemap_priority' => $p[4],
                'schema_type' => $p[5] ?? 'WebPage',
                'is_published' => true,
                'published_at' => now(),
                'in_sitemap' => true,
            ]);
        }

        // Supporting SEO pages (rendered via the CMS catch-all with intro content).
        $supporting = [
            ['kuliner-khas-palembang', 'Kuliner Khas Palembang', 'Jelajahi kuliner khas Palembang di Pondok Tince — sajian autentik untuk keluarga dan tamu luar kota.'],
            ['tempat-makan-khas-palembang', 'Tempat Makan Khas Palembang', 'Pondok Tince adalah tempat makan khas Palembang yang nyaman untuk berbagai suasana.'],
            ['tempat-makan-keluarga-palembang', 'Tempat Makan Keluarga di Palembang', 'Tempat makan keluarga di Palembang dengan menu khas dan suasana hangat.'],
            ['tempat-makan-rombongan-palembang', 'Tempat Makan Rombongan di Palembang', 'Menyambut rombongan keluarga maupun kantor di Palembang.'],
            ['restoran-khas-palembang', 'Restoran Khas Palembang', 'Restoran khas Palembang dengan cita rasa autentik di Pondok Tince.'],
            ['pesan-pempek-palembang', 'Pesan Pempek Palembang', 'Pesan pempek Palembang dari Pempek Tince untuk oleh-oleh dan frozen.'],
            ['pempek-oleh-oleh-palembang', 'Pempek Oleh-Oleh Palembang', 'Pempek oleh-oleh khas Palembang yang praktis dibawa pulang.'],
            ['pempek-palembang-enak', 'Pempek Palembang Enak', 'Pempek Palembang enak dari Pempek Tince, cocok untuk keluarga.'],
            ['pindang-palembang', 'Pindang Palembang', 'Info seputar pindang Palembang dan sajian khas di Pondok Tince.'],
            ['brengkes-tempoyak-palembang', 'Brengkes Tempoyak Palembang', 'Brengkes tempoyak, salah satu sajian khas Palembang.'],
            ['makanan-khas-palembang', 'Makanan Khas Palembang', 'Ragam makanan khas Palembang yang bisa dinikmati di Pondok Tince.'],
        ];

        foreach ($supporting as $sp) {
            Page::updateOrCreate(['slug' => $sp[0]], [
                'title' => $sp[1],
                'brand_scope' => Str::contains($sp[0], 'pempek') ? 'pempek-tince' : 'pondok-tince',
                'page_type' => 'seo_pillar',
                'hero_subtitle' => $sp[2],
                'intro_content' => '<h2>'.$sp[1].'</h2><p>'.$sp[2].' Hubungi kami via WhatsApp untuk informasi menu, harga, dan pemesanan terbaru.</p>',
                'meta_description' => $sp[2],
                'schema_type' => 'WebPage',
                'is_published' => true,
                'published_at' => now(),
                'in_sitemap' => true,
                'sitemap_priority' => 0.5,
            ]);
        }
    }

    protected function seedMenus(Brand $pondok, Brand $pempek): void
    {
        // Pondok Tince categories + items
        $pondokCats = [
            'nasi-lauk' => 'Nasi & Lauk',
            'berkuah' => 'Menu Berkuah',
            'paket-keluarga' => 'Paket Keluarga',
        ];
        $catModels = [];
        $i = 1;
        foreach ($pondokCats as $slug => $name) {
            $catModels[$slug] = MenuCategory::updateOrCreate(
                ['brand_id' => $pondok->id, 'slug' => $slug],
                ['name' => $name, 'is_active' => true, 'sort_order' => $i++]
            );
        }

        $pondokItems = [
            ['nasi-lauk', 'Nasi Gemuk Spesial', 'Nasi gurih khas dengan lauk pilihan.', null, true, true],
            ['nasi-lauk', 'Ayam Goreng Sambal', 'Ayam goreng renyah dengan sambal khas.', null, true, false],
            ['berkuah', 'Pindang Patin', 'Pindang patin khas Palembang, segar dan berbumbu.', null, true, false],
            ['berkuah', 'Model Ikan', 'Model kuah kaldu dengan pempek isi tahu.', null, false, false],
            ['berkuah', 'Tekwan', 'Sup bola ikan khas Palembang dengan bihun.', null, true, false],
            ['paket-keluarga', 'Paket Keluarga Hemat', 'Paket untuk 4-5 orang, cocok makan bersama.', null, false, true],
        ];
        $s = 1;
        foreach ($pondokItems as $it) {
            MenuItem::updateOrCreate(
                ['brand_id' => $pondok->id, 'slug' => Str::slug($it[1])],
                [
                    'menu_category_id' => $catModels[$it[0]]->id,
                    'name' => $it[1],
                    'short_description' => $it[2],
                    'price' => $it[3], // null => "menyesuaikan" [GANTI harga]
                    'is_favorite' => $it[4],
                    'is_best_seller' => $it[5],
                    'is_available' => true,
                    'sort_order' => $s++,
                    'wa_message_template' => 'Halo Pondok Tince, saya ingin pesan {name}. Apakah tersedia?',
                ]
            );
        }

        // Pempek Tince categories + items
        $pempekCat = MenuCategory::updateOrCreate(
            ['brand_id' => $pempek->id, 'slug' => 'pempek'],
            ['name' => 'Varian Pempek', 'is_active' => true, 'sort_order' => 1]
        );

        $pempekItems = [
            ['Pempek Kapal Selam', 'Pempek isi telur ayam, favorit sepanjang masa.', true, true],
            ['Pempek Lenjer', 'Pempek panjang klasik khas Palembang.', true, false],
            ['Pempek Adaan', 'Pempek bulat goreng yang gurih.', false, false],
            ['Pempek Kulit', 'Pempek kulit ikan dengan rasa khas.', false, false],
            ['Pempek Telur Kecil', 'Pempek telur ukuran kecil, pas untuk cemilan.', false, false],
        ];
        $s = 1;
        foreach ($pempekItems as $it) {
            MenuItem::updateOrCreate(
                ['brand_id' => $pempek->id, 'slug' => Str::slug($it[0])],
                [
                    'menu_category_id' => $pempekCat->id,
                    'name' => $it[0],
                    'short_description' => $it[1],
                    'price' => null, // [GANTI harga]
                    'is_favorite' => $it[2],
                    'is_best_seller' => $it[3],
                    'is_available' => true,
                    'sort_order' => $s++,
                    'wa_message_template' => 'Halo Pempek Tince, saya ingin pesan {name}. Mohon info harga & stok.',
                ]
            );
        }
    }

    protected function seedPackages(Brand $pempek): void
    {
        $packages = [
            ['Paket Keluarga', 'Paket pempek untuk dinikmati bersama keluarga di rumah.', ['Aneka pempek pilihan', 'Cuko khas Palembang', 'Cukup untuk 4-5 orang'], false, true],
            ['Paket Oleh-Oleh', 'Paket praktis untuk dibawa pulang sebagai oleh-oleh.', ['Kemasan rapi', 'Cuko terpisah', 'Cocok untuk hadiah'], false, false],
            ['Paket Frozen', 'Pempek frozen untuk stok di rumah dan pengiriman luar kota.', ['Tahan lebih lama', 'Bisa dikirim luar kota', 'Praktis digoreng sendiri'], true, true],
        ];
        $s = 1;
        foreach ($packages as $p) {
            ProductPackage::updateOrCreate(
                ['brand_id' => $pempek->id, 'slug' => Str::slug($p[0])],
                [
                    'name' => $p[0],
                    'description' => $p[1],
                    'contents' => array_map(fn ($c) => ['item' => $c], $p[2]),
                    'price' => null, // [GANTI harga]
                    'is_frozen' => $p[3],
                    'is_recommended' => $p[4],
                    'is_active' => true,
                    'sort_order' => $s++,
                    'wa_message_template' => 'Halo Pempek Tince, saya ingin pesan {name}. Mohon info harga & pengiriman.',
                ]
            );
        }
    }

    protected function seedFaqs(Brand $pondok, Brand $pempek): void
    {
        $faqs = [
            ['lokasi', 'Di mana lokasi Pondok Tince?', 'Pondok Tince berlokasi di Palembang. Silakan lihat halaman Lokasi untuk peta dan patokan lengkap. [GANTI detail lokasi]', $pondok->id],
            ['lokasi', 'Apakah tersedia parkir?', 'Informasi parkir dapat ditanyakan langsung ke admin kami via WhatsApp.', $pondok->id],
            ['acara', 'Apakah bisa untuk acara rombongan?', 'Bisa. Pondok Tince cocok untuk arisan, meeting, dan acara keluarga. Silakan konsultasi via WhatsApp.', $pondok->id],
            ['acara', 'Bagaimana cara memesan paket acara?', 'Hubungi kami via WhatsApp, sampaikan tanggal, jumlah tamu, dan kebutuhan Anda. Tim kami akan membantu.', $pondok->id],
            ['pempek', 'Apakah bisa kirim luar kota?', 'Bisa, terutama untuk pempek frozen. Silakan konfirmasi pengiriman via WhatsApp.', $pempek->id],
            ['pempek', 'Apakah tersedia pempek frozen?', 'Tersedia. Pempek frozen praktis untuk stok di rumah dan pengiriman luar kota.', $pempek->id],
            ['pempek', 'Berapa lama pempek bisa bertahan?', 'Pempek frozen dapat bertahan lebih lama bila disimpan di freezer. Detail bisa ditanyakan ke admin.', $pempek->id],
            ['pempek', 'Bisakah pesan dalam jumlah banyak?', 'Bisa. Untuk pesanan banyak atau paket, silakan hubungi kami lebih awal via WhatsApp.', $pempek->id],
            ['kontak', 'Bagaimana cara memesan?', 'Anda bisa memesan langsung via WhatsApp, atau isi form booking untuk reservasi tempat/acara.', null],
        ];
        $s = 1;
        foreach ($faqs as $f) {
            Faq::updateOrCreate(
                ['group' => $f[0], 'question' => $f[1]],
                ['answer' => $f[2], 'brand_id' => $f[3], 'is_active' => true, 'sort_order' => $s++]
            );
        }
    }

    protected function seedTestimonials(Brand $pondok, Brand $pempek): void
    {
        $items = [
            ['Keluarga Andi', 'Google', 5, 'Tempatnya nyaman untuk makan keluarga, rasanya khas Palembang banget.', $pondok->id],
            ['Rina P.', 'Instagram', 5, 'Pempeknya enak, cukonya mantap. Cocok buat oleh-oleh.', $pempek->id],
            ['Budi S.', 'Google', 4, 'Pas untuk acara kantor, pelayanannya ramah.', $pondok->id],
        ];
        $s = 1;
        foreach ($items as $t) {
            Testimonial::updateOrCreate(
                ['name' => $t[0], 'message' => $t[3]],
                ['source' => $t[1], 'rating' => $t[2], 'brand_id' => $t[4], 'is_active' => true, 'sort_order' => $s++]
            );
        }
    }

    protected function seedNavigation(): void
    {
        $header = [
            ['Menu', '/menu'],
            ['Pempek Tince', '/pempek-tince'],
            ['Paket Acara', '/paket-acara'],
            ['Lokasi', '/lokasi'],
            ['Artikel', '/artikel'],
            ['Kontak', '/kontak'],
        ];
        $s = 1;
        foreach ($header as $h) {
            NavigationMenu::updateOrCreate(
                ['location' => 'header', 'label' => $h[0]],
                ['url' => $h[1], 'is_active' => true, 'sort_order' => $s++]
            );
        }

        $mobile = array_merge($header, [['Booking', '/booking'], ['Galeri', '/galeri']]);
        $s = 1;
        foreach ($mobile as $m) {
            NavigationMenu::updateOrCreate(
                ['location' => 'mobile', 'label' => $m[0]],
                ['url' => $m[1], 'is_active' => true, 'sort_order' => $s++]
            );
        }

        $footer = [
            ['Menu Pondok Tince', '/menu'],
            ['Pempek Tince', '/pempek-tince'],
            ['Kuliner Palembang', '/kuliner-palembang'],
            ['Pempek Palembang', '/pempek-palembang'],
            ['Makanan Enak Palembang', '/makanan-enak-palembang'],
        ];
        $s = 1;
        foreach ($footer as $f) {
            NavigationMenu::updateOrCreate(
                ['location' => 'footer', 'label' => $f[0]],
                ['url' => $f[1], 'is_active' => true, 'sort_order' => $s++]
            );
        }
    }

    protected function seedArticles(): void
    {
        $cat = ArticleCategory::updateOrCreate(['slug' => 'kuliner-palembang'], [
            'name' => 'Kuliner Palembang', 'is_active' => true, 'sort_order' => 1,
        ]);
        $catPempek = ArticleCategory::updateOrCreate(['slug' => 'pempek'], [
            'name' => 'Pempek', 'is_active' => true, 'sort_order' => 2,
        ]);

        $articles = [
            ['Rekomendasi Kuliner Palembang untuk Keluarga di Pondok Tince', $cat->id, 'kuliner Palembang', 'Rekomendasi kuliner Palembang yang cocok untuk makan keluarga di Pondok Tince.'],
            ['Pempek Palembang: Menu Khas yang Wajib Dicoba dari Pempek Tince', $catPempek->id, 'pempek Palembang', 'Mengenal varian pempek Palembang dari Pempek Tince yang wajib dicoba.'],
            ['Cari Makanan Enak di Palembang? Ini Menu yang Bisa Dicoba', $cat->id, 'makanan enak Palembang', 'Panduan singkat mencari makanan enak di Palembang bersama Pondok Tince.'],
            ['Tempat Makan Khas Palembang untuk Tamu Luar Kota', $cat->id, 'tempat makan khas Palembang', 'Rekomendasi tempat makan khas Palembang untuk menjamu tamu luar kota.'],
            ['Oleh-Oleh Pempek Palembang dari Pempek Tince', $catPempek->id, 'pempek oleh-oleh Palembang', 'Pilihan oleh-oleh pempek Palembang yang praktis dari Pempek Tince.'],
            ['Pempek Frozen Palembang untuk Stok di Rumah', $catPempek->id, 'pempek frozen Palembang', 'Kenapa pempek frozen cocok untuk stok di rumah dan pengiriman luar kota.'],
        ];
        $i = 0;
        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => Str::slug($a[0])], [
                'title' => $a[0],
                'article_category_id' => $a[1],
                'brand_scope' => $a[1] === $catPempek->id ? 'pempek-tince' : 'pondok-tince',
                'focus_keyword' => $a[2],
                'excerpt' => $a[3],
                'content' => '<p>'.$a[3].'</p><h2>Tentang '.$a[2].'</h2><p>Artikel ini adalah konten awal yang dapat Anda sunting dari admin panel. Tambahkan detail, foto, dan tips sesuai kebutuhan bisnis.</p><p>Ingin memesan atau reservasi? Hubungi kami via WhatsApp.</p>',
                'author' => 'Tim Pondok Tince',
                'reading_time' => 3,
                'meta_description' => $a[3],
                'is_published' => true,
                'published_at' => now()->subDays($i++),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Faq;
use App\Models\MenuItem;
use App\Models\ProductPackage;
use App\Services\SchemaService;

class PempekTinceController extends Controller
{
    public function index(SchemaService $schema)
    {
        $page = $this->cmsPage('pempek-tince');

        $this->applySeo($page, [
            'title' => 'Pempek Tince Palembang untuk Oleh-Oleh, Frozen, dan Pesanan Online',
            'description' => 'Pempek Tince: pempek khas Palembang untuk oleh-oleh, frozen, dan pesanan keluarga. Pesan online via WhatsApp, bisa kirim luar kota.',
            'keywords' => 'Pempek Tince, Pempek Tince Palembang, pempek Palembang',
        ], $this->crumbs([['name' => 'Pempek Tince', 'url' => route('pempek.index')]]));

        seo()->addSchema($schema->restaurant());

        $variants = MenuItem::query()->available()->forBrandKey(Brand::KEY_PEMPEK)->ordered()->limit(8)->get();
        $packages = ProductPackage::query()->active()->whereHas('brand', fn ($q) => $q->where('key', Brand::KEY_PEMPEK))->ordered()->get();
        $faqs = Faq::active()->ordered()
            ->where(fn ($q) => $q->where('group', 'pempek')->orWhereHas('brand', fn ($b) => $b->where('key', Brand::KEY_PEMPEK)))
            ->get();

        if ($faqs->isNotEmpty()) {
            seo()->addSchema($schema->faqPage($faqs));
        }
        foreach ($packages as $pkg) {
            seo()->addSchema($schema->foodProduct($pkg));
        }

        return view('pages.pempek-tince', compact('page', 'variants', 'packages', 'faqs'));
    }

    // Thin route entrypoints (kept out of closures so routes stay cacheable).
    public function paketPempek() { return $this->sub('pempek-tince/paket-pempek'); }
    public function olehOleh() { return $this->sub('pempek-tince/oleh-oleh-palembang'); }
    public function frozen() { return $this->sub('pempek-tince/pempek-frozen'); }
    public function pesanOnline() { return $this->sub('pempek-tince/pesan-online'); }
    public function lokasiPempek() { return $this->sub('pempek-tince/lokasi'); }

    /**
     * Shared renderer for the Pempek Tince sub-pages.
     */
    public function sub(string $slug)
    {
        $config = [
            'pempek-tince/paket-pempek' => [
                'route' => 'pempek.paket',
                'title' => 'Paket Pempek untuk Keluarga & Oleh-Oleh | Pempek Tince',
                'description' => 'Paket pempek Palembang untuk keluarga, oleh-oleh, dan frozen. Pilih paket, pesan via WhatsApp, siap dikirim.',
                'keywords' => 'paket pempek Palembang, pempek oleh-oleh Palembang',
                'crumb' => 'Paket Pempek',
                'filter' => null,
            ],
            'pempek-tince/oleh-oleh-palembang' => [
                'route' => 'pempek.oleholeh',
                'title' => 'Pempek Oleh-Oleh Palembang | Pempek Tince',
                'description' => 'Pempek Tince, pilihan oleh-oleh khas Palembang. Praktis dibawa pulang untuk keluarga dan kerabat.',
                'keywords' => 'pempek oleh-oleh Palembang, oleh-oleh Palembang',
                'crumb' => 'Oleh-Oleh Palembang',
                'filter' => null,
            ],
            'pempek-tince/pempek-frozen' => [
                'route' => 'pempek.frozen',
                'title' => 'Pempek Frozen Palembang untuk Stok di Rumah | Pempek Tince',
                'description' => 'Pempek frozen Palembang dari Pempek Tince. Tahan lama, praktis, dan bisa dikirim ke luar kota.',
                'keywords' => 'pempek frozen Palembang, pempek Palembang',
                'crumb' => 'Pempek Frozen',
                'filter' => 'frozen',
            ],
            'pempek-tince/pesan-online' => [
                'route' => 'pempek.pesan',
                'title' => 'Cara Pesan Pempek Online | Pempek Tince Palembang',
                'description' => 'Cara memesan pempek Tince secara online: pilih menu atau paket, klik WhatsApp, konfirmasi stok & pengiriman, lalu pesanan diproses.',
                'keywords' => 'pesan pempek Palembang, pempek Palembang online',
                'crumb' => 'Pesan Online',
                'filter' => null,
            ],
            'pempek-tince/lokasi' => [
                'route' => 'pempek.lokasi',
                'title' => 'Lokasi Pempek Tince Palembang',
                'description' => 'Lokasi dan cara mendapatkan pempek Tince di Palembang. Ambil di tempat atau pesan untuk dikirim.',
                'keywords' => 'lokasi Pempek Tince, pempek Palembang',
                'crumb' => 'Lokasi',
                'filter' => null,
            ],
        ][$slug] ?? null;

        abort_if($config === null, 404);

        $page = $this->cmsPage($slug);

        $this->applySeo($page, $config, $this->crumbs([
            ['name' => 'Pempek Tince', 'url' => route('pempek.index')],
            ['name' => $config['crumb'], 'url' => route($config['route'])],
        ]));

        $packages = ProductPackage::query()->active()
            ->whereHas('brand', fn ($q) => $q->where('key', Brand::KEY_PEMPEK))
            ->when($config['filter'] === 'frozen', fn ($q) => $q->where('is_frozen', true))
            ->ordered()->get();

        $faqs = Faq::active()->ordered()->where('group', 'pempek')->get();

        return view('pages.pempek-sub', [
            'page' => $page,
            'slug' => $slug,
            'config' => $config,
            'packages' => $packages,
            'faqs' => $faqs,
        ]);
    }
}

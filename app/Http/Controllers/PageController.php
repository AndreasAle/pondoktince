<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Page;
use App\Services\SchemaService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function lokasi(SchemaService $schema)
    {
        $page = $this->cmsPage('lokasi');

        $this->applySeo($page, [
            'title' => 'Lokasi & Jam Buka | Pondok Tince Palembang',
            'description' => 'Alamat, jam buka, dan peta lokasi Pondok Tince di Palembang. Mudah dijangkau untuk keluarga, rombongan, dan tamu luar kota.',
            'keywords' => 'lokasi Pondok Tince, tempat makan Palembang',
        ], $this->crumbs([['name' => 'Lokasi', 'url' => route('lokasi')]]));

        seo()->addSchema($schema->restaurant());

        $faqs = Faq::active()->ordered()->where('group', 'lokasi')->get();
        if ($faqs->isNotEmpty()) {
            seo()->addSchema($schema->faqPage($faqs));
        }

        return view('pages.lokasi', compact('page', 'faqs'));
    }

    public function paketAcara(SchemaService $schema)
    {
        $page = $this->cmsPage('paket-acara');

        $this->applySeo($page, [
            'title' => 'Paket Acara & Rombongan | Pondok Tince',
            'description' => 'Pondok Tince cocok untuk arisan, meeting kantor, acara keluarga, dan rombongan tamu luar kota. Konsultasikan kebutuhan acara Anda via WhatsApp.',
            'keywords' => 'tempat makan acara Palembang, tempat makan rombongan Palembang',
        ], $this->crumbs([['name' => 'Paket Acara', 'url' => route('paket-acara')]]));

        $faqs = Faq::active()->ordered()->where('group', 'acara')->get();
        if ($faqs->isNotEmpty()) {
            seo()->addSchema($schema->faqPage($faqs));
        }

        $gallery = Gallery::active()->ordered()->whereIn('category', ['acara', 'tempat', 'suasana'])->limit(8)->get();

        return view('pages.paket-acara', compact('page', 'faqs', 'gallery'));
    }

    public function galeri(Request $request)
    {
        $page = $this->cmsPage('galeri');

        $this->applySeo($page, [
            'title' => 'Galeri Suasana & Makanan | Pondok Tince',
            'description' => 'Galeri foto makanan, suasana tempat, dan momen acara di Pondok Tince dan Pempek Tince.',
        ], $this->crumbs([['name' => 'Galeri', 'url' => route('galeri')]]));

        $category = $request->query('kategori');
        $items = Gallery::active()->ordered()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(24)->withQueryString();

        $categories = Gallery::active()->distinct()->orderBy('category')->pluck('category');

        return view('pages.galeri', compact('page', 'items', 'categories', 'category'));
    }

    /**
     * Generic renderer for the three SEO pillar pages.
     */
    public function pillar(string $slug, SchemaService $schema)
    {
        $config = [
            'kuliner-palembang' => [
                'title' => 'Kuliner Palembang di Pondok Tince',
                'description' => 'Kuliner Palembang yang nyaman untuk keluarga dan tamu luar kota. Nikmati masakan khas Palembang di Pondok Tince.',
                'keywords' => 'kuliner Palembang, kuliner khas Palembang',
            ],
            'pempek-palembang' => [
                'title' => 'Pempek Palembang di Pempek Tince',
                'description' => 'Pempek Palembang khas untuk makan di tempat, oleh-oleh, dan frozen. Pesan pempek Tince via WhatsApp.',
                'keywords' => 'pempek Palembang, pempek Palembang enak',
            ],
            'makanan-enak-palembang' => [
                'title' => 'Makanan Enak di Palembang untuk Keluarga dan Rombongan',
                'description' => 'Rekomendasi makanan enak khas Palembang di Pondok Tince. Cocok untuk keluarga, rombongan, dan tamu luar kota.',
                'keywords' => 'makanan enak Palembang, makanan khas Palembang',
            ],
        ][$slug] ?? null;

        abort_if($config === null, 404);

        $page = $this->cmsPage($slug);

        $this->applySeo($page, $config, $this->crumbs([
            ['name' => $config['title'], 'url' => route('pillar', $slug)],
        ]));

        seo()->addSchema($schema->restaurant());

        $favorites = MenuItem::query()->available()
            ->forBrandKey($slug === 'pempek-palembang' ? Brand::KEY_PEMPEK : Brand::KEY_PONDOK)
            ->with('brand')->ordered()->limit(6)->get();

        if ($favorites->isEmpty()) {
            $favorites = MenuItem::query()->available()->with('brand')->ordered()->limit(6)->get();
        }

        return view('pages.pillar', [
            'page' => $page,
            'slug' => $slug,
            'config' => $config,
            'favorites' => $favorites,
        ]);
    }

    /**
     * Catch-all: render any other published CMS page via the section builder.
     */
    public function show(string $slug, SchemaService $schema)
    {
        $page = Page::query()->published()->where('slug', $slug)->with(['activeSections', 'faqs'])->firstOrFail();

        $this->applySeo($page, [], $this->crumbs([
            ['name' => $page->breadcrumb_title ?: $page->title, 'url' => url('/'.$page->slug)],
        ]));

        if ($page->schema_type === 'Restaurant' || $page->schema_type === 'FoodEstablishment') {
            seo()->addSchema($schema->restaurant());
        }
        if ($page->faqs->isNotEmpty()) {
            seo()->addSchema($schema->faqPage($page->faqs));
        }
        if (is_array($page->custom_schema) && ! empty($page->custom_schema)) {
            seo()->addSchema($page->custom_schema);
        }

        return view('pages.cms', compact('page'));
    }
}

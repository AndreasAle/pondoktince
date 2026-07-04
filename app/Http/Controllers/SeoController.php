<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    /**
     * Dynamic XML sitemap. Cached for 1 hour.
     */
    public function sitemap()
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $urls = [];

            // Static, always-on public routes.
            foreach ($this->staticRoutes() as $path => $meta) {
                $urls[] = $this->urlEntry(url($path), $meta[0], $meta[1]);
            }

            // CMS pages flagged for the sitemap.
            Page::query()->published()->where('in_sitemap', true)->where('noindex', false)
                ->get(['slug', 'updated_at', 'sitemap_priority', 'sitemap_frequency'])
                ->each(function ($page) use (&$urls) {
                    $urls[] = $this->urlEntry(
                        url('/'.ltrim($page->slug, '/')),
                        $page->sitemap_frequency ?: 'weekly',
                        $page->sitemap_priority ?: 0.5,
                        $page->updated_at
                    );
                });

            // Published articles.
            Article::query()->published()->where('noindex', false)
                ->get(['slug', 'updated_at'])
                ->each(function ($article) use (&$urls) {
                    $urls[] = $this->urlEntry(route('articles.show', $article->slug), 'monthly', 0.5, $article->updated_at);
                });

            // De-duplicate by URL.
            $urls = collect($urls)->unique('loc')->values();

            return view('seo.sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /booking?',
            '',
            'Sitemap: '.url('/sitemap.xml'),
        ];

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * @return array<string,array{0:string,1:float}>  path => [changefreq, priority]
     */
    protected function staticRoutes(): array
    {
        return [
            '/' => ['daily', 1.0],
            '/menu' => ['weekly', 0.9],
            '/booking' => ['monthly', 0.7],
            '/lokasi' => ['monthly', 0.7],
            '/paket-acara' => ['monthly', 0.7],
            '/galeri' => ['monthly', 0.5],
            '/kontak' => ['yearly', 0.4],
            '/artikel' => ['weekly', 0.6],
            '/kuliner-palembang' => ['weekly', 0.9],
            '/pempek-palembang' => ['weekly', 0.9],
            '/makanan-enak-palembang' => ['weekly', 0.9],
            '/pempek-tince' => ['weekly', 0.9],
            '/pempek-tince/menu' => ['weekly', 0.7],
            '/pempek-tince/paket-pempek' => ['weekly', 0.7],
            '/pempek-tince/oleh-oleh-palembang' => ['monthly', 0.6],
            '/pempek-tince/pempek-frozen' => ['monthly', 0.6],
            '/pempek-tince/pesan-online' => ['monthly', 0.6],
            '/pempek-tince/lokasi' => ['monthly', 0.5],
        ];
    }

    protected function urlEntry(string $loc, string $freq, float $priority, $lastmod = null): array
    {
        return [
            'loc' => $loc,
            'changefreq' => $freq,
            'priority' => number_format($priority, 1),
            'lastmod' => $lastmod ? $lastmod->toDateString() : now()->toDateString(),
        ];
    }
}

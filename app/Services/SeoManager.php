<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

/**
 * Request-scoped SEO state. Controllers populate it; the layout renders it.
 * Handles meta, Open Graph, Twitter cards, canonical, robots and JSON-LD schema.
 */
class SeoManager
{
    public ?string $title = null;
    public ?string $description = null;
    public ?string $canonical = null;
    public ?string $image = null;
    public string $ogType = 'website';
    public bool $noindex = false;
    public bool $nofollow = false;
    public ?string $keywords = null;

    /** @var array<int,array{name:string,url:string}> */
    public array $breadcrumbs = [];

    /** @var array<int,array<string,mixed>> */
    public array $schemas = [];

    public function set(array $data): static
    {
        foreach ($data as $key => $value) {
            if ($value !== null && property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description ? Str::limit(strip_tags($description), 160) : null;

        return $this;
    }

    public function canonical(?string $url): static
    {
        $this->canonical = $url;

        return $this;
    }

    public function image(?string $path): static
    {
        if ($path) {
            $this->image = Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path);
        }

        return $this;
    }

    /** @param array<int,array{name:string,url:string}> $items */
    public function breadcrumbs(array $items): static
    {
        $this->breadcrumbs = $items;

        return $this;
    }

    public function addSchema(array $schema): static
    {
        $this->schemas[] = $schema;

        return $this;
    }

    /**
     * Populate SEO from a CMS Page model, applying sensible auto-defaults.
     */
    public function forPage(Page $page): static
    {
        $settings = SiteSetting::current();
        $brandName = $settings->site_name ?: 'Pondok Tince';

        $this->title = $page->meta_title ?: trim(($page->hero_title ?: $page->title).' | '.$brandName);
        $this->description($page->meta_description ?: $page->hero_subtitle ?: strip_tags((string) $page->intro_content));
        $this->canonical = $page->canonical_url ?: url('/'.ltrim($page->slug, '/'));
        $this->image($page->og_image_path ?: $page->hero_image_path ?: $settings->default_og_image_path);
        $this->keywords = $page->focus_keyword;
        $this->noindex = (bool) $page->noindex || ! $page->is_published;
        $this->nofollow = (bool) $page->nofollow;

        return $this;
    }

    public function forArticle(Article $article): static
    {
        $settings = SiteSetting::current();
        $brandName = $settings->site_name ?: 'Pondok Tince';

        $this->title = $article->meta_title ?: trim($article->title.' | '.$brandName);
        $this->description($article->meta_description ?: $article->excerpt);
        $this->canonical = $article->canonical_url ?: route('articles.show', $article->slug);
        $this->image($article->og_image_path ?: $article->featured_image_path ?: $settings->default_og_image_path);
        $this->keywords = $article->focus_keyword;
        $this->noindex = (bool) $article->noindex;
        $this->ogType = 'article';

        return $this;
    }

    public function robotsContent(): string
    {
        $index = $this->noindex ? 'noindex' : 'index';
        $follow = $this->nofollow ? 'nofollow' : 'follow';

        return "{$index}, {$follow}";
    }

    /**
     * Render the full <head> SEO block.
     */
    public function render(): string
    {
        $settings = SiteSetting::current();
        $title = $this->title ?: ($settings->default_seo_title ?: $settings->site_name);
        $description = $this->description ?: $settings->default_seo_description;
        $canonical = $this->canonical ?: url()->current();
        $image = $this->image ?: ($settings->default_og_image_path ? asset('storage/'.$settings->default_og_image_path) : null);
        $siteName = $settings->site_name ?: 'Pondok Tince';

        $out = [];
        $out[] = '<title>'.e($title).'</title>';
        if ($description) {
            $out[] = '<meta name="description" content="'.e($description).'">';
        }
        if ($this->keywords) {
            $out[] = '<meta name="keywords" content="'.e($this->keywords).'">';
        }
        $out[] = '<meta name="robots" content="'.e($this->robotsContent()).'">';
        $out[] = '<link rel="canonical" href="'.e($canonical).'">';

        // Open Graph
        $out[] = '<meta property="og:site_name" content="'.e($siteName).'">';
        $out[] = '<meta property="og:type" content="'.e($this->ogType).'">';
        $out[] = '<meta property="og:title" content="'.e($title).'">';
        if ($description) {
            $out[] = '<meta property="og:description" content="'.e($description).'">';
        }
        $out[] = '<meta property="og:url" content="'.e($canonical).'">';
        if ($image) {
            $out[] = '<meta property="og:image" content="'.e($image).'">';
        }
        $out[] = '<meta property="og:locale" content="id_ID">';

        // Twitter
        $out[] = '<meta name="twitter:card" content="'.($image ? 'summary_large_image' : 'summary').'">';
        $out[] = '<meta name="twitter:title" content="'.e($title).'">';
        if ($description) {
            $out[] = '<meta name="twitter:description" content="'.e($description).'">';
        }
        if ($image) {
            $out[] = '<meta name="twitter:image" content="'.e($image).'">';
        }

        if ($settings->google_site_verification) {
            $out[] = '<meta name="google-site-verification" content="'.e($settings->google_site_verification).'">';
        }

        // JSON-LD schema graph
        foreach ($this->allSchemas() as $schema) {
            $out[] = '<script type="application/ld+json">'
                .json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                .'</script>';
        }

        return implode("\n    ", $out);
    }

    /**
     * Combine per-request schemas with always-on Website/Organization + breadcrumbs.
     */
    protected function allSchemas(): array
    {
        $schema = app(SchemaService::class);
        $all = [$schema->website(), $schema->organization()];

        if (count($this->breadcrumbs) > 1) {
            $all[] = $schema->breadcrumbList($this->breadcrumbs);
        }

        return array_merge($all, $this->schemas);
    }
}

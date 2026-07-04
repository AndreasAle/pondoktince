<?php

namespace App\Http\Controllers;

use App\Models\Page;

abstract class Controller
{
    /**
     * Fetch a published CMS Page by slug (or null). Used to pull hero/SEO/sections
     * for the dedicated route templates.
     */
    protected function cmsPage(string $slug): ?Page
    {
        return Page::query()->published()->where('slug', $slug)->with('activeSections')->first();
    }

    /**
     * Apply SEO from a CMS page if present, otherwise from explicit fallbacks,
     * and register breadcrumbs.
     *
     * @param  array<int,array{name:string,url:string}>  $breadcrumbs
     */
    protected function applySeo(?Page $page, array $fallback = [], array $breadcrumbs = []): void
    {
        $seo = seo();

        if ($page) {
            $seo->forPage($page);
        }

        // Fallbacks fill any value the page did not provide.
        if (empty($seo->title) && ! empty($fallback['title'])) {
            $seo->title($fallback['title']);
        }
        if (empty($seo->description) && ! empty($fallback['description'])) {
            $seo->description($fallback['description']);
        }
        if (empty($seo->keywords) && ! empty($fallback['keywords'])) {
            $seo->keywords = $fallback['keywords'];
        }

        if ($breadcrumbs) {
            $seo->breadcrumbs($breadcrumbs);
        }
    }

    /**
     * @param  array<int,array{name:string,url:string}>  $items
     */
    protected function crumbs(array $items): array
    {
        return array_merge([['name' => 'Beranda', 'url' => url('/')]], $items);
    }
}

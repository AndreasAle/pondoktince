<?php

use App\Models\SiteSetting;
use App\Services\SeoManager;
use App\Services\WhatsAppService;

if (! function_exists('settings')) {
    /**
     * Access the singleton site settings row.
     */
    function settings(): SiteSetting
    {
        return SiteSetting::current();
    }
}

if (! function_exists('seo')) {
    /**
     * Access the request-scoped SEO manager.
     */
    function seo(): SeoManager
    {
        return app(SeoManager::class);
    }
}

if (! function_exists('whatsapp')) {
    function whatsapp(): WhatsAppService
    {
        return app(WhatsAppService::class);
    }
}

if (! function_exists('wa_url')) {
    /**
     * Shortcut to build a wa.me link.
     */
    function wa_url(?string $message = null, ?string $brandKey = null): string
    {
        return app(WhatsAppService::class)->url($message, $brandKey);
    }
}

if (! function_exists('media_url')) {
    /**
     * Resolve a stored media path to a public URL, with an optional fallback asset.
     */
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (! $path) {
            return $fallback ? asset($fallback) : null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }
}

if (! function_exists('youtube_id')) {
    /**
     * Extract a YouTube video id from any common URL form (or null).
     */
    function youtube_id(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('%(?:youtube\.com/(?:watch\?v=|embed/|shorts/|v/)|youtu\.be/)([\w-]{11})%i', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}

if (! function_exists('vimeo_id')) {
    function vimeo_id(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('%vimeo\.com/(?:video/)?(\d+)%i', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}

if (! function_exists('rupiah')) {
    function rupiah(int|float|string|null $value, string $fallback = 'Menyesuaikan'): string
    {
        if ($value === null || $value === '') {
            return $fallback;
        }

        return 'Rp'.number_format((float) $value, 0, ',', '.');
    }
}

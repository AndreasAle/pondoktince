<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

/**
 * Central place to resolve WhatsApp numbers + build wa.me deep links.
 * Numbers are configured per-brand (Brand model) with fallback to Site Settings.
 */
class WhatsAppService
{
    /**
     * Resolve the destination phone number (digits only) for a brand key.
     */
    public function numberFor(?string $brandKey = null): ?string
    {
        $settings = SiteSetting::current();

        $number = match ($brandKey) {
            Brand::KEY_PEMPEK => $this->brandNumber(Brand::KEY_PEMPEK) ?: $settings->whatsapp_number_pempek,
            Brand::KEY_PONDOK => $this->brandNumber(Brand::KEY_PONDOK) ?: $settings->whatsapp_number,
            default => $settings->whatsapp_number,
        };

        // Final fallback: primary Pondok Tince number.
        $number = $number ?: $settings->whatsapp_number ?: $settings->whatsapp_number_pempek;

        return $number ? $this->sanitize($number) : null;
    }

    /**
     * Build a wa.me deep link with an optional pre-filled message.
     */
    public function url(?string $message = null, ?string $brandKey = null): string
    {
        $number = $this->numberFor($brandKey);

        if (! $number) {
            return '#';
        }

        $url = 'https://wa.me/'.$number;

        if ($message) {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }

    /**
     * Fill a message template. Supports {name} and any {key} => value pair.
     */
    public function fillTemplate(?string $template, array $replacements = []): string
    {
        $template = $template ?: 'Halo, saya ingin bertanya.';

        foreach ($replacements as $key => $value) {
            $template = str_replace('{'.$key.'}', (string) $value, $template);
        }

        return $template;
    }

    public function sanitize(string $number): string
    {
        $number = preg_replace('/\D/', '', $number);

        // Convert leading 0 (local Indonesian format) to 62.
        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        return $number;
    }

    protected function brandNumber(string $key): ?string
    {
        return Cache::remember("wa_brand_{$key}", 3600, function () use ($key) {
            return Brand::where('key', $key)->value('whatsapp_number');
        });
    }
}

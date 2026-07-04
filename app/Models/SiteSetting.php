<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'opening_hours' => 'array',
    ];

    /**
     * Always work with the single settings row. Cached for performance.
     */
    public static function current(): self
    {
        return Cache::rememberForever('site_settings', function () {
            return static::query()->firstOrCreate(['id' => 1]);
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('site_settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }
}

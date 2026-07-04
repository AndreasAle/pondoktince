<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'custom_schema' => 'array',
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
        'in_sitemap' => 'boolean',
        'is_published' => 'boolean',
        'sitemap_priority' => 'float',
        'published_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function activeSections()
    {
        return $this->sections()->where('is_active', true);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }
}

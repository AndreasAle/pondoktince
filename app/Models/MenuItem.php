<?php

namespace App\Models;

use App\Models\Concerns\HasProductReviews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasProductReviews, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'gallery' => 'array',
        'is_favorite' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_spicy' => 'boolean',
        'is_new' => 'boolean',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
        'sold_count' => 'integer',
        'stock' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function scopeAvailable(Builder $q): Builder
    {
        return $q->where('is_available', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('name');
    }

    public function scopeForBrandKey(Builder $q, string $key): Builder
    {
        return $q->whereHas('brand', fn ($b) => $b->where('key', $key));
    }

    public function getEffectivePriceAttribute(): ?string
    {
        return $this->discount_price ?: $this->price;
    }
}

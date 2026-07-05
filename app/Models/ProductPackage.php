<?php

namespace App\Models;

use App\Models\Concerns\HasProductReviews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPackage extends Model
{
    use HasProductReviews, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'contents' => 'array',
        'gallery' => 'array',
        'is_frozen' => 'boolean',
        'is_recommended' => 'boolean',
        'is_active' => 'boolean',
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

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('name');
    }
}

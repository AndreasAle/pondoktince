<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $guarded = [];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function scopeApproved(Builder $q): Builder
    {
        return $q->where('is_approved', true);
    }
}

<?php

namespace App\Models\Concerns;

use App\Models\ProductReview;

/**
 * Shared marketplace behaviour for MenuItem & ProductPackage:
 * approved reviews, rating aggregates, and discount helpers.
 */
trait HasProductReviews
{
    public function reviews()
    {
        return $this->morphMany(ProductReview::class, 'reviewable');
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true)->latest();
    }

    public function ratingAvg(): ?float
    {
        $avg = $this->approvedReviews()->avg('rating');

        return $avg ? round((float) $avg, 1) : null;
    }

    public function ratingCount(): int
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Rating breakdown [5 => n, 4 => n, 3 => n, 2 => n, 1 => n] for the summary bars.
     */
    public function ratingBreakdown(): array
    {
        $counts = $this->approvedReviews()
            ->selectRaw('rating, count(*) as total')
            ->groupBy('rating')->pluck('total', 'rating')->all();

        $out = [];
        foreach ([5, 4, 3, 2, 1] as $star) {
            $out[$star] = (int) ($counts[$star] ?? 0);
        }

        return $out;
    }

    public function discountPercent(): ?int
    {
        if ($this->discount_price && $this->price && $this->discount_price < $this->price) {
            return (int) round((1 - ($this->discount_price / $this->price)) * 100);
        }

        return null;
    }

    public function effectivePrice(): ?string
    {
        return $this->discount_price ?: $this->price;
    }
}

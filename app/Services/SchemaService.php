<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\ProductPackage;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;

/**
 * Builds JSON-LD schema.org structures for rich results.
 */
class SchemaService
{
    public function website(): array
    {
        $settings = SiteSetting::current();

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'name' => $settings->site_name ?: 'Pondok Tince',
            'alternateName' => 'Pempek Tince',
            'url' => url('/'),
            'inLanguage' => 'id-ID',
            'publisher' => ['@id' => url('/').'#organization'],
        ]);
    }

    public function organization(): array
    {
        $settings = SiteSetting::current();

        $sameAs = array_values(array_filter([
            $settings->instagram_pondok,
            $settings->instagram_pempek,
        ]));

        $phone = $settings->whatsapp_number ? '+'.preg_replace('/\D/', '', $settings->whatsapp_number) : null;

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/').'#organization',
            'name' => $settings->site_name ?: 'Pondok Tince',
            'alternateName' => 'Pempek Tince',
            'description' => $settings->default_seo_description ?: 'Kuliner khas Palembang: rumah makan Pondok Tince & pempek Pempek Tince.',
            'url' => url('/'),
            'logo' => $settings->logo_path ? [
                '@type' => 'ImageObject',
                'url' => asset('storage/'.$settings->logo_path),
            ] : null,
            'image' => $settings->default_og_image_path ? asset('storage/'.$settings->default_og_image_path) : null,
            'email' => $settings->email ?: null,
            'address' => $settings->address ? [
                '@type' => 'PostalAddress',
                'streetAddress' => $settings->address,
                'addressLocality' => 'Palembang',
                'addressRegion' => 'Sumatera Selatan',
                'addressCountry' => 'ID',
            ] : null,
            'contactPoint' => $phone ? [
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => 'customer service',
                'areaServed' => 'ID',
                'availableLanguage' => ['Indonesian'],
            ] : null,
            'sameAs' => $sameAs ?: null,
        ]);
    }

    /**
     * LocalBusiness / Restaurant schema for the physical outlet.
     */
    public function restaurant(): array
    {
        $settings = SiteSetting::current();

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Restaurant',
            'name' => $settings->site_name ?: 'Pondok Tince',
            'image' => $settings->default_og_image_path ? asset('storage/'.$settings->default_og_image_path) : null,
            'url' => url('/'),
            'servesCuisine' => 'Masakan Khas Palembang',
            'priceRange' => 'Rp',
            'telephone' => $settings->whatsapp_number,
            'address' => $settings->address ? [
                '@type' => 'PostalAddress',
                'streetAddress' => $settings->address,
                'addressLocality' => 'Palembang',
                'addressRegion' => 'Sumatera Selatan',
                'addressCountry' => 'ID',
            ] : null,
            'sameAs' => array_values(array_filter([
                $settings->instagram_pondok,
                $settings->instagram_pempek,
            ])) ?: null,
        ]);
    }

    /**
     * @param array<int,array{name:string,url:string}> $items
     */
    public function breadcrumbList(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    }

    /**
     * @param Collection<int,\App\Models\Faq>|iterable $faqs
     */
    public function faqPage(iterable $faqs): array
    {
        $entities = [];

        foreach ($faqs as $faq) {
            $entities[] = [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq->answer),
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    public function menuItem(MenuItem $item): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'MenuItem',
            'name' => $item->name,
            'description' => $item->short_description ?: strip_tags((string) $item->description),
            'image' => $item->image_path ? asset('storage/'.$item->image_path) : null,
            'offers' => $item->price ? [
                '@type' => 'Offer',
                'price' => (string) ($item->discount_price ?: $item->price),
                'priceCurrency' => 'IDR',
            ] : null,
        ]);
    }

    /**
     * Full Product schema with aggregateRating + reviews (Google rich stars).
     *
     * @param  \Illuminate\Support\Collection  $reviews  approved ProductReview collection
     */
    public function productWithReviews(
        string $name,
        ?string $description,
        ?string $image,
        int|float|string|null $price,
        ?float $ratingAvg,
        int $ratingCount,
        $reviews,
        string $category = 'Pempek Palembang'
    ): array {
        $schema = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $name,
            'description' => $description ? strip_tags($description) : null,
            'image' => $image,
            'category' => $category,
            'brand' => ['@type' => 'Brand', 'name' => SiteSetting::current()->site_name ?: 'Pondok Tince'],
            'offers' => $price ? [
                '@type' => 'Offer',
                'price' => (string) $price,
                'priceCurrency' => 'IDR',
                'availability' => 'https://schema.org/InStock',
                'url' => url()->current(),
            ] : null,
        ]);

        if ($ratingCount > 0 && $ratingAvg) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (string) $ratingAvg,
                'reviewCount' => $ratingCount,
                'bestRating' => '5',
                'worstRating' => '1',
            ];

            $schema['review'] = collect($reviews)->take(10)->map(fn ($r) => [
                '@type' => 'Review',
                'author' => ['@type' => 'Person', 'name' => $r->name],
                'datePublished' => optional($r->created_at)->toDateString(),
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (string) $r->rating, 'bestRating' => '5'],
                'reviewBody' => (string) $r->comment,
            ])->values()->all();
        }

        return $schema;
    }

    public function foodProduct(ProductPackage $pkg): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $pkg->name,
            'description' => strip_tags((string) $pkg->description),
            'image' => $pkg->image_path ? asset('storage/'.$pkg->image_path) : null,
            'category' => 'Pempek Palembang',
            'offers' => $pkg->price ? [
                '@type' => 'Offer',
                'price' => (string) $pkg->price,
                'priceCurrency' => 'IDR',
                'availability' => 'https://schema.org/InStock',
            ] : null,
        ]);
    }
}

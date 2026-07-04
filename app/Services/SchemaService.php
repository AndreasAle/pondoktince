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

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $settings->site_name ?: 'Pondok Tince',
            'url' => url('/'),
        ];
    }

    public function organization(): array
    {
        $settings = SiteSetting::current();

        $sameAs = array_values(array_filter([
            $settings->instagram_pondok,
            $settings->instagram_pempek,
        ]));

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $settings->site_name ?: 'Pondok Tince',
            'url' => url('/'),
            'logo' => $settings->logo_path ? asset('storage/'.$settings->logo_path) : null,
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

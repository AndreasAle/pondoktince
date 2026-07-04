@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Galeri"
    :title="$page?->hero_title ?: 'Galeri Pondok Tince & Pempek Tince'"
    :subtitle="$page?->hero_subtitle ?: 'Momen makanan, suasana tempat, dan acara.'"
    :image="media_url($page?->hero_image_path)" />

<x-breadcrumbs />

<div class="container-x py-12">
    @if($categories->count())
        <div class="mb-8 flex flex-wrap gap-2">
            <a href="{{ route('galeri') }}" class="rounded-full px-4 py-2 text-sm font-medium {{ !$category ? 'bg-maroon-700 text-cream-50' : 'bg-cream-100 text-charcoal/70' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('galeri', ['kategori' => $cat]) }}" class="rounded-full px-4 py-2 text-sm font-medium capitalize {{ $category === $cat ? 'bg-maroon-700 text-cream-50' : 'bg-cream-100 text-charcoal/70' }}">{{ $cat }}</a>
            @endforeach
        </div>
    @endif

    @if($items->count())
        <div class="columns-2 gap-4 sm:columns-3 lg:columns-4 [&>*]:mb-4">
            @foreach($items as $g)
                <figure class="break-inside-avoid overflow-hidden rounded-xl bg-cream-200">
                    <img src="{{ media_url($g->image_path) }}" alt="{{ $g->alt_text ?: 'Galeri Pondok Tince' }}" loading="lazy" class="w-full object-cover">
                    @if($g->caption)<figcaption class="px-3 py-2 text-xs text-charcoal/60">{{ $g->caption }}</figcaption>@endif
                </figure>
            @endforeach
        </div>
        <div class="mt-10">{{ $items->links() }}</div>
    @else
        <p class="rounded-2xl border border-dashed border-cream-200 bg-cream-50 py-16 text-center text-charcoal/50">Galeri sedang disiapkan. Foto akan tampil setelah diunggah dari admin.</p>
    @endif
</div>
@endsection

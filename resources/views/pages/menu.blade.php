@extends('layouts.public')

@section('content')
<x-page-hero
    :eyebrow="$brandKey === 'pempek-tince' ? 'Pempek Tince' : 'Pondok Tince'"
    :title="$page?->hero_title ?: $title"
    :subtitle="$page?->hero_subtitle ?: $subtitle"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button :message="'Halo, saya ingin bertanya menu '.$title.'.'" :brand="$brandKey" label="Tanya Menu via WhatsApp" source="menu-hero" />
</x-page-hero>

<x-breadcrumbs />

<div class="container-x py-12" x-data="{ cat: 'all' }">
    @if($categories->count() > 1)
        <div class="mb-8 flex flex-wrap gap-2">
            <button @click="cat = 'all'" :class="cat === 'all' ? 'bg-maroon-700 text-cream-50' : 'bg-cream-100 text-charcoal/70'"
                    class="rounded-full px-4 py-2 text-sm font-medium transition">Semua</button>
            @foreach($categories as $category)
                <button @click="cat = '{{ $category->slug }}'"
                        :class="cat === '{{ $category->slug }}' ? 'bg-maroon-700 text-cream-50' : 'bg-cream-100 text-charcoal/70'"
                        class="rounded-full px-4 py-2 text-sm font-medium transition">{{ $category->name }}</button>
            @endforeach
        </div>
    @endif

    @forelse($categories as $category)
        <section x-show="cat === 'all' || cat === '{{ $category->slug }}'" class="mb-12">
            <div class="mb-5 flex items-center gap-3">
                <h2 class="font-display text-2xl font-bold text-charcoal">{{ $category->name }}</h2>
                <span class="h-px flex-1 bg-cream-200"></span>
            </div>
            @if($category->description)<p class="mb-5 max-w-2xl text-sm text-charcoal/60">{{ $category->description }}</p>@endif
            <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
                @foreach($category->activeItems as $item)
                    <x-menu-card :item="$item" source="menu-{{ $brandKey }}" />
                @endforeach
            </div>
        </section>
    @empty
        <div class="rounded-2xl border border-dashed border-cream-200 bg-cream-50 py-16 text-center text-charcoal/50">
            <p>Menu sedang disiapkan. Silakan hubungi kami via WhatsApp untuk info menu terbaru.</p>
            <div class="mt-4"><x-wa-button message="Halo, saya ingin tanya menu." :brand="$brandKey" label="Tanya via WhatsApp" source="menu-empty" /></div>
        </div>
    @endforelse

    @if($brandKey !== 'pempek-tince')
        <div class="mt-8 rounded-2xl bg-cream-100 p-6 text-center">
            <p class="text-charcoal/70">Mencari pempek Palembang untuk oleh-oleh atau frozen?</p>
            <a href="{{ route('pempek.index') }}" class="mt-3 inline-block btn-primary">Lihat Menu Pempek Tince</a>
        </div>
    @endif
</div>
@endsection

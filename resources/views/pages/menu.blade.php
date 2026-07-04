@extends('layouts.public')

@section('content')
<x-page-hero
    :eyebrow="$brandKey === 'pempek-tince' ? 'Pempek Tince' : 'Menu Pondok Tince'"
    :title="$page?->hero_title ?: $title"
    :subtitle="$page?->hero_subtitle ?: $subtitle"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button :message="'Halo, saya ingin bertanya menu '.$title.'.'" :brand="$brandKey" label="Tanya Menu via WhatsApp" source="menu-hero" variant="gold" />
</x-page-hero>

<x-breadcrumbs />

<div class="container-x py-14 lg:py-20" x-data="{ cat: 'all' }">
    {{-- Filter kategori --}}
    @if($categories->count() > 1)
        <div class="mb-10 flex flex-wrap justify-center gap-2.5">
            <button @click="cat = 'all'"
                    :class="cat === 'all' ? 'bg-maroon-700 text-cream-50 shadow-md shadow-maroon-900/20' : 'bg-white text-charcoal/70 ring-1 ring-cream-200 hover:ring-maroon-300'"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition">Semua Menu</button>
            @foreach($categories as $category)
                <button @click="cat = '{{ $category->slug }}'"
                        :class="cat === '{{ $category->slug }}' ? 'bg-maroon-700 text-cream-50 shadow-md shadow-maroon-900/20' : 'bg-white text-charcoal/70 ring-1 ring-cream-200 hover:ring-maroon-300'"
                        class="rounded-full px-5 py-2.5 text-sm font-semibold transition">{{ $category->name }}</button>
            @endforeach
        </div>
    @endif

    @forelse($categories as $category)
        <section x-show="cat === 'all' || cat === '{{ $category->slug }}'" class="mb-14">
            <div class="mb-6 flex items-center gap-4">
                <x-icon-badge name="utensils" size="sm" />
                <div class="flex-1">
                    <h2 class="font-display text-2xl font-bold text-charcoal">{{ $category->name }}</h2>
                    @if($category->description)<p class="text-sm text-charcoal/55">{{ $category->description }}</p>@endif
                </div>
                <span class="hidden h-px flex-1 bg-cream-200 sm:block"></span>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
                @foreach($category->activeItems as $item)
                    <x-menu-card :item="$item" source="menu-{{ $brandKey }}" />
                @endforeach
            </div>
        </section>
    @empty
        <div class="rounded-3xl border border-dashed border-cream-200 bg-cream-100 py-16 text-center">
            <x-icon-badge name="utensils" size="lg" class="mx-auto" />
            <p class="mt-5 text-charcoal/60">Menu sedang disiapkan. Silakan hubungi kami untuk info menu terbaru.</p>
            <div class="mt-5"><x-wa-button message="Halo, saya ingin tanya menu." :brand="$brandKey" label="Tanya via WhatsApp" source="menu-empty" /></div>
        </div>
    @endforelse

    @if($brandKey !== 'pempek-tince')
        {{-- Cross-sell ke Pempek Tince --}}
        <div class="mt-6 flex flex-col items-center gap-5 overflow-hidden rounded-3xl lux-dark p-8 text-center text-cream-50 sm:flex-row sm:justify-between sm:text-left lg:p-10">
            <div class="flex items-center gap-4">
                <x-icon-badge name="fish" size="lg" tone="light" />
                <div>
                    <h3 class="font-display text-xl font-bold text-cream-50">Cari Pempek untuk Oleh-oleh?</h3>
                    <p class="mt-1 text-sm text-cream-100/80">Pempek Tince — pempek Palembang untuk oleh-oleh, frozen, & pesan online.</p>
                </div>
            </div>
            <a href="{{ route('pempek.index') }}" class="btn-gold flex-none">Lihat Pempek Tince</a>
        </div>
    @endif
</div>
@endsection

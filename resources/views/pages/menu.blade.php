@extends('layouts.public')

@section('content')
@php $wa = app(\App\Services\WhatsAppService::class); @endphp

<x-page-hero
    :eyebrow="$brandKey === 'pempek-tince' ? 'Pempek Tince' : 'Menu Pondok Tince'"
    :title="$page?->hero_title ?: $title"
    :subtitle="$page?->hero_subtitle ?: $subtitle"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button :message="'Halo, saya ingin bertanya menu '.$title.'.'" :brand="$brandKey" label="Tanya Menu via WhatsApp" source="menu-hero" variant="gold" />
</x-page-hero>

<x-breadcrumbs />

<div class="container-x py-10 lg:py-14" x-data="{ cat: 'all' }">
    {{-- Filter kategori (scroll horizontal di mobile) --}}
    @if($categories->count() > 1)
        <div class="sticky top-16 z-30 -mx-5 mb-8 border-b border-cream-200 bg-cream-50/95 px-5 py-3 backdrop-blur lg:top-20">
            <div class="flex gap-2 overflow-x-auto pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <button @click="cat = 'all'"
                        :class="cat === 'all' ? 'bg-maroon-700 text-cream-50' : 'bg-white text-charcoal/70 ring-1 ring-cream-200'"
                        class="flex-none rounded-full px-4 py-2 text-xs font-semibold transition">Semua</button>
                @foreach($categories as $category)
                    <button @click="cat = '{{ $category->slug }}'"
                            :class="cat === '{{ $category->slug }}' ? 'bg-maroon-700 text-cream-50' : 'bg-white text-charcoal/70 ring-1 ring-cream-200'"
                            class="flex-none whitespace-nowrap rounded-full px-4 py-2 text-xs font-semibold transition">{{ $category->name }}</button>
                @endforeach
            </div>
        </div>
    @endif

    <p class="mb-8 flex items-center gap-2 text-xs text-charcoal/50">
        <x-ico name="chat" class="h-4 w-4 text-[#25D366]" />
        Klik item untuk pesan langsung via WhatsApp. Harga belum termasuk PB1 (pajak).
    </p>

    @forelse($categories as $category)
        <section x-show="cat === 'all' || cat === '{{ $category->slug }}'" class="mb-12">
            <div class="mb-5 flex items-center gap-4">
                <x-icon-badge name="utensils" size="sm" />
                <div class="flex-1">
                    <h2 class="font-display text-xl font-bold text-charcoal sm:text-2xl">{{ $category->name }}</h2>
                    @if($category->description)<p class="text-sm text-charcoal/55">{{ $category->description }}</p>@endif
                </div>
            </div>

            <div class="grid gap-x-10 sm:grid-cols-2">
                @foreach($category->activeItems as $item)
                    @php
                        $msg = 'Halo '.($brandKey === 'pempek-tince' ? 'Pempek Tince' : 'Pondok Tince').', saya mau pesan '.$item->name
                            .($item->price ? ' ('.rupiah($item->price).')' : '').'. Apakah tersedia?';
                    @endphp
                    <a href="{{ $wa->url($msg, $brandKey) }}" target="_blank" rel="noopener nofollow"
                       @click="window.trackWhatsApp({ source_page: 'menu-{{ $brandKey }}', button_label: 'Pesan {{ addslashes($item->name) }}', brand_key: '{{ $brandKey }}', destination_number: '{{ $wa->numberFor($brandKey) }}' })"
                       class="group flex items-baseline gap-2 border-b border-dashed border-cream-200 py-3 transition hover:border-maroon-300">
                        <span class="font-medium text-charcoal transition group-hover:text-maroon-700">
                            {{ $item->name }}
                            @if($item->is_best_seller)<span class="ml-1 rounded bg-gold-500/20 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-gold-600 align-middle">Best</span>@endif
                            @if($item->price_note)<span class="ml-1 text-[11px] font-normal text-charcoal/45">· {{ $item->price_note }}</span>@endif
                        </span>
                        <span class="min-w-4 flex-1 translate-y-[-3px] border-b border-dotted border-cream-300"></span>
                        <span class="flex-none font-display text-sm font-bold text-maroon-700">{{ $item->price ? rupiah($item->price) : 'Menyesuaikan' }}</span>
                    </a>
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
        <div class="mt-6 flex flex-col items-center gap-5 overflow-hidden rounded-3xl lux-dark p-8 text-center text-cream-50 sm:flex-row sm:justify-between sm:text-left lg:p-10">
            <div class="flex items-center gap-4">
                <x-icon-badge name="fish" size="lg" tone="light" />
                <div>
                    <h3 class="font-display text-xl font-bold text-cream-50">Cari Pempek & Oleh-oleh?</h3>
                    <p class="mt-1 text-sm text-cream-100/80">Pempek Tince — aneka pempek & paket pempek Palembang, bisa frozen & kirim luar kota.</p>
                </div>
            </div>
            <a href="{{ route('pempek.index') }}" class="btn-gold flex-none">Lihat Pempek Tince</a>
        </div>
    @endif
</div>
@endsection

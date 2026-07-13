@extends('layouts.public')

@section('content')
<style>[x-cloak]{display:none!important}</style>

<x-page-hero
    :eyebrow="$brandKey === 'pempek-tince' ? 'Pempek Tince' : 'Menu Pondok Tince'"
    :title="$page?->hero_title ?: $title"
    :subtitle="$page?->hero_subtitle ?: $subtitle"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button :message="'Halo, saya ingin bertanya menu '.$title.'.'" :brand="$brandKey" label="Tanya Menu via WhatsApp" source="menu-hero" variant="gold" />
</x-page-hero>

<x-breadcrumbs />

<div class="container-x py-10 lg:py-14" x-data="{ cat: 'all', open: false, item: {} }">
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
        <x-ico name="utensils" class="h-4 w-4 text-maroon-500" />
        Ketuk menu untuk melihat foto &amp; detail. Harga belum termasuk PB1 (pajak).
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
                        $photo = $item->primaryImage();
                        $payload = [
                            'name'  => $item->name,
                            'price' => $item->price ? rupiah($item->price) : 'Menyesuaikan',
                            'note'  => $item->price_note,
                            'best'  => (bool) $item->is_best_seller,
                            'cat'   => $category->name,
                            'img'   => $photo ? media_url($photo) : null,
                            'desc'  => $item->short_description ?: trim(strip_tags((string) $item->description)),
                        ];
                    @endphp
                    <button type="button" @click='item = @json($payload); open = true'
                       class="group flex w-full items-center gap-3 border-b border-dashed border-cream-200 py-3 text-left transition hover:border-maroon-300 sm:gap-4">
                        @if($photo)
                            <img src="{{ media_url($photo) }}" alt="{{ $item->name }}" loading="lazy"
                                 class="h-14 w-14 flex-none rounded-xl object-cover shadow-sm ring-1 ring-cream-200 transition group-hover:ring-maroon-300 sm:h-16 sm:w-16" />
                        @else
                            <span class="flex h-14 w-14 flex-none items-center justify-center rounded-xl bg-cream-100 ring-1 ring-cream-200 sm:h-16 sm:w-16">
                                <svg class="h-6 w-6 text-maroon-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v7a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V3M8 12v9M17 3c-1.5 0-3 1.8-3 5s.6 5 3 5m0 0v8"/></svg>
                            </span>
                        @endif
                        <span class="flex flex-1 items-baseline gap-2">
                            <span class="font-medium text-charcoal transition group-hover:text-maroon-700">
                                {{ $item->name }}
                                @if($item->is_best_seller)<span class="ml-1 rounded bg-gold-500/20 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-gold-600 align-middle">Best</span>@endif
                                @if($item->price_note)<span class="ml-1 text-[11px] font-normal text-charcoal/45">· {{ $item->price_note }}</span>@endif
                            </span>
                            <span class="min-w-4 flex-1 translate-y-[-3px] border-b border-dotted border-cream-300"></span>
                            <span class="flex-none font-display text-sm font-bold text-maroon-700">{{ $item->price ? rupiah($item->price) : 'Menyesuaikan' }}</span>
                        </span>
                    </button>
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

    {{-- Popup detail menu (khusus halaman menu / QR scan — tanpa link WhatsApp) --}}
    <div x-cloak x-show="open" @keydown.escape.window="open = false"
         class="fixed inset-0 z-[100] flex items-end justify-center p-0 sm:items-center sm:p-4">
        <div x-show="open" x-transition.opacity @click="open = false"
             class="absolute inset-0 bg-charcoal/70 backdrop-blur-sm"></div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative w-full max-w-md overflow-hidden rounded-t-3xl bg-cream-50 shadow-2xl sm:rounded-3xl">

            <button type="button" @click="open = false" aria-label="Tutup"
                    class="absolute right-3 top-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-charcoal/40 text-cream-50 backdrop-blur transition hover:bg-charcoal/60">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>

            {{-- Foto / placeholder --}}
            <template x-if="item.img">
                <img :src="item.img" :alt="item.name" class="h-60 w-full object-cover" />
            </template>
            <template x-if="!item.img">
                <div class="flex h-40 w-full items-center justify-center bg-gradient-to-br from-cream-100 to-cream-200">
                    <svg class="h-12 w-12 text-maroon-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v7a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V3M8 12v9M17 3c-1.5 0-3 1.8-3 5s.6 5 3 5m0 0v8"/></svg>
                </div>
            </template>

            <div class="p-6">
                <p class="text-[11px] font-semibold uppercase tracking-wide text-gold-600" x-text="item.cat"></p>
                <div class="mt-1 flex items-start justify-between gap-3">
                    <h3 class="font-display text-2xl font-bold text-charcoal" x-text="item.name"></h3>
                    <span x-show="item.best" class="mt-1 flex-none rounded bg-gold-500/20 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-gold-600">Best</span>
                </div>
                <p x-show="item.note" class="mt-1 text-xs text-charcoal/50" x-text="item.note"></p>

                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-3xl font-bold text-maroon-700" x-text="item.price"></span>
                </div>

                <p x-show="item.desc" class="mt-3 text-sm leading-relaxed text-charcoal/70" x-text="item.desc"></p>

                <div class="mt-5 border-t border-cream-200 pt-4 text-[11px] text-charcoal/40">
                    Harga belum termasuk PB1 (pajak). Silakan pesan langsung ke pramusaji.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

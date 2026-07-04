@extends('layouts.public')

@section('content')
@php
    $isPempek = ($content['brand'] ?? '') === 'pempek-tince';
    $brandKey = $isPempek ? 'pempek-tince' : 'pondok-tince';
@endphp

<x-page-hero :eyebrow="$content['eyebrow']"
    :title="$page?->hero_title ?: $content['title']"
    :subtitle="$page?->hero_subtitle ?: $content['subtitle']"
    :image="media_url($page?->hero_image_path)">
    @if($isPempek)
        <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek Palembang." brand="pempek-tince" label="Pesan Pempek via WhatsApp" source="pillar-{{ $slug }}" variant="gold" />
        <a href="{{ route('pempek.paket') }}" class="btn-outline !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15">Lihat Paket Pempek</a>
    @else
        <a href="{{ route('menu') }}" class="btn-gold">Lihat Menu</a>
        <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin booking.'" label="Booking via WhatsApp" source="pillar-{{ $slug }}" />
    @endif
</x-page-hero>

<x-breadcrumbs />

{{-- ============ HIGHLIGHTS STRIP ============ --}}
<section class="border-b border-cream-200 bg-gradient-to-b from-cream-100 to-cream-50">
    <div class="container-x grid grid-cols-2 gap-y-6 py-8 lg:grid-cols-4 lg:gap-y-0">
        @foreach($content['highlights'] as $i => $h)
            <div class="flex items-center gap-3.5 px-1 sm:px-4 lg:justify-center {{ $i > 0 ? 'lg:border-l lg:border-cream-200' : '' }}">
                <x-icon-badge :name="$h['icon']" />
                <span class="font-display text-[15px] font-semibold text-charcoal">{{ $h['text'] }}</span>
            </div>
        @endforeach
    </div>
</section>

{{-- ============ MAIN ARTICLE + STICKY CTA ============ --}}
<section class="container-x py-16 lg:py-20">
    <div class="grid gap-10 lg:grid-cols-3 lg:gap-14">
        {{-- Article --}}
        <article class="lg:col-span-2">
            <div class="prose-content max-w-none text-[16px]">
                @if($page?->intro_content)
                    {!! $page->intro_content !!}
                @else
                    <p class="!text-lg !leading-relaxed !text-charcoal/80">{!! $content['intro'] !!}</p>
                @endif

                @foreach($content['sections'] as $sec)
                    <h2>{{ $sec['h2'] }}</h2>
                    {!! $sec['body'] !!}
                @endforeach
            </div>

            {{-- Internal links inline --}}
            <div class="mt-8 rounded-2xl border border-cream-200 bg-cream-50 p-6">
                <h3 class="flex items-center gap-2 font-display text-lg font-semibold text-charcoal">
                    <x-ico name="arrow-right" class="h-5 w-5 text-gold-600" /> Jelajahi Lebih Lanjut
                </h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($content['links'] as $link)
                        <a href="{{ url($link['path']) }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm font-medium text-charcoal/75 transition hover:border-maroon-500 hover:text-maroon-700">{{ $link['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </article>

        {{-- Sticky CTA sidebar --}}
        <aside class="lg:col-span-1">
            <div class="lg:sticky lg:top-24 space-y-5">
                <div class="relative overflow-hidden rounded-3xl lux-dark p-7 text-cream-50">
                    <div class="pointer-events-none absolute -right-14 -top-14 h-40 w-40 rounded-full bg-gold-500/10 blur-2xl"></div>
                    <x-icon-badge :name="$isPempek ? 'fish' : 'utensils'" size="lg" tone="light" />
                    <h3 class="mt-5 font-display text-xl font-bold text-cream-50">{{ $isPempek ? 'Pesan Pempek Sekarang' : 'Kunjungi Pondok Tince' }}</h3>
                    <p class="mt-2 text-sm text-cream-100/80">{{ $isPempek ? 'Pempek khas Palembang untuk oleh-oleh, frozen, dan pesanan keluarga.' : 'Cita rasa khas Palembang untuk keluarga, rombongan, dan acara.' }}</p>
                    <div class="mt-5 flex flex-col gap-2.5">
                        @if($isPempek)
                            <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan via WhatsApp" source="pillar-{{ $slug }}-side" variant="gold" class="w-full" />
                            <a href="{{ route('pempek.menu') }}" class="btn-outline w-full !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15">Lihat Menu Pempek</a>
                        @else
                            <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin bertanya menu & booking.'" label="Chat via WhatsApp" source="pillar-{{ $slug }}-side" variant="gold" class="w-full" />
                            <a href="{{ route('menu') }}" class="btn-outline w-full !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15">Lihat Menu</a>
                        @endif
                    </div>
                </div>

                {{-- Quick facts --}}
                <div class="rounded-3xl border border-cream-200 bg-white p-6">
                    <h4 class="font-display text-base font-semibold text-charcoal">Info Singkat</h4>
                    <ul class="mt-3 space-y-3 text-sm text-charcoal/70">
                        <li class="flex gap-3"><x-ico name="pin" class="h-5 w-5 flex-none text-gold-600" /><span>{{ $siteSettings->address ?: 'Palembang, Sumatera Selatan' }}</span></li>
                        @if(is_array($siteSettings->opening_hours) && count($siteSettings->opening_hours))
                            <li class="flex gap-3"><x-ico name="clock" class="h-5 w-5 flex-none text-gold-600" /><span>{{ $siteSettings->opening_hours[0]['day'] ?? '' }}: {{ $siteSettings->opening_hours[0]['hours'] ?? '' }}</span></li>
                        @endif
                        <li class="flex gap-3"><x-ico name="chat" class="h-5 w-5 flex-none text-gold-600" /><a href="{{ wa_url('Halo '.$siteSettings->site_name.', saya ingin bertanya.', $brandKey) }}" target="_blank" rel="nofollow" class="hover:text-maroon-700">Chat WhatsApp</a></li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</section>

{{-- ============ FEATURES ============ --}}
<section class="bg-cream-100 py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading eyebrow="Kenapa Kami" :title="$isPempek ? 'Keunggulan Pempek Tince' : 'Kenapa Memilih Pondok Tince'" center />
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($content['features'] as $f)
                <div class="card flex flex-col items-center gap-4 p-7 text-center">
                    <x-icon-badge :name="$f['icon']" size="lg" />
                    <div>
                        <h3 class="font-display text-lg font-semibold text-charcoal">{{ $f['title'] }}</h3>
                        <p class="mt-1.5 text-sm text-charcoal/65">{{ $f['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ MENU HIGHLIGHT ============ --}}
@if($favorites->count())
<section class="container-x py-16 lg:py-20">
    <x-section-heading eyebrow="Menu" :title="$isPempek ? 'Varian Pempek Pilihan' : 'Menu Favorit yang Bisa Dicoba'"
        :subtitle="$isPempek ? 'Pilihan pempek yang paling dicari pelanggan.' : 'Rekomendasi menu favorit untuk memulai.'" center />
    <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
        @foreach($favorites as $item)<x-menu-card :item="$item" source="pillar-{{ $slug }}" />@endforeach
    </div>
    <div class="mt-9 text-center">
        <a href="{{ $isPempek ? route('pempek.menu') : route('menu') }}" class="btn-outline">Lihat Semua Menu →</a>
    </div>
</section>
@endif

{{-- ============ TESTIMONIALS ============ --}}
@if($testimonials->count())
<section class="bg-cream-100 py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading eyebrow="Testimoni" title="Kata Mereka" center />
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($testimonials as $t)
                <figure class="card flex flex-col p-6 lg:p-7">
                    <div class="flex text-gold-500">@for($i=0;$i<($t->rating?:5);$i++)★@endfor</div>
                    <blockquote class="mt-3 flex-1 text-sm leading-relaxed text-charcoal/75">"{{ $t->message }}"</blockquote>
                    <figcaption class="mt-5 flex items-center gap-3 border-t border-cream-200 pt-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-maroon-700/10 font-display font-bold text-maroon-700">{{ mb_substr($t->name, 0, 1) }}</span>
                        <span class="text-sm font-semibold text-charcoal">{{ $t->name }}</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ FAQ (with schema in <head>) ============ --}}
<section class="py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading eyebrow="FAQ" title="Pertanyaan yang Sering Diajukan" center />
        <div class="mx-auto mt-10 max-w-3xl divide-y divide-cream-200 rounded-3xl border border-cream-200 bg-white">
            @foreach($content['faqs'] as $faq)
                <div x-data="{ open: false }" class="p-5 sm:p-6">
                    <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-4 text-left">
                        <span class="font-display text-[15px] font-semibold text-charcoal">{{ $faq['q'] }}</span>
                        <svg class="h-5 w-5 flex-none text-maroon-600 transition" :class="open && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z" clip-rule="evenodd"/></svg>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-3 text-sm leading-relaxed text-charcoal/70">{{ $faq['a'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ FINAL CTA ============ --}}
<section class="lux-dark py-16 text-center text-cream-50 lg:py-20">
    <div class="container-x">
        <div class="ornament mb-5 text-gold-300"></div>
        <h2 class="mx-auto max-w-2xl h-display text-3xl text-cream-50 sm:text-4xl">{{ $isPempek ? 'Pesan Pempek Palembang Sekarang' : 'Kunjungi Pondok Tince Hari Ini' }}</h2>
        <p class="mx-auto mt-4 max-w-xl text-cream-100/80">{{ $isPempek ? 'Untuk oleh-oleh, frozen, atau pesanan keluarga — kami siap membantu.' : 'Nikmati kuliner khas Palembang bersama keluarga dan orang tersayang.' }}</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            @if($isPempek)
                <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan via WhatsApp" source="pillar-{{ $slug }}-final" variant="gold" class="w-full sm:w-auto" />
                <a href="{{ route('pempek.index') }}" class="btn-outline w-full !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15 sm:w-auto">Tentang Pempek Tince</a>
            @else
                <a href="{{ route('menu') }}" class="btn-gold w-full sm:w-auto">Lihat Menu</a>
                <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin booking meja.'" label="Booking via WhatsApp" source="pillar-{{ $slug }}-final" class="w-full sm:w-auto" />
            @endif
        </div>
    </div>
</section>
@endsection

@extends('layouts.public')

@section('content')
@php
    // Konten editable dari admin (Halaman > Pempek Tince > tab "Keunggulan & Langkah"),
    // dengan fallback default agar tetap tampil rapi bila belum diisi.
    $features = (is_array($page?->features) && count($page->features)) ? $page->features : [
        ['icon' => 'fish', 'title' => 'Ikan Berkualitas'],
        ['icon' => 'fire', 'title' => 'Rasa Khas Palembang'],
        ['icon' => 'gift', 'title' => 'Cocok untuk Oleh-Oleh'],
        ['icon' => 'chat', 'title' => 'Bisa Pesan Online'],
        ['icon' => 'snowflake', 'title' => 'Tersedia Frozen'],
    ];
    $steps = (is_array($page?->steps) && count($page->steps)) ? $page->steps : [
        ['title' => 'Pilih menu / paket'],
        ['title' => 'Klik WhatsApp'],
        ['title' => 'Konfirmasi stok & pengiriman'],
        ['title' => 'Pembayaran'],
        ['title' => 'Pesanan diproses'],
    ];
@endphp
<x-page-hero eyebrow="Pempek Tince Palembang"
    :title="$page?->hero_title ?: 'Pempek Tince Palembang untuk Oleh-Oleh, Frozen, dan Pesanan Online'"
    :subtitle="$page?->hero_subtitle ?: 'Pempek khas Palembang untuk oleh-oleh, frozen, dan pesanan keluarga. Pesan online, bisa kirim luar kota.'"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek" source="pempek-hero" variant="gold" />
    <a href="{{ route('pempek.paket') }}" class="btn-outline !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15">Lihat Paket</a>
</x-page-hero>

<x-breadcrumbs />

{{-- Brand story --}}
<section class="container-x py-16 lg:py-20">
    <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
        <div class="prose-content">
            @if($page?->intro_content)
                {!! $page->intro_content !!}
            @else
                <div class="flex items-center gap-3"><span class="keyline"></span><span class="eyebrow">Cerita Kami</span></div>
                <h2>Pempek Palembang dengan Cita Rasa Khas</h2>
                <p>Pempek Tince adalah bagian dari keluarga Pondok Tince, menghadirkan pempek Palembang untuk dinikmati di rumah, dibagikan sebagai oleh-oleh, atau disimpan sebagai stok frozen.</p>
                <p>Kami berkomitmen menjaga rasa khas Palembang di setiap gigitan, agar bisa dinikmati keluarga di mana saja.</p>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-4">
            @forelse($variants->take(4) as $v)
                <div class="aspect-square overflow-hidden rounded-2xl bg-cream-100">
                    @if($v->image_path)<img src="{{ media_url($v->image_path) }}" alt="{{ $v->image_alt ?: $v->name }}" loading="lazy" class="h-full w-full object-cover">
                    @else<div class="placeholder-food"><x-ico name="fish" class="h-10 w-10 opacity-70" /></div>@endif
                </div>
            @empty
                <div class="col-span-2 flex aspect-video items-center justify-center rounded-2xl bg-cream-100"><x-ico name="fish" class="h-12 w-12 text-maroon-300" /></div>
            @endforelse
        </div>
    </div>
</section>

{{-- Keunggulan (editable dari admin) --}}
<section class="bg-cream-100 py-16 lg:py-24">
    <div class="container-x">
        <x-section-heading eyebrow="Keunggulan" title="Kenapa Pempek Tince" center />
        <div class="mt-12 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-5">
            @foreach($features as $k)
                <div class="group flex flex-col items-center gap-4 rounded-2xl border border-cream-200/80 bg-white p-6 text-center transition duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-[0_20px_40px_-22px_rgba(74,22,21,0.4)]">
                    <x-icon-badge :name="$k['icon'] ?? 'star'" size="lg" />
                    <span class="text-sm font-semibold leading-snug text-charcoal/80">{{ $k['title'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Varian --}}
@if($variants->count())
<section class="container-x py-16 lg:py-20">
    <div class="flex flex-col items-center gap-5 text-center sm:flex-row sm:items-end sm:justify-between sm:text-left">
        <x-section-heading eyebrow="Varian" title="Varian Pempek" />
        <a href="{{ route('pempek.menu') }}" class="btn-outline !py-2.5 text-xs">Lihat Menu Lengkap →</a>
    </div>
    <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
        @foreach($variants as $item)<x-menu-card :item="$item" source="pempek-varian" />@endforeach
    </div>
</section>
@endif

{{-- Paket --}}
@if($packages->count())
<section class="bg-cream-100 py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading eyebrow="Paket Pempek" title="Paket untuk Keluarga & Oleh-Oleh" center />
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($packages as $pkg)<x-package-card :package="$pkg" source="pempek-paket" />@endforeach
        </div>
    </div>
</section>
@endif

{{-- Cara order (editable dari admin) --}}
<section class="container-x py-16 lg:py-24">
    <x-section-heading eyebrow="Cara Order" :title="'Mudah Pesan dalam '.count($steps).' Langkah'" center />
    <div class="relative mt-12">
        {{-- garis penghubung (desktop) --}}
        <div class="pointer-events-none absolute left-0 right-0 top-6 hidden h-px bg-gradient-to-r from-transparent via-gold-300/60 to-transparent lg:block"></div>
        <div class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-5">
            @foreach($steps as $n => $step)
                <div class="relative flex flex-col items-center text-center">
                    <span class="relative z-10 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-maroon-700 to-maroon-900 font-display text-lg font-bold text-gold-300 ring-4 ring-cream-50">{{ $n + 1 }}</span>
                    <p class="mt-3 max-w-[10rem] text-sm font-medium text-charcoal/80">{{ is_array($step) ? ($step['title'] ?? '') : $step }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-12 text-center">
        <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek Sekarang" source="pempek-cara" variant="gold" />
    </div>
</section>

<x-faq-list :faqs="$faqs" title="FAQ Pempek Tince" eyebrow="Pertanyaan Umum" />

<section class="lux-dark py-16 text-center text-cream-50 lg:py-20">
    <div class="container-x">
        <div class="ornament mb-5 text-gold-300"></div>
        <h2 class="mx-auto max-w-2xl h-display text-3xl text-cream-50 sm:text-4xl">Pesan Pempek Tince Sekarang</h2>
        <p class="mx-auto mt-4 max-w-xl text-cream-100/80">Untuk oleh-oleh, frozen, atau pesanan keluarga — hubungi kami via WhatsApp.</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan via WhatsApp" source="pempek-final" variant="gold" class="w-full sm:w-auto" />
            <a href="{{ url('/pempek-palembang') }}" class="btn-outline w-full !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15 sm:w-auto">Pempek Palembang</a>
        </div>
    </div>
</section>
@endsection

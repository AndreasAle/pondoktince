@extends('layouts.public')

@section('content')
@php
    $s = $siteSettings;
    $heroTitle = $page?->hero_title ?: 'Nikmati Cita Rasa Palembang di Pondok Tince';
    $heroSub = $page?->hero_subtitle ?: 'Tempat makan khas Palembang untuk keluarga, tamu luar kota, acara, dan pemesanan menu favorit. Terhubung juga dengan Pempek Tince untuk oleh-oleh dan pesanan pempek.';
    $heroImg = media_url($page?->hero_image_path);
    $pondok = $brands['pondok-tince'] ?? null;
    $pempek = $brands['pempek-tince'] ?? null;
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden bg-maroon-900 text-cream-50">
    @if($heroImg)
        <img src="{{ $heroImg }}" alt="{{ $heroTitle }}" class="absolute inset-0 h-full w-full object-cover opacity-35">
    @endif
    <div class="absolute inset-0 bg-gradient-to-br from-maroon-900 via-maroon-900/85 to-maroon-800/70"></div>

    <div class="container-x relative py-20 lg:py-28">
        <div class="max-w-2xl">
            <span class="eyebrow text-gold-300">Kuliner Khas Palembang</span>
            <h1 class="mt-3 h-display text-4xl text-cream-50 sm:text-5xl lg:text-6xl">{{ $heroTitle }}</h1>
            <p class="mt-5 max-w-xl text-base text-cream-100/85 sm:text-lg">{{ $heroSub }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('menu') }}" class="btn-gold">Lihat Menu</a>
                <x-wa-button :message="'Halo '.$s->site_name.', saya ingin booking tempat.'" label="Booking via WhatsApp" source="home-hero" />
                <a href="{{ route('pempek.index') }}" class="btn-outline !border-cream-100/30 !bg-white/10 !text-cream-50 hover:!bg-white/20">Pesan Pempek Tince</a>
            </div>
        </div>
    </div>
</section>

{{-- QUICK INFO BAR --}}
<section class="border-b border-cream-200 bg-cream-100">
    <div class="container-x grid grid-cols-2 gap-4 py-6 text-sm md:grid-cols-4">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🕑</span>
            <div><span class="block font-semibold text-charcoal">Jam Buka</span>
                <span class="text-charcoal/60">{{ is_array($s->opening_hours) && count($s->opening_hours) ? ($s->opening_hours[0]['hours'] ?? 'Cek lokasi') : 'Setiap hari' }}</span></div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-2xl">📍</span>
            <div><span class="block font-semibold text-charcoal">Lokasi</span>
                <a href="{{ route('lokasi') }}" class="text-charcoal/60 hover:text-maroon-700">Palembang — lihat peta</a></div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-2xl">💬</span>
            <div><span class="block font-semibold text-charcoal">WhatsApp</span>
                <a href="{{ wa_url('Halo '.$s->site_name.', saya ingin bertanya.') }}" target="_blank" rel="nofollow" class="text-charcoal/60 hover:text-maroon-700">Chat admin</a></div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-2xl">🍽️</span>
            <div><span class="block font-semibold text-charcoal">Layanan</span>
                <span class="text-charcoal/60">Dine-in · Take away · Booking</span></div>
        </div>
    </div>
</section>

{{-- BRAND ECOSYSTEM --}}
<section class="py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading eyebrow="Satu Ekosistem" title="Satu Rasa, Dua Pengalaman"
            subtitle="Pondok Tince hadir sebagai tempat makan khas Palembang yang nyaman untuk keluarga, tamu luar kota, dan acara. Pempek Tince hadir sebagai pilihan pempek Palembang untuk oleh-oleh, frozen, dan pemesanan online."
            center />

        <div class="mt-10 grid gap-6 md:grid-cols-2">
            {{-- Pondok --}}
            <div class="card flex flex-col overflow-hidden">
                <div class="aspect-[16/9] bg-cream-100">
                    @if($pondok?->logo_path)<img src="{{ media_url($pondok->logo_path) }}" alt="Pondok Tince" class="h-full w-full object-cover">
                    @else<div class="flex h-full items-center justify-center font-display text-2xl text-maroon-700">Pondok Tince</div>@endif
                </div>
                <div class="flex flex-1 flex-col p-6">
                    <h3 class="font-display text-2xl font-bold text-charcoal">Pondok Tince</h3>
                    <p class="mt-2 flex-1 text-sm text-charcoal/70">{{ $pondok?->description ?: 'Tempat makan khas Palembang untuk dine-in bersama keluarga, rombongan, dan acara. Menu lengkap dengan cita rasa autentik.' }}</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('menu') }}" class="btn-primary !py-2.5 text-xs">Lihat Menu Pondok Tince</a>
                        <a href="{{ route('paket-acara') }}" class="btn-outline !py-2.5 text-xs">Paket Acara</a>
                    </div>
                </div>
            </div>
            {{-- Pempek --}}
            <div class="card flex flex-col overflow-hidden">
                <div class="aspect-[16/9] bg-cream-100">
                    @if($pempek?->logo_path)<img src="{{ media_url($pempek->logo_path) }}" alt="Pempek Tince" class="h-full w-full object-cover">
                    @else<div class="flex h-full items-center justify-center font-display text-2xl text-maroon-700">Pempek Tince</div>@endif
                </div>
                <div class="flex flex-1 flex-col p-6">
                    <h3 class="font-display text-2xl font-bold text-charcoal">Pempek Tince</h3>
                    <p class="mt-2 flex-1 text-sm text-charcoal/70">{{ $pempek?->description ?: 'Pempek khas Palembang untuk oleh-oleh, frozen, dan pemesanan online. Praktis dikirim ke luar kota untuk keluarga di rumah.' }}</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('pempek.index') }}" class="btn-primary !py-2.5 text-xs">Lihat Pempek Tince</a>
                        <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek" source="home-brand" class="!py-2.5 text-xs" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MENU FAVORIT --}}
@if($favorites->count())
<section class="bg-cream-100 py-16 lg:py-20">
    <div class="container-x">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading eyebrow="Menu Favorit" title="Yang Paling Dicari" subtitle="Pilihan menu favorit pelanggan Pondok Tince." />
            <a href="{{ route('menu') }}" class="btn-outline !py-2.5 text-xs">Lihat Semua Menu</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
            @foreach($favorites as $item)
                <x-menu-card :item="$item" source="home-favorit" />
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEO INTRO --}}
<section class="py-16 lg:py-20">
    <div class="container-x grid gap-8 lg:grid-cols-2 lg:items-center">
        <div class="prose-content">
            @if($page?->intro_content)
                {!! $page->intro_content !!}
            @else
                <span class="eyebrow">Kuliner Palembang</span>
                <h2>Tempat Makan Khas Palembang untuk Keluarga & Tamu Luar Kota</h2>
                <p>Mencari <strong>kuliner Palembang</strong> yang nyaman untuk makan bersama keluarga? Pondok Tince menyajikan <strong>makanan enak Palembang</strong> dengan suasana hangat, cocok untuk keseharian maupun acara spesial.</p>
                <p>Untuk penikmat <strong>pempek Palembang</strong>, Pempek Tince menghadirkan pempek berkualitas untuk oleh-oleh, frozen, dan pemesanan online yang bisa dikirim ke luar kota.</p>
            @endif
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ url('/kuliner-palembang') }}" class="btn-outline !py-2.5 text-xs">Kuliner Palembang</a>
                <a href="{{ url('/pempek-palembang') }}" class="btn-outline !py-2.5 text-xs">Pempek Palembang</a>
                <a href="{{ url('/makanan-enak-palembang') }}" class="btn-outline !py-2.5 text-xs">Makanan Enak Palembang</a>
            </div>
        </div>
        <div class="rounded-2xl bg-maroon-800 p-8 text-cream-50">
            <h3 class="font-display text-2xl font-bold">Cocok untuk Acara Anda</h3>
            <p class="mt-2 text-cream-100/80">Arisan, meeting kantor, acara keluarga, hingga menjamu rombongan tamu luar kota — Pondok Tince siap membantu.</p>
            <ul class="mt-4 space-y-2 text-sm text-cream-100/85">
                <li>• Kapasitas fleksibel untuk rombongan</li>
                <li>• Menu keluarga & paket acara</li>
                <li>• Lokasi strategis di Palembang</li>
            </ul>
            <div class="mt-6"><a href="{{ route('paket-acara') }}" class="btn-gold">Lihat Paket Acara</a></div>
        </div>
    </div>
</section>

{{-- GALLERY --}}
@if($gallery->count())
<section class="bg-cream-100 py-16">
    <div class="container-x">
        <x-section-heading eyebrow="Galeri" title="Suasana & Sajian Kami" center />
        <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($gallery as $g)
                <div class="group aspect-square overflow-hidden rounded-xl bg-cream-200">
                    <img src="{{ media_url($g->image_path) }}" alt="{{ $g->alt_text ?: 'Galeri Pondok Tince' }}" loading="lazy"
                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                </div>
            @endforeach
        </div>
        <div class="mt-8 text-center"><a href="{{ route('galeri') }}" class="btn-outline">Lihat Galeri Lengkap</a></div>
    </div>
</section>
@endif

{{-- TESTIMONIALS --}}
@if($testimonials->count())
<section class="py-16 lg:py-20">
    <div class="container-x">
        <x-section-heading eyebrow="Testimoni" title="Kata Mereka tentang Kami" center />
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($testimonials as $t)
                <figure class="card p-6">
                    <div class="flex text-gold-500">
                        @for($i = 0; $i < ($t->rating ?: 5); $i++)★@endfor
                    </div>
                    <blockquote class="mt-3 text-sm leading-relaxed text-charcoal/75">"{{ $t->message }}"</blockquote>
                    <figcaption class="mt-4 text-sm font-semibold text-charcoal">{{ $t->name }}
                        @if($t->source)<span class="font-normal text-charcoal/50"> · {{ $t->source }}</span>@endif
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LOCATION --}}
<section class="bg-cream-100 py-16">
    <div class="container-x grid gap-8 lg:grid-cols-2 lg:items-center">
        <div>
            <x-section-heading eyebrow="Lokasi" title="Kunjungi Pondok Tince" />
            <p class="mt-3 text-charcoal/70">{{ $s->address ?: 'Alamat lengkap akan tampil di sini setelah diisi dari admin panel.' }}</p>
            <div class="mt-6 flex flex-wrap gap-3">
                @if($s->maps_link)<a href="{{ $s->maps_link }}" target="_blank" rel="noopener" class="btn-primary">Buka Google Maps</a>@endif
                <a href="{{ route('lokasi') }}" class="btn-outline">Detail Lokasi & Jam Buka</a>
            </div>
        </div>
        <div class="overflow-hidden rounded-2xl border border-cream-200 bg-white shadow-sm">
            @if($s->maps_embed)
                <iframe src="{{ $s->maps_embed }}" class="h-72 w-full" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Lokasi Pondok Tince"></iframe>
            @else
                <div class="flex h-72 items-center justify-center text-charcoal/40">Peta lokasi (atur embed di admin)</div>
            @endif
        </div>
    </div>
</section>

{{-- FINAL CTA --}}
<section class="bg-maroon-800 py-16 text-center text-cream-50">
    <div class="container-x">
        <h2 class="h-display text-3xl text-cream-50 sm:text-4xl">Mau makan di Pondok Tince atau pesan Pempek Tince?</h2>
        <p class="mx-auto mt-3 max-w-xl text-cream-100/80">Kami siap membantu, dari reservasi meja hingga pesanan pempek untuk keluarga dan oleh-oleh.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <x-wa-button :message="'Halo '.$s->site_name.', saya ingin bertanya menu & booking.'" label="Chat Pondok Tince" source="home-final" />
            <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek Tince" source="home-final" variant="gold" />
        </div>
    </div>
</section>
@endsection

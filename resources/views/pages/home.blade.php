@extends('layouts.public')

@section('content')
@php
    $s = $siteSettings;
    $heroTitle = $page?->hero_title ?: 'Rasa Rumahan Khas Palembang, Disajikan Istimewa';
    $heroSub = $page?->hero_subtitle ?: 'Pondok Tince menghadirkan kehangatan masakan Palembang untuk keluarga, tamu luar kota, dan acara spesial. Bersama Pempek Tince untuk oleh-oleh, frozen, dan pesanan pempek.';
    $heroImg = media_url($page?->hero_image_path);
    $pondok = $brands['pondok-tince'] ?? null;
    $pempek = $brands['pempek-tince'] ?? null;
    $jam = is_array($s->opening_hours) && count($s->opening_hours) ? ($s->opening_hours[0]['hours'] ?? 'Setiap hari') : 'Setiap hari';
@endphp

{{-- ================= HERO CAROUSEL ================= --}}
@if($heroSlides->count())
<section
    x-data="{
        active: 0,
        count: {{ $heroSlides->count() }},
        timer: null,
        start() { if (this.count > 1) this.timer = setInterval(() => this.next(), 6500); },
        stop() { clearInterval(this.timer); },
        next() { this.active = (this.active + 1) % this.count; },
        prev() { this.active = (this.active - 1 + this.count) % this.count; },
        go(i) { this.active = i; },
    }"
    x-init="start()"
    @mouseenter="stop()" @mouseleave="start()"
    class="relative overflow-hidden lux-dark text-cream-50">

    {{-- soft gold glow accents --}}
    <div class="pointer-events-none absolute -right-24 -top-24 z-20 h-72 w-72 rounded-full bg-gold-500/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 left-1/4 z-20 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>

    <div class="grid">
        @foreach($heroSlides as $i => $slide)
            @php $img = media_url($slide->image_path); @endphp
            <div class="relative col-start-1 row-start-1 transition-opacity duration-1000 ease-out"
                 :class="active === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'">

                @if($img)
                    <img src="{{ $img }}" alt="{{ $slide->image_alt ?: $slide->title }}"
                         class="absolute inset-0 h-full w-full object-cover transition-transform ease-out"
                         style="transition-duration: 8000ms;"
                         :class="active === {{ $i }} ? 'scale-110' : 'scale-100'">
                @endif

                {{-- overlay merah premium (selalu ada agar tetap bernuansa merah & teks terbaca) --}}
                <div class="absolute inset-0 bg-gradient-to-br from-maroon-900/95 via-maroon-900/80 to-maroon-800/55"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-maroon-900/70 via-transparent to-transparent"></div>

                <div class="relative container-x py-24 sm:py-28 lg:py-36">
                    <div class="mx-auto max-w-3xl text-center">
                        @if($slide->eyebrow)
                            <div class="ornament mb-5 text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">{{ $slide->eyebrow }}</div>
                        @endif
                        <h1 class="h-display text-4xl leading-[1.1] text-cream-50 sm:text-5xl lg:text-6xl">{{ $slide->title }}</h1>
                        @if($slide->subtitle)
                            <p class="mx-auto mt-6 max-w-xl text-base leading-relaxed text-cream-100/85 sm:text-lg">{{ $slide->subtitle }}</p>
                        @endif
                        <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row sm:flex-wrap">
                            @if($slide->primary_label && $slide->primary_url)
                                <a href="{{ $slide->primary_url }}" class="btn-gold w-full sm:w-auto">{{ $slide->primary_label }}</a>
                            @endif
                            @if($slide->show_whatsapp)
                                <x-wa-button :message="$slide->whatsapp_message ?: ('Halo '.$siteSettings->site_name.', saya ingin bertanya.')" label="Booking via WhatsApp" source="home-hero" class="w-full sm:w-auto" />
                            @endif
                            @if($slide->secondary_label && $slide->secondary_url)
                                <a href="{{ $slide->secondary_url }}" class="btn-outline w-full !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15 sm:w-auto">{{ $slide->secondary_label }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($heroSlides->count() > 1)
        {{-- arrows --}}
        <button @click="prev()" aria-label="Slide sebelumnya"
                class="absolute left-3 top-1/2 z-20 -translate-y-1/2 rounded-full border border-cream-100/20 bg-black/25 p-2.5 backdrop-blur transition hover:bg-black/45 sm:left-5">
            <svg class="h-5 w-5 text-cream-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" aria-label="Slide berikutnya"
                class="absolute right-3 top-1/2 z-20 -translate-y-1/2 rounded-full border border-cream-100/20 bg-black/25 p-2.5 backdrop-blur transition hover:bg-black/45 sm:right-5">
            <svg class="h-5 w-5 text-cream-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- dots --}}
        <div class="absolute bottom-6 left-1/2 z-20 flex -translate-x-1/2 gap-2">
            @foreach($heroSlides as $i => $slide)
                <button @click="go({{ $i }})" aria-label="Ke slide {{ $i + 1 }}"
                        class="h-2 rounded-full transition-all duration-300"
                        :class="active === {{ $i }} ? 'w-7 bg-gold-400' : 'w-2 bg-cream-100/40 hover:bg-cream-100/70'"></button>
            @endforeach
        </div>
    @endif
</section>
@else
    {{-- Fallback bila belum ada slide (semua dihapus dari admin) --}}
    <section class="relative overflow-hidden lux-dark py-24 text-center text-cream-50 sm:py-28">
        <div class="container-x mx-auto max-w-3xl">
            <h1 class="h-display text-4xl text-cream-50 sm:text-5xl lg:text-6xl">{{ $heroTitle }}</h1>
            <p class="mx-auto mt-6 max-w-xl text-cream-100/85">{{ $heroSub }}</p>
            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('menu') }}" class="btn-gold w-full sm:w-auto">Lihat Menu Kami</a>
                <x-wa-button :message="'Halo '.$s->site_name.', saya ingin booking tempat.'" label="Booking via WhatsApp" source="home-hero" class="w-full sm:w-auto" />
            </div>
        </div>
    </section>
@endif

{{-- ================= QUICK INFO BAR ================= --}}
<section class="border-b border-cream-200 bg-cream-100">
    <div class="container-x grid grid-cols-2 divide-cream-200 py-6 text-sm sm:divide-x lg:grid-cols-4">
        @foreach([
            ['🕑','Jam Buka', $jam],
            ['📍','Lokasi', 'Palembang'],
            ['💬','WhatsApp', 'Chat admin'],
            ['🍽️','Layanan', 'Dine-in · Take away'],
        ] as $i => $info)
            <div class="flex items-center gap-3 px-2 py-2 {{ $i % 2 === 0 ? 'sm:pl-0' : '' }} lg:justify-center">
                <span class="text-2xl">{{ $info[0] }}</span>
                <div>
                    <span class="block text-xs uppercase tracking-wide text-charcoal/45">{{ $info[1] }}</span>
                    @if($info[1] === 'Lokasi')
                        <a href="{{ route('lokasi') }}" class="font-semibold text-charcoal hover:text-maroon-700">{{ $info[2] }}</a>
                    @elseif($info[1] === 'WhatsApp')
                        <a href="{{ wa_url('Halo '.$s->site_name.', saya ingin bertanya.') }}" target="_blank" rel="nofollow" class="font-semibold text-charcoal hover:text-maroon-700">{{ $info[2] }}</a>
                    @else
                        <span class="font-semibold text-charcoal">{{ $info[2] }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ================= BRAND ECOSYSTEM ================= --}}
<section class="py-16 lg:py-24">
    <div class="container-x">
        <x-section-heading eyebrow="Satu Ekosistem" title="Satu Rasa, Dua Pengalaman"
            subtitle="Pondok Tince untuk pengalaman makan di tempat yang hangat bersama keluarga dan acara. Pempek Tince untuk oleh-oleh, frozen, dan pemesanan online khas Palembang."
            center />

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:gap-8">
            {{-- Pondok --}}
            <div class="card group flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden">
                    @if($pondok?->logo_path)
                        <img src="{{ media_url($pondok->logo_path) }}" alt="Pondok Tince" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="placeholder-food">
                            <span class="flex h-16 w-16 items-center justify-center rounded-full border border-gold-400/50 font-display text-2xl text-maroon-600">PT</span>
                        </div>
                    @endif
                    <span class="absolute left-4 top-4 rounded-full bg-cream-50/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-maroon-700">Rumah Makan</span>
                </div>
                <div class="flex flex-1 flex-col p-6 lg:p-7">
                    <h3 class="font-display text-2xl font-bold text-charcoal">Pondok Tince</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-charcoal/70">{{ $pondok?->description ?: 'Tempat makan khas Palembang untuk dine-in bersama keluarga, rombongan, dan acara. Cita rasa autentik dengan suasana yang hangat.' }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('menu') }}" class="btn-primary !py-2.5 text-xs">Lihat Menu</a>
                        <a href="{{ route('paket-acara') }}" class="btn-outline !py-2.5 text-xs">Paket Acara</a>
                    </div>
                </div>
            </div>
            {{-- Pempek --}}
            <div class="card group flex flex-col overflow-hidden">
                <div class="relative aspect-[16/10] overflow-hidden">
                    @if($pempek?->logo_path)
                        <img src="{{ media_url($pempek->logo_path) }}" alt="Pempek Tince" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="placeholder-food">
                            <span class="flex h-16 w-16 items-center justify-center rounded-full border border-gold-400/50 font-display text-2xl text-maroon-600">PT</span>
                        </div>
                    @endif
                    <span class="absolute left-4 top-4 rounded-full bg-cream-50/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-maroon-700">Oleh-oleh &amp; Frozen</span>
                </div>
                <div class="flex flex-1 flex-col p-6 lg:p-7">
                    <h3 class="font-display text-2xl font-bold text-charcoal">Pempek Tince</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-charcoal/70">{{ $pempek?->description ?: 'Pempek khas Palembang untuk oleh-oleh, frozen, dan pemesanan online. Praktis dikirim ke luar kota untuk keluarga di rumah.' }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('pempek.index') }}" class="btn-primary !py-2.5 text-xs">Lihat Pempek Tince</a>
                        <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek" source="home-brand" class="!py-2.5 text-xs" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= MENU FAVORIT ================= --}}
@if($favorites->count())
<section class="bg-cream-100 py-16 lg:py-24">
    <div class="container-x">
        <div class="flex flex-col items-center gap-6 text-center sm:flex-row sm:items-end sm:justify-between sm:text-left">
            <x-section-heading eyebrow="Menu Favorit" title="Yang Paling Dicari"
                subtitle="Pilihan menu favorit pelanggan yang wajib dicoba saat berkunjung." />
            <a href="{{ route('menu') }}" class="btn-outline !py-2.5 text-xs">Lihat Semua Menu →</a>
        </div>
        <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
            @foreach($favorites as $item)
                <x-menu-card :item="$item" source="home-favorit" />
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================= SEO INTRO / STORY ================= --}}
<section class="py-16 lg:py-24">
    <div class="container-x grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-14">
        <div class="prose-content">
            @if($page?->intro_content)
                {!! $page->intro_content !!}
            @else
                <div class="flex items-center gap-3"><span class="keyline"></span><span class="eyebrow">Kuliner Palembang</span></div>
                <h2>Tempat Makan Khas Palembang untuk Keluarga &amp; Tamu Luar Kota</h2>
                <p>Mencari <strong>kuliner Palembang</strong> yang nyaman untuk makan bersama keluarga? Pondok Tince menyajikan <strong>makanan enak Palembang</strong> dengan suasana hangat, cocok untuk keseharian maupun acara spesial.</p>
                <p>Untuk penikmat <strong>pempek Palembang</strong>, Pempek Tince menghadirkan pempek berkualitas untuk oleh-oleh, frozen, dan pemesanan online yang bisa dikirim ke luar kota.</p>
            @endif
            <div class="mt-6 flex flex-wrap gap-2.5">
                <a href="{{ url('/kuliner-palembang') }}" class="btn-outline !py-2.5 text-xs">Kuliner Palembang</a>
                <a href="{{ url('/pempek-palembang') }}" class="btn-outline !py-2.5 text-xs">Pempek Palembang</a>
                <a href="{{ url('/makanan-enak-palembang') }}" class="btn-outline !py-2.5 text-xs">Makanan Enak Palembang</a>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-3xl lux-dark p-8 text-cream-50 lg:p-10">
            <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gold-500/10 blur-2xl"></div>
            <span class="eyebrow text-gold-300">Untuk Acara Anda</span>
            <h3 class="mt-2 font-display text-2xl font-bold text-cream-50 sm:text-3xl">Ruang Hangat untuk Setiap Momen</h3>
            <p class="mt-3 text-cream-100/80">Arisan, meeting kantor, acara keluarga, hingga menjamu rombongan tamu luar kota — kami siap membantu.</p>
            <ul class="mt-5 space-y-2.5 text-sm text-cream-100/85">
                <li class="flex items-center gap-2"><span class="text-gold-400">✦</span> Kapasitas fleksibel untuk rombongan</li>
                <li class="flex items-center gap-2"><span class="text-gold-400">✦</span> Menu keluarga &amp; paket acara</li>
                <li class="flex items-center gap-2"><span class="text-gold-400">✦</span> Lokasi strategis di Palembang</li>
            </ul>
            <div class="mt-7"><a href="{{ route('paket-acara') }}" class="btn-gold">Lihat Paket Acara</a></div>
        </div>
    </div>
</section>

{{-- ================= GALLERY ================= --}}
@if($gallery->count())
<section class="bg-cream-100 py-16 lg:py-24">
    <div class="container-x">
        <x-section-heading eyebrow="Galeri" title="Suasana &amp; Sajian Kami" center />
        <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($gallery as $g)
                <div class="group aspect-square overflow-hidden rounded-2xl bg-cream-200">
                    <img src="{{ media_url($g->image_path) }}" alt="{{ $g->alt_text ?: 'Galeri Pondok Tince' }}" loading="lazy"
                         class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                </div>
            @endforeach
        </div>
        <div class="mt-10 text-center"><a href="{{ route('galeri') }}" class="btn-outline">Lihat Galeri Lengkap</a></div>
    </div>
</section>
@endif

{{-- ================= TESTIMONIALS ================= --}}
@if($testimonials->count())
<section class="py-16 lg:py-24">
    <div class="container-x">
        <x-section-heading eyebrow="Testimoni" title="Kata Mereka tentang Kami" center />
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($testimonials as $t)
                <figure class="card flex flex-col p-6 lg:p-7">
                    <svg class="h-8 w-8 text-gold-400/60" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.5 6C5 6 3 8 3 10.5S5 15 7.5 15c.2 0 .4 0 .6-.05C7.5 16.5 6.3 17.5 5 18l.8 1.6C8.6 18.4 10.5 15.7 10.5 12v-1.5C10.5 8 8.5 6 7.5 6zm9 0C14 6 12 8 12 10.5S14 15 16.5 15c.2 0 .4 0 .6-.05C16.5 16.5 15.3 17.5 14 18l.8 1.6c2.8-1.2 4.7-3.9 4.7-7.6v-1.5C19.5 8 17.5 6 16.5 6z"/></svg>
                    <blockquote class="mt-3 flex-1 text-sm leading-relaxed text-charcoal/75">{{ $t->message }}</blockquote>
                    <figcaption class="mt-5 flex items-center gap-3 border-t border-cream-200 pt-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-maroon-700/10 font-display font-bold text-maroon-700">{{ mb_substr($t->name, 0, 1) }}</span>
                        <span>
                            <span class="block text-sm font-semibold text-charcoal">{{ $t->name }}</span>
                            <span class="flex text-xs text-gold-500">@for($i = 0; $i < ($t->rating ?: 5); $i++)★@endfor</span>
                        </span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================= LOCATION ================= --}}
<section class="bg-cream-100 py-16 lg:py-24">
    <div class="container-x grid gap-10 lg:grid-cols-2 lg:items-center">
        <div>
            <x-section-heading eyebrow="Lokasi" title="Mampir &amp; Rasakan Kehangatannya" />
            <p class="mt-4 text-charcoal/70">{{ $s->address ?: 'Alamat lengkap akan tampil di sini setelah diisi dari admin panel.' }}</p>
            <div class="mt-7 flex flex-wrap gap-3">
                @if($s->maps_link)<a href="{{ $s->maps_link }}" target="_blank" rel="noopener" class="btn-primary">Buka Google Maps</a>@endif
                <a href="{{ route('lokasi') }}" class="btn-outline">Lokasi &amp; Jam Buka</a>
            </div>
        </div>
        <div class="overflow-hidden rounded-3xl border border-cream-200 bg-white shadow-sm">
            @if($s->maps_embed)
                <iframe src="{{ $s->maps_embed }}" class="h-72 w-full lg:h-80" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Lokasi Pondok Tince"></iframe>
            @else
                <div class="placeholder-food h-72 lg:h-80 !text-charcoal/40">Peta lokasi (atur embed di admin)</div>
            @endif
        </div>
    </div>
</section>

{{-- ================= FINAL CTA ================= --}}
<section class="lux-dark py-16 text-center text-cream-50 lg:py-24">
    <div class="container-x">
        <div class="ornament mb-5 text-gold-300"></div>
        <h2 class="mx-auto max-w-2xl h-display text-3xl text-cream-50 sm:text-4xl">Mau makan di Pondok Tince atau pesan Pempek Tince?</h2>
        <p class="mx-auto mt-4 max-w-xl text-cream-100/80">Kami siap membantu, dari reservasi meja hingga pesanan pempek untuk keluarga dan oleh-oleh.</p>
        <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row sm:flex-wrap">
            <x-wa-button :message="'Halo '.$s->site_name.', saya ingin bertanya menu & booking.'" label="Chat Pondok Tince" source="home-final" class="w-full sm:w-auto" />
            <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek Tince" source="home-final" variant="gold" class="w-full sm:w-auto" />
        </div>
    </div>
</section>
@endsection

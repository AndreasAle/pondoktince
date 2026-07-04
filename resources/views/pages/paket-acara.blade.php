@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Paket Acara"
    :title="$page?->hero_title ?: 'Tempat Makan untuk Acara & Rombongan di Palembang'"
    :subtitle="$page?->hero_subtitle ?: 'Cocok untuk arisan, meeting kantor, acara keluarga, dan rombongan tamu luar kota.'"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button message="Halo Pondok Tince, saya ingin konsultasi acara." label="Konsultasi Acara via WhatsApp" source="acara-hero" variant="gold" />
</x-page-hero>

<x-breadcrumbs />

{{-- Jenis acara --}}
<section class="container-x py-16 lg:py-20">
    <x-section-heading eyebrow="Cocok Untuk" title="Berbagai Jenis Acara" center />
    <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-6">
        @foreach([
            ['users','Makan Keluarga'],
            ['calendar','Meeting Kantor'],
            ['heart','Arisan'],
            ['route','Tamu Luar Kota'],
            ['sparkle','Acara Kecil'],
            ['sofa','Rombongan'],
        ] as $j)
            <div class="card flex flex-col items-center gap-3 p-5 text-center">
                <x-icon-badge :name="$j[0]" />
                <span class="text-sm font-semibold text-charcoal/80">{{ $j[1] }}</span>
            </div>
        @endforeach
    </div>
</section>

{{-- Benefit --}}
<section class="bg-cream-100 py-16 lg:py-20">
    <div class="container-x grid gap-10 lg:grid-cols-2 lg:items-center">
        <div>
            <x-section-heading eyebrow="Kenapa Pondok Tince" title="Nyaman untuk Acara Anda" />
            <ul class="mt-8 space-y-5">
                @foreach([
                    ['sofa','Suasana nyaman','Tempat yang hangat dan cocok untuk berkumpul bersama keluarga maupun kolega.'],
                    ['utensils','Menu khas Palembang','Pilihan menu lengkap yang bisa disesuaikan untuk rombongan dan acara.'],
                    ['check-circle','Fleksibel','Bisa menyesuaikan kebutuhan acara — cukup konsultasikan lewat WhatsApp.'],
                ] as $b)
                    <li class="flex gap-4">
                        <x-icon-badge :name="$b[0]" size="sm" />
                        <div><span class="block font-display text-lg font-semibold text-charcoal">{{ $b[1] }}</span>
                            <span class="text-sm text-charcoal/65">{{ $b[2] }}</span></div>
                    </li>
                @endforeach
            </ul>
        </div>
        @if($page?->intro_content)
            <div class="prose-content rounded-3xl bg-white p-8 shadow-sm lg:p-10">{!! $page->intro_content !!}</div>
        @else
            <div class="relative overflow-hidden rounded-3xl lux-dark p-8 text-cream-50 lg:p-10">
                <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gold-500/10 blur-2xl"></div>
                <x-icon-badge name="calendar" size="lg" tone="light" />
                <h3 class="mt-5 font-display text-2xl font-bold text-cream-50">Rencanakan Acara Anda</h3>
                <p class="mt-2 text-cream-100/80">Ceritakan kebutuhan acara Anda — jumlah tamu, tanggal, dan menu yang diinginkan. Tim kami akan bantu siapkan.</p>
                <div class="mt-6"><x-wa-button message="Halo Pondok Tince, saya ingin konsultasi acara." label="Konsultasi Sekarang" source="acara-benefit" variant="gold" /></div>
            </div>
        @endif
    </div>
</section>

{{-- Gallery --}}
@if($gallery->count())
<section class="container-x py-16 lg:py-20">
    <x-section-heading eyebrow="Galeri" title="Suasana Tempat & Acara" center />
    <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-4">
        @foreach($gallery as $g)
            <div class="group aspect-square overflow-hidden rounded-2xl bg-cream-200">
                <img src="{{ media_url($g->image_path) }}" alt="{{ $g->alt_text ?: 'Suasana acara Pondok Tince' }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
            </div>
        @endforeach
    </div>
</section>
@endif

<x-faq-list :faqs="$faqs" title="FAQ Paket Acara" eyebrow="Pertanyaan Umum" />

<section class="lux-dark py-16 text-center text-cream-50 lg:py-20">
    <div class="container-x">
        <div class="ornament mb-5 text-gold-300"></div>
        <h2 class="mx-auto max-w-2xl h-display text-3xl text-cream-50 sm:text-4xl">Siap Merencanakan Acara di Pondok Tince?</h2>
        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <x-wa-button message="Halo Pondok Tince, saya ingin konsultasi acara." label="Konsultasi via WhatsApp" source="acara-final" variant="gold" class="w-full sm:w-auto" />
            <a href="{{ route('booking.create') }}" class="btn-outline w-full !border-cream-100/25 !bg-white/5 !text-cream-50 hover:!bg-white/15 sm:w-auto">Isi Form Booking</a>
        </div>
    </div>
</section>
@endsection

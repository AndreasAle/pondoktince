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
<section class="container-x py-14">
    <x-section-heading eyebrow="Cocok Untuk" title="Berbagai Jenis Acara" center />
    <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
        @foreach([['👨‍👩‍👧‍👦','Makan Keluarga'],['💼','Meeting Kantor'],['🎀','Arisan'],['🧳','Tamu Luar Kota'],['🎉','Acara Kecil'],['🚐','Rombongan']] as $j)
            <div class="card flex flex-col items-center gap-2 p-5 text-center">
                <span class="text-3xl">{{ $j[0] }}</span>
                <span class="text-sm font-medium text-charcoal/80">{{ $j[1] }}</span>
            </div>
        @endforeach
    </div>
</section>

{{-- Benefit --}}
<section class="bg-cream-100 py-14">
    <div class="container-x grid gap-8 lg:grid-cols-2 lg:items-center">
        <div>
            <x-section-heading eyebrow="Kenapa Pondok Tince" title="Nyaman untuk Acara Anda" />
            <ul class="mt-6 space-y-4">
                @foreach([['Suasana nyaman','Tempat yang hangat dan cocok untuk berkumpul bersama keluarga maupun kolega.'],['Menu khas Palembang','Pilihan menu lengkap yang bisa disesuaikan untuk rombongan dan acara.'],['Fleksibel','Bisa menyesuaikan kebutuhan acara — cukup konsultasikan lewat WhatsApp.']] as $b)
                    <li class="flex gap-3">
                        <span class="mt-0.5 flex h-8 w-8 flex-none items-center justify-center rounded-full bg-maroon-700 text-cream-50">✓</span>
                        <div><span class="block font-semibold text-charcoal">{{ $b[0] }}</span><span class="text-sm text-charcoal/65">{{ $b[1] }}</span></div>
                    </li>
                @endforeach
            </ul>
        </div>
        @if($page?->intro_content)
            <div class="prose-content rounded-2xl bg-white p-8">{!! $page->intro_content !!}</div>
        @else
            <div class="rounded-2xl bg-maroon-800 p-8 text-cream-50">
                <h3 class="font-display text-2xl font-bold">Rencanakan Acara Anda</h3>
                <p class="mt-2 text-cream-100/80">Ceritakan kebutuhan acara Anda — jumlah tamu, tanggal, dan menu yang diinginkan. Tim kami akan bantu siapkan.</p>
                <div class="mt-6"><x-wa-button message="Halo Pondok Tince, saya ingin konsultasi acara." label="Konsultasi Sekarang" source="acara-benefit" variant="gold" /></div>
            </div>
        @endif
    </div>
</section>

{{-- Gallery --}}
@if($gallery->count())
<section class="container-x py-14">
    <x-section-heading eyebrow="Galeri" title="Suasana Tempat & Acara" center />
    <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
        @foreach($gallery as $g)
            <div class="aspect-square overflow-hidden rounded-xl bg-cream-200">
                <img src="{{ media_url($g->image_path) }}" alt="{{ $g->alt_text ?: 'Suasana acara Pondok Tince' }}" loading="lazy" class="h-full w-full object-cover">
            </div>
        @endforeach
    </div>
</section>
@endif

<x-faq-list :faqs="$faqs" title="FAQ Paket Acara" eyebrow="Pertanyaan Umum" />

<section class="bg-maroon-800 py-14 text-center text-cream-50">
    <div class="container-x">
        <h2 class="h-display text-3xl text-cream-50">Siap Merencanakan Acara di Pondok Tince?</h2>
        <div class="mt-6 flex justify-center gap-3">
            <x-wa-button message="Halo Pondok Tince, saya ingin konsultasi acara." label="Konsultasi via WhatsApp" source="acara-final" variant="gold" />
            <a href="{{ route('booking.create') }}" class="btn-outline !border-cream-100/30 !bg-white/10 !text-cream-50 hover:!bg-white/20">Isi Form Booking</a>
        </div>
    </div>
</section>
@endsection

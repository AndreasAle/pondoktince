@extends('layouts.public')

@section('content')
@php
    $isPempek = $slug === 'pempek-palembang';
    $brandKey = $isPempek ? 'pempek-tince' : 'pondok-tince';
    $internalLinks = [
        'kuliner-palembang' => [
            ['Menu Pondok Tince', route('menu')],
            ['Pempek Palembang', url('/pempek-palembang')],
            ['Makanan Enak Palembang', url('/makanan-enak-palembang')],
            ['Booking Tempat', route('booking.create')],
            ['Lokasi', route('lokasi')],
            ['Pempek Tince', route('pempek.index')],
        ],
        'pempek-palembang' => [
            ['Pempek Tince', route('pempek.index')],
            ['Menu Pempek Tince', route('pempek.menu')],
            ['Paket Pempek', route('pempek.paket')],
            ['Oleh-Oleh Palembang', route('pempek.oleholeh')],
            ['Pempek Frozen', route('pempek.frozen')],
            ['Kuliner Palembang', url('/kuliner-palembang')],
        ],
        'makanan-enak-palembang' => [
            ['Menu Pondok Tince', route('menu')],
            ['Booking Meja', route('booking.create')],
            ['Lokasi', route('lokasi')],
            ['Kuliner Palembang', url('/kuliner-palembang')],
            ['Pempek Palembang', url('/pempek-palembang')],
            ['Paket Acara', route('paket-acara')],
        ],
    ][$slug];
@endphp

<x-page-hero :eyebrow="$isPempek ? 'Pempek Tince' : 'Pondok Tince'"
    :title="$page?->hero_title ?: $config['title']"
    :subtitle="$page?->hero_subtitle ?: $config['description']"
    :image="media_url($page?->hero_image_path)">
    @if($isPempek)
        <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek Palembang." brand="pempek-tince" label="Pesan Pempek via WhatsApp" source="pillar-{{ $slug }}" variant="gold" />
        <a href="{{ route('pempek.paket') }}" class="btn-outline !border-cream-100/30 !bg-white/10 !text-cream-50 hover:!bg-white/20">Lihat Paket Pempek</a>
    @else
        <a href="{{ route('menu') }}" class="btn-gold">Lihat Menu</a>
        <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin booking.'" label="Booking via WhatsApp" source="pillar-{{ $slug }}" />
    @endif
</x-page-hero>

<x-breadcrumbs />

<article class="container-x py-12">
    <div class="prose-content mx-auto max-w-3xl">
        @if($page?->intro_content)
            {!! $page->intro_content !!}
        @elseif($slug === 'kuliner-palembang')
            <h2>Tempat Makan Khas Palembang untuk Keluarga</h2>
            <p>Pondok Tince menghadirkan <strong>kuliner Palembang</strong> dalam suasana nyaman yang cocok untuk keluarga, pekerja kantor, hingga tamu luar kota. Setiap sajian dibuat dengan cita rasa khas Palembang yang autentik.</p>
            <h2>Menu Kuliner Palembang yang Bisa Dicoba</h2>
            <p>Dari hidangan berkuah hingga lauk khas, menu kami dirancang untuk dinikmati bersama. Lihat daftar lengkapnya di halaman <a href="{{ route('menu') }}">menu Pondok Tince</a>.</p>
            <h2>Cocok untuk Tamu Luar Kota dan Rombongan</h2>
            <p>Membawa rombongan atau menjamu tamu dari luar kota? Pondok Tince siap menyambut Anda. Untuk acara, cek <a href="{{ route('paket-acara') }}">paket acara</a> kami.</p>
            <h2>Lokasi Pondok Tince di Palembang</h2>
            <p>Kami berlokasi strategis di Palembang dan mudah dijangkau. Lihat <a href="{{ route('lokasi') }}">lokasi dan jam buka</a>.</p>
            <h2>Booking dan Pemesanan</h2>
            <p>Amankan tempat Anda dengan <a href="{{ route('booking.create') }}">booking</a>, atau pesan langsung via WhatsApp. Ingin oleh-oleh? Kunjungi <a href="{{ route('pempek.index') }}">Pempek Tince</a>.</p>
        @elseif($slug === 'pempek-palembang')
            <h2>Pempek Khas Palembang untuk Makan di Tempat dan Oleh-Oleh</h2>
            <p><strong>Pempek Palembang</strong> dari Pempek Tince dibuat dengan bahan berkualitas dan cita rasa khas. Nikmati di tempat atau bawa pulang sebagai oleh-oleh.</p>
            <h2>Varian Pempek yang Bisa Dipesan</h2>
            <p>Tersedia berbagai varian pempek. Lihat pilihannya di <a href="{{ route('pempek.menu') }}">menu Pempek Tince</a>.</p>
            <h2>Paket Pempek untuk Keluarga dan Rombongan</h2>
            <p>Butuh dalam jumlah banyak? Tersedia <a href="{{ route('pempek.paket') }}">paket pempek</a> untuk keluarga dan rombongan.</p>
            <h2>Pempek Frozen dan Pesanan Online</h2>
            <p>Ingin stok di rumah atau kirim ke luar kota? Cek <a href="{{ route('pempek.frozen') }}">pempek frozen</a> dan cara <a href="{{ route('pempek.pesan') }}">pesan online</a>.</p>
            <h2>Cara Pesan Pempek Tince</h2>
            <p>Pilih menu atau paket, klik WhatsApp, konfirmasi stok & pengiriman, lalu pesanan diproses.</p>
        @else
            <h2>Rekomendasi Makanan Enak Khas Palembang</h2>
            <p>Bingung mau makan apa di Palembang? Pondok Tince menyajikan <strong>makanan enak Palembang</strong> yang cocok untuk keluarga dan rombongan.</p>
            <h2>Kenapa Pondok Tince Cocok untuk Makan Keluarga</h2>
            <p>Suasana nyaman, porsi bersahabat, dan menu yang beragam membuat Pondok Tince menjadi pilihan tepat untuk makan bersama.</p>
            <h2>Menu Favorit yang Bisa Dicoba</h2>
            <p>Lihat menu favorit di halaman <a href="{{ route('menu') }}">menu</a> kami.</p>
            <h2>Cocok untuk Tamu Luar Kota</h2>
            <p>Menjamu tamu dari luar kota? Ajak mereka mencicipi masakan khas Palembang di Pondok Tince.</p>
            <h2>Booking Tempat dan Lihat Lokasi</h2>
            <p>Amankan meja Anda lewat <a href="{{ route('booking.create') }}">booking</a> dan cek <a href="{{ route('lokasi') }}">lokasi</a> kami.</p>
        @endif
    </div>
</article>

{{-- Menu highlight --}}
@if($favorites->count())
<section class="bg-cream-100 py-14">
    <div class="container-x">
        <x-section-heading eyebrow="Menu" :title="$isPempek ? 'Varian Pempek Pilihan' : 'Menu Favorit yang Bisa Dicoba'" center />
        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-3">
            @foreach($favorites as $item)<x-menu-card :item="$item" source="pillar-{{ $slug }}" />@endforeach
        </div>
    </div>
</section>
@endif

{{-- Internal links --}}
<section class="container-x py-12">
    <h2 class="font-display text-xl font-semibold text-charcoal">Jelajahi Lebih Lanjut</h2>
    <div class="mt-4 flex flex-wrap gap-2">
        @foreach($internalLinks as $link)
            <a href="{{ $link[1] }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm text-charcoal/75 transition hover:border-maroon-500 hover:text-maroon-700">{{ $link[0] }}</a>
        @endforeach
    </div>
</section>

<section class="bg-maroon-800 py-14 text-center text-cream-50">
    <div class="container-x">
        <h2 class="h-display text-2xl text-cream-50 sm:text-3xl">{{ $isPempek ? 'Pesan Pempek Palembang Sekarang' : 'Kunjungi Pondok Tince Hari Ini' }}</h2>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            @if($isPempek)
                <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek via WhatsApp" source="pillar-{{ $slug }}-final" variant="gold" />
                <a href="{{ route('pempek.menu') }}" class="btn-outline !border-cream-100/30 !bg-white/10 !text-cream-50 hover:!bg-white/20">Lihat Menu Pempek</a>
            @else
                <a href="{{ route('menu') }}" class="btn-gold">Lihat Menu</a>
                <x-wa-button :message="'Halo '.$siteSettings->site_name.', saya ingin booking meja.'" label="Booking via WhatsApp" source="pillar-{{ $slug }}-final" />
            @endif
        </div>
    </div>
</section>
@endsection

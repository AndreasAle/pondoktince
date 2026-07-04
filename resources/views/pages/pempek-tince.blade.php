@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Pempek Tince Palembang"
    :title="$page?->hero_title ?: 'Pempek Tince Palembang untuk Oleh-Oleh, Frozen, dan Pesanan Online'"
    :subtitle="$page?->hero_subtitle ?: 'Pempek khas Palembang untuk oleh-oleh, frozen, dan pesanan keluarga. Pesan online, bisa kirim luar kota.'"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek" source="pempek-hero" variant="gold" />
    <a href="{{ route('pempek.paket') }}" class="btn-outline !border-cream-100/30 !bg-white/10 !text-cream-50 hover:!bg-white/20">Lihat Paket</a>
</x-page-hero>

<x-breadcrumbs />

{{-- Brand story --}}
<section class="container-x py-14">
    <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
        <div class="prose-content">
            @if($page?->intro_content)
                {!! $page->intro_content !!}
            @else
                <span class="eyebrow">Cerita Kami</span>
                <h2>Pempek Palembang dengan Cita Rasa Khas</h2>
                <p>Pempek Tince adalah bagian dari keluarga Pondok Tince, menghadirkan pempek Palembang untuk dinikmati di rumah, dibagikan sebagai oleh-oleh, atau disimpan sebagai stok frozen.</p>
                <p>Kami berkomitmen menjaga rasa khas Palembang di setiap gigitan, agar bisa dinikmati keluarga di mana saja.</p>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-4">
            @forelse($variants->take(4) as $v)
                <div class="aspect-square overflow-hidden rounded-2xl bg-cream-100">
                    @if($v->image_path)<img src="{{ media_url($v->image_path) }}" alt="{{ $v->image_alt ?: $v->name }}" loading="lazy" class="h-full w-full object-cover">
                    @else<div class="flex h-full items-center justify-center font-display text-maroon-300">{{ $v->name }}</div>@endif
                </div>
            @empty
                <div class="col-span-2 flex aspect-video items-center justify-center rounded-2xl bg-cream-100 font-display text-maroon-300">Foto Pempek Tince</div>
            @endforelse
        </div>
    </div>
</section>

{{-- Keunggulan --}}
<section class="bg-cream-100 py-14">
    <div class="container-x">
        <x-section-heading eyebrow="Keunggulan" title="Kenapa Pempek Tince" center />
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach([['🐟','Ikan Berkualitas'],['🌶️','Rasa Khas Palembang'],['🎁','Cocok untuk Oleh-Oleh'],['📦','Bisa Pesan Online'],['❄️','Tersedia Frozen']] as $k)
                <div class="card flex flex-col items-center gap-2 p-5 text-center">
                    <span class="text-3xl">{{ $k[0] }}</span>
                    <span class="text-sm font-medium text-charcoal/80">{{ $k[1] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Varian --}}
@if($variants->count())
<section class="container-x py-14">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <x-section-heading eyebrow="Varian" title="Varian Pempek" />
        <a href="{{ route('pempek.menu') }}" class="btn-outline !py-2.5 text-xs">Lihat Menu Lengkap</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
        @foreach($variants as $item)<x-menu-card :item="$item" source="pempek-varian" />@endforeach
    </div>
</section>
@endif

{{-- Paket --}}
@if($packages->count())
<section class="bg-cream-100 py-14">
    <div class="container-x">
        <x-section-heading eyebrow="Paket Pempek" title="Paket untuk Keluarga & Oleh-Oleh" center />
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($packages as $pkg)<x-package-card :package="$pkg" source="pempek-paket" />@endforeach
        </div>
    </div>
</section>
@endif

{{-- Cara order --}}
<section class="container-x py-14">
    <x-section-heading eyebrow="Cara Order" title="Mudah Pesan dalam 5 Langkah" center />
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @foreach([['1','Pilih menu / paket'],['2','Klik WhatsApp'],['3','Konfirmasi stok & pengiriman'],['4','Pembayaran'],['5','Pesanan diproses']] as $step)
            <div class="relative rounded-2xl bg-white p-5 text-center shadow-sm">
                <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-maroon-700 font-display text-lg font-bold text-cream-50">{{ $step[0] }}</span>
                <p class="mt-3 text-sm font-medium text-charcoal/80">{{ $step[1] }}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-8 text-center">
        <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan Pempek Sekarang" source="pempek-cara" variant="gold" />
    </div>
</section>

<x-faq-list :faqs="$faqs" title="FAQ Pempek Tince" eyebrow="Pertanyaan Umum" />

<section class="bg-maroon-800 py-14 text-center text-cream-50">
    <div class="container-x">
        <h2 class="h-display text-3xl text-cream-50">Pesan Pempek Tince Sekarang</h2>
        <p class="mx-auto mt-3 max-w-xl text-cream-100/80">Untuk oleh-oleh, frozen, atau pesanan keluarga — hubungi kami via WhatsApp.</p>
        <div class="mt-6 flex justify-center gap-3">
            <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan via WhatsApp" source="pempek-final" variant="gold" />
            <a href="{{ url('/pempek-palembang') }}" class="btn-outline !border-cream-100/30 !bg-white/10 !text-cream-50 hover:!bg-white/20">Pempek Palembang</a>
        </div>
    </div>
</section>
@endsection

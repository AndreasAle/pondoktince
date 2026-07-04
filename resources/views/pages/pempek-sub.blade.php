@extends('layouts.public')

@section('content')
<x-page-hero eyebrow="Pempek Tince"
    :title="$page?->hero_title ?: $config['title']"
    :subtitle="$page?->hero_subtitle ?: $config['description']"
    :image="media_url($page?->hero_image_path)">
    <x-wa-button message="Halo Pempek Tince, saya ingin pesan pempek." brand="pempek-tince" label="Pesan via WhatsApp" source="pempek-sub" variant="gold" />
</x-page-hero>

<x-breadcrumbs />

<article class="container-x py-12">
    <div class="prose-content mx-auto max-w-3xl">
        @if($page?->intro_content)
            {!! $page->intro_content !!}
        @else
            <p>{{ $config['description'] }} Pempek Tince siap membantu Anda mendapatkan pempek Palembang berkualitas — untuk dinikmati di rumah, dibagikan sebagai oleh-oleh, maupun disimpan sebagai stok.</p>
            <ul>
                <li>Bahan berkualitas dengan rasa khas Palembang.</li>
                <li>Bisa dipesan online via WhatsApp.</li>
                <li>Tersedia opsi frozen untuk pengiriman luar kota.</li>
            </ul>
        @endif
    </div>
</article>

@if($packages->count())
<section class="bg-cream-100 py-14">
    <div class="container-x">
        <x-section-heading eyebrow="Paket" title="Pilihan Paket Pempek" center />
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($packages as $pkg)<x-package-card :package="$pkg" source="pempek-sub" />@endforeach
        </div>
    </div>
</section>
@else
<section class="container-x pb-14 text-center">
    <div class="rounded-2xl border border-dashed border-cream-200 bg-cream-50 py-12 text-charcoal/60">
        <p>Detail paket sedang disiapkan. Hubungi kami untuk info pemesanan terbaru.</p>
        <div class="mt-4"><x-wa-button message="Halo Pempek Tince, saya ingin info paket pempek." brand="pempek-tince" label="Tanya via WhatsApp" source="pempek-sub-empty" /></div>
    </div>
</section>
@endif

<x-faq-list :faqs="$faqs" title="FAQ Pempek Tince" eyebrow="Pertanyaan Umum" />

<section class="container-x py-12">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('pempek.index') }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm text-charcoal/75 hover:border-maroon-500 hover:text-maroon-700">Pempek Tince</a>
        <a href="{{ route('pempek.menu') }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm text-charcoal/75 hover:border-maroon-500 hover:text-maroon-700">Menu Pempek</a>
        <a href="{{ route('pempek.paket') }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm text-charcoal/75 hover:border-maroon-500 hover:text-maroon-700">Paket Pempek</a>
        <a href="{{ route('pempek.frozen') }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm text-charcoal/75 hover:border-maroon-500 hover:text-maroon-700">Pempek Frozen</a>
        <a href="{{ url('/pempek-palembang') }}" class="rounded-full border border-cream-200 bg-white px-4 py-2 text-sm text-charcoal/75 hover:border-maroon-500 hover:text-maroon-700">Pempek Palembang</a>
    </div>
</section>
@endsection

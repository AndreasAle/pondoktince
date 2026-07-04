@extends('layouts.public')

@section('content')
@php $s = $siteSettings; @endphp
<x-page-hero eyebrow="Lokasi & Jam Buka"
    :title="$page?->hero_title ?: 'Kunjungi Pondok Tince di Palembang'"
    :subtitle="$page?->hero_subtitle ?: 'Mudah dijangkau untuk keluarga, rombongan, dan tamu luar kota.'"
    :image="media_url($page?->hero_image_path)" />

<x-breadcrumbs />

<div class="container-x grid gap-10 py-16 lg:grid-cols-2 lg:py-20">
    <div>
        {{-- Alamat --}}
        <div class="flex gap-4">
            <x-icon-badge name="pin" />
            <div>
                <h2 class="font-display text-xl font-bold text-charcoal">Alamat</h2>
                <p class="mt-1 text-charcoal/70">{{ $s->address ?: 'Alamat lengkap akan tampil di sini setelah diisi dari admin panel.' }}</p>
            </div>
        </div>

        {{-- Jam buka --}}
        <div class="mt-8 flex gap-4">
            <x-icon-badge name="clock" />
            <div class="flex-1">
                <h3 class="font-display text-xl font-bold text-charcoal">Jam Buka</h3>
                @if(is_array($s->opening_hours) && count($s->opening_hours))
                    <ul class="mt-2 space-y-1 text-sm text-charcoal/70">
                        @foreach($s->opening_hours as $row)
                            <li class="flex justify-between border-b border-cream-200 py-1.5"><span>{{ $row['day'] ?? '' }}</span><span class="font-semibold text-charcoal">{{ $row['hours'] ?? '' }}</span></li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-1 text-sm text-charcoal/60">Jam buka akan tampil di sini setelah diisi dari admin.</p>
                @endif
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            @if($s->maps_link)<a href="{{ $s->maps_link }}" target="_blank" rel="noopener" class="btn-primary">Buka Google Maps</a>@endif
            <x-wa-button :message="'Halo '.$s->site_name.', saya ingin tanya lokasi & reservasi.'" label="WhatsApp Admin" source="lokasi" />
        </div>

        @if($page?->intro_content)<div class="prose-content mt-10">{!! $page->intro_content !!}</div>@endif
    </div>

    <div class="overflow-hidden rounded-3xl border border-cream-200 bg-white shadow-sm">
        @if($s->maps_embed)
            <iframe src="{{ $s->maps_embed }}" class="h-full min-h-[400px] w-full" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Lokasi Pondok Tince"></iframe>
        @else
            <div class="placeholder-food flex min-h-[400px] flex-col items-center justify-center gap-3 !text-charcoal/40">
                <x-ico name="pin" class="h-10 w-10" />
                <span>Peta lokasi (atur embed Google Maps di admin)</span>
            </div>
        @endif
    </div>
</div>

<x-faq-list :faqs="$faqs" title="FAQ Lokasi" eyebrow="Info Lokasi" />
@endsection
